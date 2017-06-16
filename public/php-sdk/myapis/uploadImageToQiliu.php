<?php
require_once __DIR__ . '/../autoload.php';

use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;

$accessKey = '5zmzG0cy6LWM0geUQIuXzZmEMcUJPjmgVDUM8TsX';
$secretKey = 'XIn4GBrNPjdj7m6L6Kv4QwBkxKaK7P3W8pd2SUa0';

// 初始化签权对象。
$auth = new Auth($accessKey, $secretKey);

$bucket = "chairis";

$upToken = $auth->uploadToken($bucket);

// 初始化 UploadManager 对象并进行文件的上传。
$uploadMgr = new UploadManager();

$key = $_POST['name'];
$filePath = $_POST['image'];


list($ret, $err) = $uploadMgr->putFile($upToken, $key, $filePath);

if ($err !== null) {
    echo json_encode($err);
} else {
    echo json_encode($ret);
}