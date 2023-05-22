<?php

namespace App\Http\Controllers\wt;

use App\Http\Controllers\Controller;
use App\Models\wt\CompetitionAdd;
use App\Models\wt\CompetitionAdd3;
use App\Models\wt\User_inf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Competiton_InfController extends Controller
{
    //

    // man  添加项目 ok
    public function add(Request $request)   {
        if(!CompetitionAdd3::where('type3',$request['type3'])->exists()) {
            $id = CompetitionAdd::checkid($request);

            if($id==null)  {
                $i = CompetitionAdd::competition_add($request);
                $to = CompetitionAdd3::competition_add(['type2'=>$request['type2'],'type3'=>$request['type3'],'type_id'=>$i]);
                return $to?
                    json_success('添加项目成功!','true',  200):
                    json_fail('添加项目失败!','false', 100 );

            }else{
                $t = CompetitionAdd3::competition_add(['type2'=>$request['type2'],'type3'=>$request['type3'],'type_id'=>$id]);
                return $t?
                    json_success('添加项目成功!','true',  200):
                    json_fail('添加项目失败!','false', 100 );
            }
        }else{
            return json_success('添加项目失败!该项目已经存在！','false',100  );
        }
    }

    // 查询2级项目
    public function find2(Request $request) {
        $sel = CompetitionAdd::select_2($request);
        if (count($sel)>0 ){
            return json_success('查询项目成功!', $sel, 200);
        } else {
            return json_fail('查询项目失败,不存在下一级项目!', 'false', 100);
        }
    }

    // 查询3级项目
    public function find3(Request $request) {
        $sel = CompetitionAdd3::select_3($request);
        if (count($sel)>0 ){
            return json_success('查询项目成功!', $sel, 200);
        } else {
            return json_fail('查询项目失败,不存在下一级项目!', 'false', 100);
        }
    }

    // 查询全部项目
    public function find_all_user(Request $request)  {
        $data= User_inf::search_user($request);

        if (count($data)>0 ){
            return json_success('搜索成功!', $data, 200);
        } else {
            return json_fail('搜索失败,无人报名!', 'false', 100);
        }
    }
    // 查询全部项目
    public function find_all(Request $request)  {
        $data= User_inf::search($request);
        if (count($data)>0 ){
            return json_success('搜索成功!', $data, 200);
        } else {
            return json_fail('搜索失败,无人报名!', 'false', 100);
        }

    }
}
