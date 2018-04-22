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
	    <button onclick="tt_penerus_outlet()" class="btn btn-info modal_outlet_tt" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
	    <button type="button" class="btn btn-primary pull-right save_update_outlet" id="save_update_outlet" onclick="save_outlet()" data-dismiss="modal">Simpan Data</button>
	    	
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
				@if($data[$index]['potd_pod'] == null or $data[$index]['potd_potid'] == $id->pot_id)
				<tr>
					<td><input @if($data[$index]['potd_pod'] != null ) checked="checked" @endif type="checkbox" name="chck[]" onchange="hitung_outlet(this)" class="form-control child_check" ></td>
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

 			$('.save_update_outlet').addClass('disabled');

	 	}
function check_parent(){
  var parent_check = $('.parent_check:checkbox:checked');
  console.log(parent_check);
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

function check_load() {
  var temp1 = 0;
  var temp2 = 0;
  var temp3 = 0;
  var temp4 = 0;

  	datatable2.$('.tarif_dasar').each(function(){
  		var par = $(this).parents('tr');
  		var check = $(par).find('.child_check').is(':checked');
  		if (check == true) {
	  	tar_das.push($(this).val());
  		}

	  });
	  datatable2.$('.komisi').each(function(){
  		var par = $(this).parents('tr');
  		var check = $(par).find('.child_check').is(':checked');
  		if (check == true) {
	  	kom.push($(this).val());
  		}


	  });
	  datatable2.$('.komisi_tambah').each(function(){
  		var par = $(this).parents('tr');
  		var check = $(par).find('.child_check').is(':checked');
  		if (check == true) {
	  	kom_tam.push($(this).val());
  		}
	 
	  });
	  datatable2.$('.total_komisi').each(function(){
  		var par = $(this).parents('tr');
  		var check = $(par).find('.child_check').is(':checked');

  		if (check == true) {
	  	tot_kom.push($(this).val());
  		}
	  
	  });

	 console.log(tar_das);
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



$('.modal_outlet_tt').click(function(){
	var total_all_komisi = $('.total_all_komisi').val();
	var jatuh_tempo_outlet = $('.jatuh_tempo_outlet').val();
	var selectOutlet = $('.selectOutlet').val();
	var cabang = $('.cabang').val();

	if (total_all_komisi != '') {
		$('.totalterima_tt').val(total_all_komisi);
	}else{
		$('.totalterima_tt').val('Rp 0,00');
	}
	
});





  function tt_penerus_outlet() {

    var total_all_komisi 	= $('.total_all_komisi').val();
    var jatuh_tempo_outlet  = $('.jatuh_tempo_outlet').val();

    $('.jatuhtempo_tt').val(jatuh_tempo_outlet);
    $('.totalterima_tt').val(total_all_komisi);


  }

 
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
 	check_load();
 })
</script>