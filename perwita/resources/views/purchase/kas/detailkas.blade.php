<style type="text/css">
	.img{
		width: 130px;
		height: 72px;
		background: url({{ asset('assets/img/dboard/logo/logo_jpm.png') }}) no-repeat;
		
		
	}
</style>
<div style="margin:0 10;">
	<table style="border-collapse: collapse;">
	<td width="900">
		<div class="img" style="display: inline-block;  float: left; "> </div>
		<div style="display: inline-block; margin-right: 50%;">
			<h3 style="margin-top: 0; margin-bottom:2 ;text-align: center;">Detail Biaya Penerus</h3>
			<h3 style="margin-top: 0; margin-bottom:2 ;text-align: center;">PT. Jawa Pratama Mandiri</h3>
			<h5 style="margin-top: 0; margin-bottom:2;text-align: center;">Cabang : {{$cari[0]->nama}}</h5>
		</div>
	</td>
	</table>

	<table style="border-collapse: collapse;">
	<tr>
		<th align="left" style="font-size: 11px; width: 220px;">
			<div style="padding-top: 2px;">No. Bbm&nbsp;:&nbsp;{{$cari[0]->bpk_nota}}	</div>
		</th>
		<th align="left" style="font-size: 11px; width: 120px;">
		Pembiayaan&nbsp;:&nbsp;{{$cari[0]->bpk_jenis_biaya}}
		</th>
		<th align="left" style="font-size: 11px; width: 100px;">
		Nopol&nbsp;:&nbsp;{{$cari[0]->bpk_nopol}}
		</th>
		<th align="left" style="font-size: 11px; width: 170px;">
		Nama Sopir&nbsp;:&nbsp;{{$cari[0]->bpk_sopir}}
		</th>
		<th align="right" style="font-size: 11px; width: 55px;">
		KM&nbsp;:&nbsp;{{$cari[0]->bpk_jarak}}
		</th>
	</tr>
	<tr>
		<td colspan="3" align="left" style="font-size: 11px;">
			<div style="padding-top: 2px;"><b>Note&nbsp;:&nbsp;{{$cari[0]->bpk_keterangan}}	</div>
		</td>
		<th colspan="2" align="right" style="font-size: 11px; ">
		BBM&nbsp;:&nbsp;{{"Rp " . number_format($cari[0]->bpk_harga_bbm,2,",",".")}}
		</th>
	</tr>
	<tr>
		<td colspan="3" align="left" style="font-size: 11px; ">
			<div style="padding-top: 2px;"><b>Tanggal&nbsp;:&nbsp;{{$tgl}}	</div>
		</td>
		<th colspan="2" align="right" style="font-size: 11px; ">
		BBM & Tol&nbsp;:&nbsp;{{"Rp " . number_format($cari[0]->bpk_biaya_lain,2,",",".")}}
		</th>
	</tr>
	</table>
	<table border="1" style="border-collapse: collapse;">
		<thead align="center" style="font-size: 12px;">
			<tr>
			<th>No</th>
			<th>Tgl.Order</th>
			<th width="100">Kota Asal</th>
			<th width="75">Nama Pengirim</th>
			<th>Kota Tujuan</th>
			<th>Nama Penerima</th>
			<th width="60">Tarif</th>
			<th width="60">Biaya Penerus</th>
			</tr>
		</thead>
		<tbody >
			@foreach($cari_dt as $i=>$val)
			<tr style="font-size: 11px">
			<td align="center">{{$i+1}}</td>	
			<td><?php echo date('d/m/Y',strtotime($val->bpkd_tanggal)) ?></td>
			<td>{{$val->nama}}</td>
			<td>{{$val->bpkd_pengirim}}</td>
			<td>{{$tujuan[$i]->nama}}</td>
			<td>{{$val->bpkd_penerima}}</td>
			<td align="right" style="min-width: 100px;"> {{"Rp " . number_format($val->bpkd_tarif,2,",",".")}}</td>
			<td align="right" style="min-width: 40px;">{{"" . number_format($val->bpkd_tarif_penerus,2,",",".")}}</td>
			</tr>
			@endforeach
			<tr>
			<td align="right" colspan="6">Total :</td>
			<td align="right" style="font-size: 12px;">{{"Rp " . number_format($cari[0]->bpk_total_tarif,2,",",".")}}</td>
			<td style="font-size: 12px;" align="right">{{"Rp " . number_format($total_harga,2,",",".")}}</td>
			</tr>
			<tr>
				<td align="center" colspan="4">Driver :</td>
				<td align="center" colspan="4">Mengetahui :</td>
			</tr>
			<tr>
				<td align="center" colspan="4" height="75"></td>
				<td align="center" colspan="4" height="75"></td>
			</tr>
		</tbody>
	</table>
</div>
