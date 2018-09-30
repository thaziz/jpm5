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
                        {{$val->bp_nota}}
                        <input type="hidden" class="kwitansi_modal" name="" value="{{$val->bp_nota}}">
                    </td>
                    <td class="tanggal">{{$val->bp_tanggal_pengembalian}}</td>
                    <td align="right">{{number_format($val->bp_total_pengembalian, 2, ",", ".")}}</td>
                    <td align="center">
                        <input class="tanda" type="checkbox"  name="tanda">
                    </td>
                </tr>
            @endforeach
    </tbody>
</table>
<script type="text/javascript">
var table_modal_d = $('#table_data_d').DataTable({
    ordering:false,
});


$('.append').click(function(){

    var cabang = $('.cabang').val();
    var cb_jenis_pembayaran = $('.cb_jenis_pembayaran').val();
    var nomor = [];
    var tanggal = [];
    var ed_tanggal = $('.ed_tanggal').val();
    if (cb_jenis_pembayaran == 'BN'){
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
                            data.data[i].bp_nota+'<input type="hidden" value="'+data.data[i].bp_nota+'" class="form-control d_nomor_kwitansi" name="d_nomor_kwitansi[]">',

                            data.data[i].nama+'<input type="hidden" value="'+data.data[i].kode+'" class="form-control d_customer" name="d_customer[]">'+
                            '<input type="hidden" value="BONSEM" class="form-control d_kode_akun" name="d_kode_akun[]">',

                            accounting.formatMoney(data.data[i].bp_total_pengembalian,"",2,'.',',')+'<input type="hidden" value="'+data.data[i].bp_total_pengembalian+'" class="form-control d_netto" name="d_netto[]">',
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

    }
    $('#modal').modal('hide');
})
</script>