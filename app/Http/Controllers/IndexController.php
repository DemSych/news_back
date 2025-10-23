<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessLikePlus;
use App\Jobs\ProcessViewsPlus;
use App\Models\News;
use Illuminate\Http\Request;

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
}
