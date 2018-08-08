
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
     .btn-purple{
      background-color: purple;
    }
    .btn-black{
      background-color: black;
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
                     targets: 1 ,
                     className: ' left'
                  },
                  {
                     targets: 2 ,
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
            { "data": "vendor_id" },
            { "data": "jenis" },
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
        $("input[name='crud']").val('N');
        $("input[name='ed_kode_old']").val('');
        
        $('input[name="waktu_regular"]').val('');
        $('input[name="tarifkertas_reguler"]').val('');
        //reg
        $('input[name="waktu_express"]').val('');
        $('input[name="tarifkertas_express"]').val('');
      
        $('#hilang').show();
        $("input[name='kodekota']").val('');

        $('#hilang2').show();
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").change();
        $("select[name='cb_csf_penjualan']").change();
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    function edit(p) {
      var par    = $(p).parents('tr');
      var asal = $(par).find('.asal').val();
      var tujuan = $(par).find('.tujuan').val();
      var vendor_id = $(par).find('.vendor_id').val();
      var jenis = $(par).find('.jenis').text();
      var cabang = $(par).find('.cabang').val();

        $.ajax(
        {
            url : ('{{ route('get_data_tarif_vendor') }}'),
            type: "GET",
            data :  {asal,tujuan,vendor_id,jenis,cabang},
            success: function(data, textStatus, jqXHR)
            { 
                console.log(data);
                $("input[name='crud']").val('E');
                $("input[name='waktu_regular']").val(data[0].waktu_vendor);
                $("input[name='waktu_express']").val(data[3].waktu_vendor);
                
                $("input[name='tarifkertas_reguler']").val(data[0].tarif_vendor);
                $("input[name='tarif10kg_reguler']").val(data[1].tarif_vendor);
                $("input[name='tarifsel_reguler']").val(data[2].tarif_vendor);

                $("input[name='tarifkertas_express']").val(data[3].tarif_vendor);
                $("input[name='tarif10kg_express']").val(data[4].tarif_vendor);
                $("input[name='tarifsel_express']").val(data[5].tarif_vendor);  

                $("input[name='berat_minimum_reg']").val(data[0].berat_minimum);
                $("input[name='berat_minimum_ex']").val(data[3].berat_minimum);

                $("input[name='id_tarif_vendor_reg']").val(data[0].id_tarif_vendor);
                $("input[name='id_tarif_vendor_reg_1']").val(data[1].id_tarif_vendor);
                $("input[name='id_tarif_vendor_reg_2']").val(data[2].id_tarif_vendor);
                $("input[name='id_tarif_vendor_ex']").val(data[3].id_tarif_vendor);
                $("input[name='id_tarif_vendor_ex_1']").val(data[4].id_tarif_vendor);
                $("input[name='id_tarif_vendor_ex_2']").val(data[5].id_tarif_vendor);

                $("input[name='tarif_dokumen']").val(data[0].tarif_dokumen);


                $("#modal").modal("show");

                $("select[name='cb_cabang']").val(data[0].cabang_vendor).trigger('chosen:updated');
                $("select[name='cb_kota_asal']").val(data[0].id_kota_asal_vendor).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0].id_kota_tujuan_vendor).trigger('chosen:updated');
                $("select[name='cb_vendor']").val(data[0].vendor_id).trigger('chosen:updated');
                $("select[name='cb_acc_penjualan']").val(data[0].acc_vendor).trigger('chosen:updated');
                $("select[name='cb_csf_penjualan']").val(data[0].csf_vendor).trigger('chosen:updated');
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    }
        
  
    $(document).on("click","#btnsave",function(){
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_vendor/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.status == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.status == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update customer data, error : "+data.error,"error");
                    }
                }else{
                    // console.log(data.hasil_cek);
                    swal(data.hasil_cek,'Cek sekali lagi',"warning");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    function hapus(parm) {
      var par   = $(parm).parents('tr');
      var asal = $(par).find('.asal').val();
      var tujuan = $(par).find('.tujuan').val();
      var vendor_id = $(par).find('.vendor_id').val();
      var jenis = $(par).find('.jenis').text();
      var cabang = $(par).find('.cabang').val();

      if(!confirm("Hapus Data"+" ?")) return false;
        var value = {
            asal: asal,
            tujuan: tujuan,
            vendor_id: vendor_id,
            jenis: jenis,
            cabang: cabang,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_vendor/hapus_data",
            //dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.status ==1){
                    var table = $('#table_data').DataTable();
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
  
  
    function check(p) {

    var par    = $(p).parents('tr');
    var asal = $(par).find('.asal').val();
    var tujuan = $(par).find('.tujuan').val();
    var vendor_id = $(par).find('.vendor_id').val();
    var jenis = $(par).find('.jenis').text();
    var cabang = $(par).find('.cabang').val();
    var check  = $(par).find('.check').is(':checked');

    $.ajax({
      url:baseUrl + '/sales/tarif_vendor/check_kontrak_vendor',
      data:{asal,tujuan,vendor_id,jenis,check,cabang},
      type:'get',
      success:function(data){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Diupdate",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                    var table = $('#table_data').DataTable();
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
