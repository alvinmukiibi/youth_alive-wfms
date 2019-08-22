<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $validator = $this->validation($request);

        if($validator->fails()){
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $response['token'] = $user->createToken('youth_alive_passport_token')->accessToken;
            $response['user'] = $user;

            if($user->activity_status == false){
                Auth::logout();
                return redirect()->back()->with('info', 'Account inactive');
            }
            if($user->email_verified_status == false){
                Auth::logout();
                return redirect()->back()->with('info', 'Please verify your email first');
            }

            return redirect()->to('/home');

        }else{
            return redirect()->back()->with('error', 'Wrong Credentials!!');
        }
    }

    public function validation($request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        return $validator;
    }
}
