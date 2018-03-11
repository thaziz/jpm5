<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp_coa extends Model
{
    protected $table = 'd_comp_coa';
    protected $primaryKey = ['coa_comp','coa_year','coa_code'];
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
                
     protected $fillable = ['coa_comp','coa_year', 'coa_code', 'coa_name', 'coa_isparent','coa_isactive','coa_opening_tgl','coa_default'];
}
