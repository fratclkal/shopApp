<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "parents";

    public function sub_category(){
        return $this->hasMany('App\Sub_Category');
    }
}
