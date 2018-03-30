@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> VENDOR </h2>
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
                            <strong> Vendor </strong>
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
                    <h5> VENDOR
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
                            <th> Kota </th>
                            <th> Telpon </th>
                            <th> Status </th>
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
                        <h4 class="modal-title">Insert Edit Vendor</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Kode</td>
                                    <td>
                                        <input type="text" name="ed_kode" placeholder="Otomatis" class="form-control" style="text-transform: uppercase" >
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
                                    <td style="padding-top: 0.4cm">Kota</td>
                                    <td>   
                                        <select class="chosen-select-width"  name="cb_kota" style="width:100%">
                                            <option value=""></option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td style="padding-top: 0.4cm">Tipe</td>
                                    <td>
                                        <select class="form-control" name="cb_tipe">
                                            {{-- <option value="" selected="">Pilih-</option> --}}
                                            <option value="VENDOR">VENDOR</option>
                                        </select>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>
                                        <select class="form-control" name="cb_cabang">
                                            @foreach ($cabang as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="padding-top: 0.4cm">Alamat</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_alamat" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding-top: 0.4cm">Telpon</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_telpon" style="text-transform: uppercase" >
                                    </td>
                                    <td style="padding-top: 0.4cm">Kode Pos</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_kode_pos" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        
                                    </td>
                                    <td>
                                        <div >
                                            <label for="checkbox1"> <input type="checkbox" name="ck_status"> Pakai Angkutan </label>
                                        </div>  
                                    </td>
                                     <td style="padding-top: 0.4cm">Komisi Vendor(%)</td>
                                    <td>
                                        <input type="text" class="form-control" name="ed_komisi_vendor" value="80" id="ed_komisi_vendor"  >
                                    </td>
                                    
                                </tr>
                                <tr>
                                <td style="padding-top: 0.4cm">Acc Biaya</td>
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
                                <td style="padding-top: 0.4cm">CSF Biaya</td>
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
                                <td style="padding-top: 0.4cm">CSF Hutang</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="acc1 form-control chosen-select-width212" id="acc1" name="ed_acc4" width="100%">
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

     $('#ed_komisi_vendor').attr('readonly',true);
     $('input[name="ed_kode"]').attr('readonly',true);


     $('#ed_komisi_vendor').val('80');
    
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
              "url" :  baseUrl + "/master_sales/vendor/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "alamat" },
            { "data": "kota" },
            { "data": "telpon" },
            { "data": "status" },
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
        $("input[name='ed_kode_old']").val('');
        $("input[name='ed_nama']").val('');
        $("select[name='cb_tipe']").val('');
        $("select[name='cb_kota']").val('').trigger('chosen:updated');
        $("input[name='ed_alamat']").val('');
        $("input[name='ed_telpon']").val('');
        $("#ed_komisi_vendor").val('80');
        $("input[name='ed_kode_pos']").val('');
        $("input[name='ck_status']").attr('checked', false);
        $("select[name='ed_acc1']").val('').trigger('chosen:updated');
        $("select[name='ed_acc2']").val('').trigger('chosen:updated');
        $("select[name='ed_acc3']").val('').trigger('chosen:updated'); 
        $("select[name='ed_acc4']").val('').trigger('chosen:updated'); 
        $("select[name='cb_cabang']").val('').trigger('chosen:updated');

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
            url : baseUrl + "/master_sales/vendor/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='ed_kode_old']").val(data.id_vendor);
                $("input[name='ed_nama']").val(data.nama);                
                $("select[name='cb_tipe']").val(data.tipe);
                $("select[name='cb_kota']").val(data.id_kota).trigger('chosen:updated');
                $("input[name='ed_alamat']").val(data.alamat);
                $("input[name='ed_telpon']").val(data.telpon);
                $("input[name='ed_kode_pos']").val(data.kode_pos);
                $("#ed_komisi_vendor").val(data.komisi_vendor);
                $("#ed_komisi_vendor").attr('readonly',false);
                $("input[name='ck_status']").attr('checked', data.status);
                $("select[name='ed_acc1']").val(data.acc_penjualan).trigger('chosen:updated');
                $("select[name='ed_acc2']").val(data.acc_hutang).trigger('chosen:updated');
                $("select[name='ed_acc3']").val(data.csf_penjualan).trigger('chosen:updated'); 
                $("select[name='ed_acc4']").val(data.csf_hutang).trigger('chosen:updated'); 
                $("select[name='cb_cabang']").val(data.cabang_vendor).trigger('chosen:updated');

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
        $.ajax(
        {
            url : baseUrl + "/master_sales/vendor/save_data",
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
            url : baseUrl + "/master_sales/vendor/hapus_data",
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
