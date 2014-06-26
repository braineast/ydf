<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/20/2014
 * Time: 4:10 PM
 */

namespace frontend\models;

use yii;
use yii\base\Model;

class Deal extends Model {
    const STATE_PREPARE = 0;
    const STATUS_PREPARE_DRAFT = 0;
    const STATUS_PREPARE_RULING = 1;
    const STATUS_PREPARE_COMPLETED = 2;
    const STATE_OPEN = 1;
    const STATUS_OPEN_BIDDING = 0;
    const STATUS_OPEN_COMPLETED = 1;
    const STATE_REPAYMENT = 2;
    const STATUS_REPAYMENT_PROGRESS = 0;
    const STATUS_REPAYMENT_COMPLETED = 1;
    const STATUS_REPAYMENT_OVERDUE = -1;
    const STATE_COMPLETED = 3;
    const STATUS_COMPLETED = 0;
    const STATUS_COMPLETED_FAILED = -1;
    const STATUS_COMPLETED_CANCELED = -2;

    const TYPE_LOAN_PERIOD_MONTH = 'm';
    const TYPE_LOAN_PERIOD_DAY = 'd';

    const TYPE_LOAN_AMORTIZED_ETP = 1; //Equal Total Payments (Amortized Loan)
    const TYPE_LOAN_AMORTIZED_HBFX = 2; //还本付息
    const TYPE_LOAN_UN_AMORTIZED = 3; //到期本息

    public $id;
    public $userId;
    public $name;
    public $amount;
    public $period;
    public $periodType;
    public $annualInterestRate;
    public $serviceFeeRate;
    public $managementFeeRate;
    public $hasGuarantee;
    public $hasInsurance;
    public $loanType;
    public $borrowerId;

    public $state;
    public $status;

    public $isDeleted;

    //temp
    public $borrowerInfo;
    public $description;
    public $guarantee;

    public function init()
    {
        $this->periodType = 'm';
        $this->annualInterestRate = 0.00;
        $this->serviceFeeRate = 0.00;
        $this->managementFeeRate = 0.00;
        $this->hasGuarantee = false;
        $this->hasInsurance = false;
    }

    public function makePlans()
    {
        $ret = false;
        try
        {
            //满标时间
        }
        catch(yii\base\Exception $e) {
            $e->getTrace();
        }
        return $ret;
    }

    public static function getOne($condition = null)
    {
        $deal = null;
        if ($condition)
        {
            if (is_array($condition))
            {
            }
            else
            {
                if (is_int($condition))
                {
                    $ydfDeal = ydf\Deal::find()->where('id=:id', [':id'=>$condition])->one();
                    if ($ydfDeal)
                    {
                        $_rowData = self::convert($ydfDeal);
                        if ($_rowData)
                        {
                            $deal = new Deal();
                            foreach($_rowData as $att => $val)
                            {
                                $deal->$att = $val;
                            }
                        }
                    }
                }
                else
                {
                }
            }
        }
        else
        {
            //get top row without any condition
        }
        return $deal;
    }

    public static function getAll()
    {
        $ret = false;
        $list = ydf\Deal::find()->where('is_effect=1 and is_delete=0 and sort>0')->orderBy('sort DESC, deal_status ASC, id DESC, update_time DESC')->all();
        if ($list)
        {
            foreach($list as $_row)
            {
                $_rowData = self::convert($_row);
                if ($_rowData)
                {
                    $deal = new Deal();
                    foreach ($_rowData as $att => $val)
                        $deal->$att = $val;
                }
                $ret[] = $deal;
            }
        }

        return $ret;
    }

    public static function convert(ydf\Deal $YDFDeal)
    {
        $ret = [];
        if ($YDFDeal and $YDFDeal instanceof ydf\Deal)
        {
            $ret['id'] = $YDFDeal['id'];
            $ret['borrowerId'] = $YDFDeal['user_id'];
            $ret['name'] = $YDFDeal['name'];
            $ret['amount'] = floatval($YDFDeal['borrow_amount']);
            $ret['period'] = $YDFDeal['repay_time'];
            $ret['periodType'] = $YDFDeal['repay_time_type'] ? self::TYPE_LOAN_PERIOD_MONTH : self::TYPE_LOAN_PERIOD_DAY;
            $ret['annualInterestRate'] = floatval($YDFDeal['rate']);
            $ydfDealStatus = intval($YDFDeal['deal_status']);
            if ($ydfDealStatus)
            {
                if ($ydfDealStatus == 1)
                {
                    $ret['state'] = self::STATE_OPEN;
                    $ret['status'] = self::STATUS_OPEN_BIDDING;
                }
                elseif($ydfDealStatus == 3)
                {
                    $ret['state'] = self::STATE_COMPLETED;
                    $ret['status'] = self::STATUS_COMPLETED_FAILED;
                }
                elseif($ydfDealStatus == 4)
                {
                    $ret['state'] = self::STATE_REPAYMENT;
                    $ret['status'] = self::STATUS_REPAYMENT_PROGRESS;
                }
                elseif($ydfDealStatus == 5)
                {
                    $ret['state'] = self::STATE_COMPLETED;
                    $ret['status'] = self::STATUS_COMPLETED;
                }
            }
            else
            {
                $ret['state'] = self::STATE_PREPARE;
                $ret['status'] = self::STATUS_PREPARE_RULING;
            }
            $loanType = intval($YDFDeal['loantype']);
            if ($loanType == 0)
                $ret['loanType'] = self::TYPE_LOAN_AMORTIZED_ETP;
            elseif($loanType == 1)
                $ret['loanType'] = self::TYPE_LOAN_AMORTIZED_HBFX;
            elseif($loanType == 2)
                $ret['loanType'] = self::TYPE_LOAN_UN_AMORTIZED;
            $ret['guarantee'] = $YDFDeal['anquan'];
            $ret['borrowerInfo'] = $YDFDeal['qiye'];
            $ret['description'] = $YDFDeal['description'];
        }
        return $ret;
    }
}