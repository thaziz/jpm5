
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
        <td width="15%" class="text-center">Cabang</td>
        <td colspan="2">
          <select name="cabang" class="select_validate form-control chosen-select" id="cabang">
            @foreach($cabangs as $cab)
              <option value="{{$cab->kode}}">{{$cab->nama}}</option>
            @endforeach
          </select>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center">Nama Transaksi</td>
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control" name="jr_detail" placeholder="Masukkan Nama Transaksi" id="jr_detail">
        </td>

        <td width="15%" class="text-center">Tanggal Transaksi</td>
        <td colspan="2">
          <input type="text" class="form_validate form-control text-center" name="jr_date" readonly id="jr_date" value="{{date("d-m-Y")}}" readonly>
        </td>
      </tr>

      <tr>
        <td width="15%" class="text-center" style="vertical-align: top;">Catatan</td>
        <td colspan="2">
          <textarea name="jr_note" class="input-Validity upper form-control form_validate" style="resize: none;height: 100px;" placeholder="Masukkan Catatan Jurnal Disini"></textarea>
        </td>
      </tr>

    </table>
  </div>

  <div class="col-md-12 m-t-lg" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Isian Akun COA</small></span>

    <div id="saldo_all" class="text-center" style="padding: 10px 5px;">

      <div class="col-md-6" style="padding: 0px; padding-right: 8px;">
        <table border="0" id="form-table" class="col-md-12">
          <tbody>
            <tr>
              <td colspan="3" style="background: #0099CC; border: 1px solid white; color: white;">
                <strong>

                  <span class="pull-left" style="padding-left: 10px; cursor: pointer;">
                    <i class="fa fa-plus add_row" data-table="debet"></i>
                  </span>

                  Debet 
                </strong>
              </td>
            </tr>

            <tr>
              <td width="55%" class="text-left">
                <select name="nama_akun_debet[]" class="select_validate form-control chosen-select akun">
                  <option value="---"> -- Pilih Akun Coa</option>

                </select>
              </td>

              <td width="100%" class="text-left" style="padding-right: 0px;">
                <div class="input-group" style="padding: 0px;">
                  <input type="text" name="debet[]" value="0" class="currency debet form-control text-right" style="width: 100%">
                  <span class="input-group-btn">
                    <button class="btn btn-danger delete_row" type="button" style="padding: 6px 6px 5px 6px;font-size: 8pt;" data-id="debet"><i class="fa fa-eraser"></i></button>
                  </span>
                </div><!-- /input-group -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="col-md-6" style="padding: 0px; padding-left: 8px;">
        <table border="0" id="form-table" class="col-md-12">
          <tbody>
            <tr>
              <td colspan="3" style="background: #0099CC; border: 1px solid white; color: white;">
                <strong>

                  <span class="pull-left" style="padding-left: 10px; cursor: pointer;">
                    <i class="fa fa-plus add_row" data-table="kredit"></i>
                  </span>

                  Kredit 
                </strong>
              </td>
            </tr>

            <tr>
              <td width="55%" class="text-left">
                <select name="nama_akun_kredit[]" class="select_validate form-control chosen-select akun">
                  <option value="---"> -- Pilih Akun Coa</option>

                </select>
              </td>

              <td width="100%" class="text-left" style="padding-right: 0px;">
                <div class="input-group" style="padding: 0px;">
                  <input type="text" name="kredit[]" value="0" class="currency kredit form-control text-right" style="width: 100%">
                  <span class="input-group-btn">
                    <button class="btn btn-danger delete_row" type="button" style="padding: 6px 6px 5px 6px;font-size: 8pt;" data-id="kredit"><i class="fa fa-eraser"></i></button>
                  </span>
                </div><!-- /input-group -->
              </td>
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>

  <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 0px; padding: 10px; margin-top: 5px; border-top: 0px;">
      <div class="col-md-6">
        <input type="text" readonly class="form-control currency text-center" style="font-size: 8pt;" name="total_debet" id="total_debet">
      </div>

      <div class="col-md-6">
        <input type="text" readonly class="form-control currency text-center" style="font-size: 8pt;" name="total_kredit" id="total_kredit">
      </div>

  </div>

  </form>

  <div class="col-md-12 m-t" style="border-top: 1px solid #eee; padding: 10px 10px 0px 0px;">
    <button class="btn btn-primary btn-sm pull-right" id="simpan">Simpan</button>
  </div>
</div>

<script>
  $(document).ready(function(){

    akun = {!! $akun !!};

    $(".chosen-select.akun").html(initiate_akun('{{$cabang->kode}}'));
    $('.chosen-select.akun').trigger("chosen:updated");

    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: '', //Space after $, this will not truncate the first character.
          rightAlign: false,
          oncleared: function () { self.Value(''); }
      });

      $(".chosen-select").chosen()
    }

    $(this).maskFunc();

    $('#simpan').click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      btn = $(this);
      btn.attr("disabled", "disabled");
      btn.text("Menyimpan...");

      if($("#total_debet").val() != $("#total_kredit").val()){
        alert("Total Debet Kredit Harus Sama");
        btn.removeAttr("disabled");
        btn.text("Simpan");

        return;
      }

      if(validate_form()){
        $.ajax(baseUrl+"/keuangan/jurnal_umum/save_data",{
          type: "post",
          timeout: 15000,
          data: $("#akun_form").serialize(),
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "berhasil"){
              toastr.success('Data Jurnal Memorial Berhasil Disimpan');
              btn.removeAttr("disabled");
              btn.text("Simpan");

              form_reset();
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

    $("#cabang").change(function(){
      $(".chosen-select.akun").html(initiate_akun($(this).val()));
      $('.chosen-select.akun').trigger("chosen:updated");
    })

    $("table").on("click", ".delete_row", function(){
      $(this).parents("tr").remove();
      initiate_total($(this).data("id"))
    })

    $(".add_row").click(function(){
      $print = '<tr>'+
                  '<td width="55%" class="text-left">'+
                    '<select name="nama_akun_'+$(this).data("table")+'[]" class="select_validate form-control chosen-select akun">'+
                        initiate_akun($("#cabang").val())+
                    '</select>'+
                  '</td>'+
                  '<td width="100%" class="text-left" style="padding-right: 0px;">'+
                    '<div class="input-group" style="padding: 0px;">'+
                      '<input type="text" name="'+$(this).data("table")+'[]" value="0" class="currency '+$(this).data("table")+' form-control text-right" style="width: 100%">'+
                      '<span class="input-group-btn">'+
                        '<button class="btn btn-danger delete_row" type="button" style="padding: 6px 6px 5px 6px;font-size: 8pt;" data-id="'+$(this).data("table")+'"><i class="fa fa-eraser"></i></button>'+
                      '</span>'+
                    '</div><!-- /input-group -->'+
                  '</td>'+
                '</tr>';

      $(this).parents("tbody").append($print);
      $(this).maskFunc()

      return false
    })

    $("#jr_detail").on("keyup", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $("table").on("keyup", ".debet", function(){
      initiate_total('debet');
    })

    $("table").on("keyup", ".kredit", function(){
      initiate_total('kredit');
    })

    function validate_form(){
      a = true;
      $(".form_validate").each(function(i, e){
        if($(this).val() == "" && $(this).is(":visible")){
          a = false;
          $(this).focus();
          toastr.warning('Harap Lengkapi Data Diatas');
          return false;
        }
      })

      $(".select_validate").each(function(i, e){
        if($(this).val() == "---" && $(this).is(":visible")){
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

    function initiate_total(id){
      $total = 0;
      $("."+id).each(function(){
        $value = $(this).val()
        $nilai = $value.split(",")[0].replace(/\./g,"")

        // alert($nilai)
        $total += parseInt($nilai)
      })

      // alert($total)
      $("#total_"+id).val($total);
    }

    function initiate_akun(cabang){
      html = "";
      $.each($.grep(akun, function(o){ return o.kode_cabang === cabang }), function(i, n){
        html = html + '<option value="'+n.id_akun+'">'+n.nama_akun+'</option>';
      })

      return html;
    }

    function form_reset(){
      $(".form_validate").each(function(){
        $(this).val("");
      })

      $(".select_validate").each(function(){
          $(this).val("---");
      })

      $('#kode_cabang').trigger("chosen:updated");
      $('#group_neraca').trigger("chosen:updated");
    }
  })
</script>

  