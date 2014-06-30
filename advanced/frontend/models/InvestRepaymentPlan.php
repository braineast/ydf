<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/26/2014
 * Time: 3:00 PM
 */

namespace frontend\models;


class InvestRepaymentPlan extends LoanRepaymentPlan
{
    public static function tableName()
    {
        return 'invest_repayment_plan';
    }

}