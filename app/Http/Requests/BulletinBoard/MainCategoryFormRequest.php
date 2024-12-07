<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'main_category_name' => [
                'required',
                'string',
                'max:100',
                'unique:main_categories,main_category',
                'regex:/^(?![0-9]+$).*/', // 数字のみは禁止
            ],
        ];
    }


    public function messages()
    {
        return [
            'main_category_name.required' => 'メインカテゴリー名は必須です。',
            'main_category_name.string' => 'メインカテゴリー名は文字列で入力してください。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以内で入力してください。',
            'main_category_name.unique' => 'このメインカテゴリーは既に存在します。',
            'main_category_name.regex' => 'メインカテゴリー名は数字のみで入力することはできません。',
        ];
    }
}
