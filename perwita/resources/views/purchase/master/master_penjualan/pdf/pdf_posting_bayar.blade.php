
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
                            <th> Nomor </th>
                            <th> Tanggal </th>
                            <th> akun(K) </th>
                            <th> akun(D) </th>
                            <th> Keterangan </th>
                            <th> Jenis Pembayaran </th>
                            <th> jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dat1 as $index=>$val)
                        <tr>
                          <td>{{ $index+1 }}</td>
                          <td>{{ $dat1[$index][0]->nomor }}</td>
                          <td>{{ $dat1[$index][0]->tanggal }}</td>
                          <td>{{ $dat1[$index][0]->kode_akun_kredit }}</td>
                          <td>{{ $dat1[$index][0]->kode_akun_debet }}</td>
                          <td>{{ $dat1[$index][0]->keterangan }}</td>
                          <td>{{ $dat1[$index][0]->jenis_pembayaran }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->jumlah,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
