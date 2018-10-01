<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_arus_kas_detail_dt extends Model
{
    protected $table = "desain_arus_kas_detail_dt";
    protected $primaryKey = ["id_parrent", "id_group", "id_desain"];
    public $incrementing = false;
    public $timestamps = false;

    public function akun(){
    	return $this->hasMany('App\master_akun', 'main_id', 'id_group');
    }
}
