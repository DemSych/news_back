<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessLoaderImges implements ShouldQueue
{
    use Queueable;
    private $request;
    /**
     * Create a new job instance.
     */
    public function __construct($request)
    {
        $this->$request = $request;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
