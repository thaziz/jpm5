<select  name="patty_cash" class="item chosen-select-width2 form-control">
        <option value="0">Pilih - Akun</option>
    @foreach($akun as $i)
        <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
    @endforeach
</select>
<script>

	var config2 = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width2'     : {width:"100%",search_contains:true}
                }
    for (var selector in config2) {
        $(selector).chosen(config2[selector]);
    }

</script>