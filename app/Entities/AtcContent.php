<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/3/31
 * Time: 上午11:05
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class AtcContent extends Model
{
    public $table = 'atc_content';
    public $primaryKey = 'id';
    public $timestamps = true;
}