<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\User;
use App\Models\wt\SupUser;
use App\Models\wt\User_inf;
use Illuminate\Http\Request;


class AdminController extends Controller
{


    public function test(Request $request)
    {
        return 1;
    }

    /**
     * 管理员添加用户
     * @param Request $registeredRequest
     * @return false|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registered(Request $registeredRequest)
    {
        $count = User::checknumber($registeredRequest);   //检测账号密码是否存在
        if ($count == 0) {
            $student_id = User::createUser(self::userHandle($registeredRequest));
            return $student_id ?
                json_success('注册成功!', $student_id, 200) :
                json_fail('注册失败!', 'false', 100);
        } else {
            return
                json_success('注册失败!该号已经注册过了！', 'false', 100);
        }
    }


    /**
     * 管理员删除用户
     * @param Request $registeredRequest
     * @return false|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete_user(Request $registeredRequest)
    {
        $count = User_inf::select_1($registeredRequest['school_name']);   //检测报名表学校信息是否存在
        if ($count == 0) {
            $student_id = User::del($registeredRequest['school_name']);
            return $student_id ?
                json_success('删除成功!', 'true', 200) :
                json_fail('删除失败!', 'false', 100);
        } else {
            return
                json_success('删除失败！该学校已经有报名信息', null, 100);
        }
    }

    /**
     * 管理员批量删除用户
     * @param Request $request
     * @return false|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function delete_user_arr(Request $request)
    {
        $array = explode(',', $request['school_name_arr']);
        try {
            for ($i = 0; $i < count($array); $i++) {
                $count = User_inf::select_1($array[$i]);   //检测报名表学校信息是否存在
                if ($count == 0) {
                    User::del($array[$i]);
                } else {
                    return json_success('删除失败！其中学校已经有报名信息', null, 100);
                }
            }
            return json_success('删除成功!', 'true', 200);
        } catch (\Exception $e) {
            logError('报名信息提交失败!', [$e->getMessage()]);
            return json_fail('报名信息提交失败!', 'false', 100);
        }
    }

    /**
     *默认查询学校的信息
     */
    public function select_school() {
        try {
            $data = User::sel_users();
            return json_success('查询学校名和账号成功!', $data, 200);
        } catch (\Exception $e) {
            logError('查询学校名和账号失败!', [$e->getMessage()]);
            return json_fail('查询学校名和账号失败!', 'false', 100);
        }
    }
    /**
     *模糊查询学校的信息
     */
    public function dim_select_school(Request $request) {
        try {
            $data = User::dim_sel_users($request['school_name']);
            return json_success('查询学校名和账号成功!', $data, 200);
        } catch (\Exception $e) {
            logError('查询学校名和账号失败!', [$e->getMessage()]);
            return json_fail('查询学校名和账号失败!', 'false', 100);
        }
    }


    /**
     * 管理员注册
     * @param Request $registeredRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function registered_1(Request $registeredRequest)
    {
        $count = SupUser::checknumber($registeredRequest);   //检测账号密码是否存在
        if ($count == 0) {

            $student_id = SupUser::createUser(self::userHandle($registeredRequest));
            return $student_id ?
                $this->respondWithToken($student_id, "注册成功") :
                json_fail('注册失败!', null, 100);
        } else {
            return json_success('注册失败!该号已经注册过了！', null, 100);
        }
    }

    /**
     * 管理员登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = self::credentials($request);   //从前端获取账号密码
        $token = auth('super')->attempt($credentials);   //获取token
//        return $token?
//            json_success('登录成功!',$token,  200):
//            json_fail('登录失败!账号或密码错误',null, 100 ) ;
        return $token ?
            $this->respondWithToken($token, "登录成功") :
            json_fail('登录失败!账号或密码错误', null, 100);
    }

    //封装token的返回方式
    protected function respondWithToken($token, $msg)
    {
        // $data = Auth::user();
        return json_success($msg, array(
            'token' => $token,
            //设置权限  'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ), 200);
    }

    protected function credentials($request)   //从前端获取账号密码
    {
        return ['admin' => $request['admin'], 'password' => $request['password']];
    }

    protected function userHandle($request)   //对密码进行哈希256加密
    {
        $registeredInfo = $request->except('password_confirmation');
        $registeredInfo['password'] = bcrypt('666666');
        $registeredInfo['admin'] = $request['admin'];
        $registeredInfo['school_name'] = $request['school_name'];
        return $registeredInfo;
    }
}


