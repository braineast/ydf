<?php
/**
 * ChinaPNR response Controller.
 * Author: xiaohubb@hotmail.com
 * Date: 6/25/2014
 * Time: 2:56 PM
 */

namespace frontend\controllers;


use frontend\models\api\ChinaPNR;
use yii\web\Controller;

class CnpnrController extends Controller {

    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        die("Hello");
    }
    public function actionReturn($backend = false)
    {
        $backend = $backend ? true : $backend;
        if (isset($_POST) && $_POST)
        {
            $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
            $cnpnr->setResponse($_POST);
            if ($response = $cnpnr->getResponse())
            {
                switch($response[ChinaPNR::PARAM_CMDID])
                {
                    case ChinaPNR::CMD_DEPOSIT:
                        //处理充值订单
                        file_put_contents('/tmp/deposit_log', json_encode($response), FILE_APPEND);
                        break;
                }
                if ($backend) exit('Hello Kitty!');
            }
        }
    }
}