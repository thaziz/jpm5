
@if($flag == 'AGEN')
<select name="nama_kontak2" class="form-control agen_vendor  chosen-select-width1" style="text-align: center;">
 	<option data-acc_penjualan="0" data-csf_penjualan="0" value="0">- Pilih - Agen/Vendor -</option>
 	@foreach($data as $val)
 	<option @if($val->kode == $agen) selected @endif data-acc_penjualan="{{$val->acc_hutang}}" data-csf_penjualan="{{$val->csf_hutang}}" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
 	@endforeach
</select>
@else
<select name="nama_kontak2" class="form-control agen_vendor chosen-select-width1" style="text-align: center;">
 	<option data-acc_penjualan="0" data-csf_penjualan="0" value="0">- Pilih - Agen/Vendor -</option>
 	@foreach($data as $val)
 	<option @if($val->kode == $agen) selected @endif data-acc_penjualan="{{$val->acc_hutang}}" data-csf_penjualan="{{$val->csf_hutang}}" value="{{$val->kode}}">{{$val->kode}} - {{$val->nama}}</option>
 	@endforeach
</select>
@endif
@if($flag1 == "E")
<input type="hidden" name="acc_penjualan_penerus" value="{{$acc}}" class="acc_penjualan_penerus" >
<input type="hidden" name="csf_penjualan_penerus" value="{{$acc}}" class="csf_penjualan_penerus">
@else
<input type="hidden" name="acc_penjualan_penerus" value="" class="acc_penjualan_penerus" >
<input type="hidden" name="csf_penjualan_penerus" value="" class="csf_penjualan_penerus">
@endif
<script>
	var config1 = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"}
                 }
                 for (var selector in config1) {
                   $(selector).chosen(config1[selector]);
                 }

    $('.agen_vendor').change(function(){
    	var acc = $('.agen_vendor').find(':selected').data('acc_penjualan');
    	var csf = $('.agen_vendor').find(':selected').data('csf_penjualan');

    	$('.acc_penjualan_penerus').val(acc);
    	$('.csf_penjualan_penerus').val(csf);
    })

</script>