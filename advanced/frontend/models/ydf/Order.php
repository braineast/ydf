<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/25/2014
 * Time: 4:31 PM
 */

namespace frontend\models\ydf;


use yii\db\ActiveRecord;

class Order extends ActiveRecord {

    const TYPE_ACCOUNT_DEPOSIT = 1;

    const STATUS_PAYMENT_UNPAID = 0;
    const STATUS_PAYMENT_PAID = 2;

    const STATUS_ORDER_CREATED = 0;
    const STATUS_ORDER_COMPLETED = 1;

    public static function tableName()
    {
        return 'fanwe_deal_order';
    }

    public static function getDb()
    {
        return \Yii::$app->get('ydf_db');
    }

    public function init()
    {
        $this->setAttribute('pay_amount', 0.0000);
        $this->setAttribute('order_status', self::STATUS_ORDER_CREATED);
        $this->setAttribute('pay_status', self::STATUS_PAYMENT_UNPAID);
        $this->setAttribute('return_total_score', 0);
        $this->setAttribute('refund_amount', 0.0000);
        $this->setAttribute('discount_price', 0.0000);
        $this->setAttribute('delivery_fee', 0.0000);
        $this->setAttribute('ecv_money', 0.0000);
        $this->setAttribute('account_money', 0.0000);
        $this->setAttribute('delivery_id', 0);
        $this->setAttribute('payment_fee', 0.0000);
        $this->setAttribute('return_total_money', 0.0000);
        $this->setAttribute('extra_status', 0);
        $this->setAttribute('after_sale', 0);
        $this->setAttribute('refund_money', 0);
        $this->setAttribute('bank_id', '');
        $this->setAttribute('deal_ids', '');
        $this->setAttribute('user_name', '');
        $this->setAttribute('refund_status', 0);
        $this->setAttribute('retake_status', 0);
        $this->setAttribute('is_delete', 0);
        $this->setAttribute('delivery_status', 5);
        $this->setAttribute('payment_id', 4);
        $this->setAttribute('admin_memo', '');
        $this->setAttribute('memo', '');
        $this->setAttribute('region_lv1', 0);
        $this->setAttribute('region_lv2', 0);
        $this->setAttribute('region_lv3', 0);
        $this->setAttribute('region_lv4', 0);
        $this->setAttribute('address', '');
        $this->setAttribute('mobile', '');
        $this->setAttribute('zip', '');
        $this->setAttribute('consignee', '');
        $this->setAttribute('referer', '');
        $this->setAttribute('create_time', time());
        $this->setAttribute('update_time', $this->getAttribute('create_time'));
    }

} 