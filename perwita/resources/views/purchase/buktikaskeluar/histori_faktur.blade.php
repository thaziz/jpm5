<table class="table histori_tabel">
<thead>
  <tr>
    <th>No</th>
    <th>No Transaksi</th>
    <th>Tanggal</th>
    <th>Jumlah Bayar</th>
  </tr>
</thead>
<tbody>
 @foreach($data as $i=>$val)
 	<tr>
 		<td>{{ $i+1 }}</td>
 		<td>{{ $val->nota }}</td>
 		<td>{{ $val->tanggal }}</td>
 		<td>{{ number_format($val->total, 0, ",", ".") }}</td>
 	</tr>
 @endforeach
</tbody>
</table>
<script>
    var histori_tabel = $('.histori_tabel').DataTable();
</script>