
<div class="col-sm-5 header_biaya"  >
	{{ csrf_field() }}
<form class="head_atas">
<table class="table	head-biaya">
	<h3 style="text-align: center;">Form Biaya Penerus Hutang</h3>
 <tr>
 	<td style="width: 100px">Tanggal</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="tgl_biaya_head" class="form-control tgl-biaya" value="{{$date}}" readonly="" style="width: 250px;">
 		<input type="hidden" class="form-control tgl_resi"  readonly="" style="width: 250px;">
 		<input type="hidden" name="master_persen" class="form-control master_persen"  readonly="" style="width: 250px;">
 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">Jatuh Tempo</td>
 	<td width="10">:</td>
 	<td width="200">
 		<input type="text" name="jatuh_tempo" class="form-control jatuh_tempo" value="{{$jt}}" placeholder="Jatuh tempo" style="width: 250px;">
 	</td>
 </tr>
<tr>
 	<td style="width: 100px">Status </td>
 	<td width="10">:</td>
	<td width="200"><input type="text" name="status" class="form-control" value="Released" readonly="" style="width: 250px;"></td>
 </tr>
  <tr class="vendor">
 	<td style="width: 100px">Tipe Vendor </td>
 	<td width="10">:</td>
 	<td width="200">
 		<select onchange="ven()" name="vendor" class="form-control vendor1 "  style="text-align: center; width: 250px;" >
 			<option  selected="" value="kosong">-PILIH TIPE VENDOR-</option>
 			<option value="AGEN">Agen Penerus </option>
 			<option value="VENDOR">Vendor Penerus</option>
 		</select>
 		<input type="hidden" name="akun_agen" class="akun_agen">
 	</td>
 </tr>
  <!-- NAMA KONTAK KOSONG -->
 <tr class="nama-kontak-kosong">
 	<td style="width: 100px">Nama Kontak </td>
 	<td width="10">:</td>
 	<td width="200">
 		<select name="nama_kontak1" class="form-control nama-kontak" style="text-align: center; width: 250px;">
 			<option disabled="" selected="">-PILIH NAMA KONTAK-</option>
 		</select>
 	</td>
 </tr>
 <!-- NAMA KONTAK AGEN -->
 <tr hidden="" class="nama-kontak-agen">
 	<td style="width: 100px">Nama Kontak </td>
 	<td width="10">:</td>
 	<td width="200" class="agen_dropdown">

 	</td>
 </tr>
 <!-- NAMA KONTAK VENDOR -->
  <tr hidden="" class="nama-kontak-vendor">
 	<td style="width: 100px">Nama Kontak </td>
 	<td width="10">:</td>
 	<td width="200" class="vendor_dropdown">

 	</td>
 </tr>
 <tr>
 	<td style="width: 100px">No Invoice</td>
 	<td width="10">:</td>
 	<td width="200"><input type="text" name="Invoice_biaya" class="form-control" style="width: 250px;" placeholder="No Invoice"></td>
 </tr>
  <tr>
 	<td style="width: 100px">Keterangan</td>
 	<td width="10">:</td>
 	<td width="200"><input type="text" name="Keterangan_biaya" class="form-control" style="width: 250px;"></td>
 </tr>	
<!--  <tr>
 	<td style="width: 100px">Biaya Khusus</td>
 	<td width="10">:</td>
 	<td align="left"><input type="checkbox" name="biaya_khusus" title="jika dicentang akan merubah batasan menjadi biaya khusus"></td>
 </tr> -->
</table>
</form>
</div>


<div class="col-sm-5 detail_biaya disabled"   style="margin-left: 100px;">
    <form class="form">
     <table class="table">
     <div align="center" style="width: 100%;">	
		<h3 >Detail Biaya Penerus Hutang</h3>
	 </div>	
	  <tr>
		<td style="width: 100px">Nomor</td>
		<td width="10">:</td>
		<td width="200"><input type="text" name="jml_data" class="form-control jml_data" style="width: 250px;" readonly=""></td>
	  </tr>
	  <tr>
		<td style="width: 100px">Nomor POD</td>
		<td width="10">:</td>
		<td width="200"><input type="text" name="no_pod" id="tages" class="form-control no_pod" onkeyup="cariDATA()" onblur="seq();" style="width: 250px;">
			<input type="hidden" class="form-control status_pod" style="width: 250px;">
		</td>
	  </tr>
	  <tr>
		<td style="width: 100px">Account Biaya</td>
		<td width="10">:</td>
		<td width="200" class="form-inline">
			<input type="text" name="kode_akun" class="form-control kode_akun" style="width: 70px;" readonly="">
			<select name="nama_akun" class="form-control nama_akun chosen-select-width" style="width: 176px !important;" onchange="setNo()">
				@foreach($akun_biaya as $val)
		        <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
		        @endforeach
			</select> 
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px">Debet/Kredit</td>
		<td width="10">:</td>
		<td>
			<select name="debit" class="form-control debit" style="text-align: center; width: 250px;">
 				<option value="debit" selected="">DEBIT</option>
 				<option value="kredit">KREDIT</option>
 			</select>
 		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px">Memo</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text" name="ket-biaya" class="form-control ket-biaya" style="width: 250px;"></td>
	 </tr>
	  <tr>
		<td style="width: 100px">Total</td>
		<td width="10">:</td>
		<td width="200"><input type="text" name="total_jml" class="form-control total_jml" style="width: 250px;" readonly=""></td>
	  </tr>
	  <tr>
		<td style="width: 100px">Nominal Resi</td>
		<td width="10">:</td>
		<td width="200"><input type="text" readonly="" class="form-control total_pod" style="width: 250px;"></td>
	  </tr>
	  <tr>
		<td style="width: 100px">Nominal</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" name="nominal" class="form-control nominal" onkeyup="hitung()" style="width: 250px;">
			
		</td>
	  </tr>
	  <tr>
	  	<td colspan="3">
	  <button class="btn btn-info modal_penerus_tt" style="margin-right: 10px;" type="button" data-toggle="modal" data-target="#modal_tt_penerus" type="button"> <i class="fa fa-book"> </i> &nbsp; Form Tanda Terima </button>
     <button type="button" class="btn btn-primary pull-right cari-pod" onclick="cariPOD();"><i class="fa fa-search">&nbsp;Append</i></button>
	  	</td>
	  </tr>
	  <tr>
	  	<td colspan="3">
	  		<button type="button" class="btn btn-primary pull-right disabled save_biaya" id="save-update"  onclick="save_biaya()" ><i class="fa fa-save"></i> Simpan Data</button>
	  		<button type="button" class="btn btn-warning pull-left disabled" id="print-penerus" onclick="print_penerus()" ><i class="fa fa-print"></i> Print</button>
	  	</td>
	  </tr>
     </table>
      
    </form>
</div>

 <div class="table-biaya col-sm-12" hidden="">
 	<h3>Tabel Detail Resi</h3>
 	<hr>
	    <table class="table table-bordered table-hover datatable">
			<thead align="center">
				<tr>
				<th>No</th>
				<th width="90">Nomor Bukti</th>
				<th>Tanggal</th>
				<th width="90">AccBiaya</th>
				<th>Tarif Resi</th>
				<th>Jumlah Bayar</th>
				<th>Tipe Debet</th>
				<th>Keterangan</th>
				<th width="50">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	</div>
	
<div id="modal-biaya" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button style="min-height:0;" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <div class="modal-body">
     <table class="table">
	  <tr>
		<td style="width: 100px ;padding-left: 65px;">Account Biaya</td>
		<td width="10">:</td>
		<td width="200" class="form-inline">
			<input type="text" name="kode_akun" class="form-control kode_akun_update" style="width: 70px;" readonly="">
			<select name="nama_akun" class="form-control nama_akun_update chosen-select-width" style="width: 176px !important;" onchange="updt()">
				@foreach($akun_biaya as $val)
		        <option value="{{$val->id_akun}}">{{$val->nama_akun}}</option>
		        @endforeach
			</select> 
		</td>
	  </tr>
	   <tr>
		<td style="width: 100px ; padding-left: 65px;">Debet/Kredit</td>
		<td width="10">:</td>
		<td>
			<select name="debit" class="form-control debit_update" style="text-align: center; width: 250px;">
 				<option value="debit" selected="">DEBIT</option>
 				<option value="kredit">KREDIT</option>
 			</select>
 		</td>
	  </tr>
	  <tr>
	 	<td style="width: 100px ;padding-left: 65px;">Memo</td>
	 	<td width="10">:</td>
		<td width="200"><input type="text" name="ket-biaya" class="form-control ket_biaya_update" style="width: 250px;"></td>
	 </tr>
	  <tr>
		<td style="width: 100px ;padding-left: 65px;">Nominal</td>
		<td width="10">:</td>
		<td width="200"><input type="number" name="nominal" class="form-control nominal_update" onkeyup="hitung()" style="width: 250px;"></td>
	  </tr>
     </table>
     	<div class="pull-right">
     		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    		<button type="button" class="btn btn-primary" id="save-update" onclick="sve()" data-dismiss="modal">Save changes</button>
    	</div>
      </div>      
    </div>
    	
  </div>
</div>


<!--  MODAL TT PENERUS  -->

<div class="modal fade" id="modal_tt_penerus" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog" role="document" style="min-width: 800px !important; min-height: 800px">
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
                <input type="text" class="form-control lain_penerus" name="lainlain">
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
        <button type="button" class="btn btn-primary simpan_penerus" data-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	var jt = $('.jatuh_tempo').datepicker({
				format:'dd/mm/yyyy',
				autoclose: true
				});
	var dsa = $('.nominal').maskMoney({precision:0, prefix:'Rp '});
	var datatable1 = $('.datatable').DataTable({
            responsive: true,
            searching:false,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

	var tabel_remove = datatable1.column( 0 ).data().length;

	var config = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"176px"}
             }
             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }
    var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"250px"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }

    $(".nama_akun").chosen(config); 

    $(".nama-kontak-agen1").chosen(config1);

    $(".nama-kontak-vendor1").chosen(config1);
$(document).ready(function(){
    $('.modal_penerus_tt').addClass('disabled');
	var isi =  $('.nama_akun').val();
  	$('.kode_akun').val(isi);
});
    


 $('.nominal').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        $('.cari-pod').click();
        return false;
     }	
 })

$('.nama-kontak-agen1').change(function(){
 	
 	@foreach($agen as $a)
 	if ($(this).val() == '{{$a->kode}}') {
 		$('.akun_agen').val('{{$a->acc_hutang}}');
 		// console.log($('.akun_agen').val());
 	}
 	@endforeach

 });

$('.nama-kontak-vendor1').change(function(){
 	
 	@foreach($vendor as $a)
 	if ($(this).val() == '{{$a->kode}}') {
 		$('.akun_agen').val('{{$a->acc_hutang}}');
 		// console.log($('.akun_agen').val()); 
 	}
 	@endforeach

 });

// modal tt

 $('.modal_penerus_tt').click(function(){
 	  agen   = $('.vendor1 ').val();
      cabang = $('.cabang').val();
      supplier = $('.idsup').val();
      jatuh_tempo = $('.jatuh_tempo').val();
      total_jml = $('.total_jml').val();
      string = supplier.split(",");
      if (agen == 'AGEN') {
      	ven = $('.nama-kontak-agen1').val();
      }else{
      	ven = $('.nama-kontak-vendor1').val();
      }

      // console.log(agen);
      tgl = $('.tgl').val();
      jatuhtempo = $('.jatuhtempoitem').val();
      nettohutang = $('.nettohutang').val();

      $('.tgl_tt').val(tgl);
      $('.supplier_tt').val(string[2]);
      $('.jatuhtempo_tt').val(jatuhtempo);
      $('.totalterima_tt').val(nettohutang);


       $.ajax({    
            type :"get",
            data : 'cab='+cabang+'&'+'supp='+ven+'&'+'jenis='+agen+'&'+$('.head1 .nofaktur').serialize(),
            url : baseUrl + '/fakturpembelian/adinott',
            dataType:'json',
            success : function(data){
            	$('.supplier_tt').val(data.sup.nama);
            	$('.notandaterima').val(data.nota);
            	$('.jatuhtempo_tt').val(jatuh_tempo);
            	$('.totalterima_tt').val(total_jml);

            }
        })
    })

$('.simpan_penerus').click(function(){
 	agen = $('.vendor1 ').val();
 	cabang = $('.cabang').val();
 	// console.log(agen);

	if (agen == 'AGEN') {
      	ven = $('.nama-kontak-agen1').val();
      }else{
      	ven = $('.nama-kontak-vendor1').val();
      }
      // console.log(ven);
	$.ajax({    
            type :"get",
            data : $('.tabel_tt :input').serialize()+'&'+'agen='+ven+'&'+$('.head1 .nofaktur').serialize()+'&cabang='+cabang,
            url : baseUrl + '/fakturpembelian/simpan_tt1',
            dataType:'json',
            success : function(data){
            	toastr.success('Form Tanda terima berhasil disimpan');
            	$('.save_biaya').removeClass('disabled');
            }
        })
})
</script>
