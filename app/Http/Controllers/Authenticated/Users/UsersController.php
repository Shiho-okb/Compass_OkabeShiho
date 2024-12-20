<?php

namespace App\Http\Controllers\Authenticated\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Gate;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Searchs\DisplayUsers;
use App\Searchs\SearchResultFactories;

class UsersController extends Controller
{

    //ユーザープロフィールの検索しその結果を表示するためのメソッド
    public function showUsers(Request $request){
        $keyword = $request->keyword;
        $category = $request->category;
        $updown = $request->updown;
        $gender = $request->sex;
        $role = $request->role;
        $subjects = $request->subjects;// ここで検索時の科目を受け取る
        $userFactory = new SearchResultFactories();
        $users = $userFactory->initializeUsers($keyword, $category, $updown, $gender, $role, $subjects);
        $subjects = Subjects::all();
        return view('authenticated.users.search', compact('users', 'subjects'));
    }

    //特定のユーザープロフィール表示のためのメソッド
    public function userProfile($id){
        //with('subjects') = subjects テーブルのデータをリレーションを利用して一緒に取得
        //ユーザーが登録している科目情報も一括で取得
        //findOrFail($id)= 指定されたIDのユーザーが存在すればそのユーザーを取得
        $user = User::with('subjects')->findOrFail($id);
        $subjects = Subjects::all();
        return view('authenticated.users.profile', compact('user', 'subjects'));
    }

    //選択科目編集のためのメソッド
    public function userEdit(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->subjects()->sync($request->subjects);
        return redirect()->route('user.profile', ['id' => $request->user_id]);
    }
}
