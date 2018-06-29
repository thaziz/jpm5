@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
      .id {display:none; }
      .cssright { text-align: right; }
      .center{
        text-align: center;
    }
    .right: {
        text-align: right;
    }
    </style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> UANG MUKA PENJUALAN
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
                            <th> Nomor</th>
                            <th> Tanggal </th>
                            <th> Customer </th>
                            <th> Keterangan</th>
                            <th> Jenis</th>
                            <th> Jumlah</th>
                            <th> Aksi </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal_um" class="modal" >
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Uang Muka Penjualan</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal  kirim">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    <td style="width:120px; padding-top: 0.4cm">Nomor</td>
                                    <td>
                                        <input type="text" name="ed_nomor" class="form-control ed_nomor" style="text-transform: uppercase" >
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_nomor_old" class="form-control ed_nomor_old" >
                                        <input type="hidden" class="form-control crud" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
									<td style="padding-top: 0.4cm">Tanggal</td>
									<td >
										<div class="input-group date">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control col-xs-12 ed_tanggal" name="ed_tanggal" value="{{ $data->tanggal or  date('Y-m-d') }}">
										</div>
									</td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>   
                                        <select onchange="nota_um()" class="chosen-select-width b cb_cabang"  name="cb_cabang" style="width:100%">
                                            <option value="0" >Pilih - Cabang</option>
                                        @foreach ($cabang as $row)
                                            <option value="{{ $row->kode }}"> {{ $row->kode }} - {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>                                
                                <tr>
									<td style="width:110px; padding-top: 0.4cm">Customer</td>
									<td >
									<select class="chosen-select-width cb_customer" name="cb_customer" >
											<option value="0">Pilih - Customer</option>
										@foreach ($customer as $row)
											<option value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
										@endforeach
										</select>
									</td>
                                </tr>
{{-- 								<tr>
									<td style="padding-top: 0.4cm">Jenis</td>
									<td>
										<select class="form-control" name="cb_jenis" >
											<option value="U"> UANG MUKA/DP </option>
										</select>
									</td>
								</tr> --}}
								<tr>
									<td style="padding-top: 0.4cm">Jumlah</td>
									<td>
										<input type="text" class="form-control angka " name="ed_jumlah" style="text-align:right" >
									</td>
								</tr>    
								<tr>
									<td style="width:120px; padding-top: 0.4cm">Keterangan</td>
									<td >
										<input type="text" name="ed_keterangan" class="form-control ed_keterangan" style="text-transform: uppercase" > 
									</td>
								</tr>
                            </tbody>
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
            processing: true,
            // responsive:true,
            serverSide: true,
            "searching": true,
            "ordering": true,
            "info": false,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "ajax": {
              "url" :  baseUrl + "/sales/uang_muka_penjualan/tabel",
              "type": "GET"
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "nama" },
            { "data": "keterangan" },
            { "data": "jenis" },
            { "data": "jumlah" , render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            { "data": "button" },
            ],
            columnDefs:[
                 {
                 targets: 6,
                 className: 'center'
                 },
                 {
                 targets: 5,
                 className: 'right'
                 },
                 {
                 targets: 4,
                 className: 'center'
                 },

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

    
    $('#btn_add').click(function(){
        $.ajax({
            url:'{{url('sales/uang_muka_penjualan/nota_uang_muka')}}',
            dataType:'json',
            type:'get',
            success:function(data){
                $('.kirim :input').val('');
                $('.cb_cabang').val('0').trigger('chosen:updated');
                $('.cb_customer').val('0').trigger('chosen:updated');
                $('.kirim :input').val('');
                $('.ed_nomor').val(data.nota);
                $('.crud').val('N');
                var now = '{{carbon\carbon::now()->format('Y-m-d')}}';
                console.log(now);
                $('.ed_tanggal').datepicker({format:'yyyy-mm-dd'}).datepicker("setDate",'{{carbon\carbon::now()->format('Y-m-d')}}');
                $('#modal_um').modal('show');
            },
            error:function(){

            }
        })
    })

    function edit(id) {
        $.ajax({
            url:'{{url('sales/uang_muka_penjualan/edit')}}',
            dataType:'json',
            type:'get',
            data:{id},
            success:function(data){
                $('.cb_cabang').val(data.data.kode_cabang).trigger('chosen:updated');
                $('.cb_customer').val(data.data.kode_customer).trigger('chosen:updated');
                $('.ed_nomor').val(data.data.nomor);
                $('.ed_nomor_old').val(data.data.nomor);
                $('.angka').val(accounting.formatMoney(data.data.jumlah,"",0,'.',','))
                $('.angka').val(accounting.formatMoney(data.data.jumlah,"",0,'.',','))
                $('.ed_keterangan').val(data.data.keterangan);
                $('.ed_tanggal').val(data.data.tanggal);
                $('.crud').val('E');
                $('#modal_um').modal('show');
            },
            error:function(){

            }
        })
    }
    function nota_um(argument) {
        var cb_cabang = $('.cb_cabang').val();
        $.ajax({
            url:'{{url('sales/uang_muka_penjualan/nota_uang_muka')}}',
            dataType:'json',
            type:'get',
            data:{cb_cabang},
            success:function(data){
                $('.ed_nomor').val(data.nota);
                $('#modal_um').modal('show');
            },
            error:function(){

            }
        })
    }
    $('#btnsave').click(function(){

        $.ajax({
            url:'{{url('sales/uang_muka_penjualan/save_data')}}',
            dataType:'json',
            type:'get',
            data:$('.kirim :input').serialize(),
            success:function(data){
                if (data.status == 1) {
                    var table = $('#table_data').DataTable();
                    table.ajax.reload();
                    $('#modal_um').modal('hide');
                }else{
                    toastr.warning(data.pesan);
                }
            },
            error:function(){

            }
        })
    })


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
          url:'{{url('sales/uang_muka_penjualan/hapus_data')}}',
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
                         var table = $('#table_data').DataTable();
                         table.ajax.reload();
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
