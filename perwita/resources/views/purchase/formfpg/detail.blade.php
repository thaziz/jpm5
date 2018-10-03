@extends('main')

@section('title', 'dashboard')

@section('content')

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
                          <a> Transaksi Purchase </a>
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

          <form method="post" action="{{url('formfpg/updateformfpg')}}"  enctype="multipart/form-data" class="form-horizontal" id="formfpg">
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
                              @foreach($data['fpg'] as $fpg)
                              <tr>
                                  <th> Cabang </th>
                                  <td>
                                  <input type='text' class='input-sm form-control ' value="{{$fpg->namacabang}}" readonly="" name="cabang">
                                  <input type='hidden' class='cabang' value="{{$fpg->kode}}">
                                  </td>
                              </tr>

                              <tr>
                                <th> No FPG </th>
                                <td> <input type='text' class='input-sm form-control nofpg' value="{{$fpg->fpg_nofpg}}" readonly="" name="nofpg">     <input type="hidden" name="_token" value="{{ csrf_token() }}"> <input type='hidden' class='input-sm form-control nofpg' value="{{$fpg->idfpg}}" readonly="" name="idfpg"> </td>
                              </tr>
                              <tr>
                                <th> Tanggal </th>
                                <td>  
                                      <div class="input-group">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tglfpg" required="" value="{{ Carbon\Carbon::parse($fpg->fpg_tgl)->format('d-M-Y ') }}" disabled=""> <input type="hidden"  name="tglfpg" required="" value="{{$fpg->fpg_tgl}}">
                                      </div>
                               </td>
                              </tr>
                              <tr>
                                <th>
                                  Jenis Bayar
                                </th>
                                <td>
                                  <h4> {{$fpg->jenisbayar}} <input type="hidden" value="{{$fpg->fpg_jenisbayar}}" name="jenisbayar" class="jenisbayar"></h4>
                                </td>
                                 <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
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
                            <td> <input type='text' class="input-sm form-control" readonly="" name="hutangdagang" value="{{$fpg->fpg_acchutang}}"> </td>
                          </tr>

                          <tr>
                            <td> <h4> Hutang Cek / BG (K) </h4> </td>
                            <td> <input type='text' readonly="" name="hutangcekbg" class='hutang input-sm form-control' value="{{$fpg->fpg_kodebank}}"> </td>
                          </tr>

                          <tr>
                            <td> <h4> Uang Muka </h4> </td>
                            <td> <input type="text" readonly="" name="uangmuka" class="input-sm form-control" value="{{$fpg->fpg_accum}}"> </td>
                          </tr>
                          </table>
                        </div>                    
                      </div>

                      <div class="row">
                       <div class='col-xs-6 '>
                          <table class='table table-bordered table-striped tbl-jenisbayar' style="width:100%">
                            <tr>
                              <th> Kode  </th>
                              <td> <h4>
                              @if($data['jenisbayar'] != '5')
                                 @if($data['jenisbayar'] == '2')
                                  {{$fpg->nama_supplier}}
                                @elseif($data['jenisbayar'] == '4')
                                    @if($data['jenissup'] == 'agen' || $data['jenissup'] == 'subcon')
                                    {{$fpg->nama}}
                                    @elseif($data['jenissup'] == 'supplier')
                                    {{$fpg->nama_supplier}}

                                    @endif
                                @else
                                    {{$fpg->kodesupplier}} - {{$fpg->namasupplier}}                                
                                @endif
                           
                             
                              @endif
                               
                                @if($data['jenisbayar'] == '2')
                                <input type="hidden" value="{{$fpg->syarat_kredit}}"  class="syaratkreditsupplier">
                                <input type="hidden" value="{{$fpg->fpg_supplier}}" name='kodejenisbayar' class="kodejenisbayar">
                                @else
                                <input type="hidden" value="{{$fpg->fpg_agen}}" name='kodejenisbayar' class="kodejenisbayar">
                                @endif
                                 </h4> </td>
                            </tr>

                            <tr>
                              <th> Keterangan </th>
                              <td> <input type='text' class='form-control' name="keterangan" value="{{$fpg->fpg_keterangan}}"></td>
                            </tr>
                          </table>

                          <div class="deskirpsijenisbayar"> </div>

                          <button class="btn btn-xs btn-warning" type="button" id="editdata"> <i class="fa fa-pencil"> &nbsp; </i> Edit Data ? </button>

                        </div>


                        <div class="col-xs-6 pull-right">
                          <table class="table table-bordered table-striped">
                            <tr>
                              <th> Tot. Bayar </th>
                              <td> <input type="text" class="input-sm form-control totbayar" readonly="" style="text-align: right" name="totalbayar" value="{{ number_format($fpg->fpg_totalbayar, 2) }}"> </td>
                            </tr>
                            <tr>
                              <th> Uang Muka </th>
                              <td> <input type="text" class="input-sm form-control" name="uangmuka"> </td>
                            </tr>
                            <tr>
                              <th> Cek / BG </th>
                              <td> <input type="text" class="input-sm form-control ChequeBg " style="text-align: right" readonly="" name="cekbg" value="{{ number_format($fpg->fpg_totalbayar, 2) }}"> </td>
                            </tr>

                            @endforeach
                          </table>
                        </div>
                      </div>
                      
                     

                      <div class="col-xs-12" style>
                        <div class="tabs-container">
                        <ul class="nav nav-tabs">

                          <button class="btn btn-default active"  data-toggle="tab" href="#tab-1" id="detailbayar"> Detail Pembayaran </a></button>
                          <button data-toggle="tab" href="#tab-2" id="bayarcek" class="btn btn-default">Pembayaran dengan Cek / BG  </button></li>
                        
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
                                        <div class="pull-left"> <button class="btn tbn-sm btn-info  btnfaktur" type="button" data-toggle="modal" data-target="#myModal5"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah Data  Faktur</button> </div>

                                   </div>
                                    <hr>
                                   <div class="row">
                                      <div class="col-sm-8">
                                          <div class="tabs-container">
                                            <ul class="nav nav-tabs">
                                                <li class="active"><a data-toggle="tab" href="#pembayaran">Pembayaran</a></li>
                                               <!--  <li class=""><a data-toggle="tab" href="#returnbeli">Return Beli</a></li> -->
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
                                                                <th style="width:40%"> No Transaksi </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>

                                                              @if($data['jenisbayar'] != '5' && $data['jenisbayar'] != '12')
                                                              <?php $n = 1?>
                                                              @for($j=0;$j< count($data['pembayaran']);$j++)
                                                                @for($k=0; $k < count($data['pembayaran'][$j]); $k++)
                                                                  <tr style="height: 30%">
                                                                    <tr class="bayar{{$data['pembayaran'][$j][$k]->idfp}}"> <td><?php echo $n ?></td>
                                                                    <td>  {{$data['pembayaran'][$j][$k]->nofpg}} </td>
                                                                    <td>  {{$data['pembayaran'][$j][$k]->nofaktur}} </td>
                                                                    <td>{{$data['pembayaran'][$j][$k]->tgl}} </td>
                                                                    <td style="text-align: right">{{ number_format($data['pembayaran'][$j][$k]->pelunasan, 2) }} <input type="hidden" class="datapelunasan" value="{{$data['pembayaran'][$j][$k]->pelunasan}}">  </td>
                                                                  </tr>
                                                                  <?php $n++ ?>
                                                                @endfor
                                                              @endfor
                                                              @endif
                                                            </table>

                                                       </div>
                                                    </div>
                                                </div>


                                                <div id="creditnota" class="tab-pane">
                                                  <div class="panel-body">
                                                    <div class="col-sm-12">
                                                            <table class="table table-bordered" style="margin-bottom: 40%" id="table-kredit">
                                                              <tr>
                                                                <th> No </th>
                                                                <th style="width:40%"> No Bukti </th>
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                    @if($data['jenisbayar'] == '2' || $data['jenisbayar'] == '6' || $data['jenisbayar'] == '7' || $data['jenisbayar'] == '9')
                                                               <?php $no = 1; ?>  
                                                             @for($p = 0; $p < count($data['cndn']); $p++)
                                                                                 
                                                               @for($c = 0 ; $c < count($data['cndn'][$p]); $c++)
                                                               @if($data['cndn'][$p][$c]->cndn_jeniscndn == 'K')
                                                                  
                                                                  <tr>
                                                                  <td> <?php echo $no ?> </td>
                                                                  <td> {{$data['cndn'][$p][$c]->cndn_nota}} </td>
                                                                  <td> {{$data['cndn'][$p][$c]->cndn_tgl}}    </td>
                                                                  <td>  {{ number_format($data['cndn'][$p][$c]->cndn_bruto, 2) }}  <input type='hidden' class='cnbruto' value="{{$data['cndn'][$p][$c]->cndn_bruto}}"> </td>
                                                                  </tr>
                                                                    
                                                                 

                                                                  <?php $no++ ?>  
                                                                @endif
                                                                
                                                              @endfor

                                                              @endfor
                                                                @endif
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
                                                                <th style="width:40%"> Tanggal </th>
                                                                <th style="width:100%"> Jumlah Bayar </th>
                                                              </tr>
                                                                  @if($data['jenisbayar'] == '2' || $data['jenisbayar'] == '6' || $data['jenisbayar'] == '7' || $data['jenisbayar'] == '9')
                                                                 @for($p = 0; $p < count($data['cndn']); $p++)                     
                                                               @for($c = 0 ; $c < count($data['cndn'][$p]); $c++)
                                                               @if($data['cndn'][$p][$c]->cndn_jeniscndn == 'D')
                                                                    <?php $n = 1; ?>
                                                                  <tr>
                                                                  <td> <?php echo $n ?> </td>
                                                                  <td> {{$data['cndn'][$p][$c]->cndn_nota}} </td>
                                                                  <td> {{$data['cndn'][$p][$c]->cndn_tgl}}    </td>
                                                                  <td>  {{ number_format($data['cndn'][$p][$c]->cndn_bruto, 2) }}  <input type='hidden' class='dnbruto' value="{{$data['cndn'][$p][$c]->cndn_bruto}}"> </td>
                                                                  </tr>
                                                                    
                                                                  <?php $n++ ?>  
                                                                 
                                                                @endif
                                                              @endfor
                                                              @endfor
                                                              @endif
                                                            </table>
                                                       </div>
                                                  </div>
                                                </div>

                                                <div id="pelunasanum" class="tab-pane">
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
                                            <input type="text" class="input-sm form-control" readonly="" style="text-align: right" name="uangmuka">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td> Pembayaran </td>
                                          <td> <input type="text" class="input-sm form-control pembayaran" readonly="" style="text-align: right" name="pembayaran"></td>
                                        </tr>
                                        <tr>
                                          <td> Return Beli </td>
                                          <td> <input type="text" class="input-sm form-control" readonly="" style="text-align: right" name="returnbeli"> </td>
                                        </tr>
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
                                             <th> No </th>  <th> No Faktur </th>  <th> Tanggal </th> <th> Jatuh Tempo </th> <th> Netto Hutang </th> <th> Pelunasan </th> <th> Pembayaran </th> <th> Sisa Terbayar </th> <th> Keuangan </th> <th> Aksi </th>
                                          </tr>
                                          @if($data['fpg'][0]->fpg_jenisbayar == 2 || $data['fpg'][0]->fpg_jenisbayar == 6 || $data['fpg'][0]->fpg_jenisbayar == 7 || $data['fpg'][0]->fpg_jenisbayar == 9 )
                                            @foreach($data['fpgd'] as $index=>$fpgd)
                                             <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota={{$fpgd->fp_nofaktur}}>
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->fp_nofaktur}} </a>  <!-- {{$fpgd->fp_nofaktur}} --> <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->fp_nofaktur}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->fp_idfaktur}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_jatuhtempo)->format('d-M-Y ') }}  <input type='hidden'  value="{{$fpgd->fpgdt_jatuhtempo}}" name='jatuhtempo[]' class="jatuhtempoitem"> </td> 
                                            <td> {{ number_format($fpgd->fp_netto, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->fpgdt_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->fp_sisapelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->fp_sisapelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->fpgdt_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->fp_netto, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->fp_sisapelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td>

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->fp_nofaktur}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                          @endforeach

                                          @elseif($data['fpg'][0]->fpg_jenisbayar == 3)
                                            @foreach($data['fpgd'] as $index=>$fpgd)
                                            <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota="{{$fpgd->v_nomorbukti}}">
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->v_nomorbukti}} </a>   <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->v_nomorbukti}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->v_id}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_jatuhtempo)->format('d-M-Y ') }}  <input type='hidden'  value="{{$fpgd->fpgdt_jatuhtempo}}" name='jatuhtempo[]' class="jatuhtempoitem"> </td> 
                                            <td> {{ number_format($fpgd->v_hasil, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->fpgdt_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->v_pelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->v_pelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->fpgdt_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->v_hasil, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->v_pelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td> 

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->v_nomorbukti}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                              @endforeach

                                           @elseif($data['fpg'][0]->fpg_jenisbayar == 1)
                                            @foreach($data['fpgd'] as $index=>$fpgd)
                                            <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota="{{$fpgd->ik_total}}">
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->ik_nota}} </a>   <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->ik_nota}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->ik_id}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> - </td> 
                                            <td> {{ number_format($fpgd->ik_total, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->ik_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->ik_pelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->ik_pelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->ik_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->ik_total, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->ik_pelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td>

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->ik_nota}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                              @endforeach

                                         
                                          
                                          @elseif($data['fpg'][0]->fpg_jenisbayar == 4)
                                            @foreach($data['fpgd'] as $index=>$fpgd)
                                            <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota="{{$fpgd->um_nomorbukti}}">
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->fpgdt_nofaktur}} </a>   <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->fpgdt_nofaktur}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->fpgdt_id}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> - </td> 
                                            <td> {{ number_format($fpgd->um_jumlah, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->fpgdt_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->um_sisapelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->um_sisapelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->fpgdt_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->um_jumlah, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->um_sisapelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td>

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->fpgdt_nofaktur}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                              @endforeach

                                          @elseif($data['fpg'][0]->fpg_jenisbayar == 11)
                                           @foreach($data['fpgd'] as $index=>$fpgd)
                                            <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota="{{$fpgd->bp_nota}}">
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->fpgdt_nofaktur}} </a>   <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->fpgdt_nofaktur}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->fpgdt_id}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> - </td> 
                                            <td> {{ number_format($fpgd->bp_nominalkeu, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->fpgdt_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->bp_pelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->bp_pelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->fpgdt_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->bp_nominalkeu, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->bp_pelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td>

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->fpgdt_nofaktur}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                              @endforeach

                                          @elseif($data['fpg'][0]->fpg_jenisbayar == 13)
                                             @foreach($data['fpgd'] as $index=>$fpgd)
                                            <tr class='field dataitemfaktur' id="field{{$index + 1}}" data-nota="{{$fpgd->bp_nota}}">
                                            <td> {{$index + 1}} </td>
                                            <td> <a class='nofp nofp{{$index + 1}}' data-id="{{$index + 1}}"> {{$fpgd->fpgdt_nofaktur}} </a>   <input type='hidden' class="datanofaktur nofaktur{{$index + 1}}" value="{{$fpgd->fpgdt_nofaktur}}" name='nofaktur[]'>  <input type='hidden'  value="{{$fpgd->fpgdt_id}}" name='idfaktur[]'> </td>
                                            <td> {{ Carbon\Carbon::parse($fpgd->fpgdt_tgl)->format('d-M-Y ') }}  </td> <!-- Format Tgl -->
                                            <td> - </td> 
                                            <td> {{ number_format($fpgd->bp_nominalkeu, 2) }}  </td>                                            <!-- NETTO -->

                                            <td class='fakturitem{{$index + 1}}' data-pelunasanfaktur="{{ number_format($fpgd->fpgdt_pelunasan, 2)}}" data-sisapelunasanfaktur="{{ number_format($fpgd->bp_pelunasan, 2)}}"> <input type='hidden' class="sisapelunasan{{$index + 1}}" value="{{ number_format($fpgd->bp_pelunasan, 2)}}"> <input type='text' class="input-sm form-control pelunasanitem pelunasan{{$index + 1}}" style='text-align:right' readonly data-id="{{$index + 1}}" name="pelunasan[]" value="{{number_format($fpgd->fpgdt_pelunasan, 2)}}"> <input type='hidden' class="netto{{$index + 1}}" value="{{ number_format($fpgd->bp_nominalkeu, 2)}}" name='netto[]'></td>  <!-- PELUNASAN -->

                                            <td class='pembayarankanan{{$index + 1}}' data-pembayaranaslifaktur="{{ number_format($data['perhitungan'][$index], 2) }}">  <input type='text' class='input-sm pembayaranitem pembayaranitem{{$index + 1}} form-control' style='text-align:right' readonly data-id="{{$index + 1}}" name='pembayaran[]' value="{{ number_format($data['perhitungan'][$index], 2) }}">  </td> <!-- PEMBAYARAN -->


                                            <td > <input type='text' class="input-sm form-control sisa_terbayar{{$index + 1}}" data-id="{{$index + 1}}" value="{{ number_format($fpgd->bp_pelunasan, 2) }}" readonly name='sisapelunasan[]' style="text-align: right">   </td>
                                            <!-- SISA PELUNASAN -->

                                            <td> <input type='text' class='input-sm form-control keteranganitem{{$index + 1}}' value="{{$fpgd->fpgdt_keterangan}}" readonly="" name="fpgdt_keterangan[]"></td>

                                            <td> <button class='btn btn-danger removes-btn' data-id="{{$index + 1}}" data-nmrfaktur="+nmrf[i]+" data-faktur="{{$fpgd->fpgdt_nofaktur}}" data-idfpgdt="{{$fpgd->fpgdt_id}}" data-idfp="{{$fpgd->fpgdt_idfp}}" type='button'><i class='fa fa-trash'></i></button> </td>

                                          </tr>
                                              @endforeach
                                          @endif
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
                    <h4 class="modal-title" style="text-align: center;"> FAKTUR PEMBELIAN </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                    <table class="table table-bordered tbl-faktur" id="tbl-faktur">
                      <thead>
                        <tr> 
                          <th>No</th> <th> Cabang </th> <th> No Faktur </th> <th> No Invoice </th>  <th> Nama Supplier</th> <th> No TTT </th> <th> Jatuh Tempo </th> <th> Sisa Pelunasan</th> <th> </th>
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
                    <table class="table table-bordered tbl-faktur" id="tbl-cheuque">
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
           </div> <!-- END MODAL --> 
            <!-- MODAL NO FAKTUR -->
              <!-- Modal cari Nota Transaksi -->
              
              <!-- MODAL NO FAKTUR -->
            <div class="modal fade" id="myModalTransaksi" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h4 class="modal-title" style="text-align: center;"> Data Transaksi </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                    <table class="table table-bordered tbl-transaksi" id="tbl-transaksi">
                      <thead>

                        <tr> 
                          <th>No</th> <th> Nota Transaksi </th> <th> Cabang </th> <th> Nominal </th> <th> </th>
                        </tr>
                      </thead>
                    <tbody>

                    </tbody>
                    </table>
                  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="buttongettransaksi">Simpan</button>
                       
                    </div>
                </div>
              </div>
           </div> <!-- END MODAL Cari Nota Transaksi -->



            
              <!-- PEMBAYARAN -->
                            <div id="tab-2" class="tab-pane">
                              <div class="panel-body">
                                 <div class="row">
                                   <table class="table">
                                      <tr>
                                        <th> Kode Bank </th> <th> No Check /BG </th> <th> Nama Bank </th> <th> Cabang Bank </th> <th> Nominal Check / BG </th>
                                      </tr>
                                      @foreach($data['fpg'] as $fpg)
                                      <tr>
                                        <td> 
                                          <select class="form-control selectOutlet chosen-select-width1 bank bankasal" > <option value=""> Pilih Data Bank </option>
                                              @foreach($data['bank'] as $bank)
                                                <option value="{{$bank->mb_id}}+{{$bank->mb_nama}}+{{$bank->mb_cabang}}+{{$bank->mb_accno}}+{{$bank->mb_kode}}+{{$bank->mb_kelompok}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                                @endforeach
                                          </select>

                                          <input type="hidden" class="bankasaldetail" value="{{$data['fpg'][0]->mb_id}}+{{$data['fpg'][0]->mb_nama}} + {{$data['fpg'][0]->mb_cabang}} +{{$data['fpg'][0]->mb_accno}}+{{$data['fpg'][0]->mb_kode}}+{{$data['fpg'][0]->mb_kelompok}}">

                                          <input type="hidden" class="form-control kodebank" readonly="" value="{{$fpg->mb_kode}} " name="kodebank">  
                                          <input type="hidden" class="form-control mbid" readonly="" value="{{$fpg->mb_id}} " name="idbank"> </td>

                                           <td id="nocheckbg"><input type="text" class="input-sm form-control nocheck" type="  button" data-toggle="modal" data-target="#myModal2" id="getbank" readonly="">
                                            <input type="hidden" class="valjenisbayarbank" name="jenisbayarbank">
                                            <input type="hidden" class="mb_id">
                                            <input type="hidden" class="kelompokbank_mb">
                                           </td>
                                            

                                        <td> <input type="text" class="form-control nmbank" readonly="" value="{{$fpg->mb_kode}} - {{$fpg->mb_nama}}"> </td> <td> <input type="text" class="form-control cbgbank" readonly="" value="{{$fpg->mb_cabang}}"> </td> <td> <input type="text" class="form-control account" readonly="" value=""> </td>

                                        <td> <button class="btn btn-sm btn-success" type="button"> Tambah data </button> </td>                                          
                                      </tr>
                                      @endforeach
                                   </table>
                                 </div>

                                  <div class="col-md-8">
                                   <table class="table" border="0" id="tbltujuanpb">
                                      <tr>
                                        <th>
                                      Tujuan Pindah Buku </th>
                                      <td> <select class="form-control input-sm tujuanbankpb">

                                                      <option value="">
                                                        Pilih Data
                                                      </option>
                                                
                                                      <option value="BANK">
                                                          BANK
                                                      </option>
                                                      <option value="KAS">
                                                        KAS
                                                      </option>
                                                    </select>
                                        </td>
                                      
                                        <th> Data Transaksi </th>
                                        <td> <select class="form-control input-sm jenistransaksi" name="jenistransaksi">
                                              <option value="">
                                            Jenis Transaksi
                                              </option>
                                              <option value="11">
                                                BON SEMENTARA
                                              </option>
                                              <option value="12">
                                                GIRO KAS KECIL
                                              </option>
                                            </select>
                                        </td>
                                      </tr>
                                    </table>
                              </div>


                                <div class="col-md-12">
                                <div class="row">
                                <div class="col-xs-3">
                                  <fieldset>
                                      <input type="hidden" class="fpbgjenisbayarbank" value="">
                                     
                                       @if($data['fpg_bank'][0]->fpgb_jenisbayarbank == 'INTERNET BANKING')
                                       <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="jenisbayaribaking" type="checkbox" name="jenisbayarbank" value="INTERNET BANKING" class="metodebayar jenisbayarbankibaking" checked="">
                                            <label for="jenisbayarbankcekbg">
                                               Internet Banking
                                            </label>
                                        </div>

                                          <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="jenisbayarbankcekbg" type="checkbox" name="jenisbayarbank" value="CHECK/BG" class="metodebayar jenisbayarbankbg">
                                            <label for="jenisbayarbankcekbg">
                                                Cheque / BG
                                            </label>
                                        </div>
                                        @else
                                          <div class="checkbox checkbox-info checkbox-circle">
                                            <input id="jenisbayaribaking" type="checkbox" name="jenisbayarbank" value="INTERNET BANKING" class="metodebayar jenisbayarbankibaking" disabled="">
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
                                       @endif
                                   
                                    </fieldset>
                                      <br>
                                      <br>                              
                                </div>


                        @if($data['fpg'][0]->fpg_jenisbayar == '12' || $data['fpg'][0]->fpg_jenisbayar == '11')

                          <div class="col-sm-8 tujuanbankacc"> <!-- TRANSFERBANK TUJUAN ACCOUNT -->
                            <div class="col-xs-6">
                                <table class="table">
                                  <tr>
                                  <th colspan="4" style="color:#009aa9"> <h3> Tujuan Bank : </h3> </th>
                                </tr>

                              
                                  <th class="banktujuan2"> Bank Tujuan </th>
                                  <td class="banktujuan2">
                                      <select class="form-control selectOutlet chosen-select-width1 bank1 banktujuan" name="tujuanbank">    
                                        <option value=""> Pilih Data Bank </option>
                                         @foreach($data['tujuanbank'] as $bank)
                                                      <option value="{{$bank->mb_id}}+{{$bank->mb_nama}}+{{$bank->mb_cabang}}+{{$bank->mb_accno}}+{{$bank->mb_kode}}+{{$bank->mb_kelompok}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                          @endforeach   
                                      </select>
                                  </td>

                                  <th class="kastujuan2"> Kas Tujuan </th>
                                  <td class="kastujuan2"> 
                                         <select class="form-control chosen-select-width1 kastujuan" name="kastujuan">
                                              <option value=""> Pilih Data Kas </option>
                                               @foreach($data['tujuanbankkas'] as $kas)
                                                    <option value="{{$kas->id_akun}}+{{$kas->nama_akun}}+{{$kas->kode_cabang}}"> {{$kas->id_akun}} - {{$kas->nama_akun}} </option>
                                                  @endforeach
                                          </select>
                                  </td>
                                </tr>

                                @if($data['fpg_bank'][0]->fpgb_jenisbayarbank == 'INTERNET BANKING')
                                <tr>
                                  <td>
                                    <button class="btn btn-success btn-xs" type="button" id="tbmhdatainet">Tambah Data
                                    </button>
                                  </td>
                               </tr>
                                @endif
                                </table>
                              </div>

                                  <div class="col-xs-6">
                                       <table class="table">
                                      <tr>
                                      <th colspan="4" style="color:#009aa9"> <h3> Tujuan Transaksi : </h3> </th>
                                    </tr>

                                    <tr>
                                      <th> <i class="fa fa-search"> </i> Cari Nota </th>
                                      <td> 
                                        <input type="text" class="form-control carinotatransaksi input-sm" data-toggle="modal" data-target="#myModalTransaksi" id="getNotaTransaksi">
                                      </td>
                                      <td>                                      
                                      </td>
                                    </tr>
                                    </table>
                                  </div>
                               
                                </div>
                                @endif
                                </div>
                              </div>
                                <div class="col-md-12" style="padding-top: 20px">                                  
                                  <table class="table table-bordered" id="tbl-bank">
                                    @if($data['fpg'][0]->fpg_jenisbayar != '11' && $data['fpg'][0]->fpg_jenisbayar != '12')
                                      
                                    <tr>
                                      <th> Nomor </th>
                                      <th> No Bukti </th>
                                      <th> No Cek / BG </th>
                                      <th> Tanggal </th>
                                      <th> Kode Bank </th>
                                      <th> Jatuh Tempo </th>
                                      <th> Nominal </th>
                                      <th> Aksi </th>
                                      <th> RUSAK </th>
                                    </tr>
                                     @for($i =0; $i < count($data['fpg_bank']); $i++)
                                        @if($data['fpg_bank'][$i]->fpgb_cair == 'TIDAK')
                                        <tr id="datas{{$i + 1}}" class='tblbank databank' data-id='{{$i + 1}}'>
                                          <td> {{$i + 1}} </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->fpg_nofpg}} </banks2> </td>
                                          <td class='fpgbank' data-nocheck='{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}'> <a class='noseri noseri2{{$i + 1}}'  data-id={{$i+1}}> {{$data['fpg_bank'][$i]->fpgb_nocheckbg}} </a> <input type='hidden' class="noseri{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='noseri[]'> </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->fpg_tgl}} </banks2> </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->mb_kode}} </banks2> </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->fpgb_jatuhtempo}} </banks2> <input type='hidden' class="jatuhtempo{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_jatuhtempo}}"> </td>
                                          <td><input type='text' data-id="{{$i + 1}}" class="input-sm form-control nominaltblbank nominalbank{{$i + 1}} nominalcheck{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}"  name='nominalbank[]' style="text-align:right" value="{{ number_format($data['fpg_bank'][$i]->fpgb_nominal, 2) }}">
                                         
                                          </td>
                                          <td> 

                                           </td> 

                                        <td>
                                           <div class="checkbox">
                                              <input type="checkbox" data-id="{{$data['fpg_bank'][$i]->mb_id}}" data-nmr="{{$i + 1}}"  id="rusak" class="checkbox-danger rusak" value="RUSAK" aria-label="Single checkbox One" name="rusak[]" checked="" disabled="">
                                              <label> RUSAK </label> <input type="hidden" name="valrusak[]"  class='valrusak{{$i + 1}}' >
                                          </div>
                                        </td>
                                        </tr>
                                        @else
                                          <tr id="datas{{$i + 1}}" class='tbl-bank databank' data-id='{{$i + 1}}'>
                                          <td> {{$i + 1}} </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->fpg_nofpg}} </bank> </td>
                                          <td class='fpgbank' data-nocheck='{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}'> <a class='noseri noseri2{{$i + 1}}'  data-id={{$i+1}}> {{$data['fpg_bank'][$i]->fpgb_nocheckbg}} </a> <input type='hidden' class="noseri{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='noseri[]'> </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->fpg_tgl}} </bank> </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->mb_kode}} </bank> </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->fpgb_jatuhtempo}} </bank> <input type='hidden' class="jatuhtempo{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_jatuhtempo}}"> </td>
                                          <td><input type='text' data-id="{{$i + 1}}" class="input-sm form-control nominaltblbank nominalbank{{$i + 1}} nominalcheck{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}"  name='nominalbank[]' style="text-align:right" value="{{ number_format($data['fpg_bank'][$i]->fpgb_nominal, 2) }}">
                                       
                                          </td>
                                          <td> 
                                             <button class='btn btn-sm btn-danger remove-btn' data-id="{{$i + 1}}"  data-idbankdt="{{$data['fpg_bank'][$i]->mb_id}} " data-idfpgb="{{$data['fpg_bank'][$i]->fpgb_id}}" data-noseri="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" data-kodebank="{{$data['fpg_bank'][$i]->mb_kode}}" type='button'><i class='fa fa-trash'></i> </button>  

                                           </td> 

                                        <td>
                                           <div class="checkbox">
                                              <input type="checkbox" data-id="{{$data['fpg_bank'][$i]->mb_id}}" data-nmr="{{$i + 1}}"  id="rusak" class="checkbox-danger rusak" value="RUSAK" aria-label="Single checkbox One" name="rusak[]" >
                                              <label> RUSAK </label> <input type="hidden" name="valrusak[]"  class='valrusak{{$i + 1}}' >
                                          </div>
                                        </td>
                                        </tr>
                                      </table>
                                        @endif
                                      @endfor

                                    @else
                                    <table class="table" id="tbl-tfbank"> {{-- Jika Kode 11 atau 12 --}}
                                      <th> Nomor </th>
                                      <th> No Bukti </th>
                                      <th> No Cek / BG </th>
                                      <th> Tanggal </th>
                                      <th> Asal Kode Bank </th>
                                      <th> Tujuan Kode Bank </th>
                                    
                                      <th> Nama Bank Tujuan </th>
                                      <th> Nominal </th>
                                      <th> Aksi </th>
                                      <th> RUSAK </th>

                                       @for($i =0; $i < count($data['fpg_bank']); $i++)
                                        @if($data['fpg_bank'][$i]->fpgb_cair == 'TIDAK')
                                        <tr id="datas{{$i + 1}}" class='tbltfbank tblbank databank' data-id='{{$i + 1}}'>
                                          <td> {{$i + 1}} </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->fpg_nofpg}} </banks2> </td>
                                          <td class='fpgbank' data-nocheck='{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}'> <a class='noseri noseri2{{$i + 1}}'  data-id={{$i+1}}> {{$data['fpg_bank'][$i]->fpgb_nocheckbg}} </a> <input type='hidden' class="noseri{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='noseri[]'> </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->fpg_tgl}} </banks2> </td>
                                          <td> <banks2> {{$data['fpg_bank'][$i]->mb_kode}} </banks2> </td>
                                          <td> {{$data['fpg_bank'][$i]->fpgb_kodebanktujuan}}</td>
                                          <td> {{$data['fpg_bank'][$i]->fpgb_nmbanktujuan}} </td>
                                          <td> <input type='text' data-id="{{$i + 1}}" class="input-sm form-control nominaltblbank nominalbank{{$i + 1}} nominalcheck{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='nominalbank[]' style="text-align:right" value="{{ number_format($data['fpg_bank'][$i]->fpgb_nominal, 2) }}">
                                          </td>
                                          <td> 

                                           </td> 

                                        <td>
                                           <div class="checkbox">
                                              <input type="checkbox" data-id="{{$data['fpg_bank'][$i]->mb_id}}" data-nmr="{{$i + 1}}"  id="rusak" class="checkbox-danger rusak" value="RUSAK" aria-label="Single checkbox One" name="rusak[]" checked="" disabled="">
                                              <label> RUSAK </label> <input type="hidden" name="valrusak[]"  class='valrusak{{$i + 1}}' >
                                          </div>
                                        </td>
                                        </tr>
                                        @else
                                          <tr id="datas{{$i + 1}}" class='tbltfbank tblbank databank' data-id='{{$i + 1}}'>
                                          <td> {{$i + 1}} </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->fpg_nofpg}} </bank> </td>
                                          <td class='fpgbank' data-nocheck='{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}'> <a class='noseri noseri2{{$i + 1}}'  data-id={{$i+1}}> {{$data['fpg_bank'][$i]->fpgb_nocheckbg}} </a> <input type='hidden' class="noseri{{$i + 1}}" value="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='noseri[]'> </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->fpg_tgl}} </bank> </td>
                                          <td> <bank{{$i + 1}}> {{$data['fpg_bank'][$i]->mb_kode}} </bank> </td>
                                           <td> {{$data['fpg_bank'][$i]->fpgb_kodebanktujuan}}</td>
                                       
                                          <td> {{$data['fpg_bank'][$i]->fpgb_nmbanktujuan}}</td>
                                     
                                          <td><input type='text' data-id="{{$i + 1}}" class="input-sm form-control nominaltblbank nominalbank{{$i + 1}} nominalcheck{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" name='nominalbank[]' style="text-align:right" value="{{ number_format($data['fpg_bank'][$i]->fpgb_nominal, 2) }}">
                                       
                                          </td>
                                          <td> 
                                             <button class='btn btn-sm btn-danger remove-btn' data-id="{{$i + 1}}"  data-idbankdt="{{$data['fpg_bank'][$i]->mb_id}} " data-idfpgb="{{$data['fpg_bank'][$i]->fpgb_id}}" data-noseri="{{$data['fpg_bank'][$i]->fpgb_nocheckbg}}" data-kodebank="{{$data['fpg_bank'][$i]->mb_kode}}" type='button'><i class='fa fa-trash'></i> </button>  

                                           </td> 

                                        <td>
                                           <div class="checkbox">
                                              <input type="checkbox" data-id="{{$data['fpg_bank'][$i]->mb_id}}" data-nmr="{{$i + 1}}"  id="rusak" class="checkbox-danger rusak" value="RUSAK" aria-label="Single checkbox One" name="rusak[]" >
                                              <label> RUSAK </label> <input type="hidden" name="valrusak[]"  class='valrusak{{$i + 1}}' >
                                          </div>
                                        </td>
                                        </tr>
                                      </table>
                                        @endif
                                      @endfor

                                    @endif

                                  </table>
                                </div>
                                </div>

                                
                                <div class="col-md-12 dataalltransaksi">
                                    <br>
                                    <br>
                                    <hr>
                                    <div class="table-responsive">
                                      <h3> Data Transaksi </h3>
                                      <table class="table table-bordered" id="tbl-dataalltransaksi" style="width:50%">
                                        <thead style="background-color: grey;color:white">
                                        <tr>
                                            <th> Nota Transaksi </th>
                                            <th> Cabang Transaksi </th>
                                            <th> Nominal </th>
                                            <th> Hapus </th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      </tbody>
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
                  
                    <a class="btn btn-warning" href={{url('formfpg/formfpg')}} id="kembali"> Kembali </a>

                          @if($data['fpg'][0]->fpg_jenisbayar == '5' || $data['fpg'][0]->fpg_jenisbayar == '12')
                            <a class="btn btn-sm btn-info" href="{{url('formfpg/printformfpg2/'.$data['fpg'][0]->idfpg.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> </a>
                          @else
                              <a class="btn btn-sm btn-info" href="{{url('formfpg/printformfpg/'.$data['fpg'][0]->idfpg.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> </a>
                          @endif

                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
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
      $('#submit').hide();

    $('#editdata').click(function(){
      $('#submit').show();
    });

    $('.banktujuan2').hide();
    $('.kastujuan2').hide();

   $('.tujuanbankpb').change(function(){
    val = $(this).val();
    if(val == 'KAS'){
      $('.kastujuan2').show();
      $('.banktujuan2').hide();
    }
    else {
     $('.kastujuan2').hide();
      $('.banktujuan2').show(); 
    }
  })



     $('.jenisbayarbankibaking').change(function(){
          $this = $(this);
          jenisbayar = $('.jenisbayar').val();
           if ($this.is(":checked")) {
                if(jenisbayar == '12' || jenisbayar == '11'){
                  $('.transferbank').show();
                  $('.tujuanbankacc').show();
                  $('.jenisbayarbankbg').prop({ checked: false }); 
                  $('.jenisbayarbanktf').prop({ checked: false }); 
                  banktujuan =$('.banktujuan').val();
                  $('#tbmhdatainet').show();
                  $('.nocheck').attr('readonly' , true);
                  $('.nominaltujuanbank').attr('readonly' , true);
                  $('tr.tblbank').remove();
                }
                else {
                  $('.jenisbayarbankbg').prop({ checked: false });           
                  $('.tujuanbank').hide();
                  $('.tujuanbankacc').hide();
                  $('.transferbank').hide();
                  $('.checkbgtf').hide();
                  $('.ibanking').show();
                  $('#tbl-ibank').show();
                  $('tr.tblbank').remove();
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
                        "<td> <input type='text' class='form-control jatuhtempotblbank' value='"+jatuhtempo+"' readonly> </td> <td> <input type='text'  class='input-sm form-control nominaltblibank' name='nominalbank' style='text-align:right'> </td>" + //JATUH TEMPO
                        "<td>  </td> </tr>"; //NOMINAL
                      
                    $('#tbl-ibank').append(row);

                    $('.nominaltblibank').change(function(){
                      
                        totbayar = $('.totbayar').val();
                        kodebank = $('.kodebankbg').val();

                        val = $(this).val();
                        val = accounting.formatMoney(val, "", 2, ",",'.');
                        $(this).val(val);
                          jenisbayar = $('.jenisbayar').val();
                          if(jenisbayar != '5'){

                             totbayar = totbayar.replace(/,/g,'');
                             val = val.replace(/,/g,'');
                             if(parseFloat(totbayar) < parseFloat(val)) {
                              toastr.info("Nominal harus sama dengan totalbayar :)");
                              return false;
                             }
                             $('.ChequeBg').val(addCommas(val));
                          }
                          else {
                            $('.totbayar').val(val);
                            $('.ChequeBg').val(val);
                          }
                        
                    })
                }
           }
           else {
            if(jenisbayar == 12 || jenisbayar == 11){
              $('.checkbgtf').hide();
              $('.ibanking').hide();
            }
            else {
              $('.checkbgtf').show();
              $('.ibanking').hide();
            }

           }
      })


      noinet = $('.tbltfbank').length;     
      $('#tbmhdatainet').click(function(){
        noinet = parseInt(noinet) + 1;
        asalbank = $('.bankasaldetail').val();
        nofpg = $('.nofpg').val();
        jenispindahbuku = $('.tujuanbankpb').val();
        



        if(jenispindahbuku == 'BANK'){
         banktujuan = $('.banktujuan').val();
  
          if(banktujuan == '' || asalbank == ''){
            toastr.info("Mohon maaf data bank asal / tujuan belum diisi :)");
            $('.jenisbayarbankibaking').prop({checked: false });
            return false; 
          }

          split = banktujuan.split("+");
          kodebanktujuan = split[4];
          norekening = split[3];
          namabank = split[1];
          idbanktujuan = split[0];
          kelompoktujuan = split[5];
        }
        else if(jenispindahbuku == 'KAS'){
          kastujuan = $('.kastujuan').val();
          if(kastujuan == '' || asalbank == ''){
            $('.jenisbayarbankibaking').prop({checked: false });
            return false;
          }

          split = kastujuan.split("+");
          kodebanktujuan = split[0];
          norekening = '-';
          namabank = split[1];
          idbanktujuan = split[0];
          kelompoktujuan = 'KAS';
         // alert(idbanktujuan);
        }
        else if(jenispindahbuku == ''){
          toastr.info("Mohon diisi Kas / Bank :)");
          return false;
        }
        //alert(idbanktujuan);
      
       tgl = $('.tgl').val();
      
        splitasal = asalbank.split("+");
        kodebankasal = splitasal[4];
        idbankasal = splitasal[0];
        kelompok = splitasal[5];

        jenisbayar = $('.jenisbayar').val();

        if(jenisbayar == 12 || jenisbayar == 11){
           if(jenispindahbuku == 'BANK'){
                    if(kelompok == kelompoktujuan){
                      kelompokbank = 'SAMA BANK';
                    }
                    else if(kelompok != kelompoktujuan) {
                      kelompokbank = 'BEDA BANK';
                    }
                  }
                  else if(jenispindahbuku == 'KAS') {
                    kelompokbank = 'KAS';
                  }
        }
        else {
          if(kelompok == kelompoktujuan){
              kelompokbank = 'SAMA BANK';
            }
            else if(kelompok != kelompoktujuan) {
              kelompokbank = 'BEDA BANK';
            }
        }


           var row =  "<tr class='tbltfbank tblbank tbltfbank"+noinet+"'> <td>"+noinet+"</td>" +
                      "<td>"+nofpg+"</td>" + // NO FPG
                      "<td> - </td>" + // -
                      "<td>"+tgl+"</td>"+ 
                      "<td>"+kodebankasal+"</td>" + // BANK ASAL
                      "<td><input type='text' class='form-control kodebankbg' value="+kodebanktujuan+" name='kodebanktujuan[]' readonly></td>"+ // KODEBANK
                      "<td> <input type='text' class='form-control namarekening' value='"+namabank+"' name='namabanktujuan[]' readonly> <input type='hidden' class='form-control idbanktujuan' value='"+idbanktujuan+"' name='idbanktujuan[]' readonly> <input type='hidden' class='kelompokbank' name='kelompokbank[]' value='"+kelompokbank+"'>  </td>" + //NAMA BANK TUJUAN
                      "<td> <input type='text' data-id='"+noinet+"' class='input-sm form-control nominaltblbank nominaltblbank"+noinet+"'  name='nominalbank[]' style='text-align:right'> </td>" + //NOMINAL
                      "<td> <button class='btn btn-danger remove-tfbtn' data-id='"+noinet+"'  data-idbankdt="+idbankasal+" type='button'><i class='fa fa-trash'></i></button></td></tr>"; //NOMINAL
              
            $('#tbl-tfbank').append(row);
         
                 kelompokbank1 = $('.kelompokbank').val();

                 if(kelompokbank1 != ''){
                    if(kelompokbank1 == 'SAMA BANK') {
                       if(kelompok == kelompoktujuan){
                         $('.kelompokbank').val('SAMA BANK');
                        }
                       else {
                       $('.kelompokbank').val('BEDA BANK');
                      }
                    }
                    else if(kelompokbank1 == 'BEDA BANK') {
                       if(kelompok == kelompoktujuan){
                         $('.kelompokbank').val('BEDA BANK');
                        }
                       else {
                       $('.kelompokbank').val('BEDA BANK');
                      }
                    }                             
                 }
                 else{
                   if(kelompok == kelompoktujuan){
                         $('.kelompokbank').val('SAMA BANK');
                        }
                       else {
                       $('.kelompokbank').val('BEDA BANK');
                    }
                 }


                 $('.nominaltblbank').change(function(){
                    val = $(this).val();
                    val = accounting.formatMoney(val, "", 2, ",",'.');
                    $(this).val(val);

                      jumlahtf = 0;
                      $('.nominaltblbank').each(function(){
                        nominaltf = $(this).val();
                        nominaltf2 = nominaltf.replace(/,/g,'');
                        jumlahtf = parseFloat(parseFloat(jumlahtf) + parseFloat(nominaltf2)).toFixed(2);
                      })
                      alert(jumlahtf);
                      alert(jenisbayar);
                      if(jenisbayar == 12){
                        $('.totbayar').val(addCommas(jumlahtf));
                        $('.ChequeBg').val(addCommas(jumlahtf));  
                      }
                      else if(jenisbayar == 11) {
                        $('.ChequeBg').val(addCommas(jumlahtf));  
                      }
                  })

                 $('.remove-tfbtn').click(function(){
                    jenisbayar = $('.jenisbayar').val();
                    if(jenisbayar == '11'){
                      id = $(this).data('id');
                      nominal = $('.nominaltblbank' + id).val();
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
                      nominal = $('.nominaltblbank' + id).val();
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


      valjenisbayar = $('valjenisbayarbank').val();
     // alert(valjenisbayar);
      $('.metodebayar').each(function(){
        metodebayar = $('.metodebayar').val();

        if(metodebayar == valjenisbayar) {
          $(this).prop("checked");
        }

      });

      
 $('#getNotaTransaksi').click(function(){
        jenisbayar = $('.jenistransaksi').val();
        cabang = $('.cabang').val();
          
        jenispindahbuku = $('.tujuanbankpb').val();   
        if(jenispindahbuku == 'BANK'){
          toastr.info("Mohon maaf, fitur ini hanya untuk jenis kas :)");
          return false;
        }
          if(jenisbayar == ''){
            toastr.info("Mohon maaf jenis transaksi belum dipilih :)");
            return false;
          }

          kas = $('.kastujuan').val();
          if(kas == ''){
              toastr.info("tidak ada pilihan kas yang dipilih :)");
              return false;
          }

          $.ajax({
            type : "get",
            url : baseUrl + "/formfpg/caritransaksi",
            data : {jenisbayar,kas},
            dataType : "json",
            success : function(response){
              
             // alert(jenisbayar);
              if(jenisbayar == 12){
                  datatransaksi = response.transaksi;
                  var tabletransaksi = $('#tbl-transaksi').DataTable();
                  tabletransaksi.clear().draw();
                    var nmrbnk = 1;
               //     alert(datatransaksi.length);
                    for(var i = 0; i < datatransaksi.length; i++){                                   
                       var  html2 = "<tr>" +
                                    "<td>"+ nmrbnk +"</td>" +
                                    "<td>"+ datatransaksi[i].ik_nota +"</td>" +
                                    "<td>"+ datatransaksi[i].ik_comp +"</td>" +
                                    "<td style='text-align:right'>"+ addCommas(datatransaksi[i].ik_total) +"</td>" + 
                                    "<td> <div class='checkbox'> <input type='checkbox' id="+datatransaksi[i].ik_id+","+nmrbnk+","+datatransaksi[i].ik_nota+","+datatransaksi[i].ik_comp+","+datatransaksi[i].ik_total+" class='checktransaksi' value='option1' aria-label='Single checkbox One'> <label> </label> </div></td>" +
                                    "</tr>";
                         tabletransaksi.rows.add($(html2)).draw(); 
                        nmrbnk++; 
                 }
              }
              else if(jenisbayar == 11){
                  datatransaksi = response.transaksi;
                  var tabletransaksi = $('#tbl-transaksi').DataTable();
                  tabletransaksi.clear().draw();
                    var nmrbnk = 1;
                    for(var i = 0; i < datatransaksi.length; i++){                                   
                        var html2 = "<tr>" +
                                      "<td>"+nmrbnk+"</td>" +
                                      "<td>"+datatransaksi[i].bp_nota+"</td>"+
                                      "<td>"+datatransaksi[i].bp_cabang+"</td>"+
                                      "<td style='text-align:right'>"+addCommas(datatransaksi[i].bp_nominalkeu)+"</td>"+
                                       "<td><div class='checkbox'> <input type='checkbox' id="+datatransaksi[i].bp_id+","+nmrbnk+","+datatransaksi[i].bp_nota+","+datatransaksi[i].bp_cabang+","+datatransaksi[i].bp_nominalkeu+" class='checktransaksi' value='option1' aria-label='Single checkbox One'>  <label> </label> </div> </td>";
                                    "<tr>";
                         tabletransaksi.rows.add($(html2)).draw(); 
                        nmrbnk++; 
                 }
              }
           }
          })
      })



       nmr = 1;
      $('#buttongettransaksi').click(function(){
          $('#myModalTransaksi').modal('toggle');
         var checked = $(".checktransaksi:checked").map(function(){
          return this.id;
        }).toArray();

        variabel = [];
        variabel = checked;
        cabang = [];
        total =[];
        nota = [];
        id = [];
        nmr = parseInt($('.datatransaksipb').length) + 1;
        for(z=0;z<variabel.length;z++){
          string = variabel[z].split(",");
          cabang.push(string[3]);
          total.push(string[4]);
          nota.push(string[2]);
          id.push(string[0]);
        }
        alert(variabel);

       for($i = 0; $i < variabel.length; $i++){
          var row = "<tr class='datatransaksipb data"+nmr+"'><td>"+nota[$i]+" <input type='hidden' value='"+id[$i]+"' name='idfaktur[]'> </td><td>"+cabang[$i]+" <input type='hidden' value='"+nota[$i]+"' name='notafaktur[]'> </td><td><p class='totaltransaksi totaltransaksi"+nmr+"'>"+addCommas(total[$i])+" <input type='hidden' class='form-control' name='nominalfaktur[]' value="+addCommas(total[$i])+"> </p></td> <td> <button class='btn btn-xs btn-danger removes-transaksi' type='button' data-id="+nmr+"><i class='fa fa-trash'> </i> </button></td> </tr>";
            $('#tbl-dataalltransaksi').append(row);
            nmr++;
       }
          totaltransaksi = 0;
          $('.totaltransaksi').each(function(){
            val = $(this).text();
            aslinominal = val.replace(/,/g, '');
            totaltransaksi = (parseFloat(totaltransaksi) + parseFloat(aslinominal)).toFixed(2);
          })

          $('.totbayar').val(addCommas(totaltransaksi));
          nmr++;


          $('.removes-transaksi').click(function(){
              id = $(this).data('id');
             // alert(id);
              $('.data' + id).remove();
              harga = $('.totaltransaksi').val();
              totalbayar = $('.totbayar').val();
              asliharga = harga.replace(/,/g,'');
              aslitotbayar = totalbayar.replace(/,/g,'');

              hargafinal = (parseFloat(aslitotbayar) - parseFloat(asliharga)).toFixed(2);
              $('.totbayar').val(addCommas(hargafinal));
          })
      });

     $('#getbank').click(function(){
       // alert('hei');
        bank = $('.bank').val();
       // alert(bank);
        if(bank == ''){
          toastr.info("Data Bank Belum diisi :)");
          return false;
        }
      });


    $('.bank1').change(function(){
      val = $(this).val();
      string = val.split(",");
      namabank = string[1];
      alamat = string[2];
      account = string[3];
      id = string[0];

      $('.nmbank1').val(namabank);
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
                      "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+"' readonly name='nominalbank[]' style='text-align:right' required value="+nominal+"> </td>" + //NOMINAL
                      "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"' type='button'><i class='fa fa-trash'></i></button></td> </tr>"
          
          $("#tbl-bank").append(row);

          $('.nominalbank1').val(nominalbank);
          $('.ChequeBg').val(nominalbank);

      })

       $('.jenisbayarbankbgtf').change(function(){
        $this = $(this);
          if ($this.is(":checked")) {
           $('.jenisbayarbankbg').prop({ disabled: true, checked: false }); 
           $('.jenisbayarbanktfacc').prop({ disabled: true, checked: false }); 
           $('.checkbgtf').hide();
           $('.tujuanbank').show();
           $('.transferbank').show();
          }
          else {
           $('.jenisbayarbankbg').prop({ disabled: false, checked: false }); 
           $('.jenisbayarbanktfacc').prop({ disabled: false, checked: false }); 
           $('.checkbgtf').show();
           $('.tujuanbank').hide();
           $('.tujuanbankacc').hide();
            $('.transferbank').hide();
          }
      })

       $('.jenisbayarbanktfacc').change(function(){
        $this = $(this);
          if ($this.is(":checked")) {
           $('.jenisbayarbankbg').prop({ disabled: true, checked: false }); 
           $('.jenisbayarbankbgtf').prop({ disabled: true, checked: false }); 
           $('.checkbgtf').hide();
           $('.tujuanbank').hide();
           $('.tujuanbankacc').show();
           $('.transferbank').show();
          }
          else {
           $('.jenisbayarbankbg').prop({ disabled: false, checked: false }); 
           $('.jenisbayarbankbgtf').prop({ disabled: false, checked: false }); 
           $('.jenisbayarbanktfacc').prop({ disabled: false, checked: false }); 
           $('.checkbgtf').show();
           $('.tujuanbank').hide();
           $('.tujuanbankacc').hide();
            $('.transferbank').hide();
          }
      })

        // BANK BG TF
       $this = $('.jenisbayarbankbgtf');
           if ($this.is(":checked")) {
              $('.jenisbayarbankbgtf').prop({ disabled: true, checked: false }); 
           }
           else {
              $('.jenisbayarbankbgtf').prop({ disabled: false, checked: false }); 

           }

      $('.jenisbayarbankbg').change(function(){
          $this = $(this);
           if ($this.is(":checked")) {
              $('.jenisbayarbankbgtf').prop({ disabled: true, checked: false }); 
              $('.jenisbayarbanktfacc').prop({ disabled: true, checked: false });
              $('.jenisbayarbankibaking').prop({checked: false});
              $('.tujuanbank').hide();
              $('.tujuanbankacc').hide();
              $('.transferbank').hide();
              $('tr.tblbank').remove();
           }
           else {
              $('.jenisbayarbankbgtf').prop({ disabled: false, checked: false }); 
              $('.jenisbayarbanktfacc').prop({ disabled: false, checked: false }); 

           }
      })




    arrfaktur = [];
    $('.datanofaktur').each(function(){
      nofaktur = $(this).val();
        arrfaktur.push(nofaktur);
    })

    $('#kembali').click(function(){
       totbar = $('.totbayar').val();
       cekbg = $('.ChequeBg').val();

      
        if(totbar != cekbg) {
          toastr.info('Mohon Maaf nominal total faktur dengan ChequeBG tidak sama :)');
          return false;
        }

       // return false;
    })

    $('.nominaltblbank').change(function(){
       val = $(this).val();      
       val = accounting.formatMoney(val, "", 2, ",",'.');
       $(this).val(val);
          totalnominal = 0;
        $('.nominaltblbank').each(function(){
          val = $(this).val();
          if(val != ''){
            nominal = val.replace(/,/g, '');
            totalnominal = parseFloat(parseFloat(totalnominal) + parseFloat(nominal)).toFixed(2);
            $('.ChequeBg').val(addCommas(totalnominal));
          }
        })


    })


     $('#formfpg').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

      $('#formfpg').submit(function(event){
        var temp = 0;
        var tempketerangan = 0;
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

        $('.keteranganitem').each(function(){
          valketerangan = $(this).val();
          if(valketerangan == ''){
            tempketerangan = tempketerangan + 1;
          }
        })

        totbar = $('.totbayar').val();
        cekbg = $('.ChequeBg').val();

      
        if(totbar != cekbg) {
          toastr.info('Mohon Maaf nominal total faktur dengan ChequeBG tidak sama :)');
          return false;
        }
        else if(temp != 0){
           toastr.info('Pelunasan ada yang belum diisi :)');
          return false;
        }
        else if(tempketerangan != 0){
          toastr.info('Input Keterangan belum diisi :)');
          return false;
        }
        else {

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
            closeOnConfirm: false
          },
           function(){
         $.ajax({
          type : "post",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
           
                alertSuccess(); 
              window.location.href = baseUrl + "/formfpg/formfpg";
           
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

    //END SUBMIT


      $('banks2').css({"color" : "red"});
      $(document).ready(function(){


       $('.rusak').click(function(){
        
        id = $(this).data('nmr');
    
        if($(this).is(':checked')){
          dikurangi = 0;
          $('bank' + id).css({"color" : "red"});
         // $('.noseri2'+id).css({"color" : "red"});
          $('.nominalbank' + id).attr('readonly' , false);
          $('.nominalbank' + id).css({"color" : "red"});
          $('.nominalbank' + id).removeClass("nominaltblbank");

             nominalbank = $('.nominalbank' + id).val();

            var rusak = 'rusak';
            $('.valrusak'+id).val(rusak);

            var totbayar = $('.totbayar').val();

            $('.ChequeBg').val(totbayar);
          
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

            totbar = $('.totbayar').val();
             cek = $('.ChequeBg').val();
            // alert('test');
             if(totbar != cek){
                toastr.info('Jumlah Total Bayar , tidak sama dengan Jumlah Bayar Mohon di lengkapi form input, lalu simpan data anda :) ');
                 $('html,body').animate({scrollTop: $('.ChequeBg').offset().top}, 200, function() {
                
                    $('.ChequeBg').focus();
                   
                });
             }

        }
        else {
          dikurangi = 0;
          $('bank'+id).css({"color" : "black"});
       //   $('.noseri2'+id).css({"color" : "black"});
          $('.nominalbank' + id).attr('readonly' , true);
          $('.nominalbank' + id).css({"color" : "black"});
          $('.nominalbank' + id).addClass("nominaltblbank"); 



            nominalbank = $('.nominalbank' + id).val();

          
             if(nominalbank != ''){
                Totalcheq = $('.ChequeBg').val();
                if(Totalcheq != ''){
                  aslinominal = nominalbank.replace(/,/g, '');
                   aslitotal = Totalcheq.replace(/,/g, '');
               /*    alert(aslitotal + 'aslitotal');
                   alert(aslinominal + 'aslinominal');*/
                  dikurangi = parseInt(aslitotal) + parseInt(aslinominal);
               
                  
                  dikurangi = dikurangi.toFixed(2);
                  $('.ChequeBg').val(dikurangi);

                }
             }
        }



      })
     })
  

     $('.btnfaktur').click(function(){
              var idsup = $('.kodejenisbayar').val();
              var nosupplier = $('.kodejenisbayar').val();
              var idjenisbayar = $('.jenisbayarheader').val();
              var cabang = $('.cabang').val();
                
                 arrnofaktur = [];
                 $('tr.field').each(function(){
                    nobukti = $(this).data('nota');
                   // alert(nobukti);
                    arrnofaktur.push(nobukti);
                 })     

                $.ajax({
                  url : baseUrl + '/formfpg/changesupplier',
                  data : {idsup,idjenisbayar,cabang,nosupplier,arrnofaktur},
                  type : "get",
                  dataType : "json",
                  success : function(data) {
                      
                    var fp = data.fakturpembelian;
                    $('.jthtmpo_bank').val(fp[0].fp_jatuhtempo);
                    $('.hari_bank').val(fp[0].fp_jatuhtempo);

                     //tambah data ke table data po
                    var tablefaktur = $('#tbl-faktur').DataTable();
                    tablefaktur.clear().draw();
                    var n = 1;
                    if(idjenisbayar == '2'){                        
                        for(var j =0; j < fp.length; j++){
                            var html2 = "<tr class='data"+n+"' id='data"+fp[j].fp_nofaktur+"'> <td>"+n+"</td>" +
                                  "<td>"+fp[j].nama+"</td>" +
                                  "<td>"+fp[j].fp_nofaktur+"</td>" +
                                  "<td>"+fp[j].fp_noinvoice+"</td>" +            
                                  "<td>"+fp[j].nama_supplier +"</td>"+
                                  "<td>"+fp[j].tt_noform+"</td>" +
                                  "<td>"+fp[j].fp_jatuhtempo+"</td>" +
                                  "<td>"+addCommas(fp[j].fp_sisapelunasan)+"</td> ";
                              html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[j].fp_idfaktur+","+fp[j].fp_nofaktur+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                           n++; 
                        }
                      }
                    else if(idjenisbayar == '3'){
                      for(var j =0; j < fp.length; j++){
                            var html2 = "<tr class='data"+n+"' id='data"+fp[j].v_nomorbukti+"'> <td>"+n+"</td>" +
                                  "<td>"+fp[j].nama+"</td>" +
                                  "<td>"+fp[j].v_nomorbukti+"</td>" +
                                  "<td> - </td>" +            
                                  "<td>"+fp[j].nama_supplier +"</td>"+
                                  "<td> - </td>" +
                                  "<td> - </td>" +
                                  "<td>"+addCommas(fp[j].v_pelunasan)+"</td> ";
                              html2 += "<td><div class='checkbox'> <input type='checkbox' id="+fp[j].v_id+","+fp[j].v_nomorbukti+","+n+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>";
                                          
                           html2 +=  "</tr>"; 
                           tablefaktur.rows.add($(html2)).draw(); 
                           n++; 
                        }
                    }
                   } 
                })
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
    
     var nmr = $('.dataitemfaktur').length;
     var jumlahfaktur = 0;
      
    var nopembayaran = 1;

    //alert(nmr);

     $('#buttongetid').click(function(){
        jenisbayar = $('.jenisbayarheader').val();
        var checked = $(".check:checked").map(function(){
          return this.id;
        }).toArray();

        variabel1 = [];
        variabel1 = checked;
        idfp = [];
        nmrf =[];
        nofaktur = [];
        for(z=0;z<variabel1.length;z++){
          string = variabel1[z].split(",");
          idfp.push(string[0]);
          nofaktur.push(string[1]);
          nmrf.push(string[2]);
        }

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
            

          $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getfaktur',
                  data : {idfp, jenisbayar,nofaktur},
                  type : "post",
                  dataType : "json",
                  success : function(data) {
                   // alert(nmr);
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
                    
                    
                      if(jenisbayar == '2' || jenisbayar == '6' || jenisbayar == '7' || jenisbayar == '9') {
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
                  
                      }
                    console.log(data);
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

                          creditnota = data.faktur[0][0].fp_creditnota;
                          debitnota = data.faktur[0][0].fp_debitnota;
                          alert(debitnota);
                          if(creditnota == null){
                            creditnota = parseFloat(0.00).toFixed(2);
                          }
                          else {
                            creditnota = creditnota;
                          }

                          if(debitnota == null){
                          
                            debitnota = parseFloat(0.00).toFixed(2);
                          }
                          else {
                           
                            debitnota = debitnota;
                          }

                          $('.cnkanan').val(addCommas(creditnota));
                          $('.dnkanan').val(addCommas(debitnota));
                     //LOOPING DATA NO FAKTUR 
                    for(var i = 0 ; i < data.faktur.length; i++){
                        totalpembayaranfp = 0;
                        nmr++;
                        for(var l=0;l<data.pembayaran[i].length;l++){
                            pelunasanfp = data.pembayaran[i][l].fpgdt_pelunasan;
                            if(pelunasanfp != undefined){
                                totalpembayaranfp = parseFloat(parseFloat(totalpembayaranfp) + parseFloat(pelunasanfp)).toFixed(2);
                            }
                        }
                      
                        sisapelunasan = data.faktur[i][0].fp_sisapelunasan;
                       var row = "<tr class='field field"+nmr+"' id='field"+nmr+"' data-id='"+nmr+"'> <td>"+nmr+"</td>" + //nmr
                                 "<td> <a class='nofp nofp"+nmr+"' data-id='"+nmr+"'>"+data.faktur[i][0].fp_nofaktur+" </a><input type='hidden' class='datanofaktur nofaktur"+nmr+"' value="+data.faktur[i][0].fp_nofaktur+" name='nofaktur[]'>  <input type='hidden'   value="+data.faktur[i][0].fp_idfaktur+" name='idfaktur[]'>  </td>"+  //nofaktur
                                  "<td>"+data.faktur[i][0].fp_tgl+" <input type='hidden' class='tgl"+nmr+"' value="+data.faktur[i][0].fp_tgl+"></td>" + //tgl

                                  "<td>"+data.faktur[i][0].fp_jatuhtempo+" <input type='hidden'  value="+data.faktur[i][0].fp_jatuhtempo+" name='jatuhtempo[]'> </td>" + //jatuhtempo

                                  "<td>"+addCommas(data.faktur[i][0].fp_netto)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].fp_sisapelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+addCommas(data.faktur[i][0].fp_netto)+" name='netto[]'> <input type='hidden' class='formtt"+nmr+"' value="+data.faktur[i][0].tt_noform+"> </td>"+ //netto

                                   "<td class='fakturitem"+nmr+"' data-pelunasanfaktur="+addCommas(data.perhitunganfaktur[i])+" data-sisapelunasanfaktur="+addCommas(data.faktur[i][0].fp_sisapelunasan)+"> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>  <input type='hidden' class='sisapelunasan"+nmr+"' value="+addCommas(data.faktur[i][0].fp_sisapelunasan)+"> </td>" +   //pelunasan         

                                    "<td class='pembayarankanan"+nmr+"' data-pembayaranaslifaktur="+addCommas(data.perhitunganfaktur[i])+"> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].fp_idfaktur+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" + //pembayaran


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].fp_sisapelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> <input type='hidden' class='debitnota"+nmr+"' value="+data.faktur[i][0].fp_debitnota+"> <input type='hidden' class='creditnota"+nmr+"' value="+data.faktur[i][0].fp_creditnota+"> </td>" + //sisapelunasan

                                  "<td> <input type='text' class='input-sm form-control keteranganitem"+nmr+"' name='fpgdt_keterangan[]'> </td>" + //
                                 

                                  "<td> <button class='btn btn-danger removes-btn' data-id='"+nmr+"' data-nmrfaktur="+nmrf[i]+" data-faktur="+data.faktur[i][0].fp_nofaktur+" type='button'><i class='fa fa-trash'></i></button> </td>" +
                                  "</tr>";

                            $('.tbl-item').append(row);
                            jumlahfaktur = jumlahfaktur + parseFloat(sisapelunasan);
                            jumlahfakturs = jumlahfaktur.toFixed(2);
                      }
                     

                      tblitem = $('.field').length;
                      console.log('tblitem2' + tblitem);
                       arrnofaktur = [];
     
                      var nmr2 = 1;
                      for(var z =0; z < tblitem; z++ ){
                        val = $('.nofaktur'+nmr2 ).val();
                        console.log(val + 'val');
                        nmr2++;
                         arrnofaktur.push(val);
                      }
                       console.log(arrnofaktur + 'arrnofaktur2');
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

                                  "<td> <input type='text' class='input-sm form-control keteranganitem"+nmr+"' name='fpgdt_keterangan[]'> </td>" +

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
                          
                          $('.sisatrbyr').val(addCommas(data.faktur[0][0].um_pelunasan));
                          $('.sisafaktur').val(addCommas(data.faktur[0][0].um_pelunasan));
                          $('.pelunasan').attr('readonly' , false);
                          $('.jmlhfaktur').val(addCommas(data.faktur[0][0].um_jumlah));
                      


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

                                  "<td>"+addCommas(data.faktur[i][0].um_jumlah)+" <input type='hidden' class='sisapelunasan"+nmr+"' value="+data.faktur[i][0].um_pelunasan+"> </td> <input type='hidden' class='netto"+nmr+"' value="+data.faktur[i][0].um_jumlah+" name='netto[]'> </td>"+ //netto

                                   "<td> <input type='text' class='input-sm pelunasanitem pelunasan"+nmr+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pelunasan[]'>   </td>" +   //pelunasan         

                                   "<td> <input type='text' class='input-sm pembayaranitem pembayaranitem"+data.faktur[i][0].um_id+" form-control' style='text-align:right' readonly data-id="+nmr+" name='pembayaran[]' value="+addCommas(totalpembayaranfp)+"> </td>" +


                                  "<td> <input type='text' class='input-sm form-control sisa_terbayar"+nmr+" data-id="+nmr+"' value="+addCommas(data.faktur[i][0].um_pelunasan)+" readonly name='sisapelunasan[]' style='text-align:right'> </td>" + //sisapelunasan

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
					
					
					
              $('.nofp').click(function(){

                tempnofp = tempnofp + 1;
                id = $(this).data('id');
                $('.id').val(id);
                $('.keteranganitem' + id).attr('readonly' , false);
            
                //NILAI DI DALAM TABLE
                sisapelunasan =   $('.sisapelunasan' + id).val();
                sisaterbayar =   $('.sisa_terbayar' + id).val();
                netto = $('.netto' + id).val();
                
                jenisbayar = $('.jenisbayar').val();
                if(jenisbayar == '2' || jenisbayar == '6' || jenisbayar == '7' || jenisbayar == '9'){
                    creditnota = $('.creditnota' + id).val();
                    debitnota = $('.debitnota' + id).val();

                    if(creditnota == 'null'){
                      creditnota = parseFloat(0.00).toFixed(2);
                    }
                    else {
                      creditnota = creditnota;
                    }

                    if(debitnota == 'null'){
                      debitnota = parseFloat(0.00).toFixed(2);
                    }
                    else {
                      debitnota = debitnota;
                    }
                    
                    $('.dnkanan').val(addCommas(debitnota));
                    $('.cnkanan').val(addCommas(creditnota));
                     cnkanan2 = $('.cnkanan').val();
                  cnkanan =   cnkanan2.replace(/,/g, '');
                  dbkanan2 = $('.dnkanan').val();
                  dbkanan = dbkanan2.replace(/,/g, '');
                }

                //NILAI DI HEADER
                $('.pelunasan').attr('readonly' , false);
                $('.jmlhfaktur').val(addCommas(netto));
            

                pembayaranheader = $('.pembayaranitem' + id).val();
                var pembayaranasli = $('.pembayarankanan' + id).data('pembayaranaslifaktur');

                sisaterbayarheader = $('.sisatrbyr').val();
                jumlahpelunasan = 0;

                //CEK SAMA ATO ENGGAK
                pelunasanitem = $('.pelunasan' +id).val();
                var nilaiaslipelunasan = $('.fakturitem' + id).data('sisapelunasanfaktur');
                var pelunasanasli = $('.fakturitem' + id).data('pelunasanfaktur');
              //  hasilpelunasan = $('.pelunasan' + id).val();

          /*        hasilpelunasan2 =  hasilpelunasan.replace(/,/g, '');
                sisapelunasan2 =  sisapelunasan.replace(/,/g, '');
                pembayaranheader2 = pembayaranheader.replace(/,/g, '');
          */        

                nilaiaslipelunasan2 = nilaiaslipelunasan.replace(/,/g,'');
                pelunasanasli2 = pelunasanasli.replace(/,/g,'');
                pembayaranasli2 = pembayaranasli.replace(/,/g,'');

                //pembayaran
                pengurangan = parseFloat(parseFloat(pembayaranasli) - parseFloat(nilaiaslipelunasan)).toFixed(2);

                //pembayaran
               
                 tmbhnpelunasan = parseFloat(parseFloat(nilaiaslipelunasan2) + parseFloat(pelunasanasli2)).toFixed(2); 
                 penguranganpembayaran = parseFloat(parseFloat(pembayaranasli2)- parseFloat(pelunasanasli2)).toFixed(2);

             
                // alert(nilaiaslipelunasan);
                // alert(pelunasanasli);
                 $('.sisatrbyr').val(addCommas(tmbhnpelunasan));
                 $('.pembayaran').val(addCommas(penguranganpembayaran));         
                 $('.sisafaktur').val(addCommas(tmbhnpelunasan));

              
                nofaktur = $('.nofaktur' + id).val();
                tgl = $('.tgl' + id).val();
                jatuhtempo = $('.jatuhtempo' + id).val();
                formtt = $('.formtt' + id).val();


                 $('.nofaktur').val(nofaktur);
               /*  $('.tgl').val(tgl);*/
                 $('.jatuhtempo').val(jatuhtempo);
                 $('.formtt').val(formtt);



                  $sisaterbayar2 = $('.sisatrbyr').val();
                  $sisaterbayar = $sisaterbayar2.replace(/,/g, '');
                 

                  $('.sisafaktur').val(addCommas(tmbhnpelunasan));


              })

               //removes nofaktur di ajax 
               $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    var nofaktur = $(this).data('faktur');
                    
                     

                   // toastr.info('nmr');
                    parent = $('#field'+id);
                     
                    //parents = $('.field')
                    pelunasan = $('.pelunasan' + id).val();
                    hslpelunasan =  pelunasan.replace(/,/g, '');
                    totalbayar = $('.totbayar').val();
                    hsltotalbayar = totalbayar.replace(/,/g, '');

                    $('tr.data'+nmrfaktur).show();

                     index = arrnofaktur.indexOf(nofaktur);
                      arrnofaktur.splice(index, 1);

                    dikurangi = parseInt(hsltotalbayar) - parseInt(hslpelunasan);
                    dikurangi = dikurangi.toFixed(2);
                   $('.sisafaktur').val('');
                   $('.sisatrbyr').val('');
                   $('.jmlhfaktur').val('');
                    $('.pelunasan').val('');
               
                  
                     
                  

                    $('.totbayar').val(addCommas(dikurangi));
                    $('.nominal').val(addCommas(dikurangi));
                    parent.remove();


                })
              }
          })
        
     })
  

    var tempnofp = 0;
    //EDIT DI LUAR FAKTUR 
    $('.nofp').click(function(){
        tempnofp = tempnofp + 1;
        id = $(this).data('id');
        $('.id').val(id);
        $('.keteranganitem' + id).attr('readonly' , false);

        //NILAI DI DALAM TABLE
        sisapelunasan =   $('.sisapelunasan' + id).val();
        sisaterbayar =   $('.sisa_terbayar' + id).val();
        netto = $('.netto' + id).val();
      
    

        //NILAI DI HEADER
        $('.pelunasan').attr('readonly' , false);
        $('.jmlhfaktur').val(addCommas(netto));
    

        pembayaranheader = $('.pembayaranitem' + id).val();
        var pembayaranasli = $('.pembayarankanan' + id).data('pembayaranaslifaktur');
       // alert(pembayaranasli);
        sisaterbayarheader = $('.sisatrbyr').val();
        jumlahpelunasan = 0;

        //CEK SAMA ATO ENGGAK
        pelunasanitem = $('.pelunasan' +id).val();
        var nilaiaslipelunasan = $('.fakturitem' + id).data('sisapelunasanfaktur');
        var pelunasanasli = $('.fakturitem' + id).data('pelunasanfaktur');
      //  hasilpelunasan = $('.pelunasan' + id).val();

/*        hasilpelunasan2 =  hasilpelunasan.replace(/,/g, '');
        sisapelunasan2 =  sisapelunasan.replace(/,/g, '');
        pembayaranheader2 = pembayaranheader.replace(/,/g, '');
*/        

        nilaiaslipelunasan2 = nilaiaslipelunasan.replace(/,/g,'');
        pelunasanasli2 = pelunasanasli.replace(/,/g,'');
        pembayaranasli2 = pembayaranasli.replace(/,/g,'');

        //pembayaran
        pengurangan = parseFloat(parseFloat(pembayaranasli) - parseFloat(nilaiaslipelunasan)).toFixed(2);

        //pembayaran

         tmbhnpelunasan = parseFloat(parseFloat(nilaiaslipelunasan2) + parseFloat(pelunasanasli2)).toFixed(2); 
         penguranganpembayaran = parseFloat(parseFloat(pembayaranasli2)- parseFloat(pelunasanasli2)).toFixed(2);

        // alert(nilaiaslipelunasan);
        // alert(pelunasanasli);
     
         $('.sisatrbyr').val(addCommas(tmbhnpelunasan));
         $('.pembayaran').val(addCommas(penguranganpembayaran));         
         $('.sisafaktur').val(addCommas(tmbhnpelunasan));

        
        nofaktur = $('.nofaktur' + id).val();
        tgl = $('.tgl' + id).val();
        jatuhtempo = $('.jatuhtempo' + id).val();
        formtt = $('.formtt' + id).val();


         $('.nofaktur').val(nofaktur);
       /*  $('.tgl').val(tgl);*/
         $('.jatuhtempo').val(jatuhtempo);
         $('.formtt').val(formtt);

               $jumlahdebit = 0;
                  $('.dnbruto').each(function(){
                    val = $(this).val();
                  //  alert(val + 'val');
                    $jumlahdebit = parseFloat(parseFloat($jumlahdebit) + parseFloat(val)).toFixed(2);
                  });

                 // alert($jumlahdebit);
                  $('.dnkanan').val(addCommas($jumlahdebit));

                  $jumlahkredit = 0;
                  $('.cnbruto').each(function(){
                    val = $(this).val();
                    $jumlahkredit = parseFloat(parseFloat($jumlahkredit) + parseFloat(val)).toFixed(2);
                    $sisafaktur2 = $('.sisafaktur').val();  
                  })

               
                  $('.cnkanan').val(addCommas($jumlahkredit));


                  $sisaterbayar2 = $('.sisatrbyr').val();
                  $sisaterbayar = $sisaterbayar2.replace(/,/g, '');
                  cnkanan2 = $('.cnkanan').val();
                  cnkanan =   cnkanan2.replace(/,/g, '');
                  dbkanan2 = $('.dnkanan').val();
                  dbkanan = dbkanan2.replace(/,/g, '');

       })
              //removes no faktur
               $(document).on('click','.removes-btn',function(){
                    var id = $(this).data('id');
                    var nofaktur = $(this).data('faktur');
                    var nmrfaktur = $(this).data('nmrfaktur');
                   // toastr.info('nmr');
                    parent = $('#field'+id);
                    

                     var idfpgdt = $(this).data('idfpgdt');
                    var idfp = $(this).data('idfp');

                    //parents = $('.field')
                    pelunasan = $('.pelunasan' + id).val();
                    hslpelunasan =  pelunasan.replace(/,/g, '');
                    totalbayar = $('.totbayar').val();
                    hsltotalbayar = totalbayar.replace(/,/g, '');

                    $('tr.data'+nmrfaktur).show();

                     index = arrnofaktur.indexOf(nofaktur);
                      arrnofaktur.splice(index, 1);

                    dikurangi = parseInt(hsltotalbayar) - parseInt(hslpelunasan);
                    dikurangi = dikurangi.toFixed(2);
                   $('.sisafaktur').val('');
                   $('.sisatrbyr').val('');
                   $('.jmlhfaktur').val('');
                    $('.pelunasan').val('');
               
                  
                     
                  

                    $('.totbayar').val(addCommas(dikurangi));
                    $('.nominal').val(addCommas(dikurangi));
                    parent.remove();

                 
                })


      $('.nocheck').click(function(){
      //  alert('hei');
         id = $('.mbid').val();
        
         //alert('hai');
          $.ajax({
              type : "post",
              data : {id},
              url : baseUrl+'/formfpg/getkodeakun',
              dataType : 'json',
              success : function (response){
              
                  table = response.table;
              //    alert(response);
                //  toastr.info(response);
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

     nomrbnk = $('#tbl-bank').length;
     arrnohapus = [];
    $('#buttongetcek').click(function(){
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
        nofaktur = [];

        for(z=0;z<mbid.length;z++){
          string = mbid[z].split(",");
          idmb.push(string[0]);    
          nobank.push(string[1]);
        }
        syaratkredit =  $('.syaratkreditsupplier').val();

        for(var z=0; z <nobank.length; z++){
          $('tr#datacek'+nobank[z]).hide();
        }

         $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getakunbg',
                  data : {idmb},
                  type : "post",
                  dataType : "json",
                  success : function(data) {
                     $('#myModal2').modal('hide');

                     $('.checkcek').attr('checked' , false);

                    $('.nocheck').val(data.mbdt[0][0].mbdt_noseri);

                    nominalbank = $('.nominal').val();
                    nofpg = $('.nofpg').val();
                    tgl = $('.tgl').val();
                    mbdt = data.mbdt;
                    jatuhtempo = $('.jatuhtempoitem').val();

                  

                 
                    for(var i =0 ; i < mbdt.length; i++ ){  
                       nomrbnk++;
                      var row = "<tr id='datas"+nomrbnk+"' class='tblbank databank' data-id='"+nomrbnk+"'> <td>"+nomrbnk+"</td>  <td>"+nofpg+"</td>" + // NO FPG
                      "<td>  <a class='noseri'  data-id='"+nomrbnk+"'> "+mbdt[i][0].mbdt_noseri+ "</a> <input type='hidden' class='noseri"+nomrbnk+"' value='"+mbdt[i][0].mbdt_noseri+"' name='noseri[]'></td>"+ // NOSERI

                      "<td>"+tgl+"</td>"+ // TGL
                      "<td>"+mbdt[i][0].mb_kode+"</td> <td> <input type='text' class='form-control jatuhtempotblbank' value='"+jatuhtempo+"' readonly> </td>" + //JATUH TEMPO
                      "<td> <input type='text' data-id='"+nomrbnk+"' class='input-sm form-control nominaltblbank nominalbank"+nomrbnk+" nominalcheck"+mbdt[i][0].mbdt_noseri+"' readonly name='nominalbank[]' style='text-align:right' required > </td>" + //NOMINAL
                      "<td> <button class='btn btn-danger remove-btn' data-id='"+nomrbnk+"'  data-idbankdt="+mbdt[i][0].mbdt_id+" type='button'><i class='fa fa-trash'></i></button></td> </tr>";

                      $('#tbl-bank').append(row);
                      arrnohapus.push(nomrbnk);
                      $('.jatuhtempotblbank').val(jatuhtempo);
                    }

/*                    $('.nominalbank1').val(nominalbank);
                    $('.ChequeBg').val(nominalbank);
*/                   

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
                            //   alert(nominalbank);
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
                      }) //END REMOVE

                      $('.noseri').click(function(){

                        val = $(this).val();
                        id = $(this).data("id");
                       // alert(id)
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
    


      
    //REMOVE NO SERI
     $(document).on('click','.remove-btn',function(){
        //  alert('nomrbnk');
            nohapus = nomrbnk - 1;
           // alert(nohapus);
            var id = $(this).data('id');
            var kodebank = $(this).data('kodebank');
            var noseri = $(this).data('noseri');
            var idfpgb = $(this).data('idfpgb');
            var mbid = $(this).data('idbankdt');

            if(id == 1) {
              $('.nocheck').val('');
              $('.nominal').val('');
              $('.jthtmpo_bank').val('');
              $('.hari_bank').val('');
            }

            lengthbank = $('.databank').length;
        

            if(id == 1){
              if(lengthbank.length == 2){
               //  alert(nominalbank);
             //   nominaltblbank = $('.nominalbank'+arrnohapus[0]).val();
                noseritblbank = $('.noseri'+arrnohapus[1]).val();
                $('.nominal').val(nominalbank);
                $('.nocheck').val(noseritblbank);
              }
              else {
                for(var j = 0; j < lengthbank.length; j++){
                  nominaltblbank = $('.nominalbank'+arrnohapus[j]).val();
                  noseritblbank = $('.noseri'+arrnohapus[j]).val();
                  $('.nominal').val(nominaltblbank);
                  $('.nocheck').val(noseritblbank);
                  
                 }
              }
              
            }


            
            parent = $('tr#datas'+id);
            $('tr#datacek'+id).show();
            nominalbank = $('.nominalbank' + id).val();


            var totbayar = $('.totbayar').val();

            $('.ChequeBg').val(totbayar);

            lengthtblbank = $('.nominaltblbank').length;

            lengthunthapus = lengthtblbank - 1;
        //    alert(lengthunthapus);
            totalbayar2 = totbayar.replace(/,/g, '');
         /*   pembagian = totalbayar2 / lengthunthapus;
            
            $('.nominaltblbank').val(pembagian);*/

           /*$('.nominaltblbank').each(function(){
             id = $(this).data('id');
              alert(id);
              alert(pembagian);
             $('nominalbank' + id).val(addCommas(pembagian));
           })*/
          
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
              
             totbar = $('.totbayar').val();
             cek = $('.ChequeBg').val();
            // alert('test');
             if(totbar != cek){
                toastr.info('Jumlah Total Bayar , tidak sama dengan Jumlah Bayar Mohon di lengkapi form input, lalu simpan data anda :) ');
                 $('html,body').animate({scrollTop: $('.ChequeBg').offset().top}, 200, function() {
                
                    $('.ChequeBg').focus();
                   
                });
             }

            parent.remove();

        })

    //CLICK NO SERI
     $('.noseri').click(function(){
     
        val = $(this).val();
        id = $(this).data("id");
  
        var noseri =  $('.noseri' + id).val();
       // alert(noseri);
       // alert(id);
  
        $('.nocheck').val(noseri);
        $('.idbank').val(id);
        nominaltbl =  $('.nominalbank' + id).val();
        nominalheader = $('.nominal').val();
  
        jatuhtempo = $('.jatuhtempo' + id).val();
        $('.jthtmpo_bank').val(jatuhtempo);
        $('.hari_bank').val(jatuhtempo);

        $('.nominal').val(nominaltbl);

      })
      

     //bank
     $('.bank').change(function(){
       val = $(this).val();
      string = val.split(",");
      namabank = string[1];
      alamat = string[2];
      account = string[3];
      id = string[0];
      kodebank = string[4];

      $('.valbank').val(val);
      $('.nmbank').val(namabank);
      $('.cbgbank').val(alamat);
      $('.account').val(account);
      $('.kodebankbg').val(string[4]);
      $('.mbid').val(id);
      $('.kodebank').val(kodebank);

      $.ajax({
          type : "post",
          data : {id},
          url : baseUrl+'/formfpg/getkodeakun',
          dataType : 'json',
          success : function (response){
            $('.databank').val(id);
            $('.bankasaldetail').val(val);
            table = response.table;
            console.log(table);

          var tablecek = $('#tbl-cheuque').DataTable();
          tablecek.clear().draw();
            var nmrbnk = 1;
            for(var i = 0; i < table.length; i++){                                   
                var html2 = "<tr class='bank"+nmrbnk+"' id='datacek"+nmrbnk+"'> <td>"+nmrbnk+"</td>  <td>"+table[i].mb_kode+"</td>  <td>"+table[i].mb_nama+"</td>"+
                            "<td>"+table[i].mbdt_noseri+"</td>"; 

                    html2 += "<td><div class='checkbox'> <input type='checkbox' id="+table[i].mbdt_id+","+nmrbnk+" class='checkcek' value='option1' aria-label='Single checkbox One'>" +
                  "<label></label>" +
                  "</div></td>";
                                
                 html2 +=  "</tr>"; 
                 tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }    
          }

     })

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

        $.ajax({ //AJAX
                  url : baseUrl + '/formfpg/getjenisbayar',
                  data : {idjenis},
                  type : "get",
                  dataType : "json",
                  success : function(data) {
                    var response = data['isi'];
                    
                    if(idjenis == '2'){  
                      $('.jenisbayar2').empty();                   
                      for(var j=0; j<response.length; j++){  
                                    
                         $('.jenisbayar2').append("<option value="+response[j].idsup+">"+response[j].no_supplier+" - "+response[j].nama_supplier+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      }                     
                    }   
                    else if(idjenis == '6'){
                       $('.jenisbayar2').empty();  
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      } 
                    }
                    else if(idjenis == '7'){
                       $('.jenisbayar2').empty();  
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }

                  }
        })


       
            
            

      if(idjenis == '2') { // HUTANG DAGANG SUPPLIER
        $('.tbl-jenisbayar').show();
        $('.deskirpsijenisbayar').hide();
        $("#jurnal").show(); 
        $('#detailbayar').attr('disabled' , false);
        
            


      }
      if(idjenis == '1') { // GIRO / KAS KECIL
        $('#detailbayar').attr('disabled' , false);
        $('.tbl-jenisbayar').hide();
        $('.deskirpsijenisbayar').show();
        $("#jurnal").show(); 
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
      }

      if(idjenis == '5'){ // TRANSFER KAS BANK
          $('#tab-1').removeClass("active");
          $('#detailbayar').attr('disabled' , true);
          $('#tab-2').addClass("active");     
          $("#jurnal").hide();  
          $('.tbl-jenisbayar').hide();
            $('.deskirpsijenisbayar').show();

          rowTransfer =  "<table class='table table-bordered table-striped'> " +
                            "<tr>" +
                              "<th> Keterangan </th>" +
                              "<td> <input type='text' class='form-control' name='keterangantransfer'> </td>" + 
                            "</tr>" +
                          "</table>";
                       

                      $('.deskirpsijenisbayar').html(rowTransfer);
      }
      if(idjenis == '6'){ // biaya penerus agen
        $('#detailbayar').attr('disabled' , false);
        

        rowSupplier = "<div class='col-xs-6'>" +
                          "<table class='table table-bordered table-striped'>" +
                            "<tr>" +
                              "<th> Kode Agen </th>" +
                              "<td> <select class='form-control  chosen-select-width  agen'> </select>";
           rowSupplier +=    "</td> </tr>" +
                            "<tr>" +
                              "<th> Keterangan </th>" +
                              "<td> <input type='text' class='form-control'></td>"
                            "</tr>"+
                          "</table>" +
                        "</div>";

      //  $('.deskirpsijenisbayar').html(rowSupplier);
          
      }

    })
    
    //NOMINAL BANK
    arrnominal = [];
    $('.nominal').change(function(){
    
       idbank = $('.idbank').val();
      


       dataidbank = []; 
       dataidbank = $('.databank').data('id');
      // alert(dataidbank);


       val = $(this).val();
      
       val = accounting.formatMoney(val, "", 2, ",",'.');
       $(this).val(val);
      // alert(val);

       if(idbank != ''){
          $('.nominalbank' + idbank).val(val);
          totalbayar = $('.totbayar').val();
          aslitotal = totalbayar.replace(/,/g, '');
       }
       else {
          nocheck = $('.nocheck').val();
         $('.nominalcheck'+ nocheck).val(val);
       }

      // alert(val);

        var jmlhnominal = 0;
        $('.nominaltblbank').each(function(){
           nocheck = $('.nocheck').val();
          totalbayar = $('.totbayar').val();
          aslitotal = totalbayar.replace(/,/g, '');
          id = $(this).data('id');
          val = $(this).val();
           
           val2 = val.replace(/,/g, '');
       //  alert(val2);
          if(val2 != ''){
            jmlhnominal += parseFloat(val2);
           
          }
         
        })
         totalbayar = $('.totbayar').val();
          aslitotal = totalbayar.replace(/,/g, '');
      
        if(jmlhnominal > aslitotal){

           toastr.info('Angka yang di inputkan lebih dari Total Bayar :) ');
             $('.nominalcheck'+ nocheck).val('');
             $('.nominal').val('');

        }
        else {

           val3 = parseFloat(jmlhnominal);
           val4 = jmlhnominal.toFixed(2);
        //   alert('masukcekbg');
           $('.ChequeBg').val(addCommas(val4));
        }

      

       
    })

    //PELUNASAN

    $('.pelunasan').change(function(){
      vals = $(this).val(); 
 
      formatval = accounting.formatMoney(vals, "", 2, ",",'.');

      id = $('.id').val();
      sisa_terbayar = $('.sisatrbyr').val();
      replace_harga = sisa_terbayar.replace(/,/g, '');
      
      pembayaran = $('.pembayaran').val();

      $(this).val(formatval);
      vas = $(this).val();
      
      jumlahfaktur = $('.jmlhfaktur').val();
      replacefaktur = jumlahfaktur.replace(/,/g,'');

      totalpelunasan = 0;
      $('.datapelunasan').each(function(){
        val = $(this).val();
        totalpelunasan = parseFloat(totalpelunasan) + parseFloat(val);
      })

      jmlhyangkurang = parseFloat(replacefaktur) - parseFloat(totalpelunasan);

      if(id == ''){ //PERTAMA KALI INPUT

         valpelunasan = vas.replace(/,/g, '');

      
        if(parseFloat(valpelunasan) > parseFloat(jmlhyangkurang)){
            alert(valpelunasan);
            alert(jmlhyangkurang);
                toastr.info('Mohon angka yang di masukkan, kurang dari sisa terbayar :) ');
                  $(this).val('');
           
        }
        else {
          hasil = parseFloat(replace_harga - valpelunasan);
          hasil = hasil.toFixed(2);
          sisafaktur = $('.sisafaktur').val(addCommas(hasil));

          $('.pelunasan' + nmr).val(formatval);
          $('.sisa_terbayar' + nmr).val(addCommas(hasil));
          $('.pembayaranitem' + nmr).val(pembayaran);
        }
      } //END PERTAMAKALI INPUT
      else {
          
          valpelunasan = vas.replace(/,/g, '');

        if(parseFloat(valpelunasan) > parseFloat(jmlhyangkurang)){

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
          $('.sisafaktur').val();
          $('.pembayaranitem' + id).val(pembayaran);
        }
      }
        jumlahpelunasan = 0;
       $('.pelunasanitem').each(function(){
              
     //   alert('hore');

              id = $(this).data('id');
             // toastr.info(id);
              val3 = $('.pelunasan' + id).val();        
            // toastr.info(val + 'val');
              replace_harga = val3.replace(/,/g, '');

              console.log(val3 + 'ana');
              console.log(id + 'ana');
              console.log(replace_harga + 'ana');
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
               // alert(jumlahpelunasan2);
               // alert(nominal);
                //$('.nominal').val('ana');
                $('.nominal').val(addCommas(jumlahpelunasan2));
              }
             
            })


    });

   

</script>
@endsection


