<table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
  <thead align="center">
   <tr>
        <th> No. BBM </th>
        <th> Tanggal </th>
        <th> Nama Cabang </th>
        <th> Biaya Penerus </th>
        <th> Keterangan </th>
        <th> Detail </th>   
        {{-- <th> Allow Edit </th> --}}
        <th> aksi </th>
  </tr>
  </thead>
  <tbody>  
    
  </tbody>
</table>

<script type="text/javascript">

  $(document).ready(function(){
    var cabang = '{{$cab}}';
    tableDetail = $('.tbl-penerimabarang').DataTable({
         processing: true,
          // responsive:true,
          serverSide: true,
          "order": [[ 1, "desc" ],[ 0, "desc" ]],
          ajax: {
              url:'{{ route("data_loading") }}',
              data:{cabang}
          },
          columnDefs: [
            {
               targets: 3,
               className:'right'
            },
            {
               targets: 5,
               className:'center'
            },

          ],
          "columns": [
          { "data": "bpk_nota" },
          { "data": "bpk_tanggal" },
          { "data": "cabang" },
          { "data": "tagihan"},
          { "data": "bpk_keterangan"},
          { "data": "print" },
          // { "data": "print"},
          { "data": "aksi" },
          
          ]
    });
  })
     
</script>