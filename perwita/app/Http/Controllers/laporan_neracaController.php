<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class laporan_neracaController extends Controller
{
 public function index(){
 	$year=date('Y');
 $neracaAset= DB::select("select 
akun1.id_akun,akun1.nama_akun,id_parrent,saldo_akun+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='$year' 
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2018-12-31'))
as coa_end
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun where akun1.id_akun like '1%' order by id_akun");

 $totalAset=DB::select("select 'Aset' as aset,
sum(saldo_akun+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2017-12-31')))
as totalAset
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun where akun1.id_akun like '1%' 
");


$neracaK=DB::select("select
akun1.id_akun,akun1.nama_akun,id_parrent,saldo_akun+
(select sum(jrdt_value) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year'
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2017-12-31'))
as coa_end
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun 
where 
(akun1.id_akun like '2%')
order by id_akun");

$neracaM=DB::select("select 
akun1.id_akun,akun1.nama_akun,id_parrent,saldo_akun+
(select sum(jrdt_value) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2017-12-31'))
as coa_end
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun 
where 
(akun1.id_akun like '3%')
union
select 
'999999999' as id_akun, 'Laba Berjalan' as nama_akun,(NULL) as parrent,sum(saldo_akun+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2017-12-31')
))as coa_end
from d_akun akun1 join d_akun_saldo aks on akun1.id_akun=aks.id_akun 
where (akun1.id_akun like '4%' OR akun1.id_akun like '5%' OR akun1.id_akun like '6%')
order by id_akun");


$totalKM=DB::select("select 
sum(saldo_akun+
(select sum(jrdt_value) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN date(aks.tanggal_dibuat) and '2017-12-31')))
as totalKM
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun 
where cast ( SUBSTRING(akun1.id_akun,1,1) as int8) >1");

    	return view('laporan_neraca.index',compact('neracaAset','neracaK','neracaM','totalAset','totalKM'));
    }
public function neraca(){
 	$year=date('Y');
 	$kas=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1001 and 1099");
 	$bank=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1101 and 1199");
 	$deposito=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1201 and 1299");
 	 	$piutangUsaha=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1301 and 1399");
 	 	$uangMukaPembelian=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1401 and 1499");
 	$persediaan=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1501 and 1599");

//Aktiva Tidak Lancar
	$aktivaTetap=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1601 and 1699");

$akmlsiAktivaTetap=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1701 and 1799");

$aktivaLain2=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  1801 and 1899");


 $totalAset=DB::select("select 'Aset' as aset,
sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31')))
as totalAset
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun where akun1.id_akun like '1%' 
");

//kewajiban
 $hutangBank=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2201 and 2299");

  $hutangPajak=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2301 and 2399");

  $hutangUsahaDagang=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2101 and 2199");
   $dana=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2001 and 2199");

   $hutangHarusDibayar=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2401 and 2499");

   $hutangAfiliasi=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
 cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  2501 and 2599");

$ekuitas=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
cast ( SUBSTR(akun1.id_akun,1,4) as int8)  BETWEEN  3101 and 3199");

$labaRugi=DB::select("select 
COALESCE(sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year ='2018' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31'))),0)
as saldo
from d_akun akun1 left join 
d_akun_saldo aks on akun1.id_akun=aks.id_akun where 
cast ( SUBSTR(akun1.id_akun,1,2) as int8)  BETWEEN  41 and 99");


$totalKM=DB::select("select 'Aset' as aset,
sum(COALESCE(saldo_akun,0)+
(select COALESCE(sum(jrdt_value),0) from d_jurnal_dt jrdt where jrdt.jrdt_acc=akun1.id_akun
and jrdt.jrdt_jurnal in (select jr_id from d_jurnal jr where jr.jr_year = '$year' 
and jr.jr_date BETWEEN '2018-01-01' and '2018-12-31')))
as totalAset
from d_akun akun1 left join d_akun_saldo aks on akun1.id_akun=aks.id_akun where cast ( SUBSTRING(akun1.id_akun,1,1) as int8) >1
");

 	return view('laporan_neraca.neraca',compact('kas','bank','deposito','piutangUsaha','uangMukaPembelian','persediaan','totalAset',
 		'aktivaTetap','akmlsiAktivaTetap','aktivaLain2',
 		'hutangBank','hutangPajak','hutangUsahaDagang','hutangHarusDibayar',
 		'hutangAfiliasi',
 		'ekuitas','labaRugi'
 		,'totalKM','dana'));
 }
}
