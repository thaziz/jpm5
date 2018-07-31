<table style="font-size: 12px" id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
    <thead>
        <tr>
            <th>Nomor</th>
            <th>Tanggal </th>
            <th>Cabang </th>
            <th>Customer</th>
            <th>JT</th>
            <th>Tagihan </th>
            <th>Sisa Tagihan </th>
            <th>Keterangan </th>
            <th>No Faktur Pajak </th>
            <th>Status Print</th>
            <th style="width:10%"> Aksi </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script type="text/javascript">
var cabang = '{{$cab}}';
$('#tabel_data').DataTable({
    processing: true,
    // responsive:true,
    serverSide: true,
    ajax: {
        url:'{{ route("datatable_invoice1") }}',
        data:{cabang}

    },
    columnDefs: [
      {
         targets: 5,
         className: 'cssright'
      },
      {
         targets: 6,
         className: 'cssright'
      },
      {
         targets:7,
         className: 'center'
      },
      {
         targets:10,
         className: 'center'
      },
    ],
    "columns": [
    { "data": "i_nomor" },
    { "data": "i_tanggal" },
    { "data": "cabang" },
    { "data": "customer"},
    { "data": "i_jatuh_tempo" },
    { "data": "tagihan" },
    { "data": "sisa"},
    { "data": "i_keterangan" },
    { "data": "faktur_pajak" },
    { "data": "status" },
    { "data": "aksi" },
    
    ]
});
$.fn.dataTable.ext.errMode = 'throw';
</script>