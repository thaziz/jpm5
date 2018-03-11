@extends('main')

@section('title', 'dashboard')
@section('content')
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
                          <label>Nomor Bukti :</label>
                          <input type="text" name="nobukti" class="form-control bukti" value="{{ $data1->v_nomorbukti }}" style="text-transform: uppercase" >
                        </div>
                        </div> 
                        <p></p>
                        <div class="form-group">
                        <div class="col-sm-5 col-sm-offset-2">
                          <label>Tanggal :</label>
                        <input type="text" class="form-control date" value="{{ $data1->v_tgl }}" readonly="" name="tgl" style="text-transform: uppercase" >
                        </div>
                         <div class="col-sm-3">
                          <label>Tempo :</label>
                        <input type="text" class="form-control date" value="{{ $data1->v_tempo }}" readonly="" name="tempo" style="text-transform: uppercase" >
                        </div>
                        </div>
                          <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                         <input type="text" class="form-control suppilername" readonly="" value="{{ $data1->v_supid }}" name="suppilername" value="" style="text-transform: uppercase">
                        </div>
                         <div class="col-sm-5">
                         <label>Supplier Nama :</label>

                        <select class="form-control chosen-select-width suppilerid" id="suppilerid" name="supplierid" required="">
                                    @foreach($sup as $a)
                                    @if ($data1->v_supid == $a->no_supplier)
                                    <option value="{{$a->no_supplier}}" selected="true">{{$a->nama_supplier}}</option>    
                                    @else
                                    <option value="{{$a->no_supplier}}">{{$a->nama_supplier}}</option>
                                    @endif
                                    @endforeach
                        </select>
                        </div>
                        </div>
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Keterangan :</label>
                          <textarea type="text" class="form-control Keterangan" name="ket"  style="text-transform: uppercase" >{{ $data1->v_keterangan }}</textarea>
                        </div>
                        </div> 
                        <div class="form-group">
                         <div class="col-sm-8 col-sm-offset-2">
                          <label>Total :</label>
                          <input type="text" name="hasil" value="Rp.{{number_format($data1->v_hasil)}},00" class="form-control hasil" readonly="true" style="text-align: right;" >
                        </div>
                        </div>
                        <input type="hidden" name="idhidden" id="idhidden" value="{{$data1->v_id}}"> 
                        <input type="hidden" name="total" id="totalhidden" class="totalhidden" value="{{$data1->v_hasil}}">         
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
                          <th style="text-align: center;"><a  class="addRow"><i class="btn btn-info fa fa-plus"></i></a></th>
                          </tr>
                        </thead>
                      <tbody>
                          @foreach($data as $index => $a)
                        <tr>
                            <td>{{$index+1}}</td>
                            <td><input type="text" name="accountid[]" class="form-control kiri" value="{{$a->vd_acc}}" readonly="">&nbsp;&nbsp;<select class="form-control chosen-select-width3  suppilerid kanan">
                                @foreach($akunselect as $b) 
                                <option value="{{$b->id_akun}}">{{$b->nama_akun}}</option>
                                @endforeach
                              </select></td>
                            <td><input type="text" name="keterangan[]" class="form-control"  value="{{$a->vd_keterangan}}"></td>
                            <td><input type="text" name="nominal[]" onkeyup="hitung(this)" class="nominal form-control" value="{{$a->vd_nominal}}"></td>
                            <td><a class="remove" onclick="hapus(this)"><i class="btn btn-danger fa fa-minus"></i></a></td>
                          </tr>
                          @endforeach
                      </tbody>
                      </table>
                    </div>
                   
                <div class="box-footer">
                  <div class="pull-right">
                    <a class="btn btn-warning" href={{url('voucherhutang/voucherhutang')}}> Kembali </a>
                    <input type="button" id="submit" name="submit" value="Simpan" class="btn btn-success" onclick="simpan()">

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
          var reset =setInterval(function(){
             var config2 = {
                   '.chosen-select'           : {search_contains:true},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width3'     : {width:"40%",search_contains:true}
                 }
                 for (var selector in config2) {
                   $(selector).chosen(config2[selector]);
                 }

            $('.suppilerid').chosen(config2); 
            },0);
          $('.kanan').change(function() {
               $('.kiri').val($(this).val());
          });  
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
          var anjay =[];
          @foreach($data as $i =>$asw)
              anjay[{{$i}}] = {{$i}};
          @endforeach
          $('.addRow').on('click',function(){
              console.log(anjay.length);
              var lol = anjay.length+1;
              datatabel.row.add([
                  '<b class="tengah">' + lol +' </b>',
                  '<input type="text" name="accountid[]" class="form-control">'+ '&nbsp;&nbsp;' +'<select class="form-control chosen-select-width3 suppilerid hasil" name="supplierid"><option value="" selected="" disabled="">--Pilih Supplier--</option>@foreach($akunselect as $a)<option value="{{$a->id_akun}}">{{$a->nama_akun}}</option>@endforeach</select>',
                  '<input type="text" name="keterangan[]" class="form-control">',
                  '<input type="text" name="nominal[]" onkeyup="hitung(this)" class="nominal form-control" >',
                  '<a class="remove" onclick="hapus(this)"><i class="btn btn-danger fa fa-minus"></i></a>'
                ]).draw(false);
              anjay.push('123');
          });

          function hapus(h){
            var parent = h.parentNode.parentNode;
            datatabel.row(parent).remove().draw(false);            
          }

      var hasil = [];
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
        var total = $(".totalhidden").val(hasilakir);
        console.log(hasilakir);
      }
    
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    });
    
    $('#suppilerid').change(function() {
         $('.suppilername').val($(this).val());
    });
   
    function simpan (){
      var a = $('#idhidden').val();
      var b = $('#voucher_hutang').serialize();
      console.log(a);
      $.ajax({
        url : baseUrl + "/voucherhutang/updatevoucherhutang/"+a,
        type:'get',
        data: b,
        success:function(response){
            window.location = ('/jpm/voucherhutang/voucherhutang')
        }
      })

    }

</script>
@endsection
