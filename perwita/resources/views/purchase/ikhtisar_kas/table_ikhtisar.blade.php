<h3>Tabel Detail Patty Cash</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_patty_cash">
          <thead align="center">
            <tr>
            <th>Pilih</th>
            <th>Tanggal</th>
            <th>No Ref</th>
            <th>Akun Biaya</th>
            <th>Nominal</th>
            <th>Keterangan</th>
            <th>User ID</th>
            </tr>
          </thead> 
          <tbody class="">
            @foreach($cari as $val)
            <tr>
              <td align="center">
                <input type="checkbox" name="checker[]" class="ck" >
                <input type="hidden" name="id[]" class="id_table" value="{{$val->pc_id}}">
              </td>
              <td><?php echo date('d/m/Y',strtotime($val->pc_tgl));?></td>
              <td>{{$val->pc_no_trans}}</td>
              <td>{{$val->pc_akun}}</td>
              @foreach($akun as $d)
              @if($d->id_akun == $val->pc_akun)
              <td>{{$val->pc_debet}}</td>
              @endif
              @endforeach
              <td>{{$val->pc_keterangan}}</td>
              <td>{{$val->pc_user}}</td>
            </tr>
            @endforeach
          </tbody>    
      </table>
<script type="text/javascript">
  var tabel_patty = $('.tabel_patty_cash').DataTable({
    'searching':false
  })
</script>