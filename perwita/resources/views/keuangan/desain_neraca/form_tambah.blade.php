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

  </style>

@endsection


@section('content')

 <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Master Activa</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index-2.html">Home</a>
                        </li>
                        <li>
                            <a>Purchase</a>
                        </li>
                        <li>
                          <a> Master Purchase</a>
                        </li>
                        <li class="active">
                            <strong>Create Master Activa</strong>
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
                    <h5> Tambah Data Master Activa
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
                            <button class="btn btn-primary btn-sm tambah_detail" style="font-size:8pt;" type="button">Tambahkan Detail</button>
                            <button class="btn btn-danger btn-sm hapus" style="font-size:8pt;" type="button">Hapus</button>
                        </div>

                        <div class="col-md-12" style="border-top: 1px solid #eee; margin: 5px 0px"></div>

                        <div class="col-md-12 m-t" style="padding: 0px;">
                          <table border="0" class="table table-bordered" style="font-size: 8pt;">
                            <tr>
                              <th class="text-center">Id Grup Akun</th>
                              <th class="text-center">Nama Grup Akun</th>
                            </tr>

                            <tr>
                              <td>GA-001</td>
                              <td>Kas</td>
                            </tr>
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

@endsection


@section('extra_scripts')

  <script src="{{ asset('assets/vendors/jsTree/jsTree.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/jsTree/jstreetable.js') }}"></script>

  <script type="text/javascript">
     
    $(document).ready(function(){

      data = []; data_neraca = []; data_detail = [];
      state = "aktiva";

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
            }
      })

      $(".switch").click(function(evt){
        evt.preventDefault();

        btn = $(this);
        $(".switch").removeClass("aktif");
        btn.addClass("aktif");

        state = btn.data("for");
      })

      $('#aktiva_tree').jstree({
        plugins: ["dnd","contextmenu", "types"],
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

          createNode(parrent, id, id, "last", keterangan, open, type);

          data_neraca[data_neraca.length] = {
            "nomor_id": id,
            "keterangan": keterangan.toUpperCase(),
            "id_parrent": parrent,
            "level" : level,
            "jenis" : jenis,
            "type" : type
          };

          console.log(data_neraca);
          form_reset();
        }

      })

      function createNode(parent_node, new_node_id, new_node_text, position, keterangan, state = false, type = "default") {
        // alert("okee");
        $('#aktiva_tree').jstree('create_node', parent_node, { "text":keterangan+" ("+new_node_id+")", "type": type, "id":new_node_id , "data":{"id": new_node_text, "id_parrent":parent_node}, state: {"opened": state}}, position, false, false); 
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
        $("#level").val(1);
        $("#parrent").val("---"); $("#parrent").attr("disabled, disabled");
        $("#parrent_name").val("---");
        $("#nomor_id").val(grab_id);
        $("#jenis").val(1);
        $("#keterangan").val("");
      }

      function grab_id(){
        cek = $("#state_id").text(); idle = $("#state_id").text().length; fcs = "A";
        count = $.grep(data_neraca, function(n){ return n.nomor_id.substring(0, idle) == fcs }).length;

        return (count+1);
      }

    })

  </script>
@endsection
