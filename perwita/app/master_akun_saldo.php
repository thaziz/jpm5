<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class master_akun_saldo extends Model
{
    protected $table = "d_akun_saldo";
    protected $primaryKey = ["id_akun", "tahun"];
    public $incrementing = false;
    CONST CREATED_AT = "tanggal_dibuat";
    CONST UPDATED_AT = "terakhir_diupdate";

    protected $fillable = ["id_akun", "tahun", "saldo_akun", "is_active"]; 

    public function akun(){
    	return $this->belongsTo("App\master_akun", "id_akun", "id_akun");
    }
}
