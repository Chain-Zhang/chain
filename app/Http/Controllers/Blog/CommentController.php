<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/16
 * Time: 下午2:50
 */

namespace App\Http\Controllers\Blog;


use App\Entities\Article;
use App\Entities\Comment;
use App\Entities\Tourist;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\ChainResult;

class CommentController extends Controller
{
    public function Add(Request $request){
        Log::info('增加留言');
        $chain_result = new ChainResult();
        $touris = Tourist::where('ip', $request->getClientIp())->first();
        if (!empty($touris)){
            $interver = floor((strtotime(date("y-m-d H:i:s")) - strtotime($touris->updated_at))%86400/60);
            Log::info("当前时间: " . date("y-m-d H:i:s"));
            Log::info("上次评论时间: " . $touris->updated_at);
            Log::info("时间间隔:".$interver);
            if ($interver < 3){
                $chain_result->status = 1;
                $chain_result->message = "不可以连续评论,请稍后再试";
                return $chain_result->toJson();
            }
        }
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
            $article = Article::find($article_id);
            $article->comment_count ++;
            $article->save();
            $chain_result->status = 0;
            $chain_result->message = '添加成功';
            if (empty($touris)){
                $touris = new Tourist();
                $touris->ip = $request->getClientIp();
                $touris->nickname = $nickname;
            }
            $touris->comment_count ++;
            $touris->save();
            return $chain_result->toJson();
        }
        $chain_result->status = 1;
        $chain_result->message = '发表留言失败,请稍后再试';
        $chain_result->toJson();
    }
}