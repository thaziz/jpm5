<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterbank extends Model
{
    protected $table = 'masterbank';
    protected $primaryKey = 'mb_id';
    protected $fillable = array('mb_namabank' , 'mb_cabang', 'mb_accno' , 'mb_csfno' , 'mb_alamat' , 'mb_seripajak', 'mb_seripajakawal', 'mb_seripajakakhir','mb_seribg' , 'mb_seribgawal' , 'mb_seribgakhir' , 'mb_tglbukucek' , 'mb_tglbukubg' , 'mb_kodebuktibank' , 'mb_mshaktif', 'mb_tgltdkaktif', 'mb_namarekenning' , 'mb_bka');
	public $incrementing = false;

	
}
