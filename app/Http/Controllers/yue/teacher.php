<?php

namespace App\Http\Controllers\yue;

use App\information;
use App\Models\managers;
use App\Models\Users_if;
use Illuminate\Http\Request;
use App\UserModel;
class teacher extends Controller
{
    protected $tavle = 'information';

    /*
     *   在数据库中添加元素
     */
    public function xuetianjia(Request $request)
    {
        $username = $request['username'];
        $age = $request['age'];
        $res = information::xuetianjia($username,$age);
        return $res ?
            json_success('添加成功', $res, 200) :
            json_fail('添加失败', null, 100);
    }
    public function tianjia(Request $request){
//        $data = [
//            'id'=>$request->input('id'),
//            'username' => $request->input('username'),
//            'age' => $request->input('age'),
//        ];
        $name = $request->input('username');
        $age = $request->input('age');

        $user = new UserModel();
        $user->name = $name;
        $user->age = $age;
        dd($user);
        $user->save();
//        dd($data);
//        $user = UserModel::create($data);
//        dd($res);
//        dd($user);
    }
    /*
 * 用户端获取报名信息
 */
    public function yongcha()
    {
        $flight = Users_if::select('id', 'name', 'competition_group', 'education', 'phone', 'competition_1', 'competition_3')->get();


        return $flight ?
            json_success('查询成功!', 'true', 200) :
            json_fail('查询失败!', 'false', 100);


    }

    /*
 * 默认学校学校
 */
    public function xuexcha()
    {
        $flight = Users::select('id', 'school_name', 'password')->get();


        return $flight ?
            json_success('查询成功!', 'true', 200) :
            json_fail('查询失败!', 'false', 100);

    }

    /*
 * 返回报名信息
 */
    public function baocha()
    {
        $flight = Users_if::select('id', 'school_name', 'education', 'name', 'competition_1', 'competition_3')->get();


        return $flight ?
            json_success('查询成功!', 'true', 200) :
            json_fail('查询失败!', 'false', 100);

    }

    /*
     *默认全部项目
     */
    public function bisaicha()
    {
        $flight = managers::select('competition_1', 'competition_2', 'competition_3')->get();


            return $flight ?
                json_success('查询成功!', 'true', 200) :
                json_fail('查询失败!', 'false', 100);

    }

    //
    public function adda(Request $request)
    {
        // 实例化 User 模型并填充表单数据
        $data = [
            'username' => $request->input('username'),
            'age' => $request->input('age'),

        ];

        $user = UserModel::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'New user added successfully!',
            'data' => $user,
        ]);
    }

/*
 * 用户端报名信息删除
 */
    public function sancyong(Request $request){
        $name = $request['id'];
//        $count = Users_inf::jianc($request['name']);//监测是否报名
            $datab =users_if::destroy($request['id']);
            return $datab ?
                json_success('删除成功!', 'true', 200) :
                json_fail('删除失败!', 'false', 100);

    }
    /*
     * 用户端批量删除
     */
    public function piliangshancyong(Request $request){
        $ids = $request->input('ids');

        for ($i=1; $i<=(strlen($ids))/2+1; $i++)
        {
            $data = Users_if::destroy($i);
            return $data ?
                json_success('删除成功!', 'true', 200) :
                json_fail('删除失败!', 'false', 100);

        }
    }

/*
 * 管理端账号管理删除
 */
public function sancguan(Request $request){
    $name = $request['id'];
//        $count = Users_inf::jianc($request['name']);//监测是否报名
    $datab =users::destroy($request['id']);
    return $datab ?
        json_success('删除成功!', 'true', 200) :
        json_fail('删除失败!', 'false', 100);

}
/*
 * 管理端账号批量删除
 */
public function piliangshancguan(Request $request){
    $ids = $request->input('ids');

    for ($i=1; $i<=(strlen($ids))/2+1; $i++)
    {
        $data = Users::destroy($i);
        return $data ?
            json_success('删除成功!', 'true', 200) :
            json_fail('删除失败!', 'false', 100);

    }
}/*
 * 管理员报名信息删除
 */
public function sancguanbao(Request $request){
    $name = $request['id'];
//        $count = Users_inf::jianc($request['name']);//监测是否报名
    $datab =users_if::destroy($request['id']);
    return $datab ?
        json_success('删除成功!', 'true', 200) :
        json_fail('删除失败!', 'false', 100);

}
/*
 * 管理员报名信息批量删除
 */
public function piliangshancguanbao(Request $request){
    $ids = $request->input('ids');

    for ($i=1; $i<=(strlen($ids))/2+1; $i++)
    {
        $data = Users_if::destroy($i);
        return $data ?
            json_success('删除成功!', 'true', 200) :
            json_fail('删除失败!', 'false', 100);

    }
}
    /*
     * 比赛项目信息删除
     */
    public function sancguanbi(Request $request){
        $name = $request['id'];
//        $count = Users_inf::jianc($request['name']);//监测是否报名
        $datab =managers::destroy($request['id']);
        return $datab ?
            json_success('删除成功!', 'true', 200) :
            json_fail('删除失败!', 'false', 100);

    }
    /*
     * 比赛项目批量删除
     */
    public function piliangshancguannbi(Request $request){
        $ids = $request->input('ids');

        for ($i=1; $i<=(strlen($ids))/2+1; $i++)
        {
            $data = managers::destroy($i);
            return $data ?
                json_success('删除成功!', 'true', 200) :
                json_fail('删除失败!', 'false', 100);

        }
    }

    /*
 * 比赛报名
 */
    public function registered_1(Request $request)
    {
        $data = Users_if::jiancb($request);   //检测账号密码是否存在
        if ($data == 0) {
            $datab = [
                'school_name' => $request->input('schoool_name'),
                'name' => $request->input('name'),
                'sex' => $request->input('sex'),
                'age' => $request->input('age'),
                'nation' => $request->input('nation'),
                'phone' => $request->input('phon'),
                'identity' => $request->input('identity'),
                'competition_group' => $request->input('competition_group'),

                'education' => $request->input('education'),
                'teacher' => $request->input('teacher'),
                'competition_1' => $request->input('competition_1'),
                'competition_2' => $request->input('competition_2'),
                'username' => $request->input('username'),
                'competition_3' => $request->input('competition_3'),

            ];
            $student_id = Users_if::createUser($datab);
            return $student_id ?
                $this->respondWithToken($student_id, "注册成功") :
                json_fail('注册失败!', null, 100);
        } else {
            return json_success('注册失败!该号已经注册过了！', null, 100);
        }
    }
}




