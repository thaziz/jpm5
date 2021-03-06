@extends('main')

@section('title', 'dashboard')

@section('content')
<style>
  #myModal {
  z-index:0;
}
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Penerimaan Barang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Detail Penerimaan Barang  </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
	<br>		
	
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Penerimaan Barang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     
                     <div class="text-right">
                       <a class="btn btn-default" aria-hidden="true" href="{{ url('penerimaanbarang/penerimaanbarang')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 

                    </div>

                </div>                

              <form method="POST" id="formId" action="{{url('penerimaanbarang/savepenerimaan')}}"  enctype="multipart/form-data" class="form-horizontal">
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->               
                  <div class="box-body">
                    <!--  @if(count($jurnal_dt)!=0)
                      <div class="pull-right">
                         <a onclick="lihatjurnal()" class="btn-xs btn-primary" aria-hidden="true"> 
                          <i class="fa  fa-eye"> </i>
                           &nbsp;  Lihat Jurnal  
                         </a> 
                    </div>                    
                      @endif -->

                    <div class="col-xs-12">
                    <input type="hidden" value="{{Auth::user()->m_name}}" name="username">
                  

                    <!-- KONTEN PAKE FP -->
                    @if($data['flag'] == 'FP') <!-- FP -->
                    <input type="hidden" class="flag" value="FP" name="flag">
                    <table border="0" class="table">
                      <tr>
                        <th> Gudang </th>
                        <td> {{$data['header'][0]->mg_namagudang}} </td>
                      </tr>
                     <tr>
                        <input type="hidden" name="idfp" value="{{$data['fp'][0]->fp_idfaktur}}" class="idfp">
                        <input type="hidden" name="idsup" value="{{$data['fp'][0]->fp_idsup}}">
                       
                        <input type="hidden" name="acchutangsupplier" value="{{$data['fp'][0]->acc_hutang}}">
                        <input type="hidden" name="fp_pph" value="{{$data['fp'][0]->fp_pph}}">
                        <input type="hidden" name="fp_jenisppn" value="{{$data['fp'][0]->fp_jenisppn}}">
                        <input type="hidden" name="fp_ppn" value="{{$data['fp'][0]->fp_ppn}}">
                        <input type="hidden" name="fp_diskon" value="{{$data['fp'][0]->fp_discount}}">
                        <input type="hidden" name="fp_hsldiskon" value="{{$data['fp'][0]->fp_hsldiscount}}">
                        <input type="hidden" name="fp_keterangan" value="{{$data['fp'][0]->fp_keterangan}}">
                        <input type="hidden" name="gudang" value="{{$data['header'][0]->bt_gudang}}">
			                   <input type="hidden" name="ref" value="{{$data['header'][0]->bt_id}}">
                        <input type="hidden" name="comp" value="{{$data['comp']}}">
                        <input type="hidden" name="comp_po" value="{{$data['header'][0]->bt_cabangpo}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">


                        

                        <th style="width:200px"> Supplier </th>
                        <td style="width:400px"> <h3> {{$data['fp'][0]->nama_supplier}} </h3> </td>
                      
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> No Surat Jalan </th>
                        <td style="width:400px"> <input type="text" class="form-control suratjalan" name="suratjalan" required="">  </td>
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> Diterima dari </th>
                        <td style="width:400px"> <input type="text" class="form-control diterimadari" name="diterimadari" required="">  </td>
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> Keterangan </th>
                        <td style="width:400px"> <input type="text" class="form-control keterangan" name="keterangan" required="">  </td>
                      </tr>

                      <tr>
                        <th class="tgl suratjalan"> Tanggal di Terima </th>
                        <td>
                          <div class="input-group date tgl">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required>
                          </div>
                        
                          <td>
                          <div class="checkbox checkbox-primary cek2">
                            <input id="lengkap" type="checkbox" class="lengkap">
                            <label for="checkbox2">
                              Lengkap
                            </label>
                           </div>
                         </td>
                      </tr>
                   
                        <tr >
                          <th style="width:200px"> No FB </th>
                          <td style="width:400px"> {{$data['fp'][0]->fp_nofaktur}} </td>
                           
                        </tr>


                        <tr>
                          <th> Update Stock </th>
                          <td> @if($data['fp'][0]->fp_updatestock == 'Y')
                                <input type="text" class="form-control" readonly="" value="IYA" name="updatestock">
                              @else
                                  <input type="text" class="form-control" readonly="" value="TIDAK" name="updatestock">
                              @endif
                          </td>
                        </tr>                      
                      </table>

                      <br>
                      <br>
                        <h4> Data Detail Barang </h4>
                         <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" > 
                           <tr>
                              <th> No </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Jumlah dikirim </th>
                              <th class="jmlhditerima"> Jumlah yang diterima </th>
                              <th> Sisa </th>
                              <th> Tambahan Qty Sampling </th>
                           </tr>
                          
                           <?php $n = 0 ?>
                           @for($x=0 ; $x < count($data['fpdt']); $x++)
                            <tr class="databarang">
                              <td> {{$x + 1}}</td>
                              <td> {{$data['fpdt'][$x]->nama_masteritem}}</td>
                              <td> {{$data['fpdt'][$x]->unitstock}}</td>
                              
                              <td> {{$data['fpdt'][$x]->fpdt_qty}}</td> <!--qty dikirim -->
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_qty}}" class=qtykirim<?php echo $n?> data-id=<?php echo $n ?> name="qtydikirim[]">
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_kodeitem}}" name="kodeitem[]" class="item kodeitem{{$x}}"> <!--kodeitem-->
                             
                         <input type="hidden" name="accpersediaan[]" value="{{$data['fpdt'][$x]->acc_persediaan}}">
                         <input type="hidden" name="acchpp[]" value="{{$data['fpdt'][$x]->acc_hpp}}">


                              <td> <input type="number" class="form-control qtyreceive qtyterima{{$x}}" name="qtyterima[]" id=qtyterima<?php echo $n?> data-kodeitem="{{$data['fpdt'][$x]->fpdt_kodeitem}}" data-id=<?php echo $n?>> </td>
                              
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_netto}}" name="jumlahharga[]">
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_harga}}" name="hpp[]">
                              <input type="hidden" value="{{$data['fpdt'][$x]->fpdt_keterangan}}" name="keteranganfpdetail[]">
                              <td> 
                              @for($c=0; $c < count($data['sisa'][$x]); $c++)
                                @if( $data['fpdt'][$x]->fpdt_id == $data['sisa'][$x][$c]->fpdt_id)
                                  
                                        <input type="text" data-id=<?php echo $n ?> class="form-control sisa" id=sisa<?php echo $n ?> value=" {{$data['fpdt'][$x]->fpdt_qty - $data['sisa'][$x][$c]->sum}}" readonly="">
                                 
                                  @endif
                              @endfor
                              </td>


                              <td>   <button class='btn btn-xs btn-info sampling' type='button' data-kodeitem="{{$data['fpdt'][$x]->fpdt_kodeitem}}"   data-id=<?php echo $n ?> style="display:block" id=sampling<?php echo $n ?>> <i class="fa fa-plus" aria-hidden="true"> </i>  Sampling </button> <div class="row"> <div class="col-md-6"> <input type='text' class="form-control qtysampling" id=qtysampling<?php echo $n?> style="display:none" data-id=<?php echo $n ?> name="qtysampling[]" > </div> <div class="col-md-3"> <button type='button' data-id=<?php echo $n ?> class='btn btn-circle btn-success' id=close<?php echo $n ?> style="display: none" name="close"> <i class='fa fa-times'> </i> </button> </div> </div></td>
                            </tr>
                            <?php $n++; ?>
                           @endfor
                          </table>

                        <div class="text-left">
                           <input type="submit"  class="simpan btn btn-success" value="Simpan" >   
                      </div>
		</div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
    </div>
		
		<br>


		<div class="row">
			   <div class="col-lg-12" >
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5> Data Penerimaan Barang
						 <!-- {{Session::get('comp_year')}} -->
						 </h5>   
					</div>

					 <div class="ibox-content">
					   <div class="row">
						  <div class="col-xs-12">
						  <div class="box">
							
							<div class="box-body">

								<div class="judul"> </div>                     
							   <div class="tampildata"> </div> </td>


							</div>
						  </div>
						  </div>
					   </div>
					 </div>
				</div>
				</div>
        </div>

                      

                    @elseif($data['flag'] == 'PO') <!-- END FP -->
                      
                  <!-- KONTEN PAKE PO -->
                    <table border="0" class="table">

                  <input type="hidden" class="flag" value="PO" name="flag">
                      <tr>
                        <th> Gudang </th>
                        <th> {{$data['header'][0]->mg_namagudang}} </th>
                      </tr>

                      <tr>
                        <th style="width:200px"> Supplier </th>
                        <td style="width:400px"> <h3> {{$data['po'][0]->nama_supplier}} </h3> </td>
                        <input type="hidden" name="idpo" value="{{$data['po'][0]->po_id}}" class="idpo">
                        <input type="hidden" name="acchutangsupplierpo" value="{{$data['po'][0]->po_acchutangdagang}}">
                        <input type="hidden" name="ppn_po" value="{{$data['po'][0]->po_ppn}}">
                        <input type="hidden" name="diskon_po" value="{{$data['po'][0]->po_diskon}}">
                        <input type="hidden" name="gudang" value="{{$data['header'][0]->bt_gudang}}">
			                  <input type="hidden" name="ref" value="{{$data['header'][0]->bt_id}}">
                        <input type="hidden" name="comp" value="{{$data['comp']}}">
                        <input type="hidden" name="comp_po" value="{{$data['header'][0]->bt_cabangpo}}">
			                  <input type="hidden" name="po_keterangan" value="{{$data['po'][0]->po_catatan}}">
                      </tr>
                      
                        <tr>
                          <th class="suratjalan" style="width:200px"> No Surat Jalan </th>
                          <td style="width:400px"> <input type="text" class="form-control suratjalan" name="suratjalan">  </td>
                         </tr>

                           <tr>
                        <th class="suratjalan" style="width:200px"> Diterima dari </th>
                        <td style="width:400px"> <input type="text" class="form-control diterimadari" name="diterimadari">  </td>
                      </tr>

                       <tr>
                        <th class="suratjalan" style="width:200px"> Keterangan </th>
                        <td style="width:400px"> <input type="text" class="form-control keterangan" name="keterangan" required="">  </td>
                      </tr>

                         <tr>
                          <th class="tgl suratjalan"> Tanggal di Terima </th>
                          <td>
                              <div class="input-group date tgl">
                                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required>
                              </div>
                        
                                  <td>
                                      <div class="checkbox checkbox-primary cek2">
                                            <input id="lengkap" type="checkbox" class="lengkap">
                                            <label for="checkbox2">
                                               Lengkap
                                            </label>
                                      </div>
                                  </td>
                         </tr>


                    </table>

                    <hr>
                      <?php $n = 0 ?>
                      @for($i = 0; $i < count($data['po']); $i++)
                      <table class="table" style="margin-top:5px; width:50%">
                      <tr >
                        <th style="width:200px"> No SPP </th>
                        <td style="width:400px"> {{$data['po'][$i]->spp_nospp}}</td>
                           <input type="hidden" value="{{$data['po'][$i]->po_id}}" name="po_id" class="po_id">
                           <input type="hidden" value="{{$data['po'][0]->idsup}}" name="idsup" class="idsup">
                      </tr>

                      <tr>
                        <th> NO PO </th>
                        <th> {{$data['po'][$i]->po_no}} </th>
                      </tr>

                      <tr>
                        <th> Update Stock </th>
                        <td> @if($data['po'][$i]->spp_lokasigudang != '') <input type="text" class="form-control" readonly="" name="updatestock" value="IYA">  @else <input type="text" class="form-control" readonly="" name="updatestock" value="TIDAK"> @endif </td>
                      </tr>

                        <tr>
                         </tr>
                         <tr>
                         </tr>
                         </table>

                         <h4> Data Detail Barang </h4>
                         <table id=addColumn class="table table-bordered table-striped tbl-penerimabarang" > 
                           <tr>
                              <th> No </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Jumlah dikirim </th>
                              <th class="jmlhditerima"> Jumlah yang diterima </th>
                              <th> Sisa </th>
                              <th> Tambahan Qty Sampling </th>
                           </tr>

                        
                         @for($j= 0; $j < count($data['podtbarang'][$i]); $j++)                       
                          <tr class="databarang" id=" {{$data['po'][$i]->spp_nospp}}">
                           <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <input type="hidden" class= qtykirim<?php echo $n ?> value="{{$data['podtbarang'][$i][$j]->podt_qtykirim}}" id="qtydikirim"
                            data-id=<?php echo $n ?> name="qtydikirim[]"> <input type="hidden" class="item{{$j}}" value="{{$data['podtbarang'][$i][$j]->kode_item}}">

                            <input type="hidden" value="{{$data['podtbarang'][$i][$j]->podt_jumlahharga}}" name="jumlahharga[]" class="jumlahharga{{$j}}">
                            <input type="hidden" value="{{$data['podtbarang'][$i][$j]->podt_keterangan}}" name="keterangandt[]" class="keterangandt{{$j}}">

                            <input type="hidden" class="item kodeitem{{$j}}" value="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" name="kodeitem[]">

                            <input type="hidden" class="akunitem" value="{{$data['podtbarang'][$i][$j]->podt_akunitem}}" name="accpersediaan[]">

                             <input type="hidden" class="item kodeitem{{$j}}" value="{{$data['podtbarang'][$i][$j]->acc_hpp}}" name="acchpp[]">
                            
                            <input type="hidden" class="item podtid" value="{{$data['podtbarang'][$i][$j]->podt_id}}" name="podtid[]">
                            <input type='hidden' value="{{$data['po'][$i]->spp_id}}" name="idspp[]">

                          <td> {{$j + 1}} </td>
                          <td> {{$data['podtbarang'][$i][$j]->nama_masteritem}} </td>
                          <td> {{$data['podtbarang'][$i][$j]->unitstock}} </td>
                           <td data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-id={{$j}}> {{$data['podtbarang'][$i][$j]->podt_qtykirim}} <input type="hidden" class="status{{$j}}" name="status[]"> <input type="hidden" value="{{$data['podtbarang'][$i][$j]->podt_id}}" name="idpodt[]"> </td>

                        
                           <td class="isijmlhditerima">  <input type="number" class="form-control qtyreceive qtyterima{{$j}}" id=qtyterima<?php echo $n ?> name="qtyterima[]" data-id=<?php echo $n ?> data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-spp="{{$data['po'][$i]->spp_id}}"> <div class=jmlhkirim<?php echo $n ?>> </div> <div class=idspp<?php echo $n ?>> <div id=idbarang<?php echo $n?>>  </div> </td>   
                          
                          <td> 
                            
                            <input type="text" data-id=<?php echo $n ?> class="form-control sisa" id=sisa<?php echo $n ?> value="{{$data['podtbarang'][$i][$j]->podt_sisaterima}}" readonly="">

                          </td>
                          
                          <td> 
                            <button class='btn btn-xs btn-info sampling' type='button' data-kodeitem="{{$data['podtbarang'][$i][$j]->podt_kodeitem}}" data-idspp="{{$data['po'][$i]->spp_id}}"  data-id=<?php echo $n ?> style="display:block" id=sampling<?php echo $n ?>> <i class="fa fa-plus" aria-hidden="true"> </i>  Sampling </button> <div class="row"> <div class="col-md-6"> <input type='text'  class="form-control qtysampling" id=qtysampling<?php echo $n?> style="display:none" name="qtysampling[]" data-id=<?php echo $n ?>> </div> <div class="col-md-3"> <button type='button' data-id=<?php echo $n ?> class='btn btn-circle btn-success' id=close<?php echo $n ?> style="display: none" name="close"> <i class='fa fa-times'> </i> </button> </div> </div> 
                          </td>                      
                        </tr>
                        <?php $n++ ?>   
                      @endfor
                      </table>
                      
                      </tr>
                      @endfor

                      <div class="text-left">
                        <input type="submit"  class="simpan btn btn-success" value="Simpan">  
						</form>
                      </div>
                </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
    </div>
			<br>


		<div class="row">
			   <div class="col-lg-12" >
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5> Data Penerimaan Barang
						 <!-- {{Session::get('comp_year')}} -->
						 </h5>   
					</div>

					 <div class="ibox-content">
					   <div class="row">
						  <div class="col-xs-12">
						  <div class="box">
							
							<div class="box-body">

								<div class="judul"> </div>                     
						    <div class="tampildata"> </div> </td>

                

							</div>
						  </div>
						  </div>
					   </div>
					 </div>
				</div>
				</div>
        </div>
          @else <!-- PENGELUARAN BARANG -->
           <input type="hidden" class="flag" value="PBG" name="flag">
                    <table border="0" class="table">
                    <tr>
                      <th> Gudang </th>
                      <td> {{$data['header'][0]->mg_namagudang}} </td>
                    </tr>
                     <tr>
                        <input type="hidden" name="idpbg" value="{{$data['pbg'][0]->pb_id}}" class="idpbg">
                        <input type="hidden" name="idsup" value="{{$data['pbg'][0]->pb_comp}}">
            
                    
                        <input type="hidden" name="gudang" value="{{$data['header'][0]->bt_gudang}}">
                       <input type="hidden" name="ref" value="{{$data['header'][0]->bt_id}}">
                        <input type="hidden" name="comp" value="{{$data['comp']}}">
                        <input type="hidden" name="comp_po" value="{{$data['header'][0]->bt_cabangpo}}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">


                        

                        <th style="width:200px"> Pengirim Barang </th>
                        <td style="width:400px"> <h3> {{$data['pbg'][0]->nama}}</h3> </td>
                      
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> No Surat Jalan </th>
                        <td style="width:400px"> <input type="text" class="form-control suratjalan" name="suratjalan">  </td>
                      </tr>

                      <tr>
                        <th class="suratjalan" style="width:200px"> Diterima dari </th>
                        <td style="width:400px"> <input type="text" class="form-control diterimadari" name="diterimadari">  </td>
                      </tr>

                       <tr>
                        <th class="suratjalan" style="width:200px"> Keterangan </th>
                        <td style="width:400px"> <input type="text" class="form-control keterangan" name="keterangan" required="">  </td>
                      </tr>

                      <tr>
                        <th class="tgl suratjalan"> Tanggal di Terima </th>
                        <td>
                          <div class="input-group date tgl">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tgl_dibutuhkan" required>
                          </div>
                        
                          <td>
                          <div class="checkbox checkbox-primary cek2">
                            <input id="lengkap" type="checkbox" class="lengkap">
                            <label for="checkbox2">
                              Lengkap
                            </label>
                           </div>
                         </td>
                      </tr>
                   
                        <tr >
                          <th style="width:200px"> No PBG </th>
                          <td style="width:400px"> {{$data['pbg'][0]->pb_nota}} </td>
                           
                        </tr>


                        <tr>
                          <th> Update Stock </th>
                          <td> 
                                <input type="text" class="form-control" readonly="" value="IYA" name="updatestock">
                            
                          </td>
                        </tr>                      
                      </table>

                      <br>
                      <br>
                        <h4> Data Detail Barang </h4>
                         <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" > 
                           <tr>
                              <th> No </th>
                              <th> Nama Barang </th>
                              <th> Satuan </th>
                              <th> Jumlah dikirim </th>
                              <th class="jmlhditerima"> Jumlah yang diterima </th>
                              <th> Sisa </th>
                              <th> Tambahan Qty Sampling </th>
                           </tr>
                          
                           <?php $n = 0 ?>
                           @for($x=0 ; $x < count($data['pbgdt']); $x++)
                            <tr class="databarang">
                              <td> {{$x + 1}}</td>
                              <td> {{$data['pbgdt'][$x]->nama_masteritem}}</td>
                              <td> {{$data['pbgdt'][$x]->unitstock}}</td>
                              
                              <td>  {{ (int) $data['pbgdt'][$x]->pbd_disetujui}} </td> <!--qty dikirim -->
                              <input type="hidden" value="{{(int)$data['pbgdt'][$x]->pbd_disetujui}}" class=qtykirim<?php echo $n?> data-id=<?php echo $n ?> name="qtydikirim[]">
                              <input type="hidden" value="{{$data['pbgdt'][$x]->pbd_nama_barang}}" name="kodeitem[]" class="item kodeitem{{$x}}"> <!--kodeitem-->
                             
                         <input type="hidden" name="accpersediaan[]" value="{{$data['pbgdt'][$x]->acc_persediaan}}">
                         <input type="hidden" name="acchpp[]" value="{{$data['pbgdt'][$x]->acc_hpp}}">


                              <td> <input type="number" class="form-control qtyreceive qtyterima{{$x}}" name="qtyterima[]" id=qtyterima<?php echo $n?> data-kodeitem="{{$data['pbgdt'][$x]->pbd_nama_barang}}" data-id=<?php echo $n?>> </td>
                              
                              <input type="hidden" value="{{$data['pbgdt'][$x]->pb_total}}" name="jumlahharga[]">
                             
                              <td> 
                              @for($c=0; $c < count($data['sisa'][$x]); $c++)
                                @if( $data['pbgdt'][$x]->pbd_id == $data['sisa'][$x][$c]->pbd_id)
                                  
                                        <input type="text" data-id=<?php echo $n ?> class="form-control sisa" id=sisa<?php echo $n ?> value=" {{$data['pbgdt'][$x]->pbd_disetujui - $data['sisa'][$x][$c]->sum}}" readonly="">
                                 
                                  @endif
                              @endfor
                              </td>


                              <td>   <button class='btn btn-xs btn-info sampling' type='button' data-kodeitem="{{$data['pbgdt'][$x]->pbd_nama_barang}}"   data-id=<?php echo $n ?> style="display:block" id=sampling<?php echo $n ?>> <i class="fa fa-plus" aria-hidden="true"> </i>  Sampling </button> <div class="row"> <div class="col-md-6"> <input type='text' class="form-control qtysampling" id=qtysampling<?php echo $n?> style="display:none" data-id=<?php echo $n ?> name="qtysampling[]" > </div> <div class="col-md-3"> <button type='button' data-id=<?php echo $n ?> class='btn btn-circle btn-success' id=close<?php echo $n ?> style="display: none" name="close"> <i class='fa fa-times'> </i> </button> </div> </div></td>
                            </tr>
                            <?php $n++; ?>
                           @endfor
                          </table>

                        <div class="text-left">
                           <input type="submit"  class="simpan btn btn-success" value="Simpan" >   
                      </div>
    </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
    </div>
    
    <br>


    <div class="row">
         <div class="col-lg-12" >
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5> Data Penerimaan Barang
             <!-- {{Session::get('comp_year')}} -->
             </h5>   
          </div>

           <div class="ibox-content">
             <div class="row">
              <div class="col-xs-12">
              <div class="box">
              
              <div class="box-body">

                <div class="judul"> </div>                     
                 <div class="tampildata"> </div> </td>
               

              </div>
              </div>
              </div>
             </div>
           </div>
        </div>
        </div>
        </div>          
              
    @endif
             

<div class="row" style="padding-bottom: 50px;"></div>

<div class="loading text-center" style="display: none;">
        <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
    </div>
 <div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content no-padding">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No PO:  <u>{{$data['po'][0]->po_no or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">                            
                                <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> ID Akun </th>
                                            <th> Nama Akun</th>
                                            <th>Debit</th>
                                            <th>Kredit</th>                                            
                                            <th> Uraian / Detail </th>                                            
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
    function lihatjurnal(id,note){
       $('.loading').css('display', 'block');
         datasplit = id.split(",");
         ref = datasplit[0];
         note = datasplit[1];    
        
        $.ajax({
          type : "get",
          url : baseUrl + '/penerimaanbarang/lihatjurnal',
          data : {ref,note},
          dataType : "json",
          success : function(response){
              $('#jurnal').modal('show'); 
             $('.loading').css('display', 'none');
            
                $('.listjurnal').empty();
                $totalDebit=0;
                $totalKredit=0;
                        console.log(response);
                      
                        for(key = 0; key < response.countjurnal; key++) {
                           
                          var rowtampil2 = "<tr class='listjurnal'> <td>"+response.jurnal[key].id_akun+" </td> <td>"+response.jurnal[key].nama_akun+"</td>";

                          if(response.jurnal[key].dk == 'D'){
                            $totalDebit = parseFloat($totalDebit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                            rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td>";
                          }
                          else {
                            $totalKredit = parseFloat($totalKredit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
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
                                  "<th>&nbsp;</th>" +
                          "<tr>" +
                      "</tfoot>";
                                     
                   
                      $('#table_jurnal').append(rowtampil1);
          }
        })

    }
   
    $('#formId').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

    $('#formId input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formId input').change(function(){
      this.setCustomValidity("");
    })

    $('#formId').submit(function(event){
        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Penerimaan Barang!",
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
          url : post_url2,
          dataType : 'json',
          success : function (response){
             if(response.status == 'sukses') {
                 swal({
                title: "Berhasil!",
                        type: 'success',
                        text: "Data berhasil disimpan",
                        timer: 900,
                       showConfirmButton: false
                        },function(){
                        location.reload();
                });
             }
             else  if(response.status == 'gagal') {
                swal({
                title: "errpr!",
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
     $('#lengkap').attr('disabled' , false);

    var flag = $('.flag').val();
    if(flag == 'FP'){
     
         var tempsisa = 0;
        $('.sisa').each(function(){
          var sisa = $(this).val();
          var id = $(this).data('id');
          if(sisa == 0 ) {
            $('#qtyterima'+id).attr('readonly' , true);
             tempsisa = tempsisa + 1;
          }
        })


      
        var pnjgsisa = $('.sisa').length;
        if(tempsisa == pnjgsisa) {
          $('.simpan').attr('disabled' , true);
        }      
    }
    else {
    
         var tempsisa = 0;
        $('.sisa').each(function(){
          var sisa = $(this).val();
          var id = $(this).data('id');
          if(sisa == 0 ) {
            $('#qtyterima'+id).attr('readonly' , true);
             tempsisa = tempsisa + 1;
          }
        })

        var pnjgsisa = $('.sisa').length;
        if(tempsisa == pnjgsisa) {
          $('.simpan').attr('disabled' , true);
        }

    }
 
    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
      

     $('.sampling').click(function(){
      kodeitem = $(this).data('kodeitem');
      idspp = $(this).data('idspp');
      id = $(this).data('id');
      j = $(this).data('j');

     
      $('#qtyterima' + id).attr('readonly', true);
      $('#qtysampling' + id).css('display','block');
      $('#close' + id).css('display', 'block');
      $(this).css('display' , 'none');
      $('#qtyterima' + id).val('');
   })

   $('button[name="close"]').click(function(){
    id = $(this).data('id');
     $('#qtyterima' + id).attr('readonly', false);
      $('#qtysampling' + id).css('display','none');
      $('#close' + id).css('display', 'none');
     $('.sampling').css('display' , 'block');
   })
   
    $('.qtysampling').each(function(){
      $(this).change(function(){
        id = $(this).data('id');
        val = parseInt($(this).val());
        qtykirim = $('.qtykirim' + id).val();
        if(val < qtykirim){
          toastr.info('Qty Sampling harus lebih besar daripada qty kirim :)');
          $(this).val('');
        }
      })
    })

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    kodeitem = [];

    for(var i = 0; i < $('.item').length; i++) {
        item = $('.kodeitem' + i).val();
        kodeitem.push(item);
    }
      

		if(flag == 'PO') { // FLAG PO
			 po_id = $('.po_id').val();
      var url = baseUrl + '/penerimaanbarang/gettampil';
      $.ajax({    
          type :"get",
          data : {kodeitem, po_id,flag},
          url : url,
          dataType:'json',
          success : function(response){
           
            if(response.judul.length != 0) {
               $('#lengkap').attr('disabled' , true);
              console.log('ok');
            var qtykirim = [];
            var qtyditerima = [];
            $noajax = 1;
            $notable = 1;
           /* var judulpenerimaan = "<h4> Data Penerimaan Barang </h4>";
            $('.judul').html(judulpenerimaan);*/

            for(var j = 0 ; j < response.judul.length; j++) {
            
            $no = 1;
            var rowtampil = "<br> <br> <table class='table'>" +
                              "<tr> <td style='width:270px'> No LPB </td> <td> : </td> <td>" + response.judul[j].pb_lpb + "</td> </tr>" + //no lpb
                            "<tr> <td> No Surat Jalan </td> <td> : </td> <td>"+ response.judul[j].pb_suratjalan +"</td> </tr>" + // surat jalan
                            "<tr> <td> Tgl di Terima </td> <td style='width:20px'> :</td> <td>"+ response.judul[j].pb_date + "</td>  </tr> " + // tgl
                            "<tr> <td> Status Penerimaan Barang </td> <td> </td> <td> "+response.judul[j].pb_status+" </div> </td> </tr>" + //status
                            "<tr> <td> Diterima oleh </td> <td> : </td> <td>"+response.judul[j].pb_terimadari+"</td> </tr>" + //terimadari
                            "<tr> <td> <a class='btn btn-info btn-xs' href={{url('penerimaanbarang/penerimaanbarang/cetak')}}"+'/'+response.judul[j].pb_po+","+flag+","+response.judul[j].pb_id+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a> &nbsp; <a class='btn btn-xs btn-danger hapusdata' data-id="+response.judul[j].pb_id+" data-idtransaksi="+response.judul[j].pb_po+"> <i class='fa fa-trash'> </i>  Hapus </a> &nbsp;";
                              if(response.jurnal.length > 0){
                        rowtampil += "<a class='btn btn-xs btn-primary' onclick='lihatjurnal(\""+response.judul[j].pb_lpb+","+response.judul[j].pb_keterangan+"\")'> <i class='fa fa-book'> </i> Lihat Jurnal </a>";

                              }
                            rowtampil += "</td> </tr>" +
                  "<tr> <td> <div class='row'> <div class='col-sm-5'> <button class='btn btn-xs btn-default editdata' type='button' data-id="+$notable+" data-ajax="+$noajax+" style='color:red'> <i class='fa fa-pencil'> </i> Edit Data</button> </div> &nbsp; <div class='col-sm-5'> <div class='simpan2"+$notable+"'> </div> </div> </div> </td> </tr>" +
                            "</table>";
               

                 rowtampil += "<table class='table table-striped table-bordered' style='width:75%'> <tr> <th> No </th> <th> Nama Barang </th> <th> Satuan </th> <th> Harga Satuan </th> <th> Jumlah Harga </th> <th> Jumlah Dikirim </th> <th> Jumlah yang diterima </th> <th> No SPP </th> </tr>"; // judul

                 for(var x =0; x < response.barang[j].length; x++) {
                  
                        rowtampil += "<tr> <td style='width:20px'>"+ $no +"</td>" + 
                                "<td> "+ response.barang[j][x].nama_masteritem +"</td>" +// no
                              "<td>" + response.barang[j][x].unitstock + "</td>" + //satuan
                              "<td style='text-right'>Rp " + addCommas(response.barang[j][x].podt_jumlahharga) +" <input type='hidden' class='harga"+$noajax+"' value='"+addCommas(response.barang[j][x].podt_jumlahharga)+"' name='jumlahharga[]'>  </td>";
                           
                                 
                               rowtampil +=    "<td style='text-right'> <input class='input-sm form-control biaya2"+$notable+" biaya"+$noajax+"' value='"+response.barang[j][x].pbdt_totalharga+"' readonly> </td>" +
                                 
                                "<td>"+ response.barang[j][x].podt_qtykirim +"</td>" + // qty po
                                "<td> <input type='number' class='input-sm form-control qtyreceive2  qtyreceive3"+$notable+" qtyterima2"+$noajax+"' name='qtyterima[]' id=qtyterima2"+$noajax+" data-kodeitem="+response.barang[j][x].kode_item+" data-spp="+response.barang[j][x].spp_id+" data-id="+$noajax+" data-idpbdt="+response.barang[j][x].pbdt_id+" value="+response.barang[j][x].pbdt_qty+" disabled> </td>"+ // qtypb

                                 "<input type='hidden' class='status2"+$notable+" status4"+$noajax+"' value='"+response.barang[j][x].pbdt_status+"'> " +
                                "<input type='hidden' value='"+response.barang[j][x].podt_qtykirim+"' class='qtykirim2"+$noajax+"' data-id="+$noajax+" name='qtydikirim2[]'>" +
                                "<input type='hidden' value='"+response.barang[j][x].pbdt_qty+"' class='qtyterima3"+$noajax+"' data-id="+$noajax+"> "+
                                "<input type='hidden' class='kodeitem4"+$noajax+" kodeitem2"+$notable+"' value="+response.barang[j][x].kode_item+">" +
                                "<input type='hidden' class='idpbdt"+$noajax+" idpbdt2"+$notable+"' value="+response.barang[j][x].pbdt_id+">" +
                                "<input type='hidden' class='idpb2"+$notable+"' value="+response.barang[j][x].pbdt_idpb+">" +
                                "<input type='hidden' class='akunitem"+$notable+"' value="+response.barang[j][x].podt_akunitem+">" +

                                "<td>"+ response.barang[j][x].spp_nospp +"</td> </tr>";
                          qtykirim.push(response.barang[j][x].podt_qtykirim);
                         qtyditerima.push(response.barang[j][x].pbdt_qty);
                       $no++;
                       $noajax++;
                      var sisa = parseInt(response.barang[j][x].podt_qtykirim) - parseInt(response.barang[j][x].pbdt_qty);
                  }
                      
                    rowtampil += "</table>";

                    rowtampil += "<br> <br>";
                    var lengthjudul = 0;
                    $('.tampildata').append(rowtampil);  
                    $notable++;		

                  }

                  for(k = 0 ; k < response.judul.length; k++){
                    
                  }



                  $('.hapusdata').click(function(){
                       id = $(this).data('id');
                       idtransaksi = $(this).data('idtransaksi');
                       flag = 'PO';
                       swal({
                        title: "Apakah anda yakin?",
                        text: "Hapus Data!",
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                        closeOnConfirm: true
                      },
                      function(){
                        $.ajax({
                         
                          type : "get",
                          url : baseUrl + '/penerimaanbarang/hapusdatapenerimaan',
                          data : {id,idtransaksi,flag},
                          dataType : 'json',
                          success : function(response){
                                
                                  if(response == 'sukses'){
                                  swal({
                                  title: "Berhasil!",
                                          type: 'success',
                                          text: "Data Berhasil Dihapus",
                                          timer: 2000,
                                          showConfirmButton: true
                                          },function(){
                                           //  location.reload();
                                  });
                                }else{
                                 swal({
                                title: "Data Tidak Bisa Dihapus",
                                        type: 'error',
                                        timer: 1000,
                                        showConfirmButton: false
                            });
                                }
                          },
                            error:function(data){

                              swal({
                              title: "Terjadi Kesalahan",
                                      type: 'error',
                                      timer: 2000,
                                      showConfirmButton: false
                          });
                         }
                        })
                      })
                      
                  })

                 /* $('tr#'+ response.barang[j][x].spp_nospp).*/
                  $('.editdata').click(function(){
                id = $(this).data('id');
                noajax = $(this).data('ajax');
                $('.qtyreceive3' + id).attr('disabled' , false);
                $('.suratjalan' + id).attr('readonly' , false);
                simpan4 = "<button class='btn btn-xs btn-success simpan4' data-id='"+id+"' type='button'> <i class='fa fa-check'> </i> Simpan </button>";
                $('.simpan2' + id).html(simpan4);


                $('.simpan4').click(function(){
                  id = $(this).data('id');
                  suratjalan = $('.suratjalan' + id).val();
                  arrqty = [];
                  $('.qtyreceive3' + id).each(function(){
                    val = $(this).val();
                    arrqty.push(val);
                  })                  
                  idpb = $('.idpb2' + id).val();
                //  idpb = response.pbdt[0].pbdt_idpb;
                  arridpbdt = [];
                  $('.idpbdt2' + id).each(function(){
                    val = $(this).val();
                    arridpbdt.push(val);
                  })

                  arrstatus = [];
                  $('.status2' + id).each(function(){
                    val = $(this).val();
                    arrstatus.push(val);
                  })

                  arrakunitem = [];
                  $('.akunitem' + id).each(function(){
                    val = $(this).val();
                    arrakunitem.push(val);
                  })

                  arrkodeitem = [];
                  $('.kodeitem2' + id).each(function(){
                    val = $(this).val();
                    arrkodeitem.push(val);
                  })

                  arrharga = [];
                  $('.biaya2' + id).each(function(){
                    val = $(this).val();
                    arrharga.push(val);
                  })
                  idpbdt = $('.idpbdt2' + id).val();
                  status = $('.status2' + id).val();
                  kodeitem = $('.kodeitem2' + id).val();
                  flag = $('.flag').val();
                  if(flag == 'FP'){
                    iddetail = $('.idfp').val();
                  }
                  else if(flag == 'PO'){
                    iddetail = $('.idpo').val();
                  }

                  $.ajax({
                      type : "post",
                      url : baseUrl + '/penerimaanbarang/updatepenerimaanbarang',
                      data : {arrqty, arrstatus, arrkodeitem, idpb, suratjalan, arridpbdt, arrharga,iddetail,flag, arrakunitem},
                      dataType : 'json',
                      success : function(response){
                         alertSuccess(); 
                       //  location.reload();
                         $('.qtyreceive2').attr('disabled', 'true');
                         $('.suratjalan' + id).attr('readonly' , true);
                      }

                  })

                })
              }) // end edit


                    $('.qtyreceive2').keyup(function(){
                      val = $(this).val();
                      id = $(this).data('id');
                      kodeitem = $(this).data('kodeitem');
                      idpbdt = $(this).data('idpbdt');
                      rowidpbdt = "<input type='text' value="+idpbdt+" >";
                      
                      $('.idpbdt').val(idpbdt);
                      console.log(kodeitem);
                      sppid = $(this).data('spp');
                 
                      //appendkodeitem
                      qtykirim = $('.qtykirim2' + id).val();
                      qtyterima = $('.qtyterima3' + id).val();
                      $('.kodeitem4' + id).val(kodeitem);
                      
                      
                      harga = $('.harga' + id).val();
                      harga2 = harga.replace(/,/g, '');

                      biaya = parseFloat(harga2 * val).toFixed(2);
                      $('.biaya' + id).val(addCommas(biaya)); 


                      po_id = $('.po_id').val();
                      idspp = sppid;
                      flag = $('.flag').val();
                      urlterima = baseUrl + '/penerimaanbarang/changeqtyterima';
                       $.ajax({    
                          type :"get",
                          data : {kodeitem, po_id, idspp, flag, idfp},
                          url : urlterima,
                          dataType:'json',
                          success : function(response){
                         // alert('ley');
                            lengthresp = response.pbdt.length;
                            qty = 0;
                            for(var i = 0; i < lengthresp; i++) {
                              qty = qty + response.pbdt[i].pbdt_qty
                            }

                            console.log(qtyterima + 'qtyterima');

                            hasilqty = parseInt((parseInt(val) + parseInt(qty)) - parseInt(qtyterima));
                            console.log('hasilqty');
                            console.log(hasilqty + 'hasilqty');
                            console.log(qtykirim + 'qtykirim');
                            
                            if(parseInt(hasilqty) > parseInt(qtykirim)) {
                              toastr.info('tidak bisa mengisi angka di atas jumlah angka yang diterima dari yang dikirim :) ');
                              kosong = '';
                             $('.status4' + id).val('');
                             $('.qtyterima2' + id).val('');
                      //       alert('hei');
                            }


                            qtykirim = $('.qtykirim2' + id).val();
                       //     hasilterima = parseInt(qty) + parseInt(val) - ;
                            console.log(qty + 'qty');
                            console.log(val + 'val');
                            if(qtykirim == hasilqty){

                               status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='LENGKAP'> ";
                               $('.status4' + id).val('LENGKAP');
                            }
                            else {
                             /*  status = "TIDAK LENGKAP";*/
                                status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='TIDAK LENGKAP'> ";
                               $('.status4' + id).val('TIDAK LENGKAP');
                            }

                          }
                      })
                }) 

          }
          else {
            console.log('else');
          }
        },
		error : function(){
			location.reload();
		}
      })
		} /*<!--end flag po -->*/
		
		else if(flag == 'FP') { /*<!-- FLAG FP -->*/
     var url = baseUrl + '/penerimaanbarang/gettampil';
			var idfp = $('.idfp').val();
      $.ajax({    
			  type :"get",
			  data : {kodeitem, idfp,flag},
			  url : url,
			  dataType:'json',
			  success : function(response){
			
        $noajax = 1;
				if(response.judul.length != 0) {
					$('#lengkap').attr('disabled' , true);
					console.log('ok');
					var qtykirim = [];
					var qtyditerima = [];
					
					/*var judulpenerimaan = "<h4> Data Penerimaan Barang </h4>";
					$('.judul').html(judulpenerimaan);*/
          $notable = 1;
					for(var j = 0 ; j < response.judul.length; j++) {
					console.log(j);
					  $no = 1;
         	var rowtampil = "<br> <br><table class='table'> <tr> <td style='width:200px'> No LPB </td> <td> : </td> <td>" + response.judul[j].pb_lpb + "</td> </tr>" + //no lpb
									"<tr> <td> No Surat Jalan </td> <td> : </td> <td> <input type='text' class='input-sm form-control suratjalan"+$notable+"' value="+response.judul[j].pb_suratjalan+" readonly></td> </tr>" +
									"<tr> <td> Tgl di Terima </td> <td style='width:20px'> :</td> <td>"+ response.judul[j].pb_date + "</td>  </tr> " +
									"<tr> <td> Status Penerimaan Barang </td> <td> </td> <td> "+response.judul[j].pb_status+" </div> </td> </tr>" +
                  "<tr> <td> Diterima oleh </td> <td> : </td> <td>"+response.judul[j].pb_terimadari+"</td> </tr>" +
                  "<tr> <td> <a class='btn btn-info btn-xs' href={{url('penerimaanbarang/penerimaanbarang/cetak')}}"+'/'+response.judul[j].pb_fp+","+flag+","+response.judul[j].pb_id+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a> &nbsp; <a class='btn btn-xs btn-danger hapusdata' data-id="+response.judul[j].pb_id+" data-idtransaksi="+response.judul[j].pb_fp+"> <i class='fa fa-trash'> </i>  Hapus </a>  </td> <td> <a class='btn btn-xs btn-primary jurnal' onclick='lihatjurnal(\""+response.judul[j].pb_lpb+","+response.judul[j].pb_keterangan+"\")'> Lihat Jurnal </a> </td> </tr>" +
                  "<tr> <td> <div class='row'> <div class='col-sm-5'> <button class='btn btn-xs btn-default editdata' type='button' data-id="+$notable+" data-ajax="+$noajax+" style='color:red'> <i class='fa fa-pencil'> </i> Edit Data</button> </div> &nbsp; <div class='col-sm-5'> <div class='simpan2"+$notable+"'> </div> </div> </div> </td> </tr>" +
									"</table>";
						rowtampil += "<table class='table table-striped table-bordered' style='width:75%'> <tr> <th> No </th> <th> Nama Barang </th> <th> Satuan </th> <th> Harga Satuan </th> <th> Jumlah Harga </th> <th> Jumlah Dikirim </th> <th> Jumlah yang diterima </th> <th> No Transaksi </th> </tr>"; // judul

						 for(var x =0; x < response.barang[j].length; x++) {
						//  console.log(x);
								rowtampil += "<tr> <td style='width:20px'>"+ $no +"</td>" + 
										"<td> "+ response.barang[j][x].nama_masteritem +"</td>" +// no
									  "<td>" + response.barang[j][x].unitstock + "</td>" +
									  "<td style='text-right'>" + addCommas(response.barang[j][x].fpdt_harga)  + "</td> <input type='hidden' class='harga"+$noajax+"' value='"+response.barang[j][x].fpdt_harga+"'> <input type='hidden' class='akunitem' value='"+response.barang[j][x].fpdt_accpersediaan+"'>";		 
									   rowtampil +=    "<td style='text-right'> <input type='text' class='input-sm form-control biaya2"+$notable+" biaya"+$noajax+"' value='"+addCommas(response.barang[j][x].pbdt_totalharga)+"' readonly></td>" +										 
										"<td>"+ response.barang[j][x].fpdt_qty +"</td>" +
										"<td> <input type='number' class='input-sm form-control qtyreceive2  qtyreceive3"+$notable+" qtyterima2"+$noajax+"' name='qtyterima[]' id=qtyterima2"+$noajax+" data-kodeitem="+response.barang[j][x].kode_item+" data-id="+$noajax+" data-idpbdt="+response.barang[j][x].pbdt_id+" value="+response.barang[j][x].pbdt_qty+" disabled></td>" +
                    "<input type='hidden' class='status2"+$notable+" status4"+$noajax+"' value='"+response.barang[j][x].pbdt_status+"'> " +
                    "<input type='hidden' value='"+response.barang[j][x].fpdt_qty+"' class='qtykirim2"+$noajax+"' data-id="+$noajax+" name='qtydikirim2[]'>" +
                    "<input type='hidden' value='"+response.barang[j][x].pbdt_qty+"' class='qtyterima3"+$noajax+"' data-id="+$noajax+"> "+
                    "<input type='hidden' class='kodeitem4"+$noajax+" kodeitem2"+$notable+"' value="+response.barang[j][x].kode_item+">" +
                    "<input type='hidden' class='idpbdt"+$noajax+" idpbdt2"+$notable+"' value="+response.barang[j][x].pbdt_id+">" +
                    "<input type='hidden' class='idpb2"+$notable+"' value="+response.barang[j][x].pbdt_idpb+">" +
										"<td>"+ response.barang[j][x].fp_nofaktur +"</td> </tr>";
    								qtykirim.push(response.barang[j][x].podt_qtykirim);
    								qtyditerima.push(response.barang[j][x].pbdt_qty);
    							  $no++;
                    $noajax++;
    							  var sisa = parseInt(response.barang[j][x].podt_qtykirim) - parseInt(response.barang[j][x].pbdt_qty);
						  }
							 
						   var lengthjudul = 0;
						   $('.tampildata').append(rowtampil); 
               $notable++;                                
						}

                $('.hapusdata').click(function(){
                       id = $(this).data('id');
                       idtransaksi = $(this).data('idtransaksi');
                       flag = 'FP';
                       swal({
                        title: "Apakah anda yakin?",
                        text: "Hapus Data!",
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                        closeOnConfirm: true
                      },
                      function(){
                        $.ajax({
                         
                          type : "get",
                          url : baseUrl + '/penerimaanbarang/hapusdatapenerimaan',
                          data : {id,idtransaksi,flag},
                          dataType : 'json',
                          success : function(response){
                                
                                  if(response == 'sukses'){
                                  swal({
                                  title: "Berhasil!",
                                          type: 'success',
                                          text: "Data Berhasil Dihapus",
                                          timer: 2000,
                                          showConfirmButton: true
                                          },function(){
                                             location.reload();
                                  });
                                }else{
                                 swal({
                                title: "Data Tidak Bisa Dihapus",
                                        type: 'error',
                                        timer: 1000,
                                        showConfirmButton: false
                            });
                                }
                          },
                            error:function(data){

                              swal({
                              title: "Terjadi Kesalahan",
                                      type: 'error',
                                      timer: 2000,
                                      showConfirmButton: false
                          });
                         }
                        })
                      })
                      
                  })

              $('.editdata').click(function(){
                id = $(this).data('id');
                noajax = $(this).data('ajax');
                $('.qtyreceive3' + id).attr('disabled' , false);
                $('.suratjalan' + id).attr('readonly' , false);
                simpan4 = "<button class='btn btn-xs btn-success simpan4' data-id='"+id+"' type='button'> <i class='fa fa-check'> </i> Simpan </button>";
                $('.simpan2' + id).html(simpan4);


                $('.simpan4').click(function(){
                  id = $(this).data('id');
                  suratjalan = $('.suratjalan' + id).val();
                  arrqty = [];
                  $('.qtyreceive3' + id).each(function(){
                    val = $(this).val();
                    arrqty.push(val);
                  })                  
                  idpb = $('.idpb2' + id).val();
                //  idpb = response.pbdt[0].pbdt_idpb;
                  arridpbdt = [];
                  $('.idpbdt2' + id).each(function(){
                    val = $(this).val();
                    arridpbdt.push(val);
                  })

                   arrakunitem = [];
                  $('.akunitem').each(function(){
                    val = $(this).val();
                    arrakunitem.push(val);
                  })

                  arrstatus = [];
                  $('.status2' + id).each(function(){
                    val = $(this).val();
                    arrstatus.push(val);
                  })

                  arrkodeitem = [];
                  $('.kodeitem2' + id).each(function(){
                    val = $(this).val();
                    arrkodeitem.push(val);
                  })

                  arrharga = [];
                  $('.biaya2' + id).each(function(){
                    val = $(this).val();
                    arrharga.push(val);
                  })
                  idpbdt = $('.idpbdt2' + id).val();
                  status = $('.status2' + id).val();
                  kodeitem = $('.kodeitem2' + id).val();
                  flag = $('.flag').val();
                  if(flag == 'FP'){
                    iddetail = $('.idfp').val();
                  }
                  else if(flag == 'PO'){
                    iddetail = $('.idpo').val();
                  }

                  $.ajax({
                      type : "post",
                      url : baseUrl + '/penerimaanbarang/updatepenerimaanbarang',
                      data : {arrqty, arrstatus, arrkodeitem, idpb, suratjalan, arridpbdt, arrharga,iddetail,flag,arrakunitem},
                      dataType : 'json',
                      success : function(response){
                         alertSuccess(); 
                          location.reload();
                         $('.qtyreceive2').attr('disabled', 'true');
                         $('.suratjalan' + id).attr('readonly' , true);
                      }

                  })

                })



              })

              $('.qtyreceive2').keyup(function(){
                      val = $(this).val();
                      id = $(this).data('id');
                      kodeitem = $(this).data('kodeitem');
                      idpbdt = $(this).data('idpbdt');
                      rowidpbdt = "<input type='text' value="+idpbdt+" >";
                     
                      $('.idpbdt').val(idpbdt);
                      console.log(kodeitem);
                      sppid = $(this).data('spp');
                 
                      //appendkodeitem
                      qtykirim = $('.qtykirim2' + id).val();
                      qtyterima = $('.qtyterima3' + id).val();
                      $(this).val(qtykirim);
                      toastr.info("qty barang harus lengkap :)");
                      $('.kodeitem4' + id).val(kodeitem);
                      val = qtykirim;
                     
                      harga = $('.harga' + id).val();
                      harga2 = harga.replace(/,/g, '');

                      biaya = parseFloat(harga2 * val).toFixed(2);
                      $('.biaya' + id).val(addCommas(biaya)); 



                      po_id = $('.po_id').val();
                      idspp = sppid;
                      flag = $('.flag').val();
                      urlterima = baseUrl + '/penerimaanbarang/changeqtyterima';
                       $.ajax({    
                          type :"get",
                          data : {kodeitem, po_id, idspp, flag, idfp},
                          url : urlterima,
                          dataType:'json',
                          success : function(response){
                          
                            lengthresp = response.pbdt.length;
                            qty = 0;
                            for(var i = 0; i < lengthresp; i++) {
                              qty = qty + response.pbdt[i].pbdt_qty
                            }


                            hasilqty = parseInt((parseInt(val) + parseInt(qty)) - parseInt(qtyterima));
                          
                            
                            if(hasilqty > qtykirim) {
                              toastr.info('tidak bisa mengisi angka di bawah jumlah angka yang diterima dari yang dikirim :) ');
                              kosong = '';
                             $('.status4' + id).val('');
                             $('.qtyterima2' + id).val('');
                            }


                            qtykirim = $('.qtykirim2' + id).val();
                       //     hasilterima = parseInt(qty) + parseInt(val) - ;
                            console.log(qty + 'qty');
                            console.log(val + 'val');
                            if(qtykirim == hasilqty){

                               status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='LENGKAP'> ";
                               $('.status4' + id).val('LENGKAP');
                            }
                            else {
                             /*  status = "TIDAK LENGKAP";*/
                                status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='TIDAK LENGKAP'> ";
                               $('.status4' + id).val('TIDAK LENGKAP');
                            }

                          }
                      })
                }) 
				  }
				  else {
					console.log('else');
				  }
			  },
			  error : function(){
					location.reload();
			}
			  
			})
		}
     /*<!-- end flag fp -->*/
		else { /*flag pengeluaran barang*/
      var url = baseUrl + '/penerimaanbarang/gettampil';
      var idpbg = $('.idpbg').val();
      $.ajax({    
        type :"get",
        data : {kodeitem, idpbg,flag},
        url : url,
        dataType:'json',
        success : function(response){
      
        $noajax = 1;
        if(response.judul.length != 0) {
          $('#lengkap').attr('disabled' , true);
          console.log('ok');
          var qtykirim = [];
          var qtyditerima = [];
          
          /*var judulpenerimaan = "<h4> Data Penerimaan Barang </h4>";
          $('.judul').html(judulpenerimaan);*/
          $notable = 1;
          for(var j = 0 ; j < response.judul.length; j++) {
          console.log(j);
            $no = 1;
          var rowtampil = "<br> <br><table class='table'> <tr> <td style='width:200px'> No LPB </td> <td> : </td> <td>" + response.judul[j].pb_lpb + "</td> </tr>" + //no lpb
                  "<tr> <td> No Surat Jalan </td> <td> : </td> <td> <input type='text' class='input-sm form-control suratjalan"+$notable+"' value="+response.judul[j].pb_suratjalan+" readonly></td> </tr>" +
                  "<tr> <td> Tgl di Terima </td> <td style='width:20px'> :</td> <td>"+ response.judul[j].pb_date + "</td>  </tr> " +
                  "<tr> <td> Status Penerimaan Barang </td> <td> </td> <td> "+response.judul[j].pb_status+" </div> </td> </tr>" +
                  "<tr> <td> Diterima oleh </td> <td> : </td> <td>"+response.judul[j].pb_terimadari+"</td> </tr>" +
                  "<tr> <td> <a class='btn btn-info btn-xs' href={{url('penerimaanbarang/penerimaanbarang/cetak')}}"+'/'+response.judul[j].pb_pbd+","+flag+","+response.judul[j].pb_id+"><i class='fa fa-print' aria-hidden='true'  ></i>  Cetak </a> &nbsp; <a class='btn btn-xs btn-danger hapusdata' data-id="+response.judul[j].pb_id+" data-idtransaksi="+response.judul[j].pb_pbd+"> <i class='fa fa-trash'> </i>  Hapus </a>  </td> </tr>" +
                  "<tr> <td> <div class='row'> <div class='col-sm-5'> <button class='btn btn-xs btn-default editdata' type='button' data-id="+$notable+" data-ajax="+$noajax+" style='color:red'> <i class='fa fa-pencil'> </i> Edit Data</button> </div> &nbsp; <div class='col-sm-5'> <div class='simpan2"+$notable+"'> </div> </div> </div> </td> </tr>" +
                  "</table>";
            rowtampil += "<table class='table table-striped table-bordered' style='width:75%'> <tr> <th> No </th> <th> Nama Barang </th> <th> Satuan </th> <th> Harga Satuan </th> <th> Jumlah Harga </th> <th> Jumlah Dikirim </th> <th> Jumlah yang diterima </th> <th> No Transaksi </th> </tr>"; // judul
 rowtampil += "<a class='btn btn-xs btn-primary' onclick='lihatjurnal(\""+response.judul[j].pb_lpb+","+response.judul[j].pb_keterangan+"\")'> <i class='fa fa-book'> </i> Lihat Jurnal </a>";
             for(var x =0; x < response.barang[j].length; x++) {
            //  console.log(x);
                rowtampil += "<tr> <td style='width:20px'>"+ $no +"</td>" + 
                    "<td> "+ response.barang[j][x].nama_masteritem +"</td>" +// no
                    "<td>" + response.barang[j][x].unitstock + "</td>" +
                    "<td style='text-right'>" + addCommas(response.barang[j][x].pbdt_hpp)  + "</td> <input type='hidden' class='harga"+$noajax+"' value='"+response.barang[j][x].fpdt_harga+"'>";    
                     rowtampil +=    "<td style='text-right'> <input type='text' class='input-sm form-control biaya2"+$notable+" biaya"+$noajax+"' value='"+addCommas(response.barang[j][x].pbdt_totalharga)+"' readonly></td>" +                    
                    "<td>"+ response.barang[j][x].pbd_disetujui +"</td>" +
                    "<td> <input type='number' class='input-sm form-control qtyreceive2  qtyreceive3"+$notable+" qtyterima2"+$noajax+"' name='qtyterima[]' id=qtyterima2"+$noajax+" data-kodeitem="+response.barang[j][x].kode_item+" data-id="+$noajax+" data-idpbdt="+response.barang[j][x].pbdt_id+" value="+response.barang[j][x].pbdt_qty+" readonly></td>" +
                    "<input type='hidden' class='status2"+$notable+" status4"+$noajax+"' value='"+response.barang[j][x].pbdt_status+"'> " +
                    "<input type='hidden' value='"+response.barang[j][x].pbd_disetujui+"' class='qtykirim2"+$noajax+"' data-id="+$noajax+" name='qtydikirim2[]'>" +
                    "<input type='hidden' value='"+response.barang[j][x].pbdt_qty+"' class='qtyterima3"+$noajax+"' data-id="+$noajax+"> "+
                    "<input type='hidden' class='kodeitem4"+$noajax+" kodeitem2"+$notable+"' value="+response.barang[j][x].kode_item+">" +
                    "<input type='hidden' class='idpbdt"+$noajax+" idpbdt2"+$notable+"' value="+response.barang[j][x].pbdt_id+">" +
                    "<input type='hidden' class='idpb2"+$notable+"' value="+response.barang[j][x].pbdt_idpb+">" +
                    "<td>"+ response.barang[j][x].pb_nota +"</td> </tr>";
                    qtykirim.push(response.barang[j][x].pbd_disetujui);
                    qtyditerima.push(response.barang[j][x].pbdt_qty);
                    $no++;
                    $noajax++;
                    var sisa = parseInt(response.barang[j][x].pbd_disetujui) - parseInt(response.barang[j][x].pbdt_qty);
              }
               
               var lengthjudul = 0;
               $('.tampildata').append(rowtampil); 
               $notable++;                                
            }

                $('.hapusdata').click(function(){
                       id = $(this).data('id');
                       idtransaksi = $(this).data('idtransaksi');
                       flag = 'PBG';
                       swal({
                        title: "Apakah anda yakin?",
                        text: "Hapus Data!",
                        type: "warning",
                        showCancelButton: true,
                        showLoaderOnConfirm: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Ya, Hapus!",
                        cancelButtonText: "Batal",
                        closeOnConfirm: true
                      },
                      function(){
                        $.ajax({
                         
                          type : "get",
                          url : baseUrl + '/penerimaanbarang/hapusdatapenerimaan',
                          data : {id,idtransaksi,flag},
                          dataType : 'json',
                          success : function(response){
                                
                                  if(response == 'sukses'){
                                  swal({
                                  title: "Berhasil!",
                                          type: 'success',
                                          text: "Data Berhasil Dihapus",
                                          timer: 2000,
                                          showConfirmButton: true
                                          },function(){
                                            location.reload();
                                  });
                                }else{
                                 swal({
                                title: "Data Tidak Bisa Dihapus",
                                        type: 'error',
                                        timer: 1000,
                                        showConfirmButton: false
                            });
                                }
                          },
                            error:function(data){

                              swal({
                              title: "Terjadi Kesalahan",
                                      type: 'error',
                                      timer: 2000,
                                      showConfirmButton: false
                          });
                         }
                        })
                      })
                      
                  })

              $('.editdata').click(function(){
                id = $(this).data('id');
                noajax = $(this).data('ajax');
               
                $('.suratjalan' + id).attr('readonly' , false);
                simpan4 = "<button class='btn btn-xs btn-success simpan4' data-id='"+id+"' type='button'> <i class='fa fa-check'> </i> Simpan </button>";
                $('.simpan2' + id).html(simpan4);


                $('.simpan4').click(function(){
                  id = $(this).data('id');
                  suratjalan = $('.suratjalan' + id).val();
                  arrqty = [];
                  $('.qtyreceive3' + id).each(function(){
                    val = $(this).val();
                    arrqty.push(val);
                  })                  
                  idpb = $('.idpb2' + id).val();
                //  idpb = response.pbdt[0].pbdt_idpb;
                  arridpbdt = [];
                  $('.idpbdt2' + id).each(function(){
                    val = $(this).val();
                    arridpbdt.push(val);
                  })

                  arrstatus = [];
                  $('.status2' + id).each(function(){
                    val = $(this).val();
                    arrstatus.push(val);
                  })

                  arrkodeitem = [];
                  $('.kodeitem2' + id).each(function(){
                    val = $(this).val();
                    arrkodeitem.push(val);
                  })

                  arrharga = [];
                  $('.biaya2' + id).each(function(){
                    val = $(this).val();
                    arrharga.push(val);
                  })
                  idpbdt = $('.idpbdt2' + id).val();
                  status = $('.status2' + id).val();
                  kodeitem = $('.kodeitem2' + id).val();
                  flag = $('.flag').val();
                  if(flag == 'FP'){
                    iddetail = $('.idfp').val();
                  }
                  else if(flag == 'PO'){
                    iddetail = $('.idpo').val();
                  }
                  else {
                    iddetail = $('.idpbg').val();
                  }

                  $.ajax({
                      type : "post",
                      url : baseUrl + '/penerimaanbarang/updatepenerimaanbarang',
                      data : {arrqty, arrstatus, arrkodeitem, idpb, suratjalan, arridpbdt, arrharga,iddetail,flag},
                      dataType : 'json',
                      success : function(response){
                         alertSuccess(); 
                         location.reload();
                         $('.qtyreceive2').attr('disabled', 'true');
                         $('.suratjalan' + id).attr('readonly' , true);
                      }

                  })

                })



              })

              $('.qtyreceive2').change(function(){
                      val = $(this).val();
                      id = $(this).data('id');
                      kodeitem = $(this).data('kodeitem');
                      idpbdt = $(this).data('idpbdt');
                      rowidpbdt = "<input type='text' value="+idpbdt+" >";
                      
                      $('.idpbdt').val(idpbdt);
                      console.log(kodeitem);
                      sppid = $(this).data('spp');
                 
                      //appendkodeitem
                      qtykirim = $('.qtykirim2' + id).val();
                      qtyterima = $('.qtyterima3' + id).val();
                      $('.kodeitem4' + id).val(kodeitem);
                      
                      console.log(qtykirim + 'qtykirim');
                      harga = $('.harga' + id).val();
                      harga2 = harga.replace(/,/g, '');

                      biaya = parseFloat(harga2 * val).toFixed(2);
                      $('.biaya' + id).val(addCommas(biaya)); 


                      po_id = $('.po_id').val();
                      idspp = sppid;
                      flag = $('.flag').val();
                      idpbg = $('.idpbg').val();
                      alert(idpbg);
                      urlterima = baseUrl + '/penerimaanbarang/changeqtyterima';
                       $.ajax({    
                          type :"get",
                          data : {kodeitem, po_id, idspp, flag, idpbg},
                          url : urlterima,
                          dataType:'json',
                          success : function(response){
                          
                            lengthresp = response.pbdt.length;
                            qty = 0;
                            for(var i = 0; i < lengthresp; i++) {
                              qty = qty + response.pbdt[i].pbdt_qty
                            }

                          

                            hasilqty = parseInt((parseInt(val) + parseInt(qty)) - parseInt(qtyterima));
                          
                            
                            if(hasilqty > qtykirim) {
                              toastr.info('tidak bisa mengisi angka di bawah jumlah angka yang diterima dari yang dikirim :) ');
                              kosong = '';
                             $('.status4' + id).val('');
                             $('.qtyterima2' + id).val('');
                            }


                            qtykirim = $('.qtykirim2' + id).val();
                       //     hasilterima = parseInt(qty) + parseInt(val) - ;
                            console.log(qty + 'qty');
                            console.log(val + 'val');
                            if(qtykirim == hasilqty){

                               status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='LENGKAP'> ";
                               $('.status4' + id).val('LENGKAP');
                            }
                            else {
                             /*  status = "TIDAK LENGKAP";*/
                                status = "<input type='text' class='status2"+$noajax+"' name='status2[]' value='TIDAK LENGKAP'> ";
                               $('.status4' + id).val('TIDAK LENGKAP');
                            }

                          }
                      })
                }) 
          }
          else {
          console.log('else');
          }
        },
		error : function(){
			location.reload();
		}
      })
    } /*end pengeluaran barang*/
     
 
    $('#lengkap').change(function(){   
      flag = $('.flag').val();
      if($(this).is(':checked')) {
        var qtykirimlength = $('.databarang').length;      
        for(var i = 0 ; i < qtykirimlength; i++){ 
   /*     alert(qtykirimlength);   */    
          val = $('.qtykirim' + i).val();
          id = $('.qtykirim' + i).data('id');
         
          if(flag == 'PBG'){         
            angka = val.split(",");
            val2 = angka[0];
            
          }
          $('#qtyterima' + id).val(val);
        }           
      }

      if(!$(this).is(':checked')){       
         var qtykirimlength = $('.databarang').length;
        for(var i = 0 ; i < qtykirimlength; i++){
          val = $('.qtykirim' + i).val();
          id = $('.qtykirim' + i).data('id');
          kosong = '';
          $('#qtyterima' + id).val(kosong);
        }  
      }
    })


    $('.qtyreceive').keyup(function(){
    
      val = $(this).val();
      id = $(this).data('id');
  
      kodeitem = $(this).data('kodeitem');
      console.log(kodeitem);
      sppid = $(this).data('spp');
    /*  rowspp = "<input type='text' value="+sppid+" name='idspp[]'>";
      $('.idspp'+id).html(rowspp);*/


      //appendkodeitem
      barang = "<input type='text' value="+kodeitem+" name='item[]'>";
      //$('#idbarang' + id).html('barang'); 

      //appendidspp
   //   spp = "<input type='text' value="+sppid+" name=idspp[]>";
  //    $('.idspp' + id).html(spp);


       qtykirim = $('.qtykirim' + id).val();
      
        flag = $('.flag').val();
        if(flag == 'FP'){
          if(val != qtykirim) {
            toastr.info("Data Qty di terima Harus Lengkap");
            $(this).val('');
          }
        }
        else if(flag == 'FP'){
          if(val != qtykirim){
            toastr.info("Data Qty di terima Harus Lengkap");
            $(this).val(''); 
          }
        }


      //appendjumlahkirim
        row = "<input type='text' value="+qtykirim+" name=qtydikirim[]>";
     //   $('.jmlhkirim' + id).html(row);

    //  alert(qtykirim  + 'qtykirim');
      if(parseInt(val) == parseInt(qtykirim)) {
        status = "LENGKAP";
        $('.status' + id).val(status);
      }
      else if(val == ''){
        $('.jmlhkirim' + id).empty();
        $('.idspp' + id).empty();
      }
      else if(parseInt(val) > parseInt(qtykirim)) {
        $('.jmlhkirim' + id).empty();
        $('.idspp' + id).empty();
      }
      else {
        status = "TIDAK LENGKAP";
        $('.status' + id).val(status);
       // $('.jmlhkirim' + id).empty();
      }
       


      if(parseInt(val) > parseInt(qtykirim)){
        toastr.info("diharapkan mengisi angka di bawah angka jumlah dikirim :) ");
        kosong = " ";
        $(this).val(kosong);
      }
      
      po_id = $('.po_id').val();
      idspp = sppid;
      flag = $('.flag').val();
      idpbg = $('.idpbg').val();
      urlterima = baseUrl + '/penerimaanbarang/changeqtyterima';
       $.ajax({    
          type :"get",
          data : {kodeitem, po_id, idspp, flag, idfp, idpbg},
          url : urlterima,
          dataType:'json',
          success : function(response){
            console.log(response);
       /*        row = "<input type='text' value="+qtykirim+" name=qtydikirim[]>";
            $('.jmlhkirim' + id).html(row);*/
            console.log(response);
            lengthresp = response.pbdt.length;
            qty = 0;
            for(var i = 0; i < lengthresp; i++) {
              qty = qty + response.pbdt[i].pbdt_qty
            }

            console.log(qty);

            hasilqty = parseInt(val) + parseInt(qty);
            
            if(hasilqty > qtykirim) {
              toastr.info('tidak bisa mengisi angka di bawah jumlah angka yang diterima dari yang dikirim :) ');
              kosong = '';
              $('#qtyterima' + id ).val(kosong);
              $('.jmlhkirim' + id).empty();
                $('.idspp' + id).empty();
            }
          }
      })
    })


</script>
@endsection
