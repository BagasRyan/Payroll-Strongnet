$(document).ready(function(){
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/divisi'
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
                width: '10%'
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
        title: `Apakah anda yakin ingin hapus Divisi ${nama}?`,
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
                url: `/divisi/delete/${id}`,
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
                }
            })
        }
    })
}