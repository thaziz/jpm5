
<select name="tipe_kendaraan" class="form-control tipe_kendaraan chosen-select-width1 input-sm">
	@if($status == 1)
	@foreach($data as $val)
		@if($nopol == $val->nopol)
		<option selected="" value="{{$val->id}}">{{$val->nopol}}</option>
		@else
		<option value="{{$val->id}}">{{$val->nopol}}</option>
		@endif
	@endforeach
	@else
		<option value="0">Nopol Tidak Ditemukan</option>
	@endif
</select>

<script>
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
</script>