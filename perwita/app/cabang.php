<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cabang extends Model
{
    protected $table = 'cabang';
    protected $primaryKey = 'kode';
  	
	public $incrementing = false;
}
