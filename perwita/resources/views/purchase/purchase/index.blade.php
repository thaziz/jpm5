@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Pembelian Order </h2>
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
                            <strong> Pembelian Order </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

        <br>
   <div class="wrapper wrapper-content animated fadeInRight">
   
   <!--  <div class="col-md-2">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['countspp']}} SPP </b></h2> <h4 style='text-align:center'> BELUM DI PROSES PO </h4>
      </div>
    </div>   
  </div> -->
  <div id="notif"></div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Pembelian Order
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     @if(Auth::user()->punyaAkses('Purchase Order','tambah'))
                    <div class="text-right">
                        <a class="btn btn-success" href="{{url('purchaseorder/createpurchase')}}"> <i class="fa fa-plus"> </i> Buat PO </a>
                    </div>
                    @endif
                </div>
                <div class="ibox-content">



<div class="row" >
   <form method="post" id="dataSeach">
      <div class="col-md-12 col-sm-12 col-xs-12">
              
               <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">No PO</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                    <input class="form-control kosong" type="text" name="nofpg" id="nofpg" placeholder="No PO">
                </div>
              </div>


            
              <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal</label>
              </div>

              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                  <div class="input-daterange input-group">
                    <input id="tanggal1" class="form-control input-sm datepicker2 kosong" name="tanggal1" type="text">
                    <span class="input-group-addon">-</span>
                    <input id="tanggal2" "="" class="input-sm form-control datepicker2 kosong" name="tanggal2" type="text">
                  </div>
                </div>
              </div>
            

              <div class="col-md-2 col-sm-6 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat" title="Cari rentang tanggal" type="button" onclick="cari()">
                  <strong>
                    <i class="fa fa-search" aria-hidden="true"></i>
                  </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" title="Reset" onclick="resetData()">
                  <strong>
                    <i class="fa fa-undo" aria-hidden="true"></i>
                  </strong>
                </button>                
              </div>
      </div>



      <div class="col-md-12 col-sm-12 col-xs-12">
             


           



              <div class="col-md-1 col-sm-3 col-xs-12">
                <label class="tebal">Supplier</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">

                     <select class="form-control chosen-select-width kosong" name="nosupplier" id="nosupplier">
                     <option value="">Pilih Supplier</option>
                      @foreach($data['supplier'] as $supplier)
                      <option value="{{$supplier->idsup}}">{{$supplier->no_supplier}} - {{$supplier->nama_supplier}}</option>
                      @endForeach
                    </select>
                </div>
              </div>


                 <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Total Biaya</label>
              </div>

              <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="form-group">
                <input type="" name="total" class="form-control kosong" id="total">                    
                </div>
              </div>


    </div>

    </form>
</div>








                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
              
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                    </div>
                   
                    
                <div class="box-body">
                
                  <table width="100%" id="addColumn" class="table table-bordered table-striped tbl-purchase">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> No PO </th>
                        <th> Tanggal </th>
                        <th> Cabang </th>                  
                        <th> Supplier </th>
                        <th> Total Biaya </th>
                        <th> Tipe PO </th>
                        <th> Proses Keuangan </th>
                      
                    </tr>
                  

                    </thead>
                    
                 
                   
                  </table>
                </div><!-- /.box-body -->

                <!-- CREATE MODAL -->
              <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                <div class="modal-content">
                  <div class="modal-header">
                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                    <h4 class="modal-title" style="text-align: center;"> DATA PO </h4>     
                  </div>
                                
                  <div class="modal-body"> 
                      <div class="datakeuangan"> </div> 
                      <br>
                      <div class="col-sm-6">
                        <table class="table table-striped" id="tablepo">
                          
                          <tr>
                            <th style="width:50px"> <a  style="color:#919090"> No PO </a> </th>  
                            <th style="width:100px"> <div class="nopo"> </div></th>                       
                          </tr>
                          <tr>
                            <th>  <a  style="color:#919090"> Supplier </a> </th>
                            <th> <div class="supplier"> </div> </th>
                          </tr>
                          <tr>
                            <th> <a  style="color:#919090"> Jangka Waktu Pembayaran </a> </th>
                            <th> <div class="bayar"> </div> </th>
                          </tr>
                          <tr>
                            <th> <a  style="color:#919090"> Catatan </a> </th>
                            <th> <div class="catatan"> </div></th>
                          </tr>
                         
                        </table>
                      </div>

                      <div class="col-sm-6">
                        <table class="table table-striped" id="subtotal">
                          <tr>
                            <th> <a  style="color:#919090"> Sub Total </a> </th>
                            <th> <div class="subtotal"> </div></th>
                          </tr>
                          <tr>
                            <th> <a  style="color:#919090"> Diskon </a> </th>
                            <th> <div class="diskon"></div></th>
                          </tr>
                          <tr>
                            <th> <a  style="color:#919090"> Ppn  </a></th>
                            <th> <div class="ppn"> </div></th>
                          </tr>
                          <tr>
                            <th> <a  style="color:#919090"> Total </a></th>
                            <th> <div class="total"> </div> </th>
                          </tr>
                        </table>
                      </div>                      
                    
                      <div class="data-spp"> </div>
                      <!-- <div class="hell"> </div>
 -->
                      <div class="col-sm-12">
                      <h4> Pihak Keuangan : </h4>
                        <table>
                          <tr>
                            <td>
                              <div class="checkbox checkbox-danger checkbox-circle">
                              <input class="checkbox7" type="checkbox"  value="DITOLAK">
                              <label for="checkbox7">
                                  Di tolak
                              </label>
                            </div> 
                          </td>
                          <td> &nbsp; </td>
                          <td>
                           <div class="checkbox checkbox-info checkbox-circle">
                            <input class="checkbox7" type="checkbox"  value="DISETUJUI">
                            <label for="checkbox7">
                                Di Setujui
                            </label>
                          </div>
                          </td>
                          <td> &nbsp; </td>
                          <td>
                            <div class="checkbox checkbox-warning checkbox-circle">
                            <input class="checkbox7" type="checkbox"  value="DIREVISI">
                            <label for="checkbox7">
                                Di Revisi
                            </label>
                          </div>
                          </td>
                          </tr>
                        </table>
                      
                       
                         <textarea rows="4" cols="100" name="keterangan" required="" class="keterangankeuangan">                    
                        </textarea>
                        
                          <input type="hidden" class='textsetuju'>


                      <br>
                      </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="buttongetid">Simpan</button>
                       
                    </div>
                </div>
              </div>
           </div> 
           </div>

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

  
$('#total').maskMoney({thousands:',', decimal:'.', precision:0});
 var tablex;
setTimeout(function () {            
   table();
   tablex.on('draw.dt', function () {
    var info = tablex.page.info();
    tablex.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + info.start;
    });
});

      }, 1500);

     function table(){
   $('#addColumn').dataTable().fnDestroy();
   tablex = $("#addColumn").DataTable({        
         responsive: true,
        "language": dataTableLanguage,
    processing: true,
            serverSide: true,
            ajax: {
              "url": "{{ url("purchaseorder/purchaseorder/table") }}",
              "type": "get",
              data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nosupplier" :$('#nosupplier').val(),
                    "total" :$('#total').val(),
                    "nofpg" :$('#nofpg').val(),
                    },
              },
            columns: [
            {data: 'no', name: 'no'},             
            {data: 'po_no', name: 'po_no'},                           
            {data: 'created_at', name: 'created_at'},            
            {data: 'nama', name: 'nama'},
            {data: 'nama_supplier', name: 'nama_supplier'},
            {data: 'po_totalharga', name: 'po_totalharga'},            
            {data: 'po_tipe', name: 'po_tipe'},                                           
            {data: 'action', name: 'action'},                        
    



   
                          
                         
               
                   
                          
                            
                          
                          
                          
                          
                          
                    
                          

                    
                                  


            ],
            "pageLength": 10,
            "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
            "bFilter": false,
            "responsive": false,
           /*"fnCreatedRow": function (row, data, index) {
            $('td', row).eq(0).html(index + 1);
            }*/



    });
   notif();
}




dateAwal();
function dateAwal(){
      var d = new Date();
      d.setDate(d.getDate()-7);

      /*d.toLocaleString();*/
      $('#tanggal1').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      })
      /*.datepicker( "setDate", d);*/
      $('#tanggal2').datepicker({
            format:"dd-mm-yyyy",        
            autoclose: true,
      })
      /*.datepicker( "setDate", new Date());      */
      $('.kosong').val('').trigger('chosen:updated');
      $('.kosong').val('');      
}

 function cari(){
  table();  
 }

 function resetData(){  
  $('#tanggal1').val('');
  $('#tanggal2').val('');  
  /*$('#nofpg').val('');*/
  $('.kosong').val('');      
  $('.kosong').val('').trigger('chosen:updated');
  table();
  dateAwal();
}  
function notif(){
   $.ajax({
      url:baseUrl + '/purchaseorder/purchaseorder/notif',
      type:'get',   
       data: {
                    "_token": "{{ csrf_token() }}",                    
                    "tanggal1" :$('#tanggal1').val(),
                    "tanggal2" :$('#tanggal2').val(),
                    "nosupplier" :$('#nosupplier').val(),
                    "idjenisbayar" :$('#idjenisbayar').val(),
                    "nofpg" :$('#nofpg').val(),
                    },   
      success:function(data){
        $('#notif').html(data);
    }
  });
}
/*    tableDetail = $('#addColumn').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });*/

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $('input[class^="checkbox"]').change(function(){
       var $this = $(this);
      val = $this.val();
      $('.textsetuju').val(val)                             
      $('.checkbox7').each(function(){
        if ($this.is(":checked")) {
           
            $(".checkbox7").not($this).prop({ disabled: true, checked: false });   
           ;
          //  $('.simpan').attr('disabled', true);          
        } else {
            
            $(".checkbox7").prop("disabled", false);
            //$('.simpan').attr('disabled', true);  
        }
      })
    })

    function cetak(){
        var data = $('#form').serialize();
        @foreach($data['po'] as $index=>$po)
        window.open(baseUrl+'purchaseorder/print/' + '?' + data ,"_blank");  
        @endforeach
    }

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
    }


    $('#buttongetid').click(function(){
     
      valsetuju = $('.textsetuju').val();
      keterangan = $('.keterangankeuangan').val();
      poid  = poid;
    
      string = $('.hell').text();
      idspp = string.split(",");
      $('.labelkeuangand').show();
      url = baseUrl + '/purchaseorder/updatekeuangan';
      $.ajax({
        type : "POST",
        data : {valsetuju,keterangan,poid,idspp},
        url : url,
        dataType : 'json',
        success : function(data){
           $('#myModal2').modal('hide');
            alertSuccess(); 

            $('.labelkeuangan' + data).val(valsetuju);
             location.reload();
        }

      })

    })

   
   function hapusData(id){
  
    swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },

function(){
     $.ajax({
      url:baseUrl + '/purchaseorder/deletepurchase/'+id,
      type:'get',
      dataType : 'json',
      success:function(data){

        if(data.datainfo == "sukses"){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     location.reload();
          });
        }
         else if (data.datainfo == "gagal"){
               swal({
                  title: "error!",
                          type: 'error',
                          text: data.message,
                          timer: 900,
                         showConfirmButton: false                      
                  });
            }
      }
  });
  });
}

    function proseskeuangan(id){
      var idspp = [];
      poid = id;

      url = baseUrl + '/purchaseorder/detailpurchasekeuangan';
      $.ajax({
        type : "POST",
        data : {poid},
        url : url,
        dataType : 'json',
        success : function(data){
            $('.data-spp').empty();
          if(data.po[0].po_setujufinance != null  ){
            $('.datakeuangan').show();
            //  $('#buttongetid').attr('disabled' , true);
            dataHtml = "<b> Pihak Keuangan : </b>";
            
              if(data.bt.length > 0){
                 dataHtml += "<span class='label label-info'>"+data.po[0].po_setujufinance+"</span>";
                 $('#buttongetid').attr('disabled' , true);
              }
              else {
                dataHtml += "<span class='label label-info'>"+data.po[0].po_setujufinance+"</span> &nbsp; <button class='btn btn-xs btn-default'> <i class='fa fa-pencil' id='editkeuangan'> </i> </button<br>"; 

              }
          

            if(data.po[0].po_setujufinance == null  ){

            }
            else {
                 $('.datakeuangan').html(dataHtml);
                 $('.keterangankeuangan').attr('readonly', true);
                  datafinance = data.po[0].po_setujufinance;
                  if(data.po[0].po_setujufinance != ''){
                    $('.checkbox7').each(function(){
                    $this = $(this);
                   // alert($this.val() + datafinance);
                    if($this.val() == datafinance){
                     // alert('yesy');
                      $this.prop({disabled: true, checked : true});
                    }
                    else {                   
                       $this.prop({ disabled: true, checked: false });  
                    }
                  })
                  }
            }

            $idpbpo = data.pbpo;
             $('#editkeuangan').click(function(){
               if(data.po[0].po_setujufinance == 'DITOLAK' || $idpbpo.length != 0){
             //   alert('if');
                //  $('#buttongetid').attr('disabled' , true);
                    $('.checkbox7').prop('disabled' , false);
                    $('.keterangankeuangan').attr('readonly', false);
                }
                else {
               //   alert('else');
                  $('#buttongetid').attr('disabled' , false);
                  $('.checkbox7').prop('disabled' , false);
                  $('.keterangankeuangan').attr('readonly', false);
                }
             
            })

          }
          else {
             $('.checkbox7').prop('disabled' , false);
             $('.checkbox7').prop('checked' , false);
             $('.datakeuangan').hide();
             $('#buttongetid').attr('disabled' , false);
          }




          $('.nopo').html(data.po[0].po_no);
          $('.supplier').html(data.po[0].nama_supplier);
          $('.bayar').html(data.po[0].po_bayar + 'Hari');
          $('.catatan').html(data.po[0].po_catatan);
          $('.subtotal').html(addCommas(data.po[0].po_subtotal));
          if(data.po[0].po_diskon == null){
              $('.diskon').html('0 %');
          }
          else {
             $('.diskon').html(data.po[0].po_diskon + '%');
          }

          if(data.po[0].po_ppn == null){
             $('.ppn').html('0 %');
          }
          else {
              $('.ppn').html(data.po[0].po_ppn + '%');
          }
         
        
          $('.total').html(addCommas(data.po[0].po_totalharga));


          for(var j=0; j < data.spp.length; j++){
          rowData = "<div class='row'> " +
                    "<div class='col-sm-6'>" +
                      "<table class='table' id='spp'>" +
                      "<tr>" +
                        "<th> No SPP </th>" +
                        "<td style='color:#585252'> <b>"+data.spp[j].spp_nospp+" </b>  </td>" +
                      "</tr>" +
                      "<tr>" +
                        "<th> Keperluan </th>" +
                        "<td style='color:#585252'> <b>"+data.spp[j].spp_keperluan+" </b></td>" +
                      "</tr>" +
                      "<tr>" +
                        "<th> Tgl di Butuhkan </th>" +
                        "<td style='color:#585252'> <b>"+data.spp[j].spp_tgldibutuhkan+" </b></td>" +
                      "</tr>" +                    
                      "<tr>" +
                        "<th> Cabang Pemohon </th>"+
                        "<td style='color:#585252'> <b>"+data.spp[j].nama+" </b></td>" +
                      "</tr>" +
                      "</table>" +
                    "</div>" +
                    "<div class='col-sm-6'>" +
                      "<table class='table'>" +
                      "<tr>" +
                        "<th> &nbsp; </th>" +
                      "</tr>" +
                      "<tr>" +
                        "<th> &nbsp; </th>" +
                      "</tr>" +
                      "</table>" +
                    "</div>" +
                    "</div>" +
                    "<div class='col-sm-12'>" +
                      "<table class='table table-striped table-bordered' id='barang"+j+"'> " +
                        "<tr>" +
                          "<th> No </th>" +
                          "<th> Nama Barang </th>" +
                          "<th> Jumlah yang disetujui </th>" +
                          "<th> Jumlah dikirim </th>" +
                          "<th> Harga per item </th>" +
                          "<th> Total Harga per item </th>" +
                          "<th> Dikirim ke </th>" +
                        "</tr>" +
                      "</div>";


                     $('.data-spp').append(rowData);
                     $('.hell').append(data.spp[j].spp_id + ',');
                     var no = 1;
                    for(var k=0; k < data.podtbarang[j].length; k++){
                     
                      rowBarang = "<tr> <td>"+no+"</td> <td>"+data.podtbarang[j][k].nama_masteritem+"</td> <td>"+data.podtbarang[j][k].podt_approval+"</td> <td>"+data.podtbarang[j][k].podt_qtykirim+"</td> <td>"+data.podtbarang[j][k].podt_jumlahharga+"</th> <td>"+data.podtbarang[j][k].podt_totalharga+"</td> <td>"+data.podtbarang[j][k].mg_namagudang+"</td> </tr>"; 

                      $('#barang'+j).append(rowBarang); 
                      no++;
                    }   

                      idspp.push(data.spp[j].spp_id);                   
                  }

            }
       
      })
    
    }

   

</script>
@endsection
