<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 下午1:22
 */

namespace App\Http\Controllers\Member;
use App\Entities\User;
use App\Entities\UserProfile;
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
    public  function toProfile(Request $request){
        $user =$request->session()->get('user', '');
        $user_profile = UserProfile::where('user_id', $user->id)->first();
        if ($user_profile == null){
            $user_profile = new UserProfile();
        }
        return view('member.profile_edit',
            [
                'user' => $user,
                'user_profile' => $user_profile
            ]);
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

    /*-----------------------------------------------
     *编辑个人资料
     -----------------------------------------------*/
    public function EditProfile(Request $request){
        $chain_result = new ChainResult();
        $nickname = $request->input('nickname','');
        $realname = $request->input('realname','');
        $email = $request->input('email','');
        $qq_number = $request->input('qq_number','');
        $phone_number = $request->input('phone_number','');
        $intro = $request->input('intro','');

        $user = $request->session()->get('user', '');
        if ($user == ''){
            $chain_result->status = 1;
            $chain_result->message = '当前用户登录已过期,请重新登录。';
            return $chain_result->toJson();
        }
        $user_profile = UserProfile::where('user_id', $user->id)->first();
        if ($user_profile == null){
            $user_profile = new UserProfile();
            $user_profile->user_id = $user->id;
        }
        $user_profile->nickname = $nickname;
        $user_profile->realname = $realname;
        $user_profile->email = $email;
        $user_profile->qq_number = $qq_number;
        $user_profile->phone_number = $phone_number;
        $user_profile->intro = $intro;
        if ($user_profile->save()){
            $chain_result->status = 0;
            $chain_result->message = '更新个人资料成功';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '个人资料更新失败,请稍后再试。';
            return $chain_result->toJson();
        }

    }
}