<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Mail;

use DB;

use Auth;

class emailController extends Controller
{
    public function sendValidation(){

    	$member = DB::table('d_mem')->where('m_id', '=', Auth::user()->m_id)->first();
    	//return view('auth.email.verification')->withMember($member);
        $title = 'haha';
        $content = 'jaja';

       Mail::send('auth.email.verification', ['member' => $member , 'title' => $title], function ($message)
        {

            $message->from('swamsid@gmail.com', 'Dirga Ambara');

            $message->to('taziz704@gmail.com');

            $message->subject('Email Verification');

        });

        return response()->json(['message' => 'Request completed']);
    }
}
