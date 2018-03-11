<div class="row">
  <form class="form-horizontal kirim" id="form_tambah_akun">
    <table id="table_form" width="100%" border="0">
      <tbody>
        <tr>
          <td width="17%">Kode Akun<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
          <td width="35%">
            <input required class="validate" readonly style="width: 90%;background: #eee; border:1px solid #ccc" type="text" name="id_akun" id="id_akun" value="{{ $data->id_akun }}" required>
              
          </td>
          <td>Nama Akun</td>
          <td>
            <input data-toggle="tooltip" data-placement="top" title="Inputan Ini Tidak boleh Kosong" class="validate" required type="text" value="{{ $data->nama_akun }}" name="nama_akun" style="width:85%">
          </td>
        </tr>

        <tr>
          <td>Aktif</td>
          <td>
            <select class="validate" name="is_active" id="aktif">
              <option value="1">Ya</option>
              <option value="0">Tidak</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
    
    <div class="col-md-8">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>

    <input type="submit" class="btn btn-sm btn-primary col-md-3" id="btn_simpan" value="Simpan Data Akun">

</div>
  </form>

<script type="text/javascript">
  $(document).ready(function(){

    $change = false;
    $("#aktif").val("{{ $data->is_active }}")
    //alert("{{ $data->is_active }}")

    $('.tbl_isi_akun').DataTable({
          responsive: true,
          searching: false,
          sorting: false,
          paging: false,
          //"pageLength": 10,
          "language": dataTableLanguage,
    });

    $('[data-toggle="tooltip"]').tooltip()

    $("#form_tambah_akun").submit(function(){

      $("#btn_simpan").attr("disabled", "disabled");

      if(this.checkValidity()){

        if($("#aktif").val() != "{{ $data->is_active }}"){
          cfr = confirm("Mengubah Status Aktif. Juga Akan Mempengaruhi Status Pada Sub Akun Yang Terkait Dengan Akun Ini. Apakah Anda Yakin Ingin Tetap Melanjutkan Perubahan Ini ??");

          if(cfr){
            $.ajax(baseUrl+"/master_keuangan/akun/update_data/"+$("#id_akun").val(), {
               timeout: 5000,
               type: "POST",
               data: $(this).serialize(),
               dataType: "json",
               success: function (data) {
                  console.log(data);
                  if(data.status == "gagal"){
                    $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;Gagal Disimpan. '+data.content+'!');
                  }else if(data.status == "berhasil"){
                    $("#message_server").html('<i class="fa fa-check-circle"></i> &nbsp;Data Berhasil Diupdate!');
                  }

                  $change = true;
                  $("#btn_simpan").removeAttr("disabled");
               }
            })
          }else{
            $("#btn_simpan").removeAttr("disabled");
          }

        }else{
          $.ajax(baseUrl+"/master_keuangan/akun/update_data/"+$("#id_akun").val(), {
               timeout: 5000,
               type: "POST",
               data: $(this).serialize(),
               dataType: "json",
               success: function (data) {
                  console.log(data);
                  if(data.status == "gagal"){
                    $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;Gagal Disimpan. '+data.content+'!');
                  }else if(data.status == "berhasil"){
                    $("#message_server").html('<i class="fa fa-check-circle"></i> &nbsp;Data Berhasil Diupdate!');
                  }

                  $change = true;
                  $("#btn_simpan").removeAttr("disabled");
               }
            })
        }
        
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

    // $("#id_provinsi").change(function(){
    //   if($(this).val() != 0)
    //     $("#akun_parent").val('-'+$(this).val())
    //   else
    //     $("#akun_parent").val('-')

    //   $.ajax(baseUrl+"/master_keuangan/akun/kota/"+$(this).val(), {
    //        timeout: 5000,
    //        type: "GET",
    //        dataType: "html",
    //        success: function (data) {
    //           $("#id_kota").html(data);
    //        }
    //     })
    // })

    // $("#id_kota").change(function(){
    //   if($(this).val() != 0)
    //     $("#akun_parent").val('-'+$(this).val())
    //   else
    //     $("#akun_parent").val('-'+$("#id_provinsi").val())
    // })
  })
</script>

  