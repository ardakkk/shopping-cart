<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\Session;
use App\Cart;
use Stripe\Stripe;
class ProductController extends Controller
{
    public function index(){
        $product = Product::all();
        return view('shop.index',["products" => $product]);
    }
    public function getAddToCart(Request $request,$id){
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($product,$product->id);

        $request->session()->put('cart',$cart);
        return redirect()->route('product.index');
    }
    public function getCart(){
        if(!Session::has('cart')){
            return view('shop.shopping-cart',['products' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('shop.shopping-cart',['products' => $cart->items,'totalPrice' => $cart->totalPrice]);
    }
    public function getCheckout(){
        if(!Session::has('cart')){
            return view('shop.shopping-cart',['products' => null]);
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;
        return view('shop.checkout',['total' => $total]);
    }
    public function postCheckout(Request $request){
        if(!Session::has('cart')){
            return redirect()->route('shop.shopping-cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        Stripe::setApiKey('sk_test_zqw8tYchSU56ulOouPXFTqwz');
        try{
            \Stripe\Charge::create(array(
                "amount" => 2000,
                "currency" => "usd",
                "source" => $request->input('stripeToken'), // obtained with Stripe.js
                "description" => "Test Charge"
            ), array(
                "idempotency_key" => "q5axwBGn4Q5FoB2C",
            ));
        }catch (\Exception $e){
            return redirect()->route('checkout')->with(['error'=> $e->getMessage()]);
        }
        Session::forget('cart');
        return redirect()->route('product.index')->with('success','Successfully purchased');
    }
}
