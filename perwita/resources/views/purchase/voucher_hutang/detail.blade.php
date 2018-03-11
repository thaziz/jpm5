@extends('main')

@section('title', 'dashboard')

@section('content')

        <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Uang Muka Pembelian </h2>
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
                            <strong> Detail Voucher Hutang  </strong>
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
                    <h5> Detail Voucher Hutang
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
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
                      <div class="col-xs-6">
                           <table border="0">
                          <tr>
                            <td width="150px">No Bukti</td>
                            <td>@if ($a == '') &nbsp; @else {{$a}} @endif</td>
                          </tr>

                          <tr>
                            <td>&nbsp;</td>
                          </tr>

                          <tr>
                            <td>Tanggal</td>
                            <td>@if ($b == '') &nbsp; @else {{ \Carbon\Carbon::parse($b)->format('d F Y')}} @endif</td>
                          </tr>

                           <tr>
                            <td>&nbsp;</td>
                          </tr>

                          <tr>
                            <td> Supplier </td>
                            <td>{{$c}} / {{$f}}</td>
                            </td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td>Keterangan</td>
                            <td>@if ($d == '') &nbsp; @else {{$d}} @endif</td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                          <tr>
                            <td>Jatuh Tempo</td>
                            <td>@if ($b == '') &nbsp; @else {{ \Carbon\Carbon::parse($e)->format('d F Y')}} @endif</td>
                          </tr>

                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                           <tr>
                            <td>Total</td>
                            <td>Rp.{{number_format($g,0,",",".")}},00</td>
                          </tr>
                          <tr>
                            <td> &nbsp; </td>
                          </tr>

                        
                          </table>
                      </div>
                      </div>
                      <hr>
                      <h4> Detail Daftar Voucher Hutang </h4>
                   <br>

                   <div class="box-body">
                    <div class="table-responsive">
                      <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:80px;text-align: center;">No. Urut</th>
                        <th> Account Biaya </th>
                        <th> Keterangan </th>
                        <th> Nominal </th>
                    </tr>
                    </thead>
                    @foreach($data as $index => $a)
                    <tbody>
                      <tr>
                        <td style="text-align: center;"> {{$index+1}} </td>
                        <td> {{$a->vd_acc}}  </td>
                        <td> {{$a->vd_keterangan}} </td>
                        <td>Rp.{{number_format($a->vd_nominal,0,",",".")}},00</td>
                      </tr>
                    </tbody>
                    @endforeach
                   
                  </table>
                      </div>
                   </div>
                   
  

                <div class="box-footer">
                  <div class="pull-right">
                    <a class="btn btn-warning" href={{url('voucherhutang/voucherhutang')}}> Kembali </a>      
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
     $("#addColumn").append('<tr id=item-'+$no+'> <td> <b>' + $no +' </b> </td>' + 
      /* brg*/       '<td> <select class="form-control"> <option value=""> Brg A </option> <option value=""> Brg B </option> </select> </td>' + 
      /* qty*/       '<td> <input type="text" class="form-control"> </td>' +
      /* gudang  */  '<td> <input type="text" class="form-control"> </td>' +
      /* harga */    '<td> <input type="text" class="form-control"> </td>'  +
      /* amount*/    '<td> <input type="text" class="form-control">  </td>' +
      /* stok */     '<td> <select class="form-control"> <option value=""> ya </option> <option value=""> tidak </option></select></td>'  +
      /* biaya */   '<td> <input type"text" class="form-control">  </td>' +
      /* ppn */     '<td> <input type="text" class="form-control"> </td>' +
      /* netto */   '<td> <input type="text" class="form-control"> </td>' +
      /* account */ '<td> <select class="form-control"> <option value=""> A </option> <option value="B"> B </option></select></td>' +
      /* keterangan */  '<td> <input type="text" class="form-control"> </td>' +

                   '<td><a class="btn btn-danger removes-btn" data-id='+ $no +'> <i class="fa fa-trash"> </i>  </a> </td>' +
                
      '</tr>');+ 




        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#item-'+id);

             parent.remove();
          })


    })

    
  
   

</script>
@endsection
