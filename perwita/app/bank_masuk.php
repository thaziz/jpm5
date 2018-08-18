<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank_masuk extends Model
{
    protected $table = 'bank_masuk';
    protected $primaryKey = 'bm_id';
    protected $fillable = array('bm_id', 'bm_bankasal','bm_cabangasal','bm_cabangtujuan','bm_banktujuan','bm_tglterima','bm_status');
  
    public $incrementing = false;

}
