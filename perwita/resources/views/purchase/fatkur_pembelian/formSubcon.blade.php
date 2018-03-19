
<div class="col-sm-12 header_biaya"  >
	{{ csrf_field() }}
<form>
<div class="col-sm-6">
<table class="table	head_subcon">
	<h3 style="text-align: center;">Form Subcon</h3>
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
 	<td style="width: 100px">Persentase</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select class="form-control chosen-select-width1" name="persen_subcon">
 				<option value="0">- Cari - Subcon -</option>
 			@foreach($akun as $sub)
 				@if($sub->kode_akun == '5210' && $sub->cabang != 'GLOBAL')
 				<option selected="" value="{{$sub->kode}}">{{$sub->kode_akun}} - {{$sub->nama}}</option>
 				@elseif($sub->kode_akun == '5210')
 				<option selected="" value="{{$sub->kode}}">{{$sub->kode_akun}} - {{$sub->nama}}</option>
 				@else
 				<option value="{{$sub->kode}}"> {{$sub->kode_akun}} - {{$sub->nama}}</option>
 				@endif
 			@endforeach
 		</select>
 	</td>
  </tr>
  <tr class=" hd2" >
 	<td style="width: 100px">Nama Subcon</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select class="nama_sc form-control chosen-select-width1" name="nama_subcon">
 				<option value="0">- Cari - Subcon -</option>
 			@foreach($subcon as $sub)
 				<option value="{{$sub->kode}}">{{$sub->nama}}</option>
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
</table>
</div>
<div class="col-sm-12 detail_subcon disabled"  >
	<div class="col-sm-5 table_filter_subcon"   >
    <form class="form">
	  <table class="table">
	  	<div align="center" style="width: 100%;">	
			<h3 >Form Resi Subcon</h3>
		</div>	
	  <tr>
		<td style="width: 100px">Nomor Seq</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" class="form-control seq_subcon" readonly="" >
			<input type="hidden" class="form-control status_seq" style="width: 250px;">
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Nomor POD</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" readonly="" class="form-control pod_subcon" onkeyup="cariDATASUBCON(this.value)" >
			<input type="hidden" class="form-control status_pod_subcon" style="width: 250px;">
		</td>
	  </tr>
	  <tr>
		<td style="width: 100px">Tarif POD</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" class="tarif_pod_subcon form-control" readonly="" >
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px" class="label_satuan">Berat (KG)</td>
		<td width="10">:</td>
		<td class="form-inline form_satuan">
			<div class="input-group" style="width: 100%">
                <input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >
                <span class="input-group-addon" style="padding-bottom: 12px;">KG</span>
             </div>
 		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Total Biaya</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text" readonly=""  class="form-control total_subcon" ></td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Memo</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text"  class="form-control memo_subcon" >
			<input type="hidden"  class="form-control comp_subcon" >
		</td>
	 </tr>
	 <tr>
	 	<td colspan="3">
	 		<button class="btn btn-info modal_tt_subcon pull-left" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
		    <button type="button" class="btn btn-primary pull-right disabled" onclick="cariSUB()"><i class="fa fa-plus">&nbsp;Append</i></button>
		    <button type="button" class="btn btn-primary pull-right" style="margin-right: 20px" onclick="cariDOSUBCON()"><i class="fa fa-search">&nbsp;Cari DO</i></button>
	 	</td>
	 </tr>
     </table>
     
    </form>
</div>

	<div class="col-sm-5" style="margin-left: 100px;">
	<table class="table" >
	     <div align="center" style="width: 100%;" >	
			<h3 >Detail Kontrak Subcon</h3>
		 </div>	
		  <tr>
			<td style="width: 100px">Nomor</td>
			<td width="10">:</td>
			<td>
				<input type="text" name="no_kontrak_subcon" class="form-control nota_subcon"  readonly="">
				<input type="hidden" name="id_subcon" class="form-control id_subcon"  readonly="">
				<input type="hidden" name="dt_subcon" class="form-control dt_subcon"  readonly="">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Biaya Subcon</td>
			<td width="10">:</td>
			<td width="200">
				<input type="text" class="form-control biaya_subcon"  readonly="" value="" >
				<input type="hidden" class="form-control biaya_subcon_dt" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Jenis Tarif</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" name="tarif_subcon" class="form-control tarif_subcon" readonly=""  >
				<input type="hidden" name="kode_tarif_subcon" class="form-control tarif_subcon" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Asal Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly="" class="form-control asal_subcon" >
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Tujuan Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly=""  class="form-control tujuan_subcon">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Kendaraaan</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" class="form-control kendaraan_subcon" readonly=""  >
				<input type="hidden" class="form-control kode_angkutan" style="width: 250px;">
			</td>
		  </tr>
		  <tr class="hd2 tr_disabled">
		 	<td colspan="3">
		 		<button type="button" onclick="nama_sc()" class="btn btn-primary pull-right">Cari Kontrak</button>
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

 <div class=" col-sm-12 tb_sb_hidden" hidden="">
 	<h3>Tabel Detail Resi</h3>
 	<hr>
	    <table class="table table-bordered table-hover tabel_subcon">
			<thead align="center">
				<tr>
				<th>No</th>
				<th width="90">Nomor Resi</th>
				<th>Harga Resi</th>
				<th>Tarif Subcon</th>
				<th>Multiply</th>
				<th>Keterangan</th>
				<th width="50">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	    <button type="button" class="btn btn-primary pull-right" id="save-update" onclick="save_subcon()" data-dismiss="modal">Simpan Data</button>
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
                <input type="text" class="form-control lain_subcon" name="lainlain">
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
        <button type="button" class="btn btn-primary simpan_subcon" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- modal DO-->
                <div id="modal_do" class="modal" >
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

$('.tempo_subcon').datepicker();

function cari_subcon(){
	var asal 	= $('.asal_subcon').val();
	var tujuan  = $('.tujuan_subcon').val();
	console.log(asal);
	if(asal != null && tujuan != null){
		$.ajax({
			url : baseUrl +'/fakturpembelian/cari_subcon',
			data: 'asal='+asal+'&'+'tujuan='+tujuan,
			type:'get',
			success:function(response){
				if(response.status == 1){
					$('.nama_sc').html('');
					$('.nama_sc').html('<option value="">- Pilih Subcon -</option>');
					
					for(var i = 0; i<response.data.length;i++){
						var html = '<option value="'+response.data[i].ks_nama+'">'+response.data[i].nama+'</option>';

						$('.nama_sc').append(html);
						$('.nama_sc').trigger("chosen:updated");
						$('.tr_disabled').removeClass('disabled');
					}
				}else{
					console.log('asd');
					$('.nama_sc').html('');

					var html = '<option value="0">Data tidak Ditemukan</option>';

						$('.nama_sc').html(html);
						$('.nama_sc').trigger("chosen:updated");

						$('.tr_disabled').removeClass('disabled');

						

				}
			}
		});
	}
}

function radio(){
	var rad = $('.rad:checked').val();
	if (rad == 1) {
		$('.hd1').attr('hidden',false);
		$('.hd2').attr('hidden',false);
		$('.hd3').attr('hidden',true);
		$('.table_filter_subcon').attr('hidden',false);
		$('.table_filter_resi').attr('hidden',true);


		$('.hd').addClass('animated')
		$('.hd').addClass('fadeInRight')

	}else{
		$('.hd1').attr('hidden',true);
		$('.hd2').attr('hidden',true);
		$('.hd3').attr('hidden',false);
		$('.table_filter_subcon').attr('hidden',true);
		$('.table_filter_resi').attr('hidden',false);

	}
}
$('.btn_cari').click(function(){

// $('.detail_biaya ').removeClass('disabled');
var id = $('.nama_sc').val();
var asal = $('.asal_subcon').val();
var tujuan = $('.tujuan_subcon').val();
if (id == '0') {
	toastr.warning('data tidak ada')
	return 1;
}

$.ajax({
	url:baseUrl +'/master_subcon/cari_kontrak',
	data:'id='+id+'&'+'asal='+asal+'&'+'tujuan='+tujuan,
	success:function(response){
		$('.subcon_modal').html(response);
		$('#modal_subcon').modal('show');
	},
	error:function(){
		toastr.warning('Data tidak ditemukan');
	}
});

});

function pilih_kontrak(asd){
	var id = $(asd).find('.id_kontrak').val();
	// var dt = $(asd).find('.dt_kontrak').val();

	$.ajax({
		url : baseUrl +'/fakturpembelian/pilih_kontrak',
	    data: 'id='+id,
	    type:'get',
	    success:function(response){
	    	console.log(response.subcon_dt[0].ksd_nota);
	    	$('.nota_subcon').val(response.subcon_dt[0].ksd_nota);
	    	$('.biaya_subcon').val(response.subcon_dt[0].ksd_harga);
	    	$('.biaya_subcon_dt').val(response.subcon_dt[0].ksd_harga2);
	    	$('.id_subcon').val(response.subcon_dt[0].ksd_id);
	    	$('.dt_subcon').val(response.subcon_dt[0].ksd_dt);
	    	$('.tarif_subcon').val(response.subcon_dt[0].ksd_jenis_tarif);
	    	$('.asal_subcon').val(response.subcon_dt[0].ksd_asal);
	    	$('.tujuan_subcon').val(response.subcon_dt[0].ksd_tujuan);
	    	$('.kendaraan_subcon').val(response.subcon_dt[0].ksd_angkutan);
	    	$('.table_filter_subcon').removeClass('disabled');

	    	if (response.subcon_dt[0].ksd_jenis_tarif == 'KILOGRAM') {
	    		var label = 'Berat (KG)';
	    		var html  = '<div class="input-group" style="width: 100%">'
                		 +'<input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >'
                	     +'<span class="input-group-addon" style="padding-bottom: 12px;">KG</span>'
             			 +'</div>';
             	$('.label_satuan').html(label);
             	$('.form_satuan').html(html);

             	$('.berat_subcon').keyup(function(){
					var data = $(this).val();
					var total_subcon = $('.biaya_subcon_dt').val();
					total_subcon = Math.round(total_subcon).toFixed(0);
					$('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

				});
	    	}else{
	    		var label = 'Trip';
	    		var html  = '<div class="input-group" style="width: 100%">'
                		 +'<input  style="width: 100%" class="form-control trip_subcon" type="number" value="" >'
                	     +'<span class="input-group-addon" style="padding-bottom: 12px;">Trip</span>'
             			 +'</div>';
             	$('.label_satuan').html(label);
             	$('.form_satuan').html(html);

             	$('.trip_subcon').keyup(function(){
					var data = $(this).val();
					var total_subcon = $('.biaya_subcon_dt').val();
					total_subcon = Math.round(total_subcon).toFixed(0);
					$('.total_subcon').val(accounting.formatMoney(data * total_subcon,'', 2, ".",','));

				});
	    	}
	    }
	})

	$('#modal_subcon').modal('hide');
}
var sequence=[];
function cariDATASUBCON(asd){
	var asal_subcon   = $('.asal_subcon').val();
	var tujuan_subcon = $('.tujuan_subcon').val();
    // console.log(asd);
    $('.pod_subcon').autocomplete({
      source:function (request, response) {
    		$.ajax({
  			type: "get",
  			url:baseUrl+'/fakturpembelian/caripodsubcon',
  			data: {asal_subcon,tujuan_subcon},
  			dataType: 'json'
			});
  	  },
      minLength: 3,
       change: function(event, ui) {
       	try{
       	console.log(ui.item.validator);
       	if(ui.item.validator != null){
            toastr.warning('Data sudah didaftarkan');
            $(this).val("");
            $('.tarif_pod_subcon').val("0");
            $('.status_pod_subcon').val("");
            
          }else{
          	$('.status_pod_subcon').val(ui.item.id);
          	$('.status_pod_subcon').val(ui.item.id);
          	$('.seq_subcon').val(sequence.length+1);
          	$('.comp_subcon').val(ui.item.comp);
          	var asd = accounting.formatMoney(ui.item.harga,'', 2, ".",',');
        	$('.tarif_pod_subcon').val(asd);
          }
        
    	}catch(err){

    	}
    }

    });
}





function cariSUB(){

    var valPo 	   	 = $('.status_pod_subcon').val();
    var tarif_subcon = $('.tarif_subcon').val();
    tarif_subcon
    var seq   	  	 = $('.seq_subcon').val();
    var bayar 	   	 = $('.tarif_pod_subcon ').val();
    bayar 			 = bayar.replace(/[^0-9\-]+/g,"");
    bayar            = bayar/100;
    var ket   	   	 = $('.memo_subcon').val();
    var comp   	   	 = $('.comp_subcon').val();
    var tot_sub   	 = $('.total_subcon').val();
    tot_sub 		 = tot_sub.replace(/[^0-9\-]+/g,"");
    tot_sub          = tot_sub/100;
    // var harga_resi 	 = $('.total_pod').val();
    var berat_subcon = $('.berat_subcon').val();
    var trip_subcon  = $('.trip_subcon').val();

  	var index = sequence.indexOf(valPo);
  	console.log(berat_subcon)
  	if (valPo != '') {
	     if(index == -1){

	      if (tarif_subcon == 'KILOGRAM') {
	      	var html = berat_subcon+'<input type="hidden" name="kg[]" class="berat_tabel" value="'+berat_subcon+'" >';
	      }else{
	      	var html = trip_subcon+'<input type="hidden" name="trip[]" class="berat_tabel" value="'+trip_subcon+'" >';
	      }

	      subcon.row.add( [
                  seq+'<input type="hidden" class="seq_sub sub_seq_'+seq+'"  value="'+seq+'" >'
                  +'<input type="hidden" name="comp_subcon[]" value="'+comp+'" >',
                  valPo+'<input type="hidden" class="dt_resi_subcon"  name="resi_subcon[]" value="'+valPo+'" >',
                  Math.round(bayar).toFixed(2)+'<input type="hidden" class="harga_resi"  name="harga_resi[]" value="'+bayar+'" >',
                  Math.round(tot_sub).toFixed(2)+'<input type="hidden" name="harga_tarif[]" class="harga_tarif" value="'+tot_sub+'" >',
                  html,
                  ket+'<input type="hidden" name=ket_subcon[]" value="'+ket+'" >',
                  '<a class="btn btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'
              ] ).draw( false );   
	// class="seq_sub sub_seq_'+seq+'"
	      sequence.push(valPo); 
	     
	     $('.tb_sb_hidden').attr('hidden',false);
	   	 $('.status_pod_subcon').val('');
	   	 $('.berat_subcon').val('');
	   	 $('.memo_subcon').val('');


	    }else{
	    	toastr.warning('Data Sudah Ada');
	    }
	}else{
	    toastr.warning('Data Tidak Ada');

	}
	   	 $('.pod_subcon ').focus();
	   	 $('.pod_subcon ').val('');
	   	 $('.tarif_pod_subcon ').val('');
	   	 $('.total_subcon ').val('');
	   	 $('.trip_subcon ').val('');
	   	 $('.berat_subcon ').val('');

	
}
// var cariSUb = [];
// function hapus_subcon(p){
// var par = p.parentNode.parentNode;

//     var resi = $(par).find('.dt_resi_subcon').val();
//     var kg = $(par).find('.bayar_biaya').val();
//     var debet = $(par).find('.debet_biaya').val();
//     var ket = $(par).find('.ket_biaya').val();
//     cariSeq[0] = 'sub_seq_'+$(par).find('.seq_sub').val();

//     $('#subcon_modal').modal('show');
//     $(".kode_akun_update").val(kode);
//     $(".nama_akun_update").val(kode).trigger("chosen:updated");
//     $(".debit_update").val(debet);
//     $(".ket_biaya_update").val(ket);
//     $(".nominal_update").val(bayar);
// }

function hapus_subcon(o){
    var ini = o.parentNode.parentNode;
    var cari = $(ini).find('.dt_resi_subcon').val();
    var temp1=0;
    var cariIndex = sequence.indexOf(cari);
    sequence.splice(cariIndex,1);
    
 
    subcon.row(ini).remove().draw(false);
   }

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
		data:'id='+id_subcon
				+'&'+'dt='+dt_subcon
				+'&'+'ts='+tarif_subcon
				+'&'+'angkutan='+jenis_kendaraan
				+'&'+'tempo='+tempo_subcon
				+'&'+'nota='+nota_subcon
				+'&'+'invoice='+invoice_subcon
				+'&'+subcon.$('input').serialize()
				+'&'+$('.head1 .nofaktur').serialize()
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
	                   location.reload();
	        });
    	}else{
    		swal({
       		title: "Harap isi form dengan benar",
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
}

 $('.memo_subcon').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        cariSUB();
        return false;
     }
 });

$('.nama_sc').change(function(){
	if ($(this).val() != 0) {
		$('.detail_subcon').removeClass('disabled');
	}else{
		$('.detail_subcon').addClass('disabled');
	}
});



 function cari_kontrak(){
 	var kontrak_id = $('.kontrak_id').val();

 	$.ajax({
 		url:baseUrl + '/fakturpembelian/cari_kontrak_subcon1/' + kontrak_id,
 		success:function(data){
 		}
 	})

 }

 function cariDOSUBCON() {
 	var sc =  $('.nama_sc').val();
 	var cabang = $('.cabang').val();
 	$.ajax({
 		url:baseUrl + '/fakturpembelian/cari_do_subcon',
 		data:{sc,cabang},
 		dataType:'json',
 		success:function(response){
 			$('.tabel_subcon_detail').html(response);
 			$('#modal_do').modal('show');
 		}
 	})

 }

 $('.modal_tt_subcon')
</script>
