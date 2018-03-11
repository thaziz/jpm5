<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mastertb_vhc extends Model
{
    protected $table = 'tb_vhc';
    protected $primaryKey = 'id_vhc';
    protected $fillable = array('id_vhc', 'vhccde' , 'brncde' , 'divisi' , 'sts' , 'vdrcde' , 'vdrnme' , 'kode' , 'merk' , 'tipe' , 'no_rangka' , 'no_mesin' , 'jenis_bak' , 'p' , 'l' , 't' , 'volume' , 'tahun' , 'seri_unit' , 'warna_kabin' , 'no_bpkb' , 'tgl_bpkb', 'no_kir' , 'tgl_kir' , 'tgl_pjk' , 'tgl_stnk' , 'gps' , 'posisi_bpkb' , 'ket_bpkb' , 'asuransi' , 'harga' , 'tgl_perolehan', 'note' , 'act' , 'id_user' , 'id_agen' , 'uid' , 'dlu');
    public $timestamps = false;
    public $incrementing = false;


}
