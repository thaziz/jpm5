<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_cabang extends Model
{
   
    protected $table = 'cabang';
    protected $primaryKey = 'cabang';
    protected $fillable = array('kode','nama','alamat','telepon','fax','idkota','version','create_by','create_at','update_by' , 'update_at');

    public $timestamps = false;

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

}
