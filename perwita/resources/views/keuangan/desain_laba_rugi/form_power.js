$(document).ready(function(){
    var data;
    data = []; $edit = false;

    $dataDetail = {!! $datadetail !!};

    //console.log($dataDetail);

    var $dataNeraca = []; var $neracaDetail = []; var $dataNeracaCount = 0; var $neracaDetailCount = 0; var id_detail = 1; $lvl1 = 1; $lvl2 = 1;

    $.fn.childDelete = function($id){
      id = []; $a=0;
      $.each($neracaDetail, function(i, n){
        if(n.nomor_id == $id){
          id[$a] = n.id_detail; $a++;
        }
      })

      console.log(id);

      for(i = 0; i < id.length; i++){
        //alert(id[i]+" - "+$neracaDetail.findIndex(c => c.id_detail == id[i]));
        $neracaDetail.splice($neracaDetail.findIndex(c => c.id_detail == id[i]), 1);
      }
    }
    
    $('#jstree1').on("select_node.jstree", function (e, data) { 
      //console.log(data);
      //console.log($dataNeraca);

      if(data.node.id.substring(0, 1) != "A"){
        $.each($dataNeraca, function(i, n){
          if(n.nomor_id == data.node.id){
            $("#level").val(n.level); $("#level_view").val(n.level); $("#level").attr("disabled", "disabled");
            $("#no_id").val(n.nomor_id.substring(1, n.nomor_id.length)); $("#no_id").attr("disabled", "disabled");
            $("#parrent_id_view").val(n.id_parrent);
            $("#jenis").val(n.jenis); $("#jenis").attr("disabled", "disabled");
            $("#keterangan").val(n.keterangan.toUpperCase());
            $("#cancel-edit").css("visibility", "visible");

            return false;
          }
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
      $id = []; $a=0; $node = $("#level").val()+""+$("#no_id").val();

      //console.log($neracaDetail);

      $.each($dataNeraca, function(i,n){
        if(n.nomor_id == $node || n.id_parrent == $node){
          //alert(n.nomor_id+" = "+$node)
          $id[$a] = n.nomor_id; $a++;
          if(n.jenis == 2){
            $(this).childDelete(n.nomor_id);
          }
        }
      })

      //console.log($neracaDetail);

      for(i = 0; i < $id.length; i++){
        $dataNeraca.splice($dataNeraca.findIndex(x => x.nomor_id == $id[i]), 1);
      }

      //console.log($dataNeraca);


      $("#jstree1").jstree().delete_node($("#"+$node));

      $("#cancel-edit").click();

    })

    $("#jstree1").jstree({
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
          {width: 270, header: "Keterangan", headerClass: "myClass", wideCellClass:"myCell2"},
          {width: 137, value: "id", headerClass: "myClass", wideCellClass:"myCell", header: "Nomor ID"},
          {width: 110, value: "id_parrent", headerClass: "myClass", wideCellClass:"myCell", header: "ID Parrent", format: function(v){if(v){return v}else{return "-";}}}
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

       $dataNeraca[$node_id]["keterangan"] = $("#keterangan").val();

        $("#jstree1").jstree('rename_node', $node , $("#keterangan").val().toUpperCase());
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
      }else if($.grep($dataNeraca, function(n, i){ return n.nomor_id == $id }) != 0){
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
        "keterangan": $keterangan,
        "id_parrent": $parrent,
        "level" : $level,
        "jenis" : $jenis
      };

      if($jenis == "2"){
        $("#detail-in-show .inSearch").each(function(){
          //alert($(this).data('nama'));
          if($(this).data("for") != "parrent"){
            $neracaDetail[$neracaDetailCount] = {
              "id_akun" : $(this).text(),
              "nomor_id" : $id,
              "id_detail" : id_detail
            }
            //console.log($neracaDetail);
            $neracaDetailCount++; id_detail++;
          }

          createNode($id, "A"+$(this).text(), $(this).text(), "last", $(this).data('nama'), false, "demo");
        })
      }

      if($level == 1){$lvl1++;}else{$lvl2++};
      //alert($lvl1);
      //$dataNeracaCount++;
      form_reset();
      //console.log($dataNeraca);
      console.log($neracaDetail);

    })

    $("#jenis").on("change", function(){
      if($(this).val() == 2)
        $("#btn_detail").removeAttr("disabled");
      else{
        $("#btn_detail").attr("disabled", "disabled");
        $("#detail-in-show").html("");
      }

      if($(this).val() == 4)
        $("#keterangan").attr("disabled", "disabled");
    })

    $("#level").on("change", function(){
      if($(this).val() == 2 && $.grep($dataNeraca, function(n, i){ return n.level == 1; }) == 0){
        alert("Anda Harus Menambahkan Data Level 1 Terlebih Dahulu, Sebelum Membuat Data Level 2.");
        $(this).val(1);$("#level_view").val(1);
        return false;
      }else if($(this).val() == 3 && $.grep($dataNeraca, function(n, i){ return n.level == 2; }) == 0){
        alert("Anda Harus Menambahkan Data Level 2 Terlebih Dahulu, Sebelum Membuat Data Level 3.");
        $(this).val(1);$("#level_view").val(1);
      }

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
        if(n.jenis == 1)
            $html = $html+"<option value='"+n.nomor_id+"'>"+n.nomor_id+"</option>";
      })

      $("#parrent_id").html($html);
      $("#level_view").val($(this).val());
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

    // $('#jstree1').on('ready.jstree', function (e, data) {
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
      //alert("okee")
      $("#modal_detail").modal("show");
    })

    $(".clickAble").click(function(event){
      event.stopImmediatePropagation();
      $("#detail-wrapper").html("");
      var str = $(this).data("parrent").toString();

      $html = "";

      $.each($.grep($dataDetail, function(n){return n.id_akun.substring(0, str.length) == str;}), function(i, n){
        $nama = (n.nama_akun.length > 26) ? n.nama_akun.substring(0, 25)+" ..." : n.nama_akun;
        $html = $html+"<tr><td class='inSearch' data-for='child' data-nama='"+n.nama_akun+"' style='padding-left:15px;'>"+n.id_akun+"</td> <td style='padding-left:15px;'>"+$nama+"</td></tr>";
      })


      $("#detail-wrapper").html($html);
    })

    $("#apply-detail").on("click", function(event){
      event.stopImmediatePropagation();

      $html = ""; $falsed= false; $list = "";

      // $("#detail-in-show").html("");

      //alert(1);
      
      $("#detail-wrapper .inSearch").each(function(){
        $print = true;
        $a = $(this).text(); str = $(this).data("nama");
        $("#detail-in-show .inSearch").each(function(){
          //alert($(this).text());
          if($a == $(this).text()){
            $falsed = true; $print = false;
            $list = $list+"<li>"+str+"</li>";
          }
          //alert($list);
        })

        if ($print){

          $nama = (str.length > 26) ? str.substring(0, 25)+" ..." : str;
          if($(this).data("for") != "parrent"){
            $html = $html+"<tr><td class='inSearch' data-for='child' data-nama='"+str+"'>"+$(this).text()+"</td> <td>"+$nama+"</td></tr>";
          }
        }        

        //alert("okee");
      })

      if($falsed){
        errList = '<span style="font-size: 8pt; font-weight: 600;">-- Penambahan Detail Berhasil. Namun,..</span>'+
              '<span style="font-size: 8pt; font-weight: 400;"><br/>'+
                'Beberapa ID Akun Yang Masuk Kedalam Pilihan Anda Sudah Anda Pilih Sebelumnya. Akun-Akun Teresebut Adalah :'+

                '<ul id="list" style="margin-top: 10px;margin-bottom: 10px;">'+$list+'</ul>'+
                'Sehingga Data-Data Akun Tersebut Tidak Kami Tambahkan Ulang.'+
              '</span>';

        //alert("Ups. Data.");
      }else{
        errList = '<span style="font-size: 8pt; font-weight: 600;">-- Berhasil Ditambahkan</span>';
        //$("#modal_detail").modal("hide");
      }

      $("#detail-in-show").prepend($html);
      $("#listErrWrap").html(errList);
      
    })

    $("#simpan").click(function(event){
      event.stopImmediatePropagation();
      if($dataNeraca.length == 0){
        alert("Tidak Ada Data Dalam Desain Neraca");
      }else{
        $comp = confirm("Apa Anda Sudah Yakin ?");

        if($comp){
          $.ajax(baseUrl+"/master_keuangan/desain_neraca/save",{
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

  })

  function createNode(parent_node, new_node_id, new_node_text, position, keterangan, state = false, type = "default") {
    //alert("okee");
    $('#jstree1').jstree('create_node', parent_node, { "text":keterangan, "type": type, "id":new_node_id , "data":{"id": new_node_text, "id_parrent":parent_node}, state: {"opened": state}}, position, false, false); 
  }

  function form_reset(){
    $("#level").val(1); $("#level").removeAttr("disabled");
    $("#parrent_id").val("null"); $("#parrent_id").attr("disabled", "disabled");
    $("#parrent_id_view").val("---");
    $("#level_view").val("1");
    $("#no_id").val("0"+$lvl1);$("#no_id").removeAttr("disabled");
    $("#jenis").val(1); $("#jenis").removeAttr("disabled");
    $("#keterangan").val(""); $("#keterangan").removeAttr("disabled");
    $("#detail-in-show").html("");
    $("#btn_detail").attr("disabled", "disabled");
  }