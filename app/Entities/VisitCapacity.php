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
}