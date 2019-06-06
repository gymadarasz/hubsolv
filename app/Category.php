<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    
    public function categories() {
        return $this->belongsToMany('App\\Books', 'book_category_relations', 'book_id', 'category_id');
    }
}
