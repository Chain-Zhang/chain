<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:01
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public $table = 'user_profile';
    public $primaryKey = 'id';
    public $timestamps = true;
}