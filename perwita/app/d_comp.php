<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp extends Model
{
    protected $table = 'd_comp';
    protected $primaryKey = 'c_id';
    CONST CREATED_AT = 'c_insert';
    CONST UPDATED_AT = 'c_update';
    public $incrementing = false;

    public function member(){
    	return $this->belongsToMany('App\d_mem', 'd_mem_comp', 'mc_comp', 'mc_mem');
    }

    public function year(){
    	return $this->belongsTo('App\d_comp_year', 'c_id', 'd_comp');
    }
}
