<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getFaileNews(){
        $data =[];
        $data = News::get();
        return $data;
    }
}
