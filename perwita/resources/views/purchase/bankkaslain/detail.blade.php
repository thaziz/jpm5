@extends('main')

@section('title', 'dashboard')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Bank / Kas Lain </h2>
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
                            <strong> Detail Bank / Kas Lain </strong>
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
                    <h5> Detail Bank / Kas Lain
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
            
                      <div class="text-right">
                       <a class="btn btn-danger" aria-hidden="true" href="{{ url('bankkaslain/bankkaslain')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
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
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0">
                          <tr>
                            <td width="150px">
                          No Bank
                            </td>
                            <td>
                              BKK-001/AP/0107
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> Kode Bank </td>
                            <td>
                              10101 Bank BCA 'Bayangkara'
                            </td>
                          </tr>
                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> Tanggal </td>
                            <td> 03/03/2998 - Bank BCA 6100074999 Jl A. Yani Surabaya </td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                         

                           </table>
                      </div>

                        <div class="col-xs-3">
                          <table border="0">
                            <tr>
                              <td width="150px">
                              Cek / BG
                              </td>
                              <td>
                                Rp 105.209.625
                              </td>
                            </tr>

                            <tr>
                              <td> &nbsp;
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Biaya
                              </td>
                              <td>

                              </td>
                            </tr>

                            <tr>
                              <td>  &nbsp;
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Total
                              </td>
                              <td>
                                Rp 105.209.625 ,00
                              </td>
                            </tr>
                          </table>
                        </div>


                      </div>
                      </div>
                      <hr>

                      <h4> Detail Cek / BG | Faktur (Voucher)</h4>
                
                   <br>

                   <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th width="40px">  
                          No Urut
                        </th>
                          <th> No Bukti </th>
                          <th> No Faktur </th>
                          <th>
                           Acc Biaya
                          </th>


                          <th>
                            Jumlah Bayar
                          </th>

                         <th> Keterangan</th>

                        
                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                            <td> 1 </td>
                            <td> FPG-024/AP/0308</td>
                            <td> VC-004/AP/0308 </td>
                            <td> 20401 </td>
                            <td>Rp 2.387.000 </td>
                            <td> Bonus Prestasi Karyawan JPM </td>
                            
                          </tr>
                       
                      </tbody>
                      </table>
                      </div>
                   </div>
                   
                  
                    <div class="box-body">

                    <hr>  
                    <a class="btn btn-success btn"> Detail Cek / BG </a> &nbsp; &nbsp; <a class="btn btn-success btn"> Biaya </a> &nbsp; &nbsp; <a class="btn btn-success btn"> Posting GL </a>

                    <hr>

                  

                    <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th width="40px">  
                          No
                        </th>

                        <th width="40px">  
                          No Cek / BG
                        </th>
                          <th>
                           No A / C
                          </th>


                          <th>
                            Jatuh Tempo
                          </th>

                          <th>
                           Nominal
                          </th>

                          <th>
                          Keterangan
                          </th>

                          <th>
                            Supplier
                          </th>

                          <th>
                          Status
                          </th>

                          <th>
                            Hutang / Voucher
                          </th>

                          <th>
                            Tanggal FPG
                          </th>

                          <th>
                            Bank
                          </th>

                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                            <td> 1 </td>
                            <td> BB 466513 </td>
                            <td>  </td>
                            <td> 24/03/2008 </td>
                            <td> Rp 105.209.625 </td>
                            <td> 105.209.625 </td>
                            <td> Bonus Prestasi JPM 2008 </td>
                            <td> Cair </td>
                            <td> 20401 - Biaya Yang Harus Dibayar (Internal Cost) </td>
                            <td> 03-03-2008 </td>
                            <td> 10101 - Bank BCA "Bayangkara" </td>
                          </tr>
                          
                        
                      </tbody>
                      </table>
                      </div>
                   </div>


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


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('.btn').click(function(){
      $('.tulisan').removeAttr('Data akan di tampilkan disini')
    })

    
  
   

</script>
@endsection
