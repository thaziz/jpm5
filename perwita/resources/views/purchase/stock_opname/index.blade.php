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
                   <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('stockopname/createstockopname')}}"> <i class="fa fa-plus"> Membuat Laporan Stok Opname </i> </a> 
                    </div>
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
                          @if($val->so_status == 'TIDAK')
                          <td align="center"><label class="label label-warning">TIDAK SESUASI</label></td>
                          <td align="center"><a href="{{url('stockopname/berita_acara')}}/{{$val->so_id}}" class="btn btn-warning"><i class="fa fa-book"></i> Buat Berita Acara</a></td>
                          @else
                          <td align="center"><label class="label label-success">SESUASI</label></td>
                          <td align="center">
                            <a href="{{url('stockopname/berita_acara')}}/{{$val->so_id}}" class="btn btn-success"><i class="fa fa-book"></i> Buat Laporan Stock</a>
                          </td>
                          @endif 
                          <td align="center">
                            <a title="detail" class="btn btn-success btn-sm" href={{url('konfirmasipengeluaranbarang/detailkonfirmasipengeluaranbarang')}}>
                              <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
            
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-info">
         
                    
                    
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
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=field-'+$no+'> <td> <b>' + $no +' </b> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]">  <option value=""> -- Pilih Data Barang -- </option> <option value="">  Barang 1 </option> <option value="">  Barang 2 </option> </td> <td> </td>  <td> </td> <td> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option> </td> <td> 3000 </td> <td> <button class="btn btn-danger remove-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button> </td> </tr>');



      $(document).on('click','.remove-btn',function(){
              var id = $(this).data('id');
              var parent = $('#field-'+id);

              parent.remove();
          })
    })

      $('#tmbh_supplier').click(function(){
            $no++;
        $("#addColumn").append('<tr id=supp-'+$no+'> <td> <b>  </b> </td> <td> </td> <td> </td>  <td> </td> <td> </td><td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option>  </td> <td> 3000 </td> <td> <button class="btn btn-danger removes-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button>  </td> </tr>');


        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#supp-'+id);

             parent.remove();
          })
     })
  
    

</script>
@endsection
