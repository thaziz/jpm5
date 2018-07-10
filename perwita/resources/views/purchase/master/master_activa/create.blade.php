@extends('main')

@section('title', 'dashboard')

@section('content')

 <style>
   table{
    font-size: 8pt;
   }

   .form-control{
    font-size: 8pt;
   }
 </style>

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Golongan Activa</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong>Create Golongan Activa</strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Tambah Data Master Activa
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="form-data" action="post" method="POST">
                    <input type="hidden" readonly value="{{ csrf_token() }}" name="_token"> 
                  <div class="box-body">
                       <div class="row">
                          <div class="col-xs-7">

                          <table border="0">

                          <tr>
                            <td width="150px">
                           Untuk Cabang
                            </td>
                            <td width="50%">
                               <select name="cabang" class="form-control chosen-select select_validate" id="cab" required>
                                  <option value="---">- Pilih Cabang</option>
                                  @foreach ($cab as $cabang)
                                    <?php 
                                        $selected = ($cabang->kode == Session::get("cabang")) ? "selected" : "";
                                    ?>
                                    <option value="{{ $cabang->kode }}" {{ $selected }}>{{ $cabang->nama }}</option>
                                  @endforeach
                                </select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td width="150px">
                           Kode Activa
                            </td>
                            <td>
                               <input type="text" class="form-control input_validate" readonly placeholder="Kode Aktiva Otomatis" name="kode_aktiva" id="kode_aktiva" required>
                            </td>
                            <td>
                              &nbsp;&nbsp;&nbsp;&nbsp; 
                                <i data-toggle="tooltip" data-placement="top" title="Klik Untuk Membuat Kode Aktiva" class="fa fa-refresh" style="cursor: pointer;" id="generate_kode"></i>
                              &nbsp;
                                <span class="text-muted" style="font-style: italic; display: none; color: #1ab394;" id="kode_info"></span>
                            </td>
                          </tr>

                          <tr>
                          <td>
                          &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>ACC Debet </td>
                            <td>
                              <select name="acc_debet" class="form-control chosen-select select_validate" id="acc_debet" required>
                                  <option value="---">- Pilih ACC</option>
                                  @foreach ($akun as $data_akun)
                                    <option value="{{ $data_akun->id_akun }}">{{ $data_akun->nama_akun }}</option>
                                  @endforeach
                                </select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>CSF Kredit</td>
                            <td>
                              <select name="csf_kredit" class="form-control chosen-select select_validate" id="csf_kredit" required>
                                  <option value="---">- Pilih CSF</option>
                                  @foreach ($akun as $data_akun2)
                                    <option value="{{ $data_akun2->id_akun }}">{{ $data_akun2->nama_akun }}</option>
                                  @endforeach
                                </select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>Nama Activa </td>
                            <td>
                              <input type="text" class="form-control input_validate" placeholder="Masukkan Nama Aktiva" name="nama_aktiva" id="nama_aktiva" required>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>Tanggal Perolehan </td>
                            <td>
                              <input type="text" class="form-control input_validate date" placeholder="Pilih Tanggal" name="tanggal_perolehan" id="tanggal_perolehan" required readonly style="cursor: pointer;" value="{{ date("Y/m/d") }}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>Nilai Perolehan</td>
                            <td>
                              <input type="text" class="form-control input_validate currency text-right" name="nilai_perolehan" id="nilai_perolehan" required>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          </table>

                         </div>

                         <div class="col-xs-5">

                           <table border="0">

                          <tr>
                            <td>Keterangan </td>
                            <td>
                              <input type="text" class="form-control input_validate" placeholder="Masukkan Keterangan" name="keterangan" id="keterangan" required>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td width="40%">
                              Nama Golongan
                            </td>
                            <td id="gol">
                                <select name="nama_golongan" class="form-control chosen-select select_validate" id="nama_golongan" required>
                                  
                                </select>
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          <tr>
                            <td>Kode Golongan </td>
                            <td>
                              <input type="text" class="form-control input_validate golongan" placeholder="Nama Golongan Otomatis" name="kode_golongan" id="kode_golongan" required readonly>
                            </td>
                          </tr>

                          </table>

                          <table class="table table-bordered table-striped tbl-item m-t-lg">
                          <thead>
                          <tr>
                            <th class="text-center" width="30%" style="font-weight: normal;">
                              Metode
                            </th>
                            <th class="text-center" width="35%" style="font-weight: normal;">
                              Masa Manfaat (tahun)
                            </th>
                            <th class="text-center" width="35%" style="font-weight: normal;">
                            Persentase (%)
                            </th>
                          </tr>
                          </thead>
                         
                          <tbody>
                            <tr>
                              <td>
                                Garis Lurus
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" class="form-control input_validate golongan" name="masa_manfaat_gl" id="masa_manfaat_gl" required readonly>
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" readonly class="form-control input_validate golongan" name="persentase_gl" id="persentase_gl" required>
                              </td>
                            </tr>
                           
                            <tr>
                              <td>  Saldo Menurun
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" class="form-control input_validate golongan" name="masa_manfaat_sm" id="masa_manfaat_sm" required readonly>
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" readonly class="form-control input_validate golongan" name="persentase_sm" id="persentase_sm" required>
                              </td>
                            </tr>
                          </tbody>
                          
                         

                          </table>


                         </div>
                         </div>

                    </div>
                    </form>

                    <hr>

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning btn-sm" href={{url('golonganactiva/golonganactiva/'.Session::get("cabang"))}}  style="font-size: 8pt;"> Kembali </a>
                      <button type="button" id="submit" name="submit" class="btn btn-success btn-sm" style="font-size: 8pt;">Simpan</button>
                    
                    </div>
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
  <script src="{{ asset('assets/vendors/inputmask/inputmask.jquery.js') }}"></script>

  <script type="text/javascript">
     
    $(document).ready(function(){

      var golongan = {!! $gol !!};
      generate_gol("{{ Session::get("cabang") }}");

      console.log(golongan);

      $('[data-toggle="tooltip"]').tooltip();
      $(".chosen-select").chosen({width: '100%'});
      $('.date').datepicker({
          format: "yyyy/mm/dd",
      });

      $('.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: '', //Space after $, this will not truncate the first character.
          rightAlign: false,
          oncleared: function () { self.Value(''); }
      });

      $("#generate_kode").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        info = $("#kode_info");

        info.text("Membuat Kode...")
        info.css("display", "");

        if($("#cab").val() == "---"){
          info.text("Pilih Cabang Dahulu");
          setTimeout(function(){ info.fadeOut(1000,"linear"); }, 1000);

          return false;
        }

        $.ajax(baseUrl+"/masteractiva/ask_kode/"+$("#cab").val(),{
          type: "get",
          dataType: 'json',
          success: function(response){
            $("#kode_aktiva").val('MA-00'+response);
            info.css("display", "none");
          },
          error: function(request, status, err) {
              if (status == "timeout") {
                info.text("Waktu Habis");
                setTimeout(function(){ info.fadeOut(1000,"linear"); }, 1000);
              } else {
                info.text("Internal Error");
                setTimeout(function(){ info.fadeOut(1000,"linear"); }, 1000);
              }

              $("#simpan").removeAttr("disabled");
          }
        })
      })

      $("#submit").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        btn = $(this);

        btn.attr("disabled", "disabled");
        btn.text("Menyimpan...");

        if(validate_form()){

          $.ajax(baseUrl+"/master_aktiva/simpan",{
          type: "post",
          timeout: 15000,
          data: $("#form-data").serialize(),
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Master Aktiva Berhasil Disimpan');
              btn.removeAttr("disabled");
              btn.text("Simpan");

              form_reset();
            }else if(response.status == "exist"){
              toastr.error('Kode Master Aktiva Sudah Ada. Silahkan Membuat Kode Master Lagi.');
              btn.removeAttr("disabled");
              btn.text("Simpan");
            }
          },
          error: function(request, status, err) {
              if (status == "timeout") {
                toastr.error('Request Timeout. Data Gagal Disimpan');
                btn.removeAttr("disabled");
                btn.text("Simpan");
              } else {
                toastr.error('Internal Server Error. Data Gagal Disimpan');
                btn.removeAttr("disabled");
                btn.text("Simpan");
              }

              $("#simpan").removeAttr("disabled");
          }

        })
        }else{
          btn.removeAttr("disabled");
          btn.text("Simpan");
        }

      })

      $("#cab").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $("#kode_aktiva").val("");

        if($(this).val() == "---"){

          $("#nama_golongan").val("---");
          $('#nama_golongan').trigger("chosen:updated");
          generate_gol("null");

        }else{
          generate_gol($(this).val());
        }

        $(".golongan").val("");
      })

      $("#s_k").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $("#sk_view").val($(this).val())
      })

      $("#nama_golongan").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        value = $(this).val();

        if(value == "---"){
          $(".golongan").val("");
        }else{
          idx = golongan.findIndex(c => c.id == value);

          $("#kode_golongan").val(golongan[idx].id);
          $("#masa_manfaat_gl").val(golongan[idx].masa_manfaat_garis_lurus);
          $("#persentase_gl").val(golongan[idx].persentase_garis_lurus);
          $("#masa_manfaat_sm").val(golongan[idx].masa_manfaat_saldo_menurun);
          $("#persentase_sm").val(golongan[idx].persentase_saldo_menurun);
        }

      })

      $(":input[type='number']").keypress(function(evt){
        // console.log(evt.which)

        if(evt.which == 101 || evt.which == 69)
          return false;
        else if($(this).val().length == 0 && evt.which == 48)
          return false;
      })


      $("#masa_manfaat_gl").on("keyup", function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        val = 100 / $(this).val();

        $("#persentase_gl").val(val.toFixed(2));
      })

      $("#masa_manfaat_sm").on("keyup", function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        val = 100 / $(this).val();

        $("#persentase_sm").val(val.toFixed(2));
      })

      function generate_gol(id){
        html = '<option value="---">- Pilih Golongan</option>';
        $.each($.grep(golongan, function(a, b){ return a.kode_cabang == id}), function(i, n){
          html = html+'<option value="'+n.id+'">'+n.nama_golongan+'</option>'
        })

        $("#nama_golongan").html(html);
        $('#nama_golongan').trigger("chosen:updated"); 
      }

      function validate_form(){
        a = true;
        $(".input_validate").each(function(i, e){
          if($(this).val() == ""){
            a = false;
            toastr.warning('Harap Lengkapi Data Diatas');
            return false;
          }
        })

        return a;
      }

      function form_reset(){
        $(".input_validate").each(function(){
          if($(this).attr("id") == "sk_view")
            $(this).val("K")
          else
            $(this).val("");
        })

        $("#cab").val("---");
        $('#cab').trigger("chosen:updated"); 
        $("#s_k").val("K");
      }
    })

  </script>
@endsection

