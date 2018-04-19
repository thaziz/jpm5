@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css" media="screen">
  .disabled {
        pointer-events: none;
        opacity: 0.7;
        }
  .borderless td, .borderless th {
    border: none !important;
  }

   .table-hover tbody tr{
    cursor: pointer;
  }
  </style>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CN / DN Pembelian </h2>
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
                            <strong> Create CN / DN Pembelian </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
  <form class="form-horizontal" id="formsave" method="POST"> 
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                   <div class="text-right">
                        <a class="btn btn-sm btn-default" href="{{url('cndnpembelian/cndnpembelian')}}" aria-hidden="true"> <i class="fa fa-arrow-left" aria-hidden="true"> Kembali </i> </a>
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
                          <table border="0" class="table">
                          <input type="hidden" value="{{Auth::user()->m_name}}" name="username">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <tr>
                            <td> Cabang </td>
                            <td> 

                              @if(session::get('cabang') == 000)
                              <select class='form-control chosen-select-width cabang disabled'>
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" @if($cabang->kode == $data['cndn'][0]->cndn_comp) selected @endif>
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @else
                              <select class='form-control chosen-select-width cabang'>
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" 
                                   @if($cabang->kode == $data['cndn'][0]->cndn_comp) selected @endif>
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @endif

                              <input type="hidden" class="valcabang" name="cabang">
                            </td>
                          </tr>

                          <tr>
                            <td> Jenis : </td>
                            <td> <select class="form-control jeniscndn disabled" >
                            <option value="CN">
                                    CREDIT NOTA
                                </option>
                                <option value="DN">
                                    DEBIT NOTA
                                </option>
                                </select>
                            </td>

                            <input type="text" class="valjeniscndn" value="{{$data['cndn'][0]->cndn_jeniscndn}}" name="jeniscndn">
                          </tr>

                          </tr>


                          <tr>
                            <td> Nota </td>
                            <td> <input type='text' class="form-control input-sm notacndn" name="nota" readonly="" value="{{$data['cndn'][0]->cndn_nota}}">  </td>
                          </tr>

                          <tr>
                            <td> Jenis Faktur </td>
                            <td> <select class="form-control jenissup disabled" >
                                    <option value="2">
                                      Supplier Hutang Dagang
                                    </option>
                                    <option value="3">
                                      Voucher / Hutang Dagang
                                    </option>
                                    <option value="6">
                                    Biaya Penerus Agen / Vendor
                                    </option>
                                    <option value="7">
                                    Pembayaran Outlet
                                    </option>
                                    <option value="9">
                                    Vendor Subcon
                                    </option>
                                </select>
                            </td>

                            <input type="hidden" class="valjenissup" value="{{$data['cndn'][0]->cndn_jenissup}}" name="jenissup">
                          </tr>

                           <tr>
                            <td>
                              Supplier
                            </td>
                            <td>
                            
                              @if($data['cndn'][0]->cndn_jenissup == '2')

                                <select class="form-control chosen-select-width jenisbayar2 disabled" >
                                 @foreach($data['supplier'] as $supplier)
                                  <option value="{{$supplier->idsup}}" @if($data['cndn'][0]->cndn_supplier == $supplier->idsup) selected @endif> {{$supplier->no_supplier}} - {{$supplier->nama_supplier}} </option>
                                @endforeach
                                  </select>
                              <input type="hidden" class="supplier2" name="supplier" value="{{$data['cndn'][0]->cndn_supplier}}">
                              @elseif($data['cndn'][0]->cndn_jenissup == '6')
                              <select class="form-control chosen-select-width jenisbayar2 disabled" >
                                 @foreach($data['agen'] as $supplier)
                                  <option value="{{$supplier->kode}}" @if($data['cndn'][0]->cndn_agen == $supplier->kode) selected @endif> {{$supplier->kode}} - {{$supplier->nama}} </option>
                                @endforeach
                                  </select>
                               <input type="hidden" class="supplier2" name="supplier" value="{{$data['cndn'][0]->cndn_agen}}">   
                              @elseif($data['cndn'][0]->cndn_jenissup == '7')
                               <select class="form-control chosen-select-width jenisbayar2 disabled" >
                                 @foreach($data['outlet'] as $supplier)
                                  <option value="{{$supplier->kode}}" @if($data['cndn'][0]->cndn_agen == $supplier->kode) selected @endif> {{$supplier->kode}} - {{$supplier->nama}} </option>
                                @endforeach
                                  </select>
                                  <input type="hidden" class="supplier2" name="supplier" value="{{$data['cndn'][0]->cndn_agen}}">
                                @elseif($data['cndn'][0]->cndn_jenissup == '9')
                              <select class="form-control chosen-select-width jenisbayar2 disabled" >
                               @foreach($data['outlet'] as $supplier)
                                <option value="{{$supplier->kode}}" @if($data['cndn'][0]->cndn_agen == $supplier->kode) selected @endif> {{$supplier->kode}} - {{$supplier->nama}} </option>
                              @endforeach
                                </select>
                                <input type="hidden" class="supplier2" name="supplier" value="{{$data['cndn'][0]->cndn_agen}}">
                              @endif
                               
                            

                            
                            </td>
                          </tr>


                          <tr>
                            <td>   Tanggal </td>
                            <td>
                               <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl" value="{{ Carbon\Carbon::parse($data['cndn'][0]->cndn_tgl)->format('d-M-Y ') }}">
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td> Keterangan </td>
                            <td> <input type="text" class="form-control input-sm keterangan" name="keterangan" required="" value="{{$data['cndn'][0]->cndn_keterangan}}"> </td>
                          </tr>
                          </table>
                         </div>
                        
                        <div class="col-xs-6">
                           <table border="0" class ="table table-striped borderless table-hover">
                         <tr>
                          <td> <b> Jumlah Faktur </b> </td>
                          <td> <input type="text" class="form-control input-sm jumlahfaktur" readonly="" style='text-align: right' name="jumlahfaktur">  </td>
                         </tr>
                          <tr >
                            <td> <b> Bruto </b> </td>
                            <td>   <input type="text" class="form-control input-sm bruto" readonly="" style='text-align: right' name="bruto" required="" value="{{ number_format($data['cndn'][0]->cndn_bruto, 2) }}"> </td>
                            </td>
                          </tr>

                          <tr>
                            <td>
                             <b> Jumlah PPn </b>
                            </td>
                            <td style="text-align: right">
                              <input type="text" class="form-control input-sm hasilppnatas" style="text-align: right" name="jumlahppn" readonly="" value="{{ number_format($data['cndn'][0]->cndn_hasilppn, 2) }}">
                            </td>
                          </tr>

                        

                          <tr>
                            <td>  <b> Jumlah PPh </b> </td>
                            <td> <input type="text" class="form-control hasilpphatas" style="text-align: right" name="jumlahpph" readonly="" value="{{ number_format($data['cndn'][0]->cndn_hasilpph, 2) }}">  </td>
                          </tr>

                        
                            <tr>
                              <td> <b> Acc Hutang </b> </td>
                              <td> <input type="text" class="form-control input-sm acchutang" name="acchutang" readonly="" value="{{$data['cndn'][0]->cndn_acchutangdagang}}"> </td>
                            </tr>
                            <tr>
                              <td> <b> Acc CN / DN </b> </td>
                              <td>
                              <select class='form-control' name="accbiaya" value="{{$data['cndn'][0]->cndn_acccndn}}">
                                @foreach($data['akunbiaya'] as $akunbiaya)
                                <option value="{{$akunbiaya->acc_biaya}}">
                                  {{$akunbiaya->acc_biaya}} - {{$akunbiaya->nama}}
                                </option>
                                @endforeach
                              </select>
                              </td>
                            </tr>
                        
                          </table>
                        </div>                    
                      </div>
          
                       <br>
                        <div class="row"> 
                          <div class="col-sm-6">
                          
                         </div>
                        </div>
                        <br>


                        <div class="col-sm-12">
                             <button class="btn btn-sm btn-primary  createmodalfaktur" id="createmodal" data-toggle="modal" data-target="#myModal5" type="button"> <i class="fa fa-plus"> Tambah Data Faktur </i> </button>
                             <br>
                             <br>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4> Data Faktur </h4>
                                    <table class="table table-stripped" id="tbl-faktur">
                                        <tr>
                                            <td style="width:140px">  No Faktur  </td>
                                            <td> <input type="text" class="form-control input-sm nofakturheader clear" readonly=""> <input type="hidden" class="form-control input-sm idfakturheader clear" readonly=""> </td>
                                        </tr>

                                        <tr>
                                            <td> Jatuh Tempo  </td>
                                            <td> <input type="text" class="form-control input-sm jatuhtempheader clear" readonly=""> </td>
                                        </tr>

                                        <tr>
                                            <td>  DPP  </td>
                                            <td>  <input type="text" class="form-control input-sm dppheader clear" readonly="" style="text-align: right"></td>
                                        </tr>

                                        <tr>
                                            <td> Jenis PPN </td>
                                            <td>
                                                  <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppnheader clear disabled">
                                                      <option value="T">
                                                          Tanpa
                                                      </option>
                                                      <option value="I">
                                                          Input
                                                      </option>
                                                      <option value="E">
                                                          Exclude
                                                      </option>
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control input-sm inputppnheader clear" readonly=""> 
                                              </div>

                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilppnheader clear" readonly="" style="text-align: right"> 
                                              </div>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Jenis PPH
                                            </td>
                                            <td>
                                              <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppheader clear disabled" readonly="">
                                                     @foreach($data['pph'] as $pajak)
                                                       <option value="{{$pajak->kode}}">
                                                          {{$pajak->nama}}
                                                      </option>
                                                     
                                                     @endforeach
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                 <input type="text" class="form-control input-sm nilaipphheader clear" readonly=""> 
                                              </div>      
                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilpphheader clear" readonly="" style="text-align: right"> 
                                              </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td> Netto Hutang </td>
                                            <td> <input type="text" class="form-control input-sm nettoheader clear" readonly="" style="text-align: right"> </td>
                                        </tr>
                                        <tr>
                                            <td> Sisa Terbayar </td>
                                            <td> <input type="text" class="form-control input-sm sisaterbayarheader clear" readonly="" style="text-align: right"> </td>
                                        </tr>
                                        
                                    </table>
                                </div>

                                <div class="col-sm-6">
                                    <h4> Data CN / DN </h4>
                                    <table class="table">
                                       <tr>
                                          <td style="width:140px"> Nilai Bruto CN / DN </td>
                                          <td> <input type="text" class="form-control input-sm brutocn clear" style="text-align: right" ></td>
                                       </tr>

                                       <tr>
                                          <td> DPP </td>
                                          <td> <input type="text" class="form-control input-sm dppcn clear" style="text-align: right" readonly="">  </td>
                                       </tr>
                                         <tr>
                                            <td> Jenis PPN </td>
                                            <td>
                                                  <div class="col-xs-4">
                                                  <select class="form-control input-sm jenisppncn clear" readonly="">
                                                      <option value="T">
                                                          Tanpa
                                                      </option>
                                                      <option value="I">
                                                          Input
                                                      </option>
                                                      <option value="E">
                                                          Exclude
                                                      </option>
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                  <input type="text" class="form-control input-sm inputppncn clear" readonly=""> 
                                              </div>

                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilppncn clear" readonly="" style="text-align: right"> 
                                              </div>

                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                Jenis PPH
                                            </td>
                                            <td>
                                              <div class="col-xs-4">
                                                  <select class="form-control input-sm jenispphcn clear" readonly="">
                                                     @foreach($data['pph'] as $pajak)
                                                       <option value="{{$pajak->kode}}">
                                                          {{$pajak->nama}}
                                                      </option>
                                                     
                                                     @endforeach
                                                  </select>
                                                    </div>
                                              <div class="col-sm-3">
                                                 <input type="text" class="form-control input-sm inputpphcn clear" readonly=""> 
                                              </div>      
                                              <div class="col-sm-5">
                                                  <input type="text" class="form-control input-sm hasilpphcn clear" readonly="" style="text-align: right"> 
                                              </div>
                                            </td>
                                        </tr>

                                       <tr>
                                          <td> Netto </td>
                                          <td> <input type="text" class="form-control input-sm  nettohutangcn clear" style="text-align: right" readonly=""></td>
                                       </tr>

                                      <tr>
                                        <td> Total Sisa Hutang  </td>
                                        <td> <input type="text" class="form-control input-sm hasilakhir" readonly="" style="text-align: right"> </td>
                                      </tr>

                                    </table>
                                </div>

                               
                            </div>
                             <div class="pull-right">
                                  <button  class="btn btn-sm btn-default" type="button" id="append">
                                    <i class="fa fa-plus"> Append</i>
                                  </button>

                                    &nbsp; 
                                  <button style="margin-right: 10px" class="btn btn-sm btn-default" id="cancel" type="button">
                                    <i class="fa fa-close"> Cancel</i>
                                  </button>
                                </div>
                        </div>

                        <div class="row">
                         

                          <div class="col-sm-12">
                             

                            <h3> Data Faktur </h3>
                            <br>

                            <div class="table-responsive">
                              <table class="table table-bordered table-stripped table-borderless" id="table-faktur" >
                                <thead>
                                <tr>
                                  <th> No </th>
                                  <th style="width:150px"> No Faktur </th>
                                  <th style="width: 100px"> Jatuh Tempo </th>
                                  <th> Netto Hutang </th>
                                  <th> Sisa Hutang </th>
                               
                                  <th> Nilai PPn </th>
                                
                                  <th> Nilai PPh </th>
                                  <th> Netto CNDN </th>
                                  <th> Aksi </th>
                                </tr>
                                </thead>
                                <tbody>

                              @foreach($data['cndndt'] as $index=>$cndt)
                                <tr class="datafaktur data{{$index + 1}}" data-nofaktur="{{$cndt->fp_nofaktur}}">
                                  <td style='text-align:center'> {{$index + 1}}</td> 
                                  <td style='text-align:center'> 
                                 <!--  <button class="btn btn-success nofaktur2{{$cndt->fp_idfaktur}}" id="historypembayaran" data-toggle="modal" data-target="#historypembayaran" type="button"> {{$cndt->fp_nofaktur}} </button> -->

                                 <p class="nofaktur2{{$cndt->fp_idfaktur}}" id="historypembayaran" data-toggle="modal" data-target="#myModal6" type="button" onclick="pembayaran({{$cndt->fp_idfaktur}},{{$cndt->fp_jenisbayar}})"> {{$cndt->fp_nofaktur}} </p>

                                   <input type='hidden' class='form-control input-sm nofaktur' name='nofaktur[]' value='{{$cndt->fp_nofaktur}}' readonly="">
                                  <input type='hidden' class='form-control input-sm idcndt' name='idcndt[]' value='{{$cndt->cndt_id}}' readonly=""> <input type='hidden' class='form-control input-sm idcndn' name='idcndn' value='{{$cndt->cndn_id}}' readonly=""> </td> <!-- no faktur -->

                                  <td style='text-align:center'> {{ Carbon\Carbon::parse($cndt->fp_jatuhtempo)->format('d-M-Y ') }} <input type='hidden' class='form-control input-sm tglfaktur' name='tglfaktur[]' value=" {{ Carbon\Carbon::parse($cndt->fp_jatuhtempo)->format('d-M-Y ') }}"> </td> <!--tgl-->

                                  <td style='text-align:right'> <input type='hidden' class='form-control input-sm fpnetto' name='fpnetto[]' value="{{ number_format($cndt->fp_netto, 2) }} "> {{ number_format($cndt->fp_netto, 2) }} <input type='hidden' class='inputppnfp' value='{{$cndt->fp_inputppn}}' >  <input type='hidden' class='hasilppnfp' value='{{$cndt->fp_ppn}}' > <input type='hidden' class='inputpphfp' value='{{$cndt->fp_nilaipph}}' > <input type='hidden' class='hasilpphfp' value='{{$cndt->fp_pph}}' > <input type='hidden' class='jenisppnfp' value='{{$cndt->fp_jenispph}}'> <input type='hidden' class='jenispphfp' name='jenispphfp' value='{{$cndt->fp_jenispph}}'> </td> <!-- netto , ppn, pph-->

                                  <td style='text-align:right'> {{ number_format($cndt->fp_sisapelunasan, 2) }} <input type='hidden' class='sisahutang form-control input-sm' value="{{ number_format($cndt->fp_sisapelunasan, 2) }}" readonly style='text-align:right' name='sisahutang[]'> <input type='hidden' class='idfaktur form-control input-sm' value="{{$cndt->fp_idfaktur}}" readonly style='text-align:right' name='idfaktur[]'> <input type='hidden' class='dpp form-control input-sm' value="{{$cndt->fp_dpp}}" readonly style='text-align:right' name='dpp[]'> </td> <!-- sisapelunasan -->

                                  <td style='text-align:right'> <p class="ppn_text">{{ number_format($cndt->fp_ppn, 2) }} </p>
                                  <input type='hidden' class='nilaippn form-control input-sm' value="{{ number_format($cndt->cndt_hasilppn, 2) }}" readonly style="text-align:right" style="width:40%" name="nilaippn[]"> <input type='hidden' class=' form-control input-sm jenisppn' value="{{$cndt->cndt_jenisppn}}" readonly style="text-align:right" style="width:40%" name='jenisppn[]'> <input type='hidden' class=' form-control input-sm inputppn' value="{{$cndt->cndt_nilaippn}}" readonly style="text-align:right" style="width:40%" name="inputppn[]">  </td> <!--ppn -->

                                  <td style='text-align:right'>   <p class="pph_text"> {{ number_format($cndt->fp_pph, 2) }} </p> <input type='hidden' class='nilaipph form-control input-sm' value="{{ number_format($cndt->cndt_hasilpph, 2) }}" readonly style='text-align:right' name='nilaipph[]'> <input type='hidden' class='form-control input-sm inputpph' value="{{$cndt->cndt_nilaipph}}" readonly style='text-align:right' name='inputpph[]'> <input type='hidden' class=' form-control input-sm jenispph' value="{{$cndt->cndt_jenispph}}" readonly style='text-align:right' name='jenispph[]'></td>  <!--pph-->

                                  <td> <p class='cndn_text'>  {{ number_format($cndt->cndt_nettocn, 2) }} </p> <input type='hidden' class='form-control input-sm cndn' style='text-align:right' value="{{ number_format($cndt->cndt_nettocn, 2) }}" readonly name='nettocn[]'> <input type='hidden' class='brutocn2' value="{{ number_format($cndt->cndt_bruto, 2) }}" name='brutocn[]'> <input type='hidden' class='dppcn2' value="{{ number_format($cndt->cndt_dpp, 2) }}" name='dppcn[]'> <input class="hasilakhir2" type="text" value="{{ number_format($cndt->fp_sisapelunasan, 2) }}" name="hasilakhir[]">  </td> <!-- nettocdcn -->

                                  <td>  <a class='btn btn-xs btn-warning' onclick="edit(this)" data-id="{{$index + 1}}" type='button'><i class='fa fa-pencil'></i> </a> <a class='btn btn-xs btn-danger removes-btn' data-id="{{$index + 1}}" type='button'><i class='fa fa-trash'></i> </a>   </td>
                              </tr>
                              @endforeach
                              </tbody>
                              </table>
                            </div>
                            </div>

                      </div>
                   
                     <!-- Modal Pembayaran -->
                  <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true" style="min-width:200px">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title"> Data Pembayaran </h4>     
                                       </div>

                                <div class="modal-body">
                                 <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-3"> Data Pembayaran FPG </a></li>
                            <li class=""><a data-toggle="tab" href="#tab-4"> Data CN / DN </a></li>
                           
                        </ul>
                        <div class="tab-content">
                            <div id="tab-3" class="tab-pane active">
                                <div class="panel-body">
                                  

                                    <table class="table table-bordered table-striped table-datatable" id="table-pembayaran" >
                                        <thead>
                                        <tr>
                                          <th> Nomor Faktur </th>
                                          <th> Tanggal </th>
                                          <th> Jumlah Bayar </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <tr> 
                                          <td> </td>
                                          <td> </td>
                                          <td> </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                   
                                </div>
                            </div>
                            <div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    
                                    <table class="table table-bordered table-striped table-datatable" id="table-cndn">
                                        <thead>
                                        <tr>
                                          <th> Nomor CN / DN </th>
                                          <th> Tanggal </th>
                                          <th> Jumlah Bayar </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <tr> 
                                          <td> </td>
                                          <td> </td>
                                          <td> </td>
                                          </tr>
                                        </tbody>
                                    </table>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div>   <!-- End Modal -->
             
                  <!--  Modal  -->
                   <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title"> Data Faktur </h4>     
                                       </div>

                                <div class="modal-body">
                                  <table id="tblfaktur" class="table  table-bordered table-striped tbl-purchase">
                                       <thead>
                                         <tr>
                                          <th style="width:10px">No</th>
                                          <th style="width:120px"> No Faktur </th>
                                          <th style="width:120px"> Supplier </th>
                                           <th> Jatuh tempo </th>
                                          
                                          <th> Netto Hutang </th>
                                          <th> Sisa Hutang </th>
                                          <th style="width:50px"> Aksi </th>      
                                        </tr>
                                      </thead>                          
                                      <tbody>
                                       
                                      </tbody>
                                   </table>  
                                </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> 
                  <!-- End Modal -->
                  
                 

                  <div class="box-footer">
                  <div class="pull-right">


                     <button type='button' class="btn btn-sm btn-warning"> Batal </button>  <button type="submit" class='btn btn-sm btn-success simpanitem'> Simpan Data </button> 

                   </form>
                 
                    
                    
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
 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });

  tableDetail = $('.table-datatable').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

  jeniscndn = $('.valjeniscndn').val();
  if(jeniscndn == 'K'){
      $('.jeniscndn').val("CN");
  }
  else {
        $('.jeniscndn').val("DN");
  }

  jenissup = $('.valjenissup').val();
  $('.jenissup').val(jenissup);

 function pembayaran(id,jenisbayar){
 
      $.ajax({
          type : "POST",          
          data : {id,jenisbayar},
          url : baseUrl + '/cndnpembelian/pembayaran',
          dataType : 'json',
          success : function (response){
          var tablepembayaran = $('#table-pembayaran').DataTable();
          tablepembayaran.clear().draw();
           var tablecndn = $('#table-cndn').DataTable();
          tablecndn.clear().draw();
            var nmrpembayaran = 1;
          
          pembayaran = response.fpg
          cndn = response.cndn

               for(var i = 0; i < pembayaran.length; i++){      
                                   
               var html2 = "<tr> <td>"+pembayaran[i].nota+"</td>" +
                                "<td>"+ pembayaran[i].tgl +"</td>" +
                                "<td>"+ addCommas(pembayaran[i].pelunasan) +"</td>" +
                            "</tr>"
                        
                 tablepembayaran.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }  

               for(var j = 0 ; j < cndn.length; j++ ){
                 var html2 = "<tr> <td>"+cndn[i].cndn_nota+"</td>" +
                                "<td>"+ cndn[i].cndn_tgl +"</td>" +
                                "<td style='text-align:right'>"+ addCommas(cndn[i].cndt_nettocn) +"</td>" +
                            "</tr>"
                        
                 tablecndn.rows.add($(html2)).draw(); 
                nmrbnk++; 
               } 
            
          },
          error : function(){
          
          }
        })
 }

 function edit(a){
 // alert(a);
       var par          = $(a).parents('tr');
       var nomorfaktur      = $(par).find('.nofaktur').val();
       var jatuhtempo = $(par).find('.tglfaktur').val();
       var netto = $(par).find('.fpnetto').val();
       var sisahutang = $(par).find('.sisahutang').val();
       var dpp = $(par).find('.dpp').val();
       var nilaippn = $(par).find('.nilaippn').val();
       var jenisppn = $(par).find('.jenisppn').val();
       var inputppn = $(par).find('.inputppn').val();
       var nilaipph = $(par).find('.nilaipph').val();
       var jenispph = $(par).find('.jenispph').val();
       var inputpph = $(par).find('.inputpph').val();
       var nilaicndn = $(par).find('.cndn').val();
       var idcndt = $(par).find('.idcndtn').val();
       var idcndn = $(par).find('.idcndn').val();
       var idfaktur = $(par).find('.idfaktur').val();

               cndn = $('.cndn').val();

              sisaterbayars = sisahutang.replace(/,/g, '');
              cndns = cndn.replace(/,/g, '');

              hasilsisaterbyr = parseFloat(parseFloat(sisaterbayars) - parseFloat(cndns)).toFixed(2);

      // alert(jenispph);
           $('.nofakturheader').val(nomorfaktur);
            $('.jatuhtempheader').val(jatuhtempo);
            $('.dppheader').val(addCommas(dpp));
            $('.jenisppnheader').val(jenisppn);
            $('.inputppnheader').val(inputppn);
            $('.hasilppnheader').val(nilaippn);
            $('.jenisppheader').val(jenispph);
            $('.nilaipphheader').val(inputpph);
            $('.hasilpphheader').val(nilaipph);
            $('.nettoheader').val(addCommas(netto));
            $('.sisaterbayarheader').val(addCommas(hasilsisaterbyr));
           $('.idfakturheader').val(idfaktur);




           if(idcndt === undefined){
              bruto = $('.brutocn2').val();
              dpp = $('.dppcn2').val();
              cndn = $('.cndn').val();


             $('.brutocn').val(bruto);
              $('.dppcn').val(dpp);
             
              if(jenisppn != null){
                  $('.jenisppncn').val(jenisppn);
                  $('.inputppncn').val(inputppn);
                  $('.hasilpphcn').val(addCommas(nilaippn));
              }

               if(jenispph != null){
                  $('.jenispphcn').val(addCommas(jenispph));
                  $('.inputpphcn').val(addCommas(inputpph));
                  $('.hasilpphcn').val(addCommas(nilaipph));
              }
            
             
              $('.nettohutangcn').val(cndn);
           }
    }

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

        //data    
        $sisahutang = 0;
        $('.sisahutang').each(function(){
              val = $(this).val();

              aslihutang = val.replace(/,/g, '');
              $sisahutang = parseFloat(parseFloat($sisahutang) + parseFloat(aslihutang)).toFixed(2);
            })

        $('.jumlahfaktur').val(addCommas($sisahutang));


        $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    parentbayar = $('.data' + id);
                    parentbayar.remove();
                })


   $('#formsave').submit(function(event){
          trtbl = $('tr.datafaktur').length;
          if(trtbl == 0){
            toastr.info('Data yang di inputkan belum ada :)');
          }

        
         
          event.preventDefault();
          var post_url2 = baseUrl + '/cndnpembelian/update';
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data CN DN PEMBELIAN!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
               
        $.ajax({
          type : "POST",          
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
                   alertSuccess(); 
             $('.simpanitem').attr('disabled' , true);
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      
      })

  

  $('#cancel').click(function(){
    $('.clear').val('');
  })

  
  function caricndn(){
    nofaktur = $('.nofakturheader').val();
    idcndn = $('.idcndn').val();
    idcndt = $('.idcndt').val();
    idfaktur = $('.idfakturheader').val();
    $.ajax({
      url : baseUrl + '/cndnpembelian/caricndn',
      data : {nofaktur,idcndn,idcndt,idfaktur},
      type : "get",
      dataType : 'json',
      success : function(response){
          $('.brutocn').val(response.cndn[0].cndt_bruto);
          $('.dppcn').val(response.cndn[0].cndt_dpp);
          $('.dppcn').val(response.cndn[0].cndt_dpp);
          if(response.cndn[0].cndt_jenisppn != null){
              $('.jenisppncn').val(response.cndn[0].cndt_jenisppn);
              $('.inputppncn').val(response.cndn[0].cndt_nilaippn);
              $('.hasilpphcn').val(addCommas(response.cndn[0].cndt_hasilppn));
          }

           if(response.cndn[0].cndt_jenispph != null){
              $('.jenispphcn').val(addCommas(response.cndn[0].cndt_jenispph));
          $('.inputpphcn').val(addCommas(response.cndn[0].cndt_nilaipph));
          $('.hasilpphcn').val(addCommas(response.cndn[0].cndt_hasilpph));
          }
        
         
          $('.nettohutangcn').val(addCommas(response.cndn[0].cndt_nettocn));

      }
    })
  }

   $('.brutocn').change(function(){
              val = $(this).val();
              val = accounting.formatMoney(val, "", 2, ",",'.');
              $(this).val(val);
              $('.dppcn').val(val);
              
              sisahutang = $('.sisaterbayarheader').val();
              sisahutang2 = sisahutang.replace(/,/g,'');
              val2 = val.replace(/,/g,'');
             
              if(parseFloat(val2) > parseFloat(sisahutang2)){
                toastr.info('Tidak bisa menginputkan nilai lebih dari sisa faktur :)');
                return false;
                $(this).val('');
                $('.dppcn').val('');
                $('.nettohutangcn').val('');
              }
              //PPN


               //PPN
              inputppn = $('.inputppncn').val();
              jenisppn = $('.jenisppncn').val();
              ppn = $('.hasilppncn').val(); 
           
              numeric2 = val.replace(/,/g,'');

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppncn').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppncn').val(); 
              }

              pph = $('.hasilpphcn').val();

              if(pph != 0) {
                inputpph = $('.inputpphcn').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpphcn').val(addCommas(hasilpph2));
                 pph = $('.hasilpphcn').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppncn').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutangcn').val(addCommas(hsl));
                    $('.dppcn').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dppcn').val(addCommas(hargadpp));
                      subtotal = $('.dppcn').val();
                      subtotal = $('.dppcn').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppncn').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutangcn').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                      $('.dppcn').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutangcn').val(hasil);
                      $('.dppcn').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppncn').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                       $('.dppcn').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dppcn').val(addCommas(hargadpp));
                      subtotal = $('.dppcn').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppncn').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutangcn').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                      $('.dppcn').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppncn').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dppcn').val(addCommas(hargadpp));
                          subtotal = $('.dppcn').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppncn').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutangcn').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppncn').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                        $('.dppcn').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dppcn').val(addCommas(hargadpp));
                          subtotal = $('.dppcn').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppncn').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutangcn').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutangcn').val(addCommas(numeric2));
                    $('.dppcn').val(addCommas(numeric2));
                }

                jeniscn = $('.jeniscndn').val();
                if(jeniscn == 'CN'){
                   nettohutangcn2 = $('.nettohutangcn').val();
                    nettohutangcn = nettohutangcn2.replace(/,/g, '');
                    sisaterbayar2 = $('.sisaterbayarheader').val();
                    sisaterbayar = sisaterbayar2.replace(/,/g, '');
                    $hasil = parseFloat(parseFloat(nettohutangcn) + parseFloat(sisaterbayar)).toFixed(2);
                    $('.hasilakhir').val(addCommas($hasil));
                }
                else {
                    nettohutangcn2 = $('.nettohutangcn').val();
                    nettohutangcn = nettohutangcn2.replace(/,/g, '');
                    sisaterbayar2 = $('.sisaterbayarheader').val();
                    sisaterbayar = sisaterbayar2.replace(/,/g, '');
                    $hasil = parseFloat(parseFloat(sisaterbayar) - parseFloat(nettohutangcn)).toFixed(2);
                    $('.hasilakhir').val(addCommas($hasil));
                }
               

            })
  

  trlenght = $('.datafaktur').length;
  var noappend = trlenght + 1;
  $('#append').click(function(){
 
      nettocn = $('.nettohutangcn').val();
      nofaktur = $('.nofakturheader').val();
     

      if(nettocn == '' || nettocn == 0.00){
        toastr.info('Netto Hutang tidak boleh 0.00 atau kosong :)');
        return false;
      }

      if(nofaktur == ''){
        toastr.info('No faktur tidak ada :)');
        return false;
      }

     
     $('.jenisbayar2').addClass('disabled');
     $('.jenissup').addClass('disabled');
     $('.jeniscndn').addClass('disabled');
     $('.cabang').addClass('disabled');
    $('.cabang').prop('disabled', true).trigger("liszt:updated");
    $('.cabang').prop('disabled', true).trigger("chosen:updated");

    $('.jenisbayar2').prop('disabled', true).trigger("liszt:updated");
    $('.jenisbayar2').prop('disabled', true).trigger("chosen:updated");

    idfaktur = $('.idfakturheader').val();
     nofaktur = $('.nofakturheader').val();
    jatuhtempo = $('.jatuhtempheader').val();
    nettohutang = $('.nettoheader').val();
    sisahutang   =  $('.sisaterbayarheader').val();
    nettocn = $('.nettohutangcn').val();     
    dppheader = $('.dppheader').val();



    nilaipph = $('.hasilpphcn').val();
    jenispph = $('.jenispphcn').val();
    inputpph = $('.inputpphcn').val();

    nilaippn = $('.hasilppncn').val();
    jenisppn = $('.jenisppncn').val();
    inputppn = $('.inputppncn').val();

    nilaicndn = $('.nettohutangcn').val();
    brutocn = $('.brutocn').val();
    dppcn = $('.dppcn').val();
   
    jenisppnfp = $('.jenisppnfp').val();
    jeispphfp = $('.jenispphfp').val();
    
    inputppnfp = $('.inputppnfp').val();
    hasilppnfp = $('.hasilppnfp').val();

    inputpphfp = $('.inputpphfp').val();
    hasilpphfp = $('.hasilpphfp').val();

    hasilakhir = $('.hasilakhir').val();

     if(nilaippn == ''){
      nilaippn = 0.00;
     }
     if(nilaipph == ''){
      nilaipph = 0.00;
     }


     arrnofaktur = [];
      $('.datafaktur').each(function(){
        valfaktur = $(this).data('nofaktur');
        arrnofaktur.push(valfaktur);
      
     
      })

      index = arrnofaktur.indexOf(nofaktur);
      if(index == -1) {
         var row = '<tr class="datafaktur data'+noappend+'" data-nofaktur="'+nofaktur+'">' +
                    '<td style="text-align:center">'+noappend+'</td>' +
                    '<td style="text-align:center"> <p class="nofaktur2'+idfaktur+'">'+nofaktur+'</p>' +
                    '<input type="hidden" class="form-control input-sm nofaktur" name="nofaktur[]" value='+nofaktur+' readonly="">' + //nofaktur
                     
                     '<td style="text-align:center"> '+jatuhtempo+' <input type="hidden" class="form-control input-sm tglfaktur" name="tglfaktur[]" value='+jatuhtempo+'> </td>' + //tgl

                      '<td style="text-align:right"> <input type="hidden" class="form-control input-sm fpnetto" name="fpnetto[]" value="'+nettohutang+'">"'+nettohutang+'"</td>' + // netto

                      '<td style="text-align:right">"'+sisahutang+'" <input type="hidden" class="sisahutang form-control input-sm" value="'+sisahutang+'" readonly style="text-align:right" name="sisahutang[]"> <input type="hidden" class="idfaktur form-control input-sm" value='+idfaktur+' readonly style="text-align:right" name="idfaktur[]"> <input type="hidden" class="dpp form-control input-sm" value="'+dppheader+'" readonly style="text-align:right" name="dpp[]"> </td>' + // sisapelunasan

                        '<td style="text-align:right"> <p class="ppn_text"> '+addCommas(nilaippn)+' </p>' +
                        '<input type="hidden" class="nilaippn form-control input-sm" value="'+nilaippn+'" readonly style="text-align:right" style="width:40%" name="nilaippn[]"> <input type="hidden" class="form-control input-sm jenisppn" value="'+jenisppn+'" readonly style="text-align:right" style="width:40%" name="jenisppn[]"> <input type="hidden" class=" form-control input-sm inputppn" value="'+inputppn+'" readonly style="text-align:right" style="width:40%" name="inputppn[]">  <input type="hidden" class="form-control input-sm dppcn2" value="'+dppcn+'" readonly style="text-align:right;style="width:40%"" name="dppcn[]">  <input type="hidden" class="form-control input-sm brutocn2" value="'+brutocn+'" readonly style="text-align:right;style="width:40%"" name="brutocn[]"> </td>' + //ppn

                           '<td style="text-align:right">   <p class="pph_text"> '+addCommas(nilaipph)+' </p> <input type="hidden" class="nilaipph form-control input-sm" value="'+nilaipph+'" readonly style="text-align:right" name="nilaipph[]"> <input type="hidden" class="form-control input-sm inputpph" value="'+inputpph+'" readonly style="text-align:right" name="inputpph[]"> <input type="hidden" class="form-control input-sm jenispph" value="'+jenispph+'" readonly style="text-align:right" name="jenispph"></td>' + //pph

                                 ' <td> <p class="cndn_text">  '+nilaicndn+' </p> <input type="hidden" class="form-control input-sm cndn" style="text-align:right" value="'+nilaicndn+'" readonly name="nettocn[]"> <input type="text" class="form-control hasilakhir2" name="hasilakhir[]" value='+hasilakhir+'> </td>' + // <!-- nettocdcn -->

                                ' <td>  <a class="btn btn-xs btn-warning" onclick="edit(this)" data-id='+noappend+' type="button"><i class="fa fa-pencil"></i> </a> <a class="btn btn-xs btn-danger removes-btn" data-id='+noappend+' type="button"><i class="fa fa-trash"></i> </a>   </td>' +
                              '</tr>';
        
              $('#table-faktur').append(row);

         noappend++;

            $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    parentbayar = $('.data' + id);
                    parentbayar.remove();
                })

    $('.clear').val(''); 

      $('.nilaipph').each(function(){
         val = $(this).val(); 
         if(val == ''){

         }
         else {
            nilaipph = val.replace(/,/g, '');   
          $nilaipph = parseFloat(parseFloat($nilaipph) + parseFloat(nilaipph)).toFixed(2);
         }
         $('.hasilpphatas').val(addCommas($nilaipph));
      })

      $('.nilaippn').each(function(){
        val = $(this).val(); 
         if(val == ''){

         }
         else {
          nilaippn = val.replace(/,/g, '');   
          $nilaippn = parseFloat(parseFloat($nilaippn) + parseFloat(nilaippn)).toFixed(2);
         }
         $('.hasilppnatas').val(addCommas($nilaippn));
      })

      $('.cndn').each(function(){
        val = $(this).val(); 

        if(val == ''){

        }
        else {
          nilaicn = val.replace(/,/g, '');   
             
         $nilaicndn = parseFloat(parseFloat($nilaicndn) + parseFloat(nilaicn)).toFixed(2);
      
         }
      })
      $('.bruto').val(addCommas($nilaicndn));
     
       $('.sisahutang').each(function(){
              val = $(this).val();
              aslihutang = val.replace(/,/g, '');
             // alert(aslihutang);
             // alert($sisahutang);

              $sisahutang = parseFloat(parseFloat($sisahutang) + parseFloat(aslihutang)).toFixed(2);
            })

            $('.jumlahfaktur').val(addCommas($sisahutang));
      }
      else {
       // alert('else');
         nilaipph = $('.hasilpphcn').val();
        jenispph = $('.jenispphcn').val();
        inputpph = $('.inputpphcn').val();

        nilaippn = $('.hasilppncn').val();
        jenisppn = $('.jenisppncn').val();
        inputppn = $('.inputppncn').val();

        hasilakhir = $('.hasilakhir').val();


         var a                = $('.nofaktur2'+idfaktur);
         var par              = $(a).parents('tr');
         var nomorfaktur      = $(par).find('.nofakturheader').val();
         var jatuhtempo       = $(par).find('.tglfaktur').val();
         var netto            = $(par).find('.fpnetto').val();
         var sisahutang2      = $(par).find('.sisahutang').val();
         var dpp              = $(par).find('.dpp').val();
         $(par).find('.nilaippn').val();
         $(par).find('.jenisppn').val(jenisppn);
         $(par).find('.inputppn').val(inputppn);
         $(par).find('.nilaipph').val(nilaippn);

         $(par).find('.jenispph').val(jenispph);
         $(par).find('.inputpph').val(inputpph);
         $(par).find('.nilaipph').val(nilaipph);

         $(par).find('.cndn').val(nettocn);

         $('.hasilakhir2').val(hasilakhir);
      
         if(nilaippn == ''){
          nilaippn = 0.00;
         }
         if(nilaipph == ''){
          nilaipph = 0.00;
         }
          

          $(par).find('.ppn_text').text(addCommas(nilaippn));
          $(par).find('.pph_text').text(addCommas(nilaipph));
           
          $(par).find('.cndn_text').text(addCommas(nettocn));
          $('.clear').val(''); 


          $('.clear').val(''); 

          $nilaipph = 0;
      $('.nilaipph').each(function(){
         val = $(this).val(); 
         if(val == ''){

         }
         else {
            nilaipph = val.replace(/,/g, '');   
          $nilaipph = parseFloat(parseFloat($nilaipph) + parseFloat(nilaipph)).toFixed(2);
         }
         $('.hasilpphatas').val(addCommas($nilaipph));
      })

      $nilaippn = 0;
      $('.nilaippn').each(function(){
        val = $(this).val(); 
         if(val == ''){

         }
         else {
          nilaippn = val.replace(/,/g, '');   
          $nilaippn = parseFloat(parseFloat($nilaippn) + parseFloat(nilaippn)).toFixed(2);
         }
         $('.hasilppnatas').val(addCommas($nilaippn));
      })

      $nilaicndn = 0;
      $('.cndn').each(function(){
        val = $(this).val(); 

        if(val == ''){

        }
        else {
          nilaicn = val.replace(/,/g, '');   
             
         $nilaicndn = parseFloat(parseFloat($nilaicndn) + parseFloat(nilaicn)).toFixed(2);
      
         }
      })
      $('.bruto').val(addCommas($nilaicndn));
     
      $sisahutang = 0;
      $('.sisahutang').each(function(){
              val = $(this).val();
              aslihutang = val.replace(/,/g, '');
             // alert(aslihutang);
             // alert($sisahutang);

              $sisahutang = parseFloat(parseFloat($sisahutang) + parseFloat(aslihutang)).toFixed(2);
            })

            $('.jumlahfaktur').val(addCommas($sisahutang));
      }

  })

jenisbayar2 = $('.jenisbayar2').val();
//alert(jenisbayar2);
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
      $('.cabang').chosen(config2);
      $('.jenisbayar2').chosen(config2);

    })

       $('.cabang').change(function(){
       val = $('.jeniscndn').val();
        comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/cndnpembelian/getnota',
            dataType:'json',
            success : function(data){
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

                  if(val == 'CN') {
                    nospp = 'CN' + month + year2 + '/' + comp + '/' +  data.idcndn;
                  }
                  else {
                    nospp = 'DN' + month + year2 + '/' + comp + '/' + data.idcndn
                  }
            
                $('.notacndn').val(nospp);
                 nospp = $('.notacndn').val();
               
            },
            error : function(){
              location.reload();
            }
        })
    })

     $('.jenissup').change(function(){
      idjenis = $('.jenissup').val();
       $.ajax({
        type : 'GET',
        data : {idjenis},
        url : baseUrl + '/cndnpembelian/getsupplier',      
        dataType : 'json',
        success : function(response){
            var response = response['isi'];
           
           if(idjenis == '2' ){  
                      $('.jenisbayar2').empty();   
                          $('.jenisbayar2').append("<option value='' selected> Pilih Supplier </option>");                
                      for(var j=0; j<response.length; j++){  
                                    
                         $('.jenisbayar2').append("<option value="+response[j].idsup+">"+response[j].no_supplier+" - "+response[j].nama_supplier+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      }                     
                    }   
                    else if(idjenis == '6'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Agen  </option>");  
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      } 
                    }
                    else if(idjenis == '7'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Outlet  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }
                    else if(idjenis == '9'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Vendor  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }

                   
             }      
      })
     })

    $('.date').datepicker({
        autoclose: true,
         format: 'dd-MM-yyyy',
    }).datepicker("setDate", "0");



    $('#createmodal').click(function(){
      idsup = $('.jenisbayar2').val();
      jenis = $('.jenissup').val();
      cabang = $('.cabang').val();
      
       arrnofaktur = [];
      $('.datafaktur').each(function(){
        valfaktur = $(this).data('nofaktur');
        arrnofaktur.push(valfaktur);
      
      })

    

      $.ajax({
        type : 'GET',
        data : {idsup,jenis,cabang,arrnofaktur},
        url : baseUrl + '/cndnpembelian/getfaktur',      
        dataType : 'json',
        success : function(response){

            var tablecek = $('#tblfaktur').DataTable();
          tablecek.clear().draw();
            var nmrbnk = 1;
            table = response.fakturpembelian;

            if(idsup == 2){
               for(var i = 0; i < table.length; i++){      
                                   
               var html2 = "<tr id="+table[i].fp_nofaktur+" data-faktur='"+table[i].fp_nofaktur+"'>" +
                          "<td>"+nmrbnk+"</td>" +
                          "<td>"+table[i].fp_nofaktur+"</td>" + // no faktur
                          "<td>"+table[i].nama_supplier+"</td>" +
                          "<td>"+table[i].fp_jatuhtempo+"</td>" +
                       
                          "<td style='text-align:right'>Rp "+addCommas(table[i].fp_netto)+"</td>" +
                          "<td  style='text-align:right'>Rp " +addCommas(table[i].fp_sisapelunasan)+"</td>" +
                         "<td>" +
                           "<div class='checkbox'> <input type='checkbox' id="+table[i].fp_idfaktur+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>" +
                         "</tr>";
                        
                 tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }   
            }
            else {
              for(var i = 0; i < table.length; i++){  
                  var html2 = "<tr>" +
                          "<td>"+nmrbnk+"</td>" +
                          "<td>"+table[i].fp_nofaktur+"</td>" + // no faktur
                          "<td>"+table[i].nama+"</td>" +
                          "<td>"+table[i].fp_jatuhtempo+"</td>" +
                          "<td style='text-align:right'>Rp "+addCommas(table[i].fp_netto)+"</td>" +
                          "<td  style='text-align:right'>Rp " +addCommas(table[i].fp_sisapelunasan)+"</td>" +
                         "<td>" +
                           "<div class='checkbox'> <input type='checkbox' id="+table[i].fp_idfaktur+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>" +
                         "</tr>";

                tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
              }
               } 
            }
           
        })
      
    })

    $('.jenisbayar2').change(function(){
       jenisbayar = $('.jenisbayar2').val();
       $('.supplier2').val(jenisbayar);
    })

     $nomor = 0;
    
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
        $sisahutang = 0;
         arrval = []; 
        $nilaicndn = 0;
        $nilaippn = 0;
        $nilaipph = 0;
       

           arrnofaktur = [];
          $('.datafaktur').each(function(){
            valfaktur = $(this).data('nofaktur');
            arrnofaktur.push(valfaktur);
            console.log(arrnofaktur + 'arrnofaktur');
          })



        
        url = baseUrl + '/cndnpembelian/hslfaktur'; 

        if(checked.length > 1){
          toastr.info('Hanya Bisa Pilih Satu Data Faktur :) ');
          return false;
        }
        else {


         $.ajax({    
          type :"get",
          data : {checked},
          url : url,
          dataType:'json',
          success : function(response){
            $('#myModal5').modal('toggle');
            faktur = response.faktur

            $('.nofakturheader').val(faktur[0][0].fp_nofaktur);
            $('.jatuhtempheader').val(faktur[0][0].fp_jatuhtempo);
            $('.dppheader').val(addCommas(faktur[0][0].fp_dpp));
            $('.jenisppnheader').val(faktur[0][0].fp_jenisppn);
            $('.inputppnheader').val(faktur[0][0].fp_inputppn);
            $('.hasilppnheader').val(faktur[0][0].fp_ppn);
            $('.jenisppheader').val(faktur[0][0].fp_jenispph);
            $('.nilaipphheader').val(faktur[0][0].fp_nilaipph);
            $('.hasilpphheader').val(faktur[0][0].fp_pph);
            $('.nettoheader').val(addCommas(faktur[0][0].fp_netto));
            $('.sisaterbayarheader').val(addCommas(faktur[0][0].fp_sisapelunasan));

            $('.idfakturheader').val(faktur[0][0].fp_idfaktur);

            $('.acchutang').val(faktur[0][0].fp_acchutang);
             $('.jenisppncn').val(faktur[0][0].fp_jenisppn);
            $('.inputppncn').val(faktur[0][0].fp_inputppn);
            $('.hasilppnhcn').val(faktur[0][0].fp_ppn);
            $('.jenisppcn').val(faktur[0][0].fp_jenispph);
            $('.inputpphcn').val(faktur[0][0].fp_nilaipph);
            $('.hasilpphcn').val(faktur[0][0].fp_pph);

          
            $('.accpph').val(faktur[0][0].fp_accpph);
        

           $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    parentbayar = $('.data' + id);
                    parentbayar.remove();
                })


         
            
            $('.brutocn').change(function(){
              val = $(this).val();
              val = accounting.formatMoney(val, "", 2, ",",'.');
              $(this).val(val);
              $('.dppcn').val(val);
              
              sisahutang = $('.sisaterbayarheader').val();
              sisahutang2 = sisahutang.replace(/,/g,'');
              val2 = val.replace(/,/g,'');
             
              if(parseFloat(val2) > parseFloat(sisahutang2)){
                toastr.info('Tidak bisa menginputkan nilai lebih dari sisa faktur :)');
                return false;
                $(this).val('');
                $('.dppcn').val('');
                $('.nettohutangcn').val('');
              }
              //PPN


               //PPN
              inputppn = $('.inputppncn').val();
              jenisppn = $('.jenisppncn').val();
              ppn = $('.hasilppncn').val(); 
           
              numeric2 = val.replace(/,/g,'');

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppncn').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppncn').val(); 
              }

              pph = $('.hasilpphcn').val();

              if(pph != 0) {
                inputpph = $('.inputpphcn').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpphcn').val(addCommas(hasilpph2));
                 pph = $('.hasilpphcn').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppncn').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutangcn').val(addCommas(hsl));
                    $('.dppcn').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dppcn').val(addCommas(hargadpp));
                      subtotal = $('.dppcn').val();
                      subtotal = $('.dppcn').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppncn').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutangcn').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                      $('.dppcn').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutangcn').val(hasil);
                      $('.dppcn').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppncn').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                       $('.dppcn').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dppcn').val(addCommas(hargadpp));
                      subtotal = $('.dppcn').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppncn').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutangcn').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                      $('.dppcn').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppncn').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dppcn').val(addCommas(hargadpp));
                          subtotal = $('.dppcn').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppncn').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutangcn').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppncn').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutangcn').val(addCommas(hsl));
                        $('.dppcn').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dppcn').val(addCommas(hargadpp));
                          subtotal = $('.dppcn').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppncn').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutangcn').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutangcn').val(addCommas(hsl));
                          $('.dppcn').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutangcn').val(addCommas(numeric2));
                    $('.dppcn').val(addCommas(numeric2));
                }

                jeniscn = $('.jeniscndn').val();
                if(jeniscn == 'CN'){
                   nettohutangcn2 = $('.nettohutangcn').val();
                    nettohutangcn = nettohutangcn2.replace(/,/g, '');
                    sisaterbayar2 = $('.sisaterbayarheader').val();
                    sisaterbayar = sisaterbayar2.replace(/,/g, '');
                    $hasil = parseFloat(parseFloat(nettohutangcn) + parseFloat(sisaterbayar)).toFixed(2);
                    $('.hasilakhir').val(addCommas($hasil));
                }
                else {
                    nettohutangcn2 = $('.nettohutangcn').val();
                    nettohutangcn = nettohutangcn2.replace(/,/g, '');
                    sisaterbayar2 = $('.sisaterbayarheader').val();
                    sisaterbayar = sisaterbayar2.replace(/,/g, '');
                    $hasil = parseFloat(parseFloat(sisaterbayar) - parseFloat(nettohutangcn)).toFixed(2);
                    $('.hasilakhir').val(addCommas($hasil));
                }

            })

          }
        })
       }
    })

   
     
      


    $('.jeniscndn').change(function(){
      
        comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/cndnpembelian/getnota',
            dataType:'json',
            success : function(data){
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

                  if(val == 'CN') {
                    nospp = 'CN' + month + year2 + '/' + comp + '/' +  data.idcndn;
                  }
                  else {
                    nospp = 'DN' + month + year2 + '/' + comp + '/' + data.idcndn
                  }
            
                $('.notacndn').val(nospp);
                 nospp = $('.notacndn').val();
               
            },
            error : function(){
              location.reload();
            }
        })
    
    })

     
</script>
@endsection
