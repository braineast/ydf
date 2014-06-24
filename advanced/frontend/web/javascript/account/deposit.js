/**
 * Author: xiaohubb@hotmail.com
 */

var format_error = -1;
var value_less_than_zero = -2;

var regexp_float = /^\d+(\.\d+)?$/;
var account_deposit_form_notice = '请输入充值金额';
$(document).ready(
    function ()
    {
        $('input.inputMoney').bind('click', function() {
            if ($(this).val() == account_deposit_form_notice) $(this).val(null);
        });

        $('input.inputMoney').bind('blur', function() {
            var val = $.trim($(this).val());
            if (val == '') $(this).val(account_deposit_form_notice);
            else
            {
                var isValid = chkFloat(val);
                if (isValid == format_error)
                {
                    alert('请输入整数金额或者带有小数点的格式，如100，或者100.99等正确的金额。');
                }
                if (isValid == value_less_than_zero)
                {
                    alert('请输入正确的充值金额。');
                }
            }
        });

        $('button.btn_adapt_100').click(
            function (event) {
                var isValid = chkFloat($('input.inputMoney').val());
                if (isValid == true)
                {
                    $.post(
                        '/index.php?r=account/deposit',
                        {ajax:'1', amount:'100'},
                        function(data)
                        {
                            alert(data);
                        }
                    );
                    event.preventDefault();
                }
                else
                {
                    if (isValid == format_error)
                    {
                        alert('请输入整数金额或者带有小数点的格式，如100，或者100.99等正确的金额。');
                    }
                    else if (isValid == value_less_than_zero)
                    {
                        alert('请输入正确的充值金额。');
                    }
                    return false;
                }
            }
        );
    }
);

function chkFloat(val)
{
    var result = format_error;
    var val = $.trim(val);
    if (regexp_float.test(val))
    {
        if (val <= 0) result = value_less_than_zero;
        else result = true;
    }
    return result;
}