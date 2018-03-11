<select class="form-control kontrak_id" onchange="cari_kontrak()">
	<option value="0">- Cari - Subcon -</option>
	@foreach($fix as $i => $val)
	<option value="{{$val['ksd_id']}}">{{$val['ksd_asal']}} - {{$val['ksd_tujuan']}}</option>
	@endforeach
</select>