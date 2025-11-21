<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmail;
use App\Jobs\ProcessLikePlus;
use App\Jobs\ProcessLoaderNews;
use App\Jobs\ProcessRedact;
use App\Jobs\ProcessViewsPlus;
use App\Mail\NewsMail;
use App\Models\News;
use App\Models\User;
use App\Validators\ImgValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class IndexController extends Controller
{
    public function getFaileNews(){
        $data =[];
        $data = News::orderByDesc('id')->get();
        return $data;
    }
    public function getFaileActivNews(){
        $data =[];
        $data = News::orderByDesc('id')->where('status', 'active')->get();
        return $data;
    }
    public function getFaileNewsChild($newsId){
        $newsChild = News::where('id',  $newsId)->first();
        return $newsChild;
    }
    public function likePlus($newsId){
        ProcessLikePlus::dispatch($newsId);
        return "Спасибо за Ваш Like";
    }
    public function getViewsPlus($newsId){
         ProcessViewsPlus::dispatch($newsId);
         return;
    }
    public function faileNewsAutor($AuthorId){
        $authorNews = News::where('author_id',  $AuthorId)->get();
        return $authorNews;
    }
    public function postLoaderImages(Request $request){
       
        if ($request->hasFile('myFile') ) {
            $validator = ImgValidator::validator($request);
                if($validator->fails()){
                    return "Не прошло валидацию";
            }
             $path = $request->file('myFile')->store('imges', 'public');
             $url = Storage::url($path);
            return $url;
        }       
     return "Не загружен файл";
        
    }
    public function postLoaderNews(Request $request){
      
        ProcessLoaderNews::dispatch($request->title,$request->short_content,$request->contents,$request->name_img, $request->userId);
        
        return "Загрузка прошла успешно";
    }
    public function postDeleteNews($newsId){
         $news = News::where('id',  $newsId)->first();
          if($news->news_img != null){
            $segments = explode('storage/', $news->news_img);
            if (Storage::disk('public')->exists($segments[1])) { // Проверяем существование файла на диске
                Storage::disk('public')->delete($segments[1]); // Удаляем файл
            return 'Файл удален';
            }   
          }
         $news->delete();
        return;
    }
    public function getFaileNewsLike(){
       $data =[];
        $data = News::orderByDesc('like')->orderByDesc('views')->where('status', 'active')->get();
        return $data;
    }
    public function postRedactNews(Request $request){
            if($request->news_img != null){
            $segments = explode('storage/', $request->news_img);
            if (Storage::disk('public')->exists($segments[1])) { // Проверяем существование файла на диске
                Storage::disk('public')->delete($segments[1]); // Удаляем файл
            return 'Файл удален';
            }   
          }
     
        ProcessRedact::dispatch($request->id, $request->title,$request->short_content,$request->contents,$request->name_img);
        return 'Обновление контента прошло успешно';
    }
    public function getFaileBlockedNews($newsId){
        $data = [];
        $user = [];
        $data = News::find($newsId);
        $data->status = 'blocked';
        $data->save();
        $user = User::where('id',  $data->author_id)->first();
        $this->mail($user->email, "Ваш пост заблокирован администратором");
        return ;
    }
    public function getFaileActiveNews($newsId){
        $data = [];
        $user = [];
        $data = News::find($newsId);
        $data->status = 'active';
        $data->save();
        $user = User::where('id',  $data->author_id)->first();
        $this->mail($user->email, "Ваш пост активирован");
        return ;
    }
     public function mail($email, $data){
        
       ProcessEmail::dispatch($email, $data);
    }
}
