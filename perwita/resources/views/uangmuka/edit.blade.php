  @extends('main')

@section('title', 'dashboard')
@section('content')
<style type="text/css">
  .textcenter{
    text-align: center;
  }
  .textright{
    text-align: right;
  }
</style>
<form class="form-horizontal" id="voucher_hutang">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Voucher Hutang </h2>
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
                            <strong> Voucher Hutang </strong>
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
                    <h5> Tambah Data
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content">
                        <div class="row">
            <div class="col-xs-12">

              <div class="box" id="seragam_box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body">
                        <div class="row">
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <input type="hidden" name="um_id" id="um_id" value="{{$semua->um_id}}">
                          <label>Nomor Bukti :</label>
                          <input type="text" name="nobukti" readonly="" value="{{$semua->um_nomorbukti}}" class="form-control bukti a" style="text-transform: uppercase" >
                             @if($errors->has('nobukti'))
                                <small style="color: #ed5565">{{ $errors->first('nobukti')}}</small>
                            @endif
                        </div>
                        </div> 
                        <p></p>
                        <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                          <label>Tanggal :</label>
                        <input type="text" class="form-control date b" readonly="" value="{{$semua->um_tgl}}" name="tgl" style="text-transform: uppercase" >
                        
                        </div>
                        <div class="col-sm-4">
                          <label>Agen/Supplier/Subcon :</label>
                       <select class="form-control" name="suppliering" id="suppliering" onchange="change_sup()">
                        <option value="" selected="" disabled="">--Pilih Terlebih dahulu--</option>
                         <option value="supplier">Supplier</option>
                         <option value="agen">Agen</option>
                         <option value="subcon">Subcon</option>
                       </select>
                        
                        </div>
                        </div>
                          {{-- <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                           <select class="form-control chosen-select-width suppilerid d" id="suppilerid" name="supplier">
                                     <option value="" selected="" disabled="">--Pilih Supplier--</option>
                                     @foreach($data as $a)
                                     @if($a->no_supplier == $semua->um_supplier)
                                     <option value="{{$a->no_supplier}}" selected="">{{$a->no_supplier}}</option>
                                     @else
                                     <option value="{{$a->no_supplier}}" data-nama='{{$a->nama_supplier}}'>{{$a->no_supplier}}</option>
                                     @endif
                                     @endforeach
                        </select>
                        
                        </div>
                         <div class="col-sm-5">
                         <label>Supplier Nama :</label>
                           <input type="text" class="form-control suppilername" 
                        
                           @if($semua->nama_supplier === null && $semua->nama_b === null) 
                            value="{{$semua->nama_a}}"  
                           @elseif($semua->nama_a === null && $semua->nama_b === null)  
                            value="{{$semua->nama_supplier}}" 
                           @else 
                            value="{{$semua->nama_b}}" 
                           @endif readonly="" style="text-transform: uppercase">
                        
                        </div>
                        </div> --}}
                        <div class="form-group" >
                        <div class="sembunyikan col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                          <input type="text" readonly="" value="{{$semua->um_supplier}}" name="supplier" class="form-control">
                        </div>
                        <div class="aa"></div>
                         <div class="col-sm-5 sembunyikan">
                         <label>Supplier Nama :</label>
                           <input type="text" class="form-control suppilername"
                           @if($semua->nama_supplier === null && $semua->nama_b === null) 
                            value="{{$semua->nama_a}}"  
                           @elseif($semua->nama_a === null && $semua->nama_b === null)  
                            value="{{$semua->nama_supplier}}" 
                           @else 
                            value="{{$semua->nama_b}}" 
                           @endif readonly="" style="text-transform: uppercase">
                        </div>
                        </div>
                         <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Alamat :</label>
                          <input type="text" name="alamat" value="{{$semua->um_alamat}}" class="form-control hasil e">
                        </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Keterangan : </label>
                          <textarea type="text" class="form-control Keterangan" value="" name="keterangan" style="text-transform: uppercase" >{{$semua->um_keterangan}}</textarea>
                        </div>
                        </div> 
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Total :</label>
                          <input type="text" name="jumlah" class="form-control jumlah e" value="Rp.{{number_format($semua->um_jumlah,0,'','.')}}" placeholder="" style="text-align: right;" >
                        </div>
                        </div>         
                      </div>
                      </div>
                   
                <div class="box-footer">
                  <div class="pull-right">
                    <a class="btn btn-warning" href={{url('uangmuka')}}> Kembali </a>
                    <input type="button" id="submit" name="submit" value="Simpan" class="btn btn-success simpan" onclick="simpan()">

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

<div class="row" style="padding-bottom: 50px;"></div>
</form>

@endsection



@section('extra_scripts')
<script type="text/javascript">

        $(document).ready(function(){
   $('.date').datepicker({
      }).datepicker("setDate", "0");;

   $('.jumlah').maskMoney({thousands:'.',precision:0,prefix:'Rp.'});

});

        $("#suppilerid").change(function(){
        var abc = $(this).find(':selected').data('nama');
        var def = $('.suppilername').val(abc);
    })


          var datatabel = $('.tabel-datatabel').DataTable({
             "paging": false,
            "lengthChange": true,
            "searching": false,
            "ordering": false,
            "info": true,
            "responsive": true,
            "autoWidth": false,
            "pageLength": 10,
            "retrieve" : true,
            "columns": [
              { "width": "10%" },
              null,
              null,
              null,
              null
            ],
            "columnDefs": [
            { "targets": 0, // your case first column
              "className": "text-center"},
            { "targets": 1, // your case first column
              "className": "text-center"}
            ]
          });
         
            
    function simpan (){
      var a = $('#voucher_hutang').serialize();
      var b = $('#um_id').val();
      $.ajax({
        url : baseUrl + "/uangmuka/update/"+ b,
        type:'get',
        data: a,
        success:function(response){
          window.location = ('/jpm/uangmuka')
        }
      })

    }
    function change_sup (){
      var an = $('#suppliering').val();
      $.ajax({
        url : baseUrl + '/uangmuka/ajax',
        type :'get',
        data : {an : an},
        success:function(aaaa){
          $('.sembunyikan').css('display','none'); 
          $('.aa').html(aaaa);
          
        }
      })
    }


</script>
@endsection
