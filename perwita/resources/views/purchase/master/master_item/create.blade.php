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
                    <h2> Master Item </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Item </strong>
                        </li>

                    </ol>
                </div>f
                <div class="col-lg-2">

                </div>
            </div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Tambah Data Barang
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
                </div>
                   
                    
                <div class="box-body">
                

                <div class="row">
                  <div class="col-xs-6">

                    <form method="post" action="{{url('masteritem/saveitem')}}"  enctype="multipart/form-data" class="form-horizontal">
                    <table class="table" border="0">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                       

                       <tr>
                        <td> Cabang </td>
                        <td>  
                         @if(Auth::user()->punyaAkses('Master Supplier','cabang'))
                            <select class="form-control  cabang" name="cabang">
                                @foreach($data['cabang'] as $cabang)
                              <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
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

                      <tr>                      
                        <td> Nama Item </td>
                        <td> <input type="text" class="form-control nama_item a" name="nama_item" required=""> <input type="hidden" class="form-control" name="cabang" value="{{ Auth::user()->kode_cabang}}"> </td>
                      </tr>

                      <tr>
                        <td> Group Item </td>
                        <td> <select class="form-control b jenis_item" name="jenis_item"> 
                        <option value="" selected=""> Pilih Group Item </option>

                        @foreach($data['jenisitem'] as $jenisitem)

                          <option value="{{$jenisitem->kode_jenisitem}},{{$jenisitem->stock}}"> {{$jenisitem->keterangan_jenisitem}} </option>

                        @endforeach
                         </select> </td>
                      </tr>

                        <tr>                      
                        <td> Harga </td>
                        <td> <input type="text" class="form-control hrg c" name="harga" required="" style="text-align: right"></td>
                      </tr>
                   
                  </table>
                  <hr>
                  </div>

                    <div class="col-xs-6">

                      <table class="table" border="0">
                        <tr>
                          <th> Quantity</th>
                          <th> Satuan </th>
                          <th> Konversi </th>
                        </tr>
                        <tr>
                          <td> Ke Satu </td>
                          <td> <input type="text" class="form-control d qtysatu" name="unit1"> </td>
                          <td> </td>
                        </tr>
                        <tr>
                          <td> Ke Dua </td>
                          <td> <input type="text" class="form-control e qtydua" name="unit2"> </td>
                          <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya f '  name='konversi2'>  </div>
                          </td>
                        </tr>

                        <tr>
                          <td> Ke Tiga </td>
                          <td> <input type="text" class="form-control g qtytiga" name="unit3"></td>
                          <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya h '  name='konversi3'>  </div></td>
                        </tr>


                        <tr>
                          <td> Satuan Stock </td>
                          <td> <input type="text" class="form-control i qtystock" required="" name="unitstock" readonly=""> </td>
                        </tr>
                      </table>
                    </div>



                  <div class="row">
                      <div class="col-xs-6"> 
                    <table class="table" >
                      <tr>
                        <td> Minimum Stock </td>
                        <td> <input type="number" class="form-control j" name="minimum_stock" required=""></td>
                      </tr>
                      
                      <tr>
                        <td class="updatedtock"> Update Stock </td>
                        <td class="updatedtock"> <select class="form-control k updatestock" name="update_stock"> 
                          <option value='T'  selected="" > T </option>
                          <option value='Y' > Y </option>
                        </select>
                      </tr>


                      <tr>
                        <td> Acc Persediaan </td>
                        <td> <select class="chosen-select-width l accpersediaan" name="acc_persediaan" id="accpersediaan"> <option value=""> Pilih Akun <!-- </option> <option value=""> Pilih Akun2 </option>  --></select> </td>
                      </tr>
                      <tr>
                        <td> Acc HPP </td>
                        <td> 
                            <select class="chosen-select-width z acchpp" name="acc_hpp" id="accpersediaan"> <option value=""> Pilih Akun <!-- </option> <option value=""> Pilih Akun2 </option>  --></select>
                        </td>
                      </tr>
                     <!--  <tr>
                        <td> Foto </td>
                        <td> 
                           <label title="Upload image file" for="upload-file-selector" class="btn btn-primary">
                              <input type="file"  name="imageUpload" id="upload-file-selector" class="hide uploadGambar n" id="upload-file-selector" required="">
                                         <i class="fa fa-upload margin-correction"></i> Upload Gambar
                            </label>
                            
                                              
                                <div class="col-md-6 image-holder" style="padding:0px; padding-bottom: 20px;">
                        
                        </td>

                      </tr> -->
                    </table>
                  </div>

                  <div class="col-xs-6">
                  <hr>
                  <h4> Posisi Item </h4>
                    <table class="table">
                      <tr>
                        <td> Lantai </td>
                        <td> <input type="text" class="form-control o" name="posisilantai"> </td>
                      </tr>
                      <tr>
                        <td> Ruang </td>
                        <td> <input type="text" class="form-control o " name="posisiruang"> </td>
                      </tr>
                      <tr>
                        <td> Rak </td>
                        <td>  <input type="text" class="form-control q" name="posisirak"> </td>
                      </tr>
                      <tr>
                        <td> Kolom </td>
                        <td>  <input type="text" class="form-control r" name="posisikolom"></td>
                      </tr>
                    </table>
                  </div>

                  </div>
                </div>

                </div>
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('masteritem/masteritem')}}> Kembali </a>
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


     $("#accpersediaan").chosen(config);
     $('.cabang').chosen(config);
  //    $(".kndraan").chosen(config);
    })
     },2000);
    
    $('.qtysatu').change(function(){
      qtysatu = $('.qtysatu').val();
      qtydua = $('.qtydua').val();
      qtytiga = $('.qtytiga').val();

      if(qtydua != ''){
        if(qtytiga != ''){
          $('.qtystock').val(qtytiga);
        }
        else {
          $('.qtystock').val(qtydua)
        }
      }
      else if(qtytiga != ''){
        $('.qtystock').val(qtytiga);
      }
      else {
        $('.qtystock').val(qtysatu);
      }
    })

    $('.qtydua').change(function(){
      qtysatu = $('.qtysatu').val();
      qtydua = $('.qtydua').val();
      qtytiga = $('.qtytiga').val();

      if(qtytiga != ''){
     //   alert('asas');
        $('.qtystock').val(qtytiga);
      }
      else {
        $('.qtystock').val(qtydua);
      }
    })


    $('.qtytiga').change(function(){
      qtysatu = $('.qtysatu').val();
      qtydua = $('.qtydua').val();
      qtytiga = $('.qtytiga').val();

        $('.qtystock').val(qtytiga);
     
    })


    $('.jenis_item').change(function(){
          updatestock = $('.updatestock').val();
          groupitem = $('.jenis_item').val();


          cabang = $('.cabang').val();
          split = groupitem.split(",");
          stock = split[1];
          jenis = split[0];

          if(jenis == 'J'){
            $('.j').attr('required' , false);
            $('.j').attr('disabled' , true);
          }
        
          $.ajax({
            data : {updatestock,groupitem,cabang},
            url : baseUrl + '/masteritem/getaccpersediaan',
              dataType : "json",
            type : "get",
            success : function(response){
              $('.accpersediaan').empty();
              $('.acchpp').empty();
              if(stock == 'Y') {
                 if(updatestock == 'Y') {
                      arrItem = response.akun;  
                      $('.acchpp').empty();
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated");

                      $('.accpersediaan').empty();
                      $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");

              }
              else {
                  arrItem = response.akun;
                      $('.accpersediaan').empty();
                      $('.accpersediaan').trigger("chosen:updated");
                      $('.accpersediaan').trigger("liszt:updated");

                      $('.acchpp').empty();

                      $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated"); 
              } 
              }
              else {
                 arrItem = response.akun;
                      $('.accpersediaan').empty();
                      $('.accpersediaan').trigger("chosen:updated");
                      $('.accpersediaan').trigger("liszt:updated"); 

                      $('.acchpp').empty();
                      $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated"); 
              }
                           
            }

          })
    })
  


    $('.updatestock').change(function(){
         updatestock = $('.updatestock').val();
          groupitem = $('.jenis_item').val();
          split = groupitem.split(",");
          stock = split[1];

          $.ajax({
            data : {updatestock,groupitem,cabang},
            url : baseUrl + '/masteritem/getaccpersediaan',
              dataType : "json",
            type : "get",
            success : function(response){
              if(stock == 'Y'){
                 if(updatestock == 'Y') {
                      arrItem = response.akun;
                      $('.acchpp').empty();
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated");
                      
                      $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                      $('.accpersediaan').trigger("chosen:updated");
                      $('.accpersediaan').trigger("liszt:updated");
                   
              }
              else {
                  arrItem = response.akun;
                      $('.accpersediaan').empty();
                      $('.accpersediaan').trigger("chosen:updated");
                      $('.accpersediaan').trigger("liszt:updated");

                      $('.acchpp').empty();
                      $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated"); 
              } 
              }
              else {
                arrItem = response.akun;
                      $('.accpersediaan').empty();
                      $('.accpersediaan').trigger("chosen:updated");
                      $('.accpersediaan').trigger("liszt:updated"); 

                      $('.acchpp').empty();
                      $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                        })
                      $('.acchpp').trigger("chosen:updated");
                      $('.acchpp').trigger("liszt:updated"); 
              }
              
            }
          })
    })


   

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
     $('.jenis_item').change(function(){
      val = $(this).val();
      string = val.split(",");
      stock = string[1];
      if(stock == 'T') {
        $('td.updatedtock').hide();
        $('.updatestock').val('J');
      }
      else {
         $('td.updatedtock').show();
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


   $(function(){
            $('.hrg').change(function(){
                val = $(this).val();
      
                val = accounting.formatMoney(val, "", 2, ",",'.');
                $(this).val(val);
            })
        }) 


  


        $( "#submit" ).click(function() { 
          var a = $(".a").val();
          var b = $(".b").val();
          var c = $(".c").val();
          var d = $(".d").val();
          var e = $(".e").val();
          var f = $(".f").val();
          var g = $(".g").val();
          var h = $(".h").val();
          var i = $(".i").val();
          var j = $(".j").val();
          var k = $(".k").val();
          var l = $(".l").val();
          var m = $(".z").val();
          var n = $(".n").val();
          var o = $(".o").val();
          var p = $(".p").val();
          var q = $(".q").val();
          var r = $(".r").val();
                   

          if($('.e').val() != ''){ //cek qtysatu
            val = $('.f').val();
            if(val == ''){
//              toastr.info('Qty satu harap diisi :) ');
               toastr.info('Qty satu harap diisi :)');
               return false;
            }
          }

          if($('.g').val() != ''){
            val = $('.h').val();
            if(val = '') {
              toastr.info('Qty dua harap diisi :)');
              return false;
             // toastr.info('Qty dua harap diisi :)');
            }
          }

          if (a == '') {
            toastr.info('Nama Item Harus Di isi');

//            toastr.info('Nama Item Harus Di isi');
             $('html,body').animate({scrollTop: $('.a').offset().top}, 200, function() {
              $('.a').focus();
          });
            return false;
          }
          if (b == '') {
            toastr.info('Group Item Harus Di isi');
             $('html,body').animate({scrollTop: $('.b').offset().top}, 200, function() {
              $('.b').focus();
          });
            return false;
          }
          if (c == '') {
            toastr.info('Harga Harus Di isi');
             $('html,body').animate({scrollTop: $('.c').offset().top}, 200, function() {
             $('.c').focus();
            });
            return false;
          }
          if (d == '') {
            toastr.info('Quantity Ke Satu Harus Di isi');
            $('html,body').animate({scrollTop: $('.d').offset().top}, 200, function() {
             $('.d').focus();
            });
            return false;
          }
        /*  if (e == '') {
            toastr.info('Kolom PCS Harus Di isi');
           $('html,body').animate({scrollTop: $('.e').offset().top}, 200, function() {
             $('.e').focus();
            });
            return false;
          }
          if (f == '') {
            toastr.info('Quantity Ke Dua Harus Di isi');
           $('html,body').animate({scrollTop: $('.f').offset().top}, 200, function() {
             $('.f').focus();
            });
            return false;
          }

          if (g == '') {
            toastr.info('Quantity Ke Tiga Harus Di isi');
            $('html,body').animate({scrollTop: $('.g').offset().top}, 200, function() {
             $('.g').focus();
            });
            return false;
          }
          if (h == '') {
            toastr.info('Kolom PCS Harus Di isi');
           $('html,body').animate({scrollTop: $('.h').offset().top}, 200, function() {
             $('.h').focus();
            });
            return false;
          }*/
          if (i == '') {
            toastr.info('Satuan stock Harus Di isi');
            $('html,body').animate({scrollTop: $('.i').offset().top}, 200, function() {
             $('.i').focus();
            });
            return false;
          }
          
          if (j == '') {
           /* toastr.info('Minimum stock Harus Di isi');
            $('html,body').animate({scrollTop: $('.j').offset().top}, 200, function() {
             $('.j').focus();
            });
            return false;*/
          }
          if (k == '') {
            toastr.info('Update Stock Harus Di isi');
            $('html,body').animate({scrollTop: $('.k').offset().top}, 200, function() {
             $('.k').focus();
            });
            return false;
          }
          if (l == '') {
          /*  toastr.info('Acc Persediaan Harus Di isi');
            $('html,body').animate({scrollTop: $('.l').offset().top}, 200, function() {
             $('.l').focus();
            });
            return false;*/
          }
          if (m == '') {
           /* toastr.info('Acc HPP Harus Di isi');
            $('html,body').animate({scrollTop: $('.z').offset().top}, 200, function() {
             $('.z').focus();
            });
            return false;*/
          }
          if (n == '') {
            toastr.info('Foto Harus Di isi');
            $('html,body').animate({scrollTop: $('.n').offset().top}, 200, function() {
             $('.n').focus();
            });
            return false;
          }
        /*  if (o == '') {
            toastr.info('Kolom Lantai Harus Di isi');
            $('html,body').animate({scrollTop: $('.o').offset().top}, 200, function() {
             $('.o').focus();
            });
            return false;
          }
          if (p == '') {
            toastr.info('Kolom Ruang Harus Di isi');
            $('html,body').animate({scrollTop: $('.p').offset().top}, 200, function() {
             $('.p').focus();
            });
            return false;
          }
          if (q == '') {
            toastr.info('Kolom Rak Di isi');
            $('html,body').animate({scrollTop: $('.q').offset().top}, 200, function() {
             $('.q').focus();
            });
            return false;
          }
          if (r == '') {
            toastr.info('Kolom Harus Di isi');
            $('html,body').animate({scrollTop: $('.r').offset().top}, 200, function() {
             $('.r').focus();
            });
            return false;
          }*/
         
        });
        
       


       $(".uploadGambar").on('change', function () {
      

          if (typeof (FileReader) != "undefined") {

            var image_holder = $(".image-holder");
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                image_holder.html('<img src="{{ asset('assets/img/loading1.gif') }}" class="img-responsive" width="40px">');

                $('.save').attr('disabled', true);

                setTimeout(function () {
                    image_holder.empty();
                    $("<img />", {
                        "src": e.target.result,
                        "class": "thumb-image img-responsive",
                        "height": "80px",
                    }).appendTo(image_holder);
                    $('.save').attr('disabled', false);
                }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            toastr.info("This browser does not support FileReader.");
        }





      });
</script>
@endsection
