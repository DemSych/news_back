<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class ProcessRedact implements ShouldQueue
{
    use Queueable;

    public $title;
    public $short_content;
    public $content;
    public $news_img;
    public $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id, $title, $short_content, $content, $news_img)
    {
        $this->title = $title;
        $this->short_content = $short_content;
        $this->content = $content;
        $this->news_img = $news_img;
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $currentDateTime = now();
        $data = News::find( $this->id);
        if(isset($this->title) && $this->title != null){
            $data->title = $this->title;
        }
        if(isset($this->content) && $this->content != null){
            $data->short_content = $this->short_content;
        }
        if(isset($this->content) && $this->content != null){
            $data->content = $this->content;
        }
        if(isset($this->news_img) && $this->news_img != null){
            $data->news_img = $this->news_img;
        }
        $data->date = $currentDateTime->format('Y-m-d');
        $data->save();
        return;
    }
}
