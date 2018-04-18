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

<style type="text/css">
  .center{
    text-align: center;
  }
</style>
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
                        <th> Group Item </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($data_dt as $i=>$val)
                      <tr>
                        <td align="center">
                        {{$i+1}}
                        <input type="hidden" class="form-control id_mm" value="{{$val->mm_id}}" name="id_mm">
                      </td>
                        <td>{{$val->mm_nama}}</td>
                        <td>{{$val->gm_id}} - {{$val->gm_nama}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                   
                  </table>

                  <div id="myModal" class="modal" >
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Detail Transfer Kas</h4>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal form_append">
                                    <table class="table tabel_menu">
                                       <tr>
                                           <td>Nama Menu</td>
                                           <td>
                                               <input type="text " class="form-control nama_menu" name="nama_menu">
                                           </td>
                                       </tr>
                                       <tr>
                                           <td>Group Menu</td>
                                           <td>
                                               <select class="form-control grup_item chosen-select-width" name="grup_item">
                                                @foreach($data as $i)
                                                 <option value="{{$i->gm_id}}">{{$i->gm_id}} - {{$i->gm_nama}}</option>
                                                 @endforeach
                                               </select>
                                           </td>
                                       </tr>
                                    </table>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary append" id="append">Simpan</button>
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
            columnDefs: [
            {
               targets: 0 ,
               className: 'center'
            },
            ]
    });


    $('#append').click(function(){
         var nama = $('.nama_menu').val();
         var setting = $('.grup_item :selected').text();
         $.ajax({
            type : "get",          
            data : $('.tabel_menu :input').serialize(),
            url : '{{url('setting/savedaftarmenu')}}',
            dataType : 'json',
            success : function (response){
               if (response.status == 2) {
                toastr.warning('Data Sudah Ada');
                $('.tabel_menu :input').val('');
                return 1;
               }else if (response.status == 3) {
                toastr.warning('Masukan Data Dengan Benar');
                $('.tabel_menu :input').val('');
                return 1;
               }
               var temp =1 
               tableDetail.$('.id_mm').each(function(){
                temp +=1;
               })

               tableDetail.row.add([
                temp+'<input type="hidden" class="id_mm" name="id_mm">',
                nama,
                setting,
                ]).draw();
                // toastr.success('Berhasil Di Save');

                $('.tabel_menu .nama_menu').val('');

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
      $('.nama_menu').on('keydown', function(e) {
        if (e.which == 13) {
            $('#append').trigger('click');
            e.preventDefault();
        }
      });
</script>
@endsection
