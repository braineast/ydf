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
    public $enableCsrfValidation = false;

    public function actionIndex($signature, $timestamp, $nonce, $echostr=null)
    {
        file_put_contents(\Yii::$app->runtimePath.'/logs/wechat.log', sprintf("%s\n", json_encode($_REQUEST)), FILE_APPEND);
        $this->signature = $signature;
        $this->timestamp = $timestamp;
        $this->nonce = $nonce;
        if ($this->sign())
        {
            if ($echostr) exit($echostr);
            $postStr = trim(file_get_contents('php://input'));
            file_put_contents(\Yii::$app->runtimePath.'/logs/wechat.log', sprintf("%s\n", $postStr), FILE_APPEND);
            if ($postStr)
            {
                $message = simplexml_load_string($postStr);
                $xml = new \SimpleXMLElement('<xml></xml>');
                $xml->addChild('ToUserName', $message->FromUserName);
                $xml->addChild('FromUserName', $message->ToUsername);
                $xml->addChild('CreateTime', time());
                $xml->addChild('MsgType', 'text');
                $xml->addChild('Content', '收到您的信息了，我们正在处理您的请求！');
                file_put_contents(\Yii::$app->runtimePath.'/logs/wechat.log', $xml->asXML(), FILE_APPEND);
                exit($xml->asXML());
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
        if ($this->signature == sha1(implode($params))) return true;
        exit(sha1(implode('',$params)));
        return false;
    }
}