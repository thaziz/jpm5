<table class="table table-bordered">
	<thead>
		<tr>
			<th>Kode AKun</th>
			<th>Nama Akun</th>
			<th>DEBET</th>
			<th>KREDIT</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $data)
		<tr>
			<td>{{ $data->id_akun }}</td>
			<td>{{ $data->nama_akun }}</td>
			<td align="right">@if($data->jrdt_statusdk == 'D'){{ number_format($data->jrdt_value, 2, ",", ".") }}  @endif</td>
			<td align="right">@if($data->jrdt_statusdk == 'K'){{ number_format($data->jrdt_value, 2, ",", ".") }} @endif</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="2">Total</td>
			<td align="right" colspan="1">{{ number_format($d, 2, ",", ".") }}</td>
			<td align="right" colspan="1">{{ number_format($k, 2, ",", ".") }}</td>
		</tr>
	</tbody>
</table>