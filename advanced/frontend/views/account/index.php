<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/30/2014
 * Time: 10:45 AM
 */
?>
<!--main_content start-->
<div class="main_content" style=" padding-bottom:250px;">
    <table class="listInforTitle" cellpadding="0" cellspacing="0" width="100%">
        <tr align="center">
            <td width="33%">时间 </td>
            <td width="34%">类型明细</td>
            <td width="33%" style="border-right:0;">交易金额</td>
        </tr>
    </table>
    <table class="listInfoOne" cellpadding="0" cellspacing="0" width="100%">
        <tr onclick="hide1();"id="topBtn1" style="display:none;">
            <td align="left" >2014  04</td>
            <td width="40"><img src="images/close.png"/></td>
        </tr>
        <tr onclick="show1();"id="bottomBtn1" >
            <td align="left" >2014  04</td>
            <td width="40"><img src="images/open.png"/></td>
        </tr>
    </table>
    <div class="in_list" style=" padding-top:0; border-bottom:0;" id="greenTable1">
        <table class="list_table list_tableOne" cellpadding="0" cellspacing="0" width="100%">
            <tr height="60">
                <td class="td" width="13%">22日 </td>
                <td class="td" width="13%" align="center">提现</td>
                <td class="td" width="13%" align="right">-100.00</td>
            </tr>
            <tr height="60">
                <td width="13%">15日 </td>
                <td width="13%" align="center">回收本息</td>
                <td width="13%" align="right">+11.68</td>
            </tr>
        </table>
    </div>
    <table class="listInfoOne" cellpadding="0" cellspacing="0" width="100%">
        <tr onclick="hide2();"id="topBtn2" style="display:none;">
            <td align="left" >2014  03</td>
            <td width="40"><img src="images/close.png"/></td>
        </tr>
        <tr onclick="show2();"id="bottomBtn2" >
            <td align="left" >2014  03</td>
            <td width="40"><img src="images/open.png"/></td>
        </tr>
    </table>
    <div class="in_list" style=" padding-top:0"  id="greenTable2" >
        <table class="list_table list_tableOne" cellpadding="0" cellspacing="0" width="100%">
            <tr class="tr" height="60">
                <td class="td" width="13%">22日 </td>
                <td class="td" width="13%" align="center">提现</td>
                <td class="td" width="13%" align="right">-100.00</td>
            </tr>
            <tr height="60">
                <td width="13%">15日 </td>
                <td width="13%" align="center">回收本息</td>
                <td width="13%" align="right">+11.68</td>
            </tr>
        </table>
    </div>
    <table class="listInfoOne" cellpadding="0" cellspacing="0" width="100%">
        <tr onclick="hide3();"id="topBtn3" style="display:none;">
            <td align="left" >2014  02</td>
            <td width="40"><img src="images/close.png"/></td>
        </tr>
        <tr onclick="show3();"id="bottomBtn3" >
            <td align="left" >2014  02</td>
            <td width="40"><img src="images/open.png"/></td>
        </tr>
    </table>
    <div class="in_list" style=" padding-top:0"  id="greenTable3" >
        <table class="list_table list_tableOne" cellpadding="0" cellspacing="0" width="100%">
            <tr class="tr" height="60">
                <td class="td" width="13%">22日 </td>
                <td class="td" width="13%" align="center">投资</td>
                <td class="td" width="13%" align="right">-100.00</td>
            </tr>
            <tr height="60">
                <td width="13%">15日 </td>
                <td width="13%" align="center">充值</td>
                <td width="13%" align="right">+11.68</td>
            </tr>
        </table>
    </div>
    <table class="listInfoOne" cellpadding="0" cellspacing="0" width="100%">
        <tr onclick="hide4();"id="topBtn4" style="display:none;">
            <td align="left" >2014  01</td>
            <td width="40"><img src="images/close.png"/></td>
        </tr>
        <tr onclick="show4();"id="bottomBtn4" >
            <td align="left" >2014  01</td>
            <td width="40"><img src="images/open.png"/></td>
        </tr>
    </table>
    <div class="in_list" style=" padding-top:0"  id="greenTable4" >
        <table class="list_table list_tableOne" cellpadding="0" cellspacing="0" width="100%">
            <tr class="tr" height="60">
                <td class="td" width="13%">22日 </td>
                <td class="td" width="13%" align="center">提现</td>
                <td class="td" width="13%" align="right">-100.00</td>
            </tr>
            <tr height="60">
                <td width="13%">15日 </td>
                <td width="13%" align="center">回收本息</td>
                <td width="13%" align="right">+11.68</td>
            </tr>
        </table>
    </div>
    <table class="listInfoOne" cellpadding="0" cellspacing="0" width="100%" style=" border-bottom:1px solid #e6e6e6">
        <tr onclick="hide5();"id="topBtn5" style="display:none;">
            <td align="left" >2013  12</td>
            <td width="40"><img src="images/close.png"/></td>
        </tr>
        <tr onclick="show5();"id="bottomBtn5"  >
            <td align="left" >2013  12</td>
            <td width="40"><img src="images/open.png"/></td>
        </tr>
    </table>
    <div class="in_list" style=" padding-top:0"  id="greenTable5" >
        <table class="list_table list_tableOne" cellpadding="0" cellspacing="0" width="100%">
            <tr class="tr" height="60">
                <td class="td" width="13%">22日 </td>
                <td class="td" width="13%" align="center">提现</td>
                <td class="td" width="13%" align="right">-100.00</td>
            </tr>
            <tr height="60">
                <td width="13%">15日 </td>
                <td width="13%" align="center">回收本息</td>
                <td width="13%" align="right">+11.68</td>
            </tr>
        </table>
    </div>
</div>
<div class="bottom_area">
    <table cellspacing="0" width="100%" class="bottom_areaInfoOne">
        <tr>
            <td width="33%" align="center">账户金额:￥<?= number_format($account->balance, 2, '.', ','); ?>元</td>
            <td width="34%" align="center" style="border-right:0"></td>
        </tr>
        <tr>
            <td width="33%" align="center">可用金额:￥<?= number_format($account->availableBalance, 2, '.', ','); ?>元</td>
            <td width="34%" align="center" style=" border-right:0">冻结金额:￥<?= number_format($account->freezeAmount, 2); ?>元</td>
        </tr>
        <tr>
            <td align="ceter" colspan="3" class="btnBlue"><p><img src="images/icon_money.png" /><a href="<?= Yii::$app->urlManager->createUrl('product'); ?>">去理财</a> </p></td>
        </tr>
    </table>
</div>

<!--main_content eng-->
