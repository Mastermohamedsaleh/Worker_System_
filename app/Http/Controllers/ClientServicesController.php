<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests\Client\ClientOrderRequest;

use App\Repository\Orders\OrderRepositoryinterface;

use App\Models\ClientOrder;

class ClientServicesController extends Controller
{
         
    protected $Order;

    public function __construct(OrderRepositoryinterface $Order){
       $this->Order = $Order;  
    }
    
    public function addorder(ClientOrderRequest $request)
    { 
        return $this->Order->store($request);
    }

    public function showorder()
    {
        return $this->Order->showorder();
    }


    public function update($id , Request $request)
    {
        $order = ClientOrder::findOrFail($id);
        $order->SetAttribute('status',$request->status)->save();
        // $order->update(['status'=>$request->status]);
        return response()->json([
          'message' => 'update'
        ]);
    }

}
