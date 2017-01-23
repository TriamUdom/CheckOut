<?php

namespace App\Http\Controllers\User;

use Hash;
use Session;
use App\User;
use Illuminate\Http\Request;
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
        ]);

        $user = User::where('username', $request->input('username'))->first();

        $validateLoginRequest = $this->validateLoginRequest($request, $user);
        if($validateLoginRequest !== true){
            return $validateLoginRequest;
        }else{
            $this->reHashIfRequired($request, $user);
        }

        return $this->createLoginSession($request);
    }

    private function validateLoginRequest(Request $request, User $user){
        if(count($user) !== 1){
            return redirect('/login')->withErrors(['username' => 'Username not found']);
        }

        if(!Hash::check($request->input('password'), $user['password'])){
            return redirect('/login')->withErrors(['password' => 'Incorrect password']);
        }

        // TODO : 2FA Authen goes here

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

        return redirect('/');
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
