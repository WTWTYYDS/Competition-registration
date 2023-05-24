<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users_if extends Model
{
    protected $table = 'users_inf';
    public $timestamps = true;
    protected $fillable = ['school_name','name','sex','age','nation','phone','identity','state',
        'competition_group','education','teacher','competition_1','competition_2','competition_3'];
    protected $primarykey = 'id';
    public static function jianc($name) {
        try {
            $data = self::where('name',$name)
                ->where('state','1')
                ->count();
            return $data;
        } catch (\Exception $e) {
            logError('添加报名信息失败!', [$e->getMessage()]);
        }
    }
    public static function jiancb($name){
        try{
            $data = self::where('name',$name)->count();
            return $data;
        }catch(\Exception $e){
            logError('添加报名信息失败',[$e->getMessage()]);
        }
    }
}
