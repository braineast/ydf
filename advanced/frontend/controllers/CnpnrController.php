<?php
/**
 * ChinaPNR response Controller.
 * Author: xiaohubb@hotmail.com
 * Date: 6/25/2014
 * Time: 2:56 PM
 */

namespace frontend\controllers;


use frontend\models\api\ChinaPNR;
use frontend\models\Order;
use frontend\models\OrderPayment;
use frontend\models\ydf\PaymentNotice;
use yii\web\Controller;

class CnpnrController extends Controller
{
    public $enableCsrfValidation = false;
    private $response;

    public function actionIndex($backend = false)
    {
        header('Content-Type: text/html; charset=UTF-8');
        $backend = $backend ? true : $backend;
        if (isset($_POST) && $_POST)
        {
            $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
            $cnpnr->setResponse($_POST, $backend);
            if ($response = $cnpnr->getResponse())
            {
                $this->response = $response;
                $result = $this->_responser();
                if ($backend) exit('RECV_ORD_ID_'.$response[$response[ChinaPNR::PARAM_MERPRIV]['showId']]);
            }
        }
    }

    public function actionBackend()
    {
        return $this->actionIndex(true);
    }

    protected function NetSave()
    {
        if ($this->response[ChinaPNR::RESP_CODE] == '000')
        {
            $orderId = $this->response[ChinaPNR::PARAM_ORDID];
            $paymentOrder = OrderPayment::loadBySerial($orderId); //获取支付单
            if ($paymentOrder && $paymentOrder->status != OrderPayment::STATUS_PAID)
            {
                $paymentOrder->status = OrderPayment::STATUS_PAID;
                $paymentOrder->save();
                if ($paymentOrder->status == OrderPayment::STATUS_PAID)
                {
                    $order = Order::loadById($paymentOrder->orderId); //获取支付单对应的订单，并进行处理
                    if ($order && $order->status == Order::STATUS_UNPAID)
                    {
                        $order->paid_amount += $this->response[ChinaPNR::PARAM_TRANSAMT];
                        $order->save();
                        if ($order->status == Order::STATUS_PAID) return true;
                    }
                }
            }
            $this->redirect('account');
        }
        return false;
    }

    private function _responser()
    {
        $method = $this->response[ChinaPNR::PARAM_CMDID];
        if (method_exists($this, $method))
            return $this->$method();
        elseif (method_exists($this, strtolower($method)))
        {
            $method = strtolower($method);
            return $this->$method();
        }
        return $this;
    }

}