<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductListController extends Controller
{
    public function index(){
        return view("product-list")->with(['products'=>Product::all()]);
    }
    public function addToCart(Request $request){
       $request->validate([
          'id'=>'required|distinct|exists:products,id',
       ]);
       $cart = Cart::where('user_id',1)->where('product_id',$request->id)->first();
       if(!$cart){
           $productAddingToCart =  new Cart();
           $productAddingToCart->user_id = Auth::user() -> id; // @todo
           $productAddingToCart->product_id = $request->id;
           $productAddingToCart->save();
       }else{
           $cart->amount += 1;
           $cart->save();
       }

    }
}
