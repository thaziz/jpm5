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
    opacity: 0.4;
}
</style>
<link href="{{asset('assets/css/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">

<!-- <link href="{{ asset('assets/vendors/chosen/chosen.css')}}" rel="stylesheet"> -->
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Faktur Pembelian </h2>
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
                            <strong> Create Faktur Pembelian </strong>
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
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     
                     </h5>
                     <a href="../fakturpembelian/fakturpembelian" class="pull-right" style="color: grey; float: right;"><i class="fa fa-arrow-left"> Kembali</i></a>
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
                  
                      <div class="col-xs-6">
                         <table class="table head1">    
                          @if(Auth::user()->PunyaAkses('Faktur Cabang','aktif'))
                            <tr>
                            <td width="150px"> Cabang </td>
                            <td>
                              <select class='form-control chosen-select-width1 cabang' name="cabang">
                                  <option value="">
                                    Pilih-Cabang
                                  </option>

                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                 </select>
                            </td>
                            </tr>
                            @else
                            <tr>
                            <td width="150px"> Cabang </td>
                            <td>
                              <select class='form-control chosen-select-width1 cabang' disabled="" name="cabang">
                                  <option value="">
                                    Pilih Cabang
                                  </option>

                                  @foreach($data['cabang'] as $cabang)
                                    @if($cabang->kode == Auth::user()->kode_cabang)
                                    <option selected="" value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                    @else
                                    <option value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                    @endif
                                  @endforeach
                                 </select>
                            </td>
                            </tr>
                            @endif


                          <tr>
                            <td width="150px">
                          No Faktur
                            </td>
                            <td>
                               <input type="text" class="form-control nofaktur" name="nofaktur" required="" readonly="">
                            
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </td>
                          </tr>

                           <tr>
                              <td>   Tanggal </td>
                              <td>
                                <div class="input-group date">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="tgl" required="">
                                </div>
                                <div class="kolomjatuhtempo"> </div>
                               </td>
                            </tr>
                         </table>
                      </div>
                      <hr>

                  <!-- SAVE FAKTUR TANPA PO -->    
                   <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" id="tabmenu">
                            <li class="active" id="tmbhdataitem" data-val='I'><button class="btn btn-default tmbhdataitem" style="background: grey; color:black;" data-toggle="tab" href="#tab-1" >Data Item </button>
                            </li>
                            <li  id="tmbhdatapo" data-val='PO'> <button class="btn btn-default tmbhdatapo" data-toggle="tab" href="#tab-2" >Data PO </button>
                            </li>
                            <!-- TAB BIAYA PENERUS -->
                            <li  id="tmbhdatapenerus" data-val='P'><button class="btn btn-default tmbhdatapenerus" data-toggle="tab" href="#tab-3">Biaya Penerus Hutang</button>
                            </li>
                            <li  id="tmbhdataoutlet" data-val='O'><button class="btn btn-default tmbhdataoutlet" data-toggle="tab" href="#tab-4">Pembayaran Outlet</button>
                            </li>
                            <li  id="tmbhdatasubcon" data-val='SC'><button class="btn btn-default tmbhdatasubcon" data-toggle="tab" href="#tab-5">Pembayaran SUBCON</button>
                            </li>
                        </ul>
                        
                        <!-- KONTEN TANPA PO -->
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                          <div class="row">
                            <div class="col-xs-6">
               <form method="post" action="{{url('fakturpembelian/save')}}"  enctype="multipart/form-data" class="form-horizontal" id="myform">
                               <table class="table table-striped">
                                  <tr>
                                    <td> Supplier </td>
                                    <td>   <select class="form-control idsup chosen-select-width1" name="supplier" required="" novalidate> 
                                            <option value=""> -- Pilih Supplier -- </option>
                                        @foreach($data['supplier'] as $supplier)
                                            <option value="{{$supplier->idsup}},{{$supplier->syarat_kredit}},{{$supplier->nama_supplier}}"> {{$supplier->nama_supplier}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                    </td>
                                  </tr>

                                  <tr>
                                    <td>
                                      Keterangan
                                    </td>
                                    <td>
                                        <input type="text" class="form-control keterangan2" name="keterangan" required="" novalidate> 
                                    </td>
                                  </tr>
                              </table>
                            </div>  
                              <div class="col-xs-6">
                                  <table class="table table-striped">
                                  <tr>
                                    <td width="150px"> No Invoice </td>
                                    <td> <input type="text" class="form-control noinvoice" name="no_invoice" required="" novalidate> </td>
                                  </tr>

                                  <tr>
                                    <td> Jatuh Tempo </td>
                                    <td>  <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo"  readonly="" required="" novalidate>
                                    </div></td>
                                  </tr>
                                  </table>
                               </div>

                          </div>

                          <hr>

                         <div class='row'>  <div class='col-xs-6'>
                          <table class='table' style='width:90%'>

                          <tr>
                            <td> Pilih Group Item </td>
                            <td> <select class="form-control groupitem" name="groupitem"> 
                                    @foreach($data['jenisitem'] as $jenis)
                                  <option value="{{$jenis->kode_jenisitem}},{{$jenis->stock}}"> {{$jenis->keterangan_jenisitem}} </option> 
                                    @endforeach
                                    </select> 
                                  
                                  </td>
                          </tr>

                          
                           <tr>
                            <td width='200px' >
                             Pilih Barang Update Stock ?
                            </td>
                            <td id="tdupdatestock">
                              <select class='form-control updatestock'  name="updatestock" required="" id="updatestock"> <option value='Y' selected=""> Ya </option> <option value='T'> Tidak </option> </select>   
                            </td>
                          </tr>
                         </div>

                          <tr>
                            <td width='150px'> Nama Item : </td>
                            <td>
                            <select class='form-control chosen-select item' name="nama_item" required="" id="item"> 
                                    <option value=""> -- Pilih Barang -- </option>                              
                                                              
                            </select></td>
                          </tr>
                          <tr>
                            <td> Qty </td>
                            <td>
                              <input type='number' class='form-control qty' name="qty" required="">  
                              <input type='hidden' class='form-control penerimaan' name="penerimaan" required="">  
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Gudang
                            </td>
                            <td>
                            <select class="form-control gudang" name="gudang" required="">
                                <option value=""> -- Pilih Gudang -- </option>
                              @foreach($data['gudang'] as $gudang)
                                <option value="{{$gudang->mg_id}},{{$gudang->mg_namagudang}}"> {{$gudang->mg_namagudang}} </option>
                              @endforeach  
                            </select></td>
                          </tr>
                          
                          <tr>
                          <td>
                            Account Biaya
                          </td>
                          <td>
                            <input type='number' class='form-control acc_biaya' name="acc_biaya" required="">
                          </td>
                          </tr>
                          <tr>
                          <td>
                            Account Persediaan
                          </td>
                          <td>
                            <input type='number' class='form-control acc_persediaan' name="acc_persediaan" required="">
                          </td>
                          </tr>
                        </table> </div>
                       <div class='col-xs-6'>
                          <table class='table' style='width:90%'>
                          <tr>
                            <td style="width:150px">
                              Harga
                            </td>
                            <td>
                              <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control harga" style="text-align: right" name="harga" required=""> </div> </div>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Total Harga
                            </td>
                            <td style="text-align: right"> 
                             <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control amount" style="text-align: right" name="amount" readonly="" required=""> </div> </div>
                            </td>
                          
                          </tr>

                          <tr>
                            <td> Diskon </td>
                            <td> <div class="form-group"> <div class="col-md-3"> <input type='text' class='form-control diskon' name="diskon2" required=""> </div> <label class="col-sm-2 col-sm-2 control-label"> % </label> <div class="col-sm-7"> <input style='text-align: right' type="text" class="form-control hasildiskonitem"> </div> </div> </td>
                          </tr>


                          <tr>
                            <td>
                              Biaya
                            </td>
                          <td style="text-align: right">

                              <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control biaya" style="text-align: right" name="biaya" readonly="" required=""> </div> </div>
                            </td>
                          </tr>
                         


                          <tr>
                          <td>
                            Keterangan 
                          </td>
                          <td>
                            <input type='text' class='form-control keterangan' name="keterangan2" required="">
                          </td>
                          </tr>
                         </table>
                       </div> <br> <br>
                       <div class='box-footer'>
                       <div class='pull-right' style='margin-right:20px'>
                       <table border="0">
                        <tr>
                          <td><button type='button' class='btn btn-warning clear'> Bersihkan Data </button></td>
                          <td> &nbsp; </td>
                          <td> <button type='submit' class='btn btn-success tbmh-data-item'> Tambah Data Item  </button></td>
                        </tr>
                       </table>
                        </form>
                      </div> </div>
                    </div>
                   <hr>
                   <h4> Daftar Detail Faktur </h4>
                   <br>
                   <form method="get" action="{{url('fakturpembelian/update_fp')}}"  enctype="multipart/form-data" class="form-horizontal" id="form_jumlah">
                   <div class='box-body'>

                     <div class="col-xs-6 pull-right">
                      <!-- data-item -->
                        <table class='table'>
                            
                           
                        <div class="loading text-center" style="display: none;">
                            <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                        </div>
                          <tr>
                            <td> <input type='hidden' class='nofakturitem nofaktur' name='nofakturitem'> <input type='hidden' class='keteranganheader' name='keteranganheader'> <input type='hidden' class='noinvoiceitem' name='noinvoice'> <input type='hidden' class='jatuhtempoitem' name='jatuhtempoitem'> <input type='hidden' class='tglitem' name='tglitem'> <input type='hidden' class='idsupitem' name='idsupitem'> <input type='hidden' class='inputfakturpajakmasukan'>  <input type='hidden' class='inputtandaterima'> <input type='hidden' class='cabang2' name='cabang'>  <input type='hidden' class='inputtandaterima'>   </td>
                             <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          </tr>

                          <tr>
                            <td> Jumlah </td>
                            <td> <div class="col-xs-3"> Rp </div> <div class="col-xs-9"> <input type='text' class='form-control jumlahharga' name='jumlahtotal' style='text-align: right' readonly=""> </div> </td>
                          </tr>
                          <tr>
                            <td> Discount </td>
                            <td> <div class="form-group"> <div class="col-md-3"> <input type="text" class="form-control disc_item" name="diskon"> </div> <label class="col-md-2"> % </label> <div class="col-xs-6"> <input type="text" class="form-control hasildiskon" style="text-align:right" readonly="">  </div> </div> </td>
                          </tr>
                          <tr>
                             <td> Jenis PPn </td> 
                             <td> <div class='col-xs-4'> <select class='form-control jenisppn' name="jenisppn" style="width:100px"> <option value='T'> Tanpa </option> <option value='E'> Exclude </option> <option value="I"> Include </option>  </select>     </div>
                             <div clas="col-xs-8">  <button type="button" class="btn btn-primary" id="createmodal" data-toggle="modal" data-target="#myModal2">  Faktur Pajak </button>  </div> 
                                     
                              </td>
                          </tr>
                          <tr>
                            <td> DPP </th>
                            <td>  <div class='col-xs-4'> Rp </div> <div class='col-xs-8'> <input type='text' class='form-control dpp' readonly="" name='dpp' style="text-align: right"> </div> </td>
                          </tr>
                          <tr>
                            <td> PPn % </td>
                            <td > <div class="row"> <div class="col-md-4"> <input type="text" class="form-control inputppn"> </div>  <div class="col-md-8"> <input style='text-align: right' type="text" class="form-control hasilppn" readonly="" name="hasilppn"> </div>  </div> </td>
                          </tr>

                          <tr>
                              <td style='text-align: right'> <select class='form-control pajakpph' name="jenispph"> @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'> {{$pajak->nama}}</option> @endforeach </select> </td>
                              <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control inputpph" readonly=""> </div> <div class="col-md-8"> <input type="text" class="form-control hasilpph" style='text-align: right' readonly="" name='hasilpph'> </div> </div> </td>
                          </tr>

                         <!--  <tr>
                            <td> Biaya - biaya Lain </td>
                            <td> <input type='text' class='form-control biayalain2' readonly=""> </td>
                          </tr> -->

                          <tr>
                            <td> Netto Hutang </td>
                            <td> <input style="text-align: right" type='text' class='form-control nettohutang' readonly="" name="nettohutang"> </td>
                          </tr>

                          <tr>
                                              <td colspan="2">
                                                <button class="btn btn-info" style="margin-right: 10px;" type="button" id="createmodal_tt" data-toggle="modal" data-target="#myModal_TT"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
                                              </td>
                                            </tr>
                         

                          <tr>
                            <td>
                              <input type='hidden' name='dpp_fakturpembelian' class='dppfakturpembelian'>
                              <input type='hidden' name='hasilppn_fakturpembelian' class='hasilppnfakturpembelian'>
                              <input type='hidden' name='inputppn_fakturpembelian' class='inputppnfakturpembelian'> 
                              <input type='hidden' name='jenisppn_faktur' class='jenisppnfaktur'>                
                              <input type='hidden' name='masapajak_faktur' class='masapajakfaktur'>                     
                              <input type='hidden' name='netto_faktur' class='nettofaktur'>                              
                              <input type='hidden' name='nofaktur_pajak' class='nofakturpajak'>                            
                              <input type='hidden' name='tglfaktur_pajak' class='tglfakturpajak'>   


                              <!-- TT -->
                               <input type='hidden' name='lainlain_tt2' class='lainlain_tt2'>
                               <input type='hidden' name='notandaterima2' class='notandaterima2'>
                             
                            </td>
                          </tr>

                        </table>
                          <!-- FORM TANA TERIMA -->
                                 <div class="modal fade" id="myModal_TT" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                      <h4 class="modal-title" style="text-align: center;"> 
                                       </h4>     
                                    </div>
                                                  
                                    <div class="modal-body">              
                                    <table class="table table-stripped">
                                      <tr>
                                        <td width="150px">
                                          No Tanda Terima
                                        </td>
                                        <td>
                                          <input type='text' class='input-sm form-control notandaterima'>
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> Tanggal </td>
                                        <td>
                                           <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" value="" readonly="">
                                          </div>
                                        </td>
                                      </tr>
                                     
                                      <tr>
                                        <td> Supplier </td>
                                        <td> <input type='text' class="form-control supplier_tt" value="" readonly=""></td>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">
                                           <div class="row">
                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="Kwitansi" type="checkbox" checked="">
                                                      <label for="Kwitansi">
                                                          Kwitansi / Invoice / No
                                                      </label>
                                                </div> 
                                              </div>
                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="FakturPajak" type="checkbox" checked="">
                                                      <label for="FakturPajak">
                                                          Faktur Pajak
                                                      </label>
                                                </div> 
                                              </div>

                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="SuratPerananAsli" type="checkbox" checked="">
                                                      <label for="SuratPerananAsli">
                                                          Surat Peranan Asli
                                                      </label>
                                                </div> 
                                              </div>

                                               <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="SuratJalanAsli" type="checkbox" checked="">
                                                      <label for="SuratJalanAsli">
                                                         Surat Jalan Asli
                                                      </label>
                                                </div> 
                                              </div>
                                            </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                         Lain Lain
                                        </td>
                                        <td>
                                        
                                          <input type="text" class="form-control lainlain_tt" name="lainlain">
                                        </td>
                                      </tr>

                                      <tr>
                                        <td> Tanggal Kembali </td>
                                        <td>   <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo_tt" readonly="">
                                          </div> </td>
                                      </tr>

                                      <tr>
                                        <td>
                                         Total di Terima
                                        </td>
                                        <td> <div class="row"> <div class="col-sm-3"> <label class="col-sm-3 label-control"> Rp </label> </div> <div class="col-sm-9"> <input type="text" class="form-control totalterima_tt"  style="text-align:right;" readonly=""></div> </div> </td>
                                      </tr>
                                     
                                       </table>                           
                                               
                                         </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                          <button type="button" class="btn btn-primary simpan_penerus" id="buttonsimpan_tt">Simpan</button>
                                         
                                      </div>
                                      
                                  </div>
                                </div>
                             </div> 

                               <!-- FAKTUR PAJAK -->
                              <!-- modal -->
                                    <div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                                      <div class="modal-dialog modal-lg">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                              <h4 class="modal-title">Faktur Pajak Masukan  </h4>     
                                             </div>
                                    


                                      <div class="modal-body">
                                        <div class="row">
                                          <div class="col-sm-6">
                                            <table class='table'>
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <tr>
                                              <td style="width:120px"> Jenis PPn </td>
                                              <th> <input type='text' class='input-sm form-control jenisppn_faktur' name='jenisppn_faktur' readonly=""> </th>
                                            </tr>

                                              <tr> 
                                                <td> No Faktur Pajak </td>
                                                <td> <input type='text' class='form-control input-sm nofaktur_pajak' name='nofaktur_pajak'> </td>
                                              </tr>
                                              <tr>
                                                <td> Tanggal </td>
                                                <td>  <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control  tglfaktur_pajak" name="tglfaktur_pajak" required="">
                                                    </div>
                                              </td>
                                              </tr>
                                            </table>
                                          </div>

                                          <div class="col-sm-6">
                                          <table class='table'>
                                            <tr>
                                              <td> Masa Pajak </td>
                                              <td> <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control masapajak_faktur " name="masapajak_faktur" required="">
                                                    </div>
                                              </td>
                                            </tr>
                                            </table>
                                          </div>
                                        </div>


                                        <div class="row">
                                          <div class="col-sm-6">
                                              <h3 style='text-align: center'> FAKTUR PEMBELIAN </h3>

                                              <table class='table'>
                                              <tr>
                                                <td style="width:120px"> DPP </td>
                                                <td> <input type='text' class='form-control input-sm dpp_fakturpembelian' name='dpp_fakturpembelian' readonly="" style="text-align : right"> </td>
                                              </tr>
                                              <tr>
                                                <td> Ppn </td>
                                                <td> <div class='col-sm-4'> <input type='text' class='form-control input-sm inputppn_fakturpembelian' name='inputppn_fakturpembelian'> </div> <div class='col-sm-8'> <input type='text' class='form-control input-sm hasilppn_fakturpembelian' style="text-align : right" readonly="" name="hasilppn_fakturpembelian"> </div> </td>  
                                              </tr>
                                              </table>

                                          </div>
                                          <div class="col-sm-6">
                                              <h3 style='text-align: center'>  FAKTUR PAJAK </h3>
                                              <table class='table'>
                                                <tr>
                                                  <td> <input type='text' class='form-control input-sm dpp_fakturpajak' style="text-align : right" readonly=""> </td>
                                                </tr>

                                                <tr>
                                                  <td> <input type='text' class='form-control input-sm hasilppn_fakturpajak ' style="text-align : right" readonly=""> </td>
                                                </tr>
                                              </table>
                                          </div>
                                        </div>


                                        <table class="table">
                                       
                                        <tr>
                                          <td> Netto </td>
                                          <td> <input type='text' class='form-control netto_faktur' name='netto_faktur' style="text-align : right" readonly=""> </td>
                                        </tr>
                                        </table>

                                       
                                      </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                                     <button class='btn btn-sm btn-warning editfakturpajak' type="button"> <i class='fa fa-pencil' id='editkeuangan'> </i> Edit </button>
                                     <button type="button"  class="simpan btn btn-success" id="formPajak"> Simpan  </button>
                                  
                                </div>
                               </div>
                          </div> 

                              </div> <!-- ENd Modal -->


                        </div>


                    <div class="col-xs-12">
                        <div class="table-responsive">
                          <table class='table table-bordered table-striped tbl-penerimabarang' id="tablefp">
                          <tr>
                          <thead> 
                            <th>
                              No
                            </th>
                              <th width='300px'>
                                 Nama Item
                              </th>
                              <th width="100px">
                              Qty
                              </th>
                              <th width='150px'>
                                Gudang
                              </th>
                              <th width='300px'>
                                Harga / unit
                              </th>
                              <th width='300px'>
                                Total Harga
                              </th>
                              <th width='100px'>
                                Update Stock ?
                              </th>
                              <th width="100px">
                               Diskon
                              </th> 
                              <th width='300px'>
                                Biaya 
                              </th> 
                              <th width='100px'>
                                Account Biaya
                              </th>
                              <th width='100px'>
                                Account Persediaan
                              </th>
                              <th width='500px'>
                                Keterangan
                              </th>
                              <th>
                              </th>
                            </thead>
                          </tr>
                        
                          </table>
                          </div>
                       </div>
                     

                        <div class='pull-right'>
                          <table border="0">
                            <tr>
                              <td> <button type='button' class="btn btn-warning"> Batal </button> </td>
                              <td> &nbsp; </td>
                              <td> <button type="submit" class='btn btn-success'> Simpan Data </button> </td>
                            </table>
                          </form>
                        </div>                     
                   </div>
                 
                  </div>
                  </div>
                  
                            <!-- KONTEN FAKTUR PAKE PO -->
                           <div id="tab-2" class="tab-pane">
                             <form method="get" action="{{url('fakturpembelian/savefakturpo')}}"  enctype="multipart/form-data" class="form-horizontal savefakturpo" id="savefakturpo">
                                <div class="panel-body">
                                    <div class="row">
                                    <div class="col-xs-6">
                                      <table class="table table-striped">
                                          <tr>
                                            <td> Supplier </td>
                                            <td>   <select class="form-control idsup_po" name="supplier_po" novalidate required=""> 
                                                    <option value=""> -- Pilih Supplier -- </option>
                                                @foreach($data['supplier'] as $supplier)
                                                    <option value="{{$supplier->idsup}},{{$supplier->syarat_kredit}}"> {{$supplier->nama_supplier}}</option>
                                                @endforeach
                                                </select>
                                            </td>
                                            </td>
                                          </tr>

                                          <tr>
                                            <td>
                                              Keterangan
                                            </td>
                                            <td>
                                                <input type="text" class="form-control keterangan_po"   novalidate required=""> 
                                            </td>
                                          </tr>
                                      </table>
                                    </div>  
                                      <div class="col-xs-6">
                                          <table class="table table-striped">
                                          <tr>
                                            <td width="150px"> No Invoice </td>
                                            <td> <input type="text" class="form-control noinvoice_po" novalidate required=""> </td>
                                          </tr>

                                          <tr>
                                            <td> Jatuh Tempo </td>
                                            <td>  <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo_po"  readonly=""  novalidate name="jatuhtempo_po">
                                            </div></td>
                                          </tr>
                                          </table>
                                       </div>
                                  </div>


                  <div class="pull-left">
                                       <button  type="button" class="tbmh-po btn btn-success"  id="createmodal" data-toggle="modal" data-target="#myModal5"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah PO </button>
                                    </div>
                                    <br>
                                    <br>
                                    <br>

                                    <table class='table table-bordered table-striped ' id='table_po' style='width:75%'>
                                      <tr>
                                        <th style='width:20px'> No </th> <th style='width:200px'> No Bukti </th> <th> TIPE TRANSAKSI </th> <th> Jumlah Harga </th> 
                                      </tr>
                                    </table>

                                    <div class="row">
                                      <div class="col-md-7">
                                        <div class='table-responsive'>
                                        <table class="table  table-bordered" id="table_dataitempo">
                                          <tr>
                                            <th> No </th>
                                            <th style='width:100px'> Nama Item </th>
                                            <th class="qtyterima_po"> Qty Terima </th>
                                            <th class="qty_po"> Qty Po</th>
                                            <th class="gudang_po"> Gudang </th>
                                            <th class="hrgpo"> Harga / unit </th>
                                            
                                            <th> Total Harga </th>
                                            <th class="updatestockpo"> Update Stock ?</th>
                                            <th> Account Biaya </th>
                                          </tr>
                                        </table>
                                        </div>
                                      </div>

                                      <div class="col-md-5">
                                         
                                          <table class='table' style="width:100%">
                                             
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="hidden" class="keterangan2_po" name="keterangan_po">
                                              <input type="hidden" class="no_invoice2_po" name="no_invoice_po">
                                              <input type="hidden" class="no_faktur" name="no_faktur">
                                              <input type="hidden" class="tgl_po" name="tgl_po">

                                            <tr>
                                              <td> Jumlah </td>
                                              <td> <div class="col-sm-3"> Rp </div> <div class="col-sm-9"> <input type='text' class='form-control jumlahharga_po' name='jumlahtotal_po' style='text-align: right' readonly=""> </div> </td>
                                            </tr>
                                            <tr>
                                              <td> Discount </td>
                                              <td>
                                                <div class="row"> <div class="col-md-3"> <input type="text" class="form-control disc_item_po" name="disc_item_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasildiskon_po" readonly=""  style="text-align: right"> </div>  </div>

                                               </td>
                                            </tr>
                                            <tr>
                                              <td> Jenis PPn </td>
                                              <td> <div class="col-md-6">  <select class='form-control jenisppn_po' name="jenisppn_po"> <option value='T'> Tanpa </option> <option value='E'> Exclude </option> <option value="I"> Include </option>  </select> </div> </td>
                                            </tr>
                                            <tr>
                                              <td> DPP </td>
                                              <td>  <div class='col-sm-3'> Rp </div> <div class='col-sm-9'> <input type='text' class='form-control dpp_po' readonly="" name='dpp_po' style="text-align: right"> </div> </td>
                                            </tr>
                                            <tr>
                                              <td> PPn % </td>
                                              <td> <div class="row"> <div class="col-md-3"> <input type="text" class="form-control inputppn_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasilppn_po" readonly=""  style="text-align: right" name="hasilppn_po"> </div>  </div> </td>
                                            </tr>

                                            <tr>
                                                  <td style='text-align: right'> <select class='form-control pajakpph_po' name="jenispph_po"> @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'> {{$pajak->nama}}</option> @endforeach </select> </td>
                              <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control inputpph_po" readonly=""> </div> <div class="col-md-8"> <input type="text" class="form-control hasilpph_po" style='text-align: right' readonly="" name='hasilpph_po'> </div> </div> </td>
                                            </tr>

                                          <!--   <tr>
                                              <td> Biaya - biaya Lain </td>
                                              <td> <input type='text' class='form-control'> </td>
                                            </tr> -->

                                            <tr>
                                              <td> Netto Hutang </td>
                                              <td> <input type='text' class='form-control nettohutang_po' readonly="" name="nettohutang_po" style="text-align: right"> </td>
                                            </tr>
                                              
                                          </table>
                                    </div>
                    </div>
                                    
                                          <div class='pull-right'>
                                            <table border="0">
                                            <tr>
                                            <td> <button type='button' class="btn btn-danger"> Kembali </button> </td>
                                            <td> &nbsp; </td>
                                            <td> <button type="submit" class='btn btn-success'> Simpan Data </button> </td>
                                            </table>

                                             <table class='table' id="input_data">
                                              <tr>
                                                <td>
                                                
                                                </td>
                                              </tr>
                                             </table>
                                            </form>
                                          </div>

                                         <!--  <div id="input_data"> </div> -->

                                        

                                        

                                    </div>


                                </div>

                            <!-- PANEL BIAYA PENERUS AGEN -->
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body resi" style="width: 100%;margin: 0 auto">
                                </div>
                            </div>
                            <!-- END BIAYA PENERUS AGEN -->
                            <!-- PANEL PEMBAYARAN OUTLET -->
                             <div id="tab-4" class="tab-pane">
                                <div class="panel-body outlet" style="width: 100%;margin: 0 auto">
                                </div>
                            </div>
                            <!-- END PEMBAYARAN OUTLET -->
                             <!-- PANEL SUBCON -->
                             <div id="tab-5" class="tab-pane">
                                <div class="panel-body subcon" style="width: 100%;margin: 0 auto">
                                </div>
                            </div>
                              <!-- modal -->
                              <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title">Tambah Data PO </h4>     
                                       </div>

                                <div class="modal-body">
                                    <table id="addColumn" class="table  table-bordered table-striped tbl-purchase">
                                       <thead>
                                         <tr>
                                          <th style="width:10px">No</th>
                                          <th> No PO </th>
                      <th> Cabang </th>
                                          <th> Status </th>
                                          <th> Jumlah Harga </th>
                                          <th> Aksi </th>      
                                        </tr>
                                      </thead>                          
                                      <tbody>
                                       
                                      </tbody>
                                   </table>                              
                                   <div class="kosong"> </div>
                                </form>
                             </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> <!--end modal -->
                       <div class="loading text-center" style="display: none;">
                            <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                        </div>
                       <div class='title'> </div>
                        </div>
                    </div>
                </div>


                </div> <!--end body-->
                <div class="box-footer">
                  <div class="pull-right">
                  
                  <!--   <a class="btn btn-warning" href={{url('fatkurpembelian/fatkurpembelian')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success"> -->
                    
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
<script src="{{ asset('assets/vendors/chosen/chosen.jquery.js') }}"></script>
<script type="text/javascript">
  $('body').removeClass('fixed-sidebar');
  $("body").toggleClass("mini-navbar");
 
    function findArrayMin(array, attr, value) {
                  for(var i = 0; i < array.length; i ++) {
                      if(array[i][attr] == value) {
                          return i;
                      }
                  }
                  return -1;
    }

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  $('.editfakturpajak').click(function(){
        $('.inputppn').attr('readonly' , false);
        $('.pajakpph').attr('disabled' , false);
        $('.disc_item').attr('readonly', false);
        $('.tbmh-data-item').attr('disabled' , false);
        $('.jenisppn').attr('disabled', true);
        $('#myModal2').modal("toggle" );
         $('.inputfakturpajakmasukan').val('edit');
  })

  $('#formPajak').click(function(){
    
/*
     var post_url2 = $(this).attr("action");
     var form_data2 = $(this).serialize();*/
     dpp_fakturpembelian = $('.dpp_fakturpembelian').val();
     hasilppn_fakturpembelian = $('.hasilppn_fakturpembelian').val();
     inputppn_fakturpembelian = $('.inputppn_fakturpembelian').val();
     jenisppn_faktur = $('.jenisppn_faktur').val();
     masapajak_faktur = $('.masapajak_faktur').val();
     netto_faktur = $('.netto_faktur').val();
     nofaktur_pajak = $('.nofaktur_pajak').val();
     tglfaktur_pajak = $('.tglfaktur_pajak').val();
      if(nofaktur_pajak == ''){
      toastr.info("no faktur pajak masukan kosong");
     }
     else {
          sukses = $('.inputfakturpajakmasukan').val('sukses');
        $('.dppfakturpembelian').val(dpp_fakturpembelian);
       $('.hasilppnfakturpembelian').val(hasilppn_fakturpembelian);
       $('.inputppnfakturpembelian').val(inputppn_fakturpembelian);
       $('.jenisppnfaktur').val(jenisppn_faktur);
       $('.masapajakfaktur').val(masapajak_faktur);
       $('.nettofaktur').val(netto_faktur);
       $('.nofakturpajak').val(nofaktur_pajak);
       $('.tglfakturpajak').val(tglfaktur_pajak);
       $('#myModal2').modal("toggle" );
        alertSuccess();
    

    }


   /* $.ajax({
      data : {dpp_fakturpembelian,hasilppn_fakturpembelian,inputppn_fakturpembelian,jenisppn_faktur,masapajak_faktur,netto_faktur,nofaktur_pajak,tglfaktur_pajak},
      url : baseUrl + '/fakturpembelian/savefakturpajak',
      type : "post",
      dataType : 'json',
      success : function (response){
        sukses = $('.inputfakturpajakmasukan').val('sukses');
        $('#myModal2').modal("toggle" );
        alertSuccess();

        $('.inputppn').attr('readonly' , true);
        $('.pajakpph').attr('disabled' , true);
        $('.disc_item').attr('readonly', true);
        $('.jenisppn').attr('disabled', true);
        $('.tbmh-data-item').attr('disabled' , true);
      }
    })*/
  })
    
    $('#buttonsimpan_tt').click(function(){
      lainlain =   $('.lainlain_tt').val();
      notandaterima = $('.notandaterima').val();
      if(lainlain == ''){
        toastr.info('Kolom lain lain belum di isi');
      }
      else {
        if(notandaterima != '' || lainlain != ''){
           $('.inputtandaterima').val('sukses');
        }
        $('.lainlain_tt2').val(lainlain);
        $('.notandaterima2').val(notandaterima);
          $('#myModal_TT').modal("toggle" );;
      } 
    })

    $('#createmodal_tt').click(function(){
      cabang = $('.cabang').val();
      supplier = $('.idsup').val();
      string = supplier.split(",");

      tgl = $('.tgl').val();
      jatuhtempo = $('.jatuhtempoitem').val();
      nettohutang = $('.nettohutang').val();

      $('.tgl_tt').val(tgl);
      $('.supplier_tt').val(string[2]);
      $('.jatuhtempo_tt').val(jatuhtempo);
      $('.totalterima_tt').val(nettohutang);


       $.ajax({    
            type :"post",
            data : {cabang},
            url : baseUrl + '/fakturpembelian/getnotatt',
            dataType:'json',
            success : function(data){

               console.log(data);
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

              
                 nott = 'TT' + month + year2 + '/' + cabang + '/' +  data;
               
                $('.notandaterima').val(nott);
            }
        })
    })


   $('#createmodal').click(function(){

      jenisppn = $('.jenisppn').val();
      dpp = $('.dpp').val();
      inputppn = $('.inputppn').val();
      hasilppn = $('.hasilppn').val();
      netto = $('.nettohutang').val();
     

      if(inputppn == '' && hasilppn == ''){
        toastr.info("Anda belum mengisi data PPN :)");
        return false;
      }
      else {
        $('.jenisppn_faktur').val(jenisppn);
        $('.dpp_fakturpembelian').val(dpp);
        $('.dpp_fakturpajak').val(dpp);
        $('.inputppn_fakturpembelian').val(inputppn);
        $('.hasilppn_fakturpajak').val(hasilppn);
        $('.hasilppn_fakturpembelian').val(hasilppn);
        $('.netto_faktur').val(netto);

      }
   })
  
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

      $('.idsup').chosen(config2); 
    
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



  $('.keterangan_po').change(function(){
    var keterangan_po = $('.keterangan_po').val();
    $('.keterangan2_po').val(keterangan_po);
  })

  $('.noinvoice_po').change(function(){
   
    var no_invoice_po = $('.noinvoice_po').val();
    $('.no_invoice2_po').val(no_invoice_po);
  })

   
   
    $('.nofaktur').change(function(){
      $this = $(this).val();
      $('.no_faktur').val($this);
      $('.nofakturitem').val($this);
    })

    $('.noinvoice').change(function(){
     
      $this = $(this).val();
      $('.invoice_po').val($this);
      $('.noinvoiceitem').val($this);
    })

    $('.keterangan2').change(function(){
      $this = $(this).val();
      $('.keteranganheader').val($this);
    })

      $('.cabang').change(function(){
      cabang = $(this).val();
      var a = $('ul#tabmenu').find('li.active').data('val');
      
      $('.cabang2').val(cabang);
       $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/fakturpembelian/getbiayalain',
          dataType : 'json',
          success : function (response){     
           /* $('.biayalain_po').empty();     
            for(var i = 0; i < response.biaya.length; i++){
               $('.biayalain_po').append("<option value='"+response.biaya[i].id_akun+"''>"+response.biaya[i].nama_akun+"</option>"); 
                 $('.biayalain_po').trigger("chosen:updated");
                 $('.biayalain_po').trigger("liszt:updated");
            }*/

            

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

              
                 nofaktur = 'FP' + month1 + year2 + '/' + cabang + '/' + a + '-' + response.idfaktur ;
                $('.aslinofaktur').val(nofaktur);
                $('.nofaktur').val(nofaktur);
                $('.no_faktur').val(nofaktur);
          },
        })
    })
    //jenisitem di dataitem
     //jenisitem di dataitem
    $('.jenisppn').change(function(){
    
        pph = $('.hasilpph').val();
        inputppn = $('.inputppn').val();
        ppn = $('.hasilppn').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        jenisppn = $('.jenisppn').val();
        dpp = $('.dpp').val();
        numeric2 = dpp.replace(/,/g,'');
      /*  hasilbiaya2 = $('.hasilbiaya_po').val();
        hasilbiaya = hasilbiaya2.replace(/,/g,'');*/
      

        if(ppn != ''){
          if(jenisppn == 'E'){
          //JIKA PPH TIDAK ADA 
            if(pph == ''){
              hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)).toFixed(2);
              $('.nettohutang').val(addCommas(hasilnetto));
            }
            else{
              hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang').val(addCommas(hasilnetto));
            } 
          }
          else if(jenisppn == 'I'){
          
            if(pph == ''){            
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2)).toFixed(2); 
            
              $('.nettohutang').val(addCommas(total));     
            }
            else{
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) - parseFloat(replacepph)).toFixed(2);
             
              $('.nettohutang').val(addCommas(total));     
            }
          }
          else if(jenisppn == 'T') {
            if(pph == '' && hasilbiaya == ''){
              $('.hasilppn').val('');
              $('.inputppn').val('');
              $('.nettohutang').val(dpp);
            }
            else{
               total = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang').val(addCommas(total));
            }
           
          }

        }
    })


     $('.jenisppn_po').change(function(){
        pph = $('.pajakpph_po').val();
        ppn = $('.hasilppn_po').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        jenisppn = $('.jenisppn_po').val();
        dpp = $('.dpp_po').val();
        numeric2 = dpp.replace(/,/g,'');


          if(jenisppn == 'E') {
            console.log('1.1')
             if(pph != '' & ppn != '') {
                console.log('1');
              
                  hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                  hsl = hasilnetto.toFixed(2);
                  $('.nettohutang_po').val(addCommas(hsl));
              }          
          }

        else if(pph != ''){
          console.log('2');
          if(ppn = '') {
            console.log('2.1');
            hasil = parseFloat(parseFloat(numeric2) + parseFloat(replacepph));
            $('.nettohutang_po').val(hasil);
          }
          else{
            console.log('2.1.2');
              jenisppn = $('.jenisppn_po').val();
              console.log('jenisppn_po' + jenisppn);
            if(jenisppn == 'E') {
              console.log('2.2');
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
            }
          }
        }
        else if(ppn != '') {
          console.log('3');
          jenisppn = $('.jenisppn_po').val();
          if(pph = ''){
            console.log('3.1');
              if(jenisppn == 'E'){
                console.log('3.1.1');
                hasil = parseFloat(parseFloat(numeric2) + parseFloat(ppn));
                hsl = hasil.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
              }
          }
          else{
            console.log('3.1.1');
             if(jenisppn == 'E') {
              console.log('3.1.2');
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
            }
          }
        }
    })




      //menghitung ppn di dataitem
    $('.inputppn').change(function(){
      var jenisppn = $('.jenisppn').val();
   
      var dpp = $('.dpp').val();
      dpphasil =  dpp.replace(/,/g, '');
      $this = $(this).val();
      inputppn = $this;
      hasil = parseFloat(($this / 100) * dpphasil);
      hasil2 =   hasil.toFixed(2);

        pph = $('.hasilpph').val();      
        ppn = $('.hasilppn').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        jenisppn = $('.jenisppn').val();
        numeric2 = dpp.replace(/,/g,'');



      $('.hasilppn').val(addCommas(hasil2));

      if(jenisppn == 'T'){
        toastr.info('Jenis PPn anda TANPA PPN :)');
        $('.inputppn').val('');
        $('.hasilppn').val('');
      }
      else if (jenisppn == 'E') {
          if($('.hasilpph').val() != ''){
            hasilpph = $('.hasilpph').val();
            replacepph = hasilpph.replace(/,/g,'');
            hasilnetto = parseFloat((parseFloat(dpphasil)+parseFloat(hasil2)) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang').val(addCommas(hsl));
          }
          else{
            console.log('helo');
             hasilnetto = parseFloat(parseFloat(dpphasil) + parseFloat(hasil2));
             hsl = hasilnetto.toFixed(2);
             $('.nettohutang').val(addCommas(hsl)); 
          }
      }
      else if(jenisppn == 'I'){
         if(pph == ''){           
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2)).toFixed(2); 
            
              $('.nettohutang').val(addCommas(total));     
            }
            else {          
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) + parseFloat(replacepph)).toFixed(2);           
              $('.nettohutang').val(addCommas(total));     
            }
      }
    })

     $('.inputppn_po').change(function(){
      var jenisppn = $('.jenisppn_po').val();
  //    alert(jenisppn);
      var dpp = $('.dpp_po').val();
      dpphasil =  dpp.replace(/,/g, '');
      $this = $(this).val();

      hasil = parseFloat(($this / 100) * dpphasil);
      hasil2 =   hasil.toFixed(2);
      $('.hasilppn_po').val(addCommas(hasil2));
      console.log(hasil);
      console.log('hasil');

      if(jenisppn == 'T'){

      }
      else if (jenisppn == 'E') {
        console.log(dpphasil);
        console.log(hasil);
          if($('.hasilpph_po').val() != ''){
            hasilpph = $('.hasilpph_po').val();
            replacepph = hasilpph.replace(/,/g,'');

            hasilnetto = parseFloat((parseFloat(dpphasil)+parseFloat(hasil2)) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));

          }else{
            console.log('helo');
             hasilnetto = parseFloat(parseFloat(dpphasil) + parseFloat(hasil2));
             hsl = hasilnetto.toFixed(2);
             console.log(dpphasil);
             console.log(hasil2);
             console.log(hsl);
             console.log(hasilnetto);
             $('.nettohutang_po').val(addCommas(hsl)); 
          }
      }
    })



    //menghitung pph di dataitem
    $('.pajakpph').change(function(){
      val = $(this).val();
      var string = val.split(",");
      var tarif = string[1];
      $('.inputpph').val(tarif);

      var dpp = $('.dpp').val();
      hsldpp =  dpp.replace(/,/g, '');

      hasiltarif = parseFloat((tarif / 100) * hsldpp);
      hasiltarif2 =  hasiltarif.toFixed(2);
      $('.hasilpph').val(addCommas(hasiltarif2));

      hasilnetto = hsldpp - hasiltarif2;
      hasilnetto2 =  Math.round(hasilnetto).toFixed(2);

      //////
        pph = $('.hasilpph').val();      
        ppn = $('.hasilppn').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        jenisppn = $('.jenisppn').val();
        numeric2 = dpp.replace(/,/g,'');


      if($('.hasilppn').val() != '') { //ppn  tidak kosong
          if($('.jenisppn').val() == 'E'){
          
             ppn = $('.hasilppn').val();
             hasilppn = ppn.replace(/,/g,'');
             pph = addCommas(hasiltarif2);
             hasilpph = pph.replace(/,/g,'');
             hasilnetto = parseFloat(parseFloat(hsldpp)+parseFloat(hasilppn) - parseFloat(hasilpph)); 
             hsl = hasilnetto.toFixed(2);
             $('.nettohutang').val(addCommas(hsl));
          }

         else if(jenisppn == 'I'){ 
              
            hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));
            hargappn2 = hargappn.toFixed(2);
            
            $('.hasilppn').val(addCommas(hargappn2));

            total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2)).toFixed(2); 
            $('.nettohutang').val(addCommas(total));              
        }
        else {
       
          $('.inputppn').val('');
          $('.hasilppn').val('');
          hslnetto = parseFloat(parseFloat(hsldpp) - parseFloat(hasiltarif2));
          netto2 = hslnetto.toFixed(2);
          $('.nettohutang').addCommas(netto2);
        }
      }
      else {
     
          hslnetto = parseFloat(parseFloat(hsldpp) - parseFloat(hasiltarif2));
          netto2 = hslnetto.toFixed(2);
          $('.nettohutang').val(addCommas(netto2));
      }

    })



    $('.pajakpph_po').change(function(){
      val = $(this).val();
      var string = val.split(",");
      var tarif = string[1];
      $('.inputpph_po').val(tarif);

      var dpp = $('.dpp_po').val();
      hsldpp =  dpp.replace(/,/g, '');

      hasiltarif = parseFloat((tarif / 100) * hsldpp);
      hasiltarif2 =  hasiltarif.toFixed(2);
      $('.hasilpph_po').val(addCommas(hasiltarif2));

      hasilnetto = hsldpp - hasiltarif2;
      hasilnetto2 =  Math.round(hasilnetto).toFixed(2);

      if($('.hasilppn_po').val() != '') {
        if($('.jenisppn_po').val() == 'E'){
           ppn = $('.hasilppn_po').val();
           hasilppn = ppn.replace(/,/g,'');
           pph = addCommas(hasiltarif2);
           hasilpph = pph.replace(/,/g,'');
           hasilnetto = parseFloat(parseFloat(hsldpp)+parseFloat(hasilppn) - parseFloat(hasilpph)); 
           hsl = hasilnetto.toFixed(2);
           $('.nettohutang_po').val(addCommas(hsl));
        }
      }
      else {
        console.log('hsldpp' + hsldpp);
        console.log('hasiltarif2' + hasiltarif2 );

          hslnetto = parseFloat(hsldpp) - parseFloat(hasiltarif2);
          netto2 = hslnetto.toFixed(2);
          console.log(hslnetto);
          console.log(hsldpp);
          console.log(hasiltarif2);
          $('.nettohutang_po').val(addCommas(netto2));
      }

    })



    //menghitung diskon di header
    $('.diskon').change(function(){
      val = $(this).val();
      totalharga = $('.amount').val();
      hsljml =  totalharga.replace(/,/g, '');
      total = parseFloat((val / 100) * hsljml);
      
      hasiltotal = total.toFixed(2);
      $('.hasildiskonitem').val(addCommas(hasiltotal));

      hasil = hsljml - total;
      numeric = Math.round(hasil).toFixed(2);

      $('.biaya').val(addCommas(numeric));

    })


    //tambah data item
    $('.disc_item').change(function(){
      jumlahharga = $('.jumlahharga').val();
      hsljml2 =  jumlahharga.replace(/,/g, '');
      disc = $(this).val();
      total = parseFloat((disc)/100 * hsljml2);

      hasiltotal = total.toFixed(2);

      $('.hasildiskon').val(addCommas(hasiltotal));

      hasil2 = parseFloat(hsljml2 - total);

      numeric2 =hasil2.toFixed(2);
      $('.dpp').val(addCommas(numeric2));
       $('.nettohutang').val(numeric2);
        
        pph = $('.pajakpph').val();
        ppn = $('.hasilppn').val();
        jenisppn = $('.jenisppn').val();
        inputppn = $('.inputppn').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');


        if(pph != '' & ppn != '') { // JIKA PPH DAN PPN TIDAK KOSONG
          jenisppn = $('.jenisppn').val();
          if(jenisppn == 'E') {
            hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang').val(addCommas(hsl));
          }
          else if(jenisppn == 'I') {
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) + parseFloat(replacepph)).toFixed(2);
             
              $('.nettohutang').val(addCommas(total));                
          }
        }
        else if(pph != ''){ // JIKA PPH TIDAK KOSONG
          console.log('2');
          if(ppn = '') {
         
            hasil = parseFloat(parseFloat(numeric2) + parseFloat(replacepph));
            $('.nettohutang').val(addCommas(hasil));
          }
          else{
            if(jenisppn == 'E') {
          
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang').val(addCommas(hsl));
            }
            else if(jenisppn == 'I'){
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) - parseFloat(replacepph)).toFixed(2);
             
              $('.nettohutang').val(addCommas(total)); 
            }
            else if(jenisppn == 'T'){               
                total = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)).toFixed(2);
                $('.nettohutang').val(addCommas(total));
                $('.inputppn').val('');
                $('.hasilppn').val('');             
            }
          }
        }
        else if(ppn != '') { // PPN tidak kosong      
         
          if(pph = ''){ //PPH KOSONG && PPN ADA
          
              if(jenisppn == 'E'){
                console.log('3.1.1');
                hasil = parseFloat(parseFloat(numeric2) + parseFloat(ppn));
                hsl = hasil.toFixed(2);
                $('.nettohutang').val(addCommas(hsl));
              }
              else if(jenisppn == 'I'){
                 hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
                 hargappn2 = hargappn.toFixed(2);
                 $('.hasilppn').val(addCommas(hargappn2));
                 total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) - parseFloat(replacepph)).toFixed(2);
                 $('.nettohutang').val(addCommas(total)); 
              }
              else {
                $('.hasilppn').val('');
                $('.nettohutang').val(addCommas(numeric2));
              }
          }
          else{          
             if(jenisppn == 'E') { //PPN ADA PPH TIDAK KOSONG
           
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang').val(addCommas(hsl));
            }
            else if (jenisppn == 'I'){
              hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));             
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang').val(addCommas(total)); 
            }
            else {
              total = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang').val(addCommas(total));
              $('.inputppn').val('');
              $('.hasilppn').val('');
            }
          }
        }
        else {
          $('.nettohutang').val(addCommas(numeric2));
        }


    })


   


    $('.clear').click(function(){
      $('.item').prop('selectedIndex',0);
      $('.qty').val('');
      $('.gudang').val('');
      $('.harga').val('');
      $('.amount').val('');
      $('.biaya').val('');
      $('.acc_biaya').val('');
      $('.keterangan').val('');
      $('.diskon').val('');
      $('.hasildiskonitem').val('');
    })

    $('.harga').change(function(){
      val = $(this).val();
      qty = $('.qty').val();

      numeric = Math.round(val).toFixed(2);
      $(this).val(addCommas(numeric));

      if(qty != '') {
        amount = parseInt(qty) * parseInt(val);
        num_amount = Math.round(amount).toFixed(2);
        numeric = Math.round(val).toFixed(2);
        harga = addCommas(numeric);
        $(this).val(harga);
        $('.amount').val(addCommas(num_amount));
      }
    })


    $('.qty').change(function(){
      val = $(this).val();
      harga = $('.harga').val();
      console.log(harga);

      if(harga != ''){

         hsljml =  harga.replace(/,/g, '');
        amount = parseInt(val) * parseInt(hsljml);
        num_amount = Math.round(amount).toFixed(2);
        console.log(parseInt(harga));
        console.log(val);
        $('.amount').val(addCommas(num_amount));
      }
    })


    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    }).datepicker("setDate", "0");;


 tableDetail = $('.tbl-purchase').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      var sukses = 0;
      //update_T
       $('#form_jumlah').submit(function(event){

        pajakmasukan = $('.inputfakturpajakmasukan').val();
        tandaterima = $('.inputtandaterima').val();
        inputppn = $('.inputppn').val();
        hasilppn = $('.hasilppn').val();

        if(inputppn != '' && hasilppn != '' ) {
          if(pajakmasukan == 'edit'|| pajakmasukan == ''){
          
            toastr.info("Mohon maaf Anda belum menginputkan data pajak masukan :)");
            return false;
          }
        }
       if(tandaterima == ''){
          toastr.info("Mohon maaf Anda belum menginputkan data form tanda terima :)");
          return false;
        }
        else{
         
        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Faktur Pembelian!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
        $.ajax({
          type : "get",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
            console.log(response);
             if(response == 'sukses') {
                alertSuccess(); 
              window.location.href = baseUrl + "/fakturpembelian/fakturpembelian";
             }
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      }
      })

       //savefakturpo

       $('#savefakturpo').submit(function(event){

          event.preventDefault();
          var post_url3 = $(this).attr("action");
          var form_data3 = $(this).serialize();
          var jsonString = JSON.stringify(form_data3);
           swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Faktur Pembelian!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
          },
           function(){
          $.ajax({
            type : "post",
            data : form_data3,
            url : post_url3,
          
            success : function(response){
               
                  alertSuccess(); 
                   window.location.href = baseUrl + "/fakturpembelian/fakturpembelian"; 
              
              
            },
            error:function(data){
                swal("Error", "Server Sedang Mengalami Masalah", "error");
            }
          })
          });
       })



     //saveitem
      var nourut = 1;
      $jumlahharga = 0;
      $('#myform').submit(function(event){
        $('.idsup').attr('disabled', true);  
          $('.keterangan2').attr('disabled' , true);

          $('.noinvoice').attr('disabled' , true);
          $('.groupitem').attr('disabled' , true);


        event.preventDefault();
          var post_url = $(this).attr("action");
          var form_data = $(this).serialize();
       
          var updatestock = $('.updatestock').val();
          $('.updatestock').attr('disabled', true);

          var item = $('.item').val();
          var string = item.split(",");
          namaitem = string[2];
          kodeitem = string[0];
          console.log(namaitem);

          var qty = $('.qty').val();
          var gudang = $('.gudang').val();
          var harga = $('.harga').val();
         
          var string2 = gudang.split(",");
          nmgudang = string2[1];
          var amount = $('.amount').val();
          var diskon = $('.diskon').val();
          var biaya = $('.biaya').val();
          var acc_biaya = $('.acc_biaya').val();
          var acc_persediaan = $('.acc_persediaan').val();
          var keterangan = $('.keterangan').val();
         
       
          var penerimaan = $('.penerimaan').val();

          var grupitem = $('.groupitem').val();
          var string4 = grupitem.split(",");
          groupitem = string4[0];
         // alert(penerimaan);

         

          var  row = "<tr id='data-item-"+nourut+"'> <td>"+nourut+"</td>"+
                  "<td> <select class='form-control barangitem brg-"+nourut+"'  name='item[]' data-id="+nourut+"> @foreach($data['barang'] as $brg) <option value='{{$brg->kode_item}},{{$brg->harga}},{{$brg->nama_masteritem}}'>{{$brg->nama_masteritem}}</option> @endforeach </select>  </td>" + //nama barang

                  "<td> <input type='text' class='form-control qtyitem qtyitem"+nourut+"' value="+qty+" name='qty[]' data-id="+nourut+"> " +
                  "<input type='hidden' class='form-control groupitem' value="+groupitem+" name='groupitem'> </td>"+ //qty
                  
                  "<td> <select class='form-control gudangitem gudangitem"+nourut+"' name='gudang[]'> @foreach($data['gudang'] as $gudang)  <option value='{{$gudang->mg_id}},{{$gudang->mg_namagudang}}'> {{$gudang->mg_namagudang}} </option> @endforeach</select> </td>"+ //gudang

                  "<td> <input type='text' class='form-control hargaitem hargaitem"+nourut+"' value='"+ addCommas(harga)+"' name='harga[]' data-id="+nourut+"></td>"+ //harga

                  "<td> <input type='text' class='form-control totalbiayaitem totalbiayaitem"+nourut+"' value='"+ amount+"' name='totalharga[]' readonly> </td>"+ //total harga

             

                  "<td> <input type='text' class='form-control updatestockitem updatestockitem"+nourut+"' value='"+updatestock+"'  name='updatestock[]'> </td>"+ // updatestock
                       "<td> <input type='text' class='form-control diskonitem2 diskonitem2"+nourut+"' value='"+diskon+"' name='diskonitem[]' data-id="+nourut+"> </td>" + //diskon

                  "<td>  <input type='text' class='form-control biayaitem biayaitem"+nourut+"' value='"+biaya+"'  name='biaya[]'> </td>"+ //biaya

                  "<td> <input type='text' class='form-control acc_biayaitem acc_biayaitem"+nourut+"' value='"+acc_biaya+"' name='acc_biaya[]'> </td>"+ //acc_biaya

                  "<td> <input type='text' class='form-control acc_persediaanitem acc_persediaanitem"+nourut+"' value='"+acc_biaya+"' name='acc_persediaan[]'> </td>"+ //acc_persediaan

                  "<td> <input type='text' class='form-control keteranganitem keteranganitem"+nourut+"' value='"+keterangan+"'  name='keteranganitem[]'>  <input type='hidden' name='penerimaan[]' class='penerimaan' value='"+penerimaan+"'></td>" +
                  
                  "<td class='edit"+nourut+"'> <button class='btn btn-sm btn-danger removes-btn' data-id='"+nourut+"' type='button'> <i class='fa fa-trash'></i> </button> "+
                  " </td> </tr>"; 

/*
                  <button class='btn btn-xs btn-success update' data-id='"+nourut+"' type='button' id='toggle"+nourut+"'> <i id='edit"+nourut+"' class='fa fa-pencil' aria-hidden='true'></i>"+nourut+"*/

                  hsljml =  biaya.replace(/,/g, '');
                  console.log(hsljml);

                  $jumlahharga = $jumlahharga + parseInt(hsljml);
                  numeric = Math.round($jumlahharga).toFixed(2);
                  $('.jumlahharga').val(addCommas(numeric));
                  $('.dpp').val(addCommas(numeric));
                  $('.nettohutang').val(addCommas(numeric));

                  //cek jika double item
                  nobrg = nourut - 1;
                  idbarang = $('.brg-'+nobrg).val();

                  if(item == idbarang){
                    alert('Mohon maaf barang tersebut sudah ditambah :)');
                  }
                  else {
                    $('#tablefp').append(row);
                  }

                
                 $('.brg-'+nourut).val(item);

                 //pembersihan value
                 //pembersihan data
                $('.item').prop('selectedIndex',0);
                $('.qty').val('');
                $('.gudang').val('');
                $('.harga').val('');
                $('.amount').val('');
                $('.biaya').val('');
                $('.acc_biaya').val('');
                $('.keterangan').val('');
                $('.diskon').val('');
                $('.hasildiskonitem').val('');


                 //change di table item
                 $('.barangitem').change(function(){
                    var id = $(this).data('id');
                    var barang = $(this).val();
                    var string = barang.split(",");
                    var harga = string[1];
                    $('.hargaitem' + id).val(addCommas(harga));

                     qty = $('.qtyitem' + id).val();
                     diskon = $('.diskonitem2' + id).val();
                    if(qty != '') {
                       
                      if(diskon != '') {
                        totalharga = parseFloat(qty * harga);
                        hsltotal = totalharga.toFixed(2);
                        $('.totalbiayaitem' + id).val(hsltotal);
                        
                        diskon2 = parseFloat(diskon * hsltotal / 100);
                        hsldiskon = diskon2.toFixed(2);
                        totalbiaya = parseFloat(hsltotal - hsldiskon);
                        hslbiaya = totalbiaya.toFixed(2);
                        $('.biayaitem' + id).val(addCommas(hslbiaya)); 
                      }
                      else {
                        totalharga = parseFloat(qty * harga);
                        hsltotal = totalharga.toFixed(2);
                        $('.totalbiayaitem' + id).val(addCommas(hsltotal));
                      }
                    }
                 })

                 $('.qtyitem').change(function(){
                    var id = $(this).data('id');
                    var qty = $(this).val();
                    harga = $('.hargaitem' + id).val();
                    
                    console.log(harga + 'harga');
                    hslharga =  harga.replace(/,/g, '');

                    var hasil = parseFloat(qty * hslharga);
                    hsl = hasil.toFixed(2);
                    $('.totalbiayaitem' + id).val(addCommas(hsl));
                 })

                 $('.diskonitem2').change(function(){
                    var id = $(this).data('id');
                    var totalharga = $('.totalbiayaitem' + id).val();
                    hsltotalharga =  totalharga.replace(/,/g, '');

                    diskon = $(this).val();
                    diskon2 = parseFloat(diskon * hsltotalharga / 100);
                    console.log(diskon2);
                    hsldiskon = diskon2.toFixed(2);
                    totalbiaya = parseFloat(hsltotalharga - hsldiskon);
                    console.log(totalbiaya);
                    hsltotalbiaya = totalbiaya.toFixed(2);

                    $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); 
                 })


          nourut++;



        $(document).on('click','.removes-btn',function(){
          var id = $(this).data('id');
         
          var parent = $('#data-item-'+id);
          parent.remove();

       })

        $(document).on('click','.update',function(){
          var id = $(this).data('id');
          $('.brg-' +id).attr('disabeld', false);
          $('.qty' +id).attr('readonly', false);
          $('.gudang' +id).attr('readonly', false);
          $('.harga' +id).attr('readonly', false);
          $('.totalbiaya' +id).attr('readonly', false);
          $('.updatestock' +id).attr('readonly', false);
          $('.biaya' +id).attr('readonly', false);
          $('.acc_biaya' +id).attr('readonly', false);
          $('.keterangan' +id).attr('readonly', false);

          $('i#edit'+id).toggleClass('fa-pencil fa-floppy-o');
         /* $('button#toggle'+id).toggleClass('update save');*/

         /* $('button#toggle'+id).toggleClass('btn-success btn-warning');
          $('button#toggle'+id).toggleClass('update save');*/
       })

        $(document).on('click','.save',function(){
          var id = $(this).data('id');
          $('.brg-' +id).attr('disabeld', true);
          $('.qty' +id).attr('readonly', true);
          $('.gudang' +id).attr('readonly', true);
          $('.harga' +id).attr('readonly', true);
          $('.totalbiaya' +id).attr('readonly', true);
          $('.updatestock' +id).attr('readonly', true);
          $('.biaya' +id).attr('readonly', true);
          $('.acc_biaya' +id).attr('readonly', true);
          $('.keterangan' +id).attr('readonly', true);

          $('i#edit'+id).toggleClass('fa-floppy-o fa-pencil');
            $('button#toggle'+id).toggleClass('save update');

        /*  $('button#toggle'+id2).toggleClass('btn-warning btn-success');
          $('button#toggle'+id).toggleClass('save update');*/

       })


    
      /*  $.ajax({
          type : "post",
          data : form_data,
          url : post_url,
          dataType : 'json',
          success : function (response){
            $no = 1;
            $jumlahharga = 0;
            console.log(response.fpdt.length);
            for(var j = 0; j < response.fpdt.length; j++){
            var  row = "<tr id='data-item'> <td>"+$no+"</td> <td>"+response.fpdt[j].nama_masteritem+"</td> <td>"+response.fpdt[j].fpdt_qty+"</td> <td>"+response.fpdt[j].mg_namagudang+"</td> <td>"+ addCommas(response.fpdt[j].fpdt_harga)+"</td> <td>"+ addCommas(response.fpdt[j].fpdt_totalharga)+"</td> <td>"+response.fpdt[j].fpdt_updatedstock+"</td> <td>"+response.fpdt[j].fpdt_biaya+"</td> <td>"+ response.fpdt[j].fpdt_accbiaya+"</td><td>"+response.fpdt[j].fpdt_keterangan+"</td></tr>";

              $jumlahharga = $jumlahharga + parseInt(response.fpdt[j].fpdt_totalharga);

                var num = Math.round($jumlahharga).toFixed(2);
              $('.jumlahharga').val(addCommas(num));
              $no++;
            }
               $('#tablefp').append(row);
            
               $('.no_faktur').val(response.fpdt[0].fp_nofaktur);
          }
        })*/
      })

   
      //mendapatkan data fpdt

      //supplier
    $('.idsup_po').change(function(){

      $('.loading').css('display', 'block');

      tanggal = $('.tgl').val();
      // bulan - bulan
      var months = new Array(12);
      months[0] = "January";
      months[1] = "February";
      months[2] = "March";
      months[3] = "April";
      months[4] = "May";
      months[5] = "June";
      months[6] = "July";
      months[7] = "August";
      months[8] = "September";
      months[9] = "October";
      months[10] = "November";
      months[11] = "December";
      url = baseUrl + '/fakturpembelian/getchangefaktur';
      idsup = $(this).val();
     
    /*  alert(idsup);*/
       $('.supplier_po').val(idsup);
          $.ajax({    
          type :"get",
          data : {idsup},
          url : url,
          dataType:'json',
          success : function(response){
            console.log(response);
           $('.loading').css('display', 'none');

            //setting jatuh tempo
             if(tanggal != '') {
               syaratkredit = parseInt(response.supplier[0].syarat_kredit);

               var date = new Date(tanggal);
               var newdate = new Date(date);

               newdate.setDate(newdate.getDate() + syaratkredit);

               var dd = newdate.getDate();
               var MM = newdate.getMonth() ;
               var y = newdate.getFullYear();

               var newyear = dd + '-' + months[MM] + '-' + y;
               $('.jatuhtempo').val(newyear);
               $('.jatuhtempo_po').val(newyear);
               $('.jatuhtempoitem').val(newyear);
            }

            rowjatuhtempo = "<input type='hidden' value="+newyear+" name='jatuhtempo'>";
            $('.kolomjatuhtempo').html(rowjatuhtempo);
            //end jatuh tempo


            //tambah data ke table data po
            var tableFPPO = $('#addColumn').DataTable();
            tableFPPO.clear().draw();
            var n = 1;
            for(var i = 0; i < response.po.length; i++){   
            console.log(response.po.length);          
                var html2 = "<tr> <td>"+ n +" </td>" +
                                "<td>"+response.po[i].nobukti+"</td>" +
                                "<td>"+response.po[i].cabang+"</td>" +
                                "<td>"+response.status[i]+"&nbsp &nbsp("+response.po[i].penerimaan+")</td>"+
                                "<td style='text-align:right'> Rp "+ addCommas(response.po[i].totalharga) +"</td> <td> </td>"+
                                "<td>";
                                    if(response.status[i] == 'BELUM DI TERIMA'){

                                        html2 += "&nbsp";
                                    }
                                    else if(response.status[i] == 'TIDAK LENGKAP') {
                                         html2 += "&nbsp";                                    }
                                    else {
                                        html2 += "<div class='checkbox'> <input type='checkbox' id="+response.po[i].nobukti+","+response.po[i].cabang+","+response.po[i].penerimaan+","+response.po[i].flag+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div> </td>";
                                    }
                                  
                              html2 +=  "</tr>";

               tableFPPO.rows.add($(html2)).draw();
               n++;
            }

        } 

     })
  
    })


    var tanggal = $('.tgl').val();

    $('.tglitem').val(tanggal);
    $('.tgl_po').val(tanggal);

    //menghitungjatuhtempo
    $('.tgl').change(function(){
    tanggal = $(this).val(); 

    $('.tgl_po').val(tanggal);
    $('.tglitem').val(tanggal);
    val = $('.idsup').val();

    if(val != ''){


    var string = val.split(",");
    syaratkredit = string[1];

       var months = new Array(12);
      months[0] = "January";
      months[1] = "February";
      months[2] = "March";
      months[3] = "April";
      months[4] = "May";
      months[5] = "June";
      months[6] = "July";
      months[7] = "August";
      months[8] = "September";
      months[9] = "October";
      months[10] = "November";
      months[11] = "December";

             var date = new Date(tanggal);
             var newdate = new Date(date);

             newdate.setDate(newdate.getDate() + syaratkredit);

             var dd = newdate.getDate();
             var MM = newdate.getMonth() ;
             var y = newdate.getFullYear();

             var newyear = dd + '-' + months[MM] + '-' + y;
             $('.jatuhtempo').val('');
            
            rowjatuhtempo = "<input type='hidden' value="+newyear+" name='jatuhtempo'>";
           /* $('.kolomjatuhtempo').html(rowjatuhtempo);*/
           /* $('.jatuhtempo_po').val(newyear);*/
      }
    })


    //tambah data PO
    $("#tmbhdatapo").click(function(){
        $('.item').prop('selectedIndex',0);
        $('.qty').val('');
        $('.gudang').val('');
        $('.harga').val('');
        $('.amount').val('');
        $('.biaya').val('');
        $('.acc_biaya').val('');
        $('.keterangan').val('');

        $('table#tablefp tr#data-item').remove();
        $('.jumlahharga').val('');
        $('.disc_item').val('');
        $('.jenisppn').val('');
        $('.dpp').val('');

     /*   $('.tgl').val('');*/
        $('.idsup').val('');
        $('.noinvoice').val('');
        $('.jatuhtempo').val('');

    })


    //menampilkan po
     $('#buttongetid').click(function(){
      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();

      var url = baseUrl + '/fakturpembelian/tampil_po';

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
 
      variabel = [];
      variabel = checked;

      var nobukti = [];
      var cabang = [];
      var jenis = [];
      var flag = [];
      for(var i = 0 ; i < variabel.length; i++){
        string = variabel[i].split(",");
        idnobukti = string[0];
        nobukti.push(idnobukti);
        idcabang = string[1];
        cabang.push(idcabang);
        idjenis = string[2]; 
        jenis.push(idjenis);
        idflag = string[3];
        flag.push(idflag);
      }

      var uniqueNoBukti = [];
      for(ds = 0; ds < nobukti.length; ds++){
        if(uniqueNoBukti.indexOf(nobukti[ds]) === -1){
          uniqueNoBukti.push(jenis[ds]);
        }
      }


      var uniqueCabang = [];
      for(dj = 0; dj < cabang.length; dj++){
        if(uniqueCabang.indexOf(cabang[dj]) === -1){
          uniqueCabang.push(cabang[dj]);
        }
      }
   

      uniqueJenis = [];
      for(ds = 0; ds < jenis.length; ds++){
        if(uniqueJenis.indexOf(jenis[ds]) === -1){
          uniqueJenis.push(jenis[ds]);
        }
      }   

      
       uniqueFlag = [];
      for(ds = 0; ds < flag.length; ds++){
        if(uniqueFlag.indexOf(flag[ds]) === -1){
          uniqueFlag.push(flag[ds]);
        }
      } 

       $("table#table_po tr#datapo").remove();
      //buat po - tampilpo

       if(uniqueJenis.length < 2 && uniqueCabang.length < 2 && uniqueFlag.length < 2) {
       $.ajax({    
          type :"get",
          data : {nobukti,jenis,flag},
          url : url,
          dataType:'json',
          success : function(response){
        
            $('.tampilpo').empty();

            $('#myModal5').modal('hide');
                    Jumlahharga = 0;
              for(var k = 0; k < response.po.length; k++) {
                  Jumlahharga = parseInt(Jumlahharga) + parseInt(response.po[k][0].p);
              }
                //tampil po di modal
                harga =  Math.round(Jumlahharga).toFixed(2);

                
                var no = 1;
                $("table#table_po tr#datapo").remove();
                $("table#table_dataitempo tr#dataitempo").remove();

//                alert(flag);
                //jika PO 
                if(flag[0] == 'PO'){
  //                alert(flag);
                    $('th.diskonpo').remove();
                  for(var i = 0; i < response.po.length; i++) {
    //                alert('hai');
                      var rowTampil =  "<tr id='datapo'> <td>"+ no +"</td>"+
                      "<td> <a class='po' data-id="+i+" data-po="+response.po[i][0].po_id+"> "+response.po[i][0].po_no+"</td> " +
                      "<td>"+response.po[i][0].po_tipe+"</td>"+
                      "<td> Rp "+ addCommas(response.po[i][0].po_totalharga)+"</td> <input type='hidden' name='idpoheader[]' value="+response.po[i][0].po_id+"> </td>  </tr>";

                        no++;   
                       $('#table_po').append(rowTampil);    
                  } 
                }
                else if(flag[0] == "FP"){
                     for(var i = 0; i < response.po.length; i++) {
                        var rowTampil =  "<tr id='datapo'> <td>"+ no +"</td>"+
                        "<td> <a class='po' data-id="+i+" data-po="+response.po[i][0].fp_idfaktur+"> "+response.po[i][0].fp_nofaktur+"</td>"+
                        "<td>"+response.po[i][0].fp_tipe+"</td>" +
                        "<td> Rp "+ addCommas(response.po[i][0].fp_netto)+"</td> <input type='hidden' name='idpoheader[]' value="+response.po[i][0].fp_idfaktur+"> </td>  </tr>";

                          no++;   
                         $('#table_po').append(rowTampil);    
                      } 
                }

                var jumlahtotalharga_fp = 0;
              //tampil data-item unt di save
      //        alert(flag);
              if(flag[0] == 'PO'){
                $('th.diskonpo').remove();
                
                if($('th.qty_po').length < 1){
                 if($('th.qty_po')){
                   
                   $('<th class="qty_po"> Qty PO </th>').insertAfter($('.qtyterima_po'));
                  }
                  if($('.gudang_po')){
                     $('<th class="gudang_po"> Gudang </th>').insertAfter($('.qty_po'));
                  }
                    if($('th.updatestockpo')){
                     $('<th class="updatestockpo"> Updates Stock ? </th>').insertAfter($('.gudang_po'));
                  }
                }


//                $('<th class="gudang_po"> Gudang </th>').insertAfter($('.hrgpo'));

                if(jenis[0] != 'J') { // CEK PO BUKAN JENIS JASA
                    var jumlahtotalharga = 0;
                      for(var k = 0 ; k < response.po_barang.length; k++){
                        for(var z = 0; z < response.po_barang[k].length; z++){
                             var rowinput = "<tr> <th> <input type='hidden' name='item_po[]' value="+response.po_barang[k][z].pbdt_item+"> </th> <th> <input type='hidden' name='qty[]' value="+response.po_barang[k][z].sumqty+"> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pb_gudang+" name='pb_gudang[]'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pbdt_hpp+" name='hpp[]'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].sumharga+" name='totalharga[]'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pbdt_updatestock+" name='updatestock[]'> </th>   <th> <input type='hidden' value="+flag[0]+" name='flag'>  <th> <input type='hidden' value="+response.po_barang[k][z].pb_po+" name='idpo[]'></th> </tr> ";

                              $('#input_data').append(rowinput);
                                jumlahtotalharga = jumlahtotalharga + parseInt(response.po_barang[k][z].sumharga);
                                console.log('test');
                        }
                         console.log('test2' + z);
                      }
                } //end jenis JASA

                else { // PO JASA
                    var jumlahtotalharga = 0;
                  $('th.qty_po').remove();
                  $('th.gudang_po').remove();
                  $('th.hrgpo').remove();
                  $('th.updatestockpo').remove();
                      for(var k = 0 ; k < response.po_barang.length; k++){
                        for(var z = 0; z < response.po_barang[k].length; z++){
                             var rowinput = "<tr> <th> <input type='hidden' name='item_po[]' value="+response.po_barang[k][z].podt_kodeitem+"> </th> <th> <input type='hidden' name='qty[]' value="+response.po_barang[k][z].podt_qtykirim+"> </th>  <th> <input type='hidden'  value="+response.po_barang[k][z].podt_totalharga+" name='totalharga[]'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pbdt_updatestock+" name='updatestock[]'> </th>   <th> <input type='hidden' value="+response.po_barang[k][z].po_id+" name='idpo[]'>    <th> <input type='hidden' value="+flag[0]+" name='flag'>  <input type='hidden' value="+response.po_barang[k][z].podt_jumlahharga+" name='hpp[]'>  <input type='hidden' value="+jenis[0]+" name='jenis'>  </th> </tr> ";

                              $('#input_data').append(rowinput);
                         
                                jumlahtotalharga = jumlahtotalharga + parseInt(response.po_barang[k][z].podt_totalharga);
                                console.log('test');
                        }
                         console.log('test2' + z);
                      }

                 }           
              }
              else if(flag[0] == 'FP'){

                $('<th class="diskonpo"> Diskon</th>').insertAfter($('.hrgpo'));
                   
                if($('th.qty_po').length < 1){
                 if($('th.qty_po')){
                   
                   $('<th class="qty_po"> Qty PO </th>').insertAfter($('.qtyterima_po'));
                  }
                  if($('th.gudang_po')){
                     $('<th class="gudang_po"> Gudang </th>').insertAfter($('.qty_po'));
                  }
                   if($('th.updatestockpo')){
                     $('<th class="updatestockpo"> Updates Stock ? </th>').insertAfter($('.gudang_po'));
                  }
                }

                if(jenis[0] != 'J') { // FP BUKAN JASA
                for(var k = 0 ; k < response.po_barang.length; k++){
                     for(var z = 0; z < response.po_barang[k].length; z++){
                      if(response.po_barang[k][z].pbdt_updatestock == 'IYA'){
                        $updatestock_po = 'Y';
                      }
                      else {
                        $updatestock_po = 'T';
                      }

                       var rowinput = "<tr> <th> <input type='hidden' name='item_po[]' value="+response.po_barang[k][z].fpdt_kodeitem+"> </th>" +
                       "<th> <input type='hidden' name='qty[]' value="+response.po_barang[k][z].sumqty+"> </th>" + 
                       "<th> <input type='hidden' value="+response.po_barang[k][z].pb_gudang+" name='pb_gudang[]'> </th>" +
                       "<th> <input type='hidden' value="+response.po_barang[k][z].pbdt_hpp+" name='hpp[]'> </th>" +
                       "<td> <input type='text' class='form-control' value='"+response.po_barang[k][z].fpdt_diskon+"'>  </td>" +
                       "<th> <input type='hidden' value="+response.po_barang[k][z].sumharga+" name='totalharga[]'> </th>" +
                       "<th> <input type='hidden' value="+$updatestock_po+" name='updatestock[]'> </th>" +
                       "<th> <input type='hidden' value="+flag[0]+" name='flag'> </th>" +
                       "<th> <input type='hidden' value="+jenis[0]+" name='jenis'> </th>" +
                      
                        
                       "<th> <input type='hidden' value="+response.po_barang[k][z].pbdt_idfp+" name='idpo[]'></th> </tr> ";

                        $('#input_data').append(rowinput);
                        jumlahtotalharga_fp = jumlahtotalharga_fp + parseInt(response.barang_penerimaan[k].sumharga);     
                        }  
                  }
                } // END FP JENIS BUKAN JASA

                else { // FP JENIS JASA
                    var jumlahtotalharga_fp = 0;
                    $('th.qty_po').remove();
                    $('th.gudang_po').remove();
                    $('th.hrgpo').remove();
                    $('th.updatestockpo').remove();
                        for(var k = 0 ; k < response.po_barang.length; k++){
                          for(var z = 0; z < response.po_barang[k].length; z++){
                               var rowinput = "<tr> <th> <input type='hidden' name='item_po[]' value="+response.po_barang[k][z].fpdt_kodeitem+"> </th> <th> <input type='hidden' name='qty[]' value="+response.po_barang[k][z].fpdt_qty+"> </th>  <th> <input type='hidden'  value="+response.po_barang[k][z].fpdt_biaya+" name='totalharga[]'> </th> <th> <th> <input type='hidden' value="+response.po_barang[k][z].fp_idfaktur+" name='idpo[]'> <input type='hidden' value="+response.po_barang[k][z].fpdt_harga+" name='hpp[]'>   <th> <input type='hidden' value="+flag[0]+" name='flag'>  </th> </tr> ";

                                $('#input_data').append(rowinput);
                                alert()
                                  jumlahtotalharga_fp = jumlahtotalharga_fp + parseInt(response.po_barang[k][z].fpdt_biaya);
                                  console.log('test');
                          }
                         console.log('test2' + z);
                      }

                }
                   console.log('test2' + z);
                }



               if(flag[0] == 'PO') {
                 numeric = parseFloat(jumlahtotalharga).toFixed(2);
                 $('.jumlahharga_po').val(addCommas(numeric));
                 $('.dpp_po').val(addCommas(numeric));
                 $('.nettohutang_po').val(addCommas(numeric));
                }
                else if(flag[0] == 'FP'){
                  numeric = parseFloat(jumlahtotalharga_fp).toFixed(2);
                 $('.jumlahharga_po').val(addCommas(numeric));
                    $('.dpp_po').val(addCommas(numeric));
                 $('.nettohutang_po').val(addCommas(numeric));
                }
           
              //tampil data item di no po
               $('.po').each(function(){
                 
                  $(this).click(function(){
                   
                    $("table#table_dataitempo tr#dataitempo").remove();

                     $no = 1;
                  
                    for(var s = 0 ; s < response.barang_penerimaan.length; s++){
                      if(flag[0] == 'PO') {
                          if(jenis[0] != 'J') {
                             var idpo = $(this).data('po');
                       //      alert(idpo);
                            if(response.barang_penerimaan[s].pb_po == idpo) {
                     
                             var rowTable = "<tr id='dataitempo'> <td>"+ $no +"</td>" +
                             "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].pbdt_item+" name='kodeitem'> "+response.barang_penerimaan[s].nama_masteritem+"</td>" + //namaitem

                             "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].sumqty+" name='qty'>"+response.barang_penerimaan[s].sumqty+"</td>" +  //qtyterima

                             "<td>"+response.barang_penerimaan[s].podt_qtykirim+"</td>" + //qtypo

                             "<td> <input type='hidden' value="+response.barang_penerimaan[s].pb_gudang+" name='gudang'> "+response.barang_penerimaan[s].pb_comp+"</td>" + //qtypo
                            
                             "<td> <input type='hidden' value="+response.barang_penerimaan[s].pbdt_hpp+" name='harga'> "+addCommas(response.barang_penerimaan[s].pbdt_hpp)+"</td>" + //hpp

                             "<td> <input type='hidden' value="+response.barang_penerimaan[s].sumharga+" name='totalharga'> "+addCommas(response.barang_penerimaan[s].sumharga)+"</td>" + //totalharga

                             "<td> <input type='hidden' value="+response.barang_penerimaan[s].pbdt_updatestock+" name='updatestock'> "+response.barang_penerimaan[s].pbdt_updatestock+"</td> <td>"+response.barang_penerimaan[s].acc_persediaan+"</td>  <tr>";

                             $('#table_dataitempo').append(rowTable);
                               $no++;
                         }
                        }     //end jenis
                        else if(jenis[0] == 'J'){
                           var idpo = $(this).data('po');

                         // alert('jasa');
                            if(response.barang_penerimaan[s].po_id == idpo) {
                             
                               var rowTable = "<tr id='dataitempo'> <td>"+ $no +"</td>" +
                             "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].pbdt_item+" name='kodeitem'> "+response.barang_penerimaan[s].nama_masteritem+"</td>" + //namaitem

                             "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].podt_qtykirim+" name='qty'>"+response.barang_penerimaan[s].podt_qtykirim+"</td>" +  //qtyterima

                           
                             "<td> <input type='hidden' style='text-align:right' value="+response.barang_penerimaan[s].podt_totalharga+" name='totalharga'> "+addCommas(response.barang_penerimaan[s].podt_totalharga)+"</td>" + //totalharga

                             "<td>"+response.barang_penerimaan[s].acc_persediaan+"</td>  <tr>";

                             $('#table_dataitempo').append(rowTable);
                               $no++;
                            }
                        }
                      }
                      else if(flag[0] == 'FP') {
                          var idfp = $(this).data('po');
                            if(jenis[0] != 'J') {
                              if(response.barang_penerimaan[s].pb_fp == idfp) {                          
                               var rowTable = "<tr id='dataitempo'> <td>"+ $no +"</td>" +
                               "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].pbdt_item+" name='kodeitem'> "+response.barang_penerimaan[s].nama_masteritem+"</td>" + //namaitem

                               "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].sumqty+" name='qty'>"+response.barang_penerimaan[s].sumqty+"</td>" +  //qtyterima

                               "<td>"+response.barang_penerimaan[s].fpdt_qty+"</td>" + //qtypo

                               "<td> <input type='hidden' value="+response.barang_penerimaan[s].pb_gudang+" name='gudang'> "+response.barang_penerimaan[s].pb_comp+"</td>" + //qtypo
                              
                               "<td> <input type='hidden' value="+response.barang_penerimaan[s].pbdt_hpp+" name='harga'> "+addCommas(response.barang_penerimaan[s].pbdt_hpp)+"</td>" + //hpp

                               "<td> <input type='hidden' class='form-control' value='"+response.barang_penerimaan[s].fpdt_diskon+"'> "+response.barang_penerimaan[s].fpdt_diskon+" %</td>" +

                               "<td> <input type='hidden' value="+response.barang_penerimaan[s].sumharga+" name='totalharga'> "+addCommas(response.barang_penerimaan[s].sumharga)+"</td>" + //totalharga

                               "<td> <input type='hidden' value="+response.barang_penerimaan[s].pbdt_updatestock+" name='updatestock'> "+response.barang_penerimaan[s].pbdt_updatestock+"</td>" +

                                "<td>" + response.barang_penerimaan[s].fpdt_accbiaya+"</td>  </tr>";


                               $('#table_dataitempo').append(rowTable);
                                 $no++;
                              }  
                      } // END FP BUKAN JASA
                      else {
                         if(response.barang_penerimaan[s].fp_idfaktur == idfp) {                          
                               var rowTable = "<tr id='dataitempo'> <td>"+ $no +"</td>" +
                               "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].pbdt_item+" name='kodeitem'> "+response.barang_penerimaan[s].nama_masteritem+"</td>" + //namaitem

                               "<td> <input type='hidden' class='form-control' value="+response.barang_penerimaan[s].sumqty+" name='qty'>"+response.barang_penerimaan[s].fpdt_qty+"</td>" +  //qtyterima

                              
                              

                               "<td> <input type='hidden' class='form-control' value='"+response.barang_penerimaan[s].fpdt_diskon+"'> "+response.barang_penerimaan[s].fpdt_diskon+" %</td>" +

                               "<td> <input type='hidden' value="+response.barang_penerimaan[s].fpdt_biaya+" name='totalharga'>Rp  "+addCommas(response.barang_penerimaan[s].fpdt_biaya)+"</td>" + //totalharga


                                "<td>" + response.barang_penerimaan[s].acc_persediaan+"</td>  </tr>";


                               $('#table_dataitempo').append(rowTable);
                                 $no++;
                              } 
                      }
                    } 

                     //flag PO untuk jumlah harga;                     
                  } //endfor
               })             
          })      
    }
         })
    }
        else if(uniqueCabang.length > 1){
          alert('Maaf Cabang yang di inputkan harus sama :) ');
        }
        else if(uniqueJenis.length > 1){
           alert('Maaf Tipe Transaksi tidak sama :) '); 
        }
          else if(uniqueFlag.length > 1){
           alert('Maaf Jenis Transaksi tidak sama :) '); 
        }
    })
    
  //item TANPA PO
    $('.item').change(function(){
      $this = $(this).val();
      var string = $this.split(",");
      var harga = string[1];
        var acc_persediaan = string[3];
      var acc_hpp = string[4];
    
      $('.acc_biaya').val(acc_hpp);
      $('.acc_persediaan').val(acc_persediaan);
      $('.harga').val(addCommas(harga));

      qty = $('.qty').val();
      diskon = $('.diskon').val();

      if(qty != '') {
          if(diskon != '') {
            hasil = parseFloat(qty * harga);  
            totalharga = hasil.toFixed(2);
            $('.amount').val(addCommas(totalharga));
            
            hsldiskon = parseFloat(diskon * 100) / 100;
            biaya = totalharga - hsldiskon;
            hslamount = biaya.toFixed(2); 
            $('.biaya').val(hslamount);
          }
          else {
            hasil = parseFloat(qty * harga);  
            totalharga = hasil.toFixed(2);
              $('.amount').val(addCommas(totalharga));
          }
      }
    })

    $('.idsup').change(function(){
       updatestock = $('.updatestock').val();
       idsupplier = $(this).val();
       grupitem = $('.groupitem').val();

      // alert(updatestock);
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);

       var variable = grupitem.split(",");
       var groupitem = variable[0];
       var stock = variable[1];
        $('.idsupitem').val(idsup);

        tanggal = $('.tgl').val();
        // bulan - bulan
        var months = new Array(12);
        months[0] = "January";
        months[1] = "February";
        months[2] = "March";
        months[3] = "April";
        months[4] = "May";
        months[5] = "June";
        months[6] = "July";
        months[7] = "August";
        months[8] = "September";
        months[9] = "October";
        months[10] = "November";
        months[11] = "December";



       if(idsup == '') {
         
       }
       else {
          $.ajax({    
            type :"post",
            data : {idsup, updatestock, groupitem, stock },
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){



              if(tanggal != '') {
               syaratkredit = parseInt(data.supplier[0].syarat_kredit);

               var date = new Date(tanggal);
               var newdate = new Date(date);

               newdate.setDate(newdate.getDate() + syaratkredit);

               var dd = newdate.getDate();
               var MM = newdate.getMonth() ;
               var y = newdate.getFullYear();

               var newyear = dd + '-' + months[MM] + '-' + y;
               $('.jatuhtempo').val(newyear);
               $('.jatuhtempo_po').val(newyear);
               $('.jatuhtempoitem').val(newyear);
              }



               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                     
                      $('.harga').attr('readonly' , true);
                      $('#item').empty();

                      $('#item').append(" <option value=''>  -- Pilih Barang -- </option> ");

                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                            $('#item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                           $("#item").trigger("chosen:updated");
                           $("#item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('#item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('#item').append(rowKosong);   
                        $("#item").trigger("chosen:updated");
                        $("#item").trigger("liszt:updated");          
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+","+obj.acc_persediaan+","+obj.acc_hpp+"'>"+obj.nama_masteritem+"</option>");
                             $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                          $("#item").trigger("chosen:updated");
                           $("#item").trigger("liszt:updated");           
                    }
                  }
                } //end respon ajax
            
          })
        }
    })


       grupitem = $('.groupitem').val();
       
      
       var variable = grupitem.split(",");
       var groupitem = variable[0];
       var stock = variable[1];
        $('.penerimaan').val(stock);
    //cek group item
    $('.groupitem').change(function(){
       updatestock = $('.updatestock').val();
       idsupplier = $('.idsup').val();
       grupitem = $('.groupitem').val();
       
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);


       var variable = grupitem.split(",");
       var groupitem = variable[0];
       var stock = variable[1];
     // alert(stock);

       if(idsup == '') {
          alert('Dimohon untuk pilih Supplier Terlebih Dahulu :)');
       }
       if(stock == 'T') {
            $('.penerimaan').val(stock);
           //$('tr#tdupdatestock').css('display', 'none');
           $('td#tdupdatestock').css('display', 'none');
           $.ajax({    
            type :"post",
            data : {idsup, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+","+obj.acc_persediaan+","+obj.acc_hpp+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
       }
       else if(stock == 'Y'){
       // alert(updatestock);
        $('.penerimaan').val(stock);
           //$('tr#tdupdatestock').css('display', 'block');
           $('td#tdupdatestock').css('display', 'block');
       

          $.ajax({    
            type :"post",
            data : {idsup, updatestock, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
        }
        
    })

    //cek barang updatestock
    $('.updatestock').change(function(){
       updatestock = $(this).val();
       idsupplier = $('.idsup').val();
       grupitem = $('.groupitem').val();
      // alert(updatestock);
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);


       var variable = grupitem.split(",");
       var groupitem = variable[0];
       var stock = variable[1];

       if(idsup == '') {
          alert('Dimohon untuk pilih Supplier Terlebih Dahulu :)');
       }
       else {
          $.ajax({    
            type :"post",
            data : {idsup, updatestock, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
        }
    })
    
    //menampilkandiskon_po
    $('.disc_item_po').change(function(){
      jumlahharga = $('.jumlahharga_po').val();
      hsljml2 =  jumlahharga.replace(/,/g, '');
      disc = $(this).val();
      total = parseFloat((disc)/100 * hsljml2);

      hasiltotal = total.toFixed(2);

      $('.hasildiskon_po').val(addCommas(hasiltotal));

      hasil2 = parseFloat(hsljml2 - total);

      numeric2 =hasil2.toFixed(2);
      $('.dpp_po').val(addCommas(numeric2));
     $('.nettohutang_po').val(numeric2);
        
        pph = $('.pajakpph_po').val();
        ppn = $('.hasilppn_po').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        if(pph != '' & ppn != '') {
          console.log('1');
          jenisppn = $('.jenisppn_po').val();
          if(jenisppn == 'E') {
            console.log('1.1')
           

            hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));
          }
        }
        else if(pph != ''){
          console.log('2');
          if(ppn = '') {
            console.log('2.1');
            hasil = parseFloat(parseFloat(numeric2) + parseFloat(replacepph));
            $('.nettohutang_po').val(hasil);
          }
          else{
            console.log('2.1.2');
              jenisppn = $('.jenisppn_po').val();
            if(jenisppn == 'E') {
              console.log('2.2');
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
            }
          }
        }
        else if(ppn != '') {
          console.log('3');
          jenisppn = $('.jenisppn_po').val();
          if(pph = ''){
            console.log('3.1');
              if(jenisppn == 'E'){
                console.log('3.1.1');
                hasil = parseFloat(parseFloat(numeric2) + parseFloat(ppn));
                hsl = hasil.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
              }
          }
          else{
            console.log('3.1.1');
             if(jenisppn == 'E') {
              console.log('3.1.2');
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
            }
          }
        }
        else {
          console.log('.3.1.2.3');
          $('.nettohutang_po').val(numeric2);
        }
    })  
  


    $('.tbmh-data').click(function(){
      $('.tbmh-po').attr('disabled' , true);
      var htmlrows = "<table class='table'> <tr> <td> na </td></tr> </table";
    

          $('.table-databarang').html(htmlrow);
                console.log($('.qty').val());
          //close
          $('#close').click(function(){
             $('.table-databarang').empty();
             $('.tbmh-po').attr('disabled', false);
          })

    }) 

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
  // data biaya penerus

   var total = [];
   var temp =[];
   var arrayPo=[];
   var id_persen;

   $(".tmbhdatapenerus").on('click',function(e){
    e.preventDefault();

   var cab = $('.cabang').val();

      $.ajax({
      url:baseUrl + '/fakturpembelian/notapenerusagen',
      data:'cab='+cab,
      type:'get',
      success:function(response){
        $('.nofaktur').val(response.nota);
      }
    })

    $(".tmbhdatapenerus").addClass('disabled');
    $(".tmbhdatapenerus").css('background','grey');
    $(".tmbhdatapenerus").css('color','black');

    $(".tmbhdatapo").removeClass('disabled');
    $(".tmbhdatapo").css('background','none');
    $(".tmbhdatapo").css('color','none');

    $(".tmbhdataitem").removeClass('disabled');
    $(".tmbhdataitem").css('background','none');
    $(".tmbhdataitem").css('color','none');

    $(".tmbhdataoutlet").removeClass('disabled');
    $(".tmbhdataoutlet").css('background','none');
    $(".tmbhdataoutlet").css('color','none');

    $(".tmbhdatasubcon").removeClass('disabled');
    $(".tmbhdatasubcon").css('background','none');
    $(".tmbhdatasubcon").css('color','none');

    
   })

   $(".tmbhdatapo").on('click',function(e){

    e.preventDefault();
var old_nota =$('.nofaktur1').val();
    $('.nofaktur').val(old_nota);

    $(".tmbhdatapenerus").removeClass('disabled');
    $(".tmbhdatapenerus").css('background','none');
    $(".tmbhdatapenerus").css('color','none');

    $(".tmbhdatapo").addClass('disabled');
    $(".tmbhdatapo").css('background','grey');
    $(".tmbhdatapo").css('color','black');
   
    $(".tmbhdataitem").removeClass('disabled');
    $(".tmbhdataitem").css('background','none');
    $(".tmbhdataitem").css('color','none');

    $(".tmbhdataoutlet").removeClass('disabled');
    $(".tmbhdataoutlet").css('background','none');
    $(".tmbhdataoutlet").css('color','none');

    $(".tmbhdatasubcon").removeClass('disabled');
    $(".tmbhdatasubcon").css('background','none');
    $(".tmbhdatasubcon").css('color','none');
   })

   $(".tmbhdataitem").on('click',function(e){
    e.preventDefault();
   var old_nota =$('.nofaktur1').val();
    $('.nofaktur').val(old_nota);
    $(".tmbhdatapenerus").removeClass('disabled');
    $(".tmbhdatapenerus").css('background','none');
    $(".tmbhdatapenerus").css('color','none');

    $(".tmbhdatapo").removeClass('disabled');
    $(".tmbhdatapo").css('background','none');
    $(".tmbhdatapo").css('color','none');

    $(".tmbhdataitem").addClass('disabled');
    $(".tmbhdataitem").css('background','grey ');
    $(".tmbhdataitem").css('color','black');

    $(".tmbhdataoutlet").removeClass('disabled');
    $(".tmbhdataoutlet").css('background','none');
    $(".tmbhdataoutlet").css('color','none');

    $(".tmbhdatasubcon").removeClass('disabled');
    $(".tmbhdatasubcon").css('background','none');
    $(".tmbhdatasubcon").css('color','none');
   })

   $(".tmbhdataoutlet").on('click',function(e){
   var cab = $('.cabang').val();

    e.preventDefault();
    $.ajax({
      url:baseUrl + '/fakturpembelian/notaoutlet',
      data:'cab='+cab,
      type:'get',
      success:function(response){
        $('.nofaktur').val(response.nota);
      }
    })
    $(".tmbhdatapenerus").removeClass('disabled');
    $(".tmbhdatapenerus").css('background','none');
    $(".tmbhdatapenerus").css('color','none');

    $(".tmbhdatapo").removeClass('disabled');
    $(".tmbhdatapo").css('background','none');
    $(".tmbhdatapo").css('color','none');

    $(".tmbhdataitem").removeClass('disabled');
    $(".tmbhdataitem").css('background','none ');
    $(".tmbhdataitem").css('color','none');

    $(".tmbhdataoutlet").addClass('disabled');
    $(".tmbhdataoutlet").css('background','grey');
    $(".tmbhdataoutlet").css('color','black');

    $(".tmbhdatasubcon").removeClass('disabled');
    $(".tmbhdatasubcon").css('background','none');
    $(".tmbhdatasubcon").css('color','none');
   });

   $(".tmbhdatasubcon").on('click',function(e){
   var cab = $('.cabang').val();

    e.preventDefault();

    $.ajax({
      url:baseUrl + '/fakturpembelian/notasubcon',
      data:'cab='+cab,
      type:'get',
      success:function(response){
        $('.nofaktur').val(response.nota);
      }
    })

    $(".tmbhdatapenerus").removeClass('disabled');
    $(".tmbhdatapenerus").css('background','none');
    $(".tmbhdatapenerus").css('color','none');

    $(".tmbhdatapo").removeClass('disabled');
    $(".tmbhdatapo").css('background','none');
    $(".tmbhdatapo").css('color','none');

    $(".tmbhdataitem").removeClass('disabled');
    $(".tmbhdataitem").css('background','none ');
    $(".tmbhdataitem").css('color','none');

    $(".tmbhdataoutlet").removeClass('disabled');
    $(".tmbhdataoutlet").css('background','none');
    $(".tmbhdataoutlet").css('color','none');

    $(".tmbhdatasubcon").addClass('disabled');
    $(".tmbhdatasubcon").css('background','grey');
    $(".tmbhdatasubcon").css('color','black');
   });


$(document).ready(function(){
  $.ajax({
      url:baseUrl + '/fakturpembelian/getdatapenerus',
      type:'get',
      success:function(data){
        $('.resi').html(data);
      },
      error:function(){
        location.reload();
      }

    })

  $.ajax({
      url:baseUrl + '/fakturpembelian/getpembayaranoutlet',
      type:'get',
      success:function(data){
        $('.outlet').html(data);
       $('.reportrange').daterangepicker({
              autoclose: true,
              "opens": "left",
          locale: {
            format: 'DD/MM/YYYY'
        }
          
       });
      },
      error:function(){
        location.reload();
      }

    })

  $.ajax({
      url:baseUrl + '/fakturpembelian/getpembayaransubcon',
      type:'get',
      success:function(data){
        $('.subcon').html(data);
       $('.reportrange').daterangepicker({
              autoclose: true,
              "opens": "left",
          locale: {
            format: 'DD/MM/YYYY'
        }
          
       });
      },
      error:function(){
        location.reload();
      }

    })

  cari_outlet();
  $('.msh_hdn').attr('hidden',true);

 
});
    


   function tipe(){
    var tipe = $('.tipe').val();
    var kas = $('.kas').val();
    if(tipe == 'kas'){
      $('.kas').attr('hidden',false);
    }else if(tipe == 'kashutang'){
      $('.kas').attr('hidden',false);
    }else{
      $('.kas').attr('hidden',true);
    }
   }

   function kon(){
    var kontak = $('.kontak').val();
    if(kontak == 'vendor'){
      $('.vendor').attr('hidden',false);
      $('.nama-kontak-cash').attr('hidden',true);
      $('.nama-kontak-agen').attr('hidden',true);
      $('.nama-kontak-kosong').attr('hidden',false);
    }else{
      $('.vendor').attr('hidden',true);
      $('.nama-kontak-agen').attr('hidden',true);
      $('.nama-kontak-vendor').attr('hidden',true);
      $('.nama-kontak-cash').attr('hidden',false);
      $('.vendor1').val('kosong');
    }
   }
   
   function ven(){
    $('.nama-kontak-vendor1').val('0').trigger("chosen:updated");
    $('.nama-kontak-agen1').val('0').trigger("chosen:updated");
    var vendor = $('.vendor1').val();
    var cabang = $('.cabang').val();
    if(vendor == 'AGEN'){

      $('.nama-kontak-agen').attr('hidden',false);
      $('.nama-kontak-vendor').attr('hidden',true);
      $('.nama-kontak-cash').attr('hidden',true);
      $('.nama-kontak-kosong').attr('hidden',true);
      $('.detail_biaya').removeClass('disabled');
      $('.modal_penerus_tt').removeClass('disabled');

     $.ajax({
      url:baseUrl + '/fakturpembelian/carimaster/'+vendor,
      type:'get',
      success:function(response){
        var persen = parseInt(response.persen[0].persen);
        id_persen  = response.persen[0].kode;
        $('.master_persen').val(persen);
      }

    })

     $.ajax({
      url:baseUrl + '/fakturpembelian/rubahVen',
      data:{vendor,cabang},
      type:'get',
      success:function(response){
       $('.agen_dropdown').html(response);
      }

    })


    
    }else if(vendor == 'VENDOR'){

      $('.nama-kontak-agen').attr('hidden',true);
      $('.nama-kontak-vendor').attr('hidden',false);
      $('.nama-kontak-cash').attr('hidden',true);
      $('.nama-kontak-kosong').attr('hidden',true);
      $('.modal_penerus_tt').removeClass('disabled');
      $('.detail_biaya').removeClass('disabled');

      $.ajax({
      url:baseUrl + '/fakturpembelian/carimaster/'+vendor,
      type:'get',
      success:function(response){
        var persen = parseInt(response.persen[0].persen);
        id_persen  = response.persen[0].kode;
        $('.master_persen').val(persen);
      }

    })

    $.ajax({
      url:baseUrl + '/fakturpembelian/rubahVen',
      data:{vendor,cabang},
      type:'get',
      success:function(response){
       $('.vendor_dropdown').html(response);
      }

    })

    }else{
      $('.nama-kontak-kosong').attr('hidden',false);
      $('.nama-kontak-agen').attr('hidden',true);
      $('.nama-kontak-vendor').attr('hidden',true);
      $('.nama-kontak-cash').attr('hidden',true);
      $('.detail_biaya').addClass('disabled');
      $('.modal_penerus_tt').addClass('disabled');
    }
   }

   function cariDATA(){
    // console.log('asd');
    $('.total_pod').val('');
    var pod = $('.no_pod').val();
    $( "#tages" ).autocomplete({
      source:baseUrl + '/fakturpembelian/caripod', 
      minLength: 3,
       change: function(event, ui) {
        if (ui.item) {
          if(ui.item.validator != null){
            toastr.warning('Data sudah didaftarkan');
            $(this).val("");
          }
        }
    }

    });

   }

   function seq(){

    var pod = $('.no_pod').val();
    var jumlahData = arrayPo.length + 1;
    $('.jml_data').val(jumlahData);


      $.ajax({
      url:baseUrl + '/fakturpembelian/auto/'+pod,
      type:'get',
      success:function(response){
        if(response.status == 1){
            var total = parseInt(response.data.tarif_dasar);
          $('.total_pod').val(accounting.formatMoney(total, "Rp ", 2, ".",','));

          $('.tgl_resi').val(response.data.tanggal);
        }else{
            $('.total_pod').val(0);
            $('.tgl_resi').val(0);

        }
      }
    })
    

    // console.clear();

   }


   function hitung(){

    var bayar = $('.nominal').val();
    var temp1=0;
    var total_tes=0;
    try{
        bayar = bayar.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }

    bayar1 = parseInt(bayar);

    $('.total_jml').val(total_tes);
    if(isNaN(temp[0])){
      total_tes=bayar1;
    }else{
      for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }

      try{
        temp1 = temp1.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }
      total_tes=temp1+bayar1 ;
    }
      
    if(bayar == ""){
      temp1 = temp1.toLocaleString();
      $('.total_jml').val('Rp '+temp1);
    }else{
      total_tes = total_tes.toLocaleString();
      $('.total_jml').val('Rp '+total_tes);
    }
  



   }

   function cariPOD(){
    var master= $('.master_persen').val();
    var valPo = $('.no_pod').val();
    var tgl   = $('.tgl-biaya').val();
    var cariIndex = arrayPo.indexOf(valPo);
    var count = arrayPo.length;
    var seq   = arrayPo.length + 1;
    var kode  = $('.kode_akun').val();
    var bayar = $('.nominal').val();
    var ket   = $('.ket-biaya').val();
    var debet = $('.debit').val();
    var harga_resi = $('.total_pod').val();

    harga_resi = harga_resi.replace(/[^0-9\-]+/g,"")
    harga_resi = harga_resi/100;
    console.log(harga_resi);

    try{
        bayar = bayar.replace(/[^0-9\.-]+/g,"");
      }catch(err){

      }
    if(cariIndex == -1 && valPo != "" && harga_resi != 0 && bayar != ''){
      if(count == 0){
        count = 1;
      }
      arrayPo.push(valPo);  
      datatable1.row.add( [
                '<input type="hidden" class="form-control tengah kecil seq seq_biaya_'+seq+'" name="seq_biaya[]" value="'+seq+'" readonly>'+'<div class="seq-app">'+seq+'</div>',
                '<input  type="hidden" class="form-control tengah kecil pod_biaya" name="pod_biaya[]" value="'+valPo+'" readonly>'+'<div class="val-app">'+valPo+'</div>',
                '<input type="hidden" class="form-control tengah tgl_biaya" name="tgl_biaya[]" value="'+tgl+'" readonly>'+'<div class="seq-app">'+tgl+'</div>',
                '<input type="hidden" class="form-control tengah kecil kode_biaya" name="kode_biaya[]" value="'+kode+'" readonly>'+'<div class="kode-app">'+kode+'</div>',
                '<div>'+accounting.formatMoney(harga_resi, "Rp ", 2, ".",',')+'</div>'+'<input type="hidden" class="form-control tengah bayar_biaya_resi" name="harga_resi[]" value="'+parseFloat(harga_resi).toFixed(2)+'" readonly>',
                '<input type="hidden" class="form-control tengah bayar_biaya" name="bayar_biaya[]" value="'+parseFloat(bayar).toFixed(2)+'" readonly>'+'<div class="bayar-app">'+accounting.formatMoney(bayar, "Rp ", 2, ".",',')+'</div>',
                '<input type="hidden" class="form-control tengah debet_biaya" name="debet_biaya[]" value="'+debet+'" readonly>'+'<div class="debet-app">'+debet+'</div>',
                '<input type="hidden" class="form-control tengah ket_biaya" name="ket_biaya[]" value="'+ket+'" readonly>'+'<div class="ket-app">'+ket+'</div>',
                '<a class="btn btn-success btn-xs fa fa-pencil" align="center" onclick="edit_biaya(this)" title="edit"></i></a>&nbsp;&nbsp;<a class="btn btn-danger btn-xs fa fa-minus" align="center" onclick="hapus_biaya(this)" title="hapus"></i></a>'
            ] ).draw( false );   
      $('.table-biaya').css('display','block');
      bayar = parseInt(bayar);
      temp.push(bayar); 
      // console.log(temp);

      $('.no_pod').val("");
      $('.nominal').val("");
      $('.total_pod').val('');
      $('.ket-biaya').val('');

      if (tabel_remove == 0) {
        $('.header_biaya').addClass('disabled');
      }else{
        $('.header_biaya').removeClass('disabled');
      }

    }else if(valPo == ""){
      toastr.warning("Nomor POD tidak boleh kosong");
    }else if(harga_resi == 0){
      toastr.warning("Nomor POD tidak ada");
    }else if(bayar == ''){
      toastr.warning("Nominal harus diisi");
    }else{
      toastr.warning("Data sudah ada");
    }

   }

   function setNo(){   
    var isi =  $('.nama_akun').val();
    $('.kode_akun').val(isi);
   }

  function hapus_biaya(o){
    var ini = o.parentNode.parentNode;
    var cari = $(ini).find('.pod_biaya').val();
    var byr = $(ini).find('.bayar_biaya').val();
    var byr = parseInt(byr);
    var temp1=0;
    var cariIndex = arrayPo.indexOf(cari);
    var cariIndex1 = temp.indexOf(byr);
    console.log(byr);
    console.log(cariIndex1);
    console.log(temp);
    arrayPo.splice(cariIndex,1);
    temp.splice(cariIndex1,1);
    
    for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }

      if(temp.length == 0){

       $('.total_jml').val('Rp '+0); 

      }else{
        temp1 = temp1.toLocaleString();
        $('.total_jml').val('Rp '+temp1);  
      }
      

    datatable1.row(ini).remove().draw(false);
    // console.log(tabel_remove);
    // if (tabel_remove == 0) {
    //     $('.header_biaya').removeClass('disabled');
    //   }else{
    //     $('.header_biaya').addClass('disabled');
    //   }
   }

   cariSeq=[];
   function edit_biaya(o){

    var ini = o.parentNode.parentNode;
    var pod = $(ini).find('.pod_biaya').val();
    var kode = $(ini).find('.kode_biaya').val();
    var bayar = $(ini).find('.bayar_biaya').val();
    var debet = $(ini).find('.debet_biaya').val();
    var ket = $(ini).find('.ket_biaya').val();
    cariSeq[0] = 'seq_biaya_'+$ (ini).find('.seq').val();
    $('#modal-biaya').modal('show');
    $(".kode_akun_update").val(kode);
    $(".nama_akun_update").val(kode).trigger("chosen:updated");
    $(".debit_update").val(debet);
    $(".ket_biaya_update").val(ket);
    $(".nominal_update").val(bayar);
    
      
    }

    
    function sve(){
      var kode = $(".kode_akun_update").val();
      var debit = $(".debit_update").val();
      var ket = $(".ket_biaya_update").val();
      var bayar = $(".nominal_update").val();
      var updt = $('.'+cariSeq[0]).parents('tr');
      var cariNom = $(updt).find('.bayar_biaya').val();
      cariNom = parseInt(cariNom);
      bayar   = parseInt(bayar);
      var cariIndex = temp.indexOf(cariNom)
      var temp1 = 0;
      console.log(cariNom); 
      temp[cariIndex]=bayar;

      for(var i = 0 ; i<temp.length;i++){
        temp1+=parseInt(temp[i]);
      }
      console.log(temp);
      if(temp.length == 0){
       $('.total_jml').val('Rp '+0); 
      }else{
        temp1 = temp1.toLocaleString();
       $('.total_jml').val('Rp '+temp1);  
      }
      
      $(updt).find('.kode_biaya').val(kode);
      $(updt).find('.debet_biaya').val(debit);
      $(updt).find('.ket_biaya').val(ket);
      $(updt).find('.bayar_biaya').val(parseFloat(bayar));
      $(updt).find('.kode-app').html(kode);
      $(updt).find('.debet-app').html(debit);
      $(updt).find('.ket-app').html(ket);
      $(updt).find('.bayar-app').html(parseFloat(bayar));

    }
    

   function updt(){
      var isi =  $('.nama_akun_update').val();
      $('.kode_akun_update').val(isi);
    }
   
   function save_biaya(){
      var cabang = $('.cabang').val();

    swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Biaya Penerus!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
      url:baseUrl + '/fakturpembelian/save_agen',
      type:'get',
      data:'id_persen='+id_persen+'&'+$('.head1 .nofaktur').serialize()+'&'+ $('.head-biaya :input').serialize()+'&'+ datatable1.$('input').serialize()+'&'+$('.head_atas').serialize()+'&'+'cab='+cabang,
      success:function(response){
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: true
                },function(){
                  // location.reload();
                   $(".tmbhdatapenerus").addClass('disabled');
                  $(".tmbhdatapenerus").css('background','grey');
                  $(".tmbhdatapenerus").css('color','black');

                  $(".tmbhdatapo").addClass('disabled');
                  $(".tmbhdatapo").css('background','none');
                  $(".tmbhdatapo").css('color','none');

                  $(".tmbhdataitem").addClass('disabled');
                  $(".tmbhdataitem").css('background','none');
                  $(".tmbhdataitem").css('color','none');

                  $(".tmbhdataoutlet").addClass('disabled');
                  $(".tmbhdataoutlet").css('background','none');
                  $(".tmbhdataoutlet").css('color','none');

                  $(".tmbhdatasubcon").addClass('disabled');
                  $(".tmbhdatasubcon").css('background','none');
                  $(".tmbhdatasubcon").css('color','none');

                  $('#save-update').addClass('disabled');
                  $('.cari-pod').addClass('disabled');
                

        });
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

    });
   }
  });  
 });
}

function  cari_outlet(){
   $('.loading').css('display', 'block');
 var agen = $('.selectOutlet').val();
      $.ajax({  
      url:baseUrl + '/fakturpembelian/cari_outlet/'+agen,
      type:'post',
      data:$('.head_outlet :input').serialize(),
      success:function(data){
         $('.loading').css('display', 'none');
        $('.table-outlet').html(data);
       $('.msh_hdn').attr('hidden',false);
      }

    })
}
///////////////////////////////////////////////
$('#tmbhdataitem').click(function(){
       cabang = $('.cabang').val();
       $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/fakturpembelian/getbiayalain',
          dataType : 'json',
          success : function (response){     
           /* $('.biayalain_po').empty();     
            for(var i = 0; i < response.biaya.length; i++){
               $('.biayalain_po').append("<option value='"+response.biaya[i].id_akun+"''>"+response.biaya[i].nama_akun+"</option>"); 
                 $('.biayalain_po').trigger("chosen:updated");
                 $('.biayalain_po').trigger("liszt:updated");
            }*/

            

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

              
                 nofaktur = 'FP' + month1 + year2 + '/' + cabang + '/' + 'I-' + response.idfaktur ;
                $('.aslinofaktur').val(nofaktur);
                $('.nofaktur').val(nofaktur);
          },
        })
     
    })

    $('#tmbhdatapo').click(function(){
     cabang = $('.cabang').val();
       $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/fakturpembelian/getbiayalain',
          dataType : 'json',
          success : function (response){     
           /* $('.biayalain_po').empty();     
            for(var i = 0; i < response.biaya.length; i++){
               $('.biayalain_po').append("<option value='"+response.biaya[i].id_akun+"''>"+response.biaya[i].nama_akun+"</option>"); 
                 $('.biayalain_po').trigger("chosen:updated");
                 $('.biayalain_po').trigger("liszt:updated");
            }*/

            

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

              
                 nofaktur = 'FP' + month1 + year2 + '/' + cabang + '/' + 'PO-' + response.idfaktur ;
                $('.aslinofaktur').val(nofaktur);
                $('.nofaktur').val(nofaktur);
                $('.no_faktur').val(nofaktur);
          },
        })
    })
  
 
    




</script>
@endsection
