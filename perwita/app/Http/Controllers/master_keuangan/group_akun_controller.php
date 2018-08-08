<?php

namespace App\Http\Controllers\master_keuangan;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\d_group_akun;

use DB;
use Auth;
use Session;

class group_akun_controller extends Controller
{
    public function index(){
    	$data = DB::table("d_group_akun")->select("*")->orderBy('tanggal_buat', 'desc')->get();

    	return view("keuangan.group_akun.index")->withData($data);
    }

    public function add(){
        // $akun = json_encode(DB::table("d_akun")->select("id_akun", "nama_akun", "group_neraca", "group_laba_rugi")->orderBy("id_akun", "asc")->get());
        //$ids = DB::table("d_group_akun")->orderBy("id", "desc")->first()->id;

    	return view("keuangan.group_akun.insert");
    }

    public function save(Request $request){
    	// return json_encode($request->all());

    	$response = [
            "status" => "sukses",
            "content" => "null"
        ];

        $initial = '';

    	$id = (DB::table('d_group_akun')->max('id')) ? (explode('-', DB::table('d_group_akun')->orderBy('tanggal_buat', 'desc')->first()->id)[1] + 1) : 1;
    	$cek = DB::table("d_group_akun")->where("id", $id)->select("*")->first();

        if($request->jenis == 2){
            $initial = 'R';
        }else if($request->jenis == 1){
            $initial = $request->type;
        }

    	$group = new d_group_akun;
    	$group->id = $initial.'-'.$id;
    	$group->nama_group = $request->nama;
    	$group->jenis_group = $request->jenis;

    	if($group->save()){
            if($request->jenis == '1' && isset($request->akun_inside)){
                DB::table('d_akun')->whereIn(DB::raw('substring(id_akun, 1, 4)'), $request->akun_inside)->update([
                    'group_neraca'  => $initial.'-'.$id,
                ]);
            }

			return json_encode($response);
        }
    }

    public function edit($id){
    	$group = DB::table("d_group_akun")->where("id", $id)->first();

        if($group->jenis_group == 1)
            $akun = DB::table('d_akun')->where('group_neraca', $group->id);
                            
        else if($group->jenis_group == 2)
            $akun = DB::table('d_akun')->where('group_laba_rugi', $group->id);

        $data_akun = $akun->select(DB::raw('substring(id_akun, 1, 4) as id_akun'), 'main_name')
                            ->distinct(DB::raw('substring(id_akun, 1, 4)'))
                            ->orderBy('id_akun', 'asc')->get();

        $id_akun = json_encode($akun->select('id_akun')->orderBy('id_akun', 'asc')->get());

    	return view("keuangan.group_akun.edit")
               ->withData_akun($data_akun)
               ->withId_akun($id_akun)
    		   ->withGroup($group);
    }

    public function update(Request $request){
    	// return json_encode($request->all());

    	$response = [
            "status" => "sukses",
            "content" => "null"
        ];

    	// return json_encode($cek);

    	$group = DB::table("d_group_akun")->where("id", $request->kode_group)->update([
    		"nama_group"	=> $request->nama
    	]);

        if($request->jenis == 1){
            if(isset($request->akun_inside)){
                DB::table('d_akun')->whereIn(DB::raw('substring(id_akun, 1, 4)'), $request->akun_inside)->update([
                    'group_neraca'  => $request->kode_group,
                ]);
            }else if(isset($request->deleted_akun)){
                DB::table('d_akun')->whereIn(DB::raw('substring(id_akun, 1, 4)'), $request->deleted_akun)->update([
                    'group_neraca'  => '---',
                ]);
            }
        }elseif($request->jenis == 2){
            if(isset($request->akun_inside)){
                DB::table('d_akun')->whereIn(DB::raw('substring(id_akun, 1, 4)'), $request->akun_inside)->update([
                    'group_laba_rugi'  => $request->kode_group,
                ]);
            }else if(isset($request->deleted_akun)){
                DB::table('d_akun')->whereIn(DB::raw('substring(id_akun, 1, 4)'), $request->deleted_akun)->update([
                    'group_laba_rugi'  => '---',
                ]);
            }
        }

		return json_encode($response);
    }

    public function hapus($id){
        $data = DB::table('d_group_akun')->where('id', $id)->first();
    	DB::table("d_group_akun")->where("id", $id)->delete();

        if($data->jenis_group == 1){
            DB::table('d_akun')->where('group_neraca', $id)->update([
                'group_neraca'  => '---',
            ]);
        }else if($data->jenis_group == 2){
            DB::table('d_akun')->where('group_laba_rugi', $id)->update([
                'group_laba_rugi'  => '---',
            ]);
        }

    	Session::flash('sukses', "Data Master Group Akun Berhasil Dihapus.");

    	return redirect(url("master_keuangan/group_akun"));
    }

    public function list_akun(Request $request){
        // return $request->keyword;

        if($request->keyword == 1)
            $data = DB::table('d_akun')->where('group_neraca', '---')
                    ->join('cabang', 'cabang.kode', '=', 'd_akun.kode_cabang')
                    ->select(DB::raw('substring(id_akun, 1, 4) as id_akun'), 'main_name')
                    ->distinct(DB::raw('substring(id_akun, 1, 4)'))->orderBy('id_akun', 'asc')->get();
        else if($request->keyword == 2)
            $data = DB::table('d_akun')->where('group_laba_rugi', '---')
                    ->join('cabang', 'cabang.kode', '=', 'd_akun.kode_cabang')
                    ->select(DB::raw('substring(id_akun, 1, 4) as id_akun'), 'main_name')
                    ->distinct(DB::raw('substring(id_akun, 1, 4)'))->orderBy('id_akun', 'asc')->get();

        $withChecked = 'true';
        // return json_encode($data);
        return view('keuangan.group_akun.list_akun', compact('data', 'withChecked'));
    }

    public function list_akun_on_group(Request $request){
        // return $request->all();

        $withChecked = (isset($request->checked)) ? $request->checked : 'true';

        if($request->jenis == 1)
            $data = DB::table('d_akun')->where('group_neraca', $request->id_group)
                    ->select(DB::raw('substring(id_akun, 1, 4) as id_akun'), 'main_name')
                    ->distinct(DB::raw('substring(id_akun, 1, 4)'))->orderBy('id_akun', 'asc')->get();
        else if($request->jenis == 2)
            $data = DB::table('d_akun')->where('group_laba_rugi', $group->id_group)
                    ->select(DB::raw('substring(id_akun, 1, 4) as id_akun'), 'main_name')
                    ->distinct(DB::raw('substring(id_akun, 1, 4)'))->orderBy('id_akun', 'asc')->get();

        // return json_encode($data);
        return view('keuangan.group_akun.list_akun', compact('data', 'withChecked'));
    }
}
