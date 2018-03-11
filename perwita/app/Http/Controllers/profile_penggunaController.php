<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\d_mem_email;

use App\d_mem;

use DB;

use Mail;

use Auth;

use Validator;
class profile_penggunaController extends Controller
{
    public function index() {
        $id=Auth::user()->m_id;
        
        $profil = DB::select(DB::raw(
                  "select mem.*,GROUP_CONCAT(me_email SEPARATOR ' , ') as email,
                   (select me_email from d_mem_email email where 
                    mem.m_id=email.me_member  and email.me_isprimary=1)
                    as email_active 
                   from d_mem mem,d_mem_email mem_email 
                   where m_id='$id' and mem.m_id=mem_email.me_member
                   GROUP BY mem.m_id"))[0]; //total             
        //dd($profil);
         $email=d_mem_email::select('me_email')->where('me_member','=',$id)->get();
        $email_Active=d_mem_email::select('me_email')->where('me_member','=',$id)->where('me_isprimary','=','1')->first();        
        return view('data-master.profile-pengguna.index',compact('profil','email','email_Active'));        
    }
    public function edit($id) {        
        $profil = DB::select(DB::raw(
                  "select mem.*,GROUP_CONCAT(me_email SEPARATOR ' , ') as email,
                   (select me_email from d_mem_email email where 
                    mem.m_id=email.me_member  and email.me_isprimary=1)
                    as email_active 
                   from d_mem mem,d_mem_email mem_email 
                   where m_id='$id' and mem.m_id=mem_email.me_member
                   GROUP BY mem.m_id"))[0]; 
        $email=d_mem_email::select('me_email')->where('me_member','=',$id)->get();
        $email_Active=d_mem_email::select('me_email')->where('me_member','=',$id)->where('me_isprimary','=','1')->first();        
        return view('data-master.profile-pengguna.edit_profil',compact('profil','email','email_Active')); 
    }
    public function tambah_email(Request $request) {    
//        $rules = array(
//            'email' => 'required|email|unique:d_mem_email,me_email',           
//        );
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails()) {
//            return response()->json([
//                        'success' => false,
//                        'errors' => $validator->errors()->toArray()
//            ]);
//        }else{
//        $email=new d_mem_email;
//        $email->me_member=$request->member;
//        $email->me_email =$request->email;
//        $email->save();
//        return response()->json([
//                        'success' => true,
//                        'id' =>$request->member
//        ]);
//        }
        
        
        
        
        $rules = [
             'email' => 'required|email|unique:d_mem_email,me_email',           
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        }else{

        $firstId = date('y', strtotime(Auth::user()->m_birth_tgl)) . '' . date('i');
        $secondId = date('md', strtotime(Auth::user()->m_birth_tgl)) . '' . date('s');
        $vercode = sha1(md5($firstId . '' . $secondId));

        $d_mem_email = new d_mem_email;
        $d_mem_email->me_member = Auth::user()->m_id;
        $d_mem_email->me_email = $request->email;
       // $d_mem_email->me_isprimary = 0;
        $d_mem_email->me_status = 'waiting';
        $d_mem_email->me_verification_code = $vercode;

        if ($d_mem_email->save()) {

            $member = DB::table('d_mem')->where('m_id', '=', Auth::user()->m_id)->first();
            //return view('auth.email.verification')->withMember($member);

            Mail::send('auth.email.verification', ['member' => $member, 'title' => $vercode,], function ($message) use ($request) {

                $message->from('admin@dboard.com', 'Admin DBoard');

                $message->to($request->email);

                $message->subject('Email Verikasi');
            });

            return response()->json([
                        'success' => true,
                        'id' =>Auth::user()->m_id
       ]);
        }
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    public function update(Request $request,$id) {       
        $rules = array(
            //'m_username' => 'required',           
            'm_name' => 'required',           
            'm_birth_tgl' => 'required',           
            'm_addr' => 'required',           
            'email_active' => 'required|email',           
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
             return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()->toArray()
            ]);
        }else{
        $request->m_birth_tgl = date('Y-m-d', strtotime($request->m_birth_tgl));
        $d_mem=d_mem::where('m_id','=',$id)->first();
       // $d_mem->m_username  =   $request->m_username;
        $d_mem->m_name      =   $request->m_name;
        $d_mem->m_birth_tgl =   $request->m_birth_tgl;
        $d_mem->m_addr      =   $request->m_addr;  
        $d_mem->save();
        
        $reset_email=d_mem_email::where('me_member','=',$id);
        $d_mem_email=d_mem_email::where('me_email','=',$request->email_active)
                    ->where('me_member','=',$id);
        
        if($reset_email->update([ 'me_isprimary' =>0 ])){
        $d_mem_email->update([
            "me_isprimary"  =>  1
        ]);
        }
        return response()->json([
                        'success' => true,
        
        ]);
        }
    }
    
    public function hapus_email($id) { 
        $d_mem_email=d_mem_email::where('me_email','=',$id);
        if($d_mem_email->first()->me_isprimary!=1){
        $d_mem_email->delete();
        return 'sukses';
        }
        else if ($d_mem_email->first()->me_isprimary==1)
        return 'Email Aktif';
    }
    public function log_pengguna() {
       $mem_log= DB::table('d_mem')->join('d_mem_log', 'd_mem_log.l_mem', '=', 'd_mem.m_id')
               ->where('d_mem.m_id',Auth::user()->m_id)->orderBy('l_id', 'DESC')->get();
       return view('data-master.profile-pengguna.log',compact('mem_log'));
    }
    public function management_password() {
        return view('data-master.profile-pengguna.management_password');
        
    }
     public function management_password_update(Request $request) {                                
        $rules = [
            'password_lama' => 'required',
            'm_passwd' => 'required',
            'konfirmasi_password' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);
        
        if ($validation->fails()) {
           return response()->json([
                        'success' => false,
                        'errors' => $validation->errors()->toArray()
            ]);
        }

        $mem = d_mem::find(Auth::user()->m_id);
        $check = sha1(md5('passwordAllah') + $request->password_lama);

        if ($mem->m_passwd != $check) {
            $validation->getMessageBag()->add('login', 'Password Yang Anda Masukkan Salah.'); //manual validation                            
            return response()->json([
                        'success' => false,
                        'errors' => $validation->errors()->toArray()
            ]);
        }
        else if ( $request->m_passwd!=$request->konfirmasi_password) {
            $validation->getMessageBag()->add('login', 'Password Dan Konfirmasi Password Tidak Sesuai.'); //manual validation                            
            return response()->json([
                        'success' => false,
                        'errors' => $validation->errors()->toArray()
            ]);
        }

        $mem->m_passwd = sha1(md5('passwordAllah') + $request->m_passwd);
        if ($mem->save()) {            
             return response()->json([
                        'success' => true,        
            ]);
        }
    }
    
    
}
