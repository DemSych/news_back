<?php 
    namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    class AuthValidator{

        public static function validator(Request $request){
            //dd($request);
            return Validator::make($request->all(),[
                'email' => 'required|min:2|max:20|email',
                'password' => 'required|min:2|max:10|alpha_dash',
                
            ],[
                "email.required" => "Не заполнено обязательное поле Email. ",
                "email.min" => "Минимальная длина поля Email 5 символов. ",
                "email.max" => "Максимальная длина поля Email 20 символа. ",
                "email.email"=> "Не верный формат электронной почты. ",
                "password.required" => "Не заполнено обязательное поле Password. ",
                "password.min" => "Минимальная длина поля Password 2 символа. ",
                "password.max" => "Максимальная длина поля Password 20 символов. ",
                "password.alpha_dash" => "Пароль должен содержать только латинские буквы, цифры, знаки подчёркивания (_) и дефисы (-). ",
            ]);

            
        }
    }