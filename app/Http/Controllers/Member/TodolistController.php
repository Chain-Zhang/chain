<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/4/3
 * Time: 下午11:10
 */

namespace App\Http\Controllers\Member;


use App\Entities\Todolist;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ChainResult;
use Illuminate\Support\Facades\Session;

class TodolistController extends Controller
{
    public function toTodolist(Request $request){
        $todoArr = $this->getTodolist();
        $doneArr = $this->getDonelist();

        return view('member.todolist',[
            'todocount' => $todoArr['count'],
            'todolistHtml' => $todoArr['html'],
            'donecount' => $doneArr['count'],
            'donelistHtml' => $doneArr['html']
        ]);
    }


    /*--------------------Service----------------------*/
    public function Add(Request $request)
    {

        $chain_result = new ChainResult();
        $content = $request->input('content', '');
        if ($content == '') {
            $chain_result->status = 1;
            $chain_result->message = '内容不能为空';
            return $chain_result->toJson();
        }

        $todolist = new Todolist();
        $todolist->content = $content;
        $todolist->status = 0;
        $user = $request->session()->get('user', '');
        if ($user != '') {
            $todolist->user_id = $user->id;
        }
        if ($todolist->save()) {
            $todoArr = $this->getTodolist();
            $chain_result->status = 0;
            $chain_result->message = '新增成功';
            $chain_result->todocount = $todoArr['count'];
            $chain_result->todolistHtml = $todoArr['html'];
            return $chain_result->toJson();
        } else {
            $chain_result->status = 1;
            $chain_result->message = '添加待办事项失败,请稍后再试';
            return $chain_result->toJson();
        }
    }

    public function Finished(Request $request){
        $chain_result = new ChainResult();
        $id = $request->input('id', '');
        if ($id == ''){
            $chain_result->status = 1;
            $chain_result->message = 'id不能为空';
            return $chain_result->toJson();
        }
        $todolist = Todolist::find($id);
        $todolist->status = 1;
        if($todolist->save()){


            //为完成待办事项
            $todoArr = $this->getTodolist();
            $doneArr = $this->getDonelist();
            $chain_result->status = 0;
            $chain_result->message = '成功';
            $chain_result->donecount = $doneArr['count'];
            $chain_result->donelistHtml = $doneArr['html'];
            $chain_result->todocount = $todoArr['count'];
            $chain_result->todolistHtml = $todoArr['html'];
            return $chain_result->toJson();
        }

    }

    private function getTodolist(){
        $user = Session::get('user', '');
        $todolists = Todolist::where('user_id', $user->id)
            ->where('status', 0)
            ->where('created_at', '>=', Carbon::today())
            ->orderBy('created_at', 'desc')
            ->get();
        $todolistHtml = '';
        $todocount = count($todolists);
        if($todocount > 0){
            foreach ($todolists as $todo){
                $todolistHtml .= "<li><input type='checkbox' onchange='_onchanged(" . $todo->id .");'>" . $todo->content . "</li>";
            }
        }
        return ['count' => $todocount,'html' => $todolistHtml];
    }

    private function getDonelist(){
        $user = Session::get('user', '');
        //已完成待办事项
        $donelists = Todolist::where('user_id', $user->id)
            ->where('status', 1)
            ->where('created_at', '>=', Carbon::today())
            ->orderBy('updated_at', 'desc')
            ->get();

        $donecount = count($donelists);
        $donelistHtml = '';
        if($donecount > 0){
            foreach ($donelists as $done){
                $donelistHtml .= "<li>" . $done->content . "</li>";
            }
        }
        return ['count' => $donecount, 'html'=>$donelistHtml];
    }
}