@extends('main')

@section('title', 'dashboard')

@section('content')

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Form Permintaan Cek / BG (FPG) </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Transaksi Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Form Permintaan Cek / BG (FPG) </strong>
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
                    <h5> Form Permintaan Cek / BG (FPG)
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('formfpg/createformfpg')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
              <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                    <!--   <div class="box-body">
                    <div class="form-group">
                            
                            <div class="form-group">
                            <label for="bulan_id" class="col-sm-1 control-label">Bulan</label>
                            <div class="col-sm-2">
                             <select id="bulan_id" name="bulan_id" class="form-control">
                                                      <option value="">Pilih Bulan</option>
                                                      
                              </select>
                            </div>
                          </div>
                          </div>
                           <div class="form-group">
                            
                            <div class="form-group">
                            <label for="tahun" class="col-sm-1 control-label">Tahun</label>
                            <div class="col-sm-2">
                             <select id="tahun" name="tahun" class="form-control">
                                                      <option value="">Pilih Tahun</option>
                                                      
                              </select>
                            </div>
                          </div>
                          </div> 
                </div>    -->    
                    
                <div class="box-body">
             
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th  style="width:10px">No </th>
                        <th > No FPG </th>
                        <th > Tanggal </th>
                        <th > Jenis Bayar </th>
                        <th > Keterangan </th>
                        <th > Total Bayar </th>
                        <th > Uang Muka  </th>
                        <th > Cek / BG  </th>
                      
                        <th > Detail </th>
                     
                    </tr>
                  

                    </thead>
                    <tbody>
                      @foreach($data['fpg'] as $index=>$fpg)
                      <tr>
                        <td> {{$index + 1}} </td>
                        <td>  {{$fpg->fpg_nofpg}} </td>
                        <td>  {{$fpg->fpg_tgl}} </td>
                        <td> {{$fpg->jenisbayar}} </td>
                       
                        <td> {{$fpg->fpg_keterangan}} </td>
                        <td> {{$fpg->fpg_totalbayar}} </td>
                        <td> - </td>
                        <td> {{$fpg->fpg_cekbg}} </td>
                        
                        <td> <a class="btn btn-sm btn-success" href={{url('formfpg/detailformfpg/'.$fpg->idfpg.'')}}> <i class="fa fa-arrow-right" aria-hidden="true"></i> </a> <a class="btn btn-sm btn-info" href="{{url('formfpg/printformfpg/'.$fpg->idfpg.'')}}"> <i class="fa fa-print" aria-hidden="true"></i> </a>  </td>
                        
                      </tr>
                    @endforeach
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                 
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
    
  
  
    

</script>
@endsection
