<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/16
 * Time: 下午2:50
 */

namespace App\Http\Controllers\Blog;


use App\Entities\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ChainResult;

class CommentController extends Controller
{
    public function Add(Request $request){
        Log::info('增加留言');
        $chain_result = new ChainResult();

        $article_id = $request->input('article_id', '');
        $nickname = $request->input('nickname', '');
        $content = $request->input('content', '');

        if ($article_id == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客编号不能为空';
            return $chain_result->toJson();
        }

        if ($nickname == '') {
            $chain_result->status = 1;
            $chain_result->message = '昵称不能为空';
            return $chain_result->toJson();
        }
        if ($content == '') {
            $chain_result->status = 1;
            $chain_result->message = '发表内容不能为空';
            return $chain_result->toJson();
        }

        $comment = new Comment();
        $comment->article_id = $article_id;
        $comment->content = $content;
        $comment->nickname=$nickname;
        if ($comment->save()){
            $chain_result->status = 0;
            $chain_result->message = '添加成功';
            return $chain_result->toJson();
        }
        $chain_result->status = 1;
        $chain_result->message = '发表留言失败,请稍后再试';
        $chain_result->toJson();
    }
}