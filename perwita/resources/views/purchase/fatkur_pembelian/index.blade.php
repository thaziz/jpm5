@extends('main')

@section('title', 'dashboard')

@section('content')


<style type="text/css">
  #addColumn thead tr th{
    text-align: center;
  }
</style>
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
                            <strong>  Faktur Pembelian </strong>
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
                    <h5> Faktur Pembelian
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('fakturpembelian/createfatkurpembelian')}}"> <i class="fa fa-plus"> Tambah Data  </i> </a> 
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box">
               
                  <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                  <div class="box-body">
                    
                <div class="box-body">
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead align="center">
                     <tr>
                        <th style="width:10px">No</th>
                        <th> No Faktur </th>
                        <th> Tanggal </th>
                        <th> Jenis Faktur </th>
                        <th> No Invoice </th>
                        <th> Status </th>
                        <th> Detail </th>
                        <!-- <th> Allow Edit</th> -->
                        <th> Aksi </th>   
                    </tr>
                    </thead>

                    <tbody>  
                    @foreach($data['faktur'] as $index=>$faktur)

                      <tr>
                        <td> {{$index + 1}}</td>
                        <td> {{$faktur->fp_nofaktur}} </td>
                        <td>  {{$faktur->fp_tgl}} </td>
                        <td> {{$faktur->jenisbayar}} </td>
                        @if($faktur->fp_noinvoice != "")
                        <td> {{$faktur->fp_noinvoice}} </td>
                        @else
                        <td align="center"> - </td>
                        @endif
                        <td>
                          @if($faktur->fp_pending_status == 'APPROVED')
                            <label class="label label-success">APPROVED</label>
                          @elseif($faktur->fp_pending_status == 'PENDING')
                            <label class="label label-danger">PENDING</label>
                            @else
                            -
                          @endif
                        </td>
                        <td align="left" align="40">
                          <a class="fa asw fa-print" align="center"  title="edit" href="{{route('detailbiayapenerus', ['id' => $faktur->fp_nofaktur])}}"> Print Detail</a><br>
                        </td>
                        <!-- <td align="center"><input type="checkbox" class="form-control" name="allow"></td> -->
                       @if($faktur->fp_jenisbayar == 6 || $faktur->fp_jenisbayar == 7 || $faktur->fp_jenisbayar == 9)

                       <td align="center"> 
                          <a title="Edit" class="btn btn-success" href={{url('fakturpembelian/edit_penerus/'.$faktur->fp_idfaktur.'')}}>
                          <i class="fa fa-arrow-right" aria-hidden="true"></i>
                          </a> 
                          <a title="Hapus" class="btn btn-success" onclick="hapus({{$faktur->fp_idfaktur}})">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                          </a> 
                        <input type="hidden" value="{{$faktur->fp_jenisbayar}}">
                       </td>  
                       
                       @else
                        <td align="center"> <a title="Edit" class="btn btn-success" href={{url('fakturpembelian/detailfatkurpembelian/'.$faktur->fp_idfaktur.'')}}><i class="fa fa-arrow-right" aria-hidden="true"></i> </a> 
                        <a title="Hapus" class="btn btn-success" onclick="hapus({{$faktur->fp_idfaktur}})">
                          <i class="fa fa-trash" aria-hidden="true"></i>
                          </a> 
                        <input type="hidden" value="{{$faktur->fp_jenisbayar}}">
                       </td> 

                       @endif
                      </tr>
                      @endforeach
                     
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->

                <div class="box-footer">
                  <div class="pull-right">
            
                                     
                    </div>
                  </div><!-- /.box-footer --> 
              </div><!-- /.box -->
            </div><!-- /.col -->
            </div>
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

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
   /* $('#tmbh_data_barang').click(function(){
      $("#addColumn").append('<tr> <td rowspan="3"> 1 </td> <td rowspan="3"> </td> <td rowspan="3"> </td>  <td rowspan="3"> </td> <td> halo </td> <td> 3000 </td>  <tr> <td> halo </td> <td>  5.000 </td> </tr> <tr><td> halo </td> <td> 3000 </td> </tr>');
    })*/
     $no = 0;
    $('#tmbh_data_barang').click(function(){
         $no++;
     $("#addColumn").append('<tr id=field-'+$no+'> <td> <b>' + $no +' </b> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]">  <option value=""> -- Pilih Data Barang -- </option> <option value="">  Barang 1 </option> <option value="">  Barang 2 </option> </td> <td> </td>  <td> </td> <td> </td> <td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option> </td> <td> 3000 </td> <td> <button class="btn btn-danger remove-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button> </td> </tr>');



      $(document).on('click','.remove-btn',function(){
              var id = $(this).data('id');
              var parent = $('#field-'+id);

              parent.remove();
          })
    })

      $('#tmbh_supplier').click(function(){
            $no++;
        $("#addColumn").append('<tr id=supp-'+$no+'> <td> <b>  </b> </td> <td> </td> <td> </td>  <td> </td> <td> </td><td> <select  class="form-control select2" style="width: 100%;" name="idbarang[]"> <option value=""> -- Pilih Data Supplier -- </option> <option value="">  Supplier 1 </option> <option value="">  Supplier 2 </option>  </td> <td> 3000 </td> <td> <button class="btn btn-danger removes-btn" data-id='+$no+' type="button"><i class="fa fa-trash"></i></button>  </td> </tr>');


        $(document).on('click','.removes-btn',function(){
              var id = $(this).data('id');
       //       alert(id);
              var parent = $('#supp-'+id);

             parent.remove();
          })
     })

    function hapus(id){
    swal({
    title: "Apakah anda yakin?",
    text: "Hapus Data!",
    type: "warning",
    showCancelButton: true,
    showLoaderOnConfirm: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Ya, Hapus!",
    cancelButtonText: "Batal",
    closeOnConfirm: false
  },

function(){

     $.ajax({
      url:baseUrl + '/fakturpembelian/hapusbiayapenerus/'+id,
      type:'get',
      success:function(data){
        if(data.status == '1'){
          swal({
          title: "Berhasil!",
                  type: 'success',
                  text: "Data Berhasil Dihapus",
                  timer: 2000,
                  showConfirmButton: true
                  },function(){
                     location.reload();
          });
        }else{
         swal({
        title: "Data Tidak Bisa Dihapus",
                type: 'error',
                timer: 1000,
                showConfirmButton: false
    });
        }
      },
      error:function(data){

        swal({
        title: "Terjadi Kesalahan",
                type: 'error',
                timer: 2000,
                showConfirmButton: false
    });
   }
  });
  });
}
    

</script>
@endsection
