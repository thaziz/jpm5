<table class="table table-stripped tabel_tt_penerus table-hover">
  <thead>
    <tr>
      <th>No</th>
      <th>Pihak Ketiga</th>
      <th>Nota TT</th>
      <th>Tgl Kembali</th>
      <th>No Invoice</th>
      <th>Nominal</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $i => $val)
      <tr onclick="select_tt(this)">
        <td>
          {{ $i+1 }}
          <input type="hidden" class="tt_id" value="{{ $val->tt_idform }}" name="">
          <input type="hidden" class="tt_dt" value="{{ $val->ttd_detail }}" name="">
        </td>
        <td>{{ $val->tt_supplier }}</td>
        <td class="tt_form">{{ $val->tt_noform }}</td>
        <td>{{ $val->tt_tglkembali }}</td>
        <td class="tt_invoice">{{ $val->ttd_invoice }}</td>
        <td>{{number_format($val->ttd_nominal,0,",",".")}}</td>
      </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">
var tabel_tt_penerus = $('.tabel_tt_penerus').DataTable();
</script>