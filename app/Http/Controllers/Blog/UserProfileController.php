<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/20
 * Time: 下午6:33
 */

namespace App\Http\Controllers\Blog;


use App\Entities\Myproject;
use App\Entities\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Entities\VisitCapacity;
use Illuminate\Support\Facades\Log;

class UserProfileController extends Controller
{
    public  function toAboutMe(Request $request){
        $user_profile = UserProfile::find(1);
        $tags = explode(",",$user_profile->tags);
        $user_profile->tag_arr = $tags;

        $projects = Myproject::where([["user_id", 3],["status",1]])->orderby("pro_date","desc")->get();

        $tag_class = array("label-primary","label-success","label-info","label-warning","label-danger");
        $iconbg_class = array("bg-primary","bg-warning","bg-info","bg-success","bg-danger");

        Log::info($projects);

        $visit_capacity = new VisitCapacity();
        $visit_capacity->ip = $request->getClientIp();
        $visit_capacity->site = 4;
        $visit_capacity->save();


        return view('blog.aboutme',[
            'user_profile' => $user_profile,
            'projects' =>$projects,
            'tag_class' =>$tag_class,
            'iconbg_class' =>$iconbg_class,
        ]);
    }
}