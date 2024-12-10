<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;
use App\Models\Posts\Post;

class SubCategory extends Model
{
    // const UPDATED_AT = null;
    // const CREATED_AT = null;
    protected $fillable = [
        'main_category_id',
        'sub_category',
    ];

    // main_categoriesテーブルとsub_categoriesテーブルのリレーション
      // 1対多の関係 (1つのメインカテゴリーは複数のサブカテゴリーを持つ)
      //「１対多」の「1」側 → メソッド名は単数形でbelongsToを使う
    public function mainCategory(){
        return $this->belongsTo('App\Models\Categories\MainCategory');
    }

    // sub_categoriesテーブルとpostsテーブルのリレーション
      // 多対多の関係 (中間テーブルはpost_sub_categories)
    public function posts(){
        return $this->belongsToMany(Post::class, 'post_sub_categories', 'sub_category_id', 'post_id');
    }
}
