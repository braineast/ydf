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
use yii\web\Controller;

class CnpnrController extends Controller
{
    private $response;

    public function actionIndex($backend = false)
    {
        $backend = $backend ? true : $backend;
        if (isset($_POST) && $_POST)
        {
            $cnpnr = new ChinaPNR(\Yii::$app->request->hostInfo);
            $cnpnr->setResponse($_POST);
            if ($response = $cnpnr->getResponse())
            {
                $this->response = $response;
                $result = $this->_responser();
                if ($backend) exit('RECV_ORD_ID_'.$response[$response[ChinaPNR::PARAM_MERPRIV]['showId']]);
            }
        }
    }

    protected function NetSave()
    {
        if ($this->response[ChinaPNR::RESP_CODE] == '0000')
        {
            $userDataArr = $this->response[ChinaPNR::PARAM_MERPRIV];
            $orderId = $this->response[ChinaPNR::PARAM_ORDID];
            //获取支付单
            $paymentOrder = new OrderPayment();
            $paymentOrder->userId = $userDataArr['id'];
            $paymentOrder->serial = $orderId;
            $paymentOrder->load();
            if ($paymentOrder->status != OrderPayment::STATUS_PAID)
            {
                //判断支付金额是否一致
                if ($this->response[ChinaPNR::PARAM_TRANSAMT] == number_format($paymentOrder->amount, 2, '.', ''))
                {
                    $paymentOrder->paid();//处理支付单状态
                    if ($paymentOrder->status == OrderPayment::STATUS_PAID)
                    {
                        //处理订单
                        $order = new Order();
                        $order->id = $paymentOrder->orderId;
                        $order->userId = $paymentOrder->userId;
                        $order->type = Order::TYPE_ACCOUNT_DEPOSIT;
                        $order->load();
                        if ($order->status == Order::STATUS_UNPAID)
                        {
                            $order->paid_amount += $this->response[ChinaPNR::PARAM_TRANSAMT];
                            $order->paid();
                            if ($order->status == Order::STATUS_PAID) return true;
                        }
                    }
                }
            }
        }
        else {/*todo 记录日志 */}

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