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

                Per - 
                  
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
              <th rowspan="2" width="6%">Kode Akun</th>
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
            <?php $tot_saldo_d = $tot_saldo_k = $tot_mb_d = $tot_mb_k = $tot_mk_d = $tot_mk_k = $tot_mm_d = $tot_mm_k = $tot_mutasi_d = $tot_mutasi_k = $tot_saldo_akhir_debet = $tot_saldo_akhir_kredit = 0 ?>
            @foreach($data as $key => $okee)
                <tr>
                  <td style="padding: 5px; vertical-align: top;">{{ $okee->id_akun }}</td>
                  <td style="padding: 5px;font-weight: normal;">{{ $okee->nama_akun }}</td>

                  <?php 
                    $deb = $kre = $tot_deb = $tot_kred = $saldo_akhir_debet = $saldo_akhir_kredit = 0;

                    $debet = (count($data_saldo[$key]->mutasi_bank_debet) > 0) ? $data_saldo[$key]->mutasi_bank_debet->first()->total : 0;
                    $kredit = (count($data_saldo[$key]->mutasi_bank_kredit) > 0) ? $data_saldo[$key]->mutasi_bank_kredit->first()->total : 0;

                    $total = $data_saldo[$key]->coalesce + ($debet + $kredit);

                    if($data_saldo[$key]->akun_dka == 'D')
                      if($total > 0 )
                        $deb = str_replace('-', '', $total);
                      else
                        $kre = str_replace('-', '', $total);
                    else
                      if($total > 0 )
                        $kre = str_replace('-', '', $total);
                      else
                        $deb = str_replace('-', '', $total);

                    if(strtotime($data_date) < strtotime($data_saldo[$key]->opening_date)){
                      $kre = 0; $deb = 0;
                    }
                  ?>


                  {{-- saldo awal --}}

                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ number_format($deb,2) }}</td>
                  <td class="text-right" style="padding: 5px;font-weight: 600;">{{ number_format($kre,2) }}</td>

                  <?php 
                    $saldo_akhir_debet += str_replace('-', '', $deb);
                    $saldo_akhir_kredit += str_replace('-', '', $kre);

                    $tot_saldo_d += $deb;
                    $tot_saldo_k += $kre;
                  ?>

                  {{-- Mutasi bank --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_bank_debet->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_bank_debet->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_bank_kredit->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_bank_kredit->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <?php
                    $tot_mb_d += ($okee->mutasi_bank_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_bank_debet->first()->total) : 0;
                    $tot_mb_k += ($okee->mutasi_bank_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_bank_kredit->first()->total) : 0;

                    $tot_deb += ($okee->mutasi_bank_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_bank_debet->first()->total) : 0;
                    $tot_kred += ($okee->mutasi_bank_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_bank_kredit->first()->total) : 0;
                  ?>


                  {{-- Mutasi kas --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_kas_debet->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_kas_debet->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_kas_kredit->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_kas_kredit->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <?php
                    $tot_mk_d += ($okee->mutasi_kas_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_kas_debet->first()->total) : 0;
                    $tot_mk_k += ($okee->mutasi_kas_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_kas_kredit->first()->total) : 0;

                    $tot_deb += ($okee->mutasi_kas_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_kas_debet->first()->total) : 0;
                    $tot_kred += ($okee->mutasi_kas_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_kas_kredit->first()->total) : 0;
                  ?>


                  {{-- Mutasi Memorial --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_memorial_debet->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_memorial_debet->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      ($okee->mutasi_memorial_kredit->count() != 0) ? number_format(str_replace('-', '', $okee->mutasi_memorial_kredit->first()->total),2) : number_format(0,2)
                    }}
                  </td>

                  <?php
                    $tot_mm_d += ($okee->mutasi_memorial_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_memorial_debet->first()->total) : 0;
                    $tot_mm_k += ($okee->mutasi_memorial_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_memorial_kredit->first()->total) : 0;

                    $tot_deb += ($okee->mutasi_memorial_debet->count() != 0) ? str_replace('-', '', $okee->mutasi_memorial_debet->first()->total) : 0;
                    $tot_kred += ($okee->mutasi_memorial_kredit->count() != 0) ? str_replace('-', '', $okee->mutasi_memorial_kredit->first()->total) : 0;
                  ?>


                  {{-- Total Mutasi --}}
                  <td class="text-right" style="padding: 5px;font-weight: 600; background: #f1f1f1;">
                    {{ 
                      number_format($tot_deb, 2)
                    }}
                  </td>

                  <td class="text-right" style="padding: 5px;font-weight: 600; background: #f1f1f1;">
                    {{ 
                       number_format($tot_kred, 2)
                    }}
                  </td>

                  <?php
                    $tot_mutasi_d += str_replace('-', '', $tot_deb);
                    $tot_mutasi_k += str_replace('-', '', $tot_kred);

                    $saldo_akhir_debet += str_replace('-', '', $tot_deb);
                    $saldo_akhir_kredit += str_replace('-', '', $tot_kred);
                  ?>


                  {{-- Saldo Akhir --}}

                  <?php 
                    $sdo = $saldo_akhir_debet - $saldo_akhir_kredit;
                    $d = $k = 0;

                    if($sdo < 0)
                      $k = str_replace('-', '', $sdo);
                    else
                      $d = str_replace('-', '', $sdo)
                  ?>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                      number_format($d, 2)
                    }}
                  </td>

                  <td class="text-right" style="padding: 5px;font-weight: 600;">
                    {{ 
                       number_format($k, 2)
                    }}
                  </td>

                  <?php
                    $tot_saldo_akhir_debet += str_replace('-', '', $d);
                    $tot_saldo_akhir_kredit += str_replace('-', '', $k);
                  ?>

                </tr>
              @endforeach

              <tr>
                
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-center" colspan="2">Grand Total</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format(str_replace('-', '', $tot_saldo_d), 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">{{ number_format(str_replace('-', '', $tot_saldo_k), 2) }}</td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mb_d), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mb_k), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mk_d), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mk_k), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mm_d), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mm_k), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold; background: #f1f1f1;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mutasi_d), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold; background: #f1f1f1;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_mutasi_k), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_saldo_akhir_debet), 2) }}
                </td>
                <td style="background: #eee; border: 1px solid #777; font-weight: bold;" class="text-right">
                  {{ number_format(str_replace('-', '', $tot_saldo_akhir_kredit), 2) }}
                </td>
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