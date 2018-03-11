@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Voucher Hutang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Voucher Hutang </strong>
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
                    <h5> Voucher Hutang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('voucherhutang/createvoucherhutang')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
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
                        <th style="width:10px">NO</th>
                        <th> No Bukti </th>
                        <th> Tanggal </th>
                        <th> Supplier </th>
                        <th> Keterangan </th> 
                        <th> Jatuh Tempo </th>
                        <th> Aksi  </th>
                    </tr>
                    </thead>
                   
                    <tbody>
                       @foreach($data as $index => $a)
                      <tr>
                        <td> {{$index+1}} </td>
                        <td>  {{$a->v_nomorbukti}}  </td>
                        <td>  {{$a->v_tgl}} </td>
                        <td> {{$a->v_supid}} </td>
                        <td> {{$a->v_keterangan}} </td>
                        <td> {{$a->v_tempo}} </td>
                        <td>
                          <a href="editvoucherhutang/{{$a->v_id}}"><i class="btn btn-primary fa fa-cog "></i></a>
                          <a href="hapusvoucherhutang/{{$a->v_id}}"><i class="btn btn-danger fa fa-trash "></i></a>
                          <a href="detailvoucherhutang/{{$a->v_id}}"><i class="btn btn-info fa fa-arrow-right "></i></a>
                          <a href="print_voucherhutang/{{$a->v_id}}"><i class="btn btn-success fa fa-print"></i></a>
                        </td>
                      </tr>
                      @endforeach
                      <!-- <tr> <td rowspan="4"> 1 </td> <td rowspan="4"> </td> <td rowspan="4"> </td> <td> halo </td> <td> halo </td> <td> halo </td> <tr> <td> halo </td> <td> halo </td> <td> halo </td> </tr> <tr> <td> halo </td> <td> halo</td><td> halo</td>
                      </tr> -->
                    </tbody>
                    
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                 
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
    
    

</script>
@endsection
