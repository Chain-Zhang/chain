<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 下午1:30
 */
namespace App\Http\Controllers\Blog;

use App\Entities\Article;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /*-----------------------------------------------
     *进入博客首页界面, 博客列表按时间排序
     -----------------------------------------------*/
    public function toArticles(){
        $articles = Article::where([])->orderby('created_at', 'desc')->skip(0)->take(20)->get();
        return view('blog.article',[
            'articles' => $articles
        ]);
    }
}