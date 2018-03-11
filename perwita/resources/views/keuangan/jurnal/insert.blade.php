<div class="row">
  <form class="form-horizontal kirim" id="form_tambah_akun">
    <div class="col-md-12" style="background:;margin-bottom: 20px;">
      <table id="table_form" width="50%" border="0">
        <tbody>
          <tr>
            <td width="17%">Tanggal Transaksi<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
            <td width="35%">
             <input readonly type="text" name="jr_date" value="{{ date("d-m-Y") }}">
            </td>

            <td width="17%">Tanggal Transaksi<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
            <td width="35%">
             <input readonly type="text" name="jr_year" value="{{ date("Y") }}">
            </td>
          </tr>

          <tr>
            <td width="17%">Pilih Transaksi<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
            <td width="35%">
             <select name="jr_detail" style="width:85%" id="detail" class="input-Validity" required>
                <option value=""> - Pilih Transaksi Terlebih Dahulu</option>
               @foreach($transaksi as $dataTransaksi)
                  <option value="{{ $dataTransaksi->tr_code }}"> {{ $dataTransaksi->tr_name }} </option>
               @endforeach
             </select>
            </td>
          </tr>

          <tr>
            <td width="17%">Catatan Jurnal<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
            <td width="35%">
             <textarea name="jr_note" class="input-Validity upper" style="resize: none;width: 85%" rows="3" placeholder="Masukkan Catatan Jurnal Disini"></textarea>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <small><i class="fa fa-circle-o"></i> &nbsp;Akun-Akun Yang Dipengaruhi</small>
    <div class="col-md-12" style="margin-bottom: 20px; margin-top: 5px; padding: 5px 0px; border:1px solid #eee;" id="detai_wrap">
      <center><small>Anda Harus Memilih Transaksi Dulu</small></center>
    </div>

    
    
    <div class="col-md-7">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>
    <input type="submit" class="btn btn-sm btn-primary col-md-4" id="btn_simpan" value="Simpan Data Jurnal Transaksi">
  </form>
</div>
  

<script type="text/javascript">
  $(document).ready(function(){

    $change = false;

    $('[data-toggle="tooltip"]').tooltip()

    $("#form_tambah_akun").submit(function(){

      $("#btn_simpan").attr("disabled", "disabled");

      if(this.checkValidity()){
        $.ajax(baseUrl+"/keuangan/jurnal_umum/save_data", {
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

    $(".upper").on("change", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $(".input-Validity").on("invalid", function(){
      this.setCustomValidity("ada yang salah dengan inputan ini");
    })

    $(".input-Validity").on("change", function(){
      this.setCustomValidity("");
    })

    $("#detail").change(function(){
      if($(this).val() == ""){
        $("#detai_wrap").html("<center><small>Anda Harus Memilih Transaksi Dulu</small></center>");
      }else{
        $.ajax(baseUrl+"/keuangan/jurnal_umum/detail/"+$(this).val(), {
         timeout: 5000,
         type: "GET",
         success: function (data) {
            $("#detai_wrap").html(data);
         }
        })
      }
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

  