@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
  .disabled {
    pointer-events: none;
    opacity: 1;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Bank </h2>
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
                            <strong> Detail Pelunasan Hutang / Pembayaran Bank </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <br>
    <form method="post" action="{{url('pelunasanhutangbank/update')}}"  enctype="multipart/form-data" class="form-horizontal" id="formfpg">

    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Pelunasan Hutang / Pembayaran Bank
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
            
                      <div class="text-right">
                       <a class="btn btn-default" aria-hidden="true" href="{{ url('pelunasanhutangbank/pelunasanhutangbank')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
                    </div>  
               
                </div>

                <div class="ibox-content">
                <div class="row">
                   <div class="col-xs-12">
                        
    @if(count($jurnal_dt)!=0)
                      <div class="pull-right">  
                     
                          <a onclick="lihatjurnal('{{$data['bbk'][0]->bbk_nota}} or null}}','POSTING BANK')" class="btn-xs btn-primary" aria-hidden="true">
                    
                            <i class="fa  fa-eye"> </i>
                             &nbsp;  Lihat Jurnal  
                           </a> 
                      </div>
    @endif


              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0" class="table table-stripped">

                          <tr>
                            <td> 
                              Cabang
                            </td>
                            <td>
                              <select class="chosen-select-width form-control cabang" name="cabang">
                                  @foreach($data['cabang'] as $cabang)
                                  <option value="{{$cabang->kode}}" @if($data['bbk'][0]->bbk_cabang == $cabang->kode) selected @endif disabled="">
                                    {{$cabang->nama}}
                                  </option>
                                  @endforeach
                              </select>
                            </td>
                          </tr>

                          <tr>
                            <td width="150px">
                          No BBK
                            </td>
                            <td>
                             <input type="text" class="input-sm form-control nobbk" readonly="" name="nobbk" value='{{$data['bbk'][0]->bbk_nota}}'>
                              <input type="hidden" class="input-sm form-control" readonly="" name="bbkid" value='{{$data['bbk'][0]->bbk_id}}'>
                              <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                            </td>
                          </tr>

                          <tr>
                            <td> Kode Bank </td>
                            <td>
                              <select class="form-control " name="kodebank">
                                @foreach($data['bank'] as $bank)
                                  <option value="{{$bank->mb_id}}" @if($data['bbk'][0]->bbk_kodebank == $bank->mb_id) selected="" @endif disabled>  {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                @endforeach
                              </select>
                              <input type="hidden" class="kodebank" name='idbank' value="{{$data['bbk'][0]->bbk_kodebank}}">
                             </td>
                          </tr>

                          <tr>
                            <td> Tanggal </td>
                            <td>  <div class="input-group date" >
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tglbbk" value="{{$data['bbk'][0]->bbk_tgl}}">
                              </div> </td>
                            </td>
                          </tr>
                          </table>
                      </div>

                        <div class="col-xs-6">
                          <table border="0" class="table">
                            <tr>
                              <td width="150px">
                              Cek / BG
                              </td>
                              <td>
                               <input type="text" class="input-sm form-control cekbg" readonly="" style='text-align:right;' name="totalcekbg" value="{{ number_format($data['bbk'][0]->bbk_cekbg, 2) }}">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Biaya
                              </td>
                              <td>
                              <input type="text" class="form-control totalbiaya" readonly="" style='text-align: right' name="totalbiaya" value="{{ number_format($data['bbk'][0]->bbk_biaya, 2) }} " readonly="">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Total
                              </td>
                              <td>
                                <input type="text" class="form-control total" readonly="" style='text-align:right;'' name="total" value="{{ number_format($data['bbk'][0]->bbk_total, 2) }}" readonly="">
                              </td>
                            </tr>

                          <tr>
                            <td>Keterangan </td>
                            <td> <input type="text" class="input-sm form-control edit" name="keteranganheader" value="{{$data['bbk'][0]->bbk_keterangan}}">  </td>
                            <td> <input type="hidden" class="input-sm form-control flag" name="flag" value="{{$data['bbk'][0]->bbk_flag}}" readonly="">   </td>
                          </tr>
                          </table>
                        </div>


                      </div>
                      </div>

              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

                </div>
            </div>
        </div>
    </div>

        <div class="row">
           <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <table  border="0">
                    <tr>
                      <th>
                        <h5> Detail Cek /  BG  </h5>  
                    </th>
                    
                    <td> &nbsp; </td>

                    <th>
                        <button class="btn btn-xs btn-warning ubahdata" type="button">
                        <i class="fa fa-pencil"> </i> &nbsp; Ubah Data
                        </button>
                    </th>
                    </tr>
                    </table>
                     
                </div>



                 <div class="ibox-content">
                   <div class="row">
                      <div class="col-xs-12">
                      <div class="box">
                        <div class="box-header">
                        </div>

                        <div class="box-body">

                            <!--tab-->                            
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="tabs-container">
                                      <ul class="nav nav-tabs">
                                          <li class="active" id="tabcekbg"><a data-toggle="tab" href="#tab-1"> Detail Cek / BG </a></li>
                                          <li class="" id="tabbiaya"><a data-toggle="tab" href="#tab-2"> Biaya - Biaya </a></li>
                                      </ul>
                                      <div class="tab-content">
                                          <div id="tab-1" class="tab-pane active">
                                              <div class="panel-body">
                                                 
                                                 <button class='btn btn-sm btn-info tmbhdatacek' data-toggle="modal" data-target="#myModalCekBg" type="button">  <i class="fa fa-plus"> </i> Tambah Data Cek / BG </button>


                                                   <div class="col-sm-12">
                                                    <table class='table table-stripped table-bordered' id="tbl-hasilbank">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th>
                                                        <th> Tgl FPG </th>
                                                        <th> No Transaksi </th> 
                                                        <th> Jatuh Tempo </th>
                                                        <th> Acc Bank </th>
                                                        <th> Nominal </th>
                                                        <th> Supplier </th>
                                                        <th> Keterangan </th>  
                                                        <th> Aksi </th>    
                                                      </tr>
                                                        @if($data['bbk'][0]->bbk_flag == 'CEKBG')
                                                      
                                                        @for($i=0; $i < count($data['bbkd']) ; $i++)
                                                        
                                                        <tr class=data-{{$i}} id="hslbank">
                                                         <td> {{$i + 1}} </td>
                                                         <td> <input type="text" class="form-control input-sm" value="{{$data['bbkd'][$i]->bbk_nota}}" name="nofpg[]" readonly=""> <input type="hidden" class="form-control input-sm" value="{{$data['bbkd'][$i]->bbkd_idfpg}}" name="idfpg[]" readonly="">  </td>
                                                         <td> <input type="text" class="form-control input-sm" value="{{ Carbon\Carbon::parse($data['bbkd'][$i]->bbkd_tglfpg)->format('d-M-Y ') }}" name="tgl[]" readonly="">  </td>
                                                         <td> <input type="text" class="form-control input-sm" value="{{$data['bbkd'][$i]->bbkd_nocheck}}" name="notransaksi[]" readonly="">  </td>
                                                         <td> <input type="text" class="form-control" name="jatuhtempo[]" readonly="" value="{{ Carbon\Carbon::parse($data['bbkd'][$i]->bbkd_jatuhtempo)->format('d-M-Y ') }}"> </td>
                                                         <td> <input type="text" class="form-control input-sm" name="idbank[]" value="{{$data['bbkd'][$i]->mb_kode}}" readonly=""> </td>
                                                         <td style="text-align: right"> <input type="text" class="form-control input-sm nominal2" value=" {{ number_format($data['bbkd'][$i]->bbkd_nominal, 2) }}" name="nominal[]" readonly=""> </td>
                                                         @if($data['bbkd'][$i]->bbkd_jenissup == 'supplier')
                                                          <td> <input type="text" class="form-control input-sm" value="{{$data['bbkd'][$i]->nama_supplier}}"  readonly="">  <input type="hidden" class="form-control input-sm" value="{{$data['bbkd'][$i]->no_supplier}}" name="supplier[]" readonly=""> </td>
                                                         @else
                                                           <td> <input type="text" class="form-control input-sm" value="{{$data['bbkd'][$i]->nama}}"  readonly=""> <input type="hidden" class="form-control input-sm" value="{{$data['bbkd'][$i]->kode}}" name="supplier[]" readonly="">  </td>
                                                         @endif
                                                        
                                                         <td> <input type="hidden" class="form-control input-sm" value="{{$data['bbkd'][$i]->bbkd_jenissup}}" name="jenissup[]" readonly="">  <input type="text" class="form-control input-sm" value="{{$data['bbkd'][$i]->bbkd_keterangan}}" name="keterangan[]" readonly=""> </td>
                                                         <td> <button class="btn btn-danger btn-sm removes-btn" type="button" data-id={{$i}} data-cek="{{$data['bbkd'][$i]->bbkd_nocheck}}" data-nominal="{{ number_format($data['bbkd'][$i]->bbkd_nominal, 2) }}"><i class="fa fa-trash"></i></button>  </td>
                                                        </tr>
                                                        
                                                        @endfor
                                                      @endif
                                                    </table>
                                                   </div>

                                              </div>
                                          </div>
                                          <div id="tab-2" class="tab-pane">
                                              <div class="panel-body">
                                                     <button class='btn btn-sm btn-info tambahdatabiaya' data-toggle="modal" data-target="#myModalBiaya" type="button">  <i class="fa fa-plus"> </i> Tambah Data Biaya </button>

                                                   <div class="col-sm-12">
                                                    <table class='table table-stripped table-bordered' id="tbl-biaya">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th> 
                                                        <th> Acc Bank </th>
                                                        <th> D / K </th>
                                                        <th> Nominal </th>
                                                        <th> Keterangan </th>
                                                     <!--    <th> Aksi </th> -->
                                                      </tr>
                                                      @if($data['bbk'][0]->bbk_flag == 'BIAYA')
                                                      @foreach($data['bbkd'] as $index=>$bbkd)
                                                      <tr id="hslbiaya" class="databiaya transaksi{{$index + 1}}" data-biaya="{{$bbkd->bbkb_akun}}">
                                                        <td> {{$index + 1}} </td>
                                                        <td> <input type="text" class="form-control input-sm" value="{{$bbkd->bbk_nota}}" readonly=""> </td>
                                                        <td> <input type="text" class="form-control input-sm" value="{{$bbkd->nama_akun}}"  readonly=""> <input type='hidden' name="akun[]" value="{{$bbkd->bbkb_akun}}"> </td>
                                                        <td> <input type="text" class="form-control input-sm" value="{{$bbkd->bbkb_dk}}" name="dk[]" readonly=""> </td>

                                                        <td style='text-align: right'> <input type="text" class="form-control input-sm nominalbiaya" value="{{ number_format($bbkd->bbkb_nominal, 2) }}" name="jumlah[]" style="text-align: right"> </td>

                                                        <td> <input type="text" class="form-control" value="{{$bbkd->bbkb_keterangan}}" name="keterangan[]"> </td>

                                                        <td> <button class='btn btn-danger btn-sm remove-btn' type='button' data-id="{{$index + 1}}" data-cek='"{{$bbkd->bbkb_akun}}"' data-nominal="{{ number_format($bbkd->bbkb_nominal, 2) }}"><i class='fa fa-trash'></i></button> </td>
                                                      </tr>
                                                      @endforeach
                                                      @endif
                                                    </table>
                                                   </div>
                                              </div>
                                          </div>
                                      </div>


                                  </div>
                              </div>
                             
                          </div>
                          <br>
                          <br>

                          <!-- modal jurnal -->
                          <div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content no-padding">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No PO:  <u> {{$data['bbk'][0]->bbk_nota or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">                            
                                <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                             $totalDebit=0;
                                             $totalKredit=0;
                                        @endphp
                                              @for($i = 0 ; $i < count($jurnal_dt); $i++)
                                            <tr>
                                                <td>{{$jurnal_dt[$i]->nama_akun}}</td>
                                                <td> @if($jurnal_dt[$i]->dk=='D') 
                                                        @php
                                                        $totalDebit+=$jurnal_dt[$i]->jrdt_value;
                                                        @endphp
                                                         {{(number_format(abs($jurnal_dt[$i]->jrdt_value),2,',','.'))}}
                                                    @endif
                                                </td>
                                                <td>@if($jurnal_dt[$i]->dk=='K') 
                                                    @php
                                                        $totalKredit+=$jurnal_dt[$i]->jrdt_value;
                                                    @endphp
                                                    {{number_format(abs($jurnal_dt[$i]->jrdt_value),2,',','.')}}
                                                     @endif
                                                </td>
                                            <tr> 
                                              @endfor
                                                                                   
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                                <th>Total</th>                                                
                                                <th>{{number_format(abs($totalDebit),2,',','.')}}</th>
                                                <th>{{number_format(abs($totalKredit),2,',','.')}}</th>
                                        <tr>
                                    </tfoot>
                                </table>                            
                          </div>                          
                    </div>
                  </div>
                </div>


                          <!-- modal DATA BG -->
                              <div class="modal inmodal fade" id="myModalCekBg" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title">Tambah Data Cek BG </h4>     
                                       </div>

                                <div class="modal-body">
                                <div class="row">
                                                 <div class="col-sm-6">
                                                      <table class='table'>
                                                          <tr>
                                                              <th> No Check / BG </th>
                                                              <td> <input type="text" class="input-sm form-control nocheck bg" type="button" data-toggle="modal" data-target="#myModal2">  </td>
                                                          </tr>

                                                          <tr>
                                                              <th> Jatuh Tempo </th>
                                                              <td> <input type='text' class='input-sm form-control jatuhtempo bg' readonly="" name="fpg_jatuhtempo"> </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Nominal </th>
                                                            <td> <input type='text' class='input-sm form-control nominal bg' name="fpg_nominal" readonly="" style='text-align: right'> </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Keterangan </th>
                                                            <td> <input type='text' class='input-sm form-control keterangan bg' name="fpg_keterangan" readonly=""> </td>
                                                          </tr>

                                                      </table>
                                                 </div>
                                                   <div class="col-sm-6">
                                                      <table class='table'>

                                                      <tr>
                                                        <th> No FPG </th>
                                                        <td> <input type='text' class='input-sm form-control nofpg bg' readonly=""> <input type='hidden' class='input-sm form-control idfpg' readonly=""> </td>
                                                      </tr>

                                                        <tr>
                                                        <th> Bank </th>
                                                        <td> <div class='row'> <div class="col-sm-3"> <input type='text' class='col-sm-3 input-sm form-control bank bg' name="fpg_bank" readonly=""> </div> <div class="col-sm-9"> <input type='text' class='col-sm-6 input-sm form-control namabank bg' readonly=""> <input type='hidden' class="idbank">  </div>  </div>
                                                      
                                                        </tr>
                                                        <tr>
                                                          <th> Supplier </th>
                                                          <td> <div class='row'> <div class="col-sm-3"> <input type='text' class='col-sm-3 input-sm form-control kodesup bg' name="fpg_supplier" readonly=""> </div> <div class="col-sm-9"> <input type='text' class='col-sm-6 input-sm form-control namasupplier bg' readonly=""> <input type='hidden' class='jenissup' name='jenissup'>  </div>  </div> </td>
                                                        </tr>

                                                        <tr>
                                                          <th> Tanggal FPG </th>
                                                          <td> <input type='text' class='input-sm form-control tgl bg' name="tglfpg" readonly=""></td>
                                                        </tr>

                                                       
                                                      </table>
                                                   </div>
                                                   </div> 
                                 </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> <!--end modal -->

                    <!-- Modal Biaya -->
                       <div class="modal inmodal fade" id="myModalBiaya" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title">Tambah Data Biaya </h4>     
                                       </div>

                                      <div class="modal-body">
                                        
                                                    <table class="table">
                                                      <tr>
                                                        <th> Acc Biaya </th>
                                                        <td>
                                                            <div class="col-sm-12">
                                                            <select class="chosen-select-width form-control akun biaya">
                                                               <option value='' selected="">
                                                                Pilih Akun 
                                                              </option>

                                                              @foreach($data['akun'] as $akun)
                                                              <option value="{{$akun->id_akun}},{{$akun->akun_dka}},{{$akun->nama_akun}}">
                                                                {{$akun->nama_akun}}
                                                              </option>
                                                              @endforeach
                                                             </select>
                                                             </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th> D / K </th>
                                                        <td> <div class="col-sm-3"><input type="text" class="input-sm form-control dk biaya" readonly=""> </div> </td>
                                                      </tr>

                                                      <tr>
                                                        <th> Jumlah </th>
                                                        <td> <div class="col-sm-12"> <input type="text" class="input-sm form-control  jumlahaccount biaya" style="text-align: right"> </div> </td>
                                                      </tr>

                                                      <tr>
                                                        <th> Keterangan </th>
                                                        <td> <div class="col-sm-12"> <input type="text" class="input-sm form-control  keteranganbiaya biaya"> </div> </td>
                                                      </tr>
                                                    </table>
                                                  
                                            </div>      
                                         
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="tmbhdatabiaya">Save changes</button>
                          </div>
                      </div>
                     </div>
                    </div>
               
                    <!-- End -->


                          <!-- MODAL -->
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
                                          <th style="width:50px">No</th> <th> No Transaksi Bank  </th> <th> No FPG </th> <th> Jenis Bayar Bank </th> <th> Nominal </th> <th> Aksi </th>
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
                           </div>


                            <div class="pull-right">
                            <table border="0">
                            <tr>
                              <td> 
                             <a class="btn btn-sm btn-info" href="{{url('pelunasanhutangbank/cetak/'. $data['bbk'][0]->bbk_id.'')}}" type="button"> <i class="fa fa-print" aria-hidden="true"></i> Cetak BBK  </a>  
                              </td>

                              <td> &nbsp; </td>
                              <td> <button class="btn btn-success btn-sm simpansukses" type="submit"> Simpan </button> </td>
                            </tr>
                            </table>
                             <!--   -->
                              <!--  <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-sm btn-success simpansukses"> -->
                              
                          </div>

                        </div>
                      </div>
                      </div>
                   </div>
                 </div>
            </div>
            </div>
        </div>
  
</form>
<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

      $('.removes-btn').hide();
      $('.remove-btn').hide();
      $('.tmbhdatacek').hide();
      $('.simpansukses').hide();
      $('.tambahdatabiaya').hide();

      $('.flag').val();
         flag = $('.flag').val();
     
      if(flag == 'CEKBG') {
          $('#tab-1').addClass('active');
           $('#tab-2').removeClass("active");
           $('#tabbiaya').addClass("disabled");
      }
      else {
          $('#tab-2').addClass('active');
           $('#tab-1').removeClass("active");
           $('#tabcekbg').addClass("disabled");
      }

     $('#formbbk').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    });

     $('#formbbk input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    });

    $('#formbbk input').change(function(){
      this.setCustomValidity("");
    });

     $('#formfpg').submit(function(event){
       
    

        event.preventDefault();
         var post_url2 = $(this).attr("action");
         var form_data2 = $(this).serialize();
         swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Form BBK!",
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
             
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
       });
       
    })  

    arrtransaksi = [];
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




    
    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
    
    $('.nocheck').click(function(){
        kodebank = $('.kodebank').val();

     

        $.ajax({
          type : "get",
          data : {kodebank},
          url : baseUrl + '/pelunasanhutangbank/nocheck',
          dataType : "json",
          success : function(response){

              length = arrtransaksi.length;
              
              $('.datacek').empty();
              databank = response.fpgbank;
              $no = 1;

              var tablecek = $('#tbl-cheuque').DataTable();
              tablecek.clear().draw();

              if(length != 0){
                 for(j = 0 ; j < length; j++){
                  for(i = 0; i < databank.length; i++){
                    
                    if(arrtransaksi[j] ==  databank[i].fpgb_nocheckbg){

                    }
                    else {
                     // alert('heo');
                      row = "<tr class='datacek"+databank[i].fpgb_nocheckbg+"' id='transaksi"+databank[i].fpgb_nocheckbg+"'> <td>"+$no+"</td> <td>"+databank[i].fpgb_nocheckbg+"</td> <td>"+databank[i].fpg_nofpg+"</td> <td>"+databank[i].fpgb_jenisbayarbank+"</td> <td style='text-align:right'>"+addCommas(databank[i].fpgb_nominal)+"</td> <td>  <input type='checkbox' id="+databank[i].fpgb_id+","+databank[i].fpgb_idfpg+" class='checkcek' value='option1' aria-label='Single checkbox One'> <label></label>  </td> </tr> ";
                     $no++;
                     tablecek.rows.add($(row)).draw(); 
                                       }
                      
                  }
                }
              }
              else {
                 for(i = 0; i < databank.length; i++){
                    row = "<tr class='datacek"+databank[i].fpgb_nocheckbg+"' id='transaksi"+databank[i].fpgb_nocheckbg+"'> <td>"+$no+"</td> <td>"+databank[i].fpgb_nocheckbg+"</td> <td>"+databank[i].fpg_nofpg+"</td> <td>"+databank[i].fpgb_jenisbayarbank+"</td> <td style='text-align:right'>"+addCommas(databank[i].fpgb_nominal)+"</td> <td>  <input type='checkbox' id="+databank[i].fpgb_id+","+databank[i].fpgb_idfpg+" class='checkcek' value='option1' aria-label='Single checkbox One'> <label></label>  </td> </tr> ";
                     $no++;
                     tablecek.rows.add($(row)).draw(); 
                 }
              }
             
          }
        })
    })
      
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

     $('.cabang').change(function(){    
      var comp = $(this).val();
        $.ajax({    
            type :"post",
            data : {comp},
            url : baseUrl + '/pelunasanhutangbank/getnota',
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

              
                 nobbk = 'BK-' + month1 + year2 + '/' + comp + '/' +  data;
              //  console.log(nospp);
                $('.nobbk').val(nobbk);
            }
        })

    })
      

     nilaicekbg = 0;
     nilaitotal = 0; 
     $nomrd = $('#hslbank').length;
      $nomr = $nomrd + 1;
    $('#buttongetid').click(function(){
       
        $('#myModalCekBg').modal('hide');
        nofpg = $('.nofpg').val();
        nobbk = $('.nobbk').val();
        flag = $('.flag').val();
        idfpg = $('.idfpg').val(); 
      if(flag == 'BIAYA'){
        toastr.info("Anda sudah mengisi form 'biaya biaya' mohon untuk dilanjutkan :)");       
      }
     
     
      else {
        flag = $('.flag').val('CEKBG');
      nofpg = $('.nofpg').val();
      notransaksi =$('.nocheck').val();
      accbank = $('.bank').val();
      namabank = $('.namabank').val();
      nominal = $('.nominal').val();
      keterangan = $('.keterangan').val();
      tgl = $('.tgl').val();
      supplier = $('.kodesup').val();
      namasupplier = $('.namasupplier').val();
      jatuhtempo = $('.jatuhtempo').val();
      idbank = $('.idbank').val();
      jenissup = $('.jenissup').val();

      row = "<tr class='transaksi data-"+$nomr+" bayar"+$nomr+"' id='hslbank datacek"+notransaksi+" '>" +
          "<td>"+$nomr+"</td> <td> <input type='text' class='input-sm form-control' value='"+nofpg+"' name='nofpg[]' readonly></td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+tgl+"' name='tgl[]' readonly></td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+notransaksi+"' name='notransaksi[]' readonly>" +
          "</td> <td> <input type='text' class='input-sm form-control' name='jatuhtempo[]' value='"+jatuhtempo+"' readonly> <input type='text' class='input-sm form-control' name='idfpg[]' value='"+idfpg+"' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control' value= "+accbank+" name='bank[]' readonly> <input type='hidden' class='idbank' name='idbank[]' value='"+accbank+"'>  </td>" +
          "<td style='text-align:right'> <input type='text' class='input-sm form-control nominal' value= '"+addCommas(nominal)+"' name='nominal[]' readonly> </td>" +
          "<td><input type='text' class='input-sm form-control' value= '"+supplier+"' name='supplier[]' readonly> <input type='hidden' class='input-sm form-control' value= '"+jenissup+"' name='jenissup[]'> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+keterangan+"' name='keterangan[]' readonly></td>" +
          "<td> <button class='btn btn-danger btn-sm removes-btn' type='button' data-id="+$nomr+" data-cek='"+notransaksi+"' data-nominal='"+nominal+"'><i class='fa fa-trash'></i></button> </td> </tr>";


      arrtransaksi.push(notransaksi);
        $('.bg').val('');
      $('#tbl-hasilbank').append(row);
      $nomr++;

      $('.nominal2').each(function(){
        val = $(this).val();
        nominal2 = val.replace(/,/g, '');
        nilaicekbg = parseFloat(parseFloat(nilaicekbg) + parseFloat(nominal2)).toFixed(2);
      })
      console.log(nilaicekbg + 'nilaicekbg');

      nominal2 = $('.nominal').val();
      nominal = nominal2.replace(/,/g, '');
      console.log(nominal + 'nominal');

      nilaicekbg = parseFloat(parseFloat(nilaicekbg) + parseFloat(nominal)).toFixed(2);
      console.log(nilaicekbg + 'nilaicekbg');


      $('.cekbg').val(addCommas(nilaicekbg));
      $('.total').val(addCommas(nilaicekbg));
      }
    })

      //HAPUS BIAYA
       $(document).on('click','.remove-btn',function(){
            id = $(this).data('id');
            cek = $(this).data('cek');
            nominal = $(this).data('nominal');
            parentbayar = $('.transaksi'+id);
      
            biaya = $('.totalbiaya').val();
            biaya2 =  biaya.replace(/,/g, '');
            nominal2 = nominal.replace(/,/g,'');
           // alert(biaya2);
           // alert(nominal2);
            nilaibiaya = parseFloat(parseFloat(biaya2) - parseFloat(nominal2)).toFixed(2);
            $('.totalbiaya').val(addCommas(nilaibiaya));
            $('.total').val(addCommas(nilaibiaya));
         //   parent.remove();
            parentbayar.remove();
          })

      //HAPUS CEK BG
      $(document).on('click','.removes-btn',function(){
          id = $(this).data('id');
          cek = $(this).data('cek');
          nominal = $(this).data('nominal');
          parentbayar = $('.data-'+id);
       
          $('.bg').val('');
          cekbg = $('.cekbg').val();
          cekbg2 =  cekbg.replace(/,/g, '');
          nominal2 = nominal.replace(/,/g,'');
       
          nilaicekbg = parseFloat(parseFloat(cekbg2) - parseFloat(nominal2)).toFixed();
          $('.cekbg').val(addCommas(nilaicekbg));
          $('.total').val(addCommas(nilaicekbg));
       //   parent.remove();
          parentbayar.remove();
      })


    $('#buttongetcek').click(function(){
        var checked = $(".checkcek:checked").map(function(){
          return this.id;
        }).toArray();

         data = checked;
         idfpgb = [];
         idfpg = [];
        for(z=0;z<data.length;z++){
          string = data[z].split(",");
          idfpgb.push(string[0]);    
          idfpg.push(string[1]);
        }

        $.ajax({
            url : baseUrl + '/pelunasanhutangbank/getcek',
            data : {idfpgb,idfpg},
            type : "post",
            dataType : "json",
            success : function (response){
                $('#myModal2').modal('hide');
                  $('.nofpg').val(response.fpg[0].fpg_nofpg);
                  $('.idfpg').val(response.fpg[0].idfpg);
                  $('.nocheck').val(response.fpg[0].fpgb_nocheckbg);
                    $('.jatuhtempo').val(response.fpg[0].fpgb_jatuhtempo);
                    $('.nominal').val(addCommas(response.fpg[0].fpgb_nominal));
                    $('.keterangan').val(response.fpg[0].fpg_keterangan);
                    $('.bank').val(response.fpg[0].mb_kode);
                    $('.namabank').val(response.fpg[0].mb_nama)
                    $('.tgl').val(response.fpg[0].fpg_tgl );
                    $('.idbank').val(response.fpg[0].mb_id);

                if(response.fpg[0].fpg_jenisbayar == '2' || response.fpg[0].fpg_jenisbayar == '3' ) {                  
                    $('.kodesup').val(response.fpg[0].no_supplier);
                    $('.namasupplier').val(response.fpg[0].nama_supplier); 
                    $('.jenissup').val('supplier');            
                }
                else if(response.fpg[0].fpg_jenisbayar == '4') {
                    $jenissup = response.fpg[0].um_jenissup;
                    if($jenissup == 'supplier'){                      
                      $('.kodesup').val(response.fpg[0].no_supplier);
                      $('.namasupplier').val(response.fpg[0].nama_supplier);   
                      $('.jenissup').val('supplier');              
                    }
                    else if($jenissup == 'agen'){                    
                      $('.kodesup').val(response.fpg[0].kode);
                      $('.namasupplier').val(response.fpg[0].nama);
                      $('.jenissup').val('agen');                    
                    }

                }
                else if(response.fpg[0].fpg_jenisbayar == '9'){
                   $('.kodesup').val(response.fpg[0].kode);
                    $('.namasupplier').val(response.fpg[0].nama);
                    $('.jenissup').val('subcon');   
                }
                else if(response.fpg[0].fpg_jenisbayar == '1') {
                  $('.kodesup').val(response.fpg[0].kode);
                    $('.namasupplier').val(response.fpg[0].nama);
                    $('.jenissup').val('cabang');   
                }
                else {
                   $('.kodesup').val(response.fpg[0].kode);
                   $('.namasupplier').val(response.fpg[0].nama); 
                }
            }
        })

    })
    
    $('.nominalbiaya').change(function(){
      /*alert('jaja');*/
        val = $(this).val();
        val = accounting.formatMoney(val, "", 2, ",",'.');
        $(this).val(val);

        nilaitotal = 0;
        $('.nominalbiaya').each(function(){
          val = $(this).val();

          if(val != ''){
            val2 = val.replace(/,/g, '');
            nilaitotal = parseFloat(parseFloat(nilaitotal) + parseFloat(val2)).toFixed(2);
          }

          $('.totalbiaya').val(addCommas(nilaitotal));
          $('.total').val(addCommas(nilaitotal));
        })

    })

    $('.nominal2').change(function(){
      /*alert('jaja');*/
        val = $(this).val();
        val = accounting.formatMoney(val, "", 2, ",",'.');
        $(this).val(val);

        nilaitotal = 0;
        $('.nominal2').each(function(){
          val = $(this).val();

          if(val != ''){
            val2 = val.replace(/,/g, '');
            nilaitotal = parseFloat(parseFloat(nilaitotal) + parseFloat(val2)).toFixed(2);
          }

          $('.cekbg').val(addCommas(nilaitotal));
          $('.total').val(addCommas(nilaitotal));
        })

    })

    //BIAYA BIAYA
      $('.akun').change(function(){
        val = $(this).val();
        string = val.split(",");
        akundka = string[1];
        $('.dk').val(akundka);
      })

      $('.jumlahaccount').change(function(){
        val = $(this).val();
        val = accounting.formatMoney(val, "", 2, ",",'.');
        $(this).val(val);
      })

     totalbiaya = 0;
     $nomrbiayad = $('#hslbiaya').length;
      $nmrbiaya = $nomrbiayad + 1;

      arrdatabiaya = [];
      $('#tmbhdatabiaya').click(function(){
          akun = $('.akun').val();
          variabel = akun.split(',');
          idakun = variabel[0];
          nobbk = $('.nobbk').val();
          flag = $('.flag').val();
        


          $('.databiaya').each(function(){
            biaya = $(this).data('biaya');
            arrdatabiaya.push(biaya);
          })

          datatempbiaya = 0;
          for(var x = 0; x < arrdatabiaya.length; x++){
            if(idakun == arrdatabiaya[x]){
              datatempbiaya = datatempbiaya + 1;
            }
          }

          if(datatempbiaya != 0) {
            toastr.info("Id Akun sudah ada pada data di bawah :)");
            return false;
          }
          if(flag == 'CEKBG'){
            toastr.info("Anda sudah mengisi form 'CEK BG' mohon untuk dilanjutkan :)");      
            return false;    
          }
          if(akun == ''){
            toastr.info("Mohon isi data akun bank");
            return false;
          }
          if(nobbk == ''){
            toastr.info("Mohon isi data cabang");
            return false;
          }
          else {
              $('#myModalBiaya').modal('hide');
            $('.flag').val('BIAYA');
          akun = $('.akun').val();
          string = akun.split(",");
          idakun = string[0];
          nmakun = string[2];
          dk = string[1];
          jumlah = $('.jumlahaccount').val();
          keterangan = $('.keteranganbiaya').val();
          nobbk = $('.nobbk').val();

          rowHtml = "<tr class='databiaya transaksi"+$nmrbiaya+"' data-biaya="+idakun+"> <td>"+$nmrbiaya+"</td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+nobbk+"' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+nmakun+"' readonly> <input type='hidden' name='akun[]' value="+idakun+"> </td>" +
          "<td>  <input type='text' class='input-sm form-control' value='"+dk+"' name='dk[]' readonly> </td>" +
          "<td> <input type='text' style='text-align:right' class='input-sm form-control' value='"+jumlah+"' name='jumlah[]'> </td>" +
          "<td><input type='text' class='input-sm form-control' value=' "+keterangan+"' name='keterangan[]'></td>" +
          "<td> <button class='btn btn-danger btn-sm remove-btn' type='button' data-id="+$nmrbiaya+" data-cek='"+akun+"' data-nominal='"+jumlah+"'><i class='fa fa-trash'></i></button>  </td> </tr>";

          $('#tbl-biaya').append(rowHtml);

          $('.biaya').val('');
          totalbiaya2 = $('.totalbiaya').val();
          totalbiaya = totalbiaya2.replace(/,/g, '');

          jumlah2 = jumlah.replace(/,/g, '');
          totalbiaya = parseFloat(parseFloat(totalbiaya) + parseFloat(jumlah2)).toFixed(2);
          $('.totalbiaya').val(addCommas(totalbiaya));
          $('.total').val(addCommas(totalbiaya));
          $nmrbiaya++;

          }
      })

      $('.ubahdata').click(function(){
        $('.removes-btn').show();
        $('.remove-btn').show();
        $('.tmbhdatacek').show();
        $('.simpansukses').show();
        $('.tambahdatabiaya').show();
        $('.nominal2').attr('readonly' , false);
      })


  function lihatjurnal($ref,$note){

          $.ajax({
          url:baseUrl +'/data/jurnal-umum',
          type:'get',
          data:'ref='+$ref
               +'&note='+$note,
          /* data: "{'ref':'" + $ref+ "', 'note':'" + $note+ "'}",
  */
          
         
          success:function(response){
                $('#data-jurnal').html(response);
                $('#jurnal').modal('show');
              }
        });
   }
</script>
@endsection
