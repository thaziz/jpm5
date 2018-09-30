<table id="table_data_d" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Kode Transaksi</th>
            <th>Tanggal</th>
            <th style="width:20%">Jumlah</th>
            <th><input type="checkbox" onchange="check_parent()" class="parent_box" name=""></th>
        </tr>
        </thead>
    <tbody>
            @foreach ($data as $i=> $val)
                <tr>
                    <td>
                        {{$val->k_nomor}}
                        <input type="hidden" class="kwitansi_modal" name="" value="{{$val->k_nomor}}">
                    </td>
                    <td class="tanggal">{{$val->k_tanggal}}</td>
                    <td align="right">{{number_format($val->k_netto, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
            @endforeach
    </tbody>
</table>
<script type="text/javascript">
var table_modal_d = $('#table_data_d').DataTable({
    ordering:false
});




$('.append').click(function(){

    var cabang = $('.cabang').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var nomor = [];
    var tanggal = [];
    var ed_tanggal = $('.ed_tanggal').val();
    if (cb_jenis_pembayaran == 'C'|| cb_jenis_pembayaran == 'F' || cb_jenis_pembayaran == 'B' || cb_jenis_pembayaran == 'T') {
        table_modal_d.$('.tanda').each(function(){
            var check = $(this).is(':checked');
            if (check == true) {
                var par   = $(this).parents('tr');
                var inv   = $(par).find('.kwitansi_modal').val();
                var tgl   = $(par).find('.tanggal').text();
                nomor.push(inv);
                tanggal.push(tgl);
                array_simpan.push(inv);

            }  
        })

        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/append',
            data : {nomor,cabang,nomor,cb_jenis_pembayaran,tanggal,ed_tanggal},
            dataType:'json',
            success:function(data){
                if (data.status == '1') {
                    for (var i = 0; i < data.data.length; i++) {
                        if (cb_jenis_pembayaran == 'F') {
                            var cek = '<input type="text" value="" class="form-control d_cek" name="d_cek[]">';
                        }else{
                            var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';

                        }
                        table_data.row.add([
                            data.data[i].k_nomor+'<input type="hidden" value="'+data.data[i].k_nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                            data.data[i].nama+'<input type="hidden" value="'+data.data[i].k_kode_customer+'" class="form-control d_customer" name="d_customer[]">'+
                            '<input type="hidden" value="'+data.data[i].k_kode_akun+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                            accounting.formatMoney(data.data[i].k_netto,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].k_netto+'" class="form-control d_netto" name="d_netto[]">',
                            cek,

                            '<input type="text" class="form-control d_keterangan" placeholder="keterangan..." name="d_keterangan[]">',

                            '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                        ]).draw();
                    }
                    $('#modal').modal('hide');
                    hitung();
                    $('.cb_jenis_pembayaran').addClass('disabled');
                    $('.cabang_td').addClass('disabled');
                    $('.tanggal_td').addClass('disabled');
                    $('.bank_tr').addClass('disabled');
                    $('.tanggal_td').addClass('disabled');
                }else if(data.status == '0'){
                    return toastr.warning('Tanggal Kwitansi Tidak Boleh Melebihi Tanggal Posting');
                    $('#modal').modal('hide');
                }
            }
        })

    }else if (cb_jenis_pembayaran == 'U'){
        table_modal_d.$('.tanda').each(function(){
            var check = $(this).is(':checked');
            if (check == true) {
                var par   = $(this).parents('tr');
                var inv   = $(par).find('.kwitansi_modal').val();
                nomor.push(inv);
                array_simpan.push(inv);

            }  
        })

        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/append',
            data : {nomor,cabang,nomor,cb_jenis_pembayaran},
            dataType:'json',
            success:function(data){
                for (var i = 0; i < data.data.length; i++) {

         
                    var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';


                    table_data.row.add([
                        data.data[i].nomor+'<input type="hidden" value="'+data.data[i].nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                        data.data[i].nama+'<input type="hidden" value="'+data.data[i].nama+'" class="form-control d_customer" name="d_customer[]">'+
                        '<input type="hidden" value="'+data.data[i].kode_acc+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                        accounting.formatMoney(data.data[i].jumlah,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].jumlah+'" class="form-control d_netto" name="d_netto[]">',
                        cek,
                        '<input type="text" class="form-control d_keterangan" placholder="keterangan..." name="d_keterangan[]">',

                        '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                    ]).draw();
                }
                $('#modal').modal('hide');
                hitung();
                $('.cb_jenis_pembayaran').addClass('disabled');
                $('.cabang_td').addClass('disabled');
                $('.tanggal_td').addClass('disabled');
                $('.bank_tr').addClass('disabled');
            }
        })
    }else if (cb_jenis_pembayaran == 'BN'){
        table_modal_d.$('.tanda').each(function(){
            var check = $(this).is(':checked');
            if (check == true) {
                var par   = $(this).parents('tr');
                var inv   = $(par).find('.kwitansi_modal').val();
                var tgl   = $(par).find('.tanggal').text();
                nomor.push(inv);
                tanggal.push(tgl);
                array_simpan.push(inv);

            }  
        })
        $.ajax({
            url  :baseUrl+'/sales/posting_pembayaran_form/append',
            data : {nomor,cabang,nomor,cb_jenis_pembayaran,tanggal,ed_tanggal},
            dataType:'json',
            success:function(data){
                if (data.status == '1') {
                    for (var i = 0; i < data.data.length; i++) {
                        if (cb_jenis_pembayaran == 'F') {
                            var cek = '<input type="text" value="" class="form-control d_cek" name="d_cek[]">';
                        }else{
                            var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';

                        }
                        table_data.row.add([
                            data.data[i].k_nomor+'<input type="hidden" value="'+data.data[i].k_nomor+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                            data.data[i].nama+'<input type="hidden" value="'+data.data[i].k_kode_customer+'" class="form-control d_customer" name="d_customer[]">'+
                            '<input type="hidden" value="'+data.data[i].k_kode_akun+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                            accounting.formatMoney(data.data[i].k_netto,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].k_netto+'" class="form-control d_netto" name="d_netto[]">',
                            cek,

                            '<input type="text" class="form-control d_keterangan" placeholder="keterangan..." name="d_keterangan[]">',

                            '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                        ]).draw();
                    }
                    $('#modal').modal('hide');
                    hitung();
                    $('.cb_jenis_pembayaran').addClass('disabled');
                    $('.cabang_td').addClass('disabled');
                    $('.tanggal_td').addClass('disabled');
                    $('.bank_tr').addClass('disabled');
                    $('.tanggal_td').addClass('disabled');
                }else if(data.status == '0'){
                    return toastr.warning('Tanggal Kwitansi Tidak Boleh Melebihi Tanggal Posting');
                    $('#modal').modal('hide');
                }
            }
        })

    }else{
     var m_akun_kas       = $('.m_akun_kas').val();
     var m_akun_kas_text  = $('.m_akun_kas option:selected').text();
     var m_jumlah_kas     = $('.m_jumlah_kas').val();
     var m_keterangan_kas = $('.m_keterangan_kas').val();
     m_jumlah_kas         = m_jumlah_kas.replace(/[^0-9\-]+/g,"");

     var m_keterangan_kas = $('.m_keterangan_kas').val();
                var cek = '<input readonly type="text" value="" class="form-control d_cek" name="d_cek[]">';

                table_data.row.add([
                    m_akun_kas_text+'<input type="hidden" value="NON KWITANSI" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                    'NON CUSTOMER'+'<input type="hidden" value="'+'NON CUSTOMER'+'" class="form-control d_customer" name="d_customer[]">'+
                    '<input type="hidden" value="'+m_akun_kas+'" class="form-control d_kode_akun" name="d_kode_akun[]">',

                    accounting.formatMoney(m_jumlah_kas,"",2,'.',',')+'<input type="hidden" value="'+m_jumlah_kas+'" class="form-control d_netto" name="d_netto[]">',
                    cek,

                    '<input type="text" class="form-control d_keterangan" value="'+m_keterangan_kas+'"  placholder="keterangan..." name="d_keterangan[]">',

                    '<button type="button" onclick="hapus_detail(this)" class="btn btn-danger hapus btn-sm" title="hapus"><i class="fa fa-trash"><i></button>',
                ]).draw();
                $('#modal_kas').modal('hide');
                hitung();
                $('.cb_jenis_pembayaran').addClass('disabled');
                $('.cabang_td').addClass('disabled');
                $('.bank_tr').addClass('disabled');
                $('.tanggal_td').addClass('disabled');
    }
    $('#modal').modal('hide');
})
</script>