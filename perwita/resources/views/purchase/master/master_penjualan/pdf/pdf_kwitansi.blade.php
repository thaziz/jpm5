
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
                            <th> No</th>
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Customer</th>
                            <th> Satuan </th>
                            <th> Status </th>
                            <th> Diskon </th>
                            <th> Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index }}</td>
                          <td>{{ $dat1[$index][0]->nomor }}</td>
                          <td>{{ $dat1[$index][0]->tanggal }}</td>
                          <td>{{ $dat1[$index][0]->kode_customer }}</td>
                          <td>{{ $dat1[$index][0]->kode_satuan }}</td>
                          <td>{{ $dat1[$index][0]->status }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->diskon,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->total_net,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
