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
            'id'=>'required|integer|min:0',
            //'email'=>'required|email',
           // 'school_name' => 'required|string|max:100',
           //'admin'=>'required|integer|min:6|max:20',
            'name' => 'required|string|max:50',
           // 'sex' => 'required|in:male,female',
            'age' => 'required|integer|min:1|max:120',
            'nation' => 'required|string|max:50',
            'phone' => ['required', 'regex:/^[0-9]{11}$/'],
            'identity' => ['required', 'regex:/^[0-9]{18}$/'],
            'competition_group' => 'required|string|max:50',
           // 'state'=>'required|boolean',
            'education' => 'required|string|max:50',
            'teacher' => 'required|string|max:50',
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
