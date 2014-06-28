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
            file_put_contents(\Yii::$app->runtimePath.'/logs/wechat.log', sprintf("%s\n", trim(file_get_contents('php://input'))), FILE_APPEND);
            $postStr = trim(file_get_contents('php://input'));
            if ($postStr)
            {
                $message = simplexml_load_string($postStr);
                $ret = sprintf("<xml>
<ToUserName>%s</ToUserName>
<FromUserName>%s</FromUserName>
<CreateTime>%s</CreateTime>
<MsgType>text</MsgType>
<Content>%s</Content>
</xml>", $message->FromUserName, $message->ToUserName, time(),"Hello, Thank you!" );
                exit($ret);
            }
        }
    }

    public function actionVerify($signature, $timestamp, $nonce, $echostr=null)
    {
            $arr = [\Yii::$app->params['wechat']['token'], $timestamp, $nonce];
            sort($arr);
            $str = implode('',$arr);
            $str = sha1($str);
            if ($signature == $str) exit($echostr);
    }

    private function sign()
    {
        $params = [$this->timestamp, $this->nonce, \Yii::$app->params['wechat']['token']];
        sort($params);
        if ($this->signature == sha1(implode('',$params))) return true;
        exit(sha1(implode('',$params)));
        return false;
    }
} 