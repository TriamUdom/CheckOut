<?php

namespace App\Http\Controllers\User;

use Hash;
use Session;
use App\User;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Exceptions\LoginException;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginPage(Request $request){
        return view('user.login');
    }

    public function handleLoginRequest(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
            '2fa' => 'required',
        ]);

        $user = User::where('username', $request->input('username'))->first();

        $validateLoginRequest = $this->validateLoginRequest($request, $user);
        if($validateLoginRequest !== true){
            return $validateLoginRequest;
        }else{
            $this->reHashIfRequired($request, $user);
        }

        if($this->createLoginSession($request)){
            return redirect('/');
        }else{
            throw new LoginException('Cannot create login session');
        }
    }

    private function validateLoginRequest(Request $request, $user){
        if(count($user) !== 1){
            return redirect('/login')->withErrors(['username' => 'Username not found']);
        }

        if(!Hash::check($request->input('password'), $user['password'])){
            return redirect('/login')->withErrors(['password' => 'Incorrect password']);
        }

        $google2fa = new Google2FA();

        if(!$google2fa->verifyKey($user->google2fa_secret, $request->input('2fa'))){
            return redirect('/login')->withErrors(['2fa' => 'Incorrect OTP']);
        }

        return true;
    }

    private function reHashIfRequired(Request $request, User $user){
        if(Hash::needsRehash($user['password'])){
            User::where('username', $request->input('username'))->update([
                'password' => Hash::make($request->input('password')),
            ]);
        }

        return true;
    }

    private function createLoginSession(Request $request){
        Session::put([
            'username' => $request->input('username'),
            'user_logged_in' => true,
        ]);

        return true;
    }

    public static function isLoggedIn(){
        return (Session::get('user_logged_in') === true);
    }

    public function showLogoutPage(){
        return view('user.logout');
    }

    public function handleLogout(){
        Session::flush();
        Session::regenerate();

        return redirect('/');
    }
}
