
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
                            <th> Pengirim </th>
                            <th> Alamat Pengirim </th>
                            <th> Pengirim </th>
                            <th> Alamat Pengirim </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Status </th>
                            <th> Dasar </th>
                            <th> Penerus </th>
                            <th> Tambahan </th>
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
                          <td>{{ $dat1[$index][0]->nama_pengirim }}</td>
                          <td>{{ $dat1[$index][0]->alamat_pengirim }}</td>
                          <td>{{ $dat1[$index][0]->nama_penerima }}</td>
                          <td>{{ $dat1[$index][0]->alamat_penerima }}</td>
                          <td>{{ $dat1[$index][0]->asal }}</td>
                          <td>{{ $dat1[$index][0]->tujuan }}</td>
                          <td>{{ $dat1[$index][0]->status }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->tarif_dasar,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->tarif_penerus,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->biaya_tambahan,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->diskon,0,',','.') }}</td>
                          <td align="right">{{ number_format( $dat1[$index][0]->total,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
