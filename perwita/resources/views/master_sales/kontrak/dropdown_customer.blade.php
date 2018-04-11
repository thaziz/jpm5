
<select  class="chosen-select-width form-control customer"  name="id_subcon" id="customer" style="width:100%" >
    <option selected="">- Pilih Customer -</option>
    @foreach($customer as $val)
    @foreach($kota as $i)
      @if($i->id == $val->kota)
      <option value="{{$val->kode}}" data-accpiutang="{{$val->acc_piutang}}">{{$val->kode}} - {{$val->nama}} - {{$i->nama}}</option>
      @endif
    @endforeach
    @endforeach
</select>


<script>
	var config2 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"100%"}
             }
             for (var selector in config2) {
               $(selector).chosen(config2[selector]);
             }
</script>