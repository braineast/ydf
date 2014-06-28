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
    const PARAM_TOKEN = 'f1582cb3ffa64bd4bdfca73d8795';
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
            if (isset($_POST) && $_POST)
            {
            }
            elseif ($echostr)
            {
                exit($echostr);
            }
        }
    }

    public function actionVerify()
    {
        if ($_GET && isset($_GET[self::PARAM_TIMESTAMP]) && isset($_GET[self::PARAM_NONCE]) && isset($_GET[self::PARAM_ECHOSTR]))
        {
            file_put_contents('/tmp/logs', serialize($_GET), FILE_APPEND);
            $arr = [self::PARAM_TOKEN, $_GET[self::PARAM_TIMESTAMP], $_GET[self::PARAM_NONCE]];
            sort($arr);
            $str = implode('',$arr);
            $str = sha1($str);
            if ($_GET[self::PARAM_SIGNATURE] == $str) exit($_GET[self::PARAM_ECHOSTR]);
        }
    }

    private function sign()
    {
        $params = [self::PARAM_TOKEN, $this->timestamp, $this->nonce];
        sort($params);
        if ($this->signature == sha1(implode($params))) return true;
        return false;
    }
} 