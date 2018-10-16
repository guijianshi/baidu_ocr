<?php
/**
 * Created by PhpStorm.
 * User: guijianshi
 * Date: 18/10/16
 * Time: 上午11:34
 */
require_once __DIR__ . '/../vendor/autoload.php';
use baidu\ocr\AipOcr;
const APP_ID = 'APP_ID'; // 你的APP_ID
const API_KEY = 'API_KEY'; // 你的API_KEY
const SECRET_KEY = 'SECRET_KEY'; // 你的SECRET_KEY

$client = new AipOcr(APP_ID, API_KEY, SECRET_KEY);
$image = file_get_contents(__DIR__ . '/test.png');

$result = $client->basicGeneral($image);
echo json_encode($result) . PHP_EOL; // {"log_id":6982811490359330585,"words_result_num":1,"words_result":[{"words":"80"}]}