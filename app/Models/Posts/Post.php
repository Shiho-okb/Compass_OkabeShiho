<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categories\SubCategory;

class Post extends Model
{
    // const UPDATED_AT = null;
    // const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'post_title',
        'post',
    ];

    public function user(){
        return $this->belongsTo('App\Models\Users\User');
    }

    public function postComments(){
        return $this->hasMany('App\Models\Posts\PostComment');
    }

    // sub_categoriesテーブルとpostsテーブルのリレーション
      // 多対多の関係 (中間テーブルはpost_sub_categories)
    public function subCategories(){
        return $this->belongsToMany(SubCategory::class, 'post_sub_categories', 'post_id', 'sub_category_id');
    }

    // コメント数
    public function commentCounts($post_id){
        return Post::with('postComments')->find($post_id)->postComments();
    }

    // いいね数
      // Likeモデルを使用して、like_post_id が現在の投稿（$this->id）に紐づいているレコードをデータベースから検索
      // $this->id = Post モデルのインスタンス内で使われているため、現在の投稿の ID を参照している
      // 検索した結果の件数（count()）を返す
    public function getLikeCount(){
        return \App\Models\Posts\Like::where('like_post_id', $this->id)->count();
    }
}
