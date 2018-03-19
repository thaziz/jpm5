@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
  .modal-content {
    width: 800px;
  }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Zona </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li class="active">
                            <strong> Zona </strong>
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
                    <h5> AGEN
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal" onclick="tambah()"><i class="fa fa"></i>Tambah</button>
                    </div>
                </div>

                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                  
                  <div class="box-body">
                </div>        
                <div class="box-body">
                  <table id="addColumn" class="table table-bordered table-striped tbl-penerimabarang">
                    <thead>
                     <tr>
                        <th style="width:5px">No.</th>
                        <th> Nama </th>
                        <th> Harga </th>
                        <th> Jarak awal</th>
                        <th> Jarak akir</th>
                        <th> Keterangan </th>
                        <th> Aksi  </th>
                    </tr>
                    </thead>
                   
                    <tbody>
                       @foreach($data as $index => $a)
                      <tr>
                        <td> {{$index+1}} </td>
                        <td> {{$a->nama}}  </td>
                        <td> {{$a->harga_zona}} </td>
                        <td> {{$a->jarak_awal}} </td>
                        <td> {{$a->jarak_akir}} </td>
                        <td> {{$a->keterangan}} </td>
                        <td>
                         
                      

                           <button type="button" data-toggle="modal" data-target="#modal" id="edit" data-edit="{{ $a->id_zona }}"  onclick="editing(this.getAttribute('data-edit'))" class="btn btn-warning btn-xs btnedit" ><i class="glyphicon glyphicon-pencil"></i></button>



                                        <button type="button" id="hapus" data-hapus="{{ $a->id_zona }}"  onclick="hapusing(this.getAttribute('data-hapus'))" title="Delete" class="btn btn-danger btn-xs btndelete" ><i class="glyphicon glyphicon-remove"></i></button>
                        </td>
                      </tr>
                      @endforeach
                     
                    </tbody>
                    
                   
                  </table>
                </div><!-- /.box-body -->

              <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal kirim" id="saving">
                          <table id="table_data" class="table table-striped table-bordered table-hover">
                            <tbody>
                                <tr>
                                    {{-- <td style="width:120px; padding-top: 0.4cm">Kode</td> --}}
                                    <td colspan="4">
                                        {{-- <input type="text" name="ed_kode" class="form-control" style="text-transform: uppercase" > --}}
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Nama</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_nama" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Harga</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_harga" style="text-transform: uppercase" >
                                    </td>
                                </tr><tr>
                                    <td style="padding-top: 0.4cm">Jarak awal</td>
                                    <td >
                                        <input type="text" class="form-control" name="ed_jarakawal" style="text-transform: uppercase" >
                                    </td>
                                    <td style="padding-top: 0.4cm">jarak akir</td>
                                    <td >
                                        <input type="text" class="form-control" name="ed_jarakakir" style="text-transform: uppercase" >
                                    </td>
                                </tr><tr>
                                    <td style="padding-top: 0.4cm">Keterangan</td>
                                    <td colspan="3">
                                        <input type="text" class="form-control" name="ed_keterangan" style="text-transform: uppercase" >
                                    </td>
                                </tr>
                                
                                </tbody>
                              </table>
                            </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" onclick="simpan()">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>
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
  function simpan (){

      $.ajax({
            url : baseUrl + "/sales/zona/simpan",
            type: "GET",
            data : $('#saving').serialize(),
            success: function()
            {
                $("#modal").modal('hide');
                location.reload();

            }
      });
  }
  function tambah (){
            $('input[name="crud"]').val('N');
            $('input[name="ed_nama"]').val('{{ $nama }}');
            $('input[name="ed_harga"]').val('');
            $('input[name="ed_jarakawal"]').val('');
            $('input[name="ed_jarakakir"]').val('');
            $('input[name="ed_keterangan"]').val('');
    // alert(as);
  }
  function editing(anjay){
      var value = { id:anjay}
       $.ajax({
            url : baseUrl + "/sales/zona/getdata",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
              console.log(data);
              $('input[name="crud"]').val('E'); 
              $('input[name="ed_nama"]').val(data[0].nama);
              $('input[name="ed_kode_old"]').val(data[0].id_zona);
              $('input[name="ed_harga"]').val(data[0].harga_zona);
              $('input[name="ed_jarakawal"]').val(data[0].jarak_awal);
              $('input[name="ed_jarakakir"]').val(data[0].jarak_akir);
              $('input[name="ed_keterangan"]').val(data[0].keterangan);
            }
          });
      }
      
   function hapusing(hapus){
    alert('dd');
    var hapusdata = { id:hapus}
    $.ajax({
            url : baseUrl + "/sales/zona/hapus",
            type: "GET",
            data : hapusdata,
            success: function()
            {
                // $("#modal").modal('hide');
                location.reload();

            }
      });

   }

     tableDetail = $('.tbl-penerimabarang').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
   
    });

    
</script>
@endsection
