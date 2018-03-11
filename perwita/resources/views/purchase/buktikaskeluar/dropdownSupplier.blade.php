


<select class="kode_supplier form-control chosen-select-width6" onchange="supplier();" name="nama_supplier" style="width: 100%; display: inline-block;">
    <option value="- kode -">- kode -</option>
    @foreach($data as $val)
    <option value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
    @endforeach
</select> 



    <script type="text/javascript">
    	var config6 = {
               '.chosen-select'           : {},
               '.chosen-select-deselect'  : {allow_single_deselect:true},
               '.chosen-select-no-single' : {disable_search_threshold:10},
               '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
               '.chosen-select-width6'     : {width:"100% !important"}
             }
              for (var selector in config6) {
               $(selector).chosen(config6[selector]);
              } 
    </script>