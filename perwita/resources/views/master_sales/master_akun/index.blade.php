@extends('main')

@section('title', 'dashboard')

@section('content')


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
                          <a> Master Penjualan</a>
                        </li>
                        <li>
                          <a> Tarif DO</a>
                        </li>
                        <li class="active">
                            <strong> Agen </strong>
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
                      @if(Auth::user()->punyaAkses('Agen','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
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
                <div class="box-body" >
                    <div class="col-sm-6" style="margin-bottom: 250px;">
                        <h3>AKUN PATTY CASH</h3>
                        <table class="table">
                            <tr>
                                <td>Nama Akun</td>
                                <td>
                                    <select  name="patty_cash" multiple="" class="patty_cash chosen-select-width form-control">
                                        @foreach($akun as $i)
                                            <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="table tabel_patty">
                            <thead>
                                <th>No</th>
                                <th>Nama Akun</th>
                                <th>Kode Akun</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6" style="margin-bottom: 250px;">
                        <h3>AKUN FAKTUR ITEM</h3>
                        <table class="table">
                            <tr>
                                <td>Nama Akun</td>
                                <td>
                                    <select  name="patty_cash" multiple="" class="patty_cash chosen-select-width form-control">
                                        @foreach($akun as $i)
                                            <option value="{{$i->id_akun}}">{{$i->id_akun}} - {{$i->nama_akun}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <table class="table tabel_item">
                            <thead>
                                <th>No</th>
                                <th>Nama Akun</th>
                                <th>Kode Akun</th>
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
    $('.patty_cash').change(function(){
        var asd = $('.patty_cash').val();
        console.log(asd);
    })
    $(document).ready(function(){
        $('.tabel_patty').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_akun') }}',
          },
          columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center'
                  },
                ],
          columns: [
            {data: 'maf_id', name: 'maf_id'},
            {data: 'maf_kode_akun', name: 'maf_kode_akun'},
            {data: 'maf_nama', name: 'maf_nama'},
          ]

        });

        $('.tabel_item').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
              url:'{{ route('datatable_item') }}',
          },
          columnDefs: [

                  {
                     targets: 0 ,
                     className: 'center'
                  },
                ],
          columns: [
            {data: 'maf_id', name: 'maf_id'},
            {data: 'maf_kode_akun', name: 'maf_kode_akun'},
            {data: 'maf_nama', name: 'maf_nama'},
          ]

        });
    })

</script>
@endsection
