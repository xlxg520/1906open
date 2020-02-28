<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\AppModel;

class IndexController extends Controller
{
    public function  reg()
    {
        return view ('User.reg');
    }

    public  function regDo(Request $request)
    {

        //打印一下 是否可以接收到 post传过来的值
  echo  "<pre>";print_r($request->input());echo "</pre>";
         $pass1 = $request->input('pass1');
         $pass2 = $request->input('pass2');
         $user_name = $request->input('u_name');
         if($pass1 !=$pass2){
             echo "您两次输入的密码不一致";die;
         }
         $pass = password_hash($pass1,PASSWORD_BCRYPT);

        //入库
        $data =[
            'u_name' =>  $request->input('u_name'),
            'u_email' =>  $request->input('u_email'),
            'u_number' =>  $request->input('u_number'),
            'pass'  => $pass,

        ];
       $uid =  UserModel::insertGetId($data);

       if ($uid > 0){
            echo "注册成功";
        }else{
            echo "注册失败";
        }

    echo '<hr>';


        //为用户生成APPID  与 SECRET
        $app_id =  UserModel::gernerateAppid($user_name);
        $app_secret = UserModel::generateSecret();

         //写入APP表中
        $app_info =  [
            'uid' => $uid,
            'app_id' => $app_id,
            'app_secret' => $app_secret,
        ];

        $data = AppModel::insertGetId($app_info);
        if($data > 0 ){
            echo "ok";
        }else{
            echo "内部问题， 请联系管理员";
        }

        echo "用户APP_ID:" .$app_id;echo"<br>";
        echo "用户APP_SECRET:" .$app_id;echo"<br>";





    }





















    //用户登录
    public function  login()
    {
        return view ('User.login');
    }

    public function  loginDo(Request $request)
    {
          echo  "<pre>";print_r($request->input());echo "</pre>";
          $name = $request->input('u_name');
          $pass = $request->input('pass');


          $u = UserModel::where(['u_name'=>$name])
              ->orWhere(['u_email'=>$name])
              ->orWhere(['u_number'=>$name])
              ->first();

          if($u == NULL ){
              echo  "用户不存在";die;
          }

          //验证密码
        if(!password_verify($pass,$u->pass) )
        {
            echo "密码不正确";die;
        }else{
            echo "恭喜你登录成功";
        }
        
    }


}
