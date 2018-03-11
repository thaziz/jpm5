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
        return View('laporan.neraca-per', compact('neraca_aset', 'total_aset1', 'total_aset2', 'total_aset3'
                        , 'total_aset4', 'total_aset5', 'total_aset6', 'total_aset7', 'total_aset8', 'total_aset9', 'total_aset10'
                        , 'total_aset11', 'total_aset12', 'neraca_kewajiban_modal', 'total_data1', 'total_data2', 'total_data3', 'total_data4', 'total_data5', 'total_data6', 'total_data7', 'total_data8', 'total_data9', 'total_data10', 'total_data11', 'total_data12'));
    }

//    public function cari_neraca(Request $request) {
//
//        $comp = Session::get('mem_comp');
//        $year = Session::get('comp_year');
//        $tgl_now = $request->tanggal;
//        if (!empty($tgl_now)) {
//            $asset = DB::select(DB::raw("select *,coa_opening + (select sum(jrdt_value) from d_jurnal_dt
//                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
//			and jr_tgl BETWEEN '$year-01-01' and '$tgl_now' )
//                        and jrdt_acc = coa_code) as COAend
//                        from d_comp_coa
//                        where coa_comp = '$comp' and coa_year = '$year'
//                        and coa_code like '1%'
//                        and (coa_isparent = 1 or coa_isactive = 1)
//                        order by coa_code"));
//            $total_asset = 0;
//            foreach ($asset as $asset_total) {
//                $total_asset+=$asset_total->COAend;
//            }
//            $kewajiban_modal = DB::select(DB::raw("select *,SUBSTRING(coa_code,1,1) as coa_kategori,coa_opening + (select sum(jrdt_value) from d_jurnal_dt
//                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
//                        and jr_tgl BETWEEN '$year-01-01' and  '$tgl_now')
//                        and jrdt_acc = coa_code) as COAend
//                        from d_comp_coa
//                        where coa_comp = '$comp' and coa_year = '$year'
//                        and (coa_code like '2%' or coa_code like '3%')
//                        and (coa_isparent = 1 or coa_isactive = 1)
//                        order by coa_code"));
//            $total_kewajiban_modal = 0;
//            foreach ($kewajiban_modal as $km) {
//                $total_kewajiban_modal+=$km->COAend;
//            }
//            return view('laporan.neraca', compact('asset', 'total_asset', 'kewajiban_modal', 'total_kewajiban_modal', 'tgl_now'));
//        }
//    }

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

    public function labarugiperiode() {
        $bulan = Carbon::now()->format('m');
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $tgl2 = Carbon::now()->format('Y-m-d');
        //$tgl = date('Y-m-d', strtotime($req->tgl));
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


        //$tgl = date('d-M-Y', strtotime($req->tgl));
        return view('laporan.labarugi_periode', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp'
                        , 'total_expenses'
                        , 'total_depresiasi', 'total_pendapatanlain', 'total_pengeluaranlain'
                        , 'total_bunggainvesi', 'total_pajak', 'tgl', 'bulan'));
    }

    public function labarugiperiodebulan(Request $req) {
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
        return view('laporan.labarugi_periode', compact('pendapatan', 'hpp', 'expenses', 'depresiasi', 'amortisasi', 'pendapatanlain', 'pengeluaranlain', 'bunggainvesi', 'pajak', 'date1', 'date2', 'total_pendapata', 'total_hpp'
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

    public function arus_khas_periode() {
        $comp = Session::get('mem_comp');
        $year = Session::get('comp_year');
        $tgl1 = Carbon::now()->format('Y-m-d');
        $bulan = Carbon::now()->format('m');
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

        return view('laporan.arus_khas_periode', compact('ocf', 'icf', 'fcf', 'total_fcf', 'bulan', 'tgl2', 'total_icf', 'total_ocf', 'total_fcf'));
    }

    public function arus_khas_periode_bulan(Request $req) {
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
        //dd($bulan);
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

        return view('laporan.arus_khas_periode', compact('ocf', 'icf', 'fcf', 'total_fcf', 'tgl1', 'bulan', 'total_icf', 'total_ocf', 'total_fcf'));
    }

}

//select *,coa_opening + (select COALESCE(sum(jrdt_value),0) from d_jurnal_dt
//                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
//                        and YEAR(jr_tgl)=2017 and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 5)
//                        and jrdt_acc = coa_code) as COAend,coa_opening + (select COALESCE(sum(jrdt_value),0) from d_jurnal_dt
//                        where jrdt_id in (select jr_id from d_jurnal where jr_comp = coa_comp and jr_year = coa_year
//                        and YEAR(jr_tgl)=2017 and month(jr_tgl) BETWEEN month(coa_opening_tgl) and 4)
//                        and jrdt_acc = coa_code) as COAend2
//                        from d_comp_coa
//                        where coa_comp = 'COM-160049' and coa_year = '2017'
//                        and coa_code like '1%'
//                        and (coa_isparent = 1 or coa_isactive = 1)
//                        order by coa_code


//Arus Khas
//select tr_code,tr_name,sum(jr_value*tr_cashflow) as jum     from d_jurnal dj
//                left join d_comp_trans on jr_comp = tr_comp and jr_year = tr_year and jr_trans = tr_code
//                where jr_comp = 'COM-160049' and jr_year = '2017' and  month(jr_tgl)=4
//                and tr_cashtype ='O'
//                group by tr_code order by tr_code



// laporan laba rugi
//
//select jr_tgl,tr_code,tr_name,sum(tt_income*jr_value) ,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 1
//) as bulan1,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 2
//) as bulan2,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 3
//) as bulan3,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 4
//) as bulan4,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 5
//) as bulan5,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 6
//) as bulan6,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 7
//) as bulan7,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 8
//) as bulan8,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 9
//) as bulan9,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 10
//) as bulan10,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 11
//) as bulan11,
//(select sum(tt_income*f.jr_value) from d_jurnal f
//where f.jr_trans=t.tr_code and substr(f.jr_trans,1,2) in ('10','11','12')
//and substr(f.jr_trans,1,2) = tt_code
//and  f.jr_trans =t.tr_code
//and f.jr_comp=j.jr_comp and f.jr_year=j.jr_year
//and month(jr_tgl) BETWEEN 1 and 12
//) as bulan12
//
//from d_jurnal j,m_trans_cat m,d_comp_trans t
//where j.jr_trans=t.tr_code and substr(j.jr_trans,1,2) in ('10','11','12')
//and substr(j.jr_trans,1,2) = tt_code
//and  j.jr_trans =t.tr_code
//and j.jr_comp='RM00000001' and j.jr_year='2016' group by tr_code order by tr_code
