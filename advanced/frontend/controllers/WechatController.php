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
    const PARAM_SIGNATURE = 'signature';
    const PARAM_TIMESTAMP = 'timestamp';
    const PARAM_NONCE = 'nonce';
    const PARAM_ECHOSTR = 'echostr';
    const PARAM_TOKEN = 'xiaohubb';


    public function actionIndex()
    {
        exit('This is index action.');
    }

    public function actionVerify()
    {
        $arr = [self::PARAM_TOKEN, $_GET[self::PARAM_TIMESTAMP], $_GET[self::PARAM_NONCE]];
        sort($arr);
        $str = implode('',$arr);
        $str = sha1($str);
        if ($_GET[self::PARAM_SIGNATURE] == $str) exit($_GET[self::PARAM_ECHOSTR]);
    }
} 