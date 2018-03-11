<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sppdt_purchase extends Model
{
    protected $table = 'spp_detail';
    protected $primaryKey = 'sppd_idsppdetail';
    protected $fillable = array('sppd_idspp','sppd_idsppdetail', 'sppd_seq', 'sppd_kodeitem', 'sppd_qtyrequest','sppd_supplier','sppd_supplier','sppd_bayar','sppd_harga', 'sppd_kendaraan');
    
    //public $dateFormat = 'Y-m-d H:i:s+';
 
public $incrementing = false;

public function belongs()
	{
		return $this->belongsTo(spp_purchase::class, 'sppd_idspp');
	}

}
