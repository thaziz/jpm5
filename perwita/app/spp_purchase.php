<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spp_purchase extends Model
{
    protected $table = 'spp';
    protected $primaryKey = 'spp_id';
    protected $fillable = array('spp_id', 'spp_nospp', 'spp_cabang', 'spp_keperluan', 'spp_bagian', 'spp_tgldibutuhkan', 'spp_lokasigudang');
	public $incrementing = false;

	

	//public $dateFormat = 'Y-m-d H:i:s+';


	public function many()
	{
		return $this->hasMany(sppdt_purchase::class, 'spp_id');
	}

	public function belongs()
	{
		return $this->belongsTo(master_department::class, 'kode_department');
	}

}
