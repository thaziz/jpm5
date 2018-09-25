<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_neraca_detail extends Model
{
    protected $table = "desain_neraca_dt";
    protected $primaryKey = ["id_desain", "nomor_id"];
    public $incrementing = false;
    public $timestamps = false;

    public $fillable = ["id_desain", "nomor_id", "keterangan", "id_parrent", "level", "jenis", "type"];

    public function detail(){
    	return $this->hasMany('App\desain_neraca_detail_dt', 'id_parrent', 'nomor_id');
    }
}
