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
            },
            {
                data: 'potongan',
                name: 'potongan',
            },
            {
                data: 'option',
                name: 'option'
            }
        ]
    });
});