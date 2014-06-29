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
    public $enableCsrfValidation = false;
    const FIELD_TO = 'ToUserName';
    const FIELD_FROM = 'FromUserName';
    const FIELD_CREATE_TIME = 'CreateTime';
    const FIELD_MSG_TYPE = 'MsgType';
    const FIELD_CONTENT = 'Content';
    private $signature;
    private $timestamp;
    private $nonce;
    private $postXml;

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
                $this->postXml = simplexml_load_string($postStr);
                $messageType = $this->postXml->MsgType;
                file_put_contents(\Yii::$app->runtimePath.'/logs/app.log', $messageType, FILE_APPEND);
                if (method_exists($this, $messageType)) return $this->$messageType();
            }
        }
    }

    private function event()
    {
        $eventName = $this->postXml->Event;
        $eventKey = $this->postXml->EventKey;
        file_put_contents(\Yii::$app->runtimePath.'/logs/app.log', $eventName.'_'.$eventKey, FILE_APPEND);
        if (method_exists($this, $eventName)) return $this->$eventName($eventKey);
        return false;
    }

    private function subscribe($eventKey = null)
    {
        //对订阅用户回复注册绑定的图文内容（news）
        $xml = $this->xmlWriter();
        $xml->startElement(self::FIELD_MSG_TYPE);
        $xml->writeCdata('news');
        $xml->endElement();
        $xml->startElement('ArticleCount');
        $xml->text(1);
        $xml->endElement();
        $xml->startElement('Articles');
        $xml->startElement('item');
        $xml->startElement('Title');
        $xml->writeCdata('绑定平台账户，开启财富之旅。');
        $xml->endElement();
        $xml->startElement('Description');
        $xml->writeCdata('易贷发是一家高科技网络金融服务公司，创始团队是来自于金融、法律和互联网行业的资深人士，我们希望通过跨界的合作与知识的共享，通过互联网技术让更多的人享受金融服务，实践普惠金融。');
        $xml->endElement();
        $xml->startElement('PicUrl');
        $xml->writeCdata('http://9huimai.com/public/attachment/201403/06/13/53180bd19c25c.png');
        $xml->endElement();
        $xml->startElement('Url');
        $xml->writeCdata('http://www.9huimai.com');
        $xml->endElement();
        $xml->endElement();
        $xml->endElement();
        $xml->endDocument();
        $message = $xml->outputMemory(true);
        exit($this->messageFormatter($message));
    }

    private function messageFormatter($xmlStr)
    {
        $xmlStr = preg_replace('/<\?xml.*\?>/', '<xml>', $xmlStr);
        return $xmlStr . '</xml>';
    }

    private function xmlWriter()
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->startDocument();
        $xmlWriter->startElement(self::FIELD_FROM);
        $xmlWriter->writeCdata($this->postXml->ToUserName);
        $xmlWriter->endElement();
        $xmlWriter->startElement(self::FIELD_TO);
        $xmlWriter->writeCdata($this->postXml->FromUserName);
        $xmlWriter->endElement();
        $xmlWriter->startElement(self::FIELD_CREATE_TIME);
        $xmlWriter->text(time());
        $xmlWriter->endElement();
        return $xmlWriter;
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