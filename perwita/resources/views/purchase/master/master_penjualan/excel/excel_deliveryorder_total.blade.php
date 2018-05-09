
<style>
  .pembungkus{
    width: 1000px;
  }
  table {
    border-collapse: collapse;
}
  table,th,td{
    border :1px solid black;
  }
</style>

<div class=" pembungkus">
{{--   @if ()
    expr
  @endif --}}
           <table id="addColumn" width="100%" class="table table-bordered table-striped">
                    <thead>
                        <tr> 
                            <th> No.</th>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim  </th>
                            <th> Penerima  </th>
                            <th> Kota Asal  </th>
                            <th> Kota Tujuan  </th>
                            <th> Kec Tujuan  </th>
                            <th> Tipe  </th>
                            <th> Status</th>
                            <th> Cabang  </th>
                            <th> Tarif Keseluruhan  </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index }}</td>
                          <td>{{ $dat1[$index][0]->nomor }}</td>
                          <td>{{ $dat1[$index][0]->tanggal }}</td>
                          <td>{{ $dat1[$index][0]->nama_pengirim }}</td>
                          <td>{{ $dat1[$index][0]->nama_penerima }}</td>
                          <td>{{ $dat1[$index][0]->asal }}</td>
                          <td>{{ $dat1[$index][0]->tujuan }}</td>
                          <td>{{ $dat1[$index][0]->kecamatan }}</td>
                          <td>{{ $dat1[$index][0]->type_kiriman }}</td>
                          <td>{{ $dat1[$index][0]->status }}</td>
                          <td>{{ $dat1[$index][0]->cabang }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->total_net,2,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                      <td colspan="11">Total net</td>
                      <td id="total_grandtotal" align="right">{{ number_format($total_perhitungan,2,',','.') }}</td>
                    </tr>
                  </table>



</div>
<script type="text/javascript">
</script>
