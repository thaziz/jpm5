<h3>Tabel Detail Ikhtisar Kas</h3>
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
        @if ($jenis != 'BONSEM')
          <tbody class="">
            @foreach($cari as $i=>$val)
            <tr>
              <td align="center">
                <input type="checkbox" name="checker[]" class="ck" onchange="ck()">
                <input type="hidden" name="id[]" class="id_table" value="{{$val->nota}}">
              </td>
              <td><?php echo date('d/m/Y',strtotime($val->tanggal));?></td>
              <td>{{$val->nota}}</td>
              <td>
                <ul>
                  @foreach($detail[$i] as $a=>$val2)
                    <li>{{ $detail[$i][$a] }}</li>
                  @endforeach
                </ul>
              </td>
              <td align="right">{{'' . number_format(round($val->nominal),2,',','.')}}
                <input type="hidden" name="nominal[]" class="nominal" value="{{round($val->nominal)}}">
              </td>
              <td>{{$val->keterangan}}</td>
              <td>{{$val->user}}</td>
            </tr>
            @endforeach
          </tbody>  
        @else
          <tbody class="">
            @foreach($cari as $val)
            <tr>
              <td align="center">
                <input type="checkbox" name="checker[]" class="ck" onchange="ck()">
                <input type="hidden" name="id[]" class="id_table" value="{{$val->nota}}">
              </td>
              <td><?php echo date('d/m/Y',strtotime($val->tanggal));?></td>
              <td>{{$val->nota}}</td>
              <td>{{$val->akun_kas}}</td>
              <td align="right">{{'' . number_format(round($val->nominal),2,',','.')}}
                <input type="hidden" name="nominal[]" class="nominal" value="{{round($val->nominal)}}">
              </td>
              <td>{{$val->keterangan}}</td>
              <td>{{$val->user}}</td>
            </tr>
            @endforeach
          </tbody>
        @endif
          
    </table>
<script type="text/javascript">

  
  var tabel_patty = $('.tabel_patty_cash').DataTable({
    'searching':true
  })

  
  $('.parent_check').change(function(){
    console.log($(this).is(':checked'));
    if ($(this).is(':checked') == true) {
      tabel_patty.$('.ck').prop('checked',true);
      ck();
    }else{
      tabel_patty.$('.ck').prop('checked',false);
      ck();
    }
  })
</script>