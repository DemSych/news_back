<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLikePlus;
use App\Jobs\ProcessLoaderNews;
use App\Jobs\ProcessViewsPlus;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class IndexController extends Controller
{
    public function getFaileNews(){
        $data =[];
        $data = News::get();
        return $data;
    }
    public function getFaileNewsChild(Request $request, $newsId){
        ProcessViewsPlus::dispatch($newsId);
        $newsChild = News::where('id',  $newsId)->first();
        return $newsChild;
    }
    public function likePlus($newsId){
        ProcessLikePlus::dispatch($newsId);
        return ;
    }
    public function faileNewsAutor($AuthorId){
        $authorNews = News::where('author_id',  $AuthorId)->get();
        return $authorNews;
    }
    public function postLoaderImages(Request $request){
        $path = $request->file('myFile')->store('imges');

        if ($request->hasFile('myFile') ) {
            
             $path = $request->file('myFile')->store('imges', 'public');
             $url = Storage::url($path);
            return $url;
        }       
     return null;
        
    }
    public function postLoaderNews(Request $request){
        $title = $request->title;
        $short_content = $request->short_content;
        $content = $request->content;
        $news_img = $request->name_img;
        $author_id = $request->userId;
    
        ProcessLoaderNews::dispatch($title,$short_content,$content,$news_img,$author_id);
        
        return;
    }
}
