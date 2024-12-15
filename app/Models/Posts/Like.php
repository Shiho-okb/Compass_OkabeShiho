<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];
}
