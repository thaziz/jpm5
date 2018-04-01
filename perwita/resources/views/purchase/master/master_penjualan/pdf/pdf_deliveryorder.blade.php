
<style>
  .pembungkus{
    width: 900px;
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
                            <th> No DO</th>
                            <th> Tanggal </th>
                            <th> Pengirim </th>
                            <th> Penerima </th>
                            <th> Kota Asal </th>
                            <th> Kota Tujuan </th>
                            <th> Status </th>
                            <th> Tarif </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                        <tr>
                           <td>{{ $row->nomor }}</td>
                            <td>{{ $row->tanggal }}</td>
                            <td>{{ $row->nama_pengirim }}</td>
                            <td>{{ $row->nama_penerima }}</td>
                            <td>{{ $row->asal }}</td>
                            <td>{{ $row->tujuan }}</td>
                            <td>{{ $row->status }}</td>
                            <td>{{ $row->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                  </table>



</div>
<script type="text/javascript">
    window.print();
</script>
