<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Sub_Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        return view("categories.sub_category")->with(['sub_categories'=>Sub_Category::all(),'parent_categories'=>Parents::all()]);
    }

    public function create(Request $request){
        $request -> validate([
            'parent_name' => 'required | max:255',
            'sub_category_name' => 'required | max:255',
        ]);
        $parent = new Sub_Category();
        $parent->parent_id = $request->parent_name;
        $parent->sub_category_name = $request->sub_category_name;
        if($parent->save()){
            return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function detail(Request $request){
        $request->validate([
            'id'=>'required|distinct',
        ]);
        $sub = Sub_Category::find($request->id);
        return response()->json(['id'=>$sub->id,
            'sub_category_name'=>$sub->sub_category_name,
            'parent_id'=>$sub->parent_id]);
    }

    public function update(Request $request){
        $request->validate([
            'sub_category_id'=>'required|distinct',
            'sub_category_name_update'=>['required','max:255'],
            'parent_name_update'=>'required|distinct',
        ]);

        $sub = Sub_Category::find($request->sub_category_id);
        $sub->sub_category_name = $request->sub_category_name_update;
        $sub->parent_id = $request->parent_name_update;
        if($sub->save()){
            return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'id'=>'distinct',
        ]);
        if(Sub_Category::find(request('id'))->delete()){
            return response()->json(['success' => 'Success']);
        }
        return response()->json(['error'=>'We found an error. Please try again.']);
    }
}
