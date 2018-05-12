
<div class="col-sm-5 header_biaya"  >
	{{ csrf_field() }}
<form class="head_atas">
<table class="table	head-biaya">
	<h3 style="text-align: center;">Form Biaya Penerus Hutang</h3>
 <tr>
 	<td style="width: 100px">Tanggal</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{$date}}" readonly="" style="">
 		<input type="hidden" class="form-control tgl_resi"  readonly="" style="">
 		<input type="hidden" name="master_persen" class="form-control master_persen"  readonly="" style="">
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="jatuh_tempo" class="form-control jatuh_tempo" value="{{$jt}}" placeholder="Jatuh tempo" style="">
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" style=""></td>
 </tr>
  <tr class="vendor">
 	<td style="width: 100px">Tipe Vendor </td>
 	<td width="10">:</td>
 	<td width="200">
 		<select onchange="ganti_agen(this.value)" name="vendor" class="form-control vendor1 "  style="text-align: center; " >
 			<option  selected="" value="kosong">-PILIH TIPE VENDOR-</option>
 			<option value="AGEN">Agen Penerus </option>
 			<option value="VENDOR">Vendor Penerus</option>
 		</select>
 		<input type="hidden" name="akun_agen" class="akun_agen">
 	</td>
 </tr>
 <tr class="nama-kontak-kosong">
 	<td style="width: 100px">Nama Agen/Vendor </td>
 	<td width="10">:</td>
 	<td width="200" class="nama_kontak_td">
 		<select name="" class="form-control agen_vendor" style="text-align: center; ">
 			<option value="0" selected="">-PILIH NAMA AGEN/VENDOR-</option>
 		</select>
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">No Invoice</td>
 	<td width="10">:</td>
 	<td width="200"><input type="text" name="Invoice_biaya" class="form-control" style="" placeholder="No Invoice"></td>
 </tr>
  <tr>
 	<td style="width: 100px">Keterangan</td>
 	<td width="10">:</td>
 	<td width="200"><input type="text" name="Keterangan_biaya" class="form-control" style=""></td>
 </tr>	
<!--  <tr>
 	<td style="width: 100px">Biaya Khusus</td>
 	<td width="10">:</td>
 	<td align="left"><input type="checkbox" name="biaya_khusus" title="jika dicentang akan merubah batasan menjadi biaya khusus"></td>
 </tr> -->
</table>
</form>
</div>


<div class="col-sm-5 detail_biaya"   style="margin-left: 100px;">
    <form class="form">
     <table class="table table_detail">
     <div align="center" style="width: 100%;">	
		<h3 >Detail Biaya Penerus Hutang</h3>
	 </div>	
	  <tr>
		<td style="width: 100px">Nomor</td>
		<td width="10">:</td>
		<td width="200">
      <input type="text" name="jml_data" value="1" class="form-control jml_data" style="" readonly="">
    </td>
	  </tr>
	  <tr>
  		<td style="width: 100px">Nomor POD</td>
  		<td width="10">:</td>
  		<td width="200">
        <input type="text" name="no_pod" id="tages" class="form-control no_pod" onkeyup="cari_do()"  style="">
  			<input type="hidden" class="form-control status_pod" style="">
  		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Debet/Kredit</td>
		<td width="10">:</td>
		<td>
			<select name="debit" class="form-control debit" style="text-align: center; ">
 				<option value="debit" selected="">DEBIT</option>
 				<option value="kredit">KREDIT</option>
 			</select>
 		</td>
	  </tr>
    <tr>
      <td style="width: 100px ;">Akun</td>
      <td width="10">:</td>
      <td>
        <select class="form-control akun_biaya chosen-select-width1" style="text-align: center; ">
          <option value="0" selected="">Pilih - akun</option>
          @foreach($akun as $val)
            <option value="{{$val->id_akun}}" selected="">{{$val->id_akun}} - {{$val->nama_akun}}</option>
          @endforeach
        </select>
      </td>
    </tr>
	  <tr>
	 	<td style="width: 100px">Memo</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text" class="form-control keterangan_biaya" style=""></td>
	 </tr>
	  <tr>
		<td style="width: 100px">Total</td>
		<td width="10">:</td>
		<td width="200"><input type="text" name="total_jml" class="form-control total_jml" style="" readonly=""></td>
	  </tr>
	  <tr>
		<td style="width: 100px">Nominal</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" name="nominal" class="form-control nominal" onkeyup="hitung()" style="">
			<input type="hidden" readonly="" class="form-control harga_do" style="">
		</td>
	  </tr>
	  <tr>
	  	<td colspan="3">
	  <button class="btn btn-info modal_penerus_tt" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_penerus" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
     <button type="button" class="btn btn-primary pull-right cari-pod" onclick="appendDO();"><i class="fa fa-search">&nbsp;Append</i></button>
	  	</td>
	  </tr>
	  <tr>
	  	<td colspan="3">
	  		<button type="button" class="btn btn-primary pull-right disabled save_biaya" id="save-update"  onclick="save_biaya()" ><i class="fa fa-save"></i> Simpan Data</button>
	  		<button type="button" class="btn btn-warning pull-left disabled" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
	  	</td>
	  </tr>
     </table>
      
    </form>
</div>

 <div class="table_biaya col-sm-12" hidden="">
 	<h3>Tabel Detail Resi</h3>
 	<hr>
	    <table class="table table-bordered table-hover datatable">
			<thead align="center">
				<tr>
				<th>No</th>
				<th width="90">Nomor Bukti</th>
				<th width="90">AccBiaya</th>
				<th>Jumlah Bayar</th>
				<th>Tipe Debet</th>
				<th>Keterangan</th>
				<th width="50">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	</div>
	
<div id="modal_biaya_update" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <div class="modal-body">
     <table class="table table_detail">
         <div align="center" style="width: 100%;">  
        <h3 >Detail Biaya Penerus Hutang</h3>
       </div> 
        <tr>
        <td style="width: 100px">Nomor</td>
        <td width="10">:</td>
        <td width="200">
          <input type="text" name="e_jml_data" value="1" class="form-control e_jml_data" style="" readonly="">
        </td>
        </tr>
        <tr>
          <td style="width: 100px">Nomor POD</td>
          <td width="10">:</td>
          <td width="200">
            <input type="text" name="no_pod" id="tages" class="form-control e_no_pod" style="">
          </td>
        </tr>
         <tr>
        <td style="width: 100px">Debet/Kredit</td>
        <td width="10">:</td>
        <td>
          <select name="debit" class="form-control e_debit" style="text-align: center; ">
            <option value="debit" selected="">DEBIT</option>
            <option value="kredit">KREDIT</option>
          </select>
        </td>
        </tr>
        <tr>
          <td style="width: 100px ;">Akun</td>
          <td width="10">:</td>
          <td>
            <select class="form-control e_akun_biaya chosen-select-width1" style="text-align: center; ">
              <option value="0" selected="">Pilih - akun</option>
              @foreach($akun as $val)
                <option value="{{$val->id_akun}}" selected="">{{$val->id_akun}} - {{$val->nama_akun}}</option>
              @endforeach
            </select>
          </td>
        </tr>
        <tr>
        <td style="width: 100px">Memo</td>
        <td width="10">:</td>
        <td width="200"><input type="text" class="form-control e_keterangan_biaya" style=""></td>
       </tr>
        <tr>
        <td style="width: 100px">Nominal</td>
        <td width="10">:</td>
        <td width="200">
          <input type="text" name="nominal" class="form-control e_nominal" onkeyup="hitung()" style="">
        </td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="pull-right">
              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="save-update" onclick="update_tabel_detail()" data-dismiss="modal">Save changes</button>
            </div>
          </td>
        </tr>
     </table>
      </div>      
    </div>
    	
  </div>
</div>


<!--  MODAL TT PENERUS  -->

<div class="modal fade" id="modal_tt_penerus" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-stripped tabel_tt_outlet">
        	<tr>
        		<td width="150px">
                  No Tanda Terima 
                </td>
                <td>
                  <input type='text' name="nota_tt" class='input-sm form-control notandaterima'>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </td>
        	</tr>
        	<tr>
        		<td> Tanggal </td>
                <td>
                   <div class="input-group date">
                    	<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" value="" readonly="" name="tgl_tt">
                  </div>
                </td>
        	</tr>
        	<tr>
              <td> Supplier </td>
              <td> <input type='text' class="form-control supplier_tt" value="" name="supplier_tt" readonly=""></td>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                 <div class="row">
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="Kwitansi" type="checkbox" checked="" name="kwitansi">
                            <label for="Kwitansi">
                                Kwitansi / Invoice / No
                            </label>
                      </div> 
                    </div>
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="FakturPajak" type="checkbox" checked="" name="faktur_pajak">
                            <label for="FakturPajak">
                                Faktur Pajak
                            </label>
                      </div> 
                    </div>

                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratPerananAsli" type="checkbox" checked="" name="surat_peranan">
                            <label for="SuratPerananAsli">
                                Surat Peranan Asli
                            </label>
                      </div> 
                    </div>

                     <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratJalanAsli" type="checkbox" checked="" name="surat_jalan">
                            <label for="SuratJalanAsli">
                               Surat Jalan Asli
                            </label>
                      </div> 
                    </div>
                  </div>
              </td>
            </tr>
            <tr>
              <td>
               Lain Lain
              </td>
              <td>                      
                <input type="text" class="form-control lain_penerus" name="lainlain">
              </td>
            </tr>
            <tr>
              <td> Tanggal Kembali </td>
              <td><div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo_tt" readonly="" name="tgl_kembali">
                </div>
              </td>
            </tr>
            <tr>
            <td>Total di Terima</td>
              <td>
              	<div class="row">
              		<div class="col-sm-3">
              			<label class="col-sm-3 label-control"> Rp </label>
              		</div>
              		<div class="col-sm-9">
              			<input type="text" class="form-control totalterima_tt" name="total_diterima" style="text-align:right;" readonly="">
              		</div>
              	</div>
              </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary simpan_penerus" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  var array_do = [];
	var jt = $('.jatuh_tempo').datepicker({
				format:'dd/mm/yyyy',
				autoclose: true
				});
  var dsa = $('.nominal').maskMoney({precision:0,thousands:'.'});
	var dsa = $('.e_nominal').maskMoney({precision:0,thousands:'.'});
	var datatable1 = $('.datatable').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

  function ganti_agen(val) {
    $.ajax({
      url:baseUrl +'/fakturpembelian/rubahVen',
      data: {val},
      success:function(data){
        $('.nama_kontak_td').html(data);
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
  }

  function cari_do() {
    if ($('.agen_vendor').val()  == '0') {
      toastr.warning('Harap Mengisi Nama Agen/Vendor');
      return 1;
    }

    $( ".no_pod" ).autocomplete({
      source:baseUrl + '/fakturpembelian/cari_do', 
      minLength: 1,
      select: function(event, ui) {
          if (ui.item.validator != null) {
            $('.status_pod').val('Terdaftar');
          }
          $('.harga_do').val(ui.item.harga);

      }

    });
  }


  $('.no_pod').blur(function(){
    var index = array_do.indexOf($(this).val());
    if (index != -1) {
      toastr.warning('Data Telah Ada');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }

    if ($('.status_pod').val() != '') {
      toastr.warning('Data Telah Terdaftar Di Sistem');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }else if($('.harga_do').val() == ''){
      toastr.warning('Nomor Do Tidak Ada');
      $('.no_pod').val('');
      $('.status_pod').val('');
      $('.harga_do').val('');
      return 1;
    }else{
      toastr.success('Data Berhasil Diinisialisasi');
      return 1;
    }
  })






  var count = 1;
  function appendDO(){

      var jml_data            = $('.jml_data').val();
      var no_pod              = $('.no_pod ').val();
      var debit               = $('.debit').val();
      var akun_biaya          = $('.akun_biaya').val();
      var keterangan_biaya    = $('.keterangan_biaya ').val();
      var nominal             = $('.nominal').val();
      var harga_do            = $('.harga_do').val();
      nominal                 = nominal.replace(/[^0-9\-]+/g,"");

      if (no_pod == '') {
        toastr.warning('Harap Isi Nomor DO');
        return 1;
      }
      if (keterangan_biaya == '') {
        toastr.warning('Memo Harus Diisi');
        return 1;
      }


      datatable1.row.add( [
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+jml_data+'" name="seq_biaya[]" value="'+jml_data+'" readonly>'+'<div class="seq-app">'+jml_data+'</div>',

                '<input type="hidden" class="form-control tengah kecil no_do" name="no_do[]" value="'+no_pod+'" readonly>'+'<div class="no_do_text">'+no_pod+'</div>',

                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+akun_biaya+'" readonly>'+'<div class="kode_text">'+akun_biaya+'</div>',

                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(nominal)+'" readonly>'+'<div class="bayar_text">'+accounting.formatMoney(nominal, "Rp ", 2, ".",',')+'</div>'+
                '<input type="hidden" class="form-control tengah do_harga" name="do_harga[]" value="'+harga_do+'" readonly>',

                '<input type="hidden" class="form-control tengah debet_biaya" name="debet_biaya[]" value="'+debit+'" readonly>'+'<div class="debet_text">'+debit+'</div>',

                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+keterangan_biaya+'" readonly>'+'<div class="ket_text">'+keterangan_biaya+'</div>',

                '<a class="btn btn-success btn-xs fa fa-pencil" align="center" onclick="edit_biaya(this)" title="edit"></i></a>&nbsp;&nbsp;<a class="btn btn-danger btn-xs fa fa-minus" align="center" onclick="hapus_biaya(this)" title="hapus"></i></a>'
            ] ).draw( false );   
      count++;

      array_do.push(no_pod);
      $('.table_biaya').prop('hidden',false);
      $('.table_detail input').val(''); 
      $('.jml_data').val(count); 
      toastr.success('Data Berhasil Di Append, Buat Tanda Terima Untuk Mengaktifkan fitur Simpan');

  } 

  $('.nominal').on('keydown', function(e) {
    if (e.which == 13) {
      console.log('asd');
      appendDO();
        e.preventDefault();
    }
  });

  function edit_biaya(par) {
    var parent = par.parentNode.parentNode;
    var seq    = $(parent).find('.seq').val();
    var no_do    = $(parent).find('.no_do').val();
    var kode_biaya    = $(parent).find('.kode_biaya').val();
    var bayar_biaya    = $(parent).find('.bayar_biaya').val();
    var debet_biaya    = $(parent).find('.debet_biaya').val();
    var ket_biaya    = $(parent).find('.ket_biaya').val();

    console.log(kode_biaya);
    $('.e_jml_data').val(seq);
    $('.e_no_pod').val(no_do);
    $('.e_akun_biaya').val(kode_biaya).trigger('chosen:updated');
    $('.e_nominal').val(accounting.formatMoney(bayar_biaya,'',0, ".",','));
    $('.e_debit').val(debet_biaya);
    $('.e_keterangan_biaya').val(ket_biaya);

    $('#modal_biaya_update').modal('show');
  }

  function function_name(argument) {
    // body...
  }




</script>
