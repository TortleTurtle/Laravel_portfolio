<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $primaryKey = 'id';
    public $timestamps = false;

    //relationships
    public function posts(){
        return $this->belongsToMany('App\Post', 'posts_categories', 'category_id', 'post_id');
    }
}
