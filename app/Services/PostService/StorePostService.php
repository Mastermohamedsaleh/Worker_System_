<?php

namespace App\Services\PostService;


use App\Models\Post;
use App\Models\Admin;
use App\Models\PostPhoto;
use Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminPost;


class StorePostService {


     
   protected  $model;
    
   function __construct()
   {
      $this->model = new Post;
   }

   function validation($request)
   {
    $validator = Validator::make($request->all() , $request->rules());

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    return $validator;

   }


   function addminPercent($price)
   {
      $discount = $price * 0.05 ;
      $priceAfterDiscount = $price - $discount;
      return $priceAfterDiscount; 
   }



   function storePost($data)
   {
      $data = $data->except('photo');
      $data['price'] = $this->addminPercent($data['price']);
      $data['worker_id'] = auth()->guard('worker')->id();
      $post = Post::create($data);
      return $post;
   }



   function storePostPhotos($request , $postid){

    foreach($request->file('photo') as $pho){
        $postphotos = new PostPhoto();
        $postphotos->post_id = $postid; 
        $postphotos->photo = $pho->store('posts');
        $postphotos->save();
    }
   }


   function sendNotifacationadmin($post)
   {
      $Admins = Admin::get();
      Notification::send($Admins, new AdminPost(auth()->guard('worker')->user() , $post));
   }


   function store($request)
   {
           $post = $this->storePost($request);
           if($request->hasfile('photo')){
               $this->storePostPhotos($request , $post->id);
           } //end if
           $this->sendNotifacationadmin($post);
           return response()->json([
            'message'=> "Post has been created Successfully , Your price after discount is {$post->price}"
           ]);
   }




}