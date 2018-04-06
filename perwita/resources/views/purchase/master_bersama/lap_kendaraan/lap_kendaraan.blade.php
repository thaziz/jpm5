@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
  .excel:before{
    content: "\f02f"; 
    font-family: FontAwesome;

  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Laporan Pelunasan Hutang / Pembayaran Kas </h2>
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
                
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    
                <div class="box-body">
  
                <div class="col-xs-12">
                
                  <table class="table table-bordered datatable table-striped">
                      <br>
                        <tr>                                                     
                        <th> Nama Peminta: </th> 
                          <td> 
                                <input id="peminta" type="text" class="form-control ">
                          </td>  
                          <th> Status : </th> 
                            <td> 
                                <input id="status" type="text" class="form-control" >
                            </td>
                      </tr>
                      <tr>                                                     
                        <th> Jenis Keluar : </th> 
                          <td colspan="4"> 
                                <input id="keluar" type="text" class="form-control ">
                          </td>  
                      </tr>
                      <tr>
                        <th> Dimulai : </th> 
                        <td>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input name="min" id="min" type="text" class=" date form-control date_to date_range_filter
                                date" onchange="tgl()">
                          </div> 
                        </td>  
                        <th> Diakhiri : </th> 
                        <td> 
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              <input type="text" class=" date form-control date_to date_range_filter
                                  date" name="max" id="max" onchange="tgl()" >
                          </div>
                        </td>
                      </tr>
                      <br>
                    
                    
                    </table>
                  <div class="row"> &nbsp; &nbsp; <a class="btn btn-info" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"></i> Cetak </a> </div>
                  <table id="addColumn" class="table table_header table-bordered table-striped"> 
                    <thead> 
                      <th  style="text-align: center"> No.</th>                      
                      <th  style="text-align: center"> kode.</th>                      
                      <th  style="text-align: center"> nopol</th>
                      <th  style="text-align: center"> Divisi </th>
                      <th  style="text-align: center"> Status </th>
                      <th  style="text-align: center"> vdrcde </th>
                      <th  style="text-align: center"> vdrnme </th>
                      <th  style="text-align: center"> Kode</th>
                      <th  style="text-align: center"> Merk </th>
                      <th  style="text-align: center"> Tipe Angkutan </th>
                      <th  style="text-align: center"> No Rangka </th>
                      <th  style="text-align: center"> No mesin </th>
                      <th  style="text-align: center"> jenis_bak </th>
                      <th  style="text-align: center"> P , L , T , Volume</th>
                      <th  style="text-align: center"> Tahun </th>
                      <th  style="text-align: center"> seri unit </th>
                      <th  style="text-align: center"> warna kabin </th>
                      <th  style="text-align: center"> No. Bpbk </th>
                      <th  style="text-align: center"> tgl Bpkb </th>
                      <th  style="text-align: center"> No. Kir </th>
                      <th  style="text-align: center"> Tgl kir </th>
                      <th  style="text-align: center"> Tgl Pajak </th>
                      <th  style="text-align: center"> Tgl Stnk </th>
                      <th  style="text-align: center"> Gps </th>
                      <th  style="text-align: center"> Posisi Bpkb </th>
                      <th  style="text-align: center"> Ket Bpkb </th>
                      <th  style="text-align: center"> Asuransi </th>
                      <th  style="text-align: center"> Harga Perolehan </th>
                      <th  style="text-align: center"> Tgl Perolehan </th>
                      <th  style="text-align: center"> Keterangan </th>
                      <th  style="text-align: center"> tgl pjk tahunan </th>
                      <th  style="text-align: center"> tgl pjk 5 thn </th>
                      <th  style="text-align: center"> Kode Subcon </th>
                    </tdead>
                    <tbody>
                    @foreach ($data as $index => $e)
                    <tr>
                      <td style="text-align: center"> {{ $index+1 }} </td>                      
                      <td style="text-align: center"> {{ $e->id }}</td>                      
                      <td style="text-align: center"> {{ $e->nopol }}</td>
                      <td style="text-align: center"> {{ $e->divisi }}</td>
                      <td style="text-align: center"> {{ $e->status }}</td>
                      <td style="text-align: center"> {{ $e->vdrcde }}</td>
                      <td style="text-align: center"> {{ $e->vdrnme }}</td>
                      <td style="text-align: center"> {{ $e->kode }}</td>
                      <td style="text-align: center"> {{ $e->merk }}</td>
                      <td style="text-align: center"> {{ $e->tipe_angkutan }}</td>
                      <td style="text-align: center"> {{ $e->no_rangka }}</td>
                      <td style="text-align: center"> {{ $e->no_mesin }}</td>
                      <td style="text-align: center"> {{ $e->jenis_bak }}</td>
                      <td style="text-align: center"> {{ $e->p }} , {{ $e->l }} , {{ $e->t }} , {{ $e->volume }}</td>
                      <td style="text-align: center"> {{ $e->tahun }}</td>
                      <td style="text-align: center"> {{ $e->seri_unit }}</td>
                      <td style="text-align: center"> {{ $e->warna_kabin }}</td>
                      <td style="text-align: center"> {{ $e->no_bpkb }}</td>
                      <td style="text-align: center"> {{ $e->tgl_bpkb }}</td>
                      <td style="text-align: center"> {{ $e->no_kir }}</td>
                      <td style="text-align: center"> {{ $e->tgl_kir }}</td>
                      <td style="text-align: center"> {{ $e->tgl_pajak }}</td>
                      <td style="text-align: center"> {{ $e->tgl_stnk }}</td>
                      <td style="text-align: center"> {{ $e->gps }}</td>
                      <td style="text-align: center"> {{ $e->posisi_bpkb }}</td>
                      <td style="text-align: center"> {{ $e->ket_bpkb }}</td>
                      <td style="text-align: center"> {{ $e->asuransi }}</td>
                      <td style="text-align: center"> {{ $e->harga }}</td>
                      <td style="text-align: center"> {{ $e->tgl_perolehan }}</td>
                      <td style="text-align: center"> {{ $e->keterangan }} </td>
                      <td style="text-align: center"> {{ $e->tgl_pajak_tahunan }}</td>
                      <td style="text-align: center"> {{ $e->tgl_pajak_5_tahunan }}</td>
                      <td style="text-align: center"> {{ $e->kode_subcon }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>
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



<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">

    var d = new Date();
    var a = d.getDate();
    var b = d.getSeconds();
    var c = d.getMilliseconds();
    var tgl1 = '1/1/2018';
    var tgl2 = '2/2/2018';

  var table = $('#addColumn').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
       dom: 'Bfrtip',
       buttons: [
          {
                extend: 'excel',
               /* messageTop: 'Hasil pencarian dari Nama : ',*/
                text: ' Excel',
                className:'excel',
                title:'LAPORAN PENERIMAAN BARANG',
                filename:'PENERIMAANBRG-'+a+b+c,
                init: function(api, node, config) {
                $(node).removeClass('btn-default'),
                $(node).addClass('btn-warning'),
                $(node).css({'margin-top': '-50px','margin-left': '80px'})
                },
                exportOptions: {
                modifier: {
                    page: 'all'
                }
            }
            
            }
        ]
  });

  function filterColumn ( ) {
    $('#addColumn').DataTable().column(6).search(
        $('#col0_filter').val()
    ).draw();    
} 

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

            var startDate = new Date(data[3]);
            // console.log(startDate);
            if (min == null || min == '' && max == null || max == '') { return true; }
            if (min == null || min == '' || min == 'Invalid Date' && startDate <= max) { return true;}
            if (max == null || max == '' || max == 'Invalid Date' && startDate >= min) {return true;}
            if (startDate <= max && startDate >= min) { return true; }
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
    
    $('#peminta').on( 'keyup', function () {
        table.column(5).search( this.value ).draw();
      });  
    $('#status').on( 'keyup', function () {
         table.column(6).search( this.value ).draw();
      });  
    $('#keluar').on( 'keyup', function () {
         table.column(7).search( this.value ).draw();
      });
    
 
 
   
    function cetak(){
    
     var asw=[];
       var asd = table.rows( { filter : 'applied'} ).data(); 
       for(var i = 0 ; i < asd.length; i++){

           asw[i] =  $(asd[i][0]).val();
  
       }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });


      $.ajax({
        data: {a:asw,c:'download'},
        url: baseUrl + '/reportpengeluaranbarang/reportpengeluaranbarang',
         type: "post",
       success : function(data){
        var win = window.open();
            win.document.write(data);
        }
      });
    }
   

</script>
@endsection
