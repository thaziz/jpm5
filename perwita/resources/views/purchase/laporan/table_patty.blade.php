<h3> &nbsp;</h3>
                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

      <table id="addColumn" class="table table-bordered table-hover tabel_patty_cash">
          <thead align="center">
            <tr>
            <th>Tanggal</th>
            <th>Ref</th>
            <th>Akun Biaya</th>
            <th>Nama Akun</th>
            <th>Catatan</th>
            <th>Debet</th>
            <th>Kredit</th>
            <th>User ID</th>
            </tr>
          </thead> 
          <tbody class="">
            @foreach($cari as $val)
            <tr>
              <td><?php echo date('d/m/Y',strtotime($val->pc_tgl));?></td>
              <td>{{$val->jenisbayar}}</td>
              <td>{{$val->pc_akun}}</td>
              @foreach($akun as $d)
              @if($d->id_akun == $val->pc_akun)
              <td>{{$d->nama_akun}}</td>
              @endif
              @endforeach
              <td>{{$val->pc_keterangan}}</td>
              <td align="right">{{$val->pc_debet}}</td>
              <td align="right">{{$val->pc_kredit}}</td>
              <td>{{$val->pc_user}}</td>
            </tr>
            @endforeach
           
            
          </tbody>    
      </table>
<script type="text/javascript">
 
    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';

  $('#addColumn').DataTable({
    paging:true,
       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN PATTY CASH',
                filename:'PATTYCASH-'+a+b+c,
                init: function(api, node, config) {
                $(node).removeClass('btn-default'),
                $(node).addClass('btn-warning'),
                $(node).css({'margin-top': '-45px','margin-left': '80px'})
                },
                exportOptions: {
                modifier: {
                    page: 'all'
                }
            }
            
            }
        ]
  });

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(2).search(
        $('#col0_filter').val()
    ).draw();    
} 


</script>