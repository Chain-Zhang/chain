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
use Illuminate\Http\Request;
use App\Entities\VisitCapacity;


class CategoryController extends Controller
{
    public function toCategory(Request $request,$id){
        $articles = Article::where('category_id', $id)->where('status', 1)->orderby('created_at', 'desc')->paginate(5);
        $categories = Category::all();
        $current_category = Category::find($id);

        $visit_capacity = new VisitCapacity();
        $visit_capacity->ip = $request->getClientIp();
        $visit_capacity->site = 2;
        $visit_capacity->save();

        return view('blog.category',[
            'articles' => $articles,
            'categories' => $categories,
            'current_category' => $current_category
        ]);
    }
}