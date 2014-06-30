<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/28/2014
 * Time: 1:09 AM
 */

namespace frontend\controllers;


use frontend\models\ydf\User;
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

    public function actionTest()
    {
        var_dump($this->createMenu());
    }

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
                if ('event' == $messageType) return $this->event();
            }
        }
    }

    public function event()
    {
        file_put_contents(\Yii::$app->runtimePath.'/logs/app.log', 'I am event method!', FILE_APPEND);
        $eventName = $this->postXml->Event;
        $eventKey = $this->postXml->EventKey;
        if ('subscribe' == $eventName) return $this->subscribe();
        if ('unsubscribe' == $eventName) return $this->unsubscribe();
        if ($eventKey == 'account_bind_action') return $this->userBind();
        if ($eventKey == 'account_summary_action') return $this->getAccountBrief();
        return false;
    }

    private function getAccountBrief()
    {
        $user = User::find()->where('wechat_open_id=:openid', [':openid'=>$this->postXml->FromUserName])->one();
        if ($user)
        {
            $balance = number_format($user->getAttribute('money'), 2);
            $freezeAmt = number_format($user->getAttribute('lock_money'), 2);
            $total = $balance + $freezeAmt;
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
            $xml->writeCdata('账户摘要数据统计');
            $xml->endElement();
            $xml->startElement('Description');
            $xml->writeCdata(sprintf("账户总额：%s\n其中可用金额：%s，冻结金额：%s", $total, $balance, $freezeAmt));
            $xml->endElement();
            $xml->startElement('PicUrl');
            $xml->writeCdata('http://9huimai.com/public/attachment/201403/06/13/53180bd19c25c.png');
            $xml->endElement();
            $xml->startElement('Url');
            $xml->writeCdata(\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('account?wechat='.$this->postXml->FromUserName));
            $xml->endElement();
            $xml->endElement();
            $xml->endElement();
            $xml->endDocument();
            $message = $xml->outputMemory(true);
            exit($this->messageFormatter($message));
        }
    }

    private function userBind()
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
        $xml->writeCdata('绑定平台账户，开启财富人生。');
        $xml->endElement();
        $xml->startElement('Description');
        $xml->writeCdata('易贷发是一家高科技网络金融服务公司，创始团队是来自于金融、法律和互联网行业的资深人士，我们希望通过跨界的合作与知识的共享，通过互联网技术让更多的人享受金融服务，实践普惠金融。');
        $xml->endElement();
        $xml->startElement('PicUrl');
        $xml->writeCdata('http://9huimai.com/public/attachment/201403/06/13/53180bd19c25c.png');
        $xml->endElement();
        $xml->startElement('Url');
        $xml->writeCdata(\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('user/login?wechat='.$this->postXml->FromUserName));
        $xml->endElement();
        $xml->endElement();
        $xml->endElement();
        $xml->endDocument();
        $message = $xml->outputMemory(true);
        exit($this->messageFormatter($message));
    }

    public function unsubscribe()
    {
        return file_put_contents(\Yii::$app->runtimePath.'/logs/app.log', 'I am unsubscribe method.', FILE_APPEND);
    }

    private function subscribe()
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
        $xml->writeCdata('绑定平台账户，开启财富人生。');
        $xml->endElement();
        $xml->startElement('Description');
        $xml->writeCdata('易贷发是一家高科技网络金融服务公司，创始团队是来自于金融、法律和互联网行业的资深人士，我们希望通过跨界的合作与知识的共享，通过互联网技术让更多的人享受金融服务，实践普惠金融。');
        $xml->endElement();
        $xml->startElement('PicUrl');
        $xml->writeCdata('http://9huimai.com/public/attachment/201403/06/13/53180bd19c25c.png');
        $xml->endElement();
        $xml->startElement('Url');
        $xml->writeCdata(\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('user/login?wechat='.$this->postXml->FromUserName));
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

    private function getAccessToken()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.\Yii::$app->params['wechat']['appid'].'&secret='.\Yii::$app->params['wechat']['appsecret'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $htmlReturn = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($htmlReturn, true);
        return $result['access_token'];
    }

    private function getMenu()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->getAccessToken();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $htmlMessage = curl_exec($ch);
        return json_decode($htmlMessage, true);
    }

    private function createMenu()
    {
        $menu = [
            'button'=>[
                [
                    'name'=>'账户',
                    'sub_button' => [
                        [
                            'name'=>'注册/绑定',
                            'type'=>'click',
                            'key'=>'account_bind_action',
                        ],
                        [
                            'name'=>'交易明细',
                            'type'=>'view',
                            'url'=>\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('account')
                        ],
                        [
                            'name'=>'账户余额',
                            'type'=>'click',
                            'key'=>'account_summary_action',
                        ],
                        [
                            'name'=>'充值',
                            'type'=>'view',
                            'url'=>\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('account/deposit'),
                        ],
                    ]
                ],
                [
                    'name'=>'理财',
                    'sub_button'=> [
                        [
                            'name'=>'去理财',
                            'type'=>'view',
                            'url'=>\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('product'),
                        ],
                        [
                            'name'=>'安全保障',
                            'type'=>'click',
                            'key'=>'info_get_guarantee_action'
                        ],
                        [
                            'name'=>'持有产品',
                            'type'=>'view',
                            'url'=>\Yii::$app->request->hostInfo.\Yii::$app->urlManager->createUrl('account/invests'),
                        ],
                    ]
                ],
                [
                    'name'=>'服务',
                    'sub_button'=> [
                        [
                            'name'=>'关于易贷发',
                            'type'=>'click',
                            'key'=>'info_get_aboutus_action'
                        ],
                        [
                            'name'=>'新手指导',
                            'type'=>'click',
                            'key'=>'info_get_newbie_guide_action'
                        ],
                        [
                            'name'=>'理财咨询',
                            'type'=>'click',
                            'key'=>'info_get_question_action'
                        ],
                        [
                            'name'=>'投诉建议',
                            'type'=>'click',
                            'key'=>'suggest_action'
                        ]
                    ]
                ]
            ]
        ];

        $menu = '{"button":[{"name":"账户","sub_button":[{"name":"注册/绑定","type":"click","key":"account_bind_action"},{"name":"交易明细","type":"view","url":"http:\/\/wx.ltxigu.com:8733\/account"},{"name":"账户余额","type":"click","key":"account_summary_action"},{"name":"充值","type":"view","url":"http:\/\/wx.ltxigu.com:8733\/account\/deposit"}]},{"name":"理财","sub_button":[{"name":"去理财","type":"view","url":"http:\/\/wx.ltxigu.com:8733\/product"},{"name":"安全保障","type":"click","key":"info_get_guarantee_action"},{"name":"持有产品","type":"view","url":"http:\/\/wx.ltxigu.com:8733\/account\/invests"}]},{"name":"服务","sub_button":[{"name":"关于易贷发","type":"click","key":"info_get_aboutus_action"},{"name":"新手指导","type":"click","key":"info_get_newbie_guide_action"},{"name":"理财咨询","type":"click","key":"info_get_question_action"},{"name":"投诉建议","type":"click","key":"suggest_action"}]}]}';
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->getAccessToken();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$menu);
        $htmlMessage = curl_exec($ch);
        curl_close($ch);
        var_dump(json_decode($htmlMessage, true));
        var_dump($htmlMessage);
        return json_decode($htmlMessage, true);
    }

    private function deleteMenu()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=' . $this->getAccessToken();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $ret = curl_exec($ch);
        return json_decode($ret, true);
    }
}