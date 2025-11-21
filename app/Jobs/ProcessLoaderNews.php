<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessLoaderNews implements ShouldQueue
{
    use Queueable;
    public $title;
    public $short_content;
    public $content;
    public $news_img;
    public $author_id;
    /**
     * Create a new job instance.
     */
    public function __construct($title, $short_content, $content, $news_img, $author_id)
    {
        $this->title = $title;
        $this->short_content = $short_content;
        $this->content = $content;
        $this->news_img = $news_img;
        $this->author_id = $author_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $currentDateTime = now();
        $model = new News;
        $model->title =$this->title;
        $model->short_content = $this->short_content;
        $model->content = $this->content;
        $model->news_img = $this->news_img;
        $model->author_id = $this->author_id;
        $model->date = $currentDateTime->format('Y-m-d');
        $model->like = 0;
        $model->views = 0;
        $model->status = "active";
        $model->save();
    }
    
}
