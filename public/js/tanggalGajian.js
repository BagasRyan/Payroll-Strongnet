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