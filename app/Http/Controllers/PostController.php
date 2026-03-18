<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StorepostRequest;
use App\Services\PostService\StorePostService;
use App\Models\Post;
use Illuminate\Support\Facades\Redis;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquant\Builder;


class PostController extends Controller
{
     
    public function store(StorepostRequest $request){
        return (new StorePostService())->store($request);
    }
      
    public function index()
    {
       $posts =   Post::all();
       return $this->success($posts, 'All posts retrieved successfully');
    }

     public function show($id)
     {
        $post = Post::findOrFail($id);
        Redis::incr('post_views:' . $id); // Increment view Post      
        $views = Redis::get('post_views:' . $id); // Get this View  
        return response()->json([
        'status' => true,
        'data' => $post,
        'real_time_views' => $views
    ]);
     }

    public function approved()
    {
    $posts = QueryBuilder::for(Post::class)
    ->allowedFilters([
      'price',
        AllowedFilter::callback('item', function (Builder $query, $value) {
            // $query->whereHas('posts');
            $query->where('price','like',"%{$value}%");
        }),
    ]);
        return response()->json([
          "posts" => $posts
        ]);
    }
}
