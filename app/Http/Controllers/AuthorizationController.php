<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function registerIndex(){
        return view('register');
    }
    public function register(Request $request){
        $request -> validate([
           'email' => 'required | email',
           'name' => 'required | string | max:255',
           'password' => 'required | string | min:8'
        ]);

        if($request -> password == $request -> password_confirm){
            $user = User::create([
                'email' => $request -> email,
                'name' => $request -> name,
                'password' => Hash::make($request -> password)
            ]);

            Auth::login($user);

            return redirect() -> route('login');
        }else{
            return back() -> withErrors('The password dosen\'t match');
        }


    }

    public function loginIndex(){
        return view('login');
    }

    public function login(Request $request){
        $login = $request -> validate([
           'email' => 'required | email',
           'password' => 'required'
        ]);

        if (Auth::attempt($login)){
            return redirect() -> route('index');
        }
        else{
            return back()->withErrors([
                'login_failed' => 'Login Failed'
            ]);
        }
    }

    public function logout(){
        Auth::logout();

        return redirect() -> route('login');
    }
}
