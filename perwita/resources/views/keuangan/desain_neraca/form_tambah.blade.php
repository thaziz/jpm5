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
                            <strong> Create Desain Neraca  </strong>
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
                    <h5> Tambah Data Desain Neraca
                     <!-- {{Session::get('comp_year')}} -->
                     </h5>
                    <div class="ibox-tools">
                        
                    </div>
                </div>
                <div class="ibox-content">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 1px; padding: 10px; height: 500px; box-shadow: 0px 0px 10px #eee;">
                        <div role="tabpanel" class="tab-pane fade in active" id="aktiva">
                          <div id="aktiva_tree" style="font-size: 8pt;">
              
                          </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="pasiva">
                          <div id="pasiva" style="font-size: 8pt;">
                            pasiva
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="col-md-12" style="border: 1px solid #ddd; border-radius: 5px; padding: 10px;">

                        <div class="col-md-12" style="padding:0px;">
                          <div class="btn-group">
                              <button href="#aktiva" aria-controls="aktiva" role="tab" data-toggle="tab" class="btn btn-white aktif btn-sm switch" data-for="aktiva" style="font-size: 8pt;" type="button">Activa</button>

                              <button href="#pasiva" aria-controls="pasiva" role="tab" data-toggle="tab" class="btn btn-white btn-sm switch" data-for="pasiva" style="font-size: 8pt;" type="button">Pasiva</button>
                          </div>

                          <span class="pull-right text-disabled" style="font-weight: 600; font-style: italic; font-size: 7pt;">{{ date("m-d-Y") }}</span>
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
                                <select disabled id="detail_total" class="select_validate form-control" style="display:none;">
                                  <option value="---"> -- Dari Penjumlahan</option>
                                </select>
                              </td>
                            </tr>

                            <tr>
                              <td width="15%" class="text-center">Keterangan</td>
                              <td colspan="5" width="35%">
                                <input type="text" style="width: 94%" class="form_validate form-control" id="keterangan" placeholder="Masukkan Keterangan Tentang Ini">
                              </td>
                            </tr>

                          </table>
                        </div>

                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 10px 0px"></div>

                        <div class="col-md-12 text-right" style="padding: 0px;">
                            <button class="btn btn-success btn-sm" id="masukkan" style="font-size:8pt;" type="button">Masukkan Ke Desain</button>
                            <button disabled class="btn btn-primary btn-sm" id="tambah_detail" style="font-size:8pt;" type="button">Tambahkan Group Neraca</button>
                            <button disabled class="btn btn-danger btn-sm" id="hapus_detail" style="font-size:8pt;" type="button">Hapus</button>
                        </div>

                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 5px 0px"></div>

                        <div class="col-md-12 m-t" style="padding: 0px; height: 146px; overflow-x: scroll">
                          <table border="0" class="table table-bordered" style="font-size: 8pt;">
                            <tr>
                              <th width="30%" class="text-center">Id Grup Akun</th>
                              <th width="70%" class="text-center">Nama Grup Akun</th>
                            </tr>
                            
                            <tbody id="group_show">

                            </tbody>
                          </table>
                            
                        </div>

                      </div>
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
              <table border="1" width="100%" class="table table-bordered" style="font-size: 8pt;">
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

@endsection


@section('extra_scripts')

  <script src="{{ asset('assets/vendors/jsTree/jsTree.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/jsTree/jstreetable.js') }}"></script>

  <script type="text/javascript">
     
    $(document).ready(function(){

      data = []; data_neraca = []; data_detail = [];
      data_akun = {!! $data_akun !!}; data_group = {!! $data_group !!};

      // console.log(data_akun);
      // console.log(data_group);

      state = "aktiva"; chosen_group = "";

      grab_detail();

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

      $('#aktiva_tree').on("select_node.jstree", function (e, data) { 
        // console.log(data);

        $("#hapus_detail").removeAttr("disabled");

        idx = data_neraca.findIndex(n => n.nomor_id == data.node.id);
        parrent = (data.node.parent == "#") ? data_neraca[idx].nomor_id.substring(0, data_neraca[idx].level) : data_neraca[idx].id_parrent+".";

        // alert(parrent);

        $("#cancel").css("display", "inline-block");
        $("#level").val(data_neraca[idx].level); $("#level").attr("disabled", "disabled");
        $("#state_id").text(parrent);
        $("#nomor_id").val(data_neraca[idx].nomor_id.substring(parrent.length));
        $("#parrent").val((data_neraca[idx].id_parrent == null) ? "---" : data_neraca[idx].id_parrent);

        if(data_neraca[idx].id_parrent == null){
          $("#parrent_name").val("---");
        }else{
          $("#parrent_name").val(data_neraca[data_neraca.findIndex(n => n.nomor_id == data_neraca[idx].id_parrent)].keterangan);
        }

        $('#jenis').val(data_neraca[idx].jenis); $("#jenis").attr("disabled", "disabled");
        $("#keterangan").val(data_neraca[idx].keterangan)
      });

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
      })

      $("#jenis").change(function(evt){
        evt.stopImmediatePropagation();
        evt.preventDefault();
        val = $(this).val();

        if(val == "2"){
          $("#tambah_detail").removeAttr("disabled");
        }else if(val == "1" || val == "4"){
          $("#tambah_detail").attr("disabled", "disabled");
          $("#group_show").html("");
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

        group = data_group.findIndex(n => n.id == chosen_group);

        html = '<tr id="'+data_group[group].id+'" data-nama = "'+data_group[group].nama_group+'" class="search">'+
                  '<td>'+data_group[group].id+'</td>'+
                  '<td>'+data_group[group].nama_group+'</td>'+
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
              alert("Harap Pilih Group Neraca Terlebih Dahulu.");
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

          if(jenis == 2){
            $("#group_show .search").each(function(){
              text = $(this).data("nama"); ids = $(this).attr("id");
              createNode(id, id+"."+ids, text, "last", text, open, "demo");

              data_detail[data_detail.length] = {
                "id_group"   : ids,
                "nomor_id"   : id+"."+ids,
                "id_parrent" : id,
                "nama"       : text
              }
            })
          }

          console.log(data_neraca);
          console.log(data_detail);
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
        $("#keterangan").val("");
        $("#state_id").text((state == "aktiva") ? "A" : "P");
        $("#tambah_detail").attr("disabled", "disabled"); $("#hapus_detail").attr("disabled", "disabled");
        $("#group_show").html("");

        grab_id();
      }

      function grab_id(){
        cek = $("#state_id").text(); idle = $("#state_id").text().length; level = $("#level").val();
        count = $.grep(data_neraca, function(n){ return n.nomor_id.substring(0, idle) == cek && n.level == level }).length;

        // console.log(count);
        $("#nomor_id").val((count+1));
      }

      function grab_detail(){
        html = "";
        $.each(data_group, function(i, n){
          if($("#group_show").find("#"+n.id).length == 0){
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

      function grab_parrent(){
        html = '<option value="---">- Pilih Parrent</option>';

        $.each($.grep(data_neraca, function(n){ return n.id_parrent == null && n.type == state }), function(i, n){
          html = html+'<option value="'+n.nomor_id+'">'+n.nomor_id+'</option>';
        })

        $('#parrent').html(html);
      }

    })

  </script>
@endsection
