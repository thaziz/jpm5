<table class="table um_tabel">
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
 		<td>{{ $val->umfpdt_notaum }}</td>
 		<td>{{ $val->umfpdt_tgl }}</td>
 		<td>{{ number_format($val->umfpdt_jumlahum, 0, ",", ".") }}</td>
 	</tr>
 @endforeach
</tbody>
</table>

<script>
    var histori_tabel = $('.um_tabel').DataTable();
</script>