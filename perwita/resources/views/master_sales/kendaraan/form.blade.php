@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
      .id {display:none; }
    </style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Insert/Edit Kendaraan
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
                       <!--  <div class="form-group">

                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>

                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">

                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>

                              </select>
                            </div>
                          </div>
                          </div> -->
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
                                <td style="width:120px; padding-top: 0.4cm">Nopol</td>
                                <td>
                                    <input type="text" name="ed_nopol" id="ed_nopol" class="form-control" style="text-transform: uppercase" value="{{ $data->nopol or null }}" >
                                    <input type="hidden" name="ed_id" class="form-control" style="text-transform: uppercase" value="{{ $data->id or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                <td>
                                    <input type="text" name="ed_kode" class="form-control" style="text-transform: uppercase" value="{{ $data->kode or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Status</td>
                                <td>
                                    <select class="form-control" name="cb_status" >                                    
                                        <option value="OWN">OWN</option>
                                        <option value="SUB">SUB</option>
                                        <option value="DPT">DPT</option>
                                    </select>
                                </td>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td>
                                    <select class="form-control" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Subcon</td>
                                <td colspan="3">
                                    <select class="form-control" name="cb_subcon" >
                                    <option></option>
                                    @foreach ($subcon as $row)
                                        <option value="{{$row->kode}}">{{$row->nama}}</option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Divisi</td>
                                <td>
                                    <select class="form-control" name="cb_divisi" >                                    
                                        <option value="KARGO">KARGO</option>
                                        <option value="SUB">SUB</option>
                                        <option value="DPT">DPT</option>
                                    </select>
                                </td>
                                <td style="width:110px; padding-top: 0.4cm">Tipe Angkutan</td>
                                <td>
                                    <select class="form-control" name="cb_tipe_angkutan" >
                                    @foreach ($tipe_angkutan as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">No Rangka</td>
                                <td>
                                    <input type="text" name="ed_no_rangka" class="form-control" style="text-transform: uppercase" value="{{ $data->no_rangka or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">No Mesin</td>
                                <td>
                                    <input type="text" name="ed_no_mesin" class="form-control" style="text-transform: uppercase" value="{{ $data->no_mesin or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Merk</td>
                                <td colspan="3">
                                    <input type="text" name="ed_merk" class="form-control" style="text-transform: uppercase" value="{{ $data->merk or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Jenis Bak</td>
                                <td>
                                    <input type="text" name="ed_jenis_bak" class="form-control" style="text-transform: uppercase" value="{{ $data->jenis_bak or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Panjang</td>
                                <td>
                                    <input type="text" name="ed_panjang" class="form-control angka" style="text-transform: uppercase" value="{{ $data->p or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Lebar</td>
                                <td>
                                    <input type="text" name="ed_lebar" class="form-control angka" style="text-transform: uppercase" value="{{ $data->l or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Tinggi</td>
                                <td>
                                    <input type="text" name="ed_tinggi" class="form-control angka" style="text-transform: uppercase" value="{{ $data->t or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Volume</td>
                                <td>
                                    <input type="text" name="ed_volume" class="form-control" style="text-transform: uppercase" readonly="readonly" tabindex="-1"  value="{{ $data->volume or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Tahun Pembuatan</td>
                                <td>
                                    <input type="text" name="ed_tahun_pembuatan" class="form-control angka" style="text-transform: uppercase" value="{{ $data->tahun or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Seri Unit</td>
                                <td>
                                    <input type="text" name="ed_seri_unit" class="form-control" style="text-transform: uppercase" value="{{ $data->seri_unit or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Warna Kabin</td>
                                <td>
                                    <input type="text" name="ed_warna_kabin" class="form-control" style="text-transform: uppercase" value="{{ $data->warna_kabin or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">No BPKB</td>
                                <td>
                                    <input type="text" name="ed_no_bpkb" class="form-control" style="text-transform: uppercase" value="{{ $data->no_bpkb or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Tgl BPKB</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_bpkb" value="{{ $data->tgl_bpkb or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">No Kir</td>
                                <td>
                                    <input type="text" name="ed_no_kir" class="form-control" style="text-transform: uppercase" value="{{ $data->no_kir or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Tgl Kir</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_kir" value="{{ $data->tgl_kir or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Tgl Pajak Tahunan</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_pajak_tahunan" value="{{ $data->tgl_pajak_tahunan or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Tgl Pajak 5 Tahun</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_pajak_5_tahunan" value="{{ $data->tg_pajak_5_tahunan or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">GPS</td>
                                <td>
                                    <input type="text" name="ed_gps" class="form-control" style="text-transform: uppercase" value="{{ $data->gps or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Posisi BPKB</td>
                                <td>
                                    <input type="text" name="ed_posisi_bpkb" class="form-control" style="text-transform: uppercase" value="{{ $data->posisi_bpkb or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Ket BPKB</td>
                                <td>
                                    <input type="text" name="ed_ket_bpkb" class="form-control" style="text-transform: uppercase" value="{{ $data->ket_bpkb or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Asuransi</td>
                                <td>
                                    <input type="text" name="ed_asuransi" class="form-control" style="text-transform: uppercase" value="{{ $data->asuransi or null }}" >
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Harga Perolehan</td>
                                <td>
                                    <input type="text" name="ed_harga_perolehan" class="form-control angka" style="text-transform: uppercase" @if ($data === null) value="0" @else value="{{ number_format($data->harga, 0, ",", ".") }}" @endif>
                                </td>
                                <td style="width:120px; padding-top: 0.4cm">Tgl Perolehan</td>
                                <td>
                                   <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_perolehan" value="{{ $data->tgl_perolehan or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="6">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success " id="btnsimpan" name="btnsimpan" ><i class="glyphicon glyphicon-save"></i>Simpan</button>
                        </div>


                    </div>
                </form>
                
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Kota</h4>
                      </div>
                      <div class="modal-body">
                            <form class="form-horizontal  kirim">
                                <table id="table_data" class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width:120px; padding-top: 0.4cm">Kota</td>
                                            <td>
                                                <input type="hidden" name="ed_id" class="form-control" style="text-transform: uppercase" >
                                                <input type="hidden" name="ed_nopol_rute" class="form-control" style="text-transform: uppercase" >
                                                <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                <input type="hidden" class="form-control" name="crud" class="form-control" >
                                                <input type="hidden" class="form-control" name="ed_kota" class="form-control" >
                                                <select class="chosen-select-width"  name="cb_kota" style="width:100%" id="cb_kota">
                                                    <option value=""></option>
                                                @foreach ($kota as $row)
                                                    <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                @endforeach
                                                </select>
                                            </td>
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
    $(document).ready( function () {
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $("select[name='cb_status']").val('{{ $data->status or ''  }}');
        $("select[name='cb_divisi']").val('{{ $data->divisi or ''  }}');
        $("select[name='cb_subcon']").val('{{ $data->kode_subcon or ''  }}');
        $("select[name='cb_tipe_angkutan']").val('{{ $data->tipe_angkutan or ''  }}');
        
        
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
    });

    

    $(document).on("click","#btnsimpan",function(){
        $.ajax(
        {
            url :  baseUrl + "/master_sales/kendaraan/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/master_sales/kendaraan';
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/master_sales/kendaraan';
                    }
                }else{
                    swal("Error","invalid order","error");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    


</script>
@endsection
