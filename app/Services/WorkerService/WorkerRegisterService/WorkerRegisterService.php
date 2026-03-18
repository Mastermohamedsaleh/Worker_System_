<?php

namespace App\Services\WorkerService\WorkerRegisterService;



use App\Models\Worker;
use Validator;
use Illuminate\Support\Facades\DB; 


class WorkerRegisterService{
     

      
      
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


   function store($data , $request)
   {
     $worker =  $this->model->create(array_merge(
      $data->validated(),
      [
          'password' => bcrypt($request->password),
          'photo' => $request->file('photo')->store('workers')
      ]
     ));
     return $worker->email;
   }

   function sendemail()
   {

   }


   function generateToken($email)
   {
     $token = substr(md5(rand(0,9).$email.time()) , 0 , 12 );
     $worker = $this->model->whereEmail($email)->first();    
     $worker->verification_token = $token;
     $worker->save();
     return $worker;  
   }
      


   function register($request)
   {

      try{
         DB::beginTransaction();
         $data  = $this->validation($request);
         $email = $this->store($data , $request);
         $Token = $this->generateToken($email);
         DB::commit();
         return response()->json([
         'message'=>'Create Account Successfully'
        ]);

      }catch(Exception $e){
        DB::rollBack();
      }




   }

}