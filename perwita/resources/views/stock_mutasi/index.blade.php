@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Mutasi Stock </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a>Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong>Mutasi Stock</strong>
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
                    <h5> Stock Mutasi
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
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
                
                  <table id="addColumn" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="text-align: center;"> Nama Item</th>
                        <th style="text-align: center;"> Tanggal </th>
                        <th style="text-align: center;"> Keterangan </th>
                        <th style="text-align: center;"> Qty </th>
                        <th style="text-align: center;"> SPPTB </th>
                        <th style="text-align: center;"> LPB </th>
                      </tr>
                    </thead>
                    <tbody>               
                      @foreach($dataku as $val)
                        <tr>
                          <td>{{$val->nama_masteritem}}</td>
                          <td>{{ Carbon\Carbon::parse($val->sm_date)->format('d-M-Y H:i:s') }}</td>
                          <td>{{$val->keterangan}}</td>
                          <td>{{$val->sm_qty}}</td>
                            @if($val->sm_spptb == null)
                              <td> - </td>
                            @else
                              <td>{{$val->sm_spptb}}</td>
                            @endif

                            @if($val->sm_lpb == null)
                              <td> - </td>
                            @else
                              <td>{{$val->sm_lpb}}</td>
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

<style  rel="stylesheet" type="text/css">

select.input-sm {
    height: 35px;
    line-height: 30px;
}

</style>

<script type="text/javascript">

$('#addColumn').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "order": [[ 2, "desc" ]],
            "columns": [
            { "data": "nama_masteritem" },
            { "data": "sm_date" },
            { "data": "keterangan" },
            { "data": "sm_qty" },
            { "data": "sm_spptb" },
            { "data": "sm_lpb" },
            ]
      });


</script>
@endsection
