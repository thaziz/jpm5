@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
    .cssright { text-align: right; }
    .details-control {
        background: url('{{ asset('assets/img/details_open.png') }}') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('{{ asset('assets/img/details_close.png') }}') no-repeat center center;
    }
   
    tr.shown td.details-control {
        background: url('{{ asset('assets/img/details_close.png') }}') no-repeat center center;
    }
</style>

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> DELIVERY ORDER PAKET </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Penjualan</a>
                        </li>
                        <li>
                            <a>Transaksi Penjualan</a>
                        </li>
                        <li class="active">
                            <strong> DO PAKET </strong>
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
                    <h5 style="margin : 8px 5px 0 0"> 
                          <!-- {{Session::get('comp_year')}} -->
                    </h5>

                    <div class="text-right" style="">
                       <button  type="button" style="margin-right :12px; width:110px" class="btn btn-success " id="btn_add_order" name="btnok"></i>Tambah Data</button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
                         

                          <form class="form-horizontal" id="cari_data">
                  <div class="box-body">
                    <table class="table datatable" border="0">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" >

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class="cari_semua date form-control date_to date_range_filter
                                              date" name="max" id="max"  >
                              </div> </td>
                      </tr>
                    
                      <tr>

                        
                           <th style="width: 100px; padding-top: 16px">Cabang</th>
                          <td colspan="1">
                            <select class="cari_semua chosen-select-width" id="cabang"  name="cabang">
                              <option></option>
                              @foreach ($cabang as $element)
                                <option value="{{ $element->kode }}">{{ $element->kode }} - {{ $element->nama }}</option>
                              @endforeach
                            </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td >
                          <select style="width: 200px; margin-top: 20px;" name="asal" class="cari_semua chosen-select-width select-picker1 form-control" data-show-subtext="true" data-live-search="true"  id="kota_asal">
                            <option value=""  selected=""> --Asal --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->id }}">{{ $asal->nama }}</option>
                            @endforeach
                          </select>
                          </td>

                        </tr>       
                        <tr>
                          

                          <th style="width: 100px; padding-top: 16px"> Pendapatan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="pendapatan" class="cari_semua select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Tipe --</option>
                            <option value="PAKET">PAKET</option>
                            <option value="KORAN">KORAN</option>
                            <option value="KARGO">KARGO</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tujuan" class="cari_semua select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="kota_tujuan" >
                            <option value=""  selected=""> --Tujuan --</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->id }}">{{ $tujuan->nama }}</option>
                            @endforeach
                           </select>
                          </td>

                           
                        </tr>
                        <tr >
                           <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="tipe" class="cari_semua select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Tipe --</option>
                            <option value="DOKUMEN">DOKUMEN</option>
                            <option value="KILOGRAM">KILOGRAM</option>
                            <option value="KOLI">KOLI</option>
                            <option value="SEPEDA">SEPEDA</option>
                           </select>
                          </td>
                        
                        <th style="width: 100px; padding-top: 16px"> Status </th>
                          <td colspan="3"> 
                           <select style="width: 200px; margin-top: 20px;" name="status" class="cari_semua select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" id="status"  >
                            <option value=""  selected=""> --Status --</option>
                            <option value="MANIFESTED">MANIFESTED</option>
                            <option value="TRANSIT">TRANSIT</option>
                            <option value="RECEIVED">RECEIVED</option>
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="DELIVERED OK">DELIVERED OK</option>
                           </select>
                          </td>

                          
                        </tr>
                        <tr>
                          <th style="width: 100px; padding-top: 16px"> Jenis </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="jenis" class="select-picker4 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="REGULER">REGULER</option>
                            <option value="EXPRESS">EXPRESS</option>
                            <option value="OUTLET">OUTLET</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Customer </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" name="customer" class="cari_semua customer chosen-select-width form-control" data-show-subtext="true" data-live-search="true" >
                            <option value=""  selected=""> --Customer --</option>
                            @foreach ($customer as $e)
                                <option value="{{ $e->kode }}">{{ $e->kode }} - {{ $e->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                          
                        </tr>
                        <tr>
                                                    
                        </tr>
                        <tr>
                          <th style="width: 100px; padding-top: 16px"> Nomor </th>
                          <td > 
                           <input type="text" name="do_nomor" class="form-control">
                          </td>
                        </tr>
                       

                      <br>
                      </table>
                      
                     
                      <div class="row" style="margin-top: 20px;margin-bottom: 10px;"> &nbsp; &nbsp; <a class="btn btn-primary" onclick="cari()"> <i class="fa fa-search" aria-hidden="true"></i> Cari </a> </div>
                    
                </form>

            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">
                    <div id="replace">
                    <table id="addColumn" class="table table-bordered table-striped" cellspacing="10">
                        <thead>
                            <tr>
                                <th> No DO</th>
                                <th> Tanggal </th>
                                <th> Customer </th>
                                <th> Pengirim </th>
                                <th> Penerima </th>
                                <th> Kota Asal </th>
                                <th> Kota Tujuan </th>
                                <th> Status </th>
                                <th> Detail </th>
                                <th hidden=""> Jenis </th>
                                <th hidden=""> Cabang </th>
                                <th hidden=""> Tarif </th>
                                <th hidden=""> Total Net </th>
                                <th hidden="" style="width:110px"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                    
                        </tbody> 
                    </table>
                    </div>
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
    
      function format ( d ) {
      return  '<table class="table">'+
                '<tr>'+
                    '<td>type_kiriman</td>'+
                    '<td>:</td>'+
                    '<td>'+d.type_kiriman+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>jenis_pengiriman</td>'+
                    '<td>:</td>'+
                    '<td>'+d.jenis_pengiriman+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>cab</td>'+
                    '<td>:</td>'+
                    '<td>'+d.cab+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>DPP</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_dpp+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Vendor</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_vendo+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>total_net</td>'+
                    '<td>:</td>'+
                    '<td>'+d.total_net+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>button</td>'+
                    '<td>:</td>'+
                    '<td>'+d.button+'</td>'+
                '</tr>'+
            '</table>'
              ;
      }
 
      var table =  $('#addColumn').DataTable({
            processing: true,

            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_deliveryorder_paket') }}',
            },
            "columns": [
            { "data": "nomor" },
            { "data": "tanggal" },
            { "data": "cus" },
            { "data": "nama_pengirim" },
            { "data": "nama_penerima" },
            { "data": "asal" },
            { "data": "tujuan" },
            { "data": "status" },
            {
                "class": "details-control",
                "orderable": false,
                "data": null,
                "defaultContent": "",
            },
            ]
      });
    
     var detailRows = [];

       $('#addColumn tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    table.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );



    $(document).on("click","#btn_add_order",function(){
        window.location.assign('{{ route('create_deliveryorder_paket') }}');
    });

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    function tambahdata() {
        window.location.href = baseUrl + '/data-master/master-akun/create'
    }
    function hapusData(id) {
alert('ac');
return false;
        $.ajax({
            url: baseUrl + '/data-master/master-akun/delete/' + id,
            type: 'get',
            dataType: 'text',
            //headers: {'X-XSRF-TOKEN': $_token},
            success: function (response) {
                if (response == 'sukses') {
                    $('.alertBody').html('<div class="alert alert-success">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Berhasil Di Hapus' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                    $("#hapus" + id).remove();
                } else if (response == 'gagal') {
                    $('.alertBody').html('<div class="alert alert-danger">' +
                            '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' +
                            'Data Akun Sudah Digunakan' +
                            '</div>');
                    $('.alertBody').show();
                    $('.alertBody').delay(4000).slideUp(300);
                }

            }
        });
    }

    $(document).on( "click",".btnhapus", function(){
        if(!confirm("Hapus Data ?")) return false;
    });

     $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
            $("#min").datepicker({format:"dd/mm/yyyy"});
            $("#max").datepicker({format:"dd/mm/yyyy"});

       function tgl(){
         var tgl1   = $("#min").val();
         var tgl2   = $("#max").val();
          if(tgl1 != "" && tgl2 != ""){
          }

            $(document).ready(function(){
        $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
            var min = $('#min').datepicker("getDate");
            // console.log(min);
            var max = $('#max').datepicker("getDate");
            // console.log(max);

            var startDate = new Date(data[1]);
            // console.log(startDate);

            if (min == null || min == '' && max == null || max == '') { return true; }

            if (startDate >= min && startDate <= max) { return true; }

            if (min == null || min == '' || min == 'Invalid Date' && startDate <= max) { return true;}
            
            if (max == null || max == '' || max == 'Invalid Date' && startDate >= min) { return true;}
            
            // if (startDate == min && startDate == max) { return true; }
            return false;
        }
        );
            $("#min").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
            $("#max").datepicker({ onSelect: function () { table.draw(); }, changeMonth: true, changeYear: true });
           

            // Event listener to the two range filtering inputs to redraw on input
            $('#min, #max').change(function () {
                /*if($('#max').val() == '' || $('#max').val() == null ){
                    $('#max').val(0);
                }*/
                table.draw();
            });
        });
          }
   
 
    $(document).ready(function() {
        $('.tbl-item').DataTable();
     
        $('input.global_filter').on( 'keyup click', function () {
            filterGlobal();
        } );
     
        $('input.column_filter').on( 'keyup click', function () {
            filterColumn( $(this).parents('tr').attr('data-column') );
        } );
    } );

    function filterColumn () {
    $('#addColumn').DataTable().column(5).search(
        $('.select-picker1').val()).draw();    
    }
    function filterColumn1 () {
        $('#addColumn').DataTable().column(6).search(
            $('.select-picker2').val()).draw();    
    }
    function filterColumn2 () {
        $('#addColumn').DataTable().column(8).search(
            $('.select-picker3').val()).draw(); 
     }
     function filterColumn3 () {
        $('#addColumn').DataTable().column(9).search(
            $('.select-picker4').val()).draw(); 
     }
     function filterColumn4 () {
        $('#addColumn').DataTable().column(7).search(
            $('.select-picker5').val()).draw(); 
     }
      function filterColumn5 () {
        $('#addColumn').DataTable().column(10).search(
            $('.select-picker6').val()).draw(); 
     }
     $('#nama_pengirim').on( 'keyup', function () {
         table.column(3).search( this.value ).draw();
      });  
     $('#nama_penerima').on( 'keyup', function () {
        table.column(4).search( this.value ).draw();
      });  

      function cari(){
      var min = $('#min').val();
      var max = $('#max').val();
     
      if (min == '') {
                toastr.warning("Pilih Tanggal Terlebih Dahulu", "Peringatan!")
                return false;
       }
      if (max == '') {
              toastr.warning("Pilih Tanggal Terlebih Dahulu", "Peringatan!")
              return false;
      }
              $.ajax({
                  data: $('#cari_data').serialize(),
                  url: baseUrl + '/ajaxcarideliveryorder_total/ajaxcarideliveryorder_total',
                  type: "get",
                  success: function (response, textStatus, request) {
                    $('#replace').html(response);
                    
                  },
                  error: function (ajaxContext) {
                    toastr.error('Export error: '+ajaxContext.responseText);
                  },
                  
              });
        }
    


</script>
@endsection
