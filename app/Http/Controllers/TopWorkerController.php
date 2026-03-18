<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Worker;


class TopWorkerController extends Controller
{
 
     public function topRated()
    {

     $worker = Cache::remember('top_rated_workers', 3600, function () {
         return Worker::where('rate', '>=', 4)
                     ->orderBy('rate', 'desc')
                     ->take(10)
                     ->get()
                     ->toArray();
     });

     return $this->success($worker , 'the Top Worker In Worker_System');
   
     }

}
