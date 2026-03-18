<?php
namespace App\Payment;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Client;
use App\Models\Worker_cashe;
use Stripe;
use Stripe\Checkout\Session;


class StripePayment implements PaymentInterface
{

    public function index($id , Request $request) 
    {

   $post =  Post::findorFail($id);
  try{
    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    $lineItems = [];
    $totalPrice = 0;
  
        $totalPrice += $post->price;
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
              'product_data' => [
                 'name' => "Post",
         ],
                'unit_amount' => $post->price * 100,
            ],
            'quantity' => 1
        ];
// table workercashes
        $workercash = Worker_cashe::create([
            'post_id'=> $post->id, 
            'client_id'=> Client::first()->id , //auth()->guard('client')->id()
            'total'=>$post->price
        ]);
// end table workercashes

    


    $session =  Stripe\Checkout\Session::create([
        'line_items' => $lineItems,
        'mode' => 'payment',
        'success_url' => route('checkout.success', [], true) ,
        'cancel_url' => route('checkout.cancel', [], true),
    ]);
    return redirect($session->url);
  }catch(\Exception $e){
     return "Please check Enternet";
  }


}


    public function success(){
        return "payment Success";
    }
    public function cancel(){
        return "payment cancel";
    }

}
