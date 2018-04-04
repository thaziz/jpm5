@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2> Faktur Pembelian </h2>
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
				<strong> Detail Faktur Pembelian </strong>
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
                    <h5> Detail Faktur Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>                   
                      <div class="text-right">
                        <a class="btn btn-default" href="{{url('fakturpembelian/fakturpembelian')}}" aria-hidden="true"> <i class="fa fa-arrow-left" aria-hidden="true"> Kembali </i> </a>
                      </div>
                    
                </div>
              
			  <div class="ibox-content">
               <div class="row">
            <div class="col-xs-12">

 @if(count($jurnal_dt)!=0)
                    <div class="pull-right">
                         <a onclick="lihatjurnal('{{$data['faktur'][0]->fp_nofaktur or null}}','FP ITEM')" class="btn-xs btn-primary" aria-hidden="true"> 
                          <i class="fa  fa-eye"> </i>
                           &nbsp;  Lihat Jurnal  
                         </a> 
                    </div>
@endif

               <form method="post" action=""  enctype="multipart/form-data" class="form-horizontal" id="updatefp" >
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                         <table border="0" class="table">
                         
                         @foreach($data['faktur'] as $faktur)
                          <tr>
                            <td width="150px"> Cabang </td>
                            <td> <input type="text" class="input-sm form-control" value="{{$faktur->nama}}" readonly=""> <input type="hidden" class="input-sm form-control cabang" value="{{$faktur->fp_comp}}" readonly=""> <input type="hidden" name="_token" value="{{ csrf_token() }}">  </td>
                          </tr>

                          <tr>                         
                            <td width="150px">
                            <b> No Faktur </b>
                            </td>
                            <td>
                              <input type='text' readonly="" class="input-sm form-control" value="{{$faktur->fp_nofaktur}}" name="nofaktur">
                              <input type='hidden' readonly="" class="input-sm form-control tampilpo" value="nope">

                            </td>
                          </tr>

                          <tr>
                            <td>
                              <b> No Invoice </b>
                            </td>
                            <td>
                              <input type="text" class="input-sm form-control edit " readonly="" value="{{$faktur->fp_noinvoice}}" name="invoice">
                            </td>

                          </tr>

                          <tr>
                            <td> <b>  Tanggal </b> </td>
                            <td>
                              
                              <div class="input-group date">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="tgl" required="" value="{{ Carbon\Carbon::parse($faktur->fp_tgl)->format('d-M-Y') }}" readonly="">
                                </div>
                            </td>
                            </tr>
                         <tr>
                            <td>
                             <b> Jatuh Tempo </b>
                           
                            <td>
                                 <input type="text" class="form-control jatuhtempo_po" readonly="" value="{{ Carbon\Carbon::parse($faktur->fp_jatuhtempo)->format('d-M-Y') }}">
                            </td>


                          </tr>
                          
                          <tr>
                            <td> <b> Supplier </b> </td>
                            <td> <input type="text" class="form-control" readonly="" value="{{$faktur->nama_supplier}}">
                                 <input type="hidden" class="form-control idsup" readonly="" value="{{$faktur->idsup}}">

                            </td>
                           
                          </tr>

                          <tr>
                            <td>
                              <b> Tipe </b>
                            </td>
                            <td> <input type="text" readonly=""  class="form-control" value="{{$faktur->fp_tipe}}"> </td>
                          </tr>

                          <tr>
                            <td>
                              <b> Keterangan </b>
                            </td>
                            <td>
                             <input type="text" class="form-control edit" readonly="" value="{{$faktur->fp_keterangan}}" name="keterangan">
                            </td>

                          </tr>
                          @endforeach
                          </table>
                      </div>

                      <div class="col-sm-6">
                         <table class='table' style="width:100%">
                         @foreach($data['faktur'] as $faktur)                 
                      <tr>
                        <td> <b> Jumlah </b> </td>
                        <td> <div class="row"> <div class="col-md-3"> Rp </div> <div class="col-md-9"> <input type='text' class='form-control jumlahharga_po' name='jumlahtotal_po' style='text-align: right' readonly="" value="{{ number_format($faktur->fp_jumlah, 2) }}"> </div> </div> </td>
                      </tr>
                      <tr>
                        <td> <b> Discount </b> </td>
                        <td>
                          <div class="row"> <div class="col-md-3"> <input type="text" class="form-control disc_item_po" name="disc_item_po" readonly="" value="{{$faktur->fp_discount}}"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasildiskon_po" readonly=""  style="text-align: right" value="{{ number_format($faktur->fp_hsldiscount, 2) }} " name="hasildiskon_po"> </div>  </div>

                         </td>
                      </tr>
                      <tr>
                        <td> <b> Jenis PPn </b> </td>
                        <td>  <div class="col-xs-4"> 
                        <select class='form-control jenisppn_po edit' name="jenisppn_po" disabled="">
                          @if($faktur->fp_jenisppn == 'T')
                          <option value='T' selected> Tanpa </option>
                           <option value='E'> Exclude </option>
                          <option value="I"> Include </option>
                          @elseif($faktur->fp_jenisppn == 'E')
                            <option value = 'T'> Tanpa </option>
                           <option value='E' selected=""> Exclude </option>
                          <option value="I"> Include </option>
                          @elseif($faktur->fp_jenisppn == 'I')
                             <option value = 'T'> Tanpa </option>
                           <option value='E'> Exclude </option>
                          <option value="I" selected=""> Include </option>
                          @else
                           <option value = 'T' selected=""> Tanpa </option>
                           <option value='E'> Exclude </option>
                          <option value="I"> Include </option>
                          @endif

                        </select> </div> <div class="col-xs-6"> &nbsp;  <button type="button" class="btn btn-primary" id="createmodal_pajakpo" data-toggle="modal" data-target="#myModal1">  Faktur Pajak </button> </div> </td>
                      </tr>
                      <tr>
                        <td> <b> DPP </b> </td>
                        <td> <div class="row"> <div class='col-md-3'> Rp </div> <div class='col-md-9'> <input type='text' class='form-control dpp_po' readonly="" name='dpp_po' style="text-align: right" value="{{ number_format($faktur->fp_dpp, 2) }}">  <input type='hidden' class='form-control dpp_po2' readonly=""  style="text-align: right" value="{{number_format($faktur->fp_dpp, 2)}}">
                        </div> </div> </td>
                      </tr>
                      <tr>
                        <td> <b> PPn % </b> </td>
                        @if($faktur->fp_ppn != '')
                          <td> <div class="row">  <div class="col-md-3"> <input type="text" class="form-control inputppn_po edit" value="{{$faktur->fp_inputppn}}" readonly="" name="inputppn_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasilppn_po" readonly=""  style="text-align: right" name="hasilppn_po" value="{{ number_format($faktur->fp_ppn, 2) }}"> </div> </div>  </td>
                        
                        @else
                           <td> <div class="row">  <div class="col-md-3"> <input type="text" class="form-control inputppn_po" value="" name="inputppn_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasilppn_po" readonly=""  style="text-align: right" name="hasilppn_po" value=""> </div> </div>  </td>
                        @endif
                      
                      </tr>
                      <tr>
                         <td style='text-align: right'>
                          <select class='form-control pajakpph_po edit' name="jenispph_po" disabled="">
                            @if($faktur->fp_pph != '')
                              @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'   @if($pajak->nama == $faktur->fp_jenispph) selected @endif> {{$pajak->nama}}</option> @endforeach
  
                            @else
                              <option value=""> Pilih Pajak PPH
                              </option>

                              @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'   @if($pajak->nama == $faktur->fp_jenispph) selected @endif> {{$pajak->nama}}</option> @endforeach
                              
                            @endif
                            
                          </select> </td>

                         <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control inputpph_po" readonly=""> </div> <div class="col-md-8"> <input type="text" class="form-control hasilpph_po" style='text-align: right' readonly="" name='hasilpph_po' value="{{ number_format($faktur->fp_pph, 2) }}"> </div> </div> </td>
                      </tr>
                      <tr>
                        <td> <b> Netto Hutang </b> </td>
                        <td> <input type='text' class='form-control nettohutang_po' readonly="" name="nettohutang_po" style="text-align: right" value="{{ number_format($faktur->fp_netto, 2) }}"> <input type="hidden" name="idfaktur" value="{{$faktur->fp_idfaktur}}" class="idfaktur">  </td>
                      </tr>
                      @endforeach

                       <tr>
                            <td colspan="2">   <button class="btn btn-info" style="margin-right: 10px;" type="button" id="createmodal_tt" data-toggle="modal" data-target="#myModal_TT" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button> </td>
                       </tr>

                          <input type='hidden' name='dpp_fakturpembelian' class='dppfakturpembelian'>
                          <input type='hidden' name='hasilppn_fakturpembelian' class='hasilppnfakturpembelian'>
                          <input type='hidden' name='inputppn_fakturpembelian' class='inputppnfakturpembelian'> 
                          <input type='hidden' name='jenisppn_faktur' class='jenisppnfaktur'>                
                          <input type='hidden' name='masapajak_faktur' class='masapajakfaktur'>                     
                          <input type='hidden' name='netto_faktur' class='nettofaktur'>                              
                          <input type='hidden' name='nofaktur_pajak' class='nofakturpajak'>                            
                          <input type='hidden' name='tglfaktur_pajak' class='tglfakturpajak'>   
                          <input type='hidden' class='inputfakturpajakmasukan' value="sukses">
                          <input type='hidden' class='inputtandaterima' value="sukses">

                          <!-- TT -->
                           <input type='hidden' name='lainlain_tt2' class='lainlain_tt2' value="{{$data['tt'][0]->tt_lainlain}}">
                           <input type='hidden' name='notandaterima2' class='notandaterima2'>
                     </table>
                      </div>
                      </div>

                      
                      <table class="table" border="0">
                      <tr>
                        <td style="width:200px"> <h4> Detail Faktur </h4> </td>
                        <td> 
                          <!--  <button class="btn btn-primary" style="margin-right: 10px;" type="text" id="createmodal" data-toggle="modal" data-target="#myModal5"><i class="fa fa-book">&nbsp;Buat Tanda Terima</i></button> 
                       &nbsp;
                        -->
                           <a class="btn btn-sm btn-info " href="{{url('fakturpembelian/cetaktt/'.$data['tt'][0]->tt_idform.'')}}" "><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>   &nbsp;

                           @if($data['faktur'][0]->fp_status == 'Approved')

                           @else
                             <a class="btn btn-sm btn-warning ubah"> <i class="fa fa-pencil"> </i> &nbsp; Ubah Data </a>
                           @endif
                          
                        </td>
                      </tr>
                      </table>
                  

          <div class="box-body">
				  <div class="row">
                   <div class="col-md-12">
                     @if($data['faktur'][0]->fp_tipe != 'PO')

                    <button class="btn btn-sm btn-success tmbh-brg" type="button" id="createmodal_brg" data-toggle="modal" data-target="#myModalBrg" ><i class="fa fa-book">&nbsp; Tambah Data Barang </i></button>
                    <div class="table-responsive">
                      <table class="table  table-striped tbl-penerimabarang" id="tablefp">
                      <tr >
                        <thead>
                          <th> No </th>
                          <th width="150px"> Nama Item </th>
                          <th width="80px"> Qty </th>
                          <th width="150px">Gudang </th>
                          <th width="100px"> Harga / unit </th>
                          <th> Amount </th>
                          <th width="80px"> Update Stock ? </th>
                          <th width="80px"> Diskon </th>
                          <th>  Biaya </th>
                       
                          <th> Account Biaya </th>
                          <th> Account Persediaan </th>
                          <th> Keterangan</th>
                        </thead>

                      </tr>
                      <tbody>
                          @foreach($data['fakturdtpo'] as $index=>$fakturdt)
                         


                         <tr class="fpitem" id="data-item{{$index + 1}}"> <td>{{$index + 1}}</td>

                        <td> <select class="form-control barangitem brg{{$index + 1}} edit"  name="item[]" data-id="{{$index + 1}}" disabled="">
                         @foreach($data['barang'] as $brg)
                         <option value="{{$brg->kode_item}}" @if($fakturdt->kode_item == $brg->kode_item) selected @endif> {{$brg->nama_masteritem}} </option>
                          @endforeach </select>  </td>  <!-- nama barang -->

                        <td> <input type="text" class="form-control qtyitem qtyitem{{$index + 1}} edit" value="{{$fakturdt->fpdt_qty}}" name="qty[]" data-id="{{$index +1}}" readonly=""> 

                        <!-- qty -->
                        
                        <td> <select class="form-control gudangheader edit gudangitem gudangitem{{$index + 1}}" name="gudang[]" disabled=""> @foreach($data['gudang'] as $gudang)  <option value="{{$gudang->mg_id}}" @if($fakturdt->fpdt_gudang == $gudang->mg_id) selected @endif> {{$gudang->mg_namagudang}} </option> @endforeach</select> </td> <!-- gudang -->

                        <td> <input type='text' class='form-control hargaitem hargaitem{{$index + 1}} edit' value="{{ number_format($fakturdt->fpdt_harga, 2)}}" name="harga[]" data-id="{{$index + 1}}" readonly=""></td><!-- "+ //harga -->

                        <td> <input type="text" class="form-control totalbiayaitem totalbiayaitem{{$index + 1}}" value="{{number_format($fakturdt->fpdt_totalharga, 2) }}" name="totalharga[]" readonly=""> </td> <!-- //total harga -->

               

                        <td> <input type="text" class="form-control updatestockitem updatestockitem{{$index + 1}}" value="{{$fakturdt->fpdt_updatedstock}}"  name='updatestock[]' readonly=""> </td><!-- "+ // updatestock -->

                        @if($fakturdt->fpdt_diskon == '')
                        <td> <input type="text" class="form-control diskonitem2 diskonitem2{{$index + 1}} edit" value="0" name='diskonitem[]' data-id="{{$index + 1}}" readonly="" > </td><!--  //diskon -->
                        @else
                       
                         <td> <input type="text" class="form-control diskonitem2 diskonitem2{{$index + 1}} edit" value=" {{$fakturdt->fpdt_diskon}}" name='diskonitem[]' data-id="{{$index + 1}}" readonly=""> </td>
                        @endif
                        

                       <td>  <input type='text' class="form-control biayaitem biayaitem{{$index + 1}}" value="{{$fakturdt->fpdt_biaya}}"  name='biaya[]' readonly=""> </td> <!-- "+ //biaya -->

                      <td> <input type="text" class="form-control acc_biayaitem acc_biayaitem{{$index + 1}} " value="{{$fakturdt->fpdt_accbiaya}} " name='acc_biaya[]' readonly=""> </td> <!-- "+ //acc_biaya -->

                      <td> <input type="text" class="form-control acc_persediaanitem acc_persediaanitem{{$index + 1}} " value='{{$fakturdt->fpdt_accpersediaan}}' name='acc_persediaan[]' readonly=""> </td> <!-- "+ //acc_persediaan -->

                      <td> <input type='text' class="form-control keteranganitem keteranganitem{{$index + 1}} edit" value="{{$fakturdt->fpdt_keterangan}}"  name='keteranganitem[]' readonly="">  <input type='hidden' name='penerimaan[]' class='penerimaan' value=""></td>
                          
                      <td class='edit{{$index + 1}}'> <button class='btn btn-sm btn-danger removes-itm' data-id='{{$index + 1}}' type='button'> <i class='fa fa-trash'></i> </button></td> 

                       
                      </tr>
                      

                      @endforeach
                      </tbody>


                        <input type="hidden" value="ITEM" name="flag">
                         <input type="hidden" value="{{$fakturdt->fpdt_groupitem}}" class="grupitem" name="grupitem">
                         <input type="hidden" value="{{$fakturdt->fpdt_updatedstock}}" class="updatedstock">
                       <!--   <input type="hidden" value="{{$fakturdt->fpdt_gudang}}" class="gudangheader"> -->
                      </table>
                      @else
                       <button class="btn btn-sm btn-success tmbh-po" type="button" id="createmodal_po" data-toggle="modal" data-target="#myModal2" ><i class="fa fa-book">&nbsp; Tambah Data PO </i></button>

                        <div class="loading text-center" style="display: none;">
                            <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                        </div>

                      <table class="table table-striped tbl-penerimabarang" id="tbl-po">
                      <tr>
                        <thead>
                       
                          <th width="200px"> No Bukti</th>
                          <th width="150px"> Nama Item </th>
                          <th width="70px"> Qty </th>                       
                          <th width="150px"> Harga / unit </th>
                          <th> Total Harga </th>
                          <th> Update Stock ? </th>
                          <th> Account Persediaan </th>
                          <th> Account Hpp </th>
                          <th> </th>
                         
                        </thead>

                      </tr>
                      <tbody>
                          @foreach($data['fakturdtpo'] as $index=>$fakturdt)
                          <tr class="fakturdt{{$fakturdt->po_id}}" data-id="{{$fakturdt->po_no}}" id="faktur{{$fakturdt->po_no}}">
                        
                                @if($data['status'] == 'PO')
                                    <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->po_no}}" readonly=""> </td>
                                @else 
                                    <td> {{$fakturdt->fp_nofaktur}}</td>
                                @endif
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->nama_masteritem}}" readonly="">
                                <input type="hidden" value="{{$fakturdt->kode_item}}" name="kodeitem[]">
                                <input type="hidden" value="PO" name="flag">
                            </td>
                            <td> <input type="text" class="form-control input-sm" value=" {{$fakturdt->fpdt_qty}}" name="qty[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{ number_format($fakturdt->fpdt_harga, 2) }}" name="harga[]" readonly="">  </td>
                            <td> <input type="text" class="form-control input-sm totalharga{{$fakturdt->po_id}}" value="{{ number_format($fakturdt->fpdt_totalharga, 2) }}" name="totalharga[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->fpdt_updatedstock}}" name="updatestock[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->fpdt_accbiaya}}" name="accbiaya[]" readonly="">  </td>
                            <td> <input type="text" class="form-control input-sm" value=" {{$fakturdt->fpdt_accpersediaan}}" name="accpersediaan[]" readonly=""> <input type="hidden" class="form-control input-sm" value=" {{$fakturdt->po_id}}" name="po_id[]" readonly="">   </td>
                            <td> <button class='btn btn-sm btn-danger removes-btn' data-id="{{$fakturdt->po_id}}" type='button'><i class='fa fa-trash'></i></button> </td>
                          </tr>
                          @endforeach
                      </tbody>
                      </table>

                      @endif
                      </div>
					  </div>
                   </div>
                   </div>
                <!-- FORM TANA TERIMA -->
                                 <div class="modal fade" id="myModal_TT" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                      <h4 class="modal-title" style="text-align: center;"> FORM TANDA TERIMA </h4>     
                                    </div>
                                                  
                                    <div class="modal-body">              
                                    <table class="table table-stripped">
                                      <tr>
                                        <td width="150px">
                                          No Tanda Terima 
                                        </td>
                                        <td>
                                          <input type='text' class='input-sm form-control notandaterima' readonly="" value="{{$data['tt'][0]->tt_noform}}">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> Tanggal </td>
                                        <td>
                                           <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" value="{{ Carbon\Carbon::parse($data['tt'][0]->tt_tgl)->format('d-M-Y ') }}" readonly="">
                                          </div>
                                        </td>
                                      </tr>
                                     
                                      <tr>
                                        <td> Supplier </td>
                                        <td> <input type='text' class="form-control supplier_tt" value="{{$data['tt'][0]->nama_supplier}}" readonly=""></td>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">
                                           <div class="row">
                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="Kwitansi" type="checkbox" checked="">
                                                      <label for="Kwitansi">
                                                          Kwitansi / Invoice / No
                                                      </label>
                                                </div> 
                                              </div>
                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="FakturPajak" type="checkbox" checked="">
                                                      <label for="FakturPajak">
                                                          Faktur Pajak
                                                      </label>
                                                </div> 
                                              </div>

                                              <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="SuratPerananAsli" type="checkbox" checked="">
                                                      <label for="SuratPerananAsli">
                                                          Surat Peranan Asli
                                                      </label>
                                                </div> 
                                              </div>

                                               <div class="col-sm-3"> 
                                                <div class="checkbox checkbox-info checkbox-circle">
                                                    <input id="SuratJalanAsli" type="checkbox" checked="">
                                                      <label for="SuratJalanAsli">
                                                         Surat Jalan Asli
                                                      </label>
                                                </div> 
                                              </div>
                                            </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                         Lain Lain
                                        </td>
                                        <td>
                                        
                                          <input type="text" class="form-control lainlain_tt" name="lainlain" value="{{$data['tt'][0]->tt_lainlain}}">
                                        </td>
                                      </tr>

                                      <tr>
                                        <td> Tanggal Kembali </td>
                                        <td>   <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo_tt" readonly="" value="{{ Carbon\Carbon::parse($data['tt'][0]->tt_tglkembali)->format('d-M-Y ') }}">
                                          </div> </td>
                                      </tr>

                                      <tr>
                                        <td>
                                         Total di Terima
                                        </td>
                                        <td> <div class="row"> <div class="col-sm-3"> <label class="col-sm-3 label-control"> Rp </label> </div> <div class="col-sm-9"> <input type="text" class="form-control totalterima_tt"  style="text-align:right;" readonly=""></div> </div> </td>
                                      </tr>
                                     
                                       </table>                           
                                               
                                         </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                          <button type="button" class="btn btn-primary" id="buttonsimpan_tt">Simpan</button>
                                         
                                      </div>
                                      
                                  </div>
                                </div>
                             </div> 


                 <!-- MODAL PO -->
                  <div class="modal inmodal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title">Tambah Data PO </h4>     
                                       </div>

                                <div class="modal-body">
                                  <div class="loading"> </div>
                                    <table id="addColumn" class="table  table-bordered table-striped tbl-purchase">
                                       <thead>
                                         <tr>
                                          <th style="width:10px">No</th>
                                          <th> No PO </th>
                                         <th> Cabang </th>
                                          <th> Status </th>
                                          <th> Jumlah Harga </th>
                                          <th> Aksi </th>      
                                        </tr>
                                      </thead>                          
                                      <tbody>
                                       
                                      </tbody>
                                   </table>                              
                                   <div class="kosong"> </div>
                                </form>
                             </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetpo">Save changes</button>
                          </div>
                      </div>
                    </div>
			        </div> <!-- End Modal -->


                <!-- Modal Barang -->
                  <div class="modal inmodal fade" id="myModalBrg" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
						   <div class="modal-header">
							   <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
							<h4 class="modal-title">Tambah Data Barang </h4>     
						   </div>

                            <div class="modal-body" style="padding:8px">
							<div class="loading"> </div>
							<div class="com-sm-12">
								<div class='col-sm-6'>
                                <table class='table' style='width:90%'>
								<tr>
									<td> Pilih Group Item </td>
									<td> <select class="form-control groupitem" name="groupitem" disabled=""> 
											@foreach($data['jenisitem'] as $jenis)
										  <option value="{{$jenis->kode_jenisitem}}"> {{$jenis->keterangan_jenisitem}} </option> 
											@endforeach
											</select> 
										  
									 </td>
								</tr> 
								
                               <tr>
                                <td width='100px' id="tdupdatestock">
                                 Update Stock ?
                                </td>
                                <td id="tdupdatestock">
                                  <select class='form-control updatestock'  name="updatestock" required="" id="updatestock" readonly=""> <option value='Y' selected=""> Ya </option> <option value='T'> Tidak </option> </select>   
                                </td>
                              </tr>
                            
							<tr>
                                <td width='150px'> Nama Item : </td>
                                <td width="150px">
                                <select class='form-control chosen-select-width item' name="nama_item" required="" id="item"> 
                                        <option value=""> -- Pilih Barang -- </option>
                                        <option value=""> -- Pilih Barang -- </option>                              
                                        <option value=""> -- Pilih Barang -- </option>                              
                                        <option value=""> -- Pilih Barang -- </option>                              
                                                                  
                                </select>

                                <input type="hidden" class="stock"> 
							               	</td>
                              </tr>
							  
                              <tr>
                                <td> Qty </td>
                                <td>
                                  <input type='number' class='form-control qty input-sm' name="qty" required="">  
                                  <input type='hidden' class='form-control penerimaan' name="penerimaan" required="">  
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Gudang
                                </td>
                                <td>
                                <select class="form-control gudang" name="gudang" required="" disabled="">
                                    <option value=""> -- Pilih Gudang -- </option>
                                  @foreach($data['gudang'] as $gudang)
                                    <option value="{{$gudang->mg_id}}"> {{$gudang->mg_namagudang}} </option>
                                  @endforeach  
                                </select></td>
                              </tr>
                              
                              <tr>
                              <td>
                                Account Biaya
                              </td>
                              <td>
                                <input type='number' class='form-control acc_biaya input-sm' name="acc_biaya" required="">
                              </td>
                              </tr>
                              <tr>
                              <td>
                                Account Persediaan
                              </td>
                              <td>
                                <input type='number' class='form-control acc_persediaan input-sm' name="acc_persediaan" required="">
                              </td>
                              </tr>
                            </table>
							</div>
                           <div class='col-sm-6'>
                              <table class='table' style='width:100%'>
                              <tr>
                                <td style="width:100px">
                                  Harga
                                </td>
                                <td>
                                  <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control harga input-sm" style="text-align: right" name="harga" required=""> </div> </div>
                                </td>
                              </tr>
                              <tr>
                                <td>
                                  Total Harga
                                </td>
                                <td style="text-align: right"> 
                                 <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control amount input-sm" style="text-align: right" name="amount" readonly="" required=""> </div> </div>
                                </td>
                              
                              </tr>

                              <tr>
                                <td> Diskon </td>
                                <td> <div class="form-group"> <div class="col-md-3"> <input type='text' class='form-control diskon input-sm' name="diskon2" required=""> </div> <label class="col-sm-2 col-sm-2 control-label"> % </label> <div class="col-sm-7"> <input style='text-align: right' type="text" class="form-control hasildiskonitem"> </div> </div> </td>
                              </tr>


                              <tr>
                                <td>
                                  Biaya
                                </td>
                              <td style="text-align: right">

                                  <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control biaya input-sm" style="text-align: right" name="biaya" readonly="" required=""> </div> </div>
                                </td>
                              </tr>
                             


                              <tr>
                              <td>
                                Keterangan 
                              </td>
                              <td>
                                <input type='text' class='form-control keterangan input-sm' name="keterangan2" required="">
                              </td>
                              </tr>
                             </table>                           
                             
                                </form>
                             
                             </div>
							 </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetbrg">Save changes</button>
                          </div>
                      </div>
                    </div>
                </div> 
				</div><!-- End Modal -->
                <!-- End Barang -->

                @if(count($data['fpm']) != 0)

                <!-- Faktur Pajak Masukam -->
                  <div class="modal inmodal fade" id="myModal1" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
					  <div class="modal-content">
						 <div class="modal-header">
							 <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
						  <h4 class="modal-title">Faktur Pajak Masukan  </h4>     
						 </div>
                                    
									<div class="modal-body">
                                        <div class="row">
                                          <div class="col-sm-6">
                                            <table class='table'>
                                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <tr>
                                              <td style="width:120px"> Jenis PPn </td>
                                              <th> <input type='text' class='input-sm form-control jenisppn_faktur' name='jenisppn_faktur' readonly=""> </th>
                                            </tr>

                                              <tr> 
                                                <td> No Faktur Pajak </td>
                                                <td> <input type='text' class='form-control input-sm nofaktur_pajak' name='nofaktur_pajak' value="{{$data['fpm'][0]->fpm_nota}}"> </td>
                                              </tr>
                                              <tr>
                                                <td> Tanggal </td>
                                                <td>  <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control  tglfaktur_pajak" name="tglfaktur_pajak" required="" disabled="">
                                                    </div>
                                              </td>
                                              </tr>
                                            </table>
                                          </div>

                                          <div class="col-sm-6">
                                          <table class='table'>
                                            <tr>
                                              <td> Masa Pajak </td>
                                              <td> <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control masapajak_faktur " name="masapajak_faktur" required="" disabled="">
                                                    </div>
                                              </td>
                                            </tr>
                                            </table>
                                          </div>
                                        </div>


                                        <div class="row">
                                          <div class="col-sm-6">
                                              <h3 style='text-align: center'> FAKTUR PEMBELIAN </h3>

                                              <table class='table'>
                                              <tr>
                                                <td style="width:120px"> DPP </td>
                                                <td> <input type='text' class='form-control input-sm dpp_fakturpembelian' name='dpp_fakturpembelian' readonly="" style="text-align : right"> </td>
                                              </tr>
                                              <tr>
                                                <td> Ppn </td>
                                                <td> <div class='col-sm-4'> <input type='text' class='form-control input-sm inputppn_fakturpembelian' name='inputppn_fakturpembelian'> </div> <div class='col-sm-8'> <input type='text' class='form-control input-sm hasilppn_fakturpembelian' style="text-align : right" readonly="" name="hasilppn_fakturpembelian"> </div> </td>  
                                              </tr>
                                              </table>

                                          </div>
                                          <div class="col-sm-6">
                                              <h3 style='text-align: center'>  FAKTUR PAJAK </h3>
                                              <table class='table'>
                                                <tr>
                                                  <td> <input type='text' class='form-control input-sm dpp_fakturpajak' style="text-align : right" readonly=""> </td>
                                                </tr>

                                                <tr>
                                                  <td> <input type='text' class='form-control input-sm hasilppn_fakturpajak ' style="text-align : right" readonly=""> </td>
                                                </tr>
                                              </table>
                                          </div>
                                        </div>


                                        <table class="table">
                                       
                                        <tr>
                                          <td> Netto </td>
                                          <td> <input type='text' class='form-control netto_faktur' name='netto_faktur' style="text-align : right" readonly=""> </td>
                                        </tr>
                                        </table>                                       
                                      </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                                     <button class='btn btn-sm btn-warning editfakturpajak' type="button"> <i class='fa fa-pencil' id='editkeuangan'> </i> Edit </button>
                                     <button type="button"  class="simpan btn btn-success " id="formPajak"> Simpan  </button>
                                  
                                </div>
						   </div>
                        </div> 
					</div>
          @endif
               <!-- /.box-footer -->

                <div class="box-footer">
                  <div class="pull-right">
                        <table border="0">
                          <tr>  
                            <td> <div class="printpo"> </div> 
                         </td>
                          <td> &nbsp; </td>
                          <td>  <button class="btn btn-sm btn-success simpanupdate"> <i class="fa fa-save"></i> &nbsp; Simpan </button> </td>
                          
                          </tr>
                        </table>
                       

                    </div>
                  </div>
				
              <!-- /.box -->
			  
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"> </div>


<div id="data-jurnal">
</div>

@endsection



@section('extra_scripts')
<script type="text/javascript">


   $('body').removeClass('fixed-sidebar');
  $("body").toggleClass("mini-navbar");

    $('.removes-btn').hide();
    $('.removes-itm').hide();
    $('.tmbh-po').hide();
    $('.simpanupdate').hide();
    $('#createmodal_tt').hide();
    $('#createmodal_pajakpo').hide();
    $('.tmbh-brg').hide();

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
    });

      $(document).ready( function () {
      var config = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"}
                 }
                 for (var selector in config) {
                   $(selector).chosen(config[selector]);
                 }

      $('.item').chosen(config); 
    
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


    grupitem = $('.grupitem').val();
    $('.groupitem').val(grupitem);

    $('#createmodal_brg').click(function(){
         $(document).ready( function () {
        var config = {
                     '.chosen-select'           : {},
                     '.chosen-select-deselect'  : {allow_single_deselect:true},
                     '.chosen-select-no-single' : {disable_search_threshold:10},
                     '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                     '.chosen-select-width1'     : {width:"100%"}
                   }
                   for (var selector in config) {
                     $(selector).chosen(config[selector]);
                   }

        $('.item').chosen(config); 
      
        })

       updatestock = $('.updatedstock').val();
       idsupplier = $('.idsup').val();
       groupitem = $('.grupitem').val();
        gudang = $('.gudangheader').val();
        $('.gudang').val(gudang);

//       alert(updatestock);
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);


       
      

       if(idsup == '') {
          toastr.info('Dimohon untuk pilih Supplier Terlebih Dahulu :)');

       }
           $('.penerimaan').val(stock);
           $.ajax({    
            type :"post",
            data : {idsup, groupitem,updatestock},
            url : baseUrl + '/fakturpembelian/updatestockbrgfp',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else { //TIDAK TERIKAT KONTRAK
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+"''>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");            
                    }
                  }

                  valgrup = data.stock;
                  $('.stock').val(valgrup);

                  if(data.stock == 'T'){
                     $('td#tdupdatestock').hide();
                  }
                  else {
                     $('td#tdupdatestock').show();
                  }
                } //end respon ajax
            
          }) 


    })

     $('#createmodal_tt').click(function(){

      cabang = $('.cabang').val();
      supplier = $('.idsup').val();
      string = supplier.split(",");

      tgl = $('.tgl').val();
      jatuhtempo = $('.jatuhtempoitem').val();
      nettohutang = $('.nettohutang_po').val();

     
      $('.totalterima_tt').val(nettohutang);

    })

      $('#buttonsimpan_tt').click(function(){
      lainlain =   $('.lainlain_tt').val();
      notandaterima = $('.notandaterima').val();
      if(lainlain == ''){
        toastr.info('Kolom lain lain belum di isi');
      }
      else {
        if(notandaterima != '' || lainlain != ''){
           $('.inputtandaterima').val('sukses');
        }
        $('.lainlain_tt2').val(lainlain);
          $('#myModal_TT').modal("toggle" );;
      } 
    })

       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    //SIMPAN
     $('#updatefp').submit(function(event){
       // alert('sa');
        pajakmasukan = $('.inputfakturpajakmasukan').val();
        tandaterima = $('.inputtandaterima').val();
        inputppn = $('.inputppn').val();
        hasilppn = $('.hasilppn').val();
        tampilpo = $('.tampilpo').val();
        /*alert(tampilpo);
        alert(pajakmasukan);
        alert(tandaterima);*/
        if(tampilpo == 'nope'){
          toastr.info("Tidak ada perubahan yang dibuat :)");
          return false;
        }
      
        else{         

          event.preventDefault();
         // alert('test');
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Faktur Pembelian!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
        $.ajax({
          type : "get",
          data : form_data2,
          url : baseUrl + "/fakturpembelian/updatefaktur",
          dataType : 'json',
          success : function (response){
            console.log(response);
             if(response == 'sukses') {
                alertSuccess(); 
             // window.location.href = baseUrl + "/fakturpembelian/fakturpembelian";
             $('.simpanupdate').attr('disabled' , true);
             idfaktur = $('.idfaktur').val();
                html = "<a class='btn btn-info btn-sm' href={{url('fakturpembelian/cetakfaktur/')}}"+'/'+idfaktur+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a>";
              $('.printpo').html(html);
             }
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      }
      return false;
      })

    
    //data TANPA PO
    //cek group item
      $('.item').change(function(){
       // alert('ya');
      barang = $(this).val();
       $.ajax({
            data : {barang},
            type : "post",
            dataType : "json",
            url : baseUrl + '/fakturpembelian/getbarang',
            success : function(response){
            
               
                var acc_persediaan = response.barang[0].acc_persediaan;
                var acc_hpp = response.barang[0].acc_hpp;
                var harga = response.barang[0].harga;
                 $('.acc_biaya').val(acc_hpp);
                $('.acc_persediaan').val(acc_persediaan);
                $('.harga').val(addCommas(harga));


                 qty = $('.qty').val();
                  diskon = $('.diskon').val();

                  if(qty != '') {
                      if(diskon != '') {
                        hasil = parseFloat(qty * harga);  
                        totalharga = hasil.toFixed(2);
                        $('.amount').val(addCommas(totalharga));
                        
                        hsldiskon = parseFloat(diskon * 100) / 100;
                        biaya = totalharga - hsldiskon;
                        hslamount = biaya.toFixed(2); 
                        $('.biaya').val(hslamount);
                      }
                      else {
                        hasil = parseFloat(qty * harga);  
                        totalharga = hasil.toFixed(2);
                          $('.amount').val(addCommas(totalharga));
                      }
                  }
            }                     
          }) 



     
      
     
     

     
    })


    $('.qty').change(function(){
      val = $(this).val();
      harga = $('.harga').val();
      console.log(harga);

      if(harga != ''){

         hsljml =  harga.replace(/,/g, '');
        amount = parseInt(val) * parseInt(hsljml);
        num_amount = Math.round(amount).toFixed(2);
        console.log(parseInt(harga));
        console.log(val);
        $('.amount').val(addCommas(num_amount));
      }
    })



    

       grupitem = $('.groupitem').val();
       
      
      
       var groupitem = grupitem;
       stock = $('.stock').val();
       
        $('.penerimaan').val(stock);
    
    //cek group item
    $('.groupitem').change(function(){
       updatestock = $('.updatestock').val();
       idsupplier = $('.idsup').val();
       grupitem = $('.groupitem').val();
       
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);


       var variable = grupitem.split(",");
       var groupitem = variable[0];
       var stock = variable[1];
      // alert(groupitem);
      // alert(stock);

       if(idsup == '') {
          toastr.info('Dimohon untuk pilih Supplier Terlebih Dahulu :)');
       }
       if(stock == 'T') {
       // alert('barbar');
            $('.penerimaan').val(stock);
           //$('tr#tdupdatestock').css('display', 'none');
           $('td#tdupdatestock').hide();
           $.ajax({    
            type :"post",
            data : {idsup, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+","+obj.acc_persediaan+","+obj.acc_hpp+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
       }
       else if(stock == 'Y'){
       // alert('updatestock');
        $('.penerimaan').val(stock);
           //$('tr#tdupdatestock').css('display', 'block');
        $('td#tdupdatestock').show();
       

          $.ajax({    
            type :"post",
            data : {idsup, updatestock, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
        }
        
    })

    //cek barang updatestock
    $('.updatestock').change(function(){
       updatestock = $(this).val();
       idsupplier = $('.idsup').val();
       groupitem = $('.groupitem').val();
      // alert(updatestock);
       var string = idsupplier.split(",");
       var idsup = string[0];
       console.log(idsup);

       var stock = $('.stock').val();

       if(idsup == '') {
          toastr.info('Dimohon untuk pilih Supplier Terlebih Dahulu :)');
       }
       else {
          $.ajax({    
            type :"post",
            data : {idsup, updatestock, groupitem, stock},
            url : baseUrl + '/fakturpembelian/updatestockbarang',
            dataType:'json',
            success : function(data){
               arrItem = data.barang;

                  if(data.status == 'Terikat Kontrak') {
                    

                    if(arrItem.length > 0) {
                      $('.harga').attr('readonly' , true);
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.is_kodeitem+","+obj.is_harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                          $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong);  
                        $(".item").trigger("chosen:updated");
                        $(".item").trigger("liszt:updated");           
                    }
                  } // end kondisi terikat kontreak
                  else {
                     $('.harga').attr('readonly' , false);

                    if(arrItem.length > 0) {
                      $('.item').empty();
                      $('.item').append(" <option value=''>  -- Pilih Barang -- </option> ");
                        $.each(arrItem, function(i , obj) {
                  //        console.log(obj.is_kodeitem);
                          $('.item').append("<option value='"+obj.kode_item+","+obj.harga+","+obj.nama_masteritem+"'>"+obj.nama_masteritem+"</option>");
                          $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");
                        })
                    }
                    else{
                       //   alert('kosong');
                        $('.item').empty();
                          var rowKosong = "<option value=''> -- Data Kosong --</option>";
                        $('.item').append(rowKosong); 
                        $(".item").trigger("chosen:updated");
                             $(".item").trigger("liszt:updated");            
                    }
                  }
                } //end respon ajax
            
          })
        }
    })
    

    $('.diskon').change(function(){
          val = $(this).val();
          totalharga = $('.amount').val();
          hsljml =  totalharga.replace(/,/g, '');
          total = parseFloat((val / 100) * hsljml);
          
          hasiltotal = total.toFixed(2);
          $('.hasildiskonitem').val(addCommas(hasiltotal));

          hasil = hsljml - total;
          numeric = Math.round(hasil).toFixed(2);

          $('.biaya').val(addCommas(numeric));

        })



     
       $('.qtyitem').change(function(){
         var jmlbiayaqty = 0;
          var id = $(this).data('id');
          var qty = $(this).val();
          harga = $('.hargaitem' + id).val();
          
          console.log(harga + 'harga');
          hslharga =  harga.replace(/,/g, '');

          var hasil = parseFloat(qty * hslharga);
          hsl = hasil.toFixed(2);
          $('.totalbiayaitem' + id).val(addCommas(hsl));

          diskon = $('.diskonitem2' + id).val();
          diskon2 = parseFloat(diskon * hsl / 100);
          console.log(diskon2);
          hsldiskon = diskon2.toFixed(2);
          totalbiaya = parseFloat(hsl - hsldiskon);
          console.log(totalbiaya);
          hsltotalbiaya = totalbiaya.toFixed(2);

          $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); 

         $('.biayaitem').each(function(){
            val2 = $(this).val();
            replaceval2 = val2.replace(/,/g,'');

            jmlbiayaqty = parseFloat(parseFloat(jmlbiayaqty) + parseFloat(replaceval2)).toFixed(2);

          })

          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(jmlbiayaqty));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayaqty)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(jmlbiayaqty) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = jmlbiayaqty;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }
                $('.tampilpo').val('update');
       $('.inputtandaterima').val('tidaksukses');
                  

        })

   $('.diskonitem2').change(function(){
     var jmlbiayaqty = 0;
    $('.tampilpo').val('update');
      var id = $(this).data('id');
      var totalharga = $('.totalbiayaitem' + id).val();
      hsltotalharga =  totalharga.replace(/,/g, '');
       $('.inputtandaterima').val('tidaksukses');


      diskon = $(this).val();
      diskon2 = parseFloat(diskon * hsltotalharga / 100);
      console.log(diskon2);
      hsldiskon = diskon2.toFixed(2);
      totalbiaya = parseFloat(hsltotalharga - hsldiskon);
      console.log(totalbiaya);
      hsltotalbiaya = totalbiaya.toFixed(2);

      $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); 

       $('.biayaitem').each(function(){
            val2 = $(this).val();
            replaceval2 = val2.replace(/,/g,'');

            jmlbiayaqty = parseFloat(parseFloat(jmlbiayaqty) + parseFloat(replaceval2)).toFixed(2);

          })

          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(jmlbiayaqty));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayaqty)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(jmlbiayaqty) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = jmlbiayaqty;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }



   })
    //cek barang updatestock
   


  $('#createmodal_po').click(function(){
      idsup = $('.idsup').val();
      cabang = $('.cabang').val();
      $('.loading').css('display', 'block');
       url = baseUrl + '/fakturpembelian/getchangefaktur';
         $.ajax({    
          type :"get",
          data : {idsup,cabang},
          url : url,
          dataType:'json',
          success : function(response){
             $('.loading').css('display', 'none');
            console.log(response);
      
            //tambah data ke table data po
            var tableFPPO = $('#addColumn').DataTable();
            tableFPPO.clear().draw();
            var n = 1;
            for(var i = 0; i < response.po.length; i++){   
            console.log(response.po.length);          
                var html2 = "<tr> <td>"+ n +" </td>" +
                                "<td>"+response.po[i].nobukti+"</td>" +
                                "<td>"+response.po[i].cabang+"</td>" +
                                "<td>"+response.status[i]+"&nbsp &nbsp("+response.po[i].penerimaan+")</td>"+
                                "<td style='text-align:right'> Rp "+ addCommas(response.po[i].totalharga) +"</td>"+
                                "<td>";
                                    if(response.status[i] == 'BELUM DI TERIMA'){

                                        html2 += "&nbsp";
                                    }
                                    else if(response.status[i] == 'TIDAK LENGKAP') {
                                         html2 += "&nbsp";                                    }
                                    else {
                                        html2 += "<div class='checkbox'> <input type='checkbox' id="+response.po[i].nobukti+","+response.po[i].cabang+","+response.po[i].penerimaan+","+response.po[i].flag+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div> </td>";
                                    }
                                  
                              html2 +=  "</tr>";

               tableFPPO.rows.add($(html2)).draw();
               n++;
            }

        } 

     })
  })

  // FAKTUR PAJAK
   $('#createmodal_pajakpo').click(function(){

      jenisppn = $('.jenisppn_po').val();
      dpp = $('.dpp_po').val();
      inputppn = $('.inputppn_po').val();
      hasilppn = $('.hasilppn_po').val();
      netto = $('.nettohutang_po').val();
      jatuhtempo_po = $('.jatuhtempo_po').val();
      tanggal = $('.tgl').val();
      masapajak = $('.masapajak_faktur').val(jatuhtempo_po);
      $('.tglfaktur_pajak').val(tanggal);

      if(inputppn == '' && hasilppn == ''){
        toastr.info("Anda belum mengisi data PPN :)");
        return false;
      }
      else {

        $('.jenisppn_faktur').val(jenisppn);
        $('.dpp_fakturpembelian').val(dpp);
        $('.dpp_fakturpajak').val(dpp);
        $('.inputppn_fakturpembelian').val(inputppn);
        $('.hasilppn_fakturpajak').val(hasilppn);
        $('.hasilppn_fakturpembelian').val(hasilppn);
        $('.netto_faktur').val(netto);

      }
   })

   //faktur pajak
   $('#formPajak').click(function(){
    
/*
     var post_url2 = $(this).attr("action");
     var form_data2 = $(this).serialize();*/
     dpp_fakturpembelian = $('.dpp_fakturpembelian').val();
     hasilppn_fakturpembelian = $('.hasilppn_fakturpembelian').val();
     inputppn_fakturpembelian = $('.inputppn_fakturpembelian').val();
     jenisppn_faktur = $('.jenisppn_faktur').val();
     masapajak_faktur = $('.masapajak_faktur').val();
     netto_faktur = $('.netto_faktur').val();
     nofaktur_pajak = $('.nofaktur_pajak').val();
     tglfaktur_pajak = $('.tglfaktur_pajak').val();
      if(nofaktur_pajak == ''){
      toastr.info("no faktur pajak masukan kosong");
     }
     else {
          sukses = $('.inputfakturpajakmasukan').val('sukses');
        $('.dppfakturpembelian').val(dpp_fakturpembelian);
       $('.hasilppnfakturpembelian').val(hasilppn_fakturpembelian);
       $('.inputppnfakturpembelian').val(inputppn_fakturpembelian);
       $('.jenisppnfaktur').val(jenisppn_faktur);
       $('.masapajakfaktur').val(masapajak_faktur);
       $('.nettofaktur').val(netto_faktur);
       $('.nofakturpajak').val(nofaktur_pajak);
       $('.tglfakturpajak').val(tglfaktur_pajak);
       $('#myModal1').modal("toggle" );
        alertSuccess();
    

    }


   /* $.ajax({
      data : {dpp_fakturpembelian,hasilppn_fakturpembelian,inputppn_fakturpembelian,jenisppn_faktur,masapajak_faktur,netto_faktur,nofaktur_pajak,tglfaktur_pajak},
      url : baseUrl + '/fakturpembelian/savefakturpajak',
      type : "post",
      dataType : 'json',
      success : function (response){
        sukses = $('.inputfakturpajakmasukan').val('sukses');
        $('#myModal2').modal("toggle" );
        alertSuccess();

        $('.inputppn').attr('readonly' , true);
        $('.pajakpph').attr('disabled' , true);
        $('.disc_item').attr('readonly', true);
        $('.jenisppn').attr('disabled', true);
        $('.tbmh-data-item').attr('disabled' , true);
      }
    })*/
  })

   $('#buttongetpo').click(function(){
      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();

      var url = baseUrl + '/fakturpembelian/tampil_po';

   
      $('.tampilpo').val('update');

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
 
      variabel = [];
      variabel = checked;

      lengthfaktur = $('.fakturdt').length;

      var nobukti = [];
      var cabang = [];
      var jenis = [];
      var flag = [];
      for(var i = 0 ; i < variabel.length; i++){
        string = variabel[i].split(",");
        idnobukti = string[0];
        nobukti.push(idnobukti);
        idcabang = string[1];
        cabang.push(idcabang);
        idjenis = string[2]; 
        jenis.push(idjenis);
        idflag = string[3];
        flag.push(idflag);
      }

      var uniqueNoBukti = [];
      for(ds = 0; ds < nobukti.length; ds++){
        if(uniqueNoBukti.indexOf(nobukti[ds]) === -1){
          uniqueNoBukti.push(jenis[ds]);
        }
      }


      var uniqueCabang = [];
      for(dj = 0; dj < cabang.length; dj++){
        if(uniqueCabang.indexOf(cabang[dj]) === -1){
          uniqueCabang.push(cabang[dj]);
        }
      }
   

      uniqueJenis = [];
      for(ds = 0; ds < jenis.length; ds++){
        if(uniqueJenis.indexOf(jenis[ds]) === -1){
          uniqueJenis.push(jenis[ds]);
        }
      }   

      
       uniqueFlag = [];
      for(ds = 0; ds < flag.length; ds++){
        if(uniqueFlag.indexOf(flag[ds]) === -1){
          uniqueFlag.push(flag[ds]);
        }
      } 

       $("table#table_po tr#datapo").remove();
      //buat po - tampilpo

       if(uniqueJenis.length < 2 && uniqueCabang.length < 2 && uniqueFlag.length < 2) {
       $.ajax({    
          type :"get",
          data : {nobukti,jenis,flag},
          url : url,
          dataType:'json',
          success : function(response){
            $('#myModal2').modal("toggle" );
            var pobarang = response.po_barang;
            var no = lengthfaktur + 1;
            jmlharga = 0;
            for(var k = 0; k < pobarang.length; k++){
              for(var j = 0; j < pobarang[k].length; j++){
                 var rowHtml = "<tr class='fakturdt"+pobarang[k][j].po_id+"' data-id="+pobarang[k][j].po_id+" id='faktur"+pobarang[k][j].po_no+"'>  <td> <input type='text' class='form-control input-sm' value='"+ pobarang[k][j].po_no+"' readonly></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].nama_masteritem+"' readonly > <input type='hidden' class='form-control input-sm' value='"+pobarang[k][j].pbdt_item+"' readonly name='kodeitem[]' > </td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].sumqty+"' readonly name='qty[]'></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+addCommas(pobarang[k][j].podt_jumlahharga)+"' readonly name='harga[]'></td>" +
                  "<td> <input type='text' class='form-control input-sm totalharga"+pobarang[k][j].po_id+"' value='"+addCommas(pobarang[k][j].sumharga)+"' readonly name='totalharga[]'></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].pbdt_updatestock+"' readonly name='updatestock'></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].acc_persediaan+"' readonly name='accpersediaan[]'></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].acc_hpp+"' readonly name='accbiaya[]'></td> <input type='hidden' class='form-control input-sm' value='"+pobarang[k][j].po_id+"' name='po_id[]' readonly=''>  <input type='hidden' value='PO' name='flag'> " +
                  "<td> <button class='btn btn-sm btn-danger removes-btn' data-id='"+pobarang[k][j].po_id+"' type='button'><i class='fa fa-trash'></i></button> </td>" +
                  "</tr>";

                 $('#tbl-po').append(rowHtml);
                 no++;

                 jmlharga = parseFloat(parseFloat(jmlharga) + parseFloat(pobarang[k][j].sumharga));
              

              }
            } // END LOOPING

//            alert(jmlharga);
            //UPDATE UANG DI KANAN FAKTUR
            total = $('.jumlahharga_po').val();
            replacetotal = total.replace(/,/g,'');
            hasiltotal = parseFloat(parseFloat(replacetotal) + parseFloat(jmlharga)).toFixed(2);

            $('.jumlahharga_po').val(addCommas(hasiltotal));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(hasiltotal)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(hasiltotal) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasiltotal;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }// END PPN




          }
        })
       }
         else if(uniqueCabang.length > 1){
          toastr.info('Maaf Cabang yang di inputkan harus sama :) ');
        }
        else if(uniqueJenis.length > 1){
           toastr.info('Maaf Tipe Transaksi tidak sama :) '); 
        }
          else if(uniqueFlag.length > 1){
           toastr.info('Maaf Jenis Transaksi tidak sama :) '); 
        }
     })
  



    //INPUT PPN CHANGE
     $('.inputppn_po').change(function(){
      var jenisppn = $('.jenisppn_po').val();

      var dpp = $('.dpp_po2').val();
      dpphasil =  dpp.replace(/,/g, '');
      $this = $(this).val();
      $('.tampilpo').val('update');
      hasil = parseFloat(($this / 100) * dpphasil);
      hasil2 =   hasil.toFixed(2);
      $('.hasilppn_po').val(addCommas(hasil2));
      $('.inputfakturpajakmasukan').val('tidaksukses');
      $('.inputtandaterima').val('tidaksukses');


        jenisppn = $('.jenisppn_po').val();
        dpp = $('.dpp_po').val();
        numeric2 = dpp.replace(/,/g,'');
        inputppn = $('.inputppn_po').val();


        pph = $('.hasilpph_po').val();
        ppn = $('.hasilppn_po').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');

      if(jenisppn == 'T'){
         if(pph != ''){ //PPH TIDAK KOSONG
            hasilpph = $('.hasilpph_po').val();
            replacepph = hasilpph.replace(/,/g,'');

            hasilnetto = parseFloat(parseFloat(dpphasil) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));

          }else{ //PPH KOSONG
           
             $('.nettohutang_po').val(dpp); 
          }
      }
      else if (jenisppn == 'E') {
   
          if(pph != ''){ //PPH TIDAK KOSONG
            hasilpph = $('.hasilpph_po').val();
            replacepph = hasilpph.replace(/,/g,'');

            hasilnetto = parseFloat((parseFloat(dpphasil)+parseFloat(hasil2)) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));

          }else{ //PPH KOSONG
           
             hasilnetto = parseFloat(parseFloat(dpphasil) + parseFloat(hasil2));
             hsl = hasilnetto.toFixed(2);
           
             $('.nettohutang_po').val(addCommas(hsl)); 
          }
      }
      else if(jenisppn == 'I'){

            if(pph == ''){            
               hargadpp = parseFloat((parseFloat(dpphasil) * 100) / (100 + parseFloat($this))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat($this) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));    
            }
            else{
                hargadpp = parseFloat((parseFloat(dpphasil) * 100) / (100 + parseFloat($this))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat($this) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) + parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));    
            }
      }
    })


    // PAJAK PPH PO
    $('.pajakpph_po').change(function(){
      val = $(this).val();
      var string = val.split(",");
      var tarif = string[1];
      $('.inputpph_po').val(tarif);
      $('.tampilpo').val('update');
      var dpp = $('.dpp_po2').val();
      hsldpp =  dpp.replace(/,/g, '');

      $('.inputtandaterima').val('tidaksukses');

      hasiltarif = parseFloat((tarif / 100) * hsldpp);
      hasiltarif2 =  hasiltarif.toFixed(2);
      $('.hasilpph_po').val(addCommas(hasiltarif2));

      hasilnetto = hsldpp - hasiltarif2;
      hasilnetto2 =  Math.round(hasilnetto).toFixed(2);

      //////
        pph = $('.hasilpph_po').val();      
        ppn = $('.hasilppn_po').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');
        jenisppn = $('.jenisppn_po').val();
        numeric2 = dpp.replace(/,/g,'');


      if($('.hasilppn_po').val() != '') { //ppn  tidak kosong
          if($('.jenisppn_po').val() == 'E'){
          
             ppn = $('.hasilppn_po').val();
             hasilppn = ppn.replace(/,/g,'');
             pph = addCommas(hasiltarif2);
             hasilpph = pph.replace(/,/g,'');
             hasilnetto = parseFloat(parseFloat(hsldpp)+parseFloat(hasilppn) - parseFloat(hasilpph)); 
             hsl = hasilnetto.toFixed(2);
             $('.nettohutang_po').val(addCommas(hsl));
          }

         else if(jenisppn == 'I'){ 
              
             hargadpp = parseFloat((parseFloat(dpphasil) * 100) / (100 + parseFloat($this))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat($this) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));               
        }
        else {
       
          $('.inputppn_po').val('');
          $('.hasilppn_po').val('');
          hslnetto = parseFloat(parseFloat(hsldpp) - parseFloat(hasiltarif2));
          netto2 = hslnetto.toFixed(2);
          $('.nettohutang_po').addCommas(netto2);
        }
      }
      else {
     
          hslnetto = parseFloat(parseFloat(hsldpp) - parseFloat(hasiltarif2));
          netto2 = hslnetto.toFixed(2);
          $('.nettohutang_po').val(addCommas(netto2));
      }

    })


    //JENIS PPN PO
     $('.jenisppn_po').change(function(){     
        jenisppn = $('.jenisppn_po').val();
        dpp = $('.dpp_po2').val();
        numeric2 = dpp.replace(/,/g,'');
        inputppn = $('.inputppn_po').val();

        if(inputppn != ''){
          hasilppn1 = parseFloat((inputppn / 100) * numeric2);
          hasilppn2 =   hasilppn1.toFixed(2);
          $('.hasilppn_po').val(addCommas(hasilppn2));

        }

        pph = $('.hasilpph_po').val();
        ppn = $('.hasilppn_po').val();
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');

          if(ppn != ''){
          if(jenisppn == 'E'){
          //JIKA PPH TIDAK ADA 
            if(pph == ''){
              hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)).toFixed(2);
              $('.nettohutang_po').val(addCommas(hasilnetto));
              $('.dpp_po').val(dpp);
            }
            else{
              hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(hasilnetto));
              $('.dpp_po').val(dpp);
            } 
          }
          else if(jenisppn == 'I'){
          
            if(pph == ''){   //PPH KOSONG PPN TIDAK KOSONG         
              hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));    
            }
            else{
               hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));     
            }
          }
          else if(jenisppn == 'T') {
            if(pph == '' ){
             
              
              $('.nettohutang_po').val(dpp);
              $('.dpp_po').val(dpp);
            }

            else{
               total = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));
              $('.dpp_po').val(dpp);
            }
           
          }

        }
        
    })


     $(document).on('click','.removes-itm',function(){
          var id = $(this).data('id');
         
       //   replace = total.replace(/,/g,'');
        
          jumlahharga = $('.jumlahharga_po').val();
          replacejumlah = jumlahharga.replace(/,/g,'');
         
            val2 = $('.biayaitem' + id).val();
           // alert(val2);
            replaceval2 = val2.replace(/,/g,'');

            hasil = parseFloat(parseFloat(replacejumlah) - parseFloat(replaceval2)).toFixed(2);

         
          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(hasil));

          //diskon
          //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(hasil)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(hasil) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasil;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
               numeric2 = hsljumlah.replace(/,/g,'');
               
              //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

                var parent = $('tr#data-item' + id);
                parent.remove();

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');


               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
                 // alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                //  alert('pph kosong');
                      if(jenisppn == 'E'){   
                      //alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                       // alert(parseFloat(numeric2));
                        //alert(parseFloat(replaceppn));
                        //alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }// END PPN

         

       

       })


     $(document).on('click','.removes-btn',function(){
          var id = $(this).data('id');
          var total = $('.totalharga' + id).length;
       //   replace = total.replace(/,/g,'');
          val = [];
          jumlahharga = $('.jumlahharga_po').val();
          replacejumlah = jumlahharga.replace(/,/g,'');
          $('.totalharga' + id).each(function(){
            val2 = $(this).val();
            replaceval2 = jumlahharga.replace(/,/g,'');

            hasil = parseFloat(parseFloat(replacejumlah) - parseFloat(replaceval2)).toFixed(2);

          })

          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(hasil));

          //diskon
          //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(hasil)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(hasil) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasiltotal;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
               numeric2 = hsljumlah.replace(/,/g,'');
               
              //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');


               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
                 // alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                //  alert('pph kosong');
                      if(jenisppn == 'E'){   
                     // alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                      //  alert(parseFloat(numeric2));
                      //  alert(parseFloat(replaceppn));
                      //  alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }// END PPN

         

          var parent = $('.fakturdt' + id);
          parent.remove();

       })
  
  //DISKON
   $('.disc_item_po').change(function(){
      jumlahharga = $('.jumlahharga_po').val();
      hsljml2 =  jumlahharga.replace(/,/g, '');
      disc = $(this).val();
      total = parseFloat((disc)/100 * hsljml2);
      $('.tampilpo').val('update');
      hasiltotal = total.toFixed(2);

      $('.hasildiskon_po').val(addCommas(hasiltotal));

       $('.inputtandaterima').val('tidaksukses');
       

      hasil2 = parseFloat(hsljml2 - total);
      numeric2 =hasil2.toFixed(2);
      $('.dpp_po').val(addCommas(numeric2));
      $('.dpp_po2').val(addCommas(numeric2));
      $('.nettohutang_po').val(addCommas(numeric2));
        

        inputppn = $('.inputppn_po').val();
        if(inputppn != ''){
          hasilppn1 = parseFloat((inputppn / 100) * numeric2);
          hasilppn2 =   hasilppn1.toFixed(2);
          $('.hasilppn_po').val(addCommas(hasilppn2));
        }

        pph = $('.hasilpph_po').val();
       // alert(pph);
        ppn = $('.hasilppn_po').val();       
        replacepph = pph.replace(/,/g,'');
        replaceppn = ppn.replace(/,/g,'');

        if(pph != '' & ppn != '') { //PPH  ADA DAN PPN  ADA
        
          jenisppn = $('.jenisppn_po').val();
          if(jenisppn == 'E') {          
            hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));
            $('.dpp_po').val(addCommas(numeric2));
          }
          else if(jenisppn == 'I'){

               hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                            
            
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));

             
          }
          else {

              hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
              $('.dpp_po').val(addCommas(numeric2));
          
          }
        }
        else if(pph != ''){ //PPH TIDAK KOSONG
     
          if(ppn == '') { //PPN KOSONG          
            hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
            $('.nettohutang_po').val(hasil);
              $('.dpp_po').val(addCommas(numeric2));
          }
          else{ //PPN TIDAK KOSONG            
              jenisppn = $('.jenisppn_po').val();
            if(jenisppn == 'E') {
            
              hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
               $('.dpp_po').val(addCommas(numeric2));
            }
            else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

               hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                           
              $('.dpp_po').val(addCommas(hargadpp));
              subtotal = $('.dpp_po').val();
              subharga = subtotal.replace(/,/g, '');
              hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
       
              $('.hasilppn_po').val(addCommas(hargappn));

              total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));


             /* hargappn = parseFloat((numeric2 * parseFloat(100)) / (100 + inputppn));
              hargappn2 = hargappn.toFixed(2);
              $('.hasilppn_po').val(addCommas(hargappn2));
              total = parseFloat(parseFloat(numeric2) + parseFloat(hargappn2) - parseFloat(replacepph)).toFixed(2); 
            
              $('.nettohutang_po').val(addCommas(total));  */
            }
            else {
              hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
              $('.dpp_po').val(addCommas(numeric2));
            }
          }
        }
        else if(ppn != '') { //PPN TIDAK KOSONG
    
          jenisppn = $('.jenisppn_po').val();
          if(pph == ''){ //PPN TIDAK KOSONG PPH KOSONG
        
              if(jenisppn == 'E'){             
                hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                hsl = hasil.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
                  $('.dpp_po').val(addCommas(numeric2));
              }
              else if(jenisppn == 'I'){
           
                  hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                  $('.dpp_po').val(addCommas(hargadpp));
                  subtotal = $('.dpp_po').val();
                  subharga = subtotal.replace(/,/g, '');
                  hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
           
                  $('.hasilppn_po').val(addCommas(hargappn));
                  total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                  $('.nettohutang_po').val(addCommas(total));
              }
              else {
         
                hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                hsl = hasilnetto.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
                  $('.dpp_po').val(addCommas(numeric2));
              }
          }
          else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
         
            jenisppn = $('.jenisppn_po').val();
            if(jenisppn == 'E') {          
              hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
                $('.dpp_po').val(addCommas(numeric2));
            }
            else if(jenisppn == 'I'){
                  hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                           
                  $('.dpp_po').val(addCommas(hargadpp));
                  subtotal = $('.dpp_po').val();
                  subharga = subtotal.replace(/,/g, '');
                  hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
           
                  $('.hasilppn_po').val(addCommas(hargappn));

                  total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                  $('.nettohutang_po').val(addCommas(total)); 
            }
            else {

                hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                hsl = hasilnetto.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
                  $('.dpp_po').val(addCommas(numeric2));
            
            }
          }
        } 
        else {
       
          $('.nettohutang_po').val(addCommas(numeric2));
            $('.dpp_po').val(addCommas(numeric2));
        }
    })  
  


  //GETDATAMODALPO
    var nourut = $('tr.fpitem').length;
    
   $('#buttongetbrg').click(function(){   
     $jumlahharga = 0; 
          nourut++;
         $('#myModalBrg').modal("toggle" );

          $('.idsup').prop('disabled', true).trigger("liszt:updated");
          $('.idsup').prop('disabled', true).trigger("chosen:updated");
          $('.gudang').prop('disabled', true).trigger("liszt:updated");
          $('.gudang').prop('disabled', true).trigger("chosen:updated");
          $('.keterangan2').attr('disabled' , true);

          $('.noinvoice').attr('disabled' , true);
          $('.groupitem').attr('disabled' , true);

          $('.tampilpo').val('update');
     
          var post_url = $(this).attr("action");
          var form_data = $(this).serialize();
       
          var updatestock = $('.updatestock').val();
          $('.updatestock').attr('disabled', true);

          var item = $('.item').val();
         // alert(item);
          var string = item.split(",");
          namaitem = string[2];
          kodeitem = string[0];
          console.log(namaitem);

          var qty = $('.qty').val();
          var gudang = $('.gudang').val();
          var harga = $('.harga').val();
         
          var string2 = gudang.split(",");
          nmgudang = string2[1];
          var amount = $('.amount').val();
          var diskon = $('.diskon').val();
          var biaya = $('.biaya').val();
          var acc_biaya = $('.acc_biaya').val();
          var acc_persediaan = $('.acc_persediaan').val();
          var keterangan = $('.keterangan').val();
         
       
          var penerimaan = $('.penerimaan').val();

          var grupitem = $('.groupitem').val();
          var string4 = grupitem.split(",");
          groupitem = string4[0];
         // alert(penerimaan);
          var  row = "<tr id='data-item"+nourut+"'> <td>"+nourut+"</td>"+
                  "<td> <select class='form-control barangitem brg"+nourut+"'  name='item[]' data-id="+nourut+"> @foreach($data['barang'] as $brg) <option value='{{$brg->kode_item}}'>{{$brg->nama_masteritem}}</option> @endforeach </select>  </td>" + //nama barang

                  "<td> <input type='text' class='form-control qtyitem qtyitem"+nourut+"' value="+qty+" name='qty[]' data-id="+nourut+"> " +
                  "<input type='hidden' class='form-control groupitem' value="+groupitem+" name='groupitem'> </td>"+ //qty
                  
                  "<td> <select class='form-control gudangitem gudangitem"+nourut+"' name='gudang[]' readonly> @foreach($data['gudang'] as $gudang)  <option value='{{$gudang->mg_id}}'> {{$gudang->mg_namagudang}} </option> @endforeach</select> </td>"+ //gudang

                  "<td> <input type='text' class='form-control hargaitem hargaitem"+nourut+"' value='"+ addCommas(harga)+"' name='harga[]' data-id="+nourut+"></td>"+ //harga

                  "<td> <input type='text' class='form-control totalbiayaitem totalbiayaitem"+nourut+"' value='"+ amount+"' name='totalharga[]' readonly> </td>"+ //total harga

       

                  "<td> <input type='text' class='form-control updatestockitem updatestockitem"+nourut+"' value='"+updatestock+"'  name='updatestock[]' readonly> </td>"+ // updatestock
                       "<td> <input type='text' class='form-control diskonitem2 diskonitem2"+nourut+"' value='"+diskon+"' name='diskonitem[]' data-id="+nourut+"> </td>" + //diskon

                  "<td>  <input type='text' class='form-control biayaitem biayaitem"+nourut+"' value='"+biaya+"'  name='biaya[]' readonly> </td>"+ //biaya

                  "<td> <input type='text' class='form-control acc_biayaitem acc_biayaitem"+nourut+"' value='"+acc_biaya+"' name='acc_biaya[]' readonly> </td>"+ //acc_biaya

                  "<td> <input type='text' class='form-control acc_persediaanitem acc_persediaanitem"+nourut+"' value='"+acc_persediaan+"' name='acc_persediaan[]' readonly> </td>"+ //acc_persediaan

                  "<td> <input type='text' class='form-control keteranganitem keteranganitem"+nourut+"' value='"+keterangan+"'  name='keteranganitem[]'>  <input type='hidden' name='penerimaan[]' class='penerimaan' value='"+penerimaan+"'></td>" +
                  
                  "<td class='edit"+nourut+"'> <button class='btn btn-sm btn-danger removes-itm' data-id='"+nourut+"' type='button'> <i class='fa fa-trash'></i> </button> "+
                  " </td> </tr>"; 

/*
                  <button class='btn btn-xs btn-success update' data-id='"+nourut+"' type='button' id='toggle"+nourut+"'> <i id='edit"+nourut+"' class='fa fa-pencil' aria-hidden='true'></i>"+nourut+"*/

                  hsljml =  biaya.replace(/,/g, '');
                  console.log(hsljml);

                  $jumlahharga = $jumlahharga + parseInt(hsljml);
                  numeric = parseFloat($jumlahharga).toFixed(2);
               /*   $('.jumlahharga_po').val(addCommas(numeric));
                  $('.dpp_po').val(addCommas(numeric));
                  $('.dpp2').val(addCommas(numeric));
                  $('.dpp_po2').val(addCommas(numeric));
                  $('.nettohutang_po').val(addCommas(numeric));*/



                 /* Data Jumlah DPP*/
                  total = $('.jumlahharga_po').val();
                  replacetotal = total.replace(/,/g,'');
                  hasiltotal = parseFloat(parseFloat(replacetotal) + parseFloat(numeric)).toFixed(2);

             $('.jumlahharga_po').val(addCommas(hasiltotal));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(hasiltotal)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(hasiltotal) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasiltotal;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }// END PPN

                 /*END DATA DPP*/

                  //cek jika double item
                  nobrg = nourut - 1;
                  idbarang = $('.brg'+nobrg).val();
                
                  if(item == idbarang){
                    toastr.info('Mohon maaf barang tersebut sudah ditambah :)');
                  }
                  else {
                    $('#tablefp').append(row);
                  }

                
                 $('.brg'+nourut).val(item);

                 //pembersihan value
                 //pembersihan data
                $('.item').prop('selectedIndex',0);
                $('.qty').val('');
                $('.gudang').val('');
                $('.harga').val('');
                $('.amount').val('');
                $('.biaya').val('');
                $('.acc_biaya').val('');
                $('.keterangan').val('');
                $('.diskon').val('');
                $('.hasildiskonitem').val('');

                    $('.qtyitem').change(function(){
         var jmlbiayaqty = 0;
          var id = $(this).data('id');
          var qty = $(this).val();
          harga = $('.hargaitem' + id).val();
          
          console.log(harga + 'harga');
          hslharga =  harga.replace(/,/g, '');

          var hasil = parseFloat(qty * hslharga);
          hsl = hasil.toFixed(2);
          $('.totalbiayaitem' + id).val(addCommas(hsl));

          diskon = $('.diskonitem2' + id).val();
          diskon2 = parseFloat(diskon * hsl / 100);
          console.log(diskon2);
          hsldiskon = diskon2.toFixed(2);
          totalbiaya = parseFloat(hsl - hsldiskon);
          console.log(totalbiaya);
          hsltotalbiaya = totalbiaya.toFixed(2);

          $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); 

         $('.biayaitem').each(function(){
            val2 = $(this).val();
            replaceval2 = val2.replace(/,/g,'');

            jmlbiayaqty = parseFloat(parseFloat(jmlbiayaqty) + parseFloat(replaceval2)).toFixed(2);

          })

          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(jmlbiayaqty));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayaqty)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(jmlbiayaqty) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasiltotal;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }
                $('.tampilpo').val('update');
       $('.inputtandaterima').val('tidaksukses');
                  

        })

   $('.diskonitem2').change(function(){
     var jmlbiayaqty = 0;
    $('.tampilpo').val('update');
      var id = $(this).data('id');
      var totalharga = $('.totalbiayaitem' + id).val();
      hsltotalharga =  totalharga.replace(/,/g, '');
       $('.inputtandaterima').val('tidaksukses');


      diskon = $(this).val();
      diskon2 = parseFloat(diskon * hsltotalharga / 100);
      console.log(diskon2);
      hsldiskon = diskon2.toFixed(2);
      totalbiaya = parseFloat(hsltotalharga - hsldiskon);
      console.log(totalbiaya);
      hsltotalbiaya = totalbiaya.toFixed(2);

      $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); 

       $('.biayaitem').each(function(){
            val2 = $(this).val();
            replaceval2 = val2.replace(/,/g,'');

            jmlbiayaqty = parseFloat(parseFloat(jmlbiayaqty) + parseFloat(replaceval2)).toFixed(2);

          })

          //menghitung jumlah
          $('.jumlahharga_po').val(addCommas(jmlbiayaqty));


              //diskon
              diskon = $('.disc_item_po').val();
              if(diskon != ''){
                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayaqty)) / 100;
                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                jumlah = parseFloat(parseFloat(jmlbiayaqty) - parseFloat(hsl)).toFixed(2);
              }
              else {
                jumlah = hasiltotal;
              }

              //DPP
               $('.dpp_po').val(addCommas(jumlah));
               $('.dpp_po2').val(addCommas(jumlah));
               hsljumlah = $('.dpp_po').val();
                numeric2 = hsljumlah.replace(/,/g,'');
              
              //PPN


               //PPN
              inputppn = $('.inputppn_po').val();
              jenisppn = $('.jenisppn_po').val();
              ppn = $('.hasilppn_po').val(); 

              if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }

              pph = $('.hasilpph_po').val();

              if(pph != 0) {
                inputpph = $('.inputpph_po').val();
                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                 hasilpph2 =   hasil.toFixed(2); 
                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                 pph = $('.hasilpph_po').val();
              }

            

              replacepph = pph.replace(/,/g,'');
              replaceppn = ppn.replace(/,/g,'');

               if(pph != 0 & ppn != '') { 
               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                   jenisppn = $('.jenisppn_po').val();
                  if(jenisppn == 'E') {          
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));
                  }
                  else if(jenisppn == 'I'){
                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subtotal = $('.dpp_po2').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));                     
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                  
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                      $('.dpp_po').val(addCommas(numeric2));
                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                      $('.dpp_po').val(addCommas(hargadpp));
                      subtotal = $('.dpp_po').val();
                      subharga = subtotal.replace(/,/g, '');
                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
               
                      $('.hasilppn_po').val(addCommas(hargappn));

                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                      $('.nettohutang_po').val(addCommas(total));

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                      if(jenisppn == 'E'){   
                //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                      else if(jenisppn == 'I'){
                   
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));
                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total));
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                    }
                    else if(jenisppn == 'I'){
                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                   
                          $('.dpp_po').val(addCommas(hargadpp));
                          subtotal = $('.dpp_po').val();
                          subharga = subtotal.replace(/,/g, '');
                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                   
                          $('.hasilppn_po').val(addCommas(hargappn));

                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                          $('.nettohutang_po').val(addCommas(total)); 
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));
                    
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                }



   })

                 //change di table item
                 $('.barangitem').change(function(){
                    var id = $(this).data('id');
                    var barang = $(this).val();

                    $('.tampilpo').val('update');
                   // alert('barangitem');
                    $.ajax({
                      data : {barang},
                      type : "post",
                      dataType : "json",
                      url : baseUrl + '/fakturpembelian/getbarang',
                      success : function(response){
                        jmlbiayaqty = 0;
                          var harga = response.barang[0].harga;
                          $('.hargaitem' + id).val(addCommas(harga));

                           qty = $('.qtyitem' + id).val();
                           diskon = $('.diskonitem2' + id).val();
                          if(qty != '') {
                             
                            if(diskon != '') {
                              totalharga = parseFloat(qty * harga);
                              hsltotal = totalharga.toFixed(2);
                              $('.totalbiayaitem' + id).val(addCommas(hsltotal));
                              
                              diskon2 = parseFloat(diskon * hsltotal / 100);
                              hsldiskon = diskon2.toFixed(2);
                              totalbiaya = parseFloat(hsltotal - hsldiskon);
                              hslbiaya = totalbiaya.toFixed(2);
                              $('.biayaitem' + id).val(addCommas(hslbiaya)); 
                            }
                            else {
                              totalharga = parseFloat(qty * harga);
                              hsltotal = totalharga.toFixed(2);
                              $('.totalbiayaitem' + id).val(addCommas(hsltotal));
                            }
                          }

                          accpersediaan = response.barang[0].acc_persediaan;
                          acchpp = response.barang[0].acc_hpp;
                          $('.acc_persediaanitem' + id).val(accpersediaan);
                          $('.acc_biayaitem' + id).val(acchpp);

                          /* MENGHITUNG DPP */
                            $('.biayaitem').each(function(){
                            val2 = $(this).val();
                            replaceval2 = val2.replace(/,/g,'');

                            jmlbiayaqty = parseFloat(parseFloat(jmlbiayaqty) + parseFloat(replaceval2)).toFixed(2);

                          })

                          //menghitung jumlah
                          $('.jumlahharga_po').val(addCommas(jmlbiayaqty));


                              //diskon
                              diskon = $('.disc_item_po').val();
                              if(diskon != ''){
                                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayaqty)) / 100;
                                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                                jumlah = parseFloat(parseFloat(jmlbiayaqty) - parseFloat(hsl)).toFixed(2);
                              }
                              else {
                                jumlah = hasiltotal;
                              }

                              //DPP
                               $('.dpp_po').val(addCommas(jumlah));
                               $('.dpp_po2').val(addCommas(jumlah));
                               hsljumlah = $('.dpp_po').val();
                                numeric2 = hsljumlah.replace(/,/g,'');
                              
                              //PPN


                               //PPN
                              inputppn = $('.inputppn_po').val();
                              jenisppn = $('.jenisppn_po').val();
                              ppn = $('.hasilppn_po').val(); 

                              if(inputppn != '') {
                                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                                 hasilppn2 =   hasilppn.toFixed(2);
                                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                                 ppn = $('.hasilppn_po').val(); 
                              }

                              pph = $('.hasilpph_po').val();

                              if(pph != 0) {
                                inputpph = $('.inputpph_po').val();
                                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                                 hasilpph2 =   hasil.toFixed(2); 
                                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                                 pph = $('.hasilpph_po').val();
                              }

                            

                              replacepph = pph.replace(/,/g,'');
                              replaceppn = ppn.replace(/,/g,'');

                               if(pph != 0 & ppn != '') { 
                               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                                   jenisppn = $('.jenisppn_po').val();
                                  if(jenisppn == 'E') {          
                                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                    hsl = hasilnetto.toFixed(2);
                                    $('.nettohutang_po').val(addCommas(hsl));
                                    $('.dpp_po').val(addCommas(numeric2));
                                  }
                                  else if(jenisppn == 'I'){
                                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                      $('.dpp_po').val(addCommas(hargadpp));
                                      subtotal = $('.dpp_po').val();
                                      subtotal = $('.dpp_po2').val();
                                      subharga = subtotal.replace(/,/g, '');
                                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                               
                                      $('.hasilppn_po').val(addCommas(hargappn));

                                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                      $('.nettohutang_po').val(addCommas(total));                     
                                  }
                                  else {

                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));
                                  
                                  }
                                }
                                else if(pph != 0){ //PPH TIDAK KOSONG            
                               //   alert('pph tdk kosong');
                                  if(ppn == '') { //PPN KOSONG          
                                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                                    $('.nettohutang_po').val(hasil);
                                      $('.dpp_po').val(addCommas(numeric2));
                                  }
                                  else{ //PPN TIDAK KOSONG            
                                      jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {
                                    
                                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                       $('.dpp_po').val(addCommas(numeric2));
                                    }
                                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                                   
                                      $('.dpp_po').val(addCommas(hargadpp));
                                      subtotal = $('.dpp_po').val();
                                      subharga = subtotal.replace(/,/g, '');
                                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                               
                                      $('.hasilppn_po').val(addCommas(hargappn));

                                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                      $('.nettohutang_po').val(addCommas(total));

                                    }
                                    else {
                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));
                                    }
                                  }
                                }
                                else if(ppn != '') { //PPN TIDAK KOSONG   
                               // alert('ppn tdk kosong')        
                                  jenisppn = $('.jenisppn_po').val();
                                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                              //    alert('pph kosong');
                                      if(jenisppn == 'E'){   
                                //      alert('E');          
                                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                                        hsl = hasil.toFixed(2);
                                  /*      alert(parseFloat(numeric2));
                                        alert(parseFloat(replaceppn));
                                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                      }
                                      else if(jenisppn == 'I'){
                                   
                                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                          $('.dpp_po').val(addCommas(hargadpp));
                                          subtotal = $('.dpp_po').val();
                                          subharga = subtotal.replace(/,/g, '');
                                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                                   
                                          $('.hasilppn_po').val(addCommas(hargappn));
                                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                                          $('.nettohutang_po').val(addCommas(total));
                                      }
                                      else {
                                 
                                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                      }
                                  }
                                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                                 
                                    jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {          
                                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));
                                    }
                                    else if(jenisppn == 'I'){
                                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                                   
                                          $('.dpp_po').val(addCommas(hargadpp));
                                          subtotal = $('.dpp_po').val();
                                          subharga = subtotal.replace(/,/g, '');
                                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                                   
                                          $('.hasilppn_po').val(addCommas(hargappn));

                                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                          $('.nettohutang_po').val(addCommas(total)); 
                                    }
                                    else {

                                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                    
                                    }
                                  }
                                } 
                                else {
                                    $('.nettohutang_po').val(addCommas(numeric2));
                                    $('.dpp_po').val(addCommas(numeric2));
                                }


                      }                     
                    })                    
                 })

                


        $(document).on('click','.removes-btn',function(){
          var id = $(this).data('id');
         
          var parent = $('#data-item'+id);
          parent.remove();

       })

        $(document).on('click','.update',function(){
          var id = $(this).data('id');
          $('.brg-' +id).attr('disabeld', false);
          $('.qty' +id).attr('readonly', false);
          $('.gudang' +id).attr('readonly', false);
          $('.harga' +id).attr('readonly', false);
          $('.totalbiaya' +id).attr('readonly', false);
          $('.updatestock' +id).attr('readonly', false);
          $('.biaya' +id).attr('readonly', false);
          $('.acc_biaya' +id).attr('readonly', false);
          $('.keterangan' +id).attr('readonly', false);

          $('i#edit'+id).toggleClass('fa-pencil fa-floppy-o');
         /* $('button#toggle'+id).toggleClass('update save');*/

         /* $('button#toggle'+id).toggleClass('btn-success btn-warning');
          $('button#toggle'+id).toggleClass('update save');*/
       })

        $(document).on('click','.save',function(){
          var id = $(this).data('id');
          $('.brg-' +id).attr('disabeld', true);
          $('.qty' +id).attr('readonly', true);
          $('.gudang' +id).attr('readonly', true);
          $('.harga' +id).attr('readonly', true);
          $('.totalbiaya' +id).attr('readonly', true);
          $('.updatestock' +id).attr('readonly', true);
          $('.biaya' +id).attr('readonly', true);
          $('.acc_biaya' +id).attr('readonly', true);
          $('.keterangan' +id).attr('readonly', true);

          $('i#edit'+id).toggleClass('fa-floppy-o fa-pencil');
            $('button#toggle'+id).toggleClass('save update');
       })     
      })



//change di table item
     $('.barangitem').change(function(){
        var id = $(this).data('id');
        barang = $(this).val();

       // alert('barangitem');
        $.ajax({
          data : {barang},
          type : "post",
          url : baseUrl + '/fakturpembelian/getbarang',
          dataType : "json",
          success : function(response){
            jmlbiayabrg = 0
              var harga = response.barang[0].harga;
              $('.hargaitem' + id).val(addCommas(harga));

               qty = $('.qtyitem' + id).val();
               diskon = $('.diskonitem2' + id).val();
              if(qty != '') {
                 
                if(diskon != '') {
                  totalharga = parseFloat(qty * harga);
                  hsltotal = totalharga.toFixed(2);
                  $('.totalbiayaitem' + id).val(hsltotal);
                  
                  diskon2 = parseFloat(diskon * hsltotal / 100);
                  hsldiskon = diskon2.toFixed(2);
                  totalbiaya = parseFloat(hsltotal - hsldiskon);
                  hslbiaya = totalbiaya.toFixed(2);
                  $('.biayaitem' + id).val(addCommas(hslbiaya)); 
                }
                else {
                  totalharga = parseFloat(qty * harga);
                  hsltotal = totalharga.toFixed(2);
                  $('.totalbiayaitem' + id).val(addCommas(hsltotal));
                }
              }

               accpersediaan = response.barang[0].acc_persediaan;
              acchpp = response.barang[0].acc_hpp;
              $('.acc_persediaanitem' + id).val(accpersediaan);
              $('.acc_biayaitem' + id).val(acchpp);


                 $('.biayaitem').each(function(){
                            val2 = $(this).val();
                            replaceval2 = val2.replace(/,/g,'');

                            jmlbiayabrg = parseFloat(parseFloat(jmlbiayabrg) + parseFloat(replaceval2)).toFixed(2);

                          })

                          //menghitung jumlah
                          $('.jumlahharga_po').val(addCommas(jmlbiayabrg));


                              //diskon
                              diskon = $('.disc_item_po').val();
                              if(diskon != ''){
                                hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayabrg)) / 100;
                                hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                                jumlah = parseFloat(parseFloat(jmlbiayabrg) - parseFloat(hsl)).toFixed(2);
                              }
                              else {
                                jumlah = hasiltotal;
                              }

                              //DPP
                               $('.dpp_po').val(addCommas(jumlah));
                               $('.dpp_po2').val(addCommas(jumlah));
                               hsljumlah = $('.dpp_po').val();
                                numeric2 = hsljumlah.replace(/,/g,'');
                              
                              //PPN


                               //PPN
                              inputppn = $('.inputppn_po').val();
                              jenisppn = $('.jenisppn_po').val();
                              ppn = $('.hasilppn_po').val(); 

                              if(inputppn != '') {
                                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                                 hasilppn2 =   hasilppn.toFixed(2);
                                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                                 ppn = $('.hasilppn_po').val(); 
                              }

                              pph = $('.hasilpph_po').val();

                              if(pph != 0) {
                                inputpph = $('.inputpph_po').val();
                                 hasilpph = parseFloat((inputpph / 100) * numeric2);
                                 hasilpph2 =   hasil.toFixed(2); 
                                 pph2 = $('.hasilpph_po').val(addCommas(hasilpph2));
                                 pph = $('.hasilpph_po').val();
                              }

                            

                              replacepph = pph.replace(/,/g,'');
                              replaceppn = ppn.replace(/,/g,'');

                               if(pph != 0 & ppn != '') { 
                               // alert('pph ada ppn ada');//PPH  ADA DAN PPN  ADA
                                   jenisppn = $('.jenisppn_po').val();
                                  if(jenisppn == 'E') {          
                                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                    hsl = hasilnetto.toFixed(2);
                                    $('.nettohutang_po').val(addCommas(hsl));
                                    $('.dpp_po').val(addCommas(numeric2));
                                  }
                                  else if(jenisppn == 'I'){
                                      hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                      $('.dpp_po').val(addCommas(hargadpp));
                                      subtotal = $('.dpp_po').val();
                                      subtotal = $('.dpp_po2').val();
                                      subharga = subtotal.replace(/,/g, '');
                                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                               
                                      $('.hasilppn_po').val(addCommas(hargappn));

                                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                      $('.nettohutang_po').val(addCommas(total));                     
                                  }
                                  else {

                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));
                                  
                                  }
                                }
                                else if(pph != 0){ //PPH TIDAK KOSONG            
                               //   alert('pph tdk kosong');
                                  if(ppn == '') { //PPN KOSONG          
                                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                                    $('.nettohutang_po').val(hasil);
                                      $('.dpp_po').val(addCommas(numeric2));
                                  }
                                  else{ //PPN TIDAK KOSONG            
                                      jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {
                                    
                                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                       $('.dpp_po').val(addCommas(numeric2));
                                    }
                                    else if(jenisppn == 'I'){ //PPN TIDAK KOSONG && PPH TIDAK KOSONG

                                       hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                                   
                                      $('.dpp_po').val(addCommas(hargadpp));
                                      subtotal = $('.dpp_po').val();
                                      subharga = subtotal.replace(/,/g, '');
                                      hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                               
                                      $('.hasilppn_po').val(addCommas(hargappn));

                                      total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                      $('.nettohutang_po').val(addCommas(total));

                                    }
                                    else {
                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));
                                    }
                                  }
                                }
                                else if(ppn != '') { //PPN TIDAK KOSONG   
                               // alert('ppn tdk kosong')        
                                  jenisppn = $('.jenisppn_po').val();
                                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                              //    alert('pph kosong');
                                      if(jenisppn == 'E'){   
                                //      alert('E');          
                                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                                        hsl = hasil.toFixed(2);
                                  /*      alert(parseFloat(numeric2));
                                        alert(parseFloat(replaceppn));
                                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                      }
                                      else if(jenisppn == 'I'){
                                   
                                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                          $('.dpp_po').val(addCommas(hargadpp));
                                          subtotal = $('.dpp_po').val();
                                          subharga = subtotal.replace(/,/g, '');
                                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                                   
                                          $('.hasilppn_po').val(addCommas(hargappn));
                                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn)).toFixed(2);
                                          $('.nettohutang_po').val(addCommas(total));
                                      }
                                      else {
                                 
                                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                      }
                                  }
                                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                                 
                                    jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {          
                                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));
                                    }
                                    else if(jenisppn == 'I'){
                                          hargadpp = parseFloat((parseFloat(numeric2) * 100) / (100 + parseFloat(inputppn))).toFixed(2) ; 
                                                   
                                          $('.dpp_po').val(addCommas(hargadpp));
                                          subtotal = $('.dpp_po').val();
                                          subharga = subtotal.replace(/,/g, '');
                                          hargappn = parseFloat((parseFloat(inputppn) / 100) *  parseFloat(subharga)).toFixed(2);
                                   
                                          $('.hasilppn_po').val(addCommas(hargappn));

                                          total = parseFloat(parseFloat(subharga) + parseFloat(hargappn) - parseFloat(replacepph)).toFixed(2);
                                          $('.nettohutang_po').val(addCommas(total)); 
                                    }
                                    else {

                                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                          $('.dpp_po').val(addCommas(numeric2));
                                    
                                    }
                                  }
                                } 
                                else {
                                    $('.nettohutang_po').val(addCommas(numeric2));
                                    $('.dpp_po').val(addCommas(numeric2));
                                }

          }                     
        })                    
     })


 $('#buttongetid').click(function(){
   
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

       var idform = $('.idform').val();
       var lainlain = $('.lainlain').val();

      $.ajax({
      url:baseUrl + '/fakturpembelian/update_tt',
      type:'post',
      data:{idform,lainlain},
      success:function(response){
        console.log(response);
        swal({
        title: "Berhasil!",
                type: 'success',
                text: "Data berhasil disimpan",
                timer: 900,
               showConfirmButton: false
                },function(){
                  location.reload();
        });
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

		});
	},
	});
});

$('.tampilpo').change(function(){
  $(this).val('update');
})

$('.ubah').click(function(){
   $('.removes-btn').show();
   $('.removes-itm').show();
   $('.edit').attr('readonly' , false);
   $('.disc_item_po').attr('readonly' , false);
  $('.edit').attr('disabled' , false);
   $('.tmbh-po').show();
   $('.tmbh-brg').show();
   $('.simpanupdate').show();
   $('#createmodal_pajakpo').show();
   $('#createmodal_tt').show();
   $('.simpanupdate').attr('disabled', false);
    
})

$('.edit').click(function(){
   $('.tampilpo').val('update');
})


function lihatjurnal($ref,$note){

          $.ajax({
          url:baseUrl +'/data/jurnal-umum',
          type:'get',
          data:'ref='+$ref
               +'&note='+$note,
          /* data: "{'ref':'" + $ref+ "', 'note':'" + $note+ "'}",
*/
          
         
          success:function(response){
                $('#data-jurnal').html(response);
                $('#jurnal').modal('show');
              }
        });
   }
</script>
@endsection
