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
   
    <div class="col-md-2">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['countspp']}} SPP </b></h2> <h4 style='text-align:center'> belum di proses Staff Pembelian </h4>
      </div>
    </div>

    <div class="col-md-2">
      <div class="alert alert-danger alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['poblmdiproses']}} PO </b></h2> <h4 style='text-align:center'> belum di proses Staff Keuangan </h4>
      </div>
    </div>

    <div class="col-md-2">
      <div class="alert alert-warning alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <h2 style='text-align:center'> <b> {{$data['posetuju']}} PO DISETUJUI </b></h2> <h4 style='text-align:center'> oleh Staff Keuangan </h4>
      </div>
    </div>
    <div class="col-md-2">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style='text-align:center'> <b> {{$data['poditolak']}} PO DITOLAK </b></h2> <h4 style='text-align:center'> oleh  Staff Keuangan </h4>
      </div>
    </div>

     <div class="col-md-2">
      <div class="alert alert-info alert-dismissable" style="animation: fadein 0.5s, fadeout 0.5s 2.5s;">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
         <h2 style='text-align:center'> <b> {{$data['porevisi']}} PO DIREVISI </b></h2> <h4 style='text-align:center'> oleh  Staff Keuangan </h4>
      </div>
    </div>
  </div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Pembelian Order
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="text-right">
                        <a class="btn btn-success" href="{{url('purchaseorder/createpurchase')}}"> <i class="fa fa-plus"> </i> Buat PO </a>
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
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-purchase">
                    <thead>
                     <tr>
                        <th style="width:10px">No</th>
                        <th> NO PO </th>   
                        <th> Cabang </th>                  
                        <th> Supplier </th>
                        <th> Total Biaya </th>
                        <th> Tipe PO </th>
                        <th> Proses Keuangan </th>
                      
                    </tr>
                  

                    </thead>
                    
                    <tbody>
                      @foreach($data['po'] as $index=>$po)
                      <tr>
                          <td> {{$index + 1}} </td>
                         
                          <td> <a href="{{url('purchaseorder/detail/'. $po->po_id .'')}}">{{$po->po_no}} </a>
                            <input type='hidden' value="{{$po->po_id}}"  class="po_id">  </td>
                          <td> {{$po->nama}}</td>
                          <td> {{$po->nama_supplier}} </td>
                          <td>  Rp {{number_format($po->po_totalharga, 2)}}</td>
                          <td> @if($po->po_tipe == 'J')
                                  JASA
                              @elseif($po->po_tipe == 'NS')
                                  NON STOCK
                              @else
                                  STOCK
                              @endif

                          </td>
                          <td> 
                            <button class="btn btn-sm btn-danger" onclick="proseskeuangan({{$po->po_id}})" type="button" id="createmodal" data-toggle="modal" data-target="#myModal2"> PROSES  </button> &nbsp;
                            @if($po->po_setujufinance != '')
                              <span class='label label-warning labelukeuangan{{$po->po_id}}'> {{$po->po_setujufinance}}</span> @endif
                            @if($po->po_setujufinance == 'DISETUJUI')
                            <button class="btn btn-sm btn-info print" type="button" onclick="cetak()"> <i class="fa fa-print" aria-hidden="true"> </i> </button>
                           @endif
                             </td>
                      </tr>
                      @endforeach

                    
                    </tbody>
                   
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
                      <div class="hell"> </div>

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

    tableDetail = $('.tbl-purchase').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

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
        window.open(baseUrl + '/purchaseorder/print/{{$po->po_id}}?' + data ,"_blank");  
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

      url = baseUrl + '/purchaseorder/updatekeuangan';
      $.ajax({
        type : "POST",
        data : {valsetuju,keterangan,poid,idspp},
        url : url,
        dataType : 'json',
        success : function(data){
           $('#myModal2').modal('hide');
            alertSuccess(); 

            $('.labelkeuangan' + poid).val(valsetuju);
        }

      })

    })

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
              $('#buttongetid').attr('disabled' , true);
            dataHtml = "<b> Pihak Keuangan : </b>";
            if(data.po[0].po_setujufinance == 'DISETUJUI'){
              dataHtml +=  "<span class='label label-info'>"+data.po[0].po_setujufinance+"</span>";
            }
            else {
               dataHtml += "<span class='label label-info'>"+data.po[0].po_setujufinance+"</span> &nbsp; <i class='fa fa-pencil' id='editkeuangan'> </i><br>";
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
                  $('#buttongetid').attr('disabled' , true);
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
