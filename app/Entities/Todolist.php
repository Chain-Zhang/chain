<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:12
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    public $table = 'todolist';
    public $primaryKey = 'id';
    public $timestamps = true;
}