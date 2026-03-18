<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WorkerReviewRequest;

use App\Models\WorkerReview;

class WorkerReviewController extends Controller
{
     
 
    public function store(WorkerReviewRequest $request)
    {

        $data = $request->all();
        $data['client_id'] = auth()->guard('client')->id();
        $reviews = WorkerReview::create($data);
        return response()->json([
          'data'=>$reviews
        ]);
    }

    public function postRate($id)
    {

    $reviews = WorkerReview::wherePostId($id);

        $avg = $reviews->sum('rate') / $reviews->count();

        return response()->json([
            'total_rate'=>  round($avg , 1)
          ]);


    }
      

}
