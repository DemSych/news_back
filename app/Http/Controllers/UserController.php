<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLoaderUser;
use App\Mail\NewsMail;
use App\Mail\OrderShipped;
use App\Models\User;
use App\Validators\AuthValidator;
use App\Validators\ImgValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        if($request->password!=$request->second_password){
            return "Пароли не совпадают";
        }
         $validator = AuthValidator::validator($request);
        if($validator->fails()){
            return [$validator->errors()->all()];
        }
        ProcessLoaderUser::dispatch($request->name_user, $request->email,$request->password,$request->name_img);
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
    public function postFaileUsers(Request $request){
        $data =[];
        $data = User::select('id','name', 'email', 'admin', 'avatar')->get();
        return $data;
    }
    public function postFaileBlockedUser($userId) {
        $data = [];
        $data = User::find($userId);
        $data->admin = 'user';
        $data->save();
        $indexController = new IndexController();
        $result = $indexController ->mail($data->email, "Вам закрыт доступ в admin на сайте News");
        return;
    }
    public function postFaileActiveUser($userId) {
        $data = [];
        $data = User::find($userId);
        $data->admin = 'admin';
        $data->save();
        $indexController = new IndexController();
        $result = $indexController ->mail($data->email, "Вам открыт доступ в admin на сайте News");
        return;
    }
   
}
