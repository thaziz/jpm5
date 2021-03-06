@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .disabled {
    pointer-events: none;
    opacity: 1;
  }

  .table {
   overflow-x: scroll
  }


</style>

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
                     @if($data['faktur'][0]->fp_tipe != 'PO')
                         <a onclick="lihatjurnal('{{$data['faktur'][0]->fp_nofaktur or null}}','FAKTUR PEMBELIAN')" class="btn-xs btn-primary" aria-hidden="true"> 
                    @else
                        <a onclick="lihatjurnal('{{$data['faktur'][0]->fp_nofaktur or null}}','FAKTUR PEMBELIAN')" class="btn-xs btn-primary" aria-hidden="true">
                    @endif
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
                         <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                         @foreach($data['faktur'] as $faktur)
                          <tr>
                            <td width="150px"> Cabang </td>
                            <td> <input type="text" class="input-sm form-control" value="{{$faktur->nama}}" readonly=""> <input type="hidden" class="input-sm form-control cabang" value="{{$faktur->fp_comp}}" readonly="" name="cabang"> <input type="hidden" class="input-sm form-control cabangtransaksi" value="{{$faktur->fp_comp}}" readonly="" name="cabang"> </td>
                          </tr>

                          <tr>                         
                            <td width="150px">
                            <b> No Faktur </b>
                            </td>
                            <td>
                              <input type='text' readonly="" class="input-sm form-control nofaktur" value="{{$faktur->fp_nofaktur}}" name="nofaktur">
                              <input type='hidden' readonly="" class="input-sm form-control tampilpo" value="nope">
                              <input type="hidden" value="{{$faktur->fp_acchutang}}" name="acchutang">
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
                                 <input type="hidden" class="form-control idsup2" readonly="" value="{{$faktur->idsup}}+{{$faktur->syarat_kredit}}+{{$faktur->nama_supplier}}+{{$faktur->acc_hutang}}+{{$faktur->no_supplier}}">
                                 
                            </td>
                           
                          </tr>

                          <tr>
                            <td>
                              <b> Tipe </b>
                            </td>
                            <td> <input type="text" readonly=""  class="form-control tipe" value="{{$faktur->fp_tipe}}"> </td>
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
                        <td> <b> DPP </b> </td>
                        <td> <div class="row"> <div class='col-md-3'> Rp </div> <div class='col-md-9'> <input type='text' class='form-control dpp_po' readonly="" name='dpp_po' style="text-align: right" value="{{ number_format($faktur->fp_dpp, 2) }}">  <input type='hidden' class='form-control dpp_po2' readonly=""  style="text-align: right" value="{{number_format($faktur->fp_dpp, 2)}}">
                        </div> </div> </td>
                      </tr>


                      <tr>
                        <td>
                          <b> Jenis PPN </b>
                        </td>

                        <td> 
                        <div class="row">
                          <div class="col-md-5">

                            <select class="form-control jenisppn_po" name="jenisppn_po">
                              <option value="T" @if($faktur->fp_jenisppn == 'T') selected="" @endif>
                                TANPA
                              </option>
                              <option value="I" @if($faktur->fp_jenisppn == 'I') selected="" @endif>
                                INCLUDE
                              </option>
                              <option value="E" @if($faktur->fp_jenisppn == 'E') selected="" @endif>
                                EXCLUDE
                              </option>
                            </select>
                          </div>
                          <div class="col-md-5">
                            <button type="button" class="btn btn-primary" id="createmodal_pajakpo" data-toggle="modal" data-target="#myModal1">  Faktur Pajak</button>
                          </div>
                        </div>   </td>   </td>
                      </tr>
                     
                      <tr>
                        <td> <b> PPn % </b> </td>
                        @if($faktur->fp_ppn != '')
                          <td> <div class="row">  <div class="col-md-3"> <input type="text" class="form-control inputppn_po" value="{{$faktur->fp_inputppn}}" readonly="" name="inputppn_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasilppn_po edit" readonly=""  style="text-align: right" name="hasilppn_po" value="{{ number_format($faktur->fp_ppn, 2) }}"> </div> </div>  </td>
                        
                        @else
                           <td> <div class="row">  <div class="col-md-3"> <input type="text" class="form-control inputppn_po" value="" name="inputppn_po"> </div>  <div class="col-md-9"> <input type="text" class="form-control hasilppn_po edit" readonly=""  style="text-align: right" name="hasilppn_po" value=""> </div> </div>  </td>
                        @endif
                      
                      </tr>
                      <tr>
                         <td style='text-align: right'>
                          <select class='form-control pajakpph_po edit' name="jenispph_po" disabled="">
                            @if($faktur->fp_pph != '0.00' && $faktur->fp_pph != '')
                              @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'   @if($pajak->nama == $faktur->fp_jenispph) selected @endif> {{$pajak->nama}}</option> @endforeach
  
                            @else
                              <option value=""> Pilih Pajak PPH
                              </option>

                              @foreach($data['pajak'] as $pajak) <option value='{{$pajak->id}},{{$pajak->nilai}}'   @if($pajak->nama == $faktur->fp_jenispph) selected @endif> {{$pajak->nama}}</option> @endforeach
                              
                            @endif
                            
                          </select> </td>

                         <td> <div class="row"> <div class="col-md-4"> <input type="text" class="form-control inputpph_po" readonly="" value="{{$faktur->fp_nilaipph}}"> </div> <div class="col-md-8"> <input type="text" class="form-control hasilpph_po edit" style='text-align: right' readonly="" name='hasilpph_po' value="{{number_format($faktur->fp_pph, 2)}}"> </div> </div> </td>
                      </tr>
                      <tr>
                        <td> <b> Netto Hutang </b> </td>
                        <td> <input type='text' class='form-control nettohutang_po' readonly="" name="nettohutang_po" style="text-align: right" value="{{ number_format($faktur->fp_netto, 2) }}"> <input type="hidden" name="idfaktur" value="{{$faktur->fp_idfaktur}}" class="idfaktur">  </td>
                      </tr>

                      <tr>
                        <td> <b> Sisa Hutang </b> </td>
                        <td> <input type='text' class='form-control sisahutang_po' readonly="" name="sisapelunasan_po" style="text-align: right" value="{{ number_format($faktur->fp_sisapelunasan, 2) }}"> <input type='hidden' class='form-control fp_uangmuka' value="{{$faktur->fp_uangmuka}}"> </td>
                      </tr>

                      <tr>  <td> <b> No Faktur </b> </td> <td> <div class="row"> <div class="col-xs-6"> <input type="text" class="form-control notandaterima" value="{{$data['no_tt'][0]->tt_noform}}" readonly="">   </div>   <div class="col-xs-6">  <button class="btn btn-info" style="margin-right: 10px;" type="button" id="createmodal_tt" data-toggle="modal" data-target="#myModal_TT" type="button"> <i class="fa fa-book"> </i> &nbsp; Ganti Form Tanda Terima </button>  </div> </div> <input type="hidden" class="datatandaterima" name="datatandaterima" value="{{$data['no_tt'][0]->ttd_id}},{{$data['no_tt'][0]->ttd_detail}}"> </td>  </tr>

                      <tr> <td> <button class="btn btn-sm btn-primary" type="button" id="createmodal_um" data-target="#bayaruangmuka" data-toggle="modal"> Bayar dengan Uang Muka </button> </td> <td>

                       @if(isset($jurnal_um))
                           <button class="btn btn-sm btn-info" type="button" onclick="lihatjurnalum('{{$data['faktur'][0]->fp_nofaktur or null}}','UANG MUKA PEMBELIAN FP')" class="btn-sm btn-info" aria-hidden="true">             
                                <i class="fa  fa-eye"> </i>
                                 &nbsp;  Lihat Jurnal Uang Muka  
                           </button> 
                           @endif </td> </tr>

                      @endforeach

                       <tr>
                           
                       </tr>

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
                           <a class="btn btn-sm btn-info " href=""><i class="fa fa-print">&nbsp;Cetak Tanda Terima</i></a>   &nbsp;

                           @if($data['faktur'][0]->fp_status == 'Approved')

                           @else
                           <!--    @if(cek_periode(carbon\carbon::parse($data['faktur'][0]->fp_tgl)->format('m'),carbon\carbon::parse($data['faktur'][0]->fp_tgl)->format('Y') ) != 0) -->
                            
                            <!--  @endif -->
                           @endif

                           @if($data['faktur'][0]->fp_edit != 'UNALLOWED')
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
                    <div style="overflow-x:auto;" class="table-responsive">
                      <table class="table  table-border tbl-penerimabarang" id="tablefp" width="100%">
                      <tr >
                        <thead>
                          <th> No </th>
                          <th style="width:300px"> Nama Item </th>
                          <th> Qty </th>
                          <th style="width:200px">Gudang </th>
                          <th style="width:180px"> Harga / unit </th>
                          <th style="width:180px"> Amount </th>
                          <th> Update Stock ? </th>
                          <th style="width:180px">  Biaya </th>
                          <th style="width:180px"> Netto </th>
                          <th style="width:180px"> Account Biaya </th>
                          <th style="width:180px"> Account Persediaan </th>
                          <th style="width:300px"> Keterangan</th>
                        </thead>

                      </tr>
                      <tbody>
                          @foreach($data['fakturdtpo'] as $index=>$fakturdt)
                         


                         <tr class="fpitem" id="data-item{{$index + 1}}"> <td>{{$index + 1}}</td>

                        <td> <select class="form-control barangitem brg{{$index + 1}} edit"  name="item[]" data-id="{{$index + 1}}" disabled="" style="min-width: 200px">
                         @foreach($data['barang'] as $brg) 
                         <option value="{{$brg->kode_item}}" @if($fakturdt->fpdt_kodeitem == $brg->kode_item) selected @endif> {{$brg->kode_item}} - {{$brg->nama_masteritem}} </option>
                          @endforeach </select>   </td>  <!-- nama barang -->

                        <td> <input type="text" class="form-control qtyitem qtyitem{{$index + 1}} edit" value="{{$fakturdt->fpdt_qty}}" name="qty[]" data-id="{{$index +1}}" readonly="" style="min-width: 90px"> 

                        <!-- qty -->
                        
                        <td> <select class="form-control gudangheader edit gudangitem gudangitem{{$index + 1}}" name="gudang[]" disabled="" style="min-width: 200px"> @foreach($data['gudang'] as $gudang)  <option value="{{$gudang->mg_id}}" @if($fakturdt->fpdt_gudang == $gudang->mg_id) selected @endif> {{$gudang->mg_namagudang}} </option> @endforeach</select> </td> <!-- gudang -->

                        <td> <input type='text' class='form-control hargaitem hargaitem{{$index + 1}} edit' value="{{ number_format($fakturdt->fpdt_harga, 2)}}" name="harga[]" data-id="{{$index + 1}}" readonly="" style="text-align:right;min-width:200px"></td><!-- "+ //harga -->

                        <td> <input type="text" class="form-control totalbiayaitem totalbiayaitem{{$index + 1}}" value="{{number_format($fakturdt->fpdt_totalharga, 2) }}" name="totalharga[]" readonly="" style="min-width: 200px"> </td> <!-- //total harga -->

               

                        <td> <input type="text" class="form-control updatestockitem updatestockitem{{$index + 1}}" value="{{$fakturdt->fpdt_updatedstock}}"  name='updatestock[]' readonly="" style="min-width: 90px"> </td><!-- "+ // updatestock -->
    

                      <td>  <input type='text' class="form-control biayaitem biayaitem{{$index + 1}} edit" value="{{ number_format($fakturdt->fpdt_biaya, 2)}}"  name='biaya[]' readonly="" data-id="{{$index + 1}}" style="min-width: 200px">  </td> <!-- "+ //biaya -->

                      <td>  <input type='text' class="form-control nettoitem nettoitem{{$index + 1}}" value="{{ number_format($fakturdt->fpdt_netto, 2)}}"  name='nettoitem[]' readonly="" style="min-width: 200px"> </td> <!-- "+ //biaya -->

                      <td> <input type="text" class="form-control acc_biayaitem acc_biayaitem{{$index + 1}}" value="{{$fakturdt->fpdt_accbiaya}}" name='acc_biaya[]' readonly="" style="min-width: 200px"> </td> <!-- "+ //acc_biaya -->

                      <td> <input type="text" class="form-control acc_persediaanitem acc_persediaanitem{{$index + 1}} " value='{{$fakturdt->fpdt_accpersediaan}}' name='acc_persediaan[]' readonly="" style="min-width: 200px"> </td> <!-- "+ //acc_persediaan -->

                      <td> <input type='text' class="form-control keteranganitem keteranganitem{{$index + 1}} edit" value="{{$fakturdt->fpdt_keterangan}}"  name='keteranganitem[]' readonly="" style="min-width: 200px">  <input type='hidden' name='penerimaan[]' class='penerimaan' value=""> <input type="hidden" value="{{$fakturdt->fpdt_groupitem}}" class="grupitem" name="grupitem[]">   <input type="hidden" value="{{$fakturdt->fpdt_updatedstock}}" class="updatedstock"> </td>
                          
                      <td class='edit{{$index + 1}}'> <button class='btn btn-sm btn-danger removes-itm' data-id='{{$index + 1}}' type='button'> <i class='fa fa-trash'></i> </button></td> 

                       
                      </tr>
                      

                      @endforeach
                      </tbody>


                        <input type="hidden" value="ITEM" name="flag">
                         
                       
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
                      <!--     asas {{$fakturdt->fpdt_qty}} -->
                          <tr class="fakturdt{{$fakturdt->po_id}}" data-id="{{$fakturdt->po_no}}" id="faktur{{$fakturdt->po_no}}">
                        
                                @if($data['status'] == 'PO')
                                    <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->po_no}}" readonly=""> </td>
                                @else 
                                    <td> {{$fakturdt->fp_nofaktur}}</td>
                                @endif
                            <td> <input type="hidden" class="form-control input-sm" value="{{$fakturdt->po_id}}" name="po_id[]" readonly="">  <input type="text" class="form-control input-sm" value="{{$fakturdt->nama_masteritem}}" readonly="">
                                <input type="hidden" value="{{$fakturdt->kode_item}}" name="kodeitem[]">
                                <input type="hidden" value="PO" name="flag">
                            </td>
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->fpdt_qty}}" name="qty[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{ number_format($fakturdt->fpdt_harga, 2) }}" name="harga[]" readonly="">  </td>
                            <td> <input type="text" class="form-control input-sm totalharga{{$fakturdt->po_id}}" value="{{ number_format($fakturdt->fpdt_totalharga, 2) }}" name="totalharga[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->fpdt_updatedstock}}" name="updatestock[]" readonly=""> </td>
                            <td> <input type="text" class="form-control input-sm" value="{{$fakturdt->fpdt_accbiaya}}" name="accbiaya[]" readonly="">  </td>
                            <td> <input type="text" class="form-control input-sm" value=" {{$fakturdt->fpdt_accpersediaan}}" name="accpersediaan[]" readonly="">
                              </td>
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

                 

                   <form id="form_hasiltt">  
               <div class="modal fade" id="myModal_TT" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                      </button>                     
                                      <h4 class="modal-title" style="text-align: center;"> 
                                       </h4>     
                                    </div>
                                                  
                                    <div class="modal-body">              
                                      <table class="table table-stripped tabel_tt" id="table_tt">
                                         <thead>
                                            <tr>
                                                <th> No </th> <th> No Supplier </th> <th> Nota TT </th> <th> Tgl Kembali </th> <th> No Invoice </th> <th> Nominal </th> <th> Aksi </th>
                                            </tr>
                                         </thead>
                                      </table>                                      
                                    </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                          <button type="button" class="btn btn-primary " id="buttonsimpan_tt">
                                            Simpan
                                          </button>
                                         
                                      </div>
                                      
                                  </div>
                                </div>
                             </div> 
                    </form>


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
									<td> <select class="form-control groupitem" name="grupitem"  id="selectgroup"> 
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
                                <select class='form-control chosen-select-width1 item' name="nama_item" required="" id="item"> 
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
                                <input type='number' class='form-control acc_biaya input-sm' name="acc_biaya" required="" readonly="">
                              </td>
                              </tr>
                              <tr>
                              <td>
                                Account Persediaan
                              </td>
                              <td>
                                <input type='number' class='form-control acc_persediaan input-sm' name="acc_persediaan" required="" readonly="">
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
                                <td>
                                  Biaya
                                </td>
                              <td style="text-align: right">

                                  <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control biaya input-sm" style="text-align: right" name="biaya"  required="" value="0"> </div> </div>
                                </td>
                              </tr>
                             

                              <tr>
                                <td>
                                  Netto
                                </td>
                              <td style="text-align: right">

                                  <div class="form-group"> <label class="col-sm-2 col-sm-2 control-label"> Rp </label> <div class="col-md-10"> <input type='text' class="form-control nettomodal input-sm" style="text-align: right" name="nettomodal" readonly="" required=""> </div> </div>
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

                <!-- FORM BAYAR UANG MUKA -->
                            <div class="modal fade" id="bayaruangmuka" tabindex="-1" role="dialog"  aria-hidden="true">
                <form method="post" action="{{url('fakturpembelian/bayaruangmuka')}}" enctype="multipart/form-data" class="form-horizontal" id="form_hasilum">  
                                <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                                 
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                      </button>                     
                                      <h3 class="modal-title" style="text-align: center;">
                                          Uang Muka Pembelian
                                      </h3>     
                                    </div>
                                            
                                    <div class="modal-body">
                                    <div class="col-sm-8">              
                                    <table class="table table-stripped tabel_tt">
                                      <tr>
                                        <td width="150px">
                                          No Transaksi Kas / Bank 
                                        </td>
                                        <td>
                                          <input type='text' class='input-sm form-control no_umheader' id="transaksium" readonly="" data-toggle="modal" data-target="#caritransaksium">
                                          <input type="hidden" class="nota_um editum">
                                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                          
                                          <input type="hidden" class="akunhutang_um">
                                          <input type="hidden" class="notr">
                                          <input type="hidden" class="flag_um">
                                        </td>
                                      </tr>
                                      <tr>
                                        <td> Tanggal </td>
                                        <td>
                                           <div class="input-group date">
                                                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_umheader editum" value="" readonly="">
                                          </div>
                                        </td>
                                      </tr>
                                     
                                      <tr>
                                        <td> Jumlah </td>
                                        <td> <input type='text' class="form-control jumlah_header editum" value="" readonly=""></td>
                                        </td>
                                      </tr>
                                      
                                      <tr>
                                        <td>
                                         Keterangan
                                        </td>
                                        <td>
                                        
                                          <input type="text" class="form-control keterangan_header editum" readonly="">
                                        </td>
                                      </tr>

                                      <tr>
                                        <td> Dibayar </td>
                                        <td> <input type="text" class="form-control dibayar_header editum">   </td>
                                      </tr>

                                       <tr>
                                        <td> Keterangan </td>
                                        <td> <input type="text" class="form-control keteranganum_header">   </td>
                                      </tr>

                                       </table> 

                                       </div>

                                       <div class="col-sm-4">
                                          <table class="table">
                                              <tr>
                                                  <th> Total Jumlah Uang Muka </th>                      
                                              </tr>
                                              <tr>
                                                    <td> <input type="text" value="{{number_format($data['faktur'][0]->fp_uangmuka,2,",",".")}}" class="form-control totaljumlah" readonly="" name="totaljumlah" style="text-align:right"> <input type="hidden" class="inputbayaruangmuka" name="inputbayaruangmuka"> </td>
                                              </tr>
                                          </table>

                                          <br>
                                          <br>
                                          <br>
                                          <br>
                                          <br>

                                            <div class="pull-left">
                                                <button class="btn btn-sm btn-info" id="tambahdataum" type="button"> <i class="fa fa-plus"> </i>  Tambah Data </button>
                                            </div>
                                       </div>                          
                                      <div id="here"> </div>       
                                      <br>
                                      <br>
                                     
                                      <table class="table table-bordered" id="tablehasilum">
                                          <thead>
                                          <tr class="tableum">
                                            <th style="width:200px"> No Faktur </th> <th> No Kas / Bank</th> <th> Tanggal </th> <th> No Uang Muka </th> <th> Jumlah Uang Muka </th> <th> Dibayar </th> <th> Keterangan </th> <th> Hapus </th> 
                                          </tr>


                                          </thead>
                                          <tbody>
                                            @if(count($dataumfp) != 0)
                                            @foreach($dataumfp as $index=>$umfp)

                                              <tr class="dataum dataum{{$index}}" data-nota="{{$umfp->umfpdt_transaksibank}}">
                                              <td>  <p class="nofaktur idtrum nofaktur2{{$index}}"  onclick="klikkas(this)" data-id="{{$index}}"> {{$umfp->umfp_nofaktur}} {{$index}} </p>  <input type="hidden"  value="{{$umfp->umfp_id}}" name="idumfp"> </td>
                                              <td> <p class="nokas_text">{{$umfp->umfpdt_transaksibank}}</p> <input type="hidden" class="nokas" value="{{$umfp->umfpdt_transaksibank}}" name="nokas[]"> </td>
                                              <td><p class="tgl_text">{{$umfp->umfpdt_tgl}}</p> <input type="hidden" class="tglum" value="{{$umfp->umfpdt_tgl}}" name="tglum[]"> </td>
                                              <td> <p class="notaum_text">{{$umfp->umfpdt_notaum}}</p> <input type="hidden" class="notaum" value="{{$umfp->umfpdt_notaum}}" name="notaum[]"></td>
                                              <td> <p class="jumlahum_text"> {{number_format($umfp->umfpdt_jumlahum,2,",",".")}}</p> <input type="hidden" class="jumlahum" value="{{$umfp->umfpdt_jumlahum}}" name="jumlahum[]">  </td>
                                              <td> <p class="dibayar_text"> {{number_format($umfp->umfpdt_dibayar,2,",",".")}} </p> <input type="hidden" class="dibayar" value="{{$umfp->umfpdt_dibayar}}" name="dibayarum[]"> </td>
                                              <td>  <p class="keterangan_text">{{$umfp->umfpdt_keterangan}}</p><input type="hidden" value="{{$umfp->umfpdt_keterangan}}" class="keteranganum" name="keteranganum[]">  <input type="hidden" class="akunhutangum" value="{{$umfp->umfpdt_acchutang}}" name="akunhutangum[]"> <input type="hidden" class="keteranganumheader" value="{{$umfp->umfp_keterangan}}" name="keteranganumheader"> <input type="hidden" class="flagum" value="{{$umfp->umfpdt_flag}}" name="flagum[]">  </td>
                                              <td> <button class="btn btn-sm btn-danger" type="button" onclick="hapusum(this)"><i class="fa fa-trash"></i></button> </td>
                                           

                                            </tr>
                                            @endforeach
                                            @endif
                                         </tbody>

                                      </table> 
                                    
                   
                  
                                    </div>
                                      
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                          <button type="button" class="btn btn-primary" id="buttonsimpan_um">
                                            Simpan
                    </button>
                                      </div>
                                       </form>
                                  </div>
                                </div>
                             </div> 
            
            
            
              <!-- FORM BAYAR UANG MUKA -->
                            <div class="modal fade" id="caritransaksium" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="min-width: 1000px !important; min-height: 800px">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                      </button>                     
                                      <h3 class="modal-title" style="text-align: center;">
                                         Transaksi Kas / Hutang Uang Muka
                                      </h3>     
                                    </div>
                                                  
                                    <div class="modal-body">
                                                  
                                    <table class="table table-stripped tabel_tt" id="tabletransaksi">
                                      <thead>
                                      <tr>
                                        <th> No Kas / Hutang </th> <th style="width:100px"> Tgl </th> <th> Supplier</th><th> Keterangan </th> <th> Jumlah Uang Muka </th> <th> Sisa Terpakai di Faktur </th> <th> Aksi </th>
                                      </tr>
                                      </thead>
                                      
                                    </table>     
                                     </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal" >Batal</button>
                                          <button type="button" class="btn btn-primary" id="buttongetum">
                                            Simpan
                                          </button>
                                         
                                      </div>
                                      
                                  </div>
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

    //TRANSAKSI UM
    
  //transaksi_um
  $('.dibayar_header').change(function(){

     jumlahheader2 = $('.jumlah_header').val();
     $('.tampilpo').val('update');
 //     alert(jumlahheader2);
     val = $(this).val();
      
     val = accounting.formatMoney(val, "", 2, ",",'.');
     
     hasiljumlah = jumlahheader2.replace(/,/g,'');
     val2 = val.replace(/,/g,'');

      var a = $('ul#tabmenu').find('li.active').data('val');

     if(parseFloat(val2) > parseFloat(hasiljumlah)){
      toastr.info('Tidak bisa melebihi dari jumlah Uang Muka :)');
      $(this).val('');
     }
     else {
           $(this).val(val);
     }


      totaljumlah = $('.totaljumlah').val();
      totaljumlah2 = totaljumlah.replace(/,/g,'');

      if(a == 'I'){
      nettohutang2 = $('.nettohutang').val();
      nettohutang = nettohutang2.replace(/,/g,'');
/*      alert(val2);
      alert(nettohutang);
      alert(hasiljumlah);*/
          if(parseFloat(totaljumlah2) > parseFloat(nettohutang) ){
            toastr.info('Tidak bisa melebihi dari jumlah netto faktur');
           /* alert('test');*/
              $(this).val('');
            }
      
        if(parseFloat(val2) > parseFloat(nettohutang)){
            toastr.info('Tidak bisa melebihi dari jumlah netto faktur');
           
            $(this).val('');
        }
      }   
      else {
      nettohutang2 = $('.nettohutang_po').val();
      nettohutang = nettohutang2.replace(/,/g,'');
      if(parseFloat(totaljumlah2) > parseFloat(nettohutang) ){
            toastr.info('Tidak bisa melebihi dari jumlah netto faktur');
              $(this).val('');
            }
      
      if(parseFloat(val2) > parseFloat(nettohutang)){
          toastr.info('Tidak bisa melebihi dari jumlah netto faktur');
          $(this).val('');
      }

      }


  })

  $('#tambahdataum').click(function(){
       
      

        nofaktur = $('.nofaktur').val();
        nokas = $('.no_umheader').val();
        tgl = $('.tgl_umheader').val();
        jumlah = $('.jumlah_header').val();
        keterangan = $('.keterangan_header').val();
        dibayar = $('.dibayar_header').val();
        notaum = $('.nota_um').val();
        notransaksi = $('.notr').val();
        akunhutang = $('.akunhutang_um').val();
        keteranganum = $('.keteranganum_header').val();
        flagum = $('.flag_um').val();

       // alert(flagum);
        if(dibayar == ''){
          toastr.info("harap diisi jumlah dibayar nya :)");
          return false;
        }

      
          arrnotakas = [];
      $('.dataum').each(function(){
        valum = $(this).data('nota');
       // alert(valum);
        arrnotakas.push(valum);

      })

      index = arrnotakas.indexOf(nokas);

      if(index == -1) {
        notr = $('.dataum').length;
        if(notr.length == 0){
          notr = 1;
        }
        else {
          notr += 1;
        }

        html2 = '<tr class="dataum dataum'+notr+'" data-nota='+nokas+'> <td> <p class="nofaktur idtrum nofaktur2'+notr+'"  onclick="klikkas(this)" data-id='+notr+'>'+nofaktur+'</p> <input type="hidden" class="nofaktur" value="'+nofaktur+'"> </td>'+
                  '<td> <p class="nokas_text">'+nokas+'</p> <input type="hidden" class="nokas" value="'+nokas+'" name="nokas[]"> </td>' +
                  '<td><p class="tgl_text">'+tgl+'</p> <input type="hidden" class="tglum" value="'+tgl+'" name="tglum[]"></td>' +
                  '<td><p class="notaum_text">'+notaum+'</p> <input type="hidden" class="notaum" value="'+notaum+'" name="notaum[]"> </td>' +
                  '<td> <p class="jumlahum_text">'+jumlah+'</p> <input type="hidden" class="jumlahum" value="'+jumlah+'" name="jumlahum[]"> </td>' +
                  '<td> <p class="dibayar_text">'+dibayar+'</p> <input type="hidden" class="dibayar" value="'+dibayar+'" name="dibayarum[]"> </td>'+
                  '<td> <p class="keterangan_text">'+keterangan+'</p><input type="hidden" value="'+keterangan+'" class="keteranganum" name="keteranganum[]"> <input type="hidden" class="akunhutangum" value="'+akunhutang+'" name="akunhutangum[]"> <input type="hidden" class="keteranganumheader" value="'+keteranganum+'" name="keteranganumheader"> <input type="hidden" class="flagum" value="'+flagum+'" name="flagum[]"></td>' +
                  '<td> <button class="btn btn-sm btn-danger" type="button" onclick="hapusum(this)"><i class="fa fa-trash"></i></button></td>'+ 
                "</tr>";

                $('#tablehasilum').append(html2);
               
        /*tableum.row.add($(html2)).draw();*/
        }
        else {
           // alert(dibayar);
           /* console.log($("#"+nokas));*/
            var a          = $('.nofaktur2'+notransaksi);
            var val = $(a).parents('tr');
            $(val).find('.nofaktur').val(nofaktur);
            $(val).find('.nokas').val(nokas);
            $(val).find('.tglum').val(tgl);
            $(val).find('.notaum').val(notaum);
            $(val).find('.dibayar').val(dibayar);
            $(val).find('.jumlahum').val(jumlah);
            $(val).find('.keteranganum').val(keterangan);
            $(val).find('.keteranganumheader').val(keteranganum);
            $(val).find('.flagum').val(flagum);

            $(val).find('.nofaktur').text(nofaktur);
            $(val).find('.nokas_text').text(nokas);
            $(val).find('.tgl_text').text(tgl);
            $(val).find('.notaum_text').text(notaum);
            $(val).find('.dibayar_text').text(dibayar);
            $(val).find('.jumlahum_text').text(jumlah);
            $(val).find('.keterangan_text').text(keterangan);



        }
         $('.editum').val('');
          totaljumlah = 0;
                $('.dibayar').each(function(){
                  val = $(this).val();
                   dibayar2 = val.replace(/,/g,'');
                  // alert(dibayar2);
                  // alert(totaljumlah);
                   totaljumlah = parseFloat(parseFloat(totaljumlah) + parseFloat(dibayar2)).toFixed(2);
                });

                var a = $('ul#tabmenu').find('li.active').data('val');

                if(a == 'I'){
                  nettohutang2 = $('.nettohutang').val();
                 
                   nettohutangs = nettohutang2.replace(/,/g,'');
                   // alert(nettohutangs);
                   // alert(totaljumlah + 'totaljumlah');
                  if(parseFloat(totaljumlah) > parseFloat(nettohutangs)){
                    toastr.info("Mohon Maaf Kelebihan data jumlah uang muka, netto hutang di Faktur" + addCommas(nettohutangs));
                     $('.totaljumlah').val(addCommas(totaljumlah));
                    return false;
                    $('.buttonsimpan_um').attr("disabled", true);
                  }
                  else {
                    $('.totaljumlah').val(addCommas(totaljumlah));  
                    $('.inputbayaruangmuka').val('sukses');  
                     $('.buttonsimpan_um').attr("disabled", false);                
                  }
                }
                else {
                   nettohutang2 = $('.nettohutang_po').val();
                 
                   nettohutangs = nettohutang2.replace(/,/g,'');
                   // alert(nettohutangs);
                   // alert(totaljumlah + 'totaljumlah');
                  if(parseFloat(totaljumlah) > parseFloat(nettohutangs)){
                    toastr.info("Mohon Maaf Kelebihan data jumlah uang muka, netto hutang di Faktur" + addCommas(nettohutangs));
                     $('.totaljumlah').val(addCommas(totaljumlah));
                    return false;
                    $('.buttonsimpan_um').attr("disabled", true);
                  }
                  else {
                    $('.totaljumlah').val(addCommas(totaljumlah));  
                    $('.inputbayaruangmuka').val('sukses');  
                     $('.buttonsimpan_um').attr("disabled", false);                
                  }
                }
          
  })  

  function klikkas(p){

    var val          = $(p).parents('tr');
    nofaktur = $(val).find('.nofaktur').val();
    nokas = $(val).find('.nokas').val();
    tglum = $(val).find('.tglum').val();
    notaum = $(val).find('.notaum').val();
    dibayar = $(val).find('.dibayar').val();
    jumlahum = $(val).find('.jumlahum').val();
    keteranganum = $(val).find('.keteranganum').val();
    keteranganumheader = $(val).find('.keteranganumheader').val();
    flagum = $(val).find('.flagum').val();

    notr = $(val).find('.idtrum').data('id');
    
    //alert(notr);
    //alert(a);

    /*$('.nofaktur').val(nofaktur);*/
    $('.no_umheader').val(nokas);
    $('.tgl_umheader').val(tglum);
    $('.jumlah_header').val(jumlahum);
     $('.keterangan_header').val(keteranganum);
     $('.keteranganum_header').val(keteranganumheader);
    $('.dibayar_header').val(addCommas(dibayar));
    $('.nota_um').val(notaum);
    $('.notr').val(notr);
    $('.flag_um').val(flagum);


  }


  $('#buttonsimpan_um').click(function(){
      $('#bayaruangmuka').modal('toggle'); 
      
      totalum2 = $('.totaljumlah').val();
      totalum   = totalum2.replace(/,/g,'');
      sisahutang2 = $('.nettohutang_po').val();
      sisahutang = sisahutang2.replace(/,/g,'');
      
      hasilsisa = (parseFloat(sisahutang) - parseFloat(totalum)).toFixed(2);
      $('.sisahutang_po').val(addCommas(hasilsisa));

      $('.fp_uangmuka').val(totalum);

    });


  function hapusum(id){
     var val          = $(id).parents('tr');
     dibayar = $(val).find('.dibayar').val();
     totaljumlah = $('.totaljumlah').val();
     totaljumlah2 = totaljumlah.replace(/,/g,'');
     dibayar2 = dibayar.replace(/,/g,'');

     hasil = parseFloat(parseFloat(totaljumlah2) - parseFloat(dibayar2)).toFixed(2);
     $('.totaljumlah').val(addCommas(hasil));
     val.remove();
  }

  $('#buttongetum').click(function(){

    id = $('.check:checked').val();

    cabangtransaksi = $('.cabangtransaksi').val();
    $.ajax({
      url : baseUrl + '/fakturpembelian/hasilum',
      data : {id,cabangtransaksi},
      dataType : "json",
      type : "get",
      success : function(response){
        $('#caritransaksium').modal('toggle');
        $('.no_umheader').val(response.um[0].nota);
        $('.tgl_umheader').val(response.um[0].tgl);
        $('.jumlah_header').val(addCommas(response.um[0].sisaterpakai));
        $('.keterangan_header').val(response.um[0].keterangan);
        $('.nota_um').val(response.um[0].nota_um);
        $('.idtransaksi').val(response.um[0].idtransaksi);
        $('.akunhutang_um').val(response.um[0].acchutang);
        $('.flag_um').val(response.um[0].flag);
          var tableum = $('#tabletransaksi').DataTable();
      }
    })    


  })

  $('#transaksium').click(function(){
    var tableum = $('#tabletransaksi').DataTable();
    tableum.clear().draw();

    idsup = $('.idsup2').val();
    arrnoum = [];
    $('.dataum').each(function(){
      val = $(this).data('nota');
      arrnoum.push(val);
    })
  
    cabang = $('.cabangtransaksi').val();

    $.ajax({
      url : baseUrl + '/fakturpembelian/getum',
      data :{idsup,arrnoum,cabang},
      type : "get",
      dataType : "json",
      success : function(response){

          um = response.um;
           var tableum = $('#tabletransaksi').DataTable();
            tableum.clear().draw();
            var n = 1;
            for(var i = 0; i < response.um.length; i++){   
            console.log(response.um.length);          
                var html2 = "<tr>"+
                            "<td>"+um[i].nota+"</td>" +
                            "<td> "+um[i].tgl+"</td>" +
                            "<td> "+um[i].supplier+"</td>" +
                            "<td> "+um[i].keterangan+"</td>" +
                            "<td> "+addCommas(um[i].totalbayar)+"</td>" +
                            "<td> "+addCommas(um[i].sisaterpakai)+"</td>" +
                            "<td> <div class='checkbox'> <input type='checkbox' class='check' value="+um[i].idtransaksi+" aria-label='Single checkbox One'> <label></label> </div> </td>" + 
                            "</tr>";

               tableum.rows.add($(html2)).draw();
               n++;
            }


      }
    })
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

     $.ajax({
            type : "get",
            data  : {grupitem},
            url : baseUrl + "/fakturpembelian/datagroupitem",
            dataType : "json",
            success : function(response){
             
            
              for(i = 0; i < response.countgroupitem; i++){
              //  console.log(response.groupitem[i].kode_jenisitem+','+response.groupitem[i].stock);
                 $('#selectgroup option[value="'+response.groupitem[i].kode_jenisitem+'"]').remove();
              }

              /*$('#selectgroup option[value="J,T"]').remove(); */
            }
          })


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

       cabang = $('.cabang').val();

       
      

       if(idsup == '') {
          toastr.info('Dimohon untuk pilih Supplier Terlebih Dahulu :)');

       }
           $('.penerimaan').val(stock);
           $.ajax({    
            type :"post",
            data : {idsup, groupitem,updatestock, cabang},
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
      supplier = $('.idsup2').val();
      string = supplier.split("+");
      edit = 'edit';
      nofaktur = $('.nofaktur').val();
      if(supplier == ''){
          toastr.info("Mohon maaf supplier belum di pilih :)");
          return false;
      }
       $.ajax({    
            type :"post",
            data : {cabang,supplier,edit,nofaktur},
            url : baseUrl + '/fakturpembelian/getnotatt',
            dataType:'json',
            success : function(data){
              console.log(data);
                //console.log(data['tt'][0].tt_idform);
                tableTT = $('#table_tt').DataTable();
                tableTT.clear().draw();
                nomor = 1;
                for(i = 0; i < data['tt'].length; i++){
                // alert('ha');
                  var  html = "<tr> <td>"+nomor+"</td> <td>"+data['tt'][i].tt_supplier+"</td> <td>"+data['tt'][i].tt_noform+"</td> <td>"+data['tt'][i].tt_tglkembali+"</td> <td>"+data['tt'][i].ttd_invoice+"</td><td>"+addCommas(data['tt'][i].ttd_nominal)+"</td>";

                  html += "<td><div class='checkbox'> <input type='checkbox' id="+data['tt'][i].tt_idform+","+data['tt'][i].ttd_detail+","+data['tt'][i].tt_noform+" class='check_tt' value='option1' aria-label='Single checkbox One'>" +
                                      "<label></label>" +
                                      "</div> </td>" +
                                      "</tr>";              
                    nomor++;

                  tableTT.rows.add($(html)).draw();
                }
            }
        })
    })

      $('#buttonsimpan_tt').click(function(){
      notandaterima = $('.notandaterima').val();

      var checked = $(".check_tt:checked").map(function(){
        return this.id;
      }).toArray();
  //    alert(checked[0]);


      if(checked[0] == undefined){
        toastr.info("Tolong di check no tandaterima nya :)");
        return false;
      }
      else {
      //      alert(checked);
            variablett = checked[0];
            notatt = variablett.split(",");
           // alert(notatt);
            notandaterima = notatt[2];
            //alert(notandaterima);
      
      
            $('.datatandaterima').val(checked[0]);
            $('.notandaterima').val(notandaterima);
            $('#myModal_TT').modal("toggle" );
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
        tandaterima = $('.datatandaterima').val();
        inputppn = $('.inputppn').val();
        hasilppn = $('.hasilppn').val();
        tampilpo = $('.tampilpo').val();
        /*alert(tampilpo);
        alert(pajakmasukan);
        alert(tandaterima);*/
          event.preventDefault();
         // alert('test');
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();  
          var form_data3 = $('#form_hasilum').serialize();
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
          data : form_data2+form_data3,
          url : baseUrl + "/fakturpembelian/updatefaktur",
          dataType : 'json',
          success : function (response){
            console.log(response);
             if(response.status == 'sukses') {
                alertSuccess(); 
             // window.location.href = baseUrl + "/fakturpembelian/fakturpembelian";
             $('.simpanupdate').attr('disabled' , true);
             idfaktur = $('.idfaktur').val();
                html = "<a class='btn btn-info btn-sm' href={{url('fakturpembelian/cetakfaktur/')}}"+'/'+idfaktur+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a>";
              $('.printpo').html(html);
              }
              else if (response.status == 'gagal'){
               swal({
                  title: "error!",
                          type: 'error',
                          text: response.info,
                          timer: 900,
                         showConfirmButton: false
                       
                  });
            }
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });
      
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
                      /*  if(diskon != '') {
                          hasil = parseFloat(qty * harga);  
                          totalharga = hasil.toFixed(2);
                          $('.amount').val(addCommas(totalharga));
                          
                          hsldiskon = parseFloat(diskon * 100) / 100;
                          biaya = totalharga - hsldiskon;
                          hslamount = biaya.toFixed(2); 
                          $('.biaya').val(hslamount);
                          alert(hslamount);
                        }
                        else {*/
                          hasil = parseFloat(qty * harga);  
                          totalharga = hasil.toFixed(2);
                          $('.amount').val(addCommas(totalharga));

                          biaya = $('.biaya').val();
                          hslbiaya = biaya.replace(/,/g, '');
                          nettoitem = parseFloat(parseFloat(hslbiaya) + parseFloat(totalharga)).toFixed(2);
                          $('.nettomodal').val(addCommas(nettoitem));
                         /* alert('asas');
                        }*/
                    }
            }                     
          }) 
    })


  
    
    $('.harga').change(function(){
      val = $(this).val();
      qty = $('.qty').val();

      val = accounting.formatMoney(val, "", 2, ",",'.');
      $(this).val(val);


      if(qty != '') {
        amount = parseInt(qty) * parseInt(val);
        num_amount = parseFloat(amount).toFixed(2);
        numeric = parseFloat(val).toFixed(2);
        harga = addCommas(numeric);
        $(this).val(harga);
        $('.amount').val(addCommas(num_amount));

        biaya = $('.biaya').val();
        hasilnetto = parseFloat(parseFloat(biaya) + parseFloat(num_amount)).toFixed(2);
        $('.nettomodal').val(addCommas(hasilnetto));
      }

    
    })

     $('.biaya').change(function(){
      val = $(this).val();    
      val = accounting.formatMoney(val, "", 2, ",",'.');
      $(this).val(val);

      hslbiaya =  val.replace(/,/g, '');

      totalharga = $('.amount').val();
      hsltotal =  totalharga.replace(/,/g, '');
      hasilnetto = parseFloat(parseFloat(hslbiaya) + parseFloat(hsltotal)).toFixed(2);
      $('.nettomodal').val(addCommas(hasilnetto));
    })

    $('.qty').change(function(){
      val = $(this).val();
      harga = $('.harga').val();
      console.log(harga);

      if(harga != ''){

         hsljml =  harga.replace(/,/g, '');
        num_amount = parseFloat(parseInt(val) * parseInt(hsljml)).toFixed(2);
        /*num_amount = Math.round(amount).toFixed(2);*/
       /* console.log(parseInt(harga));
        console.log(val);*/
        $('.amount').val(addCommas(num_amount));

        biaya = $('.biaya').val();
        hslbiaya = biaya.replace(/,/g,'');

        hslnet = parseFloat(parseFloat(hslbiaya) + parseFloat(num_amount)).toFixed(2);
        $('.nettomodal').val(addCommas(hslnet));

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

        //biaya
        $('.biayaitem').change(function(){
        //alert('as');
          var jmlbiayaqty = 0;
          var id = $(this).data('id');
         
          totalbiayaitem  = $('.totalbiayaitem' + id).val();
          hsl = totalbiayaitem.replace(/,/g,'');
           val = $(this).val();     
           val = accounting.formatMoney(val, "", 2, ",",'.');
          $(this).val(val);


            biaya = $('.biayaitem' + id).val();
           // alert(biaya);
            hslbiaya = biaya.replace(/,/g,'');

            hslnett = parseFloat(parseFloat(hslbiaya) + parseFloat(hsl)).toFixed(2);
            $('.nettoitem' + id).val(addCommas(hslnett));

         $('.nettoitem').each(function(){
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
                   hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                    
                    $('.dpp_po').val(addCommas(numeric2));
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                   // $('.sisahutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));
                    

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                     hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                    //  $('.sisahutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    

                      fpuangmuka = $('.fp_uangmuka').val();
                    
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                      //  $('.sisahutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                      

                        fpuangmuka = $('.fp_uangmuka').val();
                      
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));


                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                $('.tampilpo').val('update');
               $('.inputtandaterima').val('tidaksukses');
        })

     
       $('.qtyitem').change(function(){
        //alert('as');
         var jmlbiayaqty = 0;
          var id = $(this).data('id');
          var qty = $(this).val();
          harga = $('.hargaitem' + id).val();
          
          console.log(harga + 'harga');
          hslharga =  harga.replace(/,/g, '');

          var hasil = parseFloat(qty * hslharga);
          hsl = hasil.toFixed(2);
          $('.totalbiayaitem' + id).val(addCommas(hsl));

         /* diskon = $('.diskonit.em2' + id).val();
          diskon2 = parseFloat(diskon * hsl / 100);
          console.log(diskon2);
          hsldiskon = diskon2.toFixed(2);
          totalbiaya = parseFloat(hsl - hsldiskon);
          console.log(totalbiaya);
          hsltotalbiaya = totalbiaya.toFixed(2);

          $('.biayaitem' + id).val(addCommas(hsltotalbiaya)); */

            biaya = $('.biayaitem' + id).val();
            hslbiaya = biaya.replace(/,/g,'');

            hslnett = parseFloat(parseFloat(hslbiaya) + parseFloat(hsl)).toFixed(2);
            $('.nettoitem' + id).val(addCommas(hslnett));

         $('.nettoitem').each(function(){
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

         /*     if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }*/

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
                    hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                    
                    $('.dpp_po').val(addCommas(numeric2));
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                   // $('.sisahutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));
                    
                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                     hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                    //  $('.sisahutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    

                      fpuangmuka = $('.fp_uangmuka').val();
                    
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                     //      alert('E');          
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                      //  $('.sisahutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                      

                        fpuangmuka = $('.fp_uangmuka').val();
                      
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                     hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));


                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                $('.tampilpo').val('update');
               $('.inputtandaterima').val('tidaksukses');
                  

        })

    $('.hasilppn_po').change(function(){
      val = $(this).val();
      val = accounting.formatMoney(val, "", 2, ",",'.');
      $(this).val(val);

      jenisppn = $('.jenisppn_po').val();
      if(jenisppn == 'T'){
        $(this).val('');
        return false;
      }

      pph = $('.hasilpph_po').val();
      if(pph != ''){
        dpp = $('.dpp_po').val();
        hasilpph = pph.replace(/,/g,'');
        hasildpp = dpp.replace(/,/g,'');
        hasilppn = val.replace(/,/g,'');

        hasilnetto = parseFloat(parseFloat(hasildpp) + parseFloat(hasilppn) - parseFloat(hasilpph)).toFixed(2);
        $('.nettohutang_po').val(addCommas(hasilnetto));
        totaljumlah2 = $('.totaljumlah').val();
              //    alert(totaljumlah2);
        if(totaljumlah2 != ''){
          totaljumlah = totaljumlah2.replace(/,/g,'');
          hslselisihum = parseFloat(parseFloat(hasilnetto) - parseFloat(totaljumlah)).toFixed(2);
          $('.sisahutang_po').val(addCommas(hslselisihum));
        }
        else {
          $('.sisahutang_po').val(addCommas(hasilnetto));
        }
      }
      else {
        dpp = $('.dpp_po').val();
        hasildpp = dpp.replace(/,/g,'');
        hasilppn = val.replace(/,/g,'');
        hasilnetto = parseFloat(parseFloat(hasildpp) + parseFloat(hasilppn)).toFixed(2);
        totaljumlah2 = $('.totaljumlah').val();
              //    alert(totaljumlah2);
        $('.nettohutang_po').val(addCommas(hasilnetto));
        if(totaljumlah2 != ''){
          totaljumlah = totaljumlah2.replace(/,/g,'');
          hslselisihum = parseFloat(parseFloat(hasilnetto) - parseFloat(totaljumlah)).toFixed(2);
          $('.sisahutang_po').val(addCommas(hslselisihum));
        }
        else {
          $('.sisahutang_po').val(addCommas(hasilnetto));
        }
      }

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

         /*     if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }*/

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
                   hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));


                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));
                    

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                       hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);

                       $('.nettohutang_po').val(addCommas(hsl));
                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }                     
                       $('.dpp_po').val(addCommas(numeric2));
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                       hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));

                         fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                      
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }  
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
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

      if(hasilppn == 0.00){
        toastr.info("Hasil Nilai PPn anda 0 :)");
        return false;
      }
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
                  "<td> <input type='text' class='form-control input-sm totalharga"+pobarang[k][j].po_id+"' value='"+addCommas(pobarang[k][j].sumharga)+"' readonly name='totalharga[]'> </td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].pbdt_updatestock+"' readonly name='updatestock[]'></td>" +
                  "<td> <input type='text' class='form-control input-sm' value='"+pobarang[k][j].acc_persediaan+"' readonly name='accpersediaan[]'> </td>" +
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

             /* if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }*/

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
                  hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                  }
                  else{ //PPN TIDAK KOSONG            
                     hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));

                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }  
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
              //    alert('pph kosong');
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                  /*      alert(parseFloat(numeric2));
                        alert(parseFloat(replaceppn));
                        alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));*/
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));

                        fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                     hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                      
                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));


                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
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


            fpuangmuka = $('.fp_uangmuka').val();
                  
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(hsl));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }

          }else{ //PPH KOSONG
           
             $('.nettohutang_po').val(dpp);


              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(dpp));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(dpp) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              } 
          }
      }
      else if (jenisppn == 'E') {
   
          if(pph != ''){ //PPH TIDAK KOSONG
            hasilpph = $('.hasilpph_po').val();
            replacepph = hasilpph.replace(/,/g,'');

            hasilnetto = parseFloat((parseFloat(dpphasil)+parseFloat(hasil2)) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));
            fpuangmuka = $('.fp_uangmuka').val();
                  
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(hsl));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }

          }else{ //PPH KOSONG
           
             hasilnetto = parseFloat(parseFloat(dpphasil) + parseFloat(hasil2));
             hsl = hasilnetto.toFixed(2);
           
             $('.nettohutang_po').val(addCommas(hsl));
              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(hsl));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
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

              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(total));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              } 
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

               fpuangmuka = $('.fp_uangmuka').val();
                  
                if(fpuangmuka == ''){
                  $('.sisahutang_po').val(addCommas(total));
                }
                else {
                  hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                  $('.sisahutang_po').val(addCommas(hasilsisahutang));
                }
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
        
      if(val == ''){
        $('.hasilpph_po').val('0.00');
        $('.inputpph_po').val('0');
        hasiltarif2 = 0;
      }
         
      if($('.hasilppn_po').val() != '') { //ppn  tidak kosong
           ppn = $('.hasilppn_po').val();
             hasilppn = ppn.replace(/,/g,'');
             pph = addCommas(hasiltarif2);
             hasilpph = pph.replace(/,/g,'');
             hasilnetto = parseFloat(parseFloat(hsldpp)+parseFloat(hasilppn) - parseFloat(hasilpph)); 
             hsl = hasilnetto.toFixed(2);
             $('.nettohutang_po').val(addCommas(hsl));

            fpuangmuka = $('.fp_uangmuka').val();
                  
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(hsl));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }
      }
      else {
          hslnetto = parseFloat(parseFloat(hsldpp) - parseFloat(hasiltarif2));
          netto2 = hslnetto.toFixed(2);
          $('.nettohutang_po').val(addCommas(netto2));

          fpuangmuka = $('.fp_uangmuka').val();
                  
          if(fpuangmuka == ''){
            $('.sisahutang_po').val(addCommas(netto2));
          }
          else {
            hasilsisahutang = parseFloat(parseFloat(netto2) - parseFloat(fpuangmuka)).toFixed(2);
            $('.sisahutang_po').val(addCommas(hasilsisahutang));
          }
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

               fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(hasilnetto));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(hasilnetto) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
            }
            else{
              hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(hasilnetto));
              $('.dpp_po').val(dpp);

               fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(hasilnetto));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(hasilnetto) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
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

              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(total));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }

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

              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(total));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }   
            }
          }
          else if(jenisppn == 'T') {
            if(pph == '' ){
          
              $('.hasilppn_po').val('');
              $('.nettohutang_po').val(dpp);
              $('.dpp_po').val(dpp);

              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(dpp));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(dpp) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
            }

            else{
            
              $('.hasilppn_po').val('');
               total = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)).toFixed(2);
              $('.nettohutang_po').val(addCommas(total));
              $('.dpp_po').val(dpp);

              fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(total));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
            }
           
          }

        }
        
    })


     $(document).on('click','.removes-itm',function(){
          var id = $(this).data('id');
         
       //   replace = total.replace(/,/g,'');
        
          jumlahharga = $('.jumlahharga_po').val();
          replacejumlah = jumlahharga.replace(/,/g,'');
         
            val2 = $('.nettoitem' + id).val();
           // alert(val2);
            replaceval2 = val2.replace(/,/g,'');

            hasil = parseFloat(parseFloat(replacejumlah) - parseFloat(replaceval2)).toFixed(2);
            $('.tampilpo').val('update');
         
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
                  hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
                 // alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                  }
                  else{ //PPN TIDAK KOSONG            
                     hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                       $('.dpp_po').val(addCommas(numeric2));
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                //  alert('pph kosong');
                       hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                       // alert(parseFloat(numeric2));
                        //alert(parseFloat(replaceppn));
                        //alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));
                        $('.nettohutang_po').val(addCommas(hsl));
                          $('.dpp_po').val(addCommas(numeric2));

                        fpuangmuka = $('.fp_uangmuka').val();                 
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        } 
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                     hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));

                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                   
                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }// END PPN
       })


     $(document).on('click','.removes-btn',function(){
          var id = $(this).data('id');
          var total = $('.totalharga' + id).length;
       //   replace = total.replace(/,/g,'');
        $('.tampilpo').val('update');
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

             /* if(inputppn != '') {
                 hasilppn = parseFloat((inputppn / 100) * numeric2);
                 hasilppn2 =   hasilppn.toFixed(2);
                 ppn2 = $('.hasilppn_po').val(addCommas(hasilppn2)); 
                 ppn = $('.hasilppn_po').val(); 
              }*/

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
                 hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                    hsl = hasilnetto.toFixed(2);
                    $('.nettohutang_po').val(addCommas(hsl));
                    $('.dpp_po').val(addCommas(numeric2));


                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
                 // alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));
                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                     hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));

                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(ppn != '') { //PPN TIDAK KOSONG   
               // alert('ppn tdk kosong')        
                  jenisppn = $('.jenisppn_po').val();
                  if(pph == 0){ //PPN TIDAK KOSONG PPH KOSONG
                //  alert('pph kosong');
                        hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                        hsl = hasil.toFixed(2);
                      //  alert(parseFloat(numeric2));
                      //  alert(parseFloat(replaceppn));
                      //  alert(parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)));
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));

                         fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                     hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                      
                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));
                    $('.inputppn_po').val('');
                    $('.hasilppn_po').val('');

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

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
            hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
            hsl = hasilnetto.toFixed(2);
            $('.nettohutang_po').val(addCommas(hsl));
            $('.dpp_po').val(addCommas(numeric2));

             fpuangmuka = $('.fp_uangmuka').val();
          
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(hsl));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }
        }
        else if(pph != ''){ //PPH TIDAK KOSONG
     
          if(ppn == '') { //PPN KOSONG          
            hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
            $('.nettohutang_po').val(hasil);
            $('.dpp_po').val(addCommas(numeric2));

            fpuangmuka = $('.fp_uangmuka').val();
                  
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(hasil));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }
          }
          else{ //PPN TIDAK KOSONG            
             hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
              $('.dpp_po').val(addCommas(numeric2));

               fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(hsl));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
          }
        }
        else if(ppn != '') { //PPN TIDAK KOSONG
    
          jenisppn = $('.jenisppn_po').val();
          if(pph == ''){ //PPN TIDAK KOSONG PPH KOSONG
              hasil = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn));
                hsl = hasil.toFixed(2);
                $('.nettohutang_po').val(addCommas(hsl));
                $('.dpp_po').val(addCommas(numeric2));
                
                fpuangmuka = $('.fp_uangmuka').val();
                  
                if(fpuangmuka == ''){
                  $('.sisahutang_po').val(addCommas(hsl));
                }
                else {
                  hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                  $('.sisahutang_po').val(addCommas(hasilsisahutang));
                }
          }
          else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
              hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
              hsl = hasilnetto.toFixed(2);
              $('.nettohutang_po').val(addCommas(hsl));
              $('.dpp_po').val(addCommas(numeric2));

               fpuangmuka = $('.fp_uangmuka').val();
                  
              if(fpuangmuka == ''){
                $('.sisahutang_po').val(addCommas(hsl));
              }
              else {
                hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                $('.sisahutang_po').val(addCommas(hasilsisahutang));
              }
          }
        } 
        else {
       
          $('.nettohutang_po').val(addCommas(numeric2));
            $('.dpp_po').val(addCommas(numeric2));
             $('.inputppn_po').val('');
           $('.hasilppn_po').val('');

            fpuangmuka = $('.fp_uangmuka').val();
                  
            if(fpuangmuka == ''){
              $('.sisahutang_po').val(addCommas(numeric2));
            }
            else {
              hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
              $('.sisahutang_po').val(addCommas(hasilsisahutang));
            }
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
         // $('.groupitem').attr('disabled' , true);

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
     //     var diskon = $('.diskon').val();
          var biaya = $('.biaya').val();
          var netto = $('.nettomodal').val();
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
                  "<input type='hidden' class='form-control groupitem' value="+groupitem+" name='grupitem[]'> </td>"+ //qty
                  
                  "<td> <select class='form-control gudangitem gudangitem"+nourut+"' name='gudang[]' readonly> @foreach($data['gudang'] as $gudang)  <option value='{{$gudang->mg_id}}'> {{$gudang->mg_namagudang}} </option> @endforeach</select> </td>"+ //gudang

                  "<td> <input type='text' class='form-control hargaitem hargaitem"+nourut+"' value='"+ addCommas(harga)+"' name='harga[]' data-id="+nourut+"></td>"+ //harga

                  "<td> <input type='text' class='form-control totalbiayaitem totalbiayaitem"+nourut+"' value='"+ amount+"' name='totalharga[]' readonly> </td>"+ //total harga

       

                  "<td> <input type='text' class='form-control updatestockitem updatestockitem"+nourut+"' value='"+updatestock+"'  name='updatestock[]' readonly> </td>"+ // updatestock
                      

                  "<td>  <input type='text' class='form-control biayaitem biayaitem"+nourut+"' value='"+biaya+"'  name='biaya[]' readonly> </td>"+ //biaya

                  "<td>  <input type='text' class='form-control biayaitem biayaitem"+nourut+"' value='"+netto+"'  name='nettoitem[]' readonly> </td>"+ //biaya


                  "<td> <input type='text' class='form-control acc_biayaitem acc_biayaitem"+nourut+"' value='"+acc_biaya+"' name='acc_biaya[]' readonly> </td>"+ //acc_biaya

                  "<td> <input type='text' class='form-control acc_persediaanitem acc_persediaanitem"+nourut+"' value='"+acc_persediaan+"' name='acc_persediaan[]' readonly> </td>"+ //acc_persediaan

                  "<td> <input type='text' class='form-control keteranganitem keteranganitem"+nourut+"' value='"+keterangan+"'  name='keteranganitem[]'>  <input type='hidden' name='penerimaan[]' class='penerimaan' value='"+penerimaan+"'></td>" +
                  
                  "<td class='edit"+nourut+"'> <button class='btn btn-sm btn-danger removes-itm' data-id='"+nourut+"' type='button'> <i class='fa fa-trash'></i> </button> "+
                  " </td> </tr>"; 

/*
                  <button class='btn btn-xs btn-success update' data-id='"+nourut+"' type='button' id='toggle"+nourut+"'> <i id='edit"+nourut+"' class='fa fa-pencil' aria-hidden='true'></i>"+nourut+"*/

                  hsljml =  netto.replace(/,/g, '');
                  //console.log(hsljml);

                 // alert(hsljml + 'hsljml');

                  $jumlahharga = $jumlahharga + parseInt(hsljml);
                  numeric = parseFloat($jumlahharga).toFixed(2);
     
                 /* Data Jumlah DPP*/
                  total = $('.jumlahharga_po').val();
                  replacetotal = total.replace(/,/g,'');
                  hasiltotal = parseFloat(parseFloat(replacetotal) + parseFloat(numeric)).toFixed(2);

                  //alert(hasiltotal + 'hasiltotal');

                    //cek jika double item
                  nobrg = nourut - 1;
                  idbarang = $('.brg'+nobrg).val();
                  
                  //alert(item);
                  //alert(idbarang);
                  if(item == idbarang){
                    toastr.info('Mohon maaf barang tersebut sudah ditambah :)');
                    return false;
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
                $('.biaya').val('0');
                $('.nettomodal').val('');
                $('.acc_biaya').val('');
                $('.keterangan').val('');
                $('.diskon').val('');
                $('.hasildiskonitem').val('');

             
                $('.tampilpo').val('update');
                $('.inputtandaterima').val('tidaksukses');

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

                    fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                  
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

                       fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(total));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }                  
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                      
                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));
                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));

                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }

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

                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(total));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
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
                         fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
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

                           fpuangmuka = $('.fp_uangmuka').val();
                  
                          if(fpuangmuka == ''){
                            $('.sisahutang_po').val(addCommas(total));
                          }
                          else {
                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                          }
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));

                        fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                    
                      fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
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

                           fpuangmuka = $('.fp_uangmuka').val();
                  
                          if(fpuangmuka == ''){
                            $('.sisahutang_po').val(addCommas(total));
                          }
                          else {
                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                          }
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                      
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                }// END PPN

                 /*END DATA DPP*/


  
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

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
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

                       fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(total));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }                  
                  }
                  else {

                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }
                  }
                }
                else if(pph != 0){ //PPH TIDAK KOSONG            
               //   alert('pph tdk kosong');
                  if(ppn == '') { //PPN KOSONG          
                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                    $('.nettohutang_po').val(hasil);
                    $('.dpp_po').val(addCommas(numeric2));

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hasil));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                  }
                  else{ //PPN TIDAK KOSONG            
                      jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {
                    
                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));

                       fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
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

                       fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(total));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }

                    }
                    else {
                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(hsl));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
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

                           fpuangmuka = $('.fp_uangmuka').val();
                  
                          if(fpuangmuka == ''){
                            $('.sisahutang_po').val(addCommas(hsl));
                          }
                          else {
                            hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                          }
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

                           fpuangmuka = $('.fp_uangmuka').val();
                  
                          if(fpuangmuka == ''){
                            $('.sisahutang_po').val(addCommas(total));
                          }
                          else {
                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                          }
                      }
                      else {
                 
                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));

                         fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                      }
                  }
                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                 
                    jenisppn = $('.jenisppn_po').val();
                    if(jenisppn == 'E') {          
                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                      hsl = hasilnetto.toFixed(2);
                      $('.nettohutang_po').val(addCommas(hsl));
                      $('.dpp_po').val(addCommas(numeric2));
                      
                       fpuangmuka = $('.fp_uangmuka').val();
                  
                      if(fpuangmuka == ''){
                        $('.sisahutang_po').val(addCommas(hsl));
                      }
                      else {
                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                      }

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

                           fpuangmuka = $('.fp_uangmuka').val();
                  
                          if(fpuangmuka == ''){
                            $('.sisahutang_po').val(addCommas(total));
                          }
                          else {
                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                          }
                    }
                    else {

                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                        hsl = hasilnetto.toFixed(2);
                        $('.nettohutang_po').val(addCommas(hsl));
                        $('.dpp_po').val(addCommas(numeric2));
                         fpuangmuka = $('.fp_uangmuka').val();
                  
                        if(fpuangmuka == ''){
                          $('.sisahutang_po').val(addCommas(hsl));
                        }
                        else {
                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                        }
                    }
                  }
                } 
                else {
                    $('.nettohutang_po').val(addCommas(numeric2));
                    $('.dpp_po').val(addCommas(numeric2));

                     fpuangmuka = $('.fp_uangmuka').val();
                  
                    if(fpuangmuka == ''){
                      $('.sisahutang_po').val(addCommas(numeric2));
                    }
                    else {
                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                    }
                }



   })

                 //change di table item
                 $('.barangitem').change(function(){
                 // alert('sss');
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
                      /*     diskon = $('.diskonitem2' + id).val();*/
                          if(qty != '') {
                             
                            
                             hasil = parseFloat(qty * harga);  
                            totalharga = hasil.toFixed(2);
                            $('.totalbiayaitem' + id).val(addCommas(totalharga));

                            biaya = $('.biayaitem' + id).val();
                            hslbiaya = biaya.replace(/,/g, '');
                            nettoitem = parseFloat(parseFloat(hslbiaya) + parseFloat(totalharga)).toFixed(2);
                            $('.nettoitem').val(addCommas(nettoitem));
                          }

                          accpersediaan = response.barang[0].acc_persediaan;
                          acchpp = response.barang[0].acc_hpp;
                          $('.acc_persediaanitem' + id).val(accpersediaan);
                          $('.acc_biayaitem' + id).val(acchpp);

                          /* MENGHITUNG DPP */
                            $('.nettoitem').each(function(){
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

                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(hsl));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }
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

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(total));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }                
                                  }
                                  else {

                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
                                  
                                  }
                                }
                                else if(pph != 0){ //PPH TIDAK KOSONG            
                               //   alert('pph tdk kosong');
                                  if(ppn == '') { //PPN KOSONG          
                                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                                    $('.nettohutang_po').val(hasil);
                                    $('.dpp_po').val(addCommas(numeric2));
                                    
                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(hasil));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }
                                  }
                                  else{ //PPN TIDAK KOSONG            
                                      jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {
                                    
                                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
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
                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(total));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
                                    }
                                    else {
                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
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
                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }

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
                                           fpuangmuka = $('.fp_uangmuka').val();
                  
                                          if(fpuangmuka == ''){
                                            $('.sisahutang_po').val(addCommas(total));
                                          }
                                          else {
                                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                          }
                                      }
                                      else {
                                 
                                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));
                                        
                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }

                                      }
                                  }
                                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                                 
                                    jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {          
                                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
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

                                           fpuangmuka = $('.fp_uangmuka').val();
                  
                                          if(fpuangmuka == ''){
                                            $('.sisahutang_po').val(addCommas(total));
                                          }
                                          else {
                                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                          }

                                    }
                                    else {

                                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));
                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }
                                    }
                                  }
                                } 
                                else {
                                    $('.nettohutang_po').val(addCommas(numeric2));
                                    $('.dpp_po').val(addCommas(numeric2));

                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(numeric2));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }
                                }


                      }                     
                    })                    
                 })

                


        $(document).on('click','.removes-btn',function(){
          var id = $(this).data('id');
         $('.tampilpo').val('update');
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
    



//change di table item
     $('.barangitem').change(function(){
        var id = $(this).data('id');
        barang = $(this).val();

     
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
              // diskon = $('.diskonitem2' + id).val();
              
               if(qty != '') {
             
                  hasil = parseFloat(qty * harga);  
                  totalharga = hasil.toFixed(2);
                  $('.totalbiayaitem' + id).val(addCommas(totalharga));

                  biaya = $('.biayaitem' + id).val();
                  hslbiaya = biaya.replace(/,/g, '');
                  nettoitem = parseFloat(parseFloat(hslbiaya) + parseFloat(totalharga)).toFixed(2);
                  $('.nettoitem' + id).val(addCommas(nettoitem));
                }

                accpersediaan = response.barang[0].acc_persediaan;
                acchpp = response.barang[0].acc_hpp;
                $('.acc_persediaanitem' + id).val(accpersediaan);
                $('.acc_biayaitem' + id).val(acchpp);


                 $('.nettoitem').each(function(){
                  val2 = $(this).val();
                  replaceval2 = val2.replace(/,/g,'');

                  jmlbiayabrg = parseFloat(parseFloat(jmlbiayabrg) + parseFloat(replaceval2)).toFixed(2);

                })

                          //menghitung jumlah
                          $('.jumlahharga_po').val(addCommas(jmlbiayabrg));
                          hasiltotal = $

                          //diskon
                          diskon = $('.disc_item_po').val();
                          if(diskon != ''){
                            hsl = parseFloat(parseFloat(diskon) * parseFloat(jmlbiayabrg)) / 100;
                            hasildiskon = $('.hasildiskon_po').val(addCommas(hsl));

                            jumlah = parseFloat(parseFloat(jmlbiayabrg) - parseFloat(hsl)).toFixed(2);
                          }
                          else {
                            jumlah = jmlbiayabrg;
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

                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(hsl));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }

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

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(total));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }                    
                                  }
                                  else {

                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }
                                  
                                  }
                                }
                                else if(pph != 0){ //PPH TIDAK KOSONG            
                               //   alert('pph tdk kosong');
                                  if(ppn == '') { //PPN KOSONG          
                                    hasil = parseFloat(parseFloat(numeric2) - parseFloat(replacepph));
                                    $('.nettohutang_po').val(hasil);
                                    $('.dpp_po').val(addCommas(numeric2));

                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(hasil));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(hasil) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }
                                  }
                                  else{ //PPN TIDAK KOSONG            
                                      jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {
                                    
                                      hasilnetto = parseFloat((parseFloat(numeric2)+parseFloat(replaceppn)) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                       $('.dpp_po').val(addCommas(numeric2));
                                        fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }
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

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(total));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
                                    }
                                    else {
                                      hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                      $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }
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

                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }
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

                                           fpuangmuka = $('.fp_uangmuka').val();
                  
                                          if(fpuangmuka == ''){
                                            $('.sisahutang_po').val(addCommas(total));
                                          }
                                          else {
                                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                          }
                                      }
                                      else {
                                 
                                        hasilnetto = parseFloat(parseFloat(numeric2) + parseFloat(replaceppn)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));

                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }

                                      }
                                  }
                                  else{ //PPN TIDAK KOSONG PPH TIDAK KOSONG
                                 
                                    jenisppn = $('.jenisppn_po').val();
                                    if(jenisppn == 'E') {          
                                      hasilnetto = parseFloat(parseFloat(numeric2)+parseFloat(replaceppn) - parseFloat(replacepph)); 
                                      hsl = hasilnetto.toFixed(2);
                                      $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));

                                       fpuangmuka = $('.fp_uangmuka').val();
                  
                                      if(fpuangmuka == ''){
                                        $('.sisahutang_po').val(addCommas(hsl));
                                      }
                                      else {
                                        hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                        $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                      }  
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

                                           fpuangmuka = $('.fp_uangmuka').val();
                  
                                          if(fpuangmuka == ''){
                                            $('.sisahutang_po').val(addCommas(total));
                                          }
                                          else {
                                            hasilsisahutang = parseFloat(parseFloat(total) - parseFloat(fpuangmuka)).toFixed(2);
                                            $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                          }
                                    }
                                    else {

                                        hasilnetto = parseFloat(parseFloat(numeric2) - parseFloat(replacepph)); 
                                        hsl = hasilnetto.toFixed(2);
                                        $('.nettohutang_po').val(addCommas(hsl));
                                        $('.dpp_po').val(addCommas(numeric2));

                                         fpuangmuka = $('.fp_uangmuka').val();
                  
                                        if(fpuangmuka == ''){
                                          $('.sisahutang_po').val(addCommas(hsl));
                                        }
                                        else {
                                          hasilsisahutang = parseFloat(parseFloat(hsl) - parseFloat(fpuangmuka)).toFixed(2);
                                          $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                        }
                                    
                                    }
                                  }
                                } 
                                else {
                                    $('.nettohutang_po').val(addCommas(numeric2));
                                    $('.dpp_po').val(addCommas(numeric2));

                                     fpuangmuka = $('.fp_uangmuka').val();
                  
                                    if(fpuangmuka == ''){
                                      $('.sisahutang_po').val(addCommas(numeric2));
                                    }
                                    else {
                                      hasilsisahutang = parseFloat(parseFloat(numeric2) - parseFloat(fpuangmuka)).toFixed(2);
                                      $('.sisahutang_po').val(addCommas(hasilsisahutang));
                                    }

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

   $('.tmbh-brg').hide();
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
  
  function lihatjurnalum($ref,$note){
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

                          if(hasilpph != '' && hasilppn != ''){
                          
                            if(response.jurnal[key].dk == 'D'){
                              $totalDebit = parseFloat($totalDebit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td>";
                            }
                            else {
                              $totalKredit = parseFloat($totalKredit) + parseFloat(response.jurnal[key].jrdt_value);
                              rowtampil2 += "<td> </td><td>"+accounting.formatMoney(response.jurnal[key].jrdt_value, "", 2, ",",'.')+"</td>";
                            }
                          }else if(hasilpph != '' && hasilppn == ''){
                            if(response.jurnal[key].dk == 'D'){
                              $totalDebit = parseFloat($totalDebit) + parseFloat(response.jurnal[key].jrdt_value);
                              rowtampil2 += "<td>"+accounting.formatMoney(response.jurnal[key].jrdt_value, "", 2, ",",'.')+"</td> <td> </td>";
                            }
                            else {
                              $totalKredit = parseFloat($totalKredit) + parseFloat(response.jurnal[key].jrdt_value);
                              rowtampil2 += "<td> </td><td>"+accounting.formatMoney(response.jurnal[key].jrdt_value, "", 2, ",",'.')+"</td>";
                            }
                          }
                          else {
                          
                              if(response.jurnal[key].dk == 'D'){
                              $totalDebit = parseFloat($totalDebit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td>";
                            }
                            else {
                              $totalKredit = parseFloat($totalKredit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td> </td><td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td>";
                            }
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


/*   function lihatjurnalum($ref,$note){

          $.ajax({
          url:baseUrl +'/fakturpembelian/lihatjurnalumum',
          type:'get',
          data:'ref='+$ref
               +'&note='+$note,
          success:function(response){
                $('#data-jurnal').html(response);
                $('#jurnal').modal('show');
              }
        });
   }
*/</script>
@endsection
