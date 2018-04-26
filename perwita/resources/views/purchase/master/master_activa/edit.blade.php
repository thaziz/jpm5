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
                    <h2>Master Activa</h2>
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
                            <strong>Create Master Activa</strong>
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
                          <div class="col-xs-6">

                          <table border="0">

                          <tr>
                            <td width="150px">
                           Untuk Cabang
                            </td>
                            <td>
                               <input type="text" name="cabang" class="form-control select_validate" id="cab" required readonly value="{{ $data->nama }}">

                               <input type="hidden" readonly value="{{ $data->kode_cabang }}" name="kode_cabang">
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
                               <input type="text" class="form-control input_validate" readonly placeholder="Kode Aktiva Otomatis" name="kode_aktiva" id="kode_aktiva" required value="{{ $data->id }}">
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
                              <input type="text" class="form-control input_validate" placeholder="Masukkan Nama Aktiva" name="nama_aktiva" id="nama_aktiva" required value="{{ $data->nama_aktiva }}">
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
                              <input type="text" class="form-control input_validate date" placeholder="Pilih Tanggal" name="tanggal_perolehan" id="tanggal_perolehan" required readonly style="cursor: pointer;" value="{{ date("d-m-Y", strtotime($data->tanggal_perolehan)) }}">
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
                              <input type="text" class="form-control input_validate currency text-right" name="nilai_perolehan" id="nilai_perolehan" required value="{{ $data->nilai_perolehan }}" readonly>
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
                              <input type="text" readonly name="acc_debet" class="form-control select_validate" id="acc_debet" required value="{{ $data->acc_debet }}">
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
                              <input type="text" readonly name="csf_kredit" class="form-control select_validate" id="csf_kredit" required value="{{ $data->csf_kredit }}">
                            </td>
                          </tr>

                          <tr>
                          <td>
                            &nbsp;
                          </td>
                          </tr>

                          </table>

                         </div>

                         <div class="col-xs-6">

                          <table border="0">

                          <tr>
                            <td>Keterangan </td>
                            <td>
                              <input type="text" class="form-control input_validate" placeholder="Masukkan Keterangan" name="keterangan" id="keterangan" required value="{{ $data->keterangan }}">
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
                                <input type="text" name="nama_golongan" class="form-control select_validate" id="nama_golongan" required value="{{ $data->nama_golongan }}" readonly>
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
                              <input type="text" class="form-control input_validate golongan" placeholder="Nama Golongan Otomatis" name="kode_golongan" id="kode_golongan" required readonly value="{{ $data->kode_golongan }}">
                            </td>
                          </tr>

                          </table>

                          <table class="table table-bordered tbl-item m-t-lg">
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
                                <input placeholder="Otomatis" type="number" min="1" class="form-control input_validate golongan" name="masa_manfaat_gl" id="masa_manfaat_gl" required readonly value="{{ $data->masa_manfaat_garis_lurus }}">
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" readonly class="form-control input_validate golongan" name="persentase_gl" id="persentase_gl" required value="{{ $data->persentase_garis_lurus }}">
                              </td>
                            </tr>
                           
                            <tr>
                              <td>  Saldo Menurun
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" class="form-control input_validate golongan" name="masa_manfaat_sm" id="masa_manfaat_sm" required readonly value="{{ $data->masa_manfaat_saldo_menurun }}">
                              </td>
                              <td>
                                <input placeholder="Otomatis" type="number" min="1" readonly class="form-control input_validate golongan" name="persentase_sm" id="persentase_sm" required value="{{ $data->persentase_saldo_menurun }}">
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
                  
                    <a class="btn btn-warning btn-sm" href={{url('masteractiva/masteractiva/'.Session::get("cabang"))}}  style="font-size: 8pt;"> Kembali </a>
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


      // console.log(golongan);

      $('[data-toggle="tooltip"]').tooltip();
      // $(".chosen-select").chosen({width: '100%'});
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

        info.text("Sedang Membuat Kode...")
        info.css("display", "");

        if($("#cab").val() == "---"){
          info.text("Pilih Cabang Dahulu");
          setTimeout(function(){ info.fadeOut(1000,"linear"); }, 1000);

          return false;
        }

        $.ajax(baseUrl+"/master_aktiva/ask_kode_master_aktiva/"+$("#cab").val(),{
          type: "get",
          dataType: 'json',
          success: function(response){
            $("#kode_aktiva").val('MA-00'+response);
            info.css("display", "none");
          },
          error: function(request, status, err) {
              if (status == "timeout") {
                info.text("Waktu Habis. Coba Lagi");
                setTimeout(function(){ info.fadeOut(1000,"linear"); }, 1000);
              } else {
                info.text("Internal Error, Coba Lagi");
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

          $.ajax(baseUrl+"/master_aktiva/update",{
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
