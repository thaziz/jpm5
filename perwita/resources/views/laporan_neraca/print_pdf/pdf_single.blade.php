<!DOCTYPE html>
  <html>
    <head>
      <title>laporan Neraca</title>


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

        <table id="table-data" width="100%" border="0">
          <thead>
            <tr>
              <th width="50%" class="text-left" style="border-right: 3px solid #ccc">Aktiva</th>
              <th width="50%" class="text-right">Pasiva</th>
            </tr>
          </thead>

          <tbody>
            
            <tr>
              <td style="border-right: 3px solid #ccc;">
                <table id="table-data-inside" border="0" width="100%">
                  <tbody>
                    
                      <?php $total_aktiva = 0; $total_pasiva = 0; ?>

                        @foreach($data_neraca as $data_neraca_aktiva)
                          @if($data_neraca_aktiva["type"] == "aktiva")
                            <?php 
                              $level = "lv".$data_neraca_aktiva["level"];
                              $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                              $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                            ?>
                            
                            @if($data_neraca_aktiva["jenis"] == 1)
                              <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td colspan="2" class="{{ $level }}" style="font-weight: bold;">{{ $data_neraca_aktiva["keterangan"] }}</td>
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

                              <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" width="60%">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money">{{ ($totDetail >= 0) ? number_format($totDetail, 2) : "(".number_format(str_replace("-", "", $totDetail), 2).")" }}</td>
                              </tr>
                            @elseif($data_neraca_aktiva["jenis"] == 3)
                              <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" style="font-weight: 600; font-style: italic;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money total">
                                  {{ ($data_neraca_aktiva["total"] >= 0) ? number_format($data_neraca_aktiva["total"], 2) : "( ".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2)." )" }}
                                </td>
                              </tr>
                            @elseif($data_neraca_aktiva["jenis"] == 4)
                              <tr>
                                <td class="{{ $level }}">&nbsp;</td>
                                <td></td>
                              </tr>
                            @endif
                          @endif
                        @endforeach

                        <tr>
                          <td colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                          <td colspan="2">&nbsp;</td>
                        </tr>

                  </tbody>
                </table>
              </td>

              <td>
                <table id="table-data-inside" border="0" width="100%">
                  <tbody>
                    
                      @foreach($data_neraca as $data_neraca_aktiva)
                        @if($data_neraca_aktiva["type"] == "pasiva")
                          <?php 
                            $level = "lv".$data_neraca_aktiva["level"];
                            $tree_parrent = ($data_neraca_aktiva['parrent'] == "") ? "" : "treegrid-parent-".str_replace(".", "_", $data_neraca_aktiva["parrent"]);;
                            $treegrid = "treegrid-".str_replace(".", "_", $data_neraca_aktiva["nomor_id"]);
                          ?>
                          
                          @if($data_neraca_aktiva["jenis"] == 1)
                            <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                              <td colspan="2" class="{{ $level }}" style="font-weight: bold;">{{ $data_neraca_aktiva["keterangan"] }}</td>
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

                              <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                                <td class="{{ $level }}" width="60%">{{ $data_neraca_aktiva["keterangan"] }}</td>
                                <td class="money">{{ ($totDetail >= 0) ? number_format($totDetail, 2) : "(".number_format(str_replace("-", "", $totDetail), 2).")" }}</td>
                              </tr>

                          @elseif($data_neraca_aktiva["jenis"] == 3)
                            <tr id="{{ $data_neraca_aktiva["nomor_id"] }}">
                              <td class="{{ $level }}" style="font-weight: bold; font-style: italic;">{{ $data_neraca_aktiva["keterangan"] }}</td>
                              <td class="money total">
                                {{ ($data_neraca_aktiva["total"] >= 0) ? number_format($data_neraca_aktiva["total"], 2) : "( ".number_format(str_replace("-", "", $data_neraca_aktiva["total"]), 2)." )" }}
                              </td>
                            </tr>
                          @elseif($data_neraca_aktiva["jenis"] == 4)
                            <tr>
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
                  <tr>
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
                  </tr>

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

          $('#print').click(function(evt){
            evt.preventDefault();

            window.print();
          })

        })
      </script>
    </body>
  </html>