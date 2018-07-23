<!DOCTYPE html>
	<html>
		<head>
			<title></title>


		    <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		    <!-- Font Awesome -->
		    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">


		    <!-- datepicker -->
		    <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
		    <link href="{{ asset('assets/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

		    <!-- Toastr style -->
		    <link href="{{ asset('assets/vendors/toastr/toastr.min.css')}}" rel="stylesheet">

			<style>

				@page { margin: 10px; }
				body { margin: 10px; }

			    .page_break { page-break-before: always; }

			    .page-number:after { content: counter(page); }

			    .table-saldo{
			    	background: #37474F;
			    	margin-top: 15px;
			    }

			   .table-saldo td{
			   		text-align: right;
			   		font-weight: 400;
			   		font-style: italic;
			   		padding: 7px 20px 7px 0px;
			   		border-top: 1px solid #efefef;
			    	font-size: 9pt;
			    	color: white;
			   }

			    .table_neraca{
			    	font-size: 0.8em;
			    	border-bottom: 2px solid #efefef;
			    	margin-top: 5px;
			    	border: 1px solid #555;
			    }

			    .table_neraca th{
			    	text-align: center;
			    	border: 1px solid #aaa;
			    	border-collapse: collapse;
			    	background: #ccc;
			    	padding: 5px 0px;
			    }

			    .table_neraca td{
			    	border-right: 1px solid #555;
			    	padding: 2px 0px;
			    }

			    .table_total{
			    	font-size: 0.8em;
			    	margin-top: 5px;
			    }

			    .table_total th.typed{
			    	text-align: right;
			    	border: 1px solid #aaa;
			    	border-collapse: collapse;
			    	background: #ccc;
			    	padding: 5px 0px;
			    	padding-right: 3px;
			    }

			    .table-info{
			    	margin-bottom: 45px;
			    	font-size: 7pt;
			    	margin-top: 5px;
			    }

		    	#form-table td{
		    		padding: 5px;
		    	}

		    	#form-table td select, #form-table td input, #form-table td button{
		    		border-radius: 0px;
		    		font-size: 0.8em;
		    	}

			</style>

			<style type="text/css" media="print">
			  @page { size: landscape; }
			  #navigation{
		    		display: none;
		    	}

		    	.table_neraca th{
		    		 background-color: #ccc !important;
		    		 -webkit-print-color-adjust: exact;
		    	}

		    	.table_total th.typed{
		    		 background-color: #ccc !important;
		    		 -webkit-print-color-adjust: exact;
		    	}

		    	.table-saldo td{
		    		 background: #37474F !important;
		    		 color: #fff !important;
		    		 -webkit-print-color-adjust: exact;
		    	}

		    	.page-break	{ display: block; page-break-before: always; }
			</style>

		</head>

		<body style="background: #555;">

			<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px;" id="navigation">
				<form role="form" id="form-register-jurnal" method="POST" action="{{ route("register_jurnal.index_single") }}" target="_self">
				<input type="hidden" value="{{ csrf_token() }}" name="_token" readonly>
				<table id="form-table" border="0" width="100%">
					<tbody>
						<tr>
							<td width="20%">
								{{-- <select class="form-control buku_besar select_validate" name="jenis" id="periode_buku_besar">
			                      <option value="Bulan">Bulanan</option>
			                      <option value="Tahun">Tahunan</option>
			                    </select> --}}
							</td>

							<td width="15%">
								{{-- <input type="text" class="form-control tanggal_register register_validate" name="tanggal" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly value="{{$request->tanggal}}"> --}}
							</td>

							<td>
								{{-- <small class="text-muted">s/d</small> --}}
							</td>

							<td width="15%">
								{{-- <input type="text" class="form-control sampai_register register_validate" name="sampai" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly required value="{{$request->sampai}}"> --}}
							</td>

							<td width="30%">
								{{-- <select class="form-control buku_besar select_bukbes_validate" name="buku_besar_cabang" id="buku_besar_cabang"> --}}

                    			{{-- </select> --}}
							</td>


							<td width="9%" style="border-right: 1px solid #999;">
								{{-- <button class="btn btn-primary btn-block" id="save_register" style="padding: 10px;"> --}}
									{{-- <i class="fa fa-check-circle"></i> &nbsp;Submit --}}
								{{-- </button> --}}
							</td>

							<td width="9%">
								<button class="btn btn-success btn-block" id="print" style="padding: 10px;">
									<i class="fa fa-print"></i> &nbsp;Print
								</button>
							</td>
						</tr>
					</tbody>
				</table>
				</form>
			</div>

			<div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 20px;">
	
				<table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
					<thead>
						<tr>
							<th style="text-align: left;">Laporan Buku Besar </th>
							<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
						</tr>
					</thead>
				</table>

				<table width="100%" border="0" style="font-size: 8pt;">
					<thead>
						<tr>
							<td style="text-align: left;">Periode Transaksi : {{ $b1 }} s/d {{ $b2 }}</td>
							<td style="text-align: right;"></td>
						</tr>
					</thead>
				</table>

				<?php $urt = 0; ?>

				@foreach($time as $data_time)
				 @foreach($data as $data_akun)

				    <?php 
				    	$mt = ($urt == 0) ? "m-t" : "m-t-lg"; $saldo = $saldo_awal[$data_time->time."/".$data_akun->akun]; 
						$tot_deb = $tot_kred = 0;
				    ?>

				     <table width="100%" border="0" class="table-saldo">
						<thead>
							<tr>
								<td>Nama Perkiraan : {{ $data_akun->akun }} - {{ $data_akun->main_name }}</td>
							</tr>
						</thead>
					</table>

					<table class="table_neraca tree" border="0" width="100%">
						<thead>
							<tr>
								<th width="10%">Tanggal</th>
						        <th width="14%">No.Bukti</th>
						        <th width="37%">Keterangan</th>
						        <th width="13%">Debet</th>
						        <th width="13%">Kredit</th>
						        <th width="13%">Saldo</th>
							</tr>
						</thead>

						<tbody>

							<tr>
				              <td></td>
				              <td></td>
				              <td style="padding-left: 50px;">Saldo Awal</td>
				              <td style="padding-left: 3px;" class="money"></td>
				              <td style="padding-left: 3px;" class="money"></td>
				              <td style="padding-right: 3px;" class="money text-right">{{ number_format($saldo, 2) }}</td>
				            </tr>

							@foreach($grap as $data_grap)
				              @if($data_grap->acc == $data_akun->akun)

				                <?php
				                  if($throttle == "Bulan")
				                    $cek = date("n-Y", strtotime($data_grap->jr_date)) == $data_time->time;
				                  else
				                    $cek = date("Y", strtotime($data_grap->jr_date)) == $data_time->time;
				                ?>

				                @if($data_grap->acc == $data_akun->akun && $cek)

				                  <?php 
				                    $debet = $kredit = 0;

				                    $saldo += $data_grap->jrdt_value;

				                    if($data_grap->jrdt_statusdk == "D"){
				                      $debet = str_replace("-", "", $data_grap->jrdt_value);
				                      $tot_deb += $debet;
				                    }
				                    else{
				                      $kredit = str_replace("-", "", $data_grap->jrdt_value);
				                      $tot_kred += $kredit;
				                    }

				                  ?>

				                  <tr>
				                    <td style="padding-left: 3px;">{{ date("d-m-Y", strtotime($data_grap->jr_date)) }}</td>
				                    <td style="padding-left: 3px;">{{ $data_grap->jr_ref }}</td>
				                    <td style="padding-left: 3px;">{{ $data_grap->jr_note }}</td>
				                    <td class="money text-right" style="padding-right: 3px;">{{ number_format($debet, 2) }}</td>
				                    <td class="money text-right" style="padding-right: 3px;">{{ number_format($kredit, 2) }}</td>
				                    <td class="money text-right" style="padding-right: 3px;">{{ number_format($saldo, 2) }}</td>
				                  </tr>
				                @endif
							  @endif
							@endforeach
						</tbody>
					</table>

					<table class="table_total tree" border="0" width="100%">
						<thead>
							<tr>
								<th width="10%"></th>
						        <th width="14%"></th>
						        <th width="37%"></th>
						        <th class="typed" width="13%">{{ number_format($tot_deb, 2) }}</th>
						        <th class="typed" width="13%">{{ number_format($tot_kred, 2) }}</th>
						        <th class="typed" width="13%">{{ number_format($saldo, 2) }}</th>
							</tr>
						</thead>
					</table>

					<table width="100%" border="0" class="table-info">
						<thead>
							<tr>
								@if($throttle == "Bulan")
									<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Bulan {{ date_ind(explode('-', $data_time->time)[0]) }} {{ explode('-', $data_time->time)[1] }}</td>
								@elseif($throttle == "Tahun")
									<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Tahun {{ $request->y }}</td>
								@endif
							</tr>
						</thead>
					</table>

					<div style="page-break-before: always;"></div>
				  @endforeach
				@endforeach

			</div>

			<script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>
			<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>

		    <!-- datepicker  --> 
		    <script src="{{ asset('assets/vendors/daterangepicker/moment.min.js') }}"></script>
		    <script src="{{ asset('assets/vendors/datapicker/bootstrap-datepicker.js') }}"></script>
		    <script src="{{ asset('assets/vendors/daterangepicker/daterangepicker.js') }}"></script>

		    <!-- Toastr -->
		    <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>

			<script type="text/javascript">
				$(document).ready(function(){
					

					$('#print').click(function(evt){
						evt.preventDefault();

						window.print();
					})

					
				})
			</script>
		</body>
	</html>