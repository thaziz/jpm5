<style type="text/css">
  <style>
    .table-form{
      border-collapse: collapse;
    }

    .table-form th{
      font-weight: 600;
    }

    .table-form th,
    .table-form td{
      padding: 2px 0px;
    }

    .table-form input{
      font-size: 10pt;
    }

    .table-detail{
      font-size: 8pt;
    }

    .table-detail td,
    .table-detail th{
      border: 1px solid #bbb;
    }

    .table-detail th{
      padding: 3px 0px 10px 0px;
      background: white;
      position: sticky;
      top: 0px;
    }

    .table-detail tfoot th{
      position: sticky;
      bottom:0px;
    }

    .table-detail td{
      padding: 5px;
    }

    .row-detail{
      cursor: pointer;
    }

    .row-detail:hover{
      background: #1b82cf;
      color: #fff;
    }
  </style>
</style>

<div class="row">

  <div class="col-md-5">
    <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px;" id="master_saldo_piutang" data-toggle="tooltip" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Master Saldo Piutang</small></span>
      <form id="customer_form">
        <table width="100%" border="0" class="table-form" style="margin-top: 10px;">
          <tr>
            <th width="30%">Pilih Cabang</th>
            <td>
              <select name="customer" class="chosen-select" id="cabang_piutang" name="cabang" style="background: red;">
                <option value="---">- Pilih Cabang</option>
                @foreach ($cab as $cabang)
                  <option value="{{ $cabang->kode }}">{{ $cabang->nama }}</option>
                @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <th>Kode Customer</th>
            <td>
              <select name="customer" class="chosen-select" id="customer" name="customer" style="background: red;">
                <option value="---">- Pilih Customer</option>
                @foreach ($cust as $customer)
                  <option value="{{ $customer->kode }}" data-nama="{{ $customer->nama }}" data-alamat="{{ $customer->alamat }}">{{ $customer->kode }} - {{ $customer->nama }}</option>
                @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <th>Nama Customer</th>
            <td>
              <input type="text" class="form-control" id="nama_cust" placeholder="" style="height: 30px;" disabled>
            </td>
          </tr>

          <tr>
            <th>Alamat</th>
            <td>
              <input type="text" class="form-control" id="alamat_cust" placeholder="" style="height: 30px;" disabled>
            </td>
          </tr>

          <tr>
            <th>Periode</th>
            <td>
              <input type="text" class="form-control" id="periode" placeholder="Bulan/Tahun" style="height: 30px; cursor: pointer; background: white;" readonly name="periode" readonly value="{{ date("m/Y") }}">
            </td>
          </tr>

          <tr>
            <th>Saldo Awal</th>
            <td>
              <input type="text" class="form-control currency" name="saldo_awal" id="saldo_awal" placeholder="0" style="height: 30px; text-align: right;">
            </td>
          </tr>

        </table>
      </form>
    </div>

    <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px; margin-top: 25px;" id="detail_saldo_piutang" data-toggle="tooltip" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Detail Saldo Piutang</small></span>

      <span class="text-muted" style="position: absolute; background: white; top: -10px; right: -5px; padding: 0px 0px; font-style: italic;"><small><i class="fa fa-arrow-right"></i> <i class="fa fa-arrow-right"></i> <i class="fa fa-arrow-right"></i></small></span>
      <table width="100%" border="0" class="table-form" style="margin-top: 10px;" id="table-datail">
        <tr>
          <th>Nomor Faktur</th>
          <td>
            <input type="text" class="form-control" placeholder="Masukkan Nomor Faktur" style="height: 30px;" id="nomor_faktur" disabled>
          </td>
        </tr>

        <tr>
          <th>Tanggal Faktur</th>
          <td>
            <input type="text" class="form-control tgl_faktur" placeholder="Tanggal/Bulan/Tahun" style="height: 30px; cursor: not-allowed;background: white;" id="tanggal_faktur" disabled>
          </td>
        </tr>

        <tr>
          <th>Jatuh Tempo</th>
          <td>
            <input type="text" class="form-control jatuh_tempo" placeholder="Tanggal/Bulan/Tahun" style="height: 30px;cursor: not-allowed;background: white;" id="jatuh_tempo" disabled>
          </td>
        </tr>

        <tr>
          <th>Keterangan</th>
          <td>
            <input type="text" class="form-control" placeholder="" style="height: 30px;" id="keterangan" disabled>
          </td>
        </tr>

        <tr>
          <th>Jumlah</th>
          <td>
            <input type="text" class="form-control currency" placeholder="0" style="height: 30px; text-align: right;" id="jumlah" disabled>
          </td>
        </tr>

      </table>
    </div>

    <div class="col-md-12 m-t text-right" style="border-top: 1px solid #ddd; padding: 15px 10px 0px 10px">
      <i class="fa fa-times" style="color: red; cursor: pointer; display: none;" data-toggle="tooltip" data-placement="right" title="Bersihkan Form Detail Saldo Piutang" id="cancel"></i> &nbsp; &nbsp; 
      <button class="btn btn-primary btn-sm" id="search"><i class="fa fa-search"></i>&nbsp;Pencarian Faktur</button>
      <button class="btn btn-success btn-sm" id="simpan"><i class="fa fa-check"></i>&nbsp;Simpan</button>
    </div>

  </div>

  <div class="col-md-7" style="background:; min-height: 300px; padding: 0px;">
    <div class="col-md-12" style="padding: 0px; height: 495px; overflow-y: scroll; border-bottom: 1px solid #bbb;">
      <table border="0" class="table-detail" width="100%">
        <thead>
          <tr>
            <th width="18%" class="text-center">Nomor Faktur</th>
            <th width="13%" class="text-center">Tanggal</th>
            <th width="14%"class="text-center">Jatuh Tempo</th>
            <th class="text-center">Keterangan</th>
            <th width="19%" class="text-center">Jumlah</th>
          </tr>
        </thead>

        <tbody id="body_detail">
          
            <td colspan="5" class="text-center text-muted">Lengkapi Data Form Master. Lalu Klik Pencarian Faktur Untuk Menampilkan Data Faktur Customer Terkait.</td>

        </tbody>
      </table>
    </div>

    <div class="col-md-12" style="padding: 0px; margin-top: 8px;">
      <table border="0" class="table-detail" width="100%">
        <tbody>
          <tr>
            <td class="text-center" width="79%" colspan="4" style="font-weight: bold;">Grand Total</td>
            <td class="text-right" id="grand_total"><b></b></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script type="text/javascript">


  $(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip();

    $data_detail = [];

    $(".chosen-select").chosen({width: '20em'});

    $('.bulan').datepicker({
        format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });

    $('.jatuh_tempo').datepicker({
        format: "dd/mm/yyyy",
    });

    $('.tgl_faktur').datepicker({
        format: "dd/mm/yyyy",
    }).on("changeDate", function(){
      $('.jatuh_tempo').val("");
      $('.jatuh_tempo').datepicker("setStartDate", $(this).val());
    });

    $("#customer").change(function(){
      nama = $(this).find(":selected").data("nama");
      alamat = $(this).find(":selected").data("alamat");

      $("#nama_cust").val(nama);
      $("#alamat_cust").val(alamat);
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

    $("#search").click(function(evt){
      evt.stopImmediatePropagation();

      $customer = $("#customer").val();
      $periode = $("#periode").val();
      $cabang = $("#cabang_piutang").val();

      // alert($("#cabang_piutang").val());

      if($customer == "---" || $periode == "" || $cabang == "---"){
        $("#master_saldo_piutang").tooltip("show");
        $( "#master_saldo_piutang" ).effect("shake");

        return false;
      }

      let html = '<td colspan="5" class="text-center text-muted">'+
                    '<i class="fa fa-spinner fa-pulse fa-fw"></i> &nbsp; Sedang Mencari Faktur. Harap Tunggu..'+
                    '<span class="sr-only">Loading...</span>'+
                  '</td>';
      
      $('#body_detail').html(html);

      $.ajax(baseUrl+"/master_keuangan/saldo_piutang/get_invoice",{
        type: "post",
        dataType: "json",
        data: { customer: $customer, periode: $periode, cabang : $cabang, _token: "{{ csrf_token() }}" },
        success: function(response){
          console.log(response);
          if(response.status == "sukses"){
            alert("Desain Berhasil Ditambahkan");
            reset_all();
          }else if(response.status == "exist"){
            alert("Customer Ini Sudah Diinputkan");
          }
        },error: function(err){
          let html = '<td colspan="5" class="text-center text-muted">'+
                        '<i class="fa fa-frown-o fa-fw"></i> &nbsp; Ups . Mohon Maaf. Terjadi Masalah, Coba Lagi Nanti..'+
                        '<span class="sr-only">Loading...</span>'+
                      '</td>';

          $('#body_detail').html(html);
        }
      })

    });

    $("#body_detail").on("click", ".row-detail", function(evt){
      evt.stopImmediatePropagation();
      
      $getId = $data_detail.findIndex(x => x.nomor_faktur == $(this).data("nf"));

      // console.log($data_detail[$getId]);

      $("#nomor_faktur").val($data_detail[$getId].nomor_faktur);
      $("#tanggal_faktur").val($data_detail[$getId].tanggal_faktur);
      $("#jatuh_tempo").val($data_detail[$getId].jatuh_tempo);
      $("#keterangan").val($data_detail[$getId].keterangan);
      $("#jumlah").val($data_detail[$getId].jumlah);

      $("#edit").removeAttr("disabled");
      $("#hapus").removeAttr("disabled");
      $("#tambah").attr("disabled", "disabled");
      $("#cancel").css("display", "");
    });

    $("#edit").click(function(evt){
      evt.stopImmediatePropagation();

      nomor_faktur = $("#nomor_faktur").val().toUpperCase();
      tanggal_faktur = $("#tanggal_faktur").val();
      jatuh_tempo = $("#jatuh_tempo").val();
      keterangan = $("#keterangan").val().toUpperCase();
      jumlah = $("#jumlah").val().split(',')[0].replace(/\./g, '');

      // alert(jumlah);

      if(nomor_faktur == "" || tanggal_faktur == "" || jatuh_tempo == "" || keterangan == "" || jumlah == ""){
        alert("inputan Detail Saldo Piutang Tidak Boleh Kosong");
        return false;
      }

      $id = $data_detail.findIndex(x => x.nomor_faktur == nomor_faktur);

      if($id == -1){
        alert("Nomor Faktur Tidak Ditemukan Di Detail");
        return false;
      }

      $data_detail[$id] = {
          nomor_faktur    : nomor_faktur,
          tanggal_faktur  : tanggal_faktur,
          jatuh_tempo     : jatuh_tempo,
          keterangan      : keterangan,
          jumlah          : jumlah
      }

      fill_detail();
      detail_reset();
    });

    $("#hapus").click(function(evt){
      evt.stopImmediatePropagation();

      nomor_faktur = $("#nomor_faktur").val().toUpperCase();

      // alert(jumlah);

      if(nomor_faktur == ""){
        alert("Nomor Faktur Tidak Boleh Koson");
        return false;
      }

      $id = $data_detail.findIndex(x => x.nomor_faktur == nomor_faktur);

      if($id == -1){
        alert("Nomor Faktur Tidak Ditemukan Di Detail");
        return false;
      }

      $data_detail.splice($id, 1);

      fill_detail();
      detail_reset();
    });

    $("#simpan").click(function(evt){
      evt.stopImmediatePropagation();

      $customer = $("#customer").val();
      $periode = $("#periode").val();
      $cabang = $("#cabang_piutang").val();
      $saldo = $("#saldo_awal").val();

      // alert($customer);

      if($customer == "---" || $periode == "" || $cabang == "---"){
        $("#master_saldo_piutang").tooltip("show");
        $( "#master_saldo_piutang" ).effect("shake");

        return false;
      }

      $.ajax(baseUrl+"/master_keuangan/saldo_piutang/save",{
        type: "post",
        dataType: "json",
        data: { cust: { saldo: $saldo, customer: $customer, periode: $periode, cabang : $cabang }, detail: $data_detail, _token: "{{ csrf_token() }}" },
        success: function(response){

          console.log(response);
          reset_all();

          if(response.status == "sukses"){
            alert("Desain Berhasil Ditambahkan");
            reset_all();
          }else if(response.status == "exist"){
            alert("Customer Ini Sudah Diinputkan");
          }
        }
      })

    })

    $("#cancel").click(function(evt){
      detail_reset();
    });

    function fill_detail(){
      $html = ""; $total = 0;
      $.each($data_detail, function(i, n){
        $html = $html + '<tr class="row-detail" data-nf = "'+n.nomor_faktur+'">'+
                  '<td>'+n.nomor_faktur+'</td>'+
                  '<td>'+n.tanggal_faktur+'</td>'+
                  '<td>'+n.jatuh_tempo+'</td>'+
                  '<td>'+n.keterangan+'</td>'+
                  '<td class="text-right">'+addCommas(n.jumlah)+',00</td>'+
                '</tr>';

        $total += parseInt(n.jumlah);
      })

      $("#saldo_awal").val($total);
      $("#grand_total b").text(addCommas($total)+",00");
      $("#body_detail").html($html);
    }

    function detail_reset(){
      $("#nomor_faktur").val("");
      $("#tanggal_faktur").val("");
      $("#jatuh_tempo").val("");
      $("#keterangan").val("");
      $("#jumlah").val("");

      $("#edit").attr("disabled", "disabled");
      $("#hapus").attr("disabled", "disabled");
      $("#tambah").removeAttr("disabled");
      $("#cancel").css("display", "none");

      // console.log($data_detail);
    }

    function reset_all(){
      detail_reset();

      // $("#cabang_piutang").val("---");
      $("#customer").val("---");
      $("#periode").val("{{ date("m/Y") }}");
      $("#nama_cust").val("");
      $("#alamat_cust").val("");

      // $('#cabang_piutang').trigger("chosen:updated");
      $('#customer').trigger("chosen:updated");

      $data_detail = [];

      fill_detail();
    }

    function addCommas(nStr) {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
      return x1 + x2;
    }

  })
  
</script>
    
