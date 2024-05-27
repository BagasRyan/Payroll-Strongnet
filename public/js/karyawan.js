$(document).ready(function() {
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '/karyawan'
        },
        columns: [{
                width: "5%",
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: 'nama',
                name: 'nama',
            },
            {
                data: 'option',
                name: 'option',
            }
        ]
    });
});

function onDelete(data){
    const id = data.id;
    const nama = data.name;
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    Swal.fire({
        title: `Apakah anda yakin ingin hapus data Karyawan ${nama}?`,
        text: "Data yang telah dihapus tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Tidak'
    }).then(function(result){
        if(result.isConfirmed){
            $.ajax({
                url: `/karyawan/delete/${id}`,
                method: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                },
                success: function(result){
                    if(result.status == 'success'){
                        Swal.fire({
                            title: 'Berhasil',
                            text: result.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500,
                            didClose: function(){
                                $('table').DataTable().ajax.reload();
                            }
                        })
                    }
                },
                error: function(result){
                    if(result.status == 'error'){
                        Swal.fire({
                            title: 'Gagal',
                            text: result.message,
                            icon: 'error',
                        })
                    }
                }
            })
        }
    })
}