<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdatePostViews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

     

    protected $postId;
    protected $views;

    public function __construct($postId, $views)
    {
       $this->postId = $postId;
        $this->views = $views;
    }
    
    public function handle()
    {
       \App\Models\Post::where('id', $this->postId)->update([
        'views' => $this->views
      ]);
    }
}
