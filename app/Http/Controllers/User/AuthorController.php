<?php

namespace App\Http\Controllers\User;

use Session;
use App\User;
use App\Authorized;
use phpseclib\Crypt\RSA;
use Illuminate\Http\Request;
use App\Exceptions\RSAException;
use PragmaRX\Google2FA\Google2FA;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function showAuthorPage(){
        return view('user.author');
    }

    public function handleAuthorization(Request $request){
        if(!$this->validateToken($request->input('token'))){
            return response()->json([], 401);
        }

        $this->validate($request, [
            'student_id' => 'required|integer|digits:5',
        ]);
    }

    public function validateGoogle2FA(Request $request){
        $google2fa = new Google2FA();
        $user = User::where('username', Session::get('username'))->firstOrFail();

        if($google2fa->verifyKey($user->google2fa_secret, $request->input('2fa'))){
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            Session::flash('author_key', $token);

            return response()->json([
                'status' => 'ok',
                'token' => $token,
            ], 200);
        }else{
            return response()->json([
                'status' => 'Invalid 2 factor token'
            ], 401);
        }
    }

    private function validateToken(String $token){
        return ($token === Session::get('author_key'));
    }

    private function verifyValidCommand(){

    }

    private function getRSAKey(){
        $key['publickey'] = User::where('username', Session::get('username'))->pluck('rsa_key.public_key')[0];
        $key['privatekey'] = User::where('username', Session::get('username'))->pluck('rsa_key.private_key')[0];

        // TODO : Decrypt the keys (Since these keys will be encrypted)

        return $key;
    }

    private function signCheckOutRequest($message){
        $rsa = new RSA;
        $key = $this->getRSAKey();

        if(!$rsa->loadkey($key['privatekey']) || !$rsa->loadkey($key['publickey'])){
            throw new RSAException('Cannot load keypair');
        }

        if(!$rsa->sign($message)){
            throw new RSAException('Cannot sign message');
        }else{
            return bin2hex($rsa->sign($message));
        }
    }

    private function authorizeCheckOut(Request $request){
        Authorized::insert([
            'student_id' => $request->input('student_id'),
            'signature' => 'sign',
        ]);
    }

    private function validateCheckOutRequest(){
        return;
    }
}
