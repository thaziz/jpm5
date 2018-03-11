<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Carbon\carbon;
use DB;

class laporan_keuanganController extends Controller {

    public function neraca() {
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl_now = Carbon::now()->format('Y-m-d');
        $asset = DB::select(DB::raw("select *,coa_opening + (select COALESCE(sum(jrdt_value),0) from d_jurnal_dt
                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
			and jr_tgl BETWEEN coa_opening_tgl and '$tgl_now' )
                        and jrdt_acc = coa_code) as COAend
                        from d_comp_coa
                        where coa_comp = '$comp' and coa_year = '$year'
                        and coa_code like '1%'
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));
        $total_asset = 0;
        foreach ($asset as $asset_total) {
            $total_asset+=$asset_total->COAend;
        }

        $kewajiban_modal = DB::select(DB::raw("select *,SUBSTRING(coa_code,1,1) as coa_kategori,coa_opening + (select COALESCE(sum(jrdt_value),0) from d_jurnal_dt
                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
                        and jr_tgl BETWEEN coa_opening_tgl and  '$tgl_now')
                        and jrdt_acc = coa_code) as COAend
                        from d_comp_coa
                        where coa_comp = '$comp' and coa_year = '$year'
                        and (coa_code like '2%' or coa_code like '3%')
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));
        $total_kewajiban_modal = 0;
        foreach ($kewajiban_modal as $km) {
            $total_kewajiban_modal+=$km->COAend;
        }
        return view('laporan.neraca', compact('asset', 'total_asset', 'kewajiban_modal', 'total_kewajiban_modal', 'tgl_now'));
    }

    public function neracaper() {
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $neraca_aset = DB::select(DB::raw("select *, (select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 1
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 1)
and jrdt_acc = coa_code) as COAend1,
 (select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 2
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 2)
and jrdt_acc = coa_code) as COAend2,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 3
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 3)
and jrdt_acc = coa_code) as COAend3,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 4
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 4)
and jrdt_acc = coa_code) as COAend4,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 5
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 5)
and jrdt_acc = coa_code) as COAend5,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 6
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 6)
and jrdt_acc = coa_code) as COAend6,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 7
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 7)
and jrdt_acc = coa_code) as COAend7,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 8
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 8)
and jrdt_acc = coa_code) as COAend8,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 9
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 9)
and jrdt_acc = coa_code) as COAend9,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 10
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 10)
and jrdt_acc = coa_code) as COAend10,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 11
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 11)
and jrdt_acc = coa_code) as COAend11,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 12
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 12)
and jrdt_acc = coa_code) as COAend12
                        from d_comp_coa c
                        where coa_comp = '$comp' and coa_year = '$year'
                        and coa_code like '1%'
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));
        $total_aset1 = 0;
        $total_aset2 = 0;
        $total_aset3 = 0;
        $total_aset4 = 0;
        $total_aset5 = 0;
        $total_aset6 = 0;
        $total_aset7 = 0;
        $total_aset8 = 0;
        $total_aset9 = 0;
        $total_aset10 = 0;
        $total_aset11 = 0;
        $total_aset12 = 0;
        foreach ($neraca_aset as $aset) {
            $total_aset1 = $total_aset1 + $aset->COAend1;
            $total_aset2 = $total_aset2 + $aset->COAend2;
            $total_aset3 = $total_aset3 + $aset->COAend3;
            $total_aset4 = $total_aset4 + $aset->COAend4;
            $total_aset5 = $total_aset5 + $aset->COAend5;
            $total_aset6 = $total_aset6 + $aset->COAend6;
            $total_aset7 = $total_aset7 + $aset->COAend7;
            $total_aset8 = $total_aset8 + $aset->COAend8;
            $total_aset9 = $total_aset9 + $aset->COAend9;
            $total_aset10 = $total_aset10 + $aset->COAend10;
            $total_aset11 = $total_aset11 + $aset->COAend11;
            $total_aset12 = $total_aset12 + $aset->COAend12;
        }

        $neraca_kewajiban_modal = DB::select(DB::raw("select *, (select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 1
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 1)
and jrdt_acc = coa_code) as COAend1,
 (select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 2
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 2)
and jrdt_acc = coa_code) as COAend2,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 3
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 3)
and jrdt_acc = coa_code) as COAend3,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 4
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 4)
and jrdt_acc = coa_code) as COAend4,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 5
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 5)
and jrdt_acc = coa_code) as COAend5,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 6
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 6)
and jrdt_acc = coa_code) as COAend6,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 7
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 7)
and jrdt_acc = coa_code) as COAend7,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 8
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 8)
and jrdt_acc = coa_code) as COAend8,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 9
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 9)
and jrdt_acc = coa_code) as COAend9,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 10
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 10)
and jrdt_acc = coa_code) as COAend10,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 11
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 11)
and jrdt_acc = coa_code) as COAend11,
(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and 12
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 12)
and jrdt_acc = coa_code) as COAend12
                        from d_comp_coa c
                        where coa_comp = '$comp' and coa_year = '$year'
                        and (coa_code like '2%' or coa_code like '3%')
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));

        $total_data1 = 0;
        $total_data2 = 0;
        $total_data3 = 0;
        $total_data4 = 0;
        $total_data5 = 0;
        $total_data6 = 0;
        $total_data7 = 0;
        $total_data8 = 0;
        $total_data9 = 0;
        $total_data10 = 0;
        $total_data11 = 0;
        $total_data12 = 0;
        foreach ($neraca_kewajiban_modal as $data) {
            $total_data1 = $total_data1 + $data->COAend1;
            $total_data2 = $total_data2 + $data->COAend2;
            $total_data3 = $total_data3 + $data->COAend3;
            $total_data4 = $total_data4 + $data->COAend4;
            $total_data5 = $total_data5 + $data->COAend5;
            $total_data6 = $total_data6 + $data->COAend6;
            $total_data7 = $total_data7 + $data->COAend7;
            $total_data8 = $total_data8 + $data->COAend8;
            $total_data9 = $total_data9 + $data->COAend9;
            $total_data10 = $total_data10 + $data->COAend10;
            $total_data11 = $total_data11 + $data->COAend11;
            $total_data12 = $total_data12 + $data->COAend12;
        }
        return View('laporan.nneraca-per', compact('neraca_aset', 'total_aset1', 'total_aset2', 'total_aset3'
                        , 'total_aset4', 'total_aset5', 'total_aset6', 'total_aset7', 'total_aset8', 'total_aset9', 'total_aset10'
                        , 'total_aset11', 'total_aset12', 'neraca_kewajiban_modal', 'total_data1', 'total_data2', 'total_data3', 'total_data4', 'total_data5', 'total_data6', 'total_data7', 'total_data8', 'total_data9', 'total_data10', 'total_data11', 'total_data12'));
    }

    public function cari_neraca(Request $request) {

        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        
        $tgl_now =date('Y-m-d', strtotime($request->tanggal)); 
       
        if (!empty($tgl_now)) {
            $asset = DB::select(DB::raw("select *,(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and month('$tgl_now')
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 1)
and jrdt_acc = coa_code) as COAend
                        from d_comp_coa c
                        where coa_comp = '$comp' and coa_year = '$year'
                        and coa_code like '1%'
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));            
            $total_asset = 0;
            foreach ($asset as $asset_total) {
                $total_asset+=$asset_total->COAend;
            }
            $kewajiban_modal = DB::select(DB::raw("select *,SUBSTRING(coa_code,1,1) as coa_kategori,(select coa_opening from d_comp_coa coa where
month (coa.coa_opening_tgl) BETWEEN 1 and month('$tgl_now')
and coa.coa_name=c.coa_name and coa.coa_comp=c.coa_comp and coa.coa_year=c.coa_year)+(select COALESCE(sum(jrdt_value),0)  from d_jurnal_dt
where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
and YEAR(jr_tgl)='$year' and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 1)
and jrdt_acc = coa_code) as COAend
                       from d_comp_coa c
                        where coa_comp = '$comp' and coa_year = '$year'
                        and (coa_code like '2%' or coa_code like '3%')
                        and (coa_isparent = 1 or coa_isactive = 1)
                        order by coa_code"));
            $total_kewajiban_modal = 0;
            foreach ($kewajiban_modal as $km) {
                $total_kewajiban_modal+=$km->COAend;
            }
            return view('laporan.neraca', compact('asset', 'total_asset', 'kewajiban_modal', 'total_kewajiban_modal', 'tgl_now'));
        }
    }

    public function labarugi() {
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');

//pendapatan ada isi
        $pendapatan = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('10','11','12')
                        group by tr_code order by tr_code"));
        $total_pendapata = 0;
        foreach ($pendapatan as $total_pendapatan) {
            $total_pendapata+=$total_pendapatan->jum;
        }
//hpp ada isi
        $hpp = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('20','21')
                        group by tr_code order by tr_code"));
        $total_hpp = 0;
        foreach ($hpp as $total) {
            $total_hpp+=$total->jum;
        }

//expenses ada isi
        $expenses = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('30')
                        group by tr_code order by tr_code"));

        $total_expenses = 0;
        foreach ($expenses as $total) {
            $total_expenses+=$total->jum;
        }


//kosong
        $depresiasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('41')
                        group by tr_code order by tr_code
                            "));
        $total_depresiasi = 0;
        foreach ($depresiasi as $total) {
            $total_depresiasi+=$total->jum;
        }
//kosong amortisasi 
        $amortisasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('42')
                        group by tr_code order by tr_code
                            "));
        $total_amortisasi = 0;
        foreach ($amortisasi as $total) {
            $total_amortisasi+=$total->jum;
        }
//pendapatanlain    ada
        $pendapatanlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('51')
                        group by tr_code order by tr_code
                            "));
        $total_pendapatanlain = 0;
        foreach ($pendapatanlain as $total) {
            $total_pendapatanlain+=$total->jum;
        }
//kosong pengeluaranlain
        $pengeluaranlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('52')
                        group by tr_code order by tr_code
                            "));
        $total_pengeluaranlain = 0;
        foreach ($pengeluaranlain as $total) {
            $total_pengeluaranlain+=$total->jum;
        }
        //bungga investasi
        $bunggainvesi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('61')
                        group by tr_code order by tr_code
                            "));
        $total_bunggainvesi = 0;
        foreach ($bunggainvesi as $total) {
            $total_bunggainvesi+=$total->jum;
        }
        //pajak kosong
        $pajak = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('62')
                        group by tr_code order by tr_code
                            "));

        $total_pajak = 0;
        foreach ($pajak as $total) {
            $total_pajak+=$total->jum;
        }


        $tgl = date('Y-m-d', strtotime($tgl1));
        $tgl = date('d-M-Y', strtotime($tgl1));
        return view('laporan.labarugi', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp'
                        , 'total_expenses'
                        , 'total_depresiasi', 'total_pendapatanlain', 'total_pengeluaranlain'
                        , 'total_bunggainvesi', 'total_pajak', 'tgl', 'tgl2'));
    }

    public function labarugiper(Request $req) {
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        $tgl = date('Y-m-d', strtotime($req->tgl));
//pendapatan ada isi
        $pendapatan = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('10','11','12')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code"));
        $total_pendapata = 0;
        foreach ($pendapatan as $total_pendapatan) {
            $total_pendapata+=$total_pendapatan->jum;
        }
//hpp ada isi
        $hpp = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('20','21')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code"));
        $total_hpp = 0;
        foreach ($hpp as $total) {
            $total_hpp+=$total->jum;
        }

//expenses ada isi
        $expenses = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('30')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code"));

        $total_expenses = 0;
        foreach ($expenses as $total) {
            $total_expenses+=$total->jum;
        }


//kosong
        $depresiasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('41')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));
        $total_depresiasi = 0;
        foreach ($depresiasi as $total) {
            $total_depresiasi+=$total->jum;
        }
//kosong amortisasi 
        $amortisasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('42')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));
        $total_amortisasi = 0;
        foreach ($amortisasi as $total) {
            $total_amortisasi+=$total->jum;
        }
//pendapatanlain    ada
        $pendapatanlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('51')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));
        $total_pendapatanlain = 0;
        foreach ($pendapatanlain as $total) {
            $total_pendapatanlain+=$total->jum;
        }
//kosong pengeluaranlain
        $pengeluaranlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('52')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));
        $total_pengeluaranlain = 0;
        foreach ($pengeluaranlain as $total) {
            $total_pengeluaranlain+=$total->jum;
        }
        //bungga investasi
        $bunggainvesi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('61')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));
        $total_bunggainvesi = 0;
        foreach ($bunggainvesi as $total) {
            $total_bunggainvesi+=$total->jum;
        }
        //pajak kosong
        $pajak = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('62')
                        and jr_tgl between '2017-01-01' and '$tgl'
                        group by tr_code order by tr_code
                            "));

        $total_pajak = 0;
        foreach ($pajak as $total) {
            $total_pajak+=$total->jum;
        }


        $tgl = date('d-M-Y', strtotime($req->tgl));
        return view('laporan.labarugi', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp'
                        , 'total_expenses'
                        , 'total_depresiasi', 'total_pendapatanlain', 'total_pengeluaranlain'
                        , 'total_bunggainvesi', 'total_pajak', 'tgl', 'tgl2'));
    }

    public function laba_rugi_periode_tahun() {
        $bulan = Carbon::now()->format('m');
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        //$tgl = date('Y-m-d', strtotime($req->tgl));
//pendapatan ada isi
        $pendapatan = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('10','11','12')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_pendapatan1 =0;
        $total_pendapatan2 =0;
        $total_pendapatan3 =0;
        $total_pendapatan4 =0;
        $total_pendapatan5 =0;
        $total_pendapatan6 =0;
        $total_pendapatan7 =0;
        $total_pendapatan8 =0;
        $total_pendapatan9 =0;
        $total_pendapatan10 =0;
        $total_pendapatan11 =0;
        $total_pendapatan12 =0;
        foreach ($pendapatan as $total_pendapatan) {
            $total_pendapatan1+=$total_pendapatan->bulan1;
            $total_pendapatan2+=$total_pendapatan->bulan2;
            $total_pendapatan3+=$total_pendapatan->bulan3;
            $total_pendapatan4+=$total_pendapatan->bulan4;
            $total_pendapatan5+=$total_pendapatan->bulan5;
            $total_pendapatan6+=$total_pendapatan->bulan6;
            $total_pendapatan7+=$total_pendapatan->bulan7;
            $total_pendapatan8+=$total_pendapatan->bulan8;
            $total_pendapatan9+=$total_pendapatan->bulan9;
            $total_pendapatan10+=$total_pendapatan->bulan10;
            $total_pendapatan11+=$total_pendapatan->bulan11;
            $total_pendapatan12+=$total_pendapatan->bulan12;
        }        
//hpp ada isi
        $hpp = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('20','21')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_hpp1 = 0;
        $total_hpp2= 0;
        $total_hpp3 = 0;
        $total_hpp4 = 0;
        $total_hpp5 = 0;
        $total_hpp6 = 0;
        $total_hpp7 = 0;
        $total_hpp8 = 0;
        $total_hpp9 = 0;
        $total_hpp10 = 0;
        $total_hpp11 = 0;
        $total_hpp12 = 0;
        foreach ($hpp as $total) {
            $total_hpp1+=$total->bulan1;
            $total_hpp2+=$total->bulan2;
            $total_hpp3+=$total->bulan3;
            $total_hpp4+=$total->bulan4;
            $total_hpp5+=$total->bulan5;
            $total_hpp6+=$total->bulan6;
            $total_hpp7+=$total->bulan7;
            $total_hpp8+=$total->bulan8;
            $total_hpp9+=$total->bulan9;
            $total_hpp10+=$total->bulan10;
            $total_hpp11+=$total->bulan11;
            $total_hpp12+=$total->bulan12;
        }

//expenses ada isi
        $expenses = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('30')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));

        $total_expenses1 = 0;
        $total_expenses2 = 0;
        $total_expenses3 = 0;
        $total_expenses4 = 0;
        $total_expenses5 = 0;
        $total_expenses6 = 0;
        $total_expenses7 = 0;
        $total_expenses8 = 0;
        $total_expenses9 = 0;
        $total_expenses10 = 0;
        $total_expenses11 = 0;
        $total_expenses12 = 0;       
        foreach ($expenses as $total) {
            $total_expenses1+=$total->bulan1;
            $total_expenses2+=$total->bulan2;
            $total_expenses3+=$total->bulan3;
            $total_expenses4+=$total->bulan4;
            $total_expenses5+=$total->bulan5;
            $total_expenses6+=$total->bulan6;
            $total_expenses7+=$total->bulan7;
            $total_expenses8+=$total->bulan8;
            $total_expenses9+=$total->bulan9;
            $total_expenses10+=$total->bulan10;
            $total_expenses11+=$total->bulan11;
            $total_expenses12+=$total->bulan12;
        }


//kosong
        $depresiasi = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('41')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_depresiasi1 = 0;
        $total_depresiasi2 = 0;
        $total_depresiasi3 = 0;
        $total_depresiasi4 = 0;
        $total_depresiasi5 = 0;
        $total_depresiasi6 = 0;
        $total_depresiasi7 = 0;
        $total_depresiasi8 = 0;
        $total_depresiasi9 = 0;
        $total_depresiasi10 = 0;
        $total_depresiasi11 = 0;
        $total_depresiasi12 = 0;
        foreach ($depresiasi as $total) {
            $total_depresiasi1 +=$total->bulan1;
            $total_depresiasi2 +=$total->bulan2;
            $total_depresiasi3 +=$total->bulan3;
            $total_depresiasi4 +=$total->bulan4;
            $total_depresiasi5 +=$total->bulan5;
            $total_depresiasi6 +=$total->bulan6;
            $total_depresiasi7 +=$total->bulan7;
            $total_depresiasi8 +=$total->bulan8;
            $total_depresiasi9 +=$total->bulan9;
            $total_depresiasi10 +=$total->bula10;
            $total_depresiasi11 +=$total->bulan11;
            $total_depresiasi12 +=$total->bulan12;            
        }
//kosong amortisasi 
        $amortisasi = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('42')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_amortisasi1 = 0;
        $total_amortisasi2= 0;
        $total_amortisasi3 = 0;
        $total_amortisasi4 = 0;
        $total_amortisasi5 = 0;
        $total_amortisasi6 = 0;
        $total_amortisasi7 = 0;
        $total_amortisasi8 = 0;
        $total_amortisasi9 = 0;
        $total_amortisasi10 = 0;
        $total_amortisasi11 = 0;
        $total_amortisasi12 = 0;
        foreach ($amortisasi as $total) {
            $total_amortisasi1+=$total->bulan1;
            $total_amortisasi2+=$total->bulan2;
            $total_amortisasi3+=$total->bulan3;
            $total_amortisasi4+=$total->bulan4;
            $total_amortisasi5+=$total->bulan5;
            $total_amortisasi6+=$total->bulan6;
            $total_amortisasi7+=$total->bulan7;
            $total_amortisasi8+=$total->bulan8;
            $total_amortisasi9+=$total->bulan9;
            $total_amortisasi10+=$total->bulan10;
            $total_amortisasi11+=$total->bulan11;
            $total_amortisasi12+=$total->bulan12;
        }
//pendapatanlain    ada
        $pendapatanlain = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('51')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_pendapatanlain1 = 0;
        $total_pendapatanlain2 = 0;
        $total_pendapatanlain3 = 0;
        $total_pendapatanlain4 = 0;
        $total_pendapatanlain5 = 0;
        $total_pendapatanlain6 = 0;
        $total_pendapatanlain7 = 0;
        $total_pendapatanlain8 = 0;
        $total_pendapatanlain9 = 0;
        $total_pendapatanlain10 = 0;
        $total_pendapatanlain11 = 0;
        $total_pendapatanlain12 = 0;
        foreach ($pendapatanlain as $total) {
            $total_pendapatanlain1+=$total->bulan1;
            $total_pendapatanlain2+=$total->bulan2;
            $total_pendapatanlain3+=$total->bulan3;
            $total_pendapatanlain4+=$total->bulan4;
            $total_pendapatanlain5+=$total->bulan5;
            $total_pendapatanlain6+=$total->bulan6;
            $total_pendapatanlain7+=$total->bulan7;
            $total_pendapatanlain8+=$total->bulan8;
            $total_pendapatanlain9+=$total->bulan9;
            $total_pendapatanlain10+=$total->bulan10;
            $total_pendapatanlain11+=$total->bulan11;
            $total_pendapatanlain12+=$total->bulan12;
        }
//kosong pengeluaranlain
        $pengeluaranlain=DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('52')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_pengeluaranlain1 = 0;
        $total_pengeluaranlain2 = 0;
        $total_pengeluaranlain3 = 0;
        $total_pengeluaranlain4 = 0;
        $total_pengeluaranlain5 = 0;
        $total_pengeluaranlain6 = 0;
        $total_pengeluaranlain7 = 0;
        $total_pengeluaranlain8 = 0;
        $total_pengeluaranlain9 = 0;
        $total_pengeluaranlain10 = 0;
        $total_pengeluaranlain11 = 0;
        $total_pengeluaranlain12 = 0;        
        foreach ($pengeluaranlain as $total) {
            $total_pengeluaranlain1+=$total->bulan1;
            $total_pengeluaranlain2+=$total->bulan2;
            $total_pengeluaranlain3+=$total->bulan3;
            $total_pengeluaranlain4+=$total->bulan4;
            $total_pengeluaranlain5+=$total->bulan5;
            $total_pengeluaranlain6+=$total->bulan6;
            $total_pengeluaranlain7+=$total->bulan7;
            $total_pengeluaranlain8+=$total->bulan8;
            $total_pengeluaranlain9+=$total->bulan9;
            $total_pengeluaranlain10+=$total->bulan10;
            $total_pengeluaranlain11+=$total->bulan11;
            $total_pengeluaranlain12+=$total->bulan12;
        }
        //bungga investasi
        $bunggainvesi = DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('61')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));
        $total_bunggainvesi1 = 0;
        $total_bunggainvesi2 = 0;
        $total_bunggainvesi3 = 0;
        $total_bunggainvesi4 = 0;
        $total_bunggainvesi5 = 0;
        $total_bunggainvesi6 = 0;
        $total_bunggainvesi7 = 0;
        $total_bunggainvesi8 = 0;
        $total_bunggainvesi9 = 0;
        $total_bunggainvesi10 = 0;
        $total_bunggainvesi11 = 0;
        $total_bunggainvesi12 = 0;
        foreach ($bunggainvesi as $total) {
            $total_bunggainvesi1+=$total->bulan1;
            $total_bunggainvesi2+=$total->bulan2;
            $total_bunggainvesi3+=$total->bulan3;
            $total_bunggainvesi4+=$total->bulan4;
            $total_bunggainvesi5+=$total->bulan5;
            $total_bunggainvesi6+=$total->bulan6;
            $total_bunggainvesi7+=$total->bulan7;
            $total_bunggainvesi8+=$total->bulan8;
            $total_bunggainvesi9+=$total->bulan9;
            $total_bunggainvesi10+=$total->bulan10;
            $total_bunggainvesi11+=$total->bulan11;
            $total_bunggainvesi12+=$total->bulan12;
        }
        //pajak kosong
        $pajak= DB::select(DB::raw("select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=1
) as bulan1,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 2
) as bulan2,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl)=3
) as bulan3,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 4
) as bulan4,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 5
) as bulan5,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 6
) as bulan6,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 7
) as bulan7,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 8
) as bulan8,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 9
) as bulan9,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 10
) as bulan10,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 11
) as bulan11,
(select sum(tt_income*f.jr_value) from d_jurnal f
where f.jr_trans=t.tr_code 
and substr(f.jr_trans,1,2) = tt_code
and  f.jr_trans =t.tr_code
and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
and month(jr_tgl) = 12
) as bulan12

from d_jurnal j,m_trans_cat m,d_comp_trans t
where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('62')
and substr(j.jr_trans,1,2) = tt_code
and  j.jr_trans =t.tr_code
and j.jr_comp='$comp' and j.jr_year='$year' group by tr_code order by tr_code
"));

        $total_pajak1 = 0;
        $total_pajak2 = 0;
        $total_pajak3 = 0;
        $total_pajak4 = 0;
        $total_pajak5 = 0;
        $total_pajak6 = 0;
        $total_pajak7 = 0;
        $total_pajak8 = 0;
        $total_pajak9 = 0;
        $total_pajak10 = 0;
        $total_pajak11 = 0;
        $total_pajak12 = 0;
        foreach ($pajak as $total) {
            $total_pajak1+=$total->bulan1;
            $total_pajak2+=$total->bulan2;
            $total_pajak3+=$total->bulan3;
            $total_pajak4+=$total->bulan4;
            $total_pajak5+=$total->bulan5;
            $total_pajak6+=$total->bulan6;
            $total_pajak7+=$total->bulan7;
            $total_pajak8+=$total->bulan8;
            $total_pajak9+=$total->bulan9;
            $total_pajak10+=$total->bulan10;
            $total_pajak11+=$total->bulan11;
            $total_pajak12+=$total->bulan12;
        }
        return view('laporan.labarugi_periode_tahun', compact('pendapatan',
                                                        'total_pendapatan1',
                                                        'total_pendapatan2',
                                                        'total_pendapatan3',
                                                        'total_pendapatan4',
                                                        'total_pendapatan5',
                                                        'total_pendapatan6',
                                                        'total_pendapatan7',
                                                        'total_pendapatan8',
                                                        'total_pendapatan9',
                                                        'total_pendapatan10',
                                                        'total_pendapatan11',
                                                        'total_pendapatan12',
                                                        'hpp',
                                                        'total_hpp1',
                                                        'total_hpp2',
                                                        'total_hpp3',
                                                        'total_hpp4',
                                                        'total_hpp5',
                                                        'total_hpp6',
                                                        'total_hpp7',
                                                        'total_hpp8',
                                                        'total_hpp9',
                                                        'total_hpp10',
                                                        'total_hpp11',
                                                        'total_hpp12',
                                                        'expenses',
                                                        'total_expenses1',
                                                        'total_expenses2',
                                                        'total_expenses3',
                                                        'total_expenses4',
                                                        'total_expenses5',
                                                        'total_expenses6',
                                                        'total_expenses7',
                                                        'total_expenses8',
                                                        'total_expenses9',
                                                        'total_expenses10',
                                                        'total_expenses11',
                                                        'total_expenses12',
                                                        'depresiasi',
                                                        'total_depresiasi1',
                                                        'total_depresiasi2',
                                                        'total_depresiasi3',
                                                        'total_depresiasi4',
                                                        'total_depresiasi5',
                                                        'total_depresiasi6',
                                                        'total_depresiasi7',
                                                        'total_depresiasi8',
                                                        'total_depresiasi9',
                                                        'total_depresiasi10',
                                                        'total_depresiasi11',
                                                        'total_depresiasi12',
                                                        'amortisasi',
                                                        'total_amortisasi1',
                                                        'total_amortisasi2',
                                                        'total_amortisasi3',
                                                        'total_amortisasi4',
                                                        'total_amortisasi5',
                                                        'total_amortisasi6',
                                                        'total_amortisasi7',
                                                        'total_amortisasi8',
                                                        'total_amortisasi9',
                                                        'total_amortisasi10',
                                                        'total_amortisasi11',
                                                        'total_amortisasi12',
                                                        'pendapatanlain',
                                                        'total_pendapatanlain1',
                                                        'total_pendapatanlain2',
                                                        'total_pendapatanlain3',
                                                        'total_pendapatanlain4',
                                                        'total_pendapatanlain5',
                                                        'total_pendapatanlain6',
                                                        'total_pendapatanlain7',
                                                        'total_pendapatanlain8',
                                                        'total_pendapatanlain9',
                                                        'total_pendapatanlain10',
                                                        'total_pendapatanlain11',
                                                        'total_pendapatanlain12',
                                                        'pengeluaranlain',
                                                        'total_pengeluaranlain1',
                                                        'total_pengeluaranlain2',
                                                        'total_pengeluaranlain3',
                                                        'total_pengeluaranlain4',
                                                        'total_pengeluaranlain5',
                                                        'total_pengeluaranlain6',
                                                        'total_pengeluaranlain7',
                                                        'total_pengeluaranlain8',
                                                        'total_pengeluaranlain9',
                                                        'total_pengeluaranlain10',
                                                        'total_pengeluaranlain11',
                                                        'total_pengeluaranlain12',
                                                        'bunggainvesi',
                                                        'total_bunggainvesi1',
                                                        'total_bunggainvesi2',
                                                        'total_bunggainvesi3',
                                                        'total_bunggainvesi4',
                                                        'total_bunggainvesi5',
                                                        'total_bunggainvesi6',
                                                        'total_bunggainvesi7',
                                                        'total_bunggainvesi8',
                                                        'total_bunggainvesi9',
                                                        'total_bunggainvesi10',
                                                        'total_bunggainvesi11',
                                                        'total_bunggainvesi12',
                                                        'pajak',
                                                        'total_pajak1',
                                                        'total_pajak2',
                                                        'total_pajak3',
                                                        'total_pajak4',
                                                        'total_pajak5',
                                                        'total_pajak6',
                                                        'total_pajak7',
                                                        'total_pajak8',
                                                        'total_pajak9',
                                                        'total_pajak10',
                                                        'total_pajak11',
                                                        'total_pajak12'
        )); 
    }

    public function laba_rugi_periode_bulan(Request $req) {
             
        if($req->bulan==null){
             $bulan =  date('m');   
        }
        else {
        if ($req->bulan == 'Januari')
            $bulan = 1;
        if ($req->bulan == 'Februari')
            $bulan = 2;
        if ($req->bulan == 'Maret')
            $bulan = 3;
        if ($req->bulan == 'April')
            $bulan = 4;
        if ($req->bulan == 'Mei')
            $bulan = 5;
        if ($req->bulan == 'Juni')
            $bulan = 6;
        if ($req->bulan == 'Juli')
            $bulan = 7;
        if ($req->bulan == 'Agustus')
            $bulan = 8;
        if ($req->bulan == 'September')
            $bulan = 9;
        if ($req->bulan == 'Oktober')
            $bulan = 10;
        if ($req->bulan == 'November')
            $bulan = 11;
        if ($req->bulan == 'Desember')
            $bulan = 12;
        }
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        $tgl = date('Y-m-d', strtotime($req->tgl));
//pendapatan ada isi
        $pendapatan = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('10','11','12')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code"));
        $total_pendapata = 0;
        foreach ($pendapatan as $total_pendapatan) {
            $total_pendapata+=$total_pendapatan->jum;
        }
//hpp ada isi
        $hpp = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('20','21')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code"));
        $total_hpp = 0;
        foreach ($hpp as $total) {
            $total_hpp+=$total->jum;
        }

//expenses ada isi
        $expenses = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('30')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code"));

        $total_expenses = 0;
        foreach ($expenses as $total) {
            $total_expenses+=$total->jum;
        }


//kosong
        $depresiasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('41')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));
        $total_depresiasi = 0;
        foreach ($depresiasi as $total) {
            $total_depresiasi+=$total->jum;
        }
//kosong amortisasi 
        $amortisasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('42')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));
        $total_amortisasi = 0;
        foreach ($amortisasi as $total) {
            $total_amortisasi+=$total->jum;
        }
//pendapatanlain    ada
        $pendapatanlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('51')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));
        $total_pendapatanlain = 0;
        foreach ($pendapatanlain as $total) {
            $total_pendapatanlain+=$total->jum;
        }
//kosong pengeluaranlain
        $pengeluaranlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('52')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));
        $total_pengeluaranlain = 0;
        foreach ($pengeluaranlain as $total) {
            $total_pengeluaranlain+=$total->jum;
        }
        //bungga investasi
        $bunggainvesi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('61')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));
        $total_bunggainvesi = 0;
        foreach ($bunggainvesi as $total) {
            $total_bunggainvesi+=$total->jum;
        }
        //pajak kosong
        $pajak = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
                        left join m_trans_cat on left(jr_trans,2) = tt_code
                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                        where jr_comp = '$comp' and jr_year = '$year'
                        and tt_code in ('62')
                        and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                        group by tr_code order by tr_code
                            "));

        $total_pajak = 0;
        foreach ($pajak as $total) {
            $total_pajak+=$total->jum;
        }


        $tgl = date('d-M-Y', strtotime($req->tgl));
        return view('laporan.labarugi_periode_bulan', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp'
                        , 'total_expenses'
                        , 'total_depresiasi', 'total_pendapatanlain', 'total_pengeluaranlain'
                        , 'total_bunggainvesi', 'total_pajak', 'tgl', 'bulan'));
    }

//    public function carilabarugi(Request $req) {
//        $comp = Session::get('mem_comp');
//        $year = Session::get('comp_year');
//        $tgl1 = $req->tanggal1;
//        $tgl2 = $req->tanggal2;
//        if (!empty($req))
//            ; {
//            $pendapatan = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('10','11','12')
//                        group by tr_code order by tr_code"));
//            $total_pendapata = 0;
//            foreach ($pendapatan as $total_pendapatan) {
//                $total_pendapata+=$total_pendapatan->jum;
//            }
////hpp ada isi
//            $hpp = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year'and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('20','21')
//                        group by tr_code order by tr_code"));
//            $total_hpp = 0;
//            foreach ($hpp as $total) {
//                $total_hpp+=$total->jum;
//            }
//
////expenses ada isi
//            $expenses = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('30')
//                        group by tr_code order by tr_code"));
//
//            $total_expenses = 0;
//            foreach ($expenses as $total) {
//                $total_expenses+=$total->jum;
//            }
//
//
////kosong
//            $depresiasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('41')
//                        group by tr_code order by tr_code
//                            "));
//            $total_depresiasi = 0;
//            foreach ($depresiasi as $total) {
//                $total_depresiasi+=$total->jum;
//            }
////kosong amortisasi 
//            $amortisasi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('42')
//                        group by tr_code order by tr_code
//                            "));
//            $total_amortisasi = 0;
//            foreach ($amortisasi as $total) {
//                $total_amortisasi+=$total->jum;
//            }
////pendapatanlain    ada
//            $pendapatanlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('51')
//                        group by tr_code order by tr_code
//                            "));
//            $total_pendapatanlain = 0;
//            foreach ($pendapatanlain as $total) {
//                $total_pendapatanlain+=$total->jum;
//            }
////kosong pengeluaranlain
//            $pengeluaranlain = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('52')
//                        group by tr_code order by tr_code
//                            "));
//            $total_pengeluaranlain = 0;
//            foreach ($pengeluaranlain as $total) {
//                $total_pengeluaranlain+=$total->jum;
//            }
//            //bungga investasi
//            $bunggainvesi = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('61')
//                        group by tr_code order by tr_code
//                            "));
//            $total_bunggainvesi = 0;
//            foreach ($bunggainvesi as $total) {
//                $total_bunggainvesi+=$total->jum;
//            }
//            //pajak kosong
//            $pajak = DB::select(DB::raw("select tr_code,tr_name,sum(tt_income*jr_value) as jum from d_jurnal dj
//                        left join m_trans_cat on left(jr_trans,2) = tt_code
//                        left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                        where jr_comp = '$comp' and jr_year = '$year' and jr_tgl BETWEEN '$tgl1' and '$tgl2'
//                        and tt_code in ('62')
//                        group by tr_code order by tr_code
//                            "));
//            $total_pajak = 0;
//            foreach ($pajak as $total) {
//                $total_pajak+=$total->jum;
//            }
//            return view('keuangan.labarugi', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp', 'total_expenses', 'total_depresiasi', 'total_pendapatanlain', 'total_pengeluaranlain', 'total_bunggainvesi', 'total_pajak', 'tgl1', 'tgl2'));
//        }
//        return redirect('labarugi');
//    }

    public function aruskas() {

        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        $tgl = date('d-M-Y', strtotime(Carbon::now()));
        $comp = Session::get('mem_comp');
        $ocf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum     from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='O'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        //dd($ocf);
        $total_ocf = 0;
        foreach ($ocf as $data_ocf) {
            $total_ocf = $total_ocf + $data_ocf->jum;
        }

        $icf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='I'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        $total_icf = 0;
        foreach ($icf as $data_icf) {
            $total_icf = $total_icf + $data_icf->jum;
        }

        $fcf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='F'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        $total_fcf = 0;
        foreach ($fcf as $data_fcf) {
            $total_fcf = $total_fcf + $data_fcf->jum;
        }
        return view('laporan.arus_kas', compact('ocf', 'icf', 'fcf', 'total_fcf', 'tgl', 'total_icf', 'total_ocf', 'total_fcf'));
    }

    public function aruskasPer(Request $req) {

        $tgl = date('Y-m-d', strtotime($req->tgl));


        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        $comp = Session::get('mem_comp');
        $ocf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum     from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and jr_tgl between '2017-01-01' and '$tgl'
                and tr_cashtype ='O'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        //dd($ocf);
        $total_ocf = 0;
        foreach ($ocf as $data_ocf) {
            $total_ocf = $total_ocf + $data_ocf->jum;
        }

        $icf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and jr_tgl between '2017-01-01' and '$tgl'
                and tr_cashtype ='I'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        $total_icf = 0;
        foreach ($icf as $data_icf) {
            $total_icf = $total_icf + $data_icf->jum;
        }

        $fcf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and jr_tgl between '2017-01-01' and '$tgl'
                and tr_cashtype ='F'  and jr_transsub=tr_codesub
                group by tr_code order by tr_code"));
        $total_fcf = 0;
        foreach ($fcf as $data_fcf) {
            $total_fcf = $total_fcf + $data_fcf->jum;
        }
        $tgl = date('d-M-Y', strtotime($req->tgl));

        return view('laporan.arus_kas', compact('ocf', 'icf', 'fcf', 'total_fcf', 'tgl', 'total_icf', 'total_ocf', 'total_fcf'));
    }

   

    public function arus_khas_periode_tahun() {

        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $ocf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum,(select sum(jr_value*tr_cashflow) from d_jurnal jr 
                 where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 1) as bln1
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 2) as bln2
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 3) as bln3
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 4) as bln4
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 5) as bln5
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 6) as bln6
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 7) as bln7
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
                and month(jr.jr_tgl) = 8
                ) as bln8
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 9) as bln9
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 10) as bln10
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 11) as bln11
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 12) as bln12
                from d_jurnal j,d_comp_trans t 
                where j.jr_comp = t.tr_comp and j.jr_year = t.tr_year 
		and j.jr_trans = t.tr_code
                and j.jr_comp = '$comp' and j.jr_year = '$year'
                and t.tr_cashtype ='O'  and j.jr_transsub=t.tr_codesub
                group by tr_code order by tr_code"));
        $ocf_total1=0;
        $ocf_total2=0;
        $ocf_total3=0;
        $ocf_total4=0;
        $ocf_total5=0;
        $ocf_total6=0;
        $ocf_total7=0;
        $ocf_total8=0;
        $ocf_total9=0;
        $ocf_total10=0;
        $ocf_total11=0;
        $ocf_total12=0;
        
        foreach ($ocf as $data) {            
           $ocf_total1+=$data->bln1;     
           $ocf_total2=$ocf_total2+$data->bln2;     
           $ocf_total3=$ocf_total3+$data->bln3;     
           $ocf_total4=$ocf_total4+$data->bln4;     
           $ocf_total5=$ocf_total5+$data->bln5;     
           $ocf_total6=$ocf_total6+$data->bln6;     
           $ocf_total7=$ocf_total7+$data->bln7;     
           $ocf_total8=$ocf_total8+$data->bln8;     
           $ocf_total9=$ocf_total9+$data->bln9;     
           $ocf_total10=$ocf_total10+$data->bln10;     
           $ocf_total11=$ocf_total11+$data->bln11;     
           $ocf_total12=$ocf_total12+$data->bln12;     
        }
        
         $fcf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum,(select sum(jr_value*tr_cashflow) from d_jurnal jr 
                 where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 1) as bln1
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 2) as bln2
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 3) as bln3
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 4) as bln4
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 5) as bln5
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 6) as bln6
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 7) as bln7
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
                and month(jr.jr_tgl) = 8
                ) as bln8
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 9) as bln9
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 10) as bln10
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 11) as bln11
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 12) as bln12
                from d_jurnal j,d_comp_trans t 
                where j.jr_comp = t.tr_comp and j.jr_year = t.tr_year 
		and j.jr_trans = t.tr_code
                and j.jr_comp = '$comp' and j.jr_year = '$year'
                and t.tr_cashtype ='F'  and j.jr_transsub=t.tr_codesub
                group by tr_code order by tr_code"));
         
         $fcf_total1=0;
         $fcf_total2=0;
         $fcf_total3=0;
         $fcf_total4=0;
         $fcf_total5=0;
         $fcf_total6=0;
         $fcf_total7=0;
         $fcf_total8=0;
         $fcf_total9=0;
         $fcf_total10=0;
         $fcf_total11=0;
         $fcf_total12=0;
         foreach ($fcf as $data) {
             $fcf_total1+=$data->bln1;
             $fcf_total2+=$data->bln2;
             $fcf_total3+=$data->bln3;
             $fcf_total4+=$data->bln4;
             $fcf_total5+=$data->bln5;
             $fcf_total6+=$data->bln6;
             $fcf_total7+=$data->bln7;
             $fcf_total8+=$data->bln8;
             $fcf_total9+=$data->bln9;
             $fcf_total10+=$data->bln10;
             $fcf_total11+=$data->bln11;
             $fcf_total12+=$data->bln12;
         }
         
         
                 $icf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum,(select sum(jr_value*tr_cashflow) from d_jurnal jr 
                 where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 1) as bln1
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 2) as bln2
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 3) as bln3
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 4) as bln4
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 5) as bln5
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		 and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 6) as bln6
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 7) as bln7
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
                and month(jr.jr_tgl) = 8
                ) as bln8
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		 and month(jr.jr_tgl) = 9) as bln9
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 10) as bln10
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 11) as bln11
                ,
                (select sum(jr_value*tr_cashflow) from d_jurnal jr 
                where  jr.jr_trans = t.tr_code  and jr.jr_comp = j.jr_comp and jr.jr_year = j.jr_year
		and jr.jr_transsub=t.tr_codesub
		and month(jr.jr_tgl) = 12) as bln12
                from d_jurnal j,d_comp_trans t 
                where j.jr_comp = t.tr_comp and j.jr_year = t.tr_year 
		and j.jr_trans = t.tr_code
                and j.jr_comp = '$comp' and j.jr_year = '$year'
                and t.tr_cashtype ='I'  and j.jr_transsub=t.tr_codesub
                group by tr_code order by tr_code"));
                 $icf_total1=0;
                 $icf_total2=0;
                 $icf_total3=0;
                 $icf_total4=0;
                 $icf_total5=0;
                 $icf_total6=0;
                 $icf_total7=0;
                 $icf_total8=0;
                 $icf_total9=0;
                 $icf_total10=0;
                 $icf_total11=0;
                 $icf_total12=0;
                 foreach ($icf as $data) {
                     $icf_total1+=$data->bln1;
                     $icf_total2+=$data->bln2;
                     $icf_total3+=$data->bln3;
                     $icf_total4+=$data->bln4;
                     $icf_total5+=$data->bln5;
                     $icf_total6+=$data->bln6;
                     $icf_total7+=$data->bln7;
                     $icf_total8+=$data->bln8;
                     $icf_total9+=$data->bln9;
                     $icf_total10+=$data->bln10;
                     $icf_total11+=$data->bln11;
                     $icf_total12+=$data->bln12;
                 }
        return view('laporan.arus_khas_periode_tahun',
                    compact('ocf',
                            'ocf_total1',
                            'ocf_total2',
                            'ocf_total3',
                            'ocf_total4',
                            'ocf_total5',
                            'ocf_total6',
                            'ocf_total7',
                            'ocf_total8',
                            'ocf_total9',
                            'ocf_total10',
                            'ocf_total11',
                            'ocf_total12',
                            'fcf',
                            'fcf_total1',
                            'fcf_total2',
                            'fcf_total3',
                            'fcf_total4',
                            'fcf_total5',
                            'fcf_total6',
                            'fcf_total7',
                            'fcf_total8',
                            'fcf_total9',
                            'fcf_total10',
                            'fcf_total11',
                            'fcf_total12',
                            'icf',
                            'icf_total1',
                            'icf_total2',
                            'icf_total3',
                            'icf_total4',
                            'icf_total5',
                            'icf_total6',
                            'icf_total7',
                            'icf_total8',
                            'icf_total9',
                            'icf_total10',
                            'icf_total11',
                            'icf_total12'
                            ));
    }
    
        public function arus_khas_periode_bulan(Request $req) {
            if($req->bulan==null){
                 $bulan =  date('m');   
            }else{
        if ($req->bulan == 'Januari')
            $bulan = 1;
        if ($req->bulan == 'Februari')
            $bulan = 2;
        if ($req->bulan == 'Maret')
            $bulan = 3;
        if ($req->bulan == 'April')
            $bulan = 4;
        if ($req->bulan == 'Mei')
            $bulan = 5;
        if ($req->bulan == 'Juni')
            $bulan = 6;
        if ($req->bulan == 'Juli')
            $bulan = 7;
        if ($req->bulan == 'Agustus')
            $bulan = 8;
        if ($req->bulan == 'September')
            $bulan = 9;
        if ($req->bulan == 'Oktober')
            $bulan = 10;
        if ($req->bulan == 'November')
            $bulan = 11;
        if ($req->bulan == 'Desember')
            $bulan = 12;
            }
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $comp = Session::get('mem_comp');
        $ocf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum     from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='O' and jr_transsub=tr_codesub
                and YEAR(jr_tgl)=$year and month(jr_tgl) ='$bulan'
                group by tr_code order by tr_code"));

        $total_ocf = 0;
        foreach ($ocf as $data_ocf) {
            $total_ocf = $total_ocf + $data_ocf->jum;
        }
        
        $icf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='I'
                and YEAR(jr_tgl)=$year and month(jr_tgl) = '$bulan'
                group by tr_code order by tr_code"));
        $total_icf = 0;
        foreach ($icf as $data_icf) {
            $total_icf = $total_icf + $data_icf->jum;
        }

        $fcf = DB::select(DB::raw("select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum
                from d_jurnal dj
                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
                where jr_comp = '$comp' and jr_year = '$year'
                and tr_cashtype ='F'
                and YEAR(jr_tgl)=$year and month(jr_tgl) = '$bulan'
                group by tr_code order by tr_code"));
        $total_fcf = 0;
        foreach ($fcf as $data_fcf) {
            $total_fcf = $total_fcf + $data_fcf->jum;
        }
        return view('laporan.arus_kas_bulan', compact('ocf', 'icf', 'fcf', 'total_fcf', 'tgl1', 'bulan', 'total_icf', 'total_ocf', 'total_fcf'));
    }

}

