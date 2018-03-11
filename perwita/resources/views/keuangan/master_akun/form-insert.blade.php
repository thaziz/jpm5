
<div class="row">
  <form class="form-horizontal kirim" id="form_tambah_akun">
    <div class="col-md-12" style="background:;">
      @if($parrent == 0)
        <table id="table_form" width="100%" border="0">
          <tbody>
            <tr>
              <td width="17%">Kode Akun<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
              <td width="35%">

                <input data-toggle="tooltip" data-placement="top" title="Kode Parrent. Secara Default Ditulis Di Awal Kode Akun" class="validate" readonly style="width: 50%; background: #eee; text-align: center;border:1px solid #ccc;" type="text" name="akun_parent" required id="akun_parent">

                <input data-toggle="tooltip" id="id_akun" data-placement="top" title="Sebagai Pembeda Antara ID Akun" class="validate" style="width: 20%" type="text" name="id_akun">
                  
              </td>
              <td width="20%">Nama Akun</td>
              <td>
                <input data-toggle="tooltip" data-placement="top" title="Inputan Ini Tidak boleh Kosong" class="validate" required type="text" name="nama_akun" style="width:85%">
              </td>
              
            </tr>

            <tr>

              <td>
                Sebagai
              </td>
              <td>
                <select name="sebagai" id="sebagai" disabled="">
                  <option value="1">Header</option>
                  <option value="2" selected>Sub Akun Dari</option>
                </select>
              </td>

              <td width="10%" class="parrent" style="display: none;">Parrent</td>
              <td class="parrent" style="display: none;">
                  <select name="parrent" class="chosen-select" id="parrent" data-toggle="tooltip" data-placement="top" title="Warna Merah Berarti Akun Sudah Memiliki Saldo. Tidak Bisa Dijadikan Parrent">
                    @foreach($subakun as $dataSubakun)
                      @if(!$dataSubakun->hasSaldo($dataSubakun->id_akun))
                        <option value="{{ $dataSubakun->id_akun }}">{{ $dataSubakun->nama_akun }}</option>
                      @else
                        <option value="{{ $dataSubakun->id_akun }}" disabled style="background: #ed5565;color:white;">{{ $dataSubakun->nama_akun }}</option>
                      @endif
                    @endforeach
                  </select>
              </td>
            </tr>

            <tr class="prok" style="display: none;">
                <td width="17%">Provinsi<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                <td>
                    <select data-toggle="tooltip" data-placement="top" name="id_kota" style="width:100%" id="id_kota" class="chosen-select">
                      <option value="0">Pilih Provinsi</option>
                      @foreach($provinsi as $dataProvinsi)
                        <option value="{{ $dataProvinsi->id }}">{{ $dataProvinsi->nama }}</option>

                      @endforeach
                    </select>
                </td>

                <td width="17%">Cabang<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                <td>
                    <select data-toggle="tooltip" data-placement="top" name="id_cabang" style="width:100%" id="id_cabang" class="chosen-select" disabled>
                      <option value="0">Pilih Cabang</option>
                      @foreach($cabang as $data_cabang)
                        <option value="{{ $data_cabang->kode }}">{{ $data_cabang->nama }}</option>

                      @endforeach
                    </select>
                </td>
            </tr>

            <tr>
              <td class="akun_dka">Posisi D/K</td>
              <td class="akun_dka">
                <select class="validate" name="akun_dka" id="akun_dka">
                  <option value="D">DEBET</option>
                  <option value="K">KREDIT</option>
                </select>
              </td>
            </tr>

            <tr>
              <td style="padding-top: 15px;">Aktif</td>
              <td style="padding-top: 15px;">
                <select class="validate" name="is_active">
                  <option value="1">Ya</option>
                  <option value="0">Tidak</option>
                </select>
              </td>

              <td width="17%">Type</td>
              <td>
                  <select data-toggle="tooltip" data-placement="top" name="type" style="width:100%" id="type">
                    <option value="OCF">OCF</option>
                    <option value="ICF">ICF</option>
                    <option value="FCF">FCF</option>
                  </select>
              </td>
            </tr>
          </tbody>
      </table>
    </div>
      
      <div class="col-md-12" style="margin-top: 20px;margin-bottom: 20px;display: none;" id='saldo-wrap'>
        <input type="checkbox" id="saldo" name="saldo"> &nbsp;<small>Akun Ini Memiliki Saldo. (Anda Juga Bisa Mengisi Saldo Awal Di Halaman Saldo Akun)</small>
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
                <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" disabled required name="saldo_debet" value="0" style="width: 85%;" id="DEBET" onkeyup="if(this.value != 'Rp 0,00'){$('#KREDIT').val(0)}">
              </td>

              <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
                <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" disabled required name="saldo_kredit" value="0" style="width: 85%;" id="KREDIT" onkeyup="if(this.value != 'Rp 0,00'){$('#DEBET').val(0)}">
              </td>
            </tr>
          </tbody>
        </table>

      @else

        <table id="table_form" width="100%" border="0">
          <tbody>
            <tr>
              <td width="17%">Kode Akun<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
              <td width="35%">

                <input data-toggle="tooltip" data-placement="top" title="Kode Parrent. Secara Default Ditulis Di Awal Kode Akun" class="validate" readonly style="width: 50%; background: #eee; text-align: center;border:1px solid #ccc;" value="{{ $nama->id_akun }}" type="text" name="akun_parent" required id="akun_parent">

                <input data-toggle="tooltip" data-placement="top" title="Sebagai Pembeda Antara ID Akun" class="validate" style="width: 20%" type="text" name="id_akun">
                  
              </td>
              <td width="20%">Nama Akun</td>
              <td>
                <input data-toggle="tooltip" data-placement="top" title="Inputan Ini Tidak boleh Kosong" class="validate" required type="text" name="nama_akun" style="width:85%">
              </td>
              
            </tr>

            <tr>

              <td>
                Sebagai
              </td>
              <td>
                <input type="text" disabled value="Sub Akun Dari">
                <input type="hidden" readonly name="sebagai" value="2">
              </td>

              <td width="10%" class="parrent" style="display:;">Parrent</td>
              <td class="parrent" style="display:;">
                  <input type="text" class="text-center" disabled value="{{ $nama->nama_akun }}">
                  <input type="hidden" id ="parrent" readonly name="parrent" value="{{ $parrent }}">
              </td>
            </tr>

            <tr class="prok" style="display:;">
                <td width="17%">Provinsi<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                <td>
                    <select data-toggle="tooltip" data-placement="top" name="id_kota" style="width:100%" id="id_kota" class="chosen-select">
                      <option value="0">Pilih Provinsi</option>
                      @foreach($provinsi as $dataProvinsi)
                        <option value="{{ $dataProvinsi->id }}">{{ $dataProvinsi->nama }}</option>

                      @endforeach
                    </select>
                </td>

                <td width="17%">Cabang<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                <td>
                    <select data-toggle="tooltip" data-placement="top" name="id_cabang" style="width:100%" id="id_cabang" class="chosen-select" disabled>
                      <option value="0">Pilih Cabang</option>
                      @foreach($cabang as $data_cabang)
                        <option value="{{ $data_cabang->kode }}">{{ $data_cabang->nama }}</option>

                      @endforeach
                    </select>
                </td>
            </tr>

            <tr>
              <td style="padding-top: 15px;">Aktif</td>
              <td style="padding-top: 15px;">
                <select class="validate" name="is_active">
                  <option value="1">Ya</option>
                  <option value="0">Tidak</option>
                </select>
              </td>

              <td width="17%">Type</td>
              <td>
                  <select data-toggle="tooltip" data-placement="top" name="type" style="width:100%" id="type">
                    <option value="OCF">OCF</option>
                    <option value="ICF">ICF</option>
                    <option value="FCF">FCF</option>
                  </select>
              </td>
            </tr>
          </tbody>
      </table>
    </div>
      
      <div class="col-md-12" style="margin-top: 20px;margin-bottom: 20px;display:;" id='saldo-wrap'>
        <input type="checkbox" id="saldo" name="saldo"> &nbsp;<small>Akun Ini Memiliki Saldo. (Anda Juga Bisa Mengisi Saldo Awal Di Halaman Saldo Akun)</small>
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
                <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" disabled required name="saldo_debet" value="0" style="width: 85%;" id="DEBET" onkeyup="if(this.value != 'Rp 0,00'){$('#KREDIT').val(0)}">
              </td>

              <td style="padding: 3px 0px; border:1px solid #eee" class="text-center">
                <input data-toggle="tooltip" data-placement="top" title="Masukkan Saldo Awal Disini" class="currency saldo_awal" type="text" disabled required name="saldo_kredit" value="0" style="width: 85%;" id="KREDIT" onkeyup="if(this.value != 'Rp 0,00'){$('#DEBET').val(0)}">
              </td>
            </tr>
          </tbody>
        </table>
      @endif
      
      </div>
    
    <div class="col-md-8">
      <small class="pull-right" id="message_server" style="padding-top: 15px;color: #ed5565; font-weight: 600"></small>
    </div>
    <input type="submit" class="btn btn-sm btn-primary col-md-3" id="btn_simpan" value="Simpan Data Akun">    

    <!--<div class="col-md-12" style="height: 180px; overflow-y: scroll; margin-top: 20px;">
    <table class="scroll table table-bordered tbl_isi_akun" id="table_data">
      <thead>
        <tr>
          <th width="10%" class="text-center">No</th>
          <th class="text-center">Kode Akun</th>
          <th class="text-center">Nama Akun</th>
        </tr>
      </thead>
      <tbody>

        <?php $no = 1; ?>

        @foreach($data as $dataAkun)
          <tr>
            <td class="text-center">{{ $no }}</td>
            <td class="text-center">{{ $dataAkun->id_akun }}</td>
            <td class="text-center">{{ $dataAkun->nama_akun }}</td>
          </tr>
          <?php $no++; ?>
        @endforeach

      </tbody>
      </th>
    </table>
  </div>-->
</div>
  </form>

<script type="text/javascript">
  $(document).ready(function(){

    $.fn.initiate = function(id){
      //alert(id)
      $.ajax(baseUrl+"/master_keuangan/akun/cek_parrent/"+id, {
         timeout: 5000,
         type: "GET",
         dataType: "json",
         success: function (response) {
            console.log(response);
            if(response.data.id_provinsi != null){
              $("#id_kota").val(response.data.id_provinsi)
              $("#id_kota").attr("disabled", "disabled")
              $('#id_kota').trigger("chosen:updated");
            }else{
              $("#id_kota").val("0")
              $("#id_kota").removeAttr("disabled")
              $('#id_kota').trigger("chosen:updated")
            }

            if(response.data.kode_cabang != null){
              $("#id_cabang").val(response.data.kode_cabang.substring(1))
              $("#id_cabang").attr("disabled", "disabled")
              $('#id_cabang').trigger("chosen:updated");
            }else{
              $("#id_cabang").val("0")
              //$("#id_cabang").removeAttr("disabled")
              $('#id_cabang').trigger("chosen:updated")
            }

            $("#akun_parent").val(response.data.id_akun)
         }
      })
    }

    @if($parrent == 0)
      cekForm();
    @endif

    $change = false;

     $(".chosen-select").chosen({width: '150px'})

     $parrent = "{{ $parrent }}";

      if($parrent != 0)
        $(this).initiate($("#parrent").val())

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
      $("#message_server").html('');

      if($("#akun_parent").val() == "" && $("#id_akun").val() == ""){
        $("#id_akun").focus();$("#btn_simpan").removeAttr("disabled");
        $("#message_server").html('<i class="fa fa-times-circle"></i> &nbsp;Gagal Disimpan. Akun Header Wajib Memiliki ID Akun!');
        return false
      }

      if(this.checkValidity()){
        $.ajax(baseUrl+"/master_keuangan/akun/save_data", {
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

                $change = true;
              }

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

    $("input:text").on("change", function(){
      $(this).val($(this).val().toUpperCase())
    })

    $("input").on("invalid", function(){
      this.setCustomValidity("ada yang salah dengan inputan ini");
    })

    $("input").on("change", function(){
      this.setCustomValidity("");
    })

    // $("#id_kota").change(function(){
    //   if($(this).val() != 0)
    //     $("#akun_parent").val('{{ $parrent }}'+$(this).val())
    //   else
    //     $("#akun_parent").val('{{ $parrent }}')

    //   $.ajax(baseUrl+"/master_keuangan/akun/kota/"+$(this).val(), {
    //      timeout: 5000,
    //      type: "GET",
    //      dataType: "html",
    //      success: function (data) {
    //         $("#id_kota").html(data);
    //      }
    //   })
    // })

    $("#id_kota").change(function(){
      
      if($(this).val() != 0){
        $("#id_cabang").removeAttr("disabled")
        $("#akun_parent").val($("#parrent").val()+""+$(this).val())
      } else{
        $("#id_cabang").attr("disabled", "disabled")
        $("#akun_parent").val($("#parrent").val())
      }
      $("#id_cabang").val(0)
      $('#id_cabang').trigger("chosen:updated");
    })

    $("#id_cabang").change(function(){
      if($(this).val() != 0)
        $("#akun_parent").val($("#parrent").val()+''+$("#id_kota").val()+""+$(this).val())
      else{
        $("#akun_parent").val($("#parrent").val()+''+$("#id_kota").val())
      }
    })

    $("#sebagai").change(function(){
      if($(this).val() == 2){
        $(".parrent").css("display", "")
        $(".akun_dka").css("display", "none");
        $("#akun_dka").attr("disabled", "disabled");
        $(".prok").css("display", "");
        $("#saldo-wrap").css("display", "");
        $(this).initiate($("#parrent").val())
      }
      else{
        $(".parrent").css("display", "none")
        $(".prok").css("display", "none");
        $(".akun_dka").css("display", "");
        $("#akun_dka").removeAttr("disabled");
        $("#saldo-wrap").css("display", "none");
        $("#akun_parent").val("")
      }
    })

    $("#parrent").change(function(){
      $(this).initiate($(this).val())
    })

    $("#saldo").on("change", function(){
      if($(this).is(":checked")){
        $(".saldo_awal").removeAttr("disabled");
        $("#"+$("#akun_dka_view").val()).focus();
      }
      else{
        $(".saldo_awal").attr("disabled", "disabled");
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

    function cekForm(){
      if($("#sebagai").val() == 2){
        $(".parrent").css("display", "")
        $(".akun_dka").css("display", "none");
        $("#akun_dka").attr("disabled", "disabled");
        $(".prok").css("display", "");
        $("#saldo-wrap").css("display", "");
        $("#sebagai").initiate($("#parrent").val())
      }
      else{
        $(".parrent").css("display", "none")
        $(".prok").css("display", "none");
        $(".akun_dka").css("display", "");
        $("#akun_dka").removeAttr("disabled");
        $("#saldo-wrap").css("display", "none");
        $("#akun_parent").val("")
      }
    }
  })
</script>

  