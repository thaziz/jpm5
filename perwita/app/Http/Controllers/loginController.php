<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\mMember;
use App\d_comp_coa;
use App\d_comp_trans;
use App\d_comp;
use Validator;
use Carbon\Carbon;
use Session;

use DB;

class loginController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function __construct(){
        $this->middleware('guest');
    }

    public function login(Request $req) {
        $username = $req->username;
        $password = $req->password;
        $user = mMember::whereRaw("m_username  = '$req->username'")->first();
        if ($user && $user->m_passwd == sha1(md5('passwordAllah') + $req->password)) {
            return response()->json([
                        'success' => 'succes',
            ]);
        } else {
            return response()->json([
                        'success' => 'gagal',
            ]);
        }
    }

    public function authenticate(Request $req) {
        $rules = array(
            'username' => 'required|min:3', // make sure the email is an actual email
            'password' => 'required|min:2' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return Redirect('/')
                            ->withErrors($validator) // send back all errors to the login form
                            ->withInput($req->except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            $username = $req->username;
            $password = $req->password;
            $user = mMember::whereRaw("m_username  = '$req->username'")->first();

//               
            if ($user && $user->m_passwd == sha1(md5('passwordAllah') + $req->password)) {

               // Auth::login($user); //set login
                
                 $user1=mMember::find($user->m_id);
                 $user1=$user->update([
                     'm_lastlogin'=>Carbon::now(),
                 ]);              

                    Auth::login($user);
                     $dataInfo=['status'=>'sukses','nama'=>$user->m_name];            
                      return json_encode($dataInfo);
            } else {
                $validator->getMessageBag()->add('login', 'Password atau Nama Salah.'); //manual validation                
                return redirect('/')->withErrors($validator)->withInput();
            }
        }
    }

}
