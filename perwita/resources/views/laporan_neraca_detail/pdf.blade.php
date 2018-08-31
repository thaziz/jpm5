<!DOCTYPE html>
  <html>
    <head>
      <title>Lampiran Neraca</title>


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
            border: 1px solid #aaa;
            border-collapse: collapse;
            border-bottom: 3px solid #ccc;
            background: #fff;
            padding: 8px 15px;
            font-size: 10pt;
          }

          #table-data td{
            border: 1px solid #ccc;
          }

          #table-data td.currency{
            text-align: right;
            padding-right: 5px;
          }

          #table-data td.no-border{
            border: 0px;
          }

          #table-data td.total.not-same{
             color: red !important;
             -webkit-print-color-adjust: exact;
          }

          #table-data-inside{
            font-size: 9pt;
            margin-top: 5px;
          }

          #table-data-inside td{
            padding: 5px 15px;
            border: 0px solid #333;
          }

          #table-data-inside td.lv1{
            padding: 5px 10px;
          }

          #table-data-inside td.lv2{
            padding: 5px 25px;
          }

          #table-data-inside td.lv3{
            padding: 5px 50px;
            font-style: italic;
          }

          #table-data-inside td.money{
            text-align: right;
            padding: 5px 10px;
            font-weight: bold;
          }

          #table-data-inside td.total{
            border-top: 2px solid #777; ;
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
        @page { size: portrait; }
        #navigation{
            display: none;
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
              {{-- <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_setting_neraca').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Neraca"></i></li> --}}
              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Lampiran Neraca (Aktiva) </th>
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
                @if($throttle == 'bulan')
                  Laporan Per Akhir Bulan {{ date_ind($request->m)." ".$request->y }}
                @elseif($throttle == 'tahun')
                  Laporan Per Akhir Tahun {{ $request->y }}
                @endif
              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="80%" border="0" style="margin-left: 30px;">
          
          <tbody>
            <tr>
              <td style="border-right: 3px solid #ccc;">
                <table id="table-data-inside" border="0" width="100%">
                  <tbody>
                    @foreach($data_neraca as $key => $group)
                      @if(substr($group['id_group'], 0, 1) == "A")

                        <?php $ds = ($key != 0) ? '50px' : ''; $totGroup = 0; ?>

                        <tr>
                          <td class="ids" style="font-weight: bold; font-size: 10pt;padding-left: 100px; padding-top: {{ $ds  }}" colspan="3">{{ $group['nama_group'] }}</td>
                        </tr>

                        @foreach($data_detail as $key => $detail)
                          @if($detail['id_group'] == $group['id_group'])
                            <tr>
                              <td width="30%" style="font-size: 9pt; padding-left: 20px;">{{ $detail['id_akun'] }}</td>
                              <td width="50%" style="font-size: 9pt; padding-left: 20px;">{{ $detail['nama_akun'] }}</td>
                              <td class="text-right" style="font-size: 9pt; padding-left: 20px; font-weight: 600">{{ ($detail['total_akhir'] >= 0) ? number_format($detail['total_akhir'], 2) : '('.str_replace('-', '', number_format($detail['total_akhir'], 2)).')' }}</td>
                            </tr>

                            <?php $totGroup += $detail['total_akhir']; ?>
                          @endif
                        @endforeach

                        <tr>
                          <td width="30%" style="font-size: 9pt; padding-left: 20px;"></td>
                          <td width="50%" style="font-size: 9pt; padding-left: 20px;"></td>
                          <td class="money total text-right" style="font-size: 9pt; padding-left: 20px; font-weight: 600">{{ ($totGroup >= 0) ? number_format($totGroup, 2) : '('.str_replace('-', '', number_format($totGroup, 2)).')' }}</td>
                        </tr>

                      @endif
                    @endforeach
                      
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>

        </table>

      </div>

      <div class="page-break"></div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 20px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Lampiran Neraca (Pasiva) </th>
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
                @if($throttle == 'bulan')
                  Bulan {{ date_ind($request->m)." ".$request->y }}
                @elseif($throttle == 'tahun')
                  Tahun {{ $request->y }}
                @endif
              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="80%" border="0" style="margin-left: 30px;">
          
          <tbody>
            <tr>
              <td style="border-right: 3px solid #ccc;">
                <table id="table-data-inside" border="0" width="100%">
                  <tbody>
                    @foreach($data_neraca as $key => $group)
                      @if(substr($group['id_group'], 0, 1) == "P")

                        <?php $ds = ($key != 0) ? '50px' : ''; $totGroup = 0; ?>

                        <tr>
                          <td class="ids" style="font-weight: bold; font-size: 10pt;padding-left: 100px; padding-top: {{ $ds  }}" colspan="3">{{ $group['nama_group'] }}</td>
                        </tr>

                        @foreach($data_detail as $key => $detail)
                          @if($detail['id_group'] == $group['id_group'])
                            <tr>
                              <td width="30%" style="font-size: 9pt; padding-left: 20px;">{{ $detail['id_akun'] }}</td>
                              <td width="50%" style="font-size: 9pt; padding-left: 20px;">{{ $detail['nama_akun'] }}</td>
                              <td class="text-right" style="font-size: 9pt; padding-left: 20px; font-weight: 600">{{ ($detail['total_akhir'] >= 0) ? number_format($detail['total_akhir'], 2) : '('.str_replace('-', '', number_format($detail['total_akhir'], 2)).')' }}</td>
                            </tr>

                            <?php $totGroup += $detail['total_akhir']; ?>
                          @endif
                        @endforeach

                        <tr>
                          <td width="30%" style="font-size: 9pt; padding-left: 20px;">&nbsp;</td>
                          <td width="50%" style="font-size: 9pt; padding-left: 20px;">&nbsp;</td>
                          <td class="money total text-right" style="font-size: 9pt; padding-left: 20px; font-weight: 600">{{ ($totGroup >= 0) ? number_format($totGroup, 2) : '('.str_replace('-', '', number_format($totGroup, 2)).')' }}</td>
                        </tr>

                      @endif
                    @endforeach
                      
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>

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

          baseUrl = '{{ url('/') }}';

          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>