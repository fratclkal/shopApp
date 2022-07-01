<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Product;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        return view("products")->with(['products'=>Product::all(),'sub_categories'=>Sub_Category::all()]);
    }

    public function create(Request $request){
        $request -> validate([
            'product_price' => 'required',
            'product_name' => 'required|max:255',
            'sub_category_name' => 'required|max:255',
            'product_path' => 'required|mimes:jpeg,jpg,png|max:1024',
        ]);
        $sub = new Product();
        $sub->product_name = $request->product_name;
        $sub->sub_category_id = $request->sub_category_name;
        $sub->product_price = $request->product_price;
        if ($file = $request->file('product_path')) {
            $name = time();
            $file->move('products/', $name);
            $sub->product_path = $name;
        }
        if($sub->save()){
            return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function detail(Request $request){
        $request->validate([
            'id'=>'required|distinct',
        ]);
        $sub = Product::find($request->id);
        return response()->json(['id'=>$sub->id,
            'sub_category_name'=>$sub->sub_category_id,
            'product_name'=>$sub->product_name,
            'product_price'=>$sub->product_price,
            'product_path'=>$sub->product_path,
            ]);
    }

    public function update(Request $request){
        $request->validate([
            'product_id'=>'required|distinct',
            'sub_category_name_update'=>'required|distinct',
            'product_name_update'=>'required|max:255',
            'product_price_update'=>'required|max:6',
            'product_path_update'=>'nullable|max:1024',
        ]);
        $sub = Product::find($request->product_id);
        $sub->product_name = $request->product_name_update;
        $sub->sub_category_id = $request->sub_category_name_update;
        $sub->product_price = $request->product_price_update;
        if ($file = $request->file('product_path_update')) {
            $name = time();
            $file->move('products/', $name);
            $sub->product_path = $name;
        }
        if($sub->save()){
            return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'id'=>'distinct|required',
        ]);
        if(Product::find(request('id'))->delete()){
            return response()->json(['success' => 'Success']);
        }
        return response()->json(['error'=>'We found an error. Please try again.']);
    }
}
