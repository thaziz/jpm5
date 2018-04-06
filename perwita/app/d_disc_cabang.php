<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_disc_cabang extends Model
{
    protected $table = 'd_disc_cabang';
    protected $primaryKey = 'dc_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['dc_cabang','dc_diskon', 'dc_id', 'dc_jenis', 'dc_kode', 'dc_note'];
}
