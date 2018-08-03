@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
 
  .disabled {
    pointer-events: none;
    opacity: 1;
 }

 .capital {
  text-transform: uppercase;
 }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
      <h2> Bon Sementara </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Transaksi Hutang</a>
          </li>
          <li class="active">
              <strong> Bon Sementara </strong>
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
                <div class="ibox-title" style="background: white">
                    <div  style="background: white" >
                      <h5> Bon Sementara </h5>
                      <a href="{{ url('bonsementaracabang/bonsementaracabang') }}" class="pull-right" style="color: white"><i class="fa fa-arrow-left"> Kembali</i></a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-8">
              <div class="box">
                <div class="box-body">
                    <form action="post" id="savebonsem">
                     <h3> <p > Data Kas Cabang <b class="namacabang">  </b> saat ini Rp <b class="kascabang">  500,000.00  </b> </p> </h3>
                     <br>

                    <table class="table">
                      <tr>
                        <th> Cabang </th>
                        <td>
                          @if(Auth::user()->punyaAkses('Bon Sementara Cabang','cabang'))
                             
                            <select class="form-control chosen-select-width cabang" name="cabang" required="">
                                @foreach($data['cabang'] as $cabang)
                              <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                              @endforeach
                            </select>
                          
                            @else
                              <td class="disabled"> 
                              <select class="form-control chosen-select-width disabled cabang" name="cabang" required="">
                                @foreach($data['cabang'] as $cabang)
                                <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif>{{$cabang->kode}} - {{$cabang->nama}} </option>
                                @endforeach
                              </select> 
                              </td>
                            @endif
                         </td>
                      </tr>
                      <tr>
                        

                        <th> No Nota </th>
                                            <input type='hidden' name='username' value="{{Auth::user()->m_name}}">
                        <td> <input type="text" class="form-control input-sm nonota" name="nonota" required="">  </td>
                      </tr>
                      <tr>  
                      <th> Tanggal </th>
                      <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl" name="tgl" required="">
                                      </div>
                            </td>
                      </tr>
                      <tr>
                        <th> Bagian </th>
                        <td> <input type="text" class="form-control bagian input-sm capital" name="bagian" required=""> </td>
                      </tr>
                      <tr>
                        <th> Nominal </th>
                        <td> <input type="text" class="nominal form-control input-sm" name="nominal" style="text-align:right" required=""> </td>
                      </tr>
                      <tr> 
                        <th> Keperluan </th>
                        <td> <input type="text" class="form-control input-sm keperluan capital" name="keperluan" required=""></td>
                      </tr>
                    </table>
                  
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="pull-right">
                    <button type="submit" class="btn btn-md btn-success simpandata"> Simpan </button>
                  </div>
                  </form>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
    


    


<div class="row" style="padding-bottom: 50px;"></div>


@endsection

@section('extra_scripts')
<script type="text/javascript">

  $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    }).datepicker("setDate", "0");

  $('.cabang').change(function(){
    comp = $('.cabang').val();
  $.ajax({
    url : baseUrl + '/bonsementaracabang/getnota',
    data : {comp},
    type : "get",
    dataType : 'json',
    success : function(response){
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

                    
                       nospp = 'BS' + month + year2 + '/' + comp + '/' +  response.idspp;
                      console.log(nospp);
                      $('.nonota').val(nospp);
                       nospp = $('.nonota').val();
                      $('.namacabang').text(response.namacabang);
    },
    error : function(){
      location.reload();
    }
  })
  })



  comp = $('.cabang').val();
  $.ajax({
    url : baseUrl + '/bonsementaracabang/getnota',
    data : {comp},
    type : "get",
    dataType : 'json',
    success : function(response){
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

                    
                       nospp = 'BS' + month + year2 + '/' + comp + '/' +  response.idspp;
                      console.log(nospp);
                      $('.nonota').val(nospp);
                       nospp = $('.nonota').val();

                       $('.namacabang').text(response.namacabang);
    },
    error : function(){
      location.reload();
    }
  })


   $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
     $('#savebonsem').submit(function(event){      
          kascabang = $('.kascabang').text();
          kascabang = kascabang.replace(/,/g, '');
         

          val =$('.nominal').val();
          
          nominal = val.replace(/,/g, '');
         
           /*if(parseFloat(kascabang) < parseFloat(nominal)){
            toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
          
            $(this).val('');
            return false;
           }*/

        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data BON SEMENTARA!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: true
          },
          function(){
               
        $.ajax({
          type : "POST",          
          data : form_data2,
          url : baseUrl + '/bonsementaracabang/save',
          dataType : 'json',
          success : function (response){
               alertSuccess();
               $('.simpandata').attr('disabled' ,true);
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
      });
     


  $('.nominal').change(function(){
    kascabang = $('.kascabang').text();
    kascabang = kascabang.replace(/,/g, '');
   

    val =$(this).val();
    val = accounting.formatMoney(val, "", 2, ",",'.');

    nominal = val.replace(/,/g, '');
   
     /*if(parseFloat(kascabang) < parseFloat(nominal)){
      toastr.info("Mohon maaf, Kas Kecil Cabang tidak mencukupi :) ");
      //$('.nominal').attr('readonly' , true);
      $(this).val('');
      return false;
     }*/

    $(this).val(val);
  });

</script>
@endsection
