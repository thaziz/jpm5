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
                        <a class="btn btn-danger" href="{{url('mastersupplier/mastersupplier')}}"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali </a>
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
                                <input type="hidden" class="form-control" name="idsupplier" value="{{$sup->idsup}}" readonly="">
                                <td width="200px">
                                  Kode Supplier
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="nosupplier" value="{{$sup->no_supplier}}" readonly="">
                                </td>
                                </tr>


                                <tr>
                                  <td>
                                  Nama Supplier
                                  </td>
                                  <td width="400px">
                                     <input type="text" class="form-control namasupplier" name="nama_supplier" value="{{$sup->nama_supplier}}" readonly="">
                                  </td>
                              </tr>

                          <tr>
                            <td> Alamat </td>
                            <td>
                              <input type="text" class="form-control alamat" name="alamat" value="{{$sup->alamat}}" readonly=""> 
                            </td>
                          </tr>
                          
                          <tr>
                            <td> 
                              Pengajuan dari Cabang
                            </td>
                            <td>
                              <select class="chosen-select-width" name="idcabang" >
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
                              <select class="chosen-select-width" name="provinsi">
                              @foreach($data['provinsi'] as $provinsi)
                                      <option value="{{$provinsi->id}}" @if($provinsi->id == $sup->propinsi) selected="" @endif> {{$provinsi->nama}} </option> 
                              @endforeach
                              </select>

                             
                            </td>
                          </tr>

                           <tr>
                            <td> Kota </td>
                            <td>
                               <select class="form-control kota" name="kota">
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
                              <input type="text" class="form-control kodepos" name="kodepos" value="{{$sup->kodepos}}" readonly="">
                            </td>
                          </tr>


                          <tr>
                            <td>
                              No Telp / Fax
                            </td>
                            <td>
                               <input type="text" class="form-control notelp" name="notelp" value="{{$sup->telp}}" readonly="">
                            </td>
                          </tr>


                          <tr>
                            <td>  
                              Status Setuju
                            </td>

                            <td>
                                <span class="label label-info"> {{$sup->status}} </span>
                            </td>
                          </tr>
                      </table>                          
                     </div>

                    <div class="col-xs-6">
                      <table border="0" class="table">
                        <tr>
                          <td width="200px">
                             Contact Person
                          </td>
                          <td width="300px">
                            <input type="number" class="form-control cp" name="cp" value="{{$sup->contact_person}}" readonly="">
                          </td>
                        </tr>

                         <tr>
                          <td width="200px">
                             Nama Contact Person
                          </td>
                          <td width="300px">
                            <input type="text" class="form-control nm_cp" name="nm_cp" value="{{$sup->nama_cp}}" readonly="">
                          </td>
                        </tr>

                        <tr>
                          <td>   Syarat Kredit  </td>
                          <td>
                             <input type="text" class="form-control syaratkredit" name="syarat_kredit" value="{{$sup->syarat_kredit}}" readonly="">
                          </td>
                        </tr>


                         <tr>
                          <td> Plafon Kredit </td>
                           <td>
                             <input type="text" class="form-control plafonkredit" name="plafon_kredit" value="{{$sup->plafon}}" readonly="">
                          </td>
                        </tr>


                         <tr>
                          <td> Mata Uang </td>
                          <td>
                                <input type="text" class="form-control matauang" name="matauang" value="{{$sup->currency}}" readonly="">
                          </td>
                        </tr>


                        <tr>
                          <td> NO NPWP </td>
                          <td>
                              <input type="text" class="form-control npwp" name="npwp" value="{{$sup->pajak_npwp}}" readonly="">
                          </td>
                        </tr>


                        <tr>
                          <td>
                            Acc Hutang Dagang
                          </td>
                          <td> <input type="text" class="form-control acchutangdagang" name="acchutangdagang" readonly="" value="{{$sup->acc_hutang}}"> </td>
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

                     

                      <div class="col-xs-12">
                        <hr>
                        <b>  Informasi Pajak Supplier </b>
                       <hr>
                        <table border="0" class="table">
                          <tr>
                            <td width="200px">
                               No Seri Pajak Supplier 
                            </td>
                            <td>
                                 <input type="text" class="form-control seripajak" name="noseri" value="{{$sup->noseri_pajak}}" readonly="">
                               
                          
                                 <td>  <div class='checkbox checkbox-info checkbox-circle'>
                                  @if($sup->ppn != '') 
                                  <input id='pajak_ppn' type='checkbox' name='pajak_ppn' checked="" disabled="">
                                  @else 
                                   <input id='pajak_ppn' type='checkbox' name='pajak_ppn'>
                                   @endif
                                    <label for='pajak_ppn'>
                                      PPn Masukan
                                    </label>
                                </div> </td>
                            
                             

                             
                                 <td> 
                                  <div class="checkbox checkbox-info checkbox-circle">
                                    @if($sup->pph23 != '') 
                                     <input id="pajak_pph" type="checkbox" name="pajak_pph" checked="" disabled="">
                                    @else
                                      <input id="pajak_pph" type="checkbox" name="pajak_pph" disabled="">
                                    @endif
                                    <label for="pajak_pph">
                                      PPh Pasal 23
                                    </label>
                                </div>

                                <td>
                                <div class="checkbox checkbox-info checkbox-circle">
                                   @if($sup->pph26 != '')
                                  <input id="pajak_26" type="checkbox" name="pajak_26" checked="" disabled="">
                                  @else
                                   <input id="pajak_26" type="checkbox" name="pajak_26"  disabled="">
                                  @endif
                                    <label for="pajak_26">
                                      PPh Pasal 26
                                    </label>
                                </div>

                                </td>
                          
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
                            <th> <button class="btn btn-success edit" type="button"> Edit Data Barang ?  </button> </th>
                        
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
                            <tr id="item-{{$index}}"> 
                              <td> {{$index + 1}} <input type="hidden" name="iditemsup[]" value="{{$item->is_id}}"> </td>
                              <td> 
                              <select class="form-control brg" disabled="" name="brg[]">
                               @foreach($data['barang'] as $brg) 
                                 <option value="{{$brg->kode_item}}" @if($item->is_kodeitem == $brg->kode_item) selected="" @endif>  {{$brg->nama_masteritem}} </option>
                                @endforeach
                              </select>

                              </td>
                              <td> <input type="text" class="form-control hrg harga{{$index}}" value=" {{number_format($item->is_harga, 2)}}" readonly="" name="harga[]"> </td>

                              <td> <select class="form-control"> <option value="Y"> Ya </option> <option value="T"> Tidak </option> </select> </td>
                              <td> <a class="btn btn-danger removes-btn" data-id="{{$index}}"> <i class="fa fa-trash"> </i>  </a> </td>
                            </tr>
                            @endforeach
                          </table>
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

    var rowBtn = '<button id="tmbh_data_barang" type="button" class="btn btn-success"> Tambah Data Barang </button>';

    $('.btn-addbrg').html(rowBtn);

    var rowdelete = '<input type="submit" id="submit" name="submit" value="PERBARUI" class="btn btn-success">';

    $('.simpandata').html(rowdelete);


      $no = 0;
    $('#tmbh_data_barang').click(function(){
      $no++;

      var rowBrg = '<tr id=item-'+$no+'>' +
                    '<td> <b>' + $no +' </b> </td>' +               
                    '<td> <select class="form-control" name="brg[]">  @foreach($data['barang'] as $item) <option value="{{$item->kode_item}}"> {{$item->nama_masteritem}} </option> @endforeach </select>' +
                     '<td> <input type="text" class="form-control  hrg'+$no+'" id="harga" name="harga[]" data-id="'+$no+'"> </td>'+
                    '<td> <a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td>' +
                    ' </tr>';

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

  })
})

  //hapus
   $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
              alert(id);
              var parent = $('#item-'+id);
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



     
        $('.kontrak').change(function(){
            var data = $(this).val();
            var id = $(this).data('id');
          //  console.log(data);
            if(data == "YA") {
                var rowContract = '<div class="form-group"> <label class="col-sm-1"> No </label> <div class="col-sm-10"> <input type="text" class="form-control" name="nokontrak" required=""> </div> </div>';
                $('.nokontrak').html(rowContract);   


                rowBarang = "<div class='col-xs-12'>" +
                           "<hr>" +
                          "<h4> Data Barang </h4>" +
                          "<hr>" +
                          "<button id='tmbh_data_barang' type='button' class='btn btn-success'> Tambah Data Barang </button>" +
                          "<table class='table table-bordered table-striped tbl-item' id='addColumn'> " +
                          "<tr id='header-column'>" +
                              "<th> No </th>" +
                              "<th> Barang </th>" +
                              "<th> Harga </th>" +
                              "<th> Update Stock </th>" +
                              "<th> </th>"
                          
                              "<th> </th>" +
                            "</tr>" +
                          "</table>" +
                         "</div>";
                $('.tambahbarang').html(rowBarang);

                  $no = 0;
                  $('#tmbh_data_barang').click(function(){
                     
                    $no++;

                    var rowBrg = "<tr id=item-"+$no+">" +
                                  "<td> <b>" + $no +"</b> <input type='hidden' value='databarang' name='databarang[]'> </td>" +               
                                  "<td> <select class='form-control' name='brg[]'>  @foreach($data['item'] as $item) <option value={{$item->kode_item}}> {{$item->nama_masteritem}} </option> @endforeach </select>" +
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

            }
            else {
              $('.nokontrak').empty();
              $('.nokontrak2').empty();
            }
        })

    


  var nokontrak = $('#nokontrak').val();
  console.log('nokontrak' + nokontrak);

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

 
</script>
@endsection
