@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pelunasan Hutang / Pembayaran Bank </h2>
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
                            <strong> Pelunasan Hutang / Pembayaran Bank </strong>
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
                    <h5> Pelunasan Hutang / Pembayaran Bank
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('pelunasanhutangbank/createpelunasanbank')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
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
                  <table id="addColumn" class="table table-bordered table-stripped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:10px">  NO  </th>
                        <th>  No Bank </th>
                        <th>  Bank  </th>
                        <th> Tanggal </th>
                        <th> Keterangan </th>
                        <th> Cek / BG </th>
                        <th> Biaya </th>
                        <th> Total </th>
                        <th> Detail </th>
                    </tr> 
                    </thead>

                    <tbody>
                    @foreach($data['bbk'] as $index=>$bbk)
                      <tr>
                        <td> {{$index + 1}} </td>
                        <td> {{$bbk->bbk_nota}} </td>
                        <td> {{$bbk->mb_nama}} </td>
                        <td> {{ Carbon\Carbon::parse($bbk->bbk_tgl)->format('d-M-Y ') }}</td>
                        <td> {{$bbk->bbk_keterangan}} </td>
                        <td> {{$bbk->bbk_cekbg}} </td>
                        <td> {{$bbk->bbk_biaya}}  </td>
                        <td> {{$bbk->bbk_total}} </td>
                        <td> <a class="btn btn-sm btn-info text-right" href={{url('pelunasanhutangbank/detailpelunasanbank/'.$bbk->bbk_id.'')}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a>  </td>
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

  
  
    

</script>
@endsection
