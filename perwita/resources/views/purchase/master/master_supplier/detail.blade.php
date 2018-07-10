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
                  @foreach($data['supplier'] as $sup)
                    <h5> Detail Data Master Supplier 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5> <span class="label label-info"> {{$sup->status}} </span>
                    <div class="text-right">
                        <a class="btn btn-default" href="{{url('mastersupplier/mastersupplier')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
                    </div>
                </div>
                
            <div class="ibox-content">
            <div class="row">  
            <div class="col-xs-12">    
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->


               
                <form method="post" action="{{url('mastersupplier/updatesupplier/'.$sup->idsup .'')}}"  enctype="multipart/form-data" class="form-horizontal">

                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-6">
                            <table border="0" class="table">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                               <tr>
                               
                                <td width="200px">
                                  Cabang
                                </td>
                                <td>
                                  <input type="text" class="form-control input-sm" name="cabang" value="{{$sup->namacabang}}" readonly="">
                                  <input type="hidden" class="form-control input-sm cabang" name="cabang" value="{{$sup->kodecabang}}" readonly="">
                                </td>
                                </tr>


                              <tr>
                                <input type="hidden" class="form-control input-sm" name="idsupplier" value="{{$sup->idsup}}" readonly="">
                                <td width="200px">
                                  Kode Supplier
                                </td>
                                <td>
                                  <input type="text" class="form-control input-sm" name="nosupplier" value="{{$sup->no_supplier}}" readonly="">
                                </td>
                                </tr>


                                <tr>
                                  <td>
                                  Nama Supplier
                                  </td>
                                  <td width="400px">
                                     <input type="text" class="form-control input-sm namasupplier" name="nama_supplier" value="{{$sup->nama_supplier}}" readonly="">
                                  </td>
                              </tr>

                          <tr>
                            <td> Alamat </td>
                            <td>
                              <input type="text" class="form-control input-sm alamat" name="alamat" value="{{$sup->alamat}}" readonly=""> 
                            </td>
                          </tr>
                          
                          <tr>
                            <td> 
                              Pengajuan dari Cabang
                            </td>
                            <td>
                              <select class="chosen-select-width ubah" name="idcabang" disabled="">
                              @foreach($data['cabang'] as $cbg) 
                                 <option value="{{$cbg->kode}}" @if($cbg->kode == $sup->idcabang) selected="" @endif>  {{$cbg->nama}} </option>
                              @endforeach
                              </select>
                            </td>
                          </tr>

                          
                          <tr>
                            <td>
                              Provinsi
                            </td>
                            <td>
                              <select class="chosen-select-width provinsi ubah" name="provinsi" disabled="">
                              @foreach($data['provinsi'] as $provinsi)
                                      <option value="{{$provinsi->id}}" @if($provinsi->id == $sup->propinsi) selected="" @endif> {{$provinsi->nama}} </option> 
                              @endforeach
                              </select>

                             
                            </td>
                          </tr>

                           <tr>
                            <td> Kota </td>
                            <td>
                               <select class="form-control kota chosen-select-width ubah" name="kota" disabled="">
                              @foreach($data['kota'] as $kota)
                                <option value="{{$kota->id}}" @if($kota->id == $sup->kota)  selected="" @endif> {{$kota->nama}} </option>
                              @endforeach
                              </select>

                            </td>
                          </tr>

                          <tr>
                            <td>
                              Kode Pos
                            </td>
                            <td>
                              <input type="text" class="form-control kodepos input-sm ubah" name="kodepos" value="{{$sup->kodepos}}" readonly="">
                            </td>
                          </tr>


                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                               <input type="text" class="form-control notelp input-sm" name="notelp" value="{{$sup->telp}}" readonly="">
                            </td>
                          </tr>

                        

                          <tr>
                            <td>  
                              Status Setuju
                            </td>

                            <td>
                                <span class="label label-info "> {{$sup->status}} </span>
                            </td>
                          </tr>
                      </table>                          
                     </div>

                    <div class="col-xs-6">
                      <table border="0" class="table">
                          <tr>
                          <td width="200px">
                             Nomor Contact Person
                          </td>
                          <td width="300px">
                            <input type="number" class="form-control cp input-sm" name="cp" value="{{$sup->contact_person}}" readonly="">
                          </td>
                        </tr>

                         <tr>
                          <td width="200px">
                             Nama Contact Person
                          </td>
                          <td width="300px">
                            <input type="text" class="form-control nm_cp input-sm ubah" name="nm_cp" value="{{$sup->nama_cp}}" readonly="">
                          </td>
                        </tr>

                        <tr>
                          <td>   Syarat Kredit  </td>
                          <td>
                             <input type="text" class="form-control syaratkredit input-sm" name="syarat_kredit" value="{{$sup->syarat_kredit}}" readonly="">
                          </td>
                        </tr>


                         <tr>
                          <td> Plafon Kredit </td>
                           <td>
                             <input type="text" class="form-control plafonkredit input-sm" name="plafon_kredit" value="{{ number_format($sup->plafon, 2) }}" readonly="">
                          </td>
                        </tr>


                         <tr>
                          <td> Mata Uang </td>
                          <td>
                                <input type="text" class="form-control matauang " name="matauang" value="{{$sup->currency}}" readonly="">
                          </td>
                        </tr>

                    


                         <tr>
                          <td>
                            Acc Hutang Dagang
                          </td>
                          <td> 
                            <select class="form-control chosen-select-width1 acc_hutangdagang"   style="width:100%" disabled="">
                              @foreach($data['mastersup'] as $mstrsup)
                              <option value="{{$mstrsup->id_akun}}" @if($mstrsup->id_akun == $sup->acc_hutang) selected @endif > {{$mstrsup->id_akun}} - {{$mstrsup->nama_akun}}
                              </option>
                              @endforeach
                            </select> <input type="hidden" class="acchutangdagang" value="{{$sup->acc_hutang}}" name="acc_hutangdagang"> <input type="hidden" class="acccsf" value="{{$sup->acc_csf}}" name="acc_csf">
                          </td>
                        </tr>
                         
                         <tr>
                          <td>
                            Acc CSF
                          </td>
                          <td> <select class="form-control chosen-select-width1 acc_csf" disabled="">

                                 @foreach($data['mastersup'] as $mstrsup)
                                 <option value="{{$mstrsup->id_akun}}" @if($mstrsup->id_akun == $sup->acc_hutang) selected @endif > {{$mstrsup->id_akun}} - {{$mstrsup->nama_akun}}
                              </option>
                              @endforeach
                            </select>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            Terikat Kontrak
                          </td>
                          <td>
                            <select class="form-control kontrak" disabled="" name="kontrak">
                              <option value="{{$sup->kontrak}}" selected="">
                                {{$sup->kontrak}}
                              </option>

                              @if($sup->kontrak == 'YA')
                                <option value="TIDAK">
                                  TIDAK
                                </option>
                              @else
                                <option value="YA">
                                YA
                                </option>
                              @endif
                            </select>
                           </td>
                        </tr>

                        @if($sup->kontrak == 'YA')

                        <tr class="nokontrak2">
                          <td>
                            No Kontrak </td> <td> <input type="text" id="nokontrak" class="form-control nokontrak" readonly="" value="{{$sup->no_kontrak}}" name="no_kontrak" required="">
                          </td>
                        </tr>
                        @endif

                        <tr>
                          <td> <div class="nokontrak"> </div> </td>
                        </tr>
                       </table>

                       </div>
                       </div> <!--endrow-->

                     

                       <div class="col-xs-6">
                            <table class="table">
                            <tr>
                            <td> <b> Apakah Supplier ini termasuk PKP ? </b> </td>
                            <td> @if($sup->namapajak != '')
                                  <select class="form-control pkp ubah" name="pkp" readonly=""><option value="Y" selected=""> Ya </option>  <option value="T"> Tidak </option> </select>
                                  @else 
                                      <select class="form-control pkp" name="pkp"><option value="Y" selected=""> Ya </option>  <option value="T" selected=""> Tidak </option> </select>    
                                 @endif
                             </td>
                          </tr>   
                            </table>
                       </div>

                          

                      <div class="col-xs-10" class="pajak">
                        <hr>
                        <b>  Informasi Pajak Supplier </b>
                         <hr>
                          <table border="0" class="table">

                          
                          <tr>
                            <td class="pajak"> NO NPWP </td>
                            <td>
                                <input type="text" class="form-control npwp input-sm pajak isipajak" name="npwp" value="{{$sup->pajak_npwp}}" readonly="">
                            </td>
                          </tr>

                          <tr>
                            <td> NIK </td>
                            <td>  <input type="text" class="form-control" value="{{$sup->nik}}"></td>
                          </tr>


                          <tr>
                            <td class="pajak"> Nama </td>
                            <td> <input type="text" class="form-control input-sm pajak isipajak" name="namapajak" value="{{$sup->namapajak}}"> </td>
                          </tr>

                          <tr>
                            <td class="pajak"> Telepon </td>
                            <td> <input type="number" class="form-control input-sm pajak isipajak" name="telppajak" value="{{$sup->telppajak}}"></td>
                          
                          </tr>

                          <tr>
                             <td class="pajak"> Alamat </td>
                            <td> <input type="text" class="form-control input-sm pajak isipajak" name="alamatpajak" value="{{$sup->alamatpajak}}"></td>
                          
                          </tr>

                         
                          
                           <tr>                           
                            <td>
                              <div class="editkontrak"> </div>
                            </td>
                          </tr>

                         
                           <tr>                           
                           
                            </tr>
                          </table>
                     @endforeach
                      </div>

                      

                        <div class="col-xs-12">
                            <th> <button class="btn btn-sm btn-info edit" type="button"> <i class="fa fa-pencil"> </i> Edit  </button> </th>
                        
						
						
						
                          <br>
                          @if($data['countitem'] > 0)      
                            <table class="table" border=0>  
                                <tr>
                                  <th style="width:250px">  Data Barang Supplier </th>
                                <!--   <th> <button class="btn btn-success edit" type="button"> Edit Data Barang ?  </button> </th> -->
                                </tr>

                            </table> 
                       
                          <table border="0">
                          <tr>
                              <td> <div class="btn-addbrg"> </div> </td>
                          </tr>
                          </table>

                         
                          <table class='table table-stripped table-bordered' id="addColumn">
                           
                            <tr>
                              <th style="width:50px"> No </th>
                              <th style="width:250px"> Barang </th>
                              <th> Harga </th>
                              <th> Update Stock </th>
                              <th> </th>
                            </tr>

                            @foreach($data['item_supplier'] as $index=>$item)
                            <tr id="dataitem item-{{$index}}" class="dataitem item-{{$index}}"> 
                              <td> {{$index + 1}} <input type="hidden" name="iditemsup[]" value="{{$item->is_id}}"> </td>
                              <td> 
                              <select class="form-control brg tablebarang" disabled="" name="brg[]">
                               @foreach($data['barang'] as $brg) 
                                 <option value="{{$brg->kode_item}}" @if($item->is_kodeitem == $brg->kode_item) selected="" @endif>  {{$brg->nama_masteritem}} </option>
                                @endforeach
                              </select>

                              </td>
                              <td> <input type="text" class="form-control hrg harga{{$index}} tablebarang" value=" {{number_format($item->is_harga, 2)}}" readonly="" name="harga[]"> </td>

                              <td> <select class="form-control tablebarang" name="updatestock[]"> <option value="Y"> Ya </option> <option value="T"> Tidak </option> </select> </td>
                              <td> <a class="btn btn-danger removes-btn" data-id="{{$index}}"> <i class="fa fa-trash"> </i> </a> </td>
                            </tr>
                            @endforeach
            					            </table>
						  
						            @else
						              <div class="tablebarang">
                              <td> <div class="btn-addbrg"> </div> </td>
                              <table class='table table-stripped table-bordered' id="addColumn">                          
                                <tr>
                                  <th style="width:50px"> No </th>
                                  <th style="width:250px"> Barang </th>
                                  <th> Harga </th>
                                  <th> Update Stock </th>
                                  <th> </th>
                                </tr>
                              </table>
                          </div>
						  
                          @endif
                         
                        </div>

                        <div class="tambahbarang"> </div>

                    </div> <!--boxbody-->
        

                <div class="box-footer">
                  <div class="pull-right">
                        <div class="simpandata"> </div>   
                         
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

    $('.simpandata').click(function(){
      
      var tr = $('tr.dataitem').length;
     // alert(tr);
      kontrak = $('.kontrak').val();
      pkp = $('.pkp').val();
     
      temppkp = 0;
      if(kontrak == 'YA'){
      //       RRRZ(kontrak);
              if(tr == 0){
                alert(tr);
        toastr.info('jenis Supplier adalah Kontrak, Mohon Tambah Data Barang :) ');
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

    pkp = $('.pkp').val();
    if(pkp == 'Y'){
        $('.pajak').show();
    }
    else {
        $('.pajak').hide();
    }

     $('.pkp').change(function(){
      val = $(this).val();
      if(val == 'T'){
        $('.pajak').hide();
      }
      else {
        $('.pajak').show();
      }
    })


//EDIT DATA
$(function(){
  $('.edit').click(function(){
    $('.namasupplier').attr('readonly' , false);
    $('.alamat').attr('readonly' , false);
    $('.provinsi').attr('readonly' , false);
    $('.kota').attr('readonly' , false);
    $('.kodepos').attr('readonly' , false);
    $('.notelp').attr('readonly' , false);
    $('.cp').attr('readonly' , false);
    $('.syaratkredit').attr('readonly' , false);
    $('.plafonkredit').attr('readonly' , false);
    $('.matauang').attr('readonly' , false);
    $('.npwp').attr('readonly' , false);
    $('.acchutangdagang').attr('readonly' , false);
    $('.kontrak').attr('disabled' , false);
    $('.nokontrak').attr('readonly' , false);
    $('.seripajak').attr('readonly' , false);
    $('#pajak_26').attr('disabled' , false);
    $('#pajak_pph').attr('disabled' , false);
    $('#pajak_ppn').attr('disabled' , false);
    $('.brg').attr('disabled' , false);
    $('.hrg').attr('readonly' , false);
    $('#idcabang').attr('disabled', false);
    $('.ubah').attr('readonly' , false);
    $('.ubah').attr('disabled' , false);
    $('.acc_hutangdagang').attr('disabled' , false);
    $('.acc_csf').attr('disabled' , false);




    var rowBtn = '<button  id="tmbh_data_barang" type="button" class="btn btn-sm btn-success tmbhdatabarang"> <i class="fa fa-plus"> </i> &nbsp; Tambah Data Barang </button>';

    $('.btn-addbrg').html(rowBtn);

    var rowdelete = '<input type="submit" id="submit" name="submit" value="PERBARUI" class="btn btn-success">';

    $('.simpandata').html(rowdelete);
    
      $notable = $('tr#dataitem').length;
     $no = $notable + 1;
    $('#tmbh_data_barang').click(function(){
                     
    $no++;

    var rowBrg = "<tr id='dataitem item-"+$no+"' class='dataitem item-"+$no+"'>" +
                  "<td> <b>" + $no +"</b> <input type='hidden' value='databarang' name='databarang[]'> </td>" +               
                  "<td> <select class='form-control' name='brg[]'>  @foreach($data['item'] as $item) <option value={{$item->kode_item}}> {{$item->nama_masteritem}} </option> @endforeach </select>" +
                   "<td> <input type='text' class='form-control  hrg"+$no+"' id='harga' name='harga[]' data-id='"+$no+"'> </td>" +
                   "<td> <select class='form-control' name='updatestock[]'> <option value='Y'> Ya </option> <option value='T'> Tidak </option> </select> </td>" +
                  "<td> <a class='btn btn-danger removes-btn' data-id='"+ $no +"'> <i class='fa fa-trash'> </i>  </a>"+$no+"</td>" +
                  "</tr>";   

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
    //      alert('hei')
              var id = $(this).data('id');
    
              var parent = $('.item-'+id);

             parent.remove();
          })


    })

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


   $notable = $('tr#dataitem').length;
     $no = $notable + 1;
    $('#tmbh_data_barang').click(function(){
                     
    $no++;

    var rowBrg = "<tr id='dataitem item-"+$no+"' class='item-"+$no+"'>" +
                  "<td> <b>" + $no +"</b> <input type='hidden' value='databarang' name='databarang[]'> </td>" +               
                  "<td> <select class='form-control' name='brg[]'>  @foreach($data['item'] as $item) <option value={{$item->kode_item}}> {{$item->nama_masteritem}} </option> @endforeach </select>" +
                   "<td> <input type='text' class='form-control  hrg"+$no+"' id='harga' name='harga[]' data-id='"+$no+"'> </td>" +
                   "<td> <select class='form-control' name='updatestock[]'> <option value='Y'> Ya </option> <option value='T'> Tidak </option> </select> </td>" +
                  "<td> <a class='btn btn-danger removes-btn' data-id='"+ $no +"'> <i class='fa fa-trash'> </i>  </a></td>" +
                  "</tr>";   

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
    //      alert('hei')
              var id = $(this).data('id');
    
              var parent = $('.item-'+id);

             parent.remove();
          })


    })

    $('.plafonkredit').change(function(){
       val = $(this).val();
       val = accounting.formatMoney(val, "", 2, ",",'.');
       $(this).val(val);
    })

   $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
             // alert(id);
              var parent = $('.item-'+id);
             parent.remove();
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

  $('.hrg').each(function(){
      $(this).change(function(){
        var val = $(this).val();
        var $this = $(this);
          numhar = Math.round(val).toFixed(2);
          $this.val(addCommas(numhar));

      })
  })

$('.acc_hutangdagang').change(function(){
  val = $(this).val();
  $('.acchutangdagang').val(val)
})

$('.acc_csf').change(function(){
  val  = $(this).val();
  $('.acccsf').val(val);
})

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


    /* cabang = $('.cabang').val();
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
     })*/



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
        })

  

     
        $('.kontrak').change(function(){
            var data = $(this).val();
            var id = $(this).data('id');
          //  console.log(data);
            if(data == "YA") {
                var rowContract = '<div class="form-group"> <label class="col-sm-1"> No </label> <div class="col-sm-10"> <input type="text" class="form-control" name="nokontrak" required=""> </div> </div>';
                $('.nokontrak').html(rowContract);   
                $('.tmbhdatabarang').attr('disabled' , false);
                $('.tablebarang').show();
                
           

               

            }
            else {
              $('.nokontrak').empty();
              $('.nokontrak2').empty();
               $('.tmbhdatabarang').attr('disabled' , true);
               $('.tablebarang').hide();
               $('#addColumn').attr('disabled' , true);
              
            }
        })

       
                   

        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


  var nokontrak = $('#nokontrak').val();
  console.log('nokontrak' + nokontrak);


//$('.tablebarang').hide();
   var row= "<input type='hidden' name='iskontrak' value='tdkeditkontrak' >";
     $('.editkontrak').html(row);

  $('#nokontrak:input').change(function(){
     var changenokontrak = $(this).val();

    if(nokontrak == changenokontrak){

      var row= "<input type='text' name='iskontrak' value='tdkeditkontrak' >";
     $('.editkontrak').html(row);

    }
    else {
        var row= "<input type='text' name='iskontrak' value='editkontrak' >";
       $('.editkontrak').html(row);
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


      $(".acc_hutangdagang").chosen(config);
      $(".acc_csf").chosen(config);
      //$('.cabang').chosen(config);
      $('.kota').chosen(config);
    })
     },2000);
 
</script>
@endsection
