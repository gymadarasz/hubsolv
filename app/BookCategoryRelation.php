<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookCategoryRelation extends Model
{
    protected $fillable = ['book_id', 'category_id'];
}
