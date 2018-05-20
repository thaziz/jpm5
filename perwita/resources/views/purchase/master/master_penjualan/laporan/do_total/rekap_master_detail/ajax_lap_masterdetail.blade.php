

<table class="table table-bordered datatable table-striped" id="table" width="900px">
  <thead>
    <tr>
      <th> No. Do</th>
      <th> Tanggal</th>
      <th> Asal</th>
      <th> Tujuan</th>
      <th> pendapatan</th>
      <th> Keterangan</th>
      <th> Brutto</th>
      <th> Netto</th>
    </tr>
  </thead>
  <tbody>
   @foreach ($customer_foreach as $index => $e) 
    <tr style="background-color: #aeff87;">
      <td colspan="8">{{ $customer_foreach[$index][0]->kode }} - {{ $customer_foreach[$index][0]->nama }}</td>
    </tr>
    <tr style="text-align: right;background-color: #e6ffda;">
      @foreach ($data as $a => $element)
        @if ($customer_foreach[$index][0]->kode == $data[$a]->kode_customer)
        <tr>
              <td>{{$data[$a]->nomor }}</td>
              <td>{{$data[$a]->tanggal }}</td>
              <td>{{$data[$a]->asal }}</td>
              <td>{{$data[$a]->tujuan }}</td>
              <td>{{$data[$a]->pendapatan }}</td>
              <td>{{$data[$a]->deskripsi }}</td>
              <td align="right">{{ number_format($data[$a]->total,0,'.','.') }}</td>
              <td align="right">{{ number_format($data[$a]->total_net,0,'.','.') }}</td>
        </tr>
        @endif
      @endforeach
    </tr>
  @endforeach
  <tr>
    <td colspan="7">Total</td>
    <td align="right">{{ number_format($total,0,'.','.') }}</td>
  </tr>
  </tbody>
</table>
