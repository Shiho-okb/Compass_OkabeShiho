<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    // const UPDATED_AT = null;
    // const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    // main_categoriesテーブルとsub_categoriesテーブルのリレーション
      // 1対多の関係 (1つのメインカテゴリーは複数のサブカテゴリーを持つ)
      //「１対多」の「多」側 → メソッド名は複数形でhasManyを使う
    public function subCategories(){
        return $this->hasMany('App\Models\Categories\SubCategory');
    }

}
