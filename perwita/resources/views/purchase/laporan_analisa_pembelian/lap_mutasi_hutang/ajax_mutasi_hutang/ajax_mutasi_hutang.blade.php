<table class="table table-bordered">
  <tr>
      <th rowspan="2">No</th>
      <th colspan="2" align="center">Kode Account</th>
      <th rowspan="2">Saldo awal</th>
      <th colspan="3" align="center">Mutasi kredit</th>
      <th colspan="5" align="center">Mutasi Debet</th>
      <th rowspan="2">Saldo akir</th>
      <th rowspan="2">Sisa uang muka</th>
  </tr>
  <tr>
      <th>Kode</th>
      <th>Nama</th>
      <th>Hutang baru</th>
      <th>Hutang Voucher</th>
      <th>Nota kredit</th>
      <th>byr cash</th>
      <th>byr uangmuka </th>
      <th>cek BG/Trans</th>
      <th>retur beli</th>
      <th>Nota debet</th>
  </tr>
  @foreach ($data['akun'] as $ah => $element)
    <tr>
        <td>{{ $ah+1 }}</td>
        <td>{{ $data['akun'][$ah]['id_akun'] }}</td>
        <td>{{ $data['akun'][$ah]['nama_akun'] }}</td>
        <td><input type="hidden" name="" class="saldoawal" value="{{ $data['hutangsupplier'][$ah]['saldoawal'] }}">
        {{ $data['hutangsupplier'][$ah]['saldoawal'] }}</td>
        
        <td><input type="hidden" name="" class="hutangbaru" value="{{ $data['isidetail'][$ah]['isi']['hutangbaru'] }}">
        {{ $data['isidetail'][$ah]['isi']['hutangbaru'] }}</td>
        
        <td><input type="hidden" name="" class="voucherhutang" value="{{ $data['isidetail'][$ah]['isi']['voucherhutang'] }}">
        {{ $data['isidetail'][$ah]['isi']['voucherhutang'] }}</td>
        
        <td><input type="hidden" name="" class="creditnota" value="{{ $data['isidetail'][$ah]['isi']['creditnota'] }}">
        {{ $data['isidetail'][$ah]['isi']['creditnota'] }}</td>
        
        <td><input type="hidden" name="" class="cash" value="{{ $data['isidetail'][$ah]['isi']['cash'] }}">
        {{ $data['isidetail'][$ah]['isi']['cash'] }}</td>
        
        <td><input type="hidden" name="" class="uangmuka" value="{{ $data['isidetail'][$ah]['isi']['uangmuka'] }}">
        {{ $data['isidetail'][$ah]['isi']['uangmuka'] }}</td>
        
        <td><input type="hidden" name="" class="bg" value="{{ $data['isidetail'][$ah]['isi']['bg'] }}">
        {{ $data['isidetail'][$ah]['isi']['bg'] }}</td>
        
        <td><input type="hidden" name="" class="rn" value="{{ $data['isidetail'][$ah]['isi']['rn'] }}">
        {{ $data['isidetail'][$ah]['isi']['rn'] }}</td>
        
        <td><input type="hidden" name="" class="debitnota" value="{{ $data['isidetail'][$ah]['isi']['debitnota'] }}">
        {{ $data['isidetail'][$ah]['isi']['debitnota'] }}</td>
        
        <td><input type="hidden" name="" class="saldoakhir" value="{{ $data['isidetail'][$ah]['isi']['saldoakhir'] }}">
        {{ $data['isidetail'][$ah]['isi']['saldoakhir'] }}</td>
        
        <td><input type="hidden" name="" class="sisaum" value="{{ $data['isidetail'][$ah]['isi']['sisaum'] }}">
        {{ $data['isidetail'][$ah]['isi']['sisaum'] }}</td>
    </tr>  
  @endforeach
  <tr>
    <td colspan="3">sub Total :</td>
    <td class="output_saldoawal"></td>
    <td class="output_hutangbaru"></td>
    <td class="output_voucherhutang"></td>
    <td class="output_creditnota"></td>
    <td class="output_cash"></td>
    <td class="output_uangmuka"></td>
    <td class="output_bg"></td>
    <td class="output_rn"></td>
    <td class="output_debitnota"></td>
    <td class="output_saldoakhir"></td>
    <td class="output_sisaum"></td>
  </tr>
</table>