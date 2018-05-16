<table class="table kredit_table">
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
 		<td>{{ $val->cndn_nota }}</td>
 		<td>{{ $val->cndn_tgl }}</td>
 		<td>{{ number_format($val->cndt_nettocn, 0, ",", ".") }}</td>
 	</tr>
 @endforeach
</tbody>
</table>

<script>
    var histori_tabel = $('.kredit_table').DataTable();
</script>