@extends('main')

@section('title', 'dashboard')

@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Supplier </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Supplier </strong>
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
                    <h5> Master Supplier
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                       <a class="btn btn-success" aria-hidden="true" href="{{ url('mastersupplier/createmastersupplier')}}"> <i class="fa fa-plus"> Tambah Data Supplier</i> </a> 
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
               
                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item">
                    <thead>
                     <tr>
                        <th style="width:10px">Kode Supplier</th>
                        <th style="width:200px"> Nama Supplier </th>
                        <th style="width:70px"> Alamat </th>
                        <th style="width:70px"> Kota </th>
                        <th style="width: 50px"> Cabang Pemohon </th>
                        <th style="width:30px"> Kode Pos </th>
                        <th style="width:70px" > No Telp / Fax </th>
                        <th  style="width:70px"> Contact Person </th>
                        <th  style="width:50px"> Status </th>
                        <th style="width:50px"> Aksi </th>
                    </tr>
                 
                    </thead>
                    
                    <tbody>

                    @foreach($data as $sp)
                    <tr>
                      <td> {{$sp->no_supplier}} </td>
                      <td > {{$sp->nama_supplier}} </td>
                      <td> {{$sp->alamat}} </td>
                      <td> {{$sp->nama2}} </td>
               
                      <td> {{$sp->idcabang}} </td>
                      <td> {{$sp->kodepos}} </td>
                      <td> {{$sp->telp}} </td>
                      <td>  {{$sp->contact_person}} </td>
                      <td style="color:red"> {{$sp->status}} </td>
                     <!--  <td> {{$sp->syarat_kredit}} </td>
                      <td> {{$sp->plafon}} </td>
                      <td> {{$sp->currency}} </td>
                      <td> {{$sp->pajak_npwp}}</td>
                      <td> {{$sp->acc_hutang}} </td> -->
                      <td> 

                         <a class="btn btn-info" href={{url('mastersupplier/detailsupplier/'. $sp->idsup .'')}}> <i class="fa fa-arrow-right" aria-hidden="true"></i> </a>
                             
                   <!--    <a class="btn btn-success" href={{url('mastersupplier/editsupplier/'.$sp->idsup .'')}}> <i class="fa fa-pencil"> </i> </a> -->


                        <a href="#" class="btn btn-danger" onclick="hapusData('{{ $sp->idsup }}')"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                                    {{ Form::open(['url'=>'mastersupplier/deletesupplier/'.$sp->idsup, 'method' => 'delete', 'id' => $sp->idsup ]) }}

                                    {{ Form::close() }}         
                      </td>
                    
                    </tr>
                   
                    @endforeach

                    </tbody>
                   
                  </table>
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

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
  
    
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
                    });
            }

</script>
@endsection
