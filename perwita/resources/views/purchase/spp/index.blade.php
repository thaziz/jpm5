@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Surat Permintaan Pembelian </h2>
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
                            <strong> Surat Permintaan Pembelian </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

  <div class="wrapper wrapper-content animated fadeInRight">
   
    <div class="col-md-2">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['belumdiproses']}} SPP </b></h2> <h4 style='text-align:center'> belum di proses Staff Pembelian </h4>
      </div>
    </div>

    <div class="col-md-2">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['disetujui']}} SPP  </b></h2> <h4 style='text-align:center'> DISETUJUI oleh Staff Keuangan </h4>
      </div>
    </div>

    <div class="col-md-2">
      <div class="alert alert-warning alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['masukgudang']}} SPP  </b></h2> <h3 style='text-align:center'> <br> MASUK GUDANG  </h3>
      </div>
    </div>
    <div class="col-md-2">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style='text-align:center'> <b> {{$data['selesai']}} SPP  </b></h2> <h3 style='text-align:center'> <br> SELESAI </h3>
      </div>
    </div>


    </div>




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('suratpermintaanpembelian/createspp')}}"> <i class="fa fa-plus"> Tambah Data Surat Permintaan Pembelian </i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
             
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                       <th style="width:10px"> No </th>
                        <th> No SPP</th>
                        <th> Tanggal di Butuhkan </th>
                        <th> Cabang </th>
                        <th> Keperluan </th>
                        <th> Bagian </th>
                        <th> Status </th>
                        <th> Detail </th>
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                    @foreach($data['spp'] as $index=>$spp)
                    <tr>
                      <td> {{$index + 1}}  </td>
                      <td> <a href="{{url('suratpermintaanpembelian/detailspp/'. $spp->spp_id .'')}}"> {{$spp->spp_nospp}} </a> </td>
                      <td> {{ Carbon\Carbon::parse($spp->spp_tgldibutuhkan)->format('d-M-Y ') }} </td>
                      <td>{{ $spp->nama }}</td>
                      <td>{{ $spp->spp_keperluan}} </td>
                      <td> {{$spp->nama_department}} </td>
                      <td><!--  {{$spp->co_mng_pem_approved}} -->

                      @if($spp->spp_status == 'DISETUJUI')
                         <span class="label label-info"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black"> --> DISETUJUI </a></span>
                      @elseif($spp->spp_status == 'DITERIMA')
                          <span class="label label-warning"><!--  <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black"> -->  DITERIMA </span>
                      @elseif($spp->spp_status == 'DITOLAK')
                            <span class="label label-danger"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black">  -->{{$spp->spp_status}} </span>
                      @else 
                            <span class="label label-default"> <!-- <a href="{{url('suratpermintaanpembelian/statuspp/'.$spp->spp_id.'')}}" stye="color:black">  -->{{$spp->spp_status}} </span>
                      @endif
                          </td>

                      <!-- <td> <a class="btn btn-success" href="{{url('suratpermintaanpembelian/detailspp/'. $spp->spp_id .'')}}"><i class="fa fa-arrow-right" aria-hidden="true"> </i> </a> -->
                      <td> <div class="row">
                      <div class="col-md-3">
                      @if($spp->spp_status == 'DITERBITKAN')
                     <a href="#" class="btn btn-sm btn-danger" onclick="hapusData('{{$spp->spp_id}}')"> <i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                          {{ Form::open(['url'=>'suratpermintaanpembelian/deletespp/'. $spp->spp_id, 'method' => 'delete', 'id' => $spp->spp_id ]) }}
                          {{ Form::close() }} </div>
                          &nbsp;
                      @endif
                          <div class="col-md-3">
                          <a class="btn btn-sm btn-success" href="{{url('suratpermintaanpembelian/createPDF/'.$spp->spp_id.'')}}"> <i class="fa fa-print" aria-hidden="true"></i>  </a>  </div> </div>
                      </td>
                      
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


    tableDetail = $('.tbl-item').DataTable({
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
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
 
      
    function hapusData(id){
   
            swal({
            title: "apa anda yakin?",
                    text: "data yang dihapus tidak akan dapat dikembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            },
                    function(){                        
                    $('#' +id).submit();
                    swal("Terhapus!", "Data Anda telah terhapus.", "success");
                    });
            }

</script>
@endsection
