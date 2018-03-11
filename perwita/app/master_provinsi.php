<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_provinsi extends Model
{
    protected $table = 'provinsi';
    protected $primaryKey = 'id';
  	protected $fillable = array('id','nama');
    public $timestamps = false;
    public $incrementing = false;

    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

}
