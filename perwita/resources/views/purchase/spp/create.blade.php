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

.chosen-container .chosen-results {
    max-height: 120px !important;
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
                                    <table class="table table-striped" id='table-utama'>
                                          <tr>
                                            <td width="200px"> Kode SPP </td>
                                            <td> <input type='text' class="input-sm form-control nospp"  name="nospp" readonly=""></td>
                                            <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                                          </tr>
                                            <tr>
                                              <td> Tgl Input </td>
                                              <td> {{-- <input type='text' class='form-control' value="{{ Carbon\Carbon::now()->format('d-M-Y ') }}" disabled=""> --}}
                                                <div class="input-group date" required="">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tglinput"  required="">

                                                       
                                                  </div>

                                              </td>
                                            </tr>
                                         

                                             <tr>
                                              <td> Cabang </td>
                                              <td>                                              

                                               @if(Auth::user()->punyaAkses('Surat Permintaan Pembelian','cabang'))
                                              <select class="form-control chosen-select cabang" name="cabang">
                                                  @foreach($data['cabang'] as $cabang)
                                                <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->kode}} - {{$cabang->nama}} </option>
                                                @endforeach
                                              </select>
                                              @else
                                                <select class="form-control disabled cabang" name="cabang">
                                                  @foreach($data['cabang'] as $cabang)
                                                  <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                                                  @endforeach
                                                </select> 
                                              @endif
                                              
                                              </td>
                                             </tr>
                                              
                                          </tr>

                                      
                                          <tr>
                                              <td>
                                                Tanggal di butuhkan 
                                              </td>
                                              <td>
                                                  <div class="input-group date" required="">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control" name="tgl_dibutuhkan" required="">

                                                       <!--  <input type="hidden" class="valcabang" name="comp"> -->
                                                  </div>
                                              </td>  
                                          </tr>
                                         
                                          <tr>
                                            <td>
                                              Keperluan
                                            </td>

                                            <td> 
                                            <input type="text" class="input-sm form-control" name="keperluan" required=""> <input type="hidden" class="valcabang" name="cabang">
                                            </td>
                                          </tr>
                                        
                                        <tr>
                                          <td>
                                            Bagian / Department
                                          </td>
                                          <td>
                                            <select class="chosen-select-width" name="bagian" required="">
                                              <option value> -- Pilih Bagian / Departmen -- </option>
                                              @foreach($data['department'] as $department)
                                                <option value="{{$department->kode_department}}"> {{$department->nama_department}} </option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>

                                      

                                        <tr>
                                          <td> Group Item </td>
                                          <td> <select class="form-control jenisitem" required="" name="jenisitem" id="selectgroup">
                                           <option value=""> -- Pilih Group Item -- </option>
                                           @foreach($data['jenisitem'] as $jnsitem)
                                            <option value="{{$jnsitem->kode_jenisitem}},{{$jnsitem->stock}}"> {{$jnsitem->keterangan_jenisitem}} </option>
                                           @endforeach 
                                          </select> <input type="hidden" name="spp_penerimaan" class="penerimaan"> </td>
                                        </tr>
                                     
                                      <tr>
                                        <td  id="tdstock"> Apakah Update Stock ? </td>
                                       <!--  <td>  <div class="checkbox">
                                            <input type="checkbox"  class="check" value="option1" aria-label="Single checkbox One">
                                            <label></label>
                                            </td> -->

                                        <td id="tdstock">  <select class="form-control updatestock" name="updatestock"  id="updatestock"> <option value="Y"> Ya </option> <option value="T"> TIDAK </option> </select></td>
                                      </tr>



                                      <tr class="lokasigudang">
                                       <td> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control chosen-select gudang' name='gudang'> </select> </td> </td>
                                      </tr>
                               <!--    <button class='btn btn-danger remv-btn' type='button'> hapus </button> -->
                                    <tr>
                                      <td> Keterangan </td>
                                      <td> <input type="text" class="input-sm form-control" name="keterangan">  </td>
                                    </tr>
                                  </table>

                                  
                               </div>
                               
                               <div class="col-md-6">
                                <h4> Total Biaya Per Supplier </h4>
                                  <table class='table' id="tbl_total_sup"> 
                                    <tr> <th> Supplier </th> <th> Total Pembayaran</th> </tr>
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
                                 
                                  <table id="table-data" class="table table-bordered" width="100%">
                                  <tr class="header-table">
                                      <th> No  </th>
                                       <th> Nama Barang</th>
                                      <th style="width:100px"> Jumlah </th>
                                      <th> Stock Gudang </th>
                                      <th> Satuan </th>
                                       <th> Harga </th>
                                      <th  class="kolompembayaran"> Supplier </th>
                                  <!--     <th class="kolompembayaran" style="width:10px" id="pembayaran"> Pembayaran </th> -->
                                      <th style="width:5px"> Aksi </th>
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                  </tr>

                                  <tr>
                                    <td> </td>
                                    <td>  <b id="add-btn" class="btn btn-info btn-flat">Tambah Data Barang</b> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td>  </td>
                                    <td class="kolomtghpembayaran">  <b id="add-btn-supp" class="btn btn-info btn-flat">Tambah Data Supplier </b> </td>
                                   <!--  <td >  </td> -->
                                    <td> </td>
                                  </tr>


                               

                                 </table>
                                 
                                </div>
                           
           
              
             <!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                       <input type="submit"  class="btn btn-success btn-flat simpan" disabled="" value="Simpan Data Rencana Penjualan" >     
                      </form>
                        <a class="btn btn-primary cek_tb"> Cek Total Biaya </a>
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
    }).datepicker("setDate", "0");

   // today = new Date();
   // $('.tglinput').val('09/03/2018');

     $('.tglinput').change(function(){
       var cabang = $('.cabang').val();
        var tglinput = $('.tglinput').val();
        $('.valcabang').val(comp);
          $.ajax({    
              type :"get",
              data : {cabang,tglinput},
              url : baseUrl + '/suratpermintaanpembelian/getnospp',
              dataType:'json',
              success : function(data){
               if(data.status == 'sukses'){
                        var d = new Date(tglinput);               
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


//      $(".suipd").chosen(config);
     
    })
     },2000);


    /*$('#table-data').DataTable({
      "scrollX" : true,
    });*/

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


       comp = $('.cabang').val();
       tglinput = $('.tglinput').val();
        $.ajax({    
            type :"get",
            data : {comp,tglinput},
            url : baseUrl + '/suratpermintaanpembelian/getnospp',
            dataType:'json',
            success : function(data){
                if(data.status == 'sukses'){
                      var d = new Date(tglinput);               
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


    

    $('.cabang').change(function(){    
      var comp = $(this).val();
      var tglinput = $('.tglinput').val();
      $('.valcabang').val(comp);
        $.ajax({    
            type :"get",
            data : {comp,tglinput},
            url : baseUrl + '/suratpermintaanpembelian/getnospp',
            dataType:'json',
            success : function(data){
             if(data.status == 'sukses'){
                      var d = new Date(tglinput);               
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
      $('.penerimaan').val(penerimaan);
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
           
              $('.lokasigudang').show();
          }
          else if(val == 'T') {
           
             valupdatestock = val;
      
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
             $('.lokasigudang').show();
           //  $("rowColom").insertAfter("#pembayaran");
        }
      }
    
      else {
          if(penerimaan == 'Y'){
           if(val == 'Y') {
               $('#tdstock').show();
            $('.updatestock').show();
              valupdatestock = val;
                $('.kendaraan').remove();
         
              $('.lokasigudang').show();
          }
          else {
             valupdatestock = val;
          
              $('.lokasigudang').show();
            
          }
        }
        else {
            $('.lokasigudang').hide();
            $('#tdstock').hide();
            $('.updatestock').hide();
            valupdatestock = 'J';
           
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
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+"> <h5>"+obj.kode_item+" - "+obj.nama_masteritem+" </h5> </option>");
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
           
        //   console.log(lengthsup + 'lengthsup ke-' + nmrbrg);

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
      kodestock = variable[1];
      $('.penerimaan').val(penerimaan);
      

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
            
              $('.lokasigudang').show();
          }
          else if(val == 'T') {
           
             valupdatestock = val;
        
            $('.header-table').find($('.kendaraan')).remove();
            var rowColom = "<th class='kendaraan' style='width:100px'> Kendaraan </th>";
             

             var colomBarang = "<td class='kendaraan'> Barang </td>";
             var colomSupplier = "<td class='kendaraan'> Supplier </td>";


            $("<th class='kendaraan' style='width:100px'> Kendaraan </th>").insertAfter($('.kolompembayaran'));
            $("<th class='kendaraan'> </th>").insertAfter($('.kolomtghpembayaran'));

            $("<td class='kendaraan'> <select class='form-control kendaraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id}}> {{$kndraan->nopol}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
            
           //  $("rowColom").insertAfter("#pembayaran");
        }
      }
    
      else {
        if(penerimaan == 'Y'){
           if(val == 'Y') {
               $('#tdstock').show();
            $('.updatestock').show();
              valupdatestock = val;
                $('.kendaraan').remove();
         
              $('.lokasigudang').show();
          }
          else {
             valupdatestock = val;
          
              $('.lokasigudang').show();
            
          }
        }
        else {
            $('.lokasigudang').hide();
            $('#tdstock').hide();
            $('.updatestock').hide();
            valupdatestock = 'J';
           
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
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+"> <h5> "+obj.kode_item+" - "+obj.nama_masteritem+" </h5> </option>");
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
     counterId++;
      $('.cek_tb').attr('disabled', false);

      supplier = $('.suipl').val();

    

       $('select[name*="idbarang"] option').attr('disabled' , false);


      var jnsitem = $('.jenisitem').val();
      var variable = jnsitem.split(",");
      var jenisitem = variable[0];
      kodestock = variable[1];
     // console.log(jenisitem);

      if(jenisitem == '') {
        toastr.info('Harap Memilih Group Item Terlebih Dahulu');
        return false;
      }

      if($('.penerimaan').val() != 'T'){
        if($('.updatestock').val() == ''){
            toastr.info('Harap Memilih Update Stock Terlebih Dahulu');
            return false;
        }

      }

         $.ajax({
            type : "get",
            data  : {kodestock},
            url : baseUrl + "/fakturpembelian/datagroupitem",
            dataType : "json",
            success : function(response){
             
              for(i = 0; i < response.countgroupitem; i++){
              //  console.log(response.groupitem[i].kode_jenisitem+','+response.groupitem[i].stock);
                 $('#selectgroup option[value="'+response.groupitem[i].kode_jenisitem+','+response.groupitem[i].stock+'"]').remove();
              }

              /*$('#selectgroup option[value="J,T"]').remove();*/
            }
          })

      var rowStr  = "<tr class='addbarang' id='field-"+no+"' data-id='"+no+"'>";
          rowStr += "<td> "+no+"</td>";
          rowStr += "<td>";
                   
          rowStr += "<select  class='chosen-select-width barang brg"+no+" form-control idbarang"+counterId+" input-sm' data-id='"+counterId+"' style='width: 100%;' name='idbarang[]' required data-no='"+no+"'> "; //barang
                    if(arrItem.length > 0) {
          rowStr += " <option value=''>  -- Pilih Barang -- </option> ";            
                     $.each(arrItem, function(i , obj) {
                        supbtn = arrSupid;
                        rowStr +=  "<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+" style='display:block'>"+obj.kode_item+" - "+ obj.nama_masteritem+"</option>";
                      });
         

                      }
                      else{
          rowStr +=  "<option value=''> -- Data Kosong -- </option>";              
                      }
          rowStr += "</select> <br>  <div class='brgduplicate duplicate"+nourutbrg+"'> </div>   </td>" +
                    "<td> <input type='number' class='input-sm form-control kuantitas qty"+counterId+"' name='qty[]' data-id='"+no+"' required > <input type='hidden' class='qty_request' name='qty_request[]' value='"+no+"'> <input type='hidden' class='statuskontraksupplier"+counterId+"' name='statuskontrak[]'> <br> <div> </div> </td>" + //qty

                    "<td> <div class='stock_gudang"+counterId+"'> <br> <br> <div> </div> </td>" + //stockgudang

                    "<td> <div class='satuan"+counterId+"'>  <br> <br> <div> </div> </td>"+ //satuan

                    "<td> <input type='text' class='input-sm form-control hrga hargabrg"+no+" harga"+counterId+"' name='harga[]' style='text-align:right' data-id='"+counterId+"' data-no='"+no+"'/> <br> <div> </div> </td>"+ //harga

                    "<td> <select id='supselect' class='form-control chosen-select-width suipd suipl sup"+no+" supplier"+counterId+" datasup"+nourutbrg+"' data-id='"+counterId+"' data-no='"+no+"' name='supplier[]' required=> <option value=''> -- Pilih Data Supplier -- </option> </select> <br> <div class='supduplicate supduplicate"+no+"'> </div> </td>"; //supplier

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
        $('#updatestock').addClass('disabled');

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
     //       var contract = string[4];
           // console.log(harga);
            contract = $('.statuskontraksupplier' + id).val();
            // toastr.info(val);
             numhar = Math.round(harga).toFixed(2);

             if(contract == 'YA'){
                  if(harga === "undefined"){
                 }
                else {
      
                 $('.harga' + id).val(addCommas(numhar));
                 $('.harga' + id).attr('readonly' , false); 
                }
             }
             else {
                  if(harga === "undefined"){
                 // toastr.info("undefined");
                }
                else {
                 // toastr.info('tidak_undefined');
                 $('.harga' + id).val(addCommas(numhar));
                 $('.harga' + id).attr('readonly' , false); 
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
             jnsitem = $('.jenisitem').val();
             variable = jnsitem.split(",");
             jenisitem = variable[0];
              penerimaan = variable[1];
              if(penerimaan == ' YA'){
                if(gudang == ''){
                  toastr.info('Harap Pilih Gudang :)');
                  return false;
                }

              }

             $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier',
                type : "GET",
                data : {kodeitem, gudang, penerimaan},
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

                    var nourut = no -1;
                    console.log(nourut + 'nourut');
                    
                    
                   

                     //$('.sup'+nourut).empty();

                    if(arrSupid.length > 0) { // terikat kontrak
                   // alert('test');
                      $('.sup' + nobarang).empty();
                      $.each(arrSupid, function(i , obj) {
                      
                        $('.sup'+nobarang).append("<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+nobarang+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected id='selectsup'>"+obj.no_supplier+"-"+obj.nama_supplier+"</option>");
                      });
                        
                      $('.sup' + nobarang).trigger("chosen:updated");
                      $('.sup' + nobarang).trigger("liszt:updated");

                      $('.statuskontraksupplier' + id).val('TIDAK');
                      $('.statuskontraksuppliers' + nobarang).val('TIDAK');
                    

                        supbtn = arrSupid;


                        var datasup = $('.sup'+nobarang).find('option:selected').val();
                        

                        var string = datasup.split(",");

                        console.log(string + 'string') 

                       
                        if(string[4] == 'YA'){
                            if(string[4] == undefined){
                             
                            }
                            else {
                         
                            $('.hargabrg' + nobarang).val(addCommas(string[5]));
                            $('.hargabrg' + nobarang).attr('readonly' , false);
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
                
                       $('.sup' + nobarang).empty();
                      $.each(supplier, function(i , obj) {
                      supbtn = supplier;
                     

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
                       $('.statuskontraksupplier' + id).val('TIDAK');
                       $('.statuskontraksuppliers' + nobarang).val('TIDAK')
                      $('.sup' + nobarang).trigger("chosen:updated");
                      $('.sup' + nobarang).trigger("liszt:updated");
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
     // alert(counterId);
              $('.cek_tb').attr('disabled', false);
              $('.loadingjenis').css('display' , 'block');

              var idtrsup = no - 1;

              var lastarr = arrnobrg.slice(-1)[0];
              val2 = $('.brg' + lastarr).val();
              var string = val2.split(",");
              var kodeitem = string[0];
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
              gudang = $('.gudang').val();
             jnsitem = $('.jenisitem').val();
             variable = jnsitem.split(",");
             jenisitem = variable[0];
              penerimaan = variable[1];

              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier',
                type : "GET",
                data : {kodeitem, gudang, penerimaan},
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
      							"<td><input type='text' style='text-align:right' name='harga[]' data-id='"+counterId+"' class='input-sm form-control hrga hargabrg"+idtrsup+" harga"+counterId+"' data-id="+counterId+" data-no="+removesup+" '/>  <input type='hidden' class='statuskontraksupplier"+counterId+" statuskontraksuppliers"+idtrsup+"' name='statuskontrak[]'></td>"+ //harga
      							"<td><select id='supselect' class='form-control chosen-select select2 suipd suipl sup"+idtrsup+" supplier"+counterId+" datasup"+nourutbrg+"' data-id='"+counterId+"' data-no='"+idtrsup+"' name='supplier[]' required> <option value=''> -- Pilih Supplier -- </option>"; //SUpplier
      					
                if(hasilsupp.length > 0){ //TERIKAT KONTRAK
                      $.each(hasilsupp, function(i , obj) {
                        rowSup +=  "<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+idtrsup+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected>"+obj.no_supplier+"-"+ obj.nama_supplier+"</option>";
                      }) 

                      for(i = 0 ; i < hasilsupp.length; i++){
                        kontrak = hasilsupp[i].kontrak;
                        if(kontrak == 'YA'){
                          $('.hrga' + idtrsup).attr('readonly' , true);    
                        }
                        else {
                          $('.hrga' + idtrsup).attr('readonly' , false);    
                        }
                      }
                                          
                }
                else {
                   $.each(hasilmaster, function(i , obj) {
                        rowSup +=  "<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+idtrsup+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected>"+obj.no_supplier+"-"+ obj.nama_supplier+"</option>";
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
                       
                        if(string[4] == 'YA'){
                            if(string[4] == undefined){
                              
                            }
                            else {
                              $('.hargabrg' + idtrsup).val(addCommas(string[5]));
                              $('.hargabrg' + idtrsup).attr('readonly' , false);
                              $('.statuskontraksupplier' + counterId).val('TIDAK')
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
                         $('.statuskontraksupplier' + counterId).val('TIDAK')
                      }
      						  }
      						  else{
      						  toastr.info('Supplier telah mencapai batas maksimum');
      						}
      					}

              
          $('.supplier' + counterId).change(function(){
            val = $(this).val();
            hargasupplier = val.split(",");
 //           kontrak = hargasupplier[4];
            id = $(this).data('id');
            kontrak = $('.statuskontraksupplier' + id).val();
            //alert(kontrak);
            
              //alert('s');
              harga = hargasupplier[5];
              $('.harga' + id).val(addCommas(harga));
            
          })

					$(function(){
						$('.harga' + counterId).change(function(){
							var id = $(this).data('id');
            //  alert(id);
              val = $(this).val();      
              val = accounting.formatMoney(val, "", 2, ",",'.');
              $(this).val(val);
						  $('.simpan').attr('disabled', true);
              $('.cek_tb').attr('disabled', false);
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
						 $('.harga' + id).attr('readonly' , false); 
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

				} // end success
				}) // end ajax
			
    counterId++;
    nourutsup2++;
   // nourutbrg++;
   /* countsup++;*/
    })      // end button tambah supplier
  


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
