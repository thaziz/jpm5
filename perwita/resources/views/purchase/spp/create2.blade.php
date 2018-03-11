  @extends('main')

@section('title', 'dashboard')

@section('content')

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
                                            <td> Kode SPP </td>
                                            <td> <input type='text' class="form-control nospp" readonly="" name="nospp"></td>
                                          </tr>
                                          
                                          <tr>
                                              <td style="width:230px">  Cabang  </td>
                                              <td>   
                                                <select class="chosen-select-width cabang" name="comp" required="">  
                                                    <option value=""> -- Pilih Cabang -- </option>
                                                  @foreach($data['cabang'] as $comp)
                                                      <option value="{{$comp->kode}}"> {{$comp->nama}} </option>
                                                  @endforeach
                                                </select>
                                              </td>
                                          </tr>

                                        

                                          <tr>
                                              <td>
                                                Tanggal di butuhkan 
                                              </td>
                                              <td>
                                                  <div class="input-group date" required="">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required="">
                                                  </div>
                                              </td>  
                                          </tr>
                                         
                                          <tr>
                                            <td>
                                              Keperluan
                                            </td>

                                            <td> 
                                            <input type="text" class="form-control" name="keperluan" required="">
                                            </td>
                                          </tr>
                                        
                                        <tr>
                                          <td>
                                            Bagian / Department
                                          </td>
                                          <td>
                                            <select class="chosen-select-width" name="bagian">
                                              <option value> -- Pilih Bagian / Departmen -- </option>
                                              @foreach($data['department'] as $department)
                                                <option value="{{$department->kode_department}}"> {{$department->nama_department}} </option>
                                              @endforeach
                                            </select>
                                          </td>
                                        </tr>

                                      

                                        <tr>
                                          <td> Group Item </td>
                                          <td> <select class="form-control jenisitem" required="" name="jenisitem">
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

                                        <td id="tdstock">  <select class="form-control updatestock" name="updatestock"  id="updatestock"> <option value="" selected=""> - Pilih - </option> <option value="Y"> Ya </option> <option value="T"> TIDAK </option> </select></td>
                                      </tr>



                                      <tr>
                                       <td colspan="2"> <div class="lokasigudang"> </div> </td>
                                      </tr>
                               <!--    <button class='btn btn-danger remv-btn' type='button'> hapus </button> -->
                                    <tr>
                                      <td> Keterangan </td>
                                      <td> <input type="text" class="form-control" name="keterangan">  </td>
                                    </tr>
                                  </table>
                               </div>
                               
                               <div class="col-md-6">
                                <h4> Total Biaya Per Supplier </h4>
                                  <table class='table' id="tbl_total_sup"> 
                                    <tr> <th> Supplier </th> <th> Total Pembayaran</th> </tr>
                                  </table>
                                 
                                
                               </div>
                         
                                <div class="col-md-12">
                                 <hr>
                                 <h3> Data Barang </h3>
                                <hr>

                                <div class="table-responsive">
                                  <table id="table-data" class="table table-bordered">
                                  <tr class="header-table">
                                      <th style="width:20px"> No  </th>
                                       <th style="width:200px"> Nama Barang</th>
                                      <th style="width:10px"> Jumlah </th>
                                      <th style="width:50px"> Stock Gudang </th>
                                      <th style="width:5px"> Satuan </th>
                                       <th style="width:10px"> Harga </th>
                                      <th style="width:10px"> Supplier </th>
                                      <th class="kolompembayaran" style="width:10px" id="pembayaran"> Pembayaran </th>
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
                                    <td>  <b id="add-btn-supp" class="btn btn-info btn-flat">Tambah Data Supplier </b> </td>
                                    <td class="kolomtghpembayaran">  </td>
                                    <td> </td>
                                  </tr>


                               

                                 </table>
                                </div>
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
    $('#formId').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

    $('#formId input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formId input').change(function(){
      this.setCustomValidity("");
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
    
    
    

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


  /*  $('.check').change(function(){e
      $this = $(this);
      if($(this).is(":checked")){
         $('.header-table').find($('.kendaraan')).remove();
          var rowgudang = "<td style='width:230px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
                          "@foreach($data['gudang'] as $gdg) <option value={{$gdg->mg_id}}> {{$gdg->mg_namagudang}} </option> @endforeach>" + 
                       "</select> </td>";

          $('.lokasigudang').html(rowgudang);
      }
      else {
        $('.lokasigudang').empty();
        $('.header-table').find($('.kendaraan')).remove();
        var rowColom = "<th class='kendaraan' style='width:100px'> Kendaraan </th>";

       // $("rowColom").insertAfter("#pendaftaran");
      }
    })*/


    $('.cabang').change(function(){
      
    
      var comp = $(this).val();
        $.ajax({    
            type :"post",
            data : {comp},
            url : baseUrl + '/suratpermintaanpembelian/getnospp',
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

              
                 nospp = 'SPP' + month1 + year2 + '/' + comp + '/' +  data;
                console.log(nospp);
                $('.nospp').val(nospp);
            }
        })

    })

    $('.simpan').click(function(){
      
    })

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $('.updatestock').change(function(){
      val = $(this).val();
    

      jnsitem = $('.jenisitem').val();
      variable = jnsitem.split(",");
      jenisitem = variable[0];

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
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td style='width:230px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
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

            $("<td class='kendaraan'> <select class='form-control kendaraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id_vhc}}> {{$kndraan->vhccde}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
            
           //  $("rowColom").insertAfter("#pembayaran");
        }
      }
    
      else {
         if(val == 'Y') {
           valupdatestock = val;
                $('.kendaraan').remove();
               var rowgudang = "<tr> <td> &nbsp; </td> </tr> <td style='width:230px'> <h4> Lokasi Gudang </h4> </td> <td> <select class='form-control gudang' name='gudang'>" +
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
            data : {jenisitem,updatestock},
            url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
            dataType:'json',
            success : function(data){
               arrItem = data;
                  
                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+">"+obj.nama_masteritem+"</option>");
                        })
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);             
                  }
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


          //pengecekan barang double

          //valbarang
          arrBarang = [];  
          
         $('.barang').each(function(){
            barang = $(this).val();
            var string = barang.split(",");
              var kodeitem = string[0];
              arrBarang.push(kodeitem);
              console.log('barang' + barang);
         })
      
        console.log(arrBarang + 'arrBarang');

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
              for(var nb = 0 ; nb < indexbrg.length; nb++){
                 indexbrg = arrBarang.indexOf(results[nb]);
              }
              console.log(indexbrg);
          }
          else{
             indexbrg = arrBarang.indexOf(results[0]);
             console.log(indexbrg);
          }

          if(indexbrg == -1){
            $('.brgduplicate').empty();
          }
          else {
            rowduplicate = "<i> <h5 style='color:red'> *Duplicate Barang </h5> </i>";
            $('.duplicate' + parseInt(indexbrg + 1)).html(rowduplicate);
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

         //mendapatkan supplier
         $('.suipl').each(function(){
           var value = $(this).val();
        //    console.log('value' + value);
           var pecahstring  = value.split(",");
           var idsupplier = pecahstring[0];
           var supplier = pecahstring[3];
           var nobrg = pecahstring[2];
           var kodesupplier = pecahstring[6];
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


  //        console.log(arrIdSup);
  //        console.log(hasilrow);

          idsupp = removeDuplicates(arrIdSup);
          outputSup = removeDuplicates(arrSup);
          hslkodesup = removeDuplicates(kodesup);
       

        // console.log(arrIdqty);
         
        // console.log(hslqty);

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

//          console.log('arrtotal' + arrtotal);
 //         console.log('idsupp' + idsupp);
  //        console.log('arrIdSup' + arrIdSup);

          var jumlahtotal = 0;
          var jumlahtotalpembayaran = [];
          for(var i = 0; i < idsupp.length; i++ ) {
            jumlahtotal = 0;
            for(var j = 0; j < hasilrow; j++){
              if(arrIdSup[j] == idsupp[i]) {
                jumlahtotal = parseInt(jumlahtotal + arrtotal[j]);
             //   console.log(jumlahtotal);
             }

            }
             jumlahtotalpembayaran.push(jumlahtotal);
          }
        
        //  console.log(jumlahtotalpembayaran);
          hsljmlhpmbayaran = [];
         // console.log(outputSup);
         //  rowhslSupp = "<h4> Total Biaya Per Supplier </h4><table class='table'> <tr> <th> Supplier </td> <th> Total Pembayaran</td></tr>";
       //   var rowhslSupp = "<table class='table'>"; 

          if(tempceknull != 0){
            toastr.info(tempceknull);
          }
          else {

           // toastr.info(tempceknull);
          for (var a = 0; a < outputSup.length; a++) {
              hsljmlhpmbayaran = Math.round(jumlahtotalpembayaran[a]).toFixed(2);
             // console.log(hsljmlhpmbayaran);
           var rowhslSupp = "<tr id='tbl_total' style='margin-bottom:30px'><td style='width:240px'><input type='text' class='form-control' value='"+ outputSup[a] +"'> <input type='hidden' name='idsupplier[]' value='"+hslkodesup[a]+"'> </td> <td class='text-right'> <input type='text' class='form-control' value='"+ addCommas(hsljmlhpmbayaran) +"' name='totbiaya[]' readonly style='text-align:right'  ></td> <td> <input type='hidden' class='form-control' readonly value='"+hasilrow+"' name='row'> </td>  </tr>";
             $('#tbl_total_sup').append(rowhslSupp);
          }
        
         }
         
          

          var num = Math.round(jumlah).toFixed(2);
          $('.biaya').val(addCommas(num));

          if(results.length > 0 ){
           // toastr.info("Nama Barang ada yang sama , mohon di ganti :)");
              toastr.info('Nama Barang ada yang sama , mohon di ganti :)');
            $('.simpan').attr('disabled', true);
          }
          else {
            $('.simpan').attr('disabled', false);            
          }


      })
    })



      var arrItem = [];
          

   $(function(){
      $('.jenisitem').change(function(){
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

              $("<td class='kendaraan'> <select class='form-control kendaraan' name='kendaraan[]'>  @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id_vhc}}> {{$kndraan->vhccde}} - {{$kndraan->merk}} </option> @endforeach  </select> </td>").insertAfter($('.pembayaranken'))
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
              //    console.log(data);
                  arrItem = data;
                  console.log('arrItem' + arrItem);

                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                        //  console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+">"+obj.nama_masteritem+"</option>");
                        })
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);             
                  }
                }
              })

             }
             else if(penerimaan != 'T') {
                 $('tr#trstock').show();
                $('td#trstock').show();

                if(updatestock != '') {
              var string = val.split(",");
              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_jenisitem',
                type : "post",
                data : {jenisitem,updatestock,penerimaan},
                dataType : "json",
                success : function(data) {
              //    console.log(data);
                  arrItem = data;
                  console.log('arrItem' + arrItem);

                  if(arrItem.length > 0) {
                      $('.barang').empty();
                      $('.barang').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                        //  console.log(obj.is_kodeitem);
                          $('.barang').append("<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+">"+obj.nama_masteritem+"</option>");
                        })
                    }
                  else{
                     
                     //   toastr.info('kosong');
                         $('.barang').empty();
                        var rowKosong = "<option value=''> -- Data Kosong --</option>";
                       $('.barang').append(rowKosong);             
                  }
                }
              })
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

    $('#add-btn').click(function(){

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
                   
          rowStr += "<select  class='barang brg"+no+" form-control idbarang"+counterId+"' data-id='"+counterId+"' style='width: 100%;' name='idbarang[]' required style='width:80px' data-no='"+no+"'> "; //barang
                    if(arrItem.length > 0) {
          rowStr += " <option value=''>  -- Pilih Barang -- </option> ";            
                /*    for(var nmbrg=0; nmbrg < arrItem.length; nmbrg++){
                      if(valbarang.length != 0) {
                          if(arrItem[nmbrg].kode_item == valbarang[nmbrg]) {
                          rowStr +=  "<option value="+arrItem[nmbrg].kode_item+","+arrItem[nmbrg].unitstock+" disabled>"+ arrItem[nmbrg].nama_masteritem+"</option>";
                          }
                          else{


                          rowStr +=  "<option value="+arrItem[nmbrg].kode_item+","+arrItem[nmbrg].unitstock+" style='display:block'>"+ arrItem[nmbrg].nama_masteritem+"</option>";
                        }
                      }
                      else{
                         rowStr +=  "<option value="+arrItem[nmbrg].kode_item+","+arrItem[nmbrg].unitstock+" style='display:block'>"+ arrItem[nmbrg].nama_masteritem+"</option>";
                      }
                    }*/

                     $.each(arrItem, function(i , obj) {
                        supbtn = arrSupid;

                        rowStr +=  "<option value="+obj.kode_item+","+obj.unitstock+","+obj.harga+" style='display:block'>"+ obj.nama_masteritem+"</option>";
                      });

         

                      }
                      else{
          rowStr +=  "<option value=''> -- Data Kosong -- </option>";              
                      }
          rowStr += "</select> <br> <div class='brgduplicate duplicate"+no+"'> </div> </td>" +
                    "<td> <input type='text' class='form-control kuantitas qty"+counterId+"' name='qty[]' data-id='"+no+"' required style='width:60px'> <input type='hidden' class='qty_request' name='qty_request[]' value='"+no+"'>  </td>" + //qty

                    "<td> <div class='stock_gudang"+counterId+"'> </td>" + //stockgudang

                    "<td> <div class='satuan"+counterId+"'> </td>"+ //satuan

                    "<td> <input type='text' class='form-control hrga hargabrg"+no+" harga"+counterId+"' name='harga[]' data-id='"+counterId+"' data-no='"+no+"'/> </td>"+ //harga

                    "<td> <select id='supselect' class='form-control select2 suipd suipl sup"+no+" supplier"+counterId+"' data-id='"+counterId+"' style='width: 100%;' name='supplier[]' required=> <option value=''> -- Pilih Data Supplier -- "+no+"</option></select> <br>  </td>" + //supplier

                    "<td class='pembayaranken'> <div class='form-group'> <div class='col-sm-8'> <input type='text' class='form-control bayar"+counterId+"' name='bayar[]' data-id='"+counterId+"'> </div> <label class='col-sm-2 col-sm-2 control-label'> Hari </label></div></td>"; //bayar


          if(valupdatestock == 'T' && jenisitem == 'S' ){
            rowStr += "<td class='kendaraan'> <select class='form-control' name='kendaraan[]'> @foreach($data['kendaraan'] as $kndraan) <option value={{$kndraan->id_vhc}}> {{$kndraan->vhccde}} - {{$kndraan->merk}} </option> @endforeach </select> </td>";
          }

          if(no != 1) {
           rowStr += "<td> <button class='btn btn-danger removes-btn' data-id='"+no+"' type='button'><i class='fa fa-trash'></i></button></td>";
          } 

       
        rowStr += "</tr>";

      //mengetahui duplicate supplier
      arrSupplier = []; 
      noidsup = no - 1;
      $('.sup' + noidsup).each(function(){
        idsup = $(this).val();
        var string = idsup.split(",");
        var idsupbrg = string[6];
        arrSupplier.push(idsupbrg);
      })
        
     



      if(jenisitem != ''){
        $('#table-data').append(rowStr);
       }

       //harga
        $(function(){
            $('.harga' + counterId).change(function(){
                var id = $(this).data('id');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
         
                $('.harga' + id).val(addCommas(numhar));

               $('.simpan').attr('disabled', true);
            })
        }) 

        //qty
        $(function(){
            $('.qty' + counterId).change(function(){
                var qty = $(this).val();
           
                var qty_request = qty;
         
              var id = $(this).data('id');

                $('.simpan').attr('disabled', true);

                var rowqty = "<input type='text' value="+ qty + ','+no+" name='qty_request[]'>";

                $('.qty_request' + id).html(rowqty);

            })
        }) 


       //supplier
         $(function(){
          $('.supplier' + counterId).change(function(){     
              $('.simpan').attr('disabled', true);

            var val = $(this).val();
            var id = $(this).data('id');
            var string = val.split(",");
            var bayar = string[1];
            var harga = string[5];
            var contract = string[4];
           // console.log(harga);
  
            // toastr.info(val);
             numhar = Math.round(harga).toFixed(2);

             /*$('select[name*="supplier"] option').attr('disabled' , false);

             $('select[name*="supplier"]').each(function(){
                var $this = $(this); 
               

                $('select[name*="supplier"]').not($this).find('option').each(function(){
                  if($(this).attr('value') == $this.val()) {
                   $(this).attr('disabled',true);
                  }
                });

              })*/
                         
           /*   $('.harga' + id).empty();
              $('.bayar' + id).empty();*/

             if(contract == 'YA'){
                  if(harga === "undefined"){
                 // toastr.info("undefined");
                }
                else {
                 // toastr.info('tidak_undefined');
                 // console.log(numhar);
//                  console.log(numhar);
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
             
            /* $('select[name*="idbarang"] option').attr('disabled' , false);

             $('select[name*="idbarang"]').each(function(){
                var $this = $(this); 
                

                $('select[name*="idbarang"]').not($this).find('option').each(function(){
                  if($(this).attr('value') == $this.val()) {
                   $(this).attr('disabled',true);
                  }
                });

              })*/
              
            /*  valbarang.push(kodeitem);
              index = valbarang.indexOf(barang);
              valbarang.splice(index, 1);
            
              if(valbarang.length == 0 ){
                valbarang.push(kodeitem);

              }
              else {

              temp1 = 0;
         
              for(var idval=0; idval<valbarang.length; idval++){   
                if(valbarang[idval] == kodeitem){
                  console.log(valbarang[idval] + 'idval');
                  temp1 = temp1 + 1;
                  tempbeda = tempbeda + 1;
                }                
              }
             }

             console.log(tempbeda + 'tempbeda');  

             if(temp1 == 0) {
               valbarang.push(kodeitem);
             }*/
         
              console.log(valbarang);

             // toastr.info(kodeitem);
              $.ajax({
                url : baseUrl + '/suratpermintaanpembelian/ajax_hargasupplier/' + kodeitem,
                type : "GET",
                dataType : "json",
                success : function(data) {
                
                  arrSupid = data.supplier; //terikat kontrak

                  supplier = data.mastersupplier;
                //  console.log('len' + arrSupid.length);

               //   console.log('data.supplier' + data.supplier);
                  satuan = data.stock[0].unitstock;
                  stock = data.stock[0].sg_qty;
                //  console.log('stock' + data.stock[0].unitstock);
                  
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
               //     toastr.info('length' + arrSupid.length);
                   

                     $('.sup'+nourut).empty();

                    if(arrSupid.length > 0) { // terikat kontrak
                     console.log('supplier terikat kontrak');
                      $('.sup' + nobarang).empty();
                       $.each(arrSupid, function(i , obj) {
                        supbtn = arrSupid;

                      $('.sup'+nobarang).append("<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+nourut+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected id='selectsup'>"+obj.nama_supplier+"</option>");
                      });

                        var datasup = $('.supplier'+nosup).find('option:selected').val();
                        

                        var string = datasup.split(",");
                        console.log(string[4])
                        idcntr = counterId - 1;
                 //       toastr.info(idcntr);
                        if(string[4] == 'YA'){
                            if(string[4] == undefined){
                               // toastr.info('undefined');
                            }
                            else {
                               // toastr.info('tidak');

                            $('.harga' + id).val(addCommas(string[5]));
                            $('.harga' + id).attr('readonly', true);
                            $('.hargabrg' + nobarang).val(addCommas(string[5]));
                            $('.hargabrg' + nobarang).attr('readonly' , true);
                          }
                        }
                        else {
                            if(string[4] == undefined){
                               // toastr.info('undefined');
                            }
                            else {
                              //  toastr.info('tidak');
                            $('.harga' + id).val(addCommas(string[5]));
                            $('.hargabrg' + nobarang).val(addCommas(string[5]));
                          }
                        }

                        var syarat_kredit = string[1];
                        console.log(syarat_kredit);
                        $('.bayar' + id).val(syarat_kredit);
                    } // end arrSUpid
                    else {
                     console.log('tdk ada terikat kontrak');
                       $('.sup' + nobarang).empty();
                      $.each(supplier, function(i , obj) {
                      supbtn = supplier;
                      idcntr = counterId - 1;
                     // toastr.info('id' + id);

                     $('.sup'+nobarang).append("<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+nourut+","+obj.nama_supplier+","+obj.kontrak+","+obj.is_harga+","+obj.idsup+"' selected id='selectsup'>"+obj.nama_supplier+"</option>");
                    
                        var datasup = $('.supplier'+nosup).find('option:selected').val();
                        //  console.log('datasup' + datasup);
                        var string = datasup.split(",");
                      
                        var syarat_kredit = string[1];
                       console.log(syarat_kredit);
                        empty = ' ';
                        console.log(hrgbrg);
                        $('.bayar' + id).val(empty);
                        $('.harga' + id).val(addCommas(hrgbrg));
                        $('.hargabrg' + nobarang).val(addCommas(hrgbrg));
                        $('.harga' + id).attr('readonly' , false);
                       
                        $('.bayar' + id).val(syarat_kredit);
                      });
                    }
               //   console.log(supbtn);
                }

              })
              $('.simpan').attr('disabled', true);

          })
        })
      counterId++;
      no++;
      countersup++;
      idremovesup++;
    })

   // console.log('valbarang2' + valbarang);

     countersup = 0;
      //tambahdatasupplier
     $('#add-btn-supp').click(function(){
      //toastr.info(arrSupid);
        var idtrsup = no - 1;        
        var removesup = idremovesup - 1;
        if(idtrsup != removesup){
          removesup = idtrsup;
        }
        else {
          removesup = removesup;
        }


        $sup++;
       
        countersup++;
//         console.log('suppid' + supbtn);
        if($('.brg' + idtrsup).val() == ''){
          toastr.info('Silhkan Memilih Data Barang Terlebih Dahulu');
        }

        var rowSup = "<tr id='supp-"+idtrsup+"' class='data-supplier supp-"+counterId+"'>";
       
        rowSup += "<td> </td> <td></td>  <td> </td> <td></td> <td>  </td>"+

                  "<td> <input type='text' name='harga[]' data-id='"+counterId+"' class='form-control hrga hargabrg"+idtrsup+" harga"+counterId+"' data-id="+counterId+" data-no="+removesup+" '/></td>"+ //harga

                  "<td> <select id='supselect' class='form-control select2 suipl sup"+idtrsup+" supplier"+counterId+"' data-id='"+counterId+"' style='width: 100%;' name='supplier[]' required=> <option value=''> -- Pilih Supplier -- </option>";


   //               console.log(arrSupid);
                $.each(supbtn, function(i , obj) {
        rowSup +=  "<option value='"+obj.no_supplier+","+obj.syarat_kredit+","+idtrsup+","+obj.nama_supplier+","+obj.is_contract+","+obj.is_harga+","+obj.idsup+"'>"+ obj.nama_supplier+"</option>";
                      }) 

        rowSup  +="</select> </td>"+ //supplier

                  "<td class='kolomtghpembayaran'> <div class='form-group'> <div class='col-sm-8'> <input type='text' class='form-control bayar"+counterId+"' name='bayar[]' data-id='"+counterId+"'> </div> <label class='col-sm-2 col-sm-2 control-label'> Hari </label></div> </td>"; //bayar

             
          rowSup +=        "<td> <button class='btn btn-danger remove-btn' data-id='"+idtrsup+"' type='button'><i class='fa fa-trash'></i></button></td>";

        rowSup += "</tr>";
       
      if($('.brg' + idtrsup).val() != ''){
        if($('tr#supp-'+ idtrsup).length < 2) {          
            $('#table-data').append(rowSup);
          }
          else{
          toastr.info('Supplier telah mencapai batas maksimum');
        }
        }
       

          $(function(){
            $('.harga' + counterId).change(function(){
           /*   toastr.info(counterId);*/
                var id = $(this).data('id');
                
                harga = $(this).val();
/*
                toastr.info(counterId);*/
                numhar = Math.round(harga).toFixed(2);

                $('.harga' + id).val(addCommas(numhar));

               $('.simpan').attr('disabled', true);
            })
        }) 

      
          $(function(){
            $('.qty2' + counterId).change(function(){
           /*   toastr.info(counterId);*/
                var id = $(this).data('id');
              
                harga = $(this).val();
         /*       toastr.info(id);*/

             
            })
        }) 

        /*  var id_supplier = [];
          $(function(){
            $('.sup' + idtrsup).change(function(){
                $('select').not(this).removeProp('disabled');        
                $('select option').removeProp('disabled');

                value = $(this).val();
                
                $('select').each(function () { 
                  var a = $(this).val();
                  id_supplier.push(a);
                   $('select.sup'+idtrsup+'option[value="'+ value +'"]').not(this).prop('disabled' , true);
                })
            })
          })*/

           $(function(){
          $('.supplier' + counterId).change(function(){     

            $('select[name*="supplier"] option').attr('disabled' , false);

             $('select[name*="supplier"]').each(function(){
                var $this = $(this); 
              

            /*    $('select[name*="supplier"]').not($this).find('option').each(function(){
                  if($(this).attr('value') == $this.val()) {
                   $(this).attr('disabled',true);
                  }
                });*/

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
              console.log(val);
             numhar = Math.round(harga).toFixed(2);

                         
           /*   $('.harga' + id).empty();
              $('.bayar' + id).empty();*/

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
          })
        })
   
    counterId++;
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
    /*    var row = $('#supp-' + id).length;
        toastr.info(id);

       parent.remove();
        console.log(counterId);
        counterId = counterId - 1;
        console.log(counterId); */
        idremovesup = idremovesup - 1;
        var id = $(this).data('id');
        var parent2 = $('#supp-'+id);
     //   parent2.remove();
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
