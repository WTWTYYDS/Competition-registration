<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\User_inf;
use Illuminate\Http\Request;

class Competiton_users extends Controller
{
    // 添加用户信息
    public function inf_add(Request $request)   {
        $b = User_inf::user_inf_add($request);
//        $b = User_inf::where('identity',$request['identity'])->first();
//        return json_fail('提交失败!',$b, 100 );

        if ($b=='1'){
            return json_success('报名信息提交成功!', 'true', 200);
        } else {
            return json_fail('提交失败!'.$b,'false', 100 );
        }
    }

    // 批量报名
    public function inf_add_array(Request $request)   {

        $array = explode(',',$request['id_arr']);
        try {
            for($i=0;$i<count($array);$i++)    {
                User_inf::user_inf_state($array[$i]);
            }
            return json_success('报名信息提交成功!', 'true', 200);
        }catch (\Exception $e) {
            logError('报名信息提交失败!', [$e->getMessage()]);
            return json_fail('报名信息提交失败!','false', 100 );
        }

    }
}

