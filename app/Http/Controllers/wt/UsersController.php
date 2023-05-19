<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * 注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registered(Request $registeredRequest)
    {
        $count = User::checknumber($registeredRequest);   //检测账号密码是否存在
        if($count == 0)
        {

            $student_id = User::createUser(self::userHandle($registeredRequest));
            return  $student_id ?
                json_success('注册成功!',$student_id,200  ) :
                json_fail('注册失败!',null,100  ) ;
        }
        else{
            return
                json_success('注册失败!该工号已经注册过了！',null,100  ) ;
        }
    }
}
