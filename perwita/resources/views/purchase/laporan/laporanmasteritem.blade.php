@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Master Item </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Master Item </strong>
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
                    <h5> Laporan Master Item
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                   
                <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> JL. KARAH AGUNG NO 45 SURABAYA
                </h3>

                  <hr>
                  
                  <div class="row"> &nbsp; &nbsp; 
                    <a class="btn btn-info" href="{{ route('masterItem.ViewReport') }}">
                        <i class="fa fa-print" aria-hidden="true"></i> Cetak 
                    </a> 
                  </div>

                   <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th width="50">NO</th>
                        <th width="50"> Kode </th>
                        <th> Nama  Item </th>
                        <th>  Group </th> 
                        <th> Satuan </th>   
                        <th> Acc Stock </th>
                        <th> Acc HP </th>                
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                      @foreach ($array as $index => $element)
                        <tr>
                          <td>{{ $index+1 }}</td>
                          <td align="center">{{ $element->kode_item }}</td>
                          <td align="center">{{ $element->nama_masteritem }}</td>
                          <td align="center">{{ $element->groupitem }}</td>
                          <td align="center">{{ $element->unitstock }}</td>
                          <td align="center">{{ $element->acc_persediaan }}</td>
                          <td align="center">{{ $element->acc_hpp }}</td>
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
 
   

</script>
@endsection
