<table class="table bp_pilih_um">
  <thead>
    <th>No Kas/Hutang</th>
    <th>Tanggal</th>
    <th>Agen/Vendor</th>
    <th>Keterangan</th>
    <th>Jumlah Uang Muka</th>
    <th>Sisa Terpakai</th>
  </thead>
  <tbody>
    @foreach($data as $val)
    <tr>
      <td>{{$val->nomor}}</td>
      <td>{{$val->um_tgl}}</td>
      <td>{{$val->um_supplier}}</td>
      <td>{{$val->um_keterangan}}</td>
      <td>{{$val->total_um}}</td>
      <td>{{$val->total_um}}</td>
    </tr>
  </tbody>
  @endforeach
</table>


<script type="text/javascript">
     var datatable3 = $('.bp_pilih_um').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
          
          
    });
</script>