@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Konfirmasi Pengeluaran Barang </h2>
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
                            <strong>Konfirmasi Pengeluaran Barang  </strong>
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
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                     
                </div>        
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th  style="width:10px; text-align: center;">No</th>
                        <th style="text-align: center;"> No BPPB </th>
                        <th style="text-align: center;"> Tanggal </th>
                        <th style="text-align: center;"> Keperluan  </th>
                        <th style="text-align: center;"> Status  </th>
                        <th style="text-align: center;"> Detail </th>
                      </tr>
                    </thead>
                    <tbody>  
                    @foreach($data as $i => $val )                  
                      <tr>
                        <td align="center">
                          {{$i+1}}
                          <input type="hidden" class="pb_id" value="{{$val->pb_id}}">
                        </td>
                        <td>{{$val->pb_nota}}</td>
                        <td>{{$val->pb_tgl}}</td>
                        <td>{{$val->pb_keperluan}}</td>
                        @if($val->pb_status == 'Approved')
                        <td align="center"><label class="label label-primary">Approved</label></td>
                        @else
                        <td align="center"><label class="label label-default">Released</label></td>
                        @endif
                        @if($val->pb_status != 'Approved')
                        <td align="center"> 
                          <a title="detail" class="btn btn-success btn-sm" href={{url('konfirmasipengeluaranbarang/detailkonfirmasipengeluaranbarang')}}/{{$val->pb_id}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>

                           
                        </td>
                      </tr>
                      @else
                      <td align="center"> 
                          <a class="btn btn-success btn-sm" onclick="printing(this)" )}}/{{$val->pb_id}}><i class="fa fa-print" aria-hidden="true"></i> {{-- </a>
                            <a onclick="lihatjurnal('{{$val->pb_nota}}','PENGELUARAN BARANG GUDANG')" class="btn-xs btn-primary" aria-hidden="true"> lihat jurnal </a> --}}

                      </td>
                      @endif


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
<div id="jurnal" class="modal" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h5 class="modal-title">Laporan Jurnal</h5>
                        <h4 class="modal-title">No Faktur:  <u>{{$data['faktur'][0]->fp_nofaktur or null }}</u> </h4>
                        
                      </div>
                      <div class="modal-body" style="padding: 15px 20px 15px 20px">   
                          <table id="table_jurnal" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th> ID Akun </th>
                                            <th> Akun</th>
                                            <th> Debit</th>
                                            <th> Kredit</th>
                                            <th style="width:100px"> Uraian / Detail </th>                                         
                                        </tr>
                                    </thead>
                                    
                                </table>                            
                          </div>                          
                    </div>
                  </div>
                </div>

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
    

function printing(par){
  var par = $(par).parents('tr')
  var id = $(par).find('.pb_id').val();
  window.open("{{url('konfirmasipengeluaranbarang/printing')}}"+'/'+id)
}


function lihatjurnal($ref,$note){
          nota = $ref;
          detail = $note;

          $.ajax({
          url:baseUrl +'/fakturpembelian/jurnalumum',
          type:'get',
          data:{nota,detail},
          dataType : "json",
          success:function(response){
                $('#jurnal').modal('show');
                hasilpph = $('.hasilpph_po').val();
                hasilppn = $('.hasilppn_po').val();

             $('.loading').css('display', 'none');
                $('.listjurnal').empty();
                $totalDebit=0;
                $totalKredit=0;
                        console.log(response);
                    
                        for(key = 0; key < response.countjurnal; key++) {
                           
                          var rowtampil2 = "<tr class='listjurnal'>" +
                          "<td> "+response.jurnal[key].id_akun+"</td>" +
                          "<td> "+response.jurnal[key].nama_akun+"</td>";

                          
                            if(response.jurnal[key].dk == 'D'){
                              $totalDebit = parseFloat($totalDebit) + parseFloat(Math.abs(response.jurnal[key].jrdt_value));
                              rowtampil2 += "<td>"+accounting.formatMoney(Math.abs(response.jurnal[key].jrdt_value), "", 2, ",",'.')+"</td> <td> </td>";
                            }
                            else {
                              $totalKredit = parseFloat($totalKredit) + parseFloat(response.jurnal[key].jrdt_value);
                              rowtampil2 += "<td> </td><td>"+accounting.formatMoney(response.jurnal[key].jrdt_value, "", 2, ",",'.')+"</td>";
                            }
                          

                            rowtampil2 += "<td>"+response.jurnal[key].jrdt_detail+"</td>";
                            $('#table_jurnal').append(rowtampil2);
                        }
                     var rowtampil1 = "</tbody>" +
                      "<tfoot>" +
                          "<tr class='listjurnal'> " +
                                  "<th colspan='2'>Total</th>" +                        
                                  "<th>"+accounting.formatMoney($totalDebit, "", 2, ",",'.')+"</th>" +
                                  "<th>"+accounting.formatMoney($totalKredit,"",2,',','.')+"</th>" +
                                  "<th>&nbsp</th>" +
                          "<tr>" +
                      "</tfoot>";
                                     
                   
                      $('#table_jurnal').append(rowtampil1);
              }
        });
   }
</script>
@endsection
