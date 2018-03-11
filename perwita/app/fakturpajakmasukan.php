<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fakturpajakmasukan extends Model
{
    protected $table = 'fakturpajakmasukan';
    protected $primaryKey = 'fpm_id';
    protected $fillable = array('fpm_id', 'fpm_nota','fpm_tgl','fpm_masapajak','fpm_dpp','fpm_hasilppn','fpm_jenisppn','fpm_inputppn','fpm_netto');
  
    public $incrementing = false;

}
