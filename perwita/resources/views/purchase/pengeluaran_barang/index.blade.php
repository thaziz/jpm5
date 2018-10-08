@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pengeluaran Barang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Pengeluaran Barang  </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Pengeluaran Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                   <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('pengeluaranbarang/createpengeluaranbarang')}}"> <i class="fa fa-plus"> Tambah Data Pengeluaran Barang </i> </a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
                          <div class="row" >
                             <form method="post" id="dataSeach">
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                        <div class="col-md-2 col-sm-3 col-xs-12">
                                          <label class="tebal">No BPPB</label>
                                        </div>

                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                          <div class="form-group">
                                              <input class="form-control kosong" type="text" name="nobppb" id="nobppb" placeholder="No BPPB">
                                          </div>
                                        </div>

                                        <div class="col-md-1 col-sm-3 col-xs-12">
                                          <label class="tebal">Tanggal</label>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12">
                                          <div class="form-group">
                                            <div class="input-daterange input-group">
                                              <input id="tanggal1" class="form-control input-sm datepicker2" name="tanggal1" type="text">
                                              <span class="input-group-addon">-</span>
                                              <input id="tanggal2" "="" class="input-sm form-control datepicker2" name="tanggal2" type="text">
                                            </div>
                                          </div>
                                        </div>


                                        <div class="col-md-2 col-sm-6 col-xs-12" align="center">
                                          <button class="btn btn-primary btn-sm btn-flat" title="Cari rentang tanggal" type="button" onclick="cari()">
                                            <strong>
                                              <i class="fa fa-search" aria-hidden="true"></i>
                                            </strong>
                                          </button>
                                          <button class="btn btn-info btn-sm btn-flat" type="button" title="Reset" onclick="resetData()">
                                            <strong>
                                              <i class="fa fa-undo" aria-hidden="true"></i>
                                            </strong>
                                          </button>
                                        </div>
                                </div>
                              </form>
                          </div>
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">

                </div>

                <div class="box-body">

                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th  style="width:10px; text-align: center;">No</th>
                        <th style="text-align: center;"> No BPPB </th>
                        <th style="text-align: center;"> Tanggal </th>
                        <th style="text-align: center;"> Keperluan  </th>
                        <th style="text-align: center;"> Status  </th>
                        <th style="text-align: center;"> Detail </th>
                      </tr>
                    </thead>
                    <tbody id="showdata">
                    @foreach($data as $i => $val )
                      <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$val->pb_nota}}</td>
                        <td>{{$val->pb_tgl}}</td>
                        <td>{{$val->pb_keperluan}}</td>
                        @if($val->pb_status == 'Approved')
                        <td align="center"><label class="label label-primary">Approved</label></td>
                        @else
                        <td align="center"><label class="label label-default">Released</label></td>
                        @endif
                        @if($val->pb_status != 'Approved')
                        <td align="center">
                          <a class="btn btn-success" href={{url('pengeluaranbarang/edit')}}/{{$val->pb_id}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                          <a class="btn btn-success" href={{url('pengeluaranbarang/hapus')}}/{{$val->pb_id}}><i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </td>
                        @else
                         <td align="center">
                          -
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
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

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=field-'+$no+'> <td> <b>' + $no +' </b> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]">  <option value=""> -- Pilih Data Barang -- </option> <option value="">  Barang 1 </option> <option value="">  Barang 2 </option> </td> <td> </td>  <td> </td> <td> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option> </td> <td> 3000 </td> <td> <button class="btn btn-danger remove-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button> </td> </tr>');



      $(document).on('click','.remove-btn',function(){
              var id = $(this).data('id');
              var parent = $('#field-'+id);

              parent.remove();
          })
    })

      $('#tmbh_supplier').click(function(){
            $no++;
        $("#addColumn").append('<tr id=supp-'+$no+'> <td> <b>  </b> </td> <td> </td> <td> </td>  <td> </td> <td> </td><td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option>  </td> <td> 3000 </td> <td> <button class="btn btn-danger removes-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button>  </td> </tr>');


        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#supp-'+id);

             parent.remove();
          })
     })

     function resetData(){
       $('#tanggal1').val('');
       $('#tanggal2').val('');
      dateAwal();
      window.location.reload();
    }

    dateAwal();
    function dateAwal(){
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      });
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",
            autoclose: true,
      });
    }

    function cari(){
      var html = '';
      var status = '';
      var detail = '';
      $.ajax({
        type: 'get',
        data: $('#dataSeach').serialize(),
        dataType: 'json',
        url: baseUrl + '/pengeluaranbarang/pengeluaranbarang/cari',
        success : function(response){
          for (var i = 0; i < response.length; i++) {
            if (response[i].pb_status == 'Approved') {
              status = '<label class="label label-primary">Approved</label>';
            } else {
              status = '<label class="label label-default">Released</label>';
            }

            if (response[i].pb_status != 'Approved') {
              detail = '<a class="btn btn-success" href={{url('pengeluaranbarang/edit')}}/'+response[i].pb_id+'><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>'+
                        ' '+
                        '<a class="btn btn-success" href={{url('pengeluaranbarang/hapus')}}/'+response[i].pb_id+'><i class="fa fa-trash" aria-hidden="true"></i> </a>';
            } else {
              detail = '-';
            }

            html += '<tr>'+
              '<td>'+(i + 1)+'</td>'+
              '<td>'+response[i].pb_nota+'</td>'+
              '<td>'+response[i].pb_tgl+'</td>'+
              '<td>'+response[i].pb_keperluan+'</td>'+
              '<td align="center">'+status+'</td>'+
              '<td align="center">'+detail+'</td>'+
            '</tr>';
          }
          $('#showdata').html(html);
        }
      });
    }

</script>
@endsection
