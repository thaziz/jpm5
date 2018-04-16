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
                      <td style="width:200px">  <select class="form-control gudang" onclick="carigudang()"> @foreach($data['gudang'] as $gdg) <option value="{{$gdg->mg_id}}"> {{$gdg->mg_namagudang}} </option> @endforeach </select> </td>
                    
                    </tr>
                  </table>

                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang" id="table-gudang">
                    <thead>
                     <tr>
                        <th style="width:10px">NO</th>
                        <th> Nama Barang </th>
                        <th> Stock Gudang </th>
                        <th> Minimum Stock  </th>
                        <th> Status </th>
                        <th> Aksi </th>
                    </tr>
                
                    </thead>
                    <tbody>
                      @foreach($data['stock'] as $index=>$stock)
                      <tr>
                        <td> {{$index + 1}} </td>
                        <td> {{$stock->kode_item}} - {{$stock->nama_masteritem}} </td>
                        <td> {{$stock->sg_qty}}</td>
                        <td> {{$stock->sg_minstock}} </td>
                        <td> @if($stock->sg_qty < $stock->sg_minstock)
                           <i class="btn btn-warning fa fa-exclamation-triangle" aria-hidden="true"></i> Waning
                            @else
                            <i class="fa fa-check" aria-hidden="true"></i> 
                            @endif
                        </td>
                        <td>  <a class="btn btn-sm btn-info" href="{{url('pengeluaranbarang/createpengeluaranbarang')}}"> <i class="fa fa-plus"> </i> Buat SPPB </a> &nbsp; <a class="btn btn-sm btn-primary" href="{{url('suratpermintaanpembelian/createspp')}}"> <i class="fa fa-plus"> </i> Buat SPP</i> </a></td>
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
    
  
  function carigudang(){
    idgudang = $('.idgudang').val();

    $.ajax({
      data : idgudang,
      type : "get",
      url : baseUrl + '/stockgudang/carigudang',
      success : function(response){

        tablegudang = $('#table-gudang').DataTable();
        tablegudang.clear.draw();

        datagudang = response.gudang;
        n = 1;
        for(i = 0 ; i < datagudang; i++){
          row = "<tr>" +
                "<td> "+n+" </td>" +
                "<td> "+datagudang[i].kode_item+" - "+datagudang[i].nama_masteritem+" </td>"
                "<td> "+datagudang[i].sg_qty+"</td>" +
                "<td> "+datagudang[i].sg_minstock+" </td>" +
                "<td>"; if(datagudang[i].sg_qty < datagudang[i].sg_minstock)
                row +=   "<i class='btn btn-warning fa fa-exclamation-triangle' aria-hidden='true'></i> Waning";
                    else
                row +=   "<i class='fa fa-check' aria-hidden='true'></i>" + 
                    
                 row +=  "</td>" +
                "<td>  <a class='btn btn-sm btn-info' href='url('pengeluaranbarang/createpengeluaranbarang')'> <i class='fa fa-plus'> </i> Buat SPPB </a> &nbsp; <a class='btn btn-sm btn-primary' href='url('suratpermintaanpembelian/createspp')'> <i class='fa fa-plus'> </i> Buat SPP</i> </a></td>" +
              "</tr>"
            

              tablegudang.rows.add($(html2)).draw(); 
              n++;
        }


      }
    })
  }
    

</script>
@endsection
