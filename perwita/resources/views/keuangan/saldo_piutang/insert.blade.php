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
    <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px;">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Master Saldo Piutang</small></span>
      <table width="100%" border="0" class="table-form" style="margin-top: 10px;">
        <tr>
          <th>Kode Customer</th>
          <td>
            <select name="customer" class="chosen-select" id="customer">
              <option value="1">- Pilih Customer</option>
              @foreach ($cust as $customer)
                <option value="{{ $customer->kode }}" data-nama="{{ $customer->nama }}" data-alamat="{{ $customer->alamat }}">{{ $customer->kode }}</option>
              @endforeach
            </select>
          </td>
        </tr>

        <tr>
          <th>Nama</th>
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
            <input type="text" class="form-control bulan" placeholder="Bulan/Tahun" style="height: 30px; cursor: pointer; background: white;" readonly>
          </td>
        </tr>

        <tr>
          <th>Saldo Awal</th>
          <td>
            <input type="text" class="form-control" placeholder="0" style="height: 30px; text-align: right;">
          </td>
        </tr>

      </table>
    </div>

    <div class="col-md-12" style="background: #fff; padding: 10px; border: 1px solid #ddd;border-radius: 5px; margin-top: 25px;">
      <span class="text-muted" style="position: absolute; background: white; top: -10px; padding: 0px 10px; font-style: italic;"><small>Detail Saldo Piutang</small></span>
      <table width="100%" border="0" class="table-form" style="margin-top: 10px;">
        <tr>
          <th>Nomor Faktur</th>
          <td>
            <input type="text" class="form-control" placeholder="Masukkan Nomor Faktur" style="height: 30px;">
          </td>
        </tr>

        <tr>
          <th>Tanggal Faktur</th>
          <td>
            <input type="text" class="form-control tgl_faktur" placeholder="Tanggal/Bulan/Tahun" style="height: 30px; cursor: pointer;background: white;" readonly>
          </td>
        </tr>

        <tr>
          <th>Jatuh Tempo</th>
          <td>
            <input type="text" class="form-control jatuh_tempo" placeholder="Tanggal/Bulan/Tahun" style="height: 30px;cursor: pointer;background: white;" readonly>
          </td>
        </tr>

        <tr>
          <th>Keterangan</th>
          <td>
            <input type="text" class="form-control" placeholder="" style="height: 30px;">
          </td>
        </tr>

        <tr>
          <th>Jumlah</th>
          <td>
            <input type="text" class="form-control" placeholder="0" style="height: 30px; text-align: right;">
          </td>
        </tr>

      </table>
    </div>

    <div class="col-md-12 m-t text-right" style="border-top: 1px solid #ddd; padding: 15px 10px 0px 10px">
      <button class="btn btn-default btn-sm"><i class="fa fa-plus-square-o"></i>&nbsp;Tambahkan</button>
      <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>&nbsp;Edit</button>
      <button class="btn btn-danger btn-sm"><i class="fa fa-times"></i>&nbsp;Hapus</button>
      <button class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;Simpan</button>
    </div>

  </div>

  <div class="col-md-7" style="background:; min-height: 300px; padding: 0px;">
    <div class="col-md-12" style="padding: 0px; height: 460px; overflow-y: scroll; border-bottom: 1px solid #bbb;">
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

        <tbody>
          <tr class="row-detail">
            <td>FKT J-0038/1207</td>
            <td>10/12/2017</td>
            <td>20/12/2017</td>
            <td>Piutang PT.JAWA POS</td>
            <td class="text-right">232.514.744,00</td>
          </tr>

          <tr class="row-detail">
            <td>FKT J-0038/1207</td>
            <td>10/12/2017</td>
            <td>20/12/2017</td>
            <td>Piutang PT.JAWA POS</td>
            <td class="text-right">232.514.744,00</td>
          </tr>

          <tr class="row-detail">
            <td>FKT J-0038/1207</td>
            <td>10/12/2017</td>
            <td>20/12/2017</td>
            <td>Piutang PT.JAWA POS</td>
            <td class="text-right">232.514.744,00</td>
          </tr>

        </tbody>
      </table>
    </div>

    <div class="col-md-12" style="padding: 0px; margin-top: 8px;">
      <table border="0" class="table-detail" width="100%">
        <tbody>
          <tr>
            <td class="text-center" width="90%" colspan="4" style="font-weight: bold;">Grand Total</td>
            <td class="text-right"><b>200.000.000.000,00</b></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div>

<script type="text/javascript">
  $(document).ready(function(){
    $(".chosen-select").chosen({width: '100%'});

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
  })
  
</script>
    
