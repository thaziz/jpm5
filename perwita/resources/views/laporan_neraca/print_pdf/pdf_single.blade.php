<!DOCTYPE html>
  <html>
    <head>

      @if($throttle == 'bulan')
        <title>Neraca {{ date_ind($request->m)." ".$request->y }}</title>
      @elseif($throttle == 'tahun')
        <title>Neraca {{ $request->y }}</title>
      @endif


        <link href="{{ asset('assets/vendors/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">


        <!-- datepicker -->
        <link href="{{ asset('assets/vendors/datapicker/datepicker3.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

        <!-- Toastr style -->
        <link href="{{ asset('assets/vendors/toastr/toastr.min.css')}}" rel="stylesheet">

        <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

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
            vertical-align: top;
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
            padding: 5px 10px;
          }

          #table-data-inside td.lv3{
            padding: 5px 10px;
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
              <li><i class="fa fa-compress" style="cursor: pointer;" onclick="$('#modal_setting_neraca_perbandingan').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Perbandingan Neraca"></i></li>

              <li><i class="fa fa-sliders" style="cursor: pointer;" onclick="$('#modal_setting_neraca').modal('show')" data-toggle="tooltip" data-placement="bottom" title="Tampilkan Setting Neraca"></i></li>

              <li><i class="fa fa-file-text" style="cursor: pointer;" onclick="window.open('{{ route("neraca_detail.index", $throttle."?m=".$request->m."&y=".$request->y."&cab=".$request->cab) }}', '_blank')" data-toggle="tooltip" data-placement="bottom" title="Buka Lampiran Neraca"></i></li>

              <li><i class="fa fa-print" style="cursor: pointer;" id="print" data-toggle="tooltip" data-placement="bottom" title="Print Laporan"></i></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-10 col-md-offset-1" style="background: white; padding: 10px 15px; margin-top: 80px;">
  
        <table width="100%" border="0" style="border-bottom: 1px solid #333;">
          <thead>
            <tr>
              <th style="text-align: left; font-size: 14pt; font-weight: 600">Laporan Neraca Dalam {{ ucfirst($throttle) }} </th>
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
                  Laporan Per Bulan {{ date_ind($request->m)." ".$request->y }}
                @elseif($throttle == 'tahun')
                  Laporan Per Tahun {{ $request->y }}
                @endif
              </td>
              
            </tr>
          </thead>
        </table>

        <table id="table-data" width="100%" border="0" style="min-height: 455px;">
          <thead>
            <tr>
              <th width="50%" class="text-left" style="border-right: 3px solid #ccc">Aktiva</th>
              <th width="50%" class="text-right">Pasiva</th>
            </tr>
          </thead>

          <tbody>
            
            <tr>
              <td style="border-right: 3px solid #ccc;">
                <table class="aktiva-tree" id="table-data-inside" border="0" width="100%">
                  <tbody>
<<<<<<< HEAD
                    
                      <?php $total_aktiva = 0; $total_pasiva = 0; ?>

                        @foreach($data_neraca as $data_neraca_aktiva)
                          @if($data_neraca_aktiva["type"] == "aktiva")
                            <?php 
                              $level = "lv".$data_neraca_aktiva["level"];
                              $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                              $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                            ?>
                            
                            @if($data_neraca_aktiva["jenis"] == 1)
                              <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" style="font-weight: bold;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money" style="display: none">{{ get_total_neraca_parrent($data_neraca_aktiva['nomor_id'], $data_neraca) }}</td>
                              </tr>
                            @elseif($data_neraca_aktiva["jenis"] == 2)

                              <?php $totDetail = 0 ?>

                              @foreach($data_detail as $data_detail_aktiva)
                                  @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                                      <?php 
                                        $totDetail += $data_detail_aktiva["total"];
                                        $total_aktiva += $data_detail_aktiva["total"];
                                      ?>
                                    </tr>
                                  @endif
                                @endforeach

                              <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" width="60%">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money">{{ ($totDetail >= 0) ? number_format($totDetail, 2) : "(".number_format(str_replace("-", "", $totDetail), 2).")" }}</td>
                              </tr>
                            @elseif($data_neraca_aktiva["jenis"] == 3)
                              <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" style="font-weight: 600; font-style: italic;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money total">
                                  {{ ($data_neraca_aktiva["total"] >= 0) ? number_format($data_neraca_aktiva["total"], 2) : "( ".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2)." )" }}
                                </td>
                              </tr>
                            @elseif($data_neraca_aktiva["jenis"] == 4)
                              <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}">
                                <td class="{{ $level }}">&nbsp;</td>
                                <td></td>
=======
                    <?php $total_aktiva = $total_pasiva = 0; ?>
                    @foreach($detail as $data_detail)
                      @if($data_detail->type == 'aktiva')

                        @if($data_detail->jenis == 1)

                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }}" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: bold;">{{ $data_detail->keterangan }}</td>
                            <td class="money" style="display: none">
                              {{ get_total_neraca_parrent($data_detail->nomor_id, 2, 'A', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>

                        @elseif($data_detail->jenis == 2)

                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }} collapse" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: bold;">{{ $data_detail->keterangan }}</td>
                            <td class="money">
                               {{ get_total_neraca_parrent($data_detail->nomor_id, 3, 'A', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>

                          @foreach($data_detail->detail as $detail_dt)
                            <tr>
                              <tr class="treegrid-{{ str_replace('.', '-', $detail_dt->id_group) }} treegrid-parent-{{ str_replace('.', '-', $detail_dt->id_parrent) }} collapse" id="{{ $detail_dt->nomor_id }}">
                                <td style="font-weight: 500; font-style: italic;">Group {{ $detail_dt->nama }}</td>
                                <td class="money">
                                  {{ get_total_neraca_parrent($detail_dt->id_parrent, 5, 'A', $data_real, $throttle, $detail, true) }}
                                </td>
                              </tr>
                            </tr>

                            @foreach($detail_dt->akun as $akun)
                              <?php 
                                $mutasi = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

                                if($throttle == 'bulan')
                                  $coalesce = (strtotime($data_real) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
                                else
                                  $coalesce = (date('Y', strtotime($data_real)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;

                                $total = ($coalesce + $mutasi);

                                if($akun->akun_dka == 'K'){
                                  $total = ($total * -1);
                                }

                                $total_aktiva += $total;

                              ?>

                              <tr>
                                <tr class="treegrid-{{ str_replace('.', '-', $akun->id_akun) }} treegrid-parent-{{ str_replace('.', '-', $akun->group_neraca) }} collapse" id="{{ $akun->id_akun }}">
                                  <td style="font-weight: 500; font-style: italic;">{{ $akun->nama_akun }}</td>
                                  <td class="money">
                                    {{ ($total < 0) ? '('.number_format(str_replace('-', '', $total), 2).')' : number_format(str_replace('-', '', $total), 2) }}
                                  </td>
                                </tr>
>>>>>>> 727c97c1b3fa6d39fa2e9ab5474fbfcb2c1576fc
                              </tr>
                            @endif
                          @endif
                        @endforeach

<<<<<<< HEAD
                        <tr>
                          <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2">&nbsp;</td>
                        </tr>
=======
                         @elseif($data_detail->jenis == 3)
                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }}" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: 600; font-style: italic;">{{ $data_detail->keterangan }}</td>
                            <td class="money total">
                              {{ get_total_neraca_parrent($data_detail->nomor_id, 4, 'A', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>
>>>>>>> 727c97c1b3fa6d39fa2e9ab5474fbfcb2c1576fc

                  </tbody>
                </table>
              </td>

              <td>
                <table class="aktiva-tree" id="table-data-inside" border="0" width="100%">
                  <tbody>
<<<<<<< HEAD
                    
                      @foreach($data_neraca as $data_neraca_aktiva)
                        @if($data_neraca_aktiva["type"] == "pasiva")
                          <?php 
                            $level = "lv".$data_neraca_aktiva["level"];
                            $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                            $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                          ?>
                          
                          @if($data_neraca_aktiva["jenis"] == 1)
                            <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                              <td class="{{ $level }}" style="font-weight: bold;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                              <td class="money" style="display: none;">{{ get_total_neraca_parrent($data_neraca_aktiva['nomor_id'], $data_neraca) }}</td>
                            </tr>
                          @elseif($data_neraca_aktiva["jenis"] == 2)
                            <?php $totDetail = 0 ?>

                              @foreach($data_detail as $data_detail_aktiva)
                                  @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                                      <?php 
                                        $totDetail += $data_detail_aktiva["total"];
                                        $total_pasiva += $data_detail_aktiva["total"];
                                      ?>
                                    </tr>
                                  @endif
                                @endforeach

                              <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" width="60%">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money">{{ ($totDetail >= 0) ? number_format($totDetail, 2) : "(".number_format(str_replace("-", "", $totDetail), 2).")" }}</td>
                              </tr>
=======

                    @foreach($detail as $data_detail)
                      @if($data_detail->type == 'pasiva')

                        @if($data_detail->jenis == 1)

                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }}" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: bold;">{{ $data_detail->keterangan }}</td>
                            <td class="money" style="display: none">
                              {{ get_total_neraca_parrent($data_detail->nomor_id, 2, 'P', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>

                        @elseif($data_detail->jenis == 2)

                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }} collapse" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: bold;">{{ $data_detail->keterangan }}</td>
                            <td class="money">
                               {{ get_total_neraca_parrent($data_detail->nomor_id, 3, 'P', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>

                          @foreach($data_detail->detail as $detail_dt)
                            <tr>
                              <tr class="treegrid-{{ str_replace('.', '-', $detail_dt->id_group) }} treegrid-parent-{{ str_replace('.', '-', $detail_dt->id_parrent) }} collapse" id="{{ $detail_dt->nomor_id }}">
                                <td style="font-weight: 500; font-style: italic;">Group {{ $detail_dt->nama }}</td>
                                <td class="money">
                                  {{ get_total_neraca_parrent($detail_dt->id_parrent, 5, 'P', $data_real, $throttle, $detail, true) }}
                                </td>
                              </tr>
                            </tr>

                            @foreach($detail_dt->akun as $akun)
                              <?php 
                                $mutasi = (count($akun->mutasi_bank_debet) > 0) ? $akun->mutasi_bank_debet[0]->total : 0;

                                if($throttle == 'bulan')
                                  $coalesce = (strtotime($data_real) < strtotime($akun->opening_date)) ? 0 : $akun->coalesce;
                                else
                                  $coalesce = (date('Y', strtotime($data_real)) < date('Y', strtotime($akun->opening_date))) ? 0 : $akun->coalesce;

                                $total = ($coalesce + $mutasi);

                                if($akun->akun_dka == 'D'){
                                  $total = ($total * -1);
                                }

                                $total_pasiva += $total;
                              ?>

                              <tr>
                                <tr class="treegrid-{{ str_replace('.', '-', $akun->id_akun) }} treegrid-parent-{{ str_replace('.', '-', $akun->group_neraca) }} collapse" id="{{ $akun->id_akun }}">
                                  <td style="font-weight: 500; font-style: italic;">{{ $akun->nama_akun }}</td>
                                  <td class="money">
                                    {{ ($total < 0) ? '('.number_format(str_replace('-', '', $total), 2).')' : number_format(str_replace('-', '', $total), 2) }}
                                  </td>
                                </tr>
                              </tr>
                            @endforeach

                          @endforeach

                        @elseif($data_detail->jenis == 4)
                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }}" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: bold;">&nbsp;</td>
                            <td></td>
                          </tr>

                         @elseif($data_detail->jenis == 3)
                          <tr class="treegrid-{{ str_replace('.', '-', $data_detail->nomor_id) }} treegrid-parent-{{ str_replace('.', '-', $data_detail->id_parrent) }}" id="{{ $data_detail->nomor_id }}">
                            <td class="{{ 'lv'.$data_detail->level }}" style="font-weight: 600; font-style: italic;">{{ $data_detail->keterangan }}</td>
                            <td class="money total">
                              {{ get_total_neraca_parrent($data_detail->nomor_id, 4, 'P', $data_real, $throttle, $detail, true) }}
                            </td>
                          </tr>
>>>>>>> 727c97c1b3fa6d39fa2e9ab5474fbfcb2c1576fc

                          @elseif($data_neraca_aktiva["jenis"] == 3)
                            <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}" id="{{ $data_neraca_aktiva["nomor_id"] }}">
                              <td class="{{ $level }}" style="font-weight: bold; font-style: italic;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                              <td class="money total">
                                {{ ($data_neraca_aktiva["total"] >= 0) ? number_format($data_neraca_aktiva["total"], 2) : "( ".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2)." )" }}
                              </td>
                            </tr>
                          @elseif($data_neraca_aktiva["jenis"] == 4)
                            <tr class="treegrid-{{ str_replace('.', '-', $data_neraca_aktiva['nomor_id']) }} treegrid-parent-{{ str_replace('.', '-', $data_neraca_aktiva['parrent']) }}">
                              <td class="{{ $level }}">&nbsp;</td>
                              <td></td>
                            </tr>
                          @endif
                        @endif
                      @endforeach

                      <tr>
                        <td colspan="2"> &nbsp;</td>
                      </tr>
                      <tr>
                        <td colspan="2"> &nbsp;</td>
                      </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            
          </tbody>

          <tfoot>
            <tr>
              <td>
                <table width="100%" style="font-size: 9pt;">
                  <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td style="font-weight: bold; padding: 5px 10px; font-weight: bold" width="50%">TOTAL AKTIVA</td>
                    <td style="font-weight: 600; padding: 5px 10px;" class="text-right">
                      {{ ($total_aktiva >= 0) ? number_format($total_aktiva, 2) : "( ".number_format(str_replace("-", "", $total_aktiva), 2)." )" }}
                    </td>
                  </tr>
                </table>
              </td>

              <td>
                <table width="100%" style="font-size: 9pt;">
                  <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                    <td style="font-weight: bold; padding: 5px 10px; font-weight: bold" width="50%">TOTAL PASIVA</td>
                    <td style="font-weight: 600; padding: 5px 10px;" class="text-right">
                      {{ ($total_pasiva >= 0) ? number_format($total_pasiva, 2) : "( ".number_format(str_replace("-", "", $total_pasiva), 2)." )" }}
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </tfoot>

        </table>

        <table id="table" width="100%" border="0" style="font-size: 8pt; margin-top: 4px;">
          <thead>
            <tr>
              
            </tr>
          </thead>
        </table>

      </div>

      <!-- modal -->
    <div id="modal_setting_neraca" class="modal">
      <div class="modal-dialog" style="width: 30%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Setting Tampilan Neraca</h4>
            <input type="hidden" class="parrent"/>
          </div>
          <div class="modal-body">
            <div class="row">
              <form id="table_setting_form">
              <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
                <table border="0" id="form-table" class="col-md-12">
                  {{-- <tr>
                    <td width="30%" class="text-center">Pilih Cabang</td>
                    <td colspan="2">
                        <select name="cab" class="select_validate_null form-control" id="group_laba_rugi">
                          
                          @if(Session::get("cabang") == '000')
                            <option value="all">SEMUA CABANG</option>
                          @endif

                          @foreach(cabang() as $cab)
                            <option value="{{ $cab->kode }}">{{ $cab->nama }}</option>
                          @endforeach
                        </select>
                    </td>
                  </tr> --}}

                  <tr>
                    <td width="30%" class="text-center">Jenis Neraca</td>
                    <td colspan="2">
                        <select class="form-control" style="width:90%; height: 30px" id="tampil">
                          <option value="bulan">Neraca Bulan</option>
                          <option value="tahun">Neraca Tahun</option>
                          {{-- <option value="p_bulan">Perbandingan Bulan</option> --}}
                          {{-- <option value="p_tahun">Perbandingan Tahun</option> --}}
                        </select>
                    </td>
                  </tr>

                  <tr>
                    <td width="30%" class="text-center"></td>
                    <td>

                        <input class="form-control text-center date" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:;" readonly data-toggle="tooltip" id="bulan" placeholder="Pilih Bulan">

                        <input class="form-control text-center date_year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_1" placeholder="Bulan Ke-1">

                        <input class="form-control text-center year" style="width:90%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_1" placeholder="Tahun Ke-1">

                    </td>

                    <td>

                        <input class="form-control text-center year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:;" readonly data-toggle="tooltip" id="tahun" placeholder="Pilih Tahun">

                        <input class="form-control text-center date_year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="bulan_2" placeholder="Bulan Ke-2">

                        <input class="form-control text-center year" style="width:80%; height: 30px; cursor: pointer; background: #fff; display:none;" readonly data-toggle="tooltip" id="tahun_2" placeholder="Tahun Ke-2">

                    </td>

                  </tr>
                </table>
              </div>
              </form>

              <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
                <button class="btn btn-primary btn-sm pull-right" id="submit_setting_neraca">Submit</button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
      <!-- modal -->

      <!-- modal -->
    <div id="modal_setting_neraca_perbandingan" class="modal">
      <div class="modal-dialog" style="width: 30%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Setting Tampilan Neraca Perbandingan</h4>
            <input type="hidden" class="parrent"/>
          </div>
          <div class="modal-body">
            <div class="row">
              <form id="table_setting_form_perbandingan">
              <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
                <table border="0" id="form-table" class="col-md-12">

                  <tr>
                    <td width="30%" class="text-center">Jenis Neraca</td>
                    <td colspan="2">
                        <select class="form-control" style="width:90%; height: 30px" id="tampil_perbandingan">
                          <option value="bulan">Perbandingan Neraca Bulan</option>
                          <option value="tahun">Perbandingan Neraca Tahun</option>
                          {{-- <option value="p_bulan">Perbandingan Bulan</option> --}}
                          {{-- <option value="p_tahun">Perbandingan Tahun</option> --}}
                        </select>
                    </td>
                  </tr>

                  <tr>
                    <td width="30%" class="text-center">Neraca 1</td>
                    <td>
                        <input type="text" readonly name="input_1" class="form-control perbandingan_bulan perbandingan_bulan_1" placeholder="Bulan Untuk Neraca 1" style="cursor: pointer;">

                        <input type="text" readonly name="input_1" class="form-control perbandingan_tahun perbandingan_tahun_1" placeholder="Tahun Untuk Neraca 1" style="cursor: pointer; display: none">
                    </td>
                  </tr>

                  <tr>
                    <td width="30%" class="text-center">Neraca 2</td>
                    <td>
                        <input type="text" readonly name="input_2" class="form-control perbandingan_bulan perbandingan_bulan_2" placeholder="Bulan Untuk Neraca 2" style="cursor: pointer;">

                        <input type="text" readonly name="input_2" class="form-control perbandingan_tahun perbandingan_tahun_2" placeholder="Tahun Untuk Neraca 2" style="cursor: pointer; display: none">
                    </td>
                  </tr>

                </table>
              </div>
              </form>

              <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
                <button class="btn btn-primary btn-sm pull-right" id="submit_setting_neraca_perbandingan">Submit</button>
              </div>
            </div>
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
      <script src="{{ asset('assets/vendors/bootstrap-treegrid/js/jquery.treegrid.js') }}"></script>

      <script type="text/javascript">
        $(document).ready(function(){

          $('.aktiva-tree').treegrid({
            onCollapse: function() {
                $(this).children('.money').first().fadeIn('200');
            },
            onExpand: function() {
                $(this).children('.money').first().fadeOut('200');
            }
          });

          $('[data-toggle="tooltip"]').tooltip({container : 'body'});

          baseUrl = '{{ url('/') }}';

          // script for neraca

            $('.date_year').datepicker( {
                format: "mm/yyyy",
                viewMode: "months", 
                minViewMode: "months"
            });

            $('#dateMonth').datepicker( {
                format: "mm",
                viewMode: "months", 
                minViewMode: "months"
            });

            $('.year').datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            });

            $('#bulan').datepicker( {
                format: "mm",
                viewMode: "months", 
                minViewMode: "months"
            });

            $("#tampil").change(function(evt){
                evt.stopImmediatePropagation();
                evt.preventDefault();

                cek = $(this);

                if(cek.val() == "bulan"){
                  // alert("okee");
                  $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
                  $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
                  $("#bulan").css("display", "inline-block"); $("#bulan").val(""); $("#tahun").css("display", "inline-block");
                  $("#bulan").removeAttr("disabled");

                }else if(cek.val() == "tahun"){
                  $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
                  $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
                  $("#bulan").css("display", "inline-block"); $("#tahun").css("display", "inline-block");
                  $("#bulan").attr("disabled", "disabled"); $("#bulan").val("-");
                }else if(cek.val() == "p_bulan"){
                  $("#tahun_1").css("display", "none"); $("#tahun_2").css("display", "none");
                  $("#bulan").css("display", "none"); $("#tahun").css("display", "none");
                  $("#bulan_1").css("display", "inline-block"); $("#bulan_2").css("display", "inline-block");
                }else if(cek.val() == "p_tahun"){
                  $("#bulan_1").css("display", "none"); $("#bulan_2").css("display", "none");
                  $("#bulan").css("display", "none"); $("#tahun").css("display", "none");
                  $("#tahun_1").css("display", "inline-block"); $("#tahun_2").css("display", "inline-block");
                }

               })

               $("#submit_setting_neraca").click(function(event){
                  event.preventDefault();
                  form = $("#table_setting_form"); $(this).attr("disabled", true); $(this).text("Mengubah Tampilan Neraca ...");

                  tampil = $("#tampil").val();

                  if(tampil == "bulan"){

                    data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan").val()+"&y="+$("#tahun").val();

                    if($("#bulan").val() == "" || $("#tahun").val() == ""){
                      toastr.warning('Bulan Dan Tahun Tidak Boleh Kosong');
                      $(this).removeAttr("disabled"); $(this).text("Submit");
                      return false;
                    }else{
                      window.location = baseUrl+"/master_keuangan/neraca/single/"+data;
                    }
                  }else if(tampil == "tahun"){

                    data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan").val()+"&y="+$("#tahun").val();

                    if($("#bulan").val() == "" || $("#tahun").val() == ""){
                      toastr.warning('Tahun Tidak Boleh Kosong');
                      $(this).removeAttr("disabled"); $(this).text("Submit");
                      return false;
                    }else{
                      window.location = baseUrl+"/master_keuangan/neraca/single/"+data;
                    }
                  }else if(tampil == "p_bulan"){

                    data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan_1").val()+"&y="+$("#bulan_2").val();

                    if($("#bulan_1").val() == "" || $("#bulan_2").val() == ""){
                      toastr.warning('Bulan Tidak Boleh Ada Yang Kosong');
                      $(this).removeAttr("disabled"); $(this).text("Submit");
                      return false;
                    }else{
                      window.location = baseUrl+"/master_keuangan/neraca/perbandingan/"+data;
                    }
                  }else if(tampil == "p_tahun"){

                    data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#tahun_1").val()+"&y="+$("#tahun_2").val();

                    if($("#tahun_1").val() == "" || $("#tahun_2").val() == ""){
                      toastr.warning('Tahun Tidak Boleh Ada Yang Kosong');
                      $(this).removeAttr("disabled"); $(this).text("Submit");
                      return false;
                    }else{
                      window.location = baseUrl+"/master_keuangan/neraca/perbandingan/"+data;
                    }
                  }

                  // window.location = baseUrl + "/master_keuangan/saldo_akun?" + form.serialize();
                })

          //end neraca

          // script for neraca

            $('.perbandingan_bulan_2').datepicker( {
                format: "mm-yyyy",
                viewMode: "months", 
                minViewMode: "months"
            })

            $('.perbandingan_bulan_1').datepicker( {
                format: "mm-yyyy",
                viewMode: "months", 
                minViewMode: "months"
            }).on("changeDate", function(){
                $('.perbandingan_bulan_2').val("");
                $('.perbandingan_bulan_2').datepicker("setStartDate", $(this).val());
            });

            $('.perbandingan_tahun_2').datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            })

            $('.perbandingan_tahun_1').datepicker( {
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years"
            }).on("changeDate", function(){
                $('.perbandingan_tahun_2').val("");
                $('.perbandingan_tahun_2').datepicker("setStartDate", $(this).val());
            });

            $('#tampil_perbandingan').change(function(evt){
                evt.preventDefault(); ctx = $(this);

                if(ctx.val() == 'bulan'){
                  $('.perbandingan_bulan').css('display', '');
                  $('.perbandingan_tahun').css('display', 'none');
                }else{
                  $('.perbandingan_tahun').css('display', '');
                  $('.perbandingan_bulan').css('display', 'none');
                }
            })

            $('#submit_setting_neraca_perbandingan').click(function(evt){
              evt.preventDefault();

              if($('#tampil_perbandingan').val() == 'bulan'){
                if($('.perbandingan_bulan_1').val() == '' || $('.perbandingan_bulan_2').val() == ''){
                  alert('Tidak Boleh Ada Bulan Yang Kosong');
                  return false;
                }else{
                  window.location = baseUrl+'/master_keuangan/neraca/perbandingan/'+$('#tampil_perbandingan').val()+'?d1='+$('.perbandingan_bulan_1').val()+'&d2='+$('.perbandingan_bulan_2').val();
                }
              }else{
                if($('.perbandingan_tahun_1').val() == '' || $('.perbandingan_tahun_2').val() == ''){
                  alert('Tidak Boleh Ada tahun Yang Kosong');
                  return false;
                }
              }

              // $('#table_setting_form_perbandingan').submit();
            })

          //end neraca

          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>