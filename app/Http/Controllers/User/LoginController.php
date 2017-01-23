<?php

namespace App\Http\Controllers\User;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginPage(Request $request){
        return view('user.login');
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
