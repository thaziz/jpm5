<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_kota extends Model
{
    protected $table = 'kota';
    protected $primaryKey = 'id';
  //	protected $fillable = array('kode','nama','alamat','telepon','fax','umr');
    public $timestamps = false;
    public $incrementing = false;

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

}
