@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Pengeluaran Barang </h2>
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
                            <strong>Konfirmasi Pengeluaran Barang  </strong>
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
                </div>
                <div class="ibox-content">
                        <div class="row">
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
                    <tbody>  
                    @foreach($data as $i => $val )                  
                      <tr>
                        <td align="center">
                          {{$i+1}}
                          <input type="hidden" class="pb_id" value="{{$val->pb_id}}">
                        </td>
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
                          <a title="detail" class="btn btn-success btn-sm" href={{url('konfirmasipengeluaranbarang/detailkonfirmasipengeluaranbarang')}}/{{$val->pb_id}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                        </td>
                      </tr>
                      @else
                      <td align="center"> 
                          <a class="btn btn-success btn-sm" onclick="printing(this)" )}}/{{$val->pb_id}}><i class="fa fa-print" aria-hidden="true"></i> </a>
                      </td>
                      @endif
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
    

function printing(){
  var id = $('.pb_id').val();
  window.open("{{url('konfirmasipengeluaranbarang/printing')}}"+'/'+id)
}
</script>
@endsection
