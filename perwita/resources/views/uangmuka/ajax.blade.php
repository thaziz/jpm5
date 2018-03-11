 <div class="col-sm-3 col-sm-offset-2">
                          <label>Supplier ID :</label>
                        <select class="form-control  suppilerid d" id="suppilerid" name="supplier">
                                     <option value="" selected="" disabled="">--Pilih Terlebih dahulu--</option>
                                     @foreach($data as $a)
                                     <option value="{{$a->no_supplier}}" data-nama='{{$a->nama_supplier}}'>{{$a->no_supplier}}</option>
                                     @endforeach
                        </select>                        
 </div>
 <div class="col-sm-5 ">
                         <label>Supplier Nama :</label>
                           <input type="text" class="form-control suppilername" readonly="" style="text-transform: uppercase">
                        </div>
                        <div><input type="hidden" name="jenissub" value="{{ $supli }}"></div>

 <script type="text/javascript">
   $("#suppilerid").change(function(){
        var abc = $(this).find(':selected').data('nama');
        var def = $('.suppilername').val(abc);
    })
   $('#suppilerid').chosen({});

 </script>