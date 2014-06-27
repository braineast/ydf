<?php
/**
 * Account Controller.
 * Author: xiaohubb@hotmail.com
 * Date: 6/22/2014
 * Time: 10:22 PM
 */

namespace frontend\controllers;


use frontend\models\Account;
use frontend\models\api\ChinaPNR;
use frontend\models\Order;
use frontend\models\OrderPayment;
use frontend\models\ydf\User as YDFUser;
use yii\web\Controller;

class AccountController extends Controller
{
    public $layout = 'ydf';
    public function actionIndex()
    {
        if ($order = Order::create(151,0.01,Order::TYPE_ACCOUNT_DEPOSIT))
        {
            $orderPayment = OrderPayment::create($order, 100.00);
            if ($orderPayment)
            {
                $ydfUser = YDFUser::find()->select(['id', 'user_name', 'is_hf_open'])->where('id=:id', [':id'=>$orderPayment->userId])->one();
                if ($orderPayment->paymentId == OrderPayment::PAYMENT_CNPNR)
                {
                    $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
                    $cnpnr->deposit($ydfUser->getAttribute('is_hf_open'));
                    $cnpnr->transAmt = $orderPayment->amount;
                    $cnpnr->ordId = $orderPayment->serial;
                    $cnpnr->ordDate = date('Ymd', $orderPayment->paymentAt);
                    $cnpnr->merPriv = json_encode([$ydfUser->getAttribute('id'),$ydfUser->getAttribute('user_name'),$ydfUser->getAttribute('is_hf_open')]);
//                    exit($cnpnr->getLink());
                    header('Location: ' . $cnpnr->getLink());
                }
            }
        }
    }

    public function actionUnFreeze()
    {
        $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
        $cnpnr->cmdId = ChinaPNR::CMD_UNFREEZE;
        $cnpnr->ordId = '';
        $cnpnr->ordDate = '';
        $cnpnr->trxId = '';
        exit($cnpnr->getLink());
    }

    public function actionDeposit()
    {
        if (isset($_POST) && $_POST)
        {
            $ajax = isset($_POST['ajax']) && $_POST['ajax'] ? true : false;
            $amount = isset($_POST['amount']) && $_POST['amount'] > 0 ? $_POST['amount'] : null;
            if ($amount)
            {
                if ($order = Order::create(151,0.01,Order::TYPE_ACCOUNT_DEPOSIT))
                {
                    $orderPayment = OrderPayment::create($order, 100.00);
                    if ($orderPayment)
                    {
                        $ydfUser = YDFUser::find()->select(['id', 'user_name', 'is_hf_open'])->where('id=:id', [':id'=>$orderPayment->userId])->one();
                        if ($orderPayment->paymentId == OrderPayment::PAYMENT_CNPNR)
                        {
                            $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
                            $cnpnr->deposit($ydfUser->getAttribute('is_hf_open'));
                            $cnpnr->transAmt = $orderPayment->amount;
                            $cnpnr->ordId = $orderPayment->serial;
                            $cnpnr->ordDate = date('Ymd', $orderPayment->paymentAt);
                            $cnpnr->merPriv = json_encode([$ydfUser->getAttribute('id'),$ydfUser->getAttribute('user_name'),$ydfUser->getAttribute('is_hf_open')]);
                            $redirectUrl = $cnpnr->getLink();
                            if ($ajax) exit($redirectUrl);
                            exit("<a href=\"".$redirectUrl."\">现在支付</a>");
                        }
                    }
                }
            }
        }
        return $this->render('deposit');
    }

    public function actionVsign()
    {
        $data = [
            'UsrCustId'=>'6000060001868215',
            'BgRetUrl'=>'http://www.yidaifa.com/return.php',
            'TransAmt'=>'0.01',
            'FeeCustId'=>'6000060001283917',
            'GateBankId'=>'CMB',
            'MerPriv'=>base64_encode('{name: "李晓", baby: "小虎"}'),
            'RetUrl'=>'http://www.yidaifa.com/return.php',
            'TrxId'=>'201406240000571011',
            'FeeAcctId'=>'MDT000001',
            'RespCode'=>'000',
            'GateBusiId'=>'B2C',
            'FeeAmt'=>'0.00',
            'CashierSysId'=>'0000571011',
            'RespDesc'=>urlencode('成功'),
            'OrdDate'=>'20140623',
            'ChkValue'=>'6767DE527DF32FA3097662A909D2073EC17C8CDACFEBDA0AA42968F64FCC6BD19715C6F48D2D631018D8246262264C6857FDD09363B7AB9FA6C65FC0FE1F2C1AE1C4C1CF56E5BB0F0097DE6B22B161441BAADFB4951A634AC9262AA59AAAB09FA9677981071CE87296D12C4A2C5D41D96CB8F05C08E228F1984899323D22BD41',
            'MerCustId'=>'6000060001283917',
            'OrdId'=>'20140623225956725096',
            'Version'=>10,
            'CmdId'=>'NetSave',
            'CashierAcctDate'=>'20140624'
        ];
        $cnpnr = new ChinaPNR();
        var_dump($cnpnr->setResponse($data));
        var_dump($cnpnr->getResponse());
    }

    public function actionTest()
    {
        var_dump(\Yii::$app->request->hostInfo);
    }

} 