<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem_log extends Model
{
    protected $table = 'd_mem_log';
    protected $primaryKey = 'l_id';
    public $incrementing = false;
    public $timestamps = false;
}
