<?php
/**
 * File: XzhController.php
 * Created at 2018/9/11 13:52.
 * Author: ZMF
 */

class XzhController extends Q
{
    private $token='fes15fes5sef5fe';
    private $clientId='ydR7pKbCGzVwoiF4F5LC90kbDTZRy5Ss';
    private $secretKey='EOb2y5lsaTEtPreP7emT7rWWpDq9w9tM';
    private $msg=[];
    private $welcome='';

    public function actionDo()
    {
        //验证
        if(isset($_GET['echostr'])){
            $this->valid();
        }
        echo 'success';
        $postArr=$_POST;
        $postJson='';
        foreach ($postArr as $key=>$val){
            if(strpos($key,'MsgId')!==false && strpos($key,'FromUserName')!==false){
                $postJson=$key;
                break;
            }
        }
        $dataArr=CJSON::decode($postJson,true);
        $this->msg=$dataArr;
        switch ($dataArr['MsgType']){
            case 'text';
                $this->welcome='真是棒棒哒，被你发现了这个秘密~功能暂时还在完善中，一起期待吧~';
                $this->sendTemplateMsg();
                break;
            case 'image';
                $this->welcome='哇哦，图片真好看~';
                $this->replyText();
                break;
            case 'voice';
                $this->welcome='哇哦，声音真好听~';
                $this->replyText();
                break;
            case 'event';
                $this->sendTemplateMsg();
                break;
        }
    }

    /**
     * 接入验证
     */
    private function valid(){
        $timestamp=zmf::val('timestamp',2);
        $nonce=zmf::val('nonce',1);
        $signature=zmf::val('signature',1);
        $echostr=zmf::val('echostr',1);
        $strSignature = $this->getSHA1($timestamp, $nonce);
        if ($strSignature == $signature) {
            echo $echostr;
        } else {
            //校验失败
            echo 'failed';
        }
        Yii::app()->end();
    }

    /**
     * 回复客服消息
     */
    private function replyText(){
        $token=$this->getAccessToken();
        if(!$token){
            return;
        }
        $url="https://openapi.baidu.com/rest/2.0/cambrian/message/custom_send?access_token=".$token;
        $replyData=[
            'touser'=>$this->msg['FromUserName'],
            'msgtype'=>'text',
            'text'=>[
                'content'=>$this->welcome
            ]
        ];
        $res=zmf::curlPost($url,CJSON::encode($replyData));
        zmf::fp($res,1);
    }

    private function sendTemplateMsg(){
        $attr=[
            'touser'=>$this->msg['FromUserName'],
            'template_id'=>'ql87VjxgVeP3mBGavKhFoOGyeC2w1axsvmJobib4cFThaO6muxabS',
            'url'=>zmf::config('baseurl'),
            'data'=>[
                'first'=>[
                    'value'=>'终于等到你！'
                ],
                'keyword1'=>[
                    'value'=>zmf::time()
                ],
                'keyword2'=>[
                    'value'=>zmf::config('sitename')
                ],
                'remark'=>[
                    'value'=>zmf::config('siteDesc')
                ],
            ],
            'footer'=>[
                [
                    'type'=>'link',
                    'content'=>zmf::config('sitename'),
                    'detail_title'=>'立即访问',
                    'detail_url'=>zmf::config('baseurl'),
                ]
            ]
        ];
        $token=$this->getAccessToken();
        if(!$token){
            return;
        }
        $url="https://openapi.baidu.com/rest/2.0/cambrian/template/send?access_token=".$token;
        $res=zmf::curlPost($url,CJSON::encode($attr));
        zmf::fp($res,1);
    }

    private function getAccessToken(){
        $key="xzh-access-token";
        $token=zmf::getFCache($key);
        if($token){
            return $token;
        }
        $url="https://openapi.baidu.com/oauth/2.0/token?grant_type=client_credentials&client_id=".$this->clientId."&client_secret=".$this->secretKey;
        $data=zmf::request_by_curl($url,'');
        $arr=CJSON::decode($data,true);
        if($arr['access_token']){
            zmf::setFCache($arr['access_token'],7000);
            return $arr['access_token'];
        }
        zmf::fp($arr,1);
        return null;
    }

    private function getSHA1($intTimeStamp, $strNonce, $strEncryptMsg = '')
    {
        $arrParams = array(
            $this->token,
            $intTimeStamp,
            $strNonce,
        );
        if (!empty($strEncryptMsg)) {
            array_unshift($arrParams, $strEncryptMsg);
        }
        sort($arrParams, SORT_STRING);
        $strParam = implode($arrParams);
        return sha1($strParam);
    }

}