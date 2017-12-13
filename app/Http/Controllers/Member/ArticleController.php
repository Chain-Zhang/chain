<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/4/3
 * Time: 下午5:59
 */

namespace App\Http\Controllers\Member;


use App\Entities\Article;
use App\Entities\AtcContent;
use App\Entities\Category;
use App\Http\Controllers\Controller;
use App\Models\ChainResult;
use App\Utility\BaiduPush;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function toArticle()
    {
        $articles = Article::orderby('created_at', 'desc')->paginate(10);
        foreach ($articles as $article) {
            $category = Category::find($article->category_id);
            if ($category != null) {
                $article->category_name = $category->name;
            } else {
                $article->category_name = 'unknown';
            }
        }
        return view('member.article',
            [
                'articles' => $articles,
            ]
        );
    }

    public function toAdd()
    {
        $categories = Category::all();
        return view('member.article_add',
            [
                'categories' => $categories
            ]);
    }
    public function toEdit($id)
    {
        $categories = Category::all();
        $article = Article::find($id);
        $atc_content = AtcContent::where('article_id', $id)->first();
        $article->content = $atc_content->content;
        Log::info('博客标题'. $article->title);
        return view('member.article_edit',
            [
                'categories' => $categories,
                'article'=>$article
            ]);
    }

    public function toDetail($id)
    {
        $article = Article::find($id);
        $atc_content = AtcContent::where('article_id', $id)->first();
        $article->content = $atc_content->content;
        Log::info('博客标题'. $article->title);
        return view('member.article_detail',
            [
                'article'=>$article
            ]);
    }

    /*-----------------Service------------------*/
        public function Add(Request $request)
    {
        $chain_result = new ChainResult();

        $title = $request->input('title', '');
        $summary = $request->input('summary', '');
        $content = $request->input('content', '');
        $category_id = $request->input('category_id', '');
        $status = $request->input('status', '');
        $keywords = $request->input('keywords', '');
        if ($title == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客标题不能为空';
            return $chain_result->toJson();
        }

        if ($summary == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客简介不能为空';
            return $chain_result->toJson();
        }
        if ($content == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客内容不能为空';
            return $chain_result->toJson();
        }
        if ($category_id == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客分类不能为空';
            return $chain_result->toJson();
        }

        $article = new Article();
        $article->title = $title;
        $article->summary = $summary;
        $article->status = $status == '' ? 0 : $status;
        $article->category_id = $category_id;
        $article->keywords = $keywords;
        $user = $request->session()->get('user', '');
        if ($user != '') {
            $article->user_id = $user->id;
        }


        if ($article->save()) {
            $atc_content = new AtcContent();
            $atc_content->content = $content;
            $atc_content->article_id = $article->id;
            if ($atc_content->save()) {
                $pushResult = null;
                if ($article->status == 1){
                    $arrUrls = array('http://www.chairis.cn/blog/article/'. $article->id);
                    $pushResult = json_decode(BaiduPush::Push($arrUrls)) ;
                }
                $chain_result->status = 0;
                if (isset($pushResult->success) && $pushResult->success > 0){
                    $chain_result->message = '博客' . $article->title . '已添加成功! 且成功推出到百度收录';
                }else{
                    $chain_result->message = '博客' . $article->title . '已添加成功!,但推送到百度收录失败';
                }
                return $chain_result->toJson();
            }

        }
        $chain_result->status = 1;
        $chain_result->message = '添加分类失败,请稍后再试';
        $chain_result->toJson();

    }

    public function Mod(Request $request)
    {
        $chain_result = new ChainResult();

        $id = $request->input('id', '');
        $title = $request->input('title', '');
        $summary = $request->input('summary', '');
        $content = $request->input('content', '');
        $category_id = $request->input('category_id', '');
        $status = $request->input('status', '');
        $keywords = $request->input('keywords', '');
        if ($id == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客ID不能为空';
            return $chain_result->toJson();
        }
        if ($title == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客标题不能为空';
            return $chain_result->toJson();
        }

        if ($summary == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客简介不能为空';
            return $chain_result->toJson();
        }
        if ($content == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客内容不能为空';
            return $chain_result->toJson();
        }
        if ($category_id == '') {
            $chain_result->status = 1;
            $chain_result->message = '博客分类不能为空';
            return $chain_result->toJson();
        }

        $article = Article::find($id);
        $article->title = $title;
        $article->summary = $summary;
        $article->status = $status == '' ? 0 : $status;
        $article->category_id = $category_id;
        $article->keywords = $keywords;
        $user = $request->session()->get('user', '');
        if ($user != '') {
            $article->user_id = $user->id;
        }


        if ($article->save()) {
            $atc_content = AtcContent::where('article_id', $id)->first();
            $atc_content->content = $content;
            if ($atc_content->save()) {
                $pushResult = null;
                if ($article->status == 1){
                    $arrUrls = array('http://www.chairis.cn/blog/article/'. $article->id);
                    $pushResult = json_decode(BaiduPush::Push($arrUrls)) ;
                }
                $chain_result->status = 0;
                if (isset($pushResult->success) && $pushResult->success > 0){
                    $chain_result->message = '博客' . $article->title . '已修改成功! 且成功推出到百度收录';
                }else{
                    $chain_result->message = '博客' . $article->title . '已修改成功!,但推送到百度收录失败';
                }
                return $chain_result->toJson();
            }

        }
        $chain_result->status = 1;
        $chain_result->message = '修改博客失败,请稍后再试';
        $chain_result->toJson();

    }

    public function Del(Request $request){
        $chain_result = new ChainResult();

        $id = $request->input('id','');
        if ($id == ''){
            $chain_result->status = 1;
            $chain_result->message = '博客编号为空';
            return $chain_result->toJson();
        }
        $article = new Article();
        if ($article == null){
            $chain_result->status = 1;
            $chain_result->message = '博客编号【' . $id . '】不存在!';
            return $chain_result->toJson();
        }
        if (Article::destroy($id) > 0){
            $atc_content = AtcContent::where('article_id', $id)->first();
            AtcContent::destroy($atc_content->id);
            $chain_result->status = 0;
            $chain_result->message = '删除成功';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '删除文章失败,请稍后再试';
            $chain_result->toJson();
        }
    }

    public  function PushBaidu(Request $request){
        $chain_result = new ChainResult();

        $id = $request->input('id','');
        if ($id == ''){
            $chain_result->status = 1;
            $chain_result->message = '博客编号为空';
            return $chain_result->toJson();
        }
        $article = Article::find($id);
        if ($article == null){
            $chain_result->status = 1;
            $chain_result->message = '博客编号【' . $id . '】不存在!';
            return $chain_result->toJson();
        }

        $arrUrls = array('http://www.chairis.cn/blog/article/'. $id);
        $pushResult = json_decode(BaiduPush::Push($arrUrls)) ;
        if (isset($pushResult->success) && $pushResult->success > 0){
            $chain_result->status = 0;
            $chain_result->message = '文章【'.$article->title.'】成功推送到百度';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '文章【'.$article->title.'】推送到百度失败';
            $chain_result->toJson();
        }
    }
}