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
                  <form method="post" action="{{url('fakturpembelian/save')}}"  enctype="multipart/form-data" class="form-horizontal" id="myform">
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                         <table class="table">     
                          <tr>
                            <td width="150px">
                          No Faktur
                            </td>
                            <td>
                               <input type="text" class="form-control nofaktur" name="nofaktur">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </td>
                          </tr>
                          <tr>
                            <td>   Tanggal </td>
                            <td>
                              <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control tgl" name="tgl">
                              </div>
                              <div class="kolomjatuhtempo"> </div>
                            </td>
                          </tr>

                          <tr>
                            <td> Supplier </td>
                            <td>   <select class="form-control idsup" name="supplier"> 
                                    <option value=""> -- Pilih Supplier -- </option>
                                @foreach($data['supplier'] as $supplier)
                                    <option value="{{$supplier->idsup}},{{$supplier->syarat_kredit}}"> {{$supplier->nama_supplier}}</option>
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
                                <input type="text" class="form-control keterangan" name="keterangan"> 
                            </td>
                          </tr>

                         </table>
                      </div>
                      <div class="col-xs-6">
                            <table class="table">
                            <tr>
                              <td width="150px"> No Invoice </td>
                              <td> <input type="text" class="form-control noinvoice" name="no_invoice"> </td>
                            </tr>

                            <tr>
                              <td> Jatuh Tempo </td>
                              <td>  <div class="input-group date">
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control jatuhtempo"  disabled="">
                              </div></td>
                            </tr>
                            </table>
                        </div>
                      </div>
                      <hr>
                  <div class="col-lg-12">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active" id="tmbhdataitem"><a data-toggle="tab" href="#tab-1" > Tambah Data Item </a></li>
                            <li class="" id="tmbhdatapo"><a data-toggle="tab" href="#tab-2">Tambah Data PO </a></li>
                        </ul>

                        <!--tambah data item -->
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class='row'>  <div class='col-xs-6'>  <table class='table' style='width:75%'>
                          <tr>
                            <td width='150px'> Nama Item : </td>
                            <td>
                            <select class='form-control item' name="nama_item"> 
                                    <option value=""> -- Pilih Barang -- </option>
                                @foreach($data['barang'] as $brg)
                                    <option value='{{$brg->kode_item}}'> {{$brg->nama_masteritem}} </option>
                                @endforeach
                            </select> </td>
                          </tr>
                          <tr>
                            <td> Qty </td>
                            <td>
                              <input type='number' class='form-control qty' name="qty"> 
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Gudang
                            </td>
                            <td>
                            <select class='form-control gudang' name="gudang">
                                <option value=''> -- Pilih Gudang -- </option>
                              @foreach($data['gudang'] as $gudang)
                                <option value='{{$gudang->mg_id}}'> {{$gudang->mg_namagudang}} </option>
                              @endforeach  
                            </select></td>
                          </tr>
                          <tr>
                            <td>
                              Harga
                            </td>
                            <td>
                              <input type='text' class='form-control harga' name="harga">
                            </td>
                          </tr>
                          <tr>
                            <td>
                              Total Harga
                            </td>
                            <td> <input type='text' class='form-control amount' name="amount" readonly=""></td>
                          </tr>
                        </table> </div>
                       <div class='col-xs-6'>
                          <table class='table' style='width:75%'>
                          <tr>
                            <td width='150px'>
                              Update Stock ?
                            </td>
                            <td>
                              <select class='form-control' name="updatestock"> <option value='Ya'> Ya </option> <option value='Tidak'> Tidak </option></select>
                            </td>
                          </tr>
                          <tr>
                          <td>
                            Biaya
                          </td>
                          <td>
                              <input type='text' class='form-control biaya' name="biaya">
                            </td>
                          </tr>
                         
                          <tr>
                          <td>
                            Account Biaya
                          </td>
                          <td>
                            <input type='number' class='form-control acc_biaya' name="acc_biaya">
                          </td>
                          </tr>
                          <tr>
                          <td>
                            Keterangan 
                          </td>
                          <td>
                            <input type='text' class='form-control keterangan' name="keterangan_fp">
                          </td>
                          </tr>
                         </table>
                       </div> <br> <br>
                       <div class='box-footer'>
                       <div class='pull-right' style='margin-right:20px'>
                       <table border="0">
                        <tr>
                          <td><button type='button' class='btn btn-warning clear'> Bersihkan Data </button></td>
                          <td> &nbsp; </td>
                          <td> <button type='submit' class='btn btn-success tbmh-data-item'> Tambah Data Item  </button></td>
                        </tr>
                       </table>
                        </form>
                      </div> </div>
                    </div>
                   <hr>
                   <h4> Daftar Detail Faktur </h4>
                   <br>
                   <div class='box-body'>
                    <div class="col-xs-6">
                    <div class='table-responsive'>
                      <table class='table table-bordered table-striped tbl-penerimabarang' id="tablefp">
                      <tr>
                      <thead> 
                        <th>
                          No
                        </th>
                          <th width='150px'>
                             Nama Item
                          </th>
                          <th>
                          Qty
                          </th>
                          <th width='150px'>
                            Gudang
                          </th>
                          <th width='100px'>
                            Harga / unit
                          </th>
                          <th>
                            Total Harga
                          </th>
                          <th>
                            Update Stock ?
                          </th>
                          <th>
                            Biaya 
                          </th> 
                          <th>
                            Account Biaya
                          </th>
                          <th>
                            Keterangan
                          </th>
                        </thead>
                      </tr>
                    
                      </table>
                      </div>
                      </div>
                      <div class="col-xs-6">
                        <table class='table'>
                            <form method="post" action="{{url('fakturpembelian/update_fp')}}"  enctype="multipart/form-data" class="form-horizontal" id="form_jumlah">
                            <input type="hidden" class="no_faktur" name="no_faktur">

                          <tr>
                            <th> Jumlah </th>
                            <td> <div class="col-xs-3"> Rp </div> <div class="col-xs-6"> <input type='text' class='form-control jumlahharga' name='jumlahtotal' style='text-align: right' readonly=""> </div> </td>
                          </tr>
                          <tr>
                            <th> Discount </th>
                            <td> <div class="col-md-3"> <input type="text" class="form-control disc_item" name="diskon"> </div> <label class="col-md-3"> % </label>  </td>
                          </tr>
                          <tr>
                            <th> Jenis PPn </th>
                            <td> <div class="col-md-3">  <select class='form-control jenisppn' > <option value='Ya'> Ya </option> <option value='Tidak'> Tidak </option> </select> </div> </td>
                          </tr>
                          <tr>
                            <th> DPP </th>
                            <td>  <div class='col-xs-3'> Rp </div> <div class='col-xs-6'> <input type='text' class='form-control dpp' readonly="" name='dpp'> </div> </td>
                          </tr>
                          <tr>
                            <td> PPn % </td>
                            <td> <select class='form-control'> @foreach($data['pajak'] as $pajak)<option value='{{$pajak->Kode}}'> {{$pajak->Nama}}</option> @endforeach </select> </td>
                          </tr>

                          <tr>
                            <td> Biaya - biaya Lain </td>
                            <td> <input type='text' class='form-control'> </td>
                          </tr>

                          <tr>
                            <td> Netto Hutang </td>
                            <td> <input type='text' class='form-control'> </td>
                          </tr>
                        </table>

                        <div class='pull-right'>
                          <table border="0">
                          <tr>
                          <td> <button type='button' class="btn btn-danger"> Kembali </button> </td>
                          <td> &nbsp; </td>
                          <td> <button type="submit" class='btn btn-success'> Simpan Data </button> </td>
                          </form>
                          </table>
                        </div>

                      </div>
                   </div>
                 
                  </div>
                  </div>

                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="pull-left">
                                       <button  type="button" class="tbmh-po btn btn-success"  id="createmodal" data-toggle="modal" data-target="#myModal5"> <i class="fa fa-plus" aria-hidden="true"></i> Tambah PO </button>
                                    </div>
                                    <br>
                                    <br>
                                    <br>

                                    <table class='table table-bordered table-striped ' id='table_po' style='width:75%'>
                                      <tr>
                                        <th style='width:20px'> No </th> <th style='width:200px'> No PO </th> <th> Jumlah Harga </th>
                                      </tr>
                                    </table>

                                    <div class="row">
                                      <div class="col-xs-6">
                                          <div class='table-responsive'>
                                        <table class="table  table-bordered" id="table_dataitempo">
                                          <tr>
                                            <th> No </th>
                                            <th style='width:100px'> Nama Item </th>
                                            <th> Qty Terima </th>
                                            <th> Qty Po</th>
                                            <th> Gudang </th>
                                            <th> Harga / unit </th>
                                            <th> Total Harga </th>
                                            <th> Update Stock ?</th>
                                            <th> Account Biaya </th>
                                          </tr>
                                        </table>
                                        </div>
                                      </div>
                                      <div class="col-xs-6">
                                          <form method="post" action="{{url('fakturpembelian/savefaktur')}}"  enctype="multipart/form-data" class="form-horizontal" id="savefakturpo">
                                          <table class='table'>
                                             
                                               <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                              <input type="hidden" class="no_faktur" name="no_faktur">
                                              <input type="hidden" class="tgl_po" name="tgl_po">
                                              <input type="hidden" class="supplier_po" name="supplier_po">
                                              <input type="hidden" class="keterangan_po" name="keterangan_po">
                                              <input type="hidden" class="invoice_po" name="invoice_po">
                                              <input type="hidden" class="jatuhtempo_po" name="jatuhtempo_po">

                                            <tr>
                                              <th> Jumlah </th>
                                              <td> <div class="col-xs-3"> Rp </div> <div class="col-xs-6"> <input type='text' class='form-control jumlahharga_po' name='jumlahtotal' style='text-align: right' readonly=""> </div> </td>
                                            </tr>
                                            <tr>
                                              <th> Discount </th>
                                              <td> <div class="col-md-3"> <input type="text" class="form-control disc_item_po" name="diskon"> </div> <label class="col-md-3"> % </label>  </td>
                                            </tr>
                                            <tr>
                                              <th> Jenis PPn </th>
                                              <td> <div class="col-md-3">  <select class='form-control jenisppn_po' > <option value='Ya'> Ya </option> <option value='Tidak'> Tidak </option> </select> </div> </td>
                                            </tr>
                                            <tr>
                                              <th> DPP </th>
                                              <td>  <div class='col-xs-3'> Rp </div> <div class='col-xs-6'> <input type='text' class='form-control dpp_po' readonly="" name='dpp' style="text-align: right"> </div> </td>
                                            </tr>
                                            <tr>
                                              <td> PPn % </td>
                                              <td> <select class='form-control'> @foreach($data['pajak'] as $pajak)<option value='{{$pajak->Kode}}'> {{$pajak->Nama}}</option> @endforeach </select> </td>
                                            </tr>

                                            <tr>
                                              <td> Biaya - biaya Lain </td>
                                              <td> <input type='text' class='form-control'> </td>
                                            </tr>

                                            <tr>
                                              <td> Netto Hutang </td>
                                              <td> <input type='text' class='form-control'> </td>
                                            </tr>
                                          </table>

                                          <div class='pull-right'>
                                            <table border="0">
                                            <tr>
                                            <td> <button type='button' class="btn btn-danger"> Kembali </button> </td>
                                            <td> &nbsp; </td>
                                            <td> <button type="submit" class='btn btn-success'> Simpan Data </button> </td>
                                          
                                            </table>

                                             <table class='table' id="input_data">
                                              <tr>
                                                <td>
                                                ans
                                                </td>
                                              </tr>
                                             </table>
                                            </form>



                                          </div>

                                         <!--  <div id="input_data"> </div> -->

                                        

                                        </div>

                                    </div>


                                </div>
                            </div>

                              <!-- modal -->
                              <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                           <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                        <h4 class="modal-title">Tambah Data PO </h4>     
                                       </div>

                                <div class="modal-body">
                                    <table id="addColumn" class="table  table-bordered table-striped tbl-purchase">
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
                       <div class="loading text-center" style="display: none;">
                            <img src="{{ asset('assets/image/loading1.gif') }}" width="100px">
                        </div>
                       <div class='title'> </div>
                        </div>
                    </div>
                </div>


                </div> <!--end body-->
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

    function findArrayMin(array, attr, value) {
                  for(var i = 0; i < array.length; i ++) {
                      if(array[i][attr] == value) {
                          return i;
                      }
                  }
                  return -1;
    }

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


    $('.nofaktur').change(function(){
      $this = $(this).val();
      $('.no_faktur').val($this);
    })

    $('.noinvoice').change(function(){
      $this = $(this).val();
      $('.invoice_po').val($this);
    })

    $('.keterangan').change(function(){
      $this = $(this).val();
      $('.keterangan_po').val($this);
    })


    //tambah data item
    //hitung diskon di tambah data item
    $('.disc_item').change(function(){
      jumlahharga = $('.jumlahharga').val();
      hsljml =  jumlahharga.replace(/,/g, '');
      disc = $(this).val();
      total = (parseInt(disc)/100) * hsljml;

      hasil = hsljml - total;

      numeric = Math.round(hasil).toFixed(2);


      $('.dpp').val(addCommas(numeric));

    })

    $('.clear').click(function(){
      $('.item').prop('selectedIndex',0);
      $('.qty').val('');
      $('.gudang').val('');
      $('.harga').val('');
      $('.amount').val('');
      $('.biaya').val('');
      $('.acc_biaya').val('');
      $('.keterangan').val('');
    })

    $('.harga').change(function(){
      val = $(this).val();
      qty = $('.qty').val();

      if(qty != '') {
        amount = parseInt(qty) * parseInt(val);
        num_amount = Math.round(amount).toFixed(2);
        numeric = Math.round(val).toFixed(2);
        harga = addCommas(numeric);
        $(this).val(harga);
        $('.amount').val(addCommas(num_amount));
      }
    })


    $('.qty').change(function(){
      val = $(this).val();
      harga = $('.harga').val();
      console.log(harga);

      if(harga != ''){

         hsljml =  harga.replace(/,/g, '');
        amount = parseInt(val) * parseInt(hsljml);
        num_amount = Math.round(amount).toFixed(2);
        console.log(parseInt(harga));
        console.log(val);
        $('.amount').val(addCommas(num_amount));
      }
    })


    $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
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

      //update_fp
       $('#form_jumlah').submit(function(event){
        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        $.ajax({
          type : "post",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
            console.log(response);
          }
          })
      })


       //savefakturpo

       $('#savefakturpo').submit(function(event){
         event.preventDefault();
          var post_url3 = $(this).attr("action");
          var form_data3 = $(this).serialize();

          $.ajax({
            type : "post",
            data : form_data3,
            url : post_url3,
            dataType : 'json',
            success : function(response){
              console.log(response);
            }
          })

       })

     //saveitem
      $('#myform').submit(function(event){
        event.preventDefault();
          var post_url = $(this).attr("action");
          var form_data = $(this).serialize();

        $.ajax({
          type : "post",
          data : form_data,
          url : post_url,
          dataType : 'json',
          success : function (response){
            $no = 1;
            $jumlahharga = 0;
            console.log(response.fpdt.length);
            for(var j = 0; j < response.fpdt.length; j++){
              row = "<tr id='data-item'> <td>"+$no+"</td> <td>"+response.fpdt[j].nama_masteritem+"</td> <td>"+response.fpdt[j].fpdt_qty+"</td> <td>"+response.fpdt[j].mg_namagudang+"</td> <td>"+ addCommas(response.fpdt[j].fpdt_harga)+"</td> <td>"+ addCommas(response.fpdt[j].fpdt_totalharga)+"</td> <td>"+response.fpdt[j].fpdt_updatedstock+"</td> <td>"+response.fpdt[j].fpdt_biaya+"</td> <td>"+ response.fpdt[j].fpdt_accbiaya+"</td><td>"+response.fpdt[j].fpdt_keterangan+"</td></tr>";
           


              $jumlahharga = $jumlahharga + parseInt(response.fpdt[j].fpdt_totalharga);

                var num = Math.round($jumlahharga).toFixed(2);
              $('.jumlahharga').val(addCommas(num));
              $no++;
            }
               $('#tablefp').append(row);
            
               $('.no_faktur').val(response.fpdt[0].fp_nofaktur);
          }
        })
      })

      //mendapatkan data fpdt

      //supplier
    $('.idsup').change(function(){

      $('.loading').css('display', 'block');

      tanggal = $('.tgl').val();
      // bulan - bulan
      var months = new Array(12);
      months[0] = "January";
      months[1] = "February";
      months[2] = "March";
      months[3] = "April";
      months[4] = "May";
      months[5] = "June";
      months[6] = "July";
      months[7] = "August";
      months[8] = "September";
      months[9] = "October";
      months[10] = "November";
      months[11] = "December";
      url = baseUrl + '/fakturpembelian/getchangefaktur';
      idsup = $(this).val();
       $('.supplier_po').val(idsup);
          $.ajax({    
          type :"get",
          data : {idsup},
          url : url,
          dataType:'json',
          success : function(response){
            
           $('.loading').css('display', 'none');

            //setting jatuh tempo
             if(tanggal != '') {
               syaratkredit = parseInt(response.supplier[0].syarat_kredit);

               var date = new Date(tanggal);
               var newdate = new Date(date);

               newdate.setDate(newdate.getDate() + syaratkredit);

               var dd = newdate.getDate();
               var MM = newdate.getMonth() ;
               var y = newdate.getFullYear();

               var newyear = dd + '-' + months[MM] + '-' + y;
               $('.jatuhtempo').val(newyear);
            }

            rowjatuhtempo = "<input type='hidden' value="+newyear+" name='jatuhtempo'>";
            $('.kolomjatuhtempo').html(rowjatuhtempo);
            //end jatuh tempo

            if(response.header.length > 0) {
               $("table#addColumn tr#data").remove();
              $("table#addColumn tr#data_kosong").remove();
            $n = 1;
            for(var i = 0; i < response.po.length; i++){
             
              //console.log('po');
               var html2 = "<tr id='data' class=data"+i+"> <td>"+ $n +"</td> <td>"+ response.po[i].po_no+"</td>";
               if(response.status[i] == null ){
                html2 += "<td> Barang belum di terima </td> <td> - </td> <td> </td>";
               }
               else {
                html2 += "<td>"+response.status[i]+"</td> <td>"+addCommas(response.po[i].sum)+"</td> <td> <div class='checkbox'>" +
                                            "<input type='checkbox' id="+response.po[i].po_no+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                            "<label></label>" +
                                        "</div> </td>  </tr>";              
               }
             /*  html2 += "<td> <div class='checkbox'>" +
                                            "<input type='checkbox' id="+response.po[i].po_no+" class='check' value='option1' aria-label='Single checkbox One'>" +
                                            "<label></label>" +
                                        "</div> </td>  </tr>";*/
                                        console.log('ana');
                $n++;  
                $('#addColumn').append(html2);
            }

             
          }
          else {
             $("table#addColumn tr#data").remove();
             $("table#addColumn tr#data_kosong").remove();
             var html = "<tr id='data_kosong'> <td colspan='3' style='text-align:center'><h1> Tidak ada Data PO yang di buat</h1> </td>";
             $('#addColumn').append(html);

            }
        }

     })
  
    })

    //menghitungjatuhtempo
    $('.tgl').change(function(){
    tanggal = $(this).val(); 
    $('.tgl_po').val(tanggal);
    val = $('.idsup').val();

    if(val != ''){


    var string = val.split(",");
    syaratkredit = string[1];

       var months = new Array(12);
      months[0] = "January";
      months[1] = "February";
      months[2] = "March";
      months[3] = "April";
      months[4] = "May";
      months[5] = "June";
      months[6] = "July";
      months[7] = "August";
      months[8] = "September";
      months[9] = "October";
      months[10] = "November";
      months[11] = "December";

             var date = new Date(tanggal);
             var newdate = new Date(date);

             newdate.setDate(newdate.getDate() + syaratkredit);

             var dd = newdate.getDate();
             var MM = newdate.getMonth() ;
             var y = newdate.getFullYear();

             var newyear = dd + '-' + months[MM] + '-' + y;
             $('.jatuhtempo').val(newyear);
            
            rowjatuhtempo = "<input type='hidden' value="+newyear+" name='jatuhtempo'>";
            $('.kolomjatuhtempo').html(rowjatuhtempo);
            $('.jatuhtempo_po').val(newyear);
      }
    })


    //tambah data PO
    $("#tmbhdatapo").click(function(){
        $('.item').prop('selectedIndex',0);
        $('.qty').val('');
        $('.gudang').val('');
        $('.harga').val('');
        $('.amount').val('');
        $('.biaya').val('');
        $('.acc_biaya').val('');
        $('.keterangan').val('');

        $('table#tablefp tr#data-item').remove();
        $('.jumlahharga').val('');
        $('.disc_item').val('');
        $('.jenisppn').val('');
        $('.dpp').val('');

        $('.nofaktur').val('');
        $('.tgl').val('');
        $('.idsup').val('');
        $('.noinvoice').val('');
        $('.jatuhtempo').val('');

    })


    //menampilkan po
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

      //buat po - tampilpo
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
                //tampil po di modal
                harga =  Math.round(Jumlahharga).toFixed(2);
                var no = 1;
                $("table#table_po tr#datapo").remove();

                for(var i = 0; i < response.po.length; i++) {
                    var rowTampil =  "<tr id='datapo'> <td>"+ no +"</td>"+
                    "<td> <a class='po' data-id="+i+" data-po="+response.po[i][0].po_id+"> "+response.po[i][0].po_no+"</td> <td> Rp "+ addCommas(response.po[i][0].p)+"</td> </td> </tr>";
                      no++;   
                     $('#table_po').append(rowTampil);    
                } 
              
              //tampil data-item unt di save
                 var jumlahtotalharga = 0;
              for(var k = 0 ; k < response.po_barang.length; k++){
                for(var z = 0; z < response.po_barang[k].length; z++){
                     var rowinput = "<tr> <th> <input type='hidden' name='item_po' value="+response.po_barang[k][z].pbdt_item+"> </th> <th> <input type='hidden' name='qty' value="+response.po_barang[k][z].sumqty+"> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pb_gudang+" name='pb_gudang'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pbdt_hpp+" name='hpp'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].sumharga+" name='totalharga'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pbdt_updatestock+" name='updatestock'> </th> <th> <input type='hidden' value="+response.po_barang[k][z].pb_po+" name='idpo'> </th> </tr> ";

                      $('#input_data').append(rowinput);
                        jumlahtotalharga = jumlahtotalharga + parseInt(response.po_barang[k][z].sumharga);
                }
              }

               numeric = Math.round(jumlahtotalharga).toFixed(2);
               $('.jumlahharga_po').val(addCommas(numeric));

              //tampil data item di no po
               $('.po').each(function(){
                 
                  $(this).click(function(){
                    var idpo = $(this).data('po');
                    $("table#table_dataitempo tr#dataitempo").remove();

                     $no = 1;
                  
                    for(var s = 0 ; s < response.barang_penerimaan.length; s++){
                      
                  //  console.log(response.barang_penerimaan[0].pb_po);
                      if(response.barang_penerimaan[s].pb_po == idpo) {
                     
                       var rowTable = "<tr id='dataitempo'> <td>"+ $no +"</td> <td>"+response.barang_penerimaan[s].nama_masteritem+"</td> <td>"+response.barang_penerimaan[s].sumqty+"</td> <td>"+response.barang_penerimaan[s].qty_po+"</td>  <td>"+response.barang_penerimaan[s].pb_comp+"</td> <td>"+addCommas(response.barang_penerimaan[s].pbdt_hpp)+"</td> <td>"+addCommas(response.barang_penerimaan[s].sumharga)+"</td> <td>"+response.barang_penerimaan[s].pbdt_updatestock+"</td> <td> </td>  <tr>";

                        $('#table_dataitempo').append(rowTable);
                         $no++;
                      

                      }
                     /* else if(response.barang_penerimaan[i].pb_po == idpo){
                        console.log('anainput');
                         var rowinput = "<input type='text' name='item_po' value="+response.barang_penerimaanqt[i].pbdt_item+"> <input type='text' name='qty' value="+response.barang_penerimaanqt[i].sumqty+"> <input type='text' value="+response.barang_penerimaan[i].pb_gudang+" name='pb_gudang'> <input type='text' value="+response.barang_penerimaan[i].pbdt_hpp+" name='hpp'> <input type='text' value="+response.barang_penerimaan[i].sumharga+" name='totalharga'> <input type='text' value="+response.barang_penerimaan[i].pbdt_updatestock+" name='updatestock'> <input type='text' value="+response.barang_penerimaan[i].pb_po+" name='idpo'>";

                         $('#input_data').append(rowinput);
                      }*/
                     
                    }

                     
                  })
               })             
          }
      })

    })
    

   $(document).on('click','.removes-btn',function(){
    alert('hai');
      /*  var id = $(this).data('id');
        var parent = $('#field-'+id);
        var valField = parent.find('.harga'+id).val();
        
        $('table#table-data tr#field-'+id).remove();
        $('table#table-data tr#supp-'+id).remove();
        var row = $('#supp-' + id).length;
        alert(id);

       parent.remove();
        console.log(counterId);
        counterId = counterId - 1;
        console.log(counterId); 

        var id = $(this).data('id');
        var parent2 = $('#supp-'+id);
     //   parent2.remove();*/
    })


    //menampilkandisc_po
    $('.disc_item_po').change(function(){
      disc = $(this).val();
       jumlahharga = $('.jumlahharga_po').val();
       hsljml =  jumlahharga.replace(/,/g, '');
       console.log(hsljml);
       total = (parseInt(disc) / 100) * parseInt(hsljml);
       hasil = hsljml - total;
       numeric = Math.round(hasil).toFixed(2);
       $('.dpp_po').val(addCommas(numeric));
    })


    $('.tbmh-data').click(function(){
      $('.tbmh-po').attr('disabled' , true);
      var htmlrows = "<table class='table'> <tr> <td> na </td></tr> </table";
    

          $('.table-databarang').html(htmlrow);
                console.log($('.qty').val());
          //close
          $('#close').click(function(){
             $('.table-databarang').empty();
             $('.tbmh-po').attr('disabled', false);
          })

    }) 

    

</script>
@endsection
