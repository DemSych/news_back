<?php 
    namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    class AuthValidator{

        public static function validator(Request $request){
            //dd($request);
            return Validator::make($request->all(),[
                'email' => 'required|min:2',

                'password' => 'required|min:2|max:10',
                
            ],[
                "email.required" => "не заполнено обязательное поле",
                "email.min" => "Минимальная длина 2 символа",
                "password.max" => "Минимальная длина 2 символа",
                "password.max" => "Максимальная длина 10 символов",
            ]);

            
        }
    }