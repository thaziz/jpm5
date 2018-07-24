
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

  #table_akun{
    width: 100%;
    font-size: 8pt;
  }

  #table_akun th{
    text-align: center;
    padding: 5px;
    background: #eee;
  }

  #table_akun td{
    border: 1px solid #eee;
    padding: 5px;
  }

  #table_akun td.currency{
    font-weight: 600;
  }

  #table_akun tfoot td{
    padding: 10px;
  }

</style>

<div class="row">
  <form id="akun_form">
    <input type="hidden" readonly value="{{ csrf_token() }}" name="_token">
    
  <div class="col-md-7" style="border: 0px solid #ddd; border-radius: 5px; padding: 10px;">
    <table border="0" id="form-table" class="col-md-12">

      <tr>
        <td width="20%" class="text-left">Jenis Transaksi</td>
        <td colspan="2">
          <select name="jenis_transaksi" class="select_validate form-control" id="jenis_transaksi" style="width: 40%">
            <option value="kas_masuk">Kas Masuk</option>
            <option value="kas_keluar">Kas Keluar</option>
          </select>
        </td>
      </tr>

      <tr>
        <td width="20%" class="text-left">Transaksi Cabang</td>
        <td colspan="2">
          <select name="cabang" class="select_validate form-control chosen-select" id="cabang">
            @foreach($cabangs as $cab)
              <option value="{{$cab->kode}}">{{$cab->nama}}</option>
            @endforeach
          </select>
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left">Akun COA</td>
        <td colspan="2">
          <select name="nama_akun_kredit[]" class="select_validate form-control chosen-select akun">
            <option value="---"> -- Pilih Akun Coa</option>
          </select>
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left">Nomor Transaksi</td>
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control" name="jr_ref" placeholder="Masukkan Nomor Transaksi" id="jr_ref">
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left">Nama Transaksi</td>
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control" name="jr_detail" placeholder="Masukkan Nama Transaksi" id="jr_detail">
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left" style="vertical-align: top; padding-top: 1em;">Catatan</td>
        <td colspan="2">
          <textarea name="jr_note" class="input-Validity upper form-control form_validate" style="resize: none;height: 100px;" placeholder="Masukkan Catatan Jurnal Disini"></textarea>
        </td>
      </tr>

    </table>
  </div>

  <div class="col-md-5" style="border: 0px solid #ddd; border-radius: 5px; padding: 10px; background: #eee;">
    <table border="0" id="form-table" class="col-md-12">

      <tr>
        {{-- <td width="10%" class="text-left">Nama</td> --}}
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control" name="jr_detail" placeholder="Masukkan Nama Transaksi" id="jr_detail">
        </td>
      </tr>

    </table>
  </div>

  <div class="col-md-12 m-t" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Detail Akun COA</small></span>

    <div id="saldo_all" style="padding: 10px 5px;">
      <table id="table_akun" border="0">
        <thead>
          <tr>
            <th width="60%">Akun COA</th>
            <th width="20%">Debet</th>
            <th width="20%">Kredit</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>100311001 - KAS BESAR JPM SURABAYA</td>
            <td class="text-right currency">{{ number_format(25000000000, 2) }}</td>
            <td class="text-right currency">{{ number_format(0, 2) }}</td>
          </tr>

          <tr>
            <td>100211002 - BON SEMENTARA JPM JEMBER</td>
            <td class="text-right currency">{{ number_format(0, 2) }}</td>
            <td class="text-right currency">{{ number_format(25000000000, 2) }}</td>
          </tr>
        </tbody>

        <tfoot>
          <tr>
            <td class="text-center" style="font-weight: bold; background: #eee;"> Total </td>
            <td class=" text-right currency" style="background: #eee;"> {{ number_format(25000000000, 2) }} </td>
            <td class=" text-right currency" style="background: #eee;"> {{ number_format(25000000000, 2) }} </td>
          </tr>
        </tfoot>
      </table>
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

    $(".chosen-select.akun").html(initiate_akun($("#cabang").val()));
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
                  '<td width="65%" class="text-left">'+
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
        html = html + '<option value="'+n.id_akun+'">'+n.id_akun+' - '+n.nama_akun+'</option>';
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

  