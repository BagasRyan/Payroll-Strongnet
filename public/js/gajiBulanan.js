$(document).ready(function(){
    // AMBIL ID TANGGAL DARI URL
    const query = document.URL;
    const idTanggal = query.substring(query.lastIndexOf("/") + 1);
    $('#table').DataTable({
        language    : {
            zeroRecords     : 'Data masih kosong',
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: `/gajiBulanan/detail/${idTanggal}`
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
                data: 'divisi',
                name: 'divisi',
            },
            {
                data: 'gaji_pokok',
                name: 'gaji_pokok',
                render: function(data){
                    return 'Rp. ' + data
                }
            },
            {
                data: 'potongan',
                name: 'potongan',
                render: function(data){
                    return 'Rp. ' + data
                }
            },
            {
                data: 'option',
                name: 'option'
            }
        ]
    });
});

function onDelete(data){
    const id = data.id;
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

    Swal.fire({
        title: `Apakah anda yakin ingin hapus data ini?`,
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
                url: `/gajiBulanan/delete/karyawan/${id}`,
                method: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                },
                success: function(){
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Data berhasil dihapus',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(function(){
                        $('#table').DataTable().ajax.reload();
                    })
                }
            })
        }
    })
}