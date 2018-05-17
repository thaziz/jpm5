<style>
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
  <form class="form-horizontal kirim" id="form_data">
      <input type="hidden" readonly name="_token" value="{{ csrf_token() }}">

    <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">
      <table id="form-table" width="100%" border="0">
        <tbody>
          <tr>
            <td width="17%">Kode Akun</td>
            <td width="35%">
              <input type="text" class="form_validate form-control text-center" id="id_akun" name="id_akun" value="{{ $data->id_akun }}" readonly>
            </td>
            <td width="10%">
              Periode
            </td>
            <td width="8%">
              <input class="form_validate text-center form-control" style="text-align: center;" type="text" required readonly name="bulan" value="{{ date("m") }}">
            </td>

            <td width="10%">
              <input class="form_validate text-center form-control" style="text-align: center;" type="text" required readonly name="tahun" value="{{ date("Y") }}">
            </td>
          </tr>
            <td width="17%">Nama Akun</td>
            <td width="35%">
              <input type="text" class="form_validate form-control text-center" id="nama_akun" name="nama_akun" value="{{ $data->nama_akun }}" readonly>
            </td>
          <tr>
            
          </tr>
        </tbody>
      </table>
    </div>

    <div class="col-md-12" style="margin-top: 20px;margin-bottom: 25px; padding: 0px;">

      <small><i class="fa fa-circle-o"></i> &nbsp;Form Isian Saldo Awal</small>

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
              <center><input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="form-control currency saldo_awal" type="text" value="0" required name="saldo_debet" style="width: 85%;" id="DEBET" onkeyup="if(this.value != 'Rp 0,00'){$('#KREDIT').val(0)}"></center>
            </td>

            <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
              <center><input data-toggle="tooltip" value="0" data-placement="top" title="Masukkan Saldo Awal Disini" class="form-control currency saldo_awal" type="text" required name="saldo_kredit" style="width: 85%;" id="KREDIT" onkeyup="if(this.value != 'Rp 0,00'){$('#DEBET').val(0)}"></center>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
   </form>
    
    <div class="col-md-7">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>
    <button class="btn btn-sm btn-primary col-md-4" id="submit">Simpan</button>
</div>

<script type="text/javascript">
  $(document).ready(function(){

    $change = false;

    $('[data-toggle="tooltip"]').tooltip()

    $("#submit").click(function(evt){
      evt.stopImmediatePropagation();
      evt.preventDefault();

      btn = $(this);
      btn.attr("disabled", "disabled");
      btn.text("Menyimpan...");

      if(validate_form()){
        $.ajax(baseUrl+"/master_keuangan/saldo_akun/update",{
          type: "post",
          timeout: 15000,
          data: $("#form_data").serialize(),
          dataType: 'json',
          success: function(response){
            console.log(response);
            if(response.status == "sukses"){
              toastr.success('Data Saldo Berhasil Diubah');
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

      btn.removeAttr("disabled");
      btn.text("Simpan");

      return false;

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

      // if($("#DEBET").val() == '0,00' && $("#KREDIT").val() == '0,00'){
      //   a = false;
      //   $("#saldo_debet").focus()
      //   toastr.warning('Saldo Maka Saldo Tidak Boleh 0.');
      // }

      if($("#DEBET").val() < '0' || $("#KREDIT").val() < '0'){
        a = false;
        $("#saldo_debet").focus()
        toastr.warning('Nilai Saldo Akun Tidak Boleh Minus.');
      }

      return a;
    }
  })
</script>

  