@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css" media="screen">
  .disabled {
        pointer-events: none;
        opacity: 0.7;
        }
  .borderless td, .borderless th {
    border: none !important;
  }

   .table-hover tbody tr{
    cursor: pointer;
  }
  </style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Return Pembelian </h2> 
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
                            <strong> Create Return Pembelian  </strong>
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
                   <div class="text-right">
                       <a class="btn btn-sm btn-default" aria-hidden="true" href="{{ url('returnpembelian/returnpembelian')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 

                    </div>
                </div>
                  <form class="form-horizontal" id="saveform"  method="POST">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                        <input type="hidden" value="{{Auth::user()->m_name}}" name="username">
                           <table border="0" class="table">
                            <tr>
                                <td> Cabang </td>
                                 <td> 

                              @if(Auth::user()->punyaAkses('Return Pembelian','cabang'))
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
                            </tr>

                          <tr>
                            <td width="150px">
                          No Return
                            </td>
                            <td>
                               <input type="text" class="form-control notareturn input-sm" name="nota">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                            </td>
                          </tr>

                          <tr>
                            <td>   Tanggal </td>
                            <td>
                             <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl" required="">
                              </div>
                            </td>
                          </tr>
                       


                          <tr>
                            <td>
                              Supplier
                            </td>
                            <td>
                              <select class="form-control chosen-select supplier" required="" name="supplier">
                              @foreach($data['supplier'] as $supplier)
                                <option value="{{$supplier->idsup}}">
                                        {{$supplier->no_supplier}} - {{$supplier->nama_supplier}}
                                </option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td> Keterangan </td>
                            <td> <input type="text" class="form-control input-sm" name="keterangan" required></td>
                          </tr>
                         
                          </table>
                       
                      </div>

                      <div class="col-sm-6">                      
                          <table class="table table-stripped">
                             
                          </table>
                          
                      </div>
                    
                      </div>

                      <hr>

                        
                      <button class="btn btn-sm btn-primary  createmodalpo" id="createmodal_po" data-toggle="modal" data-target="#myModal5" type="button"> <i class="fa fa-plus"> Tambah Data PO </i> </button>


                      <div class="row">
                          <div class="col-sm-6">
                          <br>
                              <table class="table">
                                  <tr>
                                  <th> No PO </th>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm nopo" readonly="" name="nopo"> <input type="hidden" class="form-control input-sm idpo" readonly="" name="idpo"> </div> <div class="col-sm-4"> <button class="btn btn-xs btn-info" type="button" onclick="lihatbarang()" data-toggle="modal" data-target="#myModal7"> <i class="fa fa-search"> Lihat Data PO </i> </button> </div> </td>
                                  </tr>  
                                  
                                   <tr>
                                  <td> Sub Total </td>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm subtotal" name="subtotal" readonly=""> <input type='hidden' class='subtotal2'> </div></td>
                              </tr>

                              <tr>
                                  <td> Jenis PPn </td>
                                  <td> <div class="col-sm-7"> <select class="form-control jenisppn disabled" name="jenisppn">
                                          <option value="T">
                                              Tanpa
                                          </option>
                                          <option value="E">
                                              Exclude
                                          </option>
                                          <option value="I">
                                              Include
                                          </option>
                                      </select>
                                      </div>
                                  </td>
                              </tr>
                              <tr>
                                  <td> PPn </td>
                                  <td> <div class="col-sm-5"> <input type="text" class="form-control input-sm inputppn" name="inputppn" readonly=""></div> <div class="col-sm-5"> <input type="text" class="form-control input-sm hasilppn" name="hasilppn" readonly=""> </div></td>
                              </tr>
                              <tr>
                                  <td> Total </td>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm total" name="total" readonly=""> <input type='hidden' class="total2">  </div> </td>
                              </tr>
                              </table>
                              </div>

                              <div class="col-xs-5">
                              <br>
                                <table class="table">
                                <tr>
                                  <th> TOTAL RETURN PEMBELIAN </th>
                                  <td> <input type="text" style="text-align:right" class="form-control totalreturn input-sm" name="totalreturn" readonly="" value="0.00"> </td>
                                </tr>
                                <tr>
                                  <th> TOTAL HARGA TERIMA </th>
                                  <td> <input type="text" style="text-align:right" class="form-control totalterima input-sm" name="totalterima" readonly="" value="0.00"> </td>
                                 
                                </tr>
                                </table>
                              </div>
                              </div>

                              <div class="col-sm-10">
                                <p style="color:red"> <i> *Hapus data yang tidak di perlukan </i></p>
                                  
                                  <table class="table table-datatable" id="table-barang">
                                  <thead>
                                      <tr> 
                                          <th> No </th>
                                          <th> Nama Barang </th>
                                          <th> Qty PO </th>
                                          <th> Qty Return </th>
                                          <th> Harga Return </th>
                                          <th> Total Harga Return </th>
                                          <th > Qty Terima </th>
                                          <th > Harga Terima </th>
                                          <th > Total Harga Terima </th>
                                          <th> Aksi </th>
                                      </tr>
                                  </thead>
                                     
                                  </table>
                                  
                             </div>
                       
                          

                     


                       <!--  Modal  -->
                   <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true" style="min-width:100px">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                     <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title"> Data Po </h4>     
                                       </div>

                                <div class="modal-body">
                                   <table class="table table-datatable table-bordered table-stripped" id="table-po">
                                      <thead>
                                      <tr>
                                          <th> No </th>
                                          <th> No PO </th>
                                          <th> Netto Harga </th>
                                          <th> Tipe PO </th>
                                          <th> Aksi </th>
                                      </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td> </td>
                                              <td> </td>
                                              <td> </td>
                                              <td> </td>
                                              <td> </td>
                                          </tr>
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

                    <!-- Modal Data PO -->
                         <div class="modal inmodal fade" id="myModal7" tabindex="-1" role="dialog"  aria-hidden="true" style="min-width:100px">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                     <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                          <h2> DATA PO</h2>
                                       </div>

                                <div class="modal-body">
                                     
                                   
                                          <table class="table" id="header-modal">
                                              <tr>
                                              <th> No PO </th>
                                              <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm nopomodal" readonly="" name="nopo" readonly=""> </div> </td>
                                              </tr>  
                                              
                                               <tr>
                                              <td> Sub Total </td>
                                              <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm subtotalmodal" name="subtotal" readonly=""> </div></td>
                                          </tr>

                                          <tr>
                                              <td> Jenis PPn </td>
                                              <td> <div class="col-sm-7"> <select class="form-control jenisppnmodal disabled" name="jenisppn">
                                                      <option value="T">
                                                          Tanpa
                                                      </option>
                                                      <option value="E">
                                                          Exclude
                                                      </option>
                                                      <option value="I">
                                                          Include
                                                      </option>
                                                  </select>
                                                  </div>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td> PPn </td>
                                              <td> <div class="col-sm-5"> <input type="text" class="form-control input-sm inputppnmodal" name="inputppn" readonly=""></div> <div class="col-sm-5"> <input type="text" class="form-control input-sm hasilppnmodal" name="hasilppn"> </div></td>
                                          </tr>
                                          <tr>
                                              <td> Total </td>
                                              <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm totalmodal" name="total" readonly=""></div> </td>
                                          </tr>
                                          </table>
                                         

                                          <table class="table table-datatable" id="barang-header">
                                          <thead>
                                              <tr> 
                                                  <th> No </th>
                                                  <th style="width:300px"> Nama Barang </th>
                                                  <th> Qty PO </th>
                                              
                                                  <th> Harga </th>
                                                  <th> Total Harga </th>
                                                  <th> Aksi </th>
                                              </tr>
                                          </thead>
                                             
                                          </table>
                                     

                                </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                            </div>
                          </div>
                       </div> 

                    <!-- End Modal PO -->

                    </div>
                   

             
                   
  

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-sm btn-warning" href={{url('purchase/returnpembelian')}}> Kembali </a> 
                   <button type="submit" id="submit" name="submit" value="Simpan" class="btn btn-sm btn-success simpanitem"> <i class=" fa fa-upload"> </i> Simpan </button>
         
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


    function lihatbarang () {
      $idpo = $('.idpo').val();
      checked = [];
      checked = $idpo;
      if($idpo == ''){
        toastr.info('anda belum memasukkan data po :)');
       return false;
      } 
      $.ajax({
       url : baseUrl + '/returnpembelian/hslfaktur',
       data : {checked},
       dataType : 'json',
       type : "get",
       success : function(response){
          // $('#myModal7').modal('toggle');
              $('.nopomodal').val(response.po[0].po_no);
              $('.subtotalmodal').val(addCommas(response.po[0].po_subtotal));
            
              $('.jenisppnmodal').val(response.po[0].po_jenisppn);
              if(response.po[0].po_jenisppn == 'T'){
                $('.inputppnmodal').val('0.00');
                $('.hasilppnmodal').val('0.00');

              }
              else {
                $('.inputppnmodal').val(addCommas(response.po[0].po_ppn));
                $('.hasilppnmodal').val(addCommas(response.po[0].po_hasilppn));
              }
              
              $('.totalmodal').val(addCommas(response.po[0].po_totalharga));


                var barangheader = $('#barang-header').DataTable();
                barangheader.clear().draw();
                var nmrbnk = 1;
                table2 = response.po;       
                 for(var i = 0; i < table2.length; i++){  
                       var html2 = "<tr class='databarang data"+nmrbnk+"' id="+table2[i].po_id+" data-nopo='"+table2[i].po_noform+"'>" +
                            "<td>"+nmrbnk+"</td>" +
                            "<td style='width:200px'> <p style='width:200px'>"+table2[i].nama_masteritem+"</p> <input type='hidden' class='kodeitem"+nmrbnk+"' value='"+table2[i].podt_kodeitem+"' name='kodeitem[]'></td>" + // no faktur
                            "<td>"+table2[i].podt_qtykirim+"<input type='hidden' class='qtykirim"+nmrbnk+"' value='"+table2[i].podt_qtykirim+"' name='qtypo[]'> </td>" +                           
                            "<td> <input type='text' class='form-control input-sm jumlahharga"+nmrbnk+"' value="+addCommas(table2[i].podt_jumlahharga)+" readonly name='jumlahharga[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm totalharga"+nmrbnk+"' value="+addCommas(table2[i].podt_totalharga)+" readonly name='totalharga[]'> <input type='hidden' class='minusharga minusharga"+nmrbnk+"'> <input type='hidden' class='minusharga' value='"+table2[i].podt_lokasigudang+"' name='lokasigudang[]'> </td>" +
                            "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+nmrbnk+"' type='button'><i class='fa fa-trash'></i></button> </td>" +
                           "</tr>";
                          
                       barangheader.rows.add($(html2)).draw(); 
                      nmrbnk++;                                                                                  
                 } 
       }
      })
    }


    $('#saveform').submit(function(event){
          trtbl = $('tr.databarang').length;
          if(trtbl == 0){
            toastr.info('Data yang di inputkan belum ada :)');
          }
         
          event.preventDefault();
          var post_url2 = baseUrl + '/returnpembelian/save';
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data RETURN PEMBELIAN!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
               
        $.ajax({
          type : "POST",          
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
                   alertSuccess(); 
           $('.simpanitem').attr('disabled' , true);
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      
      })

    $('.cabang').change(function(){
        comp = $('.cabang').val();    
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/returnpembelian/getnota',
            dataType:'json',
            success : function(data){
             // alert(comp);
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

                 
                    nospp = 'RN' + month + year2 + '/' + comp + '/' + data.idreturn
                
            
                $('.notareturn').val(nospp);
              
            },
            error : function(){
              location.reload();
            }
        })
    })

  comp = $('.cabang').val();    
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/returnpembelian/getnota',
            dataType:'json',
            success : function(data){
             // alert(comp);
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

                 
                    nospp = 'RN' + month + year2 + '/' + comp + '/' + data.idreturn
                
            
                $('.notareturn').val(nospp);
              
            },
            error : function(){
              location.reload();
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


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });

     $('.date').datepicker({
        autoclose: true,
         format: 'dd-MM-yyyy',
    }).datepicker("setDate", "0");

  $('#buttongetid').click(function(){
     var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();
           var tablepo = $('#table-po').DataTable();
          tablepo.clear().draw();   
        url = baseUrl + '/returnpembelian/hslfaktur'; 

        if(checked.length > 1){
          toastr.info('Hanya Bisa Pilih Satu Data Faktur :) ');
          return false;
        }
         $.ajax({    
          type :"get",
          data : {checked},
          url : url,
          dataType:'json',
          success : function(response){
              $('#myModal5').modal('toggle');
              $('.nopo').val(response.po[0].po_no);
              $('.subtotal').val(addCommas(response.po[0].po_subtotal));
              $('.subtotal2').val(addCommas(response.po[0].po_subtotal));
              $('.idpo').val(response.po[0].po_id);
              $('.jenisppn').val(response.po[0].po_jenisppn);

              if(response.po[0].po_jenisppn == 'T'){
                 $('.inputppn').val('0.00');
                 $('.hasilppn').val('0.00');
              }
              else {
                $('.inputppn').val(addCommas(response.po[0].po_ppn));
                $('.hasilppn').val(addCommas(response.po[0].po_hasilppn));
              }
              $('.total').val(addCommas(response.po[0].po_totalharga));
              $('.total2').val(addCommas(response.po[0].po_totalharga));


                var tablebarang = $('#table-barang').DataTable();
                tablebarang.clear().draw();
                var nmrbnk = 1;
                
                table2 = response.po;       
                 for(var i = 0; i < table2.length; i++){  
                       var html2 = "<tr class='databarang data"+nmrbnk+"' id="+table2[i].po_id+" data-nopo='"+table2[i].po_noform+"'>" +
                            "<td>"+nmrbnk+"</td>" +
                            "<td style='width:150px'> <p style='width:120px'>"+table2[i].nama_masteritem+"</p> <input type='hidden' class='kodeitem"+nmrbnk+"' value='"+table2[i].podt_kodeitem+"' name='kodeitem[]'></td>" + // no faktur
                            "<td>"+table2[i].podt_qtykirim+"<input type='hidden' class='qtykirim"+nmrbnk+"' value='"+table2[i].podt_qtykirim+"' name='qtypo[]'> </td>" +
                            "<td> <input type='number' class='form-control input-sm  qtyreturn qtyreturn"+nmrbnk+"' data-id='"+nmrbnk+"' name='qtyreturn[]' style='width:70px' required value='0'></td>" +
                            "<td > <input type='text' class='form-control input-sm jumlahharga"+nmrbnk+"' value="+addCommas(table2[i].podt_jumlahharga)+" readonly name='jumlahharga[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm totalharga totalharga"+nmrbnk+"' value="+addCommas(table2[i].podt_totalharga)+" readonly name='totalharga[]' style='width:100px'> <input type='hidden' class='minusharga minusharga"+nmrbnk+"' style='width:150px'> <input type='hidden' value='"+table2[i].podt_lokasigudang+"' name='lokasigudang[]'> </td>" + 
                            "<td> <input type='number' class='form-control input-sm  qtyterima qtyterima"+nmrbnk+"' data-id='"+nmrbnk+"' name='qtyterima[]' style='width:70px' required value='0'></td>" + //qtyterima
                            "<td style='width:80px'> <input type='text' class='form-control input-sm jumlahhargaterima jumlahhargaterima"+nmrbnk+"' name='jumlahhargaterima[]' data-id='"+nmrbnk+"' style='width:150px' value='0.00'> </td>" + //jumlahharga terima
                            "<td > <input type='text' class='form-control input-sm totalhargaterima totalhargaterima"+nmrbnk+"'  name='totalhargaterima[]' readonly style='width:150px' value='0.00'> <input type='hidden' name='akunitem[]' value='"+table2[i].podt_akunitem+"'>"+   //totalhargaterima
                            "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+nmrbnk+"' type='button'><i class='fa fa-trash'></i></button> </td>" +
                           "</tr>";
                          
                       tablebarang.rows.add($(html2)).draw(); 
                      nmrbnk++;                                        
                 } 

                $('.qtyreturn').focus(function(){
                  $(this).select();
                })

                $('.qtyreturn').each(function(){
                  $(this).keyup(function(){

                 //   $(this).select();
                    dataid = $(this).data('id');
                    qty = $(this).val();
                    qtykirim = $('.qtykirim' + dataid).val();

                    if(qty == ''){
                  //    alert('as');
                      $(this).val('0');
                      return false;
                    }

                    if(parseInt(qty) > parseInt(qtykirim)){
                      toastr.info('Tidak bisa melebihi dari jumlah qty PO :) ');
                      $(this).val('');
                      return false;
                    }  

                    //hitung jumlah total per barang
                    hasilqty = parseInt(qtykirim) - parseInt(qty);
                    harga = $('.jumlahharga'+dataid).val();
                    harga2 = harga.replace(/,/g, ''); 
                    totalhrga = (hasilqty * parseFloat(harga2)).toFixed(2);
                    $('.totalharga' + dataid).val(addCommas(totalhrga));

                    minusqty = (qty * parseFloat(harga2)).toFixed(2);
                    $('.minusharga' + dataid).val(addCommas(minusqty));


                    //hitung total di header
                      subtotal = response.po[0].po_subtotal;            
                      jenisppn = response.po[0].po_jenisppn;
                      inputppn = response.po[0].po_ppn;
                      hasilppn = response.po[0].po_hasilppn;
                      totalharga =$('.total').val(addCommas(response.po[0].po_totalharga));
                      hasiltotalharga = 0;
                      $('.totalharga').each(function(){
                        valharga2 = $(this).val();
                      //  alert(valharga2);
                        //alert(valminus2);
                        if(valharga2 != ''){
                          valharga = valharga2.replace(/,/g, ''); 
                         // alert(valminus);
                          hasiltotalharga = parseFloat(parseFloat(hasiltotalharga) + parseFloat(valharga)).toFixed(2);
                          // alert(subtotal);   
                         // alert(valminus); 
                        }
                      })

                    
                    hasilminus = 0;
                    $('.minusharga').each(function(){
                      val = $(this).val();
                      if(val != ''){
                        valreturn = val.replace(/,/g,'');
                        hasilminus = parseFloat(parseFloat(hasilminus) + parseFloat(valreturn)).toFixed(2);
                      }
                    })

                    $('.totalreturn').val(addCommas(hasilminus));

                    totalhargaterimafix = 0;
                    $('.totalhargaterima').each(function(){
                      val2 = $(this).val();
                      val =val2.replace(/,/g, '');


                      totalhargaterimafix = (parseFloat(totalhargaterimafix) + parseFloat(val)).toFixed(2);
                    })
                   // alert(hasiltotalharga);
                  //    hargasubtotal = $('.subtotal').val(addCommas(hasiltotalharga));
                    
                    hasilsub = (parseFloat(hasiltotalharga) + parseFloat(totalhargaterimafix)).toFixed(2);
                    //  alert(hargasubtotal);

                    $('.subtotal').val(addCommas(hasilsub));
                    
                      subtotal3 = $('.subtotal').val();
                      subtotal2 =   subtotal3.replace(/,/g, ''); 
                      if(jenisppn != 'T'){
                      //  alert('ha');
                          if(jenisppn == 'E'){
                
                            hargappn = parseFloat(inputppn * parseFloat(subtotal2) / 100);
                       
                            $('.hasilppn').val(addCommas(hargappn));
                            total = parseFloat(parseFloat(subtotal2) + parseFloat(hargappn));
                           
                            numhar = total.toFixed(2);
                            $('.total').val(addCommas(numhar));
                            $('.subtotal').val(addCommas(subtotal2));
                          }
                          else if(jenisppn == 'I'){                            
                              hargappn = parseFloat(subtotal2 * 100) / (100 + parseFloat(inputppn) );                     
                              hargappn2 = hargappn.toFixed(2);
                              $('.subtotal').val(addCommas(hargappn2));
                             // alert(subtotal2 *100);
                             // alert(100 + parseFloat(inputppn));


                              ppnasli = parseFloat((parseFloat(inputppn) / 100) * parseFloat(hargappn2)).toFixed(2);
                              $('.hargappn').val(addCommas(ppnasli));
                              hasiltotal = parseFloat(parseFloat(hargappn2) + parseFloat(ppnasli)).toFixed(2);
                             // total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                              $('.total').val(addCommas(hasiltotal));
                          }
                          else {
                             $('.subtotal').val(addCommas(subtotal));
                             $('.total').val(addCommas(subtotal));
                          }
                        }
                        else {
                            $('.total').val(addCommas(hasilsub));
                        }
                       
                  })
                })

                 tablebarang = $('#table-barang').DataTable();
                $('.removes-btn').click(function(){
                 tablebarang.row( $(this).parents('tr') )
                  .remove()
                  .draw();
                })

                /*$('.qtyterima').each(function(){
                  
                  $(this).change(function(){
                    id = $(this).data('id');
                    qtyreturn = $('.qtyreturn' +id).val();
                    val = $(this).val();

                    if(parseInt(val) > parseInt(qtyreturn)){
                      toastr.info("Tidak Bisa input data lebih dari qty return :)");
                      $(this).val('');
                    }

                  })
                })
*/      




              $('.jumlahhargaterima').each(function(){
                  
                $(this).change(function(){
                  id = $(this).data('id');
                   val = $(this).val();     
                   val = accounting.formatMoney(val, "", 2, ",",'.');
                   $(this).val(val);

                   qtyterima = $('.qtyterima' + id).val();
                   if(qtyterima != ''){
                      hargaitem =   val.replace(/,/g, ''); 
                      totalharga = (qtyterima * parseFloat(hargaitem)).toFixed(2);
                      $('.totalhargaterima' + id).val(addCommas(totalharga));
                   }

                     hasiltotalharga = 0;
                      $('.totalharga').each(function(){
                        valharga2 = $(this).val();
                      //  alert(valharga2);
                        //alert(valminus2);
                        if(valharga2 != ''){
                          valharga = valharga2.replace(/,/g, ''); 
                         // alert(valminus);
                          hasiltotalharga = parseFloat(parseFloat(hasiltotalharga) + parseFloat(valharga)).toFixed(2);
                          // alert(subtotal);   
                         // alert(valminus); 
                        }
                      })

                    totalhargaterimafix = 0;
                    $('.totalhargaterima').each(function(){
                      val2 = $(this).val();
                      val =val2.replace(/,/g, '');


                      totalhargaterimafix = (parseFloat(totalhargaterimafix) + parseFloat(val)).toFixed(2);
                    })
                   // alert(hasiltotalharga);
                  //    hargasubtotal = $('.subtotal').val(addCommas(hasiltotalharga));
                    $('.totalterima').val(addCommas(totalhargaterimafix));
                    hasilsub = (parseFloat(hasiltotalharga) + parseFloat(totalhargaterimafix)).toFixed(2);
                    //  alert(hargasubtotal);

                     $('.subtotal').val(addCommas(hasilsub));
                    jenisppn = $('.jenisppn').val();

                     subtotal3 = $('.subtotal').val();
                     subtotal2 =   subtotal3.replace(/,/g, ''); 
                      if(jenisppn != 'T'){
                          if(jenisppn == 'E'){
                
                            hargappn = parseFloat(inputppn * parseFloat(subtotal2) / 100);
                       
                            $('.hasilppn').val(addCommas(hargappn));
                            total = parseFloat(parseFloat(subtotal2) + parseFloat(hargappn));
                           
                            numhar = total.toFixed(2);
                            $('.total').val(addCommas(numhar));
                            $('.subtotal').val(addCommas(subtotal2));
                          }
                          else if(jenisppn == 'I'){                            
                              hargappn = parseFloat(subtotal2 * 100) / (100 + parseFloat(inputppn) );                     
                              hargappn2 = hargappn.toFixed(2);
                              $('.subtotal').val(addCommas(hargappn2));
                             // alert(subtotal2 *100);
                             // alert(100 + parseFloat(inputppn));


                              ppnasli = parseFloat((parseFloat(inputppn) / 100) * parseFloat(hargappn2)).toFixed(2);
                              $('.hargappn').val(addCommas(ppnasli));
                              hasiltotal = parseFloat(parseFloat(hargappn2) + parseFloat(ppnasli)).toFixed(2);
                             // total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                              $('.total').val(addCommas(hasiltotal));
                          }
                          else {
                             $('.subtotal').val(addCommas(subtotal));
                             $('.total').val(addCommas(subtotal));
                          }
                        }
                        else {
                            $('.total').val(addCommas(hasilsub));

                        }
                })
              })




              $('.qtyterima').each(function(){
              
                $(this).keyup(function(){
                   id = $(this).data('id');
                  qty = $(this).val();
                  hpp = $('.jumlahhargaterima' + id).val();

                   qtyreturn = $('.qtyreturn' + id).val();
                   // val = $(this).val();
                    if(qtyreturn == ''){
                      toastr.info('Qty Return Belum diisi :)' );
                      $(this).val('0');
                      return false;
                    }else{
                    if(parseInt(qty) > parseInt(qtyreturn)){
                      toastr.info("Tidak Bisa input data lebih dari qty return :)");
                      $(this).val('0');
                      return false;
                    }}

                    if(qty == ''){
                      $(this).val('0');
                      return false;
                    }


                  hasiltotal2 = $('.total2').val();
                  hasiltotal =  hasiltotal2.replace(/,/g, '');
                  totalhargafix = 0;
                  $('.totalharga').each(function(){
                    val2 = $(this).val();
                    val =  val2.replace(/,/g, '');

                    totalhargafix = (parseFloat(totalhargafix) + parseFloat(val)).toFixed(2);
                  })



                  if(hpp != ''){
                    hargaitem =   hpp.replace(/,/g, ''); 
                    totalharga = (parseFloat(qty) * parseFloat(hargaitem)).toFixed(2);

                    $('.totalhargaterima' + id).val(addCommas(totalharga));
                    total2 = $('.total').val();
                    total = total2.replace(/,/g, ''); 

                     totalhargaterimafix = 0;
                    $('.totalhargaterima').each(function(){
                      val2 = $(this).val();
                      val =val2.replace(/,/g, '');


                      totalhargaterimafix = (parseFloat(totalhargaterimafix) + parseFloat(val)).toFixed(2);
                    })

               //   alert(totalhargaterimafix);

                    $('.totalterima').val(addCommas(totalhargaterimafix));

                   // hsltotal = (parseFloat(total) + parseFloat(totalharga)).toFixed(2);

                    hasilsub = (parseFloat(totalhargafix) + parseFloat(totalhargaterimafix)).toFixed(2);

                    $('.subtotal').val(addCommas(hasilsub));
                    jenisppn = $('.jenisppn').val();

                     subtotal3 = $('.subtotal').val();
                     subtotal2 =   subtotal3.replace(/,/g, ''); 
                      if(jenisppn != 'T'){
                          if(jenisppn == 'E'){
                
                            hargappn = parseFloat(inputppn * parseFloat(subtotal2) / 100);
                       
                            $('.hasilppn').val(addCommas(hargappn));
                            total = parseFloat(parseFloat(subtotal2) + parseFloat(hargappn));
                           
                            numhar = total.toFixed(2);
                            $('.total').val(addCommas(numhar));
                            $('.subtotal').val(addCommas(subtotal2));
                          }
                          else if(jenisppn == 'I'){                            
                              hargappn = parseFloat(subtotal2 * 100) / (100 + parseFloat(inputppn) );                     
                              hargappn2 = hargappn.toFixed(2);
                              $('.subtotal').val(addCommas(hargappn2));
                             // alert(subtotal2 *100);
                             // alert(100 + parseFloat(inputppn));


                              ppnasli = parseFloat((parseFloat(inputppn) / 100) * parseFloat(hargappn2)).toFixed(2);
                              $('.hargappn').val(addCommas(ppnasli));
                              hasiltotal = parseFloat(parseFloat(hargappn2) + parseFloat(ppnasli)).toFixed(2);
                             // total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                              $('.total').val(addCommas(hasiltotal));
                          }
                          else {
                             $('.subtotal').val(addCommas(subtotal));
                             $('.total').val(addCommas(subtotal));
                          }
                        }
                        else {
                            $('.total').val(addCommas(hasilsub));

                        }
                  }


                })
              })
          }
        })
  })

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


    })    
   
 tableDetail = $('.table-datatable').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });
    
  
   $('#createmodal_po').click(function(){
      supplier = $('.supplier').val();
      cabang = $('.cabang').val();
      idpo = $('.idpo').val();
        $.ajax({    
          type :"get",
          data : {supplier,cabang,idpo},
          url : baseUrl + '/returnpembelian/getpo',
          dataType:'json',
          success : function(response){
          var tablepo = $('#table-po').DataTable();
          tablepo.clear().draw();
            var nmrbnk = 1;
            table = response.po;       
                 for(var i = 0; i < table.length; i++){  
                       var html2 = "<tr class='data"+nmrbnk+"' id="+table[i].po_noform+" data-faktur='"+table[i].po_noform+"'>" +
                            "<td>"+nmrbnk+"</td>" +
                            "<td>"+table[i].po_no+"</td>" + // no faktur
                            "<td>"+addCommas(table[i].po_totalharga)+"</td>" +
                            "<td style='text-align:right'>"+table[i].po_tipe+"</td>" +
                            "<td>" +
                             "<div class='checkbox'> <input type='checkbox' id="+table[i].po_id+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                        "<label></label>" +
                                        "</div></td>" +
                           "</tr>";
                          
                       tablepo.rows.add($(html2)).draw(); 
                      nmrbnk++;                                                                                  
                 }   
          },
          error : function(){
            location.reload();
          }

        })
   })

</script>
@endsection
