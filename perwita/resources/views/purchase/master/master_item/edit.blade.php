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
                                <td style="width:200px"> Nama Item </td>
                                <td> <input type="text" class="form-control" name="nama_item" value="{{$item->nama_masteritem}}"></td>
                              </tr>
							  
                              <tr>
                                <td> Group Item </td>
                                <td> <select class="form-control" name="jenis_item"> 
                                
                                    @foreach($data['jenisitem'] as $grupitem)
                                      <option value="{{$grupitem->kode_jenisitem}}" @if($grupitem->keterangan_jenisitem == $item->keterangan_jenisitem)  selected="" @endif> {{$grupitem->keterangan_jenisitem}} </option>

                                      
                                    @endforeach
                                    


                                </select></td>
                              </tr>
                              <tr>
                                <td> Harga </td>
                                <td> <input type="text" class="form-control harga"  name="harga" value="{{$item->harga}}"></td>
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
                                <td> <input type="text" class="form-control" name="unit1" value="{{$item->unit1}}"> </td>
                                <td> </td>
                              </tr>
                              <tr>
                                <td> Ke Dua </td>
                                <td> <input type="text" class="form-control" name="unit2" value="{{$item->unit2}}"> </td>
                                <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya'  name='konversi2' value="{{$item->konversi3}}">  </div> </div>
                                </td>
                              </tr>

                              <tr>
                                <td> Ke Tiga </td>
                                <td> <input type="text" class="form-control" name="unit3" value="{{$item->unit3}}"></td>
                                <td> <div class='form-group'> <label class='col-sm-3 col-sm-3 control-label'> 1 PCS </label> <div class='col-sm-6'> <input type='text' class='form-control biaya'  name='konversi3' value="{{$item->konversi3}}"> </div> </div></td>
                              </tr>

                              

                              <tr>
                                <td> Satuan Stock </td>
                                <td> <input type="text" class="form-control" required="" name="unitstock" value="{{$item->unitstock}}"> </td>
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
                            <td> <input type="number" class="form-control" name="minimum_stock" required="" value="{{$item->minstock}}"></td>
                          </tr>
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
                          <tr>
                            <td> Update Stock </td>
                            <td> <select class="form-control" name="update_stock" required=""> 
                              @if($item->updatestock == "T")
                                <option value='T'  selected="" > T </option>
                                <option value='Y'> Y </option>

                              @else
                                <option value='Y' selected=""> Y </option>
                                <option value='T' selected="">T </option>
                              @endif
                            </select></td>
                          </tr>

                          <tr>
                            <td> Acc Persediaan </td>
                            <td> <input type="text" class="form-control" name="acc_persediaan" value="{{$item->acc_persediaan}}"></td>
                          </tr>

                          <tr>
                            <td> Acc HPP </td>
                            <td> <input type="text" class="form-control" name="acc_hpp" value="{{$item->acc_hpp}}"> </td>
                          </tr>

                          <tr>
                            <td> Foto </td>
                             <td> 
                               &nbsp; &nbsp; 

                               <label title="Upload image file" for="upload-file-selector" class="btn btn-primary">
                                  <input type="file"  name="imageUpload" id="upload-file-selector" class="hide uploadGambar" id="upload-file-selector">
                                             <i class="fa fa-upload margin-correction"></i> Re-Upload Gambar
                                </label>                                                    
                                <div class="col-md-6 image-holder" style="padding:0px; padding-bottom: 20px;"> </div>
                            </td>

                          </tr>
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
    $('.harga').change(function(){
       
                var id = $(this).data('id');
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
         
                $('.harga').val(addCommas(numhar));
            
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
     var image_holder = $(".image-holder");
      image_holder.html('<img src="{{asset($data['item'][0]->foto)}}" class="img-responsive" width="40px">');
      
      setTimeout(function(){
        image_holder.html('<img src="{{asset($data['item'][0]->foto)}}" class="img-responsive">');
        $('.save').attr('disabled', false);
      }, 1000);

     $(".uploadGambar").on('change', function () {        
          alert('ana');
        if (typeof (FileReader) != "undefined")   {

            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
              image_holder.html('<img src="{{ asset('image/loading1.gif') }}" class="img-responsive" width="40px">');
              
              $('.save').attr('disabled', true);

              setTimeout(function(){
                image_holder.empty();
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image img-responsive",
                    "height": "100px",
                }).appendTo(image_holder);
                $('.save').attr('disabled', false);
              }, 2000)
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            alert("This browser does not support FileReader.");
        }

      });
</script>
@endsection
