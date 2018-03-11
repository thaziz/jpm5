@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Historis Faktur Vs Pelunasan</h2>
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
                            <strong> Historis Faktur Vs Pelunasan </strong>
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
                
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                <div class="col-xs-12">
                   <table border="0">
                      <tr>
                          <td>  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#NoFaktur">
                                 <i class="fa fa-search" aria-hidden="true"></i>  Cari No Faktur
                                </button>
                          </td>

                            <td> &nbsp; &nbsp; </td>

                          <td>
                              <input type="text" class="form-control" disabled="">
                          </td>

                      </tr>
                   </table>

                    <hr>

                    <div class="row">
                        <div class="col-xs-6">
                            <h4> Master Faktur Pembelian </h4>
                            <table class="table table-bordered">
                               
                                    <tr>
                                        <th> No Faktur </th>
                                        <td colspan="3"> FB-00009/AP/07-17 </td>
                                    </tr>
                                    <tr>
                                        <th> Tanggal </th>
                                        <td>01 Juli 2017 </td>
                                        <th> Jatuh Tempo </th>
                                        <td> 31 Juli 2017 </td>
                                    </tr>
                                    <tr>
                                        <th> Supplier </th>
                                        <td> SP/EM/538</td>
                                        <td colspan="2"> JACKY JAYA, CV </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"> KARAH V / 78 RT 005 RW 005 JAMBANGAN   </td>
                                    </tr>
                                    <tr>
                                        <th> Keterangan </th>
                                        <td colspan="3"> RENOVASI GEDUNG (JPM PAKET BAWAH) JAWAPOS KARAH </td>
                                    </tr>
                                    <tr>
                                        <th> No Pajak </th>
                                        <td>  </td>
                                        <th> Tanggal </th>
                                        <td> </td>
                                    </tr>
                               
                            </table>

                            <table class="table table-bordered table-stripped">
                                <tr>
                                    <th> Seq </th>
                                    <th> Kode Item </th>
                                    <th> Update Stock </th>
                                    <th> Quantity </th>
                                </tr>

                                <tr>
                                    <td> 1 </td>
                                    <td> B-00001 </td>
                                    <td> T </td>
                                    <td> </td>
                                </tr>
                            </table>

                            <table class="table table-bordered table-stripped">
                                <tr>
                                <th> Jumlah </th> <td colspan="2" style="text-align: right;"> Rp. 61.249.607,00 </td>
                                </tr>

                                <tr>
                                    <th> Discount </th> <td colspan="2"> </td>
                                </tr>

                                <tr>
                                    <th>  PPn </th> <td> <select class="form-control"> <option value=""> T </option> </select> </td> <td> Tanpa PPn </td>
                                </tr>
                                <tr>
                                    <th> Pajak Lain </th> <td colspan="2"> <select class="form-control">  <option value=""> Tanpa PPn </option></select> </td>
                                </tr>
                                <tr>
                                    <th> Nilai Pajak Lain </th> <td colspan="2"> </td>
                                </tr>

                                <tr>
                                    <th> Biaya - Biaya </th> <td colspan="2"> </td>
                                </tr>

                                <tr>
                                    <th> Netto </th> <td style="text-align: right"> Rp. 61.249.607,00</td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-xs-6">
                            <h4> Historis Pembayaran </h4>
                            <table class="table table-bordered">
                            <tr>
                                <th> No Bukti </th>
                                <th> Tanggal </th>
                                <th> Keterangan </th>
                                <th> Debet </th>
                                <th> Kredit </th>
                                </tr>
                                <tr>
                                    <td> FB-0009/AP/0717</td>
                                    <td> 01 Juli 2017 </td>
                                    <td> Renovasi Gedung JPM</td>
                                    <td>  </td>
                                    <td style="text-align: right"> Rp 61.249.607,00</td>
                                </tr>
                            </table>

                              <h4> Cek / BG Belum Cair </h4>

                               <table class="table table-bordered">
                               <tr>
                                  <th> No Bukti </th>
                                  <th> Tanggal </th>
                                  <th> Keterangan </th>
                                  <th> Jumlah </th>
                                  <th> Cek BG </th>
                               </tr>

                               <tr>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                                  <td> </td>
                               </tr>
                               </table>
                        </div>

                    </div>


                     <div class="modal inmodal fade" id="NoFaktur" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                            <h4 class="modal-title"> No Faktur </h4>
                                           
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                            <p><strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                                                printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting,
                                                remaining essentially unchanged.</p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
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
