@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Supplier </h2>
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
                            <strong> Create Master Supplier </strong>
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
                    <h5> Tambah Data Master Supplier
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
                </div><!-- /.box-header -->
                  <form method="post" action="{{url('mastersupplier/savesupplier')}}"  enctype="multipart/form-data" class="form-horizontal">

                  
                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-6">

                          <table border="0" class="table">

                          <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                          <tr>
                             @if(Auth::user()->PunyaAkses('Faktur Cabang','aktif'))
                            <tr>
                             <td> Pengajuan dari Cabang </td>
                            <td>
                              <select class='form-control chosen-select-width1 cabang' name="cabang">
                                  <option value="">
                                    Pilih-Cabang
                                  </option>

                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                 </select>
                            </td>
                            </tr>
                            @else
                            <tr>
                         <td> Pengajuan dari Cabang </td>
                            <td>
                              <select class='form-control chosen-select-width1 cabang' disabled="" name="cabang">
                                  <option value="">
                                    Pilih Cabang
                                  </option>

                                  @foreach($data['cabang'] as $cabang)
                                    @if($cabang->kode == Auth::user()->kode_cabang)
                                    <option selected="" value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                    @else
                                    <option value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                    @endif
                                  @endforeach
                                 </select>
                            </td>
                            </tr>
                            @endif

                         

                          <tr>
                            <td width="200px">
                            Nama Supplier
                            </td>
                            <td>
                               <input type="text" class="input-sm form-control" name="nama_supplier" >
                               <input type="hidden" class="form-control" name="cabang" value="{{ Auth::user()->kode_cabang}}">
                            </td>
                          </tr>

                         
                          <tr>
                            <td>    Alamat </td>
                            <td>
                              <input type="text" class="input-sm form-control" name="alamat">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Provinsi
                            </td>
                            <td>
                                <select class="chosen-select-width provinsi" name="provinsi">  
                                  @foreach($data['provinsi'] as $provinsi)
                                      <option value="{{$provinsi->id}}"> {{$provinsi->nama}} </option> 
                                  @endforeach
                              </select>
                            </td>
                          </tr>

                         
                           <tr>
                            <td> Kota </td>
                            <td>
                              <select class="input-sm form-control kota" name="kota">
                              @foreach($data['kota'] as $kota)
                                <option value="{{$kota->id}}"> {{$kota->nama}}</option>
                              @endforeach
                              </select>
                            </td>
                            </td>
                          </tr>


                          <tr>
                            <td>
                              Kode Pos
                            </td>
                            <td>
                              <input type="text" class="input-sm form-control" name="kodepos">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                              <input type="number" class="input-sm form-control" name="notelp">
                            </td>
                          </tr>

                            <tr>
                            <td width="200px"> Nama Contact Person </td>
                            <td> <input type="text" class="input-sm form-control" name="nm_cp">  </td>
                          </tr>

                          <tr>
                            <td width="200px">
                            Nomor Contact Person
                            </td>
                            <td>
                               <input type="number" class="input-sm form-control" name="number_cp">
                            </td>
                          </tr>
                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0" class="table">
                        

                          <tr>
                            <td>   Syarat Kredit  </td>
                            <td>
                             <div class="form-group"> <div class="col-sm-8"> <input type="number" class="form-control input-sm" name="syarat_kredit"> </div> <label class="col-sm-2 col-sm-2 control-label"> Hari </label> </div>  
                            </td>
                          </tr>

                           <tr>
                            <td> Plafon Kredit </td>
                             <td>
                                <select class="form-control" name="plafon">
                                  <option value="YA"> Ya </option>
                                  <option value="TIDAK"> Tidak </option>
                                </select>
                            </td>
                          </tr>

                           <tr>
                            <td> Mata Uang </td>
                            <td>

                                <select class="form-control" name="matauang"> <option value="RP"> RP </option> <option value="USA"> USA </option>  </select>

                            </td>
                          </tr>

                          <tr>
                            <td> Apakah Supplier ini termasuk PKP ? </td>
                            <td> <select class="form-control pkp" name="pkp"><option value="Y"> Ya </option>  <option value="T"> Tidak </option> </select> </td>
                          </tr>                       

                          <tr>
                            <td>
                              Acc Hutang Dagang
                            </td>
                            <td> 
                            <select class="form-control chosen-select-width1 acc_hutangdagang" name="acc_hutangdagang">
                              <option value=""> Pilih Id Akun
                              </option>
                            </select>
                             </td>
                          </tr>

                          <tr>
                            <td>
                              Acc Cash Flow
                            </td>
                            <td> 
                            <select class="form-control chosen-select-width1 acc_csf" name="acc_csf">
                              <option value=""> Pilih Id Akun
                              </option>
                            </select>
                             </td>
                          </tr>


                          <tr>
                              <td style="width:300px"> Terikat Kontrak </td>
                              <td>    <select class="form-control kontrak"  name="kontrak"> <option value="" selected>  -- Pilih -- </option> <option value="YA"> Ya </option> <option value="TIDAK"> Tidak </option> </select>
                          <br> <div class="nokontrak"> </div>
                           </td> </td>
                          </tr>
                          </table>

                         </div>
                         </div>

                         <hr>

                          <div class="col-xs-12" class="pajak">
                          <hr>
                          <h4>  Informasi Pajak Supplier </h4>
                          <hr>
                          <table border="0" class="table">
                          <tr>
                            <td class="pajak"> NO NPWP </td>
                            <td>
                               <input type="number" class="input-sm form-control pajak" name="npwp">
                            </td>
                          </tr>

                        <tr>
                          <td class="pajak"> Nama </td>
                          <td> <input type="text" class="form-control input-sm pajak" name="namapajak"></td>
                        </tr>

                        <tr>
                          <td class="pajak"> Telepon </td>
                          <td> <input type="number" class="form-control input-sm pajak" name="telppajak"></td>
                        
                        </tr>

                        <tr>
                           <td class="pajak"> Alamat </td>
                          <td> <input type="text" class="form-control input-sm pajak" name="alamatpajak"></td>
                        
                        </tr>
                          <tr class="pajak">
                            <td style="width:100px">
                               No Seri Pajak Supplier 
                            </td>
                         
                            <td>
                               <input type="number" class="form-control" name="seripajak">
                            </td>
                            

                              <td style="width:200px">  
                                <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="checkbox7" type="checkbox" name="pajak_ppn">
                                    <label for="checkbox7">
                                      PPn Masukan
                                    </label>
                                </div> 
                            </td>

                     
                            <td style="width:200px">
                              <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="checkbox8" type="checkbox" name="pajak_pph">
                                    <label for="checkbox8">
                                      PPh Pasal 23
                                    </label>
                                </div>
                            </td>
                      
                            <td style="width:200px">
                                <div class="checkbox checkbox-info checkbox-circle">
                                  <input id="checkbox9" type="checkbox" name="pajak_26">
                                    <label for="checkbox9">
                                      PPh Pasal 26
                                    </label>
                                </div>
                            </td>
                         </tr>
                   

                      

                          </table>
                         </div>


                         <div class="col-xs-12">
                          <hr>
                            <h4> Data Barang </h4>
                          <hr>

                          <button id="tmbh_data_barang" type="button" class="btn btn-sm btn-primary hslkontrak"> <i class="fa fa-plus"> </i> Tambah Data Barang </button>
                          <table class="table table-bordered table-striped tbl-item" id="addColumn">
                            <tr id="header-column">
                              <th> No </th>
                              <th> Barang </th>
                              <th> Harga </th>
                              <th> Update Stock </th>
                          
                              <th> </th>
                            </tr>
                          </table>

                         </div>

                    </div>
                  

                
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('mastersupplier/mastersupplier')}}> Kembali </a>
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


      $(".acc_hutangdagang").chosen(config);
      $(".acc_csf").chosen(config);
    })
     },2000);

    $('#submit').click(function(){
      var tr = $('tr#dataitem').length;
      kontrak = $('.kontrak').val();
      if(kontrak == 'YA'){
              if(tr == 0){
        toastr.info('jenis Supplier adalah  Kontrak, Mohon Tambah Data Barang :) ');
        return false;
      }        
      }

    })

    $('.pkp').change(function(){
      val = $(this).val();
      if(val == 'T'){
        $('.pajak').hide();
      }
      else {
        $('.pajak').show();
      }
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    cabang = $('.cabang').val();
     $.ajax({
      data :  {cabang},
      url : baseUrl + '/mastersupplier/getacchutang',
      dataType : 'json',
      success : function(response){

     

        $('.acc_hutangdagang').empty();
          $('.acc_hutangdagang').append(" <option value=''>  -- Pilih id akun -- </option> ");
            $.each(response, function(i , obj) {
      //        console.log(obj.is_kodeitem);
              $('.acc_hutangdagang').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
            })
              $('.acc_hutangdagang').trigger("chosen:updated");
          $('.acc_hutangdagang').trigger("liszt:updated");


           $('.acc_csf').empty();
          $('.acc_csf').append(" <option value=''>  -- Pilih id akun -- </option> ");
            $.each(response, function(i , obj) {
      //        console.log(obj.is_kodeitem);
              $('.acc_csf').append("<option value="+obj.id_akun+"> <h5> "+obj.id_akun+" - "+obj.nama_akun+" </h5> </option>");
            })
              $('.acc_csf').trigger("chosen:updated");
          $('.acc_csf').trigger("liszt:updated");

         

         }


     })

     $no = 0;
    $('#tmbh_data_barang').click(function(){
       
      $no++;

      var rowBrg = "<tr id=dataitem item-"+$no+">" +
                    "<td> <b>" + $no +"</b> </td>" +               
                    "<td> <select class='form-control' name='idbarang[]'>  @foreach($data['item'] as $item) <option value={{$item->kode_item}}> {{$item->nama_masteritem}} </option> @endforeach </select>" +
                     "<td> <input type='text' class='form-control  hrg"+$no+"' id='harga' name='harga[]' data-id='"+$no+"'> </td>" +
                     "<td> <select class='form-control' name='updatestock[]'> <option value='Y'> Ya </option> <option value='T'> Tidak </option> </select> </td>" +
                    "<td> <a class='btn btn-danger removes-btn' data-id='"+ $no +"'> <i class='fa fa-trash'> </i>  </a> </td>" +
                    "</tr>";

        /*var rowBrg = "<tr> <td colspan='4'> <select class='form-control'> <option value=''> Ana </option> <option value=''> Arief </option> </select> </td> </tr>";*/

     $("#addColumn").append(rowBrg);

     $(function(){
            $('.hrg' + $no).change(function(){
                var id = $(this).data('id');

                harga = $(this).val();
                $this = $(this);
                
                numhar = Math.round(harga).toFixed(2);
         
                $this.val(addCommas(numhar));

            })
        }) 

     

        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })


      $(function(){
        $('.kontrak').change(function(){
            var data = $(this).val();
            var id = $(this).data('id');
          //  console.log(data);
            if(data == "YA") {
                var rowContract = '<div class="form-group"> <label class="col-sm-1"> No </label> <div class="col-sm-10"> <input type="text" class="form-control" name="nokontrak" required=""> </div> </div>';
                $('.nokontrak').html(rowContract);              
            }
            else {
              $('.nokontrak').empty();
              $('.hslkontrak').attr('disabled' , true);
            }
        })

      })



     $(function(){
            $('.provinsi').change(function(){
               var provinsi = $(this).val();
               $.ajax({
                url : baseUrl + '/mastersupplier/ajaxkota/' + provinsi,
                type : "GET",
                dataType : "json",
                success : function(data) {
                  /*$('.kota').val(data);*/
                  console.log(data);

                  $('select[name="kota"]').empty();

                  $.each(data, function(key, value) {
                    $('select[name="kota"]').append('<option value="'+ key +'">'+ value +'</option>')
                  })


                }
              });

             
             })
         })
  
   

</script>
@endsection
