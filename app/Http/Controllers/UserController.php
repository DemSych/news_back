<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Validators\AuthValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    public function auth(Request $request){
        $validator = AuthValidator::validator($request);
        //$users = DB::table("users")->get();
        
       $user = User::where('email', $request->email)->first();
        
        if($validator->fails()){
            return "Не совпало";
        }
        if ( $user &&  Hash::check($request->password, $user->password)) {
           return ["token" => $user->createToken("front")->plainTextToken];
        }
        else{
            throw ValidationException::withMessages([
                "Ошибка авторизации"
            ]);
        }
        
    }
    public function registration(){

    }
    public function checkUser(Request $request){
        if(isset($request->token)){
            $token = PersonalAccessToken::findToken($request->token);
             if(!$token){
                return null;
             }
            $user = $token->tokenable;
            return $user;
        }
       
    }
}
