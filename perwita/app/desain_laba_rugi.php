<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_laba_rugi extends Model
{
    protected $table = "desain_laba_rugi";
    protected $primaryKey = "id_desain";
    CONST CREATED_AT = "tanggal_buat";
    CONST UPDATED_AT = "tanggal_update";

    public $fillable = ["id_desain", "tanggal_buat", "tanggal_update", "is_active"];
}
