@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Kas </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Kas </strong>
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
                    <h5> Pelunasan Hutang / Pembayaran Kas
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true"  href="{{ url('pelunasanhutang/createpelunasanhutang')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
         
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                       <!--  <div class="form-group">
                            
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
                          </div> -->
                </div>        
                    
                <div class="box-body">
                
             

                  <table id="addColumn" class="table table-bordered  tbl-penerimabarang">
                
                     <tr>
                        <td style="width:10px" rowspan="2"> <b> NO </b> </td>
                        <td rowspan="2"> <b> No Bukti </b> </td>
                        <td rowspan="2"> <b> Tanggal </b> </td>
                        <td rowspan="2"> <b> Jenis Bayar </b> </td>
                        <td rowspan="2"> <b> Kepada </b> </td>
                        <td rowspan="2"> <b> Keterangan </b> </td>
                        <td  colspan="2"> <b> Posting / Jurnal </b> </td>
                        <td rowspan="2"> <b> Pembayaran Cash </b> </td>
                    </tr> 
                    
                     <tr>                    
                      <td> <b> Kas </b> </td>
                      <td> <b> Uang Muka </b> </td>
                      <td> </td>
                
                     </tr>

                  
                    <tr>
                    <td> 1 </td>
                    <td> BKK-001/AP/0107 </td>
                    <td> 04-01-2007 </td>
                    <td> Petty Cash </td>
                    <td> Cash Talkah </td>
                    <td> BBM dan TOLL Tgl 26 Des-01 Jan 2007 </td>
                    <td> Kas Kecil JPM Surabaya </td>
                    <td> - </td>
                    <td> <a class="btn btn-success text-right" href={{url('pelunasanhutang/detailpelunasanhutang')}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>  </td>
                    </tr>
              
                   
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
