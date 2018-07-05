<table class="table vendor_pilih_um table-hover" style="font-size: 12px">
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
     var vendor_um = $('.vendor_pilih_um').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
          
          
    });

    function pilih_um(a) {
      var nota = a;
      var sup = $('.nama_vendor').val();
      var id  = $('.nofaktur').val();
      console.log(sup);
      $.ajax({
        url:baseUrl +'/fakturpembelian/biaya_penerus/pilih_um',
        data: {nota,sup,id},
        dataType:'json',
        success:function(data){
          $('.vendor_nomor_um').val(data.data.nomor);
          $('.vendor_tanggal_um').val(data.data.um_tgl);
          $('.vendor_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
          $('.vendor_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
          $('.vendor_keterangan_um').val(data.data.um_keterangan);
          $('.vendor_id_um').val('');
          $('#modal_show_um').modal('hide');
        },error:function(){
          toastr.warning('Terjadi Kesalahan');
        }
      })
    }
</script>