<?php
/**
 * Account Model.
 * Author: xiaohubb@hotmail.com
 * Date: 6/22/2014
 * Time: 9:49 PM
 */

namespace frontend\models;


use yii\base\Exception;
use yii\base\Model;

class Account extends Model{

    public $id;
    public $userId;
    public $serial;
    public $balance;
    public $availableBalance;
    public $freezeAmount;
    public $state;
    public $status;
    public $updatedAt;
    public $createdAt;

    public function deposit($amount)
    {
        if ($amount)
        {
            $order = new Order();
            $order->type = Order::TYPE_ACCOUNT_DEPOSIT;
            $order->amount = $amount;
        }
    }

    public static function loadByUserId($userId)
    {
        $ret = null;
        $ydfUser = ydf\User::find()->where('id=:userId', [':userId'=>$userId])->one();
        if ($ydfUser)
        {
            if ($_rowData = self::convert($ydfUser))
            {
                $ret = new Account();
                foreach ($_rowData as $attribute => $value)
                    $ret->$attribute = $value;
            }
        }

        return $ret;
    }

    public static function convert(ydf\User $ydfUser)
    {
        $ret = false;
        try
        {
            if ($ydfUser)
            {
                $ret['id'] = $ydfUser['id'];
                $ret['userId'] = $ydfUser['id'];
                $ret['serial'] = $ydfUser['id'];
                $ret['availableBalance'] = floatval($ydfUser['money']);
                $ret['freezeAmount'] = floatval($ydfUser['lock_money']);
                $ret['balance'] = floatval($ret['availableBalance'] + $ret['freezeAmount']);
                $ret['updatedAt'] = $ydfUser['update_time'];
                $ret['createdAt'] = $ydfUser['create_time'];
            }
        }
        catch(Exception $e) { $e->getTrace(); }

        return $ret;
    }

}