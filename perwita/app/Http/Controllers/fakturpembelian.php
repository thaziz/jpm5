<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fakturpembelian extends Model
{
    protected $table = 'faktur_pembelian';
    protected $primaryKey = 'fp_idfaktur';
    protected $fillable = array('fp_idfaktur', 'fp_nofaktur','fp_tgl','fp_idsup' , 'fp_keterangan' , 'fp_noinvoice', 'fp_jatuhtempo', 'fp_jumlah' , 'fp_discount','fp_dpp','fp_biaya','fp_netto','fp_comp','fp_jenisbayar');
  
    public $incrementing = false;

}
