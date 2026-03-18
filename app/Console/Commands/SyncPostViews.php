<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

use App\Jobs\UpdatePostViews;

class SyncPostViews extends Command
{
 
  protected $signature = 'sync:post-views';


    protected $description = 'This Command To Update Views In Posts From Redis To Database';

    public function handle()
    {
      $keys = Redis::keys('post_views:*');
      foreach ($keys as $key) {
      $views = Redis::get($key);

    if($views !== null) {
        $postId = str_replace("laravel_database_post_views:", '', $key);
        UpdatePostViews::dispatch($postId, $views);
    }
      
       }
 
    }
}
