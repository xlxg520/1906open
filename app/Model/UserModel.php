<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class UserModel extends Model
{
    protected  $table = 'p_user';



    //生成 appid  规则 根据用户名 和 时间戳  进行MD5加密
    public   static  function  gernerateAppid($u_name)
    {
      return  'LN'.substr(md5($u_name.time().mt_rand(11111,99999)),5,14);
    }


    //生成 App secret
    public static function generateSecret()
    {
        return Str::random(32);
    }


}
