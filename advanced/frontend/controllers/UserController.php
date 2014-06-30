<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/30/2014
 * Time: 12:02 AM
 */

namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;
use yii\web\Cookie;

class UserController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'ydf';
    public function actionLogin($wechat = false)
    {
        if ($_POST && isset($_POST['username']) && isset($_POST['password']))
        {
            $user = User::find()->where('user_name=:username or email=:username', [':username'=>$_POST['username']])->one();
            if ($user && \Yii::$app->user->login($user, 3600 * 24 * 30))
            {
                //登录成功
                if ($wechat)
                {
                    if (!$user->getAttribute('wechat_open_id'))
                    {
                        $user->setAttribute('wechat_open_id', $wechat);
                        $user->save();
                    }
                    $cookie = new Cookie(['name'=>'wechat_openid', 'value'=>$user->getAttribute('wechat_open_id'), 'expire'=>time()+3600*24*365]);
                    \Yii::$app->response->cookies->add($cookie);
                }
                $this->redirect(\Yii::$app->urlManager->createUrl('account'));
            }
            else
            {
                if (\Yii::$app->request->isAjax) exit('抱歉，登录失败，请输入正确的账号密码再次重试，谢谢！');
            }
        }
        return $this->render('login');
    }

    public function actionTest()
    {
        var_dump(\Yii::$app->request->cookies->get('wechat_openid'));
    }
}