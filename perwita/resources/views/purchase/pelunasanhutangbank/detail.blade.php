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
                            <strong> Detail Pelunasan Hutang / Pembayaran Bank </strong>
                        </li>

                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>

            <br>
    <form method="post" action="{{url('pelunasanhutangbank/update')}}"  enctype="multipart/form-data" class="form-horizontal" id="formfpg">

    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Pelunasan Hutang / Pembayaran Bank
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
            
                      <div class="text-right">
                       <a class="btn btn-default" aria-hidden="true" href="{{ url('pelunasanhutangbank/pelunasanhutangbank')}}"> <i class="fa fa-arrow-circle-left"> </i> &nbsp; Kembali  </a> 
                    </div>  
               
                </div>

                <div class="ibox-content">
                <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  <div class="box-body">
                      <div class="row">
                      <div class="col-xs-6">
                           <table border="0" class="table table-stripped">

                          <tr>
                            <td> 
                              Cabang
                            </td>
                            <td>
                              <select class="chosen-select-width form-control cabang" name="cabang">
                                  @foreach($data['cabang'] as $cabang)
                                  <option value="{{$cabang->kode}}" @if($data['bbk'][0]->bbk_cabang == $cabang->kode) selected @endif disabled="">
                                    {{$cabang->nama}}
                                  </option>
                                  @endforeach
                              </select>
                            </td>
                          </tr>

                          <tr>
                            <td width="150px">
                          No BBK
                            </td>
                            <td>
                             <input type="text" class="input-sm form-control nobbk" readonly="" name="nobbk" value='{{$data['bbk'][0]->bbk_nota}}'>
                            </td>
                          </tr>

                          <tr>
                            <td> Kode Bank </td>
                            <td>
                              <select class="form-control kodebank" name="kodebank">
                                @foreach($data['bank'] as $bank)
                                  <option value="{{$bank->mb_id}}"> {{$bank->mb_kode}} - {{$bank->mb_nama}} </option>
                                @endforeach
                              </select>
                             </td>
                          </tr>

                          <tr>
                            <td> Tanggal </td>
                            <td>  <div class="input-group date" >
                                          <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tglbbk" value="{{$data['bbk'][0]->bbk_tgl}}">
                              </div> </td>
                            </td>
                          </tr>
                          </table>
                      </div>

                        <div class="col-xs-6">
                          <table border="0" class="table">
                            <tr>
                              <td width="150px">
                              Cek / BG
                              </td>
                              <td>
                               <input type="text" class="input-sm form-control cekbg" readonly="" style='text-align:right;' name="totalcekbg" value="{{ number_format($data['bbk'][0]->bbk_cekbg, 2) }}">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Biaya
                              </td>
                              <td>
                              <input type="text" class="form-control totalbiaya" readonly="" style='text-align: right' name="totalbiaya" value="{{ number_format($data['bbk'][0]->bbk_biaya, 2) }} " readonly="">
                              </td>
                            </tr>

                            <tr>
                              <td>
                                Total
                              </td>
                              <td>
                                <input type="text" class="form-control total" readonly="" style='text-align:right;'' name="total" value="{{ number_format($data['bbk'][0]->bbk_total, 2) }}" readonly="">
                              </td>
                            </tr>

                          <tr>
                            <td>Keterangan </td>
                            <td> <input type="text" class="input-sm form-control" name="keteranganheader">  </td>
                            <td> <input type="hidden" class="input-sm form-control flag" name="flag" value="{{$data['bbk'][0]->bbk_keterangan}}" readonly="">   </td>
                          </tr>
                          </table>
                        </div>


                      </div>
                      </div>

              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

                </div>
            </div>
        </div>
    </div>

        <div class="row">
           <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Detail Cek /  BG 
                
                     </h5>   
                </div>

                 <div class="ibox-content">
                   <div class="row">
                      <div class="col-xs-12">
                      <div class="box">
                        <div class="box-header">
                        </div>

                        <div class="box-body">

                            <!--tab-->                            
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="tabs-container">
                                      <ul class="nav nav-tabs">
                                          <li class="active"><a data-toggle="tab" href="#tab-1"> Detail Cek / BG </a></li>
                                          <li class=""><a data-toggle="tab" href="#tab-2"> Biaya - Biaya </a></li>
                                      </ul>
                                      <div class="tab-content">
                                          <div id="tab-1" class="tab-pane active">
                                              <div class="panel-body">
                                              
                                                   <div class="col-sm-12">
                                                    <table class='table table-stripped table-bordered' id="tbl-hasilbank">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th>
                                                        <th> Tgl FPG </th>
                                                        <th> No Transaksi </th> 
                                                        <th> Jatuh Tempo </th>
                                                        <th> Acc Bank </th>
                                                        <th> Nominal </th>
                                                        <th> Supplier </th>
                                                        <th> Keterangan </th>  
                                                       <!--  <th> Aksi </th>   -->  
                                                      </tr>
                                                        @if($data['bbk'][0]->bbk_flag == 'CEKBG')
                                                        <?php $n = 1 ?>
                                                        @for($i=0; $i < count($data['bbkd']) ; $i++)
                                                          @for($j=0; $j < count($data['bbkd'][$i]); $j++)
                                                        <tr>
                                                         <td> <?php echo $n ?> </td>
                                                         <td>  {{$data['bbkd'][$i][$j]->bbk_nota}}</td>
                                                         <td> {{ Carbon\Carbon::parse($data['bbkd'][$i][$j]->bbkd_tglfpg)->format('d-M-Y ') }} </td>
                                                         <td> {{$data['bbkd'][$i][$j]->bbkd_nocheck}} </td>
                                                         <td> {{ Carbon\Carbon::parse($data['bbkd'][$i][$j]->bbkd_jatuhtempo)->format('d-M-Y ') }} </td>
                                                         <td> {{$data['bbkd'][$i][$j]->mb_kode}} </td>
                                                         <td style="text-align: right">   {{ number_format($data['bbkd'][$i][$j]->bbkd_nominal, 2) }}</td>
                                                         @if($data['bbkd'][$i][$j]->bbkd_jenissup == 'supplier')
                                                          <td> {{$data['bbkd'][$i][$j]->nama_supplier}}</td>
                                                         @else
                                                           <td> {{$data['bbkd'][$i][$j]->nama}}</td>
                                                         @endif
                                                        <!--  <td> {{$data['bbkd'][$i][$j]->bbkd_jenissup}}</td> -->
                                                         <td> {{$data['bbkd'][$i][$j]->bbkd_keterangan}} </td>
                                                        </tr>
                                                          @endfor
                                                          <?php $n++ ?>
                                                        @endfor
                                                      @endif
                                                    </table>
                                                   </div>

                                              </div>
                                          </div>
                                          <div id="tab-2" class="tab-pane">
                                              <div class="panel-body">
                                                  
                                                   <div class="col-sm-12">
                                                    <table class='table table-stripped table-bordered' id="tbl-biaya">
                                                      <tr>
                                                        <th> No </th>
                                                        <th> No Bukti </th> 
                                                        <th> Acc Bank </th>
                                                        <th> D / K </th>
                                                        <th> Nominal </th>
                                                        <th> Keterangan </th>
                                                     <!--    <th> Aksi </th> -->
                                                      </tr>
                                                      @if($data['bbk'][0]->bbk_flag == 'BIAYA')
                                                      @foreach($data['bbkd'] as $index=>$bbkd)
                                                      <tr>
                                                        <td> {{$index + 1}} </td>
                                                        <td> {{$bbkd->bbk_nota}} </td>
                                                        <td> {{$bbkd->bbkb_akun}} - {{$bbkd->nama_akun}} </td>
                                                        <td> {{$bbkd->bbkb_dk}} </td>
                                                        <td style='text-align: right'> {{ number_format($bbkd->bbkb_nominal, 2) }}</td>
                                                        <td> {{$bbkd->bbkb_keterangan}} </td>
                                                       <!--  <td> </td> -->
                                                      </tr>
                                                      @endforeach
                                                      @endif
                                                    </table>
                                                   </div>
                                              </div>
                                          </div>
                                      </div>


                                  </div>
                              </div>
                             
                          </div>
                          <br>
                          <br>



                          <!-- MODAL -->
                            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog"  aria-hidden="true">
                              <div class="modal-dialog" style="min-width: 1200px !important; min-height: 800px">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button style="min-height:0;" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                     
                                    <h4 class="modal-title" style="text-align: center;"> NO CHEUQUE / BG </h4>     
                                  </div>
                                                
                                  <div class="modal-body"> 
                                    <table class="table table-bordered" id="tbl-cheuque">
                                      <thead>
                                        <tr> 
                                          <th style="width:50px">No</th> <th> No Transaksi Bank  </th> <th> No FPG </th> <th> Jenis Bayar Bank </th> <th> Nominal </th> <th> Aksi </th>
                                        </tr>
                                      </thead>
                                    <tbody>

                                    </tbody>
                                    </table>
                                  </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary" id="buttongetcek">Simpan</button>
                                       
                                    </div>
                                </div>
                              </div>
                           </div>


                            <div class="pull-right">

                             <a class="btn btn-sm btn-warning" href="{{url('pelunasanhutangbank/cetak')}}"> <i class="fa fa-print" aria-hidden="true"></i> Cetak BBK  </a>  
                             <!--  <button class="btn btn-success" type="submit"> Simpan </button> -->
                              <!--  <input type="submit" id="submit" name="submit" value="Simpan" class="btn btn-sm btn-success simpansukses"> -->
                              
                          </div>

                        </div>
                      </div>
                      </div>
                   </div>
                 </div>
            </div>
            </div>
        </div>
  
</form>
<div class="row" style="padding-bottom: 50px;"></div>


@endsection



@section('extra_scripts')
<script type="text/javascript">



     $('#formbbk').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    });

     $('#formbbk input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    });

    $('#formbbk input').change(function(){
      this.setCustomValidity("");
    });

     $('#formfpg').submit(function(event){
       
       url : baseUrl + '/pelunasanhutangbank/simpan';

        event.preventDefault();
         var post_url2 = $(this).attr("action");
         var form_data2 = $(this).serialize();
         swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Form FPG!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
           function(){
         $.ajax({
          type : "post",
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
                swal({
                  title: "Berhasil!",
                          type: 'success',
                          text: "Data berhasil disimpan",
                          timer: 900,
                         showConfirmButton: false
                       
                  });
             
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
       });
       
    })  

    arrtransaksi = [];
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
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
    
    $('.nocheck').click(function(){
        kodebank = $('.kodebank').val();

     

        $.ajax({
          type : "get",
          data : {kodebank},
          url : baseUrl + '/pelunasanhutangbank/nocheck',
          dataType : "json",
          success : function(response){

              length = arrtransaksi.length;
              
              $('.datacek').empty();
              databank = response.fpgbank;
              $no = 1;

              var tablecek = $('#tbl-cheuque').DataTable();
              tablecek.clear().draw();

              if(length != 0){
                 for(j = 0 ; j < length; j++){
                  for(i = 0; i < databank.length; i++){
                    
                    if(arrtransaksi[j] ==  databank[i].fpgb_nocheckbg){

                    }
                    else {
                      row = "<tr class='datacek"+databank[i].fpgb_nocheckbg+"' id='transaksi"+databank[i].fpgb_nocheckbg+"'> <td>"+$no+"</td> <td>"+databank[i].fpgb_nocheckbg+"</td> <td>"+databank[i].fpg_nofpg+"</td> <td>"+databank[i].fpgb_jenisbayarbank+"</td> <td style='text-align:right'>"+addCommas(databank[i].fpgb_nominal)+"</td> <td>  <input type='checkbox' id="+databank[i].fpgb_id+","+databank[i].fpgb_idfpg+" class='checkcek' value='option1' aria-label='Single checkbox One'> <label></label>  </td> </tr> ";
                     $no++;
                     tablecek.rows.add($(row)).draw(); 
                    }
                      
                  }
                }
              }
              else {
                 for(i = 0; i < databank.length; i++){
                    row = "<tr class='datacek"+databank[i].fpgb_nocheckbg+"' id='transaksi"+databank[i].fpgb_nocheckbg+"'> <td>"+$no+"</td> <td>"+databank[i].fpgb_nocheckbg+"</td> <td>"+databank[i].fpg_nofpg+"</td> <td>"+databank[i].fpgb_jenisbayarbank+"</td> <td style='text-align:right'>"+addCommas(databank[i].fpgb_nominal)+"</td> <td>  <input type='checkbox' id="+databank[i].fpgb_id+","+databank[i].fpgb_idfpg+" class='checkcek' value='option1' aria-label='Single checkbox One'> <label></label>  </td> </tr> ";
                     $no++;
                     tablecek.rows.add($(row)).draw(); 
                 }
              }
             
          }
        })
    })
      
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

     $('.cabang').change(function(){    
      var comp = $(this).val();
        $.ajax({    
            type :"post",
            data : {comp},
            url : baseUrl + '/pelunasanhutangbank/getnota',
            dataType:'json',
            success : function(data){
               console.log(data);
                var d = new Date();
                
                //tahun
                var year = d.getFullYear();
                //bulan
                var month = d.getMonth();
                var month1 = parseInt(month + 1)
                console.log(d);
                console.log();
                console.log(year);

                if(month < 10) {
                  month = '0' + month1;
                }

                console.log(d);

                tahun = String(year);
//                console.log('year' + year);
                year2 = tahun.substring(2);
                //year2 ="Anafaradina";

              
                 nobbk = 'BK-' + month1 + year2 + '/' + comp + '/' +  data;
              //  console.log(nospp);
                $('.nobbk').val(nobbk);
            }
        })

    })
      
     nilaicekbg = 0;
     nilaitotal = 0; 
     $nomr = 1;
    $('.tmbhdatacek').click(function(){


        nofpg = $('.nofpg').val();
        nobbk = $('.nobbk').val();
        flag = $('.flag').val();
          
      if(flag == 'BIAYA'){
        toastr.info("Anda sudah mengisi form 'biaya biaya' mohon untuk dilanjutkan :)");       
      }
      else if(nofpg == ''){
        toastr.info("Mohon isi data transaksi bank");
      }
      else if(nobbk == ''){
        toastr.info("Mohon isi data cabang");
      }
     
      else {
        flag = $('.flag').val('CEKBG');
      nofpg = $('.nofpg').val();
      notransaksi =$('.nocheck').val();
      accbank = $('.bank').val();
      namabank = $('.namabank').val();
      nominal = $('.nominal').val();
      keterangan = $('.keterangan').val();
      tgl = $('.tgl').val();
      supplier = $('.kodesup').val();
      namasupplier = $('.namasupplier').val();
      jatuhtempo = $('.jatuhtempo').val();
      idbank = $('.idbank').val();
      jenissup = $('.jenissup').val();

      row = "<tr class='transaksi bayar"+$nomr+"' id='datacek"+notransaksi+"'>" +
          "<td>"+$nomr+"</td> <td> <input type='text' class='input-sm form-control' value='"+nofpg+"' name='nofpg[]'></td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+tgl+"' name='tgl[]'></td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+notransaksi+"' name='notransaksi[]'>" +
          "</td> <td> <input type='text' class='input-sm form-control' name='jatuhtempo[]' value="+jatuhtempo+"> </td>" +
          "<td> <input type='text' class='input-sm form-control' value= "+accbank+"-"+namabank+" name='bank[]'> <input type='hidden' class='idbank' name='idbank[]' value='"+idbank+"'>  </td>" +
          "<td style='text-align:right'> <input type='text' class='input-sm form-control' value= '"+addCommas(nominal)+"' name='nominal[]'> </td>" +
          "<td><input type='text' class='input-sm form-control' value= '"+supplier+"-"+namasupplier+"' name='supplier[]'> <input type='text' class='input-sm form-control' value= '"+jenissup+"' name='jenissup[]'> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+keterangan+"' name='keterangan[]'></td>" +
          "<td> <button class='btn btn-danger btn-sm removes-btn' type='button' data-id="+$nomr+" data-cek='"+notransaksi+"' data-nominal='"+nominal+"'><i class='fa fa-trash'></i></button> </td> </tr>";


      arrtransaksi.push(notransaksi);
        $('.bg').val('');
      $('#tbl-hasilbank').append(row);
      $nomr++;

      nominal2 =  nominal.replace(/,/g, '');
      nilaicekbg = parseFloat(parseFloat(nilaicekbg) + parseFloat(nominal2));
      nilaicekbg2 = nilaicekbg.toFixed(2);

      $('.cekbg').val(addCommas(nilaicekbg2));
      $('.total').val(addCommas(nilaicekbg2));
      }
    })



      $(document).on('click','.removes-btn',function(){
          id = $(this).data('id');
          cek = $(this).data('cek');
          nominal = $(this).data('nominal');
          parentbayar = $('.bayar'+id);
          $('#datacek' + cek).show();
          $('.bg').val('');
          cekbg = $('.cekbg').val();
          cekbg2 =  cekbg.replace(/,/g, '');
          nominal2 = nominal.replace(/,/g,'');
          alert(cekbg2);
          alert(nominal2);
          nilaicekbg = parseInt(cekbg2) - parseInt(nominal2);
          $('.cekbg').val(addCommas(nilaicekbg));
          $('.total').val(addCommas(nilaicekbg));
       //   parent.remove();
          parentbayar.remove();
      })


    $('#buttongetcek').click(function(){
        var checked = $(".checkcek:checked").map(function(){
          return this.id;
        }).toArray();

         data = checked;
         idfpgb = [];
         idfpg = [];
        for(z=0;z<data.length;z++){
          string = data[z].split(",");
          idfpgb.push(string[0]);    
          idfpg.push(string[1]);
        }

        $.ajax({
            url : baseUrl + '/pelunasanhutangbank/getcek',
            data : {idfpgb,idfpg},
            type : "post",
            dataType : "json",
            success : function (response){
                $('#myModal2').modal('hide');
                  $('.nofpg').val(response.fpg[0].fpg_nofpg);
                  $('.nocheck').val(response.fpg[0].fpgb_nocheckbg);
                    $('.jatuhtempo').val(response.fpg[0].fpgb_jatuhtempo);
                    $('.nominal').val(addCommas(response.fpg[0].fpgb_nominal));
                    $('.keterangan').val(response.fpg[0].fpg_keterangan);
                    $('.bank').val(response.fpg[0].mb_kode);
                    $('.namabank').val(response.fpg[0].mb_nama)
                    $('.tgl').val(response.fpg[0].fpg_tgl );
                    $('.idbank').val(response.fpg[0].mb_id);

                if(response.fpg[0].fpg_jenisbayar == '2' || response.fpg[0].fpg_jenisbayar == '3' ) {                  
                    $('.kodesup').val(response.fpg[0].no_supplier);
                    $('.namasupplier').val(response.fpg[0].nama_supplier); 
                    $('.jenissup').val('supplier');            
                }
                else if(response.fpg[0].fpg_jenisbayar == '4') {
                    $jenissup = response.fpg[0].um_jenissup;
                    if($jenissup == 'supplier'){                      
                      $('.kodesup').val(response.fpg[0].no_supplier);
                      $('.namasupplier').val(response.fpg[0].nama_supplier);   
                      $('.jenissup').val('supplier');              
                    }
                    else if($jenissup == 'agen'){                    
                      $('.kodesup').val(response.fpg[0].kode);
                      $('.namasupplier').val(response.fpg[0].nama);
                      $('.jenissup').val('agen');                    
                    }

                }
                else if(response.fpg[0].fpg_jenisbayar == '9'){
                   $('.kodesup').val(response.fpg[0].kode);
                    $('.namasupplier').val(response.fpg[0].nama);
                    $('.jenissup').val('subcon');   
                }
                else if(response.fpg[0].fpg_jenisbayar == '1') {
                  $('.kodesup').val(response.fpg[0].kode);
                    $('.namasupplier').val(response.fpg[0].nama);
                    $('.jenissup').val('cabang');   
                }
                else {
                   $('.kodesup').val(response.fpg[0].kode);
                   $('.namasupplier').val(response.fpg[0].nama); 
                }
            }
        })

    })
    

    //BIAYA BIAYA
      $('.akun').change(function(){
        val = $(this).val();
        string = val.split(",");
        akundka = string[1];
        $('.dk').val(akundka);
      })

      $('.jumlahaccount').change(function(){
        val = $(this).val();
        val = accounting.formatMoney(val, "", 2, ",",'.');
        $(this).val(val);
      })

      $nmrbiaya = 1;
      totalbiaya = 0;
      $('#tmbhdatabiaya').click(function(){
          akun = $('.akun').val();
          nobbk = $('.nobbk').val();
          flag = $('.flag').val();

          if(flag == 'CEKBG'){
            toastr.info("Anda sudah mengisi form 'CEK BG' mohon untuk dilanjutkan :)");
          
          }
          else if(akun == ''){
            toastr.info("Mohon isi data akun bank");
          }
          else if(nobbk == ''){
            toastr.info("Mohon isi data cabang");
          }
          else {
            $('.flag').val('BIAYA');
          akun = $('.akun').val();
          string = akun.split(",");
          idakun = string[0];
          dk = string[1];
          jumlah = $('.jumlahaccount').val();
          keterangan = $('.keteranganbiaya').val();
          nobbk = $('.nobbk').val();

          rowHtml = "<tr class='transaksi"+$nmrbiaya+"'> <td>"+$nmrbiaya+"</td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+nobbk+"'> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+idakun+"' name='akun[]'> </td>" +
          "<td>  <input type='text' class='input-sm form-control' value='"+dk+"' name='dk[]'> </td>" +
          "<td> <input type='text' class='input-sm form-control' value='"+jumlah+"' name='jumlah[]'> </td>" +
          "<td><input type='text' class='input-sm form-control' value=' "+keterangan+"' name='keterangan[]'></td>" +
          "<td> <button class='btn btn-danger btn-sm remove-btn' type='button' data-id="+$nmrbiaya+" data-cek='"+akun+"' data-nominal='"+jumlah+"'><i class='fa fa-trash'></i></button>  </td> </tr>";

          $('#tbl-biaya').append(rowHtml);


          $('.biaya').val('');

          jumlah2 = jumlah.replace(/,/g, '');
          totalbiaya = parseFloat(parseFloat(totalbiaya) + parseFloat(jumlah2)).toFixed(2);
          $('.totalbiaya').val(addCommas(totalbiaya));
          $('.total').val(addCommas(totalbiaya));
          $nmrbiaya++;

          }
      })

      $(document).on('click','.remove-btn',function(){
            id = $(this).data('id');
            cek = $(this).data('cek');
            nominal = $(this).data('nominal');
            parentbayar = $('.transaksi'+id);
            $('#datacek' + cek).show();
            biaya = $('.biaya').val();
            biaya2 =  biaya.replace(/,/g, '');
            nominal2 = nominal.replace(/,/g,'');
            $('.biaya').val('')
            nilaibiaya = parseInt(biaya2) - parseInt(nominal2).toFixed(2);
            $('.totalbiaya').val(addCommas(nilaibiaya));
            $('.total').val(addCommas(nilaibiaya));
         //   parent.remove();
            parentbayar.remove();
          })

</script>
@endsection
