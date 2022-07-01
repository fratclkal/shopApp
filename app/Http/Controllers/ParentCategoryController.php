<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use App\Models\Sub_Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParentCategoryController extends Controller
{
    public function index(){
        return view("categories.parent")->with(['parents'=>Parents::all()]);
    }

    public function create(Request $request){
        $request -> validate([
           'parent_name' => 'required | max:255',
        ]);
        $parent = new Parents();
        $parent->parent_name = $request->parent_name;
        if($parent->save()){
           return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function detail(Request $request){
        $request->validate([
            'id'=>'distinct',
        ]);
        $parent = Parents::find($request->id);
        return response()->json(['id'=>$parent->id,
            'parent_name'=>$parent->parent_name]);
    }

    public function update(Request $request){
        $request->validate([
            'parent_category_id'=>'distinct',
            'parent_name_update'=>['required','max:255'],
        ]);
        $parent = Parents::find($request->parent_category_id);
        $parent->parent_name = $request->parent_name_update;
        if($parent->save()){
            return response()->json(['success'=>'Success']);
        }else{
            return response()->json(['fail'=>'Fail']);
        }
    }

    public function delete(Request $request){
        $request->validate([
            'id'=>'distinct',
        ]);
        if(Parents::find(request('id'))->delete()){
            return response()->json(['success' => 'Success']);
        }
        return response()->json(['error'=>'We found an error. Please try again.']);
    }
}
