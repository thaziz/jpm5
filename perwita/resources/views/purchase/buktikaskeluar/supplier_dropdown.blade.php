<select class="form-control supplier_faktur chosen-select-width1" name="supplier_faktur">
  <option value="0">Pilih - Supplier</option>
  @foreach($all as $i)
  <option value="{{ $i->kode }}">{{ $i->kode }} - {{ $i->nama }}</option>
  @endforeach
</select>

<script>
	var config1 = {
                '.chosen-select'           : {},
                '.chosen-select-deselect'  : {allow_single_deselect:true},
                '.chosen-select-no-single' : {disable_search_threshold:10},
                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                '.chosen-select-width1'     : {width:"100%",search_contains:true}
                }
    for (var selector in config1) {
        $(selector).chosen(config1[selector]);
    }

    $('.supplier_faktur').change(function(){
      var supplier = $(this).val();
      $.ajax({
          url:baseUrl + '/buktikaskeluar/cari_hutang',
          type:'get',
          data:{supplier},
          dataType:'json',
          success:function(data){
            $('.hutang').val(data.data.acc_hutang);
          },
          error:function(data){
          }
      }); 
    })
</script>