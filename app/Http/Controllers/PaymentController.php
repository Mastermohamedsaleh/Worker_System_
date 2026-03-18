<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;



use App\Payment\PaymentInterface;

class PaymentController extends Controller
{

protected $payment;

public function __construct(PaymentInterface  $payment){

   $this->payment = $payment;

} 
public function index( $id ,Request $request){
       
    return $this->payment->index( $id ,$request); 

  }


}
