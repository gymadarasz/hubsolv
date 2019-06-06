<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['isbn', 'title', 'author', 'price', 'currency'];
    
    public function categories()
    {
        return $this->belongsToMany('App\\Category', 'book_category_relations', 'book_id', 'category_id');
    }
}
