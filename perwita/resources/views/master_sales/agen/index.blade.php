@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> AGEN </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master</a>
                        </li>
                        <li>
                          <a> Master Penjualan</a>
                        </li>
                        <li>
                          <a> Tarif DO</a>
                        </li>
                        <li class="active">
                            <strong> Agen </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                      @if(Auth::user()->punyaAkses('Agen','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                    </div>
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
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> Kode</th>
                            <th> Nama </th>
                            <th> Kategori </th>
                            <th> Alamat </th>
                            <th> Kota </th>
                            <th> Telpon </th>
                            <th> Fax </th>
                            <th> Komisi Outlet</th>
                            <th> Komisi Agen</th>
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
                        <h4 class="modal-title">Insert Edit Agen</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td>
                                        <input type="text" name="ed_kode" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Area</td>
                                    <td><input type="text" class="form-control" name="ed_kode_area" style="text-transform: uppercase" ></td>
                                    <td style="padding-top: 0.4cm">Kategori</td>
                                    <td>
                                        <select class="form-control" name="cb_kategori" id="cb_kategori">
                                            <option value="AGEN" data-agen="40">AGEN</option>
                                            <option value="OUTLET" data-outlet="15"> OUTLET</option>
                                            <option value="AGEN DAN OUTLET"  data-agen-g="40" data-outlet-g="15" >AGEN DAN OUTLET </option>
                                        </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    @if(Auth::user()->punyaAkses('Agen','cabang'))
                                    <td>
                                        <select class="form-control" name="cb_cabang">
                                            @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @else
                                    <td class="disabled">
                                        <select class="form-control" name="cb_cabang">
                                            @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif

                                    <td style="padding-top: 0.4cm">Kota</td>
                                    <td>   
                                        <select class="form-control"  name="cb_kota" style="width:100%">
                                            <option value=""></option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <input type="hidden" name="id_agen">
                                <tr>
                                    <td style="padding-top: 0.4cm">Alamat</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Telpon</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_telpon" style="text-transform: uppercase" >
                                    </td>
                                    <td style="padding-top: 0.4cm">Fax</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_fax" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Komisi agen(%)</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_komisi_agen" id="ed_komisi_agen" style="text-transform: uppercase" >
                                    </td>
                                    <td style="padding-top: 0.4cm">Komisi outlet(%)</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_komisi_outlet" id="ed_komisi_outlet" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                
                                <tr>
                                <td style="padding-top: 0.4cm">Acc Penjulan</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="acc1 form-control chosen-select-width212" id="acc1" name="ed_acc1" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode akun --</option>
                                        @foreach($akun as $a)
                                          <option value="{{$a->id_akun}}" data-nama="{{$a->nama_akun}}">
                                            {{$a->id_akun}} - {{$a->nama_akun}}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Acc Hutang</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="acc1 form-control chosen-select-width212" id="acc1" name="ed_acc2" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode akun --</option>
                                        @foreach($akun as $a)
                                          <option value="{{$a->id_akun}}" data-nama="{{$a->nama_akun}}">
                                            {{$a->id_akun}} - {{$a->nama_akun}}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">CSF Penjulan</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="acc1 form-control chosen-select-width212" id="acc1" name="ed_acc3" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode akun --</option>
                                        @foreach($akun as $a)
                                          <option value="{{$a->id_akun}}" data-nama="{{$a->nama_akun}}">
                                            {{$a->id_akun}} - {{$a->nama_akun}}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                          </table>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnsave">Save changes</button>
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

     $('#ed_komisi_agen').attr('readonly',true);
     $('#ed_komisi_outlet').attr('readonly',true);
     $('#cb_kategori').change(function(){
        var agensel = $('#cb_kategori :selected').data('agen');
        var outletsel = $('#cb_kategori :selected').data('outlet');
        var outletsel_g = $('#cb_kategori :selected').data('outlet-g');
        var agensel_g = $('#cb_kategori :selected').data('agen-g');
        // alert(outletsel_g);
        // alert(agensel_g);
        if (agensel == '40') {
            $('#ed_komisi_agen').val(agensel);
            $('#ed_komisi_outlet').val('');
            // alert('a');
        }else if (outletsel == '15'){
            $('#ed_komisi_outlet').val(outletsel);
            $('#ed_komisi_agen').val('');

            // alert('a');
        }else if (outletsel_g == '15' && agensel_g == '40') {
            $('#ed_komisi_agen').val(agensel_g);
            $('#ed_komisi_outlet').val(outletsel_g);
        }

        // if () {}
    })

    
    $(document).ready( function () {
        $('#table_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/master_sales/agen/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "kategori" },
            { "data": "alamat" },
            { "data": "kota" },
            { "data": "telpon" },
            { "data": "fax" },
            { "data": "komisi" },
            { "data": "komisi_agen" },
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
       // $("input[name='ed_harga']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $("select[name='cb_acc_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_acc_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_csf_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_csf_penjualan2']").val(nama_akun);
    });

    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_kode']").attr('readonly',false); 
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_kode_area']").val('');
        $("select[name='cb_kategori']").val('');
        $("select[name='cb_kota']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").change();
        $("select[name='cb_csf_penjualan']").change();
        $("input[name='ed_alamat']").val('');
        $("input[name='ed_telpon']").val('');
        $("input[name='ed_fax']").val('');
        $("input[name='ed_komisi']").val('0');
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
     $('#ed_komisi_agen').attr('readonly',false);
     $('#ed_komisi_outlet').attr('readonly',false);
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        $.ajax(
        {
            url : baseUrl + "/master_sales/agen/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='id_agen']").val(data.id_agen);
                $("input[name='ed_kode_old']").val(data.kode);
                $("input[name='ed_kode']").attr('readonly','true');
                $("input[name='ed_nama']").val(data.nama);                
                $("input[name='ed_kode_area']").val(data.kode_area);
                $("select[name='cb_kategori']").val(data.kategori);
                $("select[name='cb_cabang']").val(data.kode_cabang);
                $("select[name='cb_kota']").val(data.id_kota).trigger('chosen:updated');
                $("input[name='ed_alamat']").val(data.alamat);
                $("input[name='ed_telpon']").val(data.telpon);
                $("input[name='ed_fax']").val(data.fax);
                $("input[name='ed_komisi_outlet']").val(data.komisi);
                $("input[name='ed_komisi_agen']").val(data.komisi_agen);
                $("select[name='ed_acc1']").val(data.acc_penjualan).trigger('chosen:updated');
                $("select[name='ed_acc2']").val(data.acc_hutang).trigger('chosen:updated');
                $("select[name='ed_acc3']").val(data.csf_penjualan).trigger('chosen:updated'); 
                $("select[name='cb_acc_penjualan']").change();
                $("select[name='cb_csf_penjualan']").change();
                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){

        var nama = $("input[name='ed_nama']").val();
        var kodearea = $("input[name='ed_kode_area']").val();
        var cbkategori= $("select[name='cb_kategori']").val();
        var cbcabang= $("select[name='cb_cabang']").val();
        var edalamat= $("input[name='ed_alamat']").val();
        var edtelpon= $("input[name='ed_telpon']").val();
        var edkota = $("select[name='cb_kota']").val();
        if (nama == '' || nama == null) 
        {
            Command: toastr["warning"]("Nama Tidak boleh kosong", "Peringatan")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (kodearea == '' || kodearea == null) 
        {  
            Command: toastr["warning"]("Kode Area Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (cbkategori == null || cbkategori == '') 
        {
         Command: toastr["warning"]("Kategori Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (cbcabang == null || cbcabang == '') 
        {
         Command: toastr["warning"]("Cabang Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (edkota == null || edkota == '') 
        {
            Command: toastr["warning"]("Kota Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (edalamat == null || edalamat == '') 
        {
            Command: toastr["warning"]("Alamat Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        else if (edtelpon == null || edtelpon == '') 
        {
            Command: toastr["warning"]("Telepon Tidak boleh kosong", "Peringatan")
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }


        $.ajax(
        {
            url : baseUrl + "/master_sales/agen/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.result == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("#btn_add").focus();

                           Command: toastr["success"]("Data berhasil disimpan", "Pemberitahuan ")
                            toastr.options = {
                              "closeButton": false,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                    }else{
                        Command: toastr["error"]("Data gagal disimpan", "Peringatan")
                            toastr.options = {
                              "closeButton": false,
                              "debug": false,
                              "newestOnTop": false,
                              "progressBar": true,
                              "positionClass": "toast-top-right",
                              "preventDuplicates": false,
                              "onclick": null,
                              "showDuration": "300",
                              "hideDuration": "1000",
                              "timeOut": "5000",
                              "extendedTimeOut": "1000",
                              "showEasing": "swing",
                              "hideEasing": "linear",
                              "showMethod": "fadeIn",
                              "hideMethod": "fadeOut"
                            }
                    }
                }else if(data.crud == 'E'){
                    if(data.result == 1){
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update data, error : "+data.error,"error");
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
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        if(!confirm("Hapus Data " +name+ " ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "POST",
            url : baseUrl + "/master_sales/agen/hapus_data",
            dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    });
$('.chosen-select-width212').chosen();
 $('.chosen-single').css({
                            "min-width": "700px",
                            "max-width": "700px"
                            });
   $('.chosen-container-single').css({
                            "min-width": "400px",
                            "max-width": "400px"
                        });
    

    

</script>
@endsection
