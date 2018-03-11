<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kantorCabang extends Model
{
    protected $table = 'kantorCabang';
    protected $primaryKey = 'kode';
    protected $fillable = array('kode','nama','alamat','telepon','fax','umr');
    public $timestamps = false;


}
