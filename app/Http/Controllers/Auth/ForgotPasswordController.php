<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User; 
use Mail; 
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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

    /**
       * Write code on Method
       *
       * @return response()
       */
      public function showForgetPasswordForm(){
            return view('auth.forgetPassword');
        }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitForgetPasswordForm(Request $request){
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
          $user = User::where('email', $request->input('email'))->first();
          $email = $user->email;
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
  
          Mail::send('email.forgetPassword', ['token' => $token], function($message) use($email){
              $message->from(env('MAIL_USERNAME', 'Sistema de Portarias'));
              $message->to($email);
              $message->subject('Reset Password');
          });
  
          return back()->with('msg', 'Link com redefinição de senha enviado com sucesso, por favor confira seu email ou sua caixa de span!');
        }
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function showResetPasswordForm($token) { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
        }
  
      /**
       * Write code on Method
       *
       * @return response()
       */
      public function submitResetPasswordForm(Request $request){

        $msg = [
            'same'    => 'Senhas precisam ser iguais.',
            'min' => 'Senha precisa de pelo menos 8 caracteres.',
            'exists' => 'E-mail inválido.'
        ];
                
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'min:8', 'confirmed', 'string', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'same:password']
        ], $msg);

        $updatePassword = DB::table('password_resets')
                            ->where([
                              'email' => $request->email, 
                              'token' => $request->token
                            ])
                            ->first();
  
        if(!$updatePassword){
            return back()->withInput()->with('msgE', 'Token Inválido!');
        }
        
        try{
          $user = User::where('email', $request->email)
                  ->update(['password' => Hash::make($request->password),
                  'alter_password' => 1
                ]);

          DB::table('password_resets')->where(['email'=> $request->email])->delete();
          return redirect('/login')->with('msg', 'Sua Senha foi alterada com sucesso!');

        }catch(QueryException $e){
          return redirect()->back()->with('msgE','Erro ao editar senha!');
       }
          
      }
}
