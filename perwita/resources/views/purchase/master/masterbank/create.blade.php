@extends('main')

@section('title', 'dashboard')

@section('content')
<style type="text/css">
.disabled {
    pointer-events: none;
    opacity: 1;
}
</style>

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2> Master Bank </h2>
                    <ol class="breadcrumb">
                        <li>
                            <a >Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Bank</a>
                        </li>
                        <li class="active">
                            <strong> Create Master Bank </strong>
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
                
                </div>
                   
                 <label class="label label-info"> Master Bank </label>    
                <div class="box-body">
                  <form method="post" action="{{url('masterbank/savemasterbank')}}"  enctype="multipart/form-data" class="form-horizontal" id="formId">

                <div class="row">
                    <div class="col-sm-6">
                    
                      <br>
                      <br>
                     
                      <table class="table">


                        <input type="hidden" name="_token" value="{{ csrf_token() }}" readonly="">

                        <tr>
                          <td> Jenis Bank </td>
                          <td> <select class="form-control statusbg" name="statusbg"> <option value="SERIBG"> SERI BG </option> <option value="BUKAN BG"> BUKAN SERI / BG </option> </select> </td>
                        </tr>
                        <tr>
                          <td> Pengajuan dari Cabang : </td>
                          <td> 
                            @if(Auth::user()->punyaAkses('Master Bank','cabang'))
                            <select class="form-control chosen-select cabang" name="cabang" required="" style="min-width:60%">
                                @foreach($data['cabang'] as $cabang)
                              <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                              @endforeach
                            </select>
                            @else
                              <select class="form-control disabled cabang" name="cabang" required="" style="min-width:60%">>
                                @foreach($data['cabang'] as $cabang)
                                <option value="{{$cabang->kode}}" @if($cabang->kode == Session::get('cabang')) selected @endif> {{$cabang->nama}} </option>
                                @endforeach
                              </select> 
                            @endif
                             </td>
                        </tr>

                        <tr>
                          <td > Kode Bank </td> 
                          <td>
                          <div class="row">
                            <div class="col-sm-4">
                                 <input type="text" class="input-sm form-control idbank" readonly="" name="kodebank" required="" style="min-width:60%">
                             
                                <div class="inputseri"> </div>
                            </div>
                            <div class="col-sm-8">
                            
                             <select class="form-control input-sm chosen-select-width bank" required="" style="min-width:60%">>
                             <option value="">  Pilih Bank  </option>
                                @foreach($data['bank'] as $bank)
                                 <option value="{{$bank->id_akun}}">{{$bank->id_akun}} - {{$bank->nama_akun}}  </option>  
                                @endforeach
                              </select>
                           
                            </div>
                            </div>
                          </td>
                       
                        </tr> 
                        <tr>
                          <td> Nama Bank </th>
                          <td> <input type="text" class="input-sm form-control" name="nmbank" required="" style="text-transform: uppercase" style="min-width:60%"> </td>
                        </tr>
                        <tr>
                          <td> Cabang Bank </td>
                          <td> 
                            <select class="form-control chosen-select" name="cabangbawah">
                              @foreach($data['cabang'] as $cabang)
                                <option value="{{$cabang->kode}}"> {{$cabang->nama}} </option>
                                @endforeach
                            </select>
                          </td>
                        </tr>
                        </table>
                      
                          </div>

                          <div class="col-sm-6">
                          <br>
                          <br>
                          <div class="table-resposive">
                          <table class="table">
                        <tr>
                          <td> No Rekening </td>
                          <td> <input type="text" class="input-sm form-control" name="norekening" required=""></td>
                        </tr>
                         <tr>
                          <td> Nama Rekening </td>
                          <td> <input type="text" class="input-sm form-control" name="namarekening" required="" style="text-transform: uppercase"></td>
                        </tr>
                        <tr>
                          <td> Alamat </td>
                          <td> <input type="text" class="input-sm form-control" name="alamat" required="" style="text-transform: uppercase"></td>
                        </tr>
                        <tr>  
                          <td> Kelompok Bank </td>
                          <td>
                            <select class="form-control chosen-select" name="kelompokbank" required=""> 
                              <option value=""> Pilih Kelompok Bank </option>
                              @foreach($data['jenisbank'] as $jenisbank)
                              <option value="{{$jenisbank->id}}"> {{$jenisbank->namabank}} </option>
                              @endforeach
                            </select>
                          </td>
                        </tr>
                      </table>
                      </div>
                      </div>

                      <div class="col-xs-12">
                      <div class="table-responsive">
                      <table class="table">
                       <tr>
                        <td>
                          <div class="checkbox">
                            <input type="checkbox" class="sericek"  id="sericek" value="CEK" aria-label="Single checkbox One" name="seri">
                            <label>  Seri Cek</label>
                          </div>                   
                        </td>
                        <td>
                          <div class="col-sm-2">
                            <input type="text" class="input-sm form-control inputcek" name="sericek" style="text-transform:uppercase">
                          </div>
                          <div class="col-sm-1">
                            Tgl Buku 
                          </div>
                          <div class="col-sm-3">
                            <div class="input-group date" required="">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="input-sm form-control" name="tglbukucek" required="" id="tglbukucek">
                            </div>
                          </div>
                          <div class="col-sm-1">
                            No Urut 
                          </div> 
                          <div class="col-sm-2">
                           <input type="number" class="input-sm form-control urutcek" name="awalsericek">
                          </div> 
                          <div class="col-sm-1">
                           s/d 
                          </div>
                          <div class="col-sm-2">
                           <input type="text" class="input-sm form-control hasilurutcek" readonly="" name="akhirsericek">
                          </div>
                        </td>
                       </tr>

                       <tr>
                       <td>
                        <div class="checkbox">
                            <input type="checkbox" class="sericek" id="sericekbg" value="BG" aria-label="Single checkbox One" name="seri">
                            <label>  Seri BG</label>
                          </div>
                       </td>

                        <td>
                          <div class="col-sm-2">
                            <input type="text" class="input-sm form-control inputbg" name="seribg" style="text-transform: uppercase">
                          </div>
                          <div class="col-sm-1">
                            Tgl Buku 
                          </div>
                          <div class="col-sm-3">
                            <div class="input-group date" required="">
                              <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tglbukubg" required="" id="tglbukubg">
                            </div>
                          </div>
                          <div class="col-sm-1">
                         No Urut
                          </div> 
                          <div class="col-sm-2">
                           <input type="number" class="input-sm form-control urutbg" name="awalseribg">
                          </div> 
                          <div class="col-sm-1">
                           s/d 
                          </div>
                          <div class="col-sm-2">
                           <input type="text" class="input-sm form-control hasilurutbg "  name="akhirseribg" readonly>
                          </div>
                        </td>
                       </tr>

                       <tr>
                        <td> Masih Aktif </td>
                        <td> <div class="col-sm-2"><select class="form-control" name="mshaktif"> <option value="Y"> Ya </option> <option value="T"> Tidak </option> </select> </div> </td>
                       </tr>

                      </table>
                      </div>
                      </div>
                  </div>
                   <label class="label label-info"> No Seri Cek / BG </label>
                   <br>
                   <br>
                    <div class="box">
                      <table class="table">
                     <!--  <tr>
                        <td> No Seri Pajak </td>
                        <td> <input type="text" class="input-sm form-control"> </td>
                        <td> Tgl Buku </td>
                        <td> <input type="text" class="input-sm form-control"> </td>
                        <td> No FPG </td>
                        <td> <input type="text" class="input-sm form-control"> </td>
                      </tr> -->
                      <tr>
                        <td> <button class="btn  btn-success" id="buatseri" type="button"> Buat seri Cek / BG </button> &nbsp; <button class="btn  btn-primary" type="button" id="hapusseri"> Hapus No Seri Cek / BG </button>  </td>
<!--                         <td colspan="2"> <button class="btn  btn-success" style="width:80%" type="button"> Cari No Seri Cek / BG </button> </td> -->
                        <td> </td>
                      </tr>
                      </table>

                      <table class="table tbl-cek" id="tbl-cek">
                        <thead>
                        <tr>
                          <th> Rusak </th>
                          <th> Kode Bank </th>
                          <th> No Seri </th>
                          <th> Tgl Buku </th> 
                          <th> No FPG </th>
                          <th> No BBK </th>
                          <th> Setuju </th>
                          <th> Status </th> 
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                </div>

                <div class="box-footer">
                  <div class="pull-right">
                  
                    <a class="btn  btn-warning" href={{url('masterbank/masterbank')}}> Kembali </a>
                   <input type="submit"  name="submit" value="Simpan" class="btn btn-success" id="submit">
                  </form>
                    
                    
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


@endsection



@section('extra_scripts')
<script type="text/javascript">
    $(document).ready(function(){
      var config = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width'     : {width:"95%"}
                }

             for (var selector in config) {
               $(selector).chosen(config[selector]);
             }


       $(".bank").chosen(config);
    })


    cabang = $('.cabang').val();
    $('.valcabang').val(cabang);

    $('#submit').click(function(){

      statusbg = $('.statusbg').val();
      if(statusbg == 'BUKAN BG'){

      }
      else {
         val = $('#noseri').val();
        if(val === undefined){
       /*   alert("Harap Buat no seri CEK / BG :)");*/
         toastr.info('Harap Buat no seri CEK / BG :)');
          return false;
        }
      }
     
    });


    $('#formId').submit(function(){
        if(!this.checkValidity() ) 
          return false;
        return true;
    })

    $('#formId').submit(function(event){
        event.preventDefault();
        var post_url2 = $(this).attr("action");
        var form_data2 = $(this).serialize();

        var form_datatable = tableBank.$('input').serialize();

           swal({
            title: "Apakah anda yakin?",
            text: "Simpan Data Master Bank!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Ya, Simpan!",
            cancelButtonText: "Batal",
            closeOnConfirm: false
          },
          function(){

          $.ajax({
          type : "post",
          data : form_data2 + '&'+ form_datatable,
          url : post_url2,
          dataType : 'json',
          success : function (response){
           console.log(response);
             if(response == 'sukses') {
                alertSuccess(); 
               window.location.href = baseUrl + "/masterbank/masterbank";
             } 
          },
          error : function(){
           swal("Error", "Server Sedang Mengalami Masalah", "error");
          }
        })
        
        })
    })

    $('#formId input').on("invalid" , function(){
      this.setCustomValidity("Harap di isi :) ");
    })

    $('#formId input').change(function(){
      this.setCustomValidity("");
    })


    tableDetail = $('.tbl-cek').DataTable({
      responsive: true,
    
      paging: true,
      "pageLength": 10,
      "language": dataTableLanguage,
    });


//CHANGE SERI CEK
  $('.sericek').change(function(){ 
    val =   $(this).val();

   

      if(val == 'CEK'){

           if(($('#sericek').prop('checked') == true)){
              $('.inputcek').attr('disabled' , false);
              $('.urutcek').attr('disabled' , false);
                if(($('#sericekbg').prop('checked') == true)){
                  $('.inputbg').attr('disabled' , false);
                  $('.urutbg').attr('disabled' , false);
                }
                else {               
                   $('.inputbg').attr('disabled' , true);
                  $('.urutbg').attr('disabled' , true);
                }
           }
           else {
                if(($('#sericekbg').prop('checked') == true)) {
                       $('.inputcek').attr('disabled' , true);
                       $('.urutcek').attr('disabled' , true);
                 }
                 else {
                      
                    $('.inputcek').attr('disabled' , false);
                    $('.urutcek').attr('disabled' , false);
                    $('.inputbg').attr('disabled' , false);
                    $('.urutbg').attr('disabled' , false); 
                 }
           }

         

      }
      else {
            if(($('#sericekbg').prop('checked') == true)){
                $('.inputbg').attr('disabled' , false);
                $('.urutbg').attr('disabled' , false);
                  if(($('#sericek').prop('checked') == true)) {
                     $('.inputcek').attr('disabled' , false);
                     $('.urutcek').attr('disabled' , false);
                  }
                  else {              
                      $('.inputcek').attr('disabled' , true);
                      $('.urutcek').attr('disabled' , true);
                  }
            }
            else {
                if(($('#sericek').prop('checked') == true)) {
                       $('.inputbg').attr('disabled' , true);
                       $('.urutbg').attr('disabled' , true);
                 }
                  else {
                      $('.inputcek').attr('disabled' , false);
                      $('.urutcek').attr('disabled' , false);
                      $('.inputbg').attr('disabled' , false);
                      $('.urutbg').attr('disabled' , false);   
                  }

            }

         


      }
  })
     var tableBank = $('#tbl-cek').DataTable();

  $('#hapusseri').click(function(){
     var tableBank = $('#tbl-cek').DataTable();
     var remove = tableBank.rows().remove().draw();
     arrnourutcek = [];
     arrnourutbg = [];
   
  })

  arrnourutcek = [];
  arrnourutbg = [];
  uniquenourutCek = [];
  arrnourut2cek = [];
  arrnourut2bg = [];
  $('#buatseri').click(function(){
    //alert(hel);

    
      nosericek = $('.inputcek').val().toUpperCase();
      noseribg = $('.inputbg').val().toUpperCase();

    if($('#sericek').prop('checked') == true && $('#sericekbg').prop('checked') == true ) { // CEK DOUBLE

        var inputseri = '<input type="hidden" name="input" value="centangdua">';
        $('.inputseri').html(inputseri);

        //cek
        idbank = $('.idbank').val();
        nosericek = $('.inputcek').val();
        urutcek = $('.urutcek').val();           
        tglbukucek = $('#tglbukucek').val();
        hasilurutcek = $('.hasilurutcek').val();

        //BG
        noseribg = $('.inputbg').val();
        urutbg = $('.urutbg').val();           
        tglbukucek = $('#tglbukubg').val();
        hasilurutcek = $('.hasilurutbg').val();


        //PENGECEKAN INPUT KOSONG
         if(nosericek == ''){
            if(noseribg != ''){
                toastr.info('Harap isi no seri cek :)');
              //  alert("Harap isi no seri cek :)");
              }
            else {
              //alert("Harap isi no seri BG :)");
                toastr.info('Harap isi no seri BG :)');
            }
          }
          else if(noseribg == ''){
            if(nosericek != ''){
              toastr.info('Harap isi no seri BG :)');
            //  alert("Harap isi no seri BG :) ");
            }
            else {
              //alert("Harap isi no seri cek :)");
              toastr.info('Harap isi no seri cek :)');
            }
          }
          else if(urutcek == ''){
            if(urutbg != ''){
             // alert("Harap isi No urut CEK :)");
               toastr.info('Harap isi No urut CEK :)');
            }
            else {
//              alert("Harap isi no urut BG :)");
              toastr.info('Harap isi no urut BG :)');
            }
          }
          else if(urutbg == ''){
            if(urutcek !== ''){
             // alert("Harap isi No Urut BG :)");
              toastr.info('Harap isi No Urut BG :)');
            }
            else {
              toastr.info('Harap is no urut CEK :)');

            //  alert("Harap is no urut CEK :)");
            }
          } //SELESAI PENGECEKAN INPUT
          else {
          idbank = $('.idbank').val();
          nosericek = $('.inputcek').val();
          urutcek = $('.urutcek').val();           
          tglbukucek = $('#tglbukucek').val();
          hasilurutcek = $('.hasilurutcek').val();

          noseribg = $('.inputbg').val();
          urutbg = $('.urutbg').val();           
          tglbukubg = $('#tglbukubg').val();
          hasilurutbg = $('.hasilurutbg').val();

          tempcek = 1;
         
          for(ds = 0; ds <= arrnourutcek.length ; ds++){ // CEK DOUBLE 
            if(arrnourutcek[ds] == urutcek){
             tempcek = parseInt(tempcek) + 1;
            }
            else {
              for(i=1;i<=arrnourutcek.length;i++){
                if(arrnourutcek[ds + i] == urutcek){
                   tempcek = parseInt(tempcek) + 1;
                }
              }
            }
            urutcek++;
          } //END FOR CEK DOUBLE


          tempbg = 1;
          for(ds = 0; ds <= arrnourutbg.length ; ds++){ // CEK DOUBLE BG
            if(arrnourutbg[ds] == urutbg){
             tempbg = parseInt(tempbg) + 1;
            }
            else {
              for(i=1;i<=arrnourutbg.length;i++){
                if(arrnourutbg[ds + i] == urutbg){
                   tempbg = parseInt(tempbg) + 1;
                }
              }
            }
            urutbg++;
          } //END FOR CEK DOUBLE BG

         
          if(tempcek > 1 ){ // JIKA CEK DOUBLE
          //  alert('No seri Cek sudah digunakan :)' );
             toastr.info('No seri Cek sudah digunakan :)');

          }
          else if(tempbg > 1) {
          //  alert('No seri BG sudah digunakan :)');
             toastr.info('No seri BG sudah digunakan :)');

          }
          else {
          idbank = $('.idbank').val();
          nosericek = $('.inputcek').val();
          urutcek = $('.urutcek').val();           
          tglbukucek = $('#tglbukucek').val();
          hasilurutcek = $('.hasilurutcek').val();

          noseribg = $('.inputbg').val();
          urutbg = $('.urutbg').val();           
          tglbukubg = $('#tglbukubg').val();
          hasilurutbg = $('.hasilurutbg').val();
          //buat noseri
          var tableBank = $('#tbl-cek').DataTable();
        
          var n = 1;
          


          $temp0 = 0; 
          val = $('.urutcek').val();
          str = val.search('0');  
          if(val.indexOf(str) == 0){ // CEK jika depan nya ada 0 urutcek
            lengthval = urutcek.length;            
            for(i = 0; i < lengthval; i++){          
              if(val.indexOf('0' , i) == i){
                $temp0 = parseInt($temp0) + 1;
              }
              else {
               i = lengthval;
              }
            }  
          }

          $tempbg = 0;
          strbg = urutbg.search('0');
          if(urutbg.indexOf(strbg) == 0){
            lengthbg = urutbg.length;
            for(i = 0; i < lengthbg; i++){
              if(urutbg.indexOf('0' , i) == i){
                $tempbg = parseInt($tempbg) + 1;
              }
              else {
                i = lengthbg;
              }
            }
          }
          
          for(var i = urutcek; i <= hasilurutcek; i++){ //ADD TABLE
            if($temp0 != 0){
              urutcek = pad(urutcek, lengthval);
            }
            else {
              urutcek = urutcek;
            }
            var html2 = "<tr>" + 
                        "<td><div class='checkbox'> <input type='checkbox' class='rusak'  aria-label='Single checkbox One'>" +
                        "<label></label>" +
                        "</div></td>" +
                        "<td>"+idbank+"</td>" +
                        "<td>"+nosericek+urutcek +" <input type='hidden' value="+nosericek+urutcek +" name='nosericek[]' id='noseri'> </td>" +
                        "<td>"+tglbukubg+"</td>"+
                        "<td> </td>"+
                        "<td> </td>"+
                        "<td> </td>"+
                        "<td> </td>";
                              
            html2 +=  "</tr>";

              arrnourut2cek.push(urutcek);
              tableBank.rows.add($(html2)).draw();
           
           
            urutcek++;
          
            }


            for(var j = urutbg; j <= hasilurutbg; j++){ //LOOPING BG
              if($tempbg != 0){
                urutbg = pad(hasilurutbg, lengthbg);
              }
              else {
                urutbg = urutbg;
              }
              var html3 = "<tr>" + 
                        "<td><div class='checkbox'> <input type='checkbox' class='rusak'  aria-label='Single checkbox One'>" +
                        "<label></label>" +
                        "</div></td>" +
                        "<td>"+idbank+"</td>" +
                        "<td>"+noseribg+urutbg +" <input type='hidden' value="+noseribg+urutbg +" name='noseribg[]' id='noseri'></td>" +
                        "<td>"+tglbukubg+"</td>"+
                        "<td> </td>"+
                        "<td> </td>"+
                        "<td> </td>"+
                        "<td> </td>";
                              
            html3 +=  "</tr>";

              arrnourut2bg.push(urutbg);
              tableBank.rows.add($(html3)).draw();
           
           
            urutbg++;
            }
          }    //END ELSE   jika double 
		}		  
    }
    else {
      if($("#sericek").prop('checked') == true ){ //SERI CEK


        var inputseri = '<input type="hidden" name="input" value="CEK">';
        $('.inputseri').html(inputseri);



            idbank = $('.idbank').val();
            noseri = $('.inputcek').val();
            urutcek = $('.urutcek').val();           
            tglbukubg = $('#tglbukucek').val();
            hasilurutcek = $('.hasilurutcek').val();
          
           // alert(urutcek + 'urutcek');
              if(noseri == ''){
               // alert('Mohon di isi no seri cek :)');
                 toastr.info('Mohon di isi no seri cek :)');
              }
              else {
                if(urutcek == ''){
                 // alert('Mohon di isi no urut cek :)');
                   toastr.info('Mohon di isi no urut cek :)');
                }
                else {
             //     alert('masuk');
                  idbank = $('.idbank').val();
                  noseri = $('.inputcek').val();
                  urutcek = $('.urutcek').val();           
                  tglbukubg = $('#tglbukucek').val();
                  hasilurutcek = $('.hasilurutcek').val();

                  $('.inputbg').attr('disabled' , true);
                  $('.urutbg').attr('disabled' , true);

                  temp = 1;
                
                  for(ds = 0; ds < arrnourutcek.length; ds++){ // CEK DOUBLE
                    if(arrnourutcek[ds] == urutcek){
                     temp = parseInt(temp) + 1;
                    }
                    else {
                      for(i=1;i<=arrnourutcek.length;i++){
                        if(arrnourutcek[ds + i] == urutcek){
                           temp = parseInt(temp) + 1;
                        }
                      }
                    }
                    urutcek++;
                  }

                  if(temp > 1 ){ // JIKA DOUBLE
                   // alert('No seri Cek sudah digunakan :)' );
                   toastr.info('No seri Cek sudah digunakan :)');

                  }
                  else {
                   idbank = $('.idbank').val();
                  noseri = $('.inputcek').val();
                  urutcek = $('.urutcek').val();           
                  tglbukubg = $('#tglbukucek').val();
                  hasilurutcek = $('.hasilurutcek').val();
                  //buat noseri
                  var tableBank = $('#tbl-cek').DataTable();
                
                  var n = 1;
                  $temp0 = 0; 
                  val = $('.urutcek').val();
                  str = val.search('0');  
                  if(val.indexOf(str) == 0){ // CEK jika depan nya ada 0 urutcek
                    lengthval = urutcek.length;            
                    for(i = 0; i < lengthval; i++){          
                      if(val.indexOf('0' , i) == i){
                        $temp0 = parseInt($temp0) + 1;
                      }
                      else {
                       i = lengthval;
                      }
                    }  
                  }

                  for(var i = urutcek; parseInt(i) <= parseInt(hasilurutcek); i++){ //ADD TABLE


                    if($temp0 != 0){
                      urutcek = pad(urutcek,lengthval);
                    }
                    else{
                      urutcek = urutcek;
                    }
                    
                    var html2 = "<tr>" + 
                                "<td><div class='checkbox'> <input type='checkbox' class='rusak'  aria-label='Single checkbox One'>" +
                                "<label></label>" +
                                "</div></td>" +
                                "<td>"+idbank+"</td>" +
                                "<td>"+noseri+urutcek +" <input type='hidden' value="+noseri+urutcek +" name='nosericek[]' id='noseri'></td>" +
                                "<td>"+tglbukubg+"</td>"+
                                "<td> </td>"+
                                "<td> </td>"+
                                "<td> </td>"+
                                "<td> </td>";
                                      
                    html2 +=  "</tr>";

                      arrnourutcek.push(urutcek);
                      tableBank.rows.add($(html2)).draw();
                   
                   
                    urutcek++;
                  
                    }
                  }         
                }//END ELSE   jika double
              }
          }

      if($('#sericekbg').prop('checked') == true){ ////SERI BG

           var inputseri = '<input type="hidden" name="input" value="BG">';
        $('.inputseri').html(inputseri);

        idbank = $('.idbank').val();
        noseribg = $('.inputbg').val();
        urutbg = $('.urutbg').val();

        tglbukubg = $('#tglbukubg').val();
        if(noseribg == ''){
          toastr.info('Mohon di isi no seri cek :)');

         // alert('Mohon di isi no seri cek :)');
        }
        else {
          if(urutbg == ''){
             toastr.info('Mohon di isi no urut cek :)');
           // alert('Mohon di isi no urut cek :)');
          }
          else {
            if(urutbg == ''){
                   toastr.info('Mohon di isi no urut BG :)');

                //  alert('Mohon di isi no urut BG :)');
                }
                else {
                 // alert('masuk');
                  idbank = $('.idbank').val();
                  noseribg = $('.inputbg').val();
                  urutbg = $('.urutbg').val();           
                  tglbukubg = $('#tglbukubg').val();
                  hasilurutbg = $('.hasilurutbg').val();

                  $('.inputcek').attr('disabled' , true);
                  $('.urutcek').attr('disabled' , true);

                  temp = 1;
                
                  for(ds = 0; ds <= arrnourutbg.length; ds++){ // CEK DOUBLE
                    if(arrnourutbg[ds] == urutbg){
                     temp = parseInt(temp) + 1;                      
                    }
                    else {
                      for(i=1;i<=arrnourutbg.length;i++){
                        if(arrnourutbg[ds + i] == urutbg){
                           temp = parseInt(temp) + 1;
                        }
                      }
                    }
                    
                  
                    urutbg++;
                  }
                 
                  if(temp > 1 ){ // JIKA DOUBLE
                   toastr.info('No seri BG sudah digunakan :)');

                    //alert('No seri BG sudah digunakan :)' );
                  }
                  else {
                   idbank = $('.idbank').val();
                  noseribg = $('.inputbg').val();
                  urutbg = $('.urutbg').val();           
                  tglbukubg = $('#tglbukubg').val();
                  hasilurutbg = $('.hasilurutbg').val();
                  //buat noseri
                  var tableBank = $('#tbl-cek').DataTable();
                
                  var n = 1;
                  
                  $tempbg = 0;
                  strbg = urutbg.search('0');
                  if(urutbg.indexOf(strbg) == 0){
                    lengthbg = urutbg.length;
                    for(i = 0; i < lengthbg; i++){
                      if(urutbg.indexOf('0' , i) == i){
                        $tempbg = parseInt($tempbg) + 1;
                      }
                      else {
                        i = lengthbg;
                      }
                    }
                  }


                  for(var i = urutbg; i <= hasilurutbg; i++){ //ADD TABLE

                    if($tempbg != 0){
                      urutbg = pad(urutbg, lengthbg);
                    }
                    else {
                      urutbg = urutbg;
                    }

                    var html2 = "<tr>" + 
                                "<td><div class='checkbox'> <input type='checkbox' class='rusak'  aria-label='Single checkbox One'>" +
                                "<label></label>" +
                                "</div></td>" +
                                "<td>"+idbank+"</td>" +
                                "<td>"+noseribg+urutbg +" <input type='hidden' value="+noseribg+urutbg +" name='noseribg[]' id='noseri'></td>" +
                                "<td>"+tglbukubg+"</td>"+
                                "<td> </td>"+
                                "<td> </td>"+
                                "<td> </td>"+
                                "<td> </td>";
                                      
                    html2 +=  "</tr>";

                      arrnourutbg.push(urutbg);
                      tableBank.rows.add($(html2)).draw();
                   
                   
                    urutbg++;
                  
                    }
                  }    
            }


          }
        }
      }
     
     else {
          if($("#sericekbg").prop('checked') == false){
              if($("#sericek").prop('checked') == false){
                   toastr.info('Mohon check No seri Cek / BG :)');

                  //alert("Mohon check No seri Cek / BG :)")
              }          
          }
     } 
    }    
  })

  function pad (str, max) {
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}

  hasil = 0;
  $('.urutcek').keyup(function(){
    val = $(this).val();
    if(val == ''){
    //  alert('Mohon isi val nya :)'); 
     toastr.info('Mohon isi val nya :)');

       $('.hasilurutcek').val('');      
    }
    else {
      str = val.search('0');
      lengthval = val.length;
      if(val.indexOf(str) == 0){
        $temp0 = 0;
    
        for(i = 0; i < lengthval; i++){          
          if(val.indexOf('0' , i) == i){
            $temp0 = parseInt($temp0) + 1;
          }
          else {
           i = lengthval;
          }
        }  
          hasil = parseInt(val) + 24;
          hasil = pad(hasil, lengthval);
         
         $('.hasilurutcek').val(hasil); 
      }
      else {
        hasil = parseInt(val) + 24;
        $('.hasilurutcek').val(hasil);      
      }
    }
  })

  $('.urutbg').keyup(function(){
    val = $(this).val();
    if(val == ''){
      alert('Mohon isi val nya :)'); 
       $('.hasilurutbg').val('');      
    }
    else {
      str = val.search('0');
      lengthval = val.length;
      if(val.indexOf(str) == 0){
        $temp0 = 0;   
        for(i = 0; i < lengthval; i++){          
          if(val.indexOf('0' , i) == i){
            $temp0 = parseInt($temp0) + 1;
          }
          else {
           i = lengthval;
          }
        }  
          hasil = parseInt(val) + 24;
          hasil = pad(hasil, lengthval);
         
         $('.hasilurutbg').val(hasil); 
      }
      else {
        hasil = parseInt(val) + 24;
        $('.hasilurutbg').val(hasil);      
      }
    }
  })

 $('.date').datepicker({
        autoclose: true,
        format: 'dd-MM-yyyy',
        endDate: 'today'

    }).datepicker("setDate", "0");;
    
    $('.bank').change(function(){
        val = $(this).val();
        variabel = val.split(",");
        idakun = variabel[0];
        $('.idbank').val(idakun);
        idakun2 =    $('.idbank').val(idakun);
   
    })
   
</script>
@endsection
