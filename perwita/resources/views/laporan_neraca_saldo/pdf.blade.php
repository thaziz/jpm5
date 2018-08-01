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
            border-bottom: 3px solid #999;
            padding: 3px;
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

          .page-break { display: block; page-break-before: always; }
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
                
              </td>

              <td width="20%">
                
              </td>

              {{-- <td width="20%">
                <input type="text" class="form-control tanggal_register register_validate" name="tanggal" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly value="{{$request->tanggal}}">
              </td> --}}

              <td>
                
              </td>

              {{-- <td width="20%">
                <input type="text" class="form-control sampai_register register_validate" name="sampai" placeholder="MM/YYYY" style="cursor: pointer; background: white;" readonly required value="{{$request->sampai}}">
              </td> --}}

              <td width="9%" style="border-right: 1px solid #999;">
                {{-- <button class="btn btn-primary btn-block" id="save_register">
                  <i class="fa fa-check-circle"></i> &nbsp;Submit
                </button> --}}
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

      <div class="col-md-12" style="background: white; padding: 10px 15px; margin-top: 20px;">
  
        <table width="100%" border="0" style="font-size: 10pt; border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left;">Laporan Neraca Saldo </th>
              <th style="text-align: right;">PT. Jawa Pratama Mandiri</th>
            </tr>
          </thead>
        </table>

        <table width="100%" border="0" style="font-size: 8pt;">
          <thead>
            <tr>
              <td style="text-align: left;">Bulan Transaksi : </td>
              <td style="text-align: right;"></td>
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
            <tr>
              @foreach($data as $key => $okee)
                <tr>
                  <td style="padding: 5px; vertical-align: top;">{{ $okee->id_akun }}</td>
                  <td style="padding: 5px;font-weight: 600;">{{ $okee->nama_akun }}</td>
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
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                  <td class="text-right" style="padding: 5px;">{{ number_format(0) }}</td>
                </tr>
              @endforeach
            </tr>
          </tbody>
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
          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })
        })
      </script>
    </body>
  </html>