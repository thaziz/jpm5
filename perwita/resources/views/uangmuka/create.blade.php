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

   .disabled {
    pointer-events: none;
    opacity: 1;
}
</style>
<form class="form-horizontal" id="voucher_hutang">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Uang Muka Pembelian </h2>
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
                            <strong> Uang Muka Pembelian </strong>
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
                          <label> Cabang  </label>

                             @if(Auth::user()->punyaAkses('Uang Muka','cabang'))
                            <select class="form-control chosen-select-width cabang" name="cabang">
                                @foreach($cabang as $cabang)
                              <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                              @endforeach
                            </select>
                            @else
                              <select class="form-control disabled cabang" name="cabang">
                                @foreach($cabang as $cabang)
                                <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                                @endforeach
                              </select> 
                            @endif
                          </div>
                          </div>

                          <input type="hidden" name="username" value="{{Auth::user()->m_name}}">
                    

                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Nomor Bukti :</label>
                          <input type="text" name="nobukti" readonly="" class="form-control bukti a" style="text-transform: uppercase" >
                           <!--   @if($errors->has('nobukti'))
                                <small style="color: #ed5565">{{ $errors->first('nobukti')}}</small>
                            @endif -->
                        </div>
                        </div> 
                        <p></p>
                        <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                          <label>Tanggal :</label>
                        <input type="text" class="form-control date b" readonly="" name="tgl" style="text-transform: uppercase" >
                        
                        </div>
                        <div class="col-sm-4">
                          <label>Agen/Supplier/Subcon :</label>
                       <select class="form-control" name="suppliering" id="suppliering" onchange="change_sup()" required="">
                        <option value="" selected="" disabled="">--Pilih Terlebih dahulu--</option>
                         <option value="supplier">Supplier</option>
                         <option value="agen">Agen</option>
                         <option value="subcon">Subcon</option>
                       </select>
                        
                        </div>
                        </div>
                        <div class="form-group" >
                        <div class="sembunyikan col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                          <input type="text" readonly="" value="--Pilih Supplier Terlebih dahulu --" class="form-control" required="">
                        </div>
                        <div class="aa"></div>
                         <div class="col-sm-5 sembunyikan">
                         <label>Supplier Nama :</label>
                           <input type="text" class="form-control suppilername" readonly="" style="text-transform: uppercase" required="">
                        </div>
                        </div>
                         <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Alamat :</label>
                          <input type="text" name="alamat" class="form-control hasil e">
                        </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control Keterangan" name="keterangan" style="text-transform: uppercase" ></textarea>
                        </div>
                        </div> 
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Total :</label>
                          <input type="text" name="jumlah" class="form-control jumlah e" placeholder="" style="text-align: right;" >
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
        autoclose: true,
        format: 'dd-MM-yyyy',
     
      }).datepicker("setDate", "0");;

   $('.jumlah').maskMoney({thousands:'.',precision:0,prefix:'Rp.'});

});

      
    $('.cabang').change(function(){
            var comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/uangmuka/getnota',
           dataType : 'json',
            success : function(data){

                if(data.status == 'sukses'){
                  var d = new Date();
                
                  //tahun
                  var year = d.getFullYear();
                  //bulan
                  var month = d.getMonth();
                  var month1 = parseInt(month + 1)
                  console.log(d);
                  console.log();
                  console.log(year);

                  if(month < 10) {
                    month = '0' + month1;
                  }

                  console.log(d);

                  tahun = String(year);
  //                console.log('year' + year);
                  year2 = tahun.substring(2);
                  //year2 ="Anafaradina";

                
                   nota = 'UM' + month + year2 + '/' + comp + '/' +  data.data;
                  console.log(nota);
                  $('.bukti').val(nota);
                }
                else {
                  location.reload();
                }
            

            }
        })
    })

      var comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/uangmuka/getnota',
           dataType : 'json',
            success : function(data){
            
                if(data.status == 'sukses'){
                  var d = new Date();
                
                  //tahun
                  var year = d.getFullYear();
                  //bulan
                  var month = d.getMonth();
                  var month1 = parseInt(month + 1)
                  console.log(d);
                  console.log();
                  console.log(year);

                  if(month < 10) {
                    month = '0' + month1;
                  }

                  console.log(d);

                  tahun = String(year);
  //                console.log('year' + year);
                  year2 = tahun.substring(2);
                  //year2 ="Anafaradina";

                
                   nota = 'UM' + month + year2 + '/' + comp + '/' +  data.data;
                  console.log(nota);
                  $('.bukti').val(nota);
                }
                else {
                  location.reload();
                }
            }
        })

    


        cabang = $('.cabang').val();
        $('.valcabang').val(cabang);

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

       event.preventDefault();
         
            swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Uang Muka!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
          },
          function(){
        $.ajax({
          url : baseUrl + "/uangmuka/store",
          type:'get',
          data: a,
          dataType : "json",
          success : function (response){
            //  console.log(response.status);
               if(response.status == "gagal"){
                   
                    swal({
                        title: "error",
                        text: response.info,
                        type: "error",                        
                    });
                }
                else {
               alertSuccess(); 
               window.location.href = baseUrl + "/uangmuka";
                 }
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      });

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
