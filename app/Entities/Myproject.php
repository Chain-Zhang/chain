<?php
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2018/1/20
 * Time: 上午12:24
 */

namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class Myproject extends Model
{
    public $timestamps = true;

    public $primaryKey = 'id';

    public $table = 'myproject';

    public function getStringProDate(){
        $date=date_create($this->pro_date);
        return date_format($date, 'Y/m/d');
    }
}