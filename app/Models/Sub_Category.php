<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sub_Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "sub_categories";

    public function parent_category(){
        return $this->belongsTo('App\Models\Parents','parent_id','id');
    }
    public function product(){
        return $this->hasMany('App\Product');
    }
}
