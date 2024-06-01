$(document).ready(function(){
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '/gajiBulanan' 
        },
        columns: [{
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            data: 'total_karyawan',
            name: 'total_karyawan',
        },
        {
            data: 'total_pengeluaran',
            name: 'total_pengeluaran',
            render: function(data){
                return 'Rp. ' + data
            }
        },
        {
            data: 'tahun',
            name: 'tahun',
        },
        {
            data: 'bulan',
            name: 'bulan',
        },
        {
            data: 'option',
            name: 'option',
        }
    ]
    })
});

function onDelete(data){
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    const idTanggal = data.id;
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
                url: `/gajiBulanan/delete/${idTanggal}`,
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
                        didClose: function(){
                            window.location.reload();
                        }
                    });
                }
            })
        }
    })
}