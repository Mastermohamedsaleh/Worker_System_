<?php

namespace App\Services\WorkerService\WorkerUpdateService;



use App\Models\Worker;
use Validator;



class WorkerUpdateService {
      
    protected  $model;
    
    function __construct()
    {
       $this->model =  Worker::find(auth()->guard('worker')->id());
    }

    public function password($data){
 
        if(request()->has('password')){
           return $data['password'] = bcrypt(request()->password);
        }//end if
 
        $data['password'] = $this->model->password;
        return $data;
         
    }

    public function photo($data){
        if(request()->hasFile('photo')){
            $data['photo'] = (request()->file('photo') instanceof UploadedFile) ? request()->file('photo')->store('workers') : $this->model->photo;
            return $data;
        }//end if
        $data['photo'] = null ;
        return $data;

    }

   
    public function update($request){
         
       $data = $request->all();
       $data = $this->password($data);
       $data = $this->photo($data);
       $this->model->update($data);
        return response()->json([
           "message" => "update"
        ]);

       

    }
     
       
}