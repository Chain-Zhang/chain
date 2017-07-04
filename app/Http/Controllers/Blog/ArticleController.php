<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 下午1:30
 */
namespace App\Http\Controllers\Blog;

use App\Entities\Article;
use App\Entities\Category;
use App\Entities\AtcContent;
use App\Entities\Comment;
use App\Entities\Tourist;
use App\Entities\VisitCapacity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /*-----------------------------------------------
     *进入博客首页界面, 博客列表按时间排序
     -----------------------------------------------*/
    public function toArticles(Request $request){
        $articles = Article::where('status', 1)->orderby('created_at', 'desc')->get();
        $categories = Category::all();
        $visit_capacity = new VisitCapacity();
        $visit_capacity->ip = $request->getClientIp();
        $visit_capacity->site = 1;
        $visit_capacity->save();
        return view('blog.article',[
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function toDetail(Request $request,$id)
    {
        $article = Article::find($id);
        $article->read_count  = $article->read_count + 1;
        $article->save();
        $atc_content = AtcContent::where('article_id', $id)->first();
        $article->content = $atc_content->content;
        $current_category = Category::find($article->category_id);
        $article->category_name = $current_category->name;
        $comments = Comment::where('article_id', $id)->orderby('created_at')->get();

        $visit_capacity = new VisitCapacity();
        $visit_capacity->ip = $request->getClientIp();
        $visit_capacity->site = 3;
        $visit_capacity->save();
        $tourist = Tourist::where('ip', $request->getClientIp())->first();
        if (empty($tourist)){
            $tourist = new Tourist();
        }
        Log::info("评论人昵称: " . $tourist->nickname);
        Log::info("评论人IP: " . $tourist->ip);
        return view('blog.article_detail',
            [
                'article'=>$article,
                'comments' => $comments,
                'tourist' => $tourist
            ]);
    }
}