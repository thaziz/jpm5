@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
</style>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5 style="margin : 8px 5px 0 0"> INVOICE
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">

                    <table id="tabel_data" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Tanggal </th>
                                <th>Customer</th>
                                <th>JT</th>
                                <th>Tagihan </th>
                                <th>Keterangan </th>
                                <th>No Faktur Pajak </th>
                                <th style="width:10%"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->i_nomor }}</td>
                                <td>{{ $row->i_tanggal }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->i_jatuh_tempo }}</td>
                                <td style="text-align:right"> {{ number_format($row->i_total_tagihan, 2, ",", ".") }} </td>
                                <td>{{ $row->i_keterangan }}</td>
                                <td>{{ $row->i_no_faktur_pajak }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" onclick="hapus('{{$row->i_nomor}}')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        <button type="button" onclick="edit('{{$row->i_nomor}}')" class="btn btn-sm btn-success"><i class="fa fa-pencil"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">





                    </div>
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
        $('#tabel_data').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
      });
    });


    $(document).on("click","#btn_add_order",function(){
        window.location.href = baseUrl + '/sales/invoice_form'
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    function edit(id){
        window.location.href = baseUrl + '/sales/posting_pembayaran_edit/'+id;

    }

    function hapus(id){
        swal({
        title: "Apakah anda yakin?",
        text: "Hapus Data!",
        type: "warning",
        showCancelButton: true,
        showLoaderOnConfirm: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
    },

    function(){

         $.ajax({
          url:baseUrl + '/sales/hapus_invoice',
          data:{id},
          type:'get',
          success:function(data){
              swal({
              title: "Berhasil!",
                      type: 'success',
                      text: "Data Berhasil Dihapus",
                      timer: 2000,
                      showConfirmButton: true
                      },function(){
                         location.reload();
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
    });
}


</script>
@endsection
