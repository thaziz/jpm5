<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class desain_neraca_detail extends Model
{
    protected $table = "desain_neraca_dt";
    protected $primaryKey = ["id_desain", "nomor_id"];
    public $timestamps = false;

    public $fillable = ["id_desain", "nomor_id", "keterangan", "id_parrent", "level", "jenis", "type"];
}
