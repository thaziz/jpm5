@extends('main')

@section('title', 'dashboard')

@section('content')

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
                </div>
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
                        <td> Nama Item </td>
                        <td> <input type="text" class="form-control nama_item a" name="nama_item" required=""></td>
                      </tr>

                      <tr>
                        <td> Group Item </td>
                        <td> <select class="form-control b jenis_item" name="jenis_item"> 
                        @foreach($data['jenisitem'] as $jenisitem)

                          <option value="{{$jenisitem->kode_jenisitem}},{{$jenisitem->stock}}" selected=""> {{$jenisitem->keterangan_jenisitem}} </option>

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
                          <td> <input type="text" class="form-control d" name="unit1"> </td>
                          <td> </td>
                        </tr>
                        <tr>
                          <td> Ke Dua </td>
                          <td> <input type="text" class="form-control e " name="unit2"> </td>
                          <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya f '  name='konversi2'>  </div>
                          </td>
                        </tr>

                        <tr>
                          <td> Ke Tiga </td>
                          <td> <input type="text" class="form-control g " name="unit3"></td>
                          <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya h '  name='konversi3'>  </div></td>
                        </tr>


                        <tr>
                          <td> Satuan Stock </td>
                          <td> <input type="text" class="form-control i" required="" name="unitstock"> </td>
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
                        <td>Kode Acc</td>
                        <td> 
                          <select required="" name="akun" class="form-control chosen-select-width">
                            <option selected="true" disabled="" value="">--Pilih Terlebih dahulu--</option>
                            @foreach($akun as $akun)
                              <option value="{{ $akun->id_akun }}">{{ $akun->id_akun }} - {{ $akun->nama_akun }} </option>
                            @endforeach
                          </select>
                        </td>
                      </tr>

                     
<!-- 
                      <tr>
                        <td> Syarat Hari </td>
                        <td> <input type="text" class="form-control" name="syarat_hari"></td>
                      </tr> -->

                      <tr>
                        <td> Update Stock </td>
                        <td class="updatestock"> <select class="form-control k updatestock" name="update_stock" required=""> 
                          <option value='T'  selected="" > T </option>
                          <option value='Y' > Y </option>
                        </select>
                      </tr>


                      <tr>
                        <td> Acc Persediaan </td>
                        <td> <input type="text" class="form-control l" name="acc_persediaan"></td>
                      </tr>
                      <tr>
                        <td> Acc HPP </td>
                        <td> <input type="text" class="form-control z" name="acc_hpp"></td>
                      </tr>
                      <tr>
                        <td> Foto </td>
                        <td> 
                           <label title="Upload image file" for="upload-file-selector" class="btn btn-primary">
                              <input type="file"  name="imageUpload" id="upload-file-selector" class="hide uploadGambar n" id="upload-file-selector" required="">
                                         <i class="fa fa-upload margin-correction"></i> Upload Gambar
                            </label>
                            
                                              
                                <div class="col-md-6 image-holder" style="padding:0px; padding-bottom: 20px;">
                        
                        </td>

                      </tr>
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


    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
     $('.jenis_item').change(function(){
      val = $(this).val();
      string = val.split(",");
      stock = string[1];
      if(stock == 'T') {
        $('td.updatestock').hide();
        $('.updatestock').val('J');
      }
      else {
         $('td.updatestock').show();
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
                var id = $(this).data('id');
                harga = $(this).val();
                numhar = parseFloat(harga).toFixed(2);
         
                $('.hrg').val(addCommas(numhar));
            })
        }) 


   $('.d').change(function(){ //qtysatu
      if($('.e').val() != '') {
        e = $('e').val();
        $('.i').val(e);
      }
      else if ($('.g').val() != ''){
        g = $('.g').val();
        $('.i').val(g);
      }
      else {
        d = $('.d').val();
        $('.i').val(d);
      }
   })

   $('.e').change(function(){ //qtydua
      val = $(this).val();
      $('.i').val(val);
   })



   $('.g').change(function(){ //qtytiga
      val = $(this).val();
      $('.i').val(val);
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
            }
          }

          if($('.g').val() != ''){
            val = $('.h').val();
            if(val = '') {
              toastr.info('Qty dua harap diisi :)');

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
            toastr.info('Minimum stock Harus Di isi');
            $('html,body').animate({scrollTop: $('.j').offset().top}, 200, function() {
             $('.j').focus();
            });
            return false;
          }
          if (k == '') {
            toastr.info('Update Stock Harus Di isi');
            $('html,body').animate({scrollTop: $('.k').offset().top}, 200, function() {
             $('.k').focus();
            });
            return false;
          }
          if (l == '') {
            toastr.info('Acc Persediaan Harus Di isi');
            $('html,body').animate({scrollTop: $('.l').offset().top}, 200, function() {
             $('.l').focus();
            });
            return false;
          }
          if (m == '') {
            toastr.info('Acc HPP Harus Di isi');
            $('html,body').animate({scrollTop: $('.z').offset().top}, 200, function() {
             $('.z').focus();
            });
            return false;
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
