@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> KONTRAK
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
                                <td colspan="3">
                                    <input type="text" name="ed_nomor" id="ed_nomor" readonly="readonly" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" name="ed_nomor_old" class="form-control" style="text-transform: uppercase" value="{{ $data->nomor or null }}" >
                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                    <input type="hidden" class="form-control" name="crud_h" class="form-control" @if ($data === null) value="N" @else value="E" @endif>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Tanggal</td>
                                <td colspan="3">
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Mulai</td>
                                <td >
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_mulai" value="{{ $data->mulai or  date('Y-m-d') }}">
                                    </div>
                                </td>
                                <td style="padding-top: 0.4cm">Berakhir</td>
                                <td>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_akhir" value="{{ $data->akhir or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Kode Customer</td>
                                <td>
                                    <input type="text" name="ed_customer" value="{{ $data->kode_customer or null }}" readonly="readonly" class="form-control" style="text-transform: uppercase" tabindex="-1">
                                </td>
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td>
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Cabang</td>
                                <td colspan="3">
                                    <select class="form-control" name="cb_cabang" >
                                    @foreach ($cabang as $row)
                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                    <input type="hidden" name="ed_cabang" value="{{ $data->kode_cabang or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                <td colspan="3">
                                    <input type="text" name="ed_keterangan" class="form-control" style="text-transform: uppercase" value="{{ $data->keterangan or null }}" >
                                </td>
                            </tr>
                            <tr>
                                <td>Aktif</td>
                                <td colspan="3">
                                    <input type="checkbox" name="ck_aktif">
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
                  <table id="table_data" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Asal</th>
                            <th>Tujuan</th>
                            <th>Jenis</th>
                            <th>Type Agkutan</th>
                            <th>Jenis Tarif</th>
                            <th>Harga</th>
                            <th>Satuan</th>
                            <th>Keterangan</th>
                            <th> Aksi </th>
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
                                <h4 class="modal-title">Insert Edit Kontrak</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal  kirim">
                                    <table id="table_data" class="table table-striped table-bordered table-hover">
                                        <tbody>
                                            <tr style="display:none;">
                                                <td style="padding-top: 0.4cm">Seq Id</td>
                                                <td>   
                                                    <input type="text" class="form-control angka" name="ed_id" class="form-control">
                                                    <input type="hidden" class="form-control angka" name="ed_id_old" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Asal</td>
                                                <td>   
                                                    <select class="chosen-select-width"  name="cb_kota_asal" id="cb_kota_asal" style="width:100%">
                                                        <option value=""></option>
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control" name="crud" class="form-control">
                                                    <input type="hidden" class="form-control" name="ed_nomor_kontrak" class="form-control">
                                                    <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                                <td>   
                                                    <select class="chosen-select-width"  name="cb_kota_tujuan" style="width:100%">
                                                        <option value=""></option>
                                                    @foreach ($kota as $row)
                                                        <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:110px; padding-top: 0.4cm">Jenis</td>
                                                <td>
                                                    <select class="form-control" name="cb_jenis" >
                                                        <option value="PAKET">PAKET</option>
                                                        <option value="KORAN">KORAN</option>
                                                        <option value="KARGO">KARGO</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:110px; padding-top: 0.4cm">Tipe Angkutan</td>
                                                <td>
                                                    <select class="form-control" name="cb_tipe_angkutan" >
                                                        <option value=""></option>
                                                    @foreach ($tipe_angkutan as $row)
                                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:110px; padding-top: 0.4cm">Jenis Tarif</td>
                                                <td>
                                                    <select class="form-control" name="cb_jenis_tarif" >
                                                        <option value="DOKUMEN">DOKUMEN</option>
                                                        <option value="KILOGRAM">KILOGRAM</option>
                                                        <option value="ONE WAY STANDART">ONE WAY STANDART</option>
                                                        <option value="EMBALASI STANDART">EMBALASI STANDART</option>
                                                        <option value="ROUND TRIP STANDART">ROUND TRIP STANDART</option>
                                                        <option value="ONE WAY BOTOL KOSONG">ONE WAY BOTOL KOSONG</option>
                                                        <option value="EMBALASI BOTOL KOSONG">EMBALASI BOTOL KOSONG</option>
                                                        <option value="ROUND TRIP BOTOL KOSONG">ROUND TRIP BOTOL KOSONG</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 0.4cm;">Harga</td>
                                                <td>
                                                    <input type="text" name="ed_harga" class="form-control angka" style="text-transform: uppercase;text-align:right">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:110px; padding-top: 0.4cm">Satuan</td>
                                                <td>
                                                    <select class="form-control" name="cb_satuan" >
                                                        <option value=""></option>
                                                    @foreach ($satuan as $row)
                                                        <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                                    @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width:120px; padding-top: 0.4cm">Keterangan</td>
                                                <td>
                                                    <input type="text" name="ed_keterangan_d" class="form-control" style="text-transform: uppercase" >
                                                </td>
                                            </tr>
                                            <tr style="display:none">
                                                <td style="width:110px; padding-top: 0.4cm">Type Tarif</td>
                                                <td>
                                                    <select class="form-control" name="cb_type_tarif" >
                                                        <option></option>
                                                        <option value="DOKUMEN">DOKUMEN</option>
                                                        <option value="KILOGRAM">KILOGRAM</option>
                                                        <option value="ONE WAY STANDART">ONE WAY STANDART</option>
                                                        <option value="EMBALASI STANDART">EMBALASI STANDART</option>
                                                        <option value="ROUND TRIP STANDART">ROUND TRIP STANDART</option>
                                                        <option value="ONE WAY BOTOL KOSONG">ONE WAY BOTOL KOSONG</option>
                                                        <option value="EMBALASI BOTOL KOSONG">EMBALASI BOTOL KOSONG</option>
                                                        <option value="ROUND TRIP BOTOL KOSONG">ROUND TRIP BOTOL KOSONG</option>
                                                    </select>
                                                </td>
                                            </tr>
											<tr>
												<td style="padding-top: 0.4cm">Acc Penjualan</td>
												<td>
													<select class="chosen-select-width"  name="cb_acc_penjualan" style="width:100%">
														<option value=""></option>
													@foreach ($akun as $row)
														<option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} </option>
													@endforeach
													</select>
												</td>
												<td><input type="text" class="form-control" name="ed_acc_penjualan2" ></td>
											</tr>
											<tr>
												<td style="padding-top: 0.4cm">CSF Penjualan</td>
												<td>
													<select class="chosen-select-width"  name="cb_csf_penjualan" style="width:100%">
														<option value=""></option>
													@foreach ($akun as $row)
														<option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} </option>
													@endforeach
													</select>
												</td>
												<td><input type="text" class="form-control" name="ed_csf_penjualan2" ></td>
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
        $("select[name='cb_customer']").val('{{ $data->kode_customer or ''  }}').trigger('chosen:updated');
        $("input[name='ck_aktif']").attr('checked', {{ $data->aktif or null}});
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
//            $("input[name='ed_nomor']").attr('readonly','readonly');
            $("select[name='cb_cabang']").attr('disabled','disabled');
            $("input[name='ed_tanggal']").focus();
        }else{
            //$("input[name='ed_nomor']").focus();
        }
        $("input[name='ed_tanggal']").focus();
        $('#table_data').DataTable({
            "scrollX": true,
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
                "url": baseUrl + "/master_sales/kontrak_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id"},
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "jenis" },
            { "data": "kode_angkutan" },
            { "data": "jenis_tarif" },
            { "data": "harga" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "satuan" },
            { "data": "keterangan" },
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
        $(".angka").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $("select[name='cb_acc_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_acc_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_csf_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_csf_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_customer']").change(function(){
        var data = $("select[name='cb_customer']").val();
        $("input[name='ed_customer']").val(data);
    });

    $("select[name='cb_cabang']").change(function(){
        var data = $("select[name='cb_cabang']").val();
        $("input[name='ed_cabang']").val(data);
    });

    $(document).on("click","#btnadd",function(){
        var cabang = $("select[name='cb_cabang']").val();
        if(cabang == ''){
            alert("cabang tidak boleh kosong");
            return false;
        }
        $("input[name='crud']").val('N');
        $("input[name='ed_id']").val('');
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_jenis']").val('');
        $("select[name='cb_jenis']").val('');
        $("select[name='cb_type_tarif']").val('');
        $("select[name='cb_type_angkutan']").val('');
        $("select[name='cb_jenis']").val('');
        $("select[name='cb_jenis_tarif']").val('');
        $("select[name='cb_satuan']").val('');
        $("input[name='ed_harga']").val('0');
        $("input[name='ed_keterangan']").val('');
        $("select[name='cb_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_csf_penjualan']").val('').trigger('chosen:updated');
		$("select[name='cb_acc_penjualan']").change();
		$("select[name='cb_csf_penjualan']").change();
        $("#modal").modal("show");
        $("#cb_kota").trigger('chosen:activate');
        $.ajax(
        {
            url :  baseUrl + "/master_sales/kontrak/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        $("input[name='ed_nomor']").val(data.nomor);
                        $("input[name='ed_nomor_old']").val(data.nomor);
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        $("input[name='ed_nomor']").val(data.nomor);
                        $("input[name='ed_nomor_old']").val(data.nomor);
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
        $("#modal").modal('show');
        $("input[name='crud']").val('N');
        $("input[name='id']").val('');
        var nomor = $("input[name='ed_nomor']").val();
        $("input[name='ed_nomor_kontrak']").val(nomor);
        $('#cb_kota_asal').trigger('chosen:open');
    });

    $(document).on("click","#btnsimpan",function(){        
        $.ajax(
        {
            url :  baseUrl + "/master_sales/kontrak/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
                        window.location.href = baseUrl + '/master_sales/kontrak';
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        var nomor = $("input[name='ed_nomor']").val();
                        $("input[name='ed_nomor_old']").val(nomor);
                        window.location.href = baseUrl + '/master_sales/kontrak';
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

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var nomor_kontrak=$("input[name='ed_nomor']").val();
        var value = {
            id: id,
            nomor_kontrak: nomor_kontrak
        };
        $.ajax(
        {
            url : baseUrl + "/master_sales/kontrak/get_data_detail",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_id']").val(data.id);
                $("input[name='ed_id_old']").val(data.id);
                $("input[name='ed_nomor_kontrak']").val(data.nomor_kontrak);
                $("select[name='cb_kota_asal']").val(data.id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data.id_kota_tujuan).trigger('chosen:updated');
                $("select[name='cb_jenis']").val(data.jenis);
                $("select[name='cb_jenis_tarif']").val(data.jenis_tarif);
                $("select[name='cb_tipe_angkutan']").val(data.kode_angkutan);
                $("select[name='cb_type_tarif']").val(data.type_tarif);
                $("input[name='ed_harga']").val(data.harga).trigger('mask.maskMoney');
                $("input[name='ed_keterangan_d']").val(data.keterangan);
                $("select[name='cb_satuan']").val(data.kode_satuan);
                $("select[name='cb_angkutan']").val(data.kode_angkutan);
				$("select[name='cb_acc_penjualan']").val(data.acc_penjualan).trigger('chosen:updated');
				$("select[name='cb_csf_penjualan']").val(data.csf_penjualan).trigger('chosen:updated');
				$("select[name='cb_acc_penjualan']").change();
				$("select[name='cb_csf_penjualan']").change();
                $("#modal").modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        
        $.ajax(
        {
            url : baseUrl + "/master_sales/kontrak/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        //$("input[name='ed_nomor']").attr('readonly','readonly');
                        $("select[name='cb_cabang']").attr('disabled','disabled');
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        //$("input[name='ed_nomor']").attr('readonly','readonly');
                        $("select[name='cb_cabang']").attr('disabled','disabled');
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        //swal("Error","Can't update data, error : "+data.error,"error");
                        alert("Gagal menyimpan data!");
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

    $(document).on( "click",".btndelete", function() {
        var id = $(this).attr("id");
        var nomor_kontrak=$("input[name='ed_nomor']").val();
        if(!confirm("Hapus Data ?")) return false;
        var value = {
            id: id,
            nomor_kontrak: nomor_kontrak,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/master_sales/kontrak/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        $("select[name='cb_cabang']").removeAttr('disabled');
                    }
                    table.ajax.reload( null, false );
                }else{
                    //swal("Error","Data tidak bisa hapus : "+data.error,"error");
                    alert('gagal menghapus data');
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
