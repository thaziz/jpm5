
@extends('main')


@section('title', 'dashboard')


@section('content')
<style type="text/css">
    .cssright { text-align: right; }
     .modal-dialog {
    width: 900px;
    margin: 30px auto;
}
    .pad{
        padding: 10px;
    }
     .btn-purple{
      background-color: purple;
    }
    .btn-black{
      background-color: black;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> TARIF CABANG KILOGRAM </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Master</a>
                        </li>
                        <li>
                          <a> Master Penjualan</a>
                        </li>
                        <li>
                          <a> Master Tarif</a>
                        </li>
                        <li class="active">
                            <strong> Tarif Cabang Kilogram </strong>
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
                    <h5> 
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                     <div class="text-right">
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','tambah'))
                       <button  type="button" class="btn btn-success " id="btn_add" name="btnok"><i class="glyphicon glyphicon-plus"></i>Tambah Data</button>
                       @endif
                      @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','print'))
                       <a href="{{ url('/laporan_master_penjualan/tarif_cabang_kilogram') }}" class="btn btn-warning"><i class="glyphicon glyphicon-print"></i>Laporan</a>
                       @endif
                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                    <form class="form-horizontal" id="tanggal_seragam" action="post" method="POST">
                        <div class="box-body">
                            <div class="row">
                        <div class="col-xs- float-left">
                          <table>
                            <tr>
                              <td valign="top" style="padding-left: 20px;"><p style="background-color: red;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp;</p></td>
                              <td valign="top"><p> Menghapus Seluruh Data <b>kota</b> Menuju <b>Provinsi</b> <f style="color: red;";>*Kecuali</f> jika sudah di custom/edit</p></td>
                                                       
                              <td valign="top" style="padding-left: 50px;"><p style="background-color: purple;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp;</p></td>
                              <td  valign="top"><p>Menghapus Data <b>kota</b> Menuju <b>Kota</b> <f style="color: red;";>*Kecuali</f> jika sudah di custom/edit</p></td>

                              <td valign="top" style="padding-left: 50px;"><p style="background-color: #595959;width: 15px;height: 15px">&nbsp;</p></td>
                              <td><p>&nbsp;&nbsp;&nbsp; </p></td>
                              <td  valign="top"><p>Menghapus data Tidak diperbolehkan</p></td>
                            </tr>
                          </table>
                        </div>
                        </div>
                    </form>
                <div class="box-body">
                    <div class="col-sm-12">
                      <table cellpadding="3" cellspacing="0" border="0" class="table filter table-bordered">
                        <tr>
                            <td align="center">Asal</td>
                            <td align="center">
                              <select class="form-control asal chosen-select-width" onchange="panggil_table()" name="asal">
                                <option value="">Pilih - Tujuan </option>
                                @foreach ($kota as $a)
                                  <option value="{{$a->id}}">{{$a->id}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                            <td align="center">Tujuan</td>
                            <td align="center">
                              <select class="form-control tujuan chosen-select-width" onchange="panggil_table()" name="tujuan">
                                <option value="">Pilih - Tujuan </option>
                                @foreach ($kota as $a)
                                  <option value="{{$a->id}}">{{$a->id}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                        </tr>
                        <tr id="filter_col1" data-column="0">
                          @if (Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang')) 
                            <td align="center">Cabang</td>
                            <td align="center">
                              <select class="form-control cabang chosen-select-width" onchange="panggil_table()" name="cabang">
                                <option value="0">Pilih - Cabang </option>
                                @foreach ($cabang as $a)
                                  <option value="{{$a->kode}}">{{$a->kode}} - {{$a->nama}}</option>
                                @endforeach
                              </select>
                            </td>
                          @endif
                            <td align="center">Jenis</td>
                            <td align="center" 
                             @if (Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang'))
                             colspan="3" 
                             @endif
                             >
                              <select onchange="panggil_table()" class="form-control jenis_bayar chosen-select-width">
                                <option value="0">Pilih - Jenis </option>
                                <option value="REGULER">REGULER</option>
                                <option value="EXPRESS">EXPRESS</option>
                              </select>
                            </td>
                        </tr>
                        <tr>
                          <td align="right" colspan="4">
                          </td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-sm-12 append_table">
                      
                    </div>
                </div><!-- /.box-body -->
                <!-- modal -->
                <div id="modal" class="modal" >
                  <div class="modal-dialog modal-lg ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Insert Edit Tarif Cabang Kilogram</h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal kirim">
                          <table class="table table-striped table-bordered table-hover ">
                            <tbody>
                                <tr>
                                    {{-- <td style="width:120px; padding-top: 0.4cm">Kode</td> --}}
                                    <td colspan="3">
                                        {{-- <input type="text" name="ed_kode" class="form-control a" style="text-transform: uppercase" > --}}
                                        <input type="hidden" class="form-control" name="_token" value="{{ csrf_token() }}" readonly="" >
                                        <input type="hidden" name="ed_kode_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="crud" class="form-control" >
                                        <input type="hidden" class="form-control" name="asal_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="tujuan_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="provinsi_old" class="form-control" >
                                        <input type="hidden" class="form-control" name="cabang_old" class="form-control" >
                                    </td>
                                </tr>
                                 @if(Auth::user()->punyaAkses('Tarif Cabang Kilogram','cabang'))
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="ed_harga"  style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                        @foreach ($cabang as $row)
                                             <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @else
                                 <tr>
                                    <td style="padding-top: 0.4cm">Cabang</td>
                                    <td class="disabled">   
                                        <select class="chosen-select-width b"  name="cb_cabang" id="ed_harga" style="width:100%">
                                            <option value="" selected="" disabled="">-- Pilih Cabang --</option>
                                        @foreach ($cabang as $row)
                                            <option @if(Auth::user()->kode_cabang == $row->kode) selected="" @endif value="{{ $row->kode }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td style="padding-top: 0.4cm">Kota Asal</td>
                                    <td>   
                                        <select class="chosen-select-width b"  name="cb_kota_asal" style="width:100%" id="cb_kota_asal">
                                            <option value="" selected="" disabled="">-- Pilih Kota asal --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}" data-kota="{{ $row->kode_kota }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="hilang2">
                                    <td style="padding-top: 0.4cm">Kota Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_kota_tujuan" id="cb_kota_tujuan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Kota tujuan --</option>
                                        @foreach ($kota as $row)
                                            <option value="{{ $row->id }}"> {{ $row->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr id="hilang">
                                    <td style="padding-top: 0.4cm">Provinsi Tujuan</td>
                                    <td>   
                                        <select class="chosen-select-width c"  name="cb_provinsi_tujuan" id="cb_provinsi_tujuan" style="width:100%" i>
                                            <option value="" selected="" disabled="">-- Pilih Provinsi tujuan --</option>
                                        @foreach ($prov as $prov)
                                            <option value="{{ $prov->id }}"> {{ $prov->nama }} </option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">Acc Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_acc_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Akun Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 0.4cm">CSF Penjualan</td>
                                    <td>
                                        <select class="chosen-select-width"  name="cb_csf_penjualan" style="width:100%">
                                             <option value="" selected="" disabled="">-- Pilih Csf Penjualan --</option>
                                        @foreach ($akun as $row)
                                            <option value="{{ $row->id_akun}}" data-nama_akun="{{$row->nama_akun}}"> {{ $row->id_akun }} - {{$row->nama_akun}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                </tr>

                            </tbody>
                          </table>
                           <table class="table-striped table-bordered" width="48%"> 
                              <thead>
                                  <tr >
                                      <th style="padding: 7px; text-align: center;"  colspan="2">REGULAR</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_reguler" id="id_reguler">
                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_regular"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kertas / Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarif10kg_reguler"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" style="background-color: white;color: white; " align="center">-</td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarifkgsel_reguler"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Berat Minimum</td>
                                      <td class="pad"><input type="text" name="berat_minimum_reg"></td>
                                  </tr>


                              </tbody>
                          </table> 
                          <table class="table-striped table-bordered" style="margin-left: 45%;margin-top: -366px;position: fixed;" width="48%"> 
                              <thead>
                                  <tr>
                                      <th style="padding: 7px; text-align: center;"  colspan="2">EXPRESS</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <input type="hidden" name="id_express" id="id_express">

                                  <tr>
                                      <td class="pad">Waktu/Estimasi</td>
                                      <td class="pad"><input type="text" name="waktu_express"></td>
                                  </tr>
                                   <tr>
                                      <td class="pad">Tarif Kertas / Kg</td>
                                      <td class="pad"><input type="text" name="tarifkertas_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif 0 <= 10 Kg</td>
                                      <td class="pad"><input type="text" name="tarif0kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarif10kg_express"></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" style="background-color: white;color: white; " align="center">-</td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif <= 20 Kg</td>
                                      <td class="pad"><input type="text" name="tarif20kg_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Tarif Kg selanjutnya</td>
                                      <td class="pad"><input type="text" name="tarifkgsel_express"></td>
                                  </tr>
                                  <tr>
                                      <td class="pad">Berat Minimum</td>
                                      <td class="pad"><input type="text" name="berat_minimum_ex"></td>
                                  </tr>
                              </tbody>
                          </table>
                          
                          <input type="hidden" name="kodekota" id="kodekota">
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnsave">Save changes</button>
                      </div>
                    </div>
                  </div>
                </div>
                  <!-- modal -->
                <div class="box-footer">
                  <div class="pull-right">


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
    
  $('#cb_kota_asal').change(function(){
        var idkota = $('#cb_kota_asal :selected').data('kota');
        var kotaid = $('#kodekota').val(idkota);
    })
  $('#cb_kota_tujuan').change(function(){
        $('#hilang').hide();
        // alert('aa');

    })
    $('#cb_provinsi_tujuan').change(function(){
        $('#hilang2').hide();
    })

    function panggil_table() {
      var asal = $('.asal').val();
      var tujuan = $('.tujuan').val();
      var cabang = $('.cabang').val();
      var jenis_bayar = $('.jenis_bayar').val();
      console.log('tes');
      $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kilogram/panggil_nota",
            type: "GET",
            data : {asal,tujuan,cabang,jenis_bayar},
            success: function(data)
            {
              $('.append_table').html(data);
            },
            error: function()
            {

            }
        });
    }
    $(document).ready( function () {
        var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"100%",search_contains:true}
                }
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
        panggil_table();
        $("input[name='ed_harga'],input[name='ed_waktu']").maskMoney({thousands:'.', decimal:',', precision:-1});
    });

    $("select[name='cb_acc_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_acc_penjualan2']").val(nama_akun);
    });

    $("select[name='cb_csf_penjualan']").change(function(){
        var nama_akun = $(this).find(':selected').data('nama_akun');
        $("input[name='ed_csf_penjualan2']").val(nama_akun);
    });
    
    $(document).on("click","#btn_add",function(){
        $("input[name='crud']").val('N');
        // $("input[name='ed_kode']").val('');
        $("input[name='ed_kode_old']").val('');
        
        $('input[name="waktu_regular"]').val('');
        $('input[name="tarifkertas_reguler"]').val('');
        $('input[name="tarif0kg_reguler"]').val('');
        $('input[name="tarif10kg_reguler"]').val('');
        $('input[name="tarif20kg_reguler"]').val('');
        //reg
        $('input[name="waktu_express"]').val('');
        $('input[name="tarifkertas_express"]').val('');
        $('input[name="tarif0kg_express"]').val('');
        $('input[name="tarif10kg_express"]').val('');
        $('input[name="tarif20kg_express"]').val('');
        $('input[name="tarifkgsel_reguler"]').val('');
        $('input[name="tarifkgsel_express"]').val('');
        $('#hilang').show();
        $("input[name='kodekota']").val('');

        $('#hilang2').show();
        $("select[name='cb_provinsi_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_asal']").val('').trigger('chosen:updated');
        $("select[name='cb_kota_tujuan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_csf_penjualan']").val('').trigger('chosen:updated');
        $("select[name='cb_acc_penjualan']").change();
        $("select[name='cb_csf_penjualan']").change();
        $("#modal").modal("show");
        $("input[name='ed_kode']").focus();
    });

    $(document).on( "click",".btnedit", function() {
        var id=$(this).attr("id");
        var tujuan = $(this).data('tujuan'); 
        var value = {
          asal : id , tujuan :tujuan 
        };
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kilogram/get_data",
            type: "GET",
            data : value,
            dataType:'json',
            success: function(data, textStatus, jqXHR)
            {
              console.log(data);
                $("input[name='crud']").val('E');
                //kode sama
                $('input[name="waktu_regular"]').val(data[0][0].waktu);
                $('input[name="waktu_regular"]').val(data[0][0].waktu);
                $('input[name="tarifkertas_reguler"]').val(data[0][0].harga);
                $('input[name="tarif0kg_reguler"]').val(data[0][1].harga);
                $('input[name="tarif10kg_reguler"]').val(data[0][2].harga);
                $('input[name="tarif20kg_reguler"]').val(data[0][3].harga);
                $('input[name="tarifkgsel_reguler"]').val(data[0][4].harga);
                $('input[name="tarifkgsel_reguler"]').val(data[0][4].harga);
                $('input[name="berat_minimum_reg"]').val(data[0][4].berat_minimum);
                //reg
                $('input[name="waktu_express"]').val(data[0][5].waktu);
                $('input[name="tarifkertas_express"]').val(data[0][5].harga);
                $('input[name="tarif0kg_express"]').val(data[0][6].harga);
                $('input[name="tarif10kg_express"]').val(data[0][7].harga);
                $('input[name="tarif20kg_express"]').val(data[0][8].harga);
                $('input[name="tarifkgsel_express"]').val(data[0][9].harga);
                $('input[name="berat_minimum_ex"]').val(data[0][5].berat_minimum);
                //expre
                $('input[name="asal_old"]').val(data[0][0].id_kota_asal);
                $('input[name="tujuan_old"]').val(data[0][0].id_kota_tujuan);
                $('input[name="provinsi_old"]').val(data[0][0].id_provinsi_cabkilogram);
                $('input[name="cabang_old"]').val(data[0][0].kode_cabang);



                $('#hilang').hide();
                $('#hilang2').show();
                $("input[name='kodekota']").val(data[0][0].kode_kota);
                

                $("input[name='ed_kode_old']").val(data.kode);
                $("select[name='cb_kota_asal']").val(data[0][0].id_kota_asal).trigger('chosen:updated');
                $("select[name='cb_kota_tujuan']").val(data[0][0].id_kota_tujuan).trigger('chosen:updated');
                $("select[name='cb_cabang']").val(data[0][0].kode_cabang).trigger('chosen:updated');
                $("select[name='cb_acc_penjualan']").val(data[0][0].acc_penjualan).trigger('chosen:updated');
                $("select[name='cb_csf_penjualan']").val(data[0][0].csf_penjualan).trigger('chosen:updated');
                $("select[name='cb_provinsi_tujuan']").val(data[0][0].id_provinsi_cabkilogram).trigger('chosen:updated');
                $("#modal").modal('show');
                $("input[name='ed_kode']").focus();
                
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on("click","#btnsave",function(){
        $.ajax(
        {
            url : baseUrl + "/sales/tarif_cabang_kilogram/save_data",
            type: "get",
            dataType:"JSON",
            data : $('.kirim :input').serialize() ,
            success: function(data, textStatus, jqXHR)
            {
                if(data.crud == 'N'){
                    if(data.status == 1){
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        alert("Gagal menyimpan data!");
                    }
                }else if(data.crud == 'E'){
                    if(data.status == 1){
                        //$.notify('Successfull update data');
                        var table = $('#table_data').DataTable();
                        table.ajax.reload( null, false );
                        //$("#edkode").focus();
                        $("#modal").modal('hide');
                        $("#btn_add").focus();
                    }else{
                        swal("Error","Can't update customer data, error : "+data.error,"error");
                    }
                }else{
                    // console.log(data.hasil_cek);
                    swal(data.hasil_cek,'Cek sekali lagi',"warning");
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
               swal("Error!", textStatus, "error");
            }
        });
    });

    $(document).on( "click",".btndelete", function() {
          var name = $(this).attr("name");
        var prov = $(this).data("prov");
        var asal = $(this).data("asal");
        var id = $(this).attr("id");
        if(!confirm("Hapus Data seluruh" + asal +' menuju ke '+ prov + " ?")) return false;
        var value = {
            id: id,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_kilogram/hapus_data",
            //dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    });
    $(document).on( "click",".btndelete_perkota", function() {
        var name = $(this).attr("name");
        var id = $(this).attr("id");
        var tujuan = $(this).data("tujuan");
        var asal = $(this).data("asal");
        if(!confirm("Hapus Data " + asal +' menuju ke '+ tujuan + " ?")) return false;
        var value = {
            id: id,name:name,
            _token: "{{ csrf_token() }}"
        };
        $.ajax({
            type: "get",
            url : baseUrl + "/sales/tarif_cabang_kilogram/hapus_data_perkota",
            //dataType:"JSON",
            data: value,
            success: function(data, textStatus, jqXHR)
            {
                var data = jQuery.parseJSON(data);
                if(data.result ==1){
                    var table = $('#table_data').DataTable();
                    table.ajax.reload( null, false );
                }else{
                    swal("Error","Data tidak bisa hapus : "+data.error,"error");
                }

            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                swal("Error!", textStatus, "error");
            }
        });


    });
    

</script>
@endsection
