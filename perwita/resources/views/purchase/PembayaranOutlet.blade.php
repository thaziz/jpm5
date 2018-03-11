
<div class="header_outlet" style="width: 400px; margin: 0 auto;min-height: 400px;" >

	<form>
		<table class="table	head_outlet">
			{{ csrf_field() }}
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
		 	<td>Tanggal</td>
		 	<td width="10">:</td>
		 	<td>
		 		<input  class="form-control reportrange" type="text" value="{{$start}} - {{$second}}" name="rangepicker"  >
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

 function autoNote(){

    var note = $('#note').val();
    $( "#note" ).autocomplete({
      source:baseUrl + '/fakturpembelian/cariNote', 
      minLength: 3,
    });

   }

</script>
