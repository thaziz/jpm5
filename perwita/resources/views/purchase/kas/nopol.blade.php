<select style="display: inline-block; " class="form-control nopol chosen-select-width1" name="nopol">
   <option selected=""  value="0">- pilih-nopol -</option>
   @foreach($data as $val)
   <option @if($id == $val->id) selected="" @endif value="{{$val->id}}">{{$tipe->nama}} - {{$val->nopol}} - {{ $val->kode_cabang }} </option>
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
