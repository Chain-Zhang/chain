<?php

/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:16
 */
namespace App\Models;

class ChainResult
{
    public $status;
    public $message;

    public function toJson(){
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }
}