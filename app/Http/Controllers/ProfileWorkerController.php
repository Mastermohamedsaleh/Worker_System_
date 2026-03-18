<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\WorkerReview;
use App\Models\Worker;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\WorkerService\WorkerUpdateService\WorkerUpdateService;

class ProfileWorkerController extends Controller
{
    public function workerprofile()
    {

        $workerId = auth()->guard('worker')->id();
        $worker = Worker::with('posts')->find($workerId);
         $reviews = WorkerReview::whereIn('post_id' , $worker->pluck('id'))->get();

               $reviews =  WorkerReview::with('post')->find($worker->pluck('id'));
               $reviews = $reviews->sum('rate')/$reviews->count();
    
        return response()->json([

             'data' => $worker,
             'worker'=>auth()->guard('worker')->user(),
             'reviews'=>$reviews  
        ]);

        
    }


    public function edit()
    {
        return response()->json([      
              "worker"=>  Worker::find(auth()->guard('worker')->id())->makehidden('status')
          ]);
    }

    public function update(UpdateProfileRequest $request){
       return (new WorkerUpdateService())->update($request);




    }

    public function deleteallposts(){
        Post::where('worker_id',auth()->guard('worker')->id())->delete();
        return response()->json([
            "message" => "You delete All Posts"
        ]);
    }


}
