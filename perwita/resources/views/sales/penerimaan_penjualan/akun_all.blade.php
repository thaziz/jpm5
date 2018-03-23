<select class="form-control akun_lain chosen-select-width1">
    <option value="0">Pilih - Akun</option>


    @foreach($akun as $val)
    <option value="{{$val->id_akun}}" >{{$val->id_akun}} - {{$val->nama_akun}}</option>
    @endforeach
</select>

<script>
var config2 = {
                   '.chosen-select'           : {},
                   '.chosen-select-deselect'  : {allow_single_deselect:true},
                   '.chosen-select-no-single' : {disable_search_threshold:10},
                   '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                   '.chosen-select-width1'     : {width:"100%"}
              }
for (var selector in config2) {
    $(selector).chosen(config2[selector]);
}

// auto_biaya
$('.akun_lain').change(function(){
    var tes = $(this).val();
    $.ajax({
        url:baseUrl+'/sales/auto_biaya',
        data:{tes},
        dataType:'json',
        success:function(response){
            $('.m_debet').val(response.data.debet);
            $('.m_acc').val(response.data.id_akun);
            $('.m_csf').val(response.data.id_akun);
            $('.m_nama_akun').val(response.data.nama_akun);
            
            $('.me_debet').val(response.data.debet);
            $('.me_acc').val(response.data.id_akun);
            $('.me_csf').val(response.data.id_akun);
            $('.m_nama_akun').val(response.data.nama_akun);
        }
    });
})
</script>