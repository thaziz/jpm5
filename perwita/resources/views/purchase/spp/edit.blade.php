@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .textcenter{
    text-align: center;
  }
  .textright{
    text-align: right;
  }

  .disabled {
    pointer-events: none;
    opacity: 1;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Surat Permintaan Pembelian </h2>
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
                            <strong> Create Surat Permintaan Pembelian  </strong>
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
                    <h5> Surat Permintaan Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>

                <div class="ibox-content">
                   <div class="row">
                       <div class="col-xs-12">
                          <div class="box-header">
                          </div><!-- /.box-header -->


                           <form method="post" action="{{url('suratpermintaanpembelian/savesupplier')}}"  enctype="multipart/form-data" class="form-horizontal" id="formId">
                          <div class="box-body">
                            
                              <div class="col-md-6">
                                    <table class="table table-striped" id='table-utama'>@foreach($data['spp'] as $spp)
                                          <tr>
                                            <td width="200px"> Kode SPP </td>
                                            <td> <input type='text' class="input-sm form-control nospp" readonly="" name="nospp" value="{{$spp->spp_nospp}}"></td>
                                            <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="hidden" name="idspp" value="{{$spp->spp_id}}" class="idspp">
                                          </tr>
                                          
                                          <tr>
                                              
                                             <tr>
                                              <td> Cabang </td>
                                              <td>   
                                                <select class="form-control chosen-select cabang" name="cabang">
                                                  @foreach($data['cabang'] as $cabang)
                                                  <option value="{{$cabang->kode}}" @if($cabang->kode == $spp->spp_cabang) selected="" @endif>
                                                      {{$cabang->kode}} - {{$cabang->nama}}
                                                  </option>
                                                  @endforeach
                                                </select>
                                              </td>
                                             </tr>
                                              
                                          </tr>

                                          <tr>
                                              <td>
                                                Tanggal Input
                                              </td>
                                              <td>
                                                   <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tglinput" name="tgl_dibutuhkan" required="" value="{{ Carbon\Carbon::parse($spp->spp_tglinput)->format('d-M-Y ') }}" >
                                              </td>  
                                          </tr>
                                      
                                          <tr>
                                              <td>
                                                Tanggal di butuhkan 
                                              </td>
                                              <td>
                                                   <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required="" value="{{ Carbon\Carbon::parse($spp->spp_tgldibutuhkan)->format('d-M-Y ') }}">
                                              </td>  
                                          </tr>
                                         
                                          <tr>
                                            <td>
                                              Keperluan
                                            </td>

                                            <td> 
                                            <input type="text" class="input-sm form-control" name="keperluan" required="" value="{{$spp->spp_keperluan}}"> <input type="hidden" class="valcabang" name="cabang">
                                            </td>
                                          </tr>
                                        
                                        <tr>
                                          <td>
                                            Bagian / Department
                                          </td>
                                          <td>
                                            <select class="chosen-select-width" name="bagian" required="">
                                              <option value> -- Pilih Bagian / Departmen -- </option>
                                             @foreach($data['department'] as $department) <option value="{{$department->kode_department}}" @if($department->kode_department == $spp->kode_department) selected="" @endif> {{$department->nama_department}} </option> @endforeach
                                            </select>
                                          </td>
                                        </tr>

                                     <tr>
                                        <td> Group Item </td>
                                        <td> {{$data['jenisitem']}} <input type="hidden" value="{{$data['kodejenisitem']}}" class="jenisitem"> <input type="hidden" value="{{$data['stockjenisitem']}}" class="stockjenisitem">  </td>
                                     </tr>
                    
                                      <tr>
                                        <td  id="tdstock"> Apakah Update Stock ? </td>
                                        <td id="tdstock" class="disabled">
                                           @if($spp->spp_lokasigudang != '')
                                         <select class="form-control updatestock" name="updatestock"  id="updatestock" > <option value="Y"  selected=""> Ya </option> <option value="T"> TIDAK </option> </select>

                                          @else
                                          <select class="form-control updatestock" name="updatestock"  id="updatestock" readonly> <option value="Y" > Ya </option> <option value="T" selected=""> TIDAK </option> </select>
                                           @endif
                                        </td>
                                      </tr>
                                     


                                        @if($spp->spp_lokasigudang != '')
                                        <tr>
                                          
                                           <td> <b> Lokasi Gudang </b> </td> 
                                           <td>
                                            <select class="form-control chosen-select gudang">
                                            @foreach($data['gudang'] as $gudang)
                                                <option value="{{$gudang->mg_id}}" @if($gudang->mg_id == $spp->spp_lokasigudang) selected="" @endif> {{$gudang->mg_namagudang}} </option>
                                            @endforeach
                                          </select>
                                           </td>
                                          
                                        </tr>
                                        @endif
                             

                                    <tr>
                                      <td> Keterangan </td>
                                      <td> <input type="text" class="input-sm form-control" name="keterangan" value="{{$spp->spp_keperluan}}">  </td>
                                    </tr>

                                    @endforeach
                                  </table>

                                  
                               </div>
                               
                               <div class="col-md-6">
                                <h4> Total Biaya Per Supplier </h4>
                                  <table class="table" id="tbl-pembayaran">
                                    <thead>
                                    <tr>
                                        <th style='text-align: center'> Nama Supplier </th> <th style="text-align: center"> Total Biaya </th> <th style="text-align: center"> Syarat Kredit </th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                  </table>
                                 
                                
                               </div>
                                <br>
                                <br>
                                <br>
                                 <br>
                                 <br>
                                 <br>
                                 <br>
                                 <br>
                                  <div class="loadingjenis" style="display: none">  <img src="{{ asset('assets/image/loading1.gif') }}" width="50px"> </div>

                                <div class="col-md-12">
                                 <hr>
                                 <h3> Data Barang  </h3>
                                <hr>

                        <button class="btn btn-sm btn-info" id="tambahdatabarang" type="button"> <i class="fa fa-plus"> </i> Tambah Data Barang </button>
                        <br>
                        <table class="table table-striped" id="table-barang">
                          <thead>
                          <tr>
                              
                              <th> Barang </th>
                            
                              <th> Qty Request </th>
                              <th> Satuan </th>
                            
                              <th style='min-width: 10px'> Harga </th>
                              <th> Supplier </th>
                              <th> Aksi </th>
                              <th> Hapus Barang </th>
                              
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sppdt_barang'] as $index=>$sppdtbarang)
                            <tr class=" databarang databarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}">
                              <td rowspan="3"> {{$sppdtbarang->nama_masteritem}} </td>
                         
                              <td rowspan="3">  <input type="text" class="form-control input-sm qtyreq qtyreq{{$index}}" value="{{$sppdtbarang->sppd_qtyrequest}}" data-id="{{$index}}" style="width: 90px" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}"> </td>
                              

                              <td rowspan="3"> {{$sppdtbarang->unitstock}} </td>
                              

                              <td>                       
                                <input type='text' class="form-control hargacek hargacek0 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0' style="min-width:30px" name="hargacek[]"> 

                                <input type='hidden' class="form-control hargamanual0 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0'>
                                
                                <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">

                                <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">

                                <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">
                                          
                              </td> <!-- Kodeitem -->

                              <td>
                                <select class="chosen-select-width form-control suppliercek0 suppliercek suppliercekbarang{{$index}}" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0' data-index="{{$index}}">  <option value="" > </option>  </select>

                                  <input type='hidden' class="form-control suppliermanual0 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='0'>

                                  <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">

                                  <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">
                              </td> <!-- Harga -->
                              
                              <td> <button class="btn btn-md btn-danger removecek removecek0 removecekbarang{{$index}}" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="0"> <i class="fa fa-trash"> </i> </button> </td>
                              <td rowspan="3"> <button class="btn btn-md btn-warning removebarang" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}"> <i class="fa fa-trash"> </i> </button>  </td>

                              <tr class="databarang{{$index}} datacek1 datacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}"> 
                                <td>
                                  <!--Kodeitem  -->
                                  <input type='text' class="form-control hargacek hargacek1 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1' style="min-width:30px" name="hargacek[]">

                                  <input type='hidden' class="form-control hargamanual1 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'>

                                <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">
                                <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">
                                <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">

                                  <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">

                                <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">
                                </td>
                                <!-- Supplier -->
                                <td>
                                  <select class="chosen-select-width form-control suppliercek1 suppliercekbarang{{$index}} suppliercek" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1' data-index="{{$index}}"> <option value=""> </option> </select>

                                  <input type='hidden' class="form-control suppliermanual1 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'>

                                </td>

                                <td> <button class="btn btn-md btn-danger removecek removecek1 removecekbarang{{$index}}" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="1"> <i class="fa fa-trash"> </i> </button> </td>

                              </tr>
                              <tr class="databarang{{$index}} datacek2 datacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}">
                                <td>
                                  <!-- Kodeitem -->
                                  <input type='text' class="form-control hargacek hargacek2 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2' style="min-width:30px" name="hargacek[]">

                                  <input type='hidden' class="form-control hargamanual2 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2'>
                                   <input type='hidden' class="barang{{$index}}" name="barang[]" value="{{$sppdtbarang->sppd_kodeitem}}">
                                   <input type="hidden" value="{{$sppdtbarang->sppd_qtyrequest}}" name="qtyrequest[]">
                                   <input type="hidden" class="form-control status{{$index}}" value="SETUJU" name="status[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}">

                                   <input type='hidden' class='qtybarang{{$index}}' data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" name='qtyapproval[]' value="{{$sppdtbarang->sppd_qtyrequest}}">

                                  <input type="hidden" class="form-control keterangancektolak{{$index}}" name="keterangantolak[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="{{$index}}" readonly="">
                                </td>
                                <!-- Harga -->
                                <td class='supplier1'>
                                  <select class="chosen-select-width form-control suppliercek suppliercek2 suppliercekbarang{{$index}}" name="suppliercek[]" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2' data-index="{{$index}}"> <option value="">  </option> </select>

                                  <input type='hidden' class="form-control suppliermanual2 suppliercekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='2'>


                                </td>

                                <td> <button class="btn btn-md btn-danger removecek removecek2 removecekbarang{{$index}}" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id="2"> <i class="fa fa-trash"> </i> </button> </td>
                              </tr>

                            @endforeach
                        </tbody>
                        </table>
                        </div>
              
             <!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                       <input type="submit"  class="btn btn-success btn-flat simpan" disabled="" value="Simpan Data Rencana Penjualan" >     
                      </form>
                        <a class="btn btn-primary" id="cektb"> Cek Total Biaya </a>
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

    $('body').removeClass('fixed-sidebar');
            $("body").toggleClass("mini-navbar");

    $('#formId').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

     $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'
    }).datepicker("setDate", "0");


     function removeDuplicates(inputArray) {
            var i;
            var len = inputArray.length;
            var outputArray = [];
            var temp = {};

            for (i = 0; i < len; i++) {
                temp[inputArray[i]] = 0;
            }
            for (i in temp) {
                outputArray.push(i);
            }
            return outputArray;
     }

    function find_duplicate_in_array(arra1) {
        var object = {};
        var result = [];

        arra1.forEach(function (item) {
          if(!object[item])
              object[item] = 0;
            object[item] += 1;
        })

        for (var prop in object) {
           if(object[prop] >= 2) {
               result.push(prop);
           }
        }

        return result;

    }

    cabang = $('.cabang').val();
    $('.valcabang').val(cabang);

    var arrnobrg = [];

    $('#formId input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formId input').change(function(){
      this.setCustomValidity("");
    })

    $('.simpan').click(function(){
      kuantitas = $('.kuantitas').val();
      harga = $('.hrga').val();
       cabang = $('.cabang').val();
      // alert(cabang);
      if(kuantitas  == "undefined" && harga == "undefined" ){
         toastr.info('Harap Buat data SPP ');
        return false;
      }
       
        if(cabang == ''){
          toastr.info('Cabang harap diisi :)');
          return false;
        }
     
    })

  
    
    
    

   clearInterval(reset);
    var reset =setInterval(function(){
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


      $(".supplier").chosen(config);
      $(".kndraan").chosen(config);
    })
     },2000);

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

    //data spp
    idspp = $('.idspp').val();
  $.ajax({
    url : baseUrl + '/konfirmasi_order/ceksupplier',
    type : 'get',
    data : {idspp},
    dataType : 'json',
    success : function(response){
//      console.log(response.sppd.length);

      for($i = 0; $i < response.sppdt.length; $i++) {
        $key = 0;
        $temp = 0;
        for($j = 0; $j < response.sppd.length; $j++){
          kodeitem = $('.hargacekbarang' + $i).data('kodeitem');
    

          if(response.sppd[$j].sppd_kodeitem == kodeitem){
             if($temp == 1){
                $key = 0;
             }              

                    
              $('.hargacek' + $key + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.sppd[$j].sppd_harga));
              $('.hargamanual' + $key + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.sppd[$j].sppd_harga));

               if(response.temp[$i] == '0'){
                  for($z = 0; $z < response.itemsupplier2.length; $z++){
                    $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.itemsupplier2[$z].is_idsup+">" + response.itemsupplier2[$z].no_supplier+" - "+response.itemsupplier2[$z].nama_supplier+"</option>");
                  }
               }
               else if(response.temp[$i] == '1'){
                  for($z = 0; $z < response.supplier.length; $z++){
                    $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.supplier[$z].idsup+">" +response.supplier[$z].no_supplier+" - "+response.supplier[$z].nama_supplier+"</option>");
                    
                  }
               }  
                
                console.log(response.sppd[$j].sppd_supplier);
                $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').val(response.sppd[$j].sppd_supplier);
                $('.suppliermanual' + $key + '[data-kodeitem = '+kodeitem+']').val(response.sppd[$j].sppd_supplier);
                $('.suppliercek' + $key).trigger("chosen:updated");
                $('.suppliercek' + $key).trigger("liszt:updated");

             
              $temp = 0;
          }
          else {
              
             $temp = 1;
          }
          $key++;
        }        
      }

      for($k = 0; $k < response.temp.length; $k++){
          kodeitem = $('.hargacekbarang' + $k).data('kodeitem');
        $('.suppliercekbarang' + $k).each(function(){
          val = $(this).val();
          if(val == ''){
            
             if(response.temp[$k] == '0'){                
                  for($z = 0; $z < response.itemsupplier2.length; $z++){
                    $(this).append("<option value="+response.itemsupplier2[$z].is_idsup+">" +response.itemsupplier2[$z].no_supplier+" - "+response.itemsupplier2[$z].nama_supplier+"</option>");
                  
                  }
                $(this).trigger("chosen:updated");
                $(this).trigger("liszt:updated");
               }
               else if(response.temp[$k] == '1'){
             
                  for($z = 0; $z < response.supplier.length; $z++){                 
                    $(this).append("<option value="+response.supplier[$z].idsup+">" +response.supplier[$z].no_supplier+" - "+response.supplier[$z].nama_supplier+"</option>");
                  }

                 $(this).trigger("chosen:updated");
                $(this).trigger("liszt:updated");
               }
              
          }
        })
      }


    },
    error : function(){
      location.reload();
    }
  })

    $('.suppliercek').change(function(){
    id = $(this).data('id');
    kodeitem = $(this).data('kodeitem');
    supplier = $(this).val();
    $.ajax({
      url : baseUrl + '/konfirmasi_order/cekharga',
      type : "get",
      dataType : 'json',
      data : {kodeitem,supplier},
      success : function(response){
     
            $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').val(addCommas(response.harga));
         
      }
    })
    $('.simpantb').attr('disabled' , true);
  })

    //tambah data barang
    $('#tambahdatabarang').click(function(){
   
      jenisitem = $('.jenisitem').val();
      stock = $('.stockjenisitem').val();
      updatestock = $('.updatestock').val();
      $.ajax({
          url : baseUrl + '/suratpermintaanpembelian/tmbhdatabarang',
          data : {jenisitem , stock, updatestock},
          type : "get",
          dataType : "json",
          success : function(response){
            length = $('.databarang').length;
            index = length + 1;
            alert(length);
            html = "<tr class='databarang databarang"+index+"'>" +
                    "<td rowspan='3'>";
                   
                        html += "<select class='form-control chosen-select barang barang"+index+"' data-index="+index+">";
                           for(i = 0; i < response.kodeitem.length; i++){
                                 html += "<option value='"+response.kodeitem[i].kode_item+"'>" +
                                     response.kodeitem[i].kode_item + " - " + response.kodeitem[i].nama_masteritem +
                                  "</option>";
                                }
                        html += "</select>" +
                    "</td>" + // barang 
                    "<td rowspan='3'>"+index+"<input type='text' class='form-control input-sm qtyreq qtyreq"+index+"' data-id='"+index+"'> </td>" + //qty
                    "<td rowspan='3'> Satuan </td>" +
                    "<td>"+index+" <input type='text' class='form-control hargacek hargacek0 hargacekbarang"+index+"' data-id='0' name='hargacek[]' data-index="+index+"> </td>"+ //harga
                    "<td>"+index+" <select class='form-control chosen-select suppliercek0 suppliercekbarang"+index+" suppliercek' name='suppliercek[]' data-id='0' data-index="+index+">";
                      for(j = 0; j < response.supplier.length; j++){
                          html += "<option value='"+response.supplier[j].idsup+"'>" +
                                   response.supplier[j].no_supplier + " - " + response.supplier[j].nama_supplier +
                                   "</option>";
                      }
             html+= "</td>" + //supplier
                    "</tr>" +
                    "<tr class='databarang"+index+" datacek1 datacekbarang"+index+"' data-index="+index+">" +
                    "<td> "+index+"<input type='text' class='form-control hargacek hargacek1 hargacekbarang"+index+"' data-id='1' name='hargacek[]' data-index="+index+"> </td>"+ //harga
                    "<td>" +
                    "<select class='form-control chosen-select suppliercek1 suppliercekbarang"+index+" suppliercek' name='suppliercek[]' data-id='1' data-index="+index+">";
                      for(j = 0; j < response.supplier.length; j++){
                          html += "<option value='"+response.supplier[j].idsup+"'>" +
                                   response.supplier[j].no_supplier + " - " + response.supplier[j].nama_supplier +
                                   "</option>";
                      }
             html +=  "</select> </td>" + //supplier
                    

                    "<td> <button class='btn btn-md btn-danger removecek removecek1 removecekbarang"+index+"' type='button' data-id='1' data-index="+index+"> <i class='fa fa-trash'> </i> </button> </td>" +
                    "</tr>" +
                    "<tr class='databarang"+index+" datacek2 datacekbarang"+index+"' data-index="+index+">" +
                    "<td> <input type='text' class='form-control hargacek hargacek2 hargacekbarang"+index+"' data-id='2' name='hargacek[]' data-index="+index+"> </td>"+ //harga
                    "<td> <select class='form-control chosen-select suppliercek2 suppliercekbarang"+index+" suppliercek' name='suppliercek[]' data-id='2' data-index="+index+">";
                      for(j = 0; j < response.supplier.length; j++){
                          html += "<option value='"+response.supplier[j].idsup+"'>" +
                                   response.supplier[j].no_supplier + " - " + response.supplier[j].nama_supplier +
                                   "</option>";
                      }

             html += "</select>" +
                   "</td>" + //supplier
                    "<td> <button class='btn btn-md btn-danger removecek removecek2 removecekbarang"+index+"' type='button' data-id='2' data-index="+index+"> <i class='fa fa-trash'> </i> </button> </td>" +
                    "</tr>";

                  $('#table-barang').append(html);
            
            //changesupplier
            $('.suppliercek').change(function(){
                id = $(this).data('id');
                index = $(this).data('index');
                kodeitem = $('.barang' + index).val();
                supplier = $(this).val();
                $.ajax({
                  url : baseUrl + '/konfirmasi_order/cekharga',
                  type : "get",
                  dataType : 'json',
                  data : {kodeitem,supplier},
                  success : function(response){
                 
                        $('.hargacek' + id + '[data-index = '+index+']').val(addCommas(response.harga));
                     
                  }
                })
                $('.simpantb').attr('disabled' , true);
              })


              //ganti barang
              $('.barang').change(function(){
                 index = $(this).data('index');
                 val = $(this).val();
                 gudang = $('.gudang').val();
                 kodeitem = val;
                 $.ajax({
                    data : {kodeitem, gudang},
                    url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier',
                    dataType : 'json',
                    type : "get",
                    success : function(response){
                        arrSupid = response.supplier; //terikat kontrak
                        supplier = response.mastersupplier;
                       $('.suppliercekbarang' + index).empty();
                        if(arrSupid.length > 0){
                        
                            for(j = 0; j < arrSupid.length; j++){
                              alert(arrSupid[j].no_supplier);
                              $('.suppliercekbarang' + index).append("<option value='"+arrSupid[j].idsup+"'>"+ arrSupid[j].no_supplier + '-' + arrSupid[j].nama_supplier + "</option>");

                              $('.suppliercekbarang' + index).trigger("chosen:updated");
                              $('.suppliercekbarang' + index).trigger("liszt:updated");
                            }

                            $('.hargacekbarang' + index).val(addCommas(arrSupid[0].is_harga));

                        }
                        else {
                           for(j = 0; j < supplier.length; j++){
                              $('.suppliercekbarang' + index).append("<option value='"+supplier[j].idsup+"'>" + supplier[j].no_supplier + '-' + supplier[j].nama_supplier + "</option>");

                              $('.suppliercekbarang' + index).trigger("chosen:updated");
                              $('.suppliercekbarang' + index).trigger("liszt:updated");
                            }

                           $('.hargacekbarang' + index).val(addCommas(response.masteritem[0].harga));
                        }
                    }
                 })

              })

              // hapus
               $('.removecek').click(function(){
                id = $(this).data('id');
                index = $(this).data('index');
                kodeitem = $(this).data('kodeitem');
                

                  $('tr.datacek' + id + '[data-index = '+index+']').addClass('disabled');
                  $('.hargacek' + id + '[data-index = '+index+']').addClass('colorblack');
                  $('.suppliercek' + id + '[data-index = '+index+']').addClass('disabled');
                  $('.hargacek' + id + '[data-index = '+index+']').attr('readonly' , true);
                  $('.suppliercek' + id + '[data-index = '+index+']').val('');
                  $('.hargacek' + id + '[data-index = '+index+']').val('');

                  $('.suppliercek' + id + '[data-index = '+index+']').trigger("chosen:updated");
                   $('.suppliercek' + id + '[data-index = '+index+']').trigger("liszt:updated");
                   $('.simpantb').attr('disabled' , true);      
             })
          }
      })
    })
  
  
   $('#cektb').click(function(){
      $('.simpantb').attr('disabled' , false);
      arrjumlahtotal = [];

      $('.qtyreq').each(function(){
        qty = $(this).val();
        idqty = $(this).data('id');
        if(qty == ''){
          toastr.info("Mohon maaf data qty kosong :)");
          return false;
        }
        alert(idqty);
        alert($('.hargacekbarang' + idqty).length);
        $('.hargacekbarang'+ idqty).each(function(){
          harga2 = $(this).val();
          idharga = $(this).data('id');
          kodeitem = $(this).data('kodeitem');
          alert(idharga);
          alert(index);
          supplier = $('.suppliercek' + idharga + '[data-index= '+index+']').val();
         
          if(harga2 == '' && supplier == ''){
           /* toastr.info("Harga ada yang kosong mohon dilengkapi :)");
            return false*/
          }
          else {            
            harga = harga2.replace(/,/g, '');
            totalharga = (parseFloat(qty) * parseFloat(harga)).toFixed(2);          
            arrjumlahtotal.push({
              totalharga : totalharga,
              supplier :supplier,
             
            });
          }
        })
      })

      console.log(arrjumlahtotal);

      arrsupplier = [];
      $('.suppliercek').each(function(){
        val = $(this).val();
        if(val == '' || val == null){
        /*  toastr.info("Data Supplier ada yang kosong, mohon diisi :)");
          return false;*/
        }
        else{ 
                arrsupplier.push(val);
              }
       })


      hslsupplier = removeDuplicates(arrsupplier);
    
      if(hslsupplier.length > 3){
        toastr.info("Terdapat lebih dari 3 supplier yang berbeda, tidak bisa di proses kembali :)");
        return false;
      }

      hargasupplier = [];
   
     hargasupplier2 = [];

      $duplicatesupplier = find_duplicate_in_array(arrsupplier);
      for($i = 0; $i < $duplicatesupplier.length; $i++){
        jumlahtotal = 0;
        supplierduplicate = $duplicatesupplier[$i];
        for($j = 0; $j < arrjumlahtotal.length; $j++){
          if(supplierduplicate == arrjumlahtotal[$j]['supplier']){
            jumlahtotal = parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$j]['totalharga']);   
          }
        }

          index = arrjumlahtotal.indexOf(supplierduplicate);
         hargasupplier2.push({
          supplier : supplierduplicate,
          jumlahtotal : jumlahtotal,
          index : index,
         });
      }

      for($i = 0; $i < hslsupplier.length; $i++){
          jumlahtotal = 0;
          for($k = 0; $k < arrjumlahtotal.length; $k++){
            supplier1 = hslsupplier[$i];
            supplier2 = arrjumlahtotal[$k]['supplier'];
            if(supplier1 == supplier2){
              jumlahtotal = parseFloat(parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$k]['totalharga'])).toFixed(2);
            }
            else {
              //jumlahtotal = parseFloat(jumlahtotal) + parseFloat(arrjumlahtotal[$k]['totalharga']);
            }
          }
          hargasupplier.push(jumlahtotal);
      } 
/*
      console.log($duplicatesupplier);*/
      
       

      hslsupplier = hslsupplier; 
      idspp = $('.idspp').val();
      $.ajax({
        url : baseUrl + '/konfirmasi_order/cekhargatotal',
        data : {hslsupplier, idspp},
        type : "get",      
        dataType : 'json',
        success : function(response){
            $('tr.totalcekpembayaran').remove();
            for($j = 0; $j < response.datasupplier.length; $j++){
              html ="<tr class='totalcekpembayaran'> <td>"+response.datasupplier[$j][0].nama_supplier+" <input type='hidden' name='suppliercekbayar[]' value="+response.datasupplier[$j][0].idsup+"></td>"+
                    "<td>"+addCommas(hargasupplier[$j])+" <input type='hidden' name='totalbayarpembayaran[]' value="+hargasupplier[$j]+"></td>";
                    if(response.temp[$j] == 0){
                    html += "<td>"+response.datasupplier[$j][0].syarat_kredit+" Hari <input type='hidden' name='syaratkredit[]' value="+response.datasupplier[$j][0].syarat_kredit+"></td>";
                    }
                    else {
                    html +=  "<td>"+response.datasupplier[$j][0].spptb_bayar+" Hari <input type='hidden' name='syaratkredit[]' value="+response.datasupplier[$j][0].spptb_bayar+"> </td>";
                    }
              html += "</tr>"
            
              $('#tbl-pembayaran').append(html);
            }
        }
      })      
  });


    //remove barang
    $('.removebarang').click(function(){
      index = $(this).data('index');
      kodeitem = $(this).data('kodeitem');
      alert(index);
      $('tr.databarang' + index + '[data-kodeitem = '+kodeitem+']').remove();
    })


    //remove 
    $('.removecek').click(function(){
      id = $(this).data('id');
      index = $(this).data('index');
      kodeitem = $(this).data('kodeitem');
      

        $('tr.datacek' + id + '[data-kodeitem = '+kodeitem+']').addClass('disabled');
        $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').addClass('colorblack');
        $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').addClass('disabled');
        $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').attr('readonly' , true);
        $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').val('');
        $('.hargacek' + id + '[data-kodeitem = '+kodeitem+']').val('');

        $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("chosen:updated");
         $('.suppliercek' + id + '[data-kodeitem = '+kodeitem+']').trigger("liszt:updated");
         $('.simpantb').attr('disabled' , true);      
   })



    $('.tglinput').change(function(){
      var comp = $('.cabang').val();
      tgl = $('.tglinput').val();   
        $.ajax({    
            type :"get",
            data : {comp, tgl},
            url : baseUrl + '/suratpermintaanpembelian/getnospp',
            dataType:'json',
            success : function(data){
             if(data.status == 'sukses'){
                      var d = new Date(tgl);               
                      //tahun
                      var year = d.getFullYear();
                      //bulan
                      var month = d.getMonth();
                      var month1 = parseInt(month + 1)
                   
                      console.log(year);

                      if(month < 10) {
                        month = '0' + month1;
                      }
                      console.log(d);

                      tahun = String(year);
      //                console.log('year' + year);
                      year2 = tahun.substring(2);
                      //year2 ="Anafaradina";

                    
                       nospp = 'SPP' + month + year2 + '/' + comp + '/' +  data.data;
                      console.log(nospp);
                      $('.nospp').val(nospp);
                       nospp = $('.nospp').val();
                }
                else {
                    location.reload();
                }
              
                if(nospp === ''){
                    location.reload();
                }

               
            },
            error : function(){
               location.reload();
            }
        })

    })


    $('.cabang').change(function(){    
      var comp = $(this).val();
      tgl = $('.tglinput').val();
      $('.valcabang').val(comp);
        $.ajax({    
            type :"get",
            data : {comp, tgl},
            url : baseUrl + '/suratpermintaanpembelian/getnospp',
            dataType:'json',
            success : function(data){
             if(data.status == 'sukses'){
                      var d = new Date(tgl);               
                      //tahun
                      var year = d.getFullYear();
                      //bulan
                      var month = d.getMonth();
                      var month1 = parseInt(month + 1)
                   
                      console.log(year);

                      if(month < 10) {
                        month = '0' + month1;
                      }
                      console.log(d);

                      tahun = String(year);
      //                console.log('year' + year);
                      year2 = tahun.substring(2);
                      //year2 ="Anafaradina";

                    
                       nospp = 'SPP' + month + year2 + '/' + comp + '/' +  data.data;
                      console.log(nospp);
                      $('.nospp').val(nospp);
                       nospp = $('.nospp').val();
                }
                else {
                    location.reload();
                }
              
                if(nospp === ''){
                    location.reload();
                }

               
            },
            error : function(){
               location.reload();
            }
        })

    })

    //gudang
     $('.cabang').change(function(){
       cabang = $('.cabang').val();
        $.ajax({
          url : baseUrl + '/suratpermintaanpembelian/valgudang',
          data :{cabang},
          type : "GET",
          dataType : 'json',
          success : function(response){
               $('.gudang').empty();
                      $('.gudang').append(" <option value=''>  -- Pilih Gudang -- </option> ");
                  $.each(response.gudang, function(i , obj) {
            //        console.log(obj.is_kodeitem);
                    $('.gudang').append("<option value="+obj.mg_id+"> <h5> "+obj.mg_namagudang+" </h5> </option>");
                    $('.gudang').trigger("chosen:updated");
                     $('.gudang').trigger("liszt:updated");
                  })
          }
        })
    })

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('.updatestock').change(function(){
      val = $(this).val();
    
      $('.loadingjenis').css('display' , 'block');
      jnsitem = $('.jenisitem').val();
      variable = jnsitem.split(",");
      jenisitem = variable[0];
      penerimaan = variable[1];

      if(jenisitem == ''){
        toastr.info('Harap pilih Group Item terlebih dahulu :)');
          $('#updatestock option').prop('selected', function(){
            return this.defaultSelected;
         })
      }

      else if(jenisitem == 'S') {
      
        valupdatestock = val;
          if(val == 'Y') {
         valupdatestock = val;
                $('.kendaraan').remove();
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td width='200px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
                              "@foreach($data['gudang'] as $gdg) <option value={{$gdg->mg_id}}> {{$gdg->mg_namagudang}} </option> @endforeach>" + 
                           "</select> </td>";
              $('.lokasigudang').html(rowgudang);
          }
          else if(val == 'T') {
           
             valupdatestock = val;
            $('.lokasigudang').empty();
            $('.header-table').find($('.kendaraan')).remove();
            var rowColom = "<th class='kendaraan' style='width:100px'> Kendaraan </th>";
             

             var colomBarang = "<td class='kendaraan'> Barang </td>";
             var colomSupplier = "<td class='kendaraan'> Supplier </td>";

            /*  $('.addbarang td:eq(6)').append(colomBarang);
              $('.data-supplier td:eq(6)').append(colomSupplier);*/

            //$('.header-table th:eq(6)').append(rowColom);

            $("<th class='kendaraan' style='width:100px'> Kendaraan </th>").insertAfter($('.kolompembayaran'));
            $("<th class='kendaraan'> </th>").insertAfter($('.kolomtghpembayaran'));

            $("<td class='kendaraan'> <select class='form-control kendaraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id}}> {{$kndraan->nopol}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
            
           //  $("rowColom").insertAfter("#pembayaran");
        }
      }
    
      else {
         if(val == 'Y') {
           valupdatestock = val;
                $('.kendaraan').remove();
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td width='200px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
                              "@foreach($data['gudang'] as $gdg) <option value={{$gdg->mg_id}}> {{$gdg->mg_namagudang}} </option> @endforeach>" + 
                           "</select> </td>";
              $('.lokasigudang').html(rowgudang);
          }
          else {
             valupdatestock = val;
             $('.lokasigudang').empty();
          }
      }

     
          updatestock = $(this).val();
          $.ajax({    
            type :"post",
            data : {jenisitem,updatestock,penerimaan},
            url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
            dataType:'json',
            success : function(data){
            $('.loadingjenis').css('display' , 'none');


               arrItem = data;
                  
                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+"> <h5> "+obj.nama_masteritem+" </h5> </option>");
                           $('.barang').trigger("chosen:updated");
                           $('.barang').trigger("liszt:updated");
                        })
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);  
                        $('.barang').trigger("chosen:updated");
                      $('.barang').trigger("liszt:updated");           
                  }
                },
                error : function(){
                  location.reload();
                }
            
          })
        
      


    })

       function removeDuplicates(inputArray) {
            var i;
            var len = inputArray.length;
            var outputArray = [];
            var temp = {};

            for (i = 0; i < len; i++) {
                temp[inputArray[i]] = 0;
            }
            for (i in temp) {
                outputArray.push(i);
            }
            return outputArray;
     }


    function removeA(arr){
      var what, a= arguments, L= a.length, ax;
      while(L> 1 && arr.length){
          what= a[--L];
          while((ax= arr.indexOf(what))!= -1){
              arr.splice(ax, 1);
          }
      }
      return arr;
      }

      var tempceknull = 0;

      $(function(){
      var harga = [];
      $('.cek_tb').click(function(){
        

          $('.brgduplicate').empty();
          $('.supduplicate').empty();
          //pengecekan barang double
          //valbarang

          sup2 = $('.sup2').val();
         // console.log(sup2);

          arrBarang = [];  
        
         $('.barang').each(function(){
            barang = $(this).val();
              var string = barang.split(",");
              var kodeitem = string[0];
              arrBarang.push(kodeitem);
           //   console.log('barang' + barang);
         })
      
       
          var sorted_arr = arrBarang.slice().sort();
          var results = [];   
          for (var i = 0; i < sorted_arr.length - 1; i++) {
              if (sorted_arr[i + 1] == sorted_arr[i]) {
                  results.push(sorted_arr[i]);
              }            
          }

  
          //cari index untuk kode yang sama
          var indexbrg = [];

          if(results.length > 1) {
              for(var nb = 0 ; nb < results.length; nb++){
                 indexbrg = arrBarang.indexOf(results[nb]);
              }
          }
          else{
             indexbrg = arrBarang.indexOf(results[0]);
             //console.log(indexbrg);
          }

//          console.log(indexbrg + 'indexbrg');
          if(indexbrg == -1){
            $('.brgduplicate').empty();
          }
          else {
            rowduplicate = "<i> <h5 style='color:red'> *Duplicate Barang </h5> </i>";
            $('.duplicate' + parseInt(indexbrg)).html(rowduplicate);
          } // end cek duplicate barang



          //pengecekan SUPPLIER DOUBLE
          var arr_indexsup = [];

         for(var nmrbrg = 0; nmrbrg < arrnobrg.length; nmrbrg++){
          var indexsup = [];
          var arr_bedasup = [];
           var results_sup = [];
            lengthsup = $('.sup' + arrnobrg[nmrbrg]).length;
           
       

           $('.sup' + arrnobrg[nmrbrg]).each(function(){
/*              string = $('.sup' + arrnobrg[nmrbrg]).val(); */
              string = $(this).val();
              split = string.split(",");
              idsup = split[6];
              arr_bedasup.push(idsup);
           })

         //  console.log(arr_bedasup + 'nomer ke-' + arrnobrg[nmrbrg]);

           var sorted_supp = arr_bedasup.slice().sort();
           for(var j = 0 ; j < sorted_supp.length - 1 ; j++){
               if (sorted_supp[j + 1] == sorted_supp[j]) {
                  results_sup.push(sorted_supp[j]);
              }    
           }
            
      //    console.log(results_sup + 'results_sup');

            if(results_sup.length > 0){
               for(var ns = 0 ; ns < results_sup.length; ns++){
                   if(results_sup.length > 1){
                    indexsup = arr_bedasup.indexOf(results_sup[ns]);
                    arr_indexsup.push(indexsup);
                   }
                   else {
                     indexsup = arr_bedasup.indexOf(results_sup[0]);
                     arr_indexsup.push(indexsup);
                  }
               }        
           
         

               for(var k = 0; k < arr_indexsup.length; k++){
                if(arr_indexsup[k] == -1){
            
                }
                else {
                   rowduplicate2 = "<i> <h5 style='color:purple'> *Barang ini memiliki duplicate Supplier </h5> </i>";
                   $('.supduplicate' + parseInt(arrnobrg[nmrbrg])).html(rowduplicate2);
                    $('.simpan').attr('disabled', true);

                } // end c
               }
            }
         }

        


         

          $('#tbl_total_sup').empty();
          var rowBarang = $('#field').length;
          var arrHarga = [];
          var rowCount = $('#table-data tr').length;
  //      toastr.info(rowCount);
          hasilrow = rowCount - 2;        
      //    console.log(hasilrow);
          var jumlah  = 0;
          var outputSup = [];
          var idSup = [];
          var jumlah = 0;
          var hargaBrg = []
          
          var rowBarang = $('#field').length;
          var hslRowBrg = rowBarang - 1;

           for(var i = 0; i <hasilrow ; i++){    
           }

           var arrNoHrg  = [];
           //mendapatkan harga
         $('.hrga').each(function () { 
            var a = $(this).val();
            var noharga = $(this).data('no');
             harga = a.replace(/,/g, '');
            arrHarga.push({
              harga : harga,
              noharga : noharga
            });
            arrNoHrg.push(noharga);

            if (a == ''){
//              toastr.info('Harga harap diisi pada');
              toastr.info('Harga harap diisi');
              tempceknull = tempceknull + 1;
            }
            else {
                 tempceknull = 0;
            }


          });

//         console.log(arrHarga);
         var arrSup = [];
         var arrIdSup = [];
         var kodesup = [];
         var noBrg = [];
         var arrsyarat = [];

         //mendapatkan supplier
         $('.suipl').each(function(){
           var value = $(this).val();
        //    console.log('value' + value);
           var pecahstring  = value.split(",");
           var idsupplier = pecahstring[0];
           var supplier = pecahstring[3];
           var nobrg = pecahstring[2];
           var kodesupplier = pecahstring[6];
           var syaratkredit = pecahstring[1];
   //       console.log(value);
           if(value == ''){
          //  toastr.info('Supplier harap diisi');
            toastr.info('Mohon Supplier harap diisi :) ');
            tempceknull = tempceknull + 1;
           }
           else {
               tempceknull = 0;
           }
            
            noBrg.push(nobrg);
            arrSup.push(supplier);
            arrIdSup.push(idsupplier);
            kodesup.push(kodesupplier);
            arrsyarat.push(syaratkredit);
         })



  //       console.log(arrSup);
          var hslqty = [];
         $('.kuantitas').each(function(){
              idqty = $(this).data('id');
             qty = $(this).val();

             if(qty == '') {
           //   toastr.info('Harap Diisi Angka pada kolom Jumlah');
               toastr.info('Harap Diisi Angka pada kolom Jumlah ');
              tempceknull = tempceknull + 1;

             }
             else {
              tempceknull = 0;
             }
              hslqty.push({
              qty : qty,
              idqty : idqty
            });

         })


       //   var hslqty = [];
          var countrqty = 0;
          var counthrg = 1;
          var arrtotal = [];
          var noidqty3 = [];
          var idsupp = [];
          var arrIdqty = [];
          var hslsyaratkredit = [];
          idsupp = removeDuplicates(arrIdSup);
          outputSup = removeDuplicates(arrSup);
          hslkodesup = removeDuplicates(kodesup);

          
         for(var jx = 0; jx < idsupp.length; jx++){
          indexsyarat = arrIdSup.indexOf(idsupp[jx]);
          hslsyaratkredit.push(indexsyarat);
         }
          
         
           // console.log(arrsyarat.syaratkredit + 'syaratkredit');

         //remove qty yg undefined
          var rmvqty = undefined;
          var inputqty = removeA(hslqty,rmvqty);
          var countidqty = 1;
          var arrtotal = [];
         // console.log(hslqty);

          //hitungqty
          for(var j = 0; j < hasilrow; j++){
            for(var k = 0 ; k < hslqty.length; k++){
              if(arrHarga[j].noharga == hslqty[k].idqty){
                //  console.log(arrHarga[j].noharga);
                //  console.log(hslqty[k].idqty);

                   var nilai = arrHarga[j].harga * hslqty[k].qty;
                   arrtotal.push(nilai);
              }
            }
          }



          var jumlahtotal = 0;
          var jumlahtotalpembayaran = [];
          var indexhslsup = [];
          for(var i = 0; i < idsupp.length; i++ ) {
            jumlahtotal = 0;
            for(var j = 0; j < hasilrow; j++){
              if(arrIdSup[j] == idsupp[i]) {
                jumlahtotal = parseInt(jumlahtotal + arrtotal[j]);
                console.log(jumlahtotal);
              //  indexhslsup1 = arrIdSup.indexOf(idsupp[i]);
               
               
             }

            }
            // indexhslsup.push(indexhslsup1);
             jumlahtotalpembayaran.push(jumlahtotal);
          }
        
        //  console.log(jumlahtotalpembayaran);
          hsljmlhpmbayaran = [];
         // console.log(outputSup);
          

          if(tempceknull != 0){
            toastr.info(tempceknull);
          }
          else if(results.length > 0 ){
           // toastr.info("Nama Barang ada yang sama , mohon di ganti :)");
              toastr.info('Nama Barang ada yang sama , mohon di ganti :)');
            $('.simpan').attr('disabled', true);
          }
          else if(results_sup.length > 0){
             toastr.info('Nama Supplier ada yang sama , mohon di ganti :)');
            $('.simpan').attr('disabled', true);
          }
          else if(outputSup.length >  3){
            toastr.info('Mohon maaf, Maksimal supplier 3 :)');
            $('.simpan').attr('disabled', true);
          }
          else {
           var rowhslSupp1 = "<tr> <th> Nama Supplier </th> <th> Total Biaya </th> <th> Syarat Kredit </th> </tr>";
           $('#tbl_total_sup').append(rowhslSupp1);
           // toastr.info(tempceknull);
          for (var a = 0; a < outputSup.length; a++) {
              hsljmlhpmbayaran = parseFloat(jumlahtotalpembayaran[a]).toFixed(2);
             // console.log(hsljmlhpmbayaran);
          var  rowhslSupp = "<tr id='tbl_total' style='margin-bottom:30px'>"+
                            "<td style='width:240px'><input type='text' class='form-control' value='"+ outputSup[a] +"' readonly name='outputSup[]'>" + 
                            "<input type='hidden' name='idsupplier[]' value='"+kodesup[hslsyaratkredit[a]]+"'> </td>" +
                            "<td class='text-right'><input type='text' class='input-sm form-control' value='"+ addCommas(hsljmlhpmbayaran) +"'  readonly style='text-align:right'  >  <input type='hidden' class='input-sm form-control' value='"+ addCommas(hsljmlhpmbayaran) +"-"+hslkodesup[a]+"' name='totbiaya[]' readonly style='text-align:right'  ></td>" +
                            "<td> <div class='col-sm-7'> <input type='text' class='input-sm form-control input-sm' name='syaratkredit[]' required value='"+arrsyarat[hslsyaratkredit[a]]+"'> </div> <label class='control-label col-sm-2'> Hari</label>  </td>" +
                            "<td> <input type='hidden' class='form-control' readonly value='"+hasilrow+"' name='row'> </td>  </tr>";
             $('#tbl_total_sup').append(rowhslSupp);
          }
            $('.cek_tb').attr('disabled' , true);
           $('.simpan').attr('disabled', false);
         }
         
          

          var num = Math.round(jumlah).toFixed(2);
          $('.biaya').val(addCommas(num));

       

      })
    })



      var arrItem = [];
          
      $('.jenisitem').change(function(){
      val = $('.updatestock').val();
    
      $('.loadingjenis').css('display' , 'block');
      jnsitem = $('.jenisitem').val();
      variable = jnsitem.split(",");
      jenisitem = variable[0];
      penerimaan = variable[1];

      if(jenisitem == ''){
        toastr.info('Harap pilih Group Item terlebih dahulu :)');
          $('#updatestock option').prop('selected', function(){
            return this.defaultSelected;
         })
      }

      else if(jenisitem == 'S') {
      
        valupdatestock = val;
          if(val == 'Y') {
         valupdatestock = val;
                $('.kendaraan').remove();
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td width='200px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
                              "@foreach($data['gudang'] as $gdg) <option value={{$gdg->mg_id}}> {{$gdg->mg_namagudang}} </option> @endforeach>" + 
                           "</select> </td>";
              $('.lokasigudang').html(rowgudang);
          }
          else if(val == 'T') {
           
             valupdatestock = val;
            $('.lokasigudang').empty();
            $('.header-table').find($('.kendaraan')).remove();
            var rowColom = "<th class='kendaraan' style='width:100px'> Kendaraan </th>";
             

             var colomBarang = "<td class='kendaraan'> Barang </td>";
             var colomSupplier = "<td class='kendaraan'> Supplier </td>";

            /*  $('.addbarang td:eq(6)').append(colomBarang);
              $('.data-supplier td:eq(6)').append(colomSupplier);*/

            //$('.header-table th:eq(6)').append(rowColom);

            $("<th class='kendaraan' style='width:100px'> Kendaraan </th>").insertAfter($('.kolompembayaran'));
            $("<th class='kendaraan'> </th>").insertAfter($('.kolomtghpembayaran'));

            $("<td class='kendaraan'> <select class='form-control kendaraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id}}> {{$kndraan->nopol}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
            
           //  $("rowColom").insertAfter("#pembayaran");
        }
      }
    
      else {
         if(val == 'Y') {
           valupdatestock = val;
                $('.kendaraan').remove();
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td width='200px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
                              "@foreach($data['gudang'] as $gdg) <option value={{$gdg->mg_id}}> {{$gdg->mg_namagudang}} </option> @endforeach>" + 
                           "</select> </td>";
              $('.lokasigudang').html(rowgudang);
          }
          else {
             valupdatestock = val;
             $('.lokasigudang').empty();
          }
      }

     
          updatestock = $('.updatestock').val();
          $.ajax({    
            type :"post",
            data : {jenisitem,updatestock,penerimaan},
            url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
            dataType:'json',
            success : function(data){
            $('.loadingjenis').css('display' , 'none');


               arrItem = data;
                  
                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+"> <h5> "+obj.nama_masteritem+" </h5> </option>");
                           $('.barang').trigger("chosen:updated");
                           $('.barang').trigger("liszt:updated");
                        })
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);  
                        $('.barang').trigger("chosen:updated");
                      $('.barang').trigger("liszt:updated");           
                  }
                }
            
          })
        
      


    })
  /* $(function(){
      $('.jenisitem').change(function(){
              val = $('.updatestock').val();
              $('.loadingjenis').css('display', 'block');
              var jnsitem = $(this).val();
              var variable = jnsitem.split(",");
              var jenisitem = variable[0];
              var penerimaan = variable[1];
              


              if(penerimaan == 'T'){
                 $('.penerimaan').val(penerimaan);
                   $('td#tdstock').hide();
              }
              else {
                 $('td#tdstock').show();
                $('.penerimaan').val(penerimaan);
              }
             
              var updatestock = $('.updatestock').val();

              if(jenisitem == 'S' && updatestock == 'T'){
                 $('.loadingjenis').css('display', 'block');
                    valupdatestock = val;
              $('.lokasigudang').empty();
              $('.header-table').find($('.kendaraan')).remove();
              var rowColom = "<th class='kendaraan' style='width:100px'> Kendaraan </th>";
               

               var colomBarang = "<td class='kendaraan'> Barang </td>";
               var colomSupplier = "<td class='kendaraan'> Supplier </td>";

              /*  $('.addbarang td:eq(6)').append(colomBarang);
                $('.data-supplier td:eq(6)').append(colomSupplier);*/

              //$('.header-table th:eq(6)').append(rowColom);

              /*$("<th class='kendaraan' style='width:100px'> Kendaraan </th>").insertAfter($('.kolompembayaran'));
              $("<th class='kendaraan'> </th>").insertAfter($('.kolomtghpembayaran'));

              $("<td class='kendaraan'> <select class='form-control kendaraan kndraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id}}> {{$kndraan-> nopol}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
              }
              
            
              if(penerimaan == 'T'){
                 $('tr#trstock').hide();
                 valupdatestock = 'J';
                
                $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
                type : "post",
                data : {jenisitem,updatestock,penerimaan},
                dataType : "json",
                success : function(data) {
                  $('.loadingjenis').css('display' , 'none');
                  
                  arrItem = data;
                  console.log('arrItem' + arrItem);

                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                        //  console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+">"+obj.nama_masteritem+"</option>");
                        })
                         $('.barang').trigger("chosen:updated");
                         $('.barang').trigger("liszt:updated");
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong); 
                          $('.barang').trigger("chosen:updated");
                         $('.barang').trigger("liszt:updated");            
                  }
                }
              })

             }
             else if(penerimaan != 'T') {
                $('tr#trstock').show();
                $('td#trstock').show();

                if(updatestock != '') {

             
              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
                type : "post",
                data : {jenisitem,updatestock,penerimaan},
                dataType : "json",
                success : function(data) {
              //    console.log(data);
                  arrItem = data;
                  console.log('arrItem' + arrItem);
                  $('.loadingjenis').css('display', 'none');
                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                        //  console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+">"+obj.nama_masteritem+"</option>");
                        })
                         $('.barang').trigger("chosen:updated");
                         $('.barang').trigger("liszt:updated");
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);   
                          $('.barang').trigger("chosen:updated");
                         $('.barang').trigger("liszt:updated");          
                  }
                }
              })
            } 
           }
            
     })
    })*/



   var arrSupid = [];
   valbarang = new Array();
   //tambahdatabarang
   var counterId = 0;
   var no = 1;
   var idremovesup = 1;
   var tembar = [];
   var nourutbrg = 0;
   var nourutsup2 = 0;
   var urutsup = 1;
    $('#add-btn').click(function(){
      $('.cek_tb').attr('disabled', false);

      supplier = $('.suipl').val();

      console.log(supplier);

      console.log(valbarang);

       $('select[name*="idbarang"] option').attr('disabled' , false);


      var jnsitem = $('.jenisitem').val();
      var variable = jnsitem.split(",");
      var jenisitem = variable[0];
     // console.log(jenisitem);

      if(jenisitem == '') {
        toastr.info('Harap Memilih Group Item Terlebih Dahulu');
      }

      if($('.penerimaan').val() != 'T'){
        if($('.updatestock').val() == ''){
            toastr.info('Harap Memilih Update Stock Terlebih Dahulu');
        }

      }


      var rowStr  = "<tr class='addbarang' id='field-"+no+"' data-id='"+no+"'>";
          rowStr += "<td> "+no+"</td>";
          rowStr += "<td>";
                   
          rowStr += "<select  class='chosen-select-width barang brg"+no+" form-control idbarang"+counterId+" input-sm' data-id='"+counterId+"' style='width: 100%;' name='idbarang[]' required data-no='"+no+"'> "; //barang
                    if(arrItem.length > 0) {
          rowStr += " <option value=''>  -- Pilih Barang -- </option> ";            
                     $.each(arrItem, function(i , obj) {
                        supbtn = arrSupid;
                        rowStr +=  "<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+" style='display:block'>"+ obj.nama_masteritem+"</option>";
                      });
         

                      }
                      else{
          rowStr +=  "<option value=''> -- Data Kosong -- </option>";              
                      }
          rowStr += "</select> <br>  <div class='brgduplicate duplicate"+nourutbrg+"'> </div>   </td>" +
                    "<td> <input type='number' class='input-sm form-control kuantitas qty"+counterId+"' name='qty[]' data-id='"+no+"' required > <input type='hidden' class='qty_request' name='qty_request[]' value='"+no+"'>  <br> <div> </div> </td>" + //qty

                    "<td> <div class='stock_gudang"+counterId+"'> <br> <br> <div> </div> </td>" + //stockgudang

                    "<td> <div class='satuan"+counterId+"'>  <br> <br> <div> </div> </td>"+ //satuan

                    "<td> <input type='text' class='input-sm form-control hrga hargabrg"+no+" harga"+counterId+"' name='harga[]' data-id='"+counterId+"' data-no='"+no+"'/> <br> <div> </div> </td>"+ //harga

                    "<td> <select id='supselect' class='input-sm form-control select2 suipd suipl sup"+no+" supplier"+counterId+" datasup"+nourutbrg+"' data-id='"+counterId+"' style='width: 100%;' data-no='"+no+"' name='supplier[]' required=> <option value=''> -- Pilih Data Supplier -- </option> </select> <br> <div class='supduplicate supduplicate"+no+"'> </div> </td>"; //supplier

                  /*  "<td class='pembayaranken'> <div class='form-group'> <div class='col-sm-8'> <input type='text' class='form-control bayar"+counterId+"' name='bayar[]' data-id='"+counterId+"'> </div> <label class='col-sm-2 col-sm-2 control-label'> Hari </label></div></td>";*/ //bayar


          if(valupdatestock == 'T' && jenisitem == 'S' ){
            rowStr += "<td class='kendaraan'> <select class='chosen-select-width form-control' name='kendaraan[]'> @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id}}> {{$kndraan->nopol}} - {{$kndraan->merk}} </option> @endforeach </select> <br> <div> </div> </td>";
          }

          if(no != 1) {
           rowStr += "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+no+"' type='button'><i class='fa fa-trash'></i></button> <br> <div> </div></td>";
          } 

       
        rowStr += "</tr>";

     

      if(jenisitem != ''){
        $('#table-data').append(rowStr);
       }

       //harga
        $(function(){
            $('.harga' + counterId).change(function(){
                var id = $(this).data('id');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
               val = $(this).val();
      
               val = accounting.formatMoney(val, "", 2, ",",'.');
               $(this).val(val);

             //   $('.harga' + id).val(addCommas(numhar));
                $('.cek_tb').attr('disabled', false);
               $('.simpan').attr('disabled', true);
            })
        }) 

        //qty
        $(function(){
            $('.qty' + counterId).change(function(){
                var qty = $(this).val();
           
                var qty_request = qty;
         
              var id = $(this).data('id');
                $('.cek_tb').attr('disabled', false);
                $('.simpan').attr('disabled', true);

                var rowqty = "<input type='text' value="+ qty + ','+no+" name='qty_request[]'>";

                $('.qty_request' + id).html(rowqty);

            })
        }) 


       //supplier
         $(function(){
          $('.supplier' + counterId).change(function(){  

              $('.simpan').attr('disabled', true);
              $('.cek_tb').attr('disabled', false);

            var val = $(this).val();
            var id = $(this).data('id');
            var string = val.split(",");
            var bayar = string[1];
            var harga = string[5];
            var contract = string[4];
           // console.log(harga);
  
            // toastr.info(val);
             numhar = Math.round(harga).toFixed(2);

             if(contract == 'YA'){
                  if(harga === "undefined"){
              }
                else {
      
                 $('.harga' + id).val(addCommas(numhar));
                 $('.harga' + id).attr('readonly' , true); 
                }
             }
             else {
                  if(harga === "undefined"){
                 // toastr.info("undefined");
                }
                else {
                 // toastr.info('tidak_undefined');
                 $('.harga' + id).val(addCommas(numhar));
                 $('.harga' + id).attr('readonly' , true); 
                }
             }

           $('.bayar' + id).val(bayar);

          })

          .error(function(){
           // toastr.info('eror');
          })
            
        })
            

       
        //barang //satuan //harga
        barang = [];
        $(function(){      
          $('.idbarang'+counterId).click(function(){ 
        // Store the current value on focus and on change
           previous = this.value;
           var char = previous.split(",");
           var iditem = char[0];
          
           $this = $(this);
           barang = iditem;
          

         })
          .change(function(){
              var val = $(this).val();
             // toastr.info(val);
              var id = $(this).data('id');
              var string = val.split(",");
              var kodeitem = string[0];
              var nobarang = $(this).data('no');
              var hrgbrg = string[2];
             // alert(nobarang);
              console.log(valbarang);
             $('.loadingjenis').css('display' , 'block');

             gudang = $('.gudang').val();
             // toastr.info(kodeitem);
              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier',
                type : "GET",
                data : {kodeitem, gudang},
                dataType : "json",
                success : function(data) {
              $('.loadingjenis').css('display' , 'none');
                
                  arrSupid = data.supplier; //terikat kontrak

                  supplier = data.mastersupplier;
              
                  satuan = data.stock[0].unitstock;
                  stock = data.stock[0].sg_qty;
                  
                   supbtn = '';


                  if(!$.trim(stock)) {
                    var data = "<b style='color:red'>kosong</b>";

                    $('.stock_gudang' + id).html(data);
                  }
                  else {
                    var data = stock;
                    $('.stock_gudang' + id).html(data);
                  }

                   $('.satuan' + id).html(satuan);

                    var nosup = counterId - 1;
                    var nourut = no -1;
                    console.log(nourut + 'nourut');
            
                   

                     //$('.sup'+nourut).empty();

                    if(arrSupid.length > 0) { // terikat kontrak
                     console.log('supplier terikat kontrak');
                      $('.sup' + nobarang).empty();
                      $.each(arrSupid, function(i , obj) {
                      
                        $('.sup'+nobarang).append("<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+nobarang+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected id='selectsup'>"+obj.no_supplier+"-"+obj.nama_supplier+"</option>");
                      });
                      
                        supbtn = arrSupid;


                        var datasup = $('.sup'+nobarang).find('option:selected').val();
                        

                        var string = datasup.split(",");

                        console.log(string + 'string') 

                        console.log(string[0] + '0');
                        console.log(string[1] + '1');
                        console.log(string[2] + '2');
                        console.log(string[3] + '3');
                        console.log(string[4] + '4');
                        console.log(string[5] + '5');
                        console.log(string[6] + '6');
                        idcntr = counterId - 1;
                
                        if(string[4] == 'YA'){
                            if(string[4] == undefined){
                             
                            }
                            else {
                         
                            $('.hargabrg' + nobarang).val(addCommas(string[5]));
                            $('.hargabrg' + nobarang).attr('readonly' , true);
                          }
                        }
                        else {
                            if(string[4] == undefined){
                              
                            }
                            else {
                          
                            $('.hargabrg' + nobarang).val(addCommas(string[5]));
                          }
                        }

                        var syarat_kredit = string[1];
                        console.log(syarat_kredit);
                        $('.bayar' + id).val(syarat_kredit);
                    } // end arrSUpid
                    else { // TIDAK TERIKAT KONTRAK
                     console.log('tdk ada terikat kontrak');
                       $('.sup' + nobarang).empty();
                      $.each(supplier, function(i , obj) {
                      supbtn = supplier;
                      idcntr = counterId - 1;
               

                     $('.sup'+nobarang).append("<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+nobarang+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected id='selectsup'>"+obj.no_supplier+"-"+obj.nama_supplier+"</option>");
                    
                        var datasup = $('.sup'+nobarang).find('option:selected').val();
                  
                        var string = datasup.split(",");
                      
                        var syarat_kredit = string[1];
                       console.log(syarat_kredit);
                        empty = ' ';
                        console.log(hrgbrg + 'hrgbrg');
                        $('.bayar' + id).val(empty);
                       $('.hargabrg' + nobarang).attr('readonly' , false);
                        $('.hargabrg' + nobarang).val(addCommas(hrgbrg));
                     
                      });
                    }
             
                }

              })
              $('.simpan').attr('disabled', true);
                $('.cek_tb').attr('disabled', false);

          })
        })

      arrnobrg.push(no);
      counterId++;
      no++;
      countersup++;
      idremovesup++;
      nourutbrg++;
      nourutsup2++;
    })

     countersup = 0;
      //TAMBAHDATASUPPLIER
     $('#add-btn-supp').click(function(){
              $('.cek_tb').attr('disabled', false);
      $('.loadingjenis').css('display' , 'block');

              var idtrsup = no - 1;
              var lastarr = arrnobrg.slice(-1)[0];
              val2 = $('.brg' + lastarr).val();
              var string = val2.split(",");
              var kodeitem2 = string[0];
              var hargabrgsup = string[2];
              urutsup++;
              var removesup = idremovesup - 1;
              var id = $('.brg' + idtrsup).data("id");
              if(idtrsup != removesup){
                removesup = idtrsup;
              }
              else {
                removesup = removesup;
              }
              $sup++;            
              countersup++;

              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier/' + kodeitem2,
                type : "GET",
                dataType : "json",
                success : function(data) {
      $('.loadingjenis').css('display' , 'none');
  					 
  					    hasilsupp = data.supplier //terikat kontrak
                hasilmaster = data.mastersupplier // tdkterikatkontrak
				
      					if($('.brg' + idtrsup).val() == ''){
      						toastr.info('Silahkan Memilih Data Barang Terlebih Dahulu');
      					}

      					var rowSup = "<tr id='supp-"+idtrsup+"' class='data-supplier supp-"+counterId+"'>";
      					rowSup += "<td></td> <td></td>  <td> </td> <td></td> <td>  </td>"+
      							"<td> <input type='text' name='harga[]' data-id='"+counterId+"' class='input-sm form-control hrga hargabrg"+idtrsup+" harga"+counterId+"' data-id="+counterId+" data-no="+removesup+" '/></td>"+ //harga
      							"<td><select id='supselect' class='form-control select2  suipd suipl sup"+idtrsup+" supplier"+counterId+" datasup"+nourutbrg+"' data-id='"+counterId+"' style='width: 100%;' data-no='"+idtrsup+"' name='supplier[]' required=> <option value=''> -- Pilih Supplier -- </option>"; //SUpplier
      					
                if(hasilsupp.length > 0){ //TERIKAT KONTRAK
                      $.each(hasilsupp, function(i , obj) {
                        rowSup +=  "<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+idtrsup+","+obj.nama_supplier+","+obj.is_contract+","+obj.is_harga+","+obj.idsup+"' selected>"+obj.no_supplier+"-"+ obj.nama_supplier+"</option>";
                      }) 
                }
                else {
                   $.each(hasilmaster, function(i , obj) {
                        rowSup +=  "<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+idtrsup+","+obj.nama_supplier+","+obj.is_contract+","+obj.is_harga+","+obj.idsup+"' selected>"+obj.no_supplier+"-"+ obj.nama_supplier+"</option>";
                      }) 
                }

      					rowSup  +="</select><br> </td>"; //supplier
      					
      					rowSup +=  "<td> <button class='btn btn-sm btn-danger remove-btn' data-id='"+idtrsup+"' type='button'><i class='fa fa-trash'></i></button></td>";
      					rowSup += "</tr>";
       
      					if($('.brg' + idtrsup).val() != ''){
      						if($('tr#supp-'+ idtrsup).length < 2) {          
      							$('#table-data').append(rowSup);

                    if(hasilsupp.length > 0){
                       var datasup = $('.sup'+idtrsup).find('option:selected').val();                        

                        var string = datasup.split(",");
                        console.log(string[4])
                        idcntr = counterId - 1;
             
                        if(string[4] == 'YA'){
                            if(string[4] == undefined){
                              
                            }
                            else {
                              $('.hargabrg' + idtrsup).val(addCommas(string[5]));
                              $('.hargabrg' + idtrsup).attr('readonly' , true);
                          }
                        }
                        else {
                            if(string[4] == undefined){
                          
                            }
                            else {                          
                              $('.harga' + id).val(addCommas(string[5]));
                              $('.hargabrg' + idtrsup).val(addCommas(string[5]));
                          }
                        }

                        var syarat_kredit = string[1];
                        console.log(syarat_kredit);
                      $('.bayar' + id).val(syarat_kredit);
                    }
                    else { //TIDAK TERIKAT KONTRAK
                     
                      var datasup = $('.sup'+idtrsup).find('option:selected').val();                  
                        //  console.log('datasup' + datasup);
                        var string = datasup.split(",");
                      
                        var syarat_kredit = string[1];
                    
                        empty = ' ';
                        
                        $('.bayar' + id).val(empty);
                       $('.hargabrg' + idtrsup).attr('readonly' , false);
                       
                        $('.hargabrg' + idtrsup).val(addCommas(hargabrgsup));      
                        $('.bayar' + id).val(syarat_kredit);
                      
                      }
      						  }
      						  else{
      						  toastr.info('Supplier telah mencapai batas maksimum');
      						}
      					}
       

					$(function(){
						$('.harga' + counterId).change(function(){
							var id = $(this).data('id');
						

               val = $(this).val();
      
             val = accounting.formatMoney(val, "", 2, ",",'.');
             $(this).val(val);

					//		$('.harga' + id).val(addCommas(numhar));

						   $('.simpan').attr('disabled', true);
                $('.cek_tb').attr('disabled', false);

						})
					}) 

      
					  $(function(){
						$('.qty2' + counterId).change(function(){					 
							var id = $(this).data('id');						  
							harga = $(this).val();	 
						})
					}) 

				  // toastr.info('test');     
					var val = $(this).val();
					var id = $(this).data('id');
					var string = val.split(",");
					var bayar = string[1];
					var harga = string[5];
					var contract = string[4];
				  //  console.log(val);
					 $('.simpan').attr('disabled', true);
            $('.cek_tb').attr('disabled', false);

					  console.log(val);
					 numhar = Math.round(harga).toFixed(2);

					 if(contract == 'YA'){
						if(harga === "undefined"){
						}
						else {
						 $('.harga' + id).val(addCommas(numhar));
						 $('.harga' + id).attr('readonly' , true); 
						}
					 }
					 else {
						if(harga === "undefined") {
						  
						}
						else {
							$('.harga' + id).val(addCommas(numhar)); 
						}
					 }

					$('.bayar' + id).val(bayar);
				}
				})
			
        


    counterId++;
    nourutsup2++;
   // nourutbrg++;
   /* countsup++;*/
    })     

    //hapusbarang
    $(document).on('click','.removes-btn',function(){
        var id = $(this).data('id');
        var parent = $('#field-'+id);
        var valField = parent.find('.harga'+id).val();
        
        nmbarang = $('.brg' + id).val();
        split = nmbarang.split(",");
        kodebrg = split[0];
       
        index = valbarang.indexOf(kodebrg);
        valbarang.splice(index, 1);
        console.log(valbarang);

        $('table#table-data tr#field-'+id).remove();
        $('table#table-data tr#supp-'+id).remove();
 
        idremovesup = idremovesup - 1;
        var id = $(this).data('id');
        var parent2 = $('#supp-'+id);
        no = no - 1;

        var index = arrnobrg.indexOf(id);
        arrnobrg.splice(index, 1);
       parent2.remove();
    })

   var $sup = 0;

   //hapussupplier
  $(document).on('click','.remove-btn',function(){
        var id = $(this).data('id');
        var parent = $('#supp-'+id);
        var parenttr = $('.supp-'+id);
      /*  valsup = $('.sup' + id);
        split = valsup.split(",");
        idsup = split[6];
        index = valsup.indexOf(idsup);
        valsup.splice(index, 1);*/


        parent.remove();

  })
 

</script>
@endsection
