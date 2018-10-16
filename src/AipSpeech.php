<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 18/10/16
 * Time: 上午11:20
 */

namespace baidu\ocr;


use baidu\ocr\lib\AipBase;

class AipSpeech extends AipBase
{

    /**
     * url
     * @var string
     */
    public $asrUrl = 'http://vop.baidu.com/server_api';

    /**
     * url
     * @var string
     */
    public $ttsUrl = 'http://tsn.baidu.com/text2audio';

    /**
     * 判断认证是否有权限
     * @param  array $authObj
     * @return boolean
     */
    protected function isPermission($authObj)
    {
        return true;
    }

    /**
     * 处理请求参数
     * @param string $url
     * @param array $params
     * @param array $data
     * @param array $headers
     */
    protected function proccessRequest($url, &$params, &$data, $headers)
    {

        $token = isset($params['access_token']) ? $params['access_token'] : '';

        if (empty($data['cuid'])) {
            $data['cuid'] = md5($token);
        }

        if ($url === $this->asrUrl) {
            $data['token'] = $token;
            $data = json_encode($data);
        } else {
            $data['tok'] = $token;
        }

        unset($params['access_token']);
    }

    /**
     * 格式化结果
     * @param $content string
     * @return mixed
     */
    protected function proccessResult($content)
    {
        $obj = json_decode($content, true);

        if ($obj === null) {
            $obj = array(
                '__json_decode_error' => $content
            );
        }

        return $obj;
    }

    /**
     * @param  string $speech
     * @param  string $format
     * @param  int $rate
     * @param  array $options
     * @return array
     */
    public function asr($speech, $format, $rate, $options = array())
    {
        $data = array();

        if (!empty($speech)) {
            $data['speech'] = base64_encode($speech);
            $data['len'] = strlen($speech);
        }

        $data['format'] = $format;
        $data['rate'] = $rate;
        $data['channel'] = 1;

        $data = array_merge($data, $options);

        return $this->request($this->asrUrl, $data, array());
    }

    /**
     * @param  string $text
     * @param  string $lang
     * @param  int $ctp
     * @param  array $options
     * @return array
     */
    public function synthesis($text, $lang = 'zh', $ctp = 1, $options = array())
    {
        $data = array();

        $data['tex'] = $text;
        $data['lan'] = $lang;
        $data['ctp'] = $ctp;

        $data = array_merge($data, $options);

        $result = $this->request($this->ttsUrl, $data, array());

        if (isset($result['__json_decode_error'])) {
            return $result['__json_decode_error'];
        }

        return $result;
    }

}
