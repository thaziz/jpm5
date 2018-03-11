
<div class="col-sm-5 header_biaya"  >
	{{ csrf_field() }}
<form>
<table class="table	head_subcon">
	<h3 style="text-align: center;">Form Subcon</h3>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tempo_subcon" class="form-control tempo_subcon" value="{{$date}}" style="width: 250px;">
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" style="width: 250px;"></td>
 </tr>	
  <tr class="hd1 " >
 	<td style="width: 100px">Asal</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select style="position:relative; z-index:100" onchange="cari_subcon()" name="asal_subcon" class="form-control asal_subcon chosen-select-width1" style="text-align: center; width: 250px;">
 			<option selected="" disabled="" value="0" >- Pilih Asal -</option>
 			@foreach($kota as $val)
 			<option value="{{$val->id}}">{{$val->nama}}</option>
 			@endforeach
 		</select>
 	</td>
 </tr>
 <tr class="hd2 ">
 	<td style="width: 100px">Tujuan</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select onchange="cari_subcon()" name="tujuan_subcon" class="form-control tujuan_subcon chosen-select-width1" style="text-align: center; width: 250px;">
 			<option selected="" disabled="" value="0" >- Pilih Tujuan -</option>
 			@foreach($kota as $val)
 			<option value="{{$val->id}}">{{$val->nama}}</option>
 			@endforeach
 		</select>
 	</td>
 </tr>
 <tr class=" hd2 disabled tr_disabled" >
 	<td style="width: 100px">Nama Subcon</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select class="nama_sc form-control chosen-select-width1" name="nama_subcon">
 			
 		</select>
 	</td>
 </tr>

 <tr>
 	<td style="width: 100px">No Invoice </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="invoice_subcon" class="form-control invoice_subcon"  style="width: 250px;"></td>
 </tr>	
 <tr>
 	<td style="width: 100px">Keterangan </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="keterangan_subcon" class="form-control keterangan_subcon"  style="width: 250px;"></td>
 </tr>	
 <tr class="hd2 disabled tr_disabled">
 	<td colspan="3">
 		<button type="button" class="btn btn-primary pull-right btn_cari">Cari Kontrak</button>
 	</td>
 </tr>
 <tr>
 	<td colspan="3">
 		
 	</td>
 </tr>
  
</table>
</form>
</div>


<div class="col-sm-5 table_filter_subcon disabled"   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">	
		<h3 >Detail Biaya Penerus Hutang</h3>
	 </div>	
	  <tr>
		<td style="width: 100px">Nomor</td>
		<td width="10">:</td>
		<td width="200"><input type="text" name="no_kontrak_subcon" class="form-control nota_subcon" style="width: 250px;" readonly=""></td>
		<td width="200"><input type="hidden" name="id_subcon" class="form-control id_subcon" style="width: 250px;" readonly=""></td>
		<td width="200"><input type="hidden" name="dt_subcon" class="form-control dt_subcon" style="width: 250px;" readonly=""></td>
	  </tr>
	  <tr>
		<td style="width: 100px">Biaya Subcon</td>
		<td width="10">:</td>
		<td width="200"><input type="text" class="form-control biaya_subcon"  readonly="" value="" style="width: 250px;">
			<input type="hidden" class="form-control biaya_subcon_dt" style="width: 250px;">
		</td>
	  </tr>
	  <tr>
		<td style="width: 100px">Jenis Tarif</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" name="tarif_subcon" class="form-control tarif_subcon" readonly=""  style="width: 250px;">
			<input type="hidden" name="kode_tarif_subcon" class="form-control tarif_subcon" style="width: 250px;">
		</td>
	  </tr>
	  <tr>
		<td style="width: 100px">Kendaraaan</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" class="form-control kendaraan_subcon" readonly=""  style="width: 250px;">
			<input type="hidden" class="form-control kode_angkutan" style="width: 250px;">
		</td>
	  </tr>
<!-- 	  <tr>
		<td colspan="3">
			<div style="display: inline-block; width: 49%;">
				<label>Asal</label>
				<input type="text" readonly="" class="asal_table_subcon form-control"  >
			</div>
			<div style="display: inline-block; width: 50%;">
				<label>Tujuan</label>
				<input type="text" readonly="" class="tujuan_table_subcon form-control"  >
			</div>
		</td>
	  </tr> -->
	  <tr>
		<td style="width: 100px">Nomor Seq</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" class="form-control seq_subcon" readonly="" style="width: 250px;">
			<input type="hidden" class="form-control status_seq" style="width: 250px;">
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Nomor POD</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" class="form-control pod_subcon" onkeyup="cariDATASUBCON(this.value)" style="width: 250px;">
			<input type="hidden" class="form-control status_pod_subcon" style="width: 250px;">
		</td>
	  </tr>
	  <tr>
		<td style="width: 100px">Tarif POD</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" class="tarif_pod_subcon form-control" readonly="" style="width: 250px;">
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Berat (KG)</td>
		<td width="10">:</td>
		<td class="form-inline">
			<div class="input-group" style="width: 100%">
                <input  style="width: 100%" class="form-control berat_subcon" type="text" value="" >
                <span class="input-group-addon" style="padding-bottom: 12px;">KG</span>
             </div>
 		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Memo</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text"  class="form-control memo_subcon" style="width: 250px;"></td>
	 </tr>
     </table>
     <button type="button" class="btn btn-primary pull-right" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Append</i></button>
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
				<th>Berat (KG)</th>
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
<script type="text/javascript">
var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"250px"}
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
if (id == '0') {
	toastr.warning('data tidak ada')
	return 1;
}

$.ajax({
	url:baseUrl +'/master_subcon/cari_kontrak/'+id,
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
	var dt = $(asd).find('.dt_kontrak').val();

	$.ajax({
		url : baseUrl +'/fakturpembelian/pilih_kontrak',
	    data: 'id='+id+'&'+'dt='+dt,
	    type:'get',
	    success:function(response){

	    	$('.table_filter_subcon').removeClass('disabled');
			$('.nota_subcon').val(response.subcon_dt[0].ks_nota);
		   	var temp3 = accounting.formatMoney(response.subcon_dt[0].ksd_harga, "Rp ", 2, ".",',');
			$('.biaya_subcon').val(temp3);
			$('.id_subcon').val(response.subcon_dt[0].ksd_ks_id);
			$('.dt_subcon').val(response.subcon_dt[0].ksd_ks_dt)
			$('.kendaraan_subcon').val(response.subcon_dt[0].angkutan)
			$('.kode_angkutan').val(response.subcon_dt[0].kode_angkutan)
			$('.tarif_subcon').val(response.subcon_dt[0].ksd_jenis_tarif)
			$('.asal_table_subcon').val(response.subcon_dt[0].asal);
			$('.tujuan_table_subcon').val(response.subcon_dt[0].tujuan);
			$('.biaya_subcon_dt').val(response.subcon_dt[0].ksd_harga);

			





	    }
	})

	$('#modal_subcon').modal('hide');
}
var sequence=[];
function cariDATASUBCON(asd){
    // console.log(asd);
    $('.pod_subcon').autocomplete({
      source:baseUrl + '/fakturpembelian/caripodsubcon', 
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
          	$('.seq_subcon').val(sequence.length+1);
        	$('.tarif_pod_subcon').val(ui.item.harga);
          }
        
    	}catch(err){

    	}
    }

    });
}


function cariSUB(){

    var valPo 	   	 = $('.status_pod_subcon').val();
    var seq   	  	 = $('.seq_subcon').val();
    var bayar 	   	 = $('.tarif_pod_subcon ').val();
    var ket   	   	 = $('.memo_subcon').val();
    // var harga_resi 	 = $('.total_pod').val();
    var berat_subcon = $('.berat_subcon').val();

  	var index = sequence.indexOf(valPo);
  	console.log(berat_subcon)
  	if (valPo != '') {
	     if(index == -1){
	      subcon.row.add( [
                  seq+'<input type="hidden" class="seq_sub sub_seq_'+seq+'"  value="seq" >',
                  valPo+'<input type="hidden" class="dt_resi_subcon"  name="resi_subcon[]" value="'+valPo+'" >',
                  Math.round(bayar).toFixed(2),
                  berat_subcon+'<input type="hidden" name="kg[]" class="berat_tabel" value="'+berat_subcon+'" >',
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

	swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Subcon!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
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
</script>
