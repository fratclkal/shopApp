<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index(){
        $total = DB::table('cart')
            ->join('products','products.id','=','cart.product_id')
            ->select(DB::raw('sum(product_price * amount) as total'))
            ->where('cart.deleted_at',null)
            ->get();
        $total = $total[0]->total;
        return view("cart")->with(['carts'=>Cart::where('user_id',Auth::user()->id)->get(),'total'=>$total]); //@todo
    }

    public function amountChange(Request $request){
        $request->validate([
            'id'=>'required|distinct',
            'status'=>['required',Rule::in([0,1])]
        ]);
        $cart = Cart::where('user_id',1)->where('id',$request->id)->first();
        if($request->status == 0){ // minus 1
            $cart->amount -= 1;
        }else{ // plus 1
            $cart->amount += 1;
        }
        $cart->save();
    }

    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cart,id',
        ]);
        $cart = Cart::where('user_id',Auth::user()->id)->where('id',$request->id)->first();  //@todo //Auth::id()
        if($cart){
            $cart->delete();
        }else{
            return response()->json(['fail'=>'We found an error when removing the product from the cart. Please try again!']);
        }
    }

    public function removeAll()
    {
        Cart::where('user_id',Auth::user()->id)->delete();  //@todo //Auth::id()
    }
}
