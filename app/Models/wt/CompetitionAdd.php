<?php

namespace App\Models\wt;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompetitionAdd extends Model
{
    protected $table = 'competition_2';
    protected $guarded = [];
    //设置主键默认字段
    protected $fillable = ['type1','type2'];
    protected $hidden = [

    ];


    /**
     * 创建用户
     *
     * @param array $array
     * @return |null
     * @throws \Exception
     */
    public static function competition_add($request)
    {
        $array = ['type1'=>$request['type1'],'type2'=>$request['type2']];

        try {
//            return self::create(request(['type1','type2']))->id;
            $student_id = self::create($array)->id;
            return $student_id ?
                $student_id :
                false;
        } catch (Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function checkid($request)  {
        $type1 = $request['type1'];
        $type2 = $request['type2'];
        try{
            $count = self::where('type1',$type1)
                ->where('type2',$type2)
                ->get();
            return $count[0]->id;
        }catch (\Exception $e) {
            logError("比赛项目查询失败！", [$e->getMessage()]);
            return false;
        }
    }

    public static function select_2($request)  {
        $type1 = $request['type1'];
        try{
            $count = self::select('type2')
                ->where('type1',$type1)
                ->get();
            return $count;
        }catch (\Exception $e) {
            logError("比赛项目查询失败！", [$e->getMessage()]);
            return false;
        }
    }
}
