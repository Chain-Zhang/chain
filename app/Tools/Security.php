<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 下午5:13
 */
namespace App\Tools;

class Security
{
    public static function Encrypt($password){
        return md5($password);
    }
}