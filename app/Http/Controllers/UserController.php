<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLoaderUser;
use App\Models\User;
use App\Validators\AuthValidator;
use App\Validators\ImgValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    public function auth(Request $request){
       $validator = AuthValidator::validator($request);
       $user = User::where('email', $request->email)->first();
        
        if($validator->fails()){
           
            return [$validator->errors()->all()];
        }
        if ( $user &&  Hash::check($request->password, $user->password)) {
           return ["token" => $user->createToken("front")->plainTextToken];
        }
        else{
            return 'Не верный логин или пароль';
        }
        
    }
    public function postLoaderAvatar(Request $request){
        if ($request->hasFile('myFile') ) {
             $validator = ImgValidator::validator($request);
                if($validator->fails()){
                    return null;
            }
             $path = $request->file('myFile')->store('user', 'public');
             $url = Storage::url($path);
            return $url;
        }       
        return null;
    }
    public function registration(Request $request){
         $validator = AuthValidator::validator($request);
        if($validator->fails()){
            return [$validator->errors()->all()];
        }
        ProcessLoaderUser::dispatch($request->name_user, $request->email,$request->password,$request->editor,$request->name_img);
       // return ["token" => $request->createToken("front")->plainTextToken];
       return true;
        
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
