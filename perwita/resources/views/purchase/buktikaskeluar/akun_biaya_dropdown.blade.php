<select class="form-control akun_biaya chosen-select-width1" name="akun_biaya">
	<option value="0">Pilih - Akun</option>}
	@foreach($akun as $val)
		<option value="{{ $val->maf_kode_akun }}">{{ $val->maf_kode_akun }} - {{ $val->maf_nama }}</option>
	@endforeach
</select>

<script>
	var config1 = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width1'     : {width:"100%",search_contains:true}
                }
    for (var selector in config1) {
        $(selector).chosen(config1[selector]);
    }
    
</script>