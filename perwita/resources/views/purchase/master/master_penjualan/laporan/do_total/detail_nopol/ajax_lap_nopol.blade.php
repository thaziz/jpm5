

<table class="table table-bordered datatable table-striped" id="table" width="900px">
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
    @foreach ($nopol as $i => $a)
        <tr>
          <td colspan="9" style="background-color: #aeff87;">NOMOR POLISI  -  {{ $nopol[$i][0]->nopol }}</td>
        </tr>
      @foreach ($data as $e)
        @if ( $nopol[$i][0]->nopol == $e->nopol )
         <tr>
          <td>{{ $e->nomor }}</td>
          <td>{{ $e->tanggal }}</td>
          <td>-</td>
          <td>-</td>
          <td>{{ $e->deskripsi }}</td>
          <td>{{ $e->jumlah }}</td>
          <td>{{ $e->kode_satuan }}</td>
          <td>{{ $e->total }}</td>
          <td>{{ $e->total_net }}</td>
        </tr>
        @endif
      @endforeach
    @endforeach
  </tbody>
</table>
