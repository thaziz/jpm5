<!DOCTYPE html>
  <html>
    <head>
      <title>laporan Register Jurnal</title>


        <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">


        <!-- datepicker -->
        <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <link href="{{ asset('assets/vendors/toastr/toastr.min.css')}}" rel="stylesheet">

        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

      <style>

        @page { margin: 10px; }

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
		    	padding: 5px;
		    }

		    #table-data td{
		    	border-right: 1px solid #555;
		    	padding: 5px;
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

          #navigation ul{
            float: right;
            padding-right: 110px;
          }

          #navigation ul li{
            color: #fff;
            font-size: 15pt;
            list-style-type: none;
            display: inline-block;
            margin-left: 40px;
          }

           #form-table{
              font-size: 8pt;
            }

            #form-table td{
              padding: 5px 0px;
            }

            #form-table .form-control{
              height: 30px;
              width: 90%;
              font-size: 8pt;
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

    	#table-data td.not-same{
    		 color: red !important;
    		 -webkit-print-color-adjust: exact;
    	}

        .page-break { display: block; page-break-before: always; }
      </style>

    </head>

    <body style="background: #555;">

      <div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444;">
        <div class="row">
          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
            PT Jawa Pratama Mandiri
          </div>
          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
            <ul>
              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_register_jurnal').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 20px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Register Jurnal  </th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 12pt; font-weight: 500">PT Jawa Pratama Mandiri</th>
            </tr>

            <tr>
              <th style="text-align: left; font-size: 8pt; font-weight: 500; padding-bottom: 10px;">(Angka Disajikan Dalam Rupiah, Kecuali Dinyatakan Lain)</th>
            </tr>
          </thead>
        </table>

        <table width="100%" border="0" style="font-size: 8pt;">
          <thead>
            <tr>
              <td style="text-align: left; padding-top: 5px;">
                Transaksi : Bulan {{ date("d", strtotime($d1)) }} {{ date_ind(date("m", strtotime($d1))) }} {{ date("Y", strtotime($d1)) }} s/d {{ date("d", strtotime($d2)) }} {{ date_ind(date("m", strtotime($d2))) }} {{ date("Y", strtotime($d2)) }}
              </td>
              
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

					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;">{{ number_format($sum_debet, 2) }}</th>
					<th width="11%" style="text-align: right; padding: 7px 5px; border-bottom: 1px solid #999;">{{ number_format($sum_kredit, 2) }}</th>
				</tr>
			</thead>
		</table>

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

      </div>

      <!-- modal -->
	<div id="modal_register_jurnal" class="modal">
	  <div class="modal-dialog" style="width: 30%;">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Setting Register Jurnal</h4>
	        <input type="hidden" class="parrent"/>
	      </div>

	      <div class="modal-body" style="padding: 10px;">
	        <div class="row">
	          <form role="form" class="form-inline" id="form-register-jurnal" method="POST" action="{{ route("register_jurnal.index_single") }}" target="_self">
	            <input type="hidden" value="{{ csrf_token() }}" name="_token" readonly>
	              <table border="0" id="form-table" class="col-md-12">

	                <tr>
	                  <td width="40%" class="text-center">Pilih Jenis Laporan</td>
	                  <td colspan="3">
	                    <select class="form-control" name="jenis" id="jenis" style="width: 95%;" required>
	                      <option value="kas">Jurnal Kas</option>
	                      <option value="bank">Jurnal Bank</option>
	                      <option value="memorial">Jurnal Memorial</option>
	                    </select>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="20%" class="text-center">Masukkan Tanggal</td>
	                  <td width="25%">
	                    <input type="text" class="form-control tanggal_register register_validate" name="tanggal" placeholder="MM/YYYY" style="width: 100%; cursor: pointer; background: white;" readonly>
	                  <td class="text-center" style="font-size: 8pt;" required>
	                    s/d
	                  </td>
	                  <td width="25%">
	                    <input type="text" class="form-control sampai_register register_validate" name="sampai" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly required>
	                  </td>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="40%" class="text-center">Dengan Nama Perkiraan</td>
	                  <td colspan="3">
	                    <select class="form-control" name="nama_perkiraan" id="jenis" style="width: 30%;">
	                      <option value="1">Ya</option>
	                      <option value="0">Tidak</option>
	                    </select>
	                  </td>
	                </tr>

	              </table>
	          </form>
	        </div>
	      </div>

	      <div class="modal-footer">
	          <button class="btn btn-primary btn-sm" id="save_register" >Proses</button>
	      </div>
	    </div>
	  </div>
	</div>
	  <!-- modal -->

      <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>

      <!-- datepicker  --> 
      <script src="{{ asset('assets/vendors/daterangepicker/moment.min.js') }}"></script>
      <script src="{{ asset('assets/vendors/datapicker/bootstrap-datepicker.js') }}"></script>
      <script src="{{ asset('assets/vendors/daterangepicker/daterangepicker.js') }}"></script>

      <!-- Toastr -->
      <script src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>

      <script type="text/javascript">
        $(document).ready(function(){

          $('[data-toggle="tooltip"]').tooltip({container : 'body'});

          baseUrl = '{{ url('/') }}';

        $('.periode_year').datepicker( {
	        format: "yyyy",
	        viewMode: "years", 
	        minViewMode: "years"
	    });

	    $('.periode_month').datepicker( {
	        format: "mm",
	        viewMode: "months", 
	        minViewMode: "months"
	    });

	    $('.sampai_register').datepicker()

	    $('.tanggal_register').datepicker().on("changeDate", function(){
	        $('.sampai_register').val("");
	        $('.sampai_register').datepicker("setStartDate", $(this).val());
	    });

	    $('#save_register').click(function(event){
	      event.preventDefault();

	      if(validate_form_register()){
	        $("#form-register-jurnal").submit();
	      }
	      
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


          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>