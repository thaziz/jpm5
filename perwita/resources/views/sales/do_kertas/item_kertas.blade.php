
@if($status == 1)
<td>Item</td>
<td colspan="5">
    <select onchange="cari_item()" name="item" class="form-control item chosen-select-width1">
        <option value="0">Pilih - Item</option>
        @foreach($item as $val)
        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
        @endforeach
    </select>
    <input type="hidden" readonly="" name="kcd_dt" class="kcd_dt form-control">
</td>
@else
<td>Item</td>
<td colspan="4">
    <input type="text" readonly="" name="item" class="item form-control">
    <input type="hidden" readonly="" name="kcd_dt" class="kcd_dt form-control">
    <input type="hidden" readonly="" name="nama_kontrak" class="nama_kontrak form-control">
</td>
<td align="center">
    <button onclick="cari_kontrak()" type="button" class="btn btn-success"><i class="fa fa-search"> Cari Kontrak</i></button>
</td>
@endif
<script>
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