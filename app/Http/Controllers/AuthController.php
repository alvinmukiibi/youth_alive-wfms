<?php

namespace App\Http\Controllers;

use App\Jobs\LoggedInJobs;
use App\Notifications\ForgotPasswordNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $validator = $this->validation($request);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // $response['token'] = $user->createToken('youth_alive_passport_token')->accessToken;
            // $response['user'] = $user;

            if ($user->activity_status == false) {
                Auth::logout();
                return redirect()->back()->with('info', 'Account inactive');
            }
            if ($user->email_verified_status == false) {
                Auth::logout();
                return redirect()->back()->with('info', 'Please verify your email first');
            }

            if ($user->settings()->value('receive_login_notifications')) {
                $job = new LoggedInJobs;
                $job->user = $user;
                $job->ip = $request->ip();
                dispatch($job);
            }


            return redirect()->to('/home');
        } else {
            return redirect()->back()->with('error', 'Wrong Credentials!!');
        }
    }

    public function validation($request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        return $validator;
    }

    public function forgotPassword(Request $request)
    {
        return view('auth.forgot-password');
    }
    public function sendLink(Request $request)
    {
        $data = $this->validate($request, [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email address is invalid'
        ]);
        $user = User::where('email', $request->email)->first();
        $notification = new ForgotPasswordNotification;
        $notification->user = $user;
        $token = \bcrypt($user->email);
        $notification->token1 = Crypt::encrypt($user->email);
        $notification->token2 = Crypt::encrypt($token);
        $count = DB::table('password_resets')->where('email', $user->email)->count();
        if($count < 1){
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token]);
        }
        Notification::send($user, $notification);

        return redirect()->back()->with('info', 'Password reset link has been sent to your email address!!');
    }

    public function resetPassword(Request $request){

        $token1 = $request->segment(3);
        $token2 = $request->segment(4);

        $email = Crypt::decrypt($token1);

        $dbtoken = DB::table('password_resets')->where('email', $email)->value('token');

        if(Hash::check($email, $dbtoken) && Hash::check($email, Crypt::decrypt($token2))){
            return view('auth.reset')->with('email', $email);
        }else{
            return redirect()->to('/forgot')->with('error', 'Error, Please retry');
        }

    }

    public function doReset(Request $request){

        $data = $this->validate($request, [
            'password' => 'required|min:8|confirmed',
            'email' => 'required|exists:users,email'
        ]);

        User::where('email', $data['email'])->update(['password' => Hash::make($data['password'])]);

        return redirect('login')->with('info', 'Password successfully changed!!');


    }

    public function verifyEmail(Request $request){

        $email = Crypt::decrypt($request->segment(3)) ;

        User::where('email', $email)->update(['email_verified_status' => true]);

        return redirect()->to('/login')->with('info', 'Email address verified successfully!');

    }
}
