<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/26/2014
 * Time: 2:19 PM
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class LoanRepaymentPlan extends ActiveRecord
{
    const STATE_PLANNING = 0;
    const STATE_REPAYING = 1;
    const STATE_COMPLETED = 2;
    const STATE_OVERDUE = -1;
    const STATE_GUARANTEED = -2;
    const STATUS_PROGRESS = 0;
    const STATUS_COMPLETED = 1;

    public static function getDb()
    {
        return \Yii::$app->get('ydf_db');
    }

    public static function tableName()
    {
        return 'loan_repayment_plan';
    }
}