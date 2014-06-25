<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/22/2014
 * Time: 7:57 PM
 */

namespace frontend\models;

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

    public function create($orderType)
    {
        $this->type = $orderType;
        $ydfOrder = new YdfOrder();
        $ydfOrder->setAttribute('type', $this->type);
        $ydfOrder->setAttribute('deal_total_price', number_format($this->amount, 4, '.', ''));
        $ydfOrder->setAttribute('total_price', $ydfOrder->getAttribute('deal_total_price'));
        $ydfOrder->setAttribute('order_sn', $this->serial);
        $ydfOrder->setAttribute('user_id', $this->userId);
        if ($ydfOrder->save()) return $this->_convert($ydfOrder);
        else return false;
    }

    private function _convert($ydfOrder)
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