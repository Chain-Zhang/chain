<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/4/3
 * Time: 下午4:56
 */

namespace App\Http\Controllers\Member;


use App\Entities\Category;
use App\Http\Controllers\Controller;
use App\Models\ChainResult;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function toCategory(){
        $categories = Category::all();

        return view('member.category',
        [
            'categories' => $categories
        ]);
    }

    /*---------------------Service--------------------*/

    public function Add(Request $request){
        $chain_result = new ChainResult();
        $name = $request->input('name','');
        if ($name == ''){
            $chain_result->status = 1;
            $chain_result->message = '请输入分类名称';
            return $chain_result->toJson();
        }
        $category = Category::where('name', $name)->first();
        if ($category != null){
            $chain_result->status = 1;
            $chain_result->message = '【' . $name . '】已存在!';
            return $chain_result->toJson();
        }
        $category = new Category();
        $category->name = $name;
        if ($category->save()){
            $chain_result->status = 0;
            $chain_result->message = '添加成功';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '添加分类失败,请稍后再试';
            $chain_result->toJson();
        }
    }

    public function Del(Request $request){
        $chain_result = new ChainResult();

        $id = $request->input('id','');
        if ($id == ''){
            $chain_result->status = 1;
            $chain_result->message = '分类编号为空';
            return $chain_result->toJson();
        }
        $category = Category::find($id);
        if ($category == null){
            $chain_result->status = 1;
            $chain_result->message = '分类编号【' . $id . '】不存在!';
            return $chain_result->toJson();
        }
        if (Category::destroy($id) > 0){
            $chain_result->status = 0;
            $chain_result->message = '删除成功';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '删除分类失败,请稍后再试';
            $chain_result->toJson();
        }
    }

    public function Mod(Request $request){
        $chain_result = new ChainResult();

        $id = $request->input('id','');
        $name = $request->input('name','');
        if ($id == ''){
            $chain_result->status = 1;
            $chain_result->message = '分类编号为空';
            return $chain_result->toJson();
        }
        if ($name == ''){
            $chain_result->status = 1;
            $chain_result->message = '分类名称不能为空';
            return $chain_result->toJson();
        }
        $category = Category::find($id);
        if ($category == null){
            $chain_result->status = 1;
            $chain_result->message = '分类编号【' . $id . '】不存在!';
            return $chain_result->toJson();
        }
        $category->name = $name;
        if ($category->save()){
            $chain_result->status = 0;
            $chain_result->message = '修改成功';
            return $chain_result->toJson();
        }else{
            $chain_result->status = 1;
            $chain_result->message = '修改分类失败,请稍后再试';
            $chain_result->toJson();
        }
    }
}