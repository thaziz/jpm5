@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css" media="screen">
  .center{
    text-align: center;
  }
</style>

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
                          <a> Master Bersama</a>
                        </li>
                        <li class="active">
                            <strong> Master Akun Fitur </strong>
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
                            <div class="col-xs-6">
                              <table class="table">
                                <tr>
                                    @if(Auth::user()->punyaAkses('Master Akun Fitur','cabang'))
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    @endif
                                    @if(Auth::user()->punyaAkses('Master Akun Fitur','cabang'))
                                    <td>
                                        <select class="form-control chosen-select-width cabang" name="cabang">
                                            <option value="GLOBAL">GLOBAL</option>
                                            @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @else
                                    <td class="disabled" hidden="">
                                        <select class="form-control chosen-select-width cabang" name="cabang">
                                            @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}">{{ $row->kode }} - {{ $row->nama }} </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    @endif
                                </tr>
                              </table>
                            </div>
                          </div>
                        </div>
                    </form>
                <div class="box-body" >
                    <div class="col-sm-6" style="margin-bottom: 250px;">
                        <h3>AKUN PETTY CASH</h3>
                        <table class="table">
                          {{ csrf_field() }}
                            <tr>
                                <td width="130">Nama Akun</td>
                                <td class="patty_td">
                                    <select  name="patty_cash" multiple="" class="patty_cash chosen-select-width form-control">
                                        @foreach($akun as $i)
                                            <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                              <td><button class="btn ins_patty btn-primary">Insert</button></td>
                            </tr>
                        </table>
                        <table class="table tabel_patty">
                            <thead>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>

                    <div class="col-sm-6" style="margin-bottom: 250px;">
                        <h3>AKUN FAKTUR ITEM</h3>
                        <table class="table">
                          {{ csrf_field() }}
                            <tr>
                                <td width="130">Nama Item</td>
                                <td class="item_td">
                                    <select  name="patty_cash" multiple="" class="item chosen-select-width form-control">
                                        @foreach($item as $i)
                                            <option value="{{$i->kode_item}}">{{$i->kode_item}} - {{$i->nama_masteritem}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                              <td><button class="btn ins_item btn-primary">Insert</button></td>
                            </tr>
                        </table>
                        <table class="table tabel_item">
                            <thead>
                                <th>Kode Akun</th>
                                <th>Nama Akun</th>
                                <th>Aksi</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
                  </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
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
    $(document).ready(function(){
      var cabang = $('.cabang').val();

        $('.tabel_patty').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_akun') }}',
              data:{cabang: function() { return $('.cabang').val() }}
          },
          columnDefs: [
                  {
                     targets: 0,
                     className: 'kode_akun'
                  },
                  {
                     targets: 2 ,
                     className: 'center'
                  },
                ],
          columns: [
            {data: 'maf_kode_akun', name: 'maf_kode_akun'},
            {data: 'maf_nama', name: 'maf_nama'},
            {data: 'aksi', name: 'aksi'},
          ]

        });

        $('.tabel_item').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_item') }}',
              data:{cabang: function() { return $('.cabang').val() }}
          },
          columnDefs: [
                  {
                     targets: 0,
                     className: 'kode_akun'
                  },
                  {
                     targets: 2 ,
                     className: 'center'
                  },
                ],
          columns: [
            {data: 'maf_kode_akun', name: 'maf_kode_akun'},
            {data: 'maf_nama', name: 'maf_nama'},
            {data: 'aksi', name: 'aksi'},
          ]

        });

        $.ajax({
          url:baseUrl + '/master_sales/ganti_akun_patty',
          type:'get',
          data:{cabang},
          success:function(data){
             $('.patty_td').html(data);
          },
          error:function(data){
             location.reload();
          }
      }); 

      $.ajax({
          url:baseUrl + '/master_sales/ganti_akun_item',
          type:'get',
          data:{cabang},
          success:function(data){
             $('.item_td').html(data);
          },
          error:function(data){
             location.reload();
             
          }
      }); 
    })

    $('.cabang').change(function(){
      var cabang = $('.cabang').val();

      var patty = $('.tabel_patty').DataTable();
      patty.ajax.reload();

      var item = $('.tabel_item').DataTable();
      item.ajax.reload();

      $.ajax({
          url:baseUrl + '/master_sales/ganti_akun_patty',
          type:'get',
          data:{cabang},
          success:function(data){
             $('.patty_td').html(data);
          },
          error:function(data){
             
          }
      }); 

      $.ajax({
          url:baseUrl + '/master_sales/ganti_akun_item',
          type:'get',
          data:{cabang},
          success:function(data){
             $('.item_td').html(data);
          },
          error:function(data){
             
          }
      }); 

    })

    $('.ins_patty').click(function(){
        var cabang = $('.cabang').val();
        var patty = $('.patty_cash').val();
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
            url:baseUrl + '/master_sales/save_akun_patty',
            type:'get',
            data:{patty,cabang},
            success:function(data){
               var patty = $('.tabel_patty').DataTable();
               patty.ajax.reload();
            },
            error:function(data){
               
            }
        }); 
    })

    $('.ins_item').click(function(){
        var cabang = $('.cabang').val();
        var patty = $('.item').val();
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
        $.ajax({
            url:baseUrl + '/master_sales/save_akun_item',
            type:'get',
            data:{patty,cabang},
            dataType : "json",
            success:function(data){
              if(data == 'akun persediaan kosong') {
                toastr.info('Kode akun persediaan tidak ada pada cabang ' + cabang);
              }
              else if(data == 'akun hpp kosong') {
                toastr.info('Kode akun hpp tidak ada pada cabang ' + cabang);

              }
              else {
                 var item = $('.tabel_item').DataTable();
               item.ajax.reload();
              }
              
            },
            error:function(data){
                swal({
                title: "Terjadi Kesalahan",
                        type: 'error',
                        timer: 900,
                        showConfirmButton: true

                });
            }
        }); 
    })

    function hapus1(a) {
      var par = $(a).parents('tr');
      var akun = $(par).find('.kode_akun').text();
      var cabang = $('.cabang').val();
      $.ajax({
            url:baseUrl + '/master_sales/hapus_akun_patty',
            type:'get',
            data:{akun,cabang},
            success:function(data){
               var item = $('.tabel_patty').DataTable();
               item.ajax.reload();
            },
            error:function(data){
                swal({
                title: "Terjadi Kesalahan",
                        type: 'error',
                        timer: 900,
                        showConfirmButton: true

                });
            }
        }); 
    }

    function hapus2(a) {
      var par = $(a).parents('tr');
      var akun = $(par).find('.kode_akun').text();
      var cabang = $('.cabang').val();
      $.ajax({
            url:baseUrl + '/master_sales/hapus_akun_item',
            type:'get',
            data:{akun,cabang},
            success:function(data){
               var item = $('.tabel_item').DataTable();
               item.ajax.reload();
            },
            error:function(data){
                swal({
                title: "Terjadi Kesalahan",
                        type: 'error',
                        timer: 900,
                        showConfirmButton: true

                });
            }
        }); 
    }
</script>
@endsection
