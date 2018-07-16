
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

<div class="row">
  <form id="akun_form">
    <input type="hidden" readonly value="{{ csrf_token() }}" name="_token">
  <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
    <table border="0" id="form-table" class="col-md-12">
      <tr>
        <td width="15%" class="text-center">Kode Akun</td>
        <td width="35%" colspan="2">
          <input type="text" readonly class="form_validate form-control text-center" name="kode_akun" placeholder="Kode Akun" id="kode_akun" value="{{ $data->id_akun }}">
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Nama Akun</td>
        <td colspan="2">
          <input type="text" class="form_validate form-control" name="nama_akun" placeholder="Masukkan Nama Akun" id="nama_akun" value="{{ $data->nama_akun }}">
        </td>

        <td width="15%" class="text-center">Cabang</td>
        <td colspan="2">
          <input type="text" class="form-control" id="cabang" name="cabang" readonly value="{{ $data->nama_cabang }}">
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Posisi D/K</td>
        <td colspan="2">
          <?php $dk = ($data->akun_dka == "D") ? "DEBET" : "KREDIT"; ?>
          <input type="text" class="form-control" id="d/k" name="d/k" readonly value="{{ $dk }}">
        </td>

        <td width="15%" class="text-center">Type</td>
        <td colspan="2">
          
          <input type="text" class="form-control" id="type" name="type" readonly value="{{ $data->type_akun }}">
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Status Aktif</td>
        <td colspan="2">
          <?php $status = ($data->is_active == "1") ? "Aktif" : "Tidak Aktif"; ?>
          <input type="text" class="form-control" id="status" name="status" readonly value="{{ $status }}">
        </td>
      </tr>

    </table>
  </div>
  </form>

  <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
    <button class="btn btn-primary btn-sm pull-right" id="simpan">Simpan</button>
  </div>
</div>

<script>
  $(document).ready(function(){

    $(".chosen-select").chosen();
    $('[data-toggle="tooltip"]').tooltip();

    // console.log(cabang);

    $("#saldo").on("change", function(){
      if($(this).is(":checked")){
        $(".saldo_awal").removeAttr("disabled");
        $("#"+$("#akun_dka_view").val()).focus();
      }
      else{
        $(".saldo_awal").attr("disabled", "disabled");
        $(".saldo_awal").val(0);
      }
    })

    $("#kode_cabang").change(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      if($(this).val() !== "---"){
        idx = cabang.findIndex(c => c.kode_cabang === $(this).val());
        $("#add_kode").val(cabang[idx].id_provinsi+""+cabang[idx].kode_cabang);
      }else{
        $("#add_kode").val("");
      }

    })

    $("#kode_akun").keypress(function(evt){
      // console.log(evt)

      if(evt.charCode < 48 || evt.charCode > 57)
        return false;
      else if($(this).val().length == 0 && evt.which == 48)
          return false;

    })

    $('#simpan').click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      btn = $(this);
      btn.attr("disabled", "disabled");
      btn.text("Menyimpan...");

      if(validate_form()){
        $.ajax(baseUrl+"/master_keuangan/akun/update_data",{
          type: "post",
          timeout: 15000,
          data: $("#akun_form").serialize(),
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Master Akun Berhasil Diubah');
              btn.removeAttr("disabled");
              btn.text("Simpan");

              // form_reset();
            }else if(response.status == "exist"){
              toastr.error('Kode Master Akun Sudah Ada Dengan Nama '+response.content+'. Silahkan Membuat Kode Akun Lagi.');
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
              btn.removeAttr("disabled");
          }
        })
      }else{
        btn.removeAttr("disabled");
        btn.text("Simpan");
      }

      return false;
    })

    $("#nama_akun").on("keyup", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
    });

    function validate_form(){
      a = true;
      $(".form_validate").each(function(i, e){
        if($(this).val() == ""){
          a = false;
          $(this).focus();
          toastr.warning('Harap Lengkapi Data Diatas');
          return false;
        }
      })

      $(".select_validate").each(function(i, e){
        if($(this).val() == "---"){
          a = false;
          $(this).focus();
          toastr.warning('Harap Lengkapi Data Diatas');
          return false;
        }
      })

      if($("#saldo").is(":checked") && $("#DEBET").val() == '0,00' && $("#KREDIT").val() == '0,00'){
        a = false;
        $("#saldo_debet").focus()
        toastr.warning('Jika Akun Ini Memiliki Saldo Maka Saldo Tidak Boleh 0.');
      }

      // if($("#saldo").is(":checked")){
      //   alert($("#DEBET").val());
      // }

      return a;
    }

    function form_reset(){
      $(".form_validate").each(function(){
        $(this).val("");
      })

      $(".select_validate").each(function(){
          $(this).val("---");
      })

      $('#kode_cabang').trigger("chosen:updated");
      $('#saldo').prop('checked', false);
      $(".saldo_awal").attr("disabled", "disabled");
      $(".saldo_awal").val(0);
    }
  })
</script>

  