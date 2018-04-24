@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> SUBCON </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master DO</a>
                        </li>
                        <li class="active">
                            <strong> SUBCON </strong>
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
                    <h5> SUBCON
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
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
                <div class="box-body">
                  <table id="table_data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th> Kode</th>
                            <th> Nama </th>
                            <th> Alamat </th>
                            <th> Telpon </th>
                            <th> Fax </th>
                            <th> Persentase </th>
                            <th> acc </th>
                            <th> csf </th>
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
                        <h4 class="modal-title">Insert Edit Subcon</h4>
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
                                        <input type="hidden" name="id_subcon">
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Tgl Kontrak</td>
                                    <td>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="ed_tgl_kontrak">
                                        </div>
                                    </td>
                                    <td style="padding-top: 0.4cm">Nomor Kontrak</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_nomor_kontrak" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Penanggung Jawab</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_penanggung_jawab" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                                    </td>
                                </tr>
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
                                    <td style="padding-top: 0.4cm">Email</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_email" style="text-transform: uppercase" >
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top: 0.4cm">Kontak Person</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_kontak_person" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Akun</td>
                                    <td colspan="3">
                                      <select name="acc_code"  class="form-control acc_code chosen-select-width">
                                          <option value="0">Pilih - Akun</option>
                                        @foreach($akun as $i)
                                          <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
                                        @endforeach
                                      </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Csf Akun</td>
                                    <td colspan="3">
                                      <select name="csf_code" class="form-control csf_code chosen-select-width">
                                          <option value="0">Pilih - Akun</option>
                                        @foreach($akun as $i)
                                          <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
                                          @endforeach
                                      </select>  
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Persentase</td>
                                    <td colspan="3">
                                      <div class="input-group " style="width: 100%;text-align: right">
                                        <input type="text" class="form-control" readonly="" value="80" name="persen" style="text-transform: uppercase;text-align: right" >
                                        <span class="input-group-addon"><i class="fa fa-percent"></i></span>
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
              "url" :  baseUrl + "/master_sales/subcon/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "alamat" },
            { "data": "telpon" },
            { "data": "fax" },
            { "data": "persen" },
            { "data": "acc_code" },
            { "data": "csf_code" },
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
       // $("input[name='ed_harga']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $(document).on("click","#btn_add",function(){
        var d = new Date();
        var date = d.getDate() +'-'+(d.getMonth()+1)+'-'+d.getFullYear();
        // alert(d);    
        $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_tgl_kontrak']").val(date);
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_nomor_kontrak']").val('');
        $("input[name='ed_penanggung_jawab']").val('');
        $("input[name='ed_alamat']").val('');
        $(".acc_code").val('0').trigger('chosen:updated');
        $(".csf_code").val('0').trigger('chosen:updated');
        $("input[name='ed_telpon']").val('');
        $("input[name='ed_fax']").val('');
        $("input[name='ed_kontak_person']").val('');
        $("input[name='persen']").val('80');
        $("input[name='persen']").prop('readonly',true);
        $("input[name='ed_email']").val('');
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
            url : baseUrl + "/master_sales/subcon/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                console.log(data.acc_code);
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='id_subcon']").val(data.id_subcon);
                $("input[name='ed_kode_old']").val(data.kode);
                $("input[name='ed_nama']").val(data.nama);                
                $("input[name='ed_tgl_kontrak']").val(data.tgl_kontrak);
                $("input[name='ed_nomor_kontrak']").val(data.nomor_kontrak);
                $("input[name='ed_penanggung_jawab']").val(data.penanggung_jawab);
                $("input[name='ed_alamat']").val(data.alamat);
                $("input[name='persen']").val(data.persen);
                $(".acc_code").val(data.acc_code).trigger('chosen:updated');
                $(".csf_code").val(data.csf_code).trigger('chosen:updated');
                $("input[name='persen']").prop('readonly',false);
                $("input[name='ed_telpon']").val(data.telpon);
                $("input[name='ed_fax']").val(data.fax);
                $("input[name='ed_email']").val(data.email);
                $("input[name='ed_kontak_person']").val(data.kontak_person);
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
       var b = $("input[name='ed_nama']").val();
       var c = $("input[name='ed_nomor_kontrak']").val();
       var d = $("input[name='ed_penanggung_jawab']").val();
       var e = $("input[name='ed_alamat']").val();
       var f = $("input[name='ed_telpon']").val();
       var g =$("input[name='ed_kontak_person']").val();
       var h = $("input[name='ed_email']").val();

       if (b == '' || b == null) {
            Command: toastr["warning"]("Nama Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "800",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return 1;
       }
       else if (c== '' || c == null)  {
            Command: toastr["warning"]("Nomor Kontrak Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "800",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return 1;
       }
       else if (d== '' || d == null)  {
            Command: toastr["warning"]("Penanggung Jawab Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "800",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return 1;
       }
       else if (e== '' || e == null)  {
            Command: toastr["warning"]("Alamat Tidak Boleh Kosong", "Peringatan!")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "800",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return 1;
       }


        $.ajax(
        {
            url : baseUrl + "/master_sales/subcon/save_data",
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
            url : baseUrl + "/master_sales/subcon/hapus_data",
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
     $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy',
        calendarWeeks: true,
        todayHighlight: true,
        autoclose: true
    });


</script>
@endsection
