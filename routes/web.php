<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ParentCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductListController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/register', [\App\Http\Controllers\AuthorizationController::class,'registerIndex'])->name('registerIndex');
Route::post('/register', [\App\Http\Controllers\AuthorizationController::class,'register'])->name('register');

Route::get('/login',[\App\Http\Controllers\AuthorizationController::class,'loginIndex'])->name('loginIndex');
Route::post('/login',[\App\Http\Controllers\AuthorizationController::class,'login'])->name('login');

Route::post('/logout', [\App\Http\Controllers\AuthorizationController::class,'logout'])->name('logout');


Route::group(['middleware' => 'admin'], function (){

    Route::get('/',function (){
        return view('dashboard');
    })->name('index');

    Route::group(['prefix'=>'/parent_category','as'=>'parent_category.'], function(){
        Route::get('/',[ParentCategoryController::class,'index'])->name('index');
        Route::post('/create',[ParentCategoryController::class,'create'])->name('create');
        Route::get('/detail',[ParentCategoryController::class,'detail'])->name('detail');
        Route::post('/update',[ParentCategoryController::class,'update'])->name('update');
        Route::get('/delete',[ParentCategoryController::class,'delete'])->name('delete');
    });

    Route::group(['prefix'=>'/sub_category','as'=>'sub_category.'], function(){
        Route::get('/',[SubCategoryController::class,'index'])->name('index');
        Route::post('/create',[SubCategoryController::class,'create'])->name('create');
        Route::get('/detail',[SubCategoryController::class,'detail'])->name('detail');
        Route::post('/update',[SubCategoryController::class,'update'])->name('update');
        Route::get('/delete',[SubCategoryController::class,'delete'])->name('delete');
    });

    Route::group(['prefix'=>'/product','as'=>'product.'], function(){
        Route::get('/',[ProductController::class,'index'])->name('index');
        Route::post('/create',[ProductController::class,'create'])->name('create');
        Route::get('/detail',[ProductController::class,'detail'])->name('detail');
        Route::post('/update',[ProductController::class,'update'])->name('update');
        Route::get('/delete',[ProductController::class,'delete'])->name('delete');
    });
    Route::group(['prefix'=>'/product_list','as'=>'product_list.'], function(){
        Route::get('/',[ProductListController::class,'index'])->name('index');
        Route::post('/add-to-cart',[ProductListController::class,'addToCart'])->name('addToCart');
    });
    Route::group(['prefix'=>'/cart','as'=>'cart.'], function(){
        Route::get('/',[CartController::class,'index'])->name('index');
        Route::get('/amount-change',[CartController::class,'amountChange'])->name('amountChange');
        Route::get('/remove',[CartController::class,'remove'])->name('remove');
        Route::get('/remove-all-products-from-my-cart',[CartController::class,'removeAll'])->name('removeAll');
    });
});




