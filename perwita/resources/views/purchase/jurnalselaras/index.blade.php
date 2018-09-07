@extends('main')

@section('title', 'dashboard')

@section('content')


<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Jurnal Selaras </h2>
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
                            <strong> Jurnal Selaras </strong>
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
                    <h5> Jurnal Selaras
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                    
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                 
                  <div class="box-body">
                    {{-- <button class="btn btn-success btn-md" onclick="FP()">
                      Faktur Pembelian
                    </button> --}}
                </div>   

                <div class="box-body">
                    <button class="btn btn-success btn-md" onclick="item()">
                     add item
                    </button>
                </div> 

                <div class="">
                    <button class="btn btn-success" onclick="nofpg()">
                        Get nota fpg
                    </button>
                </div>     
                

                <div class="">
                    <button class="btn btn-success" onclick="tglpo()">
                        Get no po
                    </button>
                </div>

                <div class="">
                    <button class="btn btn-success" onclick="fpgbankmasuk()">
                        bank masuk
                    </button>
                </div> 

                 <div class="">
                    <button class="btn btn-success" onclick="duplicatebank()">
                        duplicate bank masuk
                    </button>
                </div>

                <div class="">
                    <button class="btn btn-success" onclick="postingdonefpg()">
                        POSTING DONE FPG
                    </button>
                </div>



                <div class="box-body">
             
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

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    function postingdonefpg(){
        $.ajax({
        url : baseUrl + '/jurnalselaras/fpgpostingbank',
        type : "get",
        dataType : "json",
        success : function(response){
            
        }
      }) 
    }

        
     function duplicatebank(){
        $.ajax({
        url : baseUrl + '/jurnalselaras/duplicatebank',
        type : "get",
        dataType : "json",
        success : function(response){
            
        }
      })
     }


    function FP(){
      $.ajax({
        url : baseUrl + '/jurnalselaras/fakturpembelian',
        type : "get",
        dataType : "json",
        success : function(response){

        }
      })
    }
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
     
    function item(){
         $.ajax({
        url : baseUrl + '/jurnalselaras/item',
        type : "post",
        dataType : "json",
        success : function(response){

        }
      })
    }

    function tglpo(){
        $.ajax({
        url : baseUrl + '/jurnalselaras/tglpo',
        type : "post",
        dataType : "json",
        success : function(response){

        }
      })
    }

    function nofpg(){
        $.ajax({
        url : baseUrl + '/jurnalselaras/notafpg',
        type : "post",
        dataType : "json",
        success : function(response){

        }
      })
    }

    function fpgbankmasuk(){
        $.ajax({
        url : baseUrl + '/jurnalselaras/fpgbankmasuk',
        type : "post",
        dataType : "json",
        success : function(response){

        }
      })
    }
    
   
</script>
@endsection
