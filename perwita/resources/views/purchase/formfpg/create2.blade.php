@extends('main')

@section('title', 'dashboard')

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Faktur Pembelian </h2>
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
                            <strong> Create Faktur Pembelian </strong>
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
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST"> 
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                         <table class="table">
                             
                          <tr>
                            <td width="150px">
                          No Faktur
                            </td>
                            <td>
                               <input type="text" class="form-control">
                            </td>
                          </tr>
                          <tr>
                            <td>   Tanggal </td>
                            <td>
                              <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div>
                            </td>
                          </tr>

                          <tr>
                            <td> Supplier </td>
                            <td>   <select class="form-control idsup"> 
                                    <option value=""> -- Pilih Supplier -- </option>
                                @foreach($data['supplier'] as $supplier)
                                    <option value="{{$supplier->idsup}}"> {{$supplier->nama_supplier}}</option>

                                @endforeach
                                </select>
                            </td>
                            </td>
                          </tr>

                          <tr>
                            <td>
                              Keterangan
                            </td>
                            <td>
                                <input type="text" class="form-control"> 
                            </td>
                          </tr>

                         </table>
                      </div>
                      <div class="col-xs-6">
                            <table class="table">
                            <tr>
                              <td width="150px"> No Invoice </td>
                              <td> <input type="text" class="form-control"> </td>
                            </tr>

                            <tr>
                              <td> Jatuh Tempo </td>
                              <td>  <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="03/04/2014">
                              </div></td>
                            </tr>
                            </table>
                        </div>
                      </div>
                      <hr>

                      <button  type="button" class="tbmh-data btn btn-success">  Tambah Data Item </button> &nbsp; 
                       <button  type="button" class="tbmh-po btn btn-info"  id="createmodal" data-toggle="modal" data-target="#myModal5">  Tambah Data PO </button>
                        <div class="table-databarang"> </div>
                      &nbsp; 

                    </div>
                    </form> 

                    <!-- modal -->
                <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                         <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                     
                      <h4 class="modal-title">Tambah Data PO </h4>
                       
                     </div>

                    <div class="modal-body">
                        <table id="addColumn" class="table table-bordered table-striped tbl-purchase">
                          <thead>
                           <tr>
                              <th style="width:10px">No</th>
                              <th> No PO </th>
                              <th> Status diterima </th>
                              <th> Jumlah Harga </th>
                              <th> Aksi </th>      
                          </tr>
                          </thead>
                          
                          <tbody>
                            <tr>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                                <td> </td>
                            </tr>

                          </tbody>
                        </table>
                        <div class="kosong"> </div>
                        </form>
                    </div>

                          <div class="modal-footer">
                              <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="buttongetid">Save changes</button>
                          </div>
                      </div>
                    </div>
                 </div> <!--end modal -->

                
                <br>
                <br>
                 <div class='title'> </div>
                <div class="box-footer">
                  <div class="pull-right">
                  
                  <!--   <a class="btn btn-warning" href={{url('fatkurpembelian/fatkurpembelian')}}> Kembali </a>
                   <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-success"> -->
                    
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

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy'
    });

 tableDetail = $('.tbl-purchase').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

      url = baseUrl + '/fakturpembelian/getchangefaktur';

    $('.idsup').change(function(){
      idsup = $(this).val();
          $.ajax({    
          type :"get",
          data : {idsup},
          url : url,
          dataType:'json',
          success : function(response){
            if(response.header.length > 0) {
           $('.kosong').empty();

            $n = 1;
            for(var i = 0; i < response.po.length; i++){

              console.log('po');
               var html = "<tr id='data' class=data"+i+"> <td>"+ $n +"</td> <td>"+ response.po[i].po_no+"</td> <td>"+response.status[i]+"</td> <td>"+addCommas(response.po[i].sum)+"</td> <td> <div class='checkbox'>" +
                                            "<input type='checkbox' id="+response.po[i].po_no+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                            "<label></label>" +
                                        "</div> </td>  </tr>";
                $n++;
                
                $('#addColumn').append(html);
            }
          }
          else {
              $('#addColumn').empty();
              $('.tbl-purchase').empty();
             var html = "<h1> Tidak ada Data PO yang di buat</h1>";
            
             $('.kosong').append(html);
            }
        }

     })

    })


     $('#buttongetid').click(function(){
      var checked = $(".check:checked").map(function(){
        return this.id;
      }).toArray();

      var url = baseUrl + '/fakturpembelian/tampil_po';

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });

      no_po = checked;
      console.log(no_po);

       $.ajax({    
          type :"get",
          data : {no_po},
          url : url,
          dataType:'json',
          success : function(response){
            $('.tampilpo').empty();

            $('#myModal5').modal('hide');
                    Jumlahharga = 0;
              for(var k = 0; k < response.po.length; k++) {
                  Jumlahharga = parseInt(Jumlahharga) + parseInt(response.po[k][0].p);
              }


              harga =  Math.round(Jumlahharga).toFixed(2);

            var title = "<table border='0'> <tr> <th style='width:200px'>  Jumlah </th> <td> R p"+ addCommas(harga) +"</td> </tr>" +
                                "<tr><th> &nbsp; </th> </tr>" +
                                "<tr> <th> Discount </th> <th> <input type='text' class='form-control'> </th> </tr>" +
                                "<tr> <th> &nbsp; </tr>" +
                                "<tr> <th> Jenis PPn </th> <th> <input type='text' class='form-control'> </th> </tr>" +
                                "<tr> <th> &nbsp; </tr>" +
                                "<tr> <th> DPP </th> <th> <input type='text' class='form-control'> </th> </tr>" +
                                "<tr> <th> PPn </th> <th> <input type='text' class='form-control'> </th> </tr>"
                                "</table>";
          $('.title').html(title);

            var judul = "<table class='table po' id='po'> <tr>  <th style='width:10px'> No </th> <th style='width:60px'> No PO </th> <th style='width:100px'> Jumlah Harga </th> </tr>";
                            var no = 1;
                            for(var i = 0; i < response.po.length; i++) {
                              var rowTampil =  "<table class='table'> <tr> <td style='width:10px'>"+ no +"</td> <td style='width:60px'>"+response.po[i][0].po_no+"</td> <td style='width:100px'> Rp "+ addCommas(response.po[i][0].p)+"</td> </td></table>";
                            no++;   
                             $('.tampilpo').append(rowTampil);
                            }                            
          //      rowTampil += "</table>"; 

          $('.judul').html(judul);
               

          }
      })

    })
  
    $('.tbmh-data').click(function(){
      $('.tbmh-po').attr('disabled' , true);
      var htmlrows = "<table class='table'> <tr> <td> na </td></tr> </table";

      var htmlrow =  "<br> <div class='row'> <div class='pull-right' style='margin-right:40px'> <button class='btn btn-default btn-circle' id='close' type='button'> <i class='fa fa-times'> </i> </button> </div> <div class='col-xs-6'>  <table class='table' style='width:75%'>" +
                          "<tr>" +
                            "<td width='150px'> Nama Item : </td>" +
                            "<td>" +
                            "<select class='form-control'>" + 
                                "@foreach($data['barang'] as $brg)" +
                                    "<option value='{{$brg->kode_item}}'> {{$brg->nama_masteritem}} </option>" +
                                "@endforeach" +
                            "</select> </td>" +
                          "</tr>" +
                          "<tr>" +
                            "<td> Qty </td>" +
                            "<td>" +
                              "<input type='text' class='form-control qty'>" + 
                            "</td>" +
                          "</tr>" +
                          "<tr>" +
                            "<td>" +
                              "Gudang" +
                            "</td>" +
                            "<td> <select class='form-control'> <option value=''> Gudang A </option> <option value=''> Gudang B </option></select></td>" +
                          "</tr>" +
                          "<tr>" +
                            "<td>" +
                              "Harga" +
                            "</td>" +
                            "<td>" +
                              "<input type='text' class='form-control'>" +
                            "</td>" +
                          "</tr>" +
                          "<tr>" +
                            "<td>" +
                              "Amount" +
                            "</td>" +
                            "<td> <input type='text' class='form-control'></td>" +
                          "</tr>" +
                        "</table> </div>" +
                       "<div class='col-xs-6'>" +
                          "<table class='table' style='width:75%'>" +
                          "<tr>" +
                            "<td width='150px'>" +
                              "Update Stock ?" +
                            "</td>" +
                            "<td>" +
                              "<select class='form-control'> <option value=''> Ya </option> <option value=''> Tidak </option></select>" +
                            "</td>" +
                          "</tr>" +
                           "<tr>" +
                          "<td>" +
                            "Biaya" +
                          "</td>" +
                            "<td>" +
                              "<input type='text' class='form-control'>" +
                            "</td>" +
                          "</tr>" +
                          "<tr>" +
                              "<td>" +
                                "PPn %" +
                              "</td>" +
                              "<td>" +
                                "<input type='text' class='form-control'>" +
                              "</td>" +
                          "</tr>" +
                          "<tr>" +
                            "<td>" +
                              "Netto" +
                            "</td>" +  
                            "<td>" +
                              "<input type='text' class='form-control'>"+
                            "</td>" +
                          "</tr>" +
                          "<tr>" +
                          "<td>" +
                            "Account Biaya" +
                          "</td>" +
                          "<td>" +
                            "<input type='text' class='form-control'>" +
                          "</td>" +
                          "</tr>" +
                           "<tr>" +
                          "<td>" +
                            "Keterangan" + 
                          "</td>" +
                          "<td>" +
                            "<input type='text' class='form-control'>" +
                          "</td>" +
                          "</tr>" +
                         "</table>"  +
                       "</div> <br> <br>" +
                       "<div class='box-footer'>" +
                       "<div class='pull-right' style='margin-right:20px'>" +
                         "<button type='button' class='btn btn-success tbmh-data-item'> Tambah Data Item  </button>" +
                      "</div> </div>" +
                    "</div>";

           htmlrow += 
                   "<hr>" +
                   "<h4> Daftar Detail Faktur </h4>" +
                   "<br>" +
                   "<div class='box-body'>" +
                    "<div class='table-responsive'>" +
                      "<table class='table table-bordered table-striped tbl-penerimabarang' id='addColumn'>" +
                      "<tr>" +
                        "<thead>" + 
                        "<th>" +
                          "No" +
                        "</th>" +
                          "<th width='150px'>" +
                             "Nama Item" +
                          "</th>" +
                          "<th>" +
                          "Qty" +
                          "</th>" +
                          "<th width='150px'>" +
                            "Gudang" +
                          "</th>" +
                          "<th width='100px'>" +
                            "Harga / unit" +
                          "</th>" +
                          "<th>" +
                            "Amount" +
                          "</th>" +
                          "<th>" +
                            "Update Stock ?" +
                          "</th>" +
                          "<th>" +
                            "Biaya" + 
                          "</th>" +
                          "<th>" +
                            "PPn %" + 
                          "</th>" +
                          "<th>" +
                            "Netto" +
                          "</th>" +   
                          "<th>" +
                            "Account Biaya" +
                          "</th>" +
                          "<th>" +
                            "Keterangan" +
                          "</th>" +
                        "</thead>" +
                      "</tr>" +
                    
                      "</table>" +
                      "</div>" +
                   "</div>" +
                   "<div class='text-right'> <button class='btn btn-warning' type='button'> Kembali </button> <button class='btn btn-success' type='button'> Simpan  </button> </div>";

          $('.table-databarang').html(htmlrow);
                console.log($('.qty').val());
          //close
          $('#close').click(function(){
             $('.table-databarang').empty();
             $('.tbmh-po').attr('disabled', false);
          })




          $('.tbmh-data-item').append(function(){
            console.log($('.qty').val());
              var htmlbarang = "<tr>"
                                  "<td> </td>" +
                                  "<td> </td>" + 
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                                  "<td> </td>" +
                               "</tr>";
          })
    }) 

    

</script>
@endsection
