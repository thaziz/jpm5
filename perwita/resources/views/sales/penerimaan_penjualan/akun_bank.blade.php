<select class="form-control chosen-select-width cb_akun_h" id="cb_akun_h" name="cb_akun_h" >
    <option value="0">Pilih - Akun Bank</option>
    @foreach($akun as $val)
    <option value="{{$val->mb_kode}}">{{$val->mb_kode}} - {{$val->mb_nama}}</option>
    @endforeach
</select>