@extends('main')

@section('title', 'dashboard')

@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/bootstrap-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet">

  <style>
    body{
      overflow-y: scroll;
    }

    #table{
      width: 100%;
    }

    #table td{
      padding: 8px 20px;
    }

    #table_form, #table-filter{
      border:0px solid black;
      width: 100%;
    }

    #table_form input,{
      padding-left: 5px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }

    #table-filter td,
    #table-filter th{
      padding:10px 0px;
    }

    .error-badge{
      color:#ed5565;
      font-weight: 600;
    }

    .error-badge small{
      display: none;
    }

    #table_form .right_side{
      padding-left: 10px;
    }

    .modal-open{
      overflow: inherit;
    }.chosen-select {
        background: red;
    }
  </style>
@endsection

@section('content')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2> Master Akun </h2>
        <ol class="breadcrumb">
            <li>
                <a>Home</a>
            </li>
            <li>
                <a>Keuangan</a>
            </li>
            <li class="active">
                <strong> Master Akun  </strong>
            </li>

        </ol>
    </div>

    <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
      <table border="0" width="100%" id="table-filter">
        <tr>
          <th width="7%" class="text-center">Pencarian Berdasarkan : </th>
          <td width="10%">
            &nbsp;&nbsp;<select style="width:90%; border: 0px; border-bottom: 1px solid #aaa; cursor: pointer;" id="berdasarkan">
              <option value="semua">Semua</option>
              <option value="id_akun">Kode Akun</option>
              <option value="nama_akun">Nama Akun</option>
              <option value="dka">Posisi Debet/Kredit</option>
            </select>
          </td>

          <th width="5%" class="text-center">Kata Kunci : </th>
          <td width="8%">
            &nbsp;&nbsp;<input style="width:90%; padding-left: 3px;" data-toggle="tooltip" id="filter" placeholder="Masukkan Kata Kunci">
          </td>
        </tr>
      </table>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Data Akun
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        <button class="btn btn-sm btn-success" id="collapsed" data-toggle="tooltip" data-placement="top" title="Sembunyikan Semua Sub Akun">
                          <i class="fa fa-archive fa-fw"></i>
                        </button>
                        
                        <button class="btn btn-sm btn-success" id="expand" data-toggle="tooltip" data-placement="top" title="Tampilkan Semua Sub Akun">
                          <i class="fa fa-code-fork fa-fw"></i>
                        </button>

                        <button class="btn btn-sm btn-primary tambahAkun" data-parrent="0" data-toggle="modal" data-target="#modal_tambah_akun">
                          <i class="fa fa-plus"></i> &nbsp;Tambah Data Akun
                        </button>
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body" style="min-height: 330px;">

                  <table id="table" width="100%" class="table-bordered table-striped tbl-penerimabarang no-margin" style="padding:0px;">
                    <thead>
                      <tr>
                        <th width="15%" style="padding:8px 0px" class="text-center">Kode Akun</ht>
                        <th width="50%" style="padding:8px 0px" class="text-center">Nama Akun</ht>
                        <th style="padding:8px 0px" class="text-center">Posisi Debet/Kredit</th>
                        {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
                        <th width="20%" style="padding:8px 0px" width="20%" class="text-center">Aksi</th>

                      </tr>
                    </thead>
                    <tbody  class="searchable">

                      @foreach($data as $dataAkun)

                        <tr class="treegrid-{{ $dataAkun->id_akun }} expanded">
                            <td class="id_akun">{{ $dataAkun->id_akun }}</td>
                            <td class="nama_akun">{{ $dataAkun->nama_akun }}</td>
                            <td class="text-center dka">{{ ($dataAkun->akun_dka == "D") ? "DEBET" : "KREDIT" }}</td>
                            {{-- <td></td> --}}
                            <td class="text-center">

                              <span data-toggle="tooltip" data-placement="top" title="Tambahkan Akun Di {{ $dataAkun->nama_akun }}">
                                <button data-parrent="{{ $dataAkun->id_akun }}" data-toggle="modal" data-target="#modal_tambah_akun" class="btn btn-xs btn-primary tambahAkun"><i class="fa fa-folder-open"></i></button>
                              </span>

                              <span data-toggle="tooltip" data-placement="top" title="Edit Akun {{ $dataAkun->nama_akun }}">
                                  <button data-parrent="{{ $dataAkun->id_akun }}" data-toggle="modal" data-target="#modal_edit_akun" class="btn btn-xs btn-warning editAkun"><i class="fa fa-pencil-square"></i></button>
                              </span>

                              <a onclick="return confirm('Apakah Anda Yakin, Semua Data Sub Akun Yang Terkait Dengan Akun Ini Juga Akan Dihapus ??')" href="{{ route("akun.hapus", $dataAkun->id_akun) }}">
                                <button data-toggle="tooltip" data-placement="top" title="Hapus Akun {{ $dataAkun->nama_akun }}" class="btn btn-xs btn-danger"><i class="fa fa-eraser"></i></button>
                              </a>
                            </td>
                        </tr>

                        {!! $dataAkun->getSubAkun($dataAkun->id_akun) !!}
                        
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
          </div><!-- /.row -->
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- modal -->
<div id="modal_tambah_akun" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Data Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

<!-- modal -->
<div id="modal_edit_akun" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Edit Data Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <center class="text-muted">Menyiapkan Form</center>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

@endsection



@section('extra_scripts')

<script src="{{ asset('assets/vendors/bootstrap-treegrid/js/jquery.treegrid.js') }}"></script>
<script src="{{ asset('assets/vendors/inputmask/inputmask.jquery.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip()

    @if(Session::has('sukses'))
        alert("{{ Session::get('sukses') }}")
    @endif



    // tableDetail = $('.tbl-penerimabarang').DataTable({
    //       responsive: true,
    //       searching: true,
    //       sorting: false,
    //       paging: false,
    //       //"pageLength": 10,
    //       "language": dataTableLanguage,
    // });

    $(".tambahAkun").on("click", function(){
      $("#modal_tambah_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_tambah_akun").on("hidden.bs.modal", function(e){
      $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_tambah_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_tambah_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/add/"+$("#modal_tambah_akun .modal-header .parrent").val(), {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal_tambah_akun .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_tambah_akun .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $(".editAkun").on("click", function(){
      $("#modal_edit_akun .modal-header .parrent").val($(this).data("parrent"));
    })

    $("#modal_edit_akun").on("hidden.bs.modal", function(e){
      $("#modal_edit_akun .modal-body").html('<center class="text-muted">Menyiapkan Form</center>');
      if($change)
        window.location = baseUrl+"/master_keuangan/akun";
    })

    $("#modal_edit_akun").on("shown.bs.modal", function(e){
      //alert($("#modal_edit_akun .modal-header .parrent").val())

      $.ajax(baseUrl+"/master_keuangan/edit/"+$("#modal_edit_akun .modal-header .parrent").val(), {
         timeout: 5000,
         dataType: "html",
         success: function (data) {
             $("#modal_edit_akun .modal-body").html(data);
         },
         error: function(request, status, err) {
            if (status == "timeout") {
              $("#modal_edit_akun .modal-body").html('<center class="text-muted">Waktu Koneksi habis</center>');
            } else {
              $("#modal_edit_akun .modal-body").html('<center class="text-muted">Ups Gagal Loading</center>');
            }
        } 
      });
    })

    $("#table").treegrid({
          treeColumn: 1,
          initialState: "expanded"
    });

    $("#collapsed").click(function(){
      $('#table').treegrid('collapseAll');
    })

    $("#expand").click(function(){
      $('#table').treegrid('expandAll');
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });

    $('#filter').keyup(function () {
        $val = $(this).val().toUpperCase();
        if($("#berdasarkan").val() == "semua"){
          var rex = new RegExp($(this).val(), 'i');
          $('.searchable tr').hide();
          $('.searchable tr').filter(function () {
              return rex.test($(this).text());
          }).show();
        }else{
          $(".searchable ."+$("#berdasarkan").val()).each(function(){
            $str = $(this).text().toUpperCase()

            if($str.indexOf($val) != -1){
              $(this).parents("tr").show();
            }else{
              $(this).parents("tr").hide();
            }
            
          })
        }
    })

  })

</script>
@endsection