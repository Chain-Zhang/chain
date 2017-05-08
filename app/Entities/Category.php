<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:11
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $table = 'category';
    public $primaryKey = 'id';
    public $timestamps = true;
}