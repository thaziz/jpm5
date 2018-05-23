

<table class="table table-bordered datatable table-striped" id="table_detailsales" width="900px">
  <thead>
    <tr>
      <th> No. Do</th>
      <th> Tanggal</th>
      <th> Item</th>
      <th> Nama</th>
      <th> Keterangan</th>
      <th> Qty</th>
      <th> Sat</th>
      <th> Netto</th>
      <th> Jumlah</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($marketing as $i => $a)
        <tr>
          <td colspan="9" style="background-color: #aeff87;">{{ $marketing[$i][0]->kode }} - {{ $marketing[$i][0]->nama }}</td>
        </tr>
      @foreach ($data as $e)
        @if ( $marketing[$i][0]->kode == $e->kode_marketing )
         <tr>
          <td>{{ $e->nomor }}</td>
          <td>{{ $e->tanggal }}</td>
          <td>-</td>
          <td>-</td>
          <td>{{ $e->deskripsi }}</td>
          <td>{{ $e->jumlah }}</td>
          <td>{{ $e->kode_satuan }}</td>
          <td align="right">{{ number_format($e->total,0,'','.') }}</td>
          <td align="right">{{ number_format($e->total_net,0,'','.') }}</td>
        </tr>
        @endif
      @endforeach
    @endforeach
  </tbody>
</table>
