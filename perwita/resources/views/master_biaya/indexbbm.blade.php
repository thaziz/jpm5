@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
   .datatable thead tr th{
    text-align: center;
   }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Master BBM
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">

                </div><!-- /.box-header -->     
                <div class="box-body">
  
                <table class="datatable table table-bordered">
                    <thead align="center">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama BBM</th>
                            <th>Harga</th>
                    
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($data as $index=>$val)
                        <tr>
                            <td>
                                {{$index+1}}
                            </td>
                            <td>
                                <input type="hidden" name="kode" class="kode"  value="{{$val->mb_id}}">
                                {{$val->mb_id}}
                            </td>
                            <td width="250">
                            @if(Auth::user()->PunyaAkses('Master BBM','ubah'))
                                <input type="text" name="nama" class="nama form-control" style="text-align: center;" onblur="update(this)" value="{{$val->mb_nama}}">
                            @else
                                <input type="text" readonly="" name="" class="nama form-control" style="text-align: center;"  value="{{$val->mb_nama}}">
                            @endif

                            </td>
                            <td width="250">
                            @if(Auth::user()->PunyaAkses('Master BBM','ubah'))
                                <input type="text" name="harga" class="harga form-control"  style="text-align: center;" onblur="update(this)" value="{{$val->mb_harga}}"> 
                            @else
                                <input type="text" name="" readonly="" class="harga form-control"  style="text-align: center;" value="{{$val->mb_harga}}"> 
                            @endif
      
                            </td>
        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>            
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
 



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

function update(ini){
    var parent = ini.parentNode.parentNode;
    var kode = $(parent).find('.kode').val();
    var nama = $(parent).find('.nama').val();
    var harga = $(parent).find('.harga').val();
    console.log(harga);
      $.ajax({
      url:baseUrl + '/bbm/update/'+kode+'/'+nama+'/'+harga,
      type:'get',
      success:function(data){
        toastr.success('Data berhasil di update');
      }
    })
}

function tambah(){

}

</script>
@endsection
