<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/2/24
 * Time: 上午12:27
 */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class CheckLogin
{
    /**
     * 返回请求过滤器
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $member = $request->session()->get('user','');
        if ($member == '') {
            Log::info('未登陆,进入登录界面');
            return redirect('member/login');
        }
        Log::info('已登录,用户名:'. $member->username);
        view()->share(['username' => $member->username]);
        return $next($request);
    }

}