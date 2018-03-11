<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jenisbayar extends Model
{
    protected $table = 'jenisbayar';
    protected $primaryKey = 'idjenisbayar';
    protected $fillable = array('idjenisbayar','jenisbayar');
	public $incrementing = false;

	
}
