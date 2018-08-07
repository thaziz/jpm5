 <table id="addColumn"  class="table table-bordered table-striped">
  <thead>
      <tr>
          <th> No Kwitansi</th>
          <th> Tanggal </th>
          <th> Customer </th>
          <th> Ttl Bayar</th>
          <th> Debet(+) </th>
          <th> Kredit(-) </th>
          <th> Netto </th>
          {{-- <th> bank </th> --}}
      </tr>
  </thead>
  <tbody>
    @foreach ($data as $index =>$e)
      <tr>
        <td><input type="hidden" value="{{ $e->k_nomor }}" name="nomor">{{ $e->k_nomor }}</td>
        <td>{{ $e->k_tanggal }}</td>
        <td>{{ $e->k_kode_customer }}</td>
        <td align="right">{{ number_format($e->k_jumlah,0,',','.') }}</td>
        <td align="right">{{ number_format($e->k_debet,0,',','.') }}</td>
        <td align="right">{{ number_format($e->k_kredit,0,',','.') }}</td>
        <td align="right">{{ number_format($e->k_netto,0,',','.') }}</td>
        {{-- <td >{{ $e->k_nota_bank }}</td> --}}
      </tr>
    @endforeach
  </tbody>
  <tr>
    <td colspan="6">Total net</td>
    <td id="total_grandtotal"></td>
  </tr>
</table>


  