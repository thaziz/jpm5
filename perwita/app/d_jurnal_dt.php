<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_jurnal_dt extends Model
{
    protected $table = 'd_jurnal_dt';
    protected $primaryKey = ['jrdt_jurnal', 'jrdt_detailid'];
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['jrdt_jurnal','jrdt_detailid', 'jrdt_acc', 'jrdt_value','jrdt_type','jrdt_detail','jrdt_statusdk'];

    public function akun(){
    	return $this->belongsTo("App\master_akun", "jrdt_acc", "id_akun");
    }

}
