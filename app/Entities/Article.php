<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:04
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public $table = 'article';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function getStatus()
    {
        switch ($this->status){
            case 0:
                return '草稿';
            case 1:
                return '已发布';
            default:
                return '未知';
        }
    }
}