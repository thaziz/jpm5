<table id="table_data_do" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
           <th>Nomor Invoice</th>
           <th>Tanggal</th>
           <th>Customer</th>
           <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
      @foreach($data as $val)
      <tr onclick="pilih_invoice(this)">
        <td><a class="invoice_nomor">{{$val->i_nomor}}</a></td>
        <td>{{$val->i_tanggal}}</td>
        <td>{{$val->nama}}</td>
        <td style="text-align: right">{{number_format($val->i_total_tagihan, 2, ",", ".")}}</td>
      </tr>
      @endforeach
    </tbody>
</table>