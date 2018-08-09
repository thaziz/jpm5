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

      <div class="col-md-12" style="background: white; padding: 10px 15px; margin-top: 20px;">
  
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
                Transaksi : Bulan {{-- {{ date("d", strtotime($d1)) }} {{ date_ind(date("m", strtotime($d1))) }} {{ date("Y", strtotime($d1)) }} s/d {{ date("d", strtotime($d2)) }} {{ date_ind(date("m", strtotime($d2))) }} {{ date("Y", strtotime($d2)) }} --}}
              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="100%" border="0">
          <thead>
           <tr>
              <th rowspan="2" width="6%">Kode</th>
              <th rowspan="2" width="12%">Nama Akun</th>
              <th colspan="2" width="8%">Saldo Awal</th>
              <th colspan="2" width="8%">Mutasi Bank</th>
              <th colspan="2" width="8%">Mutasi Kas</th>
              <th colspan="2" width="8%">Mutasi Memorial</th>
              <th colspan="2" width="8%">Total Mutasi</th>
              <th colspan="2" width="8%">Saldo Akhir</th>
            </tr>

            <tr>
              <th width="8%">Debet</th>
              <th>Kredit</th>

              <th width="8%">Debet</th>
              <th>Kredit</th>

              <th width="8%">Debet</th>
              <th>Kredit</th>

              <th width="8%">Debet</th>
              <th>Kredit</th>

              <th width="8%">Debet</th>
              <th>Kredit</th>

              <th width="8%">Debet</th>
              <th>Kredit</th>


            </tr>
          </thead>

          <tbody>
            
            @foreach($data as $key => $okee)
                <tr>
                  <td style="padding: 5px; vertical-align: top;">{{ $okee->id_akun }}</td>
                  <td style="padding: 5px;font-weight: 600;">{{ $okee->nama_akun }}</td>

                  <?php 
                    $deb = $kre = 0;
                    if($okee->akun_dka == "D") {
                      if($data_detail[$okee->id_akun] < 0)
                        $kre = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                      else
                        $deb = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                    }else{
                      if($data_detail[$okee->id_akun] < 0)
                        $deb = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                      else
                        $kre = number_format($data_detail[$okee->id_akun]['saldo_akun'], 2);
                    }
                  ?>


                  
                  <td class="text-right" style="padding: 5px;">{{ $deb }}</td>
                  <td class="text-right" style="padding: 5px;">{{ $kre }}</td>

                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                </tr>
              @endforeach
            
          </tbody>
        </table>

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

      </div>

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

          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>