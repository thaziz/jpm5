
<div class="col-sm-12 header_biaya"  >
	{{ csrf_field() }}
<form>
<div class="col-sm-6">
<table class="table	head_subcon">
	<h3 style="text-align: center;">Form Subcon</h3>
<tr>
 	<td style="width: 100px">Tanggal</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{$date}}" readonly="" style="">
 		<input type="hidden" name="nota_id_tt" class="form-control nota_id_tt" value="" readonly="" style="">
 		<input type="hidden" name="nota_no_tt" class="form-control nota_no_tt" value="" readonly="" style="">
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tempo_subcon" class="form-control tempo_subcon" value="{{$date}}" >
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" ></td>
 </tr>
  <tr class=" hd2" >
 	<td style="width: 100px">Nama Subcon</td>
 	<td width="10">:</td>
 	<td width="200" class="subcon_td">
 		<select class="nama_sc form-control chosen-select-width1" name="nama_subcon">
 				<option value="0">- Cari - Subcon -</option>
 			@foreach($subcon as $sub)
 				<option value="{{$sub->kode}}">{{$sub->kode}} - {{$sub->nama}}</option>
 			@endforeach
 		</select>
 	</td>
  </tr>	
 <tr>
 	<td style="width: 100px">No Invoice </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="invoice_subcon" class="form-control invoice_subcon" ></td>
 </tr>	
 <tr>
 	<td style="width: 100px">Keterangan </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="keterangan_subcon" class="form-control keterangan_subcon"  ></td>
 </tr>	
 <tr>
 	<td style="width: 100px">Total Biaya</td>
 	<td width="10">:</td>
	<td width="200"><input type="text" readonly="" style="text-align: right"  class="form-control total_subcon" name="total_subcon" ></td>
 </tr>
</table>
</div>
<div class="col-sm-12 detail_subcon"  >
	<div class="col-sm-5 table_filter_subcon"   >
    <form class="form">
	  <table class="table table_resi">
	  	<div align="center" style="width: 100%;">	
			<h3 >Form Resi Subcon</h3>
		</div>	
	  <tr hidden="">
		<td style="width: 100px">Nomor Seq</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" class="form-control m_seq" readonly="" value="1" >
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Nomor POD</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" placeholder="Klik Disini..." class="form-control m_do_subcon"  >
		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Jenis Angkutan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_jenis_angkutan_do" >
		</td>
	 </tr>
	  <tr>
		<td style="width: 100px">Tanggal</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" placeholder="" class="form-control m_do_tanggal"  >
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px" class="label_satuan">Jumlah</td>
		<td width="10">:</td>
		<td class="form-inline form_satuan">
			<div class="input-group" style="width: 100%">
                <input readonly=""  style="width: 100%" class="form-control m_do_jumlah" type="text" value="" >
                <span class="input-group-addon m_satuan" style="padding-bottom: 12px;">satuan</span>
             </div>
 		</td>
	  </tr>
	  
	  
	 <tr>
	 	<td style="width: 100px">Asal DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_do_asal" >
		</td>
	 </tr>
	 <tr>
	 	<td style="width: 100px">Tujuan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_do_tujuan" >
		</td>
	 </tr>

	 <tr>
	 	<td style="width: 100px">Tipe Kendaraan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_tipe_kendaraan" >
		</td>
	 </tr>
	
     </table>
    </form>
</div>
	<div class="col-sm-5" style="margin-left: 100px;">
	<table class="table table_kontrak" >
	     <div align="center" style="width: 100%;" >	
			<h3 >Form Kontrak Subcon</h3>
		 </div>	
		  <tr>
			<td style="width: 100px">Nomor</td>
			<td width="10">:</td>
			<td>
				<input type="text" name="sc_nomor_kontrak" class="form-control nota_subcon"  placeholder="Klik Disini...">
				<input type="hidden" name="sc_id_subcon" class="form-control id_subcon"  readonly="">
				<input type="hidden" name="sc_dt_subcon" class="form-control dt_subcon"  readonly="">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Biaya Subcon</td>
			<td width="10">:</td>
			<td width="200">
				<input type="text" class="form-control sc_biaya_subcon"  readonly="" value="" >
				<input type="hidden" class="form-control sc_biaya_subcon_dt" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
		 	<td style="width: 100px">Jumlah</td>
		 	<td width="10">:</td>
			<td width="200">
				<div class="input-group" style="width: 100%">
	                <input onkeyup="hitung_jumlah()" style="width: 100%" class="form-control sc_jumlah" type="text" value="" >
             	</div>
			</td>
		 </tr>
		 <tr>
		 	<td style="width: 100px">Total Biaya</td>
		 	<td width="10">:</td>
			<td width="200">
				<div class="input-group" style="width: 100%">
	                <input readonly=""  style="width: 100%" class="form-control sc_total" type="text" value="" >
	                <input readonly=""  style="width: 100%" class="form-control sc_total_dt" type="hidden" value="" >
             	</div>
			</td>
		 </tr>
		  <tr>
			<td style="width: 100px">Jenis Tarif</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" name="tarif_subcon" class="form-control sc_tarif_subcon" readonly=""  >
				<input type="hidden" name="kode_tarif_subcon" class="form-control sc_tarif_subcon" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Akun</td>
			<td width="10">:</td>
			<td width="200">
				<select class="form-control chosen-select-width1 sc_akun">
					@foreach($akun_biaya as $i)
						<option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
					@endforeach
				</select>
			</td>
		  </tr>
		  
		  <tr>
		 	<td style="width: 100px">Memo</td>
		 	<td width="10">:</td>
			<td width="200">
				<input type="text"  class="form-control sc__do_memo" >
			</td>
		 </tr>
		  <tr>
			<td style="width: 100px">Asal Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly="" class="form-control sc_asal_subcon" >
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Tujuan Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly=""  class="form-control sc_tujuan_subcon">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Kendaraaan</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" class="form-control sc_kendaraan_subcon" readonly=""  >
				<input type="hidden" class="form-control sc_kode_angkutan" style="width: 250px;">
			</td>
		  </tr>
		   <tr>
		 	<td colspan="3">
		 		<button class="btn btn-info modal_tt_subcon disabled pull-left" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
			    <button type="button" class="btn btn-primary pull-right append_subcon" onclick="cariSUB()"><i class="fa fa-plus">&nbsp;Append</i></button>
			    <button type="button" style="margin-right: 20px" class="btn  pull-right" onclick="cancel_data()"><i class="fa fa-close">&nbsp;Clear</i></button>
		 	</td>
		 </tr>
	</table>
	</div>
</div>
</form>
</div>



<div class="col-sm-5 table_filter_resi disabled " hidden   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">	
		<h3 >Detail Biaya Penerus Hutang</h3>
	 </div>	
	  
     </table>
     <button type="button" class="btn btn-primary pull-right cari_pod" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>

 <div class=" col-sm-12 tb_sb_hidden">
 	<h3>Tabel Detail Resi</h3>
 	<hr>
	    <button type="button" class="btn btn-primary pull-right save_subcon disabled" id="save_subcon" onclick="save_subcon()"><i class="fa fa-save"></i> Simpan Data</button>
	    <button type="button" style="margin-right: 20px" class="btn btn-warning pull-right print_subcon disabled" id="print_subcon" onclick="print_penerus()"><i class="fa fa-print"></i> Print</button>

	    <table class="table table-bordered table-hover tabel_subcon">
			<thead align="center">
				<tr>
				<th>No</th>
				<th width="90">Nomor Resi</th>
				<th>Harga Resi</th>
				<th>Asal Subcon</th>
				<th>Tujuan Subcon</th>
				<th>Jenis Tarif</th>
				<th>Akun</th>
				<th>Keterangan</th>
				<th width="100">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	</div>
	
<div id="modal_subcon" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 800px;">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body subcon_modal">

     	<div class="pull-right">
     		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    		<button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Save changes</button>
    	</div>
      </div>      
    </div>
    	
  </div>
</div>


{{-- MODAL TT SUBCON --}}

<div class="modal fade" id="modal_tt_subcon" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 1000px !important; min-height: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-stripped tabel_tt_subcon">
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
                <input type="text" class="form-control lain_subcon" name="lainlain_penerus">
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
              			<input type="text" class="form-control totalterima_tt_subcon" name="total_diterima" style="text-align:right;" readonly="">
              		</div>
              	</div>
              </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary simpan_subcon" onclick="simpan_tt()" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>



<!-- modal DO-->
<div id="modal_do" class="modal fade" >
  <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Nomor DO</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal  tabel_subcon_detail">
               
            </form>
          </div>
          <div class="modal-footer">
          </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	// global variable
	var array_do =[];
var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }	 
var subcon = $('.tabel_subcon').DataTable({
					// 'paging':false,
					'searching':false
				});

$('.tempo_subcon').datepicker({
	format:'dd/mm/yyyy'
});


$('.m_do_subcon').focus(function(){
	  var  selectOutlet = $('.nama_sc').val();
	  if (selectOutlet == '0') {
	  	toastr.warning('Harap Pilih Customer');
	  	return 1;
	  }

	  var  cabang     = $('.cabang').val();

	  $.ajax({
	      url:baseUrl +'/fakturpembelian/cari_do_subcon',
	      data: {selectOutlet,cabang,array_do},
	      success:function(data){
	        $('.tabel_subcon_detail').html(data);
			$('#modal_do').modal('show');
	      },error:function(){
	        toastr.warning('Terjadi Kesalahan');
	      }
	    })
})

$('.nota_subcon').focus(function(){
	  var  selectOutlet = $('.nama_sc').val();
	  if (selectOutlet == '0') {
	  	toastr.warning('Harap Pilih Customer');
	  	return 1;
	  }

	  var  cabang     = $('.cabang').val();

	  $.ajax({
	      url:baseUrl +'/fakturpembelian/cari_kontrak_subcon',
	      data: {selectOutlet,cabang},
	      success:function(data){
	        $('.subcon_modal').html(data);
			$('#modal_subcon').modal('show');
	      },error:function(){
	        toastr.warning('Terjadi Kesalahan');
	      }
	    })
})




function pilih_do_subcon(par) {
	var d_nomor_do = $(par).find('.d_nomor_do').val();
	var d_tanggal = $(par).find('.d_tanggal').val();
	var d_jumlah = $(par).find('.d_jumlah').val();
	var d_satuan = $(par).find('.d_satuan').val();
	var d_asal = $(par).find('.d_asal').val();
	var d_tujuan = $(par).find('.d_tujuan').val();
	var d_asal_text = $(par).find('.d_asal_text').text();
	var d_tujuan_text = $(par).find('.d_tujuan_text').text();
	var d_jenis_tarif_text = $(par).find('.d_jenis_tarif_text').text();
	var d_tipe_angkutan_text = $(par).find('.d_tipe_angkutan_text').text();
	var d_tipe_angkutan = $(par).find('.d_tipe_angkutan').val();

	$('.m_do_subcon').val(d_nomor_do);
	$('.m_do_tanggal').val(d_tanggal);
	$('.m_do_jumlah').val(d_jumlah);
	$('.m_satuan').text(d_satuan);
	$('.m_do_asal').val(d_asal_text);
	$('.m_do_tujuan').val(d_tujuan_text);
	$('.m_jenis_angkutan_do').val(d_jenis_tarif_text);
	$('.m_tipe_kendaraan').val(d_tipe_angkutan_text);

	$('.no_do_asal').val(d_asal);
	$('.no_do_tujuan').val(d_tujuan);
	$('.no_tipe_kendaraan').val(d_tipe_angkutan);
	
	$('#modal_do').modal('hide');




}

function hitung_jumlah() {
  	var harga = $('.sc_biaya_subcon_dt').val();
  	var jumlah = $('.sc_jumlah').val();
  	$('.sc_total').val(accounting.formatMoney(harga * jumlah, "Rp ", 2, ".",','));
  	$('.sc_total_dt').val(harga * jumlah);
	
}
function pilih_kontrak(asd){
	var id = $(asd).find('.id_kontrak').val();

	$.ajax({
		url : baseUrl +'/fakturpembelian/pilih_kontrak',
	    data: 'id='+id,
	    type:'get',
	    dataType:'json',
	    success:function(response){
	    	console.log(response.subcon_dt[0].ksd_nota);
	    	$('.nota_subcon').val(response.subcon_dt[0].ksd_nota);
	    	$('.sc_biaya_subcon').val(response.subcon_dt[0].ksd_harga);
	    	$('.sc_biaya_subcon_dt').val(response.subcon_dt[0].ksd_harga2);
	    	$('.id_subcon').val(response.subcon_dt[0].ksd_id);
	    	$('.sc_jumlah').val('1');
	    	$('.dt_subcon').val(response.subcon_dt[0].ksd_dt);
	    	$('.sc_tarif_subcon').val(response.subcon_dt[0].ksd_jenis_tarif);
	    	$('.sc_asal_subcon').val(response.subcon_dt[0].ksd_asal);
	    	$('.sc_tujuan_subcon').val(response.subcon_dt[0].ksd_tujuan);
	    	$('.sc_kendaraan_subcon').val(response.subcon_dt[0].ksd_angkutan);
	    	$('.table_filter_subcon').removeClass('disabled');




			$('.sc_no_asal_subcon').val(response.kontrak[0].no_asal);
	    	$('.sc_no_tujuan_subcon').val(response.kontrak[0].no_tujuan);
	    	$('.sc_no_kendaraan_subcon').val(response.kontrak[0].ksd_id_angkutan);
	    	hitung_jumlah();


	    
	    }
	})

	$('#modal_subcon').modal('hide');
}

function cancel_data() {
	$('.table_resi input').val('');
	$('.table_kontrak input').val('');
}

function hitung_subcon() {
	var temp = 0;
	$('.d_harga_subcon').each(function(){
		var total_subcon = $(this).val();
        ini = total_subcon.replace(/[^0-9\-]+/g,"");
        ini = parseFloat(ini);
		temp += ini;
	})

	$('.total_subcon').val(accounting.formatMoney(temp, "Rp ", 2, ".",','));
}


function cariSUB(){

	var m_seq = $('.m_seq').val();
	var nota_subcon = $('.nota_subcon').val();
	var m_do_subcon = $('.m_do_subcon').val();

	if (m_do_subcon == '') {
		toastr.warning('POD Harus Diisi !')
		return 1;
	}

	if (nota_subcon == '') {
		toastr.warning('Harap Memasukkan Kontrak Subcon !')
		return 1;
	}

	var sc_total_dt = $('.sc_total_dt').val();
	var sc_total = $('.sc_total').val();
	var sc_jumlah = $('.sc_jumlah').val();
	var sc_biaya_subcon = $('.sc_biaya_subcon').val();
	var sc_asal_subcon = $('.sc_asal_subcon').val();
	var sc_tujuan_subcon = $('.sc_tujuan_subcon').val();
	var sc_tarif_subcon = $('.sc_tarif_subcon').val();
	var sc__do_memo = $('.sc__do_memo').val();
	var m_seq = $('.m_seq').val();
	var sc_akun = $('.sc_akun').val();
	var id_subcon = $('.id_subcon').val();
	var index = array_do.indexOf(m_do_subcon);
	
	var m_do_asal = $('.m_do_asal').val();
	var m_do_tujuan = $('.m_do_tujuan').val();
	var m_tipe_kendaraan = $('.m_tipe_kendaraan').val();

	if (m_do_asal != sc_tujuan_subcon) {
	   	toastr.warning('Asal Do Tidak Sama Dengan Asal Kontrak');
	   	return false;
	}

	if (m_do_tujuan != m_do_tujuan) {
	   	toastr.warning('Tujuan Do Tidak Sama Dengan Tujuan Kontrak');
	   	return false;
	}

	if (m_tipe_kendaraan != m_tipe_kendaraan) {
	   	toastr.warning('Tipe Kendaraan Do Tidak Sama Dengan Tipe Kendaraan Kontrak');
	   	return false;
	}


	if (index == -1) {
	    subcon.row.add([
                  m_seq+'<input type="hidden" class="seq_sub sub_seq_'+m_do_subcon+'"  value="'+m_seq+'" >'+
                  '<input type="hidden" name="d_ksd_id[]" class="d_ksd_id"  value="'+id_subcon+'" >',

                  '<p class="d_resi_subcon_text">'+m_do_subcon+'</p>'+'<input type="hidden" class="d_resi_subcon"  name="d_resi_subcon[]" value="'+m_do_subcon+'" >',

                  '<p class="d_harga_subcon_text">'+sc_total+'</p>'+'<input type="hidden" name="d_harga_subcon[]" class="d_harga_subcon" value="'+sc_total_dt+'" >'+'<input type="hidden" name="d_jumlah_subcon[]" class="d_jumlah_subcon" value="'+sc_jumlah+'" >',

                  '<p class="d_asal_subcon_text">'+sc_asal_subcon+'</p>'+'<input type="hidden" name="d_asal_subcon[]" class="d_asal_subcon" value="'+sc_asal_subcon+'" >',

                  '<p class="d_tujuan_subcon_text">'+sc_tujuan_subcon+'</p>'+'<input type="hidden" name="d_tujuan_subcon[]" class="d_tujuan_subcon" value="'+sc_tujuan_subcon+'" >',

                  '<p class="d_jenis_tarif_subcon_text">'+sc_tarif_subcon+'</p>'+'<input type="hidden" name="d_jenis_tarif_subcon[]" class="d_jenis_tarif_subcon" value="'+sc_tarif_subcon+'" >',

                  '<p class="d_akun_text">'+sc_akun+'</p>'+'<input type="hidden" class="d_akun" name=d_akun[]" value="'+sc_akun+'">',

                  '<p class="d_memo_subcon_text">'+sc__do_memo+'</p>'+'<input type="hidden" class="d_memo_subcon" name=d_memo_subcon[]" value="'+sc__do_memo+'" >',
                  '<div class="btn-group">'+
                  '<a class="btn btn-sm btn-warning fa fa-pencil" align="center" onclick="edit_subcon(this)" title="edit"></i></a>'+
                  '<a class="btn btn-sm btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'+
                  '<div>'
            ]).draw( false );   
	    m_seq++;
 
	  	array_do.push(m_do_subcon);
	   	$('.table_resi input').val('');
	   	$('.table_kontrak input').val('');
	   	$('.m_seq').val(m_seq);
	   	$('.modal_tt_subcon').removeClass('disabled');
	   	$('.modal_tt_subcon').removeClass('disabled');
	   	$('.save_subcon').addClass('disabled');
	   	toastr.success('Append Berhasil, Silahkan Membuat Form Tanda Terima.');
	}else{
		var par = $('.sub_seq_'+m_do_subcon).parents('tr');
		$(par).find('.d_resi_subcon').val(m_do_subcon);
		$(par).find('.d_harga_subcon').val(sc_total_dt);
		$(par).find('.d_jumlah_subcon').val(sc_jumlah);
		$(par).find('.d_asal_subcon').val(sc_asal_subcon);
		$(par).find('.d_tujuan_subcon').val(sc_tujuan_subcon);
		$(par).find('.d_jenis_tarif_subcon').val(sc_tarif_subcon);
		$(par).find('.d_memo_subcon').val(sc__do_memo);
		$(par).find('.d_ksd_id').val(id_subcon);
		$(par).find('.d_akun').val(sc_akun);
		$(par).find('.d_akun_text').text(sc_akun);
		$(par).find('.d_resi_subcon_text').text(m_do_subcon);
		$(par).find('.d_harga_subcon_text').text(sc_total);
		$(par).find('.d_asal_subcon_text').text(sc_asal_subcon);
		$(par).find('.d_tujuan_subcon_text').text(sc_tujuan_subcon);
		$(par).find('.d_jenis_tarif_subcon_text').text(sc_tarif_subcon);
		$(par).find('.d_memo_subcon_text').text(sc__do_memo);
	   	toastr.success('Update Berhasil, Silahkan Membuat Form Tanda Terima.');
	   	$('.table_resi input').val('');
	   	$('.table_kontrak input').val('');
	   	$('.save_subcon').addClass('disabled');
	}
	$('.head1').addClass('disabled');
	$('.subcon_td').addClass('disabled');
	hitung_subcon();
}


function hapus_subcon(o){
    var ini = $(o).parents('tr');
    var cari = $(ini).find('.dt_resi_subcon').val();
    var temp1=0;
    var cariIndex = array_do.indexOf(cari);
    array_do.splice(cariIndex,1);
    
 
    subcon.row(ini).remove().draw(false);
    var temp = 0 ;
    $('.seq_sub').each(function(){
    	temp+=1;
    })
    if (temp == 0) {
    	$('.head1').removeClass('disabled');
		$('.subcon_td').removeClass('disabled');
    }
    $('.head1').addClass('disabled');
	$('.subcon_td').addClass('disabled');
    hitung_subcon();
}

function edit_subcon(a) {
	console.log('asd');
    var par = $(a).parents('tr');
	var d_resi_subcon = $(par).find('.d_resi_subcon').val();
	var d_ksd_id = $(par).find('.d_ksd_id').val();
	var d_memo_subcon = $(par).find('.d_memo_subcon').val();
	var d_akun = $(par).find('.d_akun').val();
	var d_jumlah_subcon = $(par).find('.d_jumlah_subcon').val();
	var d_harga_subcon_text = $(par).find('.d_harga_subcon_text').text();
	var d_harga_subcon = $(par).find('.d_harga_subcon').val();
	$.ajax({
		url : baseUrl +'/fakturpembelian/pilih_kontrak_all',
	    data: {d_resi_subcon,d_ksd_id},
	    type:'get',
	    dataType:'json',
	    success:function(response){
	    	console.log(response.kontrak[0].ksd_nota);
	    	$('.nota_subcon').val(response.kontrak[0].ksd_nota);
	    	$('.sc_biaya_subcon').val(response.kontrak[0].ksd_harga);
	    	$('.sc_biaya_subcon_dt').val(response.kontrak[0].ksd_harga2);
	    	$('.sc_total').val(d_harga_subcon_text);
	    	$('.sc_total_dt').val(d_harga_subcon);
	    	$('.id_subcon').val(response.kontrak[0].ksd_id);
	    	$('.dt_subcon').val(response.kontrak[0].ksd_dt);
	    	$('.sc_tarif_subcon').val(response.kontrak[0].ksd_jenis_tarif);
	    	$('.sc_asal_subcon').val(response.kontrak[0].ksd_asal);
	    	$('.sc_tujuan_subcon').val(response.kontrak[0].ksd_tujuan);
	    	$('.sc_kendaraan_subcon').val(response.kontrak[0].ksd_angkutan);
	    	$('.sc_jumlah').val(d_jumlah_subcon);
	    	$('.table_filter_subcon').removeClass('disabled');
	    	$('.sc__do_memo').val(d_memo_subcon);	
	    	$('.sc_akun').val(d_akun).trigger('chosen:updated');	
	    	$('.m_do_subcon').val(response.do.nomor);
			$('.m_do_tanggal').val(response.do.tanggal);
			$('.m_satuan').text(response.do.kode_satuan);
			$('.m_do_asal').val(response.do.nama_asal);
			$('.m_do_tujuan').val(response.do.nama_tujuan);
			$('.m_jenis_angkutan_do').val(response.do.nama_tarif);
			$('.m_tipe_kendaraan').val(response.do.nama_angkutan);
			$('.m_do_jumlah').val(response.do.jumlah);

			$('.no_do_asal').val(response.do.id_kota_asal);
			$('.no_do_tujuan').val(response.do.id_kota_tujuan);
			$('.no_tipe_kendaraan').val(response.do.kode_tipe_angkutan);

			$('.sc_no_asal_subcon').val(response.kontrak[0].no_asal);
	    	$('.sc_no_tujuan_subcon').val(response.kontrak[0].no_tujuan);
	    	$('.sc_no_kendaraan_subcon').val(response.kontrak[0].ksd_id_angkutan);
			toastr.info('Inisialisasi Berhasil');
	    }
	})
}

$('.modal_tt_subcon').click(function(){
	var nota_subcon = $('.nota_subcon').val();
	if (nota_subcon != '') {
		toastr.warning('Terdapat Data Yang Belum Di Append');
		return 1
	}
	var cabang = $('.cabang').val();
	var nota_id_tt = $('.nota_id_tt').val();
	if (nota_id_tt == '') {
	    $.ajax({
	      url:baseUrl +'/fakturpembelian/nota_tt',
	      data: {cabang},
	      dataType:'json',
	      success:function(data){
	        var total_subcon = $('.total_subcon').val();
			var tempo_subcon = $('.tempo_subcon').val();
			var nama_sc  	 = $('.nama_sc').val();
	        total_subcon       = total_subcon.replace(/[^0-9\-]+/g,"")/100;
	        $('.notandaterima').val(data.nota);
	        $('.supplier_tt').val(nama_sc);
	        $('.jatuhtempo_tt').val(tempo_subcon);
	        $('.tgl_tt').val('{{carbon\carbon::now()->format('d/m/Y')}}');
	        $('.totalterima_tt_subcon').val(accounting.formatMoney(total_subcon, "Rp ", 2, ".",','));
			$('#modal_tt_subcon').modal('show');
	      },error:function(){
	        toastr.warning('Terjadi Kesalahan');
	      }
	    })
	}else{
		var total_subcon = $('.total_subcon').val();
		var nota_no_tt = $('.nota_no_tt').val();
		var tempo_subcon = $('.tempo_subcon').val();
		var nama_sc  	 = $('.nama_sc').val();
		var nama_sc  	 = $('.nama_sc').val();
        total_subcon       = total_subcon.replace(/[^0-9\-]+/g,"")/100;
        $('.notandaterima').val(nota_no_tt);
        $('.supplier_tt').val(nama_sc);
        $('.jatuhtempo_tt').val(tempo_subcon);
        $('.tgl_tt').val('{{carbon\carbon::now()->format('d/m/Y')}}');
        $('.totalterima_tt_subcon').val(accounting.formatMoney(total_subcon, "Rp ", 2, ".",','));
		$('#modal_tt_subcon').modal('show');
	}
	
})




function save_subcon(){
	var id_subcon = $('.id_subcon').val();
	var dt_subcon = $('.dt_subcon').val();
	var invoice_subcon = $('.invoice_subcon').val();
	var tempo_subcon = $('.tempo_subcon').val();
	var nota_subcon =$('.nota_subcon').val();
	var jenis_kendaraan = $('.kode_angkutan').val();
	var tarif_subcon = $('.tarif_subcon').val();

	swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Subcon!",
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
     	url:baseUrl + '/fakturpembelian/subcon_save',
		data:subcon.$('input').serialize()
			 +'&'+$('.head1 :input').serialize()
			 +'&'+$('.head_subcon :input').serialize(),
		type:'GET',
      success:function(response){


      	if (response.status == 1) {

	        swal({
	        title: "Berhasil!",
	                type: 'success',
	                text: "Data berhasil disimpan",
	                timer: 900,
	               showConfirmButton: true
	                },function(){
                
    			  	  $('.idfaktur').val(response.id);
    			  	  $('.print_subcon').removeClass('disabled');
	                  $('.save_subcon').addClass('disabled');
		        	  $('.modal_tt_subcon').addClass('disabled');
		        	  $('.append_subcon').addClass('disabled');
	        });
    	}else{
    		swal({
       		title: "No FP dirubah Menjadi "+response.nota,
                type: 'error',
                timer: 900,
               showConfirmButton: true

    		},function(){
    			  $('.idfaktur').val(response.id);
	    		  $('.save_subcon').addClass('disabled');
	        	  $('.modal_tt_subcon').addClass('disabled');
	        	  $('.append_subcon').addClass('disabled');
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


function simpan_tt() {
	var selectOutlet = $('.nama_sc').val();
	var cabang = $('.cabang').val();
	var totalterima_tt_subcon = $('.totalterima_tt_subcon').val();
 	if (totalterima_tt_subcon == 'Rp 0,00') {
 		toastr.warning('Nilai Tanda Terima Tidak Boleh Nol');
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
          url:baseUrl + '/fakturpembelian/simpan_tt',
          type:'get',
          dataType:'json',
          data:$('.tabel_tt_subcon :input').serialize()+'&'+'agen='+selectOutlet+'&'+$('.head1 .nofaktur').serialize()+'&cabang='+cabang,
          success:function(response){
                swal({
                    title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                    showConfirmButton: true
                    },function(){
                      $('.nota_id_tt').val(response.id);
                      $('.nota_no_tt').val(response.no);
                	  $('.save_subcon').removeClass('disabled');
                    });

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
     window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
  }
</script>
