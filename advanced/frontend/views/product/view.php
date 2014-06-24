<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/18/2014
 * Time: 6:35 PM
 */
?>
<div class="main_content" style=" padding-bottom:88px;">
<div class="financingList">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" border-bottom:0">
        <tbody><tr>
            <td colspan="2"><span><?= $deal->name ?></span><img class="icon" src="images/home7_03.png"></td>
            <td></td>
        </tr>
        <tr>
            <td width="66%">年利率：<?=$deal['annualInterestRate']?$deal['annualInterestRate'].'%':null;?></td>
            <td width="34%" align="center"><?=$deal['amount']?number_format($deal['amount'], 2).'元':null;?></td>
        </tr>
        <tr>
            <td colspan="">期限：<?= $deal['period']; ?><?= $deal['periodType']=='m'?'个月':'天';?></td>
            <td width="34%" rowspan="3" align="center"><div style=" height:44px; width:240px; border:3px solid #ccc; background:none"><span style=" display:block; height:37px; margin:3px; line-height:100px; font-size:24px; color:#777; width:40px; background:#ff6630;padding:0"></span></div></td>
        </tr>
        <tr>
            <td colspan="">还款方式：<?= Yii::$app->params['loanType'][$deal['loanType']]; ?></td>
        </tr>
        <tr>
            <td colspan="">剩余时间：3天10时57分</td>
        </tr>
        </tbody></table>
    <table class="list_table" cellpadding="0" cellspacing="0" width="100%" style=" padding-bottom:0; padding-top:0;border-bottom:0">
        <tbody><tr>
            <td height="60" align="" colspan="3"><p class="t_30">剩余890000元可投</p></td>
        </tr>
        <tr>
            <td align="left"><input class="inputMoney" value="请输入投资金额" type="text" style=" height:60px; width:100%; border:0;"></td>
            <td align="right">元</td>
        </tr>
        <tr>
            <td align="right" colspan="3" style=" border-top: 1px solid #cccccc"><span style="padding-bottom:0;padding-top:2px; float:right;color:#777; font-size:24px;">我的余额：10378元</span></td>
        </tr>
        </tbody></table>
    <table class="recept_role" width="100%" style=" border-bottom:0; padding-top:16px;">
        <tbody><tr>
            <td colspan="2"><button class="btn_adapt_100" onclick="location.href=''">立即充值</button></td>
        </tr>
        </tbody></table>
</div>
<div class="list">
<table width="100%" border="0" class="tableOut" cellpadding="0" cellspacing="0">
    <tbody><tr onclick="hide1();" id="topBtn1" style="display:none;">
        <th width="50%" align="left">项目信息</th>
        <th width="50%" align="right"><img src="images/close.png"></th></tr>
    <tr onclick="show1();" id="bottomBtn1">
        <th width="50%" align="left">项目信息</th>
        <th align="right"><img src="images/open.png"></th>
    </tr>
    <tr>
        <td height="" colspan="2" style=" padding:0 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableIn" id="greenTable1" style="display:">
                <tbody><tr>
                    <td colspan="4">借款用途：短期周转</td>
                </tr>
                <tr>
                    <td colspan="4">详情介绍：<?=$deal['description']?></td>
                </tr>
                <tr>
                    <td width="29%">身份证</td>
                    <td width="22%"><img src="images/home6_03-02.png"></td>
                    <td width="31%">收入认证</td>
                    <td width="18%"><img src="images/home6_03-02.png"></td>
                </tr>
                <tr>
                    <td>工作认证</td>
                    <td><img src="images/home6_03-02.png"></td>
                    <td>居住地认证</td>
                    <td><img src="images/home6_03-02.png"></td>
                </tr>
                <tr>
                    <td>信用报告</td>
                    <td><img src="images/home6_03-02.png"></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableOut">
    <tbody><tr onclick="hide2();" id="topBtn2" style="display:none;">
        <th width="50%" align="left">借款人信息</th>
        <th width="50%" align="right"><img src="images/close.png"></th></tr>
    <tr onclick="show2();" id="bottomBtn2">
        <th width="50%" align="left">借款人信息</th>
        <th align="right"><img src="images/open.png"></th>
    </tr>
    <tr><td height="" colspan="2" style=" padding:0 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableIn" id="greenTable2" style="display:">
                <tbody><tr>
                    <th colspan="2" align="left">基本信息</th>
                </tr>
                <tr>
                    <td colspan="2"><?= $deal['borrowerInfo']; ?></td>
                </tr>
                <tr>
                    <th colspan="2" align="left">易贷发借款记录</th>
                </tr>
                <tr>
                    <td>发布借款笔数：10</td>
                    <td>成功借款笔数：3</td>
                </tr>
                <tr>
                    <td>还清笔数：1</td>
                    <td>逾期次数：0</td>
                </tr>
                <tr>
                    <td class="td4">严重逾期笔数：0</td>
                    <td class="td4">&nbsp;</td>
                </tr>
                <tr>
                    <td class="td5">共计借入：180,000,00</td>
                    <td class="td5">&nbsp;</td>
                </tr>
                <tr>
                    <td>待还本息：￥0,00</td>
                    <td>&nbsp;</td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
<table width="100%" border="0" class="tableOut" cellpadding="0" cellspacing="0">
    <tbody><tr onclick="hide3();" id="topBtn3" style="display:none;">
        <th width="50%" align="left">担保信息</th>
        <th width="50%" align="right"><img src="styles/images/close.png"></th></tr>
    <tr onclick="show3();" id="bottomBtn3">
        <th width="50%" align="left">担保信息</th>
        <th align="right"><img src="images/open.png"></th>
    </tr>
    <tr>
        <td height="" colspan="2" style=" padding:0 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableIn" id="greenTable3" style="display:">
                <tbody><tr>
                    <td colspan="4">安全投资，双重保障</td>
                </tr>
                <tr>
                    <td colspan="4"><?= $deal['guarantee']; ?></td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableOut">
    <tbody><tr onclick="hide4();" id="topBtn4" style="display:none;">
        <th width="50%" align="left">还款计划</th>
        <th width="50%" align="right"><img src="styles/images/close.png"></th></tr>
    <tr onclick="show4();" id="bottomBtn4">
        <th width="50%" align="left">还款计划</th>
        <th align="right"><img src="images/open.png"></th>
    </tr>
    <tr>
        <td height="" colspan="2" style=" padding:0 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableIn" id="greenTable4" style="display:">
                <tbody><tr>
                    <th align="left">预期还款时间</th>
                    <th align="">类型</th>
                    <th align="right">还款金额</th>
                </tr>
                <tr>
                    <td align="left">2014.05.20</td>
                    <td align="center">本息</td>
                    <td align="right">178090.00</td>
                </tr>
                <tr>
                    <td align="left">2014.05.20</td>
                    <td align="center">本息</td>
                    <td align="right">178090.00</td>
                </tr>
                <tr>
                    <td align="left">2014.05.20</td>
                    <td align="center">本息</td>
                    <td align="right">178090.00</td>
                </tr>
                <tr>
                    <td align="left">2014.05.20</td>
                    <td align="center">本息</td>
                    <td align="right">178090.00</td>
                </tr>
                <tr>
                    <td align="left" class="td4">2014.05.20</td>
                    <td align="center" class="td4">本息</td>
                    <td align="right" class="td4">178090.00</td>
                </tr>
                <tr>
                    <td align="right" colspan="3" class="td5" style="padding-top:6px; padding-bottom:9px;">总计：￥178090.00元</td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableOut">
    <tbody><tr onclick="hide5();" id="topBtn5" style="display:none;">
        <th width="50%" align="left">投标记录</th>
        <th width="50%" align="right"><img src="styles/images/close.png"></th></tr>
    <tr onclick="show5();" id="bottomBtn5">
        <th width="50%" align="left">投标记录</th>
        <th align="right"><img src="images/open.png"></th>
    </tr>
    <tr>
        <td height="" colspan="2" style=" padding:0 30px;"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableIn" id="greenTable5" style="display:">
                <tbody><tr>
                    <th width="50%" align="left">投标人</th>
                    <th width="50%" align="right">投标金额</th>
                </tr>
                <tr>
                    <td align="left">W***O</td>
                    <td align="right">100090.00</td>
                </tr>
                <tr>
                    <td align="left">W***O</td>
                    <td align="right">100090.00</td>
                </tr>
                <tr>
                    <td align="left">W***O</td>
                    <td align="right">100090.00</td>
                </tr>
                <tr>
                    <td align="left">W***O</td>
                    <td align="right">100090.00</td>
                </tr>
                <tr>
                    <td align="left">W***O</td>
                    <td align="right">100090.00</td>
                </tr>
                </tbody></table></td>
    </tr>
    </tbody></table>
</div>
</div>
<div class="bottom_area">
    <table cellspacing="0" width="100%" class="bottom_areaInfoOne">
        <tbody><tr>
            <td align="center" class="btnBlue" s=""><p>立刻投资</p></td>
        </tr>
        </tbody></table>
</div>