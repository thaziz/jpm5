<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\d_mem;
use App\d_comp;
use App\d_mem_comp;
use App\d_mem_email;
use App\d_comp_year;
use App\d_comp_coa;
use App\d_mem_log;
use Validator;
use Session;
use DB;
use Mail;
use Auth;

class login_Controller extends Controller {
    public function __construct() {
        $this->middleware('guest')->except(['logout', 'showGate', 'compCheck', 'showEmaliVerication', 'sendVerification', 'vericationSuccess', 'verifiedEmail', 'step1Show', 'passwordReset', 'step2Show', 'addComp']);

        $this->middleware('auth')->only(['ping','logout', 'showGate', 'compCheck', 'showEmaliVerication', 'sendVerification', 'vericationSuccess', 'verifiedEmail', 'step1Show', 'passwordReset', 'step2Show', 'addComp']);
    }

    public function showLogin() {
        return view('auth.login');
    }
    public function abc() {
        dd(sha1(md5('passwordAllah')).'12321');
    }

    public function authenticate(Request $request) {
        return DB::transaction(function() use ($request) {
            
            $request->username=nama($request->username);                
            $rules = array(
                'username' => 'required', // make sure the email is an actual email
                'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
            );

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {

                $response = [
                    'status' => 'gagal',
                    'content' => $validator->errors()->all()
                ];

                return json_encode($response);
            } else {            
                $username = $request->username;
                $password = $request->password;


                $user = d_mem::where(DB::raw('m_username'), $request->username)->first();            

                //dd(sha1(md5('passwordAllah') + $request->password) .' '.$user->m_passwd);
                if ($user && $user->m_passwd == sha1(md5('passwordAllah') + $request->password)) {

                    $userCompany = $user->company($user->m_id);      
                    if(count($userCompany)==0){
                       $response = [
                            'status' => 'gagal',
                            'content' => 'Perusahaan'
                        ];                 
                        return json_encode($response);  
                    }
                    Auth::login($user); //set login                 
                    //Session::set('mem_comp', $userCompany->c_id);
                    //Session::set('mem_year', $userCompany->y_year);
                    $response = [
                        'status' => 'sukses',
                        'content' => 'authenticate'
                    ];

                    return json_encode($response);
                } else {
                    $response = [
                        'status' => 'gagal',
                        'content' => 'Inputan Nama dan Password Tidak Sesuai !'
                    ];

                    return json_encode($response);
                }
            }
        });
    }

    public function compCheck(Request $request) {
        //Ganti Perusahaan


        if ($request->ajax()) {


            $memReset = d_mem_comp::where('mc_mem', '=', Auth::user()->m_id);
            $mem = d_mem_comp::where('mc_mem', '=', Auth::user()->m_id)->where('mc_comp', '=', $request->mem_comp);

            if (count($mem) != 0) {
                if ($memReset->update([ 'mc_active' => 0])) {
                    if ($mem->update([ 'mc_active' => 1])) {
                        Session::set('mem_comp', $request->mem_comp);
                        // /return Session::get('mem_comp');
                        Session::set('comp_year', Auth::user()->getActiveYear(Session::get('mem_comp'))->y_year);
                        $response = [
                            'status' => 'sukses',
                        ];

                        return json_encode($response);
                    }
                }
            } else {
                return view('errors.401');
            }
        }
    }

    public function showGate() {
        $memcomp = Auth::user()->company;
        //return $memcomp;
        return view('auth.gate')->withMemcomp($memcomp);
    }

    public function showEmaliVerication() {
        //Session::forget('verified_status');
        if (count(Auth::user()->email) == 1 && Auth::user()->email->first()->me_status == 'waiting') {
            return redirect('login/email-verification/success');
        } else if (count(Auth::user()->getActiveEmail(Auth::user()->m_id)) == 1) {
            return redirect('dashboard');
        } else {
            $memcomp = Auth::user()->company;
            return view('auth.email.form')->withMemcomp($memcomp);
        }
    }

    public function sendVerification(Request $request) {
        $rules = [
            'me_email' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response = [
                'status' => 'gagal'
            ];

            return json_encode($response);
        }

        $firstId = date('y', strtotime(Auth::user()->m_birth_tgl)) . '' . date('i');
        $secondId = date('md', strtotime(Auth::user()->m_birth_tgl)) . '' . date('s');
        $vercode = sha1(md5($firstId . '' . $secondId));

        $d_mem_email = new d_mem_email;
        $d_mem_email->me_member = Auth::user()->m_id;
        $d_mem_email->me_email = $request->me_email;
        $d_mem_email->me_isprimary = 0;
        $d_mem_email->me_status = 'waiting';
        $d_mem_email->me_verification_code = $vercode;

        if ($d_mem_email->save()) {

            $member = DB::table('d_mem')->where('m_id', '=', Auth::user()->m_id)->first();
            //return view('auth.email.verification')->withMember($member);

            Mail::send('auth.email.verification', ['member' => $member, 'title' => $vercode,], function ($message) use ($request) {

                $message->from('admin@dboard.com', 'Admin DBoard');

                $message->to($request->me_email);

                $message->subject('Email Verikasi');
            });

            $response = [
                'status' => 'sukses'
            ];

            return json_encode($response);
        }
    }

    public function vericationSuccess() {
        if (count(Auth::user()->email) == 1 && Auth::user()->email->first()->me_status == 'waiting') {
            $memcomp = Auth::user()->company;
            //return $memcomp;
            return view('auth.email.success')->withMemcomp($memcomp);
        } else {
            return redirect('login/email-verification');
        }
    }

    public function verifiedEmail($code) {
        $member_email = d_mem_email::where('me_verification_code', '=', $code)->where('me_member', '=', Auth::user()->m_id);

        //return $member_email->first();

        if ($member_email->first()) {
            $member_email->update([
                'me_isprimary' => 1,
                'me_status' => 'verified'
            ]);

            $member = d_mem::where('m_id', '=', $member_email->first()->me_member);

            $secondIntro = substr($member->first()->m_intro, 1, 1);
            $lastIntro = substr($member->first()->m_intro, 2, 1);

            $member->update([
                'm_intro' => '1' . $secondIntro . $lastIntro,
            ]);

            return redirect('dashboard');
        } else {
            return "user not verified";
        }
    }

    public function step1Show() {

        if (substr(Auth::user()->m_intro, 0, 1) == 0) {
            //return 'a';
            return redirect('login/email-verification');
        } else if (substr(Auth::user()->m_intro, 1, 1) == 0) {
            //return 'b';
            return view('auth.step.step1');
        } else if (substr(Auth::user()->m_intro, 2, 1) == 0) {
            //return 'b';
            return redirect('gate/step2');
        } else if (Auth::user()->m_intro == '111') {
            //return 'c';
            return redirect('dashboard');
        }
    }

    public function passwordReset(Request $request) {
        //return $check;

        $rules = [
            'm_password_lama' => 'required',
            'm_password_baru' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            $response = ['status' => 'gagal', 'content' => 'Ups. Terjadi Kesalahan Server. Coba Lagi Nanti.'];

            return json_encode($response);
        }

        $mem = d_mem::find(Auth::user()->m_id);
        $firstIntro = substr($mem->m_intro, 0, 1);
        $lastIntro = substr($mem->m_intro, 2, 1);

        $check = sha1(md5('passwordAllah') + $request->m_password_lama);

        if ($mem->m_passwd != $check) {
            $response = ['status' => 'gagal', 'content' => 'Password Lama Tidak Tepat.'];

            return json_encode($response);
        }

        $mem->m_passwd = sha1(md5('passwordAllah') + $request->m_password_baru);
        $mem->m_intro = $firstIntro . '1' . $lastIntro;

        if ($mem->save()) {
            $response = ['status' => 'sukses', 'content' => 'Ups. Terjadi Kesalahan Server. Coba Lagi Nanti.'];

            return json_encode($response);
        }
    }

    public function step2Show() {
        if (substr(Auth::user()->m_intro, 0, 1) == 0) {
            // /return 'a';
            return redirect('login/email-verification');
        } else if (substr(Auth::user()->m_intro, 1, 1) == 0) {
            // /return 'b';
            return redirect('gate/step1');
        } else if (substr(Auth::user()->m_intro, 2, 1) == 0) {
            // /return 'b';
            return view('auth.step.step2');
        } else if (Auth::user()->m_intro == '111') {
            // /return 'c';
            return redirect('dashboard');
        }
    }

    public function addComp(Request $request) {
        $rules = [
            'c_name' => 'required',
            'c_address' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $response = ['status' => 'gagal', 'content' => 'Ups. Terjadi Kesalahan Server. Coba Lagi Nanti.'];

            return json_encode($response);
        }

        $id = 'COM-' . date('His');

        $d_comp = new d_comp;
        $d_comp->c_id = $id;
        $d_comp->c_owner = Auth::user()->m_id;
        $d_comp->c_name = $request->c_name;
        $d_comp->c_address = $request->c_address;
        $d_comp->c_type = 12;
        $d_comp->c_control = 1;

        if ($d_comp->save()) {
            Session::set('mem_comp', $id);
            $com_mem = new d_mem_comp;
            $com_mem->mc_mem = Auth::user()->m_id;
            $com_mem->mc_comp = $id;
            $com_mem->mc_lvl = 1;
            $com_mem->mc_step = 0;
            $com_mem->mc_active = 1;

            if ($com_mem->save()) {

                $year = new d_comp_year;

                $year->y_comp = Session::get('mem_comp');
                $year->y_year = date('Y');
                $year->y_active = 1;

                if ($year->save()) {
                    Session::set('comp_year', date('Y'));
                    $member = d_mem::find(Auth::user()->m_id);

                    $firstIntro = substr($member->m_intro, 0, 1);
                    $secondIntro = substr($member->m_intro, 1, 1);

                    $member->update([
                        'm_intro' => $firstIntro . '1' . $secondIntro,
                    ]);

                    $response = ['status' => 'sukses', 'content' => Session::get('mem_comp')];

                    return json_encode($response);
                }
            }
        }
    }

    public function logout() {
        /*
        $d_mem_log = d_mem_log::where('l_mem', '=', Auth::user()->m_id)->where('l_active', '=','Y')->first();        
        if($d_mem_log){
        $d_mem_log->l_active = 'N';
        $d_mem_log->l_out = date('Y-m-d H:i:s');            
        $d_mem_log->save();
        }
         * 
         */
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
    public function ping(){
        $d_mem_log = d_mem_log::where('l_mem', '=', 'MEM-132701')->where('l_active', '=','Y')->max('l_id');        
        dd($d_mem_log);
    }
    
    
}
