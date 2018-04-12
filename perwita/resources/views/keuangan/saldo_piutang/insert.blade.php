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

  <form id="form">

  <div class="col-md-12">
    <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px; border-bottom: 0px;" id="master_saldo_piutang" data-toggle="tooltip" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Informasi Cabang Dan Periode</small></span>
      
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <table width="100%" border="0" class="table-form" style="margin-top: 10px;">
          <tr>
            <th>Pilih Cabang</th>
            <td width="40%">
              <select name="cabang" class="chosen-select" id="cab" style="background: red;">
                <option value="---">- Pilih Cabang</option>
                @foreach ($cab as $cabang)
                  <option value="{{ $cabang->kode }}">{{ $cabang->nama }}</option>
                @endforeach
              </select>
            </td>

            <th>Periode</th>
            <td width="20%">
              <input type="text" class="form-control" value="{{ date("m/Y") }}" name="periode">
            </td>
          </tr>

        </table>
    </div>


    <div class="col-md-12 m-t-lg" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px;" id="master_saldo_piutang" data-toggle="--" data-placement="top" title="Pastikan Tidak Ada Data Yang Kosong">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Form Saldo Awal Piutang Per Customer</small></span>
      
      <div class="col-md-12" style="padding: 0px; height: 320px; overflow-y: scroll; border-bottom: 1px solid #bbb;">
          <table width="100%" border="0" class="table table-bordered" style="margin-top: 10px;">
            <thead>
              <tr>
                <th width="20%" class="text-center">Kode Customer</th>
                <th class="text-center">Nama Customer</th>
                <th width="30%" class="text-center">Saldo Awal Piutang</th>
              </tr>
            </thead>

            <tbody id="cust_wrap">
                @foreach($cust as $customer)
                  <tr>
                    <td class="text-center">
                      {{ $customer->kode }}
                      <input type="hidden" value="{{ $customer->kode }}" name="customer[]" readonly>
                    </td>
                    <td class="text-center">{{ $customer->nama }}</td>
                    <td class="text-center">
                      <input type="text" class="form-control currency text-right" name="jumlah[]" value="0" readonly>
                    </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
      </div>

      <div class="col-md-12 m-t text-right">
        <button class="btn btn-primary btn-sm" id="simpan"><i class="fa fa-check"></i>&nbsp;Simpan</button>
      </div>
    </div>
  </div>
  
  </form>

</div>

<script type="text/javascript">


  $(document).ready(function(){

    $(".chosen-select").chosen({width: '90%'});
    $('[data-toggle="tooltip"]').tooltip();

    // console.log(customer);

    $('#cust_wrap .currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
    });

    $("#cab").change(function(){
      if($(this).val() == "---")
        $(".currency").attr("readonly", "readonly");
      else
        $(".currency").removeAttr("readonly");
    })

    $("#simpan").click(function(evt){
      evt.stopImmediatePropagation();
      $cabang = $("#cab").val();
      var form = $('#form');

      // alert($customer);

      if($cabang == "---"){
        $("#master_saldo_piutang").tooltip("show");
        $( "#master_saldo_piutang" ).effect("shake");

        return false;
      }

      $.ajax(baseUrl+"/master_keuangan/saldo_piutang/save",{
        type: "post",
        dataType: "json",
        data: form.serialize(),
        success: function(response){

          console.log(response);

          if(response.status == "sukses"){
            alert("Desain Berhasil Ditambahkan");
            reset_all();
          }
        }
      })

      return false;
    })

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

      $("#cabang").val("---");
      $("#customer").val("---");
      $("#periode").val("");
      $("#nama_cust").val("");
      $("#alamat_cust").val("");

      $('#cabang').trigger("chosen:updated");
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
    
