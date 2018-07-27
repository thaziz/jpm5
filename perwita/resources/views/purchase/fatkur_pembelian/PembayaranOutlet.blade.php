
<div class="header_outlet" style="width: 400px; margin: 0 auto;min-height: 400px;" >

	<form class="head_outlet2">
			{{ csrf_field() }}
		<table class="table	head_outlet">
		<h3 style="text-align: center;">Form Pembayaran Outlet</h3>
		 <tr>
		 	<td>Pilih Outlet</td>
		 	<td width="10">:</td>
		 	<td>
		 		<select class="form-control selectOutlet chosen-select-width1" name="selectOutlet">
		 			@foreach($agen as $val)
		 			<option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
		 			@endforeach
		 		</select>
		 	</td>
		 </tr>
		 <tr>
	      <td style="width: 100px">Tanggal Faktur</td>
	      <td width="10">:</td>
	      <td width="200">
	        <input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="" readonly="" style="">
	      </td>
	     </tr>
		  <tr>
		 	<td>Tanggal</td>
		 	<td width="10">:</td>
		 	<td>
		 		<input  class="form-control reportrange" type="text" value="{{$start}} - {{$second}}" name="rangepicker"  >
		 	</td>
		 </tr>
		 <tr>
		 	<td>Jatuh Tempo</td>
		 	<td width="10">:</td>
		 	<td>
		 		<input  class="form-control jatuh_tempo_outlet" type="text" value="{{$jt}}" name="jatuh_tempo_outlet"  >
		 	</td>
		 </tr>
		 <tr>
		  <td style="width: 100px">Tanda terima</td>
		  <td width="10">:</td>
		  <td width="200">
		    <input type="text" readonly="" name="tanda_terima" class="form-control tanda_terima" style="" >
		    <input type="hidden" readonly="" name="invoice_tt" class="form-control invoice_tt" style="" >
		    <input type="hidden" readonly="" name="id_tt" class="form-control id_tt" style="" >
		    <input type="hidden" readonly="" name="dt_tt" class="form-control dt_tt" style="" >
		  </td>
		 </tr>
		<tr>
		 	<td width="111">Note</td>
		 	<td width="20">:</td>
		 	<td>
		 		<textarea onkeyup="autoNote()" class="form-control note_po" id="note" name="note" style="max-width: 253px;min-height: 100px; max-height: 100px"></textarea> 
		 	</td>
		 </tr>
     </table>
     <button type="button" class="btn btn-warning pull-left disabled print-penerus" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
     <button type="button" class="btn btn-primary pull-right cari_outlet" onclick="cari_outlet()"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>

 <div class="table-outlet ">
 	
 </div>
<!-- Include Required Prerequisites -->

<script type="text/javascript">
$(document).ready( function () {
        
var config2 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }
             for (var selector in config2) {
               $(selector).chosen(config2[selector]);
             }

  $('.selectOutlet').chosen(config2); 


});

$('.jatuh_tempo_outlet').datepicker({
	format:'dd/mm/yyyy'
});

$('.tgl-biaya').datepicker({
	format:'dd/mm/yyyy'
});
$('.reportrange').daterangepicker({
          autoclose: true,
          "opens": "left",
          locale: {
          format: 'DD/MM/YYYY'
      }         
});

function autoNote(){

    var note = $('#note').val();
    $( "#note" ).autocomplete({
      source:baseUrl + '/fakturpembelian/cariNote', 
      minLength: 3,
    });
 }



 function cari_outlet() {
 	var  selectOutlet = $('.selectOutlet').val();
 	var  cabang 	  = $('.cabang').val();
 	var  reportrange  = $('.reportrange').val();
 	$.ajax({
      url:baseUrl +'/fakturpembelian/cari_outlet',
      data: {selectOutlet,cabang,reportrange},
      success:function(data){
 		
      	$('.table-outlet').html(data);

      },error:function(){
        toastr.warning('Terjadi Kesalahan');
      }
    })
 }

 
</script>
