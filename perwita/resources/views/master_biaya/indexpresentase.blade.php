@extends('main')

@section('title', 'dashboard')

@section('content')

<style type="text/css">
   .datatable thead tr th{
    text-align: center;
   }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" >
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5> Master Persentase
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>

                </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-xs-12">
              <div class="box" id="seragam_box">
                <div class="box-header">

                </div><!-- /.box-header -->     
                <div class="box-body">
                @if(Auth::user()->PunyaAkses('Master Persen','tambah'))
                <button type="button" class="btn btn-primary pull-right" onclick="tambah()"><i class="fa fa-plus"> Tambah Data</i></button>
                @endif
                <table class="datatable table table-bordered">
                    <thead align="center">
                        <tr>
                            <th>Kode</th>
                            <th>Akun</th>
                            <th>Kode Cabang</th>
                            <th>Nama pihak</th>
                            <th>Jenis Biaya</th>
                            <th>Keterangan</th>
                            <th width="100">Persentase</th>
                            <th>Aksi</th>
                    
                        </tr>
                    </thead>
                    <tbody >
                        @foreach($data as $index=>$val)
                        <tr>
                            <td align="center">
                                <input type="hidden" name="kode" style="width: 100px;"  class="kode_master kode_{{$val->kode}} form-control"  value="{{$val->kode}}">
                                {{$val->kode}}
                            </td>
                            <td class="">
                                {{$val->kode_akun}}
                                <input type="hidden" value="{{$val->kode_akun}}" class="akun_tabel">
                            </td>
                            <td class="">
                                {{$val->cabang}}
                                <input type="hidden" value="{{$val->cabang}}" class="cabang_tabel">
                            </td>
                            <td class="">
                               {{$val->nama}} {{$val->last_name}}
                                <input type="hidden" value="{{$val->jenis_bbm}}" class="nama_tabel">
                                <input type="hidden" value="{{$val->last_name}}" class="last_name_tabel">
                            </td>
                            <td>
                              {{$val->mjb_nama}}
                              <input type="hidden" value="{{$val->mjb_id}}" class="jenis_biaya_detail">
                            </td>
                            <td class="">
                                {{$val->keterangan}}
                                <input type="hidden" value="{{$val->keterangan}}" class="keterangan_tabel">
                            </td>
                            <td align="right">
                                <input type="text" readonly="" class="persen_tabel form-control" style="width: 100px; display: inline-block;"  style="text-align: center;" onblur="" value="{{$val->persen}}"><span> %</span>  
                            </td>
                            <td align="center">
                                @if($val->cabang != 'GLOBAL')
                                 @if(Auth::user()->PunyaAkses('Master Persen','ubah'))
                                <a onclick="edit_modal(this)"><i class="fa fa-pencil"> Edit</i></a>
                                @endif
                                @if(Auth::user()->PunyaAkses('Master Persen','hapus'))
                                <a href="{{route('hapusPersen',['id' =>$val->kode])}}"><i class="fa fa-trash"> Hapus</i></a>
                                @endif
                                @else
                                 @if(Auth::user()->PunyaAkses('Master Persen','ubah'))
                                <a onclick="edit_modal(this)"><i class="fa fa-pencil"> Edit</i></a>
                                @endif
                                @endif
                            </td>
        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>            
              </div>
            </div>
        </div>
    </div>

            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div>
 


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="max-width: 800px; min-width: 800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Form Create</h4>
        </div>
        <div class="modal-body">
          <div>
            <form class="form table_member">
            <table class="table table-bordered table-striped modal_form">
              <tr>
                <td>Nama Pembiayaan</td>
                <td>
                    <select  class="form-control first_name chosen-select-width" name="first_name">
                        @foreach($bbm as $val)
                        <option value="{{$val->jb_id}}">{{$val->jb_nama}}</option>
                        @endforeach
                    </select>
                  <input type="hidden" name="kode" class="form-control kode_id" placeholder="pembiayaan">
                </td>
                <td>
                  <input type="text" name="last_name" class="form-control last_name" placeholder="last name" style="text-transform: uppercase;">
                </td>
              </tr>
              <tr>
                <td>Persentase</td>
                <td colspan="2"><input type="text" name="persentase" class="form-control persentase" placeholder="persen"></td>
              </tr>
              <tr>
                <td>Cabang</td>
                <td colspan="2">
                    <select onchange="dropdown()" class="form-control cabang chosen-select-width" name="cabang">
                        <option selected="" value="0">- pilih-cabang -</option>
                        <option value="GLOBAL">GLOBAL</option>
                        @foreach($cabang as $val)
                        <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
                        @endforeach
                    </select>
                </td>
              </tr>
              <tr>
                <td>Kode Akun</td>
                <td colspan="2" class="akun_modal">
                    <select style="display: inline-block; " class="form-control nama_akun_dropdown chosen-select-width1" name="nama_akun">
                        <option selected="" disabled="" value="0">- pilih-akun -</option>
                        @foreach($akun as $val)
                        <option value="{{$val->id_akun}}">{{$val->id_akun}} - {{$val->nama_akun}}</option>
                        @endforeach
                    </select>
                </td>
              </tr>
              <tr>
                <td>Jenis Biaya</td>
                <td colspan="2" class="">
                    <select style="display: inline-block; " class="form-control jenis_biaya chosen-select-width1" name="jenis_biaya">
                        <option>- Jenis - Biaya -</option>     
                        @foreach($jenis_bayar as $val)
                        <option value="{{$val->mjb_id}}">{{$val->mjb_id}} - {{$val->mjb_nama}}</option>     
                        @endforeach    
                    </select>
                </td>
              </tr>
              <tr>
                <td>Keterangan</td>
                <td colspan="2" >
                    <textarea style="min-width: 100%; max-height: 300px;max-width: 365px;text-transform: uppercase;" name="keterangan" class="form-control keter"></textarea>
                </td>
              </tr>
            </table>
          </form>
          </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="save_member()">Save changes</button>
      </div>
    </div>
  </div>
</div>



@endsection



@section('extra_scripts')
<script type="text/javascript">
$(document).ready(function(){
  @if(isset($status))
  console.log({{$status}});
  
  toastr.success('Data Berhasil Dihapus');
  @endif
});
var datatable = $('.datatable').DataTable({'paging':false});

function update(ini){
    var parent = ini.parentNode.parentNode;
    var kode = $(parent).find('.kode').val();
    var nama = $(parent).find('.nama').val();
    var harga = $(parent).find('.harga').val();
    console.log(harga);
      $.ajax({
      url:baseUrl + '/presentase/update/'+kode+'/'+nama+'/'+harga,
      type:'get',
      success:function(data){
        toastr.success('Data Berhasil Di Update');
      },
      error:function(){
        toastr.error('Data Gagal Di Update');
      }
    })
}

function tambah(){
  $('.pembiayaan').val('');
  $('.persentase').val('');
  $('.kode_id').val('');
  $('.nama_akun_dropdown').val('0').trigger('chosen:updated');
  $('.cabang').val('0').trigger('chosen:updated');
  $('.jenis_biaya').val('0').trigger('chosen:updated');
  $('.keter').val('');
  $('#myModal').modal('show');
}

 var config1 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width1'     : {width:"100%"}
             }
             for (var selector in config1) {
               $(selector).chosen(config1[selector]);
             }
 var config = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width'     : {width:"100%"}
             }
             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }

    $(".nama_akun").chosen(config1);
    $(".cabang").chosen(config1);  

function save_member(){

    var biaya  = $('.pembiayaan').val();
    var persen = $('.persentase').val();
    var kode_id= $('.kode_id').val();
    var cabang = $('.cabang').val();
    var akun   = $('.nama_akun_dropdown').val();
    var ket    = $('.keter').val();
    var jenis_biaya  = $('.jenis_biaya').val();
    console.log(biaya);
    console.log(cabang);
    console.log(akun);
    console.log(jenis_biaya);
if (kode_id == '') {
    if(biaya != '' && persen != '' && cabang != 0 && akun != 0 && ket != '' && jenis_biaya != '0'){
       swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      },
      function(){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          $.ajax({
          url:baseUrl+'/presentase/tambah',
          type:'get',
          data: $('.modal_form :input').serialize(),
          success:function(response){
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       location.reload
            });
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
   }else{
    toastr.warning('Data harus diisi semua');
   }
 }else{
  if(biaya != '' && persen != '' && cabang != 0 && akun != 0 && ket != '' && jenis_biaya != '0'){
  swal({
        title: "Apakah anda yakin?",
        text: "Simpan Data",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Simpan!",
        cancelButtonText: "Batal",
        closeOnConfirm: false
      },
      function(){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
          });
          $.ajax({
          url:baseUrl+'/presentase/update',
          type:'get',
          data:'kode='+kode_id+'&'+$('.modal_form :input').serialize(),
          success:function(response){
            swal({
            title: "Berhasil!",
                    type: 'success',
                    text: "Data berhasil disimpan",
                    timer: 900,
                   showConfirmButton: true
                    },function(){
                       location.reload();
            });
          },
          error:function(data){
            swal({
            title: "Terjadi Kesalahan",
                    type: 'error',
                    timer: 900,
                   showConfirmButton: true

        });
       }
      });  
     });
   }else{
    toastr.warning('Data harus diisi semua');
   }
 }
}


function dropdown(d){
  var id = $('.cabang').val();

// console.log(d);
  $.ajax({
    url:baseUrl + '/presentase/dropdown',
    data: 'id='+id,
    type:'get',
    success:function(response){
      $('.akun_modal').html(response);
      if (d != undefined) {
        $('.nama_akun_dropdown').val(d).trigger('chosen:updated');
      }else{
        $('.nama_akun_dropdown').val('0').trigger('chosen:updated');
      }

    }
  })

}

function edit_modal(p){
  var par = p.parentNode.parentNode;

  var pembiayaan  = $(par).find('.nama_tabel').val();
  var persen  = $(par).find('.persen_tabel').val();
  var cabang  = $(par).find('.cabang_tabel').val();
  var akun_tabel  = $(par).find('.akun_tabel').val();
  var keterangan  = $(par).find('.keterangan_tabel').val();
  var kode_master  = $(par).find('.kode_master').val();
  var last_name_tabel  = $(par).find('.last_name_tabel').val();
  var jenis_biaya  = $(par).find('.jenis_biaya_detail').val();

 // console.log(kode_akun);
  $('.first_name').val(pembiayaan).trigger('chosen:updated');
  $('.persentase').val(persen);
  $('.last_name').val(last_name_tabel);
  $('.kode_id').val(persen);
  $('.cabang').val(cabang).trigger('chosen:updated');
  $('.nama_akun_dropdown').val(akun_tabel).trigger('chosen:updated');
  $('.keter').val(keterangan);
  $('.kode_id').val(kode_master);
  $('.jenis_biaya').val(jenis_biaya).trigger('chosen:updated');
  dropdown(akun_tabel);
  $('#myModal').modal('show');
  
}
</script>
@endsection
