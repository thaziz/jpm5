<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tandaterima extends Model
{
    protected $table = 'form_tt';
    protected $primaryKey = 'tt_idform';
    protected $fillable = array('tt_idform', 'tt_tgl', 'tt_idsupplier', 'tt_lainlain', 'tt_tglkembali', 'tt_totalterima' , 'tt_kwitansi', 'tt_fp' , 'tt_suratperan' , 'tt_suratjalanasli' , 'tt_noform');
	public $incrementing = false;

}
