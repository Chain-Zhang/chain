<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/4/4
 * Time: 下午5:04
 */

namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;

class TimelineController extends Controller
{
    public function toTimeline(){
        return view('member.timeline');
    }
}