<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_comp_year extends Model
{
    protected $table = 'd_comp_year';
    protected $primaryKey = ['y_comp', 'y_year'];
    public $timestamps = false;
    public $incrementing = false;
}
