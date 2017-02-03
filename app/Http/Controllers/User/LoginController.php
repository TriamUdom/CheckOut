<?php

namespace App\Http\Controllers\User;

use Hash;
use Session;
use App\User;
use Validator;
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
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->all(), 422);
        }

        if(User::where('username', $request->input('username'))->count() == 1){
            $user = User::where('username', $request->input('username'))->first();
        }else{
            $validator->errors()->add('username', 'Incorrect username or password');
            return response()->json($validator->errors()->all(), 422);
        }

        if(Hash::check($request->input('password'), $user['password'])){
            $this->reHashIfRequired($request, $user);
        }else{
            $validator->errors()->add('password', 'Incorrect username or password');
            return response()->json($validator->errors()->all(), 422);
        }

        $this->createLoginSession($request);
        return response()->json('Logged In!', 200);
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
