<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;

class ProcessLoaderUser implements ShouldQueue
{
    use Queueable;
    public $name;
    public $email;
    public $password;
    public $editor;
    public $file_avatar;
    
    /**
     * Create a new job instance.
     */
    public function __construct($name, $email, $password, $editor, $file_avatar)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->editor = $editor;
        $this->file_avatar = $file_avatar;
       
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
       $model = new User();
       $model->name =$this->name;
        $model->email =$this->email;
        $model->password = Hash::make($this->password);
        $model->author = $this->editor;
        $model->avatar = $this->file_avatar;
        $model->save();
    }
}
