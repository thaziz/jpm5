<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_department extends Model
{
    protected $table = 'masterdepartment';
    protected $primaryKey = 'kode_department';
    protected $fillable = array('kode_department','nama_department');
	public $incrementing = false;

	public function one()
	{
		return $this->hasOne(spp_purchase::class, 'spp_bagian');
	}

}
