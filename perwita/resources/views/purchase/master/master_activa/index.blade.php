@extends('main')

@section('title', 'dashboard')

@section('content')

<style>
     #table_form input{
      padding-left: 5px;
    }

    #table_form td,
    #table_form th{
      padding:10px 0px;
    }

    .table-form{
      border-collapse: collapse;
    }

    .table-form th{
      font-weight: 600;
    }

    .table-form th,
    .table-form td{
      padding: 2px 0px;
    }

    .table-form input{
      font-size: 10pt;
    }

    .table-detail{
      font-size: 8pt;
    }

</style>

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Master Activa</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong>Master Activa</strong>
                        </li>

                    </ol>
                </div>
               <div class="col-lg-12" style="border: 1px solid #eee; margin-top: 15px;">
                <table border="0" width="100%" id="table_form">
                  <tr>
                    <th width="15%" class="text-center">Menampilkan Cabang : </th>
                    <td width="17%">

                        <select class="form-control chosen-select" id="cabang" name="cabang" style="background:; width: 90%">
                          @foreach ($cab as $cabangs)
                            <?php 
                                $selected = ($cabangs->kode == $cabang) ? "selected" : "";
                            ?>
                            <option value="{{ $cabangs->kode }}" {{ $selected }}>{{ $cabangs->nama }}</option>
                          @endforeach
                        </select>

                    </td>

                    <td>
                      <button class="btn btn-success btn-sm" id="filter">Filter</button>
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
                    <h5> Daftar Master Activa
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                      <div class="text-right">
                        @if(Auth::user()->PunyaAkses('Master Activa','tambah'))
                            <a class="btn btn-success btn-sm" aria-hidden="true" href="{{ url('masteractiva/createmasteractiva')}}"> <i class="fa fa-plus"> &nbsp;Tambah Master Activa</i> </a>
                        @endif
                    </div>

                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">
              
              <div class="box" id="seragam_box">
             

                    
                <div class="box-body">
                
                  <table id="addColumn" class="table table-bordered table-striped tbl-item" style="font-size: 8pt;">
                    <thead>
                     <tr>
                        <th width="15%">Nama Aktiva</th>
                        <th width="15%"> Golongan </th>
                        <th width="15%"> Nilai Perolehan </th>
                        <th> Tanggal Perolehan </th>
                        <th> Tarif Garis Lurus </th>
                        <th> Tarif Saldo Menurun </th>
                        <th width="10%"> Aksi </th>
                                           
                    </tr>
                 
                    </thead>
                    
                    <tbody id="data-body">
                        @foreach($data as $aktiva)
                          <tr>
                            <td class="text-center">{{ $aktiva->nama_aktiva }}</td>
                            <td class="text-center">{{ $aktiva->nama_golongan }}</td>
                            <td class="text-center">{{ number_format($aktiva->nilai_perolehan) }}</td>
                            <td class="text-center">{{ date("d-m-Y", strtotime($aktiva->tanggal_perolehan)) }}</td>
                            <td class="text-center">{{ $aktiva->persentase_garis_lurus }}%</td>
                            <td class="text-center">{{ $aktiva->persentase_saldo_menurun }}%</td>
                            <td class="text-center">
                              <div class="btn-group ">
                                @if(Auth::user()->PunyaAkses('Master Activa','ubah'))
                                  <a class="btn btn-xs btn-warning" href="{{ route("master_aktiva.edit", [$aktiva->kode_cabang, $aktiva->id]) }}"><i class="fa fa-pencil"></i></a>
                                @endif

                                @if(Auth::user()->PunyaAkses('Master Activa','hapus'))
                                  <a class="btn btn-xs btn-danger" onclick="return confirm('Apa Anda Yakin Ingin Menghapus Data ini ?')" href="{{ route("master_aktiva.hapus", [$aktiva->kode_cabang, $aktiva->id]) }}"><i class="fa fa-times"></i></a>
                                @endif
                              </div>
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

    @if(Session::has("sukses"))
      toastr.success('{{ Session::get("sukses") }}');
    @endif

    tableDetail = $('.tbl-item').DataTable({
            responsive: true,
            searching: true,
            //paging: false,
            "pageLength": 10,
            "language": dataTableLanguage,
    });

    $("#filter").click(function(){
      window.location = baseUrl+"/masteractiva/masteractiva/"+$('#cabang').val();
    })

    $('.date').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
    
    $no = 0;
    $('.carispp').click(function(){
      $no++;
      $("#addColumn").append('<tr> <td> ' + $no +' </td> <td> no spp </td> <td> 21 Juli 2016  </td> <td> <a href="{{ url('purchase/konfirmasi_orderdetail')}}" class="btn btn-danger btn-flat" id="tmbh_data_barang">Lihat Detail</a> </td> <td> <i style="color:red" >Disetujui </i> </td> </tr>');   
    })
 
   

</script>
@endsection
