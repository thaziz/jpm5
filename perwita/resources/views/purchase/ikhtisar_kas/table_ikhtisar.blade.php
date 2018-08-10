<h3>Tabel Detail Patty Cash</h3>
  <hr>
      <table class="table table-bordered table-hover tabel_patty_cash">
          <thead align="center">
            <tr>
            <th><input type="checkbox" class="parent_check"></th>
            <th>Tanggal</th>
            <th>No Ref</th>
            <th>Akun</th>
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
                <input type="hidden" name="id[]" class="id_table" value="{{$val->nota}}">
              </td>
              <td><?php echo date('d/m/Y',strtotime($val->tanggal));?></td>
              <td>{{$val->nota}}</td>
              <td>{{$val->akun_kas}}</td>
              <td align="right">{{'' . number_format(round($val->nominal),2,',','.')}}
                <input type="hidden" name="nominal[]" value="{{round($val->nominal)}}">
              </td>
              <td>{{$val->keterangan}}</td>
              <td>{{$val->user}}</td>
            </tr>
            @endforeach
          </tbody>    
      </table>
<script type="text/javascript">
  var tabel_patty = $('.tabel_patty_cash').DataTable({
    'searching':true
  })

  
  $('.parent_check').change(function(){
    console.log($(this).is(':checked'));
    if ($(this).is(':checked') == true) {
      tabel_patty.$('.ck').prop('checked',true);
    }else{
      tabel_patty.$('.ck').prop('checked',false);
    }
  })
</script>