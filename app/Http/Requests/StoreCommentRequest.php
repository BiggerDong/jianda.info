<?php
/**
 * Created by PhpStorm.
 * User: BiggerDong
 * Date: 2017/8/20
 * Time: 11:37
 */

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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
            'body' => 'required|min:1|max:200',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => '评论不能为空',
            'body.min' => '评论字数不能少于1个字',
            'body.max' => '评论字数不能多于200个字',
        ];
    }
}