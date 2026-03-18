<?php

namespace App\Services\WorkerService\WorkerLoginService;

use App\Models\Worker;
use Validator;


class WorkerLoginService
{
  
   protected  $model;
    
   function __construct()
   {
      $this->model = new Worker;
   }

   function validation($request)
   {
    $validator = Validator::make($request->all() , $request->rules());

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    return $validator;

   }

   function inValidData($data)
   {

    if (! $token = auth()->guard('worker')->attempt($data->validated())) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }  
     return $token;
   }

   function getStatus($email)
   {
       $worker = $this->model->whereEmail($email)->first();
       $status = $worker->status;
       return $status;
   }
   
   function isVerified($email)
   {
       $worker = $this->model->whereEmail($email)->first();
       $verified = $worker->verified_at;
       return $verified;
   }

   protected function createNewToken($token)
   {
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL() * 60,
        'user' => auth()->guard('worker')->user()
    ]);
}

  function login($request)
  {
    $data = $this->validation($request);
    $Token =  $this->inValidData($data);

    if($this->isVerified($request->email) == null){
      return response()->json("Your account is not Verified Please Wait ... ");
    }elseif($this->getStatus($request->email) == 0 ){
     
      $token =  $this->createNewToken($Token);
      return  response()->json([
        'massage' =>"Your account is pandding",
         'token' => $token 
      ],200);
    }


  } //end one if


}