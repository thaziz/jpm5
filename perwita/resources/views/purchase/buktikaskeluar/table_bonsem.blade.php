<table class="table table-bordered table-hover bonsem">
  <caption>Pilih Untuk</caption>
  <thead>
    <tr >
      <th>No Bonsem</th>
      <th>Tanggal</th>
      <th>Total Bonsem</th>
      <th>Sisa Bonsem</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($bonsem as $val)
      <tr onclick="pilih_bonsem(this)" style="cursor: pointer;">
        <td>
          {{ $val->bp_nota }}
          <input type="hidden" value="{{ $val->bp_nota }}" class="bp_nota">
        </td>
        <td>{{ $val->bp_tgl }}</td>
        <td>{{ number_format($val->bp_nominalkeu, 0, ",", ".")}}</td>
        <td>
          {{ number_format($val->bp_sisapemakaian, 0, ",", ".")}}
          <input type="hidden" value="{{ round($val->bp_sisapemakaian) }}" class="bp_sisa">
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

<script type="text/javascript">
  $('.bonsem').DataTable();
</script>