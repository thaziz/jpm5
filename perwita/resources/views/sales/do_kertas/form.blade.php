@extends('main')

@section('title', 'dashboard')

@section('content')



<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> DO KERTAS
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <table class="table table-striped table-bordered dt-responsive nowrap table-hover">

                                </table>
                             <div class="col-xs-6">
                        </div>
                    </div>
                </form>
                <form id="form_header" class="form-horizontal">
                    <table class="table table-striped table-bordered table-hover">
                        <tbody>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="3">
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" readonly="readonly" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="ed_tampil" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date" style="width: 100%">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>                        
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    @if(Auth::user()->punyaAkses('Delivery Order','cabang'))
                                                <select onchange="ganti_nota()" class="form-control cabang_select">
                                            @foreach($cabang as $val)
                                                @if(Auth()->user()->kode_cabang == $val->kode)
                                                <option selected="" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                                @endforeach
                                                </select>
                                            @else
                                                <select disabled="" class="form-control cabang_select">
                                                @foreach($cabang as $val)
                                                @if(Auth::user()->kode_cabang == $val->kode)
                                                <option selected value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @else
                                                <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                                @endif
                                            @endforeach
                                                </select>
                                    @endif
                                    <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="ed_alamat" readonly="readonly" tabindex="-1" style="text-transform: uppercase" value="">
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Diskon</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="ed_diskon_h" readonly="readonly" tabindex="-1"  style="text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->diskon, 0, ",", ".") }}" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Total</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="ed_total_h" readonly="readonly" tabindex="-1"  style="text-align:right" @if ($data === null) value="0" @else value="{{ number_format($data->total, 0, ",", ".") }}" @endif>
                                     
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-info " id="btnadd" name="btnadd" ><i class="glyphicon glyphicon-plus"></i>Tambah</button>
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>
                    </div>
                </form>
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Kode Item</th>
                            <th>Nama Item</th>
                            <th>Keterangan</th>
                            <th>Jml</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Diskon</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Insert Edit Item DO Kertas</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal kirim" id="form_detail">
                                    <table class="table table-striped table-bordered table-hover ">
                                        <tbody>
                                            <tr style="display:none;">
                                                <td style="padding-top: 0.4cm; width:11%">Seq Id</td>
                                                <td>   
                                                    <input type="number" class="form-control" name="ed_id">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                    <input type="hidden" class="form-control" name="crud" class="form-control" >
                                                    <input type="hidden" class="form-control" name="ed_id_old">
                                                    <input type="hidden" class="form-control" name="ed_nomor_do">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Item</td>
                                                <td>
                                                    <input type="text" class="form-control" readonly="readonly" name="ed_kode_item" tabindex="-1" >   
                                                </td>
                                                <td colspan="4">
                                                    <select class="chosen-select-width B"  name="cb_item" id="cb_item">
                                                    </select>
                                                </td>
                                            </tr> 
                                            <tr>
                                                <td style="padding-top: 0.4cm">Satuan</td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control" readonly="readonly" name="ed_satuan" tabindex="-1" >   
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Jumlah</td>
                                                <td>
                                                    <input type="text" class="form-control angka" name="ed_jumlah" style="text-align: right;">
                                                </td>
                                            
                                                <td style="padding-top: 0.4cm">Harga</td>
                                                <td>
                                                    <input type="text" class="form-control angka" name="ed_harga" style="text-align: right;">
                                                </td>
                                            
                                                <td style="padding-top: 0.4cm">Total</td>
                                                <td>
                                                    <input type="text" class="form-control" readonly="readonly" name="ed_total" tabindex="-1" style="text-align: right;">
                                                    <input type="hidden" readonly="readonly" class="form-control" name="acc_penjualan" value="{{$do->acc_penjualan or null }}" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Diskon</td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control angka" name="ed_diskon" style="text-align: right;">
                                                </td>
                                            </tr>                               
                                            <tr>
                                                <td style="padding-top: 0.4cm">Netto</td>
                                                <td colspan="5">
                                                    <input type="text" class="form-control" readonly="readonly" name="ed_netto" tabindex="-1" style="text-align: right;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Asal</td>
                                                <td colspan="5">   
                                                    <select class="chosen-select-width"  name="cb_kota_asal" style="width:100%">
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                <td colspan="5">   
                                                    <select class="chosen-select-width"  name="cb_kota_tujuan" style="width:100%">
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Keterangan</td>
                                                <td colspan="5">   
                                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" >
                                                <td>                                    
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
        </div>
        </div>
    </div>
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
// datatable
$('#table_data').DataTable();

$(document).ready(function(){
    var ed_nomor = $('#ed_nomor').val();
    $.ajax({
        url:baseUrl + '/sales/nomor_do_kargo',
        data:{cabang},
        dataType:'json',
        success:function(data){
            $('#ed_nomor').val(data.nota);
        },
        error:function(){
            location.reload();
        }
    })
});
</script>
@endsection
