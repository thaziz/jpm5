  @extends('main')

@section('title', 'dashboard')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Order </h2>
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
                            <strong> Konfirmasi Order </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>


<div class="wrapper wrapper-content animated fadeInRight">

    <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['pembelian'][0]->count}} SPP </b></h2> <h4 style='text-align:center'> Belum di proses Staff Pembelian </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['keuangan'][0]->count}} SPP  </b></h2> <h4 style='text-align:center'> Belum di proses Keuangan </h4>
      </div>
    </div>


    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Daftar Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped konfirmasi">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> No SPP </th>
                        <th> Cabang Pemohon </th>
                        <th> Tanggal di butuhkan </th>
                        <th> Status Pembelian </th>
                        <th> Status Keuangan </th>
                        <th> </th>
                       
                    </tr>
                  

                    </thead>
                    <tbody>
                    @foreach($data['co'] as $index=>$co)
                      <tr> 
                        <td> {{$index + 1}} </td>
                        <td> {{$co->spp_nospp}} </td>
                        <td> {{$co->spp_cabang}} - {{$co->nama}} </td>
                        <td>  {{ Carbon\Carbon::parse($co->spp_tgldibutuhkan)->format('d-M-Y ') }}  </td>

                          {{--   @if(Auth::user()->punyaAkses('Konfirmasi Order','ubah'))
                        <td> <a class="btn btn-xs btn-danger" href="{{url('konfirmasi_order/konfirmasi_orderdetail/'. $co->co_idspp.'')}}"> <i> Lihat Detail </i> </a> </td>
                            @endif --}}
                        <td>
                        @if(Auth::user()->punyaAkses('Konfirmasi Order','aktif'))
                          @if($co->staff_pemb == 'DISETUJUI')
                                 <a class="label label-info" href="{{url('konfirmasi_order/konfirmasi_orderdetailpemb/'. $co->co_idspp.'')}}"> {{$co->staff_pemb}} </a>   
                          @elseif($co->staff_pemb == '')
                               <a class="label label-danger" href="{{url('konfirmasi_order/konfirmasi_orderdetailpemb/'. $co->co_idspp.'')}}"> <i class="fa fa-close"> </i> BELUM DI PROSES </a> &nbsp; &nbsp;
                          @else
                            <a class="label label-warning" href="{{url('konfirmasi_order/konfirmasi_orderdetailpemb/'. $co->co_idspp.'')}}"> {{$co->staff_pemb}} </a>
                          @endif
                        @endif  
                        </td>

                        <td>
                        @if(Auth::user()->punyaAkses('Konfirmasi Order Keu','aktif'))
                          @if($co->man_keu == 'DISETUJUI')
                             <a class="label label-info"  href="{{url('konfirmasi_order/konfirmasi_orderdetailkeu/'. $co->co_idspp.'')}}"> {{$co->man_keu}} </a>       
                          @elseif($co->man_keu == '')
                              <a class="label label-danger" href="{{url('konfirmasi_order/konfirmasi_orderdetailkeu/'. $co->co_idspp.'')}}"> BELUM DI PROSES </a>
                          @else
                           <a class="label label-warning" href="{{url('konfirmasi_order/konfirmasi_orderdetailkeu/'. $co->co_idspp.'')}}"> {{$co->staff_pemb}} </a>

                          @endif
                        @endif  
                        </td>
                            <td>  <a class="btn btn-sm btn-success" href="{{url('konfirmasi_order/cetakkonfirmasi/'.$co->co_id.'')}}"> <i class="fa fa-print" aria-hidden="true"></i>  </a></td>

                      </tr>
                    @endforeach
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

    tableDetail = $('.konfirmasi').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    

</script>
@endsection
