<?php
/**
 * Created by PhpStorm.
 * User: mc
 * Date: 18/10/16
 * Time: 上午11:16
 */

namespace baidu\ocr;


use baidu\ocr\lib\AipBase;

class AipImageCensor extends AipBase{

    /**
     * antiporn api url
     * @var string
     */
    private $antiPornUrl = 'https://aip.baidubce.com/rest/2.0/antiporn/v1/detect';

    /**
     * antiporn gif api url
     * @var string
     */
    private $antiPornGifUrl = 'https://aip.baidubce.com/rest/2.0/antiporn/v1/detect_gif';

    /**
     * antiterror api url
     * @var string
     */
    private $antiTerrorUrl = 'https://aip.baidubce.com/rest/2.0/antiterror/v1/detect';

    /**
     * @var string
     */
    private $faceAuditUrl = 'https://aip.baidubce.com/rest/2.0/solution/v1/face_audit';

    /**
     * @var string
     */
    private $imageCensorCombUrl = 'https://aip.baidubce.com/api/v1/solution/direct/img_censor';

    /**
     * @var string
     */
    private $imageCensorUserDefinedUrl = 'https://aip.baidubce.com/rest/2.0/solution/v1/img_censor/user_defined';

    /**
     * @var string
     */
    private $antiSpamUrl = 'https://aip.baidubce.com/rest/2.0/antispam/v2/spam';

    /**
     * @param  string $image 图像读取
     * @return array
     */
    public function antiPorn($image){

        $data = array();
        $data['image'] = base64_encode($image);

        return $this->request($this->antiPornUrl, $data);
    }

    /**
     * @param  string $image 图像读取
     * @return array
     */
    public function multi_antiporn($images){

        $data = array();
        foreach($images as $image){
            $data[] = array(
                'image' => base64_encode($image),
            );
        }

        return $this->multi_request($this->antiPornUrl, $data);
    }

    /**
     * @param  string $image 图像读取
     * @return array
     */
    public function antiPornGif($image){

        $data = array();
        $data['image'] = base64_encode($image);

        return $this->request($this->antiPornGifUrl, $data);
    }

    /**
     * @param  string $image 图像读取
     * @return array
     */
    public function antiTerror($image){

        $data = array();
        $data['image'] = base64_encode($image);

        return $this->request($this->antiTerrorUrl, $data);
    }

    /**
     * @param  string $images 图像读取
     * @return array
     */
    public function faceAudit($images, $configId=''){

        // 非数组则处理为数组
        if(!is_array($images)){
            $images = array(
                $images,
            );
        }

        $data = array(
            'configId' => $configId,
        );

        $isUrl = substr(trim($images[0]), 0, 4) === 'http';
        if(!$isUrl){
            $arr = array();

            foreach($images as $image){
                $arr[] = base64_encode($image);
            }
            $data['images'] = implode(',', $arr);
        }else{
            $urls = array();

            foreach($images as $url){
                $urls[] = urlencode($url);
            }

            $data['imgUrls'] = implode(',', $urls);
        }

        return $this->request($this->faceAuditUrl, $data);
    }

    /**
     * @param  string $image 图像读取
     * @return array
     */
    public function imageCensorComb($image, $scenes='antiporn', $options=array()){

        $scenes = !is_array($scenes) ? explode(',', $scenes) : $scenes;

        $data = array(
            'scenes' => $scenes,
        );

        $isUrl = substr(trim($image), 0, 4) === 'http';
        if(!$isUrl){
            $data['image'] = base64_encode($image);
        }else{
            $data['imgUrl'] = $image;
        }

        $data = array_merge($data, $options);

        return $this->request($this->imageCensorCombUrl, json_encode($data), array(
            'Content-Type' => 'application/json',
        ));
    }

    /**
     * @param  string $image 图像
     * @return array
     */
    public function imageCensorUserDefined($image){

        $data = array();

        $isUrl = substr(trim($image), 0, 4) === 'http';
        if(!$isUrl){
            $data['image'] = base64_encode($image);
        }else{
            $data['imgUrl'] = $image;
        }

        return $this->request($this->imageCensorUserDefinedUrl, $data);
    }

    /**
     * @param  string $content
     * @return array
     */
    public function antiSpam($content, $options=array()){

        $data = array();
        $data['content'] = $content;

        $data = array_merge($data, $options);

        return $this->request($this->antiSpamUrl, $data);
    }

}
