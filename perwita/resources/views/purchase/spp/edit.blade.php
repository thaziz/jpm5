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
                    <div class="text-right">
                        <a  class="btn btn-sm btn-default" href={{url('suratpermintaanpembelian')}}> <i class="fa fa-arrow-left"> </i>Kembali </a>
                    </div>
                </div>

                <div class="ibox-content">
                   <div class="row">
                       <div class="col-xs-12">
                          <div class="box-header">
                          </div><!-- /.box-header -->


                           <form method="post" action="{{url('suratpermintaanpembelian/updatespp')}}"  enctype="multipart/form-data" class="form-horizontal" id="formId">
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
                                        <td> {{$data['jenisitem']}} <input type="hidden" value="{{$data['kodejenisitem']}}" class="jenisitem" name='jenisitem'> <input type="hidden" value="{{$data['stockjenisitem']}}" class="stockjenisitem">  </td>
                                     </tr>
                    
                                      <tr>
                                        <td  id="tdstock"> Apakah Update Stock ? </td>
                                        <td id="tdstock" class="disabled">
                                           @if($spp->spp_tipe == 'S')
                                         <select class="form-control updatestock" name="updatestock"  id="updatestock" > <option value="Y"  selected=""> Ya </option> <option value="T"> TIDAK </option> </select>

                                          @elseif($spp->spp_tipe == 'NS')
                                          <select class="form-control updatestock" name="updatestock"  id="updatestock" readonly> <option value="Y" > Ya </option> <option value="T" selected=""> TIDAK </option> </select>
                                           @endif
                                        </td>
                                      </tr>
                                     


                                        @if($spp->spp_tipe != 'J')
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
                              

                                      <input type='hidden' class='spptipe' value="{{$spp->spp_tipe}}">

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
                        <div class="table-responsive">
                        <table class="table table-striped" id="table-barang">
                          <thead>
                          <tr>
                              
                              <th> Barang </th>
                              <th class='qtyrequestkolom'> Qty Request </th>
                              <th class='nopolkolom'> Nopol Kendaraan </th>
                              <th style="min-width: 100px"> Satuan </th>                           
                              <th> Harga </th>
                              <th> Supplier </th>
                              <th> Aksi </th>
                              <th> Hapus Barang </th>
                              
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($data['sppdt_barang'] as $index=>$sppdtbarang)
                            <tr class=" databarang databarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}">
                              <td rowspan="3"> {{$sppdtbarang->nama_masteritem}} </td>
                         
                              <td rowspan="3" class="qtyrequestkolom">  <input type="text" class="form-control input-sm qtyreq qtyreq{{$index}}" value="{{$sppdtbarang->sppd_qtyrequest}}" data-id="{{$index}}" style="width: 90px" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}"> </td>
                              
                              <td rowspan="3" class="nopolkolom">

                              <select class='form-control chosen-select kendaraan kendaraan{{$index}}' name='kendaraan[]' data-index="{{$index}}">
                                @foreach($data['kendaraan'] as $kendaraan)
                                  <option value="{{$kendaraan->id}}" @if($kendaraan->id == $sppdtbarang->sppd_qtyrequest) selected="" @endif> {{$kendaraan->nopol}} </option>
                                @endforeach
                              </select>
                              </td>

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
                              
                              <td> </td>
                              <td rowspan="3"> <button class="btn btn-md btn-warning removebarang" type="button" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}"> <i class="fa fa-trash"> </i> </button>  </td>

                              <tr class="databarang{{$index}} datacek1 datacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-index="{{$index}}"> 
                                <td>
                                  <!--Kodeitem  -->
                                  <input type='text' class="form-control hargacek hargacek1 hargacekbarang{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1' style="min-width:30px" name="hargacek[]">

                                  <input type='hidden' class="form-control hargamanual1 hargacekmanual{{$index}}" data-kodeitem="{{$sppdtbarang->sppd_kodeitem}}" data-id='1'>
                                  @if($data['spp'][0]->spp_tipe == 'NS' && $data['jenisitem'] == 'S')
                                  <input type="hidden" class="kendaraanid1 kendaraan{{$index}}" value="{{$sppdtbarang->sppd_kendaraan}}" name="kendaraan[]" data-index="{{$index}}">
                                  @endif

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

                                   @if($data['spp'][0]->spp_tipe == 'NS' && $data['jenisitem'] == 'S')
                                  <input type="hidden" class="kendaraanid1 kendaraan{{$index}}" value="{{$sppdtbarang->sppd_kendaraan}}" name="kendaraan[]" data-index="{{$index}}">
                                  @endif


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
                        </div>
              
             <!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                       <input type="submit" class="btn btn-success btn-flat simpantb" disabled="" value="Simpan Data Rencana Pembelian" >   
                      
                        <a class="btn btn-primary" id="cektb"> Cek Total Biaya </a>
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



     $('#formId').submit(function(event){
      //alert('test');
        $('.kendaraan').each(function(){
          val = $(this).val();
          if(val == ''){
            toastr.info("Mohon maaf data kendaraan kosong :)");
            return false;
          }
        })

        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Penerimaan Barang!",
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
             alertSuccess(); 
             $('.simpantb').attr('disabled' , true);
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      }) 

    jenisitem = $('.jenisitem').val();
    tipespp = $('.spptipe').val();
    $('th.nopolkolom').hide();
    $('td.nopolkolom').hide();
    

    if(jenisitem == 'S'){
      if(tipespp == 'NS'){
        $('th.nopolkolom').show();
        $('td.nopolkolom').show();

      }
    }

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
                  for($z = 0; $z < response.supplier.length; $z++){
                    $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.supplier[$z][0].is_idsup+">" + response.supplier[$z][0].no_supplier+" - "+response.supplier[$z][0].nama_supplier+"</option>");
                  }
               }
               else if(response.temp[$i] == '1'){
                  for($z = 0; $z < response.supplier2.length; $z++){
                    $('.suppliercek' + $key + '[data-kodeitem = '+kodeitem+']').append("<option value="+response.supplier2[$z].idsup+">" +response.supplier2[$z].no_supplier+" - "+response.supplier2[$z].nama_supplier+"</option>");
                    
                  }
               }  
                
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
                  for($z = 0; $z < response.itemsupplier.length; $z++){
                    $(this).append("<option value="+response.itemsupplier[$z][0].is_idsup+">" +response.itemsupplier[$z][0].no_supplier+" - "+response.itemsupplier[$z][0].nama_supplier+"</option>");
                  
                  }
                $(this).trigger("chosen:updated");
                $(this).trigger("liszt:updated");
               }
               else if(response.temp[$k] == '1'){
             
                  for($z = 0; $z < response.supplier2.length; $z++){                 
                    $(this).append("<option value="+response.supplier2[$z].idsup+">" +response.supplier2[$z].no_supplier+" - "+response.supplier2[$z].nama_supplier+"</option>");
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


  $('.hargacek').change(function(){
    val = $(this).val();
       val = accounting.formatMoney(val, "", 2, ",",'.');
      $(this).val(val);
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
            
            html = "<tr class='databarang databarang"+index+"'>" +
                    "<td rowspan='3'>";
                   
            html += "<select class='form-control chosen-select barang barang"+index+"' data-index="+index+" style='min-width:200px' name='barang[]'>";
                  html += "<option value=''> Pilih Barang </option>"
               for(i = 0; i < response.kodeitem.length; i++){
                     html += "<option value='"+response.kodeitem[i].kode_item+"'>" +
                         response.kodeitem[i].kode_item + " - " + response.kodeitem[i].nama_masteritem +
                      "</option>";
                    }
            html += "</select>" +
                    "</td>" + // barang 
                    "<td rowspan='3'><input type='text' class='form-control input-sm qtyreq qtyreq"+index+"' data-index='"+index+"' style='min-width:90px' name='qtyrequest[]' data-id='"+index+"'> </td>";
                     //qty
                     if(jenisitem == 'S' && updatestock == 'T' ){
                        html += "<td rowspan='3'> <select class='form-control chosen-select kendaraan kendaraan"+index+"' data-index='"+index+"'>";
                        html += "<option value=''> </option>";
                            for($j = 0; $j < response.kendaraan.length; $j++){
                        html +=   "<option value='"+response.kendaraan[$j].id+"'>"+response.kendaraan[$j].nopol+"</option>";
                            }
                     }
            html += "</select> </td>" +
                  "<td rowspan='3'> Satuan </td>" +
                 "<td> <input type='text' class='form-control hargacek hargacek0 hargacekbarang"+index+"' data-id='0' name='hargacek[]' data-index="+index+" style='min-width:200px'> </td>"+ //harga
                  "<td> <select class='form-control chosen-select suppliercek0 suppliercekbarang"+index+" suppliercek' name='suppliercek[]' data-id='0' data-index="+index+">";
                    for(j = 0; j < response.supplier.length; j++){
                        html += "<option value='"+response.supplier[j].idsup+"'>" +
                                 response.supplier[j].no_supplier + " - " + response.supplier[j].nama_supplier +
                                 "</option>";
                    }
           html+= "</td> <td> </td>" + //supplier
                  "<td rowspan='3'> <button class='btn btn-md btn-warning removebarang' type='button' data-index="+index+"> <i class='fa fa-trash'> </i> </button>  </td>" +
                  "</tr>" +

                  "<tr class='databarang"+index+" datacek1 datacekbarang"+index+"' data-index="+index+">" +
                  "<td> <input type='text' class='form-control hargacek hargacek1 hargacekbarang"+index+"' data-id='1' name='hargacek[]' data-index="+index+">  <input type='hidden' class='barangcek"+index+" barangid1' name='barang[]' data-index='"+index+"'>" + //namabarang
                    "<input type='hidden' class='qtyrequest"+index+" qtyrequestid1' name='qtyrequest[]' data-index='"+index+"'>" +//qty </td>"+ //harga
                   "<input type='hidden' class='kendaraanid1 kendaraan"+index+"' name='kendaraan[]' data-index="+index+">" +
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
                     
                    "<td><input type='text' class='form-control hargacek hargacek2 hargacekbarang"+index+"' data-id='2' name='hargacek[]' data-index="+index+"> <input type='hidden' class='barangcek"+index+" barangid2' name='barang[]' data-index='"+index+"'>" + //namabarang
                    
                    "<input type='hidden' class='qtyrequest"+index+" qtyrequestid2' name='qtyrequest[]' data-index='"+index+"'>" +
                    "<input type='hidden' class='kendaraanid2 kendaraan"+index+"'  name='kendaraan[]' data-index="+index+">"+//qty</td>"+ //harga
                    "<td> <select class='form-control chosen-select suppliercek2 suppliercekbarang"+index+" suppliercek' name='suppliercek[]' data-id='2' data-index="+index+">";
                      for(j = 0; j < response.supplier.length; j++){
                          html += "<option value='"+response.supplier[j].idsup+"'>" +
                                   response.supplier[j].no_supplier + " - " + response.supplier[j].nama_supplier +
                                   "</option>";
                      }

           html += "</select>" + //supplier
                 "</td> <td> <button class='btn btn-md btn-danger removecek removecek2 removecekbarang"+index+"' type='button' data-id='2' data-index="+index+"> <i class='fa fa-trash'> </i> </button> </td>" + 
                  "</tr>";

                $('#table-barang').append(html);
            
            //changesupplier
            $('.suppliercek').change(function(){
                id = $(this).data('id');
                index = $(this).data('index');
                kodeitem = $('.barang' + index).val();
                supplier = $(this).val();
                $('.removecek' + id + '[data-index = '+index+']').attr('disabled' , true);
                $.ajax({
                  url : baseUrl + '/konfirmasi_order/cekharga',
                  type : "get",
                  dataType : 'json',
                  data : {kodeitem,supplier},
                  success : function(response){
                     $('.removecek' + id + '[data-index = '+index+']').attr('disabled' , false);     
                     $('.hargacek' + id + '[data-index = '+index+']').val(addCommas(response.harga));
                     $('.simpantb').attr('disabled' , true);
   
                  }
                })
              })

              //qty
              $('.qtyreq').change(function(){
                index = $(this).data('index');
                val = $(this).val();
             //   alert(index);
                $('.qtyrequest' + index + '[data-index = '+index+']').val(val);
              });


              $('.kendaraan').change(function(){
                index = $(this).data('index');
                val = $(this).val();
                $('.kendaraan' + index + '[data-index = '+index+']').val(val);
              })

              //ganti barang
              $('.barang').change(function(){
                 index = $(this).data('index');
                 val = $(this).val();
                 gudang = $('.gudang').val();
                 kodeitem = val;
                 penerimaan = $('.stockjenisitem').val();
                 $.ajax({
                    data : {kodeitem, gudang, penerimaan},
                    url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier',
                    dataType : 'json',
                    type : "get",
                    success : function(response){
                       $('.simpantb').attr('disabled' , true);
                         $('.barangcek' + index + '[data-index = '+index+']').val(val);
                        arrSupid = response.supplier; //terikat kontrak
                        supplier = response.mastersupplier;
                       $('.suppliercekbarang' + index).empty();
                        if(arrSupid.length > 0){
                        
                            for(j = 0; j < arrSupid.length; j++){
                             
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
                  $('.barangid' + id + '[data-index='+index+']').val('');
                  $('.qtyrequestid' + id + '[data-index='+index+']').val('');
                  $('.kendaraanid' + id + '[data-index='+index+']').val('');
                  $('.suppliercek' + id + '[data-index = '+index+']').trigger("chosen:updated");
                   $('.suppliercek' + id + '[data-index = '+index+']').trigger("liszt:updated");
                   $('.simpantb').attr('disabled' , true);      
             })

            // harga
             $('.hargacek').change(function(){
              val = $(this).val();
                 val = accounting.formatMoney(val, "", 2, ",",'.');
                $(this).val(val);
              $('.simpantb').attr('disabled' , true);
            })
          }
      })
    })
  
  
   $('#cektb').click(function(){
    
      arrjumlahtotal = [];

      $('.qtyreq').each(function(){
        qty = $(this).val();
        idqty = $(this).data('id');
        index = $(this).data('index');
        if(qty == ''){
          toastr.info("Mohon maaf data qty kosong :)");
          return false;
        }
      
     // alert(qty + 'qty');
     // alert(idqty + 'idqty');
        $('.hargacekbarang'+ idqty).each(function(){
          harga2 = $(this).val();
          idharga = $(this).data('id');
          kodeitem = $(this).data('kodeitem');
       //   alert(harga2);

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
                    html += "<td> <div class='col-sm-4'> <input type='text' class='form-control input-sm' name='syaratkredit[]' value="+response.datasupplier[$j][0].syarat_kredit+" readonly> </div> <div class='col-sm-4'> Hari </div></td>";
                    }
                    else {
                    html +=  "<td> <div class='col-sm-4'> <input type='text' class='form-control input-sm' name='syaratkredit[]' value="+response.datasupplier[$j][0].syarat_kredit+"> </div> <div class='col-sm-4'> Hari </div> </td>";
                    }
              html += "</tr>"
            
              $('#tbl-pembayaran').append(html);
              $('.simpantb').attr('disabled' , false);
            }
        }
      })      
  });


    //remove barang
    $('.removebarang').click(function(){
      index = $(this).data('index');
      kodeitem = $(this).data('kodeitem');
     // alert(index);
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

   

</script>
@endsection
