<?php

namespace App\Models\wt;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable ;

    protected $table = 'users';
    protected $remeberTokenName = NULL;
    protected $guarded = [];
    protected $fillable = [ 'password','admin','school_name'];
    protected $hidden = [
        'password',
    ];
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return ['role' => 'user'];
    }


    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }
    /**
     * 创建用户
     *
     * @param array $array
     * @return |null
     * @throws \Exception
     */
    public static function createUser($array = [])
    {
        try {
            $student_id = self::create($array)->id;
            //echo "student_id:" . $student_id;
            return $student_id ?
                $student_id :
                false;
        } catch (\Exception $e) {
            logError('添加用户失败!', [$e->getMessage()]);
            die($e->getMessage());
            return false;
        }
    }

    /**
     * 查询该工号是否已经注册
     * 返回该工号注册过的个数
     * @param $request
     * @return false
     */
    public static function checknumber($request)
    {
        $student_job_number = $request['admin'];
        try{
            $count = self::where('admin',$student_job_number)
                ->count();
            return $count;
        }catch (\Exception $e) {
            logError("账号查询失败！", [$e->getMessage()]);
            return false;
        }
    }

    /**
     * where 删除
     */
    public static function del($name)
    {
        try{
            $count = self::where('school_name',$name)->delete();
            return $count;
        }catch (\Exception $e) {
            logError("账号删除失败！", [$e->getMessage()]);
            return false;
        }
    }

    /**
     *
     *查询学校名和账号
     */
    public static function sel_users()  {
        try{
            $count = self::select('school_name as 学校名', 'admin as 账号')->get();
//            $count = self::all();
            return $count;
        }catch (\Exception $e) {
            logError("查询学校名和账号失败！", [$e->getMessage()]);
            return false;
        }
    }
    /**
     *
     *查询学校名和账号
     */
    public static function dim_sel_users($name)  {
        try{
            $count = self::select('school_name as 学校名', 'admin as 账号')
                ->where('school_name','like','%'.$name.'%')
                ->get();
            return $count;
        }catch (\Exception $e) {
            logError("查询学校名和账号失败！", [$e->getMessage()]);
            return false;
        }
    }
}
