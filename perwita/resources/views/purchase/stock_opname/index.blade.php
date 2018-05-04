@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Opname </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Warehouse Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Stock Opname </strong>
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
                    <h5> Stock Opname
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                       @if(Auth::user()->punyaAkses('Stock Opname','tambah'))
                   <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('stockopname/createstockopname')}}"> <i class="fa fa-plus"> Membuat Laporan Stok Opname </i> </a> 
                    </div>
                    @endif
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
           
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                </div>        
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Bulan </th>
                        <th> Lokasi Gudang </th>
                        <th> Status  </th>
                        <th> Aksi </th>
                        <th> Detail </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $i =>$val)
                        <tr>
                          <td>{{$i+1}}</td>
                          <td>{{$tgl[$i]}}</td>
                          <td>{{$val->mg_namagudang}}</td>
                          @if($val->so_status == 'TIDAK SESUAI')
                          <td align="center"><label  class="label label-warning">TIDAK SESUAI</label></td>
                          <td align="center"><a href="{{url('stockopname/berita_acara')}}/{{$val->so_id}}" class="btn btn-md btn-info"><i class="fa fa-book"></i> Buat Berita Acara</a></td>
                          @else
                          <td align="center"><label class="label label-success">SESUAI</label></td>
                          <td align="center">
                            <a href="{{url('stockopname/berita_acara')}}/{{$val->so_id}}" class="btn btn-md btn-info"><i class="fa fa-book"></i> Buat Laporan Stock</a>
                          </td>
                          @endif 
                          <td align="center">
                            <a title="detail" class="btn btn-md btn-success btn-sm" href={{url('stockopname/detailstockopname/'. $val->so_id .'')}}>
                              <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                              @if(Auth::user()->punyaAkses('Stock Opname','hapus'))
                            <a class="btn btn-sm btn-danger" onclick="hapusdata({{$val->so_id}})">
                              <i class="fa fa-trash"> </i> 
                            </a>
                            @endif

                            @if(Auth::user()->punyaAkses('Stock Opname','print'))
                            <a class="btn btn-sm btn-info" href="{{url('stockopname/print/'. $val->so_id .'')}}">
                              <i class="fa fa-print"> </i> 
                            </a>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
            
                 <!--   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-info">
          -->
                    
                    
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

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    function hapusdata(id){
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
      data : {id},
      url : baseUrl + '/stockopname/delete/'+id,
      type : "get",
      success : function(response){
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
     })
   })
    }
    

</script>
@endsection
