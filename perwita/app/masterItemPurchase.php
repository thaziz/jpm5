<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterItemPurchase extends Model
{
    protected $table = 'masteritem';
    protected $primaryKey = 'kode_item';
    protected $fillable = array('kode_item','nama_masteritem', 'minstock' ,'groupitem','updatestock','acc_persediaan','acc_hpp', 'foto', 'comp_id' , 'harga', 'jenisitem', 'unit1', 'unit2', 'unit3', 'unit4', 'konversi2' , 'konversi3', 'konversi4' , 'posisilantai' , 'posisiruang' , 'posisirak' , 'posisikolom','kode_akun');
 
public $incrementing = false;

}
