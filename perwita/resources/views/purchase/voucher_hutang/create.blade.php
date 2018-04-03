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
                        @if(session::get('cabang') != 000)
                         <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label> Cabang  </label>
                          <select class="form-control chosen-select-width disabled cabang" name="cabang">
                            @foreach($cabang as $cabang)
                            <option value="{{$cabang->kode}}" @if(Auth()->user()->kode_cabang == $cabang->kode) selected @endif> {{$cabang->nama}} </option>
                            @endforeach
                          </select>                          
                        </div>
                        </div>
                        @else
                          <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label> Cabang  </label>
                          <select class="form-control cabang" name="cabang">
                            @foreach($cabang as $cabang)
                            <option value="{{$cabang->kode}}" @if(Auth()->user()->kode_cabang == $cabang->kode) selected @endif> {{$cabang->nama}} </option>
                            @endforeach
                          </select>                          
                        </div>
                        </div>
                        @endif  

                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Nomor Bukti :</label>
                          <input type="text" name="nobukti" class="form-control bukti a" style="text-transform: uppercase"   readonly="">
                         
                        </div>
                        </div> 
                        <p></p>
                        <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-2">
                          <label>Tanggal :</label>
                        <input type="text" class="form-control date b tanggal"  name="tgl" style="text-transform: uppercase" >
                        </div>
                         <div class="col-sm-3">
                          <label>Tempo :</label>
                        <input type="text" class="form-control c tempo" readonly="" name="tempo" style="text-transform: uppercase" >
                        </div>
                        </div>
                          <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                         <input type="text" class="form-control suppilername" readonly="" name="suppilername" value="" style="text-transform: uppercase">
                        </div>
                         <div class="col-sm-5">
                         <label>Supplier Nama :</label>
                        <select class="form-control chosen-select-width suppilerid d" id="suppilerid" name="supplierid">
                                     <option value="" selected="" disabled="">--Pilih Supplier--</option>
                                     @foreach($sup as $a)
                                     <option value="{{$a->no_supplier}},{{$a->syarat_kredit}}">{{$a->nama_supplier}}</option>
                                     @endforeach
                        </select>
                        </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control Keterangan" name="ket" style="text-transform: uppercase" ></textarea>
                        </div>
                        </div> 
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Total :</label>
                          <input type="text" name="hasil" class="form-control hasil e" readonly="true" style="text-align: right;" >
                        </div>
                        </div> 
                        <input type="hidden" name="total" id="totalhidden" class="totalhidden">         
                      </div>
                      </div>
                      <hr>
                      <h4> Detail Voucher Hutang </h4>
                      <br>
                      <div class="">
                      <table class="table table-bordered table-striped tbl-penerimabarang tabel-datatabel" id="tabel-datatabel">
                        <thead>
                          <tr>
                          <th>No. Urut</th>
                          <th>Account Biaya</th>
                          <th>Keterangan</th>
                          <th>Nominal</th>
                          <th style="text-align: center;"><a  class="addRow"><i class="btn btn-info fa fa-plus pull-right"></i></a></th>
                          </tr>
                        </thead>
                      <tbody>
                      </tbody>
                      </table>
                    </div>
                   
                <div class="box-footer">
                  <div class="pull-right">
                    <a class="btn btn-warning" href={{url('voucherhutang/voucherhutang')}}> Kembali </a>
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

  //CHOSEN SELECT WIDTH
    clearInterval(reset);
          var reset =setInterval(function(){
             var config2 = {
                     '.chosen-select'           : {search_contains:true},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width3'     : {width:"45%",search_contains:true}
                 }
                 for (var selector in config2) {
                   $(selector).chosen(config2[selector]);
                 }

            $('.suppilerid').chosen(config2); 
            $('.cabang').chosen(config2);
            },0);


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
              "className": "text-center"}
           
            ]
          });
          var anjay =[];
          var no = 1;
          $('.addRow').on('click',function(){
               console.log(anjay.length);
              var lol = anjay.length+1;
              datatabel.row.add([
                   '<b class="tengah">' + lol +' </b>',
                  '<input type="text" name="accountid[]" class="form-control f accc" readonly>'+ '&nbsp;&nbsp;' +'<select class="form-control chosen-select-width3 suppilerid hasil" name="supplierid"><option value="" selected="" disabled="">--Pilih Akun--</option>@foreach($akunselect as $a)<option value="{{$a->id_akun}}">{{$a->nama_akun}}</option>@endforeach</select>',
                  '<input type="text" name="keterangan[]" class="form-control g">',
                  '<input type="text" name="nominal[]" onkeyup="hitung(this)" class="nominal form-control h textright" id="nominal">',
                  '<a class="remove textcenter pull-right" onclick="hapus(this)"><i class="btn btn-danger fa fa-minus"></i></a>'
                ]).draw(false);
             anjay.push('123');
             no++;
            $('.hasil').change(function(a) {
              var parent = $(this).parents('tr');
              var angka = $(parent).find('.accc').val($(this).val());
          });
          }); 

          var hasil = [];
          function hapus(h){
            var parent = h.parentNode.parentNode;
            datatabel.row(parent).remove().draw(false);
            var angka = $(parent).find('.nominal').val();
            var index = hasil.indexOf(parseInt(angka));
            var sembarang = hasil.splice(index,1);
            var temp = 0;
             for (var i=0  ; i < hasil.length ;i++){
                temp += parseInt(hasil[i]);
            }
            var money = temp.toLocaleString('de-DE');
            var hasilakir = money.replace(/[^0-9\,-]+/g,"");
            var total = $(".hasil").val("Rp."+money+',00');
            var total = $(".totalhidden").val(hasilakir);
            var lol = anjay.length-1;
            anjay.shift('a');
          }
                 
      
      function hitung(hitung){
      var temp = 0;
      $('.nominal').each(function(i){
        if ($(this).val() != '') {
            hasil[i] = $(this).val();
        }
        else {
         hasil[i] = 0; 
        }
      })
       for (var i=0  ; i < hasil.length ;i++){
          temp += parseInt(hasil[i]);
      }
        var money = temp.toLocaleString('de-DE');
        var hasilakir = money.replace(/[^0-9\,-]+/g,"");
        var total = $(".hasil").val("Rp."+money+',00');
        var n = Number(hasilakir);
        var total = $(".totalhidden").val(n);
      }
    
   $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
    
    $('#suppilerid').change(function() {
          variable = $(this).val();
          string = variable.split(",");
          idsup = string[0];
          syaratkredit = string[1];


          //BULAN
           tanggal = $('.tanggal').val();
          // bulan - bulan
          var months = new Array(12);
          months[0] = "January";
          months[1] = "February";
          months[2] = "March";
          months[3] = "April";
          months[4] = "May";
          months[5] = "June";
          months[6] = "July";
          months[7] = "August";
          months[8] = "September";
          months[9] = "October";
          months[10] = "November";
          months[11] = "December";
          
            syaratkredit = parseInt(syaratkredit);

               var date = new Date(tanggal);
               var newdate = new Date(date);

               newdate.setDate(newdate.getDate() + syaratkredit);

               var dd = newdate.getDate();
               var MM = newdate.getMonth() ;
               var y = newdate.getFullYear();

               var newyear = dd + '-' + months[MM] + '-' + y;
              $('.tempo').val(newyear);


         $('.suppilername').val(idsup);
    });

/*    var a1 = $(".a").val();
       var b1 = $(".b").val();
       var c1 = $(".c").val();
       var d1 = $(".d").val();
       var e1 = $(".e").val();
       var f1 = $(".f").val();
       var g1 = $(".g").val();
       var h1 = $(".h").val();
   var disable = $(".simpan").attr('disabled','disabled');
   
   if (a1 != ''){
      $(".simpan").removeAtrr('disabled');
   }
*/
    
    function simpan (){

       var a1 = $(".a").val();
       var b1 = $(".b").val();
       var c1 = $(".c").val();
       var d1 = $(".d").val();
       var e1 = $(".e").val();
       var f1 = $(".f").val();
       var g1 = $(".g").val();
       var h1 = $(".h").val();

        if(a1 == '' || a1 == null ){
            toastr.info('Nomor Bukti harus di isi');
             $('html,body').animate({scrollTop: $('.a').offset().top}, 200, function() {
              $(".a").focus();
         });
            return false;
        } else {
          $(".simpan").attr('disabled',false);
        }
         if(b1 == '' || b1 == null ){
            toastr.info('Tanggal harus di isi');
             $('html,body').animate({scrollTop: $('.b').offset().top}, 200, function() {
              $(".b").focus();
         });
            return false;
        }
         if(c1 == '' || c1 == null ){
            toastr.info('Tempo harus di isi');
             $('html,body').animate({scrollTop: $('.c').offset().top}, 200, function() {
              $(".c").focus();
         });
            return false;
        }
         if(d1 == '' || d1 == null ){
            toastr.info('Supplier harus di isi');
             $('html,body').animate({scrollTop: $('.d').offset().top}, 200, function() {
              $(".d").focus();
         });
            return false;
        }
        /* if(e1 == '' || e1 == null ){
            alert('Total harus diisi , total adalah jumlah dari nominal di voucher');
            return false;
        }*/
        if(f1 == '' || f1 == null ){
            toastr.info('Account Biaya harus di isi');
             $('html,body').animate({scrollTop: $('.f').offset().top}, 200, function() {
              $(".f").focus();
         });
            return false;
        }
        /*if(g1 == '' || g1 == null ){
            alert(' harus di isi');
             $('html,body').animate({scrollTop: $('.g').offset().top}, 200, function() {
              $(".e").focus();
         });
            return false;
        }*/
        if(h1 == '' || h1 == null ){
            toastr.info('nominal harus di isi');
             $('html,body').animate({scrollTop: $('.h').offset().top}, 200, function() {
              $(".h").focus();
         });
            return false;
        }
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
          url : baseUrl + '/voucherhutang/store1',
          type:"get",
          data: a,
          dataType :'json',
         success : function (response){
              alertSuccess(); 
                window.location.href = baseUrl + "/voucherhutang/voucherhutang"; 
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
      })
    }
    

      $('.cabang').change(function(){
              var comp = $('.cabang').val();
          $.ajax({    
              type :"get",
              data : {comp},
              url : baseUrl + '/voucherhutang/getnota',
             dataType : 'json',
              success : function(data){
              
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

                
                   nota = 'VC' + month + year2 + '/' + comp + '/' +  data.idvc;
                  console.log(nota);
                  $('.bukti').val(nota);
              }
          })
      })

      var comp = $('.cabang').val();
        $.ajax({    
            type :"get",
            data : {comp},
            url : baseUrl + '/voucherhutang/getnota',
           dataType : 'json',
            success : function(data){
            
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

              
                 nota = 'VC' + month + year2 + '/' + comp + '/' +  data.idvc;
                console.log(nota);
                $('.bukti').val(nota);
            }
        })


</script>
@endsection
