
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

  input.currency{
    font-size: 8pt;
    text-align: right;
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
            <option value="1">Kas Masuk</option>
            <option value="2">Kas Keluar</option>
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
          <select class="select_validate form-control chosen-select akun" id="akun_transaksi">
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

    </table>
  </div>

  <div class="col-md-5" style="border: 0px solid #ddd; border-radius: 5px;">

    <div class="col-md-12" style="padding: 0px;">
      <table border="0" id="form-table" class="col-md-12">

        <tr>
          <td width="20%" class="text-left" style="vertical-align: top; padding-top: 1em;">Catatan</td>
          <td colspan="2">
            <textarea name="jr_note" class="input-Validity upper form-control form_validate" style="width:100%; resize: none; height: 100px;" placeholder="Masukkan Catatan Jurnal Disini"></textarea>
          </td>
        </tr>

      </table>
    </div>

    <div class="col-md-12 m-t" style="padding: 10px; background: #eee;">
      <table border="0" id="form-table" class="col-md-12">

        <tr>
          {{-- <td width="10%" class="text-left">Nama</td> --}}
          <td width="35%" colspan="2">
            <select class="select_validate form-control chosen-select akun">
              <option value="---"> -- Pilih Akun Coa</option>
            </select>
          </td>
        </tr>

        <tr>
          {{-- <td width="10%" class="text-left">Nama</td> --}}
          <td colspan="2" style="padding-top: 10px;">
            <button class="btn btn-primary btn-xs btn-block" id="add_coa_lawan">Tambahkan Ke Detail COA</button>
          </td>
        </tr>

      </table>
    </div>

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

        <tbody id="coa_detail">
          <tr id="coa_1" data-id="1">
            <td class="name">100311001 - KAS BESAR JPM SURABAYA</td>
            <td class="text-right currency">
              <input class="form-control currency debet" value="0" data-id="1">
            </td>
            <td class="text-right currency">
              <input class="form-control currency kredit" value="0" data-id="1" readonly>
            </td>
          </tr>
        </tbody>

        <tfoot>
          <tr>
            <td>  </td>
            <td style="font-weight: bold; background: #eee; border: 1px solid #fff;"><input class="form-control currency total_debet" style="height: 10px; border: none; padding-right: 8px; background: #eee;" value="0"></td>
            <td style="font-weight: bold; background: #eee; border: 1px solid #fff;"><input class="form-control currency total_kredit" style="height: 10px; border: none; padding-right: 8px; background: #eee;" value="0"></td>
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

    akun = {!! $akun !!}; var id = 1;

    $(".chosen-select.akun").html(initiate_akun($("#cabang").val()));
    $('.chosen-select.akun').trigger("chosen:updated");

    generate_coa_transaksi();

    $.fn.maskFunc = function(){
      $('input.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: '', //Space after $, this will not truncate the first character.
          rightAlign: false,
          allowMinus: false
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

    $("#jr_detail").on("keyup", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $("#coa_detail").on('keyup', 'input.debet', function(evt){
      evt.preventDefault(); var id = evt.target.getAttribute('data-id');

      if(evt.key != "Tab"){
        $('#coa_'+id+' input.kredit').val(0);
        initiate_total();
      }

    })

    $("#coa_detail").on('keyup', 'input.kredit', function(evt){
      evt.preventDefault(); var id = evt.target.getAttribute('data-id');

      if(evt.key != "Tab"){
        $('#coa_'+id+' input.debet').val(0);
        initiate_total();
      }

    })

    $('#akun_transaksi').change(function(evt){
      evt.preventDefault();
      generate_coa_transaksi();
    })

    $("#jenis_transaksi").change(function(evt){
      evt.preventDefault(); context = $(this);

      if(context.val() == 1){
        val =  $("#coa_1 input.kredit").val().replace(/\./g, '').split(',')[0];
        $("#coa_1 input.debet").removeAttr('readonly');
        $("#coa_1 input.kredit").attr('readonly', 'readonly');
        $("#coa_1 input.kredit").val(0);
        $("#coa_1 input.debet").val(val);
      }else{
        val =  $("#coa_1 input.debet").val().replace(/\./g, '').split(',')[0];
        $("#coa_1 input.kredit").removeAttr('readonly');
        $("#coa_1 input.debet").attr('readonly', 'readonly');
        $("#coa_1 input.debet").val(0);
        $("#coa_1 input.kredit").val(val);
      }

      initiate_total();
    })

    $("#add_coa_lawan").click(function(evt){
      evt.preventDefault();

      var html = '<tr id="coa_'+(id + 1)+'" data-id="'+(id+1)+'">'+
                    '<td class="name">100311001 - KAS BESAR JPM SURABAYA</td>'+
                    '<td class="text-right currency">'+
                      '<input class="form-control currency debet" value="0" data-id="'+(id+1)+'">'+
                    '</td>'+
                    '<td class="text-right currency">'+
                      '<input class="form-control currency kredit" value="0" data-id="'+(id+1)+'">'+
                    '</td>'+
                  '</tr>';


      $("#coa_detail").append(html);
      $(this).maskFunc();
      id++;
    })

    function generate_coa_transaksi(){
      $('#coa_1 .name').text($("#akun_transaksi option:selected").text());
    }

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

    function initiate_total(context){
      var total = 0;
      $(".debet").each(function(idx){
       var num = $(this).val().replace(/\./g, '').split(',')[0];
       total += parseInt(num);
      })

      $("input.total_debet").val(total);

      total = 0;
      $(".kredit").each(function(idx){
       var num = $(this).val().replace(/\./g, '').split(',')[0];
       total += parseInt(num);
      })

      $("input.total_kredit").val(total);
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

  