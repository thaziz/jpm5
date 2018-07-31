<table id="table" width="100%" class="table table-bordered tabel-list no-margin" style="padding:0px; font-size: 8pt;">
  <thead>
    <tr>
      <th width="20%" class="text-center">No Referensi</th>
      <th width="20%" class="text-center">Tanggal</th>
      <th class="text-center">Jurnal Detail</th>
      {{-- <th style="padding:8px 0px" class="text-center">Saldo</th> --}}
    </tr>
  </thead>
  <tbody  class="searchable">

    @foreach($data as $data_trans)
      <tr>
        <td class="clickable-list" style="background: white; cursor: pointer;" data-id="{{ $data_trans->jr_id }}">{{ $data_trans->jr_ref }}</td>
        <td style="background: white">{{ $data_trans->jr_date }}</td>
        <td style="background: white">{{ $data_trans->jr_detail }}</td>
      </tr>
    @endforeach
    
  </tbody>
</table>

<script type="text/javascript">
  tableDetail = $('.tabel-list').DataTable({
          responsive: true,
          searching: true,
          sorting: true,
          paging: true,
          //"pageLength": 10,
          "language": dataTableLanguage,
    });

  $("#cab_list_name").text("{{ $cab_nama }}");
  var detail_trans = {!! $data_json !!};

  $('.tabel-list').on('click', 'td.clickable-list', function(evt){
      evt.preventDefault();
      form_reset();
      var ids = detail_trans.findIndex(i => i.jr_id == $(this).data('id')); var html_detail = '';
      
      $('#jenis_transaksi').val((detail_trans[ids].jr_no.substr(0, 2) == "KM") ? "1" : "2");
      $("#cabang").val(detail_trans[ids].jr_no.substr(8, 3));
      $('#akun_transaksi').val(detail_trans[ids].detail[0].jrdt_acc);
      $('#jr_detail').val(detail_trans[ids].jr_detail);
      $('#jr_note').val(detail_trans[ids].jr_note);
      $('#info-referensi').fadeIn(200);
      $('#info-referensi input').val(detail_trans[ids].jr_ref);

      if(detail_trans[ids].detail[0].jrdt_statusdk == 'D')
        $("#coa_1 input.debet").val(detail_trans[ids].detail[0].jrdt_value.replace('-', ''));
      else
         $("#coa_1 input.kredit").val(detail_trans[ids].detail[0].jrdt_value.replace('-', ''));

       $.each(detail_trans[ids].detail, function(i, n){
          if(i != 0){
            if(n.jrdt_statusdk == "D"){
              var html_detail = '<tr id="coa_'+(i + 1)+'" data-id="'+(i+1)+'" class="akun_lawan_wrap">'+
                      '<td class="name">'+n.jrdt_acc+' - '+n.akun.nama_akun+'</td>'+
                      '<td class="text-right currency">'+
                        '<input class="form-control currency debet" name="debet[]" value="'+n.jrdt_value.replace('-', '')+'" data-id="'+(i+1)+'" disabled>'+
                      '</td>'+
                      '<td class="text-right currency">'+
                        '<input class="form-control currency kredit" name="kredit[]" value="0" data-id="'+(i+1)+'" disabled>'+
                      '</td>'+
                    '</tr>';
            }else{
              var html_detail = '<tr id="coa_'+(i + 1)+'" data-id="'+(i+1)+'" class="akun_lawan_wrap">'+
                      '<td class="name">'+n.jrdt_acc+' - '+n.akun.nama_akun+'</td>'+
                      '<td class="text-right currency">'+
                        '<input class="form-control currency debet" name="debet[]" value="0" data-id="'+(i+1)+'" disabled>'+
                      '</td>'+
                      '<td class="text-right currency">'+
                        '<input class="form-control currency kredit" name="kredit[]" value="'+n.jrdt_value.replace('-', '')+'" data-id="'+(i+1)+'" disabled>'+
                      '</td>'+
                    '</tr>';
            }

            $("#coa_detail").append(html_detail);
            $(this).maskFunc();
          }
       })

       initiate_total();
      $(".list-should-disabled").attr('disabled', 'disabled');
      $('.chosen-select#akun_transaksi').trigger("chosen:updated");
      $('.chosen-select#akun_lawan').trigger("chosen:updated");
      $('.chosen-select#cabang').trigger("chosen:updated");

      $('#modal_list_transaksi').modal('toggle');
      // alert(detail_trans[ids].detail[0].jrdt_acc);
    })

  function initiate_total(){
    var total = 0;
      $(".debet").each(function(idx){
       var num = $(this).val().replace(/\./g, '').split(',')[0];
       total += parseInt(num);
      })

      $("input.total_debet").val(total);

      total = 0;
      $(".kredit").each(function(idx){
       var num = $(this).val().replace(/\./g, '').split(',')[0];
       total += parseInt(num);
      })

      $("input.total_kredit").val(total);
  }

  function form_reset(){
      $(".form_validate").each(function(){
        $(this).val("");
      })

      $(".select_validate").each(function(){
          $(this).val($(this).children('option').first().attr('value'));
      })

      $(".akun_lawan_wrap").remove();
      $("#coa_1 input").val(0);

      $(".total_debet").val(0); 
      $(".total_kredit").val(0)

      $("#list-reset").fadeIn(200);

      // $('#kode_cabang').trigger("chosen:updated");
      // $('#group_neraca').trigger("chosen:updated");
    }
</script>