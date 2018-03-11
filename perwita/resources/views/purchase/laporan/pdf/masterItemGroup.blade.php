@extends('main')

@section('title', 'dashboard')

@section('extra_styles')
<style>
  #table-parent{
    border: 2px solid #000;
  }

  div.surat{
    margin-top: 35px;
    font-size: 20px;
    line-height: 30px;
    font-weight: bold;
  }

  td#td-first, td#td-first-sibbling{
    border: 1px solid #000;
  }
  td#td-first-sibbling{
    width: auto;
    padding: 29px 7px 0;
  }
</style>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <div class="ibox float-e-margins">
        <div class="ibox-content">
          <a class="btn btn-info" href="{{ route('masterItemGroup.ViewReport', ['download' => 'pdf']) }}">
            <i class="fa fa-print" aria-hidden="true"></i> Download PDF 
          </a>
          <table border="1" class="table table-bordered" id="table-parent">
            <tr>
              <td valign="middle" align="center" id="td-first">
                <img src="{{ asset('/assets/img/dboard/logo/Capture.png') }}" alt="">
              </td>

              <td valign="middle" align="center" id="td-first">
                <div class="surat">
                  LAPORAN MASTER BARANG GROUP
                </div>
              </td>

              <td valign="middle" id="td-first-sibbling">
                <table width="100%" style="height: auto;">
                  <tr>
                    <td width="75">Tanggal</td>
                    <td width="5">:</td>
                    <td width="25"></td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td colspan="3" style="padding: 0;">
                <table width="100%" style="height: 35px; padding: 0;" border="1">
                  <tr>
                    <td valign="middle" align="center">NO</td>
                    <td valign="middle" align="center">Kode</td>
                    <td valign="middle" align="center">Nama</td>
                  </tr>

                  @for ($index = 0; $index < count($masterItemGroup["kodeGroup"]); $index++)
                    <tr>
                      <td valign="middle" align="center">{{ $index + 1 }}</td>
                      <td valign="middle" align="center">{{ $masterItemGroup["kodeGroup"][$index] }}</td>
                      <td valign="middle" align="center">{{ $masterItemGroup["keterangan"][$index] }}</td>
                    </tr>
                  @endfor                 
                </table>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </div>  
  </div>
</div>
@endsection