<?php

namespace App\Http\Controllers\djp;

use App\Http\Controllers\Controller;
use App\Http\Requests\wt\FromUserInf;
use App\Models\wt\User_inf;
use App\Models\wt\SupUser;
use App\Models\wt\CompetitionAdd;
use App\Models\wt\CompetitionAdd3;
use Elastic\Apm\ElasticApm;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Project;

class AdminController extends Controller
{
    //显示用户的所有信息
    public function showcase($id)
    {
//        $data = User_inf::all();
//        return  $data;
        // $id=$request['id'];
        $info = User_inf::find($id);
        if (!$info) {
            return json_fail('无该用户', 'null', 400);
        } else {
            return json_success('用户获取成功', $info, 200);
        }
    }

    //确定更改用户的信息
    public function revise(FromUserInf $request)
    {
        $id=$request['id'];
        $info=User_inf::where(['id'=>$id])->first();
        $info->school_name=$request['school_name'];
        $info->name=$request['name'];
        $info->age=$request['age'];
        $info->nation=$request['nation'];
        $info->phone=$request['phone'];
        $info->identity=$request['identity'];
        $info->state=$request['state'];
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

    //显示将要修改项目的信息
    public function showproject($id){
        $info = CompetitionAdd3::where(['id' => $id])->first();
         $type_id = $info['type_id'];
         $game[0]=$id;
         if (!$info){
             return json_success('项目查找失败1','null',400);
         }
         $data = CompetitionAdd::where(['id' => $type_id])->first();
        if (!$data){
            return json_success('项目查找失败2','null',400);
        }
        $game[1]=$data['type1'];
        $game[2]=$data['type2'];
        $game[3]=$info['type3'];
         return json_success('项目查找成功',$game,200);
    }


    //修改项目的内容
    public function chage(Request $request){
        $id=$request['id'];
        $info = CompetitionAdd3::where(['id' => $id])->first();
        $number=$info['type_id'];
        if (!$info){
            return json_fail('项目查找失败1','null',400);
        }
        $data= CompetitionAdd::where(['id' => $number])->first();
        if (!$data){
            return json_fail('项目查找失败2','null',400);
        }
       $info->type3=$request['type3'];
        $info->type2=$request['type2'];
        $data->type2=$request['type2'];
        $data->type1=$request['type1'];
        if ($data->save()&&$info->save()){
            return json_success('修改成功',$info,200);
        }
        else{
            return json_fail('修改失败','null',400);
        }
    }

}
