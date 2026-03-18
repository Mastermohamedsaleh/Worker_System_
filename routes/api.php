<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AdminAuthController , WorkerAuthController , ClientAuthController , PostController ,ClientServicesController,WorkerReviewController ,  ProfileWorkerController , PaymentController , TopWorkerController};
use App\Http\Controllers\AdminDashboard\{AdminNotificationController,PostStatusController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/test2',function(){
         return 'hello';
}); 
 
 

Route::controller(AdminAuthController::class)->prefix('auth/admin')->group(function(){
    Route::post('/login',  'login');
    Route::post('/register',  'register');
    Route::post('/logout',  'logout');
    Route::post('/refresh', 'refresh');
    Route::get('/user-profile', 'userProfile');    
});

Route::controller(WorkerAuthController::class)->prefix('auth/worker')->group(function(){
    Route::post('/login',  'login');
    Route::post('/register',  'register');
    Route::post('/logout',  'logout');
    Route::post('/refresh',  'refresh');
    Route::get('/user-profile',  'userProfile');    
});

Route::controller(ClientAuthController::class)->prefix('auth/client')->group(function(){
    Route::post('/login',  'login');
    Route::post('/register',  'register');
    Route::post('/logout', 'logout');
    Route::post('/refresh',  'refresh');
    Route::get('/user-profile',  'userProfile');    
});






 

// big important method in this project used Redis With Queues and jobs and used Cache With topRated
Route::controller(PostController::class)->prefix('client/post')->group(function (){
   Route::get('/show/{id}' , 'show')->middleware('auth:client');
 });



Route::get('topRated' ,[TopWorkerController::class,'topRated'])->middleware('auth:client');

// Cache::forget('top_rated_workers'); if you want forget cache after every rate 


 
//end big important method in this project used Redis With Queues and jobs









Route::controller(PostController::class)->prefix('worker/post')->group(function (){
  

    Route::post('/add' , 'store')->middleware('auth:worker');
    Route::get('/show' , 'index')->middleware('auth:admin');
    
    Route::get('/approved' , 'approved');
     
});

Route::controller(PostStatusController::class)->prefix('admin')->group(function (){
  
    Route::get('/changstatus' , 'changStatusPost')->middleware('auth:admin');
     
});



/////////////////////////////start profile///////////////////////////////////

Route::get('/workerprofile' , [ProfileWorkerController::class, 'workerprofile' ])->middleware('auth:worker');
Route::get('/workereditprofile' , [ProfileWorkerController::class, 'edit' ])->middleware('auth:worker');
Route::post('/workerupdateprofile' , [ProfileWorkerController::class, 'update' ])->middleware('auth:worker');
Route::get('/deleteallposts' , [ProfileWorkerController::class, 'deleteallposts' ])->middleware('auth:worker');


///////////////////////////end profile/////////////////////////////////////

Route::controller(AdminNotificationController::class)->prefix('admin/notifications')->group(function (){
  
    Route::get('/all' , 'index')->middleware('auth:admin');
    Route::get('/unread' , 'unread')->middleware('auth:admin');
    Route::get('/markread' , 'markread')->middleware('auth:admin');
     
});





Route::controller(ClientServicesController::class)->prefix('order')->group(function (){

    Route::post('/addorder' , 'addorder')->middleware('auth:client');
    Route::get('/showorder' , 'showorder')->middleware('auth:worker');
    Route::post('/update/order/{id}' , 'update')->middleware('auth:worker');
     
});

Route::controller(WorkerReviewController::class)->group(function (){
    Route::post('/review' , 'store')->middleware('auth:client');
    Route::get('/postRate/{id}' , 'postRate');
});









Route::controller(PaymentController::class)->group(function(){
    Route::get('handle-payment/{id}', 'index')->name('handle-payment');
    Route::get('checkoutsuccess', 'success')->name('checkout.success');
    Route::get('checkoutcancel', 'cancel')->name('checkout.cancel');
});



