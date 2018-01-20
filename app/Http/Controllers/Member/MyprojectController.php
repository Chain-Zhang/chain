<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2018/1/20
 * Time: 上午12:25
 */

namespace App\Http\Controllers\Member;


use App\Entities\Myproject;
use App\Models\ChainResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MyprojectController
{
    public function toList(){
        $projects = Myproject::where("status","<>",0)->orderby("pro_date", "desc")->get();
        return view('member.project_list',
            [
                'projects' => $projects
            ]);
    }

    public function toEdit($id){
        $project = Myproject::find($id);
        if ($project == null){
            $project = new Myproject();
        }
        return view('member.project_edit',[
            'project' => $project
        ]);
    }
    public function toAdd(){
        return view('member.project_add');
    }

    /*----------------services-------------------*/
    public function ProjectAdd(Request $request){
        Log::info("add project");
        $chain_result = new ChainResult();
        $project = new Myproject();
        $project->name = $request->input('name','');
        $project->pro_date = $request->input('pro_date','');
        $project->source = $request->input('source','');
        $project->pro_url = $request->input('pro_url','');
        $project->icon = $request->input('icon','');
        $project->picture = $request->input('picture','');
        $project->tags = $request->input('tags','');
        $project->desc = $request->input('desc','');
        $project->status = 1;

        $user = $request->session()->get('user', '');
        if ($user == ''){
            $chain_result->status = 1;
            $chain_result->message = '当前用户登录已过期,请重新登录。';
            return $chain_result->toJson();
        }
        $project->user_id = $user->id;

        if ($project->save()){
            $chain_result->status = 0;
            $chain_result->message = '新增项目成功';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '新增项目失败,请稍后再试。';
            return $chain_result->toJson();
        }
    }

    public function ProjectEdit(Request $request){
        $chain_result = new ChainResult();
        $id = $request->input("id", '');
        $project = Myproject::find($id);
        Log::info($project);
        $project->name = $request->input('name','');
        $project->pro_date = $request->input('pro_date','');
        $project->source = $request->input('source','');
        $project->pro_url = $request->input('pro_url','');
        $project->icon = $request->input('icon','');
        $project->picture = $request->input('picture','');
        $project->tags = $request->input('tags','');
        $project->desc = $request->input('desc','');

        if ($project->save()){
            $chain_result->status = 0;
            $chain_result->message = '新增项目成功';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '新增项目失败,请稍后再试。';
            return $chain_result->toJson();
        }
    }

    public function ProjectDel(Request $request){
        $chain_result = new ChainResult();
        $id = $request->input("id", '');
        $project = Myproject::find($id);
        $project->status = 0;
        if ($project->save()){
            $chain_result->status = 0;
            $chain_result->message = '删除项目成功';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '删除项目失败,请稍后再试。';
            return $chain_result->toJson();
        }
    }

    public function ProjectEnable(Request $request){
        $chain_result = new ChainResult();
        $id = $request->input("id", '');
        $status = $request->input("status", '');
        $project = Myproject::find($id);
        $project->status = $status;
        if ($project->save()){
            $chain_result->status = 0;
            $chain_result->message = '隐藏项目成功';
            return $chain_result->toJson();
        }
        else{
            $chain_result->status = 1;
            $chain_result->message = '隐藏项目失败,请稍后再试。';
            return $chain_result->toJson();
        }
    }
}