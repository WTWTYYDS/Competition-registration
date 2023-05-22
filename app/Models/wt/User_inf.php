<?php

namespace App\Models\wt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User_inf extends Model
{
    protected $table = 'users_inf';
    protected $guarded = [];
    //设置主键默认字段
    protected $fillable = ['school_name','name','sex','age','nation','phone','identity','state',
        'competition_group','education','teacher','competition_1','competition_2','competition_3'];
    protected $hidden = [
    ];

    public static function search($request) {
        try {
            $student_id = self::select('id as 编号','school_name as 学校','competition_group as 学生/教师组',
                'education as 本科/专科','name as 姓名','competition_1 as 比赛类型',
                'competition_3 as 比赛项目','phone as 联系方式')
                ->where('competition_1',$request['competition_1'])
                ->where('competition_3',$request['competition_3'])
                ->where('state','1')
                ->get();
            return $student_id;
        } catch (\Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function search_user($request) {
        try {

//            $x = '0';
//            if ($request->filled('competition_3')){
//                $x = '1';
//            }

            $student_id = self::select('id as 编号','competition_group as 学生/教师组', 'education as 本科/专科',
                'name as 姓名','competition_1 as 比赛类型', 'competition_3 as 比赛项目',
                'phone as 联系电话','state as 报名状态')
                ->where('competition_1',$request['competition_1'])
                ->where('competition_3',$request['competition_3'])
//                ->whereRaw('IF (`'.$x.'` = 0, , `competition_3`'.' = '.$request['competition_3'].')')
                ->get();
            return $student_id;
        } catch (\Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function user_inf_add($request)    {
        try {
            if(self::where('identity',$request['identity'])->first()) {
                return '参赛人员已经存在';
            }else{
                return self::create(request(['school_name','name','sex','age','nation','phone','identity', 'competition_group',
                    'education','teacher','competition_1','competition_2','competition_3']))->save();
            }

        } catch (\Exception $e) {
            logError('添加用户报名信息失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function user_inf_state($id)    {
        try {
            self::where('id',$id)->update(['state'=>'1']);
        } catch (\Exception $e) {
            logError('添加用户报名信息失败!', [$e->getMessage()]);
        }
    }

    /**
     * school_name查询该校向报名情况
     *
     */
    public static function select_1($name) {
        try {
            $count = self::where('school_name',$name)
                ->where('state','1')
                ->count();
            return $count;
        } catch (\Exception $e) {
            logError('添加用户报名信息失败!', [$e->getMessage()]);
        }
    }

    /**
     * school_name查询该校向报名情况
     *
     */
    public static function select_excel($request) {
        try {
            $student_id = self::select('school_name as 学校','competition_group as 学生/教师组','name as 姓名',
                'education as 本科/专科','competition_1 as 比赛类型', 'competition_3 as 比赛项目','phone as 联系方式')
                ->where('competition_1',$request['competition_1'])
                ->where('competition_3',$request['competition_3'])
                ->where('state','1')
                ->get();
            return $student_id;
        } catch (\Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function select_excel_all($request) {
        try {
            $student_id = self::select('school_name as 学校','competition_group as 学生/教师组','name as 姓名',
                'education as 本科/专科','competition_1 as 比赛类型', 'competition_3 as 比赛项目','phone as 联系方式')
                ->where('state','1')
                ->get();
            return $student_id;
        } catch (\Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

}
