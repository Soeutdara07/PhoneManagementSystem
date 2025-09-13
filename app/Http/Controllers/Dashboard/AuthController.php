<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){
        return view('back_end.login');
    }
    
    public function authenticate(Request $request){
          $validator = Validator::make($request->all(),[
             'email' => 'required',
             'password' => 'required'
          ]);

          if($validator->passes()){
             // Attempt to authenticate the user
             $credentials = $request->only('email', 'password');
             if(Auth::attempt($credentials,$request->filled('remember'))){

                if(Auth::user()->role == 1){
                    return redirect()->route('dashboard.index');
                }else{
                    return redirect()->back()->with('error','You are not admin');
                }
             }else{
                return redirect()->back()->with('error','Invalid Password or Email');
            }
          }else{
            return redirect()->back()->withInput()->withErrors($validator->errors());
          }
    }

    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.index');
    }
}
