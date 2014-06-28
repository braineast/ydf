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
    const FIELD_TO = 'ToUserName';
    const FIELD_FROM = 'FromUserName';
    const FIELD_CREATE_TIME = 'CreateTime';
    const FIELD_MSG_TYPE = 'MsgType';
    const FIELD_CONTENT = 'Content';
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
                $xml = new \XMLWriter();
                $xml->openMemory();
                $xml->startDocument(null);
                $xml->startElement(self::FIELD_FROM);
                $xml->writeCdata($message->ToUserName);
                $xml->endElement();
                $xml->startElement(self::FIELD_TO);
                $xml->writeCdata($message->FromUserName);
                $xml->endElement();
                $xml->startElement(self::FIELD_CREATE_TIME);
                $xml->text(time());
                $xml->endElement();
                $xml->startElement(self::FIELD_MSG_TYPE);
                $xml->text('text');
                $xml->endElement();
                $xml->startElement(self::FIELD_CONTENT);
                $xml->writeCdata('欢迎致信易贷发，我们将竭诚为您服务！');
                $xml->endElement();
                $xml->endDocument();
                $message = $xml->outputMemory(true);
                file_put_contents(\Yii::$app->runtimePath.'/logs/wechat.log', $message, FILE_APPEND);
                exit($message);
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