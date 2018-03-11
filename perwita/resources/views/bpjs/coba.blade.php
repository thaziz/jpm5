@extends('main')

@section('title', 'dashboard')
<style type="text/css">
@import url('//cdn.datatables.net/1.10.2/css/jquery.dataTables.css');
 td.details-control {
    background: url('http://www.datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('http://www.datatables.net/examples/resources/details_close.png') no-repeat center center;
}
</style>

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Daftar BPJS 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="#">
                <div class="box-body table-responsive">
                 <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>NO URUT</th>
                                <th>NIK</th>
                                <th>NOMOR PESERTA</th>
                                <th>NAMA LENGKAP</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr data-child-tgl="7 April 1999" data-child-jkel="P" data-child-upah="7000.000">
                                <td class="details-control"></td>
                                <td>1.</td>
                                <td>999988</td>
                                <td>123456</td>
                                <td>Nivada Mayang</td>
                            </tr>
                             <tr data-child-tgl="10 April 1999" data-child-jkel="L" data-child-upah="1000.000">
                                <td class="details-control"></td>
                                <td>2.</td>
                                <td>999977</td>
                                <td>1234567</td>
                                <td>xlayword</td>
                            </tr>
                             <tr data-child-tgl="20 April 1999" data-child-jkel="L" data-child-upah="1000.000">
                                <td class="details-control"></td>
                                <td>3.</td>
                                <td>999977</td>
                                <td>1234567</td>
                                <td>vanasta</td>
                            </tr>
                        </tbody>
                </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                      <input type="submit" id="submit" name="submit" value="Print" class="btn btn-info" onclick="window.open('cetak_daftarbpjs')">
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
     function format(tgl , jkel , upah) {
      // return '<div>Tanggal Lahir: ' + tgl + '<br />Jenis Kelamin: ' + jkel +'<br />Upah Perbulan: ' + upah + '</div>';;
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Tanggal Lahir:</td>'+
            '<td>'+tgl+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Jenis Kelamin:</td>'+
            '<td>'+jkel+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Upah Perbulan:</td>'+
            '<td>'+upah+'</td>'+
        '</tr>'+
    '</table>';

     }
  $(document).ready(function () {
      var table = $('#example').DataTable({});

      // Add event listener for opening and closing details
      $('#example').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var row = table.row(tr);

          if (row.child.isShown()) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass('shown');
          } else {
              // Open this row
              row.child(format(tr.data('child-tgl'), tr.data('child-jkel'), tr.data('child-upah'))).show();
              tr.addClass('shown');
          }
      });
  });

</script>
@endsection
