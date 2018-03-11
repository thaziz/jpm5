<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class co_purchase extends Model
{
    protected $table = 'confirm_order';
    protected $primaryKey = 'co_idspp';
    protected $fillable = array('co_id', 'co_noco', 'co_idspp', 'mng_umum_approved', 'time_mng_umum_approved', 'co_staffpemb_approved','co_time_staffpemb_approved','co_mng_pem_approved', 'co_time_mng_pem_approved');
	public $incrementing = false;

}
