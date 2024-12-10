<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class PostSubCategories extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'post_id',
        'sub_category_id'
    ];
}
