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
                        <th> Aksi </th>
                        <th> Mng Umum Status </th>
                        <th> Staff Pembelian </th>
                        <th> Mng Pembelian </th>
                       
                    </tr>
                  

                    </thead>
                    <tbody>
                    @foreach($data['co'] as $index=>$co)
                      <tr> 
                        <td> {{$index + 1}} </td>
                        <td> {{$co->spp_nospp}} </td>
                        <td> {{$co->spp_cabang}} </td>
                        <td>  {{ Carbon\Carbon::parse($co->spp_tgldibutuhkan)->format('d-M-Y ') }}  </td>

                        <td> <a class="btn btn-xs btn-danger" href="{{url('konfirmasi_order/konfirmasi_orderdetail/'. $co->co_idspp.'')}}"> <i> Lihat Detail </i> </a> </td>
                     <!--    
                        <td> {{$co->mng_umum_approved}} </td>
                        <td> {{$co->co_staffpemb_approved}}  </td>
                        <td> {{$co->co_mng_pem_approved}} </td> -->

                         @if($co->mng_umum_approved == 'BELUM DI SETUJUI')
                          <td> <span class="label label-info"> {{$co->mng_umum_approved}} </span> </td>
                         @else
                          <td> <span class="label label-warning"> {{$co->mng_umum_approved}} </span> </td>
                         @endif

                          @if($co->co_staffpemb_approved == 'BELUM DI SETUJUI')   
                          <td> <span class="label label-info"> {{$co->co_staffpemb_approved}} </span>  </i></td>
                          @else
                          <td> <span class="label label-warning"> {{$co->co_staffpemb_approved}} </span>  </i></td>
                          @endif


                          @if($co->co_mng_pem_approved == 'BELUM DI SETUJUI')
                                 <td> <span class="label label-info"> {{$co->co_mng_pem_approved}} </span></td>     
                          @else
                            <td> <span class="label label-warning"> {{$co->co_mng_pem_approved}} </span></td>
                          @endif

       

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
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> Perusahaan Cabang Nganjuk </td><td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
 
   

</script>
@endsection
