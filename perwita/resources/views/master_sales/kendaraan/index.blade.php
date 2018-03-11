@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> KETERANGAN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Bersama</a>
                        </li>
                        <li class="active">
                            <strong> KETERANGAN </strong>
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
                    <h5 style="margin : 8px 5px 0 0"> KENDARAAN
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th> Nopol</th>
                                <th> Tipe </th>
                                <th> GPS </th>
                                <th> Cabang </th>
                                <th> Status </th>
                                <th style="width:12%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->nopol }}</td>
                                <td>{{ $row->tipe_angkutan }}</td>
                                <td>{{ $row->gps }}</td>
                                <td>{{ $row->nama_cabang }}</td>
                                <td>{{ $row->status }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('master_sales/kendaraan_form/'.$row->id.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('master_sales/kendaraan/'.$row->id.'/hapus_data') }}" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
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
    $(document).ready( function () {
        $('#tabel_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
      });
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/master_sales/kendaraan_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $(document).on( "click",".btnhapus", function(){
        if(!confirm("Hapus Data ?")) return false;
    });


</script>
@endsection
