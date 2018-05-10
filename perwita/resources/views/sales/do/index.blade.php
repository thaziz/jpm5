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
                            <table class="table  datatable ">
                         <tr>
                        <td> Dimulai : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                              date" onchange="tgl()">

                              </div> </td>  <td> Diakhiri : </td> <td> <div class="input-group">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                          <input type="text" class=" date form-control date_to date_range_filter
                                              date" name="max" id="max" onchange="tgl()" >
                              </div> </td>
                      </tr>
                       <tr>
                          <th style="width: 100px; padding-top: 16px"> Cabang </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker6 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn5()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            @foreach ($cabang as $cabang)
                                <option value="{{ $cabang->nama }}">{{ $cabang->kode }} - {{ $cabang->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                          
                           <th style="width: 100px; padding-top: 16px"> Tipe </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker3 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn2()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="DOKUMEN">DOKUMEN</option>
                            <option value="KILOGRAM">KILOGRAM</option>
                            <option value="KOLI">KOLI</option>
                            <option value="SEPEDA">SEPEDA</option>
                           </select>
                          </td>
                        
                           
                        </tr>
                       <tr>
                        <th> Nama Pengirim : </th> 
                          <td> 
                                <input id="nama_pengirim" type="text" class="form-control ">
                          </td>  
                          <th> Nama Penerima : </th> 
                            <td> 
                                <input id="nama_penerima" type="text" class="form-control" >
                            </td>
                      </tr>

                        <tr >
                           <th style="width: 100px; padding-top: 16px"> Kota Asal  </th>
                          <td >
                          <select style="width: 200px; margin-top: 20px;" class="select-picker1 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            @foreach ($kota1 as $asal)
                                <option value="{{ $asal->nama }}">{{ $asal->nama }}</option>
                            @endforeach
                          </select>
                          </td>
                        
                          <th style="width: 100px; padding-top: 16px"> Kota Tujuan </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker2 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn1()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            @foreach ($kota as $tujuan)
                                <option value="{{ $tujuan->nama }}">{{ $tujuan->nama }}</option>
                            @endforeach
                           </select>
                          </td>
                        </tr>

                        <tr>

                           <th style="width: 100px; padding-top: 16px"> Status </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker5 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn4()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="MANIFESTED">MANIFESTED</option>
                            <option value="TRANSIT">TRANSIT</option>
                            <option value="RECEIVED">RECEIVED</option>
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="DELIVERED OK">DELIVERED OK</option>
                           </select>
                          </td>

                          <th style="width: 100px; padding-top: 16px"> Jenis </th>
                          <td > 
                           <select style="width: 200px; margin-top: 20px;" class="select-picker4 chosen-select-width form-control" data-show-subtext="true" data-live-search="true" onchange="filterColumn3()">
                            <option value="" disabled="" selected=""> --Pilih --</option>
                            <option value="REGULER">REGULER</option>
                            <option value="EXPRESS">EXPRESS</option>
                            <option value="OUTLET">OUTLET</option>
                           </select>
                          </td>
                        </tr>
                      </table>
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                <div class="box-body">
                    
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
                       {{--  
                            @foreach ($do as $row)
                            <tr>
                                <td>{{ $row->nomor }}</td>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->cus }}</td>
                                <td>{{ $row->nama_pengirim }}</td>
                                <td>{{ $row->nama_penerima }}</td>
                                <td>{{ $row->asal }}</td>
                                <td>{{ $row->tujuan }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->type_kiriman }}</td>
                                <td>{{ $row->jenis_pengiriman }}</td>
                                <td>{{ $row->cab }}</td>
                                <td>{{ $row->total }}</td>
                                <td>{{ $row->total_net }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('sales/deliveryorderform/'.$row->nomor.'/edit') }}" data-toggle="tooltip" title="Edit" class="btn btn-warning btn-xs btnedit"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ url('sales/deliveryorderform/'.$row->nomor.'/nota') }}" target="_blank" data-toggle="tooltip" title="Print" class="btn btn-warning btn-xs btnedit"><i class="fa fa-print"></i></a>
                                        <a href="{{ url('sales/deliveryorderform/'.$row->nomor.'/update_status') }}" data-toggle="tooltip" title="Update Status" class="btn btn-warning btn-xs btnedit"><i class="fa fa-cog"></i></a>
                                        <a href="{{ url('sales/deliveryorderform/'.$row->nomor.'/hapus_data') }}" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger btnhapus"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        --}}
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
                    '<td>'+d.total+'</td>'+
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
                url:'{{ route('tabledata_detail') }}',
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

            // { "data": "type_kiriman" },
            // { "data": "jenis_pengiriman" },
            // { "data": "cab" },
            // { "data": "total", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            // { "data": "total_net", render: $.fn.dataTable.render.number( '.'),"sClass": "cssright" },
            // { "data": "button" },
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
        window.location.href = baseUrl + '/sales/deliveryorderform'
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


</script>
@endsection
