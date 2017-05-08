<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:09
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;

    public $primaryKey = 'id';

    public $table = 'comment';
}