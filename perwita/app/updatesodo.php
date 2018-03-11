<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class updatesodo extends Model{

   
    protected $table = 'u_s_order_do';  
     public $incrementing = false;
    public $remember_token = false;
    protected $fillable = ['no_do','status','catatan','id','nama','created_at','updated_at'];


}
