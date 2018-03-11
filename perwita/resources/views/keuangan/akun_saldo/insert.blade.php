<div class="row">
  <form class="form-horizontal kirim" id="form_tambah_akun">
    <div class="col-md-12" style="background:;">
      <table id="table_form" width="100%" border="0">
        <tbody>
          <tr>
            <td width="17%">Pilih Akun<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
            <td width="35%">
             <select name="id_akun" style="width: 80%" data-toggle="tooltip" data-placement="top" title="Hanya Menampilkan Akun Yang Tidak Memiliki Subakun Dan Belum Memiliki Saldo Di Tahun Ini.">
               @foreach($data as $dataAkun)
                  @if(!$dataAkun->hasSaldo($dataAkun->id_akun))
                    <option value="{{ $dataAkun->id_akun }}">{{ $dataAkun->nama_akun }}</option>
                  @endif
               @endforeach
             </select>
                
            </td>
            <td width="20%">
              Tahun Periode
            </td>
            <td>
              <input class="validate" style="text-align: center;" type="text" required readonly name="tahun" value="{{ date("Y") }}">
            </td>
          </tr>
        </tbody>
      </table>
    </div>

      <div class="col-md-12" style="margin-top: 20px;margin-bottom: 25px;">

        <small><i class="fa fa-circle-o"></i> &nbsp;Form Isian Saldo Awal</small>

        <table id="table_saldo" width="100%" border="1" style="margin-top: 10px;">
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
                <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" value="0" required name="saldo_debet" style="width: 85%;" id="DEBET" onkeyup="if(this.value != 'Rp 0,00'){$('#KREDIT').val(0)}">
              </td>

              <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
                <input data-toggle="tooltip" value="0" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" required name="saldo_kredit" style="width: 85%;" id="KREDIT" onkeyup="if(this.value != 'Rp 0,00'){$('#DEBET').val(0)}">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    
    <div class="col-md-7">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>
    <input type="submit" class="btn btn-sm btn-primary col-md-4" id="btn_simpan" value="Simpan Data Saldo Awal Akun">
</div>
  </form>

<script type="text/javascript">
  $(document).ready(function(){

    $change = false;

    $('[data-toggle="tooltip"]').tooltip()

    $("#form_tambah_akun").submit(function(){

      $("#btn_simpan").attr("disabled", "disabled");

      if(this.checkValidity()){
        $.ajax(baseUrl+"/master_keuangan/saldo_akun/save_data", {
           timeout: 5000,
           type: "POST",
           data: $(this).serialize(),
           dataType: "json",
           success: function (data) {
              console.log(data);
              if(data.status == "gagal"){
                $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;Gagal Disimpan. '+data.content+'!');
              }else if(data.status == "berhasil"){
                $("#message_server").html('<i class="fa fa-check-circle"></i> &nbsp;Data Berhasil Disimpan!');
                $("#table_data").prepend('<tr><td class="text-center">+</td><td class="text-center">'+data.content.id_akun+'</td><td class="text-center">'+data.content.nama_akun+'</td></tr>')
              }

              $change = true;
              $("#btn_simpan").removeAttr("disabled");
           }
        })
        return false
      }
      else{
        $("#btn_simpan").removeAttr("disabled");
        return false
      }
    })

    $("input").on("invalid", function(){
      this.setCustomValidity("ada yang salah dengan inputan ini");
    })

    $("input").on("change", function(){
      this.setCustomValidity("");
    })

    $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: 'Rp ', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
    });
  })
</script>

  