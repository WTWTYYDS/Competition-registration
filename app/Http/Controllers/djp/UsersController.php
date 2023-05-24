<?php

namespace App\Http\Controllers\djp;

use App\Http\Controllers\Controller;
use App\Http\Requests\wt\FromUserInf;
use App\Models\wt\User;
use App\Models\wt\User_inf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{


    /**
     * 用户登录
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $credentials = self::credentials($request);   //从前端获取账号密码
        $token = auth('api')->attempt($credentials);   //获取token
        return $token ?
            $this->respondWithToken($token, "登录成功") :
            json_fail('登录失败!账号或密码错误', null,200);
    }

    //忘记密码的邮箱验证
    public function verify(Request $request)
    {
        $data = $request->input();
        $admin = $data['admin'];
        $email = $data['email'];
        $user = User::where(['admin' => $admin])->first();
        if (!$user['email']) {
            return json_fail('该用户未绑定邮箱', 'null', 400);
        }
        if ($email != $user->email) {
            return json_fail('未绑定该邮箱', 'null', 400);
        }
        $random = rand(10000, 99999);

        Mail::raw("您的验证码是:" . $random, function ($message) use ($email) {
            $message->to($email)->subject('验证码');
        });
        $randomnum = bcrypt($random);
        return json_success('发送成功', $randomnum, 200);
    }

    //确定密码的更改
    public function confirm(Request $request)
    {
        $admin = $request['admin'];
        $info = User::where(['admin' => $admin])->first();
        if (!$info) {
            json_fail('无该用户', 'null', 400);
        }
        $info->password = $this->userHandle($request);
        if ($info->save()) {
           return json_success('更改成功', $info, 200);
        } else {
          return json_fail('更改失败', 'null', 400);
        }

    }

//展示将要修改用户的全部信息
    public function showcase($id)
    {
        $info=User::where(['id'=>$id])->first();
        if (!$info) {
            return json_fail('无该用户', 'null', 400);
        } else {
            return json_success('用户获取成功', $info, 200);
        }
    }

//修改用户的信息并保存
    public function revise(FromUserInf $request)
    {
         $id=$request['id'];
        $info=User_inf::where(['id'=>$id])->first();
         $info->name=$request['name'];
        $info->age=$request['age'];
        $info->nation=$request['nation'];
        $info->phone=$request['phone'];
        $info->identity=$request['identity'];
        $info->competition_group=$request['competition_group'];
        $info->education=$request['education'];
        $info->teacher=$request['teacher'];
        $info->competition_1=$request['competition_1'];
        $info->competition_2=$request['competition_2'];
        $info->competition_3=$request['competition_3'];
        if ($info->save()) {
          return json_success('修改成功', $info, 200);
        } else {
           return json_fail('修改失败', 'null', 400);
        }
    }

    //判断是否第一次登录
    public function judgement(Request $request){
        $admin=$request['admin'];
        $info=User::where(['admin'=>$admin])->first();
        $email=$info['email'];
        if (!$email){
            return json_success('该用户为第一次登录，未绑定邮箱','true',200);
        }
        else{
            return json_success('该用户已经绑定邮箱','false',200);
        }
    }


    //第一次登录修改密码，绑定邮箱
    public function first(Request $request)
    {
        $data = $request->input();
        $admin = $data['admin'];
        $email = $data['email'];
        $user = User::where(['admin' => $admin])->first();
            $random = rand(10000, 99999);
            Mail::raw("您的验证码是:" . $random, function ($message) use ($email) {
                $message->to($email)->subject('验证码');
            });
            $randomnum = bcrypt($random);
            $user->email=$email;
            if ($user->save()) {
               return json_success('绑定邮箱成功',$randomnum , 200);
            } else {
               return json_fail('绑定邮箱失败', 'null', 400);
            }

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
        $registeredInfo['password'] = bcrypt($registeredInfo['password']);
        return $registeredInfo;
    }
}





