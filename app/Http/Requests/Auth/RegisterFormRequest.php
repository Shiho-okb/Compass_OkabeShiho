<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // 認可が必要ない場合は true を返す
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $year = request()->input('old_year');
        $month = request()->input('old_month');
        $day = request()->input('old_day');

        // バリデーション用に日付を作成
        $birth_day = "{$year}-{$month}-{$day}";
        //「birth_day」をバリデーションチェックするために、バリデーションのチェック項目に追加（merge）している
        $this->merge(['birth_day' => $birth_day]);

        return [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'], // カタカナのみ
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ァ-ヶー]+$/u'], // カタカナのみ
            'mail_address' => ['required', 'string', 'email', 'max:100', 'unique:users,mail_address'], // 登録済み無効
            'sex' => ['required', 'in:1,2,3'], // 指定値のみ
            'birth_day' => ['after:2000/01/01', 'before:today', 'date'],
            'role' => ['required', 'in:1,2,3,4'], // 指定値のみ
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'], // 確認用と一致
        ];
    }

    /**
     * バリデーションエラーメッセージのカスタマイズ（任意）
     *
     * @return array
     */
    public function messages()
    {
        return [
            'over_name.required' => '姓は必須です。',
            'over_name.string' => '姓は文字列でなければなりません。',
            'over_name.max' => '姓は10文字以内で入力してください。',

            'under_name.required' => '名は必須です。',
            'under_name.string' => '名は文字列でなければなりません。',
            'under_name.max' => '名は10文字以内で入力してください。',

            'over_name_kana.required' => '姓（カタカナ）は必須です。',
            'over_name_kana.string' => '姓（カタカナ）は文字列でなければなりません。',
            'over_name_kana.max' => '姓（カタカナ）は30文字以内で入力してください。',
            'over_name_kana.regex' => '姓（カタカナ）はカタカナのみで入力してください。',

            'under_name_kana.required' => '名（カタカナ）は必須です。',
            'under_name_kana.string' => '名（カタカナ）は文字列でなければなりません。',
            'under_name_kana.max' => '名（カタカナ）は30文字以内で入力してください。',
            'under_name_kana.regex' => '名（カタカナ）はカタカナのみで入力してください。',

            'mail_address.required' => 'メールアドレスは必須です。',
            'mail_address.email' => 'メールアドレスは有効な形式で入力してください。',
            'mail_address.max' => 'メールアドレスは100文字以内で入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に登録されています。',

            'sex.required' => '性別は必須です。',
            'sex.in' => '性別は「男性」「女性」「その他」から選択してください。',

            'birth_day.after' => '生年月日は2000年1月1日以降でなければなりません。',
            'birth_day.before' => '生年月日は今日以前の日付でなければなりません。',
            'birth_day.date' => '生年月日は有効な日付でなければなりません。',

            'role.required' => '役職は必須です。',
            'role.in' => '役職は「講師(国語)」「講師(数学)」「教師(英語)」「生徒」から選択してください。',

            'password.required' => 'パスワードは必須です。',
            'password.string' => 'パスワードは文字列でなければなりません。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'password.confirmed' => 'パスワード確認と一致しません。',
        ];
    }

}
