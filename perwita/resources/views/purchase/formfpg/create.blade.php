@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .table-biaya{
    overflow-x: auto;
  }
  tbody tr{
    cursor: pointer;
  }
  th{
    text-align: center !important;
  }
  .tengah{
    text-align: center;
  }
  .kecil{
    width: 50px;
    
  }
  .datatable tbody tr td{
    padding-top: 16px;
  }
  .dataTables_paginate{
    float: right;
  }
  #modal-biaya .modal-dialog .modal-body{
    min-height: 340px;
  }
  .disabled {
    pointer-events: none;
    opacity: 1;
}
  .right{
      text-align: right;
  }
  .table-hover tbody tr{
    cursor: pointer;
  }

  .center{
      text-align: center;
  }
  .modal {
  overflow-y:auto;
}
</style>
 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Form Permintaan Cek / BG (FPG) </h2>
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
                            <strong> Create Form Permintaan Ceks / BG (FPG) </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

          <form method="post" action="{{url('formfpg/saveformfpg')}}"  enctype="multipart/form-data" class="form-horizontal" id="formfpg">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>

                

                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                
                  <div class="box-body">
                      <div class="row">
                        <div class="col-xs-6"> 
                            <table class="table table-striped table-bordered">
                            <tr>
                              <th> Cabang </th>
                              <td>
                                   @if(Auth::user()->punyaAkses('Form Permintaan Giro','cabang'))
                                <select class="form-control chosen-select-width cabang" name="cabang">
                                    @foreach($data['cabang'] as $cabang)
                                  <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->kode}} - {{$cabang->nama}} </option>
                                  @endforeach
                                </select>
                                @else
                                  <select class="form-control disabled cabang" name="cabang">
                                    @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                                    @endforeach
                                  </select> 
                                @endif
                                
                                <input type="hidden" class="cabangfaktur">
                              </td>
                             
                            </tr>

                              <tr>
                                <th> No FPG </th>
                                <td> <input type='text' class='input-sm form-control nofpg' value="" name="nofpg" readonly="">     <input type="hidden" name="_token" value="{{ csrf_token() }}"> <input type="hidden" class="valcabang" name="cabang">
                                <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                                </td>
                              </tr>
                              <tr>
                                <th> Tanggal </th>
                                <td>  
                                      <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tglfpg" required="">
                                      </div>
                               </td>
                              </tr>
                              <tr>
                                <th>
                                  Jenis Bayar
                                </th>
                                <td>
                                  <select class="input-sm form-control jenisbayar" name="jenisbayar">
                                           <option value=""> Pilih Jenis Bayar</option>
                                       @foreach($data['jenisbayar'] as $jenisbayar)
                                           <option value="{{$jenisbayar->idjenisbayar}}"> {{$jenisbayar->jenisbayar}} </option>
                                       @endforeach
                                      </select>
                                 
                                </td>
                              </tr>
                            </table>
                        </div>

                        <div class="col-xs-6" id="jurnal">
                          <table class="table table-bordered table-striped">
                          <tr>
                            <th colspan="3" style="text-align: center"> Posting / Jurnal </th>
                          </tr>
                          <tr>
                            <td> <h4> Hutang Dagang (D)  </h4> </td>
                            <td> <input type='text' class="input-sm form-control hutangdagang" readonly="" name="hutangdagang"> </td>
                          </tr>

                          <tr>
                            <td> <h4> Hutang Cek / BG (K) </h4> </td>
                            <td> <input type='text' readonly="" name="hutangcekbg" class="input-sm form-control hutangbank" name="hutangbank"> </td>
                          </tr>

                          <tr>
                            <td> <h4> Uang Muka </h4> </td>
                            <td> <input type="text" readonly="" name="uangmuka" class="input-sm form-control uangmuka" name="hutangum" > </td>
                          </tr>
                          </table>
                        </div>                    
                      </div>

                      <div class="row">
                       <div class='col-xs-6 '>
                          <table class='table table-bordered table-striped tbl-jenisbayar' style="width:100%">
                            <tr>
                              <th> Kode  </th>
                              <td> <select class='form-control  chosen-select-width  jenisbayar2'>  </select> <input type="hidden" class="hsljenisbayar" name="kodebayar">  </td>
                            </tr>

                            <tr>
                              <th> Keterangan </th>
                              <td> <input type='text' class='form-control' name="keterangan"></td>
                            </tr>
                          </table>

                          <div class="deskirpsijenisbayar"> </div>
                        </div>



                        <div class="col-xs-6 pull-right">
                          <table class="table table-bordered table-striped">
                            <tr>
                              <th> Tot. Bayar </th>
                              <td> <input type="text" class="input-sm form-control totbayar" readonly="" style="text-align: right" name="totalbayar"> </td>
                            </tr>
                            <tr>
                              <th> Uang Muka </th>
                              <td> <input type="text" class="input-sm form-control" name="uangmuka" readonly=""> </td>
                            </tr>
                            <tr>
                              <th> Cek / BG </th>
                              <td> <input type="text" class="input-sm form-control ChequeBg" style="text-align: right" readonly="" name="cekbg"> </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      
                     

                      <div class="col-xs-12" style>
                        <div class="tabs-container">
                        <ul class="nav nav-tabs">

                          <button class="btn btn-default active"  data-toggle="tab" href="#tab-1" id="detailbayar" > Detail Pembayaran </a></button>
                          <button data-toggle="tab" href="#tab-2" id="bayarcek" class="btn btn-default" > Pembayaran dengan Cek / BG  </button></li>
                        
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                   <div class="col-sm-12">
                                        <table class='table'>
                                          <tr>
                                            <th>
                                              No Faktur
                                            </th>
                                            <td style="width:200px">
                                             <!--  <select class='input-sm form-control chosen-select nofaktur'>
                                                <option value=''> -- Pilih No Faktur -- </option>
                                              </select> -->

                                              <input type="text" class="input-sm form-control nofaktur" > 
                                            </td>
                                            <td>
                                            &nbsp;
                                            </td>
                                            
                                            <th> Tgl </th>
                                            <td> <input type="text" class="input-sm form-control tgl" readonly=""> </td>

                                              <td>
                                              &nbsp;
                                              </td>

                                            <th> Jatuh Tempo </th>
                                            <td> <input type="text" class="input-sm form-control jatuhtempo" readonly=""> </td>
                                          </tr>

                                          <tr>
                                            <td>
                                              No TTT
                                            </td>
                                            <td>
                                              <input type="text" class="input-sm form-control formtt" readonly=""> 
                                              <input type="hidden" class="netto" readonly="">
                                              <input type="hidden" class="sisapelunasan" readonly="">
                                            </td>

                                            <td>
                                              &nbsp;
                                            </td>

                                          </tr>
                                        </table>
                                        <div class="pull-left"> <button class="btn tbn-sm btn-info " type="button" data-toggle="modal" data-target="#myModal5" id="getDataFaktur"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data  Faktur</button> </div>

                                   </div>
                                    <hr>
                                   <div class="row">
                                      <div class="col-sm-8">
                                          <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#pembayaran">Pembayaran</a></li>
                                                <!-- <li class=""><a data-toggle="tab" href="#returnbeli">Return Beli</a></li> -->
                                                <li class=""><a data-toggle="tab" href="#creditnota"> Credit Nota </a></li>
                                                <li class=""><a data-toggle="tab" href="#debitnota"> Debit Nota </a></li>
                                                <li class=""><a data-toggle="tab" href="#pelunasanum"> Pelunasan UM </a></li>
                                            </ul>
                                            <div class="tab-content" style="height: 100%">
                                                <div id="pembayaran" class="tab-pane active"> <!-- PEMBAYARAN -->
                                                    <div class="panel-body">
                                                       <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%" id="tbl-pembayaran">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                             
                                                            </table>
                                                       </div>
                                                    </div>
                                                </div>

                                               <!--  <div id="returnbeli" class="tab-pane">
                                                    <div class="panel-body">
                                                      <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                              <tr style="height: 30%">
                                                                <td> </td>
                                                                <td> </td>
                                                                <td> </td>
                                                                <td> </td>

                                                              </tr>
                                                            </table>
                                                       </div>
                                                    </div>
                                                </div> -->

                                                <div id="creditnota" class="tab-pane">
                                                  <div class="panel-body">
                                                    <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%" id="table-kredit">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> No Transaksi </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                             
                                                            </table>
                                                       </div>
                                                  </div>
                                                </div>

                                                <div id="debitnota" class="tab-pane">
                                                  <div class="panel-body">
                                                    <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%" id="table-debit">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> No Transaksi </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                              
                                                            </table>
                                                       </div>
                                                  </div>
                                                </div>

                                                <div id="pelunasanum" class="tab-pane">
                                                  <div class="panel-body">
                                                    <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%" id="tableum">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                             
                                                            </table>
                                                       </div>
                                                  </div>
                                                </div>
                                            </div>


                                        </div>
                                      </div>

                                      <div class="col-md-4">
                                        <table class="table">
                                        <tr>
                                          <td> Jumlah Faktur </td>
                                          <td> <input type="text" class="input-sm form-control jmlhfaktur" readonly="" style="text-align: right"> <input type="hidden" class="id"> </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            Pelunasan Uang Muka
                                          </td>
                                          <td> 
                                            <input type="text" class="input-sm form-control uangmukakanan" readonly="" style="text-align: right" name="uangmuka">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td> Pembayaran </td>
                                          <td> <input type="text" class="input-sm form-control pembayaran" readonly="" style="text-align: right" name="pembayaran"></td>
                                        </tr>
                                       <!--  <tr>
                                          <td> Return Beli </td>
                                          <td> <input type="text" class="input-sm form-control" readonly="" style="text-align: right" name="returnbeli"> </td>
                                        </tr> -->
                                        <tr>
                                          <td> 
                                            Credit Nota
                                          </td>
                                          <td> <input type="text" class="input-sm form-control cnkanan" readonly="" style="text-align: right" name="creditnota"> </td>
                                        </tr>
                                        <tr>
                                          <td> Debit Nota </td>
                                          <td> <input type="text" class="input-sm form-control dnkanan" readonly="" style="text-align: right" name="debitnota"> </td>
                                        </tr>
                                        <tr>
                                          <td> Sisa Terbayar </td>
                                          <td> <input type="text" class="input-sm form-control sisatrbyr" readonly="" style="text-align: right" name="sisaterbayar"> </td>
                                        </tr>
                                        <tr>
                                          <td> Pelunasan </td>
                                          <td> <input type="text" class="input-sm form-control pelunasan" style="text-align: right" readonly="" name=""> </td>
                                        </tr>
                                        <tr>
                                          <td> Sisa Faktur </td>
                                          <td> <input type="text" class="input-sm form-control sisafaktur" readonly="" style="text-align: right">  </td>
                                        </tr>
                                        </table>
                                      </div>

                                       <hr>
                                    <div class="col-sm-12">
                                        <table class="table tbl-item" id="tbl-item">
                                          <tr>
                                             <th> No </th>  <th> No Faktur </th>  <th> Tanggal </th> <th> Jatuh Tempo </th> <th> Netto Hutang </th> <th> Pelunasan </th> <th> Pembayaran</th> <th> Sisa Terbayar </th> <th> Keterangan </th> <th> Aksi </th>
                                          </tr>
                                       
                                       </table>

                                    </div>   

                                   </div>

                                </div>



                            </div>

              <!-- MODAL NO FAKTUR -->
              <div class="modal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h4 class="modal-title" style="text-align: center;"> Data Data </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                    <table class="table table-bordered tbl-faktur" id="tbl-faktur">
                      <thead>

                        <tr> 
                          <th>No</th> <th> Cabang </th> <th> No Transaksi </th> <th class="invfaktur"> No Invoice </th>  <th class="supfaktur"> Nama Supplier</th> <th> No TTT </th> <th> Jatuh Tempo </th> <th> Sisa Pelunasan</th> <th> </th>
                        </tr>
                      </thead>
                    <tbody>

                    </tbody>
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="buttongetid">Simpan</button>
                       
                    </div>
                </div>
              </div>
           </div> <!-- END MODAL -->

              <!-- MODAL NO CHEQUE -->
              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h4 class="modal-title" style="text-align: center;"> NO CHEUQUE / BG </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                    <table class="table table-bordered" id="tbl-cheuque">
                      <thead>
                        <tr> 
                          <th style="width:50px">No</th> <th> Kode Bank  </th> <th> Nama Bank </th> <th> No Seri </th> <th> No FPG</th> <th> Nominal </th> <th> Setuju </th> <th> Rusak </th>  <th> </th>
                        </tr>
                      </thead>
                    <tbody>

                    </tbody>
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="buttongetcek">Simpan</button>
                       
                    </div>
                </div>
              </div>
           </div> <!-- END MODAL -->   <!-- MODAL NO FAKTUR -->
        
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                   <div class="row">
                                     <table class="table">
                                        <tr>
                                          <th colspan="4" style="color:#009aa9" class="transferbank"> <h3> Asal Bank : </h3> </th>
                                        </tr>
                                        <tr>
                                          <th> Kode Bank </th> <th> Nama Bank </th> <th> Cabang / Alamat </th> <th> No Account </th>
                                        </tr>
                                        <tr>
                                          <td> <select class="form-control selectOutlet chosen-select-width1 bank bankasal" >
                                               
                                                    <option value=""> Pilih Data Bank </option>

                                                    @foreach($data['bank'] as $bank)
                                                      <option value="{{$bank->mb_id}}, {{$bank->mb_nama}} , {{$bank->mb_cabang}} ,{{$bank->mb_accno}},{{$bank->mb_kode}},{{$bank->mb_kelompok}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                                    @endforeach
                                                  
                                                </select> </td>
                                          <td> <input type="text" class="form-control nmbank" readonly=""> </td> <td> <input type="text" class="form-control cbgbank" readonly=""> </td> <td> <input type="text" class="form-control account" readonly=""> <input type="hidden" class="valbank" readonly="" name="selectOutlet"></td>
                                          
                                        </tr>
                                     </table>
                                   </div>

                                    <div class="col-md-3">
                                    <fieldset>


                                        <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="jenisbayaribaking" type="checkbox" name="jenisbayarbank" value="INTERNET BANKING" class="metodebayar jenisbayarbankibaking">
                                            <label for="jenisbayarbankcekbg">
                                               Internet Banking
                                            </label>
                                        </div>
                                     
                                        <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="jenisbayarbankcekbg" type="checkbox" name="jenisbayarbank" value="CHECK/BG" class="metodebayar jenisbayarbankbg" checked="">
                                            <label for="jenisbayarbankcekbg">
                                                Cheque / BG
                                            </label>
                                        </div>
                                     

                                      



                                    </fieldset>
                                      <br>
                                      <br>
                                <!--       <div class="pull-left"> <button class="btn btn-info"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data Bank </button> </div> -->
                                </div>

                                <div class="col-md-6 checkbgtf">
                                    <table class="table">
                                    <tr>
                                      <th colspan="4" style="color:#009aa9"  class="transferbank"> <h3> </h3> </th>
                                    </tr>

                                    <tr>
                                      <th> <h4> No Cheque / BG </h4> </th>
                                      <td> <input type="text" class="input-sm form-control nocheck" type="button" data-toggle="modal" data-target="#myModal2" id="getbank" readonly="">
                                      <input type="hidden" class="valjenisbayarbank" name="jenisbayarbank">
                                     </td>
                                      
                                      <th> Nominal </th>
                                      <td> <input type="text" class="input-sm form-control nominal" style="text-align: right"> <input type="hidden" class="idbank"> </td>

                                      <td> <div class="checkbox  checkbox-circle">
                                                <input id="checkbox7" type="checkbox" name="setuju" required="" checked="">
                                                <label for="checkbox7">
                                                   Setuju
                                                </label>
                                            </div> </td>
                                    </tr>

                                    <tr>
                                      <th>Jatuh Tempo </th>
                                      <td> <input type="text" class="input-sm form-control jthtmpo_bank"></td>

                                  
                                    </tr>
                                    </table>
                                </div>


                                <div class="col-xs-8 tujuanbank"> <!-- TRANSFERBANK -->
                                    <table class="table">
                                      <tr>
                                      <th colspan="4" style="color:#009aa9"> <h3 class="transferbank"> Tujuan Bank : </h3> </th>
                                    </tr>

                                    <tr>
                                      <th> <h4> No Referensi  </h4> </th>
                                      <td> <input type="text" class="input-sm form-control namabank" name="namabank">

                                     </td>
                                      

                                      <th> No Rekening </th>
                                      <td> <input type="text" class="input-sm form-control norekening" name="norekening"></td>
                                     
                                     <th> Nama Rekening </th>
                                      <td> <input type="text" class="input-sm form-control namarekening" name="namarekening" readonly=""></td>

                                    </tr>

                                    <tr>

                                      <th> Nominal </th>
                                      
                                      <td> <input type="text" class="input-sm form-control nominal" style="text-align: right"> <input type="hidden" class="idbank"> </td>

                                      

                                      <th> Periode </th>
                                      <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tglfpg" required="">
                                          </div>
                                      </td>


                                      <td> <div class="checkbox  checkbox-circle">
                                                <input id="checkbox7" type="checkbox" name="setuju" required="" checked="">
                                                <label for="checkbox7">
                                                   Setuju
                                                </label>
                                            </div>
                                      </td>

                                    </tr>
                                    </table>


                                    <div class="pull-right">
                                        <button class="btn btn-sm btn-info" id="tmbhtujuan" type="button"> Tambah Rekening </button>
                                    </div>
                                </div>

                                 <div class="col-xs-8 tujuanbankacc"> <!-- TRANSFERBANK TUJUAN ACCOUNT -->
                                    <table class="table">
                                      <tr>
                                      <th colspan="4" style="color:#009aa9"> <h3 class="transferbank"> Tujuan Bank : </h3> </th>
                                    </tr>

                                    <tr>
                                      <th> <h4> No Referensi  </h4> </th>
                                      <td> <input type="text" class="input-sm form-control nocheck" type="button" data-toggle="modal" data-target="#myModal2" id="getbank2">
                                     </td>
                                    
                                   </tr>
                                    <tr>
                                      <th> Bank Tujuan </th>
                                      <td> <select class="form-control selectOutlet chosen-select-width1 bank1 banktujuan" name="tujuanbank">
                                               
                                                    <option value=""> Pilih Data Bank </option>

                                                    @foreach($data['bank'] as $bank)
                                                      <option value="{{$bank->mb_id}}+{{$bank->mb_nama}}+{{$bank->mb_cabang}}+{{$bank->mb_accno}}+{{$bank->mb_kode}}+{{$bank->mb_kelompok}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                                    @endforeach
                                                  
                                                </select>
                                      </td>
                                     
                                     <th> Nama Rekening Tujuan </th>
                                      <td> <input type="text" class="input-sm form-control nmbank1" name="nama" readonly=""></td> 

                                    </tr>

                                    <tr>
                                      <th> Nominal </th>                                      
                                      <td> <input type="text" class="input-sm form-control nominal nominaltujuanbank" style="text-align: right"> <input type="hidden" class="idbank"> </td>

                                      <td>
                                            <button class="btn btn-success btn-xs" type="button" id="tbmhdatainet">
                                            Tambah Data
                                          </button>
                                      </td>

                                      <td>
                                       
                                      </td>
                                    </tr>
                                    </table>


                                </div>


                                <div class="col-md-12 ibanking" style="padding-top: 20px">
                                  <table class="table table-bordered" id="tbl-ibank">
                                    <tr>
                                      <th> Nomor </th>
                                      <th> No Bukti </th>
                                      <th> Tanggal </th>
                                      <th> Kode Bank </th>
                                      <th> Jatuh Tempo </th>
                                      <th> Nominal </th>
                                      <th> Aksi </th>
                                     
                                    </tr>
                                  </table>
                                </div>

                                <div class="col-md-12 checkbgtf" style="padding-top: 20px">
                                  <table class="table table-bordered" id="tbl-bank">
                                    <tr>
                                        <th> Nomor </th>
                                      <th> No Bukti </th>
                                      <th> No Cek / BG </th>
                                      <th> Tanggal </th>
                                      <th> Kode Bank </th>
                                      <th> Jatuh Tempo </th>
                                      <th> Nominal </th>
                                      <th> Aksi </th>
                                     
                                    </tr>
                                  </table>
                                </div>

                                 <div class="col-md-12 transferbank" style="padding-top: 20px">
                                  <div class="table-responsive">
                                  <table class="table table-bordered" id="tbl-tfbank">
                                    <tr>
                                       <th> Nomor </th>
                                      <th> No Bukti </th>
                                      <th> No Cek / BG </th>
                                      <th> Tanggal </th>
                                      <th> Asal Kode Bank </th>
                                      <th> Tujuan Kode Bank </th>
                                      <th> No Rekening Tujuan </th>
                                      <th> Nama Rekening </th>
                                      <th> Nominal </th>
                                      <th> Aksi </th>
                                     
                                    </tr>
                                  </table>
                                  </div>
                                </div>

                            </div>
                        </div>

                       


                    </div>
                    <br>
                   

                     </div>
                    </div>
                    </form>

             
                   
  

                <div class="box-footer">
                  <div style="margin-top:10px;padding-top: 20px"> </div>
                  <div class="pull-right">
                    <table border="0">
                    <tr>
                      <td> <a  class="btn btn-sm btn-warning" href={{url('formfpg/formfpg')}}> Kembali </a> </td>
                      <td> &nbsp; </td>
                      <td>  <div class='print'> </div> </td>
                      <td> &nbsp; </td>
                      <td>  <a class="btn btn-sm btn-info reload" type="button"> <i class="fa fa-refresh"></i>  Reload  </a> </td>
                      <td> &nbsp; </td>
                      <td>  <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-sm btn-success simpansukses">  </form> </td>
                    </tr>
                    </table>
                   
                    
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

      $('.tujuanbank').hide();
      $('.tujuanbankacc').hide();
      $('.transferbank').hide();
      $('.ibanking').hide();

      //MENDAPATKAN NO FPG
       cabang = $('.cabang').val();
        $('.valcabang').val(cabang);
      
      //MENDAPATKAN JENISBAYAR
      $('.metodebayar').change(function(){
       val = $('.metodebayar:checked').val();
        $('.valjenisbayarbank').val(val);       
      })

        valjenisbayar = $('.metodebayar:checked').val();
        $('.valjenisbayarbank').val(valjenisbayar);

      $('.cabang2').val(cabang);
       $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/formfpg/getnofpg',
          dataType : 'json',
          success : function (response){     
                cabang = $('.cabang').val();
               var d = new Date();
                
                //tahun
                var year = d.getFullYear();
                //bulan
                var month = d.getMonth();
                var month1 = parseInt(month + 1)
                console.log(d);
                console.log();
                console.log(year);

                if(month < 10) {
                  month = '0' + month1;
                }

                console.log(d);

                tahun = String(year);
//                console.log('year' + year);
                year2 = tahun.substring(2);
                //year2 ="Anafaradina";
                 nofpg = 'FPG' + month + year2 + '/' + cabang + '/'  + response.idfpg ;
               
                $('.nofpg').val(nofpg);

                nofpg = $('.nofpg').val();
                if(nofpg == ''){
                    location.reload();
                }
          },
          error : function(){
            location.reload();
          }
        })

       $('.cabang').change(function(){
         $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/formfpg/getnofpg',
          dataType : 'json',
          success : function (response){     
               cabang = $('.cabang').val();
               $('.cabangfaktur').val(cabang);
               var d = new Date();
                
                //tahun
                var year = d.getFullYear();
                //bulan
                var month = d.getMonth();
                var month1 = parseInt(month + 1)
                console.log(d);
                console.log();
                console.log(year);

                if(month < 10) {
                  month = '0' + month1;
                }

                console.log(d);

                tahun = String(year);
//                console.log('year' + year);
                year2 = tahun.substring(2);
                //year2 ="Anafaradina";
                 nofpg = 'FPG' + month + year2 + '/' + cabang + '/'  + response.idfpg ;
               
                $('.nofpg').val(nofpg);

                nofpg = $('.nofpg').val();
                if(nofpg == ''){
                    location.reload();
                }
          },
          error : function(){
            location.reload();
          }
        })
       })



      $('#getbank').click(function(){
       // alert('hei');
        bank = $('.bank').val();
       // alert(bank);
        if(bank == ''){
          toastr.info("Data Bank Belum diisi :)");
          return false;
        }
      })

      $('#getbank2').click(function(){
          metodebayar = $('.metodebayar:checked').val();
          //alert(metodebayar);
        if(metodebayar == 'TFAkun'){
          bank = $('.bank1').val();
          if(bank == ''){
            toastr.info("Harap Pilih Tujuan Bank :)");
            return false;
          }
        }

        // alert('hei');
        bank = $('.bank').val();
       // alert(bank);
        if(bank == ''){
          toastr.info("Data Bank Belum diisi :)");
          return false;
        }

      })

      nomrbnk = 1;   
      $('#tmbhtujuan').click(function(){
          lengthbank2 = $('.tblbank').length;
          if(lengthbank2 > 1){
            $('.nominal').attr('readonly' , true);
          }

           nofpg = $('.nofpg').val();
          namabank = $('.namabank').val();
          norekening = $('.norekening').val();
          nominal = $('.nominal').val();
          jatuhtempo = $('.jthtmpo_bank').val();
          tgl = $('.tgl').val();

        
          var row = "<tr class='tblbank' id='datas"+nomrbnk+"'> <td>"+nomrbnk+"</td>  <td>"+nofpg+"</td>" + // NO FPG
                      "<td>  <a class='noseri'  data-id='"+nomrbnk+"'> - </a></td>"+ // NOSERI
                      "<td>"+tgl+"</td>"+ // TGL
                      "<td>"+namabank+"-"+norekening+"</td> <td> <input type='text' class='form-control jatuhtempotblbank' value='"+jatuhtempo+"'> </td>" + //JATUH TEMPO
                      "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+"' readonly name='nominalbank[]' style='text-align:right'  value="+nominal+"> </td>" + //NOMINAL
                      "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"' type='button'><i class='fa fa-trash'></i></button></td> </tr>"
          
          $("#tbl-bank").append(row);

          $('.nominalbank1').val(nominalbank);
          $('.ChequeBg').val(nominalbank);

      })

       $('.jenisbayarbankbgtf').change(function(){
        $this = $(this);
          if ($this.is(":checked")) {
           
           $('.checkbgtf').hide();
           $('.tujuanbank').show();
           $('.transferbank').show();
          }
          else {
         
           $('.tujuanbank').hide();
           $('.tujuanbankacc').hide();
            $('.transferbank').hide();
          }
      })


       $('.jenisbayarbanktfacc').change(function(){
        $this = $(this);
          if ($this.is(":checked")) {         
           $('.checkbgtf').hide();
           $('.tujuanbank').hide();
           $('.tujuanbankacc').show();
           $('.transferbank').show();
          }
          else {          
           $('.checkbgtf').show();
           $('.tujuanbank').hide();
           $('.tujuanbankacc').hide();
           $('.transferbank').hide();
          }
      })

        // BANK BG TF
       $this = $('.jenisbayarbankbgtf');
           if ($this.is(":checked")) {
             
           }
           else {
             

           }

      noinet = 1;     
      $('#tbmhdatainet').click(function(){

        banktujuan =$('.banktujuan').val();
        asalbank = $('.bankasal').val();

        if(banktujuan == '' || asalbank == ''){
          toastr.info("Mohon maaf data bank asal / tujuan belum diisi :)");
          return false;
        }
        split = banktujuan.split("+");
        kodebanktujuan = split[4];
        norekening = split[3];
        namabank = split[1];
        idbanktujuan = split[0];
        kelompoktujuan = split[5];
       tgl = $('.tgl').val();
      
        splitasal = asalbank.split(",");
        kodebankasal = splitasal[4];
        idbankasal = splitasal[0];
        kelompok = splitasal[5];

      
        if(kodebankasal.match(/1099.*/)){
          $('.kelompokbank').val('BEDA BANK');
        }
        else {
         if(kelompok == kelompoktujuan){
            $('.kelompokbank').val('SAMA BANK');
          }
          else {
            toastr.info("Mohon maaf, tidak bisa beda bank :)");
            return false;
          }
        }


           var row =  "<tr class='tbltfbank tbltfbank"+noinet+"'> <td>"+noinet+"</td>" +
                      "<td>"+nofpg+"</td>" + // NO FPG
                      "<td> - </td>" + // -
                      "<td>"+tgl+"</td>"+ 
                      "<td>"+kodebankasal+"</td>" + // BANK ASAL
                      "<td><input type='text' class='form-control kodebankbg' value="+kodebanktujuan+" name='kodebanktujuan[]' readonly></td>"+ // KODEBANK
                       "<td> <input type='text' class='form-control norekening' value='"+norekening+"' readonly> </td>" + //NO REKENING TUJUAN
                      "<td> <input type='text' class='form-control namarekening' value='"+namabank+"' name='namabanktujuan[]' readonly> <input type='hidden' class='form-control idbanktujuan' value='"+idbanktujuan+"' name='idbanktujuan[]' readonly> <input type='text' class='kelompokbank' name='kelompokbank'>  </td>" + //NAMA BANK TUJUAN
                      "<td> <input type='text' data-id='"+noinet+"' class='input-sm form-control nominaltbltfbank nominaltbltfbank"+noinet+"'  name='nominalbank[]' style='text-align:right' required> </td>" + //NOMINAL
                      "<td> <button class='btn btn-danger remove-tfbtn' data-id='"+noinet+"'  data-idbankdt="+idbankasal+" type='button'><i class='fa fa-trash'></i></button></td></tr>"; //NOMINAL
              
            $('#tbl-tfbank').append(row);
         
                if(kodebankasal.match(/1099.*/)){
                  $('.kelompokbank').val('BEDA BANK');
                }
                else {
                 if(kelompok == kelompoktujuan){
                    $('.kelompokbank').val('SAMA BANK');
                  }
                }

                 $('.nominaltbltfbank').change(function(){
                    val = $(this).val();
                    val = accounting.formatMoney(val, "", 2, ",",'.');
                    $(this).val(val);

                      jumlahtf = 0;
                      $('.nominaltbltfbank').each(function(){
                        nominaltf = $(this).val();
                        nominaltf2 = nominaltf.replace(/,/g,'');
                        jumlahtf = parseFloat(parseFloat(jumlahtf) + parseFloat(nominaltf2)).toFixed(2);
                      })

                      $('.totbayar').val(addCommas(jumlahtf));
                      $('.ChequeBg').val(addCommas(jumlahtf));
                  })

                 $('.remove-tfbtn').click(function(){
                    jenisbayar = $('.jenisbayar').val();
                    if(jenisbayar == '11'){
                      id = $(this).data('id');
                      nominal = $('.nominaltbltfbank' + id).val();
                      nominaltf = nominal.replace(/,/g,'');
                      cekbg = $('.ChequeBg').val();
                      cekbg = cekbg.replace(/,/g,'');
                      nominalakhir = parseFloat(parseFloat(cekbg) - parseFloat(nominaltf)).toFixed(2);
                      $('.ChequeBg').val(addCommas(nominalakhir));
                      parent = $('.tbltfbank' + id);
                      parent.remove();
                    }
                    else {
                      id = $(this).data('id');
                      nominal = $('.nominaltbltfbank' + id).val();
                      nominaltf = nominal.replace(/,/g,'');
                      cekbg = $('.ChequeBg').val();
                      cekbg = cekbg.replace(/,/g,'');
                      nominalakhir = parseFloat(parseFloat(cekbg) - parseFloat(nominaltf)).toFixed(2);
                      $('.ChequeBg').val(addCommas(nominalakhir));
                      $('.totbayar').val(addCommas(nominalakhir));
                      parent = $('.tbltfbank' + id);
                      parent.remove();
                    }
                 })
      })

      $('.jenisbayarbankbg').change(function(){
          $('#tbmhdatainet').hide();
          $('.nocheck').attr('readonly' , false);
          $('.nominaltujuanbank').attr('readonly' , false);
          $this = $(this);
          jenisbayar = $('.jenisbayar').val();
           if ($this.is(":checked")) {
                if(jenisbayar == '12'){
                    $('.transferbank').show();
                    $('.tujuanbankacc').show();
                    $('.jenisbayarbankibaking').prop({checked: false });
                    
                }
                else {
                  $('.jenisbayarbankibaking').prop({checked: false });
                  $('.tujuanbank').hide();
                  $('.tujuanbankacc').hide();
                  $('.transferbank').hide();
                  $('.checkbgtf').show();
                  $('.ibanking').hide();
                  $('#tbl-bank').show();
                }
           }
           else {
                if(jenisbayar == '12'){
                  $('.ibanking').hide();
                  $('.checkbgtf').hide();
                }
                else {
                  $('.ibanking').hide();
                }
           }
      })

      $('#tbmhdatainet').hide();

      $('.jenisbayarbankibaking').change(function(){
          $this = $(this);
          jenisbayar = $('.jenisbayar').val();
           if ($this.is(":checked")) {
                if(jenisbayar == '12' || jenisbayar == '11'){
                  $('.transferbank').show();
                  $('.tujuanbankacc').show();
                  $('.jenisbayarbankbg').prop({ checked: false }); 

                  banktujuan =$('.banktujuan').val();
                  $('#tbmhdatainet').show();
                 

                
                    $('.nocheck').attr('readonly' , true);
                    $('.nominaltujuanbank').attr('readonly' , true);

                }
                else {
                  $('.jenisbayarbankbg').prop({ checked: false });           
                  $('.tujuanbank').hide();
                  $('.tujuanbankacc').hide();
                  $('.transferbank').hide();
                  $('.checkbgtf').hide();
                  $('.ibanking').show();
                  $('#tbl-ibank').show();

                  tgl = $('.tgl').val();
                  bank = $('.bank').val();
                  kodebank = bank.split(",");
                  

                  if(kodebank == ''){
                    toastr.info("Mohon pilih data bank terlebih dahulu :)");
                    return false;
                  }
                  jatuhtempo = $('.jatuhtempo').val();
                  nofpg = $('.nofpg').val();

                  $('tr.tblbank').remove();

                   var row = "<tr class='tblbank'> <td> 1 </td>  <td>"+nofpg+"</td>" + // NO FPG
                        "<td>"+tgl+"</td>"+
                        "<td> <input type='text' class='form-control kodebankbg' value="+kodebank[4]+" name='kodebankbg' readonly></td>"+ // TGL
                        "<td> <input type='text' class='form-control jatuhtempotblbank' value='"+jatuhtempo+"' readonly> </td> <td> <input type='text'  class='input-sm form-control nominaltblibank' name='nominalbank' style='text-align:right' required > </td>" + //JATUH TEMPO
                        "<td>  </td> </tr>"; //NOMINAL
                      
                    $('#tbl-ibank').append(row);

                    $('.nominaltblibank').change(function(){
                        //alert('as');
                        totbayar = $('.totbayar').val();
                        kodebank = $('.kodebankbg').val();

                        val = $(this).val();
                        
                         val = accounting.formatMoney(val, "", 2, ",",'.');
                         $(this).val(val);
                         totbayar = totbayar.replace(/,/g,'');
                         val = val.replace(/,/g,'');
                         if(parseFloat(totbayar) < parseFloat(val)) {
                          toastr.info("Nominal harus sama dengan totalbayar :)");
                          return false;
                         }


                         $('.totbayar').val(addCommas(val));
                         $('.ChequeBg').val(addCommas(val));
                    })
                }
           }
           else {
            if(jenisbayar == 12){
              $('.checkbgtf').hide();
              $('.ibanking').hide();
            }
            else {
              $('.checkbgtf').show();
              $('.ibanking').hide();
            }

           }
      })




     $('#formfpg').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })


//     $('.cabang').attr('disabled' , true);

    $('.reload').click(function(){
      location.reload();
    })



    $('#formfpg').submit(function(event){
        var temp = 0;
        $('.nominaltblbank').each(function(){
          valbank = $(this).val();
          if(valbank == ''){
            temp = temp + 1;
          }
        })

        $('.pelunasanitem').each(function(){
          valpelunasan = $(this).val();
          if(valpelunasan == ''){
            temp = temp + 1;
          }
        })


        nofgp = $('.nofpg').val();
        totbar = $('.totbayar').val();
        cekbg = $('.ChequeBg').val();

        console.log(totbar);
        console.log(cekbg);

        if(totbar != cekbg) {
          toastr.info('Mohon Maaf nominal total faktur dengan ChequeBG tidak sama :)');
          return false;
        }
        else if(temp != 0){
           toastr.info('Terdapat nilai input yang belum diisi :)');
          return false;
        }
        else {
          jenisbayar = $('.jenisbayar').val();

        event.preventDefault();
         var post_url2 = $(this).attr("action");
         var form_data2 = $(this).serialize();
         swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Form FPG!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
           function(){
         $.ajax({
          type : "post",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
                swal({
                  title: "Berhasil!",
                          type: 'success',
                          text: "Data berhasil disimpan",
                          timer: 900,
                         showConfirmButton: false
                       
                  });
                
                var idfpg = response.isfpg[0].idfpg;
                $('.simpansukses').attr('disabled', true);
                html = "<a class='btn btn-success btn-sm' href={{url('formfpg/printformfpg')}}"+'/'+idfpg+"><i class='fa fa-print'></i>  Cetak </a>";
                $('.print').html(html);
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
       });
       }
    })  

   

    $('#formfpg input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formfpg input').change(function(){
      this.setCustomValidity("");
    })

  function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }

     tableDetail = $('.tbl-faktur').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

     


   //CHOSEN SELECT WIDTH
    $(document).ready( function () {
      var config2 = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"}
                 }
                 for (var selector in config2) {
                   $(selector).chosen(config2[selector]);
                 }

      $('.supplier').chosen(config2); 
   //   $('.nofaktur').chosen(config2); 
      $('.agen').chosen(config2);

    })



     $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    }).datepicker("setDate", "0");;
    
     var nmr = 0;
     var jumlahfaktur = 0;
      
     
      var nopembayaran = 1;


      // NO REFERENSI DICEK
    
     $('#buttongetid').click(function(){

        jenisbayar = $('.jenisbayar').val();
        $('.jenisbayar').addClass('disabled');
        var checked = $(".check:checked").map(function(){
          return this.id;
        }).toArray();

        variabel = [];
        variabel = checked;
        idfp = [];
        nmrf =[];
        nofaktur = [];
        for(z=0;z<variabel.length;z++){
          string = variabel[z].split(",");
          idfp.push(string[0]);
          nofaktur.push(string[1]);
          nmrf.push(string[2]);
        }

       // alert(nmrf);

        for(var z=0; z <nmrf.length; z++){
          $('tr.data'+nmrf[z]).hide();
        }

        uniquefp = [];
 
          var tempz = 0;
          for(ds = 0; ds < arrnofaktur.length; ds++){
            for(zx = 0; zx < nofaktur.length; zx++){
              if(arrnofaktur[ds] == nofaktur[zx]){
               tempz = tempz + 1;
              }
            }
          }
          
          if(checked.length == 0){
            toastr.info("Mohon untuk check data nya :) ");
          }

          $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getfaktur',
                  data : {idfp, jenisbayar,nofaktur},
                  type : "post",
                  dataType : "json",
                  success : function(data) {
                    $('.pelunasan').val('');

                     var totalpembayaran = 0;
                    var totalpembayaran2 = 0;
                    //TOTAL PEMBAYARAN
                    if(data.pembayaran.length > 0){

                      for(var z=0; z < data.pembayaran[0].length; z++){
                         pelunasan2 = data.pembayaran[0][z].pelunasan;
                         totalpembayaran2 = parseFloat(parseFloat(totalpembayaran2) + parseFloat(pelunasan2)).toFixed(2);
                      }


                    for(var j = 0; j < data.pembayaran.length; j++){
                     for(var k=0; k < data.pembayaran[j].length; k++){
                       pelunasan = data.pembayaran[j][k].pelunasan;
                     
                     // alert(pelunasan);
                      totalpembayaran = parseFloat(parseFloat(totalpembayaran) + parseFloat(pelunasan)).toFixed(2);
                     
                   //   alert(totalpembayaran);
                  
                       var rowpembayaran = "<tr class='bayar"+data.pembayaran[j][k].idfp+"'> <td>"+ nopembayaran+"</td>"+
                                        "<td>"+data.pembayaran[j][k].nofpg+"</td>"+ //NOFPG
                                        "<td>"+data.pembayaran[j][k].tgl+"</td>"+ // TGLFPG
                                        "<td>"+addCommas(data.pembayaran[j][k].pelunasan)+"</td>"; //PEMBAYARAN
                       nopembayaran++;
                       $('#tbl-pembayaran').append(rowpembayaran);
                     }
                    }
                   
                      $('.pembayaran').val(addCommas(totalpembayaran2));
                  }
                  else {
                    $('.pembayaran').val('0.00');
                  }
                  
                      if(jenisbayar == '2'){
                        cndn = data.cndn;
                  /*    $("table#table-debit tr#datacredit").remove();
                      $("table#table-kredit tr#datadebit").remove();*/

                       for($p = 0; $p < data.cndn.length; $p++){                      
                             for($c = 0 ; $c < data.cndn[$p].length; $c++){
                               if(data.cndn[$p][$c].cndn_jeniscndn == 'D'){
                                  $n = 1;
                                 row = "<tr id='datacredit'>" +
                                "<td>"+$n+" 1</td>" +
                                "<td>"+cndn[$p][$c].cndn_nota+"</td>" +
                                "<td>"+cndn[$p][$c].fp_nofaktur+"</td>" +
                                "<td>"+cndn[$p][$c].cndn_tgl+"</td>" +
                                "<td>"+addCommas(cndn[$p][$c].cndn_bruto)+" <input type='hidden' class='dnbruto' value='"+cndn[$p][$c].cndn_bruto+"'>"+
                                 "<input type='hidden' value='"+cndn[$p][$c].cndn_id+"' name='idcndn[]'>" + //idcn
                                 "<input type='hidden' value='"+cndn[$p][$c].cndt_idfp+"' name='idcnfp[]'>" + //idfp
                                 "<input type='hidden' value='"+cndn[$p][$c].cndt_nettocn+"' name='nettocn[]'>" + //idfp
                                "</td>" +
                                "</tr>";
                                $('#table-debit').append(row);  
                                $n++;  
                               }
                             else {
                              $n = 1;
                              row = "<tr id='datadebit'>" +
                                      "<td>"+$n+"</td>" +
                                      "<td>"+cndn[$p][$c].cndn_nota+"</td>" +
                                      "<td>"+cndn[$p][$c].fp_nofaktur+"</td>" +
                                      "<td>"+cndn[$p][$c].cndn_tgl+"</td>" +
                                      "<td>"+addCommas(cndn[$p][$c].cndn_bruto)+" <input type='hidden' class='cnbruto' value='"+cndn[$p][$c].cndn_bruto+"'>" +
                                         "<input type='hidden' value='"+cndn[$p][$c].cndn_id+"' name='idcndn[]'>" + //idcn
                                         "<input type='hidden' value='"+cndn[$p][$c].cndt_idfp+"' name='idcnfp[]'>" + //idfp
                                         "<input type='hidden' value='"+cndn[$p][$c].cndt_nettocn+"' name='nettocn[]'>" + //idfp
                                      "</td>" +
                                      "</tr>";
                              $('#table-kredit').append(row);
                              $n++;
                             }
                          }                         
                        }
                          $no = 1;
                          uangmuka = data.uangmuka
                        for($i = 0; $i < data.uangmuka.length; $i++){

                              row = "<tr id='datadebit'>" +
                                      "<td>"+$no+"</td>" +
                                      "<td>"+uangmuka[$i].umfpdt_notaum+"</td>" +
                                      "<td>"+uangmuka[$i].fp_nofaktur+"</td>" +
                                      "<td>"+uangmuka[$i].umfpdt_tgl+"</td>" +
                                      "<td>"+addCommas(uangmuka[$i].umfp_totalbiaya)+
                                      "</td>" +
                                      "</tr>";
                              $('#tableum').append(row);
                              $no++;
                              $('.uangmuka').val(uangmuka[0].um_akunhutang); 

                        }
                      }
                      

                    $('#myModal5').modal('hide');
                      $('.check').attr('checked' , false);

                      if(jenisbayar == '2' || jenisbayar == '6' || jenisbayar == '7' || jenisbayar == '9') {
                          $('.nofaktur').val(data.faktur[0][0].fp_nofaktur);
                          $('.tgl').val(data.faktur[0][0].fp_tgl);
                          $('.jatuhtempo').val(data.faktur[0][0].fp_jatuhtempo);
                          $('.formtt').val(data.faktur[0][0].tt_noform);
                         // $('.jthtmpo_bank').val(data.faktur[0][0].fp_jatuhtempo);
                            
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].fp_sisapelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].fp_sisapelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].fp_netto));
                          if(data.faktur[0][0].fp_uangmuka == null){
                              $('.uangmukakanan').val('0.00');
                          }
                          else {
                              $('.uangmukakanan').val(addCommas(data.faktur[0][0].fp_uangmuka)); 
                          }

                          if(data.faktur[0][0].fp_creditnota == null){
                            $('.cnkanan').val('0.00');
                          }
                          else {
                            $('.cnkanan').val(addCommas(data.faktur[0][0].fp_creditnota));
                          }

                          if(data.faktur[0][0].fp_debitnota == null){
                            $('.dnkanan').val('0.00');
                          }
                          else {
                            $('.dnkanan').val(addCommas(data.faktur[0][0].fp_debitnota));
                          }

                          $('.hutangdagang').val(data.faktur[0][0].fp_acchutang); 
                          $('.cabangfaktur').val(data.faktur[0][0].fp_comp);

                     //LOOPING DATA NO FAKTUR 

                    for(var i = 0 ; i < data.faktur.length; i++){
                       nmr++;
                        totalpembayaranfp = 0;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].pelunasan;
                           // alert(pelunasan);
                            totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                        }


                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"' data-nota='"+data.faktur[i][0].fp_nofaktur+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"' data-idfaktur="+data.faktur[i][0].fp_idfaktur+">"+data.faktur[i][0].fp_nofaktur+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].fp_nofaktur+" name='nofaktur[]'> <input type='hidden' class='datanofaktur'  value="+data.faktur[i][0].fp_idfaktur+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].fp_tgl+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].fp_tgl+"></td>" + //tgl

                                  "<td>"+data.faktur[i][0].fp_jatuhtempo+" <input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].fp_jatuhtempo+" name='jatuhtempo[]'> </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].fp_netto)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].fp_sisapelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].fp_netto+" name='netto[]'> <input type='hidden' class='formtt"+nmr+"' value="+data.faktur[i][0].tt_noform+"> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].fp_idfaktur+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].fp_sisapelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> <input type='hidden' class='debitnota"+nmr+"' value="+data.faktur[i][0].fp_debitnota+"> <input type='hidden' class='creditnota"+nmr+"' value="+data.faktur[i][0].fp_creditnota+"> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control' name='fpgdt_keterangan[]'> </td>" +

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].fp_nofaktur+" data-idfaktur="+data.faktur[i][0].fp_idfaktur+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";

                            $('.tbl-item').append(row);
                          
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                      }

                    

                      tblitem = $('.field').length;
                 //     console.log('tblitem2' + tblitem);
                       arrnofaktur = [];
     
                      var nmr2 = 1;
                      for(var z =0; z < tblitem; z++ ){
                        val = $('.nofaktur'+nmr2 ).val();
                   //     console.log(val + 'val');
                        nmr2++;
                         arrnofaktur.push(val);
                      }
                     
                    } // END SUPPLIER HUTANG DAGANG

                    else if(jenisbayar == '3'){
                         $('.nofaktur').val(data.faktur[0][0].v_nomorbukti);
                          $('.tgl').val(data.faktur[0][0].v_tgl);
                          $('.jatuhtempo').val(data.faktur[0][0].v_tempo);
                        //  $('.formtt').val(data.faktur[0][0].tt_noform);
                         // $('.jthtmpo_bank').val(data.faktur[0][0].fp_jatuhtempo);
                          
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].v_pelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].v_pelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].v_hasil));
                           $('.cabangfaktur').val(data.faktur[0][0].vc_comp);
                           $('.hutangdagang').val(data.faktur[0][0].v_acchutang);


                     //LOOPING DATA NO FAKTUR 
                    for(var i = 0 ; i < data.faktur.length; i++){
                       nmr++;
                        totalpembayaranfp = 0;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].pelunasan;
                           // alert(pelunasan);
                            totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                        }


                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"' data-nota='"+data.faktur[i][0].v_nomorbukti+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"' data-idfaktur="+data.faktur[i][0].v_id+">"+data.faktur[i][0].v_nomorbukti+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].v_nomorbukti+" name='nofaktur[]'> <input type='hidden' class='datanofaktur'  value="+data.faktur[i][0].v_id+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].v_tgl+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].v_tgl+"></td>" + //tgl

                                  "<td>"+data.faktur[i][0].v_tempo+" <input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].v_tempo+" name='jatuhtempo[]'> </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].v_hasil)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].v_pelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].v_hasil+" name='netto[]'> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].v_id+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].v_pelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control' name='fpgdt_keterangan[]'> </td>" +

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].v_nomorbukti+" data-idfaktur="+data.faktur[i][0].v_id+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";


                            $('.tbl-item').append(row);
                          
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                       }

                    

                            tblitem = $('.field').length;
                       //     console.log('tblitem2' + tblitem);
                             arrnofaktur = [];
           
                            var nmr2 = 1;
                            for(var z =0; z < tblitem; z++ ){
                              val = $('.nofaktur'+nmr2 ).val();
                         //     console.log(val + 'val');
                              nmr2++;
                               arrnofaktur.push(val);
                            }
                    }
                    
					// UANG MUKA PEMBELIAN
					 else if(jenisbayar == '4'){
                         $('.nofaktur').val(data.faktur[0][0].um_nomorbukti);
                          $('.tgl').val(data.faktur[0][0].um_tgl);
/*                          $('.jatuhtempo').val(data.faktur[0][0].v_tempo);
*/                        //  $('.formtt').val(data.faktur[0][0].tt_noform);
                         // $('.jthtmpo_bank').val(data.faktur[0][0].fp_jatuhtempo);
                          
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].um_sisapelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].um_sisapelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].um_jumlah));
                          $('.hutangdagang').val(data.faktur[0][0].um_akunhutang); 
                            $('.cabangfaktur').val(data.faktur[0][0].um_comp);


                     //LOOPING DATA NO FAKTUR 

                    for(var i = 0 ; i < data.faktur.length; i++){
                       nmr++;
                        totalpembayaranfp = 0;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].pelunasan;
                           // alert(pelunasan);
                            totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                        }


                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"' data-nota='"+data.faktur[i][0].um_nomorbukti+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"' data-idfaktur="+data.faktur[i][0].um_id+">"+data.faktur[i][0].um_nomorbukti+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].um_nomorbukti+" name='nofaktur[]'> <input type='hidden' class='datanofaktur'  value="+data.faktur[i][0].um_id+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].um_tgl+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].um_tgl+"></td>" + //tgl

                                  "<td style='text-align:center'> - </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].um_jumlah)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].um_sisapelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].um_jumlah+" name='netto[]'> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].um_id+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].um_sisapelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control' name='fpgdt_keterangan[]'> </td>" +

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].um_nomorbukti+" data-idfaktur="+data.faktur[i][0].um_id+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";

                            $('.tbl-item').append(row);
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                       }
                            tblitem = $('.field').length;
                       //     console.log('tblitem2' + tblitem);
                             arrnofaktur = [];
           
                            var nmr2 = 1;
                            for(var z =0; z < tblitem; z++ ){
                              val = $('.nofaktur'+nmr2 ).val();
                         //     console.log(val + 'val');
                              nmr2++;
                               arrnofaktur.push(val);
                            }
                    }

             // GIRO KAS KECIL
               else if(jenisbayar == '1'){
                         $('.nofaktur').val(data.faktur[0][0].ik_nota);
                          $('.tgl').val(data.faktur[0][0].ik_tgl_akhir);
/*                          $('.jatuhtempo').val(data.faktur[0][0].v_tempo);
*/                        //  $('.formtt').val(data.faktur[0][0].tt_noform);
                         // $('.jthtmpo_bank').val(data.faktur[0][0].fp_jatuhtempo);
                          
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].ik_pelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].ik_pelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].ik_total));
                          $('.hutangdagang').val(data.faktur[0][0].ik_akunhutang); 
                          


                     //LOOPING DATA NO FAKTUR 
                    for(var i = 0 ; i < data.faktur.length; i++){
                       nmr++;
                        totalpembayaranfp = 0;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].pelunasan;
                           // alert(pelunasan);
                            totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                        }


                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"' data-nota='"+data.faktur[i][0].ik_nota+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"' data-idfaktur="+data.faktur[i][0].ik_id+">"+data.faktur[i][0].ik_nota+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].ik_nota+" name='nofaktur[]'> <input type='hidden' class='datanofaktur'  value="+data.faktur[i][0].ik_id+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].ik_tgl_akhir+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].ik_tgl_akhir+"></td>" + //tgl

                                  "<td style='text-align:center'> - </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].ik_total)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].ik_pelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].ik_total+" name='netto[]'> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].ik_id+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].ik_pelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control' name='fpgdt_keterangan[]'> </td>" +

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].ik_nota+" data-idfaktur="+data.faktur[i][0].ik_id+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";

                           
                             

                            $('.tbl-item').append(row);
                        
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                       }

                          
                     
                            tblitem = $('.field').length;
                       //     console.log('tblitem2' + tblitem);
                             arrnofaktur = [];
           
                            var nmr2 = 1;
                            for(var z =0; z < tblitem; z++ ){
                              val = $('.nofaktur'+nmr2 ).val();
                         //     console.log(val + 'val');
                              nmr2++;
                               arrnofaktur.push(val);
                            }
                    }
                    else if( jenisbayar == '11'){
                         $('.nofaktur').val(data.faktur[0][0].bp_nota);
                          $('.tgl').val(data.faktur[0][0].bp_tgl);
/*                          $('.jatuhtempo').val(data.faktur[0][0].v_tempo);
*/                        //  $('.formtt').val(data.faktur[0][0].tt_noform);
                         // $('.jthtmpo_bank').val(data.faktur[0][0].fp_jatuhtempo);
                          
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].bp_pelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].bp_pelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].bp_nominalkeu));
                          $('.hutangdagang').val(data.faktur[0][0].bp_akunhutang); 
                            $('.cabangfaktur').val(data.faktur[0][0].bp_akunhutang);


                     //LOOPING DATA NO FAKTUR 

                    for(var i = 0 ; i < data.faktur.length; i++){
                       nmr++;
                        totalpembayaranfp = 0;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].pelunasan;
                           // alert(pelunasan);
                            totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                        }


                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"' data-nota='"+data.faktur[i][0].bp_nota+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"' data-idfaktur="+data.faktur[i][0].bp_id+">"+data.faktur[i][0].bp_nota+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].bp_nota+" name='nofaktur[]'> <input type='hidden' class='datanofaktur'  value="+data.faktur[i][0].bp_id+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].bp_tgl+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].bp_tgl+"></td>" + //tgl

                                  "<td style='text-align:center'> - </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].bp_nominalkeu)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].bp_pelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].bp_nominalkeu+" name='netto[]'> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].bp_id+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].bp_pelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control' name='fpgdt_keterangan[]'> </td>" +

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].bp_nota+" data-idfaktur="+data.faktur[i][0].bp_id+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";

                            $('.tbl-item').append(row);
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                       }
                            tblitem = $('.field').length;
                       //     console.log('tblitem2' + tblitem);
                             arrnofaktur = [];
           
                            var nmr2 = 1;
                            for(var z =0; z < tblitem; z++ ){
                              val = $('.nofaktur'+nmr2 ).val();
                         //     console.log(val + 'val');
                              nmr2++;
                               arrnofaktur.push(val);
                            }
                    }
	
						
//                        alert(hasilsisaterbayar);

              $('.nofp').click(function(){
                id = $(this).data('id');
                idfaktur = $(this).data('idfaktur');
                $('.id').val(id);
                sisapelunasan =   $('.sisapelunasan' + id).val();
                sisaterbayar =   $('.sisa_terbayar' + id).val();
                pembayaran = $('.pembayaranitem' + idfaktur).val();
                

                creditnota = $('.creditnota' + id).val();
                debitnota = $('.debitnota' + id).val();
                if(creditnota == null){
                  creditnota = '0.00';
                }
                else {
                  creditnota = creditnota;
                }

                if(debitnota == null){
                  debitnota = '0.00';
                }
                else {
                  debitnota = debitnota;
                }


                netto = $('.netto' + id).val();
                $('.sisatrbyr').val(addCommas(sisapelunasan));
                $('.sisafaktur').val(addCommas(sisaterbayar));
                $('.pelunasan').attr('readonly' , false);
                $('.jmlhfaktur').val(addCommas(netto));
                $('.pelunasan').val('');
                $('.pembayaran').val(addCommas(pembayaran));
                  jumlahpelunasan = 0;

                $('.dnkanan').val(addCommas(debitnota));
                $('.cnkanan').val(addCommas(creditnota));

                hasilpelunasan = $('.pelunasan' + id).val();
                $('.pelunasan').val(hasilpelunasan);

                nofaktur = $('.nofaktur' + id).val();
                tgl = $('.tgl' + id).val();
                jatuhtempo = $('.jatuhtempo' + id).val();
                formtt = $('.formtt' + id).val();


                 $('.nofaktur').val(nofaktur);
                 $('.tgl').val(tgl);
                 $('.jatuhtempo').val(jatuhtempo);
                 $('.formtt').val(formtt);
              })

               $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    var nofaktur = $(this).data('faktur');
                    var nmrfaktur = $(this).data('nmrfaktur');
                    var idfaktur = $(this).data('idfaktur');
                   // toastr.info('nmr');
                    parent = $('#field'+id);
                     
                    //parents = $('.field')
                    pelunasan = $('.pelunasan' + id).val();
                    hslpelunasan =  pelunasan.replace(/,/g, '');
                    totalbayar = $('.totbayar').val();
                    //alert(totalbayar);
                    if(totalbayar != ''){
                      hsltotalbayar = totalbayar.replace(/,/g, '');
                      $('tr.data'+nmrfaktur).show();

                      index = arrnofaktur.indexOf(nofaktur);
                      arrnofaktur.splice(index, 1);

                      dikurangi = parseInt(hsltotalbayar) - parseInt(hslpelunasan);
                      dikurangi = dikurangi.toFixed(2);
                      
                      $('.totbayar').val(addCommas(dikurangi));
                      $('.nominal').val(addCommas(dikurangi));
                    }

                    $('.sisafaktur').val('');
                      $('.sisatrbyr').val('');
                      $('.jmlhfaktur').val('');
                      $('.pelunasan').val('');
                      $('.pembayaran').val('');      
                      
                      $('.jmlhfaktur').val('');
                      $('.pembayaran').val('');
                      $('.cnkanan').val('');
                      $('.dnkanan').val('');
                      $('.sisatrbyr').val('');
                      $('.pelunasan').val('');
                      $('.sisafaktur').val('');


                    //alert('test');
                     parentbayar = $('.bayar'+idfaktur);
                    parent.remove();
                    parentbayar.remove();
                })


                  } // end success
          })
        
     })

     nomrbnk = 1;
     arrnohapus = [];
    $('#buttongetcek').click(function(){

        lengthbank = $('.tblbank').length;
        databank = $('.bank').val();
        $('.valbank').val(databank);
     

        $('.metodebayar').attr('disabled' , true);

        if(lengthbank > 1){
          $('.nominal').attr('readonly', true);
        }

        nominaltujuan = $('.nominaltujuanbank').val();
        

        jenisbayar = $('.jenisbayar').val();
        if(jenisbayar == 12 || jenisbayar == 11){
          banktujuan = $('.banktujuan').val();
          if(banktujuan == ''){
            toastr.info("Mohon maaf bank tujuan belum dipilih :)");
            return false;
          }
        }
       var checked = $(".checkcek:checked").map(function(){
          return this.id;
        }).toArray();

      // variabel = [];
       idmb = [];
       nobank = [];
       mbid = checked;
     

        variabel = [];
        variabel = checked;
        idfp = [];
        nmrf =[];
        nofaktur = [];

        for(z=0;z<mbid.length;z++){
          string = mbid[z].split(",");
          idmb.push(string[0]);    
          nobank.push(string[1]);
        }


        for(var z=0; z <nobank.length; z++){
          $('tr#datacek'+nobank[z]).hide();
        }
         $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getakunbg',
                  data : {idmb},
                  type : "post",
                  dataType : "json",
                  success : function(data) {

                    bank = $('.bank').val();
                    explode = bank.split(",");
                    kodebank = explode[4];
                    $('.hutangbank').val(kodebank);

                    $('#myModal2').modal('hide');

                    $('.checkcek').attr('checked' , false);
                    $('.nocheck').val(data.mbdt[0][0].mbdt_noseri);

                    nominalbank = $('.nominal').val();
                    nofpg = $('.nofpg').val();
                    tgl = $('.tgl').val();

                    mbdt = data.mbdt;
                    
                    metodebayar = $('.metodebayar:checked').val();
                    jenisbayar = $('.jenisbayar').val();

                    if(jenisbayar == 11){
                      if(metodebayar == 'CHECK/BG'){
                        jenisbayar = $('.jenisbayar').val();
                        if(jenisbayar == 5){
                          $('.jthtmpo_bank').attr('disabled' , true);
                          //$('.hari_bank').attr('disabled', true);
                          jatuhtempo = $('.jthtmpo_bank').val();
                        }
                        else {
                          jatuhtempo = $('.jthtmpo_bank').val();      
                        }

                        banktujuan = $('.banktujuan').val();
                        split = banktujuan.split("+");
                        kodebanktujuan = split[4];
                        norekening = split[3];
                        namabank = split[1];
                        idbank = split[0];


                        for(var i =0 ; i < mbdt.length; i++ ){                    
                           var row = "<tr class='tblbank' id='datas"+nomrbnk+"'> <td>"+nomrbnk+"</td>  <td>"+nofpg+"</td>" + // NO FPG
                            "<td>  <a class='noseri'  data-id='"+nomrbnk+"'> "+mbdt[i][0].mbdt_noseri+ "</a> <input type='hidden' class='noseri"+nomrbnk+"' value='"+mbdt[i][0].mbdt_noseri+"' name='noseri[]'></td>"+ // NOSERI

                            "<td>"+tgl+"</td>"+ // TGL
                            "<td>"+mbdt[i][0].mb_kode+"</td> <td> <input type='text' class='form-control kodebanktujuan' value='"+kodebanktujuan+"' name='kodebanktujuan[]' readonly> </td>" + //BANK TUJUAN
                            "<td> <input type='text' class='form-control norekening' value='"+norekening+"' readonly> </td>" + //NO REKENING TUJUAN
                            "<td> <input type='text' class='form-control namarekening' value='"+namabank+"' name='namabanktujuan[]' readonly> <input type='hidden' class='form-control idbanktujuan' value='"+idbank+"' name='idbanktujuan[]'></td>" + //NAMA BANK TUJUAN
                            "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+"' readonly name='nominalbank[]' style='text-align:right' required> </td>" + //NOMINAL
                            "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"'  data-idbankdt="+mbdt[i][0].mbdt_id+" type='button'><i class='fa fa-trash'></i></button></td> </tr>";

                            $('#tbl-tfbank').append(row);
                            arrnohapus.push(nomrbnk);
                            nomrbnk++;
                        }
                      }
                    }
                    else{

                      if(jenisbayar == '12') {
                        banktujuan = $('.banktujuan').val();
                        split = banktujuan.split("+");
                        kodebanktujuan = split[4];
                        norekening = split[3];
                        namabank = split[1];
                        idbank = split[0];
                        kelompok = split[5];

                        if(metodebayar == 'CHECK/BG'){
                          for(var i =0 ; i < mbdt.length; i++ ){
                            
                              if(mbdt[i][0].mb_kode.match(/1099.*/)){
                                $('.kelompokbank').val('BEDA BANK');
                              }
                              else {
                               if(mbdt[i][0].mb_kelompok == kelompok){
                                 $('.kelompokbank').val('SAMA BANK');
                                }
                                else {
                                  toastr.info("Mohon maaf, tidak bisa beda bank :)");
                                  return false;
                                }
                              }

                            var row = "<tr class='tblbank' id='datas"+nomrbnk+"'> <td>"+nomrbnk+"</td>  <td>"+nofpg+"</td>" + // NO FPG
                            "<td>  <a class='noseri'  data-id='"+nomrbnk+"'> "+mbdt[i][0].mbdt_noseri+ "</a> <input type='hidden' class='noseri"+nomrbnk+"' value='"+mbdt[i][0].mbdt_noseri+"' name='noseri[]'></td>"+ // NOSERI

                            "<td>"+tgl+"</td>"+ // TGL
                            "<td>"+mbdt[i][0].mb_kode+"</td> <td> <input type='text' class='form-control kodebanktujuan' value='"+kodebanktujuan+"' name='kodebanktujuan[]' readonly> </td>" + //BANK TUJUAN
                            "<td> <input type='text' class='form-control norekening' value='"+norekening+"' readonly> </td>" + //NO REKENING TUJUAN
                            "<td> <input type='text' class='form-control namarekening' value='"+namabank+"' name='namabanktujuan[]' readonly> <input type='hidden' class='form-control idbanktujuan' value='"+idbank+"' name='idbanktujuan[]'> <input type='text' class='kelompokbank' name='kelompokbank'> </td>" + //NAMA BANK TUJUAN
                            "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+"' readonly name='nominalbank[]' style='text-align:right' required> </td>" + //NOMINAL
                            "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"'  data-idbankdt="+mbdt[i][0].mbdt_id+" type='button'><i class='fa fa-trash'></i></button></td> </tr>";

                            $('#tbl-tfbank').append(row);
                            arrnohapus.push(nomrbnk);
                            nomrbnk++;

                              if(mbdt[i][0].mb_kode.match(/1099.*/)){
                                $('.kelompokbank').val('BEDA BANK');
                              }
                              else {
                               if(mbdt[i][0].mb_kelompok == kelompok){
                                 $('.kelompokbank').val('SAMA BANK');
                                }
                              }
                          }
                        }
                      }
                      else {
                        if(metodebayar == 'CHECK/BG'){
                        
                        jenisbayar = $('.jenisbayar').val();
                        if(jenisbayar == 5){
                          $('.jthtmpo_bank').attr('disabled' , true);
                          //$('.hari_bank').attr('disabled', true);
                          jatuhtempo = $('.jthtmpo_bank').val();
                        }
                        else {
                          jatuhtempo = $('.jthtmpo_bank').val();      
                        }

                        for(var i =0 ; i < mbdt.length; i++ ){                    
                          var row = "<tr class='tblbank' id='datas"+nomrbnk+"'> <td>"+nomrbnk+"</td>  <td>"+nofpg+"</td>" + // NO FPG
                          "<td>  <a class='noseri'  data-id='"+nomrbnk+"'> "+mbdt[i][0].mbdt_noseri+ "</a> <input type='hidden' class='noseri"+nomrbnk+"' value='"+mbdt[i][0].mbdt_noseri+"' name='noseri[]'></td>"+ // NOSERI

                          "<td>"+tgl+"</td>"+ // TGL
                          "<td>"+mbdt[i][0].mb_kode+"</td> <td> <input type='text' class='form-control jatuhtempotblbank' value='"+jatuhtempo+"'> </td>" + //JATUH TEMPO
                          "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+"' readonly name='nominalbank[]' style='text-align:right' required> </td>" + //NOMINAL
                          "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"'  data-idbankdt="+mbdt[i][0].mbdt_id+" type='button'><i class='fa fa-trash'></i></button></td> </tr>";

                          $('#tbl-bank').append(row);
                          arrnohapus.push(nomrbnk);
                          nomrbnk++;
                        }
                       }
                      }
                    }
                    // IF CHECKBG
                  
                    if(jenisbayar == '12'){
                      $('.nominalbank1').val(nominaltujuan);
                      $('.ChequeBg').val(nominaltujuan);  
                    }
                    else {
                      $('.nominalbank1').val(nominalbank);
                      $('.ChequeBg').val(nominalbank);
                    }

                    $('.bank').prop('disabled' , true).trigger("liszt:updated");
                     $('.bank').prop('disabled', true).trigger("chosen:updated");

                      $(document).on('click','.remove-btn',function(){

                        //alert(nomrbnk);
                          nohapus = nomrbnk - 1;
                         // alert(nohapus);
                          var id = $(this).data('id');

                          if(id == 1) {
                            $('.nocheck').val('');
                            $('.nominal').val('');
                          }

                       //   alert(arrnohapus);
                          if(id == 1){
                            if(arrnohapus.length == 2){
                              // alert(nominalbank);
                           //   nominaltblbank = $('.nominalbank'+arrnohapus[0]).val();
                              noseritblbank = $('.noseri'+arrnohapus[1]).val();
                              $('.nominal').val(nominalbank);
                              $('.nocheck').val(noseritblbank);
                            }
                            else {
                              for(var j = 0; j < arrnohapus.length; j++){
                                nominaltblbank = $('.nominalbank'+arrnohapus[j]).val();
                                noseritblbank = $('.noseri'+arrnohapus[j]).val();
                                $('.nominal').val(nominaltblbank);
                                $('.nocheck').val(noseritblbank);
                                
                               }
                            }
                            
                          }
                         /* $('.jthtmpo_bank').val('');
                          $('.hari_bank').val('');*/
                         // toastr.info('nmr');
                          
                          parent = $('tr#datas'+id);
                          $('tr#datacek'+id).show();
                          nominalbank = $('.nominalbank' + id).val();

                        
                        
                           if(nominalbank != ''){
                              Totalcheq = $('.ChequeBg').val();
                              if(Totalcheq != ''){
                                aslinominal = nominalbank.replace(/,/g, '');
                                 aslitotal = Totalcheq.replace(/,/g, '');
                                dikurangi = parseInt(aslitotal) - parseInt(aslinominal);
                             
                                
                                dikurangi = dikurangi.toFixed(2);
                                $('.ChequeBg').val(dikurangi);

                              }
                           }
                        
                          parent.remove();
                      })

                      $('.noseri').click(function(){

                        val = $(this).val();
                        id = $(this).data("id");
                        $('.nominal').attr('readonly', false);
                   //     toastr.info(id);
                        var noseri =  $('.noseri' + id).val();
                         //   toastr.info(noseri);
                        $('.nocheck').val(noseri);
                        $('.idbank').val(id);
                        nominaltbl =  $('.nominalbank' + id).val();
                        nominalheader = $('.nominal').val();
                   //     alert(nominal);

                        if(nominalheader != ''){
                            $('.nominal').val(nominaltbl);
                        }
                        else {
                          $('.nominal').val('');
                        }

                      })
                  }
          })


    })

      
  
     //bank
     $('.bank').change(function(){
      val = $(this).val();
      string = val.split(",");
      namabank = string[1];
      alamat = string[2];
      account = string[3];
      id = string[0];

      $('.valbank').val(val);
      $('.nmbank').val(namabank);
      $('.cbgbank').val(alamat);
      $('.account').val(account);
      $('.kodebankbg').val(string[4]);
      $.ajax({
          type : "post",
          data : {id},
          url : baseUrl+'/formfpg/getkodeakun',
          dataType : 'json',
          success : function (response){
            table = response.table;
             $('.hutangbank').val(string[4]);
          var tablecek = $('#tbl-cheuque').DataTable();
          tablecek.clear().draw();
            var nmrbnk = 1;
            for(var i = 0; i < table.length; i++){                                   
                var html2 = "<tr class='bank"+nmrbnk+"' id='datacek"+nmrbnk+"'> <td>"+nmrbnk+"</td>" +
                                  "<td>"+table[i].mb_kode+"</td>" +
                                  "<td>"+table[i].mb_nama+"</td>"+
                                  "<td>"+table[i].mbdt_noseri+"</td>";
                                  if(table[i].mbdt_nofpg == null){
                                  html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_nofpg+"</td>";
                                  }
                                   if(table[i].mbdt_nominal == null || table[i].mbdt_nominal == 0.00 ){
                                      html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_nominal+"</td>";
                                  }
                                  
                                  if(table[i].mbdt_setuju == null || table[i].mbdt_setuju == ''){
                                     html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_setuju+"</td>";
                                  }

                                   if(table[i].mbdt_rusak == null || table[i].mbdt_rusak == ''){
                                     html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_rusak+"</td>";
                                  }


                          if(table[i].mbdt_nofpg == null || table[i].mbdt_nofpg  == '' ){
                             html2 += "<td><div class='checkbox'> <input type='checkbox' id="+table[i].mbdt_id+","+nmrbnk+" class='checkcek' value='option1' aria-label='Single checkbox One'>";
                          }
                          else {
                            html2 += "<td> </td>";
                          }

                   
                html2 +=  "<label></label>" +
                  "</div></td>";
                                
                 html2 +=  "</tr>"; 
                 tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }    
          }

     })

    })

       $('.bank1').change(function(){
      val = $(this).val();
      string = val.split(",");
      namabank = string[1];
      alamat = string[2];
      account = string[3];
      id = string[0];

      $('.nmbank1').val(namabank);
     /* $.ajax({
          type : "post",
          data : {id},
          url : baseUrl+'/formfpg/getkodeakun',
          dataType : 'json',
          success : function (response){
            table = response.table;
            console.log(table);

          var tablecek = $('#tbl-cheuque').DataTable();
          tablecek.clear().draw();
            var nmrbnk = 1;
            for(var i = 0; i < table.length; i++){                                   
                var html2 = "<tr class='bank"+nmrbnk+"' id='datacek"+nmrbnk+"'> <td>"+nmrbnk+"</td>" +
                                  "<td>"+table[i].mb_kode+"</td>" +
                                  "<td>"+table[i].mb_nama+"</td>"+
                                  "<td>"+table[i].mbdt_noseri+"</td>";
                                  if(table[i].mbdt_nofpg == null){
                                  html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_nofpg+"</td>";
                                  }
                                   if(table[i].mbdt_nominal == null || table[i].mbdt_nominal == 0.00 ){
                                      html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_nominal+"</td>";
                                  }
                                  
                                  if(table[i].mbdt_setuju == null || table[i].mbdt_setuju == ''){
                                     html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_setuju+"</td>";
                                  }

                                   if(table[i].mbdt_rusak == null || table[i].mbdt_rusak == ''){
                                     html2 +=  "<td> </td>";
                                  }
                                  else {
                                     html2 +=  "<td>"+table[i].mbdt_rusak+"</td>";
                                  }


                          if(table[i].mbdt_nofpg == null || table[i].mbdt_nofpg  == '' ){
                             html2 += "<td><div class='checkbox'> <input type='checkbox' id="+table[i].mbdt_id+","+nmrbnk+" class='checkcek' value='option1' aria-label='Single checkbox One'>";
                          }
                          else {
                            html2 += "<td> </td>";
                          }

                   
                html2 +=  "<label></label>" +
                  "</div></td>";
                                
                 html2 +=  "</tr>"; 
                 tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }    
          }

     })*/

    })


     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
   arrnofaktur =[];
     
    // Getter
    $('.jenisbayar').change(function(){     
      idjenis = $(this).val(); 

      nofpg = $('.nofpg').val();
      if(nofpg == ''){
        toastr.info('Data No FPG belum ada, form akan reload otomatis');
        location.reload();
      }
     /* alert(idjenis);*/
      if(idjenis == 12 ||idjenis == 11){
         $('#tbl-bank').hide();  
         $('#tbl-ibank').hide();  
         $('.transferbank').show();
         $('.tujuanbankacc').show();
          $('.checkbgtf').hide();
      }
      else {
        metodebayar = $('.metodebayar').val();
        if(metodebayar == 'INTERNET BANKING'){
                $('.jenisbayarbankbg').prop({ checked: false });           
                  $('.tujuanbank').hide();
                  $('.tujuanbankacc').hide();
                  $('.transferbank').hide();
                  $('.checkbgtf').hide();
                  $('.ibanking').show();
        }
        else {

        }
      }
     

      var tablefaktur = $('#tbl-faktur').DataTable();  
      tablefaktur.clear().draw();
        $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getjenisbayar',
                  data : {idjenis},
                  type : "get",
                  dataType : "json",
                  success : function(data) {
                    var response = data['isi'];
                 
                    $('.jenisbayar2').empty();
                    $('.jenisbayar2').trigger("chosen:updated");
                    $('.jenisbayar2').trigger("liszt:updated");

                    if(idjenis == '2' || idjenis == '3'){  
                     
                       $('.jenisbayar2').attr('disabled' , false);

                      $('.jenisbayar2').empty();   
                          $('.jenisbayar2').append("<option value='' selected> Pilih Supplier </option>");                
                      for(var j=0; j<response.length; j++){  
                                    
                         $('.jenisbayar2').append("<option value="+response[j].idsup+","+response[j].no_supplier+">"+response[j].no_supplier+" - "+response[j].nama_supplier+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      }                     
                    }   
                    else if(idjenis == '6'){
                       $('.jenisbayar2').attr('disabled',false);

                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Agen  </option>");  
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value='"+response[j].nama+","+response[j].kode+"'>"+response[j].kode+" - "+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      } 
                    }
                    else if(idjenis == '7'){
                        
                        $('.jenisbayar2').attr('disabled',false);
                        $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Outlet  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].nama+","+response[j].kode+">"+response[j].kode+" - "+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }
                    else if(idjenis == '9'){
                       $('.jenisbayar2').attr('disabled' , false);
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Vendor  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value='"+response[j].nama+","+response[j].kode+"'>"+response[j].kode+" - "+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }
                    else if(idjenis == '1'){
                        $('.jenisbayar2').val(cabang);
                   
                        $('.jenisbayar2').attr('disabled' , true);

                        $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Cabang  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value='"+response[j].nama+","+response[j].kode+"'>"+response[j].kode+" - "+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 

                        cabang = $('.cabang').val();
                       

                       // alert(cabang);
/*                        if(cabang != 000){
                          $('.jenisbayar2').val(cabang);
                          $('.jenisbayar2').prop('disabled', true).trigger("liszt:updated");
                          $('.jenisbayar2').prop('disabled', true).trigger("chosen:updated");
                        }*/

                    }
                    else if(idjenis == '4'){
                        $('.jenisbayar2').attr('disabled' , false);
                        $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Data  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+","+response[j].kode+">"+response[j].kode+'-'+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }

                  }
        })
            
			 var hslnota = [];
        //button get faktur
   

      cabang = $('.cabang').val();    
      $('.cabangfaktur').val(cabang);
		$('#getDataFaktur').click(function(){
              var tablefaktur = $('#tbl-faktur').DataTable();
              tablefaktur.clear().draw();

            
              var idjenisbayar = $('.jenisbayar').val();
              if(idjenisbayar == '1' || idjenisbayar == '11'){
                nosupplier = cabang;
              } 
              else {
                  var val = $('.jenisbayar2').val();
                split = val.split(",");
                idsup = split[0];
                nosupplier = split[1];
                nosupplier = nosupplier;
                if(idsup == ''){
                toastr.info("Data Supplier belum ada :)");
                return false;
                 }
              }

              cabangfaktur = $('.cabangfaktur').val();
             // alert(cabangfaktur);
              $('.hsljenisbayar').val(val);

             
              //alert(cabangfaktur);
              arrnofaktur = [];
             $('tr.field').each(function(){
                nobukti = $(this).data('nota');
               // alert(nobukti);
                arrnofaktur.push(nobukti);
             })              

             // alert(idsup);
               $.ajax({
                  url : baseUrl + '/formfpg/changesupplier',
                  data : {idsup, idjenisbayar,cabangfaktur, arrnofaktur,nosupplier},
                  type : "get",
                  dataType : "json",
                  success : function(data) {
                 
                    var fp = data.fakturpembelian;
                  
                  
                    var n = 1;
                    if(idjenisbayar == '2' ){
                       var tablefaktur = $('#tbl-faktur').DataTable();
                       tablefaktur.clear().draw();
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                       $('.jthtmpo_bank').val(fp[0].fp_jatuhtempo);
                         
                             for(var i = 0; i < fp.length; i++){ 
                             
                                   var html2 = "<tr class='data"+n+"' id='data"+fp[i].fp_nofaktur+"'> <td>"+n+"</td>" +
                                           "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].fp_nofaktur+"</td>" +
                                          "<td>"+fp[i].fp_noinvoice+"</td>" +                                       
                                        
                                          "<td>"+fp[i].nama_supplier +"</td>"+
                                          "<td>"+fp[i].tt_noform+"</td>";
                                          if(idjenisbayar != '7'){
                                              html2 +=  "<td>"+fp[i].fp_jatuhtempo+"</td>";
                                          }
                                          else {
                                            html2 +=  "<td>- </td>";
                                          }
                                         html2 += "<td>"+addCommas(fp[i].fp_sisapelunasan)+"</td> ";

                                       
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].fp_idfaktur+","+fp[i].fp_nofaktur+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                                
                              }
                          $('.hutangdagang').val(fp[0].fp_acchutang); 
                          $('.cabangfaktur').val(fp[0].fp_comp);
                        }
                    else if(idjenisbayar == '6' || idjenisbayar == '7'|| idjenisbayar == '9') {
                         var tablefaktur = $('#tbl-faktur').DataTable();
                       tablefaktur.clear().draw();
                      $('.supfaktur').show();
                      $('.invfaktur').show(); 
                     // alert(fp.length);                      
                       for(var i = 0; i < fp.length; i++){ 
                           var html2 = "<tr class='data"+n+"' id='data"+fp[i].fp_nofaktur+"'> <td>"+n+"</td>" +
                                       "<td>"+fp[i].namacabang+"</td>" +
                                      "<td>"+fp[i].fp_nofaktur+"</td>" +
                                      "<td> - </td>";                                   
                                      if(idjenisbayar == '9') {
                              html2 +=  "<td>"+fp[i].namavendor +"</td>";                                            
                                      }
                                      else {
                              html2 += "<td>"+fp[i].namaoutlet+"</td>";
                                      }

                                      html2 += "<td> - </td>";
                                      if(idjenisbayar == 6){
                                        html2 += "<td>"+fp[i].fp_jatuhtempo+"</td>";
                                      }
                                      else {
                                        html2 += "<td> - </td>";
                                      }

                                   html2 += "<td>"+addCommas(fp[i].fp_sisapelunasan)+"</td> ";

                                   
                                    html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].fp_idfaktur+","+fp[i].fp_nofaktur+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                  "<label></label>" +
                                  "</div></td>";
                                      
                             html2 +=  "</tr>"; 
                             tablefaktur.rows.add($(html2)).draw(); 
                            n++; 
                            console.log(n +'n');
                              }
                        $('.hutangdagang').val(fp[0].fp_acchutang); 
                       $('.cabangfaktur').val(fp[0].fp_comp) 
                     
                    }
                    else if(idjenisbayar == '3'){
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                       var tablefaktur = $('#tbl-faktur').DataTable();
                       tablefaktur.clear().draw();
                             for(var i = 0; i < fp.length; i++){ 
                            
                                   var html2 = "<tr class='data"+n+"' id='data"+fp[i].v_nomorbukti+"'> <td>"+n+"</td>" +
                                             "<td>"+fp[i].nama+"</td>" +
                                            "<td>"+fp[i].v_nomorbukti+"</td>" +
                                            "<td> - </td>" +                                       
                                          
                                            "<td>"+fp[i].nama_supplier +"</td>"+
                                            "<td> - </td>" +
                                            "<td>"+fp[i].v_tempo+"</td>" +
                                            "<td>"+addCommas(fp[i].v_pelunasan)+"</td> ";

                                         
                                          html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].v_id+","+fp[i].v_nomorbukti+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                        "<label></label>" +
                                        "</div></td>";
                                            
                                   html2 +=  "</tr>"; 
                                   tablefaktur.rows.add($(html2)).draw(); 
                                  n++; 
                             }                        
                    } // END IF JENS
                    else if(idjenisbayar == '4'){
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                       var tablefaktur = $('#tbl-faktur').DataTable();
                       tablefaktur.clear().draw();
                      
                       for(var i = 0; i < fp.length; i++){ 
                        
                           var html2 = "<tr class='data"+n+"' id='data"+fp[i].um_nomorbukti+"'>"+
                                          " <td>"+n+"</td>" +
                                          "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].um_nomorbukti+"</td>" +                                      
                                          "<td> - </td>" +
                                          "<td>"+fp[i].um_supplier+"</td>" +
                                          "<td> - </td>" +
                                          "<td> - </td>" +
                                          "<td>"+addCommas(fp[i].um_sisapelunasan)+"</td> " +
                                          "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].um_id+","+fp[i].um_nomorbukti+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>" +
                                      "</tr>"; 
                          tablefaktur.rows.add($(html2)).draw(); 
                          n++;
                          console.log(n +'n');                                                           
                       } 
                    }
                                         
                    else if(idjenisbayar == '1'){
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                      var tablefaktur = $('#tbl-faktur').DataTable();
                      tablefaktur.clear().draw();

                         for(var i = 0; i < fp.length; i++){    
                           
                               var html2 = "<tr class='data"+n+"' id='data"+fp[i].ik_nota+"'> <td>"+n+"</td>" +
                                             "<td>"+fp[i].nama+"</td>" +
                                            "<td>"+fp[i].ik_nota+"</td>" +
                                            "<td> - </td>" +                                       
                                          
                                            "<td>"+fp[i].nama +"</td>"+
                                            "<td> - </td>" +
                                            "<td> - </td>" +
                                            "<td>"+addCommas(fp[i].ik_pelunasan)+"</td> ";

                                         
                                          html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].ik_id+","+fp[i].ik_nota+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                        "<label></label>" +
                                        "</div></td>";
                                            
                             html2 +=  "</tr>"; 
                             tablefaktur.rows.add($(html2)).draw(); 
                            n++; 

                            console.log(n +'n');
                           } 
                                           
                      } // END ELSE IF JENISBAYAR GIRO

                      else if (idjenisbayar == '11'){ // BON SEMENTARA 
                        $('.supfaktur').show();
                        $('.invfaktur').show();
                        var tablefaktur = $('#tbl-faktur').DataTable();
                        tablefaktur.clear().draw();

                           for(var i = 0; i < fp.length; i++){    
                             
                                 var html2 = "<tr class='data"+n+"' id='data"+fp[i].bp_nota+"'> <td>"+n+"</td>" +
                                               "<td>"+fp[i].nama+"</td>" +
                                              "<td>"+fp[i].bp_nota+"</td>" +
                                              "<td> - </td>" +                                       
                                            
                                              "<td>"+fp[i].nama +"</td>"+
                                              "<td> - </td>" +
                                              "<td> - </td>" +
                                              "<td>"+addCommas(fp[i].bp_pelunasan)+"</td> ";

                                           
                                            html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].bp_id+","+fp[i].bp_nota+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                          "<label></label>" +
                                          "</div></td>";
                                              
                               html2 +=  "</tr>"; 
                               tablefaktur.rows.add($(html2)).draw(); 
                              n++; 

                              console.log(n +'n');
                             } 
                      }
                    },
					error : function(){
					//	location.reload();
					}
                    
                })
               
            })
    
    jenisbayar = $('.jenisbayar').val();
    if(jenisbayar == '5') {

    }
    else {
          idsup = $('jenisbayar2').val();
          $('.hsljenisbayar').val(idsup);
    }

		/*$('.jenisbayar2').change(function(){
              var idsup = $(this).val();
              var idjenisbayar = $('.jenisbayar').val();
              var cabang = $('.cabang').val();
              $('.hsljenisbayar').val(idsup);
                $.ajax({
                  url : baseUrl + '/formfpg/changesupplier',
                  data : {idsup, idjenisbayar},
                  type : "get",
                  dataType : "json",
                  success : function(data) {
                    var fp = data.fakturpembelian;
                    $('.jthtmpo_bank').val(fp[0].fp_jatuhtempo);
                    //$('.hari_bank').val(fp[0].fp_jatuhtempo);

                     //tambah data ke table data po
                    var tablefaktur = $('#tbl-faktur').DataTable();
                    tablefaktur.clear().draw();
                    var n = 1;
                    if(idjenisbayar == '2' ){
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                        for(var i = 0; i < fp.length; i++){   
                                  
                          var html2 = "<tr class='data"+n+"' id='data"+fp[i].fp_nofaktur+"'> <td>"+n+"</td>" +
                                           "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].fp_nofaktur+"</td>" +
                                          "<td>"+fp[i].fp_noinvoice+"</td>" +                                       
                                        
                                          "<td>"+fp[i].nama_supplier +"</td>"+
                                          "<td>"+fp[i].tt_noform+"</td>";
                                          if(idjenisbayar != '7'){
                                              html2 +=  "<td>"+fp[i].fp_jatuhtempo+"</td>";
                                          }
                                          else {
                                            html2 +=  "<td>- </td>";
                                          }
                                         html2 += "<td>"+addCommas(fp[i].fp_sisapelunasan)+"</td> ";

                                       
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].fp_idfaktur+","+fp[i].fp_nofaktur+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                         }      

                        $('.hutangdagang').val(fp[0].acc_hutang);                       
                    }
                    else if(idjenisbayar == '6' || idjenisbayar == '7'|| idjenisbayar == '9') {
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                      for(var i = 0; i < fp.length; i++){   
                                  
                          var html2 = "<tr class='data"+n+"' id='data"+fp[i].fp_nofaktur+"'> <td>"+n+"</td>" +
                                           "<td>"+fp[i].namacabang+"</td>" +
                                          "<td>"+fp[i].fp_nofaktur+"</td>" +
                                          "<td> - </td>";                                   
                                          if(idjenisbayar == '9') {
                                  html2 +=  "<td>"+fp[i].namavendor +"</td>";                                            
                                          }
                                          else {
                                  html2 += "<td>"+fp[i].namaoutlet+"</td>";
                                          }

                                          html2 += "<td> - </td>";
                                          if(idjenisbayar == 6){
                                            html2 += "<td>"+fp[i].fp_jatuhtempo+"</td>";
                                          }
                                          else {
                                            html2 += "<td> - </td>";
                                          }

                                       html2 += "<td>"+addCommas(fp[i].fp_sisapelunasan)+"</td> ";

                                       
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].fp_idfaktur+","+fp[i].fp_nofaktur+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                         }      

                        $('.hutangdagang').val(fp[0].acc_hutang);     
                    }
                    else if(idjenisbayar == '3'){
                      $('.supfaktur').show();
                      $('.invfaktur').show();
                       for(var i = 0; i < fp.length; i++){   
                                  
                          var html2 = "<tr class='data"+n+"' id='data"+fp[i].v_nomorbukti+"'> <td>"+n+"</td>" +
                                           "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].v_nomorbukti+"</td>" +
                                          "<td> - </td>" +                                       
                                        
                                          "<td>"+fp[i].nama_supplier +"</td>"+
                                          "<td> - </td>" +
                                          "<td>"+fp[i].v_tempo+"</td>" +
                                          "<td>"+fp[i].v_pelunasan+"</td> ";

                                       
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].v_id+","+fp[i].v_nomorbukti+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                         }   
                    }
                    else if(idjenisbayar == '4'){
                      $('.invfaktur').hide();
                      $('.supfaktur').hide();
                      for(var i = 0; i < fp.length; i++){   
                    
                          var html2 = "<tr class='data"+n+"' id='data"+fp[i].um_nomorbukti+"'>"+
                                          " <td>"+n+"</td>" +
                                          "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].um_nomorbukti+"</td>" +
                                          " <td class='invfaktur'> </td> <td class='supfaktur'> </td>" +
                                          "<td> - </td>" +
                                          "<td> - </td>" +
                                          "<td>"+fp[i].um_pelunasan+"</td> ";
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].um_id+","+fp[i].um_nomorbukti+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                         
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                         } 
                           $('.invfaktur').hide();
                      $('.supfaktur').hide(); 
                    }
                                         
                    else if(idjenisbayar == '1'){
                       for(var i = 0; i < fp.length; i++){                                   
                          var html2 = "<tr class='data"+n+"' id='data"+fp[i].ik_nota+"'> <td>"+n+"</td>" +
                                           "<td>"+fp[i].nama+"</td>" +
                                          "<td>"+fp[i].ik_nota+"</td>" +
                                          "<td> - </td>" +                                       
                                        
                                          "<td>"+fp[i].nama +"</td>"+
                                          "<td> - </td>" +
                                          "<td> - </td>" +
                                          "<td>"+fp[i].ik_pelunasan+"</td> ";

                                       
                                        html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[i].ik_id+","+fp[i].ik_nota+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                          n++; 

                          console.log(n +'n');
                         } 
                    }
                   
                      }
                    
                })
            })*/

      if(idjenis == '2' || idjenis == '3' || idjenis == '4' || idjenis == '5' || idjenis == '6' || idjenis == '7' || idjenis == '8' || idjenis == '9' || idjenis == '1' || idjenis == '11') { // HUTANG DAGANG SUPPLIER
        $('.tbl-jenisbayar').show();
        $('.deskirpsijenisbayar').hide();
        $("#jurnal").show(); 
        $('#detailbayar').attr('disabled' , false);

      }
     /* if(idjenis == '1') { // GIRO / KAS KECIL
        $('.tbl-jenisbayar').hide();
        $('.deskirpsijenisbayar').show();
        $("#jurnal").show(); 
          $('#detailbayar').attr('disabled' , false);

          // $('.deskirpsijenisbayar').show();
         var rowSupplier =  "<table class='table table-bordered table-striped'>" +
                            "<tr>" +
                              "<th> Kepada </th>" +
                              "<td> <input type='text' class='form-control'> </td>" +
                            "</tr>" +

                            "<tr>" +
                              "<th> Keterangan </th>" +
                              "<td> <input type='text' class='form-control'></td>"
                            "</tr>"+
                          "</table>";
                       

                        $('.deskirpsijenisbayar').html(rowSupplier);
      }*/

      if(idjenis == '5' || idjenis == '12'){ // TRANSFER KAS BANK
          $('#tab-1').removeClass("active");
          $('#detailbayar').attr('disabled' , true);
          $('#tab-2').addClass("active");     
          $("#jurnal").hide();  
          $('.tbl-jenisbayar').hide();
            $('.deskirpsijenisbayar').show();
          $('.jthtmpo_bank').attr('disabled' , true);
          //$('.hari_bank').attr('disabled' , true);

          rowTransfer =  "<table class='table table-bordered table-striped'> " +
                            "<tr>" +
                              "<th> Keterangan </th>" +
                              "<td> <input type='text' class='form-control' name='keterangantransfer'> </td>" + 
                            "</tr>" +
                          "</table>";
                       

                      $('.deskirpsijenisbayar').html(rowTransfer);
      }
  
      if(idjenis == '1'){
           $('#detailbayar').attr('disabled' , false);
           
      }

    })
    
    //NOMINAL BANK
    arrnominal = [];
    $('.nominal').change(function(){
 
          totalbayar = $('.totbayar').val();
          jenisbayar = $('.jenisbayar').val();
          val = $(this).val();
            
          val = accounting.formatMoney(val, "", 2, ",",'.');

          $(this).val(val);

          if(jenisbayar == 5){
            idbank = $('.idbank').val();     
            val = $(this).val();
            
            val = accounting.formatMoney(val, "", 2, ",",'.');

           
            if(idbank != ''){
                $('.nominalbank' + idbank).val(val);
                totalbayar = $('.totbayar').val();
                aslitotal = totalbayar.replace(/,/g, '');
            }
            else {
                 $('.nominalbank1').val(val);
            }

          var jmlhnominal = 0;
          $('.nominaltblbank').each(function(){
           
            totalbayar = $('.totbayar').val();
            aslitotal = totalbayar.replace(/,/g, '');
            id = $(this).data('id');
            val = $(this).val();
             
             val2 = val.replace(/,/g, '');
           
            if(val2 != ''){
              jmlhnominal += parseFloat   (val2);
             
            }
           
          })
        
        jenisbayarnominal = $('.jenisbayar').val();
        // alert(jmlhnominal);

            if(jenisbayarnominal != '5'){
                if(jmlhnominal > aslitotal){
                 toastr.info('Angka yang di inputkan lebih dari Total Bayar :) ');
                  $('.nominal').val('');
                  $('.nominalbank' + idbank).val('');
                }
                else {

                   val3 = parseFloat(jmlhnominal);
                   val4 = jmlhnominal.toFixed(2);
                   $('.ChequeBg').val(addCommas(val4));
                }
            }
            else {
              val3 = parseFloat(jmlhnominal);
              val4 = jmlhnominal.toFixed(2);
              $('.totbayar').val(addCommas(val4));
              $('.ChequeBg').val(addCommas(val4));
            }     
          }
          else {

          jenisbayar = $('.jenisbayar').val();
          if(jenisbayar != '12'){
            if(totalbayar == '') {
            
              toastr.info("Anda Belum menginputkan nilai pembayaran di transaksi :)");
                return false;
            }
           
               idbank = $('.idbank').val();  
               val = $(this).val();
                alert(idbank);
               val = accounting.formatMoney(val, "", 2, ",",'.');
               $(this).val(val);
          
               if(idbank != ''){
                  $('.nominalbank' + idbank).val(val);
                  totalbayar = $('.totbayar').val();
                  aslitotal = totalbayar.replace(/,/g, '');
               }
               else {
                   $('.nominalbank1').val(val);
               }

              var jmlhnominal = 0;
              $('.nominaltblbank').each(function(){
             
              totalbayar = $('.totbayar').val();
              aslitotal = totalbayar.replace(/,/g, '');
              id = $(this).data('id');
              val = $(this).val();
               
               val2 = val.replace(/,/g, '');
             
              if(val2 != ''){
                jmlhnominal += parseFloat   (val2);               
              }
            })
        
       
          jenisbayarnominal = $('.jenisbayar').val();
          // alert(jmlhnominal);

          if(jenisbayarnominal != '5'){
              if(jmlhnominal > aslitotal){
             toastr.info('Angka yang di inputkan lebih dari Total Bayar :) ');
              $('.nominal').val('');
              $('.nominalbank' + idbank).val('');
            }
            else {

               val3 = parseFloat(jmlhnominal);
               val4 = jmlhnominal.toFixed(2);
               $('.ChequeBg').val(addCommas(val4));
            }
          }
          else {
             val3 = parseFloat(jmlhnominal);
             val4 = jmlhnominal.toFixed(2);
            $('.totbayar').val(addCommas(val4));
            $('.ChequeBg').val(addCommas(val4));
          }
          
            }
            else if(jenisbayar == '12') {
               idbank = $('.idbank').val();     
                val = $(this).val();
                
                val = accounting.formatMoney(val, "", 2, ",",'.');

               
                if(idbank != ''){
                    $('.nominalbank' + idbank).val(val);
                    totalbayar = $('.totbayar').val();
                    aslitotal = totalbayar.replace(/,/g, '');
                }
                else {
                     $('.nominalbank1').val(val);
                }

              var jmlhnominal = 0;
              $('.nominaltblbank').each(function(){
               
                totalbayar = $('.totbayar').val();
                aslitotal = totalbayar.replace(/,/g, '');
                id = $(this).data('id');
                val = $(this).val();
                 
                 val2 = val.replace(/,/g, '');
               
                if(val2 != ''){
                  jmlhnominal += parseFloat   (val2);
                 
                }
               
              })

              $('.ChequeBg').val(addCommas(jmlhnominal));
              $('.totbayar').val(addCommas(jmlhnominal));
            }
          }
      

       
    })

    //PELUNASAN

 //   $('.pelunasan').maskMoney({thousands:',', decimal:'.' , precision: 2});
    $('.pelunasan').change(function(){
      vals = $(this).val(); 
 
      formatval = accounting.formatMoney(vals, "", 2, ",",'.');

      id = $('.id').val();
      sisa_terbayar = $('.sisatrbyr').val();
      replace_harga = sisa_terbayar.replace(/,/g, '');
      
      $(this).val(formatval);
      vas = $(this).val();

   //   alert(id + 'id');
 
      if(id == ''){ //PERTAMA KALI INPUT

         valpelunasan = vas.replace(/,/g, '');

       
        if(parseFloat(valpelunasan) > parseFloat(replace_harga)){
            toastr.info('Mohon angka yang di masukkan, kurang dari sisa terbayar :) ');
            $(this).val('');
    /*        alert(valpelunasan);
            alert(replace_harga);
    */
        }
        else {
       //   alert('okeyes');
          hasil = parseFloat(replace_harga - valpelunasan);
          hasil = hasil.toFixed(2);
         // toastr.info(hasil + 'hasil');
          sisafaktur = $('.sisafaktur').val(addCommas(hasil));

          $('.pelunasan1').val(formatval);
          $('.sisa_terbayar1').val(addCommas(hasil));
  //        $('.sisafaktur').val()
        }
      } //END PERTAMAKALI INPUT
      else {
     

          valpelunasan = vas.replace(/,/g, '');

        if(valpelunasan > parseInt(replace_harga)){
          toastr.info('Mohon angka yang di masukkan, kurang dari sisa terbayar :) ');
          $(this).val('');
        }
        else {

          hasil = parseFloat(replace_harga - valpelunasan);
          hasil = hasil.toFixed(2);
         // toastr.info(hasil + 'hasil');
          sisafaktur = $('.sisafaktur').val(addCommas(hasil));
          $('.pelunasan' + id).val(formatval);
          $('.sisa_terbayar' + id).val(addCommas(hasil));
  //        $('.sisafaktur').val()
        }
      }
        jumlahpelunasan = 0;
       $('.pelunasanitem').each(function(){
              


              id = $(this).data('id');
             // toastr.info(id);
              val3 = $('.pelunasan' + id).val();        
            // toastr.info(val + 'val');
              replace_harga = val3.replace(/,/g, '');

              if(replace_harga == ''){

              }
              else {
                jumlahpelunasan = jumlahpelunasan + parseFloat(replace_harga);          
               jumlahpelunasan2 = jumlahpelunasan.toFixed(2);
            // toastr.info(replace_harga + 'ana');
            // toastr.info(jumlahpelunasan);
                console.log(replace_harga);
                console.log(jumlahpelunasan);
                console.log(jumlahpelunasan2);
                 $('.totbayar').val(addCommas(jumlahpelunasan2));

                nominal = $('.nominal').val();
              //  alert(nominal);
               /*  if(nominal != ''){

                 }
                 else {
                     $('.nominal').val(addCommas(jumlahpelunasan2));

                 }*/
                  $('.nominal').val(addCommas(jumlahpelunasan2));
              }
             
            })


    });

   

</script>
@endsection


