<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\d_comp_trans;
use App\d_comp_coa;
use App\m_trans_cat;
use DB;
use Validator;
use Session;
use Yajra\Datatables\Datatables;

class d_comp_transController extends Controller {
    

    public function index_view() {
        return view('d_comp_trans.index', compact('comp_trans'));
    }
    
    public function index_data() {
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $comp_trans = DB::select(DB::raw("select tr.*,coa.coa_name as coa1name,coa2.coa_name as coa2name from d_comp_trans tr left join d_comp_coa coa "
                                . "                       on coa.coa_code=tr.tr_acc01 and coa.coa_comp=tr.tr_comp and coa.coa_year=tr.tr_year"
                                . "                       left join d_comp_coa coa2 on coa2.coa_code=tr.tr_acc02 and coa2.coa_comp=tr.tr_comp and coa2.coa_year=tr.tr_year"
                                . "                        where tr_comp='$comp' and tr_year='$year' order By tr_code"));
        $comp_trans= collect($comp_trans);
          return Datatables::of($comp_trans)
                        ->addColumn('action', function ($comp_trans) {
                            return' <div class="dropdown">                                
                                            <button class="btn btn-primary btn-flat btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Kelola
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a href="master-transaksi-akun/edit/' . $comp_trans->tr_code .'/'.$comp_trans->tr_codesub.'" ><i class="fa fa-pencil" aria-hidden="true"></i>Edit Data</a></li>                                                
                                                <li role="separator" class="divider"></li>                                                                        
                                                <li><a class="btn-delete" data-remote="master-transaksi-akun/delete/' . $comp_trans->tr_code.'/'.$comp_trans->tr_codesub.'"></i>Hapus Data</a></li>                                                
                                            </ul>
                                        </div>';
                        })->editColumn('tr_cashtype', function ($comp_trans) {
                            if ($comp_trans->tr_cashtype == 'O')
                                return 'Operating Cash Flow';
                            if ($comp_trans->tr_cashtype == 'I')
                                return 'Investing Cash Flow';
                            if ($comp_trans->tr_cashtype == 'F')
                                return 'Financial Cash Flow';
                        })
                        ->make(true);

    }
    public function index() {
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $comp_trans = DB::select(DB::raw("select tr.*,coa.coa_name as coa1name,coa2.coa_name as coa2name from d_comp_trans tr left join d_comp_coa coa "
                                . "                       on coa.coa_code=tr.tr_acc01 and coa.coa_comp=tr.tr_comp and coa.coa_year=tr.tr_year"
                                . "                       left join d_comp_coa coa2 on coa2.coa_code=tr.tr_acc02 and coa2.coa_comp=tr.tr_comp and coa2.coa_year=tr.tr_year"
                                . "                        where tr_comp='$comp' and tr_year='$year' order By tr_code"));
        return view('d_comp_trans.index1', compact('comp_trans'));
    }

    public function create() {
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $trans_cat = m_trans_cat::orderBy('tt_code')->get();
        $acc01 = d_comp_coa::orderBy('coa_code')->where('coa_comp', '=', $comp)->where('coa_year', '=', $year)->
                        where('coa_isactive', '=', 1)->get();
        return view('d_comp_trans.create', compact('trans_cat', 'acc01'));
    }

    public function store(Request $req) {

        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $tr01dk = $req->tr_acc01dk;
        $tr02dk = $req->tr_acc02dk;
        $tr01 = substr($req->Account01, 0, 1);
        $tr02 = substr($req->Account02, 0, 1);
        if ($tr01 == 1 && $tr02 == 1) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            }
        } else if ($tr01 == 1 && $tr02 == 2 || $tr01 == 1 && $tr02 == 3) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 1 || $tr01 == 3 && $tr02 == 1) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 2) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 3 && $tr02 == 3) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 3 || $tr01 == 3 && $tr02 == 2) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        }

        $rules = array(
            'Kategori' => 'required',
            'Kode_Transaksi' => 'required',
            'Nama_Transaksi' => 'required',
            'Cash_Type' => 'required', // make sure the email is an actual email
           // 'cashflow' => 'required',
            'Account01' => 'required|min:9|max:9',
            'Account02' => 'required|min:9|max:9',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Redirect('data-master/master-transaksi-akun/create')
                            ->withInput()
                            ->withErrors($validator); // send back the input (not the password) so that we can repopulate the form
        } else {
            $chek = d_comp_trans::where('tr_comp', '=', $comp)->where('tr_year', '=', $year)->where('tr_code', '=', $req->Kode_Transaksi)->get();
            if (count($chek) == 0) {
                d_comp_trans::create([
                    'tr_comp' => $comp,
                    'tr_year' => $year,
                    'tr_code' => $req->Kode_Transaksi,
                    'tr_codesub' => '1',
                    'tr_name' => $req->Nama_Transaksi,
                    'tr_namesub' => $req->Sub_Nama,
                    'tr_cashtype' => $req->Cash_Type,
                    'tr_cashflow' =>$req->tr_acc01dk,
                    'tr_acc01' => $req->Account01,
                    'tr_acc01dk' => $req->tr_acc01dk,
                    'tr_acc02' => $req->Account02,
                    'tr_acc02dk' => $req->tr_acc02dk,
                ]);
                Session::flash('flash_message', 'Data Berhasil Di Simpan.');
                return Redirect('data-master/master-transaksi-akun');
            } else if (count($chek) != 0) {
                $codesub = d_comp_trans::where('tr_comp', '=', $comp)->where('tr_year', '=', $year)->where('tr_code', '=', $req->Kode_Transaksi)->max('tr_codesub');                 
                d_comp_trans::create([
                    'tr_comp' => $comp,
                    'tr_year' => $year,
                    'tr_code' => $req->Kode_Transaksi,
                    'tr_codesub' => $codesub+1,
                    'tr_name' => $req->Nama_Transaksi,
                    'tr_namesub' => $req->Sub_Nama,
                    'tr_cashtype' => $req->Cash_Type,
                    'tr_cashflow' => $req->tr_acc01dk,
                    'tr_acc01' => $req->Account01,
                    'tr_acc01dk' => $req->tr_acc01dk,
                    'tr_acc02' => $req->Account02,
                    'tr_acc02dk' => $req->tr_acc02dk,
                ]);
                Session::flash('flash_message', 'Data Berhasil Di Simpan.');
                return Redirect('data-master/master-transaksi-akun');
            }
        }
    }

    public function edit($id,$subid) {
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
       // $trans_cat = m_trans_cat::orderBy('tt_code')->get();
       // $trans_cat = m_trans_cat::orderBy('tt_code')->get();
        $comp_trans = DB::select(DB::raw("select tr.*,coa.coa_name as coa1name,coa2.coa_name as coa2name from d_comp_trans tr left join d_comp_coa coa "
                                . "                       on coa.coa_code=tr.tr_acc01 and coa.coa_comp=tr.tr_comp and coa.coa_year=tr.tr_year"
                                . "                       left join d_comp_coa coa2 on coa2.coa_code=tr.tr_acc02 and coa2.coa_comp=tr.tr_comp and coa2.coa_year=tr.tr_year where"
                                . "                       tr.tr_code=$id and tr.tr_comp='$comp' and tr.tr_year='$year' and tr.tr_codesub='$subid'"))[0];
        $tr01 = substr($comp_trans->tr_acc01, 0, 1);
        $tr02 = substr($comp_trans->tr_acc02, 0, 1);
        //dd($tr02);
        if ($tr01 == 1 && $tr02 == 1) {
            if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk ='debet';
                $comp_trans->tr_acc02dk = 'kredit';
            } else if ($comp_trans->tr_acc01dk=='-1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            }
        } else if ($tr01 == 1 && $tr02 == 2 || $tr01 == 1 && $tr02 == 3) {
            if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk= 'debet';
                $comp_trans->tr_acc02dk= 'kredit';
            } else if ($comp_trans->tr_acc01dk == '-1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            }
        } else if ($tr01 == 2 && $tr02 == 1 || $tr01 == 3 && $tr02 == 1) {
            if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            } else if ($comp_trans->tr_acc01dk == '-1') {
                $comp_trans->tr_acc01dk= 'debet';
                $comp_trans->tr_acc02dk= 'kredit';
            }
        } else if ($tr01 == 2 && $tr02 == 2) {
           if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            } else if ($comp_trans->tr_acc01dk == '-1') {
                $comp_trans->tr_acc01dk= 'debet';
                $comp_trans->tr_acc02dk= 'kredit';
            }
        } else if ($tr01 == 3 && $tr02 == 3) {
           if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            } else if ($comp_trans->tr_acc01dk == '-1') {
                $comp_trans->tr_acc01dk= 'debet';
                $comp_trans->tr_acc02dk= 'kredit';
            }
        } else if ($tr01 == 2 && $tr02 == 3 || $tr01 == 3 && $tr02 == 2) {
           if ($comp_trans->tr_acc01dk == '1') {
                $comp_trans->tr_acc01dk= 'kredit';
                $comp_trans->tr_acc02dk= 'debet';
            } else if ($comp_trans->tr_acc01dk == '-1') {
                $comp_trans->tr_acc01dk= 'debet';
                $comp_trans->tr_acc02dk= 'kredit';
            }
        }
        
        
        //$tr01dk = $comp_trans->tr_acc01dk;
        //$tr02dk = $comp_trans->tr_acc02dk;
        //dd($comp_trans);
        $acc01 = d_comp_coa::where('coa_comp','=',$comp)->where('coa_year','=',$year)->orderBy('coa_code')->get();
        //$tt_code=substr($id,0,2);
        return view('d_comp_trans.edit', compact('comp_trans', 'acc01'));
    }

    public function update($id,$subid, Request $req) {
        //  dd($req);
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        
        
        $tr01dk = $req->tr_acc01dk;
        $tr02dk = $req->tr_acc02dk;
        $tr01 = substr($req->Account01, 0, 1);
        $tr02 = substr($req->Account02, 0, 1);
        if ($tr01 == 1 && $tr02 == 1) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            }
        } else if ($tr01 == 1 && $tr02 == 2 || $tr01 == 1 && $tr02 == 3) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 1 || $tr01 == 3 && $tr02 == 1) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 2) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 3 && $tr02 == 3) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        } else if ($tr01 == 2 && $tr02 == 3 || $tr01 == 3 && $tr02 == 2) {
            if ($tr01dk == 'Kredit') {
                $req->tr_acc01dk = 1;
                $req->tr_acc02dk = -1;
            } else if ($tr01dk == 'Debet') {
                $req->tr_acc01dk = -1;
                $req->tr_acc02dk = 1;
            }
        }
        
        
        $comp_trans = d_comp_trans::where('tr_comp', '=', $comp)->where('tr_year', '=', $year)->where('tr_code', '=', $id)->where('tr_codesub','=',$subid);
        $rules = array(
            'Kode_Transaksi' => 'required',
            'Nama_Transaksi' => 'required',
            'Cash_Type' => 'required', // make sure the email is an actual email
            //'cashflow' => 'required',
            'Account01' => 'required|min:9|max:9',
            'Account02' => 'required|min:9|max:9',
            "tr_acc01dk" => 'required',
            "tr_acc02dk" => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
            return Redirect('comp_trans/edit/' . $id)
                            ->withInput()
                            ->withErrors($validator); // send back the input (not the password) so that we can repopulate the form
        } else {

            $comp_trans->update([
                'tr_comp' => $comp,
                'tr_year' => $year,
                'tr_code' => $req->Kode_Transaksi,
                //'tr_codesub' => '1',
                'tr_name' => $req->Nama_Transaksi,
                'tr_namesub' => $req->Sub_Nama,
                'tr_cashtype' => $req->Cash_Type,                
                'tr_cashflow' => $req->tr_acc01dk,
                'tr_acc01' => $req->Account01,
                'tr_acc01dk' => $req->tr_acc01dk,
                'tr_acc02' => $req->Account02,
                'tr_acc02dk' => $req->tr_acc02dk,
            ]);
            Session::flash('flash_message', 'Data Berhasil Di Update.');
        }
    }

    public function destroy($id,$tr_code) {
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        
        $d_comp_trans = d_comp_trans::where('tr_comp', '=', $comp)->where('tr_year', '=', $year)->where('tr_code', '=', $id)->where('tr_codesub', '=', $tr_code);
      
        $d_comp_trans->delete();
        Session::flash('flash_message_hapus', 'Data Berhasil Di Hapus.');
        return 'sukses';
    }

    public function kode($id) {
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $a = DB::select(DB::raw("select max(SUBSTRING(tr_code,3,5)) as id from d_comp_trans where tr_comp='$comp' and tr_year='$year' and SUBSTRING(tr_code,1,2)=$id"))[0];
        $kode = $a->id + 1;
        $kode = $id . sprintf("%03s", $kode);
        return $kode;
    }

    public function chekNamaTransaksi($nama,$kode) {
        
        $comp = Session::get('mem_comp');
        $year =Session::get('comp_year');
        $a = d_comp_trans::where('tr_comp', '=', $comp)->where('tr_year', '=', $year)->where('tr_name', '=', $nama)->where(DB::raw('substr(tr_code,1,2)'),'=',$kode)->first();
        
        return $a;
    }

}
