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
                            <stronbg> Create Pelunasan Hutang / Pembayaran Bank </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <br>
    <form method="post" action="{{url('pelunasanhutangbank/simpan')}}"  enctype="multipart/form-data" class="form-horizontal" id="formbbk">

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
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0" class="table table-stripped">

                          <tr>
                           <td> Cabang </td>
                               @if(Auth::user()->punyaAkses('Pelunasan Hutang','cabang'))
                            <td class="cabang_td">  
                            <select class="form-control chosen-select-width cabang" name="cabang">
                                @foreach($data['cabang'] as $cabang)
                              <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                              @endforeach
                            </select>
                            </td>
                            @else
                              <td class="disabled"> 
                              <select class="form-control chosen-select-width disabled cabang" name="cabang">
                                @foreach($data['cabang'] as $cabang)
                                <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                                @endforeach
                              </select> 
                              </td>
                            @endif
                          </tr>

                          <tr>
                            <td width="150px">
                          No BBK
                            </td>
                            <td>
                             <input type="text" class="input-sm form-control nobbk" readonly="" name="nobbk">
                           
                             <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                            </td>
                          </tr>

                          <tr>
                            <td class='disabledbank'> Kode Bank </td>
                            <td>
                              <select class="form-control kodebank chosen-select" name="kodebank">
                               <option value=""> Pilih Data Bank</option>

                                @foreach($data['bank'] as $bank)
                                  <option value="{{$bank->mb_id}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                @endforeach
                              </select>
                              
                             </td>
                          </tr>

                          <tr>
                            <td> Tanggal </td>
                            <td>  <div class="input-group date" >
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tglbbk" name="tglbbk">
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
                               <input type="text" class="input-sm form-control cekbg" readonly="" style='text-align:right;' name="totalcekbg">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Biaya
                              </td>
                              <td>
                              <input type="text" class="form-control totalbiaya" readonly="" style='text-align: right' name="totalbiaya">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Total
                              </td>
                              <td>
                                <input type="text" class="form-control total" readonly="" style='text-align:right;' name="total">
                              </td>
                            </tr>

                          <tr>
                            <td>Keterangan </td>
                            <td> <input type="text" class="input-sm form-control" name="keteranganheader" required=""> <input type="hidden" class="input-sm form-control flag" name="flag" required=""> <imput type="hidden" class="jenistab" name="jenistab"> </td>
                            <td>    </td>
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
                    <h5> Detail Cek /  BG
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>   
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
                                      <ul class="nav nav-tabs" id="tabmenu">
                                          <li class="active" id="tabcekbg" data-val='BG'><a data-toggle="tab" href="#tab-1" > Detail Cek / BG </a></li>
                                          <li class="" id="tabcekbgakun" data-val="AKUNBG"><a data-toggle="tab" href="#tab-3"> Cek / BG & Akun </a></li>
                                          <li class="" id="tabbiaya" data-val="BIAYA"><a data-toggle="tab" href="#tab-2"> POSTING </a></li>
                                      </ul>
                                      <div class="tab-content">
                                          <div id="tab-1" class="tab-pane active">
                                              <div class="panel-body">
                                                <div class="row">
                                                 <div class="col-sm-6">

                                                     <div class="loadingcek text-center" style="display: none;">
                                        <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                                    </div>

                                                      <table class='table'>
                                                          <tr>
                                                              <th> No Check / BG </th>
                                                              <td> <input type="text" class="input-sm form-control nocheck bg" type="button" data-toggle="modal" data-target="#myModal2" readonly="">  </td>
                                                          </tr>

                                                          <tr>
                                                              <th> Jatuh Tempo </th>
                                                              <td> <input type='text' class='input-sm form-control jatuhtempo bg' readonly="" > </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Nominal </th>
                                                            <td> <input type='text' class='input-sm form-control nominal bg' readonly="" style='text-align: right'> </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Keterangan </th>
                                                            <td> <input type='text' class='input-sm form-control keterangan bg' readonly=""> </td>
                                                          </tr>

                                                      </table>
                                                 </div>
                                                   <div class="col-sm-6">
                                                      <table class='table'>

                                                      <tr>
                                                        <th> No FPG </th>
                                                        <td> <input type='text' class='input-sm form-control nofpg bg' readonly=""> <input type='hidden' class='input-sm form-control idfpg' readonly=""> <input type="hidden" class="idfpgb"> </td>
                                                      </tr>

                                                        <tr>
                                                        <th> Bank </th>
                                                        <td> <div class='row'> <div class="col-sm-3"> <input type='text' class='col-sm-3 input-sm form-control bank bg'  readonly=""> </div> <div class="col-sm-9"> <input type='text' class='col-sm-6 input-sm form-control namabank bg' readonly=""> <input type='hidden' class="idbank">  </div> <input type='hidden' class='akunkodebank'> <input type='hidden' class='hutangdagang'> <input type='hidden' class='akunuangmuka'> <input type='hidden' class='jenisbayarfpg'>  </div>
                                                      
                                                        </tr>
                                                        <tr>
                                                          <th> Supplier </th>
                                                          <td> <div class='row'> <div class="col-sm-3"> <input type='text' class='col-sm-3 input-sm form-control kodesup bg'  readonly=""> </div> <div class="col-sm-9"> <input type='text' class='col-sm-6 input-sm form-control namasupplier bg' readonly=""> <input type='hidden' class='jenissup' >  </div>  </div> </td>
                                                        </tr>

                                                        <tr>
                                                          <th> Tanggal FPG </th>
                                                          <td> <input type='text' class='input-sm form-control tgl bg' readonly=""></td>
                                                        </tr>

                                                       
                                                      </table>
                                                   </div>
                                                   </div>
                                                   <div class="text-left">
                                                      <a class='btn btn-sm btn-info tmbhdatacek'> <i class="fa fa-plus"> </i> Tambah Data Cek / BG </a>
                                                   </div>
                                                   <br>
                                                   <br>
                                                   <div class="col-sm-12">
                                                   <div style="overflow-x:auto;">
                                                    <table class='table table-stripped table-bordered' id="tbl-hasilbank" style='width:100%'>
                                                      <thead>
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
                                                    </thead>
                                                    </table>
                                                    </div>
                                                   </div>

                                              </div>
                                          </div>
                                          <div id="tab-2" class="tab-pane">
                                              <div class="panel-body">
                                                  <div class="row">
                                                  <div class="col-sm-8">
                                                    <table class="table">
                                                      <tr>
                                                        <th> Acc Biaya </th>
                                                        <td>
                                                            <div class="col-sm-12">
                                                            <select class="chosen-select-width form-control akun biaya">
                                                               <option value="">
                                                                Pilih Akun 
                                                              </option>

                                                              @foreach($data['akun'] as $akun)
                                                              <option value="{{$akun->id_akun}},{{$akun->akun_dka}}">
                                                               {{$akun->id_akun}} - {{$akun->nama_akun}}
                                                              </option>
                                                              @endforeach
                                                             </select>
                                                             </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th> D / K </th>
                                                        <td> <div class="col-sm-3"><input type="text" class="input-sm form-control dk biaya"> </div> </td>
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
                                                  
                                                  <div class="col-sm-6">
                                                  &nbsp;
                                                  </div>
                                                  </div>
                                                

                                                   <div class="text-left">
                                                      <a class='btn btn-sm btn-info' id="tmbhdatabiaya"> <i class="fa fa-plus"> </i> Tambah Data Biaya </a>
                                                   </div>

                                                   <br>
                                                   <br>
                                                   <div class="col-sm-12">
                                                    <table class='table table-stripped table-bordered' id="tbl-biaya">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th> 
                                                        <th> Acc Bank </th>
                                                        <th> D / K </th>
                                                        <th> Nominal </th>
                                                        <th> Keterangan </th>
                                                        <th> Aksi </th>
                                                      </tr>
                                                    </table>
                                                   </div>
                                              </div>
                                          </div>
                                          <div id="tab-3" class="tab-pane">
                                              <div class="panel-body">
                                                  <div class="row">
                                                    <div class="col-sm-8">
                                                      <table class="table table-bordered">
                                                        <thead>
                                                        <tr> 
                                                          <th> No Check / BG </th> <th> NO FPG </th> <th> Nominal </th>
                                                          <th> Keterangan </th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                        <tr> <td> <input type="text" class="input-sm form-control nocheck  checkakunbg" type="button" data-toggle="modal" data-target="#myModal2" readonly="">  </td> <td> <input type='text' class='input-sm form-control jatuhtempo  nofpgakunbgbiaya' readonly=""> <input type='hidden' class='input-sm form-control jatuhtempo idfpgakunbgbiaya' readonly="" > </td> <td> <input type='text' class='input-sm form-control nominalakunbiaya'  readonly="" style='text-align:right'> </td> <td> <input type='text' class='input-sm form-control keteranganakunbiayafpg'  readonly=""> </td> </tr>
                                                      </tbody>
                                                      </table>
                                                    </div>

                                                  <div class="col-sm-6">
                                                    <table class="table">
                                                      <tr>
                                                        <th> Acc Biaya </th>
                                                        <td>
                                                            <div class="col-sm-12">
                                                            <select class="chosen-select-width form-control akun biayabg accbiayaakun">
                                                               <option value="">
                                                                Pilih Akun 
                                                              </option>

                                                              @foreach($data['akun'] as $akun)
                                                              <option value="{{$akun->id_akun}},{{$akun->akun_dka}}">
                                                               {{$akun->id_akun}} - {{$akun->nama_akun}}
                                                              </option>
                                                              @endforeach
                                                             </select>
                                                             </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th> D / K </th>
                                                        <td> <div class="col-sm-3"><input type="text" class="input-sm form-control dk dkbiayabg biayabg" > </div> <input type='hidden' class='nomorbgakun'> <input type='hidden' class='idfpgbakunbg'> </td>
                                                      </tr>

                                                      <tr>
                                                        <th> Jumlah </th>
                                                        <td> <div class="col-sm-12"> <input type="text" class="input-sm form-control  jumlahaccount  jumlahakunbg" style="text-align:right'" > </div> </td>
                                                      </tr>

                                                      <tr>
                                                        <th> Keterangan </th>
                                                        <td> <div class="col-sm-12"> <input type="text" class="input-sm form-control  keteranganakunbg " readonly=""> </div> </td>
                                                      </tr>
                                                      <tr>
                                                        <td>
                                                          <div class="text-left">
                                                            <a class='btn btn-sm btn-info' id="tmbhdatabgakun"> <i class="fa fa-plus"> </i> Tambah Data </a>
                                                         </div>
                                                        </td>
                                                      </tr>
                                                    </table>
                                                  </div>
                                                  
                                                  {{-- <div class="col-sm-6">
                                                    <table class="table">
                                                      <tr>
                                                          <th> No Check / BG </th>
                                                              
                                                          </tr>

                                                          <tr>
                                                              <th> No FPG </th>
                                                              <td> <input type='text' class='input-sm form-control jatuhtempo biayabg nofpgakunbgbiaya' readonly=""> <input type='hidden' class='input-sm form-control jatuhtempo biayabg idfpgakunbgbiaya' readonly="" > </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Nominal </th>
                                                            <td> <input type='text' class='input-sm form-control nominalakunbiaya biayabg'  readonly="" style='text-align:right'> </td>
                                                          </tr>

                                                          <tr>
                                                            <th> Keterangan </th>
                                                            <td> <input type='text' class='input-sm form-control keteranganakunbiayafpg biayabg'  readonly=""> </td>
                                                          </tr>
                                                    </table>
                                                  </div>
                                                  </div> --}}
                                                

                                                   

                                                   <br>
                                                   <br>
                                                   <div class="col-sm-12">
                                                    <div class="table-responsive">
                                                    <table class='table table-stripped table-bordered' id="tbl-biayaakun">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th> 
                                                        <th> Acc Bank </th>
                                                        <th> D / K </th>
                                                        <th> Nominal </th>
                                                        <th> Keterangan Akun </th>
                                                        <th> No FPG </th>
                                                        <th> No Check </th>
                                                        <th> Nominal </th>
                                                        <th> Keterangan FPG </th>
                                                        <th> Aksi </th>
                                                      </tr>
                                                    </table>
                                                    </div>
                                                   </div>
                                              </div>
                                          </div>
                                      </div>


                                  </div>
                              </div>
                             
                          </div>
                          <br>
                          <br>



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

                                    <div class="loading text-center" style="display: none;">
                                        <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                                    </div>

                                  </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary" id="buttongetcek">Simpan</button>
                                       
                                    </div>
                                </div>
                              </div>
                           </div>


                            <div class="pull-right">
                             <!--  <button class="btn btn-success" type="submit"> Simpan </button> -->
                              <table border="0">
                                  <tr>
                                    <td>
                                      <div class="print"> </div>
                                    </td>
                                    <td> 
                                      &nbsp;
                                    </td>
                                    <td>
                                       <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-sm btn-success simpansukses">
                                    </td>
                                  </tr>
                              </table>
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
        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.date').change(function(){
      cabang = $('.cabang').val();
      tgl = $('.tglbbk').val();
    
       $.ajax({
          type : "get",
          data : {cabang,tgl},
          url : baseUrl + '/pelunasanhutangbank/getnota',
          dataType : 'json',
          success : function (response){     
              if(response.status = 'sukses'){
                var d = new Date(tgl);                
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
                 nofaktur = 'BK' + '-' + month + year2 + '/' + cabang + '/' +  response.data ;
                $('.nobbk').val(nofaktur);
              
                kodebank = $('.kodebank').val();

               if(kodebank != ''){
                  
                  split = nofaktur.split("-");
                  bank = split[0];
                  lain = split[1];
                  if(parseInt(kodebank) < parseInt(10)){
                      kodebank = '0' + kodebank;
                  }
                  
                  str = bank.substr(0,2);
                

                  nobbk = str + kodebank + '-' + lain;
                  $('.nobbk').val(nobbk);
               }
              }
              else {
                location.reload();
              }
               
              
          },
          eror : function(){
            location.reload();
          }
        })
    })

      
    $('#tmbhdatabgakun').click(function(){

      kodecabang = $('.kodebank').val();
      $('.valkodebank').val(kodecabang);
      $('.disabledbank').addClass('disabled');

      nobbk = $('.nobbk').val();
      nofpg = $('.nofpgakunbgbiaya').val();
      idfpg = $('.idfpgakunbgbiaya').val();
      nominal = $('.nominalakunbiaya').val();
      keteranganbiaya = $('.keteranganakunbiayafpg').val();
      nocheckakunbg = $('.checkakunbg').val();
      accbiayaakun = $('.accbiayaakun').val();  

     // alert(nocheckakunbg);

      if(accbiayaakun == ''){
        toastr.info("Mohon pilih data akun biaya :)");
        return false;
      }  

      dk = $('.dkbiayabg').val();
      jumlahakunbiaya = $('.jumlahakunbg').val();
      keteranganakunbg = $('.keteranganakunbg').val();
      idfpgb = $('.idfpgbakunbg').val();

      if(nofpg == ''){
        toastr.info("Mohon lengkapi isi data :)");
        return false;
      }

      if(nominal == ''){
        toastr.info("Mohon lengkapi isi data :)");
        return false;
      }

      $('.flag').val('BGAKUN');


       
      $('#tabcekbg').addClass('disabled');
      $('#tabbiaya').addClass('disabled');

      splitakun = accbiayaakun.split(",");
      akundakun = splitakun[0];
      
       arridbank = [];
      $('tr.dataakunbg').each(function(){
        valid = $('.dataakunbg').data('nomor');
        valid2 = valid.toString();
         arridbank.push(valid2);
       // alert(arrnofaktur + 'arrnofaktur');
      });

      $nomor = $('tr.dataakunbg').length;
      if($nomor == 0){
        $nomor = 1;
      }
      else {
        $nomor++;
      }

      index = arridbank.indexOf(akundakun);
  
      if(index == -1) {  
      row = "<tr class='transaksi dataakunbg dataakunbg"+akundakun+"' data-nomor="+akundakun+"> <td>"+$nomor+"</td>" +
                  "<td> <input type='text' class='form-control input-sm nobbkdetailbg' value="+nobbk+" style='min-width:200px' readonly>  </td>" + //nobbk
                  "<td> <input type='text' class='form-control input-sm akundakundetailbg' value="+akundakun+" name='accbiayaakun[]' style='min-width:200px' readonly> </td>"+
                  "<td> <input type='text' class='form-control input-sm dkakundetailbg ' value="+dk+" name='dk[]' style='min-width:90px' readonly> </td>" +
                  "<td> <input type='text' class='form-control input-sm jumlahakunbiayadetailbg' value="+jumlahakunbiaya+" style='min-width:200px; text-align:right' name='nominalakun[]' style='min-width:100px' readonly data-dk='"+dk+"'> </td>" +
                  "<td> <input type='text' class='form-control input-sm keteranganakunbgdetail' value='"+keteranganakunbg+"' name='keteranganakunbg[]' style='min-width:200px' readonly> </td>" +
                  "<td> <input type='text' class='form-control input-sm nofpgdetailbg' value="+nofpg+" name='nofpg[]' readonly style='min-width:200px'> <input type='hidden' class='idfpgakunbgdetail' value="+idfpg+" name='idfpg[]'> </td>" +
                  "<td> <input type='text' class='form-control input-sm accbiayaakundetailbg' value='"+nocheckakunbg+"' name='nocheck[]' readonly style='min-width:200px'> </td>" +
                  "<td> <input type='text' class='form-control input-sm nominalfpgdetailbg' value="+nominal+" name='nominalfpg[]' readonly style='min-width:200px;text-align:right'> </td>" +
                  "<td> <input type='text' class='form-control input-sm keteranganbiayadetailbg' value='"+keteranganbiaya+"' name='keteranganfpg[]' readonly style='min-width:200px'> <input type='hidden' value='"+idfpgb+"' name='idfpgb[]'> </td>" +
                  "</td>" +
                  "<td> <button class='btn btn-xs btn-danger' type='button' onclick='hapus(this)'> <i class='fa fa-trash'> </i> </button></td>" +
                  "</tr>";
        $('#tbl-biayaakun').append(row);

        jumlahnominal = 0;
        $('.jumlahakunbiayadetailbg').each(function(){
          nominal = $(this).val();
          dk = $(this).data('dk');
          nominal2 =  nominal.replace(/,/g, '');
          if(dk == 'D') {
            jumlahnominal = parseFloat(parseFloat(nominal2) + parseFloat(jumlahnominal)).toFixed(2);
          }
          else {
           jumlahnominal = parseFloat(parseFloat(nominal2) - parseFloat(jumlahnominal)).toFixed(2);
          }
          $('.total').val(addCommas(jumlahnominal));
          $('.cekbg').val(addCommas(jumlahnominal));
        })
         $('.biayabg').val(''); 
      }
      else {

      nobbk = $('.nobbk').val();
      nofpg = $('.nofpgakunbgbiaya').val();
      idfpg = $('.idfpgakunbgbiaya').val();
      nominal = $('.nominalakunbiaya').val();
      keteranganbiaya = $('.keteranganakunbiayafpg').val();
      nocheckakunbg = $('.checkakunbg').val();
      accbiayaakun = $('.accbiayaakun').val();    
      dk = $('.dkbiayabg').val();
      jumlahakunbiaya = $('.jumlahakunbg').val();
      keteranganakunbg = $('.keteranganakunbg').val();

      splitakun = accbiayaakun.split(",");
      akundakun = splitakun[0];
      valid2 = akundakun.toString();

      var a = $('.dataakunbg' + valid2);
      var par = a.parents('tr');
      nobbk = par.find('.nobbkdetailbg').val(nobbk);
      accakun = par.find('.akundakundetailbg').val(accbiayaakun);
      dk = par.find('.dkakundetailbg').val(dk);
      nominalakun = par.find('.jumlahakunbiayadetailbg').val(jumlahakunbiaya);
      keteranganakun = par.find('.keteranganakunbgdetail').val(keteranganakunbg);
      nofpg = par.find('.nofpgdetailbg').val(nofpg);
      idfpg = par.find('.idfpgakunbgdetail').val(idfpg);
      nocheck = par.find('.accbiayaakundetailbg').val(nocheckakunbg);
      nominalfpg = par.find('.nominalfpgdetailbg').val(nominal);
      keteranganfpg = par.find('.keteranganbiayadetailbg').val(keteranganakunbg);
      
        jumlahnominal = 0;
        $('.jumlahakunbiayadetailbg').each(function(){
          nominal = $(this).val();
          nominal2 =  nominal.replace(/,/g, '');
          dk = $(this).data('dk');
          if(dk == 'D'){
             jumlahnominal = parseFloat(parseFloat(nominal2) + parseFloat(jumlahnominal)).toFixed(2);
          }
          else {
            jumlahnominal = parseFloat(parseFloat(nominal2) - parseFloat(jumlahnominal)).toFixed(2);

          }
          $('.total').val(addCommas(jumlahnominal));
          $('.cekbg').val(addCommas(jumlahnominal));
        })

      }
    })
    
    function editakunbg(a){
      var par = $(a).parents('tr');
      nobbk = par.find('.nobbkdetailbg').val();
      accakun = par.find('.akundakundetailbg').val();
      dk = par.find('.dkakundetailbg').val();
      nominalakun = par.find('.jumlahakunbiayadetailbg').val();
      keteranganakun = par.find('.keteranganakunbgdetail').val();
      nofpg = par.find('.nofpgdetailbg').val();
      idfpg = par.find('.idfpgakunbgdetail').val();
      nocheck = par.find('.accbiayaakundetailbg').val();
      nominalfpg = par.find('.nominalfpgdetailbg').val();
      keteranganfpg = par.find('.keteranganbiayadetailbg').val();
      nomorbank = par.find('.transaksi').data('nomor');
      

        $('.nofpgakunbgbiaya').val(nofpg);
        $('.nominalakunbiaya').val(nominalfpg);
        $('.keteranganakunbg').val(keteranganakun);
        $('.checkakunbg').val(nocheck);
        $('.accbiayaakun').val(accakun + "," + dk);
        $('.dkbiayabg').val(dk);
        $('.jumlahakunbg').val(nominalakun);
        $('.keteranganakunbiayafpg').val(keteranganfpg);
        $('.idfpgakunbgbiaya').val(idfpg);
        $('.nomorbgakun').val(nomorbank);
    }

    function hapus(a){
       var par = $(a).parents('tr');
       nominal = par.find('.nominalfpgdetailbg').val();

       replacenominal = nominal.replace(/,/g , '');
       cekbg = $('.cekbg').val();
       total = $('.total').val();
       replacecekbg = cekbg.replace(/,/g, '');
       replacetotal = total.replace(/,/g, '');

       totalcekbg = parseFloat(parseFloat(replacecekbg) - parseFloat(replacenominal)).toFixed(2);
       total = parseFloat(parseFloat(replacetotal) - parseFloat(replacenominal)).toFixed(2);
       $('.cekbg').val(addCommas(totalcekbg));
       $('.total').val(addCommas(total))
       par.remove();
    }


    $('.kodebank').change(function(){
      val = $(this).val();
      notabbk = $('.nobbk').val();
      split = notabbk.split("-");
      bank = split[0];
      lain = split[1];
      if(parseInt(val) < parseInt(10)){
          val = '0' + val;
      }
      
      str = bank.substr(0,2);

      nobbk = str + val + '-' + lain;
      $('.nobbk').val(nobbk);
    })
   

    //GET NO BBK
    cabang = $('.cabang').val();
    $('.valcabang').val(cabang);
      tgl = $('.tglbbk').val();
      $('.cabang2').val(cabang);
       $.ajax({
          type : "get",
          data : {cabang,tgl},
          url : baseUrl + '/pelunasanhutangbank/getnota',
          dataType : 'json',
          success : function (response){     
              if(response.status = 'sukses'){
                var d = new Date(tgl);                
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
                 nofaktur = 'BK' + '-' + month + year2 + '/' + cabang + '/' +  response.data ;
                $('.nobbk').val(nofaktur);
              }
              else {
                location.reload();
              }
               
              
          },
          eror : function(){
            location.reload();
          }
        })

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

     $('#formbbk').submit(function(event){
        
     if($('tr.transaksi').length == 0 ){
      toastr.info("Harap Input Data Transaksi :) ");
      return false;
     }
     else {
      var a = $('ul#tabmenu').find('li.active').data('val');
      $('.jenistab').val(a);
      if(a == 'CEKBG'){
        cekbg = $('.cekbg').val();
        total = $('.total').val();
        if(cekbg != total){
          toastr.info("Total BG dan Total tidak sama :)");
          return false;
        }
      }
      else if(a == 'BIAYA'){
        biaya = $('.totalbiaya').val();
        total = $('.total').val();
     
        if(biaya != total){
          toastr.info("Total Biaya dan Total tidak sama :)");
          return false;
        }
      }
      else if(a == 'AKUNBG'){
        total = $('.total').val();
        cekbg = $('.cekbg').val();
        if(total != cekbg){
          toastr.info("Total BG dan Total tidak sama :)");
          return false;
        }

        nominalfpg2 = $('.nominalfpgdetailbg').val();
        totalakun = 0;
        $('.jumlahakunbiayadetailbg').each(function(){
            val = $(this).val();
            val = val.replace(/,/g, '');
            if(val == ''){
              toastr.info("nominal akun bg ada yang blm di isi :)");
              return false;
            }
            else {
              dk = $(this).data('dk');
              if(dk == 'D'){
                totalakun = parseFloat(parseFloat(totalakun) + parseFloat(val)).toFixed(2);
              }
              else if(dk == 'K'){
                totalakun = parseFloat(parseFloat(totalakun) - parseFloat(val)).toFixed(2);

              }
            }  
        })
        
        totalakun = addCommas(totalakun);
        if(nominalfpg2 != totalakun){
          toastr.info("Mohon maaf nominal FPG tidak sama dengan akun :)");
          return false;
        }
      }


       url : baseUrl + '/pelunasanhutangbank/simpan';

        event.preventDefault();
         var post_url2 = $(this).attr("action");
         var form_data2 = $(this).serialize();
         swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Form Posting Bank !",
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

            if(response.status == 'sukses'){
                swal({
                  title: "Berhasil!",
                          type: 'success',
                          text: response.info,
                          timer: 900,
                         showConfirmButton: false
                       
                  });
             
                 $('.simpansukses').attr('disabled' , true);
                 html = "<a class='btn btn-info btn-sm' href={{url('pelunasanhutangbank/cetak')}}"+'/'+response.message+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a>";
                $('.print').html(html);
            }
            else if (response.status == 'gagal'){
               swal({
                  title: "error!",
                          type: 'error',
                          text: response.info,
                          timer: 900,
                         showConfirmButton: false
                       
                  });
            }
              
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
       });
       }
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
         $('.loading').css('display', 'block');
          cabang = $('.cabang').val();
         if(kodebank == ''){
          toastr.info("Mohon pilih data bank :) ");
          return false;
         }

         arrtransaksi = [];
        $('.transaksi').each(function(){
          transaksi = $(this).data('transaksi');
          arrtransaksi.push(transaksi);
        })

      
        $.ajax({
          type : "get",
          data : {kodebank,arrtransaksi,cabang},
          url : baseUrl + '/pelunasanhutangbank/nocheck',
          dataType : "json",
          success : function(response){
               
              $('.loading').css('display', 'none');
              length = arrtransaksi.length;
             // alert(length + 'length');
             // alert(arrtransaksi + 'arrtransaksi');

              $('.datacek').empty();
              databank = response.fpgbank;
              $no = 1;

              var tablecek = $('#tbl-cheuque').DataTable();
              tablecek.clear().draw();

                  for(i = 0; i < databank.length; i++){
                    row = "<tr class='datacek"+databank[i].fpgb_nocheckbg+"' id='transaksi"+databank[i].fpgb_nocheckbg+"'> <td>"+$no+"</td> <td>";
                      if(databank[i].fpgb_jenisbayarbank == 'INTERNET BANKING'){
                        row += "-";
                      }
                      else {
                        row += databank[i].fpgb_nocheckbg
 
                      }


                      row += "</td> <td>"+databank[i].fpg_nofpg+"</td> <td>"+databank[i].fpgb_jenisbayarbank+"</td> <td style='text-align:right'>"+addCommas(databank[i].fpgb_nominal)+"</td> <td>  <input type='checkbox' id="+databank[i].fpgb_id+","+databank[i].fpgb_idfpg+" class='checkcek' value='option1' aria-label='Single checkbox One'> <label></label>  </td> </tr> ";
                     $no++;
                     tablecek.rows.add($(row)).draw(); 
                
                      
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
      var cabang = $(this).val();
      var tgl = $('.tglbbk').val();
        $.ajax({    
            type :"get",
            data : {cabang,tgl},
            url : baseUrl + '/pelunasanhutangbank/getnota',
            dataType:'json',
            success : function(data){
               
                 if(data.status = 'sukses'){
               
                  var d = new Date(tgl);
                  
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

                
                   nobbk = 'BK-' + month + year2 + '/' + cabang + '/' +  data.data;
                //  console.log(nospp);
                  $('.nobbk').val(nobbk);

                       kodebank = $('.kodebank').val();

                       if(kodebank != ''){
                          
                          split = nobbk.split("-");
                          bank = split[0];
                          lain = split[1];
                          if(parseInt(kodebank) < parseInt(10)){
                              kodebank = '0' + kodebank;
                          }
                          
                          str = bank.substr(0,2);
                        
                          nobbk = str + kodebank + '-' + lain;

                          $('.nobbk').val(nobbk);
                       }



                 }
                 else {
                  location.reload();
                 }
            },
            error : function(){
              location.reload();
            }
        })

    })
      
     nilaicekbg = 0;
     nilaitotal = 0; 
     $nomr = 1;
    $('.tmbhdatacek').click(function(){

        jenisbayar = $('.jenisbayarfpg').val();
        if(jenisbayar == '5'){
          toastr.info("Mohon Maaf Transaksi TRANSFER KAS hanya bisa dilakukan di CEK / BG & Akun :)");
          return false;
        }
      
        nofpg = $('.nofpg').val();
        nobbk = $('.nobbk').val();
        flag = $('.flag').val();
        idfpg = $('.idfpg').val();


          kodecabang = $('.kodebank').val();
        // alert(kodecabang);
         

      if(flag == 'BIAYA'){
        toastr.info("Anda sudah mengisi form 'biaya biaya' mohon untuk dilanjutkan :)");       
      }
      else if(nofpg == ''){
        toastr.info("Mohon isi data transaksi bank");

      }
      else if(nobbk == ''){
        toastr.info("Mohon isi data cabang");
      }
     
      else {
          $('.kodebank').addClass('disabled');
           $('.valkodebank').val(kodecabang);
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
      kodebank = $('.akunkodebank').val();
      hutangdagang = $('.hutangdagang').val();
      akunum = $('.akunuangmuka').val();
      idfpgb = $('.idfpgb').val();

      row = "<tr class='transaksi bayar"+$nomr+"' id='datacek"+notransaksi+"' data-transaksi="+notransaksi+">" +
          "<td>"+$nomr+"</td> <td> <input type='text' class='input-sm form-control' value='"+nofpg+"' name='nofpg[]' readonly> <input type='hidden' class='input-sm form-control' value='"+kodebank+"' name='akunkodebank' readonly> <input type='hidden' class='input-sm form-control' value='"+hutangdagang+"' name='hutangdagang[]' readonly> <input type='hidden' class='input-sm form-control' value='"+akunum+"' name='akunum[]' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+tgl+"' name='tgl[]' readonly></td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+notransaksi+"' name='notransaksi[]' readonly>" +
          "</td> <td> <input type='text' class='input-sm form-control' name='jatuhtempo[]' value='"+jatuhtempo+"' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control' value= "+accbank+"-"+namabank+" name='bank[]'> <input type='hidden' class='idbank' name='idbank[]' value='"+idbank+"' readonly>  </td>" +
          "<td style='text-align:right'> <input type='text' class='input-sm form-control' value= '"+addCommas(nominal)+"' name='nominal[]' readonly> </td>" +
          "<td><input type='text' class='input-sm form-control' value= '"+supplier+" "+namasupplier+"' name='supplier[]' readonly> <input type='hidden' class='input-sm form-control' value= '"+jenissup+"' name='jenissup[]'> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+keterangan+"' name='keterangan[]' readonly> <input type='hidden' value='"+idfpgb+"' name='idfpgb[]'></td>" +
          "<td> <button class='btn btn-danger btn-sm removes-btn' type='button' data-id="+$nomr+" data-cek='"+notransaksi+"' data-nominal='"+nominal+"'> <i class='fa fa-trash'></i></button> <input type='hidden' name='idfpg[]' value="+idfpg+">  </td> </tr>";


      arrtransaksi.push(notransaksi);
        $('.bg').val('');
      $('#tbl-hasilbank').append(row);
      $nomr++;

      nominal2 =  nominal.replace(/,/g, '');
      nilaicekbg = parseFloat(parseFloat(nilaicekbg) + parseFloat(nominal2));
      nilaicekbg2 = nilaicekbg.toFixed(2);

      $('.cekbg').val(addCommas(nilaicekbg2));
      $('.total').val(addCommas(nilaicekbg2));
      }
    })



      $(document).on('click','.removes-btn',function(){
          id = $(this).data('id');
          cek = $(this).data('cek');
          nominal = $(this).data('nominal');
          parentbayar = $('.bayar'+id);
          $('#datacek' + cek).show();
          $('.bg').val('');
          cekbg = $('.cekbg').val();
          cekbg2 =  cekbg.replace(/,/g, '');
          nominal2 = nominal.replace(/,/g,'');
         // alert(cekbg2);
         // alert(nominal2);
          nilaicekbg = (parseInt(cekbg2) - parseInt(nominal2)).toFixed(2);
          $('.cekbg').val(addCommas(nilaicekbg));
          $('.total').val(addCommas(nilaicekbg));
       //   parent.remove();
          
          datacek = cek.toString();
          indexdata = arrtransaksi.indexOf(datacek);
          //alert(indexdata + 'indexdata');
          if(indexdata > -1){
            arrtransaksi.splice(indexdata , 1);
          }
        //  alert(arrtransaksi + 'arrtransaksi');

     //   alert(jQuery.type(arrtransaksi));
          parentbayar.remove();
      })


    $('#buttongetcek').click(function(){
        var checked = $(".checkcek:checked").map(function(){
          return this.id;
        }).toArray();




        $('.loadingcek').css('display' , 'block');
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
               $('.loadingcek').css('display' , 'none');
                $('#myModal2').modal('hide');
                var a = $('ul#tabmenu').find('li.active').data('val');
                if(a == 'AKUNBG'){
                    if(response.fpg[0].fpg_jenisbayar == '5'){                    
                          $('.nofpgakunbgbiaya').val(response.fpg[0].fpg_nofpg);
                          $('.idfpgakunbgbiaya').val(response.fpg[0].idfpg);
                          $('.nominalakunbiaya').val(addCommas(response.fpg[0].fpgb_nominal));
                          $('.keteranganakunbiayafpg').val(response.fpg[0].fpg_keterangan);
                          $('.checkakunbg').val(response.fpg[0].fpgb_nocheckbg);
                          $('.idfpgbakunbg').val(response.fpg[0].fpgb_id);
                          $('.jumlahakunbg').val(addCommas(response.fpg[0].fpgb_nominal));
                          $('.keteranganakunbg').val(response.fpg[0].fpg_keterangan);
                        }
                        else {
                          toastr.info("Transaksi ini hanya bisa di pake jenis bayar transfer kas bank :) ");
                          return false;
                        }
                  //  alert(response.fpg[0].fpgb_nocheckbg);
                }
                else {
               
                  $('.idfpg').val(response.fpg[0].idfpg);
                  $('.nofpg').val(response.fpg[0].fpg_nofpg);
                  $('.nocheck').val(response.fpg[0].fpgb_nocheckbg);
                    $('.jatuhtempo').val(response.fpg[0].fpgb_jatuhtempo);
                    $('.nominal').val(addCommas(response.fpg[0].fpgb_nominal));
                    $('.keterangan').val(response.fpg[0].fpg_keterangan);
                    $('.bank').val(response.fpg[0].mb_kode);
                    $('.namabank').val(response.fpg[0].mb_nama)
                    $('.tgl').val(response.fpg[0].fpg_tgl );
                    $('.idbank').val(response.fpg[0].mb_id);
                    $('.akunkodebank').val(response.fpg[0].fpg_kodebank);
                    $('.hutangdagang').val(response.fpg[0].fpg_acchutang);
                    $('.akunuangmuka').val(response.fpg[0].fpg_accum);
                    $('.jenisbayarfpg').val(response.fpg[0].fpg_jenisbayar);
                    $('.idfpgb').val(response.fpg[0].fpgb_id);

                if(response.fpg[0].fpg_jenisbayar == '2' || response.fpg[0].fpg_jenisbayar == '3' ) {                  
                    $('.kodesup').val(response.fpg[0].no_supplier);
                    $('.namasupplier').val(response.fpg[0].nama_supplier); 
                    $('.jenissup').val('supplier');            
                }
                else if(response.fpg[0].fpg_jenisbayar == '4') {
                    $jenissup = response.jenissup;
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
            }
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

      $nmrbiaya = 1;
      totalbiaya = 0;
      $('#tmbhdatabiaya').click(function(){
          akun = $('.akun').val();
          nobbk = $('.nobbk').val();
          flag = $('.flag').val();

          kodecabang = $('.kodebank').val();
          $('.kodebank').addClass('disabled');
         // alert(kodecabang);
          $('.valkodebank').val(kodecabang);

          $('#tabcekbg').addClass('disabled');
          $('#tabcekbgakun').addClass('disabled');

          if(flag == 'CEKBG'){
            toastr.info("Anda sudah mengisi form 'CEK BG' mohon untuk dilanjutkan :)");
          
          }
          else if(akun == ''){
            toastr.info("Mohon isi data akun bank");
          }
          else if(nobbk == ''){
            toastr.info("Mohon isi data cabang");
          }
          else {
            $('.flag').val('BIAYA');
          akun = $('.akun').val();
          string = akun.split(",");
          idakun = string[0];
          dk = $('.dk').val();
          jumlah = $('.jumlahaccount').val();
          keterangan = $('.keteranganbiaya').val();
          nobbk = $('.nobbk').val();

          rowHtml = "<tr class='transaksi transaksi"+$nmrbiaya+"'> <td>"+$nmrbiaya+"</td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+nobbk+"' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+idakun+"' name='akun[]' readonly> </td>" +
          "<td>  <input type='text' class='input-sm form-control' value='"+dk+"' name='dk[]' readonly> </td>" +
          "<td> <input type='text' class='input-sm form-control jumlah' value='"+jumlah+"' name='jumlah[]' style='text-align:right' data-dk='"+dk+"' readonly> </td>" +
          "<td><input type='text' class='input-sm form-control' value=' "+keterangan+"' name='keterangan[]' readonly></td>" +
          "<td> <button class='btn btn-danger btn-sm remove-btn' type='button' data-id="+$nmrbiaya+" data-cek='"+akun+"' data-nominal='"+jumlah+"'><i class='fa fa-trash'></i></button>  </td> </tr>";

          $('#tbl-biaya').append(rowHtml);


          $('.biaya').val('');

          jumlah2 = jumlah.replace(/,/g, '');
          if(dk == 'D'){
              totalbiaya = parseFloat(parseFloat(totalbiaya) + parseFloat(jumlah2)).toFixed(2);
          }
          else {
            totalbiaya = parseFloat(parseFloat(totalbiaya) - parseFloat(jumlah2)).toFixed(2);
          }
          $('.totalbiaya').val(addCommas(totalbiaya));
          $('.total').val(addCommas(totalbiaya));
          $nmrbiaya++;

          }

           jmlahval = 0;
          $('.jumlah').change(function(){  
             val = $(this).val();
             val2 = accounting.formatMoney(val, "", 2, ",",'.');
              
              $(this).val(val2);
              dk = $(this).data('dk');
              $('.jumlah').each(function(){
                val2 = $(this).val();
                dk = $(this).data('dk');
                jmlval = val2.replace(/,/g, '');
                if(dk == 'D'){
                  jmlahval = parseFloat(parseFloat(jmlahval) + parseFloat(jmlval)).toFixed(2);
                }
                else {
                  jmlahval = parseFloat(parseFloat(jmlahval) - parseFloat(jmlval)).toFixed(2);

                }
              })

              //alert(jmlahval);
              console.log(jmlahval + 'jmlahval');

              $('.total').val(addCommas(jmlahval));
              $('.totalbiaya').val(addCommas(jmlahval));
          })
      })

     

      $(document).on('click','.remove-btn',function(){
            id = $(this).data('id');
            cek = $(this).data('cek');
            nominal = $(this).data('nominal');
            parentbayar = $('.transaksi'+id);
        //    $('#datacek' + cek).show();
            biaya = $('.biaya').val();
            biaya2 =  biaya.replace(/,/g, '');
            nominal2 = nominal.replace(/,/g,'');
            $('.biaya').val('')
            nilaibiaya = parseInt(biaya2) - parseInt(nominal2).toFixed(2);
            $('.totalbiaya').val(addCommas(nilaibiaya));
            $('.total').val(addCommas(nilaibiaya));
         //   parent.remove();
            parentbayar.remove();
          })

</script>
@endsection
