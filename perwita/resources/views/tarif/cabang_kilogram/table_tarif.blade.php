<table id="table_data" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:70px"> Kode</th>
            <th> Asal </th>
            <th> Tujuan </th>
            <th> Provinsi Tujuan </th>
            <th> Tarif </th>
            <th> Jenis </th>
            <th> Cabang </th>
            <th> Waktu </th>
            <th> Keterangan </th>
            <th style="width:80px"> Aksi </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
    var cabang = '{{ $cabang }}';
    $('#table_data').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        processing: true,
        serverSide: true,
        "info": false,
        "responsive": true,
        "autoWidth": false,
        "pageLength": 10,
        "retrieve" : true,
        "ajax": {
          "url" :  baseUrl + "/sales/tarif_cabang_kilogram/tabel",
          data:{cabang},
          "type": "GET"
        },
        "columns": [
        { "data": "kode" },
        { "data": "asal" },
        { "data": "tujuan" },
        { "data": "provinsi" },
        { "data": "harga", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
        { "data": "jenis", },
        { "data": "cabang", },
        { "data": "waktu", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
        { "data": "keterangan" },
        { "data": "aksi" },
        ]
    });
</script>