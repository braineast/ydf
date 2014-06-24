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
use yii\web\Controller;

class AccountController extends Controller
{
    public $layout = 'ydf';
    public function actionIndex()
    {
        var_dump(Account::loadByUserId(68));
    }

    public function actionDeposit()
    {
        if (isset($_POST) && $_POST)
        {
            $ajax = isset($_POST['ajax']) && $_POST['ajax'] ? true : false;
            $amount = isset($_POST['amount']) && $_POST['amount'] > 0 ? $_POST['amount'] : null;
            if ($amount)
            {
                $order = new Order();
                $order->type = Order::TYPE_ACCOUNT_DEPOSIT;
                $order->amount = $amount;
                $cnpnr = new ChinaPNR();
                $cnpnr->deposit();
                $cnpnr->usrCustId = '6000060001868215';
                $cnpnr->transAmt = number_format($amount, 2, '.', '');
                $cnpnr->returl = 'http://www.yidaifa.com/return.php';
                $cnpnr->bgreturl = 'http://www.yidaifa.com/return.php';
                $cnpnr->ordId = $order->serial;
                $cnpnr->ordDate = substr($cnpnr->ordId, 0, 8);
                $cnpnr->merPriv = '{name: "李晓", baby: "小虎"}';
                $redirectUrl = $cnpnr->getLink();
                if ($ajax) exit($redirectUrl);
                exit("<a href=\"".$redirectUrl."\">现在支付</a>");
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

} 