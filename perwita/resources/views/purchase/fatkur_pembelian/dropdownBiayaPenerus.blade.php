
@if($flag == 'AGEN')
<select name="nama_kontak1" class="form-control nama-kontak-agen1  chosen-select-width1" style="text-align: center; width: 250px;">
 	<option value="0">- Pilih - Agen -</option>
 	@foreach($data as $val)
 	<option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
 	@endforeach
</select>
@else
<select name="nama_kontak2" class="form-control nama-kontak-vendor1 chosen-select-width1" style="text-align: center; width: 250px;">
 	<option value="0">- Pilih - Vendor -</option>
 	@foreach($data as $val)
 	<option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
 	@endforeach
</select>
@endif