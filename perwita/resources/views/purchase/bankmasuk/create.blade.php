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
                      <h5> Bon Sementara </h5>
                      <a href="{{ url('bonsementaracabang/bonsementaracabang') }}" class="pull-right" style="color: black"><i class="fa fa-arrow-left"> Kembali</i></a>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-sm-12">
              <div class="box">
                <div class="box-body">
                  <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <table class="table">
                                <tr>
                                  <th> Cabang </th>
                                  <td> <select class="form-control chosen-select">
                                          @foreach($data['cabang'] as $cabang)
                                          <option value="{{$cabang->kode}}">
                                                {{$cabang->nama}}
                                          </option>
                                          @endforeach
                                        </select>
                                  </td>
                                </tr>

                                <tr>
                                      <th> Nota </th>
                                      <td> <input type='text' class='form-control input-sm notabm'> </td>
                                </tr>
                      
                            <tr>
                              <th> Tanggal </th>
                              <td> <div class="input-group date">
                                          <span class="input-sm input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control tgl tglbm" name="tgl" required="">
                                      </div>
                              </td>
                            </tr>
                            <tr>
                                <th> Bank </th>
                                <td> <select class="form-control chosen-select">
                                        @foreach($data['bank'] as $bank)
                                          <option value="{{$bank->mb_id}}">
                                                {{$bank->mb_nama}}
                                          </option>
                                        </option>
                                        @endforeach
                                      </select>
                                </td>
                            </tr>
                            <tr>
                              <th> Keterangan BM </th>
                              <td> <input type="text" class="form-control input-sm"> </td>
                            </tr>
                          </table>
                        </div>                     
                        

                    <div class="col-sm-6">
                    <table class="table">
                      <tr>
                        <th> Akun </th>
                        <td>
                        <select class="form-control chosen-select akun">
                          @foreach($data['akun'] as $akun)
                            <option value="{{$akun->id_akun}},{{$akun->akun_dka}}">
                              {{$akun->nama_akun}}
                            </option>  
                          @endforeach
                        </select>
                        </td>
                      </tr>

                      <tr>
                        <th> DK </th>
                        <td> <input type="text" class="form-control input-sm akundka"> </td>
                      </tr>

                      <tr>
                        <th> Nominal </th>
                        <td> <input type="text" class="form-control input-sm nominal"> </td>
                      </tr>

                      <tr>
                        <th> Keterangan Akun </th>
                        <td> <input type="text" class="form-control input-sm keterangan"> </td>
                      </tr>
                    </table>
                  </div>
                  </div>

                        <div class="pull-right">
                          <button class="btn btn-sm btn-info" id="tbmhdata">
                            <i class="fa fa-plus"> Tambah Data </i>
                          </button>
                            <br>
                  <br>
                  <br>
                  <br>
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
                         Dk
                      </th>
                      <th>
                        Nominal
                      </th>
                      <th>
                        Keterangan
                      </th>
                    </tr>
                  </thead>
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

  $('.akun').change(function(){
    val = $(this).val();
    split = val.split(",");


    dk = split[0];
    $('.dk').val(dk);
  })

  $('.nominal').change(function(){
     val =$(this).val();
     val = accounting.formatMoney(val, "", 2, ",",'.');
     nominal = val.replace(/,/g, '');
  })

  $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate : 'today',
    }).datepicker("setDate", "0");

  $('.cabang').change(function(){
    cabang = $(this).val();
    tgl = $('.tglbm').val();
    bank = $('.bank').val();
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

    cabang = $('.cabang').val();
    tgl = $('.tglbm').val();
    bank = $('.bank').val();
    $.ajax({
      data : {cabang,tgl,bank},
      url : baseUrl + '/bankmasuk/getnota',
      type : "get",
      dataType : "json",
      success : function(response){
        $('.notabm').val(response);
      }
    })

  $('.tglbm').change(function(){
    tgl = $('.tglbm').val();
    bank = $('.bank').val();
    cabang = $(this).val();
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

  $('#tbmhdata').click(function(){

  })


</script>
@endsection
