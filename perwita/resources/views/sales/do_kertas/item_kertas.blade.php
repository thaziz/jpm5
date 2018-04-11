
@if($status == 1)
<td>Item</td>
<td colspan="5">
    <select onchange="cari_item()" name="item" class="form-control item chosen-select-width">
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
</td>
<td align="center">
    <button onclick="cari_kontrak()" type="button" class="btn btn-success"><i class="fa fa-search"> Cari Kontrak</i></button>
</td>
@endif