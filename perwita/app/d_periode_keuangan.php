<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_periode_keuangan extends Model
{
    protected $table = "d_periode_keuangan";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ["bulan", "tahun", "status"];
}
