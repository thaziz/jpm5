<!DOCTYPE html>
  <html>
    <head>
      <title>Laporan Buku Besar</title>


        <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">


        <!-- datepicker -->
        <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <link href="{{ asset('assets/vendors/toastr/toastr.min.css')}}" rel="stylesheet">

        <script type="text/javascript" src="{{ asset('assets/plugins/jquery-1.12.3.min.js') }}"></script>

    	<link href="{{ asset('assets/css/chosen/chosen.css') }}" rel="stylesheet">

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
		    	vertical-align: top;
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

	    	.table-saldo{
		    	margin-top: 5px;
		    }

		   .table-saldo td{
		   		text-align: right;
		   		font-weight: 400;
		   		font-style: italic;
		   		padding: 7px 20px 7px 0px;
		   		border-top: 0px solid #efefef;
		    	font-size: 10pt;
		    	color: white;
		    	color: #555;
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

      <div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2;">
        <div class="row">
          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
            PT Jawa Pratama Mandiri
          </div>
          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
            <ul>
              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_buku_besar').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Buku Besar"></i></li>
              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Buku Besar  </th>
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
              	@if($throttle == 'Bulan')
                	Transaksi : Bulan {{ date_ind(explode('-', $b1)[0]).' '.explode('-', $b1)[1] }} &nbsp;s/d &nbsp;{{ date_ind(explode('-', $b2)[0]).' '.explode('-', $b2)[1] }}
                @else
                	Transaksi : Tahun {{ $request->y1 }} &nbsp;s/d &nbsp;{{ $request->y2 }}
                @endif
              </td>
              
            </tr>
          </thead>
        </table>

        <?php $urt = 0; ?>

		@foreach($data as $ledger)
		 	<?php 
		    	$mt = ($urt == 0) ? "m-t" : "m-t-lg"; $saldo = 0; 
				$tot_deb = $tot_kred = 0;
		    ?>

		     <table width="100%" border="0" class="table-saldo" style="margin-top: 10px;">
				<thead>
					<tr>
						<td style="font-weight: bold; text-align: center;border-top: 1px solid #ccc; padding-top: 10px; padding-bottom: 0px;">Nama Perkiraan : {{ $ledger->id_akun }} &nbsp; {{ $ledger->nama_akun }}</td>
					</tr>
				</thead>
			</table>

			<table id="table-data" class="table_neraca tree" border="0" width="100%">
				<thead>
					<tr>
						<th width="8%">Tanggal</th>
				        <th width="8%">No.Bukti</th>
				        <th width="25%">Keterangan</th>

				        @if($request->akun_lawan == 'true')
					        <th width="5%">Seq</th>
					        <th width="5%">D/K</th>
					        <th width="6%">Acc.Lawan</th>
					    @endif

				        <th width="10%">Debet</th>
				        <th width="10%">Kredit</th>
				        <th width="10%">Saldo</th>
					</tr>
				</thead>

				<tbody>

					<tr>
		              <td></td>
		              <td></td>
		              <td style="padding-left: 50px; font-weight: 600;">Saldo Awal</td>

		              @if($request->akun_lawan == 'true')
			              <td></td>
			              <td></td>
			              <td></td>
			          @endif

		              <td style="padding-left: 8px;" class="money"></td>
		              <td style="padding-left: 8px;" class="money"></td>
		              <td style="padding-right: 8px; font-weight: 600;" class="money text-right">
		              	{{ 
                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
                    	}}
		              </td>
		            </tr>

					@foreach($ledger->jurnal_detail as $jurnal)

						<?php 
		                    $debet = $kredit = 0;

		                    $saldo += $jurnal->jrdt_value;

		                    if($jurnal->jrdt_statusdk == "D"){
		                      $debet = str_replace("-", "", $jurnal->jrdt_value);
		                      $tot_deb += $debet;
		                    }
		                    else{
		                      $kredit = str_replace("-", "", $jurnal->jrdt_value);
		                      $tot_kred += $kredit;
		                    }

		                ?>

						<tr>
		                    <td style="padding-left: 5px;">{{ date("d-m-Y", strtotime($jurnal->d_jurnal->jr_date)) }}</td>
		                    <td style="padding-left: 5px;">{{ $jurnal->d_jurnal->jr_no }}</td>
		                    <td style="padding-left: 5px;">{{ $jurnal->d_jurnal->jr_note }}</td>

		                    @if($request->akun_lawan == 'true')
			                    <td style="padding-left: 5px;" class="text-center">001</td>
			                    <td style="padding-left: 5px;" class="text-center">{{ $jurnal->jrdt_statusdk }}</td>
			                    <td style="padding-left: 5px;" class="text-center">{{ $jurnal->jrdt_acc }}</td>
			                @endif

		                    <td class="money text-right" style="padding-right: 8px;">{{ number_format($debet,2) }}</td>
		                    <td class="money text-right" style="padding-right: 8px;">{{ number_format($kredit,2) }}</td>
		                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
		                    	{{ 
		                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
		                    	}}
		                    </td>
		                </tr>

		                @if($request->akun_lawan == 'true')
		                  	@foreach($jurnal->d_jurnal->detail as $key => $data_detail)
		                  		@if($data_detail->jrdt_acc != $jurnal->jrdt_acc)
			                  		<tr>
					                    <td style="padding-left: 5px;" class="text-center">&nbsp;</td>
					                    <td style="padding-left: 5px;" class="text-center">&nbsp;</td>
					                    <td style="padding-left: 5px;">{{ $jurnal->d_jurnal->jr_note }}</td>

					                    @if($request->akun_lawan == 'true')
						                    <td style="padding-left: 5px;" class="text-center">{{ str_pad(($key + 1), 3, "0",STR_PAD_LEFT) }}</td>
					                    	<td style="padding-left: 5px;" class="text-center">{{ $data_detail->jrdt_statusdk }}</td>
					                    	<td style="padding-left: 5px;" class="text-center">{{ $data_detail->jrdt_acc }}</td>
					                    @endif

					                    <td class="money text-right" style="padding-right: 8px;">{{ number_format(0,2) }}</td>
					                    <td class="money text-right" style="padding-right: 8px;">{{ number_format(0,2) }}</td>
					                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
					                    	{{ 
					                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
					                    	}}
					                    </td>
					                </tr>
					            @endif
		                  	@endforeach
		                @endif

	                  	@if($request->akun_lawan == 'true')
		                  	<tr style="background: #f1f1f1;">
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;">&nbsp;</td>
			                    <td style="padding-left: 5px;"></td>
			                    <td style="padding-left: 5px;"></td>
			                    <td style="padding-left: 5px;"></td>
			                    <td class="money text-right" style="padding-right: 8px;">&nbsp;</td>
			                    <td class="money text-right" style="padding-right: 8px;">&nbsp;</td>
			                    <td class="money text-right" style="padding-right: 8px;font-weight: 600;">
			                    	&nbsp;
			                    </td>
			                </tr>
			            @endif
					@endforeach
				</tbody>
			</table>

			<table class="table_total tree" border="0" width="100%">
				<thead>
					<tr>
						<th width="8%"></th>
				        <th width="8%"></th>
				        <th width="25%"></th>

				        @if($request->akun_lawan == 'true')
					        <th width="5%"></th>
					        <th width="5%"></th>
					        <th width="6%"></th>
					    @endif

				        <th width="10%" class="typed" style="padding-right: 8px;">{{ number_format($tot_deb, 2) }}</th>
				        <th width="10%" class="typed" style="padding-right: 8px;">{{ number_format($tot_kred, 2) }}</th>
				        <th width="10%" class="typed" style="padding-right: 8px;">
				        	{{ 
	                    		($saldo < 0) ? '('.number_format(str_replace('-', '', $saldo), 2).')' : number_format($saldo,2) 
	                    	}}
				        </th>
					</tr>
				</thead>
			</table>

			<table width="100%" border="0" class="table-info">
				<thead>
					<tr>
						@if($throttle == "Bulan")
							<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Bulan {{ date_ind(explode('-', $b1)[0]).' '.explode('-', $b1)[1] }} &nbsp;s/d &nbsp;{{ date_ind(explode('-', $b2)[0]).' '.explode('-', $b2)[1] }}</td>
						@elseif($throttle == "Tahun")
							<td style="text-align: right; font-weight: 400; padding: 0px 5px 0px 0px; border-top: 0px solid #efefef;">Laporan Buku Besar Tahun {{ $request->y1 }} &nbsp;s/d &nbsp;{{ $request->y2 }}</td>
						@endif
					</tr>
				</thead>
			</table>
		@endforeach

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

      </div>

      <!-- modal -->
	<div id="modal_buku_besar" class="modal">
	  <div class="modal-dialog" style="width: 40%;">
	    <div class="modal-content">

	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">Form Buku Besar</h4>
	        <input type="hidden" class="parrent"/>
	      </div>

	      <div class="modal-body" style="padding: 10px;">
	        <div class="row">
	          <form role="form" class="form-inline" id="form-buku-besar" method="POST" action="{{ route("buku_besar.index_single") }}" target="_self">
	              <input type="hidden" value="{{ csrf_token() }}" name="_token" readonly>
	              <table border="0" id="form-table" class="col-md-12">

	                <tr>
	                  <td width="40%" class="text-center">Periode Buku Besar</td>
	                  <td colspan="3">
	                    <select class="form-control buku_besar select_validate" name="jenis" id="periode_buku_besar" style="width: 80%;">
	                      <option value="Bulan">Bulanan</option>
	                      <option value="Tahun">Tahunan</option>
	                    </select>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="40%" class="text-center">Pilih Cabang</td>
	                  <td colspan="3">
	                    <select class="form-control buku_besar select_bukbes_validate choosen_akun" name="buku_besar_cabang" id="buku_besar_cabang" style="width: 80%;">
                    		<option value="---">-- Pilih Cabang</option>
                    		@if(Session::get('cabang') == '000')
	                          <option value="all">SEMUA CABANG</option>
	                        @endif

	                    	@foreach(cabang() as $dataCabang)
	                    		<option value="{{ $dataCabang->kode }}">{{ $dataCabang->nama }}</option>
	                    	@endforeach

	                    </select>
	                    &nbsp;&nbsp; <small id="buku_besar_cabang_txt" style="display: none;"><i class="fa fa-hourglass-half"></i></small>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="20%" class="text-center">Masukkan <span id="state-masuk">Bulan</span></td>
	                  <td width="25%">
	                    <input type="text" class="form-control buku_besar form_bukbes_validate buku_besar_tanggal first" name="d1" placeholder="MM/YYYY" style="width: 100%; cursor: pointer; background: white;" readonly>

	                    <input type="text" class="form-control buku_besar form_bukbes_validate buku_besar_tahun first" name="y1" placeholder="YYYY" style="width: 90%; cursor: pointer; background: white; display: none;" readonly>

	                  <td class="text-center" style="font-size: 8pt;">
	                    s/d
	                  </td>
	                  <td width="25%">
	                    <input type="text" class="form-control buku_besar form_bukbes_validate buku_besar_tanggal sampai" name="d2" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly>

	                    <input type="text" class="form-control buku_besar form_bukbes_validate buku_besar_tahun sampai" name="y2" placeholder="YYYY" style="width: 90%; cursor: pointer; background: white; display: none;" readonly>
	                  </td>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="40%" class="text-center">Kode Akun</td>
	                  <td colspan="3">
	                    <select class="form-control buku_besar select_bukbes_validate choosen_akun" name="akun1" id="akun1" style="width: 35%;">

	                    </select>
	                    <br><small id="buku_besar_akun1_txt"> &nbsp;Pilih Cabang Dahulu</small>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="40%" class="text-center">Sampai Dengan Akun</td>
	                  <td colspan="3">
	                    <select class="form-control buku_besar select_bukbes_validate choosen_akun" name="akun2" id="akun2" style="width: 35%;">
	                      
	                    </select>
	                    <br><small id="buku_besar_akun2_txt"> &nbsp;Pilih Cabang Dahulu</small>
	                  </td>
	                </tr>

	                <tr>
	                  <td width="40%" class="text-center">Dengan Akun Lawan</td>
	                  <td colspan="3">
	                    <select class="form-control buku_besar select_validate" name="akun_lawan" id="akun_lawan" style="width: 30%;">
	                      <option value="false">Tidak</option>
	                      <option value="true">Ya</option>
	                    </select>
	                  </td>
	                </tr>

	              </table>
	          </form>
	        </div>
	      </div>

	      <div class="modal-footer">
	          <button class="btn btn-primary btn-sm" id="proses_buku_besar" >Proses</button>
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

      <script src="{{ asset('assets/js/chosen/chosen.jquery.js') }}"></script>

      <script type="text/javascript">
        $(document).ready(function(){

          $('[data-toggle="tooltip"]').tooltip({container : 'body'});

          baseUrl = '{{ url('/') }}';

          // script for buku besar
          	  $(".buku_besar.choosen_akun").chosen({ width: '20em' });
		      akun = [];
		      html = '<option value="---">-- Pilih Cabang</option>';

		      $('.buku_besar_tanggal.sampai').datepicker( {
		          format: "yyyy-mm",
		          viewMode: "months", 
		          minViewMode: "months"
		      })

		      $('.buku_besar_tanggal.first').datepicker( {
		          format: "yyyy-mm",
		          viewMode: "months", 
		          minViewMode: "months"
		      }).on("changeDate", function(){
		          $('.buku_besar_tanggal.sampai').val("");
		          $('.buku_besar_tanggal.sampai').datepicker("setStartDate", $(this).val());
		      });

		      $('.buku_besar_tahun.sampai').datepicker( {
		          format: "yyyy",
		          viewMode: "years", 
		          minViewMode: "years"
		      })

		      $('.buku_besar_tahun.first').datepicker( {
		          format: "yyyy",
		          viewMode: "years", 
		          minViewMode: "years"
		      }).on("changeDate", function(){
		          $('.buku_besar_tahun.sampai').val("");
		          $('.buku_besar_tahun.sampai').datepicker("setStartDate", $(this).val());
		      });

		      	// $.ajax(baseUrl+"/purchaseorder/grapcabang", {
         //           timeout: 15000,
         //           type: "get",
         //           dataType: 'json',
         //           success: function (data) {
         //               $.each(data, function(i, n){
         //                    html = html + '<option value="'+n.kode+'">'+n.nama+'</option>';
         //               })

         //               $("#buku_besar_cabang").html(html);
         //               $("#buku_besar_cabang_txt").fadeOut(300);
         //           },
         //           error: function(request, status, err) {
         //              if (status == "timeout") {
         //                alert("Request Timeout. Gagal Mengambil Data Cabang.");
         //              }else {
         //                alert("Internal Server Error. Gagal Mengambil Data Cabang.");
         //              }

         //              $(".cek").removeAttr("disabled");
         //          }
         //        });

		      $("#periode_buku_besar").change(function(evt){
		        evt.preventDefault();

		        periode = $(this);

		        $("#state-masuk").text(periode.val());
		        if(periode.val() == "Bulan"){
		          $(".buku_besar_tahun").css("display", "none");
		          $(".buku_besar_tanggal").css("display", "inline-block");
		        }else if(periode.val() == "Tahun"){
		          $(".buku_besar_tanggal").css("display", "none");
		          $(".buku_besar_tahun").css("display", "inline-block");
		        }
		      })

		      $("#buku_besar_cabang").change(function(evt){
		        evt.preventDefault();
		        cab = $(this);
		        html = '<option value="---">-- Akun</option>';

		        if(cab.val() != "---"){
		          $.ajax(baseUrl+"/master_keuangan/akun/get/"+cab.val(), {
		             timeout: 15000,
		             type: "get",
		             dataType: 'json',
		             success: function (data) {
		                $.each(data, function(i, n){
		                    html = html + '<option value="'+n.id_akun+'">'+n.id_akun+' - '+n.nama_akun+'</option>';
		                })

		                $("#akun1").html(html);
		                $("#akun2").html(html);

		                $("#buku_besar_akun1_txt").fadeOut(300);
		                $("#buku_besar_akun2_txt").fadeOut(300);

		                akun = data;
		                $('.buku_besar.choosen_akun').trigger("chosen:updated");
		             },
		             error: function(request, status, err) {
		                if (status == "timeout") {
		                  alert("Request Timeout. Gagal Mengambil Data Akun.");
		                }else {
		                  alert("Internal Server Error. Gagal Mengambil Data Akun.");
		                }

		                $(".cek").removeAttr("disabled");
		            }
		          });
		        }
		      })

		      $("#akun1").change(function(evt){
		        evt.preventDefault();

		        akun1 = $(this);
		        html = '<option value="---" selected>-- Akun</option>';

		        if(akun1.val() != "---"){
		          idx = akun.findIndex(a => a.id_akun === akun1.val());

		          $("#buku_besar_akun1_txt").html(" &nbsp;"+akun[idx].nama_akun);
		          $("#buku_besar_akun1_txt").fadeIn(200);

		          $.each(akun, function(i, n){
		            if(n.id_akun >= akun1.val())
		              html = html + '<option value="'+n.id_akun+'">'+n.id_akun+' - '+n.nama_akun+'</option>';
		            else
		              html = html + '<option value="'+n.id_akun+'" style="background:#ff4444; color:white;" disabled>'+n.id_akun+' - '+n.nama_akun+'</option>';
		          })
		          
		          $("#akun2").html(html);
		          $('.buku_besar.choosen_akun').trigger("chosen:updated");
		        }else{
		          $("#buku_besar_akun1_txt").fadeOut(300);
		          $("#buku_besar_akun2_txt").fadeOut(300);

		          $.each(akun, function(i, n){
		            html = html + '<option value="'+n.id_akun+'">'+n.id_akun+'</option>';
		          })
		          
		          $("#akun2").html(html);
		        }
		      })

		      $("#akun2").change(function(evt){
		        evt.preventDefault();

		        akun2 = $(this);
		        html = '<option value="---" selected>-- Akun</option>';

		        if(akun2.val() != "---"){
		          idx = akun.findIndex(a => a.id_akun === akun2.val());

		          $("#buku_besar_akun2_txt").html(" &nbsp;"+akun[idx].nama_akun);
		          $("#buku_besar_akun2_txt").fadeIn(200);
		        }else{
		          $("#buku_besar_akun2_txt").fadeOut(300);
		        }
		      })

		      $('#proses_buku_besar').click(function(evt){
		        evt.preventDefault()

		        if(validate_form_buku_besar() == true){
		          $("#form-buku-besar").submit();
		        }
		      })

		      function validate_form_buku_besar(){
		        a = true;
		        $(".buku_besar.form_bukbes_validate").each(function(i, e){
		          if($(this).val() == "" && $(this).is(":visible")){
		            a = false;
		            $(this).focus();
		            toastr.warning('Harap Lengkapi Data Diatas');
		            return false;
		          }
		        })

		        $(".buku_besar.select_bukbes_validate").each(function(i, e){
		          if($(this).val() == "---"){
		            a = false;
		            $(this).focus();
		            toastr.warning('Harap Lengkapi Data Diatas');
		            return false;
		          }
		        })

		        return a;
		      }

		     // buku besar end

        
          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>