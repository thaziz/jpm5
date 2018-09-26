<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_arus_kas extends Model
{
    protected $table = "desain_arus_kas";
    protected $primaryKey = "id_desain";
    CONST CREATED_AT = "tanggal_buat";
    CONST UPDATED_AT = "tanggal_update";

    public $fillable = ["id_desain", "tanggal_buat", "tanggal_update", "is_active"];

    public function detail(){
    	return $this->hasMany('App\desain_arus_kas_detail', 'id_desain', 'id_desain');
    }
}
