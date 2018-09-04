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
                       @foreach($data['item'] as $item)
                          <form method="post" action="{{url('masteritem/updateitem/'.$item->kode_item .'')}}"  enctype="multipart/form-data" class="form-horizontal">
                          <table class="table" border="0">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                              <tr>        
                                <td style="width:200px"> Cabang </td>
                                <td> <input type="text" class="form-control "  value="{{$item->nama}}" disabled=""> <input type="hidden" class="cabang" name="cabang" value="{{$item->kode}}"> </td>
                              </tr>

                              <tr>        
                                <td style="width:200px"> Nama Item </td>
                                <td> <input type="text" class="form-control" name="nama_item" value="{{$item->nama_masteritem}}"> <input type="hidden" class="form-control kodeitem"  value="{{$item->kode_item}}"></td>
                              </tr>
							  
                              <tr>
                                <td> Group Item </td>
                                <td> <select class="form-control jenis_item" name="jenis_item"> 
                                
                                    @foreach($data['jenisitem'] as $grupitem)
                                      <option value="{{$grupitem->kode_jenisitem}}" @if($grupitem->keterangan_jenisitem == $item->keterangan_jenisitem)  selected="" @endif> {{$grupitem->keterangan_jenisitem}} </option>       
                                    @endforeach
                                    
                                </select></td>
                              </tr>
                              <tr>
                                <td> Harga </td>
                                <td> <input type="text" class="form-control harga hrg"  name="harga" value="{{$item->harga}}" style="text-align:right"></td>
                              </tr>
                            </table>
                        </div>   
                        
                        <div class="col-md-6">
                           <table class="table" border="0">
                              <tr>
                                <th> Quantity</th>
                                <th> Satuan </th>
                                <th> Konversi </th>
                              </tr>
                              <tr>
                                <td> Ke Satu </td>
                                <td> <input type="text" class="form-control d qtysatu" name="unit1" value="{{$item->unit1}}"> </td>
                                <td> </td>
                              </tr>
                              <tr>
                                <td> Ke Dua </td>
                                <td> <input type="text" class="form-control e qtydua" name="unit2" value="{{$item->unit2}}"> </td>
                                <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya'  name='konversi2' value="{{$item->konversi2}}">  </div> </div>
                                </td>
                              </tr>

                              <tr>
                                <td> Ke Tiga </td>
                                <td> <input type="text" class="form-control g qtytiga" name="unit3" value="{{$item->unit3}}"></td>
                                <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya'  name='konversi3' value="{{$item->konversi3}}"> </div> </div></td>
                              </tr>

                              

                              <tr>
                                <td> Satuan Stock </td>
                                <td> <input type="text" class="form-control i qtystock" required="" name="unitstock" value="{{$item->unitstock}}" readonly=""> </td>
                              </tr>
                            </table>
                        </div>
						</div>
                      
					  <div class="row">
                        <div class="col-sm-6">
              						<table class="table">
              						<hr>
                                <h4>  Item </h4>
              						
              						  <tr>
                            <td style="width:200px"> Minimum Stock </td>
                            <td> <input type="number" class="form-control j" name="minimum_stock" required="" value="{{$item->minstock}}"></td>
                          </tr>
                          
                      </tr>
                          <tr>
                            <td class="updatedtock"> Update Stock  </td>
                            <td class="updatedtock"> <select class="form-control updatestock" name="update_stock" required=""> 
                              @if($item->updatestock == "T")
                                <option value='T'  selected="" > T </option>
                                <option value='Y'> Y </option>

                              @else
                                <option value='Y' selected=""> Y </option>
                                <option value='T'>T </option>
                              @endif
                            </select></td>
                          </tr>

                          <tr>
                            <td> Acc Persediaan </td>
                            <td>
                            <select class="chosen-select-width l accpersediaan" name="acc_persediaan" id="accpersediaan"></select> </td>
                          </tr>

                          <tr>
                            <td> Acc HPP </td>
                            <td>
                            <select class="chosen-select-width l acchpp" name="acc_hpp" id="accpersediaan"> </select>

                          </tr>

                      <!--     <tr>
                            <td> Foto </td>
                             <td> 
                               &nbsp; &nbsp; 

                               <label title="Upload image file" for="upload-file-selector" class="btn btn-primary">
                                  <input type="file"  name="imageUpload" id="upload-file-selector" class="hide uploadGambar" id="upload-file-selector">
                                             <i class="fa fa-upload margin-correction"></i> Re-Upload Gambar
                                </label>                                                    
                                <div class="col-md-6 image-holder" style="padding:0px; padding-bottom: 20px;"> </div>
                            </td>

                          </tr> -->
						  </table>
                        </div>

                        <div class="col-md-6">
                            <hr>
                              <h4> Posisi Item </h4>
                                <table class="table">
                                  <tr>
                                    <td> Lantai </td>
                                    <td> <input type="text" class="form-control" name="posisilantai" value="{{$item->posisilantai}}"> </td>
                                  </tr>
                                  <tr>
                                    <td> Ruang </td>
                                    <td> <input type="text" class="form-control" name="posisiruang" value="{{$item->posisiruang}}"> </td>
                                  </tr>
                                  <tr>
                                    <td> Rak </td>
                                    <td>  <input type="text" class="form-control" name="posisirak" value="{{$item->posisirak}}"> </td>
                                  </tr>
                                  <tr>
                                    <td> Kolom </td>
                                    <td>  <input type="text" class="form-control" name="posisikolom"  value="{{$item->posisirak}}"></td>
                                  </tr>
                                </table>
                        </div>
                      </div>  
                  

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('masteritem/masteritem')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
                    @endforeach
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
  //    $(".kndraan").chosen(config);
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


  $('.jenis_item').change(function(){
    val = $(this).val();
    if(val == 'J'){
          $('.j').attr('required' , false);
          $('.j').attr('disabled' , true);
          
    }
  });


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  $('.jenis_item').change(function(){
    kodejenis = $(this).val();
    updatestock = $('.updatestock').val();
    cabang = $('.cabang').val();
    kodeitem = $('.kodeitem').val();
    groupitem = $('.jenis_item').val();
      $.ajax({
        data : {kodejenis,updatestock,cabang,kodeitem,groupitem},
        url : baseUrl + '/masteritem/getpersediaan',
        type : "get",
        dataType : "json",
        success : function(response){
          stock = response.stock;
        
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
                //alert('t');
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


    $(function(){
            $('.hrg').change(function(){
                val = $(this).val();
      
                val = accounting.formatMoney(val, "", 2, ",",'.');
                $(this).val(val);
            })
        }) 

 

    $('.harga').change(function(){
       
                var id = $(this).data('id');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
         
                $('.harga').val(addCommas(numhar));
            
    })

   


   $('.updatestock').change(function(){
     kodejenis = $(this).val();
    updatestock = $('.updatestock').val();
    cabang = $('.cabang').val();
    kodeitem = $('.kodeitem').val();
    groupitem = $('.jenis_item').val();
   
      $.ajax({
        data : {kodejenis,updatestock,cabang,groupitem,kodeitem},
        url : baseUrl + '/masteritem/getpersediaan',
        type : "get",
        dataType : "json",
        success : function(response){
          stock = response.stock;
        
            if(stock == 'Y'){
                 if(updatestock == 'Y') {
                      arrItem = response.akun;
                      if(arrItem.length != 0) {
                         akunitem = response.masteritem[0].acc_persediaan;
                        $('.acchpp').empty();
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated");
                        
                        $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrItem, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                        $('.accpersediaan').val(akunitem);  
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                      }
                      else {
                        arrMaster = response.akunmaster;
                        akunitem = response.masteritem[0].acc_persediaan;

                        $('.acchpp').empty();
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated");
                        
                        $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })
                        $('.accpersediaan').val(akunitem); 
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                      }
              }
              else {
                  arrItem = response.akun;
                      if(arrItem.length != 0) {
                        akunitem = response.masteritem[0].acc_hpp;
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");

                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrItem, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })
                        $('.acchpp').val(akunitem);
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                      }
                      else {
                        arrMaster = response.akunmaster;
                        akunitem = response.masteritem[0].acc_hpp;
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");

                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })
                        $('.acchpp').val(akunitem);
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                      }
              } 
              }
              else {
                arrItem = response.akun;
                    if(arrItem.length != 0){
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
                    else {
                      arrMaster = response.akunmaster;
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated"); 
  
                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                    }
              }
         
        },
        error : function(){
      
          location.reload();
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
          


          updatestock = $('.updatestock').val();
          groupitem = $('.jenis_item').val();
          cabang = $('.cabang').val();
          kodeitem = $('.kodeitem').val();
          if(groupitem == 'J'){
            $('.j').attr('required' , false);
            $('.j').attr('disabled' , true);
          }
        
          $.ajax({
            data : {updatestock,groupitem,cabang,kodeitem},
            url : baseUrl + '/masteritem/getpersediaan',
              dataType : "json",
            type : "get",
            success : function(response){
              $('.accpersediaan').empty();
              $('.acchpp').empty();
              stock = response.stock;
                if(stock == 'Y'){
                 if(updatestock == 'Y') {
                      arrItem = response.akun;
                      if(arrItem.length != 0) {
                        akunitem = response.masteritem[0].acc_persediaan;

                        $('.acchpp').empty();
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated");
                        
                        $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrItem, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                          $('.accpersediaan').val(akunitem);
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                      }
                      else {
                        arrMaster = response.akunmaster;
                        $('.acchpp').empty();
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated");
                         akunitem = response.masteritem[0].acc_persediaan;
                        $('.accpersediaan').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.accpersediaan').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })
                         $('.accpersediaan').val(akunitem);
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                      }
              }
              else {
                  akunitem = response.masteritem[0].acc_hpp;

                  arrItem = response.akun;
                      if(arrItem.length != 0) {
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                         akunitem = response.masteritem[0].acc_hpp;

                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrItem, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                         $('.acchpp').val(akunitem);
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                      }
                      else {
                        arrMaster = response.akunmaster;
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated");
                         akunitem = response.masteritem[0].acc_hpp;

                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                          $('.acchpp').val(akunitem);
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                      }
              } 
              }
              else {
                arrItem = response.akun;
                    if(arrItem.length != 0){
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated"); 
                         akunitem = response.masteritem[0].acc_hpp;
                        
                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrItem, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                          $('.acchpp').val(akunitem);
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                    }
                    else {
                      arrMaster = response.akunmaster;
                        $('.accpersediaan').empty();
                        $('.accpersediaan').trigger("chosen:updated");
                        $('.accpersediaan').trigger("liszt:updated"); 
                         akunitem = response.masteritem[0].acc_hpp;

                        $('.acchpp').empty();
                        $('.acchpp').append(" <option value=''>  -- Pilih id akun -- </option> ");
                          $.each(arrMaster, function(i , obj) {
                    //        console.log(obj.is_kodeitem);
                            $('.acchpp').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
                          })

                         $('.acchpp').val(akunitem); 
                        $('.acchpp').trigger("chosen:updated");
                        $('.acchpp').trigger("liszt:updated"); 
                    }
              }             
            }
          })
    
</script>
@endsection
