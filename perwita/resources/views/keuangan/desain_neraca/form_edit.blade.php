@extends('main')

@section('title', 'dashboard')


@section("extra_styles")
  
  <link href="{{ asset('assets/vendors/jsTree/style.min.css') }}" rel="stylesheet">

  <style type="text/css">
  
    #form-table{
      font-size: 8pt;
    }

    #form-table td{
      padding: 5px 0px;
    }

    #form-table .form-control{
      height: 30px;
      width: 90%;
      font-size: 8pt;
    }

    .table-group{
      font-size: 8pt;
    }

    .table-group tbody tr{
      cursor: pointer;
    }

    .table-group tbody tr:hover{
      background: #1ab394;
      color: white;
    }

    .table-group tbody tr.aktif{
      background: #1ab394;
      color: white;
    }

    .table-group tbody tr.chosen{
      background: #eee;
      color: #909090;
      cursor: no-drop
    }

    .switch.aktif{
      background: #1ab394;
      color: white;
    }

    .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }

    .modal-open{
      overflow: inherit;
    }

  </style>

@endsection


@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Desain Neraca</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a>Home</a>
                        </li>
                        <li>
                            <a>Operasional</a>
                        </li>
                        <li>
                            <a>Keuangan</a>
                        </li>
                        <li>
                            <a>Desain Neraca</a>
                        </li>
                        <li class="active">
                            <strong> Edit Desain Neraca  </strong>
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
                    <h5> Edit Desain Neraca
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 1px; padding: 10px; height: 500px; box-shadow: 0px 0px 10px #eee;">
                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="aktiva">
                              <span style="position: absolute; top: 50%; left: 28%; opacity: 0.1; color: #000; font-size: 15pt; font-style: italic; ">Canvas Neraca Aktiva</span>
                              <div id="aktiva_tree" style="font-size: 8pt;">
                                  
                              </div>
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="pasiva">
                              <span style="position: absolute; top: 50%; left: 28%; opacity: 0.1; color: #000; font-size: 15pt; font-style: italic; ">Canvas Neraca Pasiva</span>
                              <div id="pasiva_tree" style="font-size: 8pt;">
                                
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">

                        <div class="col-md-6" style="padding:0px;">
                          <div class="btn-group">
                              <button href="#aktiva" aria-controls="aktiva" role="tab" data-toggle="tab" class="btn btn-white aktif btn-sm switch" data-for="aktiva" style="font-size: 8pt;" type="button">Activa</button>

                              <button href="#pasiva" aria-controls="pasiva" role="tab" data-toggle="tab" class="btn btn-white btn-sm switch" data-for="pasiva" style="font-size: 8pt;" type="button">Pasiva</button>
                          </div>
                        </div>

                        <div class="col-md-6" style="padding: 0px;">
                          <input type="text" class="form-control text-center upper" id="nama_desain" name="nama_desain" style="height: 30px; font-size: 8pt" placeholder="Masukkan Nama Desain" value="{{ $data_desain->nama_desain }}">
                        </div>
                        
                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 10px 0px"></div>

                        <div class="col-md-12" style="padding: 0px;">

                          <table border="0" id="form-table" class="col-md-12">

                            <tr>
                              <td width="15%" class="text-center">Level</td>
                              <td colspan="2" width="35%">
                                <input type="number" id="level" class="form-control form_validate" max="2" min="0" value="1">
                              </td>

                              <td width="15%">
                                <i class="fa fa-times" style="color: #ed5564; cursor: pointer; display: none;" id="cancel"></i>
                              </td>
                              <td colspan="2">
                                
                              </td>
                            </tr>

                            <tr>
                              <td width="15%" class="text-center">Parrent ID</td>
                              <td colspan="2" width="35%">
                                <select id="parrent" class="select_validate form-control" disabled>
                                  <option value="---"> - Pilih Parrent</option>
                                </select>
                              </td>

                              <td colspan="3">
                                <input type="text" id="parrent_name" class="form_validate form-control text-center" readonly value="---">
                              </td>
                            </tr>

                            <tr>
                              <td width="15%" class="text-center">Nomor ID</td>
                              <td colspan="2" width="35%">
                                <div class="input-group">
                                  <span class="input-group-addon" style="font-size: 8pt;" id="state_id">A</span>
                                  <input type="text" class="form_validate form-control" name="nomor_id" value="1" id="nomor_id" data-toggle="tooltip" data-placement="top" title="Hanya Memperbolehkan Input Angka" readonly>
                                </div>
                              </td>

                              <td colspan="3">
                                
                              </td>
                            </tr>

                            <tr>
                              <td width="15%" class="text-center">Jenis</td>
                              <td colspan="2" width="35%">
                                <select id="jenis" class="select_validate form-control">
                                  <option value="1">Header/Title</option>
                                  <option value="2">Detail</option>
                                  <option value="3">Total</option>
                                  <option value="4">Line Break</option>
                                </select>
                              </td>

                              <td colspan="3">
                                <select disabled id="detail_total" class="form-control" style="display:none;">
                                  <option value="---"> -- Dari Penjumlahan</option>
                                </select>
                              </td>
                            </tr>

                            <tr>
                              <td width="15%" class="text-center">Keterangan</td>
                              <td colspan="5" width="35%">
                                <input type="text" style="width: 94%" class="form_validate form-control upper" id="keterangan" placeholder="Masukkan Keterangan Tentang Ini">
                              </td>
                            </tr>

                          </table>
                        </div>

                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 10px 0px"></div>

                        <div class="col-md-12 text-right" style="padding: 0px;">
                            <button class="btn btn-success btn-sm" id="masukkan" style="font-size:8pt;" type="button">Masukkan Ke Desain</button>
                            <button disabled class="btn btn-warning btn-sm" id="update_detail" style="font-size:8pt;" type="button">Update</button>
                            <button disabled class="btn btn-primary btn-sm" id="tambah_detail" style="font-size:8pt;" type="button">Tambahkan Group Neraca</button>
                            <button disabled class="btn btn-danger btn-sm" id="hapus_detail" style="font-size:8pt;" type="button">Hapus</button>
                        </div>

                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 5px 0px"></div>

                        <div class="col-md-12 m-t" style="padding: 0px; height: 146px; overflow-x: scroll">
                          <table border="0" class="table table-bordered" style="font-size: 8pt;">
                            <tr>
                              <th width="25%" class="text-center">Id Detail Referensi</th>
                              <th width="40%" class="text-center">Nama Detail Referensi</th>
                              <th width="25%" class="text-center">Referensi Dari</th>
                              <th width="10%" class="text-center">*</th>
                            </tr>
                            
                            <tbody id="group_show">

                            </tbody>
                          </table>
                            
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12 m-t">
                      <button class="btn btn-primary btn-sm pull-right" style="font-size: 8pt; margin-left: 5px;" id="simpan_desain">Simpan Perubahan Desain</button>
                      <a href="{{ route("desain_neraca.index") }}" class="btn btn-default btn-sm pull-right" style="font-size: 8pt;" id="simpan_desain">Kembali</a>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal -->
<div id="modal_detail" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Form Tambah Group Akun</h4>
        <input type="hidden" class="parrent"/>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-md-5" style="padding: 0px;">
            <div id="d" style="height: 430px; overflow-x: scroll">
              <table border="1" width="100%" class="table table-bordered table-group">
                <tbody id="detail_body">
                  
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-md-7">
            <div id="d" style="height: 430px; overflow-x: scroll">
              <table border="1" width="100%" class="table table-bordered" style="font-size: 8pt; font-weight: 600;">
                <tbody id="detail_group">
                  <tr>
                    <td class="text-center">Detail Akun Akan Tampil Disini</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          
          <div class="col-md-12" style="border-top: 1px solid #eee; margin: 5px 0px"></div>

          <div class="col-md-12 m-t">
            <button class="btn btn-primary btn-sm" style="font-size: 8pt;" id="confirm_detail">Masukkan Grup Ke Detail</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<!-- modal -->

<!-- modal -->
<div id="modal_list_akun" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Anggota Akun Group <span id="nama_group"></span></h4>
        <input type="hidden" class="parrent"/>
      </div>
      <div class="modal-body">
        <div style="height: 450px; overflow-x: scroll">
          <table class="table table-bordered" style="font-size: 8pt;">
            <thead>
              <tr>
                <th style="position: sticky; top: 0px;">ID Akun</th>
                <th style="position: sticky; top: 0px;" width="40%">Nama Akun</th>
                <th style="position: sticky; top: 0px;">Debet/Kredit</th>
              </tr>
            </thead>

            <tbody id="anggota_wrap">
              
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
  <!-- modal -->

@endsection


@section('extra_scripts')

  <script src="{{ asset('assets/vendors/jsTree/jsTree.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/jsTree/jstreetable.js') }}"></script>

  <script type="text/javascript">
     
    $(document).ready(function(){

      data = []; data_neraca = {!! $data_neraca !!}; data_detail = {!! $data_detail !!};
      data_akun = {!! $data_akun !!}; data_group = {!! $data_group !!};

      // console.log(data_neraca);
      // console.log(data_detail);

      // console.log(data_group);
      // console.log(data_akun);

      state = "aktiva"; chosen_group = "";

      grab_detail();

      $('#pasiva_tree').jstree({
        plugins: ["types"],
        "types" : {
          "default" : {
            "icon" : "fa fa-folder"
          },
          "demo" : {
            "icon" : "fa fa-book"
          },
          "total" : {
            "icon" : "fa fa-calculator"
          },
          "space" : {
            "icon" : "fa fa-arrow-right"
          }
        },
        core: {
          data: data,
          "check_callback": true
        },
      });

      $('#pasiva_tree').on('ready.jstree', function (e, data) {

          state = "pasiva";

          $.each($.grep(data_neraca, function(a){ return a.type === "pasiva" }), function(i, n) {
            
            level = n.level;
            parrent = (n.id_parrent == "") ? null : n.id_parrent;
            id = n.nomor_id;
            jenis = n.jenis;
            keterangan = n.keterangan.toUpperCase();

            open = (jenis != "1") ? false : true;
            type = "default";

            if(jenis == "3")
              type = "total";
            else if(jenis == "4")
              type = "space";

            createNode(parrent, id, id, "last", keterangan, open, type);

            if(jenis == 2 || jenis == 3){

              $.each($.grep(data_detail, function(e){ return e.id_parrent === id }), function(i, n){

                text = ""; ids = n.nomor_id; dari = n.dari;

                if(n.dari == "Group Neraca"){
                  dbbm = data_group.findIndex(a => a.id === n.id_group);
                  text = data_group[dbbm].nama_group;
                }else{
                  dbbm = data_neraca.findIndex(a => a.nomor_id === n.id_group);
                  text = data_neraca[dbbm].keterangan;
                }
                
                createNode(id, ids, text, "last", text, open, "demo");

              })
            }

            // console.log(data_neraca);
            // console.log(data_detail);
            form_reset();
            grab_parrent();
          })

      });

      $('#aktiva_tree').jstree({
        plugins: ["types"],
        "types" : {
          "default" : {
            "icon" : "fa fa-folder"
          },
          "demo" : {
            "icon" : "fa fa-book"
          },
          "total" : {
            "icon" : "fa fa-calculator"
          },
          "space" : {
            "icon" : "fa fa-arrow-right"
          }
        },
        core: {
          data: data,
          "check_callback": true
        },
      });

      $('#aktiva_tree').on('ready.jstree', function (e, data) {

          state = "aktiva";

          $.each($.grep(data_neraca, function(a){ return a.type === "aktiva" }), function(i, n) {

            level = n.level;
            parrent = (n.id_parrent == "") ? null : n.id_parrent;
            id = n.nomor_id;
            jenis = n.jenis;
            keterangan = n.keterangan.toUpperCase();

            open = (jenis != "1") ? false : true;
            type = "default";

            if(jenis == "3")
              type = "total";
            else if(jenis == "4")
              type = "space";

            createNode(parrent, id, id, "last", keterangan, open, type);

            if(jenis == 2 || jenis == 3){

              $.each($.grep(data_detail, function(e){ return e.id_parrent === id }), function(i, n){

                text = ""; ids = n.nomor_id; dari = n.dari;

                if(n.dari == "Group Neraca"){
                  dbbm = data_group.findIndex(a => a.id === n.id_group);
                  text = data_group[dbbm].nama_group;
                }else{
                  dbbm = data_neraca.findIndex(a => a.nomor_id === n.id_group);
                  text = data_neraca[dbbm].keterangan;
                }
                
                createNode(id, ids, text, "last", text, open, "demo");

              })
            }

            // console.log(data_neraca);
            // console.log(data_detail);
            form_reset();
            grab_parrent();
          })

      });

      $('#aktiva_tree').on("select_node.jstree", function (e, data) { 
        // console.log(data);

        if(data.node.type != "demo"){
          $("#masukkan").attr("disabled", "disabled");
          $("#hapus_detail").removeAttr("disabled");
          $('#update_detail').removeAttr("disabled");
          $("#detail_total").css("display", "none"); $("#detail_total").attr("disabled", "disabled");

          idx = data_neraca.findIndex(n => n.nomor_id == data.node.id);
          parrent = (data.node.parent == "#") ? data_neraca[idx].nomor_id.substring(0, data_neraca[idx].level) : data_neraca[idx].id_parrent+".";

          // alert(parrent);

          $("#cancel").css("display", "inline-block");
          $("#level").val(data_neraca[idx].level); $("#level").attr("disabled", "disabled");
          $("#state_id").text(parrent);
          $("#nomor_id").val(data_neraca[idx].nomor_id.substring(parrent.length));
          // $("#parrent").val((data_neraca[idx].id_parrent == null) ? "---" : data_neraca[idx].id_parrent);

          if(data_neraca[idx].id_parrent == null || data_neraca[idx].id_parrent == ""){
            $("#parrent_name").val("---");
          }else{
            $("#parrent_name").val(data_neraca[data_neraca.findIndex(n => n.nomor_id == data_neraca[idx].id_parrent)].keterangan);
          }

          $("#parrent").attr("disabled", "disabled");
          $('#jenis').val(data_neraca[idx].jenis); $("#jenis").attr("disabled", "disabled");
          $("#keterangan").val(data_neraca[idx].keterangan);
          $("#group_show").html("");

          if(data_neraca[idx].jenis == 4){
            $("#keterangan").attr("readonly", "readonly");
          }else if(data_neraca[idx].jenis == 2 || data_neraca[idx].jenis == 3){

            if(data_neraca[idx].jenis == 2)
              $("#tambah_detail").removeAttr("disabled");
            else
              $("#tambah_detail").attr("disabled", "disabled");

            $.each($.grep(data_detail, function(n){ return n.id_parrent == data_neraca[idx].nomor_id }), function(i, n){
              if(data_neraca[idx].jenis == 2){
                html = '<tr id="'+n.id_group+'" data-nama = "'+n.nama+'" data-dari = "'+n.dari+'" class="search">'+
                          '<td class="text-center">'+n.id_group+'</td>'+
                          '<td class="text-center">'+n.nama+'</td>'+
                          '<td class="text-center">'+n.dari+'</td>'+
                          '<td class="text-center delete_detail" style="color:#ed5564; cursor:pointer;"><i class="fa fa-times"></i></td>'+
                        '</tr>';
              }
              else{
                html = '<tr id="'+n.id_group+'" data-nama = "'+n.nama+'" data-dari = "'+n.dari+'" class="search">'+
                          '<td class="text-center">'+n.id_group+'</td>'+
                          '<td class="text-center">'+n.nama+'</td>'+
                          '<td class="text-center">'+n.dari+'</td>'+
                          '<td class="text-center" style="color:#ed5564;">-</td>'+
                        '</tr>';
              }

                $("#group_show").append(html);
            })

          }

        }else{
          idx = data_detail.findIndex(n => n.nomor_id == data.node.id);
          $("#modal_list_akun").modal("show");
          $("#nama_group").text(data.node.data.id+" ("+data_detail[idx].id_group+")");

          html = "";

          $.each($.grep(data_akun, function(n) { return n.group_neraca === data_detail[idx].id_group }), function(i, n){
            dk = (n.akun_dka == "D") ? "DEBET" : "KREDIT";
            html = html + '<tr>'+
                            '<td>'+n.id_akun+'</td>'+
                            '<td class="text-center">'+n.nama_akun+'</td>'+
                            '<td class="text-center">'+dk+'</td>'+
                          '</tr>';
          })

          if($.grep(data_akun, function(n) { return n.group_neraca === data_detail[idx].id_group }).length == 0){
            html = html + '<tr><td colspan="3" class="text-center" style="color:#ccc;"> Tidak Ada Anggota Akun Di Group Ini.</td></tr>'
          }

          $("#anggota_wrap").html(html);

          form_reset();
        }
      });

      $('#pasiva_tree').on("select_node.jstree", function (e, data) { 
        // console.log(data);

        if(data.node.type != "demo"){
          $("#masukkan").attr("disabled", "disabled");
          $("#hapus_detail").removeAttr("disabled");
          $('#update_detail').removeAttr("disabled");
          $("#detail_total").css("display", "none"); $("#detail_total").attr("disabled", "disabled");

          idx = data_neraca.findIndex(n => n.nomor_id == data.node.id);
          parrent = (data.node.parent == "#") ? data_neraca[idx].nomor_id.substring(0, data_neraca[idx].level) : data_neraca[idx].id_parrent+".";

          // alert(parrent);

          $("#cancel").css("display", "inline-block");
          $("#level").val(data_neraca[idx].level); $("#level").attr("disabled", "disabled");
          $("#state_id").text(parrent);
          $("#nomor_id").val(data_neraca[idx].nomor_id.substring(parrent.length));
          // $("#parrent").val((data_neraca[idx].id_parrent == null) ? "---" : data_neraca[idx].id_parrent);

          if(data_neraca[idx].id_parrent == null || data_neraca[idx].id_parrent == ""){
            $("#parrent_name").val("---");
          }else{
            $("#parrent_name").val(data_neraca[data_neraca.findIndex(n => n.nomor_id == data_neraca[idx].id_parrent)].keterangan);
          }

          $("#parrent").attr("disabled", "disabled");
          $('#jenis').val(data_neraca[idx].jenis); $("#jenis").attr("disabled", "disabled");
          $("#keterangan").val(data_neraca[idx].keterangan);
          $("#group_show").html("");

          if(data_neraca[idx].jenis == 4){
            $("#keterangan").attr("readonly", "readonly");
          }else if(data_neraca[idx].jenis == 2 || data_neraca[idx].jenis == 3){

            $("#group_show").html("");

            if(data_neraca[idx].jenis == 2)
              $("#tambah_detail").removeAttr("disabled");
            else
              $("#tambah_detail").attr("disabled", "disabled");
            
            $.each($.grep(data_detail, function(n){ return n.id_parrent == data_neraca[idx].nomor_id }), function(i, n){
                if(data_neraca[idx].jenis == 2){
                  html = '<tr id="'+n.id_group+'" data-nama = "'+n.nama+'" data-dari = "'+n.dari+'" class="search">'+
                            '<td class="text-center">'+n.id_group+'</td>'+
                            '<td class="text-center">'+n.nama+'</td>'+
                            '<td class="text-center">'+n.dari+'</td>'+
                            '<td class="text-center delete_detail" style="color:#ed5564; cursor:pointer;"><i class="fa fa-times"></i></td>'+
                          '</tr>';
                }
                else{
                  html = '<tr id="'+n.id_group+'" data-nama = "'+n.nama+'" data-dari = "'+n.dari+'" class="search">'+
                            '<td class="text-center">'+n.id_group+'</td>'+
                            '<td class="text-center">'+n.nama+'</td>'+
                            '<td class="text-center">'+n.dari+'</td>'+
                            '<td class="text-center" style="color:#ed5564;">-</td>'+
                          '</tr>';
                }

                $("#group_show").append(html);
            })

          }

        }else{
          idx = data_detail.findIndex(n => n.nomor_id == data.node.id);
          $("#modal_list_akun").modal("show");
          $("#nama_group").text(data.node.data.id+" ("+data_detail[idx].id_group+")");

          html = "";

          $.each($.grep(data_akun, function(n) { return n.group_neraca === data_detail[idx].id_group }), function(i, n){
            dk = (n.akun_dka == "D") ? "DEBET" : "KREDIT";
            html = html + '<tr>'+
                            '<td>'+n.id_akun+'</td>'+
                            '<td class="text-center">'+n.nama_akun+'</td>'+
                            '<td class="text-center">'+dk+'</td>'+
                          '</tr>';
          })

          if($.grep(data_akun, function(n) { return n.group_neraca === data_detail[idx].id_group }).length == 0){
            html = html + '<tr><td colspan="3" class="text-center" style="color:#ccc;"> Tidak Ada Anggota Akun Di Group Ini.</td></tr>'
          }

          $("#anggota_wrap").html(html);

          form_reset();
        }
      });

      $(".upper").on("keyup", function(){
        $(this).val($(this).val().toUpperCase())
      })

      $("#level").on("focusin", function(){

            before = $(this).val();

      }).change(function(evt){
            evt.stopImmediatePropagation();
            evt.preventDefault();

            input = $(this);

            if(input.val() > 2){
              alert("Level Tidak Boleh Lebih Dari 2");
              input.val(before);
            }else if(input.val() > 1 && data_neraca.length == 0){
              alert("Anda Harus Membuat Detail Level 1 Terlebih Dahulu Sebelum Membuat Level 2.");
              input.val(before);
            }else if(input.val() > 1){
              $("#parrent").removeAttr("disabled");
            }else if(input.val() == 1){
              $("#parrent").val("---"); $("#parrent").attr("disabled", "disabled");
              $("#parrent_name").val("---");
              $("#state_id").text((state == "aktiva") ? "A" : "P");

              grab_id();
            }
      })

      $("#parrent").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        val = $(this).val();
        idx = data_neraca.findIndex(n => n.nomor_id === val);

        if(val === "---"){
          $("#parrent_name").val("---");
        }
        else{
          $("#parrent_name").val(data_neraca[idx].keterangan);
          $('#state_id').text(data_neraca[idx].nomor_id+".");

          grab_id();
        }
      })

      $(".switch").click(function(evt){
        evt.preventDefault();

        btn = $(this);
        $(".switch").removeClass("aktif");
        btn.addClass("aktif");

        state = btn.data("for");

        form_reset(); grab_parrent();
      })

      $("#jenis").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();
        val = $(this).val();

        if(val == "2"){
          $("#tambah_detail").removeAttr("disabled");
          $("#detail_total").css("display", "none"); $("#detail_total").attr("disabled", "disabled");
          $("#group_show").html("");
          $("#keterangan").removeAttr("readonly"); $("#keterangan").val(""); 
        }else if(val == "1" || val == "4"){
          $("#tambah_detail").attr("disabled", "disabled");
          $("#group_show").html("");
          $("#detail_total").css("display", "none"); $("#detail_total").attr("disabled", "disabled");
          $("#keterangan").removeAttr("readonly"); $("#keterangan").val("");

          if(val == 4){
            $("#keterangan").val("."); $("#keterangan").attr("readonly", "readonly");
          }
        }else if(val == "3"){
          $("#detail_total").css("display", "inline-block"); $("#detail_total").removeAttr("disabled");
          $("#tambah_detail").attr("disabled", "disabled");
          $("#group_show").html("");
          $("#keterangan").removeAttr("readonly"); $("#keterangan").val("");

          grab_detail_total();
        }

      })

      $("#detail_total").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();
        select = $(this);

        if(select.val() != "---"){
          group = data_neraca.findIndex(n => n.nomor_id == select.val());
          html = '<tr id="'+data_neraca[group].nomor_id+'" data-nama = "'+data_neraca[group].keterangan+'" data-dari = "Detail Neraca" class="search">'+
                  '<td class="text-center">'+data_neraca[group].nomor_id+'</td>'+
                  '<td class="text-center">'+data_neraca[group].keterangan+'</td>'+
                  '<td class="text-center">Detail Neraca</td>'+
                  '<td class="text-center delete_detail" style="color:#ed5564; cursor:pointer;"><i class="fa fa-times"></i></td>'+
                '<tr>';

          $("#group_show").append(html);
          $("#detail_total option:selected").attr("disabled", "disabled");
        }

      })

      $("#detail_body").on("click", ".row", function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        row = $(this);

        $("#detail_body tr").removeClass("aktif");
        row.addClass("aktif");

        grab_detail_grup(row.data("id"));

        if(!row.hasClass("chosen"))
          chosen_group = row.data("id");

        // console.log(row.data("id"));
      })

      $('#confirm_detail').click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        if(chosen_group == ""){
          return false;
        }

        group = data_group.findIndex(n => n.id == chosen_group);

        html = '<tr id="'+data_group[group].id+'" data-nama = "'+data_group[group].nama_group+'" data-dari = "Group Neraca" class="search">'+
                  '<td class="text-center">'+data_group[group].id+'</td>'+
                  '<td class="text-center">'+data_group[group].nama_group+'</td>'+
                  '<td class="text-center">Group Neraca</td>'+
                  '<td class="text-center delete_detail" style="color:#ed5564; cursor:pointer;"><i class="fa fa-times"></i></td>'+
                '<tr>';

        $("#group_show").append(html);
        $("#detail_body").find("#"+data_group[group].id).addClass("chosen");
        chosen_group = "";
      })

      $("#cancel").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $(this).css("display", "none");
        $("#hapus_detail").attr("disabled", "disabled");
        form_reset();
      })

      $("#group_show").on("click", ".delete_detail", function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        row = $(this);
        row.closest("tr").remove();
      })

      $("#hapus_detail").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        id = $("#state_id").text()+""+$("#nomor_id").val();

        $.each($.grep(data_neraca, function(a){ return a.nomor_id === id || a.id_parrent === id }), function(i, n){
          idx = data_neraca.findIndex(a => a.nomor_id === n.nomor_id);

          if(n.jenis == 2 || n.jenis == 3){
            delete_detail(n.nomor_id);
          }

          data_neraca.splice(idx, 1);
        })

        $('#'+state+'_tree').jstree().delete_node(id);
        form_reset();
        grab_parrent();

        // console.log(data_neraca);
        // console.log(data_detail);
      })

      $("#masukkan").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        if(validate_form()){
          level = $("#level").val();
          parrent = ($("#level").val() == 1) ? null : $("#parrent").val();
          id = $("#state_id").text()+""+$("#nomor_id").val();
          jenis = $("#jenis").val();
          keterangan = $("#keterangan").val().toUpperCase();

          open = (jenis != "1") ? false : true;
          type = "default";

          if(jenis == "3")
            type = "total";
          else if(jenis == "4")
            type = "space";

          if(jenis == 2){
            if($("#group_show").find(".search").length == 0){
              alert("Harap Pilih Detail Group Neraca Terlebih Dahulu.");
              return false;
            }
          }else if(jenis == 3){
            if($("#group_show").find(".search").length == 0){
              alert("Harap Pilih Detail Penjumlahan Terlebih Dahulu.");
              return false;
            }
          }

          createNode(parrent, id, id, "last", keterangan, open, type);

          data_neraca[data_neraca.length] = {
            "nomor_id": id,
            "keterangan": keterangan.toUpperCase(),
            "id_parrent": parrent,
            "level" : level,
            "jenis" : jenis,
            "type" : state
          };

          if(jenis == 2 || jenis == 3){
            $("#group_show .search").each(function(){
              text = $(this).data("nama"); ids = $(this).attr("id"); dari = $(this).data("dari");
              createNode(id, id+"."+ids, text, "last", text, open, "demo");

              data_detail[data_detail.length] = {
                "id_group"   : ids,
                "nomor_id"   : id+"."+ids,
                "id_parrent" : id,
                "nama"       : text,
                "dari"       : dari
              }
            })
          }

          // console.log(data_neraca);
          // console.log(data_detail);
          form_reset();
          grab_parrent();
        }
      })

      $("#tambah_detail").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        $("#modal_detail").modal("show");
        grab_detail();
      })

      $('#update_detail').click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        jenis = $("#jenis").val();

        if(jenis == 2){
          if($("#group_show").find(".search").length == 0){
            alert("Harap Pilih Detail Group Neraca Terlebih Dahulu.");
            return false;
          }
        }else if(jenis == 3){
          if($("#group_show").find(".search").length == 0){
            alert("Harap Pilih Detail Penjumlahan Terlebih Dahulu.");
            return false;
          }
        }

        id = $("#state_id").text()+""+$("#nomor_id").val();
        idx = data_neraca.findIndex(n => n.nomor_id === id);
        node_ket = $("#keterangan").val().toUpperCase()+' ('+$("#state_id").text()+''+$("#nomor_id").val()+')';
        data_neraca[idx].keterangan = $("#keterangan").val();

        $('#'+state+'_tree').jstree('rename_node', id , node_ket);

        if(data_neraca[idx].jenis == 2){
          balancing_detail(data_neraca[idx].nomor_id);
        }

        form_reset();

        // console.log(data_neraca);
        // console.log(data_detail);
      })

      $("#simpan_desain").click(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();

        btn = $(this);
        btn.attr("disabled", "disabled");
        btn.text("Menyimpan...");

        if($("#nama_desain").val() == ""){
          $("#nama_desain").focus();
          toastr.warning('Harap Mengisi Terlebih Dahulu Nama Desain Neraca Ini.');
          btn.text("Simpan Perubahan Desain");
          btn.removeAttr("disabled");
          return false;
        }

        if(data_neraca.length > 0 ){
          $.ajax(baseUrl+"/master_keuangan/desain_neraca/update/{{ $id }}",{
            type: "post",
            timeout: 15000,
            data: {data_neraca: data_neraca, data_detail: data_detail, nama_desain: $("#nama_desain").val(), _token: "{{ csrf_token() }}" },
            dataType: 'json',
            success: function(response){
              console.log(response);
              if(response.status == "sukses"){
                toastr.success('Data Desain Neraca Berhasil Diubah');
                btn.removeAttr("disabled");
                btn.text("Simpan Perubahan Desain");

                form_reset();
              }else if(response.status == "exist"){
                toastr.error('Kode Master Group Akun Sudah Ada Dengan Nama "'+response.content+'". Silahkan Membuat Kode Akun Lagi.');
                btn.removeAttr("disabled");
                btn.text("Simpan Perubahan Desain");
              }

              btn.removeAttr("disabled");
              btn.text("Simpan Desain");
            },
            error: function(request, status, err) {
                if(status == "timeout") {
                  toastr.error('Request Timeout. Data Gagal Disimpan');
                }else{
                  toastr.error('Internal Server Error. Data Gagal Disimpan');
                }

                btn.text("Simpan Perubahan Desain");
                btn.removeAttr("disabled");
            }
          })
        }else{
          toastr.error('Desain Neraca Yang Anda Buat Masih Kosong.');
          btn.removeAttr("disabled");
          btn.text("Simpan Perubahan Desain");
        }
      })

      function createNode(parent_node, new_node_id, new_node_text, position, keterangan, open = false, type = "default") {
        // alert(state);
        $('#'+state+'_tree').jstree('create_node', parent_node, { "text":keterangan+" ("+new_node_id+")", "type": type, "id":new_node_id , "data":{"id": new_node_text, "id_parrent":parent_node}, state: {"opened": open}}, position, false, false); 
      }

      function validate_form(){
        a = true;
        $(".form_validate").each(function(i, e){
          if($(this).val() == ""){
            a = false;
            $(this).focus();
            toastr.warning('Harap Lengkapi Data Diatas');
            return false;
          }
        })

        $(".select_validate").each(function(i, e){
          if($(this).val() == "---" && !$(this).is(":disabled")){
            a = false;
            $(this).focus();
            toastr.warning('Harap Lengkapi Data Diatas');
            return false;
          }
        })

        return a;
      }

      function form_reset(){
        $("#level").val(1); $('#level').removeAttr("disabled");
        $("#parrent").val("---"); $("#parrent").attr("disabled", "disabled");
        $("#parrent_name").val("---");
        $("#jenis").val(1); $('#jenis').removeAttr("disabled");
        $("#keterangan").val(""); $("#keterangan").removeAttr("readonly");
        $("#state_id").text((state == "aktiva") ? "A" : "P");
        $("#tambah_detail").attr("disabled", "disabled"); $("#hapus_detail").attr("disabled", "disabled"); $('#update_detail').attr("disabled", "disabled"); $("#masukkan").removeAttr("disabled");
        $("#group_show").html("");
        $("#cancel").css("display", "none");
        $("#detail_total").css("display", "none"); $("#detail_total").attr("disabled", "disabled"); 

        grab_id();
      }

      function grab_id(){
        cek = $("#state_id").text(); idle = $("#state_id").text().length; level = $("#level").val();
        data = $.grep(data_neraca, function(n){ return n.nomor_id.substring(0, idle) == cek && n.level == level });
        count = data.length;

        idxx = (count == 0) ? 0 : data[count-1].nomor_id.substring(idle);

        $("#nomor_id").val((parseInt(idxx)+1));
      }

      function grab_detail(){
        html = "";
        $.each(data_group, function(i, n){
          if($("#group_show").find("#"+n.id).length == 0 && data_detail.findIndex(a => a.id_group === n.id) < 0){
            html = html+'<tr data-id="'+n.id+'" class="row" id="'+n.id+'">'+
                  '<td>'+n.nama_group+'</td>'+
                '</tr>';
          }else{
            html = html+'<tr data-id="'+n.id+'" class="row chosen" id="'+n.id+'" title="Sudah Dipilih">'+
                  '<td>'+n.nama_group+'</td>'+
                '</tr>';
          }
          
        })

        $("#detail_body").html(html);
      }

      function grab_detail_grup(id){
        html = "";
        $.each($.grep(data_akun, function(n) { return n.group_neraca == id }), function(i, n){
          html = html+'<tr>'+
                  '<td>'+n.nama_akun+'</td>'+
                '</tr>';
        })

        if($.grep(data_akun, function(n) { return n.group_neraca == id }).length == 0){
          html = html+'<tr>'+
                  '<td class="text-center">Tidak Ada Akun Di Group Ini</td>'+
                '</tr>';
        }

        $("#detail_group").html(html);
      }

      function grab_detail_total(){
        pieces = (state == "aktiva") ? "A" : "P";
        html = '<option value="---" id="first">-- Dari Penjumlahan</option>';

        $.each($.grep(data_neraca, function(n){ return n.jenis == 2 && n.nomor_id.substring(0,1) == pieces }), function(i, a){
          html = html + '<option value="'+a.nomor_id+'" id="'+a.nomor_id+'">'+a.keterangan+'</option>';
        })

        // alert(html);
        $('#detail_total').html(html);

      }

      function grab_parrent(){
        html = '<option value="---">- Pilih Parrent</option>';

        $.each($.grep(data_neraca, function(n){ return n.id_parrent == "" && n.type == state && n.jenis == 1 }), function(i, n){
          html = html+'<option value="'+n.nomor_id+'">'+n.nomor_id+'</option>';
        })

        $('#parrent').html(html);
      }

      function delete_detail(parrent){
        $.each($.grep(data_detail, function(a){ return a.id_parrent == parrent }), function(i, n){
          idxx = data_detail.findIndex(s => s.nomor_id === n.nomor_id);

          data_detail.splice(idxx, 1);
        })

        return true
      }

      function balancing_detail(parrent){
        $.each($.grep(data_detail, function(a){ return a.id_parrent === parrent }), function(i, n){
          idxx = data_detail.findIndex(a => a.nomor_id === n.nomor_id);

          $('#'+state+'_tree').jstree().delete_node(data_detail[idxx].nomor_id);
          data_detail.splice(idxx, 1);
        })

        $("#group_show .search").each(function(){
          text = $(this).data("nama"); ids = $(this).attr("id"); dari = $(this).data("dari");
          createNode(parrent, parrent+"."+ids, text, "last", text, open, "demo");

          data_detail[data_detail.length] = {
            "id_group"   : ids,
            "nomor_id"   : parrent+"."+ids,
            "id_parrent" : parrent,
            "nama"       : text,
            "dari"       : dari
          }
        })
      }

    })

  </script>
@endsection
