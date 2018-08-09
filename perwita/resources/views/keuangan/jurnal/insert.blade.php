
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

  #form-table input:disabled, #form-table textarea:disabled, #table_akun input:disabled{
    background: white;
  }

</style>

<div class="row">
  <form id="akun_form">
    <input type="hidden" readonly value="{{ csrf_token() }}" name="_token">
    
  <div class="col-md-7" style="border: 0px solid #ddd; border-radius: 5px; padding: 10px;">
    <table border="0" id="form-table" class="col-md-12">

      <tr>
        <td width="20%" class="text-left">Jenis Transaksi <input type="hidden" name="type_transaksi" value="kas" readonly /> </td>
        <td colspan="2">
          <select name="jenis_transaksi" class="select_validate form-control list-should-disabled" id="jenis_transaksi" style="width: 40%; display: inline-block;">
            <option value="1">Kas Masuk</option>
            <option value="2">Kas Keluar</option>
          </select> &nbsp;&nbsp;&nbsp;&nbsp;

          <i class="fa fa-search" style="display: inline-block; cursor: pointer;" id="list-show"></i>&nbsp;&nbsp;&nbsp;
          <i class="fa fa-times text-danger" style="display: none; cursor: pointer;" id="list-reset"></i>
        </td>
      </tr>

      <tr id="info-referensi" style="display: none;">
        <td width="20%" class="text-left">Nomor Referensi <input type="hidden" name="ref" readonly /> </td>
        <td colspan="2">
          <input type="text" class="form_validate form-control list-should-disabled" placeholder="Nomor Referensi" id="jr_ref" style="width: 60%">
        </td>
      </tr>

      <tr>
        <td width="20%" class="text-left">Transaksi Cabang</td>
        <td colspan="2">
          <select name="cabang" class="select_validate form-control chosen-select list-should-disabled" id="cabang">
            @foreach($cabangs as $cab)
              <option value="{{$cab->kode}}">{{$cab->kode}} - {{$cab->nama}}</option>
            @endforeach
          </select>
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left">Akun COA</td>
        <td colspan="2">
          <select class="select_validate form-control chosen-select akun list-should-disabled" id="akun_transaksi">
            <option value="---"> -- Pilih Akun Coa</option>
          </select>
        </td>
      </tr>

      {{-- <tr>
        <td width="10%" class="text-left">Nomor Transaksi</td>
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control" name="jr_ref" placeholder="Masukkan Nomor Transaksi" id="jr_ref">
        </td>
      </tr> --}}

      <tr>
        <td width="10%" class="text-left">Nama Transaksi</td>
        <td width="35%" colspan="2">
          <input type="text" class="form_validate form-control list-should-disabled" name="jr_detail" placeholder="Masukkan Nama Transaksi" id="jr_detail">
        </td>
      </tr>

      <tr>
        <td width="10%" class="text-left">Nominal</td>
        <td width="35%" colspan="2">
          <input type="text" class="form-control list-should-disabled currency" id="nominal" name="jr_nominal" placeholder="Masukkan Nama Transaksi">
        </td>
      </tr>

    </table>
  </div>

  <div class="col-md-5" style="border: 0px solid #ddd; border-radius: 5px;">

    <div class="col-md-12 m-t" style="padding: 10px; background: #eee;">
      <table border="0" id="form-table" class="col-md-12">

        <tr>
          {{-- <td width="10%" class="text-left">Nama</td> --}}
          <td width="35%" colspan="2">
            <select class="select_validate form-control chosen-select list-should-disabled" id="akun_lawan">
              <option value="---"> -- Pilih Akun Lawan</option>
              @foreach($akun_all as $key => $data_akun)
                <option value="{{ $data_akun->id_akun }}">{{ $data_akun->id_akun }} - {{ $data_akun->nama_akun }}</option>
              @endforeach
            </select>
          </td>
        </tr>

        <tr>
          {{-- <td width="10%" class="text-left">Nama</td> --}}
          <td colspan="2" style="padding-top: 10px;">
            <button class="btn btn-primary btn-xs btn-block list-should-disabled" id="add_coa_lawan">Tambahkan Ke Detail COA</button>
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
            <th width="5%">**</th>
            <th width="55%">Akun COA</th>
            <th width="20%">Debet</th>
            <th width="20%">Kredit</th>
          </tr>
        </thead>

        <tbody id="coa_detail">
          <tr id="coa_1" data-id="1">
            <td width="5%" class="text-center" style="cursor: pointer;">
              
            </td>
            <td class="name">
              100311001 - KAS BESAR JPM SURABAYA</td>
            <td class="text-right currency">
              <input type="hidden" name="akun[]" class="akunName" readonly>
              <input class="form-control currency debet first list-should-disabled" value="0" data-id="1" name="debet[]" id="debet_first" readonly>
            </td>
            <td class="text-right currency">
              <input class="form-control currency kredit first list-should-disabled" value="0" data-id="1" name="kredit[]" readonly id="kredit_first">
            </td>
          </tr>
        </tbody>

        <tfoot>
          <tr>
            <td></td>
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
    <button class="btn btn-primary btn-sm pull-right list-should-disabled" id="simpan">Simpan</button>
  </div>
</div>

<script>
  $(document).ready(function(){

    akun = {!! $akun_real !!}; var id = 1; var list = '';

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

    $("#nominal").keyup(function(evt){
      evt.preventDefault();

      if($("#jenis_transaksi").val() == 1)
        $('#debet_first').val($(this).val());
      else
        $('#kredit_first').val($(this).val());

      initiate_total();
    })

    $('#simpan').click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      btn = $(this);
      btn.attr("disabled", "disabled");
      btn.text("Menyimpan...");

      if($(".total_debet").val() != $(".total_kredit").val()){
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
            form_reset();
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

      generate_coa_transaksi();
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
        // $("#coa_1 input.debet").removeAttr('readonly');
        // $("#coa_1 input.kredit").attr('readonly', 'readonly');
        $("#coa_1 input.kredit").val(0);
        $("#coa_1 input.debet").val(val);
      }else{
        val =  $("#coa_1 input.debet").val().replace(/\./g, '').split(',')[0];
        // $("#coa_1 input.kredit").removeAttr('readonly');
        // $("#coa_1 input.debet").attr('readonly', 'readonly');
        $("#coa_1 input.debet").val(0);
        $("#coa_1 input.kredit").val(val);
      }

      initiate_total();
    })

    $("#add_coa_lawan").click(function(evt){
      evt.preventDefault(); var value = $("#akun_lawan");

      if(value.val() == '---')
        return;

      var html = '<tr id="coa_'+(id + 1)+'" data-id="'+(id+1)+'" class="akun_lawan_wrap">'+
                    '<td width="5%" class="text-center text-danger" style="cursor: pointer;">'+
                      '<i class="fa fa-eraser delete_akun" data-id="'+(id+1)+'"></i>'+
                    '</td>'+
                    '<td class="name">'+
                        '<input type="hidden" name="akun[]" value="'+value.val()+'" readonly>'+value.children('option:selected').text()+'</td>'+
                    '<td class="text-right currency">'+
                      '<input class="form-control currency debet" name="debet[]" value="0" data-id="'+(id+1)+'">'+
                    '</td>'+
                    '<td class="text-right currency">'+
                      '<input class="form-control currency kredit" name="kredit[]" value="0" data-id="'+(id+1)+'">'+
                    '</td>'+
                  '</tr>';


      $("#coa_detail").append(html);
      $(this).maskFunc();
      id++;
    })

    $("#coa_detail").on('click', '.delete_akun', function(evt){
      evt.preventDefault(); ctx = $(this); 
      ctx.parents('tr').first().remove();
      initiate_total();
    })

    $("#list-show").click(function(evt){
      evt.preventDefault();
      $('#overlay').fadeIn(80);

      if(list != $("#cabang").val())
        $("#overlay .modal-body").html('<center class="text-muted">Sedang Memuat ...</center>');

      $.ajax(baseUrl+"/keuangan/jurnal_umum/list_transaksi?cab="+$("#cabang").val(), {
         timeout: 15000,
         dataType: "html",
         success: function (data) {
             $("#overlay .modal-body").html(data);
             list = $("#cabang").val();
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#overlay .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#overlay .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });

      // $("#modal_list_transaksi").modal('show');
    })

    $("#list-reset").click(function(evt){
      evt.preventDefault();
      $(this).fadeOut(200);
      $(".list-should-disabled").removeAttr('disabled');
      $('.chosen-select#akun_transaksi').trigger("chosen:updated");
      $('.chosen-select#akun_lawan').trigger("chosen:updated");
      $('.chosen-select#cabang').trigger("chosen:updated");
      $("#info-referensi").fadeOut(200);
      form_reset();
    })

    function generate_coa_transaksi(){
      $('#coa_1 .name').text($("#akun_transaksi option:selected").text());
      $('#coa_1 .akunName').val($("#akun_transaksi").val());
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
          $(this).val($(this).children('option').first().attr('value'));
      })

      $(".akun_lawan_wrap").remove();
      $("#coa_1 input").val(0);

      $(".total_debet").val(0); 
      $(".total_kredit").val(0);
      
      $('.akunName').val($('#akun_transaksi').val());

      // $('#kode_cabang').trigger("chosen:updated");
      // $('#group_neraca').trigger("chosen:updated");
    }
  })
</script>

  