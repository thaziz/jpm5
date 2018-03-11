<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_mem_comp extends Model
{
    protected $table = 'd_mem_comp';
    protected $primarykey = ['mc_mem', 'mc_comp'];
    CONST CREATED_AT = 'mc_insert';
    CONST UPDATED_AT = 'mc_update';
    public $incrementing = false;

    protected $fillable = ['mc_active', 'mc_step'];
}
