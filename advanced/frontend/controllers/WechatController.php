<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/28/2014
 * Time: 1:09 AM
 */

namespace frontend\controllers;


use yii\web\Controller;

class WechatController extends Controller
{
    const PARAM_TOKEN = 'f1582cb3ffa64bd43d8795';
    private $signature;
    private $timestamp;
    private $nonce;

    public function actionIndex($signature, $timestamp, $nonce, $echostr=null)
    {
        $this->signature = $signature;
        $this->timestamp = $timestamp;
        $this->nonce = $nonce;
        if ($this->sign())
        {
            if ($echostr) exit($echostr);
            $postStr = trim(file_get_contents('php://input'));
            if ($postStr && $message = simplexml_load_string($postStr))
            {
                exit(
                    sprintf("<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>", $message->FromUserName, $message->ToUserName, time(), '欢迎致信易贷发公众服务号，我们正在进行开发测试。')
                );
            }
        }
    }

    public function actionVerify($signature, $timestamp, $nonce, $echostr=null)
    {
            $arr = [self::PARAM_TOKEN, $timestamp, $nonce];
            sort($arr);
            $str = implode('',$arr);
            $str = sha1($str);
            if ($signature == $str) exit($echostr);
    }

    private function sign()
    {
        $params = [self::PARAM_TOKEN, $this->timestamp, $this->nonce];
        sort($params);
        exit(sha1(implode('', $params)));
        if ($this->signature == sha1(implode('',$params))) return true;
        return false;
    }
} 