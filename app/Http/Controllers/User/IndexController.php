<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
class IndexController extends Controller
{
    public function  reg()
    {
        return view ('User.reg');
    }

    public  function regDo(Request $request)
    {

        //打印一下 是否可以接收到 post传过来的值
//        echo  "<pre>";print_r($request->input());echo "</pre>";
         $pass1 = $request->input('pass1');
         $pass2 = $request->input('pass2');
         if($pass1 !=$pass2){
             echo "您两次输入的密码不一致";die;
         }
         $pass = password_hash($pass1,PASSWORD_BCRYPT);

        //入库
        $data =[
            'u_name' =>  $request->input('u_name'),
            'u_email' =>  $request->input('u_email'),
            'u_number' =>  $request->input('u_number'),
            'pass'  => $pass
        ];
       $uid =  UserModel::insertGetId($data);
        if ($uid > 0){
            echo "注册成功";
        }else{
            echo "注册失败";
        }
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
