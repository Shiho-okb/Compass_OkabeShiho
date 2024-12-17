<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Posts\PostSubCategories;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\MainCategoryFormRequest;
use App\Http\Requests\BulletinBoard\SubCategoryFormRequest;
use App\Http\Requests\BulletinBoard\CommentFormRequest;
use Auth;
use Illuminate\Validation\Rule;

class PostsController extends Controller
{
    //投稿一覧画面表示のためのメソッド
    public function show(Request $request){
        //postテーブルからリレーションで紐付けたuser・postComments・subCategoriesテーブルの情報を取得
        $posts = Post::with('user', 'postComments', 'subCategories')->get();
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;

        //キーワード検索の場合
          //$request->keyword が送信されている場合（空でない場合）に実行
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();

        //サブカテゴリー検索の場合
          //$requestで category_word（サブカテゴリーIDなど）が送信されている場合に実行
        }else if($request->category_word){
            //bladeから送られてくる値
            $sub_category = $request->category_word;

            //指定したリレーションのデータも、一緒にデータベースから取得
            $posts = Post::with('user', 'postComments')
            //「投稿（Post）」モデルが「サブカテゴリー（SubCategory）」と多対多のリレーションを持っている場合
            //投稿が持つ「サブカテゴリー」の中に条件を満たすものがあるかを確認
            //サブカテゴリーID（$sub_category）と一致するものがある投稿を取得
            ->whereHas('subCategories', function ($query) use ($sub_category) {
                //サブカテゴリーの条件を指定
                //サブカテゴリーテーブル（sub_categories）の id カラムが、変数 $sub_category に格納された値と一致するものだけを選ぶ
                $query->where('sub_category_id', $sub_category);
            })->get();

        //いいねした投稿の取得の場合
          //like_posts がリクエストされた場合に実行
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')
                ->whereIn('id', $likes)->get();
        //自分の投稿のみ取得の場合
          //my_posts がリクエストされた場合に実行
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')
                ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    //新規投稿のためのメソッド
    //引数の「PostFormRequest」はバリデーション用ファイルを表している
    public function postCreate(PostFormRequest $request){
        // dd($request->post_category_id);
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);

        PostSubCategories::create([
            'post_id' => $post->id,
            //$requestはbladeから取得してくる値
            'sub_category_id' => $request->post_category_id,
        ]);
        return redirect()->route('post.show');
    }

    //投稿編集のためのメソッド
    //引数の「PostFormRequest」はバリデーション用ファイルを表している
    public function postEdit(PostFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }

    //メインカテゴリーの追加のためのメソッド
    //引数の「MainCategoryFormRequest」はバリデーション用ファイルを表している
    public function mainCategoryCreate(MainCategoryFormRequest $request){

        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    //サブカテゴリーの追加のためのメソッド
    //引数の「SubCategoryFormRequest」はバリデーション用ファイルを表している
    public function subCategoryCreate(SubCategoryFormRequest $request){

        SubCategory::create([
            'main_category_id' => $request->input('main_category'),
            'sub_category' => $request->input('sub_category_name'),
        ]);
        return redirect()->route('post.input');
    }

    //投稿コメントのためのメソッド
    public function commentCreate(CommentFormRequest $request)
    {
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    //投稿いいねのためのメソッド
    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    //投稿いいね解除のためのメソッド
    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
            ->where('like_post_id', $post_id)
            ->delete();

        return response()->json();
    }
}
