<select class="form-control kas" name="kas">
	@foreach($akun as $val)
		<option value="{{ $val->id_akun }}">{{ $val->id_akun }} - {{ $val->nama_akun }}</option>
	@endforeach
</select>