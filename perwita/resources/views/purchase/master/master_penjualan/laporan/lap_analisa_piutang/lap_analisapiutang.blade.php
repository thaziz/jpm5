@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .br{
    border:none;
  }
  th{
        text-align: center !important;
      }

  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .dataTables_filter, .dataTables_info { display: none; }
    .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
  .btn-special{
    background-color: #6d2db3;
    border-color: #6d2db3;
    color: #FFFFFF;
  }
  #addColumn{
    font-size: 10px;
  }
</style>
  <meta name="csrf-token" content="{{ csrf_token() }}" /> 

<div class="return">
  {{ csrf_field() }}

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Laporan Tarif Dokumen
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="col-xs-12">

                 
                 <form class="form-horizontal" id="search" action="post" method="POST">
                  <div class="box-body">
                    <table class="table datatable ">
                        <tr>
                        <td> Dimulai : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                date" value="{{ carbon\carbon::now()->subDay(30)->format('Y-m-d') }}">
                          </div> 
                        </td>  
                        <td> Diakhiri : </td> 
                        <td> 
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="text" class=" date form-control date_to date_range_filter
                                date" name="max" id="max" value="{{ carbon\carbon::now()->format('Y-m-d') }}">
                          </div> 
                        </td>
                      </tr>
                      <tr>
                        <td>Customer</td>
                        <td>
                          <select class="chosen-select-width" name="customer" id="customer">
                            <option value="">- Pilih -</option>
                            @foreach ($customer as $e)
                              <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                      
                        <td>Cabang</td>
                        <td>
                          <select class="chosen-select-width" name="cabang" id="cabang">
                            <option value="">- Pilih -</option>
                            @foreach ($cabang as $cab)
                              <option value="{{ $cab->kode }}">{{ $cab->kode }} - {{ $cab->nama }}</option>
                            @endforeach
                          </select>
                        </td>
                      </tr>
                      <tr>  
                      <td>Laporan</td>
                        <td>
                          <select class="chosen-select-width" name="laporan" id="laporan">
                            <option value="">- Pilih -</option>
                            <option value="Rekap">Rekap </option>
                          </select>
                        </td>
                        <td>Acc Piutang</td>
                        <td>
                          <select class="chosen-select-width" name="akun" id="akun">
                            <option value="">- Harap Memilih Cabang Dahulu -</option>
                          </select>
                        </td>
                        
                      </tr>
                      <br>
                      </table>
                       <div class="row" style="margin-top: 20px;"> &nbsp; &nbsp; <a class="btn btn-special cetak" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 55px;"> &nbsp; &nbsp; <a class="btn btn-info cetak" onclick="pdf()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                      <div class="row" style="margin-top: -39px;margin-left: 136px;"> &nbsp; &nbsp; <a class="btn btn-warning cetak" onclick="excel()"> <i class="fa fa-print" aria-hidden="true"></i> Excel </a> </div>
                    </div>
                </form>

                </div>


            <div class="box-body">
              <br>
              <br>
              <br>
              <br>
              <div class="drop">
              
              </div><!-- /.box-body -->
              <div class="box-footer">
                  {{-- @include('purchase.master.master_penjualan.laporan.lap_analisa_piutang.ajax_analisapiutang_rekap') --}}
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
</div>

@endsection



@section('extra_scripts')
<script type="text/javascript">


      $('.date').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
      });

      $('#cabang').change(function(){
        $.ajax({
          data:$('#search').serialize(),
          type:'get',
          url: baseUrl + '/laporan_sales/analisa_piutang/piutang_dropdown',
          success : function(data){
            $('#akun').empty();
            for (var i = 0; i < data.piutang.length; i++) {
              $('#akun').append("<option value='"+data.piutang[i].id_akun+"'>"+data.piutang[i].id_akun+'-'+data.piutang[i].nama_akun+"</option>");
              $('#akun').chosen().trigger("chosen:updated");
            }
          }
        })
      })

      function cari(){
        var awal = $('#min').val();
        var akir = $('#max').val();
        var customer = $('#customer').val();
        var akun = $('#akun').val();
        var laporan = $('#laporan').val();

        if (laporan == 'Rekap') {

          $.ajax({
            data:$('#search').serialize(),
            type:'get',
            url: baseUrl + '/laporan_sales/analisa_piutang/ajax_lap_analisa_piutang',
            success : function(data){
              $('.drop').html(data);
              $('#container').hide();
            }
          })
        }else if (laporan == 'Rekap per Customer Detail') {
          alert('b');
        }else if (laporan == 'Rekap per akun') {

          alert('c');
        }else if (laporan == 'Rekap per akun Detail') {

        // alert('d');
        }
        
     }

  
</script>
@endsection
