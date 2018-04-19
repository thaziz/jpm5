<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_golongan_aktiva extends Model
{
    protected $table = "d_golongan_aktiva";
    public $incrementing = false;

    CONST CREATED_AT = "tanggal_buat";
    CONST UPDATED_AT = "tanggal_update";

}
