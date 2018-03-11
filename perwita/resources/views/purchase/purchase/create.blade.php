@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pembelian Order </h2>
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
                            <strong> Tambah Data Pembelian Order </strong>
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
                    <h5> Pembelian Order
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                       
                    </div>
                </div>

                <form method="post" action="{{url('purchaseorder/savepurchase')}}"  enctype="multipart/form-data" class="form-horizontal">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              



              <div class="box" id="seragam_box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-2">



                         <select class="form-control cabang" name="cabang">
                            <option value=""> Pilih Data Cabang </option>
                            @foreach($data['cabang'] as $cabang)
                            <option value="{{$cabang->kode}}"> {{$cabang->nama}} </option>
                            @endforeach
                        </select>
                        
                        </div>

                    <div class="col-sm-4">
                    <button type="button" class="btn btn-primary" id="createmodal" data-toggle="modal" data-target="#myModal5">
                        Tambah Data SPP
                    </button>  
                    </div>
                    </div>
                    <br>
                    <br>
                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row">
                        <div class="col-md-8">
                           <div class="tablespp"> </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="judul-spp"> </div> 
                             <div class="pull-right">
                         <div class="simpan"> </div>
                    </div>

                        </div>
                    </div>
                    
                   
                    <div class="pull-right">
                       
                    </div>

                </div><!-- /.box-body -->

                <!-- modal create SPP -->
                <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     
                      <h4 class="modal-title">Tambah Data SPP </h4>
                         <small class="font-bold">Tambahkan Data SPP sesuai dengan supplier yang sama </small>
                     </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                        <table id="addColumn" class="table table-bordered table-striped tbl-purchase" id="tbl-spp">
                          <thead>
                           <tr>
                              <th style="width:10px">No</th>
                              <th> No SPP   </th>
                              <th> Tanggal di Butuhkan</th>
                              <th> Supplier </th>
                              <th> Cabang Pemohon </th>
                              <th> Tipe </th>
                              <th> Keperluan </th>                           
                              <th> Aksi </th>      
                          </tr>
                          </thead>
                          
                        </table>
                        </div>
                        </form>
                    </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div>
                <div class="box-footer">
                      <div class="pull-right">
                   
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

    tableDetail = $('.tbl-purchase').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    

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

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        })

    $('.cabang').change(function(){
      val = $(this).val();
      $.ajax({
        url : baseUrl + '/purchaseorder/getcabang',
        data : {val},
        dataType : "json",
        type : "post",
        success : function (response){
              //tambah data ke table data po
              console.log(response.spp.length);
            var tableSPP = $('.tbl-purchase').DataTable();
            tableSPP.clear().draw();
            var n = 1;
            for(var i = 0; i < response.spp.length; i++){   
                 
                var html2 = "<tr> <td>"+ n +" </td>" +
                                "<td>"+response.spp[i].spp_nospp+"</td>" +
                                "<td>"+response.spp[i].spp_tgldibutuhkan+"</td>" +
                                "<td>"+response.spp[i].nama_supplier+"</td>"+
                                "<td>"+response.spp[i].spp_cabang+"</td>"+
                                "<td>"+response.spp[i].spp_tipe+"</td>" +
                                "<td>"+response.spp[i].spp_keperluan+"</td>" +
                                "<td> <div class='checkbox'> <input type='checkbox' id='"+response.spp[i].co_idspp+","+response.spp[i].idsup+","+response.spp[i].spp_lokasigudang+","+response.spp[i].spp_cabang+","+response.spp[i].spp_penerimaan+"' class='check' value='option1' aria-label='Single checkbox One'> <label> </label>"+
                                "</div>"+
                                "</td>";
                                    
                                  
                              html2 += "</tr>";

               tableSPP.rows.add($(html2)).draw();
               n++;
            }
        }
      })
    })

    $('#buttongetid').click(function(){
      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();
        


       var url = baseUrl + '/purchaseorder/ajax_tampilspp';
       var idspp = [];
       var idspp = checked;
      
      console.log(idspp);

       console.log(idspp);
      
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var supplier = [];
        var cabang = [];
        var gudang = [];
        var penerimaan = [];
        for(var i=0 ; i< idspp.length; i++) {
           
             string = idspp[i].split(",");
             idsupplier = string[1];
             supplier.push(idsupplier);
             idcabang = string[3];
             cabang.push(idcabang);
             idgudang = string[2];
             gudang.push(idgudang);
             idpenerimaan = string[4];
             penerimaan.push(idpenerimaan);           
        } 

      
     
      //penerimaan
      var uniquePenerimaan = [];
      for(ds = 0; ds < penerimaan.length; ds++){
        if(uniquePenerimaan.indexOf(penerimaan[ds]) === -1){
          uniquePenerimaan.push(penerimaan[ds]);
        }
      }

    
       //supplier 
       var uniqueNames = [];
       for(i = 0; i< supplier.length; i++){    
          if(uniqueNames.indexOf(supplier[i]) === -1){
              uniqueNames.push(supplier[i]);        
          }        
        }

     

        //cabang
      var uniqueCabang = [];
      for(var j=0;j<cabang.length;j++){
        if(uniqueCabang.indexOf(cabang[j]) === -1){
              uniqueCabang.push(cabang[j]);        
          }
      }

      var uniqueGudang = [];
      for(var j=0;j<gudang.length;j++){
        if(uniqueGudang.indexOf(gudang[j]) === -1){
              uniqueGudang.push(gudang[j]);        
          }
      }      

       if(uniqueNames.length < 2 && uniqueGudang.length < 2 && uniqueCabang.length < 2 && uniquePenerimaan.length < 2 ) {
          $('#myModal5').modal('hide');
        $.ajax({    
          type :"get",
          data : {idspp},
          url : url,
          dataType:'json',
          success : function(response){
          cabang = $('.cabang').val();
          var simpan ='<br> <button class="btn btn-success save" type="submit" > Simpan </button> </form>';

         $('.simpan').html(simpan);

          $('.table-spp').empty();    
       
          var totalharga = [];
          var angka = 0 ;
          for(var i=0 ; i< response.spp.length; i++) {
             var value =  response.spp[i][0].cotb_totalbiaya;
             harga = value.replace(/,/g, '');
            angka = angka + parseInt(harga);

          }

         var judul = '<table class="table" > <tr> <td style="width:100px"> <h2> SUPPLIER </h2> </td> <td style="width:20px"> : </td> <td> <h2> '+response.spp[0][0].nama_supplier+' </h2>  </td> <input type="hidden" value='+response.spp[0][0].idsup+' name="idsupplier"> <input type="hidden" name="nosupplier" value='+response.spp[0][0].idsup+'> </tr>' + //namasupplier

                    '<tr> <td> Jatuh Tempo </td> <td> : </td>  <td>  <div class="col-sm-8"> <input type="number" class="form-control bayar" name="bayar" value="'+response.spp[0][0].spptb_bayar+'"> </div> <label class="col-sm-2 col-sm-2 control-label"> Hari </label> </div>' + // jangka waktu pembayaran

                    '<input type="hidden" value="'+response.spp[0][0].spp_penerimaan+'" name="spp_penerimaan"> </td> </tr>  </tr>' +
                    '<tr> <td> Catatan </td>  <td> : </td> <td> <div class="col-md-12"> <input type="text" class="form-control" name="catatan" required=""> </div> </td> </tr>' +

                    '<tr> <td> Sub Total </td> <td> : </td> <td>  <label class="col-sm-1 col-sm-1 control-label"> Rp </label> <div class="col-md-8"> <input type="text" class="form-control subtotal" readonly="" name="subtotal" style="text-align:right"> </div> </td>  </tr>' + // subtotal

                  /*  '<tr> <td> Discount </td> <td> : </td> <td> <div class="row"><div class="col-md-4"> <input type="text" class="form-control disc" name="diskon"> </div> <label class="col-md-3"> % </label> <div class="col-md-5">   <input type="text" style="text-align:right" class="form-control hsldiskon" readonly>   </div> </td> </tr>' + //diskon*/

                    '<tr> <td> Jenis PPn </td> <td> : </td> <td> <select class="form-control jenisppn" name="jenisppn">  <option value="T"> Tanpa </option> <option value="E"> Exclude </option> <option value="I"> Include </option> </select> </td> </tr>' + //jenisppn

                    '<tr> <td> PPn </td> <td> : </td> <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control ppn" name="ppn"> </div> <label class="col-md-3"> % </label> <div class="col-md-5">   <input type="text" style="text-align:right" class="form-control hargappn" readonly>   </div> </div> </td> </tr>' + //ppn

                    '<tr> <td> Total </td> <td> : </td> <td> <label class="col-md-1"> Rp </label> <div class="col-md-8"> <input type="text" class="form-control total" readonly="" name="total" style="text-align:right">  </div> </td> </tr> </table>'; //total

               
                      //jangka waktu pembayaran;
         $('.judul-spp').html(judul);

           numhar = Math.round(angka).toFixed(2);
       
         /* $('.subtotal').val(addCommas(numhar));*/

         

            var nosup = 1;
            var totalperitem = 0;
          //tampil-spp

          $('.tablespp').empty();
           /*'<tr> <td> &nbsp; </td> </tr> <tr> <td> <h3 style="color:red"> Data SPP </h3> </td> </tr> </table> </div>';*/
         for(var i=0 ; i< response.spp.length; i++) {
          
          var angka = 1 + i;
            var rowTable = '<div class="table-resposive"> <table class="table" border="0">' +
            '<tr> <th style="width:210px"> No SPP </th> <th style="width:20px"> : </th> <th> '+response.spp[i][0].spp_nospp+' </th> <input type="hidden" value='+response.spp[i][0].cotb_id+' name="idcotbsetuju[]">  </tr>' +
            '<tr> <th>  Keperluan  </th> <th> : </th> <td>'+response.spp[i][0].spp_keperluan+'</td> </tr>' +
            '<tr> <th>  Tgl di Butuhkan </th> <th> : </th> <td>'+response.spp[i][0].spp_tgldibutuhkan+'</td> </tr>' +
            '<tr> <th> Pembayaran </th> <td> : </td> <td> '+response.spp[i][0].spptb_bayar+' hari </td> </tr>' +
            '<tr> <th> Total Biaya di Perlukan </th> <th> : </th><th> Rp '+ addCommas(response.spp[i][0].cotb_totalbiaya) +'</th> </tr>' +
            '<tr> <th> Cabang Pemohon </th> <th> :  </th> <td>'+response.spp[i][0].nama  +'</td> </tr> </div>';

            if(response.spp[i][0].mg_namagudang == undefined) {

            }
            else {
              
              rowTable += '<tr> <th> Lokasi Gudang </th> <td> : </td> <td>'+ response.spp[i][0].mg_namagudang +'</td>' +
              '</tr>';            
            }

            
           var button = '<tr> <td> &nbsp; </td> </tr><tr> <th> <button class="btn btn-primary edit"> Edit Data </button> </th> </tr>';

            rowTable += '<table class="table table-bordered">' +
                    '<thead>' +
                     '<tr>' +
                        '<th style="width:10px">NO</th>' +
                        '<th style="width:130px"> Nama Barang </th>' +
                        '<th style="width:80px"> Jumlah disetujui </th>' +
                        '<th style="width:80px"> Jumlah dikirim </th>' +
                        '<th style="width:130px"> Harga Per Item </th>' +
                        '<th style="width:130px"> Total Harga</th>' +
                        '<th style="width:200px"> Dikirim Ke </th>' +      
                    '</tr>' +
                   
                    '</thead>' +
                    '<tbody>'; 
          
          for(var j=0; j < response.codt[i].length; j++){
                    no = 1 + j;
              
                  
               rowTable += 
                        '<tr>' +
                        '<td > '+no+' <input type="hidden" value='+response.codt[i][j].kode_item+' name="kodeitem[]"> <input type="hidden" value=' +response.codt[i][j].codt_qtyapproved+' name="qtyapproved[]">  <input type="hidden" value='+response.spp[i][0].spp_id+' name="idspp[]"> </td>' +

                        '<td> ' +response.codt[i][j].nama_masteritem+' </td>' + //namamasteritem

                        '<td> ' +response.codt[i][j].codt_qtyapproved+' </td>' + //approval
                       
                        '<td> <input type="number" class="form-control qtykirim" id="qtykirim'+nosup+'" name="qtykirim[]" data-id='+nosup+' required value=' +response.codt[i][j].codt_qtyapproved+' > <input type="hidden" class="qtyapproved'+nosup+'" value=' +response.codt[i][j].codt_qtyapproved+' data-id='+nosup+' name="qtyapproval[]" > <input type="hidden" class="status'+nosup+'" name="status[]"> <input type="hidden" value='+response.codt[i][j].spp_tipe+' name="spptipe"> </td>' + //jumlahdikirim

                        '<td > <input type="text" class="form-control harga harga'+nosup+'" value='+ addCommas(response.codt[i][j].codt_harga)+' data-id='+nosup+' name="harga[]"></td>' + //harga

                        '<td> <input type="text" class="form-control totalharga2 totalharga2'+nosup+'" readonly="" name="totalharga[]" data-id='+nosup+'>  </td>' +

                        '<td > <select class="form-control gudang" name="lokasikirim[]">  @foreach($data['gudang'] as $gdg) <option value="{{$gdg->mg_id}}"> {{$gdg->mg_namagudang}}</option> @endforeach </select></td>' + //cabang
                     '<tr>';
                       nosup++;
                    
           }          
              rowTable +=        '</tbody>' +
                      '</table>';

                      $('.tablespp').append(rowTable);

                    
                      for(var k = 0; k < response.gudang.length; k++){
                          if(response.gudang[k].mg_cabang == cabang){
                              $('.gudang').val(response.gudang[k].mg_id );
                              console.log('gudang');                        
                          }
                      }


                      

                      //totalharga otomatis
                        hrgtotal = 0;
                       $('.totalharga2').each(function(){

                          var id = $(this).data('id');
                          var qty = $('#qtykirim'+id).val();
                         

                          var harga = $('.harga'+id).val();
                          hslhrg = harga.replace(/,/g, '');
                          totalharga = parseFloat(qty * hslhrg);
                          hsltotalharga = totalharga.toFixed(2);
                          console.log(hsltotalharga);
                          console.log(totalharga);
                          console.log(harga);
                          console.log(id);
                          console.log(qty);
                          $('.totalharga2' + id).val(addCommas(hsltotalharga));  

                           total = $(this).val();
                            
                         
                          console.log(total);
                          hasiltotal = total.replace(/,/g, '');
                          
                          hrgtotal = hrgtotal + parseInt(hasiltotal);
                          hasilhrgtotal = hrgtotal.toFixed(2);
                          $('.subtotal').val(addCommas(hasilhrgtotal));
                          $('.total').val(addCommas(hasilhrgtotal));
                             /* diskon = $('.hsldiskon').val();
                               hsldiskon = diskon.replace(/,/g, '');*/
                               ppn = $('.hargappn').val();
                               hslppn = ppn.replace(/,/g, '');
                               hsltotal = hrgtotal.toFixed(2);
                              
                              if(ppn != ''){
                              /*  if(diskon != '') {
                                  total = parseInt(hsltotal) + parseInt(hslppn) + parseInt(hsldiskon);
                                  console.log('total' + total);
                                  hasiltotal = total.toFixed(2);
                                  $('.total').val(addCommas(hasiltotal));
                                } 
                                else {*/
                                  total = parseInt(hsltotal) + parseInt(hslppn);
                                  console.log('total' + total);
                                  hasiltotal = total.toFixed(2);
                                  $('.total').val(addCommas(hasiltotal));
                                
                             }
                             /*else if(diskon != '') {
                                if(ppn != ''){
                                  total = parseInt(hsltotal) + parseInt(hslppn) + parseInt(hsldiskon);
                                  console.log('total' + total);
                                  hasiltotal = total.toFixed(2);
                                  $('.total').val(addCommas(hasiltotal));
                                }*/
                               /* else {
                                  console.log('1');
                                  total = parseInt(hsltotal) + parseInt(hsldiskon);
                                  console.log('hsltotal' + hsltotal);
                                  console.log('hsldiskon' + hsldiskon);
                                  console.log('total' + total);
                                  hasiltotal = total.toFixed(2);
                                  $('.total').val(addCommas(hasiltotal));
                                }
                             } */
                             else {
                          //    $('.subtotal').val(addCommas(hsltotal));
                             }
                           
                          })

                      //menghitung totalharga otomatis ketika di change
                      $('.qtykirim').change(function(){
                          var id = $(this).data('id');
                          var qty = $(this).val();
/*                          toastr.info(id);
*/
                          var harga = $('.harga'+id).val();
                          hslhrg = harga.replace(/,/g, '');
                          totalharga = parseFloat(qty * hslhrg);
                          hsltotalharga = totalharga.toFixed(2);

/*                          toastr.info(hsltotalharga);
*/                        $('.totalharga2' + id).val(addCommas(hsltotalharga));    

                            hrgtotal = 0;
                          $('.totalharga2').each(function(){
                              total = $(this).val();
                            
                                if (total == ''){

                                }
                                else {
                                console.log(total);
                                hasiltotal = total.replace(/,/g, '');
                                
                                hrgtotal = hrgtotal + parseInt(hasiltotal);
                                hasilhrgtotal = hrgtotal.toFixed(2);
                                $('.subtotal').val(addCommas(hasilhrgtotal));
                                $('.total').val(addCommas(hasilhrgtotal));
                                   /* diskon = $('.hsldiskon').val();
                                     hsldiskon = diskon.replace(/,/g, '');*/
                                     ppn = $('.hargappn').val();
                                     hslppn = ppn.replace(/,/g, '');
                                     hsltotal = hrgtotal.toFixed(2);
                                    
                                    if(ppn != ''){
                                     /* if(diskon != '') {
                                        total = parseInt(hsltotal) + parseInt(hslppn) + parseInt(hsldiskon);
                                        console.log('total' + total);
                                        hasiltotal = total.toFixed(2);
                                        $('.total').val(addCommas(hasiltotal));
                                      } 
                                      else {*/
                                        total = parseInt(hsltotal) + parseInt(hslppn);
                                        console.log('total' + total);
                                        hasiltotal = total.toFixed(2);
                                        $('.total').val(addCommas(hasiltotal));
                                      /*}*/
                                   }
                                  /* else if(diskon != '') {
                                      if(ppn != ''){
                                        total = parseInt(hsltotal) + parseInt(hslppn) + parseInt(hsldiskon);
                                        console.log('total' + total);
                                        hasiltotal = total.toFixed(2);
                                        $('.total').val(addCommas(hasiltotal));
                                      }
                                      else {
                                        console.log('1');
                                        total = parseInt(hsltotal) + parseInt(hsldiskon);
                                        console.log('hsltotal' + hsltotal);
                                        console.log('hsldiskon' + hsldiskon);
                                        console.log('total' + total);
                                        hasiltotal = total.toFixed(2);
                                        $('.total').val(addCommas(hasiltotal));
                                      }
                                   }*/
                                   else {
                                //    $('.subtotal').val(addCommas(hsltotal));
                                }
                              }
                          })

                      })


                        

                     

                  

                    hrgfinal = [];
                   /* $('.cek_tb').click(function(){
                       $('.save').attr('disabled' , false);
                        totalperitem = 0;
                       $('.totalharga2').each(function(){
/*                       
                        hrg = $(this).val();
                          if(hrg != ''){
                                hslhrg = hrg.replace(/,/g, '');
                                hrgfinal.push(hslhrg);
                                totalperitem = parseFloat(parseFloat(hslhrg) + totalperitem);
                          }
                         
                        })
                        
                       diskon = $('.hsldiskon').val();
                       hsldiskon = diskon.replace(/,/g, '');
                       ppn = $('.hargappn').val();
                       hslppn = ppn.replace(/,/g, '');
                       hsltotal = totalperitem.toFixed(2);
                       $('.subtotal').val(addCommas(hsltotal));
                       if(ppn != ''){
                         total = hsltotal + hslppn;
                          if(diskon != '') {
                            total = parseInt(hsltotal + hslppn + hsldiskon);
                            hasiltotal = total.toFixed(2);
                            $('.total').val(addCommas(hasiltotal));
                          } 
                          else {
                            hasiltotal = total.toFixed(2);
                            $('.total').val(addCommas(hasiltotal));
                          }
                       }
                       else if(diskon != '') {
                          if(ppn != ''){
                            total = parseInt(hsltotal + hslppn + hsldiskon);
                            hasiltotal = total.toFixed(2);
                            $('.total').val(addCommas(hasiltotal));
                          }
                          else {
                            total = parseInt(hsltotal + hsldiskon);
                            hasiltotal = total.toFixed(2);
                            $('.total').val(addCommas(hasiltotal));
                          }
                       }
                       else {
                    //    $('.subtotal').val(addCommas(hsltotal));
                      
                       }


                    })*/
                      
             }



              //diskon
           /*   $('.disc').change(function(){
                  $this = $(this).val();
                  subtotal =  $('.subtotal').val();
                  subharga = subtotal.replace(/,/g, '');
                  diskon = parseFloat($this * parseFloat(subharga) / 100);
                  diskon2 = diskon.toFixed(2);
                  $('.hsldiskon').val(addCommas(diskon2));  

                 /* angkappn = $('.ppn').val();
                  ppn = angkappn.replace(/,/g, '');
                  hargappn = parseFloat(ppn * parseFloat(subharga) / 100);*/

                 /* if(ppn == ''){
                    total = subharga - diskon;
                    numhar = (total).toFixed(2);

                    $('.total').val(addCommas(numhar));
                  }
                  else {
                    if(jenisppn == 'E'){
                      hargappn = parseFloat($this * parseFloat(subharga) / 100);
                      ppnhar = hargappn.toFixed(2);
                      $('.hargappn').val(addCommas(ppnhar));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon));
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));
                      console.log(numhar);
                    }
                    else if(jenisppn == 'I'){
                      hargappn = parseFloat(subharga * parseFloat(100) / 100 + $this );
                      hargappn2 = hargappn2.toFixed(2);
                      $('.hargappn').val(addCommas(hargappn2));
                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon)).toFixed(2);
                      $('.total').val(addCommas(total));
                    }
                    else if(jenisppn == 'T'){
                         hargappn = parseFloat($this * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                         total = parseFloat(subharga  - diskon).toFixed(2);
                        $('.total').val(addCommas(total));
                    }

                  /*  total = parseFloat(subharga - diskon + hargappn);
                    console.log(subharga-diskon);
                    console.log(hargappn);
                    numhar = total.toFixed(2);
                    $('.total').val(addCommas(numhar));
                  }
                 
              }) */

              $('.jenisppn').change(function(){
                  ppn = $('.ppn').val();
               
                  subtotal =  $('.subtotal').val();
                  subharga = subtotal.replace(/,/g, '');
                  //subharga = 40000;
                  jenisppn = $('.jenisppn').val();
  
                  if(ppn != ''){
                    if(jenisppn == 'E'){
                  //    $('.subtotal').
                      hargappn = parseFloat($this * parseFloat(subharga) / 100);
                      ppnhar = hargappn.toFixed(2);
                      $('.hargappn').val(addCommas(ppnhar));
                      total = parseFloat(parseFloat(subharga) + parseFloat(ppnhar));
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));
                     
                    }
                    else if(jenisppn == 'I'){
                  
                      hargadpp = parseFloat((parseFloat(subharga) * 100) / (100 + parseFloat(ppn))).toFixed(2) ; 
                  

                      $('.subtotal').val(addCommas(hargadpp));
                      subtotal = $('.subtotal').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(ppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hargappn').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                      $('.total').val(addCommas(total));
                    }
                    else if(jenisppn == 'T'){
                         hargappn = parseFloat($this * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                        $('.total').val(addCommas(subharga));
                    }
                  }
              })

              $('.ppn').change(function(){
                $this = $(this).val();
                subtotal =  $('.subtotal').val();
                subharga = subtotal.replace(/,/g, '');
                jenisppn = $('.jenisppn').val();
//                ppn = angkappn.replace(/,/g, '');
             


              /*  disc = $('.disc').val();
                diskon = (disc * parseInt(subharga)) / 100;*/
               
                console.log(jenisppn + 'jenisppn');
             
                    if(jenisppn == 'E'){
                      hargappn = parseFloat($this * parseFloat(subharga) / 100);
                      ppnhar = hargappn.toFixed(2);
                      $('.hargappn').val(addCommas(ppnhar));
                      total = parseFloat(parseFloat(subharga) + parseFloat(ppnhar));
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));
                     
                    }
                    else if(jenisppn == 'I'){
                      hargappn = parseFloat(subharga * parseFloat(100) / (100 + $this) );
                      hargappn2 = hargappn.toFixed(2);
                      $('.hargappn').val(addCommas(hargappn2));
                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                      $('.total').val(addCommas(total));
                    }
                    else if(jenisppn == 'T'){
                         hargappn = parseFloat($this * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                        $('.total').val(addCommas(subharga));
                    }
                   
             
                   /* if(jenisppn == 'E'){
                      hargappn = parseFloat($this * parseFloat(subharga) / 100);
                      ppnhar = hargappn.toFixed(2);
                      $('.hargappn').val(addCommas(ppnhar));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon));
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));
                      console.log(numhar);
                    }
                    else if(jenisppn == 'I'){
                      hargappn = parseFloat(subharga * parseFloat(100) / 100 + $this );
                      hargappn2 = hargappn2.toFixed(2);
                      $('.hargappn').val(addCommas(hargappn2));
                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(diskon)).toFixed(2);
                      $('.total').val(addCommas(total));
                    }
                    else if(jenisppn == 'T'){
                         hargappn = parseFloat($this * parseFloat(subharga) / 100);
                         ppnhar = hargappn.toFixed(2);
                        $('.hargappn').val(addCommas(ppnhar));
                         total = parseFloat(subharga  - diskon).toFixed(2);
                        $('.total').val(addCommas(total));
                    }
/**/
                     /* total = parseFloat(subharga - diskon + hargappn);
                      console.log(subharga-diskon);
                      console.log(hargappn);
                      numhar = total.toFixed(2);
                      $('.total').val(addCommas(numhar));*/
                  

              })


              $('.qtykirim').change(function(){
  
                val = $(this).val();
                id = $(this).data('id');
                qtyapprov = $('.qtyapproved' + id).val();
                kosong = '';

                $('.status' + id).val(kosong);
                
                val = parseInt(val);
                qtyapprov = parseInt(qtyapprov);

                if(val > qtyapprov) {
                  
                  kosong = '';
                  $('.status' + id).val(kosong);
                  $(this).val(kosong);
                  toastr.info('Anda tidak bisa menginputkan angka lebih besar dari jumlah yang di setujui :)');
                }
                else if(val == qtyapprov) {
                  status = 'LENGKAP';
                  $('.status' + id).val(status);
                }
                else {
                   status = 'TIDAK LENGKAP';
                  $('.status' + id).val(status);
                }
                
              })

              $('.edit').click(function(){
                  $('.hrg').attr('readonly' , false);
              })

              //harga
        $(function(){
            $('.harga').change(function(){
                var id = $(this).data('id');           
                harga = $(this).val();
                numhar = Math.round(harga).toFixed(2);
                console.log(id);
                $(this).val(addCommas(numhar));
              
            })
        })    
          }
        })
       }
       else if(uniqueNames.length > 1) {
        toastr.info('Diharapkan Anda harus memilih supplier yang sama :) ');
       }
       else if(uniqueGudang.length > 1){
        toastr.info('Diharapkan Anda harus memilih status update stock yang sama :)');
       }
       else if(uniqueCabang.length > 1){
        toastr.info('Diharapkan Anda harus memilih cabang pemohon yang sama :)');
       }

       else if(uniquePenerimaan.length > 1){
        toastr.info('Diharapkan Anda harus memilih tipe Group Item yang sama :)');
       }
    })



</script>
@endsection
