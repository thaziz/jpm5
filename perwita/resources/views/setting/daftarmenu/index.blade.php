@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                  <br>
                    <h3> Master Menu</h3>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Pengguna</a>
                        </li>
                        <li>
                          <a> Master Menu</a>
                        </li>
                        <li class="active">
                            <strong> Master Menu </strong>
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
                    <h5> Master Menu
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                      <button class="btn btn-info" style="margin-right: 10px;" type="button" id="createmodal" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus"> </i> &nbsp; Tambah Menu </button>
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                    
                <div class="box-body">
                    
             
                    <br>
                    <br>

                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:40px">No</th>
                        <th> Nama Menu </th>
                        <th> Keterangan </th>
                    </tr>
                 
                    </thead>
                    
                    <tbody>
              



                    </tbody>
                   
                  </table>

                  <!-- Modal -->
                     <div class="modal fade" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
                                <div class="modal-dialog" style="min-width: 800px !important; min-height: 800px">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button style="min-height:0;" type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                      </button>                     
                                      <h4 class="modal-title" style="text-align: center;"> 
                                       </h4>     
                                    </div>
                                                  
                                    <div class="modal-body">
                                    <button class="btn btn-xs btn-info tmbhmenu">
                                            <i class="fa fa-plus"> Tambah Daftar Menu </i>
                                    </button>
                                    <br>
                                    <br>
                                     <form method="post" action="{{url('setting/savedaftarmenu')}}"  enctype="multipart/form-data" class="form-horizontal" id="formsave">
                                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <table class="table table-stripped table-bordered" id="tbl-menu">
                                        <thead>
                                            <tr>
                                                <td> No </td>
                                                <td> Nama Menu</td>
                                            </tr>
                                        </thead>
                                    </table>                           
                                               
                                         </div>

                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-white" data-dismiss="modal">Batal</button>
                                          <button type="submit" class="btn btn-primary " id="buttonsimpan">
                                            Simpan
                                          </button>
                                         
                                      </div>
                                      
                                  </div>
                                </div>
                             </div> 

                  <!-- ENd Modal -->



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


    tableDetail = $('.tbl-item').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $no = 0;
    $('.tmbhmenu').click(function(){
        $no++;
        row = "<tr> <td style='text-align:center'>"+$no+"</td> <td> <input type='text form-control' name='menu[]'> </td> </tr>";
        $('#tbl-menu').append(row);
    })
    
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

  

    var arrnobrg = [];

    $('#formsave input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formsave input').change(function(){
      this.setCustomValidity("");
    })

    $('#formsave').submit(function(){

          var post_url2 = $(this).attr("action");
          var form_data2 = $(this).serialize();
          event.preventDefault();
         $.ajax({
          type : "POST",          
          data : form_data2,
          url : post_url2,
          dataType : 'json',
          success : function (response){
            $('#myModal').modal('toggle');
             
          }
      })
     })


    function hapusData(id){
    
            swal({
            title: "apa anda yakin?",
                    text: "data yang dihapus tidak akan dapat dikembalikan",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ya, Hapus!",
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true
            },
                    function(){                        
                    $('#' +id).submit();
                    swal("Terhapus!", "Data Anda telah terhapus.", "success");
                  /*  swal("Deleted!", "Your imaginary file has been deleted.", "success");*/
                    });
            }

</script>
@endsection
