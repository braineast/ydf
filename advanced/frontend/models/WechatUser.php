<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 7/7/2014
 * Time: 12:07 PM
 */

namespace frontend\models;


use yii\db\ActiveRecord;

/**
 * Class WechatUser
 * @package frontend\models
 * @property integer $id
 * @property string $openId
 * @property string $nickName
 * @property string $imgUrl
 * @property string $accessKey
 */
class WechatUser extends ActiveRecord
{
    public static function tableName()
    {
        return 'wechat_user';
    }
}