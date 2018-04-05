@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CN / DN Pembelian </h2>
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
                            <strong> Create CN / DN Pembelian </strong>
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
                    <h5> Tambah Data
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
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                          <table border="0" class="table">
                          
                          <tr>
                            <td> Cabang </td>
                            <td> 

                              @if(session::get('cabang') == 000)
                              <select class='form-control chosen-select-width cabang'>
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}">
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @else
                              <select class='form-control chosen-select-width cabang'>
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" 
                                    @if($cabang->kode == Session::get('cabang')) selected @endif>
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @endif
                            </td>
                          </tr>

                          <tr>
                            <td> Jenis : </td>
                            <td> <select class="form-control jeniscndn"><option value="CN">
                                    CREDIT NOTA
                                </option>
                                <option value="DN">
                                    DEBIT NOTA
                                </option>
                                </select>
                            </td>
                          </tr>

                          </tr>


                          <tr>
                            <td> Nota </td>
                            <td> <input type='text' class="form-control input-sm notacndn" name="nota" readonly="">  </td>
                          </tr>

                          <tr>
                            <td> Jenis Faktur </td>
                            <td> <select class="form-control jenissup">
                                    <option value="2">
                                      Supplier Hutang Dagang
                                    </option>
                                    <option value="3">
                                      Voucher / Hutang Dagang
                                    </option>
                                    <option value="6">
                                    Biaya Penerus Agen / Vendor
                                    </option>
                                    <option value="7">
                                    Pembayaran Outlet
                                    </option>
                                    <option value="9">
                                    Vendor Subcon
                                    </option>
                                </select>
                            </td>
                          </tr>

                           <tr>
                            <td>
                              Supplier
                            </td>
                            <td>
                              <select class="form-control chosen-select-width jenisbayar2" name="supplier">
                                @foreach($data['supplier'] as $supplier)
                                  <option value="{{$supplier->idsup}}"> {{$supplier->nama_supplier}} </option>
                                @endforeach
                              </select>
                            </td>
                          </tr>


                          <tr>
                            <td>   Tanggal </td>
                            <td>
                               <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control">
                              </div>
                            </td>
                          </tr>
                          </table>
                         </div>
                        
                        <div class="col-xs-6">
                           <table border="0" class ="table table-bordered table-striped">
                         
                          <tr >
                            <td> Bruto </td>
                            <td>   <input type="text" class="form-control input-sm"> </td>
                            </td>
                          </tr>


                          <tr>
                            <td>
                              DPP
                            </td>
                            <td style="text-align: right">
                                <input type="text" class="form-control input-sm"> 
                            </td>
                          </tr>


                          <tr>
                            <td>
                              Jenis PPn
                            </td>
                            <td>
                              <select class="form-control"> <option value=""> </option> </select>
                            </td>
                          </tr>
                   

                          <tr>
                            <td>
                              PPn
                            </td>
                            <td style="text-align: right">
                              <input type="text" class="form-control input-sm">
                            </td>
                          </tr>

                          <tr>
                            <td> 
                              Netto
                            </td>
                            <td style="text-align: right">
                              <input type="text" class="form-control input-sm">
                            </td>
                          </tr>
                          </table>
                        </div>                    
                      </div>
					
					
					 <div class="row"> 
                          <div class="col-sm-6">
                           <button class="btn btn-sm btn-primary  createmodalfaktur" id="createmodal" data-toggle="modal" data-target="#myModal5" type="button"> <i class="fa fa-plus"> Tambah Data Faktur </i> </button>
                         </div>
                        </div>

                        <div class="row">
                         <div class="col-sm-6">
                           <table class="table table-bordered table-striped">
                          <tr>
                            <td>
                             <b> Jumlah Biaya Faktur</b>
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm biayafaktur" readonly="">
                            </td>
                          </tr>

                      
                          <tr>
                            <td> 
                             <b>  Keterangan  </b>
                            </td>
                            <td>
                              <input type="text" class="form-control input-sm">
                            </td>
                          </tr>

                          <tr>
                            <td>
                              <b> Acc. Hutang Dagang </b>
                            </td>
                            <td> <input type="text" class="form-control input-sm acchutangdagang"> </td>
                          </tr>

                          <tr>
                            <td>
                             <b>  Acc. CN / DN </b>
                            </td>
                            <td> <input type="text" class="form-control input-sm"> </td>
                          </tr>


                          <tr>
                            <td>
                             <b> Acc. PPn </b>
                            </td>
                            <td> <input type="text" class="form-control input-sm accppn" readonly=""> </td>
                          </tr>

                          <tr>
                            <td> <b> Acc PPh </b> </td>
                            <td>  <input type="text" class="form-control input-sm accpph" readonly=""> </td>
                          </tr>
                          </table>
                          </table>
                      </div>
                      </div>
                    </form>

             
                  <!--  Modal  -->
                   <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title"> Data Faktur </h4>     
                                       </div>

                                <div class="modal-body">
                                  <table id="tblfaktur" class="table  table-bordered table-striped tbl-purchase">
                                       <thead>
                                         <tr>
                                          <th style="width:10px">No</th>
                                          <th style="width:120px"> No Faktur </th>
                                          <th style="width:120px"> Supplier </th>
                                           <th> Jatuh tempo </th>
                                          <th> Netto Hutang </th>
                                          <th> Sisa Hutang </th>
                                          <th style="width:50px"> Aksi </th>      
                                        </tr>
                                      </thead>                          
                                      <tbody>
                                       
                                      </tbody>
                                   </table>  
                                </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> 
                  <!-- End Modal -->

            
                 
                  <div class="col-sm-6">
                  <h3> Data Faktur </h3>
                  <br>

                  <div class="table-responsive">
                    <table class="table table-bordered table-stripped" id="table-faktur" >
                      <thead>
                      <tr>
                        <th> No </th>
                        <th> No Faktur </th>
                        <th> Jatuh Tempo </th>
                        <th> Netto Hutang </th>
                        <th> Sisa Hutang </th>
                      </tr>
                      </thead>
                    </table>
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

jenisbayar2 = $('.jenisbayar2').val();
alert(jenisbayar2);
     $(document).ready( function () {
      var config2 = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"}
                 }
                 for (var selector in config2) {
                   $(selector).chosen(config2[selector]);
                 }

      $('.supplier').chosen(config2); 
   //   $('.nofaktur').chosen(config2); 
      $('.cabang').chosen(config2);
      $('.jenisbayar2').chosen(config2);

    })



     $('.jenissup').change(function(){
      idjenis = $('.jenissup').val();
       $.ajax({
        type : 'GET',
        data : {idjenis},
        url : baseUrl + '/cndnpembelian/getsupplier',      
        dataType : 'json',
        success : function(response){
            var response = response['isi'];
           
           if(idjenis == '2' ){  
                      $('.jenisbayar2').empty();   
                          $('.jenisbayar2').append("<option value='' selected> Pilih Supplier </option>");                
                      for(var j=0; j<response.length; j++){  
                                    
                         $('.jenisbayar2').append("<option value="+response[j].no_supplier+">"+response[j].no_supplier+" - "+response[j].nama_supplier+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      }                     
                    }   
                    else if(idjenis == '6'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Agen  </option>");  
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                      } 
                    }
                    else if(idjenis == '7'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Outlet  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }
                    else if(idjenis == '9'){
                       $('.jenisbayar2').empty();  
                        $('.jenisbayar2').append("<option value='' selected> Pilih Vendor  </option>"); 
                       for(var j=0; j<response.length; j++){                                    
                         $('.jenisbayar2').append("<option value="+response[j].kode+">"+response[j].kode+","+response[j].nama+"</option>");
                          $('.jenisbayar2').trigger("chosen:updated");
                          $('.jenisbayar2').trigger("liszt:updated");
                        } 
                    }
             }      
      })
     })

    $('.date').datepicker({
        autoclose: true,
         format: 'dd-MM-yyyy',
    }).datepicker("setDate", "0");



    $('#createmodal').click(function(){
      idsup = $('.jenisbayar2').val();
      jenis = $('.jenissup').val();
      cabang = $('.cabang').val();
      $.ajax({
        type : 'GET',
        data : {idsup,jenis,cabang},
        url : baseUrl + '/cndnpembelian/getfaktur',      
        dataType : 'json',
        success : function(response){
            var tablecek = $('#tblfaktur').DataTable();
          tablecek.clear().draw();
            var nmrbnk = 1;
            table = response.fakturpembelian;

            if(idsup == 2){
               for(var i = 0; i < table.length; i++){      
                                   
               var html2 = "<tr>" +
                          "<td>"+nmrbnk+"</td>" +
                          "<td>"+table[i].fp_nofaktur+"</td>" + // no faktur
                          "<td>"+table[i].nama_supplier+"</td>" +
                          "<td>"+table[i].fp_jatuhtempo+"</td>" +
                          "<td style='text-align:right'>Rp "+addCommas(table[i].fp_netto)+"</td>" +
                          "<td  style='text-align:right'>Rp " +addCommas(table[i].fp_sisapelunasan)+"</td>" +
                         "<td>" +
                           "<div class='checkbox'> <input type='checkbox' id="+table[i].fp_idfaktur+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>" +
                         "</tr>";
                        
                 tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
               }   
            }
            else {
              for(var i = 0; i < table.length; i++){  
                  var html2 = "<tr>" +
                          "<td>"+nmrbnk+"</td>" +
                          "<td>"+table[i].fp_nofaktur+"</td>" + // no faktur
                          "<td>"+table[i].nama+"</td>" +
                          "<td>"+table[i].fp_jatuhtempo+"</td>" +
                          "<td style='text-align:right'>Rp "+addCommas(table[i].fp_netto)+"</td>" +
                          "<td  style='text-align:right'>Rp " +addCommas(table[i].fp_sisapelunasan)+"</td>" +
                         "<td>" +
                           "<div class='checkbox'> <input type='checkbox' id="+table[i].fp_idfaktur+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div></td>" +
                         "</tr>";

                tablecek.rows.add($(html2)).draw(); 
                nmrbnk++; 
              }
               } 
            }
           
        })
      
    })


    $('#buttongetid').click(function(){
      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();

      var url = baseUrl + '/fakturpembelian/tampil_po';

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
        $nomor = 0;
        $sisahutang = 0;
        url = baseUrl + '/cndnpembelian/hslfaktur'; 
         $.ajax({    
          type :"get",
          data : {checked},
          url : url,
          dataType:'json',
          success : function(response){
            $('#myModal5').modal('toggle');
            faktur = response.faktur

            for(i = 0; i < faktur.length; i++ ){
              $nomor++;
              var row = "<tr>" +
                          "<td style='text-align:center'> "+$nomor+" </td>" +
                          "<td style='text-align:center'>"+faktur[i][0].fp_nofaktur+" </td>" +
                          "<td style='text-align:center'>"+faktur[i][0].fp_jatuhtempo+"</td>" +
                          "<td style='text-align:right'>"+addCommas(faktur[i][0].fp_netto)+"</td>" +
                          "<td style='text-align:right'> <input type='text' class='sisahutang form-control input-sm' value='"+addCommas(faktur[i][0].fp_sisapelunasan)+"' readonly></td>" +
                        "</tr>";
              $('#table-faktur').append(row);

            }


            $('.sisahutang').each(function(){
              val = $(this).val();
              aslihutang = val.replace(/,/g, '');
              $sisahutang = parseFloat(parseFloat($sisahutang) + parseFloat(aslihutang)).toFixed(2);
            })

            $('.biayafaktur').val(addCommas($sisahutang));
          }
        })
    })

     val = $('.jeniscndn').val();
     comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/cndnpembelian/getnota',
            dataType:'json',
            success : function(data){
              alert(comp);
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

                  if(val == 'CN') {
                    nospp = 'CN' + month + year2 + '/' + comp + '/' +  data.idcndn;
                  }
                  else {
                    nospp = 'DN' + month + year2 + '/' + comp + '/' + data.idcndn
                  }
            
                $('.notacndn').val(nospp);
                 nospp = $('.notacndn').val();
               
            }
        })




    $('.jeniscndn').change(function(){
      
        comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/cndnpembelian/getnota',
            dataType:'json',
            success : function(data){
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

                  if(val == 'CN') {
                    nospp = 'CN' + month + year2 + '/' + comp + '/' +  data.idcndn;
                  }
                  else {
                    nospp = 'DN' + month + year2 + '/' + comp + '/' + data.idcndn
                  }
            
                $('.notacndn').val(nospp);
                 nospp = $('.notacndn').val();
               
            }
        })
    
    })

     
</script>
@endsection
