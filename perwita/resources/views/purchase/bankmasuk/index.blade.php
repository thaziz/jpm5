  @extends('main')

@section('title', 'dashboard')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Bank Masuk </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Bank Masuk </a>
                        </li>
                        <li class="active">
                            <strong> Bank Masuk </strong>
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
        <h2 style='text-align:center'> <b> {{$data['belumdiproses']}} DATA </b></h2> <h4 style='text-align:center'> Belum di proses  </h4>
      </div>
    </div>

     <div class="col-md-2" style="min-height: 100px">
      <div class="alert alert-success alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
      <h2 style='text-align:center'> <b> {{$data['sudahdiproses']}} DATA  </b></h2> <h4 style='text-align:center'> Sudah di proses </h4>
      </div>
    </div>


    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Daftar Bank Masuk
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
                        <th> Nota Bank Masuk </th>
                        <th> Nota Transaksi </th>
                        <th> Bank Asal </th>
                        <th> Bank Tujuan </th>
                        <th> Nominal </th>
                        <th> Jenis Bayar </th>
                        <th> No Seri Transaksi </th>
                        <th> Status </th>
                        <th> Aksi </th>
                        <th> Lihat Jurnal </th>
                       
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['bankmasuk'] as $key=>$bankmasuk)
                        <tr>
                        <td> {{$key + 1}} </td>
                        <td> @if($bankmasuk->bm_nota != '')
                                {{$bankmasuk->bm_nota}}
                            @else
                                -
                            @endif
                        </td>
                        <td> {{$bankmasuk->bm_notatransaksi}} </td>
                        <td> {{$bankmasuk->bm_bankasal}} </td>
                        <td> {{$bankmasuk->bm_banktujuan}} </td>
                        <td> {{number_format($bankmasuk->bm_nominal ,2)}} </td>
                        <td> {{$bankmasuk->bm_jenisbayar}} </td>
                        <td> {{$bankmasuk->bm_transaksi}}</td>
                        <td> {{$bankmasuk->bm_status}}</td>
                        <td> <a class="btn btn-success btn-sm"> <i class="fa fa-book"> </i> PROSES </a> </td>
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
