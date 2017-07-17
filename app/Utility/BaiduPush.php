<?php

namespace App\Utility;
/**
 * Created by PhpStorm.
 * User: chain
 * Date: 2017/7/17
 * Time: 上午9:56
 */
class BaiduPush
{
    public static function Push($arrUrls){
        $api = 'http://data.zz.baidu.com/urls?site=www.chairis.cn&token=zBjqBwdSVYVbo17L';
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $arrUrls),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        return curl_exec($ch);
    }
}