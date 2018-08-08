
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
  <form id="data_form">
    <input type="hidden" readonly value="{{ csrf_token() }}" name="_token">
  <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
    <table border="0" id="form-table" class="col-md-12">
      <tr>
        <td width="15%" class="text-center">Kode Group</td>
        <td colspan="2" width="35%">
          <div class="input-group" style="width: 80%">
            <input type="text" display: inline-block;" class="form_validate form-control text-center" name="kode_group" placeholder="Kode Group" id="kode_group" data-toggle="tooltip" data-placement="top" title="Hanya Memperbolehkan Input Angka" value="{{ $group->id }}" readonly>
          </div>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Nama Group</td>
        <td colspan="2">
          <input type="text" class="form_validate form-control" name="nama_group" placeholder="Masukkan Nama Group" id="nama_group" value="{{ $group->nama_group }}">
        </td>

        <td width="15%" class="text-center">Jenis</td>
        <td colspan="2">
          <select name="jenis" class="select_validate form-control" id="jenis" disabled>
            <option value="1"> Neraca / Balance Sheet</option>
            <option value="2"> Laba Rugi</option>
          </select>
        </td>
      </tr>

    </table>
  </div>

  </form>

  <div class="col-md-12 m-t" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
    <table class="table table-bordered tabel-list no-margin" id="table" style="padding:0px; font-size: 8pt;">
      <thead>
        <tr>
          <th style="position: sticky;top: 0px;" width="5%">*</th>
          <th style="position: sticky;top: 0px;" width="15%">Kode Akun</th>
          <th style="position: sticky;top: 0px;" width="60%">Nama Akun</th>
        </tr>
      </thead>

      <tbody>
          @foreach($data_akun as $key => $akun)
            <tr>
              <td style="background: white;" class="text-center"><input type="checkbox" value="{{ $akun->id_akun }}" class="deleted_check" checked="true"></td>
              <td style="background: white;">{{ $akun->id_akun }}</td>
              <td style="background: white;">{{ $akun->main_name }}</td>
            </tr>
          @endforeach
      </tbody>
    </table>
  </div>

  <div class="col-md-6" style="border-top: 0px solid #eee; padding: 13px 10px 0px 0px; background: none; margin-top: 10px;">
    <small class="text-info" style="font-style: italic;"><span id="akun_counter" style="font-weight: bold;">0</span> Akun Telah Ditambahkan Di Group Ini</small>
  </div>

  <div class="col-md-6 text-right" style="border-top: 0px solid #eee; padding: 10px 10px 0px 0px; background: none; margin-top: 10px;">
    <button class="btn btn-default btn-sm" id="tambah_akun">Tambahkan Akun</button>
    <button class="btn btn-primary btn-sm" id="simpan">Simpan</button>
  </div>

</div>

<script>
  $(document).ready(function(){

    var state = null; var deleted_akun = []; list_akun = [];

    $(".chosen-select").chosen();
    $('[data-toggle="tooltip"]').tooltip();
    $("#jenis").val('{{ $group->jenis_group }}');

    console.log(deleted_akun);
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

    $("#kode_group").keypress(function(evt){
      // console.log(evt)

      if(evt.charCode < 48 || evt.charCode > 57)
        return false;

    })

    $('#simpan').click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      btn = $(this);
      btn.attr("disabled", "disabled");
      btn.text("Menyimpan...");

      if(validate_form()){

        data = {
          _token        : '{{ csrf_token() }}',
          nama          : $("#nama_group").val(),
          jenis         : $("#jenis").val(),
          kode_group    : $("#kode_group").val(),
          akun_inside   : list_akun,
          deleted_akun  : deleted_akun
        }

        $.ajax(baseUrl+"/master_keuangan/group_akun/update",{
          type: "post",
          timeout: 15000,
          data: data,
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Master Group Akun Berhasil Diubah');
              btn.removeAttr("disabled");
              btn.text("Simpan");

              form_reset();
            }else if(response.status == "exist"){
              toastr.error('Kode Master Group Akun Sudah Ada Dengan Nama "'+response.content+'". Silahkan Membuat Kode Akun Lagi.');
              btn.removeAttr("disabled");
              btn.text("Simpan");
            }
          },
          error: function(request, status, err) {
              if (status == "timeout") {
                toastr.error('Request Timeout. Data Gagal Diubah');
                btn.removeAttr("disabled");
                btn.text("Simpan");
              } else {
                toastr.error('Internal Server Error. Data Gagal Diubah');
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

    $("#nama_group").on("keyup", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $("#tambah_akun").click(function(evt){
      evt.preventDefault(); var name = $('#jenis');
      $('#overlay').fadeIn(80);
      $('#cab_list_name').text('Data Akun Yang Belum Memiliki Grup '+name.children('option:selected').text());

      if(state != name.val()){
        $("#overlay .modal-body").html('<center class="text-muted">Sedang Memuat ...</center>');
        list_akun = [];
      }else{
        return;
      }

      $.ajax(baseUrl+"/master_keuangan/group_akun/list_akun?keyword="+name.val(), {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#overlay .modal-body").html(data);
             state = name.val();
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#overlay .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#overlay .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $(".overlay_close").click(function(){
      $("#overlay").fadeOut(100);
      $('#akun_counter').text(list_akun.length);
    });

    $('.deleted_check').change(function(){
      if($(this).is(':checked'))
        deleted_akun.splice(deleted_akun.findIndex(u => u.id_akun == $(this).val()), 1);
      else
        deleted_akun.push($(this).val());
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
          $(this).val("Neraca/Balance Sheet");
      })

      // $('#kode_cabang').trigger("chosen:updated");
      // $('#saldo').prop('checked', false);
      // $(".saldo_awal").attr("disabled", "disabled");
      // $(".saldo_awal").val(0);
    }
  })
</script>

  