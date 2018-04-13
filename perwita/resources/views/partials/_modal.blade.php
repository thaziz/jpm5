 <!-- modal -->
<div id="modal_periode" class="modal">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambahkan Periode Keuangan</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <div class="modal-body" style="padding: 10px;">
          <form role="form" class="form-inline">
              <div class="form-group">
                  <label for="exampleInputEmail2" class="sr-only">Email address</label>
                  <input style="cursor: pointer;" type="text" placeholder="Bulan" id="periode_month"
                         class="form-control" readonly value="{{date('m')}}">
              </div>
              <div class="form-group">
                  <label for="exampleInputPassword2" class="sr-only">Password</label>
                  <input style="cursor: pointer;" type="text" placeholder="Tahun" id="periode_year"
                         class="form-control" readonly value="{{date('Y')}}">
              </div>
          </form>
      </div>

      <div class="modal-footer">
          <button class="btn btn-primary btn-sm" id="save" >Simpan</button>
      </div>
    </div>
  </div>
</div>
  <!-- modal -->

   <!-- modal -->
<div id="modal_option_periode" class="modal">
  <div class="modal-dialog" style="width: 30%;">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Setting Periode Keuangan</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <div class="modal-body" style="padding: 10px;">
        <form id="data_setting">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly>
          <table class="table table-bordered table striped table-periode">
            <thead>
                <tr>
                  <th><i class="fa fa-lock fa-fw"></i></th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                </tr>
            </thead>

            <tbody>
              @foreach(get_periode() as $periode)
                <?php 
                  $title = ($periode->status == "locked") ? "Hilangkan Centang Untuk Membuka Kunci" : "Centang untuk Mengunci"
                ?>
                <tr class="text-center">
                  <td>
                    <input class="cek" type="checkbox" id="{{ $periode->id }}" name="{{ $periode->id }}" {{ ($periode->status == "locked") ? 'checked' : '' }} title="{{ $title }}">
                  </td>
                  <td>{{ $periode->bulan }}</td>
                  <td>{{ $periode->tahun }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>

      <div class="modal-footer text-center">
          <span>&nbsp;</span>
          <small id="sts" class="text-center text-navy text-muted" style="display: none; font-weight: bold;">Sedang Merubah Status...</small>
      </div>
    </div>
  </div>
</div>
  <!-- modal -->

  <script type="text/javascript">
    $('#periode_year').datepicker( {
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });

     $('#periode_month').datepicker( {
        format: "mm",
        viewMode: "months", 
        minViewMode: "months"
    });

     $("#save").click(function(evt){
        evt.preventDefault();

        $(this).attr("disabled", "disabled");
        $(this).text("Sedang Menambahkan...");

        $.ajax(baseUrl+"/master_keuangan/periode_keuangan/tambah", {
           timeout: 500000,
           type: "post",
           data: {bulan: $("#periode_month").val(), tahun: $("#periode_year").val(), _token: '{{ csrf_token() }}' },
           dataType: 'json',
           success: function (data) {
              console.log(data);
               if(data.status == "sukses")
                alert("Periode Berhasil Dibuat Dan Secara Otomatis Diaktifkan...");
               else if(data.status == "exist")
                alert("Periode Sudah Ada. Data Gagal Disimpan...");
               else if(data.status == "past_insert")
                alert("Anda Tidak Bisa Menambahkan Periode Yang Sudah Berlalu...");

              $("#save").text("Simpan");
              $("#save").removeAttr("disabled");
           },
           error: function(request, status, err) {
              if (status == "timeout") {
                alert("Request Timeout. Data Gagal Ditambahkan");
              }else {
                alert("Internal Server Error. Data Gagal Ditambahkan");
              }

              $("#save").text("Simpan");
              $("#save").removeAttr("disabled");
          }
        });
     })

     $(".cek").change(function(){

        $(".cek").attr("disabled", "disabled");
        $id = $(this).attr("id"); $val = ""; $title = "";

        $("#sts").text("Sedang Merubah Status...");
        $("#sts").fadeIn(100);

        if($(this).is(":checked")){
          $val = "locked";
          $title = "Hilangkan Centang Untuk Membuka Kunci";
        }else{
          $val = "accessable"
          $title = "Centang Untuk Membuka Kunci";
        }

        $.ajax(baseUrl+"/master_keuangan/periode_keuangan/setting", {
           timeout: 10000,
           type: "post",
           data: {id: $id, val: $val, _token: '{{ csrf_token() }}' },
           dataType: 'json',
           success: function (data) {
               // console.log(data);
              if(data.status == "sukses"){
                $("#sts").text("Berhasil");
                $("#sts").fadeOut(2000);
                $("#"+$id).attr("title", $title);
              }

              $(".cek").removeAttr("disabled");
           },
           error: function(request, status, err) {
              if (status == "timeout") {
                alert("Request Timeout. Data Gagal Diubah");
              }else {
                alert("Internal Server Error. Data Gagal Diubah");
              }

              $(".cek").removeAttr("disabled");
          }
        });
     })
  </script>