
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
 		<input type="text" name="jatuh_tempo" class="form-control jatuh_tempo" value="" placeholder="Jatuh tempo" style="width: 250px;">
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
 			<option value="AGEN">Agen</option>
 			<option value="VENDOR">Vendor</option>
 		</select>
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
 	<td width="200">
 		<select name="nama_kontak1" class="form-control nama-kontak-agen1 chosen-select-width1" style="text-align: center; width: 250px;">
 			@foreach($agen as $val)
 			<option value="{{$val->kode}}">{{$val->nama}}</option>
 			@endforeach
 		</select>
 	</td>
 </tr>
 <!-- NAMA KONTAK VENDOR -->
  <tr hidden="" class="nama-kontak-vendor">
 	<td style="width: 100px">Nama Kontak </td>
 	<td width="10">:</td>
 	<td width="200">
 		<select name="nama_kontak2" class="form-control nama-kontak-vendor1 chosen-select-width1" style="text-align: center; width: 250px;">
 			@foreach($vendor as $val)
 			<option value="{{$val->kode}}">{{$val->nama}}</option>
 			@endforeach
 		</select>
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
		<td style="width: 100px">Nominal</td>
		<td width="10">:</td>
		<td width="200">
			<input type="text" name="nominal" class="form-control nominal" onkeyup="hitung()" style="width: 250px;">
			<input type="hidden" class="form-control total_pod" style="width: 250px;">
		</td>
	  </tr>
     </table>
     <button type="button" class="btn btn-primary pull-right cari-pod" onclick="cariPOD();"><i class="fa fa-search">&nbsp;Append</i></button>
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
				<th>Jumlah Bayar</th>
				<th>Tipe Debet</th>
				<th>Keterangan</th>
				<th width="50">Aksi</th>
				</tr>
			</thead> 
			<tbody align="center" class="body-biaya">

			</tbody>   	
	    </table>
	    <button type="button" class="btn btn-primary pull-right" id="save-update" onclick="save_biaya()" data-dismiss="modal">Simpan Data</button>
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
	var isi =  $('.nama_akun').val();
  	$('.kode_akun').val(isi);
});
    


 $('.nominal').keypress(function(e){

    if ((e.which && e.which == 13) || (e.keyCode && e.keyCode == 13)) {
        $('.cari-pod').click();
        return false;
     }
 })

</script>
