<table class="table ot_pilih_um table-hover">
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
     var datatable4 = $('.ot_pilih_um').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
          
          
    });

    function pilih_um(a) {
      var nota = a;
      var sup = $('.selectOutlet').val();
      $.ajax({
        url:baseUrl +'/fakturpembelian/biaya_penerus/pilih_um',
        data: {nota,sup},
        dataType:'json',
        success:function(data){
          $('.ot_nomor_um').val(data.data.nomor);
          $('.ot_tanggal_um').val(data.data.um_tgl);
          $('.ot_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
          $('.ot_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
          $('.ot_keterangan_um').val(data.data.um_keterangan);
          $('.ot_id_um').val('');
          $('#modal_show_um').modal('hide');
        },error:function(){
          toastr.warning('Terjadi Kesalahan');
        }
      })
    }
</script>