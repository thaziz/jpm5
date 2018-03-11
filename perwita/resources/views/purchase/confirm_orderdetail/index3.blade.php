@extends('main')

@section('title', 'dashboard')

@section('content')


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

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">

                    <h5> Konfirmasi Order Detail
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                    
                          <a class="btn btn-success" href="{{url('konfirmasi_order/konfirmasi_order')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    
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
                          <table border="0">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="idspp" value="{{$spp->spp_id}}" class="idspp">
                           <input type="hidden" name="idco" value="{{$spp->co_id}}">
                          <tr>
                            <td width="200px">
                              No SPP
                            </td>
                            <td>
                               <input type="text" class="form-control" readonly="" value="{{$spp->spp_nospp}}">
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
                             <input type="text" class="form-control" readonly="" value="{{$spp->spp_tgldibutuhkan}}">
                            </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                      

                          <tr>
                            <td>
                              Keperluan
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_keperluan}}">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              &nbsp;
                            </td>
                          </tr>

                          <tr>
                            <td>
                             Cabang
                            </td>
                            <td>
                              <input type="text" class="form-control" readonly="" value="{{$spp->spp_cabang}}">
                            </td>
                          </tr>

                          </table>

                         </div>




                         </div>
                    @endforeach
                    </div>
                 

                    <br>

                    <hr>
                    
                    <h4> Data Barang </h4>

                    <hr>
                    
                  @if($data['countcodt'] > 0)
                     <table class="table table-bordered table-striped" id="hargatable">
                      <tr>
                        <th rowspan="2"  style="width:20px"> No </th>
                        <th rowspan="2"  style="width:200px"> Nama Barang </th>
                        <th rowspan="2"  style="width:50px"> Jumlah Permintaan </th>
                        <th rowspan="2"  style="width:50px"> Jumlah Disetujui </th>
                        <th rowspan="2"  style="width:50px"> Satuan </th>
                        <th colspan= {{$data['count']}} style="text-align: center"> Supplier </th>
                      </tr>

                      <tr class="data-supplier">
                         <!--  @foreach($data['codt_supplier'] as $index=>$codtsup)
                          <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codt_supplier}}">
                            <select class="form-control supplier{{$index}} sup" name="supplier[]"  data-supplier="{{$codtsup->codt_supplier}}" disabled="">
                                  <option value="{{$codtsup->codt_supplier}}"> {{$codtsup->codt_supplier}} </option>
                              @foreach($data['supplier'] as $sup)
                              <option value="{{$codtsup->codt_supplier}}" @if($codtsup->codt_supplier == $sup->no_supplier) selected="" @endif>  {{$sup->nama_supplier}};
                              </option>
                            
                             @endforeach 
                            </select> --> 
                            <td class="supplier{{$index}} spl" data-id="{{$index}}" data-supplier="{{$codtsup->codt_supplier}}" style="text-align: center">
                               {{$codtsup->nama_supplier}}
                           </td> 
                         <!--  @endforeach -->
                      </tr>


                      @foreach($data['codt'] as $idbarang=>$codt)
                      <tr class="brg{{$idbarang}}" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$codt->codt_kodeitem}}" >
                        <td> {{$idbarang + 1}} </td>
                        <td> {{$codt->nama_masteritem}} </td>
                        <td> {{$codt->codt_qtyrequest}} </td>
                        <td> {{$codt->codt_qtyapproved}} </td>
                        <td>  @if ($codt->sg_qty == '')
                           Kosong
                            @else
                            {{$codt->sg_qty}}
                             @endif
                         </td>
                         @foreach($data['codt_supplier'] as $codtsupp)
                          <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier"> </td>
                         @endforeach
                       
                      </tr>

                      @endforeach
                       <tr class="totalbiaya"> <td colspan="5" style="text-align: center"> Total Biaya </td> 
                        @foreach($data['codt_tb'] as $cotb)
                          <td data-suppliertotal="{{$cotb->cotb_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='form-control totalbiaya'  value="{{number_format($cotb->cotb_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>

                     

                     </table>
                  @else 


                  <table border=0> 
                  <tr>
                    <td style="width:10px">
                    </td>
                    <td>  <h4> Edit Data Barang ? </h4> </td>
               
                   <td> </td>
                   <td>     <button class="btn btn-sm btn-primary edit" type="button"> Edit Data</button> </div> </td>
                  </tr>

                <!--   <tr>
                    <td> Total : <div class="total"> </div> </td>
                  </tr> -->
                  </table>

                <div class="box-body">
                
                <table id="hargatable" class="table table-bordered table-striped">
                    <thead>
                     <tr>
                        <th style="width:20px" rowspan="2"> No  </th>
                        <th style="width:150px; text-align: center" rowspan="2"> Nama Barang</th>
                        <th style="width:50px" rowspan="2"> Jumlah Permintaan </th>
                        <th style="width:50px" rowspan="2"> Jumlah Disetujui </th>
                        <th style="width:50px" rowspan="2"> Stock Gudang </th>
                        <th style="width:70px" rowspan="2"> Satuan </th>
                      
                      
                        <th style="width:700px; text-align: center" colspan="{{$data['count']}}"> Supplier </th>

                    
                    </tr>

                   <!--  supplier -->
                    <tr class="data-supplier">
                      @foreach($data['spptb'] as $index=>$spptb)
                      <td class="supplier{{$index}}" data-id="{{$index}}" data-supplier="{{$spptb->spptb_supplier}}"> 
                            <select class="form-control supplier{{$index}} sup" name="supplier[]" disabled="">
                             @foreach($data['supplier'] as $sup)
                              <option value="{{$spptb->no_supplier}}" @if($spptb->spptb_supplier == $sup->no_supplier) selected="" @endif>  {{$sup->nama_supplier}}
                              </option>
                            
                             @endforeach
                            </select>
                          </div>
                    <!--   <label  class="col-sm-6 control-label hapus sup"> </label> -->
                        </div>
                      </td> 
                      @endforeach
                    </tr>

                 
                    </thead>
                    <tbody>
                        @foreach($data['sppdt_barang'] as $idbarang=>$sppd)
                 
                      <tr class="brg{{$idbarang}}" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$sppd->sppd_kodeitem}}" >
                        <td>  {{$idbarang + 1}} </td>
                        <td> 
                            <select class="form-control item" disabled="" name="item[]">
                              @foreach($data['item'] as $item)
                                <option value="{{$sppd->sppd_kodeitem}}" @if($sppd->sppd_kodeitem == $item->kode_item) selected="" @endif> {{$item->nama_masteritem}} </option>
                              @endforeach
                            </select>
<!-- 
                               <input type="text" class="form-control" value=" {{$sppd->nama_masteritem}} " readonly="">  </td> -->
                             
                        </td>
                        <td>  <input type="text" class="form-control qtyrequest{{$idbarang}}" value="{{$sppd->sppd_qtyrequest}}" readonly="" name="qtyrequest[]">  </td>
                        <td>  <input type="text" class="form-control qty qtyapproval{{$idbarang}}" readonly="" name="qtyapproval[]" data-id="{{$idbarang}}">  </td>
                        <td> 
                        @if ($sppd->sg_qty == '')
                           Kosong
                        @else
                        {{$sppd->sg_qty}}
                         @endif
                         </td>

                        <td> <input type="text" class="form-control satuan" value="{{$sppd->unitstock}} " disabled=""></td>
                        <!-- hargasupplier-->
                   
                       <!--    @foreach($data['spptb'] as $index=>$spptb)                        
                             <td> 
                             <div class="form-group">
                              <label class="col-sm-1 control-label"> @ </label>
                              <label class="col-sm-1 control-label"> Rp </label> 
                             <div class="col-sm-5">
                                <input type="text" class="form-control harga{{$index}} hrg"  readonly="" data-id="{{$index}}" name="harga[]" value="2900.00">
                              </div>

                            <div class="col-sm-1">
                              <a class="btn-setuju{{$index}}" data-id="{{$index}}" data-count="{{$index}}" data-supplier=""> <i class="fa fa-check" aria-hidden="true"></i> 
                              </a> 
                            </div>

                               
                                <table border="0" id="table">
                                    <tr>
                                        <td>    <div class="disetujui{{$index}}" data-id="{{$index}}"> </div> </td>
                                    </tr>

                                    <tr>
                                        <td>   <div class="btlsetuju{{$index}}" data-id="{{$index}}"> </div>  </td>
                                    </tr>
                                </table>
                            

                            </div>
                            </td> 
                            
                        
                           @endforeach -->

                             @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
                         
                      </tr>                     
                      @endforeach


                        <tr class="totalbiaya"> <td colspan="6" style="text-align: center"> Total Biaya </td> 
                        @foreach($data['spptb'] as $spptb)
                          <td data-suppliertotal="{{$spptb->spptb_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='form-control totalbiaya'  value="{{number_format($spptb->spptb_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>

                        <tr>
                          <td> <div class="hsltb"> </div> </td>
                        </tr>
                    </tbody>
                   
                  </table>
                 
                    
                </div><!-- /.box-body -->
                 @endif  
                <div class="box-footer">
                  <div class="pull-right">
                     @if($data['countcodt'] < 1)
                      
                      <a class="btn btn-danger" onclick="cek_tb({{$data['count_brg']}})"> Cek Total Biaya </a>
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

      function cek_tb(index){ 
        var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').serialize();
       
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         
        $.ajax({    
          type :"post",
          data : idspp,
          url : url,
          dataType:'json',
          success : function(data){

          $('.simpan').attr('disabled', false);
              var harga = [];
      var arrtotal = [];
      var nmsupplier = [];
      var newArray = [];


      for(var i = 0; i < data.sppdt.length; i++){    
      var isDisabled = $('#hrga' + i).prop('disabled');

        if (isDisabled) {
          var harga = $('#hrga' + i).val();
          var idbrg = $('#hrga' + i).data('brg');
       
        }
        else {
          var harga = $('#hrga' + i).val();

          var idbarang = $('#hrga' + i).data('brg');

          var idsupplier = $('#hrga' + i).data('hrgsupplier');

          var qty = $('.qtyapproval' + idbarang).val();

          var qty2 = $('.qtyapproval' + idbarang).index();
         
          totalharga = parseInt(harga * qty);
          
         

          arrtotal.push("totalharga :" +  totalharga + "," +  "idsupplier :" + idsupplier);

           newArray.push({
            totalharga : totalharga ,
            idsupplier :  idsupplier});
        }
     
        }

      

      console.log(arrtotal);
      console.log(newArray);
    

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

       console.log(result);

         //beda in supplier
           for(var x=0;x<data.spptb.length;x++){  //2itusupplier               
                  var supDisabled = $('.supplier'+x).is(':disabled');;                
                  if(supDisabled){
                     var supplier1 = $('.supplier' + x).index() + 1;
                     biaya2 = 0;
                      $('tr.totalbiaya').find("td").eq(supplier1).html(addCommas(biaya2));
                   
                  }                 
            }

          for(var h=0;h<result.length;h++){


                    var supplier2 = $('td[data-supplier="'+ result[h].id + '"]').index() + 1;
                    var biaya = Math.round(result[h].totalharga).toFixed(2);
                    var tb = '<div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-sm-8"> <input type="text" class="form-control totalbiaya" name="bayar[]" value="'+addCommas(biaya)+'" readonly="" > <input type="hidden" name="tb[]" value="'+result[h].id+ "," + result[h].totalharga +'"> </div>  </div>';

                    $('tr.totalbiaya').find("td").eq(supplier2).html(tb);

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

          }



        })
     }

    $(function(){
      var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').serialize();
       
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({     
          type :"post",
          data : idspp,
          url : url,
          dataType:'json',
          success : function(data){
          console.log(data);

            if(data.codt.length > 0) {

              $('#hargatable').each(function(){

                for(var n=0; n < data.sppdt_barang.length; n++){
                  var kodebrg = $('.brg' + n).data("kodeitem");
                    console.log($('.brg0').data("kodeitem"));
                    for(var i = 0; i < data.codt.length; i++){
                        if(kodebrg == data.codt[i].codt_kodeitem) {

                          for (var j = 0; j < data.codt_tb.length; j++) {
                            if(data.codt[i].codt_supplier == data.codt_tb[j].cotb_supplier){
                              var row = $('td[data-supplier="'+ data.codt[i].codt_supplier + '"]').index() + 5; 
                              console.log('row' + row);
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="form-control hrg harga'+i+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+data.codt[i].codt_harga+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.codt[i].codt_supplier+'">  </div>';

                                    


                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                            }
                          }
                        }
                    }
                }

              })
            }          
            if(data.codt.length == 0) { 
              $('#hargatable').each(function(){
              console.log(data.sppdt_barang.length);
                      for(var n=0;n<data.sppdt_barang.length;n++){
                       var kodebrg =  $('.brg'+ n).data("kodeitem");
                       console.log('kodebrg');
                       console.log(kodebrg);
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
                                        
                                        tampilharga += '<input type="text" class="form-control hrg harga'+i+'"  disabled="" data-id="'+i+'" name="harga[]" value="'+data.sppdt[i].sppd_harga+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.sppdt[i].sppd_supplier+'">  </div> <div class="datasup'+ i +'"> </div> ';

                                        //disetujui
                                        tampilharga +=  '<div class="col-sm-1">' +
                                                        '<button class="btn btn-outline btn-default btn-sm btn-setuju'+i+'" id="cek0" data-count="'+i+'" data-supplier='+data.sppdt[i].sppd_supplier +' onclick="btnsetuju('+i+')" data-n="'+n+'" type="button"> <i class="fa fa-check" aria-hidden="true"></i>' + 
                                                          '</button>';

                                        //btn setuju-tdksetuju
                                     /*   tampilharga += '<table border="0" id="table">' +
                                                       '<tr>' +
                                                           '<td>    <div class="disetujui" data-id=""> </div> </td>' +
                                                      '</tr>'+
                                                      '<tr>' +
                                                          '<td>   <div class="btlsetuju" data-id=""> </div>  </td> ' +
                                                      '</tr>' +
                                                     '</table>' +
                                                    '</div>';
                                      */

                                      tampilharga +=  '<div class="disetujui'+i+'" data-id="'+i+'"> </div>  <div class="btlsetuju'+i+'" data-id="'+i+'" data-supplier='+data.sppdt[i].sppd_supplier+' data-harga='+data.sppdt[i].sppd_harga+' data-totalhrg='+data.spptb[j].spptb_totalbiaya+'> </div> </div> </div> ';

                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                                }

                                }
                              }  
                            }
                      }
                 })
              
              }
             }

        })
 
      })

   $('.qty').change(function(){
                    val = $(this).val();
                    id = $(this).data('id');

                    qtyrequest = $('.qtyrequest' + id).val();
                  
                    /*  if(val > qtyrequest) {
                        alert('Maaf, angka melebihi dari jumlah permintaan :) ');
                        kosong = '';
                        $(this).val(kosong);
                      }
*/
                    $('.simpan').prop("disabled" , true);
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
                harga = $(this).val();
               /* indexhrg = $(this).index();
                console.log(indexhrg);*/

                numhar = Math.round(harga).toFixed(2);
                  

               var tdtotalsuplier = $('td[data-suppliertotal="'+ datasupplier + '"]');
               // $('.harga' + index).val(addCommas(numhar));
                $('.harga' + index).val(numhar);

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
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
         
                $('.harga' + id).val(addCommas(numhar));
            
              $('.simpan').prop("disabled" , true);
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
       //  $('.sup').attr('disabled', false);
      

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
