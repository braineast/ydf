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
    public $amount;
    public $type;
    public $status;
    public $updatedAt;
    public $createdAt;

    public function init()
    {
        $this->serial = $this->_createSerial();
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