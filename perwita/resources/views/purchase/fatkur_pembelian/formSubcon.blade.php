
<div class="col-sm-12 header_biaya"  >
	{{ csrf_field() }}
<form>
<div class="col-sm-6">
<table class="table	head_subcon">
	<h3 style="text-align: center;">Form Subcon</h3>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tempo_subcon" class="form-control tempo_subcon" value="{{$date}}" >
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" ></td>
 </tr>
  <tr class=" hd2" >
 	<td style="width: 100px">Nama Subcon</td>
 	<td width="10">:</td>
 	<td width="200">
 		<select class="nama_sc form-control chosen-select-width1" name="nama_subcon">
 				<option value="0">- Cari - Subcon -</option>
 			@foreach($subcon as $sub)
 				<option value="{{$sub->kode}}">{{$sub->kode}} - {{$sub->nama}}</option>
 			@endforeach
 		</select>
 	</td>
  </tr>	
 <tr>
 	<td style="width: 100px">No Invoice </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="invoice_subcon" class="form-control invoice_subcon" ></td>
 </tr>	
 <tr>
 	<td style="width: 100px">Keterangan </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="keterangan_subcon" class="form-control keterangan_subcon"  ></td>
 </tr>	
 <tr>
 	<td style="width: 100px">Total Biaya</td>
 	<td width="10">:</td>
	<td width="200"><input type="text" readonly=""  class="form-control total_subcon" ></td>
 </tr>
</table>
</div>
<div class="col-sm-12 detail_subcon"  >
	<div class="col-sm-5 table_filter_subcon"   >
    <form class="form">
	  <table class="table">
	  	<div align="center" style="width: 100%;">	
			<h3 >Form Resi Subcon</h3>
		</div>	
	  <tr>
		<td style="width: 100px">Nomor Seq</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" class="form-control m_seq" readonly="" value="1" >
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Nomor POD</td>
		<td width="10">:</td>
		<td width="200">

			<input type="text" placeholder="Klik Disini..." class="form-control m_do_subcon"  >
		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Jenis Angkutan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_jenis_angkutan_do" >
		</td>
	 </tr>
	  <tr>
		<td style="width: 100px">Tanggal</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" placeholder="" class="form-control m_do_tanggal"  >
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px" class="label_satuan">Jumlah</td>
		<td width="10">:</td>
		<td class="form-inline form_satuan">
			<div class="input-group" style="width: 100%">
                <input readonly=""  style="width: 100%" class="form-control m_do_jumlah" type="text" value="" >
                <span class="input-group-addon m_satuan" style="padding-bottom: 12px;">satuan</span>
             </div>
 		</td>
	  </tr>
	  
	  
	 <tr>
	 	<td style="width: 100px">Asal DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_do_asal" >
		</td>
	 </tr>
	 <tr>
	 	<td style="width: 100px">Tujuan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_do_tujuan" >
		</td>
	 </tr>

	 <tr>
	 	<td style="width: 100px">Tipe Kendaraan DO</td>
	 	<td width="10">:</td>
		<td width="200">
			<input type="text" readonly="" class="form-control m_tipe_kendaraan" >
		</td>
	 </tr>
	 <tr>
	 	<td colspan="3">
	 		<button class="btn btn-info modal_tt_subcon pull-left" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_outlet" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
		    <button type="button" class="btn btn-primary pull-right disabled" onclick="cariSUB()"><i class="fa fa-plus">&nbsp;Append</i></button>
	 	</td>
	 </tr>
     </table>
    </form>
</div>
	<div class="col-sm-5" style="margin-left: 100px;">
	<table class="table" >
	     <div align="center" style="width: 100%;" >	
			<h3 >Form Kontrak Subcon</h3>
		 </div>	
		  <tr>
			<td style="width: 100px">Nomor</td>
			<td width="10">:</td>
			<td>
				<input type="text" name="sc_nomor_kontrak" class="form-control nota_subcon"  placeholder="Klik Disini...">
				<input type="hidden" name="sc_id_subcon" class="form-control id_subcon"  readonly="">
				<input type="hidden" name="sc_dt_subcon" class="form-control dt_subcon"  readonly="">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Biaya Subcon</td>
			<td width="10">:</td>
			<td width="200">
				<input type="text" class="form-control sc_biaya_subcon"  readonly="" value="" >
				<input type="hidden" class="form-control sc_biaya_subcon_dt" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Jenis Tarif</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" name="tarif_subcon" class="form-control sc_tarif_subcon" readonly=""  >
				<input type="hidden" name="kode_tarif_subcon" class="form-control sc_tarif_subcon" style="width: 250px;">
			</td>
		  </tr>
		  <tr>
		 	<td style="width: 100px">Memo</td>
		 	<td width="10">:</td>
			<td width="200">
				<input type="text"  class="form-control sc__do_memo" >
			</td>
		 </tr>
		  <tr>
			<td style="width: 100px">Asal Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly="" class="form-control sc_asal_subcon" >
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Tujuan Kontrak</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" readonly=""  class="form-control sc_tujuan_subcon">
			</td>
		  </tr>
		  <tr>
			<td style="width: 100px">Kendaraaan</td>
			<td width="10">:</td>
			<td width="200">

				<input type="text" class="form-control sc_kendaraan_subcon" readonly=""  >
				<input type="hidden" class="form-control sc_kode_angkutan" style="width: 250px;">
			</td>
		  </tr>
		  <tr class="hd2 tr_disabled">
		 </tr>
	</table>
	</div>
</div>
</form>
</div>



<div class="col-sm-5 table_filter_resi disabled " hidden   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">	
		<h3 >Detail Biaya Penerus Hutang</h3>
	 </div>	
	  
     </table>
     <button type="button" class="btn btn-primary pull-right cari_pod" onclick="cariSUB();"><i class="fa fa-search">&nbsp;Search</i></button>
    </form>
</div>

 <div class=" col-sm-12 tb_sb_hidden" hidden="">
 	<h3>Tabel Detail Resi</h3>
 	<hr>
	    <table class="table table-bordered table-hover tabel_subcon">
			<thead align="center">
				<tr>
				<th>No</th>
				<th width="90">Nomor Resi</th>
				<th>Harga Resi</th>
				<th>Tarif Subcon</th>
				<th>Multiply</th>
				<th>Keterangan</th>
				<th width="50">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	    <button type="button" class="btn btn-primary pull-right" id="save-update" onclick="save_subcon()" data-dismiss="modal">Simpan Data</button>
	</div>
	
<div id="modal_subcon" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 800px;">

    <!-- Modal content-->
    <div id="subcon_modal" class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kontrak Subcon</h4>
      </div>
        <div class="modal-body subcon_modal">

     	<div class="pull-right">
     		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    		<button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Save changes</button>
    	</div>
      </div>      
    </div>
    	
  </div>
</div>


{{-- MODAL TT SUBCON --}}

<div class="modal fade" id="modal_tt_subcon" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 1000px !important; min-height: 1000px">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title">Form Tanda Terima</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-stripped tabel_tt_outlet">
        	<tr>
        		<td width="150px">
                  No Tanda Terima 
                </td>
                <td>
                  <input type='text' name="nota_tt" class='input-sm form-control notandaterima'>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </td>
        	</tr>
        	<tr>
        		<td> Tanggal </td>
                <td>
                   <div class="input-group date">
                    	<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl_tt" value="" readonly="" name="tgl_tt">
                  </div>
                </td>
        	</tr>
        	<tr>
              <td> Supplier </td>
              <td> <input type='text' class="form-control supplier_tt" value="" name="supplier_tt" readonly=""></td>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                 <div class="row">
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="Kwitansi" type="checkbox" checked="" name="kwitansi">
                            <label for="Kwitansi">
                                Kwitansi / Invoice / No
                            </label>
                      </div> 
                    </div>
                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="FakturPajak" type="checkbox" checked="" name="faktur_pajak">
                            <label for="FakturPajak">
                                Faktur Pajak
                            </label>
                      </div> 
                    </div>

                    <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratPerananAsli" type="checkbox" checked="" name="surat_peranan">
                            <label for="SuratPerananAsli">
                                Surat Peranan Asli
                            </label>
                      </div> 
                    </div>

                     <div class="col-sm-3"> 
                      <div class="checkbox checkbox-info checkbox-circle">
                          <input id="SuratJalanAsli" type="checkbox" checked="" name="surat_jalan">
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
                <input type="text" class="form-control lain_subcon" name="lainlain">
              </td>
            </tr>
            <tr>
              <td> Tanggal Kembali </td>
              <td><div class="input-group">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo_tt" readonly="" name="tgl_kembali">
                </div>
              </td>
            </tr>
            <tr>
              <td>Total di Terima</td>
              <td>
              	<div class="row">
              		<div class="col-sm-3">
              			<label class="col-sm-3 label-control"> Rp </label>
              		</div>
              		<div class="col-sm-9">
              			<input type="text" class="form-control totalterima_tt" name="total_diterima" style="text-align:right;" readonly="">
              		</div>
              	</div>
              </td>
            </tr>
        </table>
      </div>
      <div class="modal-footer inline-form">
        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary simpan_subcon" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>


<!-- modal DO-->
<div id="modal_do" class="modal" >
  <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Nomor DO</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal  tabel_subcon_detail">
               
            </form>
          </div>
          <div class="modal-footer">
          </div>
    </div>
  </div>
</div>

<!-- modal DO-->
<div id="modal_do" class="modal" >
  <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Pilih Nomor DO</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal  tabel_subcon_detail">
               
            </form>
          </div>
          <div class="modal-footer">
          </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	// global variable
	var array_do =[];
var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }	 
var subcon = $('.tabel_subcon').DataTable({
					// 'paging':false,
					'searching':false
				});

$('.tempo_subcon').datepicker();


$('.m_do_subcon').focus(function(){
	  var  selectOutlet = $('.nama_sc').val();
	  if (selectOutlet == '0') {
	  	toastr.warning('Harap Pilih Customer');
	  	return 1;
	  }

	  var  cabang     = $('.cabang').val();

	  $.ajax({
	      url:baseUrl +'/fakturpembelian/cari_do_subcon',
	      data: {selectOutlet,cabang},
	      success:function(data){
	        $('.tabel_subcon_detail').html(data);
			$('#modal_do').modal('show');
	      },error:function(){
	        toastr.warning('Terjadi Kesalahan');
	      }
	    })
})

function pilih_do_subcon(par) {
	var d_nomor_do = $(par).find('.d_nomor_do').val();
	var d_tanggal = $(par).find('.d_tanggal').val();
	var d_jumlah = $(par).find('.d_jumlah').val();
	var d_satuan = $(par).find('.d_satuan').val();
	var d_asal = $(par).find('.d_asal').val();
	var d_tujuan = $(par).find('.d_tujuan').val();
	var d_asal_text = $(par).find('.d_asal_text').text();
	var d_tujuan_text = $(par).find('.d_tujuan_text').text();
	var d_jenis_tarif_text = $(par).find('.d_jenis_tarif_text').text();
	var d_tipe_angkutan_text = $(par).find('.d_tipe_angkutan_text').text();

	$('.m_do_subcon').val(d_nomor_do);
	$('.m_do_tanggal').val(d_tanggal);
	$('.m_do_jumlah').val(d_jumlah);
	$('.m_satuan').text(d_satuan);
	$('.m_do_asal').val(d_asal_text);
	$('.m_do_tujuan').val(d_tujuan_text);
	$('.m_jenis_angkutan_do').val(d_jenis_tarif_text);
	$('.m_tipe_kendaraan').val(d_tipe_angkutan_text);
	
	$('#modal_do').modal('hide');




}

function cariSUB(){


	      subcon.row.add( [
                  seq+'<input type="hidden" class="seq_sub sub_seq_'+seq+'"  value="'+seq+'" >'
                  +'<input type="hidden" name="comp_subcon[]" value="'+comp+'" >',
                  valPo+'<input type="hidden" class="dt_resi_subcon"  name="resi_subcon[]" value="'+valPo+'" >',
                  Math.round(bayar).toFixed(2)+'<input type="hidden" class="harga_resi"  name="harga_resi[]" value="'+bayar+'" >',
                  Math.round(tot_sub).toFixed(2)+'<input type="hidden" name="harga_tarif[]" class="harga_tarif" value="'+tot_sub+'" >',
                  html,
                  ket+'<input type="hidden" name=ket_subcon[]" value="'+ket+'" >',
                  '<a class="btn btn-danger fa fa-trash" align="center" onclick="hapus_subcon(this)" title="hapus"></i></a>'
              ] ).draw( false );   

	   	 $('.pod_subcon ').focus();
	   	 $('.pod_subcon ').val('');
	   	 $('.tarif_pod_subcon ').val('');
	   	 $('.total_subcon ').val('');
	   	 $('.trip_subcon ').val('');
	   	 $('.berat_subcon ').val('');

	
}


function hapus_subcon(o){
    var ini = o.parentNode.parentNode;
    var cari = $(ini).find('.dt_resi_subcon').val();
    var temp1=0;
    var cariIndex = sequence.indexOf(cari);
    sequence.splice(cariIndex,1);
    
 
    subcon.row(ini).remove().draw(false);
}


function nama_sc() {
	// body...
}

function save_subcon(){
	var id_subcon = $('.id_subcon').val();
	var dt_subcon = $('.dt_subcon').val();
	var invoice_subcon = $('.invoice_subcon').val();
	var tempo_subcon = $('.tempo_subcon').val();
	var nota_subcon =$('.nota_subcon').val();
	var jenis_kendaraan = $('.kode_angkutan').val();
	var tarif_subcon = $('.tarif_subcon').val();

	swal({
    title: "Apakah anda yakin?",
    text: "Simpan Data Subcon!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Simpan!",
    cancelButtonText: "Batal",
    closeOnConfirm: true
  },
  function(){
       $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      $.ajax({
     	url:baseUrl + '/fakturpembelian/subcon_save',
		data:'id='+id_subcon
				+'&'+'dt='+dt_subcon
				+'&'+'ts='+tarif_subcon
				+'&'+'angkutan='+jenis_kendaraan
				+'&'+'tempo='+tempo_subcon
				+'&'+'nota='+nota_subcon
				+'&'+'invoice='+invoice_subcon
				+'&'+subcon.$('input').serialize()
				+'&'+$('.head1 .nofaktur').serialize()
				+'&'+$('.head_subcon :input').serialize(),
		type:'GET',
      success:function(response){


      	if (response.status == 1) {

	        swal({
	        title: "Berhasil!",
	                type: 'success',
	                text: "Data berhasil disimpan",
	                timer: 900,
	               showConfirmButton: true
	                },function(){
	                   location.reload();
	        });
    	}else{
    		swal({
       		title: "Harap isi form dengan benar",
                type: 'error',
                timer: 900,
               showConfirmButton: true

    		});
    	}
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 900,
               showConfirmButton: true

    });
   }
  });  
 });
}


</script>
