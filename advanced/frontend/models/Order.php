<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/22/2014
 * Time: 7:57 PM
 */

namespace frontend\models;

use frontend\models\ydf\User;
use yii;
use yii\base\Model;
use frontend\models\ydf\Order as YdfOrder;


class Order extends Model {

    const TYPE_ACCOUNT_DEPOSIT = 1;
    const TYPE_ACCOUNT_WITHDRAW = 2;
    const TYPE_DEAL_BIDDING = 3;
    const TYPE_REPAYMENT = 4;
    const TYPE_REFUND = 5;

    const STATUS_UNPAID = 0;
    const STATUS_PAID = 1;

    public $id;
    public $userId;
    public $serial;
    public $type;
    public $amount;
    public $paid_amount;
    public $status;
    public $updatedAt;
    public $createdAt;

    public function init()
    {
        $this->serial = $this->_createSerial();
        $this->status = self::STATUS_UNPAID;
        $this->paid_amount = 0.0000;
        $this->createdAt = time();
        $this->updatedAt = $this->createdAt;
    }

    public static function create($userId, $amount, $orderType)
    {
        $order = new Order();
        $order->userId = $userId;
        $order->amount = $amount;
        $order->type = $orderType;
        $order->save();
        return $order;
    }

    public function save()
    {
        $isNewRecord = $this->id ? false : true;
        $needUpdateTime = false;
        $order = new YdfOrder();
        if (!$isNewRecord)
            $order = YdfOrder::find()->where('id=:id', [':id'=>$this->id])->one();
        $order->setAttribute('user_id', $this->userId);
        $order->setAttribute('type', $this->type);
        $order->setAttribute('order_sn', $this->serial);
        $order->setAttribute('deal_total_price', $this->amount);
        $order->setAttribute('total_price', $order->getAttribute('deal_total_price'));
        $order->setAttribute('pay_amount', $this->paid_amount);
        $this->status = $this->paid_amount == $this->amount ? self::STATUS_PAID : self::STATUS_UNPAID;
        if ($this->status == self::STATUS_PAID)
        {
            if ($order->getAttribute('pay_status') == YdfOrder::STATUS_PAYMENT_UNPAID)
            {
                $order->setAttribute('pay_status', YdfOrder::STATUS_PAYMENT_PAID);
                $order->setAttribute('pay_amount', $this->paid_amount);
                $needUpdateTime = true;
            }
            if ($order->getAttribute('order_status') == YdfOrder::STATUS_ORDER_CREATED)
            {
                $order->setAttribute('order_status', YdfOrder::STATUS_ORDER_COMPLETED);
                $needUpdateTime = true;
            }
        }
        if ($needUpdateTime) $order->setAttribute('update_time', time());
        if ($order->save()) return $this->_convert($order);
        return null;
    }

    public function _convert($ydfOrder)
    {
        $data = $ydfOrder;
        if ($ydfOrder instanceof ydf\Order)
            $data = $ydfOrder->attributes;
        if (is_array($data))
        {
            $this->id = $data['id'];
            $this->userId = $data['user_id'];
            $this->serial = $data['order_sn'];
            $this->type = $data['type'];
            $this->amount = $data['total_price'];
            $this->paid_amount = $data['pay_amount'];
            $this->status = $data['order_status'];
            $this->updatedAt = $data['update_time'];
            $this->createdAt = $data['create_time'];
        }
        return $this;
    }

    public static function loadById($id)
    {
        $ydfOrder = YdfOrder::find()->where('id=:id', [':id'=>$id])->one();
        if ($ydfOrder)
        {
            $order = new Order();
            $order->_convert($ydfOrder);
            return $order;
        }
        return false;
    }

    public function load()
    {
        $ydfOrder = $this->loadYdfOrder();
        if ($ydfOrder) $this->_convert($ydfOrder);
        return $this;
    }

    public function paid()
    {
        $ydfOrder = $this->loadYdfOrder();
        if ($this->status != self::STATUS_PAID)
        {
            $ydfOrder->setAttribute('pay_amount', $this->paid_amount);
            $ydfOrder->setAttribute('update_time', time());
            if ($this->paid_amount == $this->amount)
            {
                $this->status = self::STATUS_PAID;
                $ydfOrder->setAttribute('pay_status', YdfOrder::STATUS_PAYMENT_PAID);
                $ydfOrder->setAttribute('order_status', YdfOrder::STATUS_ORDER_COMPLETED);
            }
            if ($ydfOrder->save())
            {
                $this->_convert($ydfOrder);
                if ($this->status == self::STATUS_PAID)
                {
                    switch($this->type){
                        case self::TYPE_ACCOUNT_DEPOSIT:
                            $user = User::find()->where('id=:id', [':id'=>$this->userId])->one();
                            if ($user)
                            {
                                $user->setAttribute('money', $user->getAttribute('money') + $this->amount);
                                $user->save();
                            }
                            break;
                    }
                }
            }
        }
        return $this;
    }

    private function loadYdfOrder()
    {
        return YdfOrder::find()->where('id=:id and user_id=:userId and type=:typeId', [':id'=>$this->id,':userId'=>$this->userId,':typeId'=>$this->type])->one();
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