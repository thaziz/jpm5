@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> CUSTOMER </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master</a>
                        </li>
                        <li>
                            <a>Master Penjualan</a>
                        </li>
                        <li>
                            <a>Master DO</a>
                        </li>
                        <li class="active">
                            <strong> CUSTOMER </strong>
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
                      @if(Auth::user()->punyaAkses('Customer','tambah'))
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
                                <th> Alamat </th>
                                <th> Kota </th>
                                <th> Telpon </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg" style="width: 1200px;">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Item</h4>
                      </div>
                      <div class="modal-body" {{-- style="min-height: 1000px;" --}}>
                        <form class="form-horizontal kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover" style="width: 640px;">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm;text-align: center;font-weight: bold;" colspan="2">Identitas Customer</td>
                                    <td hidden="">
                                        <input type="hidden" name="ed_kode" class="form-control" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama Member</td>
                                    <td><input type="" class="form-control" name="ed_nama" style="text-transform: uppercase" ></td>
                                </tr>
                                
                                <input type="hidden" name="id_cus">
                                <tr>
                                    <td style="padding-top: 0.4cm">Alamat Member</td>
                                    <td colspan="1"><input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" ></td>
                                    
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Telpon Member</td>
                                    <td><input type="text" class="form-control" name="ed_telpon" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="width:100px;">Syarat Kredit (Hari)</td>
                                    <td><input type="number" class="form-control" name="ed_syarat_kredit" style="text-transform: uppercase" style="text-align:right"></td>
                                </tr>
                                <tr>
                                    <td>Plafon</td>
                                    <td colspan="1"><input type="text" class="form-control" name="ed_plafon"></td>
                                </tr>
                                @if(Auth::user()->punyaAkses('Customer','cabang'))
                                <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select class="chosen-select-width" name="cabang">
                                            <option value="0">Pilih - Cabang</option>
                                            @foreach($cabang as $val)
                                            <option @if(Auth::user()->kode_cabang == $val->kode) selected="" @endif  value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @else
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td class="disabled">
                                        <select class="chosen-select-width" name="cabang">
                                            <option value="0">Pilih - Cabang</option>
                                            @foreach($cabang as $val)
                                            <option @if(Auth::user()->kode_cabang == $val->kode) selected="" @endif value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Groups</td>
                                    <td colspan="1">
                                        <select name="group_customer" class="chosen-select-width">
                                            <option>Pilih - Group</option>
                                            @foreach ($group_customer as $loop)
                                                <option value="{{ $loop->group_id }}">{{ $loop->group_id }} - {{ $loop->group_nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_kota" style="width:100%">
                                            <option value="">Pilih - kota</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Kode Bank</td>
                                    <td>
                                        <select class="form-control" name="ed_kode_bank" >
                                            <option selected="" disabled="">Pilih - Bank</option>
                                            @foreach ($bank as $bank)
                                                <option value="{{ $bank->id_akun }}">{{ $bank->id_akun }} - {{ $bank->nama_akun }}</option>
                                            @endforeach
                                            
                                        </select>
                                    </td>
                                </tr>
                                {{-- adasd --}}
                                
                                
                                
                            </tbody>
                          </table>
                          <table id="table_data" class="table table-striped table-bordered table-hover" style="width: 500px;margin-top: -550px;margin-left: 650px;">
                              <tr>
                                    <td colspan="2" style="text-align: center;font-weight: bold;">Identitas PIC</td>
                                </tr>
                                <tr>
                                    <td> Nama PiC</td>
                                    <td><input type="text" class="form-control" name="nama_pic"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Alamat PIC</td>
                                    <td ><input type="text" class="form-control" name="alamat_pic" style="text-transform: uppercase" ></td>
                                    
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Telp PIC</td>
                                    <td><input type="text" class="form-control" name="telp_pic" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Email PIC</td>
                                    <td><input type="text" class="form-control" name="email_pic" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Fax</td>
                                    <td> <input type="text" class="form-control" name="fax_pic"></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Piutang</td>
                                    <td>
                                        <select class="form-control chosen-select-width" name="ed_acc_piutang"  id="ed_acc_piutang" style="text-transform: uppercase">
                                            <option value="">Pilih - akun hutang</option>    
                                            @foreach ($accpenjualan as $acc)
                                                <option value="{{ $acc->id_akun }}">{{ $acc->id_akun }} - {{ $acc->nama_akun }}</option>    
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">CSF Piutang</td>
                                    <td>
                                        <select class="form-control chosen-select-width" name="ed_csf_piutang" id="ed_csf_piutang"  style="text-transform: uppercase">
                                            <option value="">Pilih - csf hutang</option>    
                                            @foreach ($accpenjualan as $csf)
                                                <option value="{{ $csf->id_akun }}">{{ $csf->id_akun }} - {{ $csf->nama_akun }}</option>    
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">status</td>
                                    <td>
                                        <select class="select2_single form-control"  name="status_pic"   style="width: 100% !important;">
                                            <option>Pilih - Status</option>
                                            <option value="AKTIF">Aktif</option>
                                            <option value="NON-AKTID">Non-aktif</option>    
                                        </select>
                                    </td>
                                </tr>
                          </table>
                          <table id="table_data" class="table table-striped table-bordered table-hover" style="margin-top: 100px;">
                              <tr>
                                    <td colspan="7" style="text-align: center;font-weight: bold;">Identitas Pajak</td>
                                </tr>
                                <tr>
                                    <td> Nama Pajak</td>
                                    <td><input type="text" class="form-control" name="nama_pajak"></td>

                                    <td>Kota</td>
                                    <td>
                                         <select class="chosen-select-width"  name="kota_pajak" style="width:100%">
                                            <option value="" >pilih - kota</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Alamat Pajak</td>
                                    <td colspan="7"><input type="text" class="form-control" name="alamat_pajak" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">NPWP</td>
                                    <td><input type="text" class="form-control" name="ed_npwp" ></td>

                                    <td style="padding-top: 0.4cm">PPH 23</td>
                                    <td >
                                        <input type="checkbox" name="ck_pph23">
                                    </td>
                                </tr>
                                 
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama Pajak 23</td>
                                    <td>
                                        <select class="select2_single form-control"  name="cb_nama_pajak_23"  style="width: 100% !important; ">
                                            <option></option>
                                            <option value="PPH PS 23"> PPH PS 23</option>
                                            <option value="PPH PS 23 SEWA"> PPH PS 23 SEWA</option>
                                            <option value="PPH PS 4/2">PPH PS 4/2</option>
                                            <option value="PPN BM">PPH BM</option>
                                            <option value="TANPA PPH 23">TANPA PPH 23</option>
                                            <option value="UM PAJAK PS 23">UM PAJAK PS 23</option>
                                        </select>
                                    </td>
                                    <td style="padding-top: 0.4cm">Tarif Pajak 23</td>
                                    <td>
                                        <select name="pajak_tarif" class="chosen-select-width">
                                            <option value="" selected="">Pilih - pajak</option>
                                            @foreach ($pajak as $pajak)
                                                <option value="{{ $pajak->kode }}">{{ $pajak->kode }} - {{ $pajak->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                                 
                                <tr>
                                    <td style="padding-top: 0.4cm">PPN</td>
                                    <td>
                                        <input type="checkbox" name="ck_ppn">
                                    </td>
                                    <td style="padding-top: 0.4cm">Type Faktur</td>
                                    <td>
                                        <select class="select2_single form-control"  name="cb_type_faktur"   style="width: 100% !important;">
                                            <option></option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="3">2</option>
                                        </select>
                                    </td>
                                </tr>
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
              "url" :  baseUrl + "/master_sales/customer/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "alamat" },
            { "data": "kota" },
            { "data": "telpon" },
            { "data": "button" },
            ]
        });
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%"}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
    });




    $(document).on("click","#btn_add",function(){

        
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_alamat']").val('');
        $("input[name='ed_telpon']").val('');
        $("select[name='cb_kota']").val('').trigger('chosen:updated');
        $("select[name='cb_nama_pajak_23']").val('');
        $("select[name='cb_type_faktur']").val('');
        $("input[name='ed_alamat']").val('');
        $("input[name='ed_syarat_kredit']").val('0');
        $("select[name='ed_acc_piutang']").val('').trigger('chosen:updated');
        $("select[name='ed_csf_piutang']").val('').trigger('chosen:updated');
        $("select[name='ed_kode_bank']").val('').trigger('chosen:updated');
        $("input[name='ed_kode_bank']").val('');
        $("input[name='ed_npwp']").val('');
        
        $("input[name='ed_plafon']").val('');
        $("select[name='kota_pajak']").val('').trigger('chosen:updated');
        $("input[name='nama_pajak']").val('');
        $("select[name='pajak_tarif']").val('').trigger('chosen:updated');
        $("input[name='nama_pic']").val('');
        $("input[name='fax_pic']").val('');
        $("input[name='alamat_pic']").val('');
        $("input[name='telp_pic']").val('');
        $("input[name='email_pic']").val('');
        $("select[name='status_pic']").val('');
        $("select[name='group_customer']").val('').trigger('chosen:updated');
        
        $("input[name='alamat_pajak']").val('');
        $("input[name='ck_pph23']").attr('checked', false); 
        $("input[name='ck_ppn']").attr('checked', false); 
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var value = {
            id: id
        };
        
        $.ajax(
        {
            url : baseUrl + "/master_sales/customer/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='id_cus']").val(data.id_cus);
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='ed_kode_old']").val(data.kode);
                $("input[name='ed_nama']").val(data.nama);
                $("select[name='cabang']").val(data.cabang).trigger('chosen:updated');
                $("input[name='ed_alamat']").val(data.alamat);
                $("input[name='ed_telpon']").val(data.telpon);
                $("select[name='cb_kota']").val(data.kota).trigger('chosen:updated');
                $("select[name='cb_nama_pajak_23']").val(data.nama_pph23);
                $("select[name='cb_type_faktur']").val(data.type_faktur_ppn);
                $("select[name='ed_acc_piutang']").val(data.acc_piutang).trigger('chosen:updated');
                $("select[name='ed_csf_piutang']").val(data.csf_piutang).trigger('chosen:updated');
                $("select[name='ed_kode_bank']").val(data.kode_bank).trigger('chosen:updated');
                $("input[name='ed_syarat_kredit']").val(data.syarat_kredit);
                $("input[name='ed_plafon']").val(data.plafon);
                $("select[name='group_customer']").val(data.group_customer).trigger('chosen:updated');
                $("input[name='ed_npwp']").val(data.pajak_npwp);
                $("select[name='kota_pajak']").val(data.pajak_kota).trigger('chosen:updated');
                $("input[name='nama_pajak']").val(data.pajak_nama);
                $("select[name='pajak_tarif']").val(data.pajak_tarif).trigger('chosen:updated');

                $("input[name='nama_pic']").val(data.pic_nama);
                $("input[name='fax_pic']").val(data.pic_fax);
                $("input[name='alamat_pic']").val(data.pic_alamat);
                $("input[name='telp_pic']").val(data.pic_telpon);
                $("input[name='email_pic']").val(data.pic_email);
                $("select[name='status_pic']").val(data.pic_status);
                // $("select[name='name='ed_faktur']").val(data.type_faktur_ppn);
                // console.log(data.ppn);
                if(data.ppn == true || data.ppn == 'true'){
                    $("input[name='ck_ppn']").prop('checked', true);  
                }else if (data.ppn == false || data.ppn == 'false') {
                $("input[name='ck_ppn']").val('');
                }
                if(data.pph23 == true || data.pph23 == 'true'){
                    $("input[name='ck_pph23']").prop('checked', true); 
                }else if (data.pph23 == false || data.pph23 == 'false'){
                $("input[name='ck_pph23']").val('');
                }
                $("input[name='alamat_pajak']").val(data.pajak_alamat);
                $("#modal").modal("show");
                $("input[name='ed_kode']").focus();
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
       
     $ed_acc_piutang = $('#ed_acc_piutang').val();
     $ed_csf_piutang = $('#ed_csf_piutang').val();
     $plafon = $("input[name='ed_plafon']").val();
     $nama_member = $("input[name='ed_nama']").val();
     $alamat_member = $("input[name='ed_alamat']").val();
     $nama_pajak = $("input[name='nama_pajak']").val();
     $nama_pic = $("input[name='nama_pic']").val();
     $alamat_pic = $("input[name='alamat_pic']").val();
     $alamat_pajak = $("input[name='alamat_pajak']").val();
     
        if ($nama_member == '' || $nama_member == null) 
        {
            Command: toastr["warning"]("Nama Member Tidak boleh kosong", "Peringatan")

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
        if ($alamat_member == '' || $alamat_member == null) 
        {
            Command: toastr["warning"]("Alamat Member Tidak boleh kosong", "Peringatan")

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
        if ($plafon == '' || $plafon == null) 
        {
            Command: toastr["warning"]("Plafon Tidak boleh kosong", "Peringatan")

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
        if ($nama_pic == '' || $nama_pic == null) 
        {
            Command: toastr["warning"]("Nama PIC Tidak boleh kosong", "Peringatan")

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
        if ($alamat_pic == '' || $alamat_pic == null) 
        {
            Command: toastr["warning"]("Alamat PIC Tidak boleh kosong", "Peringatan")

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
        if ($ed_acc_piutang == '' || $ed_acc_piutang == null) 
        {
            Command: toastr["warning"]("Akun Piutang Tidak boleh kosong", "Peringatan")

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
         if ($ed_csf_piutang == '' || $ed_csf_piutang == null) 
        {
            Command: toastr["warning"]("Csf Piutang Tidak boleh kosong", "Peringatan")
            
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
        if ($nama_pajak == '' || $nama_pajak == null) 
        {
            Command: toastr["warning"]("Nama Pajak Tidak boleh kosong", "Peringatan")
            
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
        if ($alamat_pajak == '' || $alamat_pajak == null) 
        {
            Command: toastr["warning"]("Alamat Pajak Tidak boleh kosong", "Peringatan")
            
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
            url : baseUrl + "/master_sales/customer/save_data",
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
                    }else{
                        alert("Gagal menyimpan data!");
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
            url : baseUrl + "/master_sales/customer/hapus_data",
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

</script>
@endsection
