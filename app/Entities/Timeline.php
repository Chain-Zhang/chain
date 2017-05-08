<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:13
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    public $table = 'timeline';
    public $primaryKey = 'id';
    public $timestamps = true;
}