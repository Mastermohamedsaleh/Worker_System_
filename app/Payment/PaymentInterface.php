<?php

namespace App\Payment;

use Illuminate\Http\Request;


interface PaymentInterface{

      
    public function index($id ,Request $request); 

}