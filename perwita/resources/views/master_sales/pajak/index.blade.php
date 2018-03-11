@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
    
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> PAJAK12
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
                            <th> Nilai </th>
                            <th> Keterangan </th>
                            <th> Kode Accounting  </th>
                            <th> Kode cash </th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Pajak</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                            <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm" >Kode Pajak</td>
                                    <td colspan="7">
                                         <input type="text" maxlength="10" name="ed_kode" class="form-control kode" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama Pajak</td>
                                    <td colspan="7"><input type="text" class="form-control nama" name="ed_nama" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Tarif (%)</td>
                                    <td colspan="7"><input type="text" class="form-control Tarif" name="ed_nilai" style="text-transform: uppercase" ></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                    <td colspan="7"><textarea type="text" class="form-control Keterangan" name="ed_keterangan" style="text-transform: uppercase" ></textarea>
                                    </td>
                                </tr>
                                <tr>
                                <td style="padding-top: 0.4cm">Kode Accounting</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="acc1 form-control chosen-select-width212" id="acc1" name="ed_acc1" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode akun --</option>
                                        @foreach($data as $a)
                                          <option value="{{$a->id_akun}}" data-nama="{{$a->nama_akun}}">
                                            {{$a->id_akun}} - {{$a->nama_akun}}
                                          </option>
                                        @endforeach
                                      </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 0.4cm">Kode Subcon</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="subcon1 form-control chosen-select-width212" id="subcon1" name="ed_subcon1" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode subcon --</option>
                                        @foreach($data2 as $b)
                                          <option value="{{$b->kode}}" data-subcon="{{$b->nama}}">{{$b->kode}} - {{$b->nama}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                </td>
                            </tr> 
                            <tr>
                                <td style="padding-top: 0.4cm">Kode Cash Flow</td>
                                <td colspan="7">
                                    <div class="input-group date">
                                      <select class="ed_cash1 form-control chosen-select-width212" id="ed_cash1" name="ed_cash1" width="100%">
                                         <option value="" selected="" disabled="">-- Pilih kode akun --</option>
                                        @foreach($data as $a)
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
              "url" :  baseUrl + "/master_sales/pajak/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "kode" },
            { "data": "nama" },
            { "data": "nilai" },
            { "data": "keterangan" },
            { "data": "acc1" },
            { "data": "cash1" },
            { "data": "button" },
            ]
        });
        $("input[name='ed_harga']").maskMoney({thousands:'.', decimal:',', precision:-1});
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

    $(document).on("click","#btn_add",function(){
         $("input[name='crud']").val('N');
        $("input[name='ed_kode']").val('');
        $("input[name='ed_nama']").val('');
        $("input[name='ed_nilai']").val('');
        $("textarea[name='ed_keterangan']").val('');
        $("input[name='ed_acc1']").val('');
        $("input[name='ed_acc2']").val('');
        $("input[name='ed_subcon1']").val('');
        $("input[name='ed_subcon2']").val('');
        $("input[name='ed_cash1']").val('');
        $("input[name='ed_cash2']").val('');;
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
            url : baseUrl + "/master_sales/pajak/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
                $("input[name='crud']").val('E');
                $("input[name='ed_kode']").val(data.kode);
                $("input[name='ed_kode_old']").val(data.kode);
                $("input[name='ed_nama']").val(data.nama);
                $("input[name='ed_nilai']").val(data.nilai);
                $("textarea[name='ed_keterangan']").val(data.keterangan);
                $("input[name='ed_acc1']").val(data.acc1).trigger('chosen:updated');
                $("input[name='ed_acc2']").val(data.acc2);
                $("input[name='ed_cash1']").val(data.cash1).trigger('chosen:updated');
                $("input[name='ed_subcon1']").val(data.subcon1).trigger('chosen:updated');
                $("input[name='ed_subcon2']").val(data.subcon2);
                $("input[name='ed_cash2']").val(data.cash2);;
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
       var a = $(".kode").val();
        var b = $(".nama").val();
        var c = $(".Tarif").val();
        var d = $(".Keterangan").val();
        var e = $(".acc1").val();
        var f = $(".acc2").val();
        var g = $(".cash1").val();
        var h = $(".cash2").val();
       
        if (a == '') {
            Command: toastr["warning"]("Kolom Kode tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if (b == '') {
            Command: toastr["warning"]("Kolom Nama tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            
            }

            return false;
        }
        if (c == '') {
            Command: toastr["warning"]("Kolom Tarif tidak boleh kosong ", "Peringatan !")
            
            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            
            }
            return false;
        }
        if (e == '') {
            Command: toastr["warning"]("Kolom Accounting tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }
        if (f == '') {
            alert('Accounting harus di isi');
           $('html,body').animate({scrollTop: $('.f').offset().top}, 200, function() {
             $('.f').focus();
         });
            return false;
        }
        if (g == '') {
            Command: toastr["warning"]("Kolom Cash Flow tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            };
         
            return false;
        }
        if (h == '') {
           Command: toastr["warning"]("Kolom Cash Flow tidak boleh kosong ", "Peringatan !")

            toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "3000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            return false;
        }

        /*
        var kode_old = $("#ed_kode_old").val();
        var kode = $("#ed_kode").val();
        var kota = $("#ed_kota").val();
        var provinsi = $("#cb_kota_asal").val();
        var crud   = $("#crud").val();
        if(id == '' || id == null ){
            alert('Id harus di isi');
            $("#ed_kode").focus();
            return false;
        }
        if(provinsi == '' || provinsi == null ){
            alert('provinsi harus di isi');
            $("#cb_kota_asal").focus();
            return false;
        }
        /*
        value = {
            id_old: id_old,
            id: id,
            provinsi: provinsi,
            kota: kota.toUpperCase(),
            crud: crud,
            _token: "{{ csrf_token() }}",
        };
        */
        $.ajax(
        {
            url : baseUrl + "/master_sales/pajak/save_data",
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
            }, error:function(x, e) {
          if (x.status == 0) {
              alert('ups !! gagal menghubungi server, harap cek kembali koneksi internet anda');
          } else if (x.status == 404) {
              alert('ups !! Halaman yang diminta tidak dapat ditampilkan.');
          } else if (x.status == 500) {
              swal("Code telah Terpakai", "Harap Cek sekali lagi",'warning');
          } else if (e == 'parsererror') {
              alert('Error.\nParsing JSON Request failed.');
          } else if (e == 'timeout'){
              alert('Request Time out. Harap coba lagi nanti');
          } else {
              alert('Unknow Error.\n' + x.responseText);
          }
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
            url : baseUrl + "/master_sales/pajak/hapus_data",
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
    $("#acc1").change(function(){
        var abc = $(this).find(':selected').data('nama');
        var def = $('.acc2').val(abc);
    })

    $("#subcon1").change(function(){
        var hij = $(this).find(':selected').data('subcon');
        var klm = $('.subcon2').val(hij);
    })
   $('.chosen-select-width212').chosen();
   $('.chosen-single').css({
                            "min-width": "400px",
                            "max-width": "400px"
                            });
   $('.chosen-container-single').css({
                            "min-width": "400px",
                            "max-width": "400px"
                        });
            

</script>
@endsection
