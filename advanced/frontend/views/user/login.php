<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/30/2014
 * Time: 12:04 AM
 */
?>
<!--main_content start-->
<div class="main_content" style=" min-height:1048px;">
    <div class="register">
        <table cellpadding="0" cellspacing="0" class="borderBt"style=" margin-top:0">
            <tr>
                <td width="80" class="icon_user"></td>
                <td><input type="text" name="username" placeholder="用户名 / 邮箱" class="field_adapt_90"></td>
            </tr>
        </table>
        <table cellpadding="0" cellspacing="0" class="borderBt">
            <tr>
                <td width="80" class="user_lock"></td>
                <td><input type="password" name="password" placeholder="密码" class="field_adapt_90"></td>
            </tr>
        </table>
        <table class="recept_role">
            <tr>
                <td style=" padding-bottom:20px;"><button class="btn_adapt_100" name="bind">绑定</button></td>
            </tr>
            <!--tr>
                <td><button class="btn_adapt_100_grey">忘记密码</button></td>
            </tr-->
        </table>
    </div>
</div>
<!--main_content eng-->
<script type="text/javascript">
    var loginUrl = "<?= Yii::$app->request->url; ?>";
    $(document).ready(
        function()
        {
            $('button[name="bind"]').bind('click', function(event) {
                $.post(loginUrl,{username:$('input[name="username"]').val(), password:$('input[name="password"]').val()},
                function(data)
                {
                    alert(data);
                }
                );
                event.preventDefault();
            });
            $('input').bind('click', function() {
                $(this).removeAttr('placeholder');
            });
            $('input[name="username"]').bind('blur', function() {
                if ($.trim($(this).val()) == '') $(this).attr('placeholder', '用户名 / 邮箱');
            });
            $('input[name="password"]').bind('blur', function() {
                if ($.trim($(this).val()) == '') $(this).attr('placeholder','密码');
            })
        }
    );
</script>
