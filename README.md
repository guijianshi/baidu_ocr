# 百度ocr识别sdk php的composer包
此包适用于各类支持composer的php框架

## 安装
```
composer require guijianshi/baidu-ocr
```
## 版本说明
版本与官方保持一致可以根据自己实际使用选择最低版本为(2.2.3)

## 使用
使用与官方文档一致

```
//本地图片识别
$client = new baidu\ocr\AipOcr(APP_ID, API_KEY, SECRET_KEY);
$image = file_get_contents(__DIR__ . '/test.png'); // 图片地址 (远程地址https可用这个)
$result = $client->basicGeneral($image);
```

```
//远程图片识别
$client = new baidu\ocr\AipOcr(APP_ID, API_KEY, SECRET_KEY);
$url = 'http://test.com'; // 只支持http地址(不支持https)图片地址 https可以用楼上方法
$result = $client->basicGeneral($url);
```


