<?php

namespace App\Jobs;
use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessViewsPlus implements ShouldQueue
{
    use Queueable;
    private $idNews;
    /**
     * Create a new job instance.
     */
    public function __construct($idNews)
    {
       $this->idNews = $idNews;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
         $model= News::where('id',$this->idNews)->first();   
        $model->views++;
        $model->save();
        return;
    }
}
