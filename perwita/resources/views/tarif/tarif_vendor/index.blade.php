
@extends('main')


@section('title', 'dashboard')

@section('content')
@include('tarif.tarif_vendor.modal_vendor_darat')

<style type="text/css">
    .cssright { text-align: right; }
     .modal-dialog {
    width: 900px;
    margin: 30px auto;
}
    .pad{
        padding: 10px;
    }
    .center{
        text-align: center;
    }
    .right{
        text-align: right;
    }
    .btn-purple{
      background-color: purple;
    }
    .btn-black{
      background-color: black;
    }
    .error{
      border: 1px solid red !important;
    }
    .reds{
      color:red !important;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF VENDOR </h2>
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
                          <a> Master Vendor</a>
                        </li>
                        <li class="active">
                            <strong> Tarif Vendor </strong>
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
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','print'))
                       <a href="{{ url('/laporan_master_penjualan/tarif_cabang_kilogram') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Laporan</a>
                       @endif
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                    <table id="datatable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:70px"> Kode</th>
                                <th> Asal </th>
                                <th> Tujuan </th>
                                <th> Tarif </th>
                                <th> Cabang </th>
                                <th> Vendor </th>
                                <th> jenis </th>
                                <th> Waktu </th>
                                @if(Auth::user()->punyaAkses('Verifikasi','aktif'))
                                <th>Active</th>
                                @endif
                                <th style="width:80px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <!-- modal -->
               
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
    
  $('#datatable').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('tarif_vendor_datatable') }}',
            },
             columnDefs: [
                  {
                     targets: 0 ,
                     className: ' center'
                  },
                  {
                     targets: 1 ,
                     className: ' left'
                  },
                  {
                     targets: 3 ,
                     className: ' right'
                  },
                  {
                     targets: 5 ,
                     className: ' right'
                  },
                  {
                     targets: 8 ,
                     className: 'center '
                  },
                  {
                     targets: 6 ,
                     className: 'center jenis'
                  },
                  {
                     targets: 7 ,
                     className: 'center'
                  },
                  {
                     targets: 9 ,
                     className: 'center'
                  },
                ],
            "columns": [
            { "data": "id_tarif_vendor" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "tarif_vendor" ,render: $.fn.dataTable.render.number( '.', '.', 0, '' ) },
            { "data": "nama_cab" },
            { "data": "vendor" },
            { "data": "jenis_tarif" },
            { "data": "waktu_vendor" ,render: $.fn.dataTable.render.number( '.', '.', 0, '' ) },
            { "data": "active"},
            { 'data': 'button' },
            ]
      });





  $('#cb_kota_asal').change(function(){
        var idkota = $('#cb_kota_asal :selected').data('kota');
        var kotaid = $('#kodekota').val(idkota);
    })
  $('#cb_kota_tujuan').change(function(){
        $('#hilang').hide();
        // alert('aa');

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('#hilang2').hide();
    })
 
    $('#cb_cabang').change(function(){
      $.ajax({
            type: "get",
            url : ('{{ route('cabang_vendor') }}'),
            //dataType:"JSON",
            data: $(this).val(),
            success: function(data, textStatus, jqXHR)
            {
                

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    })


    $("select[name='cb_acc_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_acc_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_csf_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_csf_penjualan2']").val(nama_akun);
    });
    
    $(document).on("click","#btn_add",function(){
        $('.wajib').val('');
        $('.ed_kode_old').val('');
        $('.option').val('').trigger('chosen:updated');

        $('#hilang2').show();
        
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    function edit(id) {
        $.ajax(
        {
            url : ('{{ route('get_data_tarif_vendor') }}'),
            type: "GET",
            data :  {id},
            success: function(data, textStatus, jqXHR)
            { 
                $('.cabang').val(data.data.cabang_vendor).trigger('chosen:updated');
                $('.kota_asal').val(data.data.id_kota_asal_vendor).trigger('chosen:updated');
                $('.kota_tujuan').val(data.data.id_kota_tujuan_vendor).trigger('chosen:updated');
                $('.vendor').val(data.data.vendor_id).trigger('chosen:updated');
                $('.jenis_angkutan').val(data.data.jenis_angkutan).trigger('chosen:updated');
                $('.jenis_tarif').val(data.data.jenis_tarif).trigger('chosen:updated');
                $('.acc_penjualan').val(data.data.acc_vendor).trigger('chosen:updated');
                $('.csf_penjualan').val(data.data.csf_vendor).trigger('chosen:updated');
                $('.waktu').val(data.data.waktu_vendor);
                $('.tarif').val(Math.round(data.data.tarif_vendor));
                $('.tarif_kurang').val(data.data.tarif_kurang_10);
                $('.tarif_lebih').val(data.data.tarif_setelah_10);
                $('.berat_minimum').val(data.data.berat_minimum);
                $('.ed_kode_old').val(id);
                $("#modal").modal("show");
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    }

    $('.option').change(function(){
      var par = $(this).parents('td');
      par.find('.chosen-single').eq(0).removeClass('error');
    })

    $('.wajib').keyup(function(){
      $(this).removeClass('error');
    })
        
  
    $(document).on("click","#btnsave",function(){
        var validator = [];
        var validator_name = [];

        $('.wajib').each(function(){
          if ($(this).val() == '') {
            $(this).addClass('error');
            validator.push(0);
          }
        })

        $('.option').each(function(){
          if ($(this).val() == '') {
            var par = $(this).parents('td');
            par.find('.chosen-single').eq(0).addClass('error');
            validator.push(0);
          }
        })

        var index = validator.indexOf(0);
        if (index != -1) {
          alert("Semua Inputan Harus Diisi!");
          
          return false;
        } 
        $('.loadings').addClass('fa-circle-o-notch fa-spin');
        $('.loadings').addClass('fa-spin');
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_vendor/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
              if(data.status == 1){
                  var table = $('#datatable').DataTable();
                  table.ajax.reload();
                  $("#modal").modal('hide');
                  $("#btn_add").focus();
                  toastr.success('Berhasil Menyimpan Data');
              }
              if(data.status == 2){
                  var table = $('#datatable').DataTable();
                  table.ajax.reload();
                  $("#modal").modal('hide');
                  $("#btn_add").focus();
                  toastr.success('Berhasil Mengupdate Data');
              }

              if(data.status == 0){
                  toastr.warning('Terjadi Kesalahan');
              }
              $('.loadings').removeClass('fa-circle-o-notch fa-spin');
              $('.loadings').removeClass('fa-spin');
                   
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
              swal("Error!", textStatus, "error");
              $('.loadings').removeClass('fa-circle-o-notch fa-spin');
              $('.loadings').removeClass('fa-spin');
            }
        });
    });

    function hapus(id) {
      
      if(!confirm("Hapus Data"+" ?")) return false;

        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_vendor/hapus_data",
            //dataType:"JSON",
            data: {id},
            success: function(data, textStatus, jqXHR)
            {
                if(data.status ==1){
                    var table = $('#datatable').DataTable();
                    table.ajax.reload();
                }else{
                  toastr.warning('terjadi kesalahan');
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    }
  
  
    function check(id,status) {

    $.ajax({
      url:baseUrl + '/sales/tarif_vendor/check_kontrak_vendor',
      data:{id,status},
      type:'get',
      success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Diupdate",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var table = $('#datatable').DataTable();
                    table.ajax.reload(null,false);
                  });
      },
      error:function(data){
        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
        });
      }
    });
  }

</script>
@endsection
