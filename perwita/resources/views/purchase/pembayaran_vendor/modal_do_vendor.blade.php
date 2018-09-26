<div id="modal_show_vendor" class="modal fade" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document" style="width: 1200px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Pilih Delivery Order</h4>
	      	</div>
	      	<div class="modal-body vendor_div">
	        	
	    	</div><!-- /.modal-content -->
	    	<div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="hidden" class="btn btn-primary append_vendor" >Save changes</button>
	      	</div>
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>


<div id="modal_um_vendor" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width: 1200px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pembayaran Uang Muka</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-sm-8">
              <table class="table vendor_tabel_um">
              <tr>
                <td>No Transaksi Kas / Bank</td>
                <td colspan="2">
                  <input placeholder="klik disini" type="text" name="vendor_nomor_um" class=" form-control vendor_nomor_um">
                  <input type="hidden" name="vendor_id_um" class=" form-control vendor_id_um">
                </td>
              </tr>
              <tr>
                <td>Tanggal</td>
                <td colspan="2">
                  <input type="text" name="vendor_tanggal_um" class=" form-control vendor_tanggal_um">
                </td>
              </tr>
              <tr>
                <td>Jumlah</td>
                <td colspan="2">
                  <input readonly="" type="text" name="vendor_jumlah_um" class=" form-control vendor_jumlah_um">
                </td>
              </tr>
              <tr>
                <td>Sisa Uang Muka</td>
                <td colspan="2">
                  <input readonly="" type="text" name="vendor_sisa_um" class=" form-control vendor_sisa_um">
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td colspan="2">
                  <input readonly="" type="text" name="vendor_keterangan_um" class=" form-control vendor_keterangan_um">
                </td>
              </tr>
              <tr>
                <td>Dibayar</td>
                <td>
                  <input type="text" name="vendor_dibayar_um" class=" form-control vendor_dibayar_um">
                </td>
                <td align="right">
            
                    <button class="btn btn-primary vendor_tambah_um" type="button" ><i class="fa fa-plus"> Tambah</i></button> 
     
                </td>
              </tr>
            </table>
            </div>
            <div class="col-sm-4">
              <table class="table ">
                <tr>
                  <td align="center">
                   <h3>Total Jumlah Uang Muka</h3>
                  </td>
                </tr>
              <tr>
                <td>
                  <input readonly="" type="text" name="vendor_total_um" class="vendor_total_um form-control ">
                </td>
              </tr>
            </table>
            </div>

              <div class="col-sm-12">
               <table class="table table-bordered vendor_tabel_detail_um" ">
                <thead>
                <tr class="tableum">
                  <th style="width:120px"> No Faktur </th>
                  <th> No Kas / Bank</th>
                  <th> Tanggal </th>
                  <th> No Uang Muka</th>
                  <th> Jumlah Uang Muka </th>
                  <th> Sisa Uang Muka </th>
                  <th> Dibayar </th>
                  <th> Keterangan</th>
                  <th> Aksi </th> 
                </tr>
                </thead>
                <tbody>
              
               </tbody>
            </table>
          </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="hidden" class="btn btn-primary save_vendor_um disabled" >Save changes</button>
      </div>
      </div>
     
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal_tt_penerus" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body div_tt">
        
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button onclick="simpan_tt()" type="button" class="btn btn-primary simpan_penerus" data-dismiss="modal">Simpan</button>
    </div>
  </div>
</div>





<div class="modal modal_jurnal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" style="width: 1000px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body tabel_jurnal">
          
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="modal_pajak" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 800px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">FAKTUR PAJAK MASUKAN</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-8">
                <table class="table table_pajak_penerus">
                  <tr>
                    <td>No Faktur Pajak</td>
                    <td><input type="text" class="form-control faktur_pajak_penerus" name="faktur_pajak_penerus"></td>
                  </tr>
                  <tr>
                    <td>Tanggal</td>
                    <td><input type="text" class="form-control date tanggal_pajak_penerus" name="tanggal_pajak_penerus"></td>
                  </tr>
                  <tr>
                    <td>Masa Pajak</td>
                    <td><input type="text" class="form-control date masa_pajak_penerus" name="masa_pajak_penerus"></td>
                  </tr>
                </table>
              </div>
              <div class="col-sm-6">
                <table class="table">
                  <caption class="center"><h4>FAKTUR PEMBELIAN</h4></caption>
                  <tr>
                    <td>DPP</td>
                    <td  colspan="2">
                      <input type="text" readonly="" class="form-control dpp_faktur_pajak_penerus" name="dpp_faktur_pajak_penerus">
                    </td>
                  </tr>
                  <tr>
                    <td>PPN</td>
                    <td width="70">
                      <input type="text" readonly="" class="form-control  nilai_ppn_pajak_penerus" name="nilai_ppn_pajak_penerus">
                    </td>
                    <td>
                      <input type="text" readonly="" class="form-control  ppn_pajak_penerus" name="ppn_pajak_penerus">
                    </td>
                  </tr>
                </table>
              </div>
              <div class="col-sm-6">
                <table class="table">
                  <caption class="center"><h4>FAKTUR PAJAK</h4></caption>
                  <tr>
                    <td><input type="text" readonly="" class="form-control dpp_faktur_pajak_penerus1" name="dpp_faktur_pajak_penerus1"></td>
                  </tr>
                  <tr>
                    <td><input type="text" readonly="" class="form-control  ppn_pajak_penerus1" name="ppn_pajak_penerus1"></td>
                  </tr>
                </table>
              </div>
              <div class="col-sm-12">
                <table class="table">
                  <tr>
                    <td>Netto</td>
                    <td><input readonly="" type="text" class="form-control  netto_pajak_penerus" name="netto_pajak_penerus"></td>
                  </tr>
                </table>
              </div>
          </div><!-- /.modal-content -->
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="hidden" class="btn btn-primary" data-dismiss="modal">Save changes</button>
          </div>
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>



