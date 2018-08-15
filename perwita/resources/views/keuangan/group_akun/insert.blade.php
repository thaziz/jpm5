
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
  <div class="col-md-12" style="border-bottom: 1px solid #ddd; border-radius: 0px; padding: 10px; padding-bottom: 15px; padding-top: 0px;">
    <table border="0" id="form-table" class="col-md-12">

      <tr>
        <td width="15%" class="text-center">Jenis</td>
        <td colspan="2">
          <select name="jenis" class="select_validate form-control" id="jenis">
            <option value="1"> Neraca / Balance Sheet</option>
            <option value="2"> Laba Rugi</option>
          </select>
        </td>

        <td width="15%" class="text-center">Nama Group</td>
        <td colspan="2">
            <input type="text" class="form_validate form-control" name="nama_group" placeholder="Masukkan Nama Group" id="nama_group">
        </td>
      </tr>

      <tr id="type_ctn">
        <td class="text-center">Type Group</td>
        <td colspan="2">
          <select name="type" class="select_validate form-control" id="type">
            <option value="A"> Aset</option>
            <option value="P"> Liabilitas</option>
          </select>
        </td>
      </tr>

    </table>
  </div>

  </form>

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

    var state = null; list_akun = [];

    $(".chosen-select").chosen();
    $('[data-toggle="tooltip"]').tooltip();

    // generate_akun("Laba Rugi");

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

      // console.log($("#data_form").serialize());

      if(validate_form()){
        data = {
          _token        : '{{ csrf_token() }}',
          nama          : $("#nama_group").val(),
          jenis         : $("#jenis").val(),
          type          : $('#type').val(),
          akun_inside   : list_akun
        }

        $.ajax(baseUrl+"/master_keuangan/group_akun/save",{
          type: "post",
          timeout: 15000,
          data: data,
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Master Group Akun Berhasil Disimpan');
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

    $("#nama_group").on("keyup", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $("#jenis").change(function(evt){
      evt.preventDefault(); var context = $(this);
      if(context.val() == 2)
        $('#type_ctn').css('display', 'none');
      else
        $('#type_ctn').css('display', '');
    })

    $("#tambah_akun").click(function(evt){
      evt.preventDefault(); var name = $('#jenis');
      $('#overlay').fadeIn(80);
      $('#cab_list_name').text(name.children('option:selected').text());

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
      $("#data_form .form_validate").each(function(i, e){
        if($(this).val() == ""){
          a = false;
          $(this).focus();
          toastr.warning('Harap Lengkapi Data Diatas');
          return false;
        }
      })

      $("#data_form .select_validate").each(function(i, e){
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

      $("#jenis").val(1);
      $("#type").val("A");
      $('#type_ctn').css('display', '');

      // $(".select_validate").each(function(){
      //     $(this).val(1);
      // })

      // $('#kode_cabang').trigger("chosen:updated");
      // $('#saldo').prop('checked', false);
      // $(".saldo_awal").attr("disabled", "disabled");
      // $(".saldo_awal").val(0);
    }

    function generate_akun(jenis){

      html = "";

      if(jenis == "Neraca/Balance Sheet"){
        $.each($.grep(akun, function(n){ return n.group_neraca === "---" }), function(i, n) {

          html = html + '<tr>'+
                          '<td class="text-center">aaa</td>'+
                          '<td class="text-center">'+n.id_akun+'</td>'+
                          '<td>'+n.nama_akun+'</td>'+
                        '</tr>';

        })

      }else{
        $.each($.grep(akun, function(n){ return n.group_laba_rugi === "---" }), function(i, n) {

          html = html + '<tr>'+
                          '<td class="text-center">aaa</td>'+
                          '<td class="text-center">'+n.id_akun+'</td>'+
                          '<td>'+n.nama_akun+'</td>'+
                        '</tr>';

        })
      }

      $("#akun-wrap").html(html);

    }
  })
</script>

  