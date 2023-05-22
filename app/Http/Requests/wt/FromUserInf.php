<?php

namespace App\Http\Requests\wt;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FromUserInf extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;   //这里一定要改成true默认是false 不然会报403错误
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //size:6：字段长度固定在某个值；    'username '     =>  'required|size:6',
            //email：字段必须符合 email 格式； 'username '     =>  'required|email ',
            // 'alpha_num' => '验证字段必须全是字母和数字',
            'school_name' => 'required',
            'name' => 'required',
            'sex' => 'required',
            'age' => 'required|between:1,120',
            'nation' => 'required',
            'phone' => 'required',
            'identity' => 'required',
            'competition_group' => 'required',
            'education' => 'required',
            'teacher' => 'required',
            'competition_1' => 'required',
            'competition_2' => 'required',
            'competition_3' => 'required',
        ];
    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required'  => 'A message is required',
        ];
    }


    public function failedValidation(Validator $validator){

        throw(new HttpResponseException(json_fail('参数错误',$validator->errors()->all(),422)));
    }
}
