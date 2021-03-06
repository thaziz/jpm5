<table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" style="width: 100%">
  <thead align="center">
   <tr>
        <th> No. BBM </th>
        <th> Tanggal </th>
        <th> Nama Cabang </th>
        <th> Biaya Penerus </th>
        <th> Keterangan </th>
        <th> Detail </th>   
        <th> Status </th>   
        {{-- <th> Allow Edit </th> --}}
        <th> aksi </th>
  </tr>
  </thead>
  <tbody>  
    
  </tbody>
</table>

<script type="text/javascript">

  $(document).ready(function(){
    var cabang        = '{{$cab}}';
    var tanggal_awal  = '{{ $tanggal_awal }}';
    var tanggal_akhir = '{{ $tanggal_akhir }}';
    var jenis_biaya   = '{{ $jenis_biaya }}';
    var nota          = '{{ $nota }}';
    $('.tbl-penerimabarang').DataTable({
         processing: true,
          // responsive:true,
          searching:false,
          serverSide: true,
          "order": [[ 1, "desc" ],[ 0, "desc" ]],
          ajax: {
              url:'{{ route("datatable_bk") }}',
              data:{cabang,tanggal_awal,tanggal_akhir,jenis_biaya,nota}
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
          { "data": "status"},
          { "data": "aksi" },
          
          ]
    });
  })
     
</script>