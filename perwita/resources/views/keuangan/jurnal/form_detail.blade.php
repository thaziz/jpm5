<div class="col-md-6">
  <table id="table_form" width="100%" border="0">
    <tbody>
      <tr>
        <td colspan="3" class="text-center" style="vertical-align: middle;padding: 5px; background: #eee;"><button class="btn btn-success btn-xs add_row pull-left" data-table="debet"><i class="fa fa-plus"></i></button> &nbsp;Debet</td>
      </tr>
      
      @foreach($detail as $dataDetail1)
        @if($dataDetail1->trdt_accstatusdk == "D")
          <tr>
            <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-left" width="45%">
              <select name="nama_akun_debet[]" style="width:90%">
                @foreach($akun as $dataAkun)
                  <?php $able = ($dataAkun->id_akun == $dataDetail1->trdt_acc) ? "selected" : ""; ?>
                  <option value="{{ $dataAkun->id_akun }}" {{ $able }}>{{ $dataAkun->nama_akun }}</option>
                @endforeach
              </select>
            </td>
            <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="45%"><input type="text" name="debet[]" value="0" class="currency debet" style="width: 90%"></td>
            <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="10%">
              <button class="btn btn-danger btn-xs delete_row"><i class="fa fa-eraser"></i></button></td>
          </tr>
        @endif
      @endforeach
    </tbody>

    <tfoot>
      <tr>
        <td style="border-bottom: 1px solid #eee;padding: 5px;vertical-align: middle;" class="text-center" width="45%">
          Total Debet
        </td>
        <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="45%"><input type="text" value="0" class="currency" id="total_debet" name="total_debet" style="width: 90%" readonly></td>
        <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="10%"></td>
      </tr>
    </tfoot>
  </table>
</div>

<div class="col-md-6">
  <table id="table_form" width="100%" border="0">
    <tbody>
      <tr>
        <td colspan="3" class="text-center" style="vertical-align: middle;padding: 5px; background: #eee;"><button class="btn btn-success btn-xs add_row pull-left" data-table="kredit"><i class="fa fa-plus"></i></button> &nbsp;Kredit</td>
      </tr>
      
      @foreach($detail as $dataDetail1)
        @if($dataDetail1->trdt_accstatusdk == "K")
          <tr>
            <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-left" width="45%">
              <select name="nama_akun_kredit[]" style="width:90%">
                @foreach($akun as $dataAkun)
                  <?php $able = ($dataAkun->id_akun == $dataDetail1->trdt_acc) ? "selected" : ""; ?>
                  <option value="{{ $dataAkun->id_akun }}" {{ $able }}>{{ $dataAkun->nama_akun }}</option>
                @endforeach
              </select>
            </td>
            <td id="inputmask" style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="45%"><input type="text" name="kredit[]" value="0" class="currency kredit" style="width: 90%"></td>
            <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="10%">
              <button class="btn btn-danger btn-xs delete_row"><i class="fa fa-eraser"></i></button></td>
          </tr>
        @endif
      @endforeach
    </tbody>

    <tfoot>
      <tr>
        <td style="border-bottom: 1px solid #eee;padding: 5px;vertical-align: middle;" class="text-center" width="45%">
          Total Kredit
        </td>
        <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="45%"><input type="text" value="0" name="total_kredit" class="currency" id="total_kredit" style="width: 90%" readonly></td>
        <td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="10%"></td>
      </tr>
    </tfoot>
  </table>
  
  <select style="width:90%;display: none;" id="akun_hidden">
    @foreach($akun as $dataAkun)
      <option value="{{ $dataAkun->id_akun }}">{{ $dataAkun->nama_akun }}</option>
    @endforeach
  </select>

</div>

<script>
  $(document).ready(function(){

    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: 'Rp ', //Space after $, this will not truncate the first character.
          rightAlign: false,
          oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc()

    $("table").on("click", ".delete_row", function(){
      $(this).parents("tr").remove();
    })

    $("table").on("keyup", ".debet", function(){
      $total = 0;
      $(".debet").each(function(){
        $value = $(this).val()
        $nilai = $value.split(",")[0].replace(/\./g,"").substring(3)

        //alert($nilai)
        $total += parseInt($nilai)
      })

      //alert($total)
      $("#total_debet").val($total);
    })

    $("table").on("keyup", ".kredit", function(){
      $total = 0;
      $(".kredit").each(function(){
        $value = $(this).val()
        $nilai = $value.split(",")[0].replace(/\./g,"").substring(3)

        //alert($nilai)
        $total += parseInt($nilai)
      })

      //alert($total)
      $("#total_kredit").val($total);
    })

    $(".add_row").click(function(){
      $print = '<tr>'+
                '<td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-left" width="45%">'+
                  '<select name="nama_akun_'+$(this).data("table")+'[]" style="width:90%">'
                    +$("#akun_hidden").html()+
                  '</select>'+
                '<td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="45%">'+
                  '<input type="text" name="'+$(this).data("table")+'[]" value="0" class="currency '+$(this).data("table")+'" style="width: 90%">'+
                '</td>'+
                '<td style="border-bottom: 1px solid #eee;padding: 5px;" class="text-center" width="10%">'+
                  '<button class="btn btn-danger btn-xs delete_row"><i class="fa fa-eraser"></i></button>'+
                  '</td>'+
              '</tr>';

      $(this).parents("tbody").append($print);
      $(this).maskFunc()

      return false
    })
  })
</script>