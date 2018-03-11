<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_laba_rugi_dt extends Model
{
    protected $table = "desain_laba_rugi_dt";
    protected $primaryKey = ["id_desain", "nomor_id"];
    public $timestamps = false;

    public $fillable = ["id_desain", "nomor_id", "keterangan", "id_parrent", "level", "jenis", "type"];
}
