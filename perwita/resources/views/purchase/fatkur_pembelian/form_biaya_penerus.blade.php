
<div class="col-sm-5 header_biaya"  >
	{{ csrf_field() }}
<form class="head_atas">
<table class="table	head_biaya">
	<h3 style="text-align: center;">Form Biaya Penerus Hutang</h3>
 <tr>
 	<td style="width: 100px">Tanggal</td>
 	<td width="10">:</td>
 	<td width="200" colspan="3">
 		<input type="text" name="tgl_biaya_head" class="form-control tgl-biaya tgl_biaya_head" value="{{$date}}" readonly="" style="">
 		<input type="hidden" class="form-control tgl_resi"  readonly="" style="">
 		<input type="hidden" name="master_persen" class="form-control master_persen"  readonly="" style="">
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200" colspan="3">
 		<input type="text" name="jatuh_tempo" class="form-control jatuh_tempo" value="{{$jt}}" placeholder="Jatuh tempo" style="">
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200" colspan="3"><input type="text" name="status" class="form-control" value="Released" readonly="" style=""></td>
 </tr>
  <tr class="">
 	<td style="width: 100px">Tipe Vendor </td>
 	<td width="10">:</td>
 	<td width="200" colspan="3" class="vendor_td">
 		<select onchange="ganti_agen(this.value)" name="vendor" class="form-control vendor1 "  style="text-align: center; " >
 			<option  selected="" value="kosong">-PILIH TIPE VENDOR-</option>
 			<option value="AGEN">Agen Penerus </option>
 			<option value="VENDOR">Vendor Penerus</option>
 		</select>
 	</td>
 </tr>
 <tr class="nama-kontak-kosong">
 	<td style="width: 100px">Nama Agen/Vendor </td>
 	<td width="10">:</td>
 	<td width="200" colspan="3" class="nama_kontak_td">
 		<select name="" class="form-control agen_vendor" style="text-align: center; ">
 			<option value="0" selected="">-PILIH NAMA AGEN/VENDOR-</option>
 		</select>
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">No Invoice</td>
 	<td width="10">:</td>
 	<td width="200" colspan="3"><input type="text" name="Invoice_biaya" readonly="" class="form-control invoice_tt" style="" placeholder="No Invoice"></td>
 </tr>
 <tr>
  <td style="width: 100px">Tanda terima</td>
  <td width="10">:</td>
  <td width="200" colspan="3">
    <input type="text" readonly="" name="tanda_terima" class="form-control tanda_terima" value="" >
    <input type="hidden" readonly="" name="invoice_tt" class="form-control invoice_tt" value="" >
    <input type="hidden" readonly="" name="id_tt" class="form-control id_tt" value="" >
    <input type="hidden" readonly="" name="dt_tt" class="form-control dt_tt" value="" >
  </td>
 </tr>
  <tr>
 	<td style="width: 100px">Keterangan</td>
 	<td width="10">:</td>
 	<td width="200" colspan="3">
    <input type="text" name="Keterangan_biaya" style="text-transform: uppercase;" class="form-control" style="">
  </td>
 </tr>	
 <tr>
    <td style="width: 100px">Total</td>
    <td width="10">:</td>
    <td width="200" colspan="3">
      <input value="0" type="text" name="total_kotor_penerus" class="form-control total_kotor_penerus" style="" readonly="">
    </td>
  </tr>
 <tr>
    <td style="width: 100px">Diskon</td>
    <td width="10">:</td>
    <td width="200" colspan="3">
      <input value="" type="text" name="diskon_penerus" class="form-control diskon_penerus hanya_angka">
    </td>
  </tr>
 <tr>
    <td style="width: 100px">DPP</td>
    <td width="10">:</td>
    <td width="200" colspan="3">
      <input value="Rp. 0,00" type="text" name="total_dpp_penerus" class="form-control total_dpp_penerus" style="" readonly="">
    </td>
  </tr>
 </tr>
  <tr>
  <td style="width: 100px" >Jenis PPN</td>
  <td width="10">:</td>
  <td width="200" >
    <select onchange="hitung_ppn_penerus()" class="form-control jenis_ppn_penerus chosen-select-width1" name="jenis_ppn_penerus">
      <option>Pilih - PPN</option>
      <option class="include">INCLUDE</option>
      <option class="exclude">EXCLUDE</option>
    </select>
  </td>
  <td style="width: 100px">
    <input type="text" name="persen_ppn_penerus" value="10" style="text-transform: uppercase;" class="form-control persen_ppn_penerus hanya_angka center" onkeyup="hitung_ppn_penerus()">
  </td>
  <td width="200" >
    <input type="text" name="ppn_penerus" readonly="" style="text-transform: uppercase;" class="form-control ppn_penerus" style="">
  </td>
 </tr>  
 <tr>
  <td style="width: 100px" >Jenis PPH</td>
  <td width="10">:</td>
  <td width="200" >
    <select class="form-control jenis_pph_penerus chosen-select-width1" name="jenis_pph_penerus" onchange="hitung_pph_penerus()">
      <option>Pilih - PPH</option>
      @foreach ($pajak as $val)
        <option class="{{ $val->kode }}" data-val="{{ $val->nilai }}">{{ $val->nama }}</option>
      @endforeach
    </select>
  </td>
  <td style="width: 100px">
    <input type="text" readonly="" name="persen_pph_penerus" value="0" style="text-transform: uppercase;" class="form-control persen_pph_penerus hanya_angka center">
  </td>
  <td width="200" >
    <input type="text" readonly="" name="pph_penerus" style="text-transform: uppercase;" class="form-control pph_penerus" style="">
  </td>
 </tr> 
 <tr>
    <td style="width: 100px">Total Netto</td>
    <td width="10">:</td>
    <td width="200" colspan="3">
      <input value="Rp. 0,00" type="text" name="total_netto" class="form-control total_netto" style="" readonly="">
    </td>
  </tr>
<tr>
  <td colspan="5">
     <button onclick="tt_penerus()" class="btn btn-info modal_penerus_tt disabled" style="margin-right: 20px;" type="button" data-toggle="modal" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
     <button type="button" class="btn btn-danger" onclick="modal_pajak_penerus()">Faktur Pajak</button>
     <button type="button" style="margin-right: 20px;" class="btn btn-warning pull-left disabled" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
  </td>
</tr>
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
		<td style="width: 100px">DEBET/Kredit</td>
		<td width="10">:</td>
		<td>
			<select name="DEBET" class="form-control DEBET" style="text-align: center; ">
 				<option value="DEBET" selected="">DEBET</option>
 				<option value="kredit">KREDIT</option>
 			</select>
 		</td>
	  </tr>
{{--     <tr>
      <td style="width: 100px ;">Akun</td>
      <td width="10">:</td>
      <td class="disabled">
        <select class="form-control akun_biaya chosen-select-width1" style="text-align: center; ">
          <option value="0" selected="">Pilih - akun</option>
          @foreach($akun as $val)
            <option @if($val->id_akun == '531512000') selected="" @endif value="{{$val->id_akun}}" >{{$val->id_akun}} - {{$val->nama_akun}}</option>
          @endforeach
        </select>
      </td>
    </tr> --}}
	  <tr>
	 	<td style="width: 100px">Memo</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text" class="form-control keterangan_biaya" style="text-transform: uppercase;" style=""></td>
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
        <button type="button" class="btn btn-primary pull-right cari-pod" onclick="appendDO();"><i class="fa fa-search">&nbsp;Append</i></button>

        <button type="button" class="btn btn-primary pull-right disabled save save_biaya" style="margin-right: 20px" id="save-update"  onclick="save_biaya()" ><i class="fa fa-save"></i> Simpan Data</button>

        <button class="btn btn-primary btn_modal_bp disabled" type="button" > Bayar dengan Uang Muka </button>

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
				<th>Nomor Bukti</th>
				<th >AccBiaya</th>
				<th>Jumlah Bayar</th>
				<th>Tipe debet</th>
				<th>Keterangan</th>
				<th>Aksi</th>
				</tr>
			</thead> 
			<tbody class="body-biaya">

			</tbody>   	
	    </table>
	</div>
	
<div id="modal_biaya_update" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 800px;">

    <!-- Modal content-->
    <div class="modal-content ">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <div class="modal-body" >
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
          <td style="width: 100px">Nomor DO</td>
          <td width="10">:</td>
          <td width="200">
            <input type="text"  readonly="" name="no_pod" id="tages" class="form-control e_no_pod" style="">
          </td>
        </tr>
         <tr>
        <td style="width: 100px">Debet/Kredit</td>
        <td width="10">:</td>
        <td>
          <select name="DEBET" class="form-control e_DEBET" style="text-align: center; ">
            <option value="DEBET" selected="">DEBET</option>
            <option value="kredit">KREDIT</option>
          </select>
        </td>
        </tr>
        <tr>
          <td style="width: 100px ;">Akun</td>
          <td width="10">:</td>
          <td class="disabled">
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
              <button type="button" class="btn btn-primary" id="save-update" onclick="update_biaya()" data-dismiss="modal">Update</button>
            </div>
          </td>
        </tr>
     </table>
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

  var jt = $('.tgl_biaya_head').datepicker({
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
            columnDefs: [
              {
                 targets: 0,
                 className: 'center'
              },
              {
                 targets: 3,
                 className: 'right'
              },
              {
                 targets: 6,
                 className: 'center'
              }
            ]
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


  $('.jenis_pph_penerus').change(function(){
    var jumlah = $('.jenis_pph_penerus option:selected').data('val');
    $('.persen_pph_penerus ').val(jumlah);
  })

  function hitung_total() {
    var total_dpp_penerus  = $('.total_dpp_penerus').val().replace(/[^0-9\-]+/g,"")/100;
    var ppn_penerus        = $('.ppn_penerus').val().replace(/[^0-9\-]+/g,"")/100;
    var pph_penerus        = $('.pph_penerus').val().replace(/[^0-9\-]+/g,"")/100;

    var hasil = total_dpp_penerus + ppn_penerus - pph_penerus;
    $('.total_netto').val(accounting.formatMoney(hasil, "", 2, ".",','));
  }

  function hitung_ppn_penerus() {
    var jenis_ppn_penerus  = $('.jenis_ppn_penerus ').val();
    var ppn_penerus  = $('.total_dpp_penerus').val().replace(/[^0-9\-]+/g,"")/100;
    var persen_ppn_penerus = $('.persen_ppn_penerus ').val();
    var total_kotor_penerus  = $('.total_kotor_penerus').val().replace(/[^0-9\-]+/g,"")/100;
    var diskon_penerus  = $('.diskon_penerus').val();
    var td = total_kotor_penerus - diskon_penerus;
    var hasil = 0;
    if (jenis_ppn_penerus == 'EXCLUDE') {
      hasil = persen_ppn_penerus/100 * td;
      $('.total_dpp_penerus').val(accounting.formatMoney(td, "", 2, ".",','));
    }else if (jenis_ppn_penerus == 'INCLUDE') {
      hasil = persen_ppn_penerus/(100+persen_ppn_penerus*1) * td;
      $('.total_dpp_penerus').val(accounting.formatMoney(td - hasil, "", 2, ".",','));
    }

    $('.ppn_penerus').val(accounting.formatMoney(hasil, "", 2, ".",','));
    hitung_total();
  }

  function hitung_pph_penerus() {
    var jenis_pph_penerus  = $('.jenis_pph_penerus ').val();
    var total_kotor_penerus  = $('.total_kotor_penerus').val().replace(/[^0-9\-]+/g,"")/100;
    var diskon_penerus  = $('.diskon_penerus').val();
    var persen_pph_penerus = $('.persen_pph_penerus ').val();

    var hasil = 0;
    var td = total_kotor_penerus - diskon_penerus;
    hasil = persen_pph_penerus/100 * td;
    $('.pph_penerus').val(accounting.formatMoney(hasil, "", 2, ".",','));
    hitung_total();
  }

  $('.diskon_penerus').keyup(function(){
    hitung();
  })

  function hitung() {
    var temp = 0;
    var diskon_penerus =  $('.diskon_penerus').val();
    if (diskon_penerus == '') {
      diskon_penerus = 0;
    }

    datatable1.$('.bayar_biaya').each(function(){
      temp+=parseInt($(this).val());
    })

    var hasil = temp - diskon_penerus;
    if (hasil < 0) {
      toastr.warning('PERHATIAN! DPP tidak boleh minus');

      datatable1.$('.bayar_biaya').each(function(){
        temp+=parseInt($(this).val());
      })
      $('.diskon_penerus').val('0');
      hitung();
      return false;
    }
    $('.total_kotor_penerus').val(accounting.formatMoney(temp, "", 2, ".",','));
    $('.total_dpp_penerus').val(accounting.formatMoney(hasil, "", 2, ".",','));

    hitung_ppn_penerus();
    hitung_pph_penerus();
    hitung_total();
  }


  var count = 1;
  function appendDO(){

      var jml_data            = $('.jml_data').val();
      var no_pod              = $('.no_pod ').val();
      var DEBET               = $('.DEBET').val();
      var akun_biaya          = $('.akun_biaya').val();
      var akun_biaya_text     = $('.akun_biaya :selected').text();
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
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+jml_data+'" name="seq_biaya[]" value="'+jml_data+'" readonly>'+'<div class="seq_text">'+jml_data+'</div>',

                '<input type="hidden" class="form-control tengah kecil no_do" name="no_do[]" value="'+no_pod+'" readonly>'+'<div class="no_do_text">'+no_pod+'</div>',

                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+akun_biaya+'" readonly>'+'<div class="kode_biaya_text">'+akun_biaya_text+'</div>',

                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(nominal)+'" readonly>'+'<div class="bayar_biaya_text">'+accounting.formatMoney(nominal, "Rp ", 2, ".",',')+'</div>'+
                '<input type="hidden" class="form-control tengah do_harga" name="do_harga[]" value="'+harga_do+'" readonly>',

                '<input type="hidden" class="form-control tengah DEBET_biaya" name="DEBET_biaya[]" value="'+DEBET+'" readonly>'+'<div class="DEBET_biaya_text">'+DEBET+'</div>',

                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+keterangan_biaya+'" readonly>'+'<div class="ket_biaya_text">'+keterangan_biaya+'</div>',

                
                '<div class="btn-group ">'+
                '<a  onclick="edit_biaya(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
                '<a  onclick="hapus_biaya(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
                '</div>',
            ] ).draw( false );   
      count++;
      array_do.push(no_pod);
      $('.table_biaya').prop('hidden',false);
      $('.table_detail input').val(''); 
      $('.jml_data').val(count); 
      $('.modal_penerus_tt').removeClass('disabled');
      toastr.success('Data Berhasil Di Append, Buat Tanda Terima Untuk Mengaktifkan fitur Simpan');
      $('.vendor_td').addClass('disabled');
      $('.nama_kontak_td').addClass('disabled');
      hitung();

  } 

  $('.nominal').on('keydown', function(e) {
    if (e.which == 13) {
      appendDO();
        e.preventDefault();
    }
  });

  function edit_biaya(par) {
    var parent = $(par).parents('tr');
    var seq    = $(parent).find('.seq').val();
    var no_do    = $(parent).find('.no_do').val();
    var kode_biaya    = $(parent).find('.kode_biaya').val();
    var bayar_biaya    = $(parent).find('.bayar_biaya').val();
    var DEBET_biaya    = $(parent).find('.DEBET_biaya').val();
    var ket_biaya    = $(parent).find('.ket_biaya').val();

    console.log(kode_biaya);
    $('.e_jml_data').val(seq);
    $('.e_no_pod').val(no_do);
    $('.e_akun_biaya').val(kode_biaya).trigger('chosen:updated');
    $('.e_nominal').val(accounting.formatMoney(bayar_biaya,'',0, ".",','));
    $('.e_DEBET').val(DEBET_biaya);
    $('.e_keterangan_biaya').val(ket_biaya);

    $('#modal_biaya_update').modal('show');
  }

  function update_biaya() {
   var e_jml_data = $('.e_jml_data').val();
   var e_no_pod = $('.e_no_pod').val();
   var e_akun_biaya = $('.e_akun_biaya').val();
   var e_nominal = $('.e_nominal').val();
   e_nominal = e_nominal.replace(/[^0-9\-]+/g,"");
   var e_DEBET = $('.e_DEBET').val();
   var e_keterangan_biaya = $('.e_keterangan_biaya').val();

   var e_akun_biaya_text = $('.e_akun_biaya :selected').text();

   var par = $('.seq_biaya_'+e_jml_data).parents('tr');


   $(par).find('.seq').val(e_jml_data);
   $(par).find('.no_do').val(e_no_pod);
   $(par).find('.kode_biaya').val(e_akun_biaya);
   $(par).find('.bayar_biaya').val(e_nominal);
   $(par).find('.DEBET_biaya').val(e_DEBET);
   $(par).find('.ket_biaya').val(e_keterangan_biaya);

   $(par).find('.seq_text').text(e_jml_data);
   $(par).find('.bayar_biaya_text').text(accounting.formatMoney(e_nominal, "Rp ", 2, ".",','));
   $(par).find('.no_do_text').text(e_no_pod);
   $(par).find('.kode_biaya_text').text(e_akun_biaya_text);
   $(par).find('.DEBET_biaya_text').text(e_DEBET);
   $(par).find('.ket_biaya_text').text(e_keterangan_biaya);
   hitung();

  }

  function hapus_biaya(par) {
    var parent = $(par).parents('tr');
    var pod = $(parent).find('.no_do').val();
    
    var index = array_do.indexOf(pod);
  
    array_do.splice(index,1);
    datatable1.row(parent).remove().draw(false);

    var temp = 0;
    $('.no_do').each(function(){
      temp+=1;
    })
    if (temp == 0) {
      $('.vendor_td').removeClass('disabled');
      $('.nama_kontak_td').removeClass('disabled');
      $('.save_biaya').addClass('disabled');
      $('.modal_penerus_tt').addClass('disabled');
    }
    
    hitung();
  }

  function modal_pajak_penerus() {
    $('#modal_pajak').modal('show');
  }

  function tt_penerus() {

    var cabang = $('.cabang').val();
    var agen_vendor = $('.agen_vendor ').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/nota_tt',
      data: {cabang,agen_vendor},
      success:function(data){
        $('.div_tt').html(data);
        $('#modal_tt_penerus').modal('show');
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })

  }
  function select_tt(a) {
    var tt_form = $(a).find('.tt_form').text();
    var tt_invoice = $(a).find('.tt_invoice').text();
    var tt_id = $(a).find('.tt_id').val();
    var tt_dt = $(a).find('.tt_dt').val();

    $('.tanda_terima').val(tt_form);
    $('.invoice_tt').val(tt_invoice);
    $('.id_tt').val(tt_id);
    $('.dt_tt').val(tt_dt);
    $('#modal_tt_penerus').modal('hide');
    $('.save').removeClass('disabled');
  }



  function save_biaya() {

      var temp = 0;
      $('.no_do').each(function(){
        temp+=1;
      })

      if (temp == 0) {
        toastr.warning('Tidak Ada Data');
        return 1;
      }

      swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: true
      },
      function(){
           $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
          $.ajax({
          url:baseUrl + '/fakturpembelian/save_agen',
          type:'post',
          data:$('.head1 :input').serialize()
              +'&'+$('.head_biaya :input').serialize()
              +'&'+datatable1.$('input').serialize(),
          success:function(response){
            if (response.status == 1) {
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                      $('.save_biaya').addClass('disabled');
                      $('.modal_penerus_tt').removeClass('disabled');
                      $('#print-penerus').removeClass('disabled');
                      $('.idfaktur').val(response.id);
                      $('.save_bp_um').removeClass('disabled');
                      $('.btn_modal_bp').removeClass('disabled');
                      $('#tabmenu').addClass('disabled');
                    });
            }else{
              swal({
                title: "Terjadi Kesalahan",
                type: 'error',
                text: response.pesan,
                timer: 3000,
                showConfirmButton: true

              });
            }
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
  }

function print_penerus() {
  var idfaktur = $('.idfaktur').val();
  console.log(idfaktur);
  window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
}


function hitung_um() {
  var temp = 0;
  datatable2.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  $('.bp_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  


var array_um1 = [];
var array_um2 = [];
$('.btn_modal_bp').click(function(){
  $('#modal_um_bp').modal('show');
})


var array_um1 = [0];
var array_um2 = [0];
$('.bp_nomor_um').focus(function(){
  var sup = $('.agen_vendor').val();
  if (sup == '0') {
    toastr.warning('Agen/Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus_um',
    data: {sup,array_um1,array_um2},
    success:function(data){
      console.log('asd');
      $('.bp_div_um').html(data);
      $('#modal_show_um').modal('show');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })

})
var id_um    = 1;

$('.bp_tambah_um').click(function(){
  var nota = $('.bp_nomor_um').val();
  var sup = $('.agen_vendor').val();
  var nofaktur = $('.nofaktur').val();
  var bp_id_um = $('.bp_id_um').val();
  var bp_dibayar_um = $('.bp_dibayar_um').val();
  bp_dibayar_um   = bp_dibayar_um.replace(/[^0-9\-]+/g,"")/1;





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (bp_dibayar_um == '' || bp_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup},
    dataType:'json',
    success:function(data){

      $('.bp_nomor_um').val(data.data.nomor);
      $('.bp_tanggal_um').val(data.data.um_tgl);
      $('.bp_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.bp_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.bp_keterangan_um').val(data.data.um_keterangan);

      if (bp_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (bp_id_um == '') {
        datatable2.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(bp_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+bp_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+bp_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(bp_dibayar_um);
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(bp_dibayar_um, "", 2, ".",','));
      }
      hitung_um();
      $('.bp_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.bp_id_um').val(tb_faktur_um);
  $('.bp_nomor_um').val(tb_transaksi_um);
  $('.bp_tanggal_um').val(tb_tanggal_text);
  $('.bp_jumlah_um').val(tb_jumlah_um_text);
  $('.bp_sisa_um').val(tb_sisa_um_text);
  $('.bp_keterangan_um').val(tb_keterangan_um_text)
  $('.bp_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  datatable2.row(par).remove().draw(false);

  hitung_um();
}


$('.save_bp_um').click(function(){

  var temp = 0;
  var bp_total_um = $('.bp_total_um').val();
  datatable2.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  var total_netto = $('.total_netto').val();
  total_netto   = total_netto.replace(/[^0-9\-]+/g,"")/100;

  if (temp > total_netto) {
    toastr.warning("Pembayaran Lebih Besar Dari Total Faktur");
    return false;
  }

  swal({
      title: "Apakah anda yakin?",
      text: "Simpan Data!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Ya, Simpan!",
      cancelButtonText: "Batal",
      closeOnConfirm: true
    },
    function(){
         $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
        url:baseUrl + '/fakturpembelian/save_bp_um',
        type:'post',
        data:$('.head1 :input').serialize()
              +'&'+$('.head_biaya :input').serialize()
              +'&'+datatable2.$('input').serialize()+'&bp_total_um='+bp_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_bp_um').addClass('disabled');
                   $('.btn_modal_bp').addClass('disabled');
                   
                  });
          }else if(response.status == 0){
            swal({
              title: "Data Faktur Tidak Ada",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }else if(response.status == 2){
            swal({
              title: "Status Faktur Pending",
              type: 'error',
              timer: 900,
              showConfirmButton: true

            });
          }
        },
        error:function(data){
          swal({
          title: "Terjadi Kesalahan",
                  type: 'error',
                  timer: 900,
                 showConfirmButton: true

      });
     }
    });  
  });
})
</script>
