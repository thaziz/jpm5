@extends('main')

@section('title', 'dashboard')

@section('content')


 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Master Barang</h2>
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
                            <strong> Create Master Barang </strong>
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
                    <h5>  Master Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                       
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
                            <td width="150px">
                              Kode Barang
                            </td>
                            <td>
                              <input type="text" class="form-control">
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
                               <input type="text" class="form-control">
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
                              <input type="text" class="form-control">
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
                               <input type="text" class="form-control">
                            </td>
                          </tr>

                          <tr>
                          <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td>  Pemilik Lama </td>
                            <td>   <input type="text" class="form-control"> </td>
                          </tr>
                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="150px">
                              Kode Account
                            </td>
                            <td>
                               <input type="text" class="form-control">
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
                              <input type="text" class="form-control">
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
                                  <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div>
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
                              <input type="text" class="form-control">
                            </td>
                          </tr>


                          </table>

                         </div>
                  </div>

                  <hr>

                  <div class="box-body">
                    <div class="row">
                       <div class="col-xs-6">
                          <table border="0">
                          <tr>
                            <td width="150px">
                            No Polisi
                            </td>
                            <td>
                               <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                   <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                  <input type="text" class="form-control">
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
                                  <input type="text" class="form-control">
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
                                  <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                  <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                  <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                 <input type="text" class="form-control">
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
                                <input type="text" class="form-control">
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
                                <input type="text" class="form-control">
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
                                    <input type="text" class="form-control">
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
                                <input type="text" class="form-control">
                            </td>
                          </tr>
                          </table>
                    </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                      <a class="btn btn-danger" href="{{url('masterbarang/masterbarang')}}"> Batal </a>
                      <a class="btn btn-success"> Simpan </a>
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
