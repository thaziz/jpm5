<select style="display: inline-block; " class="form-control nama_akun_dropdown chosen-select-width1" name="nama_akun">
   <option selected=""  value="0">- pilih-akun -</option>
   @foreach($data as $val)
   <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
   @endforeach
</select>

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
</script>