<!DOCTYPE html>
  <html>
    <head>
      <title>laporan Neraca Saldo</title>


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
          border-bottom: 2px solid #555;
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

      <div class="col-md-12" id="navigation" style="background: rgba(0, 0, 0, 0.4); box-shadow: 0px 2px 5px #444; position: fixed; z-index: 2">
        <div class="row">
          <div class="col-md-7" style="background: none; padding: 15px 15px; color: #fff; padding-left: 120px;">
            PT Jawa Pratama Mandiri
          </div>
          <div class="col-md-5" style="background: none; padding: 10px 15px 5px 15px">
            <ul>
              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_neraca_saldo').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Register Jurnal"></i></li>
              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-12" style="background: white; padding: 10px 15px; width: 1600px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Neraca Saldo  </th>
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

                Transaksi : 
                  
                @if($request['jenis'] == 'Bulan')
                  Bulan {{ date_ind(explode('-', $request['d1'])[1]) }} {{ explode('-', $request['d1'])[0] }}
                @else
                  Tahun {{ $request['y1'] }}
                @endif

              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="100%" border="0">
          <thead>
           <tr>
              {{-- <th rowspan="2" width="6%">Kode</th> --}}
              <th rowspan="2" width="12%">Nama Akun</th>
              <th colspan="2" width="10%">Saldo Awal</th>
              <th colspan="2" width="10%">Mutasi Bank</th>
              <th colspan="2" width="10%">Mutasi Kas</th>
              <th colspan="2" width="10%">Mutasi Memorial</th>
              <th colspan="2" width="10%">Total Mutasi</th>
              <th colspan="2" width="10%">Saldo Akhir</th>
            </tr>

            <tr>
              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>

              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>

              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>

              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>

              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>

              <th width="6%">Debet</th>
              <th width="6%">Kredit</th>


            </tr>
          </thead>

          <tbody>
            <?php $tot_saldo_d = $tot_saldo_k = $tot_mb_d = $tot_mb_k = $tot_mk_d = $tot_mk_k = $tot_mm_d = $tot_mm_k = $tot_mutasi_d = $tot_mutasi_k = $tot_salda_d = $tot_salda_k = 0 ?>
            @foreach($data as $key => $okee)
                <tr>
                  {{-- <td style="padding: 5px; vertical-align: top;">{{ $okee->id_akun }}</td> --}}
                  <td style="padding: 5px;font-weight: normal;">{{ $okee->nama_akun }}</td>

                  <?php 
                    $deb = $kre = 0; $tot_deb = $tot_kred = 0;
                    //if($okee->akun_dka == "D") {
                      //if($data_detail[$okee->id_akun] < 0)
                        //$kre = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                      //else
                        //$deb = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                    //}else{
                      //if($data_detail[$okee->id_akun] < 0)
                        //$deb = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                      //else
                        //$kre = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                    //}

                    if($okee->akun_dka == "D")
                      $deb = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                    else
                      $kre = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                  ?>


                  {{-- saldo awal --}}

                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($deb >= 0) ? $deb : '('.$deb.')' }}</td>
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($kre >= 0) ? $kre : '('.$kre.')' }}</td>

                  {{-- Mutasi bank --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_bank_D'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_bank_D'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_bank_D'], 2)).')' }}</td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_bank_K'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_bank_K'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_bank_K'], 2)).')' }}</td>

                  {{-- Mutasi Kas --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_kas_D'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_kas_D'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_kas_D'], 2)).')' }}</td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_kas_K'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_kas_K'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_kas_K'], 2)).')' }}</td>

                  {{-- Mutasi memorial --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_memorial_D'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_memorial_D'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_memorial_D'], 2)).')' }}</td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($data_detail[$okee->id_akun]['mutasi_memorial_K'] >= 0) ? str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_memorial_K'], 2)) : '('.str_replace('-', '', number_format($data_detail[$okee->id_akun]['mutasi_memorial_K'], 2)).')' }}</td>

                  <?php 
                    $tot_deb =  $data_detail[$okee->id_akun]['mutasi_bank_D'] + $data_detail[$okee->id_akun]['mutasi_kas_D'] + $data_detail[$okee->id_akun]['mutasi_memorial_D'];

                    $tot_kre =  $data_detail[$okee->id_akun]['mutasi_bank_K'] + $data_detail[$okee->id_akun]['mutasi_kas_K'] + $data_detail[$okee->id_akun]['mutasi_memorial_K'];

                    ?>

                  {{-- total mutasi --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($tot_deb >= 0) ? str_replace('-', '', number_format($tot_deb, 2)) : '('.str_replace('-', '', number_format($tot_deb, 2)).')' }}</td>
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($tot_kre >= 0) ? str_replace('-', '', number_format($tot_kre, 2)) : '('.str_replace('-', '', number_format($tot_kre, 2)).')' }}</td>

                  {{-- Saldo Akhir --}}
                  <?php
                    $sad = $ak = 0;

                    if($okee->akun_dka == 'D'){
                      if(($data_detail[$okee->id_akun]['saldo_akun'] + $tot_deb) + $tot_kre < 0)
                        $ak = ($data_detail[$okee->id_akun]['saldo_akun'] + $tot_deb) + $tot_kre;
                      else
                        $sad = ($data_detail[$okee->id_akun]['saldo_akun'] + $tot_deb) + $tot_kre;
                    }
                    else{
                      if(($data_detail[$okee->id_akun]['saldo_akun'] + $tot_deb) + $tot_kre < 0)
                        $sad = ($data_detail[$okee->id_akun]['saldo_akun'] + $tot_kre) + $tot_deb;
                      else
                        $ak = ($data_detail[$okee->id_akun]['saldo_akun'] + $tot_deb) + $tot_kre;
                    }
                  ?>
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($sad >= 0) ? str_replace('-', '', number_format($sad, 2)) : '('.str_replace('-', '', number_format($sad, 2)).')' }}</td>
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ ($ak >= 0) ? str_replace('-', '', number_format($ak, 2)) : '('.str_replace('-', '', number_format($ak, 2)).')' }}</td>

                  <?php
                    $tot_saldo_d += $deb;
                    $tot_salda_k += $kre;
                    $tot_mb_d += $data_detail[$okee->id_akun]['mutasi_bank_D'];
                    $tot_mb_k += $data_detail[$okee->id_akun]['mutasi_bank_K'];
                    $tot_mk_d += $data_detail[$okee->id_akun]['mutasi_kas_D'];
                    $tot_mk_k += $data_detail[$okee->id_akun]['mutasi_kas_K'];
                    $tot_mm_d += $data_detail[$okee->id_akun]['mutasi_memorial_D'];
                    $tot_mm_k += $data_detail[$okee->id_akun]['mutasi_memorial_K'];
                    $tot_mutasi_d += $tot_deb;
                    $tot_mutasi_k += $tot_kre;
                    $tot_salda_d += $sad;
                    $tot_salda_k += $ak;

                  ?>
                </tr>
              @endforeach

              <tr>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-center">Grand Total</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_saldo_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_saldo_k, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mb_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mb_k, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mk_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mk_k, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mm_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mm_k, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mutasi_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_mutasi_k, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_salda_d, 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format($tot_salda_k, 2) }}</td>
              </tr>
            
          </tbody>
        </table>

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>

          </thead>
        </table>

      </div>

      <!-- modal -->
    <div id="modal_neraca_saldo" class="modal">
      <div class="modal-dialog" style="width: 40%;">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Form Neraca Saldo</h4>
            <input type="hidden" class="parrent"/>
          </div>

          <div class="modal-body" style="padding: 10px;">
            <div class="row">
              <form role="form" class="form-inline" id="form-neraca-saldo" method="POST" action="{{ route("neraca_saldo.index") }}" target="_self">
                  <input type="hidden" value="{{ csrf_token() }}" name="_token" readonly>
                  <table border="0" id="form-table" class="col-md-12">

                    <tr>
                      <td width="40%" class="text-center">Periode Neraca Saldo</td>
                      <td colspan="3">
                        <select class="form-control neraca_saldo select_validate" name="jenis" id="periode_neraca_saldo" style="width: 80%;">
                          <option value="Bulan">Bulanan</option>
                          <option value="Tahun">Tahunan</option>
                        </select>
                      </td>
                    </tr>

                    {{-- <tr>
                      <td width="40%" class="text-center">Pilih Cabang</td>
                      <td colspan="3">
                        <select class="form-control buku_besar select_bukbes_validate" name="buku_besar_cabang" id="buku_besar_cabang" style="width: 80%;">

                        </select>
                        &nbsp;&nbsp; <small id="buku_besar_cabang_txt" style="display: none;"><i class="fa fa-hourglass-half"></i></small>
                      </td>
                    </tr> --}}

                    <tr>
                      <td width="20%" class="text-center">Masukkan <span id="state-masuk">Bulan</span></td>
                      <td width="25%">
                        <input type="text" class="form-control neraca_saldo form_neraca-saldo_validate neraca_saldo_tanggal first" name="d1" placeholder="MM/YYYY" style="width: 100%; cursor: pointer; background: white;" readonly>

                        <input type="text" class="form-control neraca_saldo form_neraca-saldo_validate neraca_saldo_tahun first" name="y1" placeholder="YYYY" style="width: 90%; cursor: pointer; background: white; display: none;" readonly>
                      <td>
                    </tr>

                  </table>
              </form>
            </div>
          </div>

          <div class="modal-footer">
              <button class="btn btn-primary btn-sm" id="proses_neraca_saldo" >Proses</button>
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

          $('.neraca_saldo_tanggal.first').datepicker( {
              format: "yyyy-mm",
              viewMode: "months", 
              minViewMode: "months"
          })

          $('.neraca_saldo_tahun.first').datepicker( {
              format: "yyyy",
              viewMode: "years", 
              minViewMode: "years"
          })

          $("#periode_neraca_saldo").change(function(evt){
            evt.preventDefault();

            periode = $(this);

            $("#state-masuk").text(periode.val());
            if(periode.val() == "Bulan"){
              $(".neraca_saldo_tahun").css("display", "none");
              $(".neraca_saldo_tanggal").css("display", "inline-block");
            }else if(periode.val() == "Tahun"){
              $(".neraca_saldo_tanggal").css("display", "none");
              $(".neraca_saldo_tahun").css("display", "inline-block");
            }
          })

          $('#proses_neraca_saldo').click(function(evt){
            evt.preventDefault()

            // if(validate_form_buku_besar() == true){
              $("#form-neraca-saldo").submit();
            // }
          })

          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>