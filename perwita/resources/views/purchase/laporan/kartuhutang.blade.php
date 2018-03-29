@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Kartu Hutang </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Laporan Purchase </a>
                        </li>
                        <li class="active">
                            <strong> Kartu Hutang </strong>
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
                
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
                
                <div class="row">
                <a id="totop" href="#" class="pull-right" style="margin-right: 20px;color: grey;" title="SCROLL KE BAWAH"><i class="fa-2x fa fa-arrow-circle-down"></i></a>

                  <h3 style="text-align: center"> PT JAWA PRATAMA MANDIRI  <br> Laporan Register Rekap Kartu Hutang <br>
                  {{-- Periode : July - 2017 --}}
                </h3>
                <div class="col-xs-6">
                   Dimulai :<div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                              date" >

                              </div>  
                      
                      
            
                </div>
                <div class="col-xs-6">
                   Diakhiri :  <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class=" date form-control date_to date_range_filter
                                              date" name="max" id="max" >
                              </div>
                </div>
                
               

                <div class="col-xs-12">
                  <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-success" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> cari </a> </div>
                
                <div class="row pull-right " style="margin-top: -40px;    margin-right: 84px;"> &nbsp; &nbsp; <a class="btn btn-warning" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>

                <div class="row pull-right" style="margin-top: -40px;    margin-right: 2px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>

                  <br>
                  <div class="hiddening">
            <table id="addColumn" class="table table-bordered table-striped tbl-item" width="100%">
                    <thead>
                     <tr>
                        <th style="text-align:center;height: 30px;" width= '3%'> No  </th>
                        <th style="text-align:center" width="22%"> No Faktur  </th>
                        <th style="text-align:center" width="12%"> Tanggal  </th>
                        <th style="text-align:center" width="28%"> Keterangan  </th>
                        <th style="text-align:center" width="12%"> DPP  </th>
                        <th style="text-align:center" width="12%"> netto </th>
                        <th style="text-align:center" width="12%"> netto </th>
                    </tr>
                   
                    </thead>
                    <tbody>
                      @foreach ($data as $index => $a)               
                    <tr align="center">
                      <td> {{ $index+1 }}  </td>
                      <td> {{ $a->fp_nofaktur }}  </td>
                      <td> {{ $a->fp_tgl }} </td>
                      <td> {{ $a->fp_keterangan}} </td>
                      <td style="text-align: right"> {{ number_format($a->fp_dpp,0,',','.') }} </td>
                      <td style="text-align: right"> {{ number_format($a->fp_netto,0,',','.') }}</td>
                      <td style="text-align: right"> {{ number_format($a->fp_netto,0,',','.') }} </td>
                    </tr>
                     @endforeach
                     <tr style="border-top: none;">
                      <td align="right" colspan="4">Total :</td>
                      <td align="right">{{ number_format($debet,0,',','.') }}</td>
                      <td align="right">{{ number_format($kredit,0,',','.') }}</td>
                      <td align="right">{{ number_format($saldo,0,',','.') }}</td>
                    </tr>
                    
                
                    </tbody>
                   
                  </table>
                  </div>
                    <div id="anjay" class="col-md-12"></div>
     
                  </div>
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
</div>



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">
  function cari(){
      lol = $('#min').val();
       lolol = $('#max').val();
$.ajax({
   url : baseUrl + '/kartuhutangajax/kartuhutangajax',
   type:'get',
   data:{xox:lol,xoxx:lolol},
   success:function(data){
      $('.hiddening').css('display','none')
      $('#anjay').html(data)
   }

});
}

   $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
         
      function cetak(){
       x = $('#min').val();
       x1 = $('#max').val();



      $.ajax({
        data: {a:x,b:x1,c:'download'/*,d:z,e:z1,f:z2*/},
        url: baseUrl + '/reportkartuhutang/reportkartuhutang',
        type: "get",
         complete : function(){
        window.open(this.url,'_blank');
        },     
        success : function(data){
        // window.open(this.data,'_blank');  
        }
      });
    }
    function excel(){
       x = $('#min').val();
       x1 = $('#max').val();



      $.ajax({
        data: {a:x,b:x1,c:'download'/*,d:z,e:z1,f:z2*/},
        url: baseUrl + '/reportexcelkartuhutang/reportexcelkartuhutang',
        type: "get",
         complete : function(){
        window.open(this.url,'_blank');
        },     
        success : function(data){
        // window.open(this.data,'_blank');  
        }
      });
    }
   $('#totop').click(function(){
    var body = $("html, body");
    body.animate({scrollTop:$(document).height()}, 'fast');
    return false;
   })

</script>
@endsection




    {{-- <tr>
                      <td colspan="4" style="text-align: center"> Total </td>
                       <td style="text-align: right"> Rp 36.015.000,00 </td>
                       <td> 0 </td>
                        <td style="text-align: right"> Rp 36.015.000,00 </td>
                    </tr>
                    
                    <tr>
                        <td colspan="4" style="text-align: center"> Grand Total </td>
                          <td style="text-align: right"> Rp 36.015.000,00 </td>
                          <td> 0 </td>
                          <td> </td>
                    </tr> --}}
