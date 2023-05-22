<?php

namespace App\Models\wt;

use Illuminate\Database\Eloquent\Model;

class CompetitionAdd3 extends Model
{
    protected $table = 'competition_3';
    protected $remeberTokenName = NULL;
    protected $guarded = [];
    protected $fillable = [ 'type2','type3','type_id'];
    protected $hidden = [];

    public static function competition_add(array $array = []): bool
    {
        try {
            $student_id = self::create($array)->id;
            return $student_id ?
                $student_id :
                false;
        } catch (Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            return false;
        }
    }

    public static function select_3($request)  {
        $type2 = $request['type2'];
        try{
            $count = self::select('type3')
                ->where('type2',$type2)
                ->get();
            return $count;
        }catch (\Exception $e) {
            logError("比赛项目查询失败！", [$e->getMessage()]);
            return false;
        }
    }}
