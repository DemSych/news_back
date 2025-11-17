<?php 
    namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

    class ImgValidator{

        public static function validator(Request $request){
            //dd($request);
            return Validator::make($request->all(),[
                'myFile' => 'image',   
            ],[
                "myFile.image" => "Загруженный  файл должен быть изображением (jpg, jpeg, png, bmp, gif или webp)  ",
            ]);

            
        }
    }