<table class="table bp_pilih_um table-hover">
  <thead>
    <th>No Kas/Hutang</th>
    <th>Uang Muka</th>
    <th>Tanggal</th>
    <th>Agen/Vendor</th>
    <th>Keterangan</th>
    <th>Jumlah Uang Muka</th>
    <th>Sisa Terpakai</th>
  </thead>
  <tbody>
    @foreach($data as $val)
    <tr onclick="pilih_um('{{$val->nomor}}')">
      <td>{{$val->nomor}}</td>
      <td>{{$val->um_nomorbukti}}</td>
      <td>{{$val->um_tgl}}</td>
      <td>{{$val->um_supplier}}</td>
      <td>{{$val->um_keterangan}}</td>
      <td>{{number_format($val->total_um,2,",",".")}}</td>
      <td>{{number_format($val->sisa_um,2,",",".")}}</td>
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

    function pilih_um(a) {
      var nota = a;
      var sup = $('.agen_vendor').val();
      $.ajax({
        url:baseUrl +'/fakturpembelian/biaya_penerus/pilih_um',
        data: {nota,sup},
        dataType:'json',
        success:function(data){
          $('.bp_nomor_um').val(data.data.nomor);
          $('.bp_tanggal_um').val(data.data.um_tgl);
          $('.bp_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
          $('.bp_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
          $('.bp_keterangan_um').val(data.data.um_keterangan);
          $('.bp_id_um').val('');
          $('#modal_show_um').modal('hide');
        },error:function(){
          toastr.warning('Terjadi Kesalahan');
        }
      })
    }
</script>