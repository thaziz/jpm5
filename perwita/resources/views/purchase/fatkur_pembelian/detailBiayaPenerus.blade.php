<div style="width: 100%" >
 <div style="float: left">
	<img style="padding-left: 10px;padding-top: 10px; position: absolute; display: inline-block; width: 150px" src="{{ asset('assets/img/dboard/logo/logo_jpm.png') }}">
 </div>
 <div style="margin-left: 5%">
	<h4 style="text-align: center;">
		LAPORAN AGEN/VENDOR
		<br>
		<br>
		PT. JAWA PRATAMA MANDIRI
	</h4>
 </div>
</div>


 <div style="width: 100%;"> 
 	<h5>Nama AGEN/VENDOR : {{$cari_fp[0]->nama}}</h5>
 	<h5>No Faktur : {{$cari_fp[0]->fp_nofaktur}}</h5>
 	<table border="1" style="border-collapse: collapse; font-size: 9px">
 		<thead align="center">
 			<tr>
 			<th>No</th>
 			<th>No.Order</th>
 			<th>Tgl.Explain</th>
 			<th>Customer</th>
 			<th>Penerima</th>
 			<th>Asal</th>
 			<th>Tujuan</th>
 			<th>Type</th>
 			<th>Status</th>
 			<th>Tarif</th>
 			<th>Biaya Handling</th>
 			</tr>
 		</thead>
 		<tbody>
 			@foreach($cari_bpd as $i=>$val)
 			@if($cari_fp[0]->fp_jenisbayar == 6)
 			<tr>
 				<td align="center">{{$i+1}}</td>
 				<td>{{$val->nomor}}</td>
 				<td>{{$val->bpd_tgl}}</td>
 				<td>{{$val->nama_pengirim}}</td>
 				<td>{{$val->nama_penerima}}</td>
 				<td>{{$val->nama}}</td>
 				<td>{{$kota_tujuan[$i]->nama}}</td>
 				<td>{{$val->type_kiriman}}</td>
 				<td>{{$val->status}}</td>
 				<td align="right">{{"Rp " . number_format($val->bpd_tarif_resi,2,",",".")}}</td>
 				<td align="right">{{"Rp " . number_format($val->bpd_nominal,2,",",".")}}</td>
 			</tr>
 			@elseif($cari_fp[0]->fp_jenisbayar == 7)
 			<tr>
 				<td align="center">{{$i+1}}</td>
 				<td>{{$val->nomor}}</td>
 				<td>{{$val->potd_tgl}}</td>
 				<td>{{$val->nama_pengirim}}</td>
 				<td>{{$val->nama_penerima}}</td>
 				<td>{{$val->nama}}</td>
 				<td>{{$kota_tujuan[$i]->nama}}</td>
 				<td>{{$val->type_kiriman}}</td>
 				<td>{{$val->status}}</td>
 				<td align="right">{{"Rp " . number_format($val->potd_komisi_total,2,",",".")}}</td>
 				<td align="right">{{"Rp " . number_format($val->potd_tarif_resi,2,",",".")}}</td>
 			</tr>
 			@elseif($cari_fp[0]->fp_jenisbayar == 9)
 			<tr>
 				<td align="center">{{$i+1}}</td>
 				<td>{{$val->nomor}}</td>
 				<td>{{$cari_fp[0]->fp_tgl}}</td>
 				<td>{{$val->nama_pengirim}}</td>
 				<td>{{$val->nama_penerima}}</td>
 				<td>{{$val->nama}}</td>
 				<td>{{$kota_tujuan[$i]->nama}}</td>
 				<td>{{$val->type_kiriman}}</td>
 				<td>{{$val->status}}</td>
 				<td align="right">{{"Rp " . number_format($val->pbd_tarif_resi,2,",",".")}}</td>
 				<td align="right">{{"Rp " . number_format($cari_fp[0]->fp_netto,2,",",".")}}</td>
 			</tr>
 			@endif
 			@endforeach
 			<tr>
 				<td colspan="10" align="right">Total : </td>
 				<td>{{"Rp " . number_format($cari_fp[0]->fp_netto,2,",",".")}}</td>
 			</tr>
 		</tbody>
 	</table>
 </div>

