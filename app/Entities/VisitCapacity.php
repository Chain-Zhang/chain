<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/6/22
 * Time: 上午9:51
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class VisitCapacity extends Model
{
    protected $table = 'visit_capacity';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function getSite(){
        switch ($this->site){
            case 1:
                return '首页文章列表';
            case 2:
                return '分类文章列表';
            case 3:
                return'文章详情';
            case 4:
                return '关于我';
            default :
                return '未知';
        }
    }
}