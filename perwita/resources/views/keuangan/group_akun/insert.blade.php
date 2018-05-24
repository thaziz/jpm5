
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
          <div class="input-group" style="width: 97%">
            <span class="input-group-addon" style="font-size: 8pt;">GA -</span>
            <input type="text" display: inline-block;" class="form_validate form-control text-center" name="kode_group" placeholder="Kode Group" id="kode_group" data-toggle="tooltip" data-placement="top" title="Hanya Memperbolehkan Input Angka">
          </div>
        </td>

        <td colspan="3" class="text-center">
          <small class="text-muted">Kode Group Terakhir Di Database &nbsp;<i class="fa fa-arrow-right"></i>&nbsp; {{ $ids }}</small>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Nama Group</td>
        <td colspan="2">
          <input type="text" class="form_validate form-control" name="nama_group" placeholder="Masukkan Nama Group" id="nama_group">
        </td>

        <td width="15%" class="text-center">Jenis</td>
        <td colspan="2">
          <select name="jenis" class="select_validate form-control" id="jenis">
            <option value="Neraca/Balance Sheet"> Neraca / Balance Sheet</option>
            <option value="Laba Rugi"> Laba Rugi</option>

            {{-- @foreach($cabang as $cab)
              <option value="{{ $cab->kode_cabang }}">{{ $cab->nama_cabang }}</option>
            @endforeach --}}

          </select>
        </td>
      </tr>

    </table>
  </div>


  {{-- <div class="col-md-12 m-t" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">

    <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Pilih Akun</small></span>
    
    <div class="col-md-12 m-t" style="padding: 0px; height: 300px; overflow-y: scroll; border-bottom: 1px solid #bbb;">
      <table border="0" class="table table-bordered" style="padding:0px; font-size: 8pt;">
        
        <thead>
          <tr>
            <th width="10%" style="background: white; color: #999;position: sticky;top: 0;">
              <input type="checkbox" name="check_all" id="check_all">
            </th>
            <th width="15%" style="background: white; color: #999;position: sticky;top: 0;">ID Akun</th>
            <th style="background: white; color: #999;position: sticky;top: 0;">Nama Akun</th>
          </tr>
        </thead>
        
        <tbody id="akun-wrap">

        </tbody>

      </table>
    </div>
  </div> --}}

  </form>

  <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
    <button class="btn btn-primary btn-sm pull-right" id="simpan">Simpan</button>
  </div>
</div>

<script>
  $(document).ready(function(){

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

      if(validate_form()){
        $.ajax(baseUrl+"/master_keuangan/group_akun/save",{
          type: "post",
          timeout: 15000,
          data: $("#data_form").serialize(),
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

  