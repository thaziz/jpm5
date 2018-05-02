<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_group_akun extends Model
{
    protected $table = "d_group_akun";
    protected $primaryKey = "id";
    public $incrementing = false;

    CONST CREATED_AT = "tanggal_buat";
    CONST UPDATED_AT = "tanggal_update";

    protected $fillable = ["id", "nama_group", "jenis_group"];
}
