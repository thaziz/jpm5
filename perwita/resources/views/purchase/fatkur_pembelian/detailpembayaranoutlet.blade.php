<style type="text/css">
	.dataTables_length{
		display: none;
	}

</style>
 <link href="{{asset('assets/vendors/datatables/datatables.min.css')}}" rel="stylesheet">

    <link href="{{ asset('assets/vendors/bootstrapTour/bootstrap-tour.min.css') }}" rel="stylesheet">
<div class="col-sm-12 msh_hdn">
<h3>Tabel Detail Resi</h3>
 	<hr>
 		<div class="col-sm-5">

	 	<table class="table table-stripped header_total_outlet1">
	{{ csrf_field() }}
	 		
	 		<tr>
	 			<td>Total Tarif</td>
	 			<td>:</td>
	 			<td><input style="width: 150px;" readonly="" type="text" name="total_tarif" class="form-control total_tarif form-inline"></td>
	 		</tr>
	 		<tr>
	 			<td>Total Komisi Outlet</td>
	 			<td>:</td>
	 			<td><input style="width: 150px;" readonly="" type="text" name="total_komisi_outlet" class="form-control total_komisi_outlet form-inline"></td>
	 		</tr>
	 	</table>
	 	</div>
	 	<div class="col-sm-5" style="margin-left: 10%">
	 	<table class="table table-stripped header_total_outlet2">
	 		<tr>
	 			<td>Total Komisi Tambahan</td>
	 			<td>:</td>
	 			<td><input style="width: 150px;" readonly="" type="text" name="total_komisi_tambahan" class="form-control total_komisi_tambahan form-inline"></td>
	 		</tr>
	 		<tr>
	 			<td>Total Jumlah Komisi</td>
	 			<td>:</td>
	 			<td><input style="width: 150px;" readonly="" type="text" name="total_all_komisi" class="form-control total_all_komisi form-inline"></td>
	 		</tr>
	 	</table>
	 	</div>
	    <table class="table table-bordered table-hover table_outlet" style="font-size: 12px; ">
	    <button onclick="tt_penerus_outlet()" class="btn btn-info modal_outlet_tt" style="margin-right: 10px;" type="button" data-toggle="modal"  type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
        <button class="btn btn-primary btn_modal_ot disabled" type="button" > Bayar dengan Uang Muka </button>
	    <button type="button" class="btn btn-primary pull-right save save_update_outlet" id="save_update_outlet" onclick="save_outlet()" data-dismiss="modal">Simpan Data</button>
	    	
	    <div class="loading text-center" style="display: none;">
          <img src="{{ asset('assets/img/loading1.gif') }}" width="100px">
        </div>
			<thead align="center">
				<tr>
				<th><input type="checkbox" class="form-control parent_check" onchange="check_parent()"></th>
				<th>
					No.Order
				</th>
				<th>
					Tanggal
				</th>
				<th>
					Kota Asal
				</th>
				<th>
					Kota Tujuan
				</th>
				<th>
					Status
				</th>
				<th>
					Tarif
				</th>
				<th>
					Komisi Outlet
				</th>
				<th>
					Komisi Tambahan
				</th>
				<th>
					Jumlah Komisi
				</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-outlet">
				@foreach($data as $index => $val)
				@if($data[$index]['potd_pod'] == null)
				<tr>
					<td><input type="checkbox" name="chck[]" onchange="hitung_outlet(this)" class="form-control child_check" ></td>
					<td >
						{{$data[$index]['nomor']}}
						<input type="hidden" name="no_resi[]" class="form-control" value="{{$data[$index]['nomor']}}">
					</td>
					<td>
					<?php echo date('d/m/Y',strtotime($data[$index]['tanggal'])); ?>
						<input type="hidden" name="tgl[]" class="form-control" value="{{$data[$index]['tanggal']}}">
					</td>
					<td>
						{{$data[$index]['asal']}}
						<!-- <input type="hidden" name="kota_asal[]" class="form-control" value="{{$data[$index]['id_asal']}}"> -->
					</td>
					<td>
						{{$data[$index]['tujuan']}}
						<!-- <input type="hidden" name="kota_tujuan[]" class="form-control" value="{{$data[$index]['id_tujuan']}}"> -->
					</td>
					<td>
						{{$data[$index]['status']}}
						<!-- <input type="hidden" name="status[]" class="form-control" value="{{$data[$index]['status']}}"> -->
					</td>
					<td>
						{{$data[$index]['total_net']}}
						<input type="hidden" name="tarif[]" class="form-control tarif_dasar" value="{{$data[$index]['total_net']}}">
					</td>
					<td>
						{{$data[$index]['komisi']}}
						<input type="hidden" name="komisi[]" class="form-control komisi" value="{{$data[$index]['komisi']}}">
						<input type="hidden" name="comp[]" class="form-control" value="{{$data[$index]['kode_cabang']}}">
					</td>
					<td>
						{{$data[$index]['biaya_komisi']}}
						<input type="hidden" name="komisi_tambahan[]" onload="hitung_komisi(this)" class="form-control komisi_tambah" value="{{$data[$index]['biaya_komisi']}}">
					</td>
					<td >
						<span class="komisi_total">{{$data[$index]['total_komisi']}}</span>
						<input type="hidden" name="total_komisi[]" class="form-control total_komisi" value="{{$data[$index]['total_komisi']}}">
					</td>
				</tr>
				@endif
				@endforeach
			</tbody>   	
	    </table>
	</div>








<!-- {{-- MODAL TT OUTLET --}} -->

<div class="modal fade" id="modal_tt_outlet" tabindex="-1" role="dialog"  aria-hidden="true">
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
                <input type="text" class="form-control lain_outlet" name="lainlain_penerus">
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
        <button type="button" class="btn btn-primary simpan_outlet" onclick="simpan_tt()" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
                       
<script type="text/javascript" src="{{asset('assets/vendors/datatables/datatables.min.js')}}"></script>
	    <script type="text/javascript">
		var datatable2 = $('.table_outlet').DataTable({
	            responsive: true,
	            searching:false,
	            //paging: false,
	            "pageLength": 10,
	            "language": dataTableLanguage,
	    });

	    $('.total_komisi').each(function(){
	    	var par 	= this.parentNode.parentNode;
	    	var kom_out = $(par).find('.komisi').val();
	    	var kom_tam = $(par).find('.komisi_tambah').val();
	    	var kom_tot = $(par).find('.komisi_total');
	    	$(this).val(parseInt(kom_out)+parseInt(kom_tam));
	    	kom_tot.html(parseInt(kom_out)+parseInt(kom_tam));


	    });
	 




	 	var kom 	= [];
	 	var tot_kom = [];
	 	var tar_das = [];
	 	var kom_tam = [];
	 	function hitung_outlet(p){
	 		var ini 			= p.parentNode.parentNode;
	 		var komisi_tambah  	= $(ini).find('.komisi_tambah').val();
	 		var child_check  	= $(ini).find('.child_check:checked').val();
	    	var komisi  		= $(ini).find('.komisi').val();
	    	var total_komisi  	= $(ini).find('.total_komisi').val();
	    	var tarif_dasar  	= $(ini).find('.tarif_dasar').val();
	    	var temp1  			= 0;
	    	var temp2  			= 0;
	    	var temp3  			= 0;
	    	var temp4  			= 0;

	    	if (child_check == 'on') {
	    		tar_das.push(tarif_dasar);
	    		kom_tam.push(komisi_tambah)
	    		tot_kom.push(total_komisi)
	    		kom.push(komisi);

	    		for(var i=0; i<tar_das.length;i++){
	    			
	    			temp1 += parseInt(tar_das[i]);
	    		}

	    		for(var i=0; i<kom_tam.length;i++) {
	    			temp2 += parseInt(kom_tam[i]);
	    		}

	    		for(var i=0; i<tot_kom.length;i++) {
	    			temp3 += parseInt(tot_kom[i]);
	    		}

	    		for(var i=0; i<kom.length;i++) {
	    			temp4 += parseInt(kom[i]);	
	    		}
	    		console.log(temp3);
	    		temp1 = accounting.formatMoney(temp1, "Rp ", 2, ".",',');
	    		$('.total_tarif').val(temp1);

	    		temp4 = accounting.formatMoney(temp4, "Rp ", 2, ".",',');
		    	$('.total_komisi_outlet').val(temp4);

		    	temp2 = accounting.formatMoney(temp2, "Rp ", 2, ".",',');
		    	$('.total_komisi_tambahan').val(temp2);

		    	temp3 = accounting.formatMoney(temp3, "Rp ", 2, ".",',');
		    	$('.total_all_komisi').val(temp3);


	    	}else{
	    		var index1 = tar_das.indexOf(tarif_dasar);
	    		var index2 = kom_tam.indexOf(komisi_tambah);
	    		var index3 = tot_kom.indexOf(total_komisi);
	    		var index4 = kom.indexOf(komisi);
	    		tar_das.splice(index1,1);
	    		kom_tam.splice(index2,1);
	    		tot_kom.splice(index3,1);
	    		kom.splice(index4,1);

	    		for(var i=0; i<tar_das.length;i++){	
	    			temp1 += parseInt(tar_das[i]);
	    		}
	    		for(var i=0; i<kom_tam.length;i++) {
	    			temp2 += parseInt(kom_tam[i]);
	    		}
	    		for(var i=0; i<tot_kom.length;i++) {
	    			temp3 += parseInt(tot_kom[i]);
	    		}
	    		for(var i=0; i<kom.length;i++) {
	    			temp4 += parseInt(kom[i]);
	    		}

	    		temp1 = accounting.formatMoney(temp1, "Rp ", 2, ".",',');
	    		$('.total_tarif').val(temp1);
	    		temp4 = accounting.formatMoney(temp4, "Rp ", 2, ".",',');
		    	$('.total_komisi_outlet').val(temp4);
		    	temp2 = accounting.formatMoney(temp2, "Rp ", 2, ".",',');
		    	$('.total_komisi_tambahan').val(temp2);
		    	temp3 = accounting.formatMoney(temp3, "Rp ", 2, ".",',');
		    	$('.total_all_komisi').val(temp3);
	    	}


	 	}
function check_parent(){
  var parent_check = $('.parent_check:checkbox:checked');

  if (parent_check.length >0) {
    datatable2.$('.child_check:checkbox').prop('checked',true);
  }else if(parent_check.length==0) {
    datatable2.$('.child_check:checkbox').removeAttr('checked');
  }

  if(parent_check.length >0) {
  	  //Remove all array value
	  tar_das.splice(0,tar_das.length);
	  kom.splice(0,kom.length);
	  kom_tam.splice(0,kom_tam.length);
	  tot_kom.splice(0,tot_kom.length);
	  //////////////////
	  var temp1 = 0;
	  var temp2 = 0;
	  var temp3 = 0;
	  var temp4 = 0;


	  //////////////////////////////////////
	  datatable2.$('.tarif_dasar').each(function(){
	  	tar_das.push($(this).val());

	  });
	  datatable2.$('.komisi').each(function(){
	  	kom.push($(this).val());

	  });
	  datatable2.$('.komisi_tambah').each(function(){
	  	kom_tam.push($(this).val());
	 
	  });
	  datatable2.$('.total_komisi').each(function(){
	  	tot_kom.push($(this).val());
	  
	  });

	 	for(var i=0; i<tar_das.length;i++){	
			temp1 += parseInt(tar_das[i]);
		}
		for(var i=0; i<kom_tam.length;i++) {
			temp2 += parseInt(kom_tam[i]);
		}
		for(var i=0; i<tot_kom.length;i++) {
			temp3 += parseInt(tot_kom[i]);
		}
		for(var i=0; i<kom.length;i++) {
			temp4 += parseInt(kom[i]);
		} 

		temp1 = accounting.formatMoney(temp1, "Rp ", 2, ".",',');
		$('.total_tarif').val(temp1);
		temp4 = accounting.formatMoney(temp4, "Rp ", 2, ".",',');
		$('.total_komisi_outlet').val(temp4);
		temp2 = accounting.formatMoney(temp2, "Rp ", 2, ".",',');
		$('.total_komisi_tambahan').val(temp2);
		temp3 = accounting.formatMoney(temp3, "Rp ", 2, ".",',');
		$('.total_all_komisi').val(temp3);

	}else{
	  tar_das.splice(0,tar_das.length);
	  kom.splice(0,kom.length);
	  kom_tam.splice(0,kom_tam.length);
	  tot_kom.splice(0,tot_kom.length);

	  temp1 = accounting.formatMoney(0, "Rp ", 2, ".",',');
	  $('.total_tarif').val(temp1);
	  temp4 = accounting.formatMoney(0, "Rp ", 2, ".",',');
	  $('.total_komisi_outlet').val(temp4);
	  temp2 = accounting.formatMoney(0, "Rp ", 2, ".",',');
	  $('.total_komisi_tambahan').val(temp2);
	  temp3 = accounting.formatMoney(0, "Rp ", 2, ".",',');
	  $('.total_all_komisi').val(temp3);
	}

}



function hitung_komisi(o){
  var ini   = o.parentNode.parentNode;
  var komisi_tambah = $(ini).find('.komisi_tambah').val();
  var komisi = $(ini).find('.komisi').val();
  var total = $(ini).find('.total_komisi').val();
  var komisi_total = $(ini).find('.komisi_total');

  total = parseInt(komisi)+parseInt(komisi_tambah);
  komisi_total.html(total);
  $(ini).find('.total_komisi').val(total);

  if(komisi_tambah.length == 0){
      komisi_total.html(komisi);
      $(ini).find('.total_komisi').val(komisi);
  }

}
 function save_outlet(){
 	
 	var no_resi=[];
 	var chck=[];
 	var tgl=[];
 	var kota_asal=[];
 	var kota_tujuan=[];
 	var status=[];
 	var tarif=[];
 	var komisi=[];
 	var komisi_tambahan=[];
 	var total_komisi=[];
 	var count = datatable2.data().count()/10;

 	for(var i = 0 ;i < count;i++){
 		
 	 	// chck[i] = datatable2.$('.chck').eq(i).val()
 	 	// no_resi[i] = datatable2.$('.no_resi').eq(i).val()
 	 	// tgl[i] = datatable2.$('.tgl').eq(i).val()
 	 	// kota_asal[i] = datatable2.$('.kota_asal').eq(i).val()
 	 	// kota_tujuan[i] = datatable2.$('.kota_tujuan').eq(i).val()
 	 	// status[i] = datatable2.$('.status').eq(i).val()
 	 	// tarif[i] = datatable2.$('.tarif').eq(i).val()
 	 	// komisi[i] = datatable2.$('.komisi').eq(i).val()
 	 	// komisi_tambahan[i] = datatable2.$('.komisi_tambahan').eq(i).val()
 	 	// total_komisi[i] = datatable2.$('.total_komisi').eq(i).val()


 	 }
    
 	 var head1 = $('.head1 .nofaktur').serializeArray();
 	 var header_total_outlet1 = $('.header_total_outlet1 :input').serializeArray()
 	 var header_total_outlet2 = $('.header_total_outlet2 :input').serializeArray()
 	 var head_outlet 		  = $('.head-outlet :input').serializeArray()

    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Pembayaran Outlet!",
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
      url:baseUrl + '/fakturpembelian/save_outlet',
      type:'post',
      data: $('.head_outlet :input').serialize()+'&'+$('.head1 :input').serialize()+'&'+datatable2.$('input').serialize()+'&'+$('.header_total_outlet1 :input').serialize()+'&'+$('.header_total_outlet2 :input').serialize(),
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                   // location.reload();
                  $("#tmbhdatapenerus").addClass('disabled');
                  $(".tmbhdatapenerus").css('background','none');
                  $(".tmbhdatapenerus").css('color','black');

                  $(".tmbhdatapo").addClass('disabled');
                  $(".tmbhdatapo").css('background','none');
                  $(".tmbhdatapo").css('color','none');

                  $("#tmbhdataitem").addClass('disabled');
                  $(".tmbhdataitem").css('background','none');
                  $(".tmbhdataitem").css('color','none');

                  $(".tmbhdataoutlet").addClass('disabled');
                  $(".tmbhdataoutlet").css('background','grey');
                  $(".tmbhdataoutlet").css('color','none');

                  $(".tmbhdatasubcon").addClass('disabled');
                  $(".tmbhdatasubcon").css('background','none');
                  $(".tmbhdatasubcon").css('color','none');

                  $('.save_update_outlet').addClass('disabled');
                  $('.cari-pod').addClass('disabled');
                  
                  $('.modal_outlet_tt').addClass('disabled');
                  $('.print-penerus').removeClass('disabled');
                  $('.idfaktur').val(response.id);

                  $('.btn_modal_ot').removeClass('disabled');
                  $('.save_ot_um').removeClass('disabled');

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


$('.modal_outlet_tt').click(function(){
	var total_all_komisi = $('.total_all_komisi').val();
	var jatuh_tempo_outlet = $('.jatuh_tempo_outlet').val();
	var selectOutlet = $('.selectOutlet').val();
	var cabang = $('.cabang').val();
		$.ajax({    
	            type :"get",
	            data : 'cab='+cabang+'&'+'outlet='+selectOutlet+'&'+$('.head1 .nofaktur').serialize(),
	            url : baseUrl + '/fakturpembelian/adinott',
	            dataType:'json',
	            success : function(data){
	            	$('.supplier_tt').val(data.sup.nama);
	            	$('.jatuhtempo_tt').val(jatuh_tempo_outlet);
	            	if (total_all_komisi != '') {
	            		$('.totalterima_tt').val(total_all_komisi);
	            	}else{
	            		$('.totalterima_tt').val('Rp 0,00');
	            	}

	            }
	    })
	
});


  function tt_penerus_outlet() {

    var cabang = $('.cabang').val();
    var agen_vendor = $('.selectOutlet').val();
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
    $('#save_update_outlet').removeClass('disabled');
    $('.save').removeClass('disabled');
}
function print_penerus() {
  var idfaktur = $('.idfaktur').val();
  console.log(idfaktur);
   window.open('{{url('fakturpembelian/detailbiayapenerus')}}'+'/'+idfaktur);
  }

function hitung_um_ot() {
  var temp = 0;
  datatable5.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  $('.ot_total_um').val(accounting.formatMoney(temp, "", 2, ".",','));

}
  



$('.btn_modal_ot').click(function(){
  $('#modal_um_ot').modal('show');
})


var array_um1 = [0];
var array_um2 = [0];
$('.ot_nomor_um').focus(function(){
  var sup = $('.selectOutlet').val();
  if (sup == '0') {
    toastr.warning('Agen/Vendor Harus Diisi');
    return false;
  }

  $.ajax({
    url:baseUrl +'/fakturpembelian/outlet_um',
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

$('.ot_tambah_um').click(function(){
  var nota = $('.ot_nomor_um').val();
  var sup = $('.selectOutlet').val();
  var nofaktur = $('.nofaktur').val();
  var ot_id_um = $('.ot_id_um').val();
  var ot_dibayar_um = $('.ot_dibayar_um').val();
  ot_dibayar_um   = ot_dibayar_um.replace(/[^0-9\-]+/g,"")/1;





  if (nota == '') {
    toastr.warning("Uang Muka Harus dipilih");
    return false;
  }
  if (ot_dibayar_um == '' || ot_dibayar_um == '0') {
    toastr.warning("Pembayaran Tidak Boleh 0");
    return false;
  }

  
  

  $.ajax({
    url:baseUrl +'/fakturpembelian/biaya_penerus/append_um',
    data: {nota,sup},
    dataType:'json',
    success:function(data){

      $('.ot_nomor_um').val(data.data.nomor);
      $('.ot_tanggal_um').val(data.data.um_tgl);
      $('.ot_jumlah_um').val(accounting.formatMoney(data.data.total_um, "", 2, ".",','));
      $('.ot_sisa_um').val(accounting.formatMoney(data.data.sisa_um, "", 2, ".",','));
      $('.ot_keterangan_um').val(data.data.um_keterangan);

      if (ot_dibayar_um > data.data.sisa_um) {
        toastr.warning("Pembayaran Melebihi Sisa Uang Muka");
        return false;
      }
      if (ot_id_um == '') {
        datatable5.row.add([
            '<p class="tb_faktur_um_text">'+nofaktur+'</p>'+
            '<input type="hidden" class="tb_faktur_um_'+id_um+' tb_faktur_um" value="'+id_um+'">',

            '<p class="tb_transaksi_um_text">'+data.data.nomor+'</p>'+
            '<input type="hidden" class="tb_transaksi_um" name="tb_transaksi_um[]" value="'+data.data.nomor+'">',

            '<p class="tb_tanggal_text">'+data.data.um_tgl+'</p>',

            '<p class="tb_um_um_text">'+data.data.um_nomorbukti+'</p>'+
            '<input type="hidden" class="tb_um_um" name="tb_um_um[]" value="'+data.data.um_nomorbukti+'">',

            '<p class="tb_jumlah_um_text">'+accounting.formatMoney(data.data.total_um, "", 2, ".",',')+'</p>',

            '<p class="tb_sisa_um_text">'+accounting.formatMoney(data.data.sisa_um, "", 2, ".",',')+'</p>',

            '<p class="tb_bayar_um_text">'+accounting.formatMoney(ot_dibayar_um, "", 2, ".",',')+'</p>'+
            '<input type="hidden" class="tb_bayar_um" name="tb_bayar_um[]" value="'+ot_dibayar_um+'">',

            '<p class="tb_keterangan_um_text">'+data.data.um_keterangan+'</p>',

            '<div class="btn-group ">'+
            '<a  onclick="edit_um_ot(this)" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i></a>'+
            '<a  onclick="hapus_um_ot(this)" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>'+
            '</div>',
          ]).draw();
        id_um++;
        array_um1.push(data.data.nomor);
        array_um2.push(data.data.um_nomorbukti);
      }else{
        var par = $('.tb_faktur_um_'+ot_id_um).parents('tr');
        $(par).find('.tb_bayar_um').val(ot_dibayar_um);
        $(par).find('.tb_bayar_um_text').text(accounting.formatMoney(ot_dibayar_um, "", 2, ".",','));
      }
      hitung_um_ot();
      $('.ot_tabel_um :input').val('');
    },error:function(){
      toastr.warning('Terjadi Kesalahan');
    }
  })
})


function edit_um_ot(a) {
  var par = $(a).parents('tr');
  var tb_faktur_um          = $(par).find('.tb_faktur_um').val();
  var tb_transaksi_um       = $(par).find('.tb_transaksi_um').val();
  var tb_tanggal_text       = $(par).find('.tb_tanggal_text').text();
  var tb_um_um              = $(par).find('.tb_um_um').val();
  var tb_jumlah_um_text     = $(par).find('.tb_jumlah_um_text').text();
  var tb_sisa_um_text       = $(par).find('.tb_sisa_um_text').text();
  var tb_bayar_um           = $(par).find('.tb_bayar_um').val();
  var tb_keterangan_um_text = $(par).find('.tb_keterangan_um_text').text();

  $('.ot_id_um').val(tb_faktur_um);
  $('.ot_nomor_um').val(tb_transaksi_um);
  $('.ot_tanggal_um').val(tb_tanggal_text);
  $('.ot_jumlah_um').val(tb_jumlah_um_text);
  $('.ot_sisa_um').val(tb_sisa_um_text);
  $('.ot_keterangan_um').val(tb_keterangan_um_text)
  $('.ot_dibayar_um').val(accounting.formatMoney(tb_bayar_um, "", 0, ".",','));

}

function hapus_um_ot(a) {
  var par             = $(a).parents('tr');
  var tb_transaksi_um = $(par).find('.tb_transaksi_um').val();
  var tb_um_um        = $(par).find('.tb_um_um').val();

  var index1 = array_um1.indexOf(tb_transaksi_um);
  var index2 = array_um2.indexOf(tb_um_um);

  array_um1.splice(index1,1);
  array_um2.splice(index2,1);

  datatable5.row(par).remove().draw(false);

  hitung_um_ot();
}


$('.save_ot_um').click(function(){

  var temp = 0;
  var ot_total_um = $('.ot_total_um').val();
  datatable5.$('.tb_bayar_um').each(function(){
    var b = $(this).val();
    b   = b.replace(/[^0-9\-]+/g,"")/1;
    console.log(b);
    temp+=b;
  })
  var total_jml = $('.total_all_komisi').val();
  total_jml   = total_jml.replace(/[^0-9\-]+/g,"")/100;

  if (temp > total_jml) {
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
              +'&'+datatable5.$('input').serialize()+'&bp_total_um='+ot_total_um,
        success:function(response){
          if (response.status == 1) {
              swal({
                  title: "Berhasil!",
                  type: 'success',
                  text: "Data berhasil disimpan",
                  timer: 900,
                  showConfirmButton: true
                  },function(){
                   $('.save_ot_um').addClass('disabled');
                   $('.btn_modal_ot').addClass('disabled');
                   
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

$.fn.serializeArray = function () {
    var rselectTextarea= /^(?:select|textarea)/i;
    var rinput = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i;
    var rCRLF = /\r?\n/g;
    
    return this.map(function () {
        return this.elements ? jQuery.makeArray(this.elements) : this;
    }).filter(function () {
        return this.name && !this.disabled && (this.checked || rselectTextarea.test(this.nodeName) || rinput.test(this.type) || this.type == "checkbox");
    }).map(function (i, elem) {
        var val = jQuery(this).val();
        if (this.type == 'checkbox' && this.checked === false) {
            val = 'off';
        }
        return val == null ? null : jQuery.isArray(val) ? jQuery.map(val, function (val, i) {
            return {
                name: elem.name,
                value: val.replace(rCRLF, "\r\n")
            };
        }) : {
            name: elem.name,
            value: val.replace(rCRLF, "\r\n")
        };
    }).get();
}
$(document).ready(function(){
	var cabang = $('.cabang').val();
    $.ajax({
      url:baseUrl +'/fakturpembelian/nota_tt',
      data: {cabang},
      dataType:'json',
      success:function(data){
        $('.notandaterima').val(data.nota);
       
      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
})
</script>