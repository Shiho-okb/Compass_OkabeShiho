<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Http\Requests\Auth\RegisterFormRequest;
use DB;

use App\Models\Users\Subjects;
use App\Models\Users\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */


    //映し出すためのメソッド(新規登録フォームを表示)
    public function create()
    {
        //Subjectsテーブルの情報を取得
        //auth/register.blade.phpという"ビュー"をブラウザに表示させる
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }


    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */


    //引数の「RegisterFormRequest」はバリデーション用ファイルを表している
    public function store(RegisterFormRequest $request)
    {
        //トランザクション処理を開始
        //途中でエラーが起きた場合にすべての変更をロールバック（取り消し）する
        DB::beginTransaction();
        try{
            //入力データの加工
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            // ユーザーの新規作成
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            if($request->role == 4){
                $user = User::findOrFail($user_get->id);
                $user->subjects()->attach($subjects);
            }

            //成功した場合：DB::commit(); でトランザクションを確定
            //成功時：ログイン画面を表示
            DB::commit();
            return view('auth.login.login');

        }catch(\Exception $e){
            //失敗した場合：DB::rollback(); で変更を取り消し
            //失敗時：ログインページにリダイレクト
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
