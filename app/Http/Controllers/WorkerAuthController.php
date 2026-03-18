<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Worker;
use Validator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\WorkerRegisterRequest;
use App\Services\WorkerService\WorkerLoginService\WorkerLoginService;
use App\Services\WorkerService\WorkerRegisterService\WorkerRegisterService;




class WorkerAuthController extends Controller
{

    public function __construct() {
        $this->middleware('auth:worker', ['except' => ['login', 'register']]);
    }
 
    public function login(LoginRequest $request){
    
            return (new WorkerLoginService())->login($request);
    }
 

    public function register(WorkerRegisterRequest $request) {
      
        return (new WorkerRegisterService())->register($request);
    }

 
    public function logout() {
        auth()->guard('worker')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
  
    

    public function refresh() {
        return $this->createNewToken(auth()->guard('worker')->refresh());
    }

 
    public function userProfile() {
        return response()->json(auth()->guard('worker')->user());
    }


    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('worker')->user()
        ]);
    }
}