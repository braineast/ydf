<?php
/**
 * @var yii\web\View $this
 */
use frontend\models\Deal;
$annualInterestMin = null;
$annualInterestMax = null;
if (isset($summary) and $summary)
{
    $annualInterestMin = $summary['annual_interest_min'] == intval($summary['annual_interest_min']) ? intval($summary['annual_interest_min']) : $summary['annual_interest_min'];
    $annualInterestMax = $summary['annual_interest_max'] == intval($summary['annual_interest_max']) ? intval($summary['annual_interest_max']) : $summary['annual_interest_max'];
}
$this->title = '理财列表';
?>
<!--main_content start-->
<div class="main_content" style="">
    <Div class="financing" style="background:#f8f8f8">
        <table class="financingTitle" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <th align="left" width="33%"><?= $this->title; ?></th>
            </tr>
            <tr align="center">
                <td width="33%">
                    <span>
                        <?= $annualInterestMin.'%'; ?><?= $annualInterestMax==$annualInterestMin ? '' : ' - ' . $annualInterestMax.'%' ?>
                    </span>
                </td>
            </tr>
        </table>
    </Div>
    <div class="line"></div>
    <?php foreach($deals as $deal): ?>
        <div class="financingList" style="padding-bottom:8px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr align="center">
                    <td align="left" colspan="2">
                        <span><?= \yii\helpers\Html::a($deal['name'], Yii::$app->urlManager->createUrl('product/view&id='.$deal['id'])) ?></span>
                        <?php if ($deal['hasGuarantee']): ?><img class="icon" src="images/home7_03-03.png"><?php endif; ?>
                        <?php if ($deal['hasInsurance']): ?><img class="icon" src="images/home7_03.png"><?php endif; ?>
                    </td>
                    <td width="17%" rowspan="3">
                        <?php if ($deal['state'] == Deal::STATE_OPEN && $deal['status'] == Deal::STATUS_OPEN_BIDDING): ?><img src="images/home7_03-02.png" /><?php endif; ?>
                        <?php if ($deal['state'] == Deal::STATE_REPAYMENT && $deal['status'] == Deal::STATUS_REPAYMENT_PROGRESS): ?><div class="zt zt_1"><span class="span">还款中</span></div><?php endif; ?>
                        <?php if ($deal['state'] == Deal::STATE_COMPLETED && $deal['status'] == Deal::STATUS_COMPLETED): ?><div class="zt"><span class="span">已完成</span></div><?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td width="41%">年化利率：<?= $deal['annualInterestRate']; ?>%</td>
                    <td width="42%"><?= number_format($deal['amount'], 2, '.', ','); ?>元</td>
                </tr>
                <tr>
                    <td colspan="2">期限：<?= $deal['period'].($deal['periodType']=='d'?'天':($deal['periodType']=='m'?'个月':null)); ?></td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>
</div>


<!--main_content eng-->