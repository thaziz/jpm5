@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Stock Gudang </h2>
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
                            <strong> Stock Gudang  </strong>
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
                    <h5> Stock Gudang
                  
                     </h5>
                   
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div>
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">   
                  </div>        
                    
                <div class="box-body">

                  <table class="table" style="width:400px">
                    <tr>
                      <th> Gudang : </th>
                      <td style="width:200px">  <select class="form-control idgudang"> @foreach($data['gudang'] as $gdg) <option value="{{$gdg->mg_id}}"> {{$gdg->mg_namagudang}} </option> @endforeach </select> </td>
                    
                    </tr>
                  </table>

                  <table class="table table-bordered table-striped tbl-penerimabarang" id="tablegudang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Nama Barang </th>
                        <th style="width:50px"> Stock Gudang </th>
                        <th style="width:50px"> Minimum Stock  </th>
                        <th> Status </th>
                        <th> Aksi </th>
                    </tr>
                
                    </thead>
                   <tbody>
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

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            paging: true,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
  
  $('.idgudang').change(function(){
   
    idgudang = $('.idgudang').val();
  
    $.ajax({
      data : {idgudang},
      type : "get",
      url : baseUrl + '/stockgudang/carigudang',
      dataType : 'json',
      success : function(response){

        tablegudang = $('#tablegudang').DataTable();
        tablegudang.clear().draw();

        datagudang = response.gudang;
        n = 1;
        for(i = 0 ; i < response.count; i++){        
          var row = "<tr> <td> "+n+" </td>" +
                "<td> "+datagudang[i].kode_item+" - "+datagudang[i].nama_masteritem+" </td>" + 
                "<td> "+datagudang[i].sg_qty+"</td>" +
                "<td> "+datagudang[i].sg_minstock+" </td>" +
                "<td>"; 
                if(datagudang[i].sg_qty < datagudang[i].sg_minstock) {
                  row +=   "<i class='btn btn-warning fa fa-exclamation-triangle' aria-hidden='true'></i> Waning";

                }
                    else {
                   row +=   "<i class='fa fa-check' aria-hidden='true'></i>";

                    }
                    
                 row +=  "</td>" +
                "<td>  <a class='btn btn-sm btn-info' href={{url('pengeluaranbarang/pengeluaranbarang')}}> <i class='fa fa-plus'> </i> Buat SPPB </a> &nbsp; <a class='btn btn-sm btn-primary' href={{url('suratpermintaanpembelian/createspp')}}> <i class='fa fa-plus'> </i> Buat SPP</i> </a></td>" +
              "</tr>";
         
               tablegudang.rows.add($(row)).draw();
              n++;
        }


      },
      error : function(){
        location.reload();
      }
    })
  })
  
  idgudang = $('.idgudang').val();
  
    $.ajax({
      data : {idgudang},
      type : "get",
      url : baseUrl + '/stockgudang/carigudang',
      dataType : 'json',
      success : function(response){

        tablegudang = $('#tablegudang').DataTable();
        tablegudang.clear().draw();

        datagudang = response.gudang;
        n = 1;
        for(i = 0 ; i < response.count; i++){        
          var row = "<tr> <td> "+n+" </td>" +
                "<td> "+datagudang[i].kode_item+" - "+datagudang[i].nama_masteritem+" </td>" + 
                "<td> "+datagudang[i].sg_qty+"</td>" +
                "<td> "+datagudang[i].sg_minstock+" </td>" +
                "<td>"; 
                if(datagudang[i].sg_qty < datagudang[i].sg_minstock) {
                  row +=   "<i class='btn btn-warning fa fa-exclamation-triangle' aria-hidden='true'></i> Waning";

                }
                    else {
                   row +=   "<i class='fa fa-check' aria-hidden='true'></i>";

                    }
                    
                 row +=  "</td>" +
                "<td>  <a class='btn btn-sm btn-info' href={{url('pengeluaranbarang/createpengeluaranbarang')}}> <i class='fa fa-plus'> </i> Buat SPPB </a> &nbsp; <a class='btn btn-sm btn-primary' href={{url('suratpermintaanpembelian/createspp')}}> <i class='fa fa-plus'> </i> Buat SPP</i> </a></td>" +
              "</tr>";
         
               tablegudang.rows.add($(row)).draw();
              n++;
        }


      },
      error : function(){
        location.reload();
      }
    })

</script>
@endsection
