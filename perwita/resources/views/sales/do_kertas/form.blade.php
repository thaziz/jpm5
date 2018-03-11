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
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                
                                <td style="padding-top: 0.4cm">Customer</td>
                                <td style="width:23.5%">
                                    <input type="text" class="form-control" readonly="readonly" name="ed_kode_customer" tabindex="-1" >   
                                </td>
                                <td>
                                    <select class="chosen-select-width"  name="cb_customer" id="cb_customer" style="width:100%" >
                                        <option> </option>
                                    @foreach ($customer as $row)
                                        <option value="{{ $row->kode }}" data-alamat="{{$row->alamat}}" data-telpon="{{$row->telpon}}"  >{{ $row->kode }}  &nbsp - &nbsp  {{ $row->nama }} </option>
                                    @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:110px; padding-top: 0.4cm">Alamat</td>
                                <td colspan="3">
                                    <input type="text" class="form-control" name="ed_alamat" readonly="readonly" tabindex="-1" style="text-transform: uppercase" value="{{ $data->alamat or null }}">
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
    Number.prototype.format = function(n, x) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
        return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&.');
    };
    $(document).ready( function () {
        $("input[name='ed_tanggal']").focus();
        $("select[name='cb_cabang']").val('{{ $data->kode_cabang or ''  }}');
        $("select[name='cb_customer']").val('{{ $data->kode_customer or ''  }}').trigger('chosen:updated');
        $("select[name='cb_customer']").change();
        $jml_detail = {{ $jml_detail->jumlah  or 0}};
        if ($jml_detail > 0){
            $("input[name='ed_nomor']").attr('readonly','readonly');
        }else{
            //$("input[name='ed_nomor']").focus();
        }
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
                "url": baseUrl + "/sales/deliveryorderkertas_form/tabel_data_detail",
                "type": "GET",
                "data" : { nomor : function () { return $('#ed_nomor').val()}},
            },
            "columns": [
            { "data": "id"},
            { "data": "kode_item" },
            { "data": "nama" },
            { "data": "keterangan"},
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "kode_satuan"},
            { "data": "harga" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "diskon" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "total" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
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

    function hitung(){
        var jumlah = $("input[name='ed_jumlah']").val();
        var harga = $("input[name='ed_harga']").val();
        var diskon  = $("input[name='ed_diskon']").val();
        var jumlah = jumlah.replace(/[A-Za-z$. ,-]/g, "");
        var harga = harga.replace(/[A-Za-z$. ,-]/g, "");
        var diskon = diskon.replace(/[A-Za-z$. ,-]/g, "");
        var total = parseFloat(jumlah) * parseFloat(harga);
        var netto = parseFloat(total) - parseFloat(diskon);
        $("input[name='ed_total']").val(total.format());
        $("input[name='ed_netto']").val(netto.format());
    }
    
    $("input[name='ed_jumlah'],input[name='ed_diskon'],input[name='ed_harga']").keyup(function(){
        hitung();
    });

    $("select[name='cb_item']").change(function(){
        var kode_item = $(this).val();
        var harga = $(this).find(':selected').data('harga');
        var satuan = $(this).find(':selected').data('satuan');
        var acc = $(this).find(':selected').data('acc');
        $("input[name='ed_harga']").val(harga);
        $("input[name='ed_kode_item']").val(kode_item);
        $("input[name='ed_satuan']").val(satuan);
        $("input[name='acc_penjualan']").val(acc);
        hitung();
    });

    $("select[name='cb_customer']").change(function(){
        var kode = $(this).val();
        var alamat = $(this).find(':selected').data('alamat');
        $("input[name='ed_kode_customer']").val(kode);
        $("input[name='ed_alamat']").val(alamat);
    });

    $(document).on("click","#btnadd",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_tampil']").val('Y');
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderkertas/save_data",
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
                var table = $('#table_data_do').DataTable();
				$("#cb_item").empty();
				$('.B').append(data.item);
				$("#cb_item").trigger("chosen:updated");
                $("input[name='ed_id']").val('');
                $("input[name='ed_kode_item']").val('');
                $("select[name='cb_item']").val('');
                $("select[name='cb_kota_asal']").val('');
                $("select[name='cb_kota_tujuan']").val('');
                $("input[name='ed_satuan']").val('');
                $("input[name='ed_jumlah']").val('0');
                $("input[name='ed_harga']").val('0');
                $("input[name='ed_diskon']").val('0');
                $("input[name='ed_total']").val('0');
                $("input[name='ed_keterangan']").val();
                $("#modal").modal("show");
                //$("select[name='cb_item']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsimpan",function(){
        $("input[name='crud']").val('N');
        $.ajax(
        {
            url :  baseUrl + "/sales/deliveryorderkertas/save_data",
            type: "POST",
            dataType:"JSON",
            data : $('#form_header').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result != 1){
                        alert("Gagal menyimpan data!");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorderkertas'
                    }
                }else if(data.crud == 'E'){
                    if(data.result != 1){
                        swal("Error","Can't update data, error : "+data.error,"error");
                    }else{
                        window.location.href = baseUrl + '/sales/deliveryorderkertas';
                    }
                }else{
                    swal("Error","invalid order","error");
                }
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


    $(document).on("click","#btnsave",function(){
        var nomor_do = $("input[name='ed_nomor']").val();
        $("input[name='ed_nomor_do']").val(nomor_do);
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderkertas/save_data_detail",
            type: "POST",
            dataType:"JSON",
            data : $('#form_detail').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result == 1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                    $("#modal").modal('hide');
                    $("input[name='ed_total_h']").val(data.total);
                    $("input[name='ed_diskon_h']").val(data.diskon);
                    //$("input[name='ed_nomor']").attr('readonly','readonly');
                    //$("select[name='cb_rute']").prop('disabled', true).trigger("chosen:updated");
                    //$("select[name='cb_cabang']").attr('disabled','disabled');
                    $("#btn_add").focus();
                }else{
                    alert("Gagal menyimpan data!");
                }
            },
            
        });
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var nomor = $("#ed_nomor").val();
        var value = {
            id: id,
            nomor: nomor
        };
        $.ajax(
        {
            url : baseUrl + "/sales/deliveryorderkertas/get_data_detail",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_id']").val(data.id);
                $("input[name='ed_id_old']").val(data.id);
                $("input[name='ed_kode_item']").val(data.kode_item);
                $("select[name='cb_item']").val(data.kode_item).trigger('chosen:updated');
                $("select[name='cb_kota_asal']").val(data.id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data.id_kota_tujuan).trigger('chosen:updated');
                $("input[name='ed_satuan']").val(data.kode_satuan);
                $("input[name='ed_jumlah']").val(data.jumlah);
                $("input[name='ed_harga']").val(data.harga).trigger('mask.maskMoney');
                $("input[name='ed_diskon']").val(data.diskon).trigger('mask.maskMoney');
                $("input[name='ed_total']").val(data.total).trigger('mask.maskMoney');
                $("input[name='ed_keterangan']").val(data.keterangan);
                $("#modal").modal("show");
                $("select[name='cb_item']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var nomor = $("input[name='ed_nomor']").val();
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            nomor: nomor,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/sales/deliveryorderkertas/hapus_data_detail",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    if (data.jml_detail == 0) {
                        //$("input[name='ed_nomor']").removeAttr('readonly');
                        //$("select[name='cb_cabang']").removeAttr('disabled');
                        //$("select[name='cb_rute']").prop('disabled', false).trigger("chosen:updated");
                    }
                    table.ajax.reload( null, false );
                    $("input[name='ed_total_h']").val(data.total);
                    $("input[name='ed_diskon_h']").val(data.diskon);
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
