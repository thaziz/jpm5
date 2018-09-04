<table id="tab" class="table table-bordered table-striped">
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
    var asal = '{{ $asal }}';
    var tujuan = '{{ $tujuan }}';
    var jenis = '{{ $jenis }}';
    $('#tab').DataTable({
        processing: true,
        // responsive:true,
        searching:false,
        serverSide: true,
        ordering:false,
        ajax: {
            url:baseUrl + "/sales/tarif_cabang_kilogram/tabel",
            data:{cabang,asal,tujuan,jenis}
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