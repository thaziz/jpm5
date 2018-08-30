@extends('main')

@section('title', 'dashboard')

@section('content')


<style>
  .row-eq-height {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

    .table input{
      padding-left: 5px;
    }

    .table th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
      font-size : 12px;
    }

    .table td{
       font-size : 12px;
    }

    .table input{
     
      font-size :12px;
    }

    .table select{
    
      font-size :12px;
    }


    .hargatable {
      width: 800px; margin: 0 auto;
    }
   /* #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    #tree th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
    }

    #tree td.secondTree{
      padding-left: 40px;
    }

    #tree td{
      border: 0px;
      padding: 5px;
    }

    #tree td.{
      color:blue;
    }

    #tree td.highlight{
      border-top:2px solid #aaa;
      border-bottom: 2px solid #aaa;
      color:#222;
    }

    #tree td.break{
      padding: 10px 0px;
      background: #eee;
    }

    #bingkai td.header{
      font-weight: bold;
    }

    #bingkai td.child{
      padding-left: 20px;
    }

    #bingkai td.total{
      /*border-top: 2px solid #999;*/
    /*  font-weight: 600;
    }

    #bingkai td.no-border{
      border: 0px;
    }*/

  </style>

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Order </h2>
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
                            <strong> Konfirmasi Order </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
              <br>
          <div class="alert alert-info" id="statuskeuangan">
              <p> Pihak Keuangan bisa melakukan transaksi jika pihak pembelian sudah mensetujui transaksi ini </p>
          </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5> Konfirmasi Order SPP
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                    
                          <a class="btn btn-sm btn-default" href="{{url('konfirmasi_order/konfirmasi_order')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    
                    </div>
                </div>
                  <form method="post" action="{{url('konfirmasi_order/savekonfirmasiorderdetail')}}"  enctype="multipart/form-data" class="form-horizontal">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->



                
                @foreach($data['spp'] as $spp)
                  <div class="box-body">
                    <div class="row">
                      <div class="col-xs-6">
                          <table border="0" class="table">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="idspp" value="{{$spp->spp_id}}" class="idspp">
                           <input type="hidden" name="idco" value="{{$spp->co_id}}">
                          <tr>
                            <td width="200px">
                             <b> No SPP </b>
                            </td>
                            <td>
                               <input type="text" class="form-control" readonly="" value="{{$spp->spp_nospp}}">
                            </td>
                          </tr>
                          <tr>
                            <td> <b> Tanggal </b> </td>
                            <td>
                             <input type="text" class="form-control" readonly="" value="{{$spp->spp_tgldibutuhkan}}">
                            </td>
                          </tr>
                          <tr>
                            <td>
                             <b> Keperluan </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_keperluan}}">
                            </td>
                          </tr>
                           <tr>
                            <td>
                             <b> Keterangan </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_keterangan}}">
                            </td>
                          </tr>
                          <tr>
                            <td>
                            <b> Cabang </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->nama}}">
                            </td>
                          </tr>

                           <tr>
                            <td>
                            <b> Tipe </b>
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$namatipe}}">
                              <input type="hidden" class="prosespembelian" readonly="" value="{{$spp->staff_pemb}}">
                            </td>
                          </tr>

                          <tr>
                            <td> <b> Pemroses </b> </td>
                            <td class="disabled"> 
                                <select class="form-control pemroses" name="pemroses">
                                      
                                      <option value="PEMBELIAN" selected="">
                                         PIHAK PEMBELIAN
                                      </option>
                                   </select>

                            {{--  @if(Auth::user()->punyaAkses('Konfirmasi Order Keu','aktif'))
                                   <select class="form-control pemroses" name="pemroses">
                                      <option value="KEUANGAN" selected="">
                                          PIHAK KEUANGAN
                                      </option>
                                      <option value="PEMBELIAN">
                                         PIHAK PEMBELIAN
                                      </option>
                                   </select>
                                  @elseif(Auth::user()->punyaAkses('Konfirmasi Order','aktif'))
                                     <select class="form-control pemroses" name="pemroses">
                                          <option value="KEUANGAN">
                                              PIHAK KEUANGAN
                                          </option>
                                          <option value="PEMBELIAN" selected="">
                                              PIHAK PEMBELIAN
                                          </option>
                                       </select>
                                  @endif --}}
                            </td>
                          </tr>

                          </table>
                         </div>

                         <div class="col-xs-6">
                            <table class="table">
                              <tr>
                                <th colspan="2" style="text-align:center">
                                    Status Persetujuan
                                </th>
                              </tr>
                              <tr>
                                  <th style="text-align:center"> Staff Pembelian </th>
                                  <th style="text-align:center"> Manager Keuangan </th>
                              </tr>
                              <tr>
                                  <th> 
                                      @if($spp->staff_pemb == 'DISETUJUI')
                                         <div style='text-align: center'>  <p class="label label-info" > {{$spp->staff_pemb}} </p> </div>
                                      @else
                                        <div style='text-align: center'>  <p class="label label-danger" > BELUM DI PROSES </p> </div>
                                      @endif
                                  </th>
                                  <th>
                                    @if($spp->man_keu == 'DISETUJUI')
                                       <div style='text-align: center'>  <p class="label label-info" > {{$spp->man_keu}} </p> </div>
                                    @else
                                      <div style='text-align: center'> <p class="label label-danger" style='text-align: center'> BELUM DI PROSES </p> </div>
                                    @endif
                                  </th>
                              </tr>
                            </table>
                         </div>
                         </div>
                    @endforeach
                    </div>

                    <hr>
                    
                    <h4> Data Barang </h4>

                    <hr>
                    
                  @if($data['countcodt'] > 0)
                     <table class="table table-bordered table-striped hargatable" id="hargatable" style="width:100%">
                      <tr>
                        <td rowspan="2"  style="width:20px"> No </td>
                        <td rowspan="2"  style="width:200px"> Nama Barang </td>
                        <td rowspan="2"  style="width:50px"> Jumlah Permintaan </td>
                        <td rowspan="2"  style="width:50px"> Jumlah Disetujui </td>
                        <td rowspan="2"  style="width:50px"> Satuan </td>
                        <td rowspan="2"  style="width:50px"> Stock Gudang </td>
                        <td colspan= {{$data['count']}} style="text-align: center"> Supplier </td>
                      </tr>

                      <tr class="data-supplier">
                         <!--  @foreach($data['codt_supplier'] as $index=>$codtsup)
                          <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codtk_supplier}}">
                            <select class="form-control supplier{{$index}} sup"  data-supplier="{{$codtsup->codtk_supplier}}" disabled="">
                                  <option value="{{$codtsup->codtk_supplier}}"> {{$codtsup->codtk_supplier}} </option>
                              @foreach($data['supplier'] as $sup)
                              <option value="{{$codtsup->codtk_supplier}}" @if($codtsup->codtk_supplier == $sup->no_supplier) selected="" @endif>  {{$sup->nama_supplier}};
                              </option>
                            
                             @endforeach 
                            </select> --> 
                            <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codtk_supplier}}" style="text-align: center">
                               {{$codtsup->nama_supplier}}
                           </td> 
                         <!--  @endforeach -->
                      </tr>


                      @foreach($data['codt'] as $idbarang=>$codt)
                      <tr class="brg{{$idbarang}}" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$codt->codtk_kodeitem}}" >
                        <td> {{$idbarang + 1}} </td>
                        <td> {{$codt->nama_masteritem}} </td>
                        <td> {{$codt->codtk_qtyrequest}} </td>
                        <td> {{$codt->codtk_qtyapproved}} </td>
                        <td> {{$codt->unitstock}}</td>
                        <td> 
                        @if($tipespp != 'J')
                          @if($codt->sg_qty == '')
                           Kosong
                            @else
                            {{$codt->sg_qty}}
                             @endif
                        @else
                          -
                          @endif

                         </td>
                         @foreach($data['codt_supplier'] as $codtsupp)
                          <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier"> </td>
                         @endforeach
                       
                      </tr>

                      @endforeach
                       <tr class="totalbiaya"> <td colspan="6" style="text-align: center"> <b> Total Biaya </b> </td> 
                        @foreach($data['codt_tb'] as $cotb)
                          <td data-suppliertotal="{{$cotb->cotbk_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='input-sm form-control totalbiaya'  value="{{number_format($cotb->cotbk_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>

                     

                     </table>
                  @else 

                  <table border=0> 
                  <tr>
                    <td style="width:10px">
                    </td>
                    <td>  <h4> Konfirmasi Order Detail</h4> </td>
               
                   <td> &nbsp; </td>
                   <td>    <!--  <button class="btn btn-sm btn-primary edit" type="button"> Edit Data</button> --> </div> </td>
                   <td>
                    </td>
                  </tr>
                  </table>

                <div class="box-body">
                
                <table id="hargatable" class="table table-bordered hargatable" style="width:100%">
                    <thead>
                     <tr>
                        <td style="width:20px" rowspan="2"> No  </td>
                        <td style="width:150px; text-align: center" rowspan="2"> Nama Barang</td>
                        <td style="width:50px" rowspan="2"> Jumlah Permintaan </td>
                        <td style="width:50px" rowspan="2"> Jumlah Disetujui </td>
                        <td style="width:50px" rowspan="2"> Stock Gudang </td>
                        <td style="width:70px" rowspan="2"> Satuan </td>                      
                        <td style="width:500px; text-align: center" colspan="{{$data['count']}}"> Supplier </td>
                        <td rowspan="2" style="width:20px;"> Ditolak </td>
                        <td rowspan="2"> Keterangan Tolak </td>
                    
                    </tr>

                   <!--  supplier -->
                    <tr class="data-supplier">
                      @foreach($data['spptb'] as $index=>$spptb)
                      <td class="supid supplier{{$index}}" data-id="{{$index}}" data-supplier="{{$spptb->spptb_supplier}}"> 
                            <select class="input-sm form-control supplier{{$index}} sup" name="supplier3[]" disabled="" data-supplier="{{$spptb->spptb_supplier}}" data-id="{{$index}}" style="color:#000">
                             @foreach($data['supplier'] as $sup)
                              <option value="{{$sup->idsup}},{{$sup->syarat_kredit}},{{$sup->kontrak}}" @if($spptb->spptb_supplier == $sup->idsup) selected="" @endif>  {{$sup->nama_supplier}} 
                             @endforeach
                            </select>
                          </div>
                   
                        </div>
                          <input type="hidden" value="{{$spptb->spptb_bayar}}" name="spptb_bayar[]" class="bayar{{$index}}">
                      </td> 
                      @endforeach
                    </tr>

                 
                    </thead>
                    <tbody>
                        @foreach($data['sppdt_barang'] as $idbarang=>$sppd)
                 
                      <tr class="brg{{$idbarang}}" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$sppd->sppd_kodeitem}}" >
                        <td>  {{$idbarang + 1}} </td>
                        <td> 
                            <select class="input-sm form-control item" readonly="" name="item[]">
                              @foreach($data['item'] as $item)
                                <option value="{{$sppd->sppd_kodeitem}}" @if($sppd->sppd_kodeitem == $item->kode_item) selected="" @endif> {{$item->nama_masteritem}} </option>
                              @endforeach
                            </select>
<!-- 
                               <input type="text" class="form-control" value=" {{$sppd->nama_masteritem}} " readonly="">  </td> -->
                             
                        </td>
                        <td>  <input type="text" class="input-sm form-control qtyrequest qtyrequest{{$idbarang}}" value="{{$sppd->sppd_qtyrequest}}" readonly="" name="qtyrequest[]" data-id="{{$idbarang}}">  </td>
                        <td>  <input type="text" class="input-sm form-control qty qtyapproval{{$idbarang}}"  name="qtyapproval[]" data-id="{{$idbarang}}" required="">  </td>
                       
                        <td> 
                         @if($tipespp != 'J')
                          @if($sppd->sg_qty == '')
                           Kosong
                            @else
                            {{$sppd->sg_qty}}
                             @endif
                        @else
                          -
                          @endif
                         </td>


                        <td> <input type="text" class="input-sm form-control satuan" value="{{$sppd->unitstock}} " disabled=""></td>
                        <!-- hargasupplier-->
                   
                            @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
                        <td>  <div class="checkbox">
                                <input id="tolak tolak{{$idbarang}}" type="checkbox" data-id="{{$idbarang}}" class="tolak tolak{{$idbarang}}" data-barang="{{$sppd->sppd_kodeitem}}">
                                  <label for="tolak{{$idbarang}}">   
                                  </label>
                              </div>
                        </td>   

                        <td> <input type="text" class="form-control input-sm kettolak kettolak{{$idbarang}}" name="keterangantolak[]" > <input type="hidden" class="databarangtolak" name="databarangtolak[]"> <input type="hidden" class="status status{{$idbarang}}" name="status[]" value="SETUJU"> </td>
                      </tr>                     
                      @endforeach


                        <tr class="totalbiaya"> <td colspan="6" style="text-align: center"> <b> Total Biaya </b> </td> 
                        @foreach($data['spptb'] as $spptb)
                          <td data-suppliertotal="{{$spptb->spptb_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='input-sm form-control totalbiaya'  value="{{number_format($spptb->spptb_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>
<!-- 
                        <tr>
                          <td> <div class="hsltb"> </div> </td>
                        </tr> -->
                    </tbody>
                   
                  </table>
                 
                    
                </div><!-- /.box-body -->
                 @endif  
                <div class="box-footer">
                  <div class="pull-right">
                     @if($data['countcodt'] < 1)
                      
                      <a class="btn btn-danger cektotal" onclick="cek_tb({{$data['count_brg']}})"> Cek Total Biaya </a>
                      <button type="submit" class="btn btn-success btn-flat simpan" disabled=""> Simpan </button>
                      </form>
                    @endif
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
  $('.kettolak').attr('readonly' , true);
     $('#statuskeuangan').hide();
  prosespembelian = $('.prosespembelian').val();
  pemroses = $('.pemroses').val();
  if(pemroses == 'KEUANGAN'){
      if(prosespembelian !== "DISETUJUI"){
          $('.cektotal').attr('disabled' , true);
          $('#statuskeuangan').show();
      }
      else {
         $('#statuskeuangan').hide();
      }
     
  }
  else {
    $('#statuskeuangan').hide();
    $('.cektotal').attr('disabled' , false);  
  }

  $('.pemroses').change(function(){
    val = $(this).val();
    if(val == 'KEUANGAN'){
       if(prosespembelian != "DISETUJUI"){
          $('.cektotal').attr('disabled' , true);
          $('#statuskeuangan').show();
        }
        else {
           $('#statuskeuangan').hide();
        }
    }
    else {
        $('#statuskeuangan').hide();
        $('.cektotal').attr('disabled' , false);  
    }
   
  })

   $('body').removeClass('fixed-sidebar');
            $("body").toggleClass("mini-navbar");

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




    $('.sup').each(function(){
        $(this).change(function(){
          id = $(this).data('id');
          val = $(this).val();
         //// alert(val);
          string = val.split(",");
          syaratkredit = string[1];
          $('.bayar' + id).val(syaratkredit);
      })
    })

    $('.tolak').change(function(){
      var id = $(this).data('id');
        if($('input.tolak'+id).is(':checked')){
        
          $('.qtyapproval'+id).attr('readonly' , true); 
           $('.checkbox' + id).prop('checked' , false); 
          $('.checkbox' + id).attr('disabled' , true);
          $('.kettolak' + id).attr('readonly' , false);

          $('.hrga' + id ).attr('readonly' , true); 
          $('.simpan').attr('disabled', true);
          $('.hrga' + id).val('0');
          databarang = $(this).data('barang');
          $('.databarangtolak').val(databarang);
          $('.status' + id).val('TOLAK');
        }
        else {
        $('.qtyapproval'+id).attr('readonly' , false); 
          $('.checkbox' + id).attr('disabled' , false);
         $('.kettolak'+id).attr('readonly' , true); 
          hargahid = $('.hargahid' + id).val();
          $('.status' + id).val('SETUJU');
        //  alert(hargahid);
          $('.hrga' + id).val(hargahid);
          
        }
    })

      function cek_tb(index){ 

        var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').val();
        var pemroses = $('.pemroses').val();

        $temp = 0;
            $('.checkboxhrg').each(function(){
              if ($(this).is(":checked")) {
                $temp = $temp + 1;
              }
            })
        

       if($temp == 0){
        if($('input.tolak'+id).is(':checked')){
         // alert('test');
        }
        else {
          toastr.info("Harap centang supplier yang dipilih");
          return false;
        }
       }

        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    
      
         
        $.ajax({    
          type :"GET",
          data : {idspp,pemroses},
          url : url,
          dataType:'json',
          success : function(data){

          $('.simpan').attr('disabled', false);
          var harga = [];
          var arrtotal = [];
          var nmsupplier = [];
          var newArray = [];


          for(var i = 0; i < data.sppdt.length; i++){   
              testharga = $('#hrga' + i).val();
              if(testharga == undefined){

              } 
              else {
              var isDisabled = $('#hrga' + i).prop('disabled');

                if(isDisabled) {
                  
                  var harga = $('#hrga' + i).val();
                  var idbrg = $('#hrga' + i).data('brg');              
                }
                else {

                  var harga = $('#hrga'+i).val();

                  var idbarang = $('#hrga'+i).data('brg');

                  var idsupplier = $('#hrga'+i).data('hrgsupplier');

                  var qty = $('.qtyapproval'+idbarang).val();

                  var qty2 = $('.qtyapproval'+idbarang).index();
                 
                  harga2 = harga.replace(/,/g,'');
                  totalharga = parseFloat(harga2 * qty);
                  
                  console.log('qty' + qty);
                  console.log(harga + 'harga');

                  arrtotal.push("totalharga :" +  totalharga + "," +  "idsupplier :" + idsupplier);

                   newArray.push({
                    totalharga : totalharga ,
                    idsupplier :  idsupplier});
                }
              }
            }
      
            console.log(arrtotal);
            console.log(newArray + 'newArray');



            var hrgtotal = [];
            for (var j=0;j<arrtotal.length;j++){
                 var pecahstring  = arrtotal[j].split(",");
                 var supplier = pecahstring[1];
                 var harga = pecahstring[0];
                 nmsupplier.push(supplier);
                 hrgtotal.push(harga);
              }

              var datasupplier = [];
              for(var k=0; k < 2; k++){
                var data_supplier= $('.supplier' + k).data('supplier');
                  datasupplier.push(data_supplier);
                  console.log(data_supplier);
              }


              var harga = 0;
              var g = 0;
              var h = 1;
              var totalharga = [];
              var tothar = [];

            

              var result = [];
              newArray.reduce(function (res, value) {
                  if (!res[value.idsupplier]) {
                      res[value.idsupplier] = {
                          totalharga: 0,
                          id: value.idsupplier
                      };
                      result.push(res[value.idsupplier])
                  }
                  res[value.idsupplier].totalharga += value.totalharga
                  return res;
              },{});

    
                 
            //CEK SEMUA DATA SUPPLIER
                var lengthsup = $('.supid').length;
              
                var arrkosong = [];
                     //PERULANGAN RESULT
                 var lengthsup = $('.supid').length;
                 for(var p = 0; p < result.length; p++){
                console.log('hmm');
                console.log('hmm');
                 for(var z =0; z < lengthsup; z++){
                   var datasup = $('.supplier' + z).data('supplier');
                   console.log('yek');
                   console.log(datasup + 'datasup');
                   console.log(result[p].id + 'result');
                    if(result[p].id != datasup ){
                      
                       var supplier1 = $('td[data-supplier="'+ datasup + '"]').index() + 1;
                       biaya2 = 0;
                       $('tr.totalbiaya').find("td").eq(supplier1).html(addCommas(biaya2))
                    }
                  }
                }



                for(var j = 0; j < result.length; j++){

                 //PERULANGAN RESULT
               /*  for(var z =0; z < lengthsup; z++){
                   var datasup = $('.supplier' + z).data('supplier');
                    if(result[j].id != datasup ){
                      console.log('yesy');
                       var supplier1 = $('td[data-supplier="'+ datasup + '"]').index() + 1;
                       biaya2 = 0;
                       $('tr.totalbiaya').find("td").eq(supplier1).html(addCommas(biaya2))
                    }
                  }*/

                  for(var k = 0; k < lengthsup; k++){
                      var datasup = $('.supplier' + k).data('supplier');
                                      
                      if(result[j].id == datasup) {
                        var supplier3 = $('td[data-supplier="'+ datasup + '"]').index() + 1;
                          var biaya = Math.round(result[j].totalharga).toFixed(2);
                          var tb = '<div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-sm-8"> <input type="text" class="input-sm form-control totalbiaya" name="bayar[]" value="'+addCommas(biaya)+'" readonly="" > <input type="hidden" name="tb[]" value="'+result[j].id+ "," + result[j].totalharga +'">  <input type="hidden" name="datasupplier[]" value="'+datasup+'"> </div>  </div>';
                      
                          $('tr.totalbiaya').find("td").eq(supplier3).html(tb);
                      }
                  } 


                }
            

                      var counthrg = $('.hrg').length;
                      var countqty = $('.qty').length;
                       //supplier
                      var countsup = $('.sup').length;
                   //     console.log(countsup);

                   for(var k=0; k <  countqty; k++) {
                     $('.qtyapproval' + k).change(function(){
                          


                          $('.simpan').prop("disabled" , true);
                        })
                  }
                      for(var n=0; n <  counthrg; n++) {
                         $('.harga' + n).change(function(){
                               
                              $('.simpan').prop("disabled" , true);
                            })
                      }

                },
                error : function(){
                  location.reload();
                }



        })
     }

    $(function(){
      var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').val();
        var pemroses = $('.pemroses').val();
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({     
          type :"GET",
          data : {idspp,pemroses},
          url : url,
          dataType:'json',
          success : function(data){
          
            if(data.codt.length > 0) {

              $('#hargatable').each(function(){
                for(var n=0; n < data.sppdt_barang.length; n++){
                  var kodebrg = $('.brg' + n).data("kodeitem");
             
                    for(var i = 0; i < data.codt.length; i++){
                        if(kodebrg == data.codt[i].codtk_kodeitem) {
                       
                          for (var j = 0; j < data.codt_tb.length; j++) {

                            if(data.codt[i].codtk_supplier == data.codt_tb[j].cotbk_supplier){
                              var row = $('td[data-supplier="'+ data.codt[i].codtk_supplier + '"]').index() + 6; 
                                     // alert(data.codt[i].codtk_harga);
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="input-sm form-control hrg harga'+i+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+addCommas(data.codt[i].codtk_harga)+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.codt[i].codtk_supplier+'"> <input type="hidden" value="'+addCommas(data.codt[i].codtk_harga)+' class="hargahid'+i+'" "> </div>';
                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                            }
                          }
                        }
                    }
                }

              })
            } 
            var nourut = 1;         
            if(data.codt.length == 0) { 
              $('#hargatable').each(function(){
              console.log(data.sppdt_barang.length);
                      for(var n=0;n<data.sppdt_barang.length;n++){
                       var kodebrg =  $('.brg'+ n).data("kodeitem");
                          for(var i = 0 ; i <data.sppdt.length;i++){
                            if(kodebrg == data.sppdt[i].sppd_kodeitem) {
                               for(var j =0; j < data.spptb.length; j++){
                                if(data.sppdt[i].sppd_supplier == data.spptb[j].spptb_supplier) {
                                        var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 6; 
                                        console.log(row);
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="input-sm form-control hrg harga'+i+' hrga'+n+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+addCommas(data.sppdt[i].sppd_harga)+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.sppdt[i].sppd_supplier+'" data-kontrak="'+data.sppdt[i].sppd_kontrak+'" data-hargaasli="'+data.sppdt[i].sppd_harga+'"> <input type="hidden" value="'+addCommas(data.sppdt[i].sppd_harga)+'" class="hargahid hargahid'+i+'" data-brg="'+n+'" data-id="'+i+'""> <input type="hidden" class="statuskontrak'+i+'" data-brg="'+n+'" data-id="'+i+'" value="'+data.sppdt[i].sppd_kontrak+'">  </div> <div class="datasup'+ i +'">  </div> ';

                                        tampilharga += '<div class="col-sm-2"> <div class="checkbox checkbox-primary ">' +
                                            '<input id="cek" type="checkbox" value='+data.sppdt[i].sppd_supplier+' class="checkboxhrg checkbox'+n+'" data-val='+i+' data-id='+nourut+' required data-supplier='+data.sppdt[i].sppd_supplier+' data-harga='+data.sppdt[i].sppd_harga+' data-totalhrg='+data.spptb[j].spptb_totalbiaya+' data-n='+n+' data-kontrak='+data.sppdt[i].sppd_kontrak+'>' +
                                            '<label for="checkbox'+nourut+'">' +  
                                            '<div class="suppliercek'+nourut+'">  </div> '                                           
                                            '</label>' +
                                        '</div> </div>';

                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  


                                         $('input[class^="checkbox"]').change(function(){
                                           var $this = $(this);
                                          idsup = $(this).val();
                                          id = $(this).data('id');
                                          val = $(this).data('val');
                                          n = $(this).data('n');
                                          supplier = $(this).data('supplier');
                                          kontrak = $(this).data('kontrak');
                                                $('.checkbox'+n).each(function(){
                                                  if($this.is(":checked")) {

                                                      rowsupplier = "<input type='hidden' value="+idsup+" name='datasup[]'>";
                                                      $('.suppliercek'+id).html(rowsupplier);

                                                      $('.harga' + val).attr('disabled', false);

                                                      $('.hrg').each(function(){
                                                        dataid = $(this).data('id');
                                                        datan = $(this).data('brg');
                                                        if(datan == n){
                                                          if(dataid != val){
                                                            $(this).val('0');
                                                          }
                                                        }
                                                      })

                                                      $(".checkbox"+n).not($this).prop({ disabled: true, checked: false }); 
                                                      $('.simpan').attr('disabled', true);          

                                                      $('.sup').each(function(){
                                                        supplier = $(this).data('supplier');
                                                        if(supplier == idsup){
                                                          $(this).attr('disabled', false);
                                                          if(kontrak == 'YA'){
                                                            $('td[data-supplier="'+supplier+ '"]').addClass('disabled');
                                                          }
                                                          else {
                                                             $('td[data-supplier="'+supplier+ '"]').removeClass('disabled');
                                                          }
                                                        }
                                                      })
                                                    
                                                  } else {
                                                        
                                                    hargaasli = $(this).data('harga');
                                                     $('.hrg').each(function(){
                                                        dataid = $(this).data('id');
                                                        datan = $(this).data('brg');
                                                        nilai = $('.hargahid' + dataid).val();

                                                        if(datan == n){
                                                          if(dataid != val){
                                                            $(this).val(addCommas(nilai));
                                                          }
                                                        }
                                                      });

                                                   

                                                      $('.suppliercek'+id).empty();

                                                      $('.harga' + val).prop("disabled" , true);

                                                      $(".checkbox"+n).prop("disabled", false);
                                                      $('.simpan').attr('disabled', true);  

                                                      $('.sup').each(function(){
                                                        supplier = $(this).data('supplier');
                                                        if(supplier == idsup){
                                                          $(this).attr('disabled', true);
                                                        }
                                                      })
                                                  }
                                                })
                                        })

                                        $('.hrg').each(function(){
                                        $(this).change(function(){
                                          kontrak = $(this).data('kontrak');
                                          harga = $(this).data('hargaasli');
                                          if(kontrak == 'YA'){
                                            toastr.info("Barang termasuk kontrak, tidak bisa dirubah :)");
                                            $(this).val(addCommas(harga));
                                            return false;
                                          }
                                          else{
                                            val = $(this).val();    
                                            val = accounting.formatMoney(val, "", 2, ",",'.');
                                            $(this).val(val);
                                          }
                                        })
                                      })


                                }

                                }
                              }  
                              nourut++;
                            }
                      }
                 })
              
              }
             },
			 error : function(){
				location.reload();
			 }

        })
 
      })
  

  $('.qtyrequest').each(function(){
    id = $(this).data('id');
    val = $(this).val();
    $('.qtyapproval'+id).val(val);
    console.log('val' + id);
  })


  
   $('.qty').each(function(){
      $(this).change(function(){
        val = $(this).val();
        id = $(this).data('id');
        qtyrequest = $('.qtyrequest' + id).val();
        $('.simpan').prop("disabled" , true);
      })
   })
   
    
    var total = 0;
     function btnsetuju(index) {

          var thisis = $(this);
          var indexcol = thisis.index();
    //      console.log(indexcol);
          var val = index;
      //    $('.datasup' + val).remove();
          var kosong = '';
          var datasupplier = $('.btn-setuju' + index).data('supplier');
          var thiss = $('.btn-setuju' + val).data('n');
          console.log(thiss);
          var ttd = '<label class="control-label"> Disetujui </label>';
          var batal = '<span class="label label-danger" style="cursor:pointer" onclick="btlsetuju('+index+')" data-btlsupplier="'+datasupplier+'" data-n="'+thiss+'"> BATAL SETUJU </span>';
          

          var data_supplier = "<input type='hidden' value="+datasupplier+" name='datasup[]'>"; 
          $('.datasup' + val).html(data_supplier);

//          $('.btn-setuju'+val).not($(this)).hide();

         // .prop('disabled', true);
         /* $('#cek0').prop('disabled', true);*/

          $('.harga' + val).attr('disabled', false);
          $('.disetujui' + val).html(ttd);
          $('.btlsetuju' + val).html(batal);
        //  $('.btn-setuju' + val).empty();

        //disabled centang setuju
//        var supliersetuju = $('td[data-tbsupplier="'+ datasupplier+'"]');

  //      ('td#supplier').not(suppliersetuju).find($('#cek0')).hide();

          //disabled-supplier
         var tdsuplier = $('td[data-supplier="'+ datasupplier + '"]');


          (tdsuplier).find("select").attr('disabled', false);

           $('.harga' + index).change(function(){
                var id = $(this).data('id');
                val = $(this).val();
            
                val = accounting.formatMoney(val, "", 2, ",",'.');

               var tdtotalsuplier = $('td[data-suppliertotal="'+ datasupplier + '"]');
               // $('.harga' + index).val(addCommas(numhar));
                $('.harga' + index).val(val);

               // (tdtotalsuplier).find("input").val(addCommas(numhar));
               /* total = parseInt(harga) + total;
                totalnum = Math.round(total).toFixed(2);
                $('.total').html(addCommas(total));*/

          })
      }

      function btlsetuju(index){
        var val = index;       
        var icon = '<a class="btn-setuju'+index+'" data-id="'+index+'" data-count="'+index+'"  onclick="btnsetuju('+index+')"> <i class="fa fa-check" aria-hidden="true"></i>' +
              '</a> </div>';

      

         var harga = $('.btlsetuju' + index).data('harga');
         var datasupplier = $('.btlsetuju' + index).data('supplier');
         var thiss = $('.btlsetuju' + index).data('n');

            $('.harga' + val).attr('disabled', true);

           $('.harga' + val).val(harga);
            
            $('.btlsetuju'+ val).empty();
            $('.disetujui' + val).empty();   
            $('.btn-setuju' + val).html(icon);
            kosong = '';
                $('.datasup' + val).empty();

          var tdsuplier = $('td[data-supplier="'+ datasupplier + '"]');
          (tdsuplier).find("select").attr('disabled', true);   
      }



    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   

    //harga
      var counthrg = $('.hrg').length;
      var countqty = $('.qty').length;
  //    alert(counthrg);

       //supplier
      var countsup = $('.sup').length;
   //     console.log(countsup);



      for(var n=0; n <  counthrg; n++) {
         $('.harga' + n).change(function(){
                var id = $(this).data('id');
                var kontrak = $(this).data('kontrak');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
               
                if(kontrak == 'YA'){
                  toastr.info("Tidak bisa mengedit harga, karena termasuk harga kontrak :)");
                  return false;
                }
                else if(kontrak == 'TIDAK') {
                  $('.harga' + id).val(addCommas(numhar));
                  $('.simpan').prop("disabled" , true);

                }
            })
      }

       
     /* 
      for (var k=0; k<counthrg; k++){
         $('.btn-setuju'+k).click(function(){ 
              var val = $(this).data('id');
              var count = $(this).data('count');
    //          $('.harga' + val).attr('readonly', false);
              var sup = $(this).data('supplier');
          //    alert(val);

              var kosong = '';
              var ttd = '<label class="control-label"> Disetujui </label>';
              var batal = '<span class="label label-danger" style="cursor:pointer"> BATAL SETUJU </span>'
              $('.harga' + count).attr('disabled', false);


              $('.disetujui' + count).html(ttd);
              $('.btlsetuju' + count).html(batal);

              

              for(var i=0; i < counthrg; i++) {
              if($('.btn-setuju'+ k).data('id') == val) {
                if($('.btn-setuju'+k).data('supplier')  != sup) {
                  $('.btn-setuju'+k).prop('disabled', true);
                }
              }
              }
          })

           $('.btlsetuju' + k).click(function(){
                     var val = $(this).data('id');
                     $('.harga' + val).attr('disabled', true);
                     $(this).remove();
                     $('.disetujui' + val).remove();
                })
    }*/

      $('.edit').click(function(){
    
         $('.qty').attr('readonly', false);
       
    //     $('.sup').attr('disabled', false);
         $('.item').attr('disabled', false);
         $('.sup').attr('disabled', false);
      

         var hapusSup =" <div class='col-sm-2'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a </div>";
         $('.hapusup').html(hapusSup); 
        
        var hapusbrg = "<label class='col-sm-2 col-sm-2 control-label'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a> </label>";

         $('.hapusbarang').html(hapusbrg);

       //hapusupplier
     })

   
    
    function setujumngstaffpemb() {
      document.getElementById("setujui").disabled = true;
       $(this).find($(".fa")).removeClass('fa-check')
    

       var input = "<input type='text' hidden value='DISETUJUI'  name='mngstaffpemb'>";
      $('.inputmngstaffpemsetuju').html(input);
       var setuju = 'DISETUJUI';
      $('.setujui').html(setuju);
    }

   /* $('.mngstffpemb').click(function(){
     /* $(this).next('i').slideToggle('500');

      $(this).find($(".fa")).toggleClass('fa-check fa-times');*/
     /* $(this).find($(".fa")).removeClass('fa-check');
      
      var setuju = 'DISETUJUI';
      $('.setujui').html(setuju);
      $('.setujui').disabled = true;

    })*/

     function setujumngpemb() {
      document.getElementById("setujuipemb").disabled = true;
       $(this).find($(".fa")).removeClass('fa-check')

       var input = "<input type='text' hidden value='DISETUJUI' name='mngpembsetuju'>";
       var setuju = 'DISETUJUI';
      $('.setujuipemb').html(setuju);
    //  $('.inputmngpemsetuju').html(input);
    }



</script>
@endsection
