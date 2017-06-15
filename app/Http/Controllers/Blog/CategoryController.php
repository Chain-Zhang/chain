<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/15
 * Time: 下午3:49
 */

namespace App\Http\Controllers\Blog;

use App\Entities\Article;
use App\Entities\Category;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function toCategory($id){
        $articles = Article::where('category_id', $id)->orderby('created_at', 'desc')->get();
        $categories = Category::all();
        $current_category = Category::find($id);
        return view('blog.category',[
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $current_category
        ]);
    }
}