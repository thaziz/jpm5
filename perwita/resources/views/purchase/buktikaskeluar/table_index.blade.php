<table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
  <thead align="center">
   <tr>
      <th> No. BKK </th>
      <th> Tanggal </th>
      <th> Nama Cabang </th>
      <th> Jenis Bayar</th>
      <th> Keterangan </th> 
      <th> Total </th>   
      <th> Print </th>   
      <th> Status </th>
      <th> Aksi </th>
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
    tableDetail = $('.tbl-penerimabarang').DataTable({
          processing: true,
          serverSide: true,
          "order": [[ 1, "desc" ],[ 0, "desc" ]],
          ajax: {
              url:'{{ route("datatable_bkk") }}',
              data:{cabang,tanggal_awal,tanggal_akhir,jenis_biaya,nota}
          },
          columnDefs: [
            {
               targets: 5,
               className:'right'
            },
            {
               targets: 6,
               className:'center'
            },
            {
               targets:7,
               className:'center'
            },
          ],
          "columns": [
          { "data": "bkk_nota" },
          { "data": "bkk_tgl" },
          { "data": "cabang" },
          { "data": "jenisbayar"},
          { "data": "bkk_keterangan" },
          { "data": "tagihan" },
          { "data": "print"},
          { "data": "status"},
          { "data": "aksi" },
          
          ]
    });
  })
     
</script>