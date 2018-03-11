@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  #addColumn thead tr th{
    text-align: center;
  }
  .asw{
    color: grey;
  }
  .asw:hover{
    color: red;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pembayaran Kas </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li class="active">
                            <strong> Kontrak Subcon </strong>
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
                    <h5> Kontrak Subcon
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('master_subcon/tambahkontraksubcon')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  
                  <div class="box-body">
                    
                <div class="box-body">
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead align="center">
                     <tr>
                        <th> No. Kontrak </th>
                        <th> Tanggal Kontrak </th>
                        <th> Akhir Kontrak </th>
                        <th> Nama Subcon </th>
                        <th> Cabang Kontrak </th>
                        <th> Allow Edit </th>
                        <th> aksi </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data as $i => $val)
                      <tr>
                        <td>{{$val->ks_nota}}</td>
                        <td>{{$val->ks_tgl_mulai}}</td>
                        <td>{{$val->ks_tgl_akhir}}</td>
                        <td>{{$subcon[$i]->nama}}</td>
                        <td>{{$val->nama}}</td>
                        <td align="center"><input type="checkbox" class="allow" name="cek[]"></td>
                        <td class="text-center">
                          <div class="btn-group">
                            <a href="{{url('master_subcon/edit_subcon')}}/{{$val->ks_id}}" data-toggle="tooltip" title="" class="btn btn-warning btn-xs btnedit" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            <a href="{{url('master_subcon/hapus_subcon')}}/{{$val->ks_id}}" data-toggle="tooltip" title="" class="btn btn-xs btn-danger btnhapus" data-original-title="Delete"><i class="fa fa-times"></i></a>
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
            </div>
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

</script>
@endsection
