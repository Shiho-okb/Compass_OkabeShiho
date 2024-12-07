<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubCategoryFormRequest extends FormRequest
{
    public function authorize()
    {
        return true; // 必要に応じて認可ロジックを変更
    }

    public function rules()
    {
        return [
            'main_category' => [
                'required',
                'exists:main_categories,id',
            ],
            'sub_category_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^(?![0-9]+$).*/', // 数字のみは禁止
                Rule::unique('sub_categories', 'sub_category')->where('main_category_id', $this->input('main_category')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'main_category.required' => 'メインカテゴリーを選択してください。',
            'main_category.exists' => '選択したメインカテゴリーが存在しません。',
            'sub_category_name.required' => 'サブカテゴリー名は必須です。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列である必要があります。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以内で入力してください。',
            'sub_category_name.unique' => 'このサブカテゴリーは既に存在します。',
            'sub_category_name.regex' => 'サブカテゴリー名は数字のみで入力することはできません。',
        ];
    }
}
