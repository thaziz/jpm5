@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Kas </h2>
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
                            <strong> Detail Pelunasan Hutang / Pembayaran Kas </strong>
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
                    <h5> Detail Pelunasan Hutang / Pembayaran Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
            
                        <div class="text-right">
                       <a class="btn btn-danger" aria-hidden="true" href="{{ url('pelunasanhutang/pelunasanhutang')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
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
                          No Bukti
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
                            <td> Tanggal </td>
                            <td>
                              04/01/2007
                            </td>
                          </tr>
                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td> Jenis Bayar </td>
                            <td> Petty Cash </td>
                            </td>
                          </tr>


                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>

                            <td>
                              Kepada
                            </td>
                            <td>
                             Cash - Talkah

                            </td>

                          </tr>


                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td> Keterangan </td>
                            <td> BBM & Tol Tgl 26 Des-01 Jan 2007 JPM Nganjuk </td>
                          </tr>

                           </table>
                      </div>

                        <div class="col-xs-3">
                           <table class="table table-bordered table-striped">
                              <tr width="300px">
                                <td colspan="2"> <b> Posting / Jurnal </b> </td>
                              </tr>
                              <tr>
                                <td > <b> Kas </b> </td>
                                <td> <b> Uang Muka </b> </td>
                              </tr>
                              <tr>
                                <td> Kas Kecil JPM Surabaya </td>
                                <td> - </td>
                              </tr>
                           </table>
                        </div>
                        </div>

                      </div>

                      <hr>

                      <h4> Pembayaran Cash </h4>

                      <div class="box-body">
                        <table class="table table-bordered table-striped tbl-penerimabarang">
                        <tr>
                        <th>
                          No
                        </th>
                        <th>
                          Acc Biaya 
                        </th>
                        <th>
                          Keterangan
                        </th>
                        <th>
                          Debit / Kredit
                        </th>
                        <th>
                        Nominal
                        </th>
                        </tr>

                        <tr>
                          <td>
                            1
                          </td>
                          <td>
                            50105 - BBM & Toll (Divisi Koran)
                          </td>
                          <td> 
                            BBM & Toll Tgl 26 Des - 01 Jan 2017 JPM Gresik
                          </td>
                          <td>
                            Debit
                          </td>
                          <td>
                            Rp 2.837.000,00
                          </td>
                        </tr>
                        </table>
                      </div>


                      <hr>

                      <h4> Detail Daftar Cek /  BG (Faktur/Voucher) </h4>
                
                   <br>

                   <div class="box-body">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped tbl-penerimabarang" id="addColumn">
                      <tr>
                        <thead>
                        <th width="40px">  
                          No
                        </th>

                        <th width="40px">  
                          No Bukti
                        </th>
                          <th>
                           No Faktur
                          </th>


                          <th>
                            Tanggal
                          </th>

                          <th>
                           Acc Biaya
                          </th>

                          <th>
                          Jumlah Bayar
                          </th>

                          <th>
                            Keterangan
                          </th>
                        </thead>

                      </tr>
                      <tbody>
                          <tr>
                            <td> 1 </td>
                            <td> BKK-001/AP/0107  </td>
                            <td> </td>
                            <td> 03/03/2008 </td>
                            <td> 20401 </td>
                            <td> 105.209.625 </td>
                            <td> Bonus Prestasi JPM </td>
                            
                          </tr>
                          
                        
                      </tbody>
                      </table>
                      </div>

                      <div class="row"> <a class="btn btn-info"> Posting / Jurnal AKuntansi </a> <a class="btn btn-info"> Posting / Jurnal Cash Flow</a> </div>

                      <div class="table-responsive">
                      <table class="table table-striped table-bordered ">
                        <thead>
                          <tr>
                            <th> No </th>  <th> Acc </th> <th> Keterangan </th> <th> DKA </th> <th> Debet </th> <th> Kredit </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td> 000 </td>
                            <td> 10001 </td>
                            <td> BBM & TOLL TGL 26 Des-01 Jan 2007 JPEM Nganjuk </td>
                            <td> K </td>
                            <td> </td>
                            <td> Rp 2.387.000,00 </td>
                          </tr>

                          <tr>
                            <td> 001 </td>
                            <td> 50105 </td>
                            <td> BBM & TOLL Tgl 26 Des - 01 Jan JPEM Ngajuk </td>
                            <td> D </td>
                            <td> Rp 2.367.000,00 </td>
                            <td> </td>
                          </tr>

                          <tr>
                            <td colspan="4">
                            </td>
                            <td> Rp. 2.387.000,00 </td>
                            <td> Rp. 2.387.000,00 </td>
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
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td>' + 
      /* brg*/       '<td> <select class="form-control"> <option value=""> Brg A </option> <option value=""> Brg B </option> </select> </td>' + 
      /* qty*/       '<td> <input type="text" class="form-control"> </td>' +
      /* gudang  */  '<td> <input type="text" class="form-control"> </td>' +
      /* harga */    '<td> <input type="text" class="form-control"> </td>'  +
      /* amount*/    '<td> <input type="text" class="form-control">  </td>' +
      /* stok */     '<td> <select class="form-control"> <option value=""> ya </option> <option value=""> tidak </option></select></td>'  +
      /* biaya */   '<td> <input type"text" class="form-control">  </td>' +
      /* ppn */     '<td> <input type="text" class="form-control"> </td>' +
      /* netto */   '<td> <input type="text" class="form-control"> </td>' +
      /* account */ '<td> <select class="form-control"> <option value=""> A </option> <option value="B"> B </option></select></td>' +
      /* keterangan */  '<td> <input type="text" class="form-control"> </td>' +

                   '<td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td>' +
                
      '</tr>');+ 




        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

    
  
   

</script>
@endsection
