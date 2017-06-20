<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 下午1:22
 */

namespace App\Http\Controllers\Member;
use App\Entities\User;
use App\Http\Controllers\Controller;
use App\Models\ChainResult;
use App\Tools\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /*-----------------------------------------------
     *进入登录界面
     -----------------------------------------------*/
    public function toLogin(){
        return view('member.login');
    }

    /*-----------------------------------------------
     *进入注册界面
     -----------------------------------------------*/
    public function toRegister(){
        return view('member.register');
    }

    public  function toChangePassword(){
        return view('member.changepassword');
    }
    public  function toProfile(){
        return view('member.profile_edit');
    }

    public function toHome(){
        return view('member.home');
    }



    /*-------------------Service--------------------*/

    /*-----------------------------------------------
     *登录请求
     -----------------------------------------------*/
    public function Login(Request $request)
    {
        Log::info('开始进行登录');
        $username = $request->input('username', '');
        $password = $request->input('password', '');

        $chain_result = new ChainResult();
        if ($username == '') {
            $chain_result->status = 1;
            $chain_result->message = '用户名不能为空';
            return $chain_result->toJson();
        }

        if ($password == '') {
            $chain_result->status = 1;
            $chain_result->message = '用户密码不能为空';
            return $chain_result->toJson();
        }

        $user = User::where('username', $username)->first();
        if ($user == null) {
            $chain_result->status = 1;
            $chain_result->message = '用户【' . $username . '】不存在';
            return $chain_result->toJson();
        }
        if (Security::Encrypt($password) != $user->password) {
            $chain_result->status = 1;
            $chain_result->message = '用户密码不正确';
            return $chain_result->toJson();
        }
        Session::put('user', $user);
        $chain_result->status = 0;
        $chain_result->message='登录成功';
        return $chain_result->toJson();
    }

    /*-----------------------------------------------
     *退出登录请求
     -----------------------------------------------*/
    public function Logout(Request $request)
    {
        $chain_result = new ChainResult();
        if($request->session()->has('user')){
            $request->session()->forget('user');
            $chain_result->status = 0;
            $chain_result->message = '退出登录成功';
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '你的用户尚未登录';
        }
        return $chain_result->toJson();
    }

    /*-----------------------------------------------
     *注册请求
     -----------------------------------------------*/
    public function Register(Request $request){
        Log::info('开始进行注册');
        $username = $request->input('username','');
        $password = $request->input('password','');
        $confirmpassword = $request->input('confirmpassword','');

        $chain_result = new ChainResult();
        if ($username == ''){
            $chain_result->status = 1;
            $chain_result->message = '用户名不能为空';
            return $chain_result->toJson();
        }

        if ($password == ''){
            $chain_result->status = 1;
            $chain_result->message = '用户密码不能为空';
            return $chain_result->toJson();
        }

        if ($password != $confirmpassword){
            $chain_result->status = 1;
            $chain_result->message = '两次输入的密码不一致';
            return $chain_result->toJson();
        }
        $users = User::where('username', $username)->get();
        if(count($users) > 0){
            $chain_result->status = 1;
            $chain_result->message = '该用户名已存在';
            return $chain_result->toJson();
        }

        $user = new User();
        $user->username = $username;
        $user->password = Security::Encrypt($password);
        $user->is_active = 0;
        if ($user->save()){
            $chain_result->status = 0;
            $chain_result->message = '用户:【'.$username . ']已注册成功!';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '用户:【'.$username . ']已注册失败!';
        }
    }

    /*-----------------------------------------------
     *修改密码
     -----------------------------------------------*/
    public function ChangePassword(Request $request){
        $chain_result = new ChainResult();
        $oldpw = $request->input('oldpw','');
        $newpw = $request->input('newpw','');
        $confirmpw = $request->input('confirmpw','');

        if($newpw != $confirmpw){
            $chain_result->status = 1;
            $chain_result->message = '两次输入的密码不一致';
            return $chain_result->toJson();
        }
        $user =User::find($request->session()->get('user', '')->id);
        if (Security::Encrypt($oldpw) != $user->password){
            $chain_result->status = 1;
            $chain_result->message = '旧密码不正确!';
            return $chain_result->toJson();
        }
        $user->password = Security::Encrypt($newpw);
        if ($user->save()){
            Session::put('user', $user);
            $chain_result->status = 0;
            $chain_result->message = '密码修改成功!';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '对不起, 密码修改失败, 请稍后再试!';
            return $chain_result->toJson();
        }
    }
}