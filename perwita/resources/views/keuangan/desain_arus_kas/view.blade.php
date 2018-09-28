<style>
  
  .table_neraca td{
    font-weight: 600;
    border-top:1px dotted #efefef;
  }

  .table_neraca td.lv1{
    padding: 5px 10px;
  }

  .table_neraca td.lv2{
    padding: 5px 25px;
  }

  .table_neraca td.lv3{
    padding: 5px 40px;
  }

  .table_neraca td.money{
    text-align: right;
    padding: 5px 10px;
  }

  .table_neraca td.total{
    border-top: 1px solid #666;
  }

</style>

<div class="row">
  
  {{-- Aktiva START --}}

  <div class="col-md-12">
    <div class="col-md-12 text-center text-muted" style="padding: 10px; border: 1px solid #eee; box-shadow: 0px 0px 10px #eee;">Laporan Arus Kas</div>

    <div class="col-md-12" style="border: 1px solid #eee; box-shadow: 0px 0px 10px #eee; padding: 0px;">
      <table class="table_neraca" width="100%" style="font-size: 8pt;" border="0">

        @foreach($data_neraca as $data_neraca_aktiva)
            <?php 
              $level = "lv".$data_neraca_aktiva["level"];
            ?>
            
            @if($data_neraca_aktiva["jenis"] == 1)
              <tr>
                <td colspan="3" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
              </tr>
            @elseif($data_neraca_aktiva["jenis"] == 2)
              <tr>
                <td width="55%" class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                <td class="money">{{ $data_neraca_aktiva["total"] }}</td>
                <td></td>
              </tr>

                {{-- @foreach($data_detail as $data_detail_aktiva)
                  @if($data_detail_aktiva["id_parrent"] == $data_neraca_aktiva["nomor_id"])
                    <tr>
                      <td class="lv3">{{ $data_detail_aktiva["nama_referensi"] }}</td>
                      <td class="money">{{ $data_detail_aktiva["total"] }}</td>
                      <td></td>
                    </tr>
                  @endif
                @endforeach --}}

            @elseif($data_neraca_aktiva["jenis"] == 3)
              <tr>
                <td class="{{ $level }}">{{ $data_neraca_aktiva["keterangan"] }}</td>
                <td></td>
                <td class="money total">{{ $data_neraca_aktiva["total"] }}</td>
              </tr>
            @elseif($data_neraca_aktiva["jenis"] == 4)
              <tr>
                <td class="{{ $level }}">&nbsp;</td>
                <td></td>
                <td></td>
              </tr>
            @endif
        @endforeach

      </table>
    </div>
  </div>

  {{-- Aktiva END --}}

</div>

{{-- <div class="row">
  <div class="col-md-12 m-t">
    <div class="col-md-12" style="border: 1px solid #eee; box-shadow: 0px 0px 10px #eee; padding: 0px;">
      <table class="table_neraca" width="100%" style="font-size: 8pt;" border="0">

        <tr>
          <td class="text-center">Laba Rugi</td>
          <td class="money">XXXX</td>
        </tr>

      </table>
    </div>
  </div>
</div> --}}

@if($cek->is_active == 1)
  <div class="row">
    <div class="col-md-12 m-t-lg">
      <a href="{{ route("arus_kas.index_single", "bulan?m=".date("m")."&y=".date("Y")."") }}" target="_blank" class="btn btn-primary btn-sm pull-right" style="font-size: 8pt;" id="simpan_desain">Buka Laporan Arus Kas</a>
    </div>
  </div>
@endif