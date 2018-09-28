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
      <h2> Bank Masuk </h2>
      <ol class="breadcrumb">
          <li>
              <a>Home</a>
          </li>
          <li>
              <a>Purchase</a>
          </li>
          <li>
            <a>Bank Masuk</a>
          </li>
          <li class="active">
              <strong> Bank Masuk </strong>
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
                      <h5> Bank Masuk </h5>
                      <a href="{{ url('bonsementaracabang/bonsementaracabang') }}" class="pull-right" style="color: black"><i class="fa fa-arrow-left"> Kembali</i></a>
                    </div>
                </div>
                <div class="ibox-content">
                 <form method="post" action="{{url('bankmasuk/update')}}"  enctype="multipart/form-data" class="form-horizontal" id="myform">
                        <div class="row">
            <div class="col-sm-12">
              <div class="box">
                <div class="box-body">
                  <div class="table-responsive">
                    <div class="col-sm-12">
                        <table class="table">
                          <tr>
                            <th> Cabang </th>
                            <td> <select class="form-control chosen-select cabang" name="cabang">
                                          @foreach($data['cabang'] as $cabang)
                                          <option value="{{$cabang->kode}}" @if($data['BM'][0]->bm_cabangtujuan == $cabang->kode) selected="" @endif>
                                                {{$cabang->nama}}
                                          </option>
                                          @endforeach
                                        </select>
                            </td>
                            <th> Tanggal </th>
                            <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl tglbm" name="tgl" required="" value="{{$data['BM'][0]->bm_tglterima}}">
                                      </div>
                              </td>
                              <th> Nota </th>
                               <td> <input type='text' class='form-control input-sm notabm'name="notabm" readonly="" value="{{$data['BM'][0]->bm_nota}}">
                                <input type="hidden" value="{{$data['BM'][0]->bm_id}}"  name='idbm'>
                              </td>
                          </tr>
                        </table>
                    </div>
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table">
                                
                            <tr>
                                <th> Bank </th>
                                <td> <select class="form-control chosen-select bank" name="bank">
                                        @foreach($data['bank'] as $bank)
                                          <option value="{{$bank->mb_id}},{{$bank->mb_kode}}">
                                             {{$bank->mb_kode}} - {{$bank->mb_nama}}
                                          </option>
                                        </option>
                                        @endforeach
                                      </select>
                                </td>
                            </tr>
                            <tr>
                              <th> DK Bank </th>
                              <td> <input type='text' class="form-control input-sm dkbank" name='dkbank' value='D'> </td>
                            </tr>

                            <tr>
                              <th> Nominal </th>
                              <td> <input type='text' class="form-control input-sm nominalbank" name="nominalbank" value="{{$data['BM'][0]->bm_nominal}}"> </td>
                            </tr>

                            <tr>
                              <th> Keterangan BM </th>
                              <td> <input type="text" class="form-control input-sm keteranganbm" name="keteranganbm" value="{{$data['BM'][0]->bm_keterangan}}"> </td>
                            </tr>
                          </table>
                        </div>                     
                        

                    <div class="col-sm-6">
                    <table class="table">
                      <tr>
                        <th> Akun </th>
                        <td>
                        <select class="form-control chosen-select tabakun akun">
                          <option value=""> Pilih Akun </option>
                          @foreach($data['akun'] as $akun)
                            <option value="{{$akun->id_akun}}">
                                {{$akun->id_akun}} - {{$akun->nama_akun}}
                            </option>  
                          @endforeach
                        </select>
                        </td>
                      </tr>

                      <tr>
                        <th> DK </th>
                        <td> <input type="text" class="form-control input-sm tabakun akundka"> <input type='hidden' class='no'> </td>
                      </tr>

                      <tr>
                        <th> Nominal </th>
                        <td> <input type="text" class="form-control input-sm tabakun nominal" style="text-align:right"> </td>
                      </tr>

                      <tr>
                        <th> Keterangan Akun </th>
                        <td> <input type="text" class="form-control input-sm tabakun keterangan keteranganakun"> </td>
                      </tr>
                    </table>
                  </div>
                  </div>

                        <div class="pull-right">
                          <button class="btn btn-sm btn-info" id="tbmhdata" type="button">
                            <i class="fa fa-plus"> Tambah Data </i>
                          </button>
                            <br>
                  <br>
                  <br>
                  <br>
                        </div>

                </div>
              </div>
                
                  <table class="table" id="tablebank">
                    <thead>
                    <tr>
                      <th>
                        No
                      </th>
                      <th>
                        Nota BM
                      </th>
                      <th>
                        Bank
                      </th>
                      <th>
                          Tanggal
                      </th>
                      <th>
                        Akun
                      </th>
                      <th>
                         DK
                      </th>
                      <th>
                        Nominal
                      </th>
                      <th>
                        Keterangan
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                      @foreach($data['bmdt'] as $index=>$bmdt)
                        <tr class="trbank trbank{{$bmdt->bmdt_akun}}"> <td> {{$index + 1}}  </td>
                        <td> {{$bmdt->bm_nota}} </td>
                        <td> {{$data['BM'][0]->mb_nama}}   </td>
                        <td> {{ Carbon\Carbon::parse($data['BM'][0]->bm_tglterima)->format('d-m-Y') }} </td>
                        <td> <input type='text' class='form-control'value="{{$bmdt->nama_akun}}" readonly="">  <input type='hidden' class='form-control akundt' name='akun[]' value="{{$bmdt->id_akun}}"> </td>
                        <td><input type="text" class="form-control dkdt" name="dk[]" value="{{$bmdt->bmdt_dk}}" readonly=""> </td>
                       <td><input type="text" class="form-control input-sm nominaldt" name="nominal[]" value="{{$bmdt->bmdt_nominal}}" readonly=""></td>
                       <td><input type="text" class="keterangandt form-control input-sm" name="keteranganakun[]" value="{{$bmdt->bmdt_keterangan}}" readonly=""></td>
                        <td> <button class="btn btn-xs btn-danger removes-btn" type="button" onclick="hapus(this)"> <i class="fa fa-trash"> </i> </button> <button class="btn btn-xs btn-warning removes-btn" type="button" onclick="edit(this)"> <i class="fa fa-pencil"> </i> </button>  </td> </tr>
                      @endforeach
                  </tbody>
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


  $('.bank').change(function(){
    val = $(this).val();
    $('.dkbank').val('D');
  })

  $('.akun').change(function(){
    kodeakun = $(this).val();
       $.ajax({
      data : {kodeakun},
      url : baseUrl + '/bankmasuk/getakun',
      type : "get",
      dataType : "json",
      success : function(response){
        $('.akundka').val(response);
      }
    })
   
  })

  $('.nominal').change(function(){
     val =$(this).val();
     val = accounting.formatMoney(val, "", 2, ",",'.');
     nominal = val.replace(/,/g, '');
     $(this).val(addCommas(nominal));
  })

  $('.nominalbank').change(function(){
     val =$(this).val();
     val = accounting.formatMoney(val, "", 2, ",",'.');
     nominal = val.replace(/,/g, '');
     $(this).val(addCommas(nominal));
  })

  $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    });

  $('.cabang').change(function(){
    cabang = $(this).val();
    tgl = $('.tglbm').val();
    databank = $('.bank').val();
    kodebank = databank.split(",");
    bank = kodebank[0];
    $.ajax({
      data : {cabang,tgl,bank},
      url : baseUrl + '/bankmasuk/getnota',
      type : "get",
      dataType : "json",
      success : function(response){
        $('.notabm').val(response);
      }
    })
  })

   

  $('.tglbm').change(function(){
    tgl = $('.tglbm').val();
    databank = $('.bank').val();
    kodebank = databank.split(",");
    bank = kodebank[0];
    cabang = $('.cabang').val();
     $.ajax({
      data : {cabang,tgl,bank},
      url : baseUrl + '/bankmasuk/getnota',
      type : "get",
      dataType : "json",
      success : function(response){
        $('.notabm').val(response);
      },
       error : function(){
        location.reload();
      }
    })
  })


   $('.bank').change(function(){
    tgl = $('.tglbm').val();
    databank = $('.bank').val();
    kodebank = databank.split(",");
    bank = kodebank[0];
    cabang = $('.cabang').val();
     $.ajax({
      data : {cabang,tgl,bank},
      url : baseUrl + '/bankmasuk/getnota',
      type : "get",
      dataType : "json",
      success : function(response){
        $('.notabm').val(response);
      },
       error : function(){
        location.reload();
      }
    })
  })


  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      }); 
  
  $('#tbmhdata').click(function(){

     length = $('tr.trbank').length;

     no = parseInt(length) + 1 ; 

   
    dataakun = $('.akun').val();
    akun2 = dataakun.split(",");
    akun = akun2[0];
    dk = $('.akundka').val();
    nominal = $('.nominal').val();
    keteranganakun = $('.keteranganakun').val();
    keteranganbm = $('.keteranganbm').val();
    tanggal = $('.tgl').val();
    nota = $('.notabm').val();
    bank = $('.bank').val();
    bank = bank.split(",");
    bank = bank[1];
    nodata = [];
    

    $('.akundt').each(function(){
      val = $(this).val();
      val2 = val.split(",");
      akund = val2[0];
      nodata.push(akund);  
    });
  
    index = nodata.indexOf(akun);
    



    if(index == -1){
      html = "<tr class='trbank trbank"+akun+"'> <td>"+no+" <input type='hidden' class='nodata' value='"+no+"'></td>" +
            "<td>"+nota+" </td>"+
            "<td>"+bank+"   </td>"+
            "<td>"+tanggal+" </td>"+
            "<td> <input type='text' class='form-control akundt' name='akun[]' value='"+akun+"'> </td>" +
            "<td><input type='text'class='form-control dkdt' name='dk[]' value='"+dk+"'></td>"+
            "<td><input type='text' class='form-control input-sm nominaldt ' name='nominal[]' value='"+nominal+"'></td>" +
            "<td><input type='text' class='keterangandt form-control input-sm' name='keteranganakun[]' value='"+keteranganakun+"'></td>"+
            "<td> <button class='btn btn-xs btn-danger removes-btn' type='button' onclick='hapus(this)'> <i class='fa fa-trash'> </i> </button> <button class='btn btn-xs btn-warning removes-btn' type='button' onclick='edit(this)'> <i class='fa fa-pencil'> </i> </button>  </td>" +
            "</tr>";

      $('#tablebank').append(html);  

    }
    else {
  
         var a  = $('.trbank'+akun);
         $(a).find('.akundt').val(dataakun);
         $(a).find('.dkdt').val(dk);
         $(a).find('.nominaldt').val(nominal);
         $(a).find('.keterangandt').val(keteranganakun);

    }
    

       $('.tabakun').val('');
  })

  function hapus(a){
    var par  = $(a).parents('tr');
    par.remove();
  }

  function edit(a){
    var par = $(a).parents('tr');
    akun = $(par).find('.akundt').val();
    dk = $(par).find('.dkdt').val();
    nominal = $(par).find('.nominaldt').val();
    keterangan = $(par).find('.keterangandt').val();
    nodata = $(par).find('.nodata').val();
  
    $('.akun').val(akun);
    $('.akundka').val(dk);
    $('.nominal').val(nominal);
    $('.keteranganakun').val(keterangan);
    $('.no').val(nodata);

    $('.akun').trigger("chosen:updated");
    $('.akun').trigger("liszt:updated");
  }
  

  $('#myform').submit(function(event){      
        event.preventDefault();
          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
        
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Bank Masuk!",
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
          url : baseUrl + '/bankmasuk/updatedata',
          dataType : 'json',
          success : function (response){
            
             if(response.status == 'sukses'){
               alertSuccess();
                $('.simpandata').hide();
             }
             else if(response.status == 'gagal') {
              swal({
                  title: "error!",
                          type: 'error',
                          text: response.info,
                          timer: 900,
                         showConfirmButton: false
                       
                  });
             }

          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
      });

</script>
@endsection
