<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::WELCOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function updatePassword(Request $request){
        // The passwords matches
            $input = $request->all();
    
            $msg = [
                'same'    => 'Senhas precisam ser iguais',
                'different'    => 'Senha atual igual à antiga',
            ];
            
            $user = User::findOrFail($request->id);
            $validator = Validator::make($request->all(),[
                'newPassword' => ['required', 'min:8', 'different   :senhaAntiga'],
                'confirmaSenha' => ['required', 'same:newPassword']
            ], $msg);
    
            if($validator->fails()){
                #
                return redirect()->back()->with('msgE','Erro ao editar senha!');
            }else{
                try{
                    $user_id = $request->id;
                    $user->password =  Hash::make($request->newPassword);
                    $user->alter_password = 1;
                    $user->save();
                    return redirect()->back()->with("msg","Senha alterada com suucesso!");
                    
                }catch(QueryException $e){
                    return redirect()->back()->with('msgE','Erro ao editar senha!');
                } 
            }   
        }
}
