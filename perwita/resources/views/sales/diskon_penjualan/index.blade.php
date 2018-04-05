@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Tambah Data Diskon Penjualan </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Sales</a>
            </li>
            <li class="active">
                <strong> Diskon Penjualan </strong>
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
                    <h5> Diskon Penjualan
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                   <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"></i> Tambah Data Diskon</a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
           
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="get">
                  <div class="box-body">
                </div>        
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-diskonpenjualan">
                    <thead>
                     <tr>
                        <th style="width:5%">NO</th>
                        <th> Cabang </th>
                        <th> Max Diskon </th>
                        <th> Oleh </th>
                        <th> Aksi </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $index=>$data)
                        <tr>
                          <td>{{ $index + 1 }}</td>
                          <td>{{ $data->nama }}</td>
                          <td>{{ $data->dc_diskon }}</td>
                          <td>{{ $data->m_name }}</td>
                          <td></td>
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

<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                {{-- <i class="fa fa-laptop modal-icon"></i> --}}
                <h4 class="modal-title">Tambah Data Diskon Penjualan</h4>
                <small class="font-bold">Data diskon ini digunakan untuk membatasi pemberian diskon pada setiap cabang.</small>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">
                  <tr>
                    <td class=""><strong>Cabang</strong></td>
                    <td colspan="5">
                        <select class="form-control chosen-select-width"  name="cb_cabang" style="width:100%" id="cb_cabang">
                            <option value=""></option>
                        @foreach ($cabang as $row)
                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                        @endforeach
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <td class=""><strong>Diskon</strong></td>
                    <td colspan="5">
                        <input class="form-control" id="demo1" type="text" value="55" name="demo1">
                    </td>
                  </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                <button class="ladda-button ladda-button-demo btn btn-primary"  data-style="zoom-in">Submit</button>
            </div>
        </div>
    </div>
</div>


<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
$(document).ready( function () {
    var tableDetail = $('.tbl-diskonpenjualan').DataTable({
        responsive: true,
        searching: true,
        "pageLength": 10,
        "language": dataTableLanguage,
        "columnDefs": [ {
          "targets"  : [4],
          "orderable": false,
        }]
    });
    $("input[name='demo1']").TouchSpin({
        min: 0,
        max: 100,
        step: 5,
        boostat: 5,
        maxboostedstep: 10,
        postfix: '%'
    });
});

function tambah(){

}
</script>
@endsection
