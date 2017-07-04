<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/4
 * Time: 下午5:28
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    public $table = 'tourist';
    public $primaryKey = 'id';
    public $timestamps = true;
}