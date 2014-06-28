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
            if ($echostr) exit($echostr);
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
        if ($this->signature == sha1(implode('',$params))) return true;
        exit(sha1(implode('',$params)));
        return false;
    }
} 