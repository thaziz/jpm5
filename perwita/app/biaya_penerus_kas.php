<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class biaya_penerus_kas extends Model
{
    protected $table = 'biaya_penerus_kas';
    protected $primaryKey = 'bpk_id';
    protected $fillable = array('bpk_id',
							  	'bpk_nota',  	  	 
							  	'bpk_jenis_biaya', 	
							  	'bpk_pembiayaan',  	
							  	'bpk_total_tarif', 	
							  	'bpk_tanggal',    
							  	'bpk_nopol',		 
							  	'bpk_status',	  	
							  	'bpk_status_pending',
							  	'bpk_kode_akun',	
							  	'bpk_sopir',	
							  	'bpk_keterangan',
							  	'bpk_keterangan',
							  	'created_at',
							  	'bpk_comp',
							  	'bpk_tarif_penerus',
							  	'update_at',
							  	'bpk_edit',
							  	'bpk_tipe_angkutan',
							  	'bpk_biaya_lain',
							  	'bpk_jarak',
							  	'bpk_harga_bbm'
						);
  
    public $incrementing = false;

}
