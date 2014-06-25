<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/25/2014
 * Time: 4:03 PM
 */

namespace frontend\models\ydf;


use yii\db\ActiveRecord;

class PaymentNotice extends ActiveRecord
{
    const PAYMENT_CREDIT = 1;
    const PAYMENT_CNPNR = 4;

    const STATUS_UNPAID = 0;

    public function init()
    {
        $this->setAttribute('payment_id', self::PAYMENT_CREDIT);
        $this->setAttribute('is_paid', self::STATUS_UNPAID);
        $this->setAttribute('create_time', time());
        $this->setAttribute('memo', '');
        $this->setAttribute('outer_notice_sn', '');
    }

    public static function tableName()
    {
        return 'fanwe_payment_notice';
    }

    public static function getDb()
    {
        return \Yii::$app->get('ydf_db');
    }
} 