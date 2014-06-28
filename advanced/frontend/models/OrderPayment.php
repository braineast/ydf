<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/25/2014
 * Time: 3:49 PM
 */

namespace frontend\models;


use frontend\models\ydf\PaymentNotice;
use yii\base\Exception;
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
        $this->paymentId = self::PAYMENT_CNPNR;
        $this->status = self::STATUS_UNPAID;
        $this->paymentCount = 0;
        $this->paymentAt = time();
        $this->serial = $this->_createSerial();
    }

    public function createAAA()
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

    public static function create(Order $order, $amount, $paymentMethod = self::PAYMENT_CNPNR)
    {
        $payment = new OrderPayment();
        $payment->orderId = $order->id;
        $payment->userId = $order->userId;
        $payment->amount = $amount > $order->amount ? $order->amount : $amount;
        $payment->paymentId = $paymentMethod;
        $payment->save();
        if ($payment->id) return $payment;
        return null;
    }

    public function save()
    {
        $payment = new PaymentNotice();
        if ($this->id) $payment = PaymentNotice::find()->where('id=:id', [':id'=>$this->id])->one();
        if ($this->status == self::STATUS_PAID)
        {
            if ($payment->getAttribute('is_paid') == PaymentNotice::STATUS_UNPAID)
            {
                $payment->setAttribute('is_paid', PaymentNotice::STATUS_PAID);
                $payment->setAttribute('pay_time', time());
            }
        }
        else $payment->setAttribute('pay_time', 0);
        $payment->setAttribute('user_id', $this->userId);
        $payment->setAttribute('order_id', $this->orderId);
        $payment->setAttribute('notice_sn', $this->serial);
        $payment->setAttribute('money', $this->amount);
        $payment->setAttribute('payment_id', $this->paymentId);
        if ($payment->save()) $this->_convert($payment);
        return $this;
    }

    public function _convert($ydfPaymentNotice)
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

    public function load()
    {
        $ydfPaymentNotice = PaymentNotice::find()->where('user_id=:userId and notice_sn=:id', [':userId'=>$this->userId,':id'=>$this->serial])->one();
        if ($ydfPaymentNotice)
            return $this->_convert($ydfPaymentNotice);
        return false;
    }

    public static function loadBySerial($serial)
    {
        try {
            $ydfPaymentNotice = PaymentNotice::find()->where('notice_sn=:payment_order_sn', [':payment_order_sn'=>$serial])->one();
            if ($ydfPaymentNotice)
            {
                $orderPayment = new OrderPayment();
                $orderPayment->_convert($ydfPaymentNotice);
                return $orderPayment;
            }
        }
        catch (Exception $e) {
            $e->getTrace();
        }
        return false;
    }

    public function paid()
    {
        $ydfPaymentNotice = PaymentNotice::find()->where('id=:id', [':id'=>$this->id])->one();
        if ($ydfPaymentNotice)
        {
            $ydfPaymentNotice->setAttribute('is_paid', PaymentNotice::STATUS_PAID);
            $ydfPaymentNotice->setAttributes('pay_time', time());
            $ydfPaymentNotice->save();
            $this->_convert($ydfPaymentNotice);
        }

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