@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .disabled {
    pointer-events: none;
    opacity: 1;
  }

  .table {
   overflow-x: scroll
  }

 

</style>

           <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Detail SPP </h2>
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

                    <h5> Surat Permintaan Pembelian Detail
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                    
                          <a class="btn btn-md btn-default" href="{{url('suratpermintaanpembelian')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    
                    </div>
                </div>
                 
            <div class="ibox-content">
            <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->


                @foreach($data['spp'] as $spp)
                 <form method="post" action="{{url('suratpermintaanpembelian/updatesupplier/'.$spp->spp_id.'')}}"  enctype="multipart/form-data" class="form-horizontal">              
                  <div class="box-body">
                    <div class="row">
                      <div class="col-xs-6">
                          <table border="0" class="table">
                           <input type="hidden" name="_token" value="{{ csrf_token() }}">
                           <input type="hidden" name="idspp" value="{{$spp->spp_id}}" class="idspp">
                          <tr>
                            <td width="200px">
                              <b> No SPP </b>
                            </td>
                            <td>
                               <input type="text" class="form-control" readonly="" value="{{$spp->spp_nospp}}" name="nospp">
                            </td>
                          </tr>


                          <tr>
                            <td> <b> Tanggal di Butuhkan</b> </td>
                            <td>
                           <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required="" value="{{ Carbon\Carbon::parse($spp->spp_tgldibutuhkan)->format('d-M-Y') }}" disabled="">
                             </div> 
                            </td>
                          </tr>

                          <tr>
                            <td>
                             <b> Keperluan </b>
                            </td>
                            <td>
                              <input type="text" class="form-control keperluan" readonly="" value="{{$spp->spp_keperluan}}" name="keperluan">
                            </td>
                          </tr>

                           <tr>
                              <td> 
                               <b> Tgl Input  </b>
                              </td>
                              <td> 
                                <input type='text' class='form-control' value="{{ Carbon\Carbon::parse($spp->tglinput)->format('d-M-Y ')}}" readonly=""> 
                              </td>
                           </tr>
                                        
                        

                          <tr>
                            <td>
                            <b> Cabang </b>
                            </td>
                            

                            <td>  <select class="form-control cabang" name="cabang" disabled="">
                            
                                @foreach($data['cabang'] as $cbg) 
                                 <option value="{{$spp->spp_cabang}}" @if($spp->spp_cabang == $cbg->kode) selected="" @endif>  {{$cbg->nama}} </option>
                                @endforeach
                                
                                </select>

                            </td>
                          </tr>

                        
                          <tr>
                            <td> <b> Bagian / Department </b> </td>
                            <td> 
                              <select class="form-control Department" name="cabang" disabled=""> @foreach($data['department'] as $department) <option value="{{$department->kode_department}}" @if($department->kode_department == $spp->kode_department) selected="" @endif> {{$department->nama_department}} </option> @endforeach </select>

                            </td>
                          </tr>
                     

                          @if($spp->spp_lokasigudang != '')
                          <tr>
                            @foreach($data['gudang'] as $gudang)
                             <td> <b> Lokasi Gudang </b> </td>   <td> <input type="text" class="form-control gudang" value="{{$gudang->mg_namagudang}}" readonly=""> </td>
                             @endforeach
                          </tr>
                          @endif

                          <tr>
                            <td> <b> Keterangan </b></td>
                            <td> <input type="text" class="form-control keterangan" value="{{$spp->spp_keperluan}}" readonly=""> </td>
                          </tr>
                          </table>

                         </div>

                         <div class="col-sm-6">
                          <div class="tampilbayar"> </div>
                           <h4> <a href="{{url('suratpermintaanpembelian/cetakspp/'.$spp->spp_id.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </h4>

                           <div class="kettolak">
                           </div>

                            @if(Auth::user()->punyaAkses('SPP Kabag','aktif'))
                            <button class='btn btn-sm btn-info' type="button" id="createmodal" data-toggle="modal" data-target="#myModal2">
                              <i class="fa fa-info-circle"> </i>
                                Mengetahui Kabag
                             
                            </button>
                            @endif
                         </div>
                         </div>
                   @endforeach



                    </div>
                  </div>
         
              <div class="wrapper wrapper-content animated fadeInRight">
                  <table border=0> 
                 
                  @if(Auth::user()->punyaAkses('Purchase Order','ubah'))
                   <!--  @if($data['countcodt'] < 1)

                    <td>  <h4> Edit Data Barang ? </h4> </td>
               
                   <td> &nbsp; </td>
                   <td>     <button class="btn btn-sm btn-info edit" type="button"> Edit Data</button> </div> </td>
                  </tr>

                  @endif -->
                  @endif
                  </table>
                
                <div class="box-body">
                <br>
                <div style="overflow-x:auto;">
                <table id="hargatable" class="table table-bordered" style="width:100%">
                    <thead>
                     <tr>
                        <td style="vertical-align: center" rowspan="2"> No  </td>
                        <td style="text-align: center;vertical-align: center" rowspan="2"> Nama Barang</td>
                        <td  rowspan="2"> Jumlah Permintaan </td>
                       <!--  <th style="width:50px" rowspan="2"> Jumlah Disetujui </th> -->
                      
                         @if($data['countkendaraan'] > 0)           
                            <td rowspan="2"> Kendaraan </td>                         
                         @endif

                        <td style="vertical-align: center" rowspan="2"> Stock Gudang </td>
                        <td style="vertical-align: center" rowspan="2"> Satuan </td>
                      
                      
                        <td style="text-align: center;vertical-align: center" colspan="{{$data['count']}}"> Supplier </td>

                    
                    </tr>
                     
                   <!--  supplier -->
                    <tr class="data-supplier">
                      @foreach($data['spptb'] as $index=>$spptb)
                      <td class="supplier{{$index}}" data-id="{{$index}}" data-supplier="{{$spptb->spptb_supplier}}"> 
                          <select id="sup" class="chosen-select-width spl sp{{$index}}" name="idsup[]" data-index="{{$index}}" disabled="">
                             @foreach($data['supplier'] as $sup)
                              <option value="{{$spptb->spptb_supplier}}, {{$spptb->syarat_kredit}}, {{$spptb->nama_supplier}}" @if($spptb->spptb_supplier == $sup->no_supplier) selected="" @endif>  {{$spptb->no_supplier}} - {{$spptb->nama_supplier}} 
                              </option>
                            
                             @endforeach
                            </select>

                            <input type="hidden" name="idspptb[]" value="{{$spptb->spptb_id}}">
                      </td> 
                      @endforeach
                    </tr>

                 
                    </thead>
                    <tbody>
                        @foreach($data['sppdt_barang'] as $idbarang=>$sppd)
                 
                      <tr class="brg{{$idbarang}} barang" data-id="{{$idbarang}}" id="brg" data-kodeitem="{{$sppd->sppd_kodeitem}}" >
                        <td>  {{$idbarang + 1}} </td>
                        <td> 
                            <select class="chosen-select-width itm item{{$idbarang}}"  name="item[]" id="item" disabled="">
                              @foreach($data['item'] as $item)
                               <option value="{{$item->kode_item}}" @if($sppd->sppd_kodeitem == $item->kode_item) selected="" @endif> {{$item->kode_item}} - {{$item->nama_masteritem}}
                              </option>
                              @endforeach
                            </select>
                             
                        </td>
                        <td>  <input type="text" class="form-control qty qtyreq{{$idbarang}}" value="{{$sppd->sppd_qtyrequest}}" readonly="" name="qtyrequest[]">  </td>
                    
                         @if($data['countkendaraan'] > 0) 
                          @foreach($data['kendaraan'] as $kndaraan)
                            <td> <select class="form-control kendaraan" disabled=""> @foreach($data['masterkendaraan'] as $msterkendaraan) <option value="{{$msterkendaraan->id_vhc}}" @if($kndaraan->sppd_kendaraan == $msterkendaraan->id_vhc) selected="" @endif  > {{$msterkendaraan->vhccde}} - {{$msterkendaraan->merk}}  </option> @endforeach </select> </td>
                          @endforeach
                         @endif


                        <td> 
                        @if($data['tipespp'] != 'J')
                        @if ($sppd->sg_qty == '')
                           Kosong
                        @else
                        {{$sppd->sg_qty}}
                         @endif
                         @else
                          -
                         @endif
                         </td>

                      
                        <td> <input type="text" class="form-control satuan" value="{{$sppd->unitstock}} " disabled=""></td>

                            <!-- harga -->
                            @foreach($data['spptb'] as $index=>$spptb)
                                <td class="supplier{{$index}}" data-id="{{$index}}" id="supplier" data-tbsupplier="{{$spptb->spptb_supplier}}"> </td>
                            @endforeach
                         
                      </tr>                     
                      @endforeach

                           @if($data['countkendaraan'] > 0) 
                             <tr class="totalbiaya"> <td colspan="6" style="text-align: center"> <b> Total Biaya </b> </td> 
                           @else
                              <tr class="totalbiaya"> <td colspan="5" style="text-align: center"> <b> Total Biaya </b> </td> 
                           @endif
                      

                        @foreach($data['spptb'] as $spptb)
                          <td data-suppliertotal="{{$spptb->spptb_supplier}}"> <div class='form-group'> <label class='col-sm-2 col-sm-2 control-label'> Rp </label> <div class='col-sm-8'> <input type='text' class='form-control totalbiaya' name='bayar[]' value="{{number_format($spptb->spptb_totalbiaya, 2)}}" readonly="" > </div>  </div></td>
                          @endforeach
                        </tr>
                    </tbody>
                   
                  </table>
                 </div>
                      
                      <!-- Modal -->
                       <div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                                      <div class="modal-dialog">
                                          <div class="modal-content">
                                             <div class="modal-header">
                                                 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                              <h4 class="modal-title">KEPALA BAGIAN  </h4>     
                                             </div>
                                    

                                      <div class="modal-body">
                                        <table border="0" class="table">
                                          <tr>
                                              <th>
                                                  <i class="fa fa-check"> </i> Kepala Bagian
                                              </th>
                                              
                                          </tr>
                                          <tr>
                                            <th>
                                                Nama 
                                            </th>
                                            <td>
                                                <input type="text" class="form-control" name="namakabag" value="{{Auth::user()->m_username}}">
                                            </td>
                                          </tr>
                                          <tr>
                                            <th>
                                              Keterangan
                                            </th>
                                            <td>
                                                <input type="text" class="form-control" name="keterangankabag">
                                            </td>
                                          </tr>
                                        </table>
                                        
                                        <button class="btn btn-primary" type="submit">
                                          <i class="fa fa-check"> </i> Ya, Saya Mengetahui dan Menyetujui
                                        </button>

                                      </div>

                                
                               </div>
                          </div> 
                              </div> <!-- ENd Modal -->



                </div><!-- /.box-body -->
                  
                <div class="box-footer">
                  <div class="pull-right">
                      
                      <div class="editdata"> </div>
                    
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


    $(document).ready(function(){
      var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }

             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }

    })

    idspp = $('.idspp').val();
    $.ajax({
      data : {idspp},
      url :baseUrl + '/suratpermintaanpembelian/kettolak',
      dataType : "json",
      type : "get",
      success : function(response){
       // alert(response[0].nama_masteritem);
       var table = "<br><h4>DATA YANG DITOLAK OLEH PUSAT </h4> <table border='0' class='table'> " +
                  "<tr> <th> No </th> <th> Nama Barang </th> <th> Keterangan di Tolak </th> </tr>";
                    if(response.length == 0){
                        table += "<tr> <td> - </td> <td> - </td> <td> - </td> </tr>";
                    }
                    else {
                        for(i=0; i < response.length; i++){
    
                          no = 1;
                          table += "<tr> <td>"+ no +"</td> <td>"+response[i].nama_masteritem+"</td> <td>"+response[i].sppd_kettolak+"</td> </tr>";
                          no++;
                        }
                    }

                table += "</table>";
            $('.kettolak').html(table);
      }
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


    var countsup = $('.spl').length;
    var countitem = $('.itm').length;
    console.log(countitem);

    var arritem = [];
    $(function(){
      for (var z = 0; z < countitem; z++ ){
          var value = $('.item' + z).val();
          arritem.push(value);
      }
    })

        var arrSup = [];
       $(function(){
        $('[id^=sup]').change(function(){
          var valuesup = $(this).val();
          var pecahstring  = valuesup.split(",");
          var kodesupplier = pecahstring[0];
          var syarat_kredit = pecahstring[1];
          var namasupplier = pecahstring[2];
          var indexsup = $(this).data('index');
          console.log(indexsup);
          $('.simpan').attr('disabled', true);

       

          var tampilbyr = '<div class="col-sm-5"> <input type="text" class="form-control byr bayar'+indexsup+'" value='+syarat_kredit+' readonly id="bayar" data-id="'+indexsup+'"> </div> Hari';
           

             var supplier = '<input type="text" name="idsuplier[]" value='+kodesupplier+'>';
             var syaratkredit = '<input type="text" name="syaratkredit[]" value='+syarat_kredit+'>';
            $('.tampilsupplier'+indexsup).html(supplier);
            $('.tampilsyaratkredit'+indexsup).html(syaratkredit);
            
       
          
            $('tr#supplierid').find($('.sp'+indexsup)).html(namasupplier);       
            $('tr#supplierid').find($('.bayar'+indexsup)).html(tampilbyr);   


          $('.byr').each(function(){
               $(this).change(function(){
                 value = $(this).val();
                 id = $(this).data('id');

                  var syaratkredit = '<input type="text" name="syaratkredit[]" value='+value+'>';
                //  $('.tampilsupplier'+indexsup).html(supplier);
                  $('.tampilsyaratkredit'+id).html(syaratkredit);
               })
          })
        })
      })


     
    //pembayaran
    $(function(){
      var arrValSup = [];

 
  

      for(var j =0 ; j < countsup;j++){
       var value =  $('.sp'+j).val();

        var pecahstring  = value.split(",");
        var kodesupplier = pecahstring[0];
        var syarat_kredit = pecahstring[1];
        var namasupplier = pecahstring[2];

        arrValSup.push({
          kodesupplier : kodesupplier,
          syarat_kredit : syarat_kredit,
          namasupplier : namasupplier
        })
      }

      console.log(arrValSup);

      var tampilbayar = '<table class="table table-striped dataTable">' +                       
                          '<tr>' +
                            '<th> Nama Supplier </th>' +
                            '<th> Pembayaran </th>' +
                          '</tr>';

      var ok = [];     

      console.log(arrValSup);



      for(var k=0;k<countsup;k++){
         tampilbayar +=                      
                          '<tr id="supplierid">' +
                            '<td class=sp'+k+'>'+arrValSup[k].namasupplier +'</td>' +
                            '<td class=bayar'+k+'> <div class="col-sm-5"> <input type="text" class="form-control byr bayar'+k+'" value='+arrValSup[k].syarat_kredit+' readonly  id="bayar" data-id='+k+'> </div> Hari';
                            
                            '</td>' +
                          '</tr>' +
                         '</table>';

       $('.tampilbayar').html(tampilbayar);  


        $('.byr').each(function(){
             $(this).change(function(){
               value = $(this).val();
               id = $(this).data('id');

                var syaratkredit = '<input type="text" name="syaratkredit[]" value='+value+'>';
              //  $('.tampilsupplier'+indexsup).html(supplier);
                $('.tampilsyaratkredit'+id).html(syaratkredit);
             })
        })

      }
       



    })

    $(function(){
      var url = baseUrl + '/konfirmasi_order/ajax_confirmorderdt';
        var idspp = $('.idspp').serialize();
       
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        console.log(idspp);
        $.ajax({     
          type :"get",
          data : idspp,
          url : url,
          dataType:'json',
          success : function(data){
         
              $('#hargatable').each(function(){    
                      for(var n=0;n<data.sppdt_barang.length;n++){
                       var kodebrg =  $('.brg'+ n).data("kodeitem");
                       console.log('kodebrg');
                       console.log(kodebrg);
                          for(var i = 0 ; i <data.sppdt.length;i++){
                            if(kodebrg == data.sppdt[i].sppd_kodeitem) {
                               for(var j =0; j < data.spptb.length; j++){
                                if(data.sppdt[i].sppd_supplier == data.spptb[j].spptb_supplier) {
                                    console.log(data.sppdt[i].sppd_supplier + 'supplier');
                                        if(data.sppdt[i].sppd_kendaraan != null) {
                                          var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 6;
                                        }
                                        else {
                                         var row = $('td[data-supplier="'+ data.sppdt[i].sppd_supplier + '"]').index() + 5; 
                                        }
                                        var column = $('td', this).eq(row);
                                        var tampilharga = '<div class="form-group">' +
                                                          '<label class="col-sm-1 control-label"> @ </label>' +
                                                           '<label class="col-sm-1 control-label"> Rp </label>' + 
                                                            '<div class="col-xs-6">';
                                        
                                        tampilharga += '<input type="text" class="form-control hrg harga'+i+'"  readonly="" data-id="'+i+'" name="harga[]" value="'+addCommas(data.sppdt[i].sppd_harga)+'" data-brg="'+n+'" id="hrga'+i+'" data-hrgsupplier="'+data.sppdt[i].sppd_supplier+'"> </div>';

                                        tampilharga += '<input type="hidden" name="itembarang[]" value="'+arritem[n]+''+','+''+n+'" >';
                                        
                                        tampilharga += '<div class="tampilsupplier'+j+'"> <input type="hidden" name="idsuplier[]" value='+data.spptb[j].spptb_supplier+'> </div>';

                                        tampilharga += '<div class="tampilsyaratkredit'+j+'"> <input type="hidden" name="syaratkredit[]" value='+data.sppdt[i].sppd_bayar+'> </div>';

                                        tampilharga += '<input type="hidden" name="idsppd[]" value='+data.sppdt[i].sppd_idsppdetail+'>';
                                      tampilharga +=  '<div class="disetujui'+i+'" data-id="'+i+'"> </div>  <div class="btlsetuju'+i+'" data-id="'+i+'" data-supplier='+data.sppdt[i].sppd_supplier+' data-harga='+data.sppdt[i].sppd_harga+' data-totalhrg='+data.spptb[j].spptb_totalbiaya+'> </div> </div> </div> ';

                                        $('tr.brg'+n).find("td").eq(row).html(tampilharga);  
                                }

                                }
                              }  



                            }
                      }

                                $('.hrg').each(function(){
                                  $(this).change(function(){
                                     var id = $(this).data('id');
                                      harga = $(this).val();
                                      numhar = Math.round(harga).toFixed(2);
                                      $('.harga' + id).val(addCommas(numhar));
                                  })
                                })

                 })
                

              
             }

        })
 
      })




    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   

    //harga
      var counthrg = $('.hrg').length;
  //    alert(counthrg);

   
   //     console.log(countsup);

   


       
    function cek_tb(){
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
                var harga = [];
      var arrtotal = [];
      var nmsupplier = [];
      var newArray = [];

       $('.simpan').attr('disabled', false);

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

          var qty = $('.qtyreq' + idbarang).val();

          var qty2 = $('.qtyreq' + idbarang).index();
          
          hasil_harga = harga.replace(/,/g, '');

          totalharga = parseInt(hasil_harga * qty);
       
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
        for(var k=0; k < data.spptb,length; k++){
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

        for(var x=0;x<data.spptb.length;x++){  //2itusupplier               
          var supplier2 = $('td[data-supplier="'+ result[x].id + '"]').index() + 1;
          var biaya = Math.round(result[x].totalharga).toFixed(2);
          var tb = '<div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-sm-8"> <input type="text" class="form-control totalbiaya" name="bayar[]" value="'+addCommas(biaya)+'" readonly="" > </div>  </div>';
          $('tr.totalbiaya').find("td").eq(supplier2).html(addCommas(tb));                  
                
          }


         
        }
      })
    
    } 
        
  
     
      $(function(){
            $('.qty').change(function(){
                $('.simpan').attr('disabled', true);

              })
          

          });
  
     // $('#sup').attr('disabled', true);

      $('.edit').click(function(){
    
         $('.qty').attr('readonly', false);
         $('.hrg').attr('readonly', false);
         $('.byr').attr('readonly', false);
         $('.gudang').attr('readonly', false);

         $('.tgl').attr('readonly', false);
         $('.keperluan').attr('readonly', false);
         $('.cabang').attr('disabled', false);
         $('.bagian').attr('disabled', false);
         $('.department').attr('disabled', false);
         $('.kendaraan').attr('disabled', false);
         $('.keterangan').attr('readonly', false);


       
         // $('.spl').attr('disabled', false);
        $('.itm').attr('disabled', false);
        $('#sup').attr('disabled', false);
       

         var hapusSup =" <div class='col-sm-2'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a </div>";
         $('.hapusup').html(hapusSup); 
        
        var hapusbrg = "<label class='col-sm-2 col-sm-2 control-label'> <a class='btn btn-danger'> <i class='fa fa-trash'> </i> </a> </label>";

        var edit = "<a class='btn btn-danger' onclick='cek_tb()'> Cek Total Biaya </a> &nbsp;" +
                      "<button type='submit' class='btn btn-success btn-flat simpan' disabled> Simpan </button>";

        

         $('.editdata').html(edit);             
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
