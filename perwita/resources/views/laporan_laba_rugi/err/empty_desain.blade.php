@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
  .row-eq-height {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
  }

    #table_form input{
      padding-left: 5px;
    }

    #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    #tree th{
      padding:5px;
      border: 1px solid #ccc;
      font-weight: 600;
    }

    #tree td.secondTree{
      padding-left: 40px;
    }

    #tree td{
      border: 0px;
      padding: 5px;
    }

    #tree td.{
      color:blue;
    }

    #tree td.highlight{
      border-top:2px solid #aaa;
      border-bottom: 2px solid #aaa;
      color:#222;
    }

    #tree td.break{
      padding: 10px 0px;
      background: #eee;
    }

    #bingkai td.header{
      font-weight: bold;
    }

    #bingkai td.child{
      padding-left: 20px;
    }

    #bingkai td.total{
      border-top: 2px solid #999;
      font-weight: 600;
    }

    #bingkai td.no-border{
      border: 0px;
    }

  </style>
@endsection

@section('content')

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
                        <div class="box-body" style="min-height: 330px;">
                          <div class="col-md-12" style="border-bottom: 1px solid #eee; padding-bottom: 10px;">
                            <center><small class="text-muted">Ups . Kami Tidak Bisa Menemukan Satu Pun Desain Laba rugi Di Database, Sehingga Laporan Laba Rugi Tidak Bisa Ditampilkan. <br><b>Harap Membuat Desain Laba Rugi Terlebih Dahulu Dengan Mengklik Tombol Dibawah.</b></small></center>
                          </div>

                          <div class="col-md-12 m-t text-center">
                            <a class="btn btn-sm btn-primary tambahAkun" href="{{ url('master_keuangan/desain_laba_rugi/add')}}">
                              <i class="fa fa-plus"></i> &nbsp;Tambahkan Data Desain Laba Rugi
                            </a>
                          </div>

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

<!-- modal -->
<div id="modal_tampilkan" class="modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tampilan Desain Neraca</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body" id="wrap">

      </div>

    </div>
  </div>
</div>
  <!-- modal -->

@endsection



@section('extra_scripts')
  <script>
    $(document).ready(function(){
      

    })
  </script>
@endsection





