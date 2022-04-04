<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    public function reset(Request $request){

        $request->validate([
            'email'=>'required|email|exists:users,email'
        ]);

        $token = \Str::random(64);
        \DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);

        $action_link = route('password.showReset',['token'=>$token,'email'=>$request->email]);
        $body = "Voce esta recebendo esse email para alteração de senha do sistema de portarias do <b>IFNMG-campus Almenara</b> a conta e associada ao email ".$request->email.".Para alterar a senha clique no link abaixo";

        \Mail::send('email-forgot',['action_link'=>$action_link,'body'=>$body], function($message) use ($request){
            $message->from('noreply@example.com','Your App Name');
            $message->to($request->email,'Your Name')
                    ->subject('Alterar Senha');
        });

        return back()->with('msg','O email foi enviado com sucesso!');
    }
}
