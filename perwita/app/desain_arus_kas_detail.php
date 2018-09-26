<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_arus_kas_detail extends Model
{
    protected $table = "desain_arus_kas_dt";
    protected $primaryKey = ["id_desain", "nomor_id"];
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = ["id_desain", "nomor_id", "keterangan", "id_parrent", "level", "jenis", "type"];

    public function detail(){
    	return $this->hasMany('App\desain_arus_kas_detail_dt', 'id_parrent', 'nomor_id');
    }
}
