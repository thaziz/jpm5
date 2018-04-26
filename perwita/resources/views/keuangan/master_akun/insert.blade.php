
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
        <td width="18%">
          <input type="text" display: inline-block;" class="form_validate form-control text-center" name="kode_akun" placeholder="Kode Akun" id="kode_akun">
        </td>

        <td width="18%" data-toggle="tooltip" data-placement="top" title="Tambahan Kode Akun. Sesuai Dengan Cabang Yang Dipilih">
          <input type="text" display: inline-block;" class="form_validate form-control text-center" name="add_kode" id="add_kode" placeholder="Otomatis" readonly>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Nama Akun</td>
        <td colspan="2">
          <input type="text" class="form_validate form-control" name="nama_akun" placeholder="Masukkan Nama Akun" id="nama_akun">
        </td>

        <td width="15%" class="text-center">Cabang</td>
        <td colspan="2">
          <select name="kode_cabang" class="select_validate form-control chosen-select" id="kode_cabang">
            <option value="---"> -- Pilih Cabang</option>

            @foreach($cabang as $cab)
              <option value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
            @endforeach

          </select>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Posisi D/K</td>
        <td colspan="2">
          <select name="posisi_dk" class="select_validate form-control" id="posisi_dk">
            <option value="---"> -- Pilih Posisi D/K</option>
            <option value="D">DEBET</option>
            <option value="K">KREDIT</option>
          </select>
        </td>

        <td width="15%" class="text-center">Type</td>
        <td colspan="2">
          <select name="type_akun" class="select_validate form-control" id="type_akun">
            <option value="---"> -- Pilih Type Akun</option>
            <option value="ICF">ICF</option>
            <option value="OCF">OCF</option>
            <option value="FCF">FCF</option>
          </select>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Status Aktif</td>
        <td colspan="2">
          <select name="status_aktif" class="select_validate form-control" id="status_aktif">
            <option value="---"> -- Pilih Status Aktif</option>
            <option value="1"> Aktif</option>
            <option value="2"> Tidak</option>
          </select>
        </td>
      </tr>

    </table>
  </div>

  <div class="col-md-12 m-t-lg" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
    <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Isian Saldo Akun</small></span>
    
    <input type="checkbox" id="saldo" name="saldo" style="margin-top: 10px;"> &nbsp;<small>Akun Ini Memiliki Saldo. (Anda Juga Bisa Mengisi Saldo Awal Di Halaman Saldo Akun)</small>
    <table id="form-table" width="100%" border="1" style="margin-top: 10px;">
      <thead>
        <tr>
          <th class="text-center" width="26%" style="padding: 5px 0px; border:1px solid #eee">Keterangan</th>
          <th class="text-center" width="37%" style="padding: 5px 0px; border:1px solid #eee">Debet</th>
          <th class="text-center" style="padding: 5px 0px; border:1px solid #eee">Kredit</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="text-center" style="padding: 3px 0px; border:1px solid #eee">Saldo Awal</td>
          <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
            <center>
              <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal form-control text-right" type="text" disabled required name="saldo_debet" value="0" style="width: 85%;" id="DEBET" onkeyup="if(this.value != 'Rp 0,00'){$('#KREDIT').val(0)}">
            </center>
          </td>

          <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
            <center>
              <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal form-control text-right" type="text" disabled required name="saldo_kredit" value="0" style="width: 85%;" id="KREDIT" onkeyup="if(this.value != 'Rp 0,00'){$('#DEBET').val(0)}">
            </center>
          </td>
        </tr>
      </tbody>
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

    var cabang = {!! $cabangjson !!};

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
      // btn.attr("disabled", "disabled");
      // btn.text("Menyimpan...");

      if(validate_form()){
        $.ajax(baseUrl+"/master_keuangan/akun/save_data",{
          type: "post",
          timeout: 15000,
          data: $("#akun_form").serialize(),
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Master Akun Berhasil Disimpan');
              btn.removeAttr("disabled");
              btn.text("Simpan");

              form_reset();
            }else if(response.status == "exist"){
              toastr.error('Kode Master Akun Sudah Ada. Silahkan Membuat Kode Akun Lagi.');
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
        btn.text("simpan");
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

  