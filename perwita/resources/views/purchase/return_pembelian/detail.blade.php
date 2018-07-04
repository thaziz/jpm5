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
                      <div class="col-xs-12">
                          @foreach($data['rn'] as $rn)
                         @if(count($data['jurnal_return'])!=0)
                          <div class="pull-right">  
                         
                              <a onclick="lihatjurnal('{{$data['rn'][0]->rn_nota or null}}','RETURN PEMBELIAN RETURN')" class="btn-xs btn-primary" aria-hidden="true">
                       
                                <i class="fa  fa-eye"> </i>
                                 &nbsp;  Lihat Jurnal Return
                               </a> 
                          </div>
                          @endif

                           @if(count($data['jurnal_terima'])!=0)
                          <div class="pull-right">  
                                <a onclick="lihatjurnal('{{$data['rn'][0]->rn_nota or null}}','RETURN PEMBELIAN TERIMA')" class="btn-xs btn-primary" aria-hidden="true">
                       
                                <i class="fa  fa-eye"> </i>
                                 &nbsp;  Lihat Jurnal Terima
                               </a> 
                          </div>
                          @endif


                        <input type="hidden" value="{{Auth::user()->m_name}}" name="username">
                           <table border="0" class="table">
                           
                            <tr>
                                <td> Cabang </td>
                                 <td> 

                              @if(session::get('cabang') == 000)
                              <select class='form-control chosen-select-width cabang disabled' name="cabang">
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" @if($rn->rn_cabang == $cabang->kode) selected @endif>
                                      {{$cabang->kode}} - {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @else
                              <select class='form-control chosen-select-width cabang disabled'>
                                  @foreach($data['cabang'] as $cabang)
                                    <option value="{{$cabang->kode}}" 
                                     @if($rn->rn_cabang == $cabang->kode) selected @endif>
                                      {{$cabang->nama}}
                                    </option>
                                  @endforeach
                                  </select>
                              @endif
                            </tr>

                          <tr>
                            <td width="150px">
                          No Return
                            </td>
                            <td>
                               <input type="text" class="form-control notareturn input-sm disabled" name="nota" value="{{$rn->rn_nota}}" readonly="">

                               <input type="hidden" class="form-control idrn input-sm disabled"  value="{{$rn->rn_id}}" readonly="" name="idrn">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                            </td>
                          </tr>

                          <tr>
                            <td>   Tanggal </td>
                            <td>
                             <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control disabled" name="tgl" required="" value="{{ Carbon\Carbon::parse($rn->rn_tgl)->format('d-M-Y ') }}">
                              </div>
                            </td>
                          </tr>
                       
                          <tr>
                            <td>
                              Supplier
                            </td>
                            <td>
                              <select class="form-control chosen-select supplier disabled" required="" name="supplier">
                              @foreach($data['supplier'] as $supplier)
                                <option value="{{$supplier->idsup}}" @if($rn->rn_supplier == $supplier->idsup) selected @endif >
                                        {{$supplier->no_supplier}} - {{$supplier->nama_supplier}}
                                </option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td> Keterangan </td>
                            <td> <input type="text" class="form-control input-sm disabled" name="keterangan" required value="{{$rn->rn_keterangan}}"></td>
                          </tr>
                          
                          @endforeach
                          </table>
                       
                      </div>

                    
                    
                      </div>

                      <hr>

                        
                    <!--   <button class="btn btn-sm btn-primary  createmodalpo" id="createmodal_po" data-toggle="modal" data-target="#myModal5" type="button"> <i class="fa fa-plus"> Tambah Data PO </i> </button> -->
                      <button class="btn btn-sm editdata btn-warning" type="button"> <i class="fa fa-pencil"> </i> Edit Data </button>  &nbsp; <button class="btn btn-sm btn-success tmbhdatabarang" type="button" data-toggle="modal" data-target="#myModalbarang"> <i class="fa fa-plus"> </i> Tambah Data Barang </button>  


                      <div class="col-sm-12">
                       
                          <div class="col-sm-8">
                          <br>
                              <table class="table">

                                  @foreach($data['rn'] as $rn)
                                  <tr>
                                  <th> No PO </th>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm nopo" readonly="" name="nopo" value="{{$rn->po_no}}"> <input type="hidden" class="form-control input-sm idpo" readonly="" name="idpo" value="{{$rn->po_id}}"> </div> <div class="col-sm-4"> <button class="btn btn-xs btn-info" type="button" onclick="lihatbarang()" data-toggle="modal" data-target="#myModal7"> <i class="fa fa-search"> Lihat Data PO </i> </button> </div> </td>
                                  </tr>  
                                  
                                   <tr>
                                  <td> Sub Total </td>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm subtotal" name="subtotal" value="{{ number_format($rn->rn_subtotal, 2) }}" readonly=""> <input type="hidden" class="subtotalpo" value="{{$rn->po_subtotal}}">    </div></td>
                              </tr>

                              <tr>
                                  <td> Jenis PPn </td>
                                  <td> <div class="col-sm-7"> <select class="form-control jenisppn disabled" name="jenisppn" value="{{$rn->rn_jenisppn}}">
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
                                  <td> <div class="col-sm-5"> <input type="text" class="form-control input-sm inputppn" name="inputppn" value="{{$rn->rn_inputppn}}" readonly=""></div> <div class="col-sm-5"> <input type="text" class="form-control input-sm hasilppn" name="hasilppn" value="{{ number_format($rn->rn_hasilppn, 2) }}" readonly=""> <input type="hidden" class="hasilppnpo" value="{{$rn->po_hasilppn}}">  </div>  </td>
                              </tr>
                              <tr>
                                  <td> Total </td>
                                  <td> <div class="col-sm-7"> <input type="text" class="form-control input-sm total" name="total" value="{{ number_format($rn->rn_totalharga, 2) }}" readonly=""> </div> <input type="hidden" class="totalpo" value="{{$rn->po_totalharga}}">  </td>
                              </tr>
                              @endforeach
                              </table>
                              
                              <p style="color:red"> <i> *Hapus data yang tidak di perlukan </i></p>

                              <table class="table table-datatable" id="table-barang">
                              <thead>
                                  <tr> 
                                      <th> No </th>
                                      <th style="width:200px"> Nama Barang </th>
                                      <th> Qty PO </th>
                                      <th style="width:70px"> Qty Return </th>
                                      <th> Harga </th>
                                      <th> Total Harga </th>
                                     
                                  </tr>
                              </thead>
                              <tbody>
                                @foreach($data['rndt'] as $index=>$rndt)
                                  <tr class="databarang" data-barang="{{$rndt->rndt_item}}">
                                    <td> {{$index + 1 }} </td>
                                    <td> {{$rndt->nama_masteritem}} <input type="hidden" value="{{$rndt->rndt_item}}" class="itembarang" name='kodeitem[]'> </td>
                                    <td> {{$rndt->rndt_qtypo}} <input type='hidden' class='qtykirim{{$index}}' value="{{$rndt->rndt_qtypo}}" name="qtypo[]"></td>
                                    <td> <input type='text' class='form-control input-sm  edit qtyreturn qtyreturn{{$index}}' data-id='{{$index}}' name="qtyreturn[]"  required value="{{$rndt->rndt_qtyreturn}}" readonly="">  </td>
                                    <td> {{ number_format($rndt->rndt_harga, 2) }} <input type='hidden' class='form-control input-sm jumlahharga{{$index}}' value="{{number_format($rndt->rndt_harga, 2) }}" readonly name="jumlahharga[]"></td>
                                    <td>   <input type='text' class='form-control input-sm totalharga{{$index}}' value="{{number_format($rndt->rndt_totalharga, 2) }}" readonly name='totalharga[]'> <input type='hidden' class='minusharga minusharga{{$index}}'> <input type='hidden'  value="{{$rndt->podt_lokasigudang}}" name='lokasigudang[]'></td>
                                   
                                  </tr>
                                @endforeach
                              </tbody>  
                              </table>
                          </div>
                          

                      </div>

                    <!-- Modal barang -->
                      <div class="modal inmodal fade" id="myModalbarang" tabindex="-1" role="dialog"  aria-hidden="true" style="min-width:100px">
                               <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                     <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title"> Data Barang PO </h4>     
                                       </div>

                                <div class="modal-body">
                                   <table class="table table-datatable table-bordered table-stripped" id="table-barangpo">
                                      <thead>
                                      <tr>
                                          <th> No </th>
                                          <th> No PO </th>
                                          <th> Barang </th>
                                          <th> Qty Po </th>
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
                              <button type="button" class="btn btn-primary" id="buttongetbarang">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> 

                    <!-- End Modal Barang -->


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

                         <!--  <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div> -->
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
                  
                    <a class="btn btn-sm btn-warning kembali" href={{url('purchase/returnpembelian')}}> Kembali </a>
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

<div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No Faktur:  <u>{{$data['faktur'][0]->fp_nofaktur or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">   
                          <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> ID Akun </th>
                                            <th> Akun</th>
                                            <th> Debit</th>
                                            <th> Kredit</th>
                                            <th style="width:100px"> Uraian / Detail </th>                                         
                                        </tr>
                                    </thead>
                                    
                                </table>                            
                          </div>                          
                    </div>
                  </div>
                </div>
<button class="btn btn-info" id="test"> test </button>
<div class="row" style="padding-bottom: 50px;"></div>



@endsection



@section('extra_scripts')
<script type="text/javascript">

    $('.tmbhdatabarang').hide();

    $('.editdata').click(function(){
        $('.tmbhdatabarang').show();
        $('.edit').attr('readonly' , false);
        $('.simpanitem').show();
        $('.kembali').show();
    })


    $('#test').click(function(){
      $.ajax({
        type : "get",
        url : baseUrl + '/kartuhutangrekap',
        dataType : "json",
        success:function(response){
          
        }
      })
    })


     function lihatjurnal($ref,$note){
    nota = $ref;
          detail = $note;

          $.ajax({
          url:baseUrl +'/fakturpembelian/jurnalumum',
          type:'get',
          data:{nota,detail},
          dataType : "json",
          success:function(response){
                $('#jurnal').modal('show');
                hasilpph = $('.hasilpph_po').val();
                hasilppn = $('.hasilppn_po').val();

             $('.loading').css('display', 'none');
                $('.listjurnal').empty();
                $totalDebit=0;
                $totalKredit=0;
                        console.log(response);
                    
                        for(key = 0; key < response.countjurnal; key++) {
                           
                          var rowtampil2 = "<tr class='listjurnal'>" +
                          "<td> "+response.jurnal[key].id_akun+"</td>" +
                          "<td> "+response.jurnal[key].nama_akun+"</td>";

                          
                            if(response.jurnal[key].dk == 'D'){
                              $totalDebit = parseFloat(Math.abs($totalDebit)) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td>";
                            }
                            else {
                              $totalKredit = parseFloat(Math.abs($totalKredit)) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td> </td><td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td>";
                            }
                         

                            rowtampil2 += "<td>"+response.jurnal[key].jrdt_detail+"</td>";
                            $('#table_jurnal').append(rowtampil2);
                        }
                     var rowtampil1 = "</tbody>" +
                      "<tfoot>" +
                          "<tr class='listjurnal'> " +
                                  "<th colspan='2'>Total</th>" +                        
                                  "<th>"+accounting.formatMoney($totalDebit, "", 2, ",",'.')+"</th>" +
                                  "<th>"+accounting.formatMoney($totalKredit,"",2,',','.')+"</th>" +
                                  "<th>&nbsp</th>" +
                          "<tr>" +
                      "</tfoot>";
                                     
                   
                      $('#table_jurnal').append(rowtampil1);
              }
        });
  }


    $('.simpanitem').hide();
    $('.kembali').hide();
    $('#buttongetbarang').click(function(){

      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();

     // alert(checked);

       var datapo = [];
       var datapo = checked;
       idpo = [];
       kodeitem = [];
       for($i = 0; $i < datapo.length; $i++){
          datadata = datapo[$i].split(",");
          idpo.push(datadata[0]);
          kodeitem.push(datadata[1]);
       }

       $.ajax({
         url : baseUrl + '/returnpembelian/hasilbarangpo',
         data : {idpo, kodeitem},
         dataType : 'json',
         type : "get",
         success : function(response){
          $('#myModalbarang').modal('toggle');
            var barangheader = $('#table-barang').DataTable();
           
            $n = 1;
            table2 = response.po;
            nmrbnk = 1;
            $nomor = $('.databarang').length + 1;

            for(i = 0; i < response.po.length; i++){  
              var html = "<tr class='databarang data"+$nomor+"' id="+table2[i].po_id+" data-nopo='"+table2[i].po_noform+"'>" +
                            "<td>"+$nomor+"</td>" +
                            "<td style='width:200px'> <p style='width:200px'>"+table2[i].nama_masteritem+"</p> <input type='hidden' class='kodeitem"+$nomor+"' value='"+table2[i].podt_kodeitem+"' name='kodeitem[]'></td>" + // no faktur
                            "<td>"+table2[i].podt_qtykirim+"<input type='hidden' class='qtykirim"+$nomor+"' value='"+table2[i].podt_qtykirim+"' name='qtypo[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm  qtyreturn qtyreturn"+$nomor+"' data-id='"+$nomor+"' name='qtyreturn[]' style='width:70px' required></td>" +
                            "<td> <input type='text' class='form-control input-sm jumlahharga"+$nomor+"' value="+addCommas(table2[i].podt_jumlahharga)+" readonly name='jumlahharga[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm totalharga"+$nomor+"' value="+addCommas(table2[i].podt_totalharga)+" readonly name='totalharga[]'> <input type='hidden' class='minusharga minusharga"+$nomor+"'> <input type='hidden'  value='"+table2[i].podt_lokasigudang+"' name='lokasigudang[]'> </td>" +
                            "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+$nomor+"' type='button'><i class='fa fa-trash'></i></button> </td>" +
                           "</tr>";
                     
              barangheader.rows.add($(html)).draw(); 
               nmrbnk++; 
            }

             $('.qtyreturn').each(function(){
                  $(this).change(function(){
                    dataid = $(this).data('id');
                    qty = $(this).val();
                    qtykirim = $('.qtykirim' + dataid).val();
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
                      hasilminus = 0;
                      $('.minusharga').each(function(){
                        valminus2 = $(this).val();
                        alert(valminus2);
                        if(valminus2 != ''){
                          valminus = valminus2.replace(/,/g, ''); 
                          alert(valminus);
                          hasilminus = parseFloat(parseFloat(hasilminus) + parseFloat(valminus)).toFixed(2);
                          // alert(subtotal);   
                         // alert(valminus); 
                         
                          // alert(hargasubtotal);
                        }

                      })
                  alert(hasilminus);
                    hargasubtotal = parseFloat(parseFloat(subtotal) - parseFloat(hasilminus)).toFixed(2);
                    //  alert(hargasubtotal);
                      $('.subtotal').val(addCommas(hargasubtotal));
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
                  })
                })

                 tablebarang = $('#table-barang').DataTable();
                $('.removes-btn').click(function(){
                 tablebarang.row( $(this).parents('tr') )
                  .remove()
                  .draw();
                })
         }
     })

    })


       $('.qtyreturn').each(function(){
                  $(this).change(function(){
                   /* alert('halo');*/
                    dataid = $(this).data('id');
                    qty = $(this).val();
                    qtykirim = $('.qtykirim' + dataid).val();
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
                      subtotal2 = $('.subtotalpo').val();            
                      jenisppn = $('.jenisppn').val();
                      inputppn = $('.inputppn').val();
                      hasilppn2 = $('.hasilppnpo').val();
                      totalharga2  =$('.totalpo').val();

                      subtotal =  subtotal2.replace(/,/g, ''); 
                      hasilppn =  hasilppn2.replace(/,/g, ''); 
                      totalharga =  totalharga2.replace(/,/g, ''); 
                      hasilminus = 0;
                      $('.minusharga').each(function(){
                        valminus2 = $(this).val();
                        alert(valminus2);
                        if(valminus2 != ''){
                          valminus = valminus2.replace(/,/g, ''); 
                          alert(valminus);
                          hasilminus = parseFloat(parseFloat(hasilminus) + parseFloat(valminus)).toFixed(2);
                          // alert(subtotal);   
                         // alert(valminus); 
                         
                          // alert(hargasubtotal);
                        }

                      })

                      alert(hasilminus);
                      hargasubtotal = parseFloat(parseFloat(subtotal) - parseFloat(hasilminus)).toFixed(2);
                    //  alert(hargasubtotal);
                      $('.subtotal').val(addCommas(hargasubtotal));
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
                  })
                })

    $('.tmbhdatabarang').click(function(){
      idpo = $('.idpo').val();
      databarang = [];
      $('tr.databarang').each(function(){
          val = $(this).data('barang');
         // alert(val);
          databarang.push(val);
      })

     
       $.ajax({
       url : baseUrl + '/returnpembelian/getbarangpo',
       data : {idpo, databarang},
       dataType : 'json',
       type : "get",
       success : function(response){
         /* alert(response.podt.length);*/
          $('#myModal5').modal('hide');
          var barangheader = $('#table-barangpo').DataTable();
          barangheader.clear().draw();
          $n = 1;
          
  
          for($i = 0; $i < response.countpodt; $i++){  
              html = "<tr>" +
                      "<td>"+$n+"</td>" +
                      "<td>"+response.podt[$i].po_no+"</td>" +
                      "<td>"+response.podt[$i].nama_masteritem+"</td>" +
                      "<td>"+response.podt[$i].podt_qtykirim+"</td>"+
                     
                      "<td> <div class='checkbox'> <input type='checkbox' id="+response.podt[$i].po_id+","+response.podt[$i].podt_kodeitem+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                        "<label></label>" +
                                        "</div> </td>";
            barangheader.rows.add($(html)).draw(); 
            $n++;  
          }
       }
      })
    })

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
                            "<td style='width:200px'> <p style='width:200px'>"+table2[i].nama_masteritem+"</p> <input type='hidden' class='kodeitem"+nmrbnk+"' value='"+table2[i].podt_kodeitem+"' ></td>" + // no faktur
                            "<td>"+table2[i].podt_qtykirim+"<input type='hidden' class='qtykirim"+nmrbnk+"' value='"+table2[i].podt_qtykirim+"' name='qtypo[]'> </td>" +                           
                            "<td> <input type='text' class='form-control input-sm jumlahharga"+nmrbnk+"' value="+addCommas(table2[i].podt_jumlahharga)+" readonly name='jumlahharga[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm totalharga"+nmrbnk+"' value="+addCommas(table2[i].podt_totalharga)+" readonly name='totalharga[]'> <input type='hidden' class='minusharga minusharga"+nmrbnk+"'> <input type='hidden' value='"+table2[i].podt_lokasigudang+"' name='lokasigudang[]'> </td>" +
                            "<td>  </td>" +
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
          var post_url2 = baseUrl + '/returnpembelian/update';
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


                var tablebarang = $('#table-barang').DataTable();
                tablebarang.clear().draw();
                var nmrbnk = 1;
                table2 = response.po;       
                 for(var i = 0; i < table2.length; i++){  
                       var html2 = "<tr class='databarang data"+nmrbnk+"' id="+table2[i].po_id+" data-nopo='"+table2[i].po_noform+"'>" +
                            "<td>"+nmrbnk+"</td>" +
                            "<td style='width:200px'> <p style='width:200px'>"+table2[i].nama_masteritem+"</p> <input type='hidden' class='kodeitem"+nmrbnk+"' value='"+table2[i].podt_kodeitem+"' name='kodeitem[]'></td>" + // no faktur
                            "<td>"+table2[i].podt_qtykirim+"<input type='hidden' class='qtykirim"+nmrbnk+"' value='"+table2[i].podt_qtykirim+"' name='qtypo[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm  qtyreturn qtyreturn"+nmrbnk+"' data-id='"+nmrbnk+"' name='qtyreturn[]' style='width:70px' required></td>" +
                            "<td> <input type='text' class='form-control input-sm jumlahharga"+nmrbnk+"' value="+addCommas(table2[i].podt_jumlahharga)+" readonly name='jumlahharga[]'> </td>" +
                            "<td> <input type='text' class='form-control input-sm totalharga"+nmrbnk+"' value="+addCommas(table2[i].podt_totalharga)+" readonly name='totalharga[]'> <input type='hidden' class='minusharga minusharga"+nmrbnk+"'> <input type='hidden' class='minusharga' value='"+table2[i].podt_lokasigudang+"' name='lokasigudang[]'> </td>" +
                            "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+nmrbnk+"' type='button'><i class='fa fa-trash'></i></button> </td>" +
                           "</tr>";
                          
                       tablebarang.rows.add($(html2)).draw(); 
                      nmrbnk++;                                                                                  
                 } 

                $('.qtyreturn').each(function(){
                  $(this).change(function(){
                    dataid = $(this).data('id');
                    qty = $(this).val();
                    qtykirim = $('.qtykirim' + dataid).val();
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
                      $('.minusharga').each(function(){
                        valminus2 = $(this).val();

                        if(valminus2 != ''){
                          valminus = valminus2.replace(/,/g, ''); 
                          hargasubtotal = parseFloat(parseFloat(subtotal) - parseFloat(valminus)).toFixed(2);
                          // alert(subtotal);   
                         // alert(valminus); 
                         
                          // alert(hargasubtotal);
                        }

                      })
                    //  alert(hargasubtotal);
                      $('.subtotal').val(addCommas(hargasubtotal));
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
                  })
                })

                 tablebarang = $('#table-barang').DataTable();
                $('.removes-btn').click(function(){
                 tablebarang.row( $(this).parents('tr') )
                  .remove()
                  .draw();
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
        $.ajax({    
          type :"get",
          data : {supplier},
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
          }

        })
   })

</script>
@endsection
