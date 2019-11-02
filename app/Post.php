<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'title', 'slug', 'content', 'status', 'author',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
    public function categories(){
        return $this->belongsToMany('App\Category', 'posts_categories', 'post_id', 'category_id');
    }
}
