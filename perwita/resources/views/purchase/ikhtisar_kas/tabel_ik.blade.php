<table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
  <thead align="center">
   <tr>
        <th> No. Ikhtisar </th>
        <th> Tanggal </th>
        <th> Nama Cabang </th>
        <th> Keterangan </th> 
        <th> Total </th> 
        <th> Print </th>     
        <th> Status </th>     
        <th> Allow Edit </th>
        <th> Aksi </th>
  </tr>
  </thead>
  <tbody>  
    
  </tbody>
</table>

<script type="text/javascript">

  $(document).ready(function(){
    var cabang = '{{$cab}}';
    $('.tbl-penerimabarang').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route("datatable_ikhtisar") }}',
                data:{cabang}
            },
            columnDefs: [
              {
                 targets: 4,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'center'
              },
              {
                 targets:7,
                 className: 'center'
              },
              {
                 targets:8,
                 className: 'center'
              },
            ],
            "columns": [
            { "data": "ik_nota" },
            { "data": "tanggal" },
            { "data": "nama" },
            { "data": "ik_keterangan" },
            { "data": "ik_total",render: $.fn.dataTable.render.number( '.', '.', 0, '' ) },
            { "data": "print"},
            { "data": "ik_status" },
            { "data": "editing" },
            { "data": "aksi" },
            ]
      });
  })
     
</script>