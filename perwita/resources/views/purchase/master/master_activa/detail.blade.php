@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Activa </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Activa</a>
                        </li>
                        <li class="active">
                            <strong> Detail Master Activa </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
         <div class="row">
      <div class="col-xs-12">

            <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Detail Master Activa </a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2"> Detail Garis Lurus </a></li>
                            <li class=""><a data-toggle="tab" href="#tab-"> Detail Komersial Saldo Menurun </a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                   <table id="addColumn" class="table table-bordered table-striped tbl-item">
                                      <thead>
                                          <tr>
                                               <th style="width:10px">No Nota</th>
                                                <th> Kode Activa </th>
                                                <th> Kode Barang </th>
                                                <th> Nama </th>
                                                <th> Tanggal </th>
                                                <th> Nilai </th>       
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td> ACTIVA1 </td>
                                              <td> ACTIVA1 </td>
                                              <td> ACTIVA1 </td>
                                              <td>Mobil Mobilan</td>
                                              <td>  11 Juni 2012  </td>
                                              <td>  1.000.0000  </td>
                                          </tr>
                           <tr>
                            <td>
                            AD-002
                            </td>
                            <td>
                              ACTIVA1
                            </td>
                            <td>
                              J-00007
                            </td>
                            <td>
                            </td>
                            <td>
                              11 Juni 2007
                            </td>
                            <td>
                              Rp 5.820.000
                            </td>
                           </tr>


                          </tbody>
                         
                        </table>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                   <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> Bulan </th>
                        <th> Susut </th>
                        <th> Akum. Susut </th>
                        <th> Nilai </th>                                           
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                    <tr>
                      <td> 1 </td>
                      <td> 11 Juli 2009 </td>
                      <td> 93.031.35 </td>
                      <td> 96.031.35 </td>
                      <td> 9.122.978.65  </td>
                    </tr>
                    <tr>
                      <td> 2 </td>
                      <td> 11 Agustus 2009 </td>
                      <td> 93.031.35 </td>
                      <td> 96.031.35 </td>
                      <td> 9.122.978.65  </td>
                    </tr>

                    </tbody>
                   
                  </table>
                                </div>
                            </div>

                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                      <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px">Bulan ke</th>
                        <th> Bulan  </th>
                        <th> Nilai </th>
                                           
                    </tr>
                 
                    </thead>
                    
                    <tbody>
                    <tr>
                      <td> 1 </td>
                      <td> 11/Juli/2009 </td>
                      <td> 8.758.059.50 </td>
                     
                    </tr>

                    <tr>
                      <td> 2 </td>
                      <td> 11/Agustus/2009 </td>
                      <td> 8.659.059.50 </td>
                    </tr>
                   

                    </tbody>
                   
                  </table>
                                </div>
                            </div>
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
