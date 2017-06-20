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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /*-----------------------------------------------
     *进入博客首页界面, 博客列表按时间排序
     -----------------------------------------------*/
    public function toArticles(){
        $articles = Article::where('status', 1)->orderby('created_at', 'desc')->skip(0)->take(20)->get();
        $categories = Category::all();
        return view('blog.article',[
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    public function toDetail($id)
    {
        $article = Article::find($id);
        $article->read_count  = $article->read_count + 1;
        $article->save();
        $atc_content = AtcContent::where('article_id', $id)->first();
        $article->content = $atc_content->content;
        $current_category = Category::find($article->category_id);
        $article->category_name = $current_category->name;
        $comments = Comment::where('article_id', $id)->orderby('created_at')->get();
        return view('blog.article_detail',
            [
                'article'=>$article,
                'comments' => $comments
            ]);
    }
}