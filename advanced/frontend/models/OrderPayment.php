<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/25/2014
 * Time: 3:49 PM
 */

namespace frontend\models;


use frontend\models\ydf\PaymentNotice;
use yii\base\Model;

class OrderPayment extends Model{
    const PAYMENT_CREDIT = 1;
    const PAYMENT_CNPNR = 4;
    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;
    const STATUS_PAYMENT_FAILED = -1;

    public $id;
    public $userId;
    public $orderId;
    public $serial;
    public $amount;
    public $paymentId;
    public $status;
    public $paymentCount;
    public $paymentAt;
    public $updatedAt;
    public $createdAt;

    public function init()
    {
        $this->paymentId = self::PAYMENT_CREDIT;
        $this->status = self::STATUS_UNPAID;
        $this->paymentCount = 0;
        $this->paymentAt = time();
        $this->serial = $this->_createSerial();
    }

    public function create()
    {
        $ydfPaymentNotice = new PaymentNotice();
        $ydfPaymentNotice->order_id = $this->orderId;
        $ydfPaymentNotice->user_id = $this->userId;
        $ydfPaymentNotice->notice_sn = $this->serial;
        $ydfPaymentNotice->payment_id = $this->paymentId;
        $ydfPaymentNotice->pay_time = $this->paymentAt;
        $ydfPaymentNotice->money = $this->amount;
        if ($ydfPaymentNotice->save())
            return $this->_convert($ydfPaymentNotice);
        return false;
    }

    private function _convert($ydfPaymentNotice)
    {
        $params = $ydfPaymentNotice;
        if ($ydfPaymentNotice instanceof ydf\PaymentNotice)
            $params = $ydfPaymentNotice->attributes;
        $this->id = $params['id'];
        $this->userId = $params['user_id'];
        $this->orderId = $params['order_id'];
        $this->serial = $params['notice_sn'];
        $this->amount = $params['money'];
        $this->paymentId = $params['payment_id'];
        $this->status = $params['is_paid'] ? self::STATUS_PAID : self::STATUS_UNPAID;
        $this->paymentAt = $params['pay_time'];
        $this->createdAt = $params['create_time'];
        $this->updatedAt = $this->paymentAt;
        return $this;
    }

    private function _createSerial()
    {
        $orderNumber = false;
        if (preg_match('/.*\.+?(\d+)?\s*(\d+)$/', microtime(), $microTimeArr))
        {
            $orderNumber = date('YmdHis', $microTimeArr[2]).substr($microTimeArr[1], 0, 6);
        }
        return $orderNumber;
    }
}