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
                    <h5> SURAT JALAN TRAYEK
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
                                <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                <td colspan="4">
                                    <input type="text" name="ed_nomor" id="ed_nomor" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" id="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tanggal" name="tanggal" value="{{ $data->tanggal or  date('Y-m-d') }} " onblur="ganti_nota()" >
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Filter Tanggal</td>
                                <td>
                                    <div class="input-group ">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text" class="range_date form-control" name="range_date" value="{{ carbon\carbon::now()->subDays(30)->format('d/m/Y') }} - {{ carbon\carbon::now()->format('d/m/Y') }}">
                                    </div>
                                </td>
                            </tr>
                            @if (Auth::user()->punyaAkses('Surat Jalan By Trayek','cabang'))
                                <tr>
                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                    <td colspan="4">
                                        <select class="form-control chosen-select-width cabang" name="cb_cabang" onchange="ganti_nota()" >
                                        @foreach ($cabang as $row)
                                            <option @if ($row->kode == Auth::user()->kode_cabang)
                                                selected="" 
                                            @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                        <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                    </td>
                                </tr>
                            @else
                                <tr class="disabled">
                                    <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                    <td colspan="4">
                                        <select class="form-control chosen-select-width cabang" name="cb_cabang" onchange="ganti_nota()" >
                                        @foreach ($cabang as $row)
                                            <option @if ($row->kode == Auth::user()->kode_cabang)
                                                selected="" 
                                            @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                        <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                    </td>
                                </tr>
                            @endif
                            
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Rute</td>
                                <td colspan="4">
                                    <select class="chosen-select-width" name="cb_rute" id="cb_rute" >
                                        <option></option>
                                    @foreach ($rute as $row)
                                        <option value="{{ $row->kode }}">{{ $row->nama }}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_nama_rute" class="form-control" style="text-transform: uppercase" value="{{ $data->nama_rute or null }}" >
                                    <input type="hidden" name="ed_kode_rute" class="form-control" style="text-transform: uppercase" value="{{ $data->kode_rute or null }}" >
                                </td>
                            </tr>
                            <tr >
                                <td style="padding-top: 0.4cm">Nopol</td>
                                <td colspan="4">
                                    <select class="chosen-select-width" id="cb_nopol" name="cb_nopol" style="width:100%">
                                        <option></option>
                                    @foreach ($kendaraan as $row)
                                        <option value="{{ $row->id }}">{{ $row->nopol }}</option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_nopol" class="form-control" style="text-transform: uppercase" value="{{ $data->nopol or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Sopir</td>
                                <td colspan="4">
                                    <input type="text" name="ed_sopir" class="form-control" style="text-transform: uppercase" value="{{ $data->sopir or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="4">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
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
                            <th style="display:none;">id</th>
                            <th>Nomor Order</th>
                            <th>Tgl Order</th>
                            <th>Tujuan</th>
                            <th>Alamat</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                
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

<!-- modal -->
<div id="modal" class="modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Insert Nomor DO</h4>
  </div>
      <div class="modal-body">
            <form class="form-horizontal  kirim">
                <table id="table_data_do" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nomor Order</th>
                            <th>Tgl Order</th>
                            <th>Tujuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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

<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

    $('.tanggal').datepicker({
        format:'yyyy-mm-dd'
    });
    $('.range_date').daterangepicker({
        autoclose: true,
          "opens": "left",
          locale: {
          format: 'DD/MM/YYYY'
          }
    });
    $(document).ready( function () {
        $('#table_data').DataTable({
            "lengthChange": true,
            "ordering": true,
            "searching": false,
            "paging": false,
            "ordering": true,
            "info": false,
            "responsive": true,
            
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
                "url": baseUrl + "/sales/surat_jalan_trayek_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id" , render: $.fn.dataTable.render.number( '.'),"sClass": "id" },
            { "data": "nomor_do" },
            { "data": "tanggal" },
            { "data": "tujuan" },
            { "data": "alamat_penerima" },
            { "data": "type_kiriman" },
            { "data": "button" },
            ]
        });
        
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
        var tanggal = $('.tanggal').val();
        var cabang  = $('.cabang').val();
        $.ajax({
            url:baseUrl+'/sales/surat_jalan_trayek_form/ganti_nota',
            data:{cabang,tanggal},
            dataType : 'json',
            success:function(response){
                $('#ed_nomor_old').val(response.nota);
                $('#ed_nomor').val(response.nota);
            }
        });

    });
    
    function ganti_nota() {
        var tanggal = $('.tanggal').val();
        var cabang  = $('.cabang').val();
        $.ajax({
            url:baseUrl+'/sales/surat_jalan_trayek_form/ganti_nota',
            data:{cabang,tanggal},
            dataType : 'json',
            success:function(response){
                $('#ed_nomor_old').val(response.nota);
                $('#ed_nomor').val(response.nota);
            }
        });
    }
    function tampil_data_do(){
        var rute = $("#cb_rute").val();
        var cabang = $(".cabang").val();
        var range_date = $(".range_date").val();
  
        var range_date = $('.range_date').val();
        var cabang  = $('.cabang').val();
        $('#table_data_do').DataTable({
            "lengthChange": true,
            "ordering": true,
            "searching": false,
            "paging": false,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
                "url": baseUrl + "/sales/surat_jalan_trayek_form/tampil_do",
                "type": "GET",
                "data" : {cabang,range_date},
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "tujuan" },
            { "data": "button" },
            ]
        });
    }



    $(document).on("click","#btnsimpan",function(){
        $("select[name='cb_rute']").prop('disabled', false).trigger("chosen:updated");
        $("input[name='crud']").val('N');
        $.ajax(
        {
            url :  baseUrl + "/sales/surat_jalan_trayek/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
             
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              // swal("Error!", textStatus, "error");
            }
        });
        
        
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $(this).val();
        $("input[name='ed_cabang']").val(data);
    });

    $('#cb_nopol').change(function(){
        $nopol = $("select[name='cb_nopol'] option:selected").text();
        $("input[name='ed_nopol']").val($nopol);
    });

    $('#cb_rute').change(function(){
        $kode_rute = $("select[name='cb_rute'] option:selected").val();
        $nama_rute = $("select[name='cb_rute'] option:selected").text();
        $("input[name='ed_kode_rute']").val($kode_rute);
        $("input[name='ed_nama_rute']").val($nama_rute);
    });


    $(document).on("click","#btnadd",function(){
        
        var table = $('#table_data_do').DataTable();
        table.ajax.reload();
        tampil_data_do();

        $('#modal').modal('show');
    });

    $(document).on( "click",".btndelete", function() {

    });


</script>
@endsection
