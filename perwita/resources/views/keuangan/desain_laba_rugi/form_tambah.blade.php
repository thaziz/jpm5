<style type="text/css">
  .myClass{
    background: white;
    font-size: 8pt;
    padding: 5px;
    text-align: center;
    position: -webkit-sticky;
      top: 0;
  }
  .myCell{
    text-align: center;
    padding:3px 0px;
  }
  #tabelNeraca{
    width:100%;
    font-size: 8pt;
    position: sticky;
    position: -webkit-sticky;
    background: white;
      top: 0;
  }

  #table_form, #table-filter{
      border:0px solid black;
      width: 100%;
    }

    #table_form input,{
      padding-left: 50px;
    }

    #table_form td{
      padding: 10px 0px 0px 0px;
      vertical-align: top;
    }
  #table_form .right_side{
      padding-left: 10px;
    }

  #tabelNeraca th{
    padding: 3px;
    border: 1px solid #eee;
  }

  .jstree-open > .jstree-anchor > .fa-folder:before {
        content: "\f07c";
    }

    .jstree-default .jstree-icon.none {
        width: 0;
    }
</style>

<div class="row" style="width: 100%">
  <div class="col-md-7" style="background: #f9f9f9;height: 500px; padding: 0px; overflow-y: scroll;">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane fade in active" id="home">
        <div id="aktiva_tree" style="font-size: 8pt;">
            
        </div>  
      </div>
    </div>
    
  </div>

  <div class="col-md-5" style="padding: 0px;">
    <div class="col-md-12" style="color:#555;border:1px solid #ccc;padding: 0px;">
      <div class="col-md-12 text-center type" data-type="aktiva" href="#home" aria-controls="home" role="tab" data-toggle="tab" data-type="aktiva" style="padding: 5px;border-right: 1px solid #ccc; cursor: pointer;">
        Form Isian Desain
      </div>
    </div>

    <div class="col-md-12" style="margin-top: 5px;">
      <form id="myForm">
        <table id="table_form" border="0">
              <tbody>
                <tr>
                  <td width="24%">Level<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                  <td width="35%">

                    <input type="number" value="1" min="1" max="2" id="level" name="level" style="width:80%;padding-left: 5px;"> &nbsp;<i class="fa fa-close" style="font-weight:600; color:#ed5565; visibility: hidden; cursor: pointer;" id="cancel-edit"></i>
                      
                  </td>
                  <td colspan="2"></td>
                  
                </tr>

                <tr>
                  <td width="17%">Parrent ID<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                  <td width="35%">

                    <select name="parrent_id" id="parrent_id" disabled>
                      <option value="null">Pilih Parrent</option>
                    </select>
                      
                  </td>
                  <td colspan="2" class="text-center"><input class="text-center" type="text" min="1" max="3" id="parrent_id_view" name="parrent_id_view" style="width:90%" disabled value="---"></td>
                  
                </tr>

                <tr>
                  <td width="17%">Nomor ID<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                  <td width="35%">
            
                    <input type="text" class="text-center" value="DT31" id="level_view" name="level_view" style="width:35%" disabled>
                    <input type="text" min="1" max="3" id="no_id" value="01" name="no_id" style="width:50%;padding-left: 5px;" disabled>
                      
                  </td>
                  <td colspan="2"></td>
                  
                </tr>

                <tr>
                  <td width="17%">Jenis<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                  <td width="35%">

                    <select id="jenis" name="jenis">
                      <option value="1">Header/Title</option>
                      <option value="2">Detail</option>
                      <option value="3">Total</option>
                      <option value="4">Line Break</option>
                    </select>
                      
                  </td>
                  
                  <td colspan="2" class="text-center">
                    <select name="jenis" style="width: 90%; visibility: hidden;" id="total_for">

                    </select>
                  </td>

                </tr>

                <tr>
                  <td width="17%">Keterangan<input type="hidden" readonly name="_token" value="{{ csrf_token() }}"></td>
                  <td width="35%" colspan="4">

                    <input type="text" id="keterangan" name="keterangan" style="width:100%;padding-left: 5px;">
                      
                  </td>
                  
                </tr>
              </tbody>
          </table>
        </form>
    </div>

    <div class="col-md-12 m-t" style="border-top: 1px solid #eee;border-bottom: 1px solid #eee;padding: 8px 5px;">
      <button class="btn btn-success btn-xs col-md-3" id="masukkan"><i class="fa fa-arrow-left"></i> &nbsp;<span>Masukkan</span></button>

      <button class="btn btn-success btn-xs col-md-4" id="btn_detail" style="margin-left: 5px;" disabled><i class="fa fa-list-ul"></i> &nbsp;Tambah Detail</button>

      <button class="btn btn-danger btn-xs col-md-4" disabled id="btn_hapus_detail" style="margin-left: 5px;"><i class="fa fa-list-ul"></i> &nbsp;Hapus Detail</button>

    </div>

    <div class="col-md-12 m-t">
      <div class="col-md-12" style="background: #f9f9f9; height: 200px;padding: 0px;overflow-y: scroll;">
        <table border="0" style="width: 100%; font-size: 8pt;" class="table">
          <thead>
            <tr>
              <th class="text-center inSearch" style="background: white;border: 1px solid #ccc;" width="30%">Kode</th>
              <th class="text-center" style="background: white;border: 1px solid #ccc;">Keterangan</th>
            </tr>
          </thead>

          <tbody id="detail-in-show">
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-md-12" style="padding: 10px;border-top: 1px solid #eee;">
    <button class="btn btn-primary btn-xs col-md-2 col-md-offset-10" id="simpan">Simpan Desain</button>
  </div>
</div>

<script>
  $(document).ready(function(){
    var data;
    data = []; $edit = false;

    $dataDetail = {!! $datadetail !!}; $apply_nama = ""; $apply_id = "";

    //console.log($dataDetail);

    $dataNeraca = []; $neracaDetail = []; var $dataNeracaCount = 0; var $neracaDetailCount = 0; $type = "aktiva"; var id_detail = 1; $detail = "detail";

    $aktiva_lvl1 = 1; $aktiva_lvl2 = 1;
    $pasiva_lvl1 = 1; $pasiva_lvl2 = 1;

    $.fn.childDelete = function($id){
      id = []; $c=0;
      $.each($neracaDetail, function(i, n){
        if(n.nomor_id == $id){
          id[$a] = n.id_detail; $c++;
        }
      })

      //console.log(id);

      for(i = 0; i < id.length; i++){
        //alert(id[i]+" - "+$neracaDetail.findIndex(c => c.id_detail == id[i]));
        $neracaDetail.splice($neracaDetail.findIndex(c => c.id_detail == id[i]), 1);
      }
    }
    
    $('#aktiva_tree').on("select_node.jstree", function (e, data) { 
      console.log(data);
      //console.log($dataNeraca);
      // alert(data.node.id);

      $idOnSelect = "";

      if(data.node.id.indexOf("/") == -1){
        $.each($dataNeraca, function(i, n){
          if(n.nomor_id == data.node.id){
            $("#detail-in-show").html("");
            $("#level").val(n.level); $("#level_view").val(n.nomor_id.substring(0,2)); $("#level").attr("disabled", "disabled");
            $("#no_id").val(n.nomor_id.substring(2)); $("#no_id").attr("disabled", "disabled");
            $("#parrent_id_view").val(n.id_parrent);
            $("#jenis").val(n.jenis); $("#jenis").attr("disabled", "disabled");
            $("#keterangan").val(n.keterangan.toUpperCase());
            $("#cancel-edit").css("visibility", "visible");

            $idOnSelect = n.nomor_id.substring(0,2)+""+n.nomor_id.substring(2);

            return false;
          }
        })

        $.each($.grep($neracaDetail, function(n){ return n.nomor_id == $idOnSelect}), function(i, n){
          $html = "<tr><td class='inSearch' data-for='child' data-nama='"+n.nama+"'>"+n.id_akun+"</td> <td>"+n.nama+"</td></tr>";
          $("#detail-in-show").prepend($html);
        })

        $("#btn_hapus_detail").removeAttr("disabled");
        $("#masukkan span").text("Ubah");
        $("#keterangan").focus();
        $edit = true;
      }else{
        $("#cancel-edit").click();
      }
    });

    $('#pasiva_tree').on("select_node.jstree", function (e, data) { 
      //console.log(data);
      //console.log($dataNeraca);

      //alert("okee");
      $idOnSelect = "";

      if(data.node.id.substring(0, 1) != "D"){
        $.each($dataNeraca, function(i, n){
          if(n.nomor_id == data.node.id){
            $("#detail-in-show").html("");
            $("#level").val(n.level); $("#level_view").val(n.nomor_id.substring(0,2)); $("#level").attr("disabled", "disabled");
            $("#no_id").val(n.nomor_id.substring(2)); $("#no_id").attr("disabled", "disabled");
            $("#parrent_id_view").val(n.id_parrent);
            $("#jenis").val(n.jenis); $("#jenis").attr("disabled", "disabled");
            $("#keterangan").val(n.keterangan.toUpperCase());
            $("#cancel-edit").css("visibility", "visible");

            $idOnSelect = n.nomor_id.substring(0,2)+""+n.nomor_id.substring(2);

            return false;
          }
        })

        $.each($.grep($neracaDetail, function(n){ return n.nomor_id == $idOnSelect}), function(i, n){
          $html = "<tr><td class='inSearch' data-for='child' data-nama='"+n.nama+"'>"+n.id_akun+"</td> <td>"+n.nama+"</td></tr>";
          $("#detail-in-show").prepend($html);
        })

        $("#btn_hapus_detail").removeAttr("disabled");
        $("#masukkan span").text("Ubah");
        $("#keterangan").focus();
        $edit = true;
      }else{
        $("#cancel-edit").click();
      }
    });

    $("#btn_hapus_detail").click(function(){
      $id = []; $a=0; $node = $("#level_view").val()+""+$("#no_id").val();

      //console.log($neracaDetail);

      $.each($dataNeraca, function(i,n){
        if(n.nomor_id == $node || n.id_parrent == $node){
          //alert(n.nomor_id+" = "+$node)
          $id[$a] = n.nomor_id; $a++;
          if(n.jenis == 2 || n.jenis == 3){
            $(this).childDelete(n.nomor_id);
          }
        }
      })

      //console.log($neracaDetail);

      for(i = 0; i < $id.length; i++){
        $dataNeraca.splice($dataNeraca.findIndex(x => x.nomor_id == $id[i]), 1);
      }

      
      //alert($node);

      $('#'+$type+'_tree').jstree().delete_node($("#"+$node));

      console.log($dataNeraca);
      console.log($neracaDetail);

      $("#cancel-edit").click();

    })

    $('#aktiva_tree').jstree({
      plugins: ["table","dnd","contextmenu", "types"],
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

      table: {
        columns: [
          {width: 517, header: "Keterangan", headerClass: "myClass", wideCellClass:"myCell"}
        ],
        resizable: false,
        draggable: false,
        contextmenu: true,
        width: "100%",
        height: "100%"
      },
    });

    $('#pasiva_tree').jstree({
      plugins: ["table","dnd","contextmenu", "types"],
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

      table: {
        columns: [
          {width: 517, header: "Keterangan", headerClass: "myClass", wideCellClass:"myCell"}
        ],
        resizable: false,
        draggable: false,
        contextmenu: true,
        width: "100%",
        height: "100%"
      },
    });

    $("#masukkan").click(function(event){

      if($edit){
        $node = "#"+$("#level_view").val()+""+$("#no_id").val();

        //console.log($dataNeraca);
       $node_id = $dataNeraca.findIndex(x => x.nomor_id == $node.substring(1));

       $dataNeraca[$node_id]["keterangan"] = $("#keterangan").val().toUpperCase();

        $('#'+$type+'_tree').jstree('rename_node', $node , $("#keterangan").val().toUpperCase());
        $("#cancel-edit").click();

        return false;
      }

      event.stopImmediatePropagation();
      $dataNeracaCount = $dataNeraca.length;
      $neracaDetailCount = $neracaDetail.length;
      //console.log($dataNeraca);
      //$("#parrent_id").val()
      $id = $("#level_view").val()+""+$("#no_id").val();
      $keterangan = $("#keterangan").val().toUpperCase();
      $parrent = ($("#parrent_id").val() == "null") ? null : $("#parrent_id").val();
      $level = $("#level").val();
      $jenis = $("#jenis").val();

      if($("#no_id").val() == "" || $("#no_id").val() == null){
        alert("Masukkan ID Terlebih Dahulu")
        return false;
      }else if($.grep($dataNeraca, function(n, i){ return n.nomor_id == $id && n.type == $type }) != 0){
        alert("Nomor ID Ini Sudah Digunakan.");
        return false;
      }

      if($("#level").val() != "1" && $("#parrent_id").val() == "null"){
        alert("Detail Level "+$("#level").val()+" Harus Memiliki Parrent.");
        return false;
      }

      open = ($jenis != "1") ? false : true;
      type = "default";

      if($jenis == "3")
        type = "total";
      else if($jenis == "4")
        type = "space";

      createNode($parrent, $id, $id, "last", $keterangan, open, type);
      $dataNeraca[$dataNeracaCount] = {
        "nomor_id": $id,
        "keterangan": $keterangan.toUpperCase(),
        "id_parrent": $parrent,
        "level" : $level,
        "jenis" : $jenis,
        "type" : $type
      };

      if($jenis == "2" || $jenis == "3"){
        $("#detail-in-show .inSearch").each(function(){
          //alert($(this).data("for"));
          if($(this).data("for") != "parrent"){
            $neracaDetail[$neracaDetailCount] = {
              "id_akun" : $(this).text(),
              "nomor_id" : $id,
              "id_detail" : id_detail,
              "nama"      : $(this).data("nama")
            }
            //console.log($neracaDetail);
            $neracaDetailCount++; id_detail++;
          }

          //alert($id);
          if($jenis == 2)
            createNode($id, $id+"/"+$(this).text(), $(this).text(), "last", $(this).data('nama'), false, "demo");
        })
      }

      if($type == "aktiva"){
        if($level == 1){$aktiva_lvl1++;}else{$aktiva_lvl2++};
      }
      else{
        if($level == 1){$pasiva_lvl1++;}else{$pasiva_lvl2++};
      }

      //alert($lvl1);
      //$dataNeracaCount++;
      form_reset();
      console.log($dataNeraca);
      console.log($neracaDetail);

    })

    $("#jenis").on("change", function(){

      $("#total_for").css("visibility", "hidden");

      if($(this).val() == 2){
        $("#btn_detail").removeAttr("disabled");
      }else if($(this).val() == 3){
        $("#total_for").html("");
        $html = '<option value="0">Dari Penjumlahan</option>';

        $.each($.grep($dataNeraca, function(n){ return n.jenis == 2 && n.type == $type || n.jenis == 3 && n.type == $type}), function(i, n){

          $html = $html+'<option value="'+n.nomor_id+'" id="sel_'+n.nomor_id+'">'+n.keterangan+'</option>';

        })

        $("#total_for").html($html);
        //alert($html);
        $("#total_for").css("visibility", "visible");
      }
      else{
        $("#btn_detail").attr("disabled", "disabled");
        $("#detail-in-show").html("");
      }

      if($(this).val() == 4)
        $("#keterangan").attr("disabled", "disabled");
      else
        $("#keterangan").removeAttr("disabled");
    })

    $("#level").on("change", function(){
      $first = ($type == "aktiva") ? "3" : "4";
      if($(this).val() == 2 && $.grep($dataNeraca, function(n, i){ return n.level == 1; }) == 0){
        alert("Anda Harus Menambahkan Data Level 1 Terlebih Dahulu, Sebelum Membuat Data Level 2.");
        $(this).val(1);$("#level_view").val("DT"+$first+"1");
        return false;
      }else if($(this).val() == 3 && $.grep($dataNeraca, function(n, i){ return n.level == 2; }) == 0){
        alert("Anda Harus Menambahkan Data Level 2 Terlebih Dahulu, Sebelum Membuat Data Level 3.");
        $(this).val(1);$("#level_view").val("DT"+$first+"1");
      }

      $lvl1 = ($type == "aktiva") ? $aktiva_lvl1 : $pasiva_lvl1;
      $lvl2 = ($type == "aktiva") ? $aktiva_lvl2 : $pasiva_lvl2;

      if($(this).val() != 1){
        $("#parrent_id").removeAttr("disabled");
        $("#no_id").val("0"+$lvl2);
      }
      else{
        $("#parrent_id").attr("disabled", "disabled");
        $("#no_id").val("0"+$lvl1);
      }


      $html = '<option value="null">Pilih Parrent</option>';
      $cek = ($(this).val() - 1);
      $.each($.grep($dataNeraca, function(a, b){ return a.level == $cek}), function(i, n){
        if(n.jenis == 1 && n.type == $type)
            $html = $html+"<option value='"+n.nomor_id+"'>"+n.nomor_id+"</option>";
      })

      $("#parrent_id").html($html);
      $("#level_view").val("DT"+$first+""+$(this).val());
    })

    $("#parrent_id").change(function(){

      if($(this).val() != "null"){
        $data = $(this).val();
        $get = $.grep($dataNeraca, function(n, i){ return n.nomor_id == $data; });
        $("#parrent_id_view").val($get[0].keterangan);
      }
      else{
        $("#parrent_id_view").val("---");
      }
    })

    // $('#aktiva_tree').on('ready.jstree', function (e, data) {
    //   $dataNeraca[$dataNeracaCount] = {
    //     "nomor_id": "101",
    //     "keterangan": "Aktiva Lancar",
    //     "id_parrent": null,
    //     "level" : "1",
    //     "jenis": "1"
    //   }

    //   $dataNeracaCount++;
    //     createNode(null, "101", "101", "last", "Aktiva Lancar");
    // });

    $("#btn_detail").click(function(event){
      event.stopImmediatePropagation();
      $("#modal_detail").modal("show");
    })

    $("#parrent-wrap").on("click", ".clickAble", function(event){
      event.stopImmediatePropagation();
      $("#detail-wrapper").html("");
      var str = $(this).data("parrent").toString(); var nama = $(this).data("nama");

      $apply_id = str; apply_nama = nama;

      $html = "";

      $.each($.grep($dataDetail, function(n){return n.id_akun.substring(0, str.length) == str;}), function(i, n){
        $nama = (n.nama_akun.length > 26) ? n.nama_akun.substring(0, 25)+" ..." : n.nama_akun;
        $html = $html+"<tr><td class='inSearch' data-for='child' data-nama='"+n.nama_akun+"' style='padding-left:15px;'>"+n.id_akun+"</td> <td style='padding-left:15px;'>"+$nama+"</td></tr>";
      })

      //console.log(dataParrent);
      $("#detail-wrapper").html($html);
    })

    $("#simpan").click(function(event){
      event.stopImmediatePropagation();
      if($dataNeraca.length == 0){
        alert("Tidak Ada Data Dalam Desain Neraca");
      }else{
        $comp = confirm("Apa Anda Sudah Yakin ?");

        if($comp){
          $.ajax(baseUrl+"/master_keuangan/desain_laba_rugi/save",{
            type: "post",
            dataType: "json",
            data: { neraca: $dataNeraca, detail: $neracaDetail, _token: "{{ csrf_token() }}" },
            success: function(response){
              console.log(response);
              if(response.status == "sukses"){
                alert("Desain Berhasil Ditambahkan");
              }
            }
          })
        }
      }
    })

    $("#cancel-edit").click(function(event){
      event.stopImmediatePropagation();
      $(this).css("visibility", "hidden");
      $("#btn_hapus_detail").attr("disabled", "disabled");
      $edit = false;
      $("#masukkan span").text("Masukkan");

      form_reset();
    })

    $(".type").click(function(event){
      $type = $(this).data("type");
      $(".type").css({"background" : "none", "color" : "#333"});
      $(this).css({"background" : "#1ab394", "color" : "white"});
      
      $("#cancel-edit").click();

      
    })

    $("#total_for").change(function(){
      //alert($("#sel_"+$(this).val()).text()+" -- "+$(this).val());
      
      if($(this).val() != 0){
        $html = "<tr><td class='inSearch' data-for='child' data-nama='"+$("#sel_"+$(this).val()).text()+"'>"+$(this).val()+"</td> <td>"+$("#sel_"+$(this).val()).text()+"</td></tr>";

        $("#detail-in-show").prepend($html);
        $("#sel_"+$(this).val()).attr("disabled", "disabled");
      }
      
    })

  })

  function createNode(parent_node, new_node_id, new_node_text, position, keterangan, state = false, type = "default") {
    //alert("okee");
    $('#'+$type+'_tree').jstree('create_node', parent_node, { "text":keterangan+" ("+new_node_id+")", "type": type, "id":new_node_id , "data":{"id": new_node_text, "id_parrent":parent_node}, state: {"opened": state}}, position, false, false); 
  }

  function form_reset(){
    $lvl1 = ($type == "aktiva") ? $aktiva_lvl1 : $pasiva_lvl1;
    $first = ($type == "aktiva") ? "3" : "4";

    $("#total_for").css("visibility", "hidden");
    $("#level").val(1); $("#level").removeAttr("disabled");
    $("#parrent_id").val("null"); $("#parrent_id").attr("disabled", "disabled");
    $("#parrent_id_view").val("---");
    $("#level_view").val("DT"+$first+"1");
    $("#no_id").val("0"+$lvl1);
    $("#jenis").val(1); $("#jenis").removeAttr("disabled");
    $("#keterangan").val(""); $("#keterangan").removeAttr("disabled");
    $("#detail-in-show").html("");
    $("#btn_detail").attr("disabled", "disabled");

    return false;
  }
</script>