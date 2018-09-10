@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
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
                  <form method="post" action="{{url('mastersupplier/savesupplier')}}"  enctype="multipart/form-data" class="form-horizontal" id="savesupplier">

                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-6">

                          <table border="0" class="table">
                          


                          <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                        
                          <tr>
                          <td> Cabang </td>
                          <td>  
                           @if(Auth::user()->punyaAkses('Master Supplier','cabang'))
                            <select class="form-control  cabang" name="cabang" required>
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
                            <td> No Supplier </td>
                            <td> <input type="text" class="form-control input-sm nosupplier" name="nosupplier" readonly="" required=""></td>
                          </tr>

                          <tr>
                            <td width="200px">
                            Nama Supplier
                            </td>
                            <td>
                               <input type="text" class="input-sm form-control nmsupplier" name="nama_supplier" required="">                            
                            </td>
                          </tr>

                         
                          <tr>
                            <td>    Alamat </td>
                            <td>
                              <input type="text" class="input-sm form-control" name="alamat" required="">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Provinsi
                            </td>
                            <td>
                                <select class="chosen-select-width provinsi" name="provinsi" required="">  
                                  @foreach($data['provinsi'] as $provinsi)
                                      <option value="{{$provinsi->id}}"> {{$provinsi->nama}} </option> 
                                  @endforeach
                              </select>
                            </td>
                          </tr>

                         
                           <tr>
                            <td> Kota </td>
                            <td>
                              <select class="input-sm form-control chosen-select-width kota" name="kota" required="">
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
                              <input type="text" class="input-sm form-control" name="kodepos" required="">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                              <input type="number" class="input-sm form-control" name="notelp" required="">
                            </td>
                          </tr>

                            <tr>
                            <td width="200px"> Nama Contact Person </td>
                            <td> <input type="text" class="input-sm form-control" name="nm_cp" required="">  </td>
                          </tr>

                          <tr>
                            <td width="200px">
                            Nomor Contact Person
                            </td>
                            <td>
                               <input type="number" class="input-sm form-control" name="number_cp" required="">
                            </td>
                          </tr>
                          </table>

                         </div>

                         <div class="col-xs-6">
                          <table border="0" class="table">
                        

                          <tr>
                            <td>   Syarat Kredit  </td>
                            <td>
                             <div class="form-group"> <div class="col-sm-8"> <input type="number" class="form-control input-sm" name="syarat_kredit" required=""> </div> <label class="col-sm-2 col-sm-2 control-label"> Hari </label> </div>  
                            </td>
                          </tr>

                           <tr>
                            <td> Plafon Kredit </td>
                             <td>
                               <input type="text" class="input-sm form-control plafon" name="Plafon" required="">

                            </td>
                          </tr>

                           <tr>
                            <td> Mata Uang </td>
                            <td>

                                <select class="form-control" name="matauang" required> <option value="RP"> RP </option> <option value="USA"> USA </option>  </select>

                            </td>
                          </tr>
                   

                          <tr>
                            <td>
                              Acc Hutang Dagang
                            </td>
                            <td> 
                            <select class="form-control chosen-select-width1 acc_hutangdagang" name="acc_hutangdagang" required>
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
                            <select class="form-control chosen-select-width1 acc_csf" name="acc_csf" required>
                              <option value=""> Pilih Id Akun
                              </option>
                            </select>
                             </td>
                          </tr>


                          <tr>
                              <td style="width:300px"> Terikat Kontrak </td>
                              <td>    <select class="form-control kontrak"  name="kontrak" required=""> <option value="" selected >  -- Pilih -- </option> <option value="YA"> Ya </option> <option value="TIDAK"> Tidak </option> </select>
                          <br> <div class="nokontrak"> </div>
                           </td> </td>
                          </tr>
                          </table>

                         </div>
                         </div>

                         <hr>

                         <div class="col-xs-6">
                         <table class="table">

                          <tr>
                            <td style="width:200px"><b>  Apakah Supplier ini termasuk PKP ? </b> </td>
                            <td> <select class="form-control pkp" name="pkp" required><option value="Y"> Ya </option>  <option value="T"> Tidak </option> </select> </td>
                          </tr>    
                         </table>
                         </div>

                          <div class="col-xs-10" class="pajak">
                          <hr>
                          <h4>  Informasi Pajak Supplier </h4>
                          <hr>
                          <table border="0" class="table">
                          <tr>
                            <td class="pajak"> NO NPWP </td>
                            <td>
                               <input type="text" class="input-sm form-control pajak isipajak" name="npwp">
                            </td>
                          </tr>

                          <tr>
                            <td> NIK </td>
                            <td> <input type="number" class="form-control pajak" name="nik"></td>
                          </tr>

                        <tr>
                          <td class="pajak"> Nama </td>
                          <td> <input type="text" class="form-control input-sm pajak isipajak" name="namapajak" ></td>
                        </tr>

                        <tr>
                          <td class="pajak"> Telepon </td>
                          <td> <input type="number" class="form-control input-sm pajak isipajak" name="telppajak"></td>
                        
                        </tr>

                        <tr>
                           <td class="pajak"> Alamat Lengkap </td>
                          <td> <input type="text" class="form-control input-sm pajak isipajak" name="alamatpajak"></td>                       
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
                              <th> Keterangan </th>
                          
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

    $('#savesupplier').submit(function(){
        data2 = $(this).serialize();
        baseurl = baseUrl + '/mastersupplier/savesupplier';
      $.ajax({
        data : {data2},
        url : baseurl,
        type : "POST",
        success : function(response){

        }
      })
    })

      $('.nmsupplier').change(function(){
        val = $(this).val();
        
        if(val.indexOf(',') > -1){         
           test =  val.replace(/,/g , '');
           $(this).val(test);
           toastr.info("Mohon maaf nama tidak boleh ada comma :)");
        }
       
      })

      $('.cabang').change(function(){
         cabang = $('.cabang').val();
      $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/mastersupplier/getnosupplier',
          dataType : 'json',
          success : function (response){     
  
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
                 nofaktur = 'SP' + '-' + cabang + '/'  + response.idsupplier ;
              
                $('.nosupplier').val(nofaktur);

                
          },
          error : function (){
            location.reload();
          }
        })
      })

      cabang = $('.cabang').val();
      $.ajax({
          type : "get",
          data : {cabang},
          url : baseUrl + '/mastersupplier/getnosupplier',
          dataType : 'json',
          success : function (response){     
  
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
                 nofaktur = 'SP' + '-' + cabang + '/'  + response.idsupplier ;
              
                $('.nosupplier').val(nofaktur);

                
          },
          error : function(){
            location.reload();
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
                '.chosen-select-width'     : {width:"100%"}
                }

             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }


      $(".acc_hutangdagang").chosen(config);
      $(".acc_csf").chosen(config);
      $('.cabang').chosen(config);
    })
     },2000);

    $('#submit').click(function(){
      var tr = $('tr.dataitem').length;
      kontrak = $('.kontrak').val();
      pkp = $('.pkp').val();
    
      temppkp = 0;
      if(kontrak == 'YA'){
        if(tr == 0){
        toastr.info('jenis Supplier adalah  Kontrak, Mohon Tambah Data Barang :) ');
        return false;
        }        
      }
  
      else if(pkp == 'Y'){
        $('.isipajak').each(function(){
          val = $(this).val();
      
          if(val == ''){
              temppkp = temppkp + 1;
          }
         
        })
       
        if(temppkp != 0 ){
          toastr.info('Mohon lengkapi data informasi pajak supplier :)');
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
    
    $('.cabang').change(function(){


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
     })


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

      var rowBrg = "<tr id='dataitem item-"+$no+"' class='dataitem item-"+$no+"'>" +
                  "<td> <b>" + $no +"</b> <input type='hidden' value='databarang' name='databarang[]'> </td>" +               
                  "<td> <select class='form-control chosen-select brg' name='brg[]' data-id="+$no+" >  @foreach($data['item'] as $item) <option value='{{$item->kode_item}}+{{$item->harga}}+{{$item->updatestock}}'> {{$item->nama_masteritem}} </option> @endforeach </select>" +
                   "<td> <input type='text' class='form-control  hrg"+$no+"' id='harga' name='harga[]' data-id='"+$no+"'> </td>" +
                   "<td> <select class='form-control updatestock"+$no+"' name='updatestock[]' readonly> <option value='Y'> Ya </option> <option value='T'> Tidak </option> </select> </td>" +
                   "<td> <input type='text' class='form-control' name='keteranganitem[]'> </td>" +
                  "<td> <a class='btn btn-danger removes-btn' data-id='"+ $no +"'> <i class='fa fa-trash'> </i>  </a></td>" +
                  "</tr>";

        /*var rowBrg = "<tr> <td colspan='4'> <select class='form-control'> <option value=''> Ana </option> <option value=''> Arief </option> </select> </td> </tr>";*/

     $("#addColumn").append(rowBrg);

     $(function(){
            $('.hrg' + $no).change(function(){
                val = $(this).val();
      
               val = accounting.formatMoney(val, "", 2, ",",'.');
               $(this).val(val);

            })
        }) 

     

        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
              length = $('tr.dataitem').length;
             // alert(length + 'length');
              var parent = $('.item-'+id);
             parent.remove();
          });

        $('.brg').change(function(){
            val = $(this).val();
            explode = val.split("+");
            harga = explode[1];
            updatestock = explode[2];
            //alert(val);
            dataid = $(this).data('id');
            $('.hrg' + dataid).val(addCommas(harga));
            $('.updatestock' + dataid).val(updatestock);
         });

    })
  


      $(function(){
        $('.kontrak').change(function(){
            var data = $(this).val();
            var id = $(this).data('id');
          //  console.log(data);
            if(data == "YA") {
                var rowContract = '<div class="form-group"> <label class="col-sm-1"> No </label> <div class="col-sm-10"> <input type="text" class="form-control" name="nokontrak" required=""> </div> </div>';
                $('.nokontrak').html(rowContract);    
                $('.hslkontrak').show();          
            }
            else {
              $('.nokontrak').empty();
            
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
                $('.kota').trigger("chosen:updated");
                 $('.kota').trigger("liszt:updated");
                }
              });

             
             })
         })
  
    $('.plafon').change(function(){

               val = $(this).val();
      
               val = accounting.formatMoney(val, "", 2, ",",'.');
               $(this).val(val);

            
    })

</script>
@endsection
