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

			    #table-data{
					font-size: 8pt;
					margin-top: 10px;
					border: 1px solid #555;
			    }
			    #table-data th{
			    	text-align: center;
			    	border: 1px solid #aaa;
			    	border-collapse: collapse;
			    	background: #ccc;
			    }

			    #table-data td{
			    	border-right: 1px solid #555;
			    }

			    #table-data td.currency{
			    	text-align: right;
			    	padding-right: 5px;
			    }

			    #table-data td.no-border{
			    	border: 0px;
			    }

			    #table-data td.total{
			    	background: #ccc;
			    	padding: 5px;
			    	font-weight: bold;
			    }

			    #table-data td.total.not-same{
		    		 color: red !important;
		    		 -webkit-print-color-adjust: exact;
		    	}

		    	#form-table{
		    		background: none;
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

		    	#table-data td.total{
		    		 background-color: #ccc !important;
		    		 -webkit-print-color-adjust: exact;
		    	}

		    	#table-data td.total.not-same{
		    		 color: red !important;
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
								<select class="form-control" name="jenis" id="jenis" required>
			                      <option value="kas">Jurnal Kas</option>
			                      <option value="bank">Jurnal Bank</option>
			                      <option value="memorial">Jurnal Memorial</option>
			                    </select>
							</td>

							<td width="20%">
								<select class="form-control" name="nama_perkiraan" id="nama_perkiraan">
			                      <option value="1">Dengan Nama Perkiraan</option>
			                      <option value="0">Tidak Dengan Nama Perkiraan</option>
			                    </select>
							</td>

							<td width="20%">
								<input type="text" class="form-control tanggal_register register_validate" name="tanggal" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly value="{{$request->tanggal}}">
							</td>

							<td>
								<small class="text-muted">s/d</small>
							</td>

							<td width="20%">
								<input type="text" class="form-control sampai_register register_validate" name="sampai" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly required value="{{$request->sampai}}">
							</td>

							<td width="9%" style="border-right: 1px solid #999;">
								<button class="btn btn-primary btn-block" id="save_register">
									<i class="fa fa-check-circle"></i> &nbsp;Submit
								</button>
							</td>

							<td width="9%">
								<button class="btn btn-success btn-block" id="print">
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
							<th style="text-align: left;">Laporan Register Jurnal {{ ucfirst($request->jenis) }}</th>
							<th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
						</tr>
					</thead>
				</table>

				<table width="100%" border="0" style="font-size: 8pt;">
					<thead>
						<tr>
							<td style="text-align: left;">Bulan Transaksi : {{ date("d/m/Y", strtotime($d1)) }} s/d {{ date("d/m/Y", strtotime($d2)) }}</td>
							<td style="text-align: right;"></td>
						</tr>
					</thead>
				</table>

				<table id="table-data" width="100%" border="0">
					<thead>
						<tr>
							<th width="8%">Tanggal</th>
							<th width="12%">No.Bukti</th>
							<th width="8%">No.Perkiraan</th>

							@if($request->nama_perkiraan)
								<th width="25%">Nama Perkiraan</th>
							@endif
							<th>Uraian</th>

							<th width="11%">Debet</th>
							<th width="11%">Kredit</th>
						</tr>
					</thead>

					<tbody>
						
						<?php $sum_debet = $sum_kredit = 0; ?>
						@foreach($data as $data_jr)
							<?php $tot_debet = $tot_kredit = 0; ?>
							@foreach($detail[$data_jr->jr_id] as $data_detail)
								<tr>
									<td style="padding-left: 3px;">{{ date('d-m-Y', strtotime($data_jr->jr_date)) }}</td>
									<td style="padding-left: 3px;">{{ $data_jr->jr_ref }}</td>
									<td style="padding-left: 3px;">{{ $data_detail->jrdt_acc }}</td>

									@if($request->nama_perkiraan)
										<td style="padding-left: 3px;">{{ $data_detail->nama_akun }}</td>
									@endif

									<td style="padding-left: 3px;">{{ $data_jr->jr_note }}</td>
									
									<?php 
										$deb = $kre = 0;
										if($data_detail->jrdt_statusdk == "D") {
											$deb = str_replace("-", "", $data_detail->jrdt_value);
											$tot_debet += $deb;
											$sum_debet += $deb;
										}else{
											$kre = str_replace("-", "", $data_detail->jrdt_value);
											$tot_kredit += $kre;
											$sum_kredit += $kre;
										}
									?>

									<td class="currency">{{ number_format($deb, 2) }}</td>
									<td class="currency no-border">{{ number_format($kre, 2) }}</td>
								</tr>
							@endforeach

							<tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>

								@if($request->nama_perkiraan)
									<td>&nbsp;</td>
								@endif

								<?php
									$not = "";

									if($tot_debet != $tot_kredit)
										$not = "not-same"
								?>

								<td>&nbsp;</td>
								<td class="currency total {{$not}}">{{ number_format($tot_debet, 2) }}</td>
								<td class="currency total no-border {{$not}}">{{ number_format($tot_kredit, 2) }}</td>
							</tr>

						@endforeach
						
					</tbody>
				</table>

				<table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
					<thead>
						<tr>
							<th width="8%"></th>
							<th width="12%"></th>
							<th width="8%"></th>

							@if($request->nama_perkiraan)
								<th width="25%"></th>
							@endif
							<th></th>

							<th width="11%" style="text-align: right; padding: 7px 5px; border: 1px solid #555;">{{ number_format($sum_debet, 2) }}</th>
							<th width="11%" style="text-align: right; padding: 7px 5px; border: 1px solid #555;">{{ number_format($sum_kredit, 2) }}</th>
						</tr>
					</thead>
				</table>

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
					$('.sampai_register').datepicker();

				    $('.tanggal_register').datepicker().on("changeDate", function(){
				        $('.sampai_register').val("");
				        $('.sampai_register').datepicker("setStartDate", $(this).val());
				    });

				    $("#jenis").val('{{$request->jenis}}');
				    $("#nama_perkiraan").val('{{$request->nama_perkiraan}}');
				    $('.sampai_register').datepicker("setStartDate", $('.tanggal_register').val());

				    $('#save_register').click(function(event){
				      event.preventDefault();

				      if(validate_form_register()){
				        $("#form-register-jurnal").submit();
				      }
				      
				    })

					$('#print').click(function(evt){
						evt.preventDefault();

						window.print();
					})

					function validate_form_register(){
				        a = true;
				        $(".register_validate").each(function(i, e){
				          if($(this).val() == "" && $(this).is(":visible")){
				            a = false;
				            $(this).focus();
				            toastr.warning('Harap Lengkapi Data Diatas');
				            return false;
				          }
				        })

				        $(".register_validate_select").each(function(i, e){
				          if($(this).val() == "---"){
				            a = false;
				            $(this).focus();
				            toastr.warning('Harap Lengkapi Data Diatas');
				            return false;
				          }
				        })

				        return a;
				      }
				})
			</script>
		</body>
	</html>