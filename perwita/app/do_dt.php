<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class do_dt extends Model
{
    protected $table = 'delivery_order_dt';
    protected $primaryKey = 'id_do';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['do_dt','id_do_dt', 'berat', 'jenis'];
}
