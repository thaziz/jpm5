
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
                            <th> Customer</th>
                            <th> Tanggal </th>
                            <th> Pengirim  </th>
                            <th> Penerima  </th>
                            <th> Kota Asal  </th>
                            <th> Kota Tujuan  </th>
                            <th> Tipe  </th>
                            <th> Pendapatan  </th>
                            <th> Status</th>
                            <th> Cabang  </th>
                            <th> Tarif Keseluruhan  </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index }}</td>
                          <td>{{ $val->nomor }}</td>
                          <td>{{ $val->tanggal }}</td>
                          <td>{{ $val->cus }}</td>
                          <td>{{ $val->nama_pengirim }}</td>
                          <td>{{ $val->nama_penerima }}</td>
                          <td>{{ $val->asal }}</td>
                          <td>{{ $val->tujuan }}</td>
                          <td>{{ $val->type_kiriman }}</td>
                          <td>{{ $val->pendapatan }}</td>
                          <td>{{ $val->status }}</td>
                          <td>{{ $val->cab }}</td>
                          <td align="right">{{ number_format( $val->total_net,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tr>
                      <td colspan="10">Total net</td>
                      <td id="total_grandtotal" align="right">{{ number_format($total_perhitungan,0,',','.') }}</td>
                    </tr>
                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
