<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
<link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<style type="text/css">
	.wrapper {
		width: 1000px;
		margin: 10px 10px 10px 10px;
	}

	.inlineTable {
		display: inline-block;
	}

	.textright {
		text-align: right;
		padding-right: 5px;
	}

	.textleft {
		text-align: left;
		text-indent: 5px;
	}

	.hiddenborderleft {
		border-left: 0px;
	}

	.hiddenborderright {
		border-right: 0px;
	}

	.hiddenbordertop {
		border-top: 0px;
	}

	.hiddenborderbottom {
		border-bottom: 0px;
	}
	.bold{
		font-weight: bold;
	}
</style>

<body>
	<div class="wrapper">
		<table class="inlineTable">
			<tr>
				<td>
					<img style="margin-right: 100px;" width="100" height="50" src="/jpm/perwita/img/logo_jpm.png">
				</td>
				<td>
					{{--  <img style="margin-right: 100px;" src="/jpm/perwita/img/logo_jpm.png" width="50" height="50">  --}}
				</td>
			</tr>
		</table>
		<table class="inlineTable">
			<tr>
				<td>
					{{--  <img style="margin-right: 100px;" src="/jpm/perwita/img/logo_jpm.png" width="60" height="20">  --}}
				</td>
			</tr>
			<tr>
				{{--  <td>412121</td>  --}}
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
		</table>
		<table class="inlineTable pull-right">
			<tr>
				<td style="width: 170px;">Asal/Origin</td>
				<td >Tujuan/Destination</td>
			</tr>
			<tr>
				<td class="bold">{{$nota->asal}}</td>
				<td class="bold">{{$nota->tujuan}}</td>
			</tr>
		</table>
		<table class="inlineTable">
			<tr>
				<td style="width: 170px;">Branch/Code :</td>
				<td style="width: 170px;">No.Account :</td>
				<td>No.POD/AWB : {{$nota->nomor}}</td>
			</tr>
		</table>
		
		<div style="position: relative;">
			<table>
				<tr>
					<td>Pengirim / Sender :</td>
				</tr>
				<tr>
					<td>{{$nota->nama_pengirim}}</td>
				</tr>
				<tr>
					<td>Alamat / Address :</td>
				</tr>
				<tr>
					<td>{{$nota->alamat_pengirim}}</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>Phone / Fax : {{$nota->telpon_pengirim}}</td>
				</tr>
				<tr>
					<td>Penerima / Receiver / Company Name :</td>
				</tr>
				<tr>
					<td>{{$nota->nama_penerima}}</td>
				</tr>
				<tr>
					<td>Alamat / Address :</td>
				</tr>
				<tr>
					<td>{{$nota->alamat_penerima}}</td>
				</tr>
				<tr>
					<td>Phone / Fax : {{$nota->telpon_penerima}}</td>
				</tr>
				
			</table>
			<table>
				<tr>
					<td>&nbsp;</td>
				</tr>
			</table>
			<div class="pull-right" style="margin-top: -26%; padding-right:100px; padding-top:40px ">
				<table>
					<tr>
						<td>&nbsp</td>
						<td>&nbsp</td>
					</tr>
					<tr>
						<td >Colly :3</td>
						<td >Kg: 70</td>
					</tr>
					<tr>
						<td colspan="3">Jenis Kiriman / Type of Shipment</td>
					</tr>
					<tr>
						<td>{{$nota->type_kiriman}}</td>
					</tr>
					<tr>
						<td colspan="3">Jenis Pembayaran / Type of Payment</td>
					</tr>
					<tr>
						<td>{{$nota->jenis_pembayaran}}&nbsp</td>
					</tr>
					<tr>
						<td style="width: 120px;">Layanan / Service</td>
						<td>Harga / Charge</td>
					</tr>
					
					<tr>
						<td>Total</td>
						<td class="bold">{{ number_format($nota->total, 0, ",", ".") }}</td>
					</tr>
					<tr >
						<td colspan="3">Keterangan Khusus:</td>
					</tr>
					<tr>
						<td>{{$nota->instruksi}}&nbsp</td>
					</tr>
				</table>
			</div>
		</div>

		<div>
			<table width="100%">
				<tr>
					<td>Dimension / Volume :</td>
					<td>Diterima Oleh/Received</td>
					<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
					<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
					<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
				</tr>
				<tr>
					<td>70</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>

				<tr>
					<td>
						<table>
							<tr>
								<td>Tgl / Date</td>
								<td width="100">Waktu / Time</td>
								<td>Ttd / Signature</td>
							</tr>
							<tr>
								<td width="100">{{$nota->tanggal}}</td>
								<td>&nbsp</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
					<td>&nbsp</td>
					<td>&nbsp</td>
					<td>&nbsp</td>
				</tr>
			</table>
		</div>
		<p style="margin-left: 35%;margin-top: -15px;">
			Signature/ Ttd, Nama, Stempel
		</p>


	</div>
</body>

</html>