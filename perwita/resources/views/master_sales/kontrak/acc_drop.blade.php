<select class="acc_akun_modal form-control chosen-select-width1" name="acc_akun_modal">
        <option value="0">Pilih - Akun</option>
    @foreach($data as $val)
    	<option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
    @endforeach
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