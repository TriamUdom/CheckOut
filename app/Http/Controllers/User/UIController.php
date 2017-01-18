<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UIController extends Controller
{
    public function showIndexPage(Request $request){
        return view('user.index');
    }
}
