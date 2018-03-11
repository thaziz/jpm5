@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Gudang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Gudang </strong>
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
                    <h5> Tambah Data Master Gudang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="box" id="seragam_box">
              <!-- /.box-header -->
                          <form method="post" action="{{url('mastergudang/savemastergudang')}}"  enctype="multipart/form-data" class="form-horizontal">
                          <div class="box-body">
                            <div class="col-xs-12">
                              <table class="table" border="0">
                                  <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">
                                <tr>
                                  <td> Nama Gudang </td>
                                  <td> <input type="text" class="form-control" name="nmgudang"></td>
                                </tr>
                                <tr>
                                  <td> Cabang </td>
                                  <td> <select class="chosen-select-width" name="idcabang">
                                       @foreach($data['cabang'] as $cbg)
                                       <option value="{{$cbg->kode}}"> {{$cbg->nama}} </option>
                                       @endforeach
                                        </select>
                                  </td>
                                </tr>
                                <tr>
                                  <td> Alamat </td>
                                  <td> <input type="text" class="form-control" name="alamat"> </td>
                                </tr>

                              </table>
                            </div>
                          </div>
                       
                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn btn-warning" href={{url('mastergudang/mastergudang')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success">
                   </form>
                    
                    
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
   var config = {
                '.chosen-select'           : {search_contains:true},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
  })

    
  
   

</script>
@endsection
