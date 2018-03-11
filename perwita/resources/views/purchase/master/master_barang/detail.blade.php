@extends('main')

@section('title', 'dashboard')

@section('content')


 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Barang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Detail Master Barang </strong>
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
                    <h5> Detail Master Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                        <div class="text-right">
                       <a class="btn btn-danger" aria-hidden="true" href="{{ url('masterbarang/masterbarang')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    

                    <hr>
                    
                    <h4> Daftar Detail Master Barang </h4>

                  
                    <hr>
                    
                <div class="box-body">
                  <div class="row">
                     <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="100px">
                              Kode Barang
                            </td>
                            <td>
                              K-0078
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>  Nama Barang  </td>
                            <td>
                            
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Nama Pemilik </td>
                             <td>
                              Indri Wijayanti
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Cara Perolehan </td>
                            <td>
                              
                            </td>
                          </tr>

                          <tr>
                          <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td>  Pemilik Lama </td>
                            <td>  </td>
                          </tr>
                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="100px">
                              Kode Account
                            </td>
                            <td>

                             </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>  Jenis Activa  </td>
                            <td>
                              Kendaraan
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Tanggal Perolehan </td>
                             <td>

                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Keadaan </td>
                            <td>
                              
                            </td>
                          </tr>


                          </table>

                         </div>



                  </div>

                    <hr>
                      <h4>      Detail Kendaraan </h4>
                    <hr>

                    <div class="row">
                       <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="150px">
                            No Polisi
                            </td>
                            <td>
                                G 1556 PE
                             </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>  Nomor Rangka  </td>
                            <td>
                              4034T
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Nomor Mesin </td>
                             <td>
                                4034
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Merk </td>
                            <td>
                              Mitsubishi
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Type </td>
                            <td>
                              FE71 MT
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Jenis  </td>
                            <td>
                              Mob Barang
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Model </td>
                            <td>
                              Light Truck
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Tahun Pembuatan </td>
                            <td>
                              2010
                             </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Tahun Perakitan </td>
                            <td>
                              2010
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Warna </td>
                            <td>
                              Kuning
                            </td>
                          </tr>


                          </table>

                         </div>


                         <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="150px">
                            Nomor Register
                            </td>
                            <td>
                              R/9952
                             </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>  Nomor BPKB  </td>
                            <td>
                              F 8600219 i
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Bahan Bakar </td>
                             <td>
                                SOLAR
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Jumlah Roda </td>
                            <td>
                              4
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Nomor STNK </td>
                            <td>

                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Isi Silinder  </td>
                            <td>
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Warna TNKB </td>
                            <td>
                             </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Berat yang boleh </td>
                            <td>

                             </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                           <tr>
                            <td> Nomor Polisi Lama </td>
                            <td>
                              G 1556 PE
                            </td>
                          </tr>


                         


                          </table>

                         </div>

                    </div>

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
