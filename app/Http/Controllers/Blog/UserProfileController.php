<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/20
 * Time: 下午6:33
 */

namespace App\Http\Controllers\Blog;


use App\Entities\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\VisitCapacity;

class UserProfileController extends Controller
{
    public  function toAboutMe(Request $request){
        $user_profile = UserProfile::find(1);

        $visit_capacity = new VisitCapacity();
        $visit_capacity->ip = $request->getClientIp();
        $visit_capacity->site = 4;
        $visit_capacity->save();

        return view('blog.about_me',[
            'user_profile' => $user_profile
        ]);
    }
}