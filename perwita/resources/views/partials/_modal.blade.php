<style type="text/css">
  
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

 <!-- modal -->
<div id="modal_periode" class="modal">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambahkan Periode Keuangan</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <div class="modal-body" style="padding: 10px;">
          <form role="form" class="form-inline" method="post" action="{{ route('periode_keuangan.tambah') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
              <div class="form-group">
                  <label for="exampleInputEmail2" class="sr-only">Email address</label>
                  <input style="cursor: pointer;" type="text" placeholder="Bulan"
                         class="form-control periode_month" name="bulan" readonly value="{{date('m')}}">
              </div>
              <div class="form-group">
                  <label for="exampleInputPassword2" class="sr-only">Password</label>
                  <input style="cursor: pointer;" type="text" placeholder="Tahun" name="tahun"
                         class="form-control periode_year" readonly value="{{date('Y')}}">
              </div>
              <div class="form-group" style="margin-top: 20px;">
                  <button class="btn btn-primary btn-sm" type="submit" id="submit">Simpan</button>
              </div>

          </form>
      </div>

      {{-- <div class="modal-footer">
          
      </div> --}}
    </div>
  </div>
</div>
  <!-- modal -->

  <!-- modal -->
<div id="modal_setting_neraca" class="modal">
  <div class="modal-dialog" style="width: 30%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tampilan Neraca</h4>
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

  <!-- modal -->
<div id="modal_register_jurnal" class="modal">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Register Jurnal</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <div class="modal-body" style="padding: 10px;">
        <div class="row">
          <form role="form" class="form-inline" id="form-register-jurnal" method="GET" action="{{ route("register_jurnal.index_single") }}" target="_blank">
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
          <form role="form" class="form-inline" id="form-buku-besar" method="GET" action="{{ route("buku_besar.index_single") }}" target="_blank">
              <input type="hidden" value="{{ csrf_token() }}" name="_token" readonly>
              <table border="0" id="form-table" class="col-md-12">

                <input type="hidden" readonly name="jenis" value="Bulan">

                {{-- <tr>
                  <td width="40%" class="text-center">Periode Buku Besar</td>
                  <td colspan="3">
                    <select class="form-control buku_besar select_validate" name="jenis" id="periode_buku_besar" style="width: 80%;">
                      <option value="Bulan">Bulanan</option>
                      <option value="Tahun">Tahunan</option>
                    </select>
                  </td>
                </tr> --}}

                <tr>
                  <td width="40%" class="text-center">Pilih Cabang</td>
                  <td colspan="3">
                    <select class="form-control buku_besar select_bukbes_validate choosen_akun" name="buku_besar_cabang" id="buku_besar_cabang" style="width: 80%;">
                      <option value="---">-- Pilih Cabang</option>

                       {{-- @if(Session::get('cabang') == '000')
                          <option value="all">SEMUA CABANG</option>
                        @endif --}}

                      @foreach(cabang() as $cab)
                        @if($cab->kode == Session::get('cabang') || Session::get('cabang') == '000')
                          <option value="{{ $cab->kode }}">{{ $cab->nama }}</option>
                        @endif
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
          <form role="form" class="form-inline" id="form-neraca-saldo" method="GET" action="{{ route("neraca_saldo.index") }}" target="_blank">
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

   <!-- modal -->
<div id="modal_option_periode" class="modal">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setting Periode Keuangan</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <form id="data_setting" method="post" action="{{ route('periode_keuangan.setting') }}">
      <div class="modal-body" style="padding: 10px;">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
          <table class="table table-bordered table striped table-periode">
            <thead>
                <tr>
                  <th><i class="fa fa-lock fa-fw"></i></th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                </tr>
            </thead>

            <tbody>
              @foreach(get_periode() as $periode)
                <?php 
                  $title = ($periode->status == "locked") ? "Hilangkan Centang Untuk Membuka Kunci" : "Centang untuk Mengunci"
                ?>
                <tr class="text-center">
                  <td>
                    <input type="checkbox" id="{{ $periode->id }}" name="checked[]" {{ ($periode->status == "locked") ? 'checked' : '' }} title="{{ $title }}" value="{{ $periode->id }}">
                  </td>
                  <td>{{ $periode->bulan }}</td>
                  <td>{{ $periode->tahun }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
      </div>

      <div class="modal-footer text-center">
          <button class="btn btn-primary btn-xs" type="submit">Simpan Perubahan</button>
      </div>

      </form>
    </div>
  </div>
</div>
  <!-- modal -->

  <script type="text/javascript">
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

     // $("#save").click(function(evt){
     //    evt.preventDefault();

     //    $(this).attr("disabled", "disabled");
     //    $(this).text("Sedang Menambahkan...");

     //    $.ajax(baseUrl+"/master_keuangan/periode_keuangan/tambah", {
     //       timeout: 500000,
     //       type: "post",
     //       data: {bulan: $("#periode_month").val(), tahun: $("#periode_year").val(), _token: '{{ csrf_token() }}' },
     //       dataType: 'json',
     //       success: function (data) {
     //          console.log(data);
     //           if(data.status == "sukses")
     //            alert("Periode Berhasil Dibuat Dan Secara Otomatis Diaktifkan...");
     //           else if(data.status == "exist")
     //            alert("Periode Sudah Ada. Data Gagal Disimpan...");
     //           else if(data.status == "past_insert")
     //            alert("Anda Tidak Bisa Menambahkan Periode Yang Sudah Berlalu...");

     //          $("#save").text("Simpan");
     //          $("#save").removeAttr("disabled");
     //       },
     //       error: function(request, status, err) {
     //          if (status == "timeout") {
     //            alert("Request Timeout. Data Gagal Ditambahkan");
     //          }else {
     //            alert("Internal Server Error. Data Gagal Ditambahkan");
     //          }

     //          $("#save").text("Simpan");
     //          $("#save").removeAttr("disabled");
     //      }
     //    });
     // })

     // $(".cek").change(function(){

     //    $(".cek").attr("disabled", "disabled");
     //    $id = $(this).attr("id"); $val = ""; $title = "";

     //    $("#sts").text("Sedang Merubah Status...");
     //    $("#sts").fadeIn(100);

     //    if($(this).is(":checked")){
     //      $val = "locked";
     //      $title = "Hilangkan Centang Untuk Membuka Kunci";
     //    }else{
     //      $val = "accessable"
     //      $title = "Centang Untuk Membuka Kunci";
     //    }

     //    $.ajax(baseUrl+"/master_keuangan/periode_keuangan/setting", {
     //       timeout: 10000,
     //       type: "post",
     //       data: {id: $id, val: $val, _token: '{{ csrf_token() }}' },
     //       dataType: 'json',
     //       success: function (data) {
     //           // console.log(data);
     //          if(data.status == "sukses"){
     //            $("#sts").text("Berhasil");
     //            $("#sts").fadeOut(2000);
     //            $("#"+$id).attr("title", $title);
     //          }

     //          $(".cek").removeAttr("disabled");
     //       },
     //       error: function(request, status, err) {
     //          if (status == "timeout") {
     //            alert("Request Timeout. Data Gagal Diubah");
     //          }else {
     //            alert("Internal Server Error. Data Gagal Diubah");
     //          }

     //          $(".cek").removeAttr("disabled");
     //      }
     //    });
     // })

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
                window.open(baseUrl+"/master_keuangan/neraca/single/"+data, '_blank');
              }
            }else if(tampil == "tahun"){

              data = $("#tampil").val()+"?"+form.serialize()+"&m="+$("#bulan").val()+"&y="+$("#tahun").val();

              if($("#bulan").val() == "" || $("#tahun").val() == ""){
                toastr.warning('Tahun Tidak Boleh Kosong');
                $(this).removeAttr("disabled"); $(this).text("Submit");
                return false;
              }else{
                window.open(baseUrl+"/master_keuangan/neraca/single/"+data, '_blank');
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

     // script for buku besar

      akun = [];

      $(".buku_besar.choosen_akun").chosen({ width: '20em' });

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

                $('.buku_besar.choosen_akun').trigger("chosen:updated");

                akun = data;
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
            html = html + '<option value="'+n.id_akun+'">'+n.id_akun+' - '+n.nama_akun+'</option>';
          })
          
          $("#akun2").html(html);
          $('.buku_besar.choosen_akun').trigger("chosen:updated");
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


     // script for neraca_saldo

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

      //end neraca_saldo



  </script>