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
use frontend\models\api\Log;
use frontend\models\Order;
use frontend\models\OrderPayment;
use frontend\models\ydf\User as YDFUser;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountController extends Controller
{
    public $layout = 'ydf';

    public function actionIndex()
    {
        $account = Account::loadByUserId(\Yii::$app->user->getId());
        return $this->render('index', ['account'=>$account]);
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
            $amount = isset($_POST['amount']) && $_POST['amount'] > 0 ? $_POST['amount'] : null;
            if ($amount)
            {
                if ($order = Order::create(\Yii::$app->user->getId(),$amount,Order::TYPE_ACCOUNT_DEPOSIT))
                {
                    $orderPayment = OrderPayment::create($order, $amount);
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
                            $cnpnr->merPriv = json_encode(['id'=>$ydfUser->getAttribute('id'),'username'=>$ydfUser->getAttribute('user_name'),'cnpnr_acct'=>$ydfUser->getAttribute('is_hf_open')]);
                            $redirectUrl = $cnpnr->getLink();
                            if (\Yii::$app->request->isAjax) exit($redirectUrl);
                            exit("<a href=\"".$redirectUrl."\">现在支付</a>");
                        }
                    }
                }
            }
        }
        return $this->render('deposit');
    }

    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'only'=>['login', 'logout', 'index'],
                'rules'=> [
                    [
                        'allow'=>true,
                        'actions'=>['login'],
                        'roles'=>['?'],
                    ],
                    [
                        'allow'=>true,
                        'actions'=>['index'],
                        'roles'=>['@'],
                    ],
                ],
            ],
        ];
    }
}