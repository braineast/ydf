<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/18/2014
 * Time: 2:51 PM
 */

namespace frontend\models\ydf;

use yii;
use yii\db\ActiveRecord;
use yii\db\Query;


class Deal extends ActiveRecord
{
    public static function tableName()
    {
        return 'fanwe_deal';
    }
    public static function getDb()
    {
        return Yii::$app->get('ydf_db');
    }

    public function getOne()
    {
        $deal = new Deal();
        $_row = $this->find()->where('id=38')->one();
        $deal->load($_row->getAttributes());
        $deal = self::convert($deal);
        return $deal;
    }

    public static function getDeals()
    {
        $ret = self::find()->where('is_effect=1 and is_delete=0 and sort>0')->orderBy('sort DESC, deal_status ASC, id DESC, update_time DESC')->all();
        if ($ret && is_array($ret))
        {
            foreach($ret as $k=>$v)
            {
                $_data = $v->getAttributes();
                $_data['annual_interest'] = $_data['rate'] == intval($_data['rate']) ? intval($_data['rate']) : $_data['rate'];
                $_data['hasGuarantee'] = 1;
                $_data['hasInsurance'] = 1;
                $_data['status'] = $_data['deal_status'];
                $_data['amount'] = $_data['borrow_amount'];
                $_data['period'] = $_data['repay_time'];
                $_data['period_type'] = $_data['repay_time_type'] ? 'm' : 'd';
                $ret[$k] = $_data;
            }
        }
        return $ret;
    }

    public static function getSummary()
    {
        $query = new Query();
        $query->select(['count(id) as count','max(rate) as annual_interest_max', 'min(rate) as annual_interest_min', 'max(borrow_amount) as max_amount', 'min(borrow_amount) as min_amount'])->from(self::tableName())->where('is_effect=1 and is_delete=0 and sort>0');
        try
        {
            $command = $query->createCommand(self::getDb());
        }
        catch(yii\base\Exception $e)
        {
            $e->getTrace();
        }
        return $command->queryOne(\PDO::FETCH_ASSOC);
    }

    public static function convert(Deal $deal)
    {
        $deal->setAttribute('annualInterestRate', $deal->getAttribute('rate'));
        return $deal;
    }

}