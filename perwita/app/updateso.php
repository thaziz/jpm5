<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class updateso extends Model{

   
    protected $table = 'u_s_order';   
    protected $primaryKey= 'u_o_nomor';
     public $incrementing = false;
    public $remember_token = false;
    protected $fillable = ['u_o_nomor','Status','catatan'];


}
