<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/22/2014
 * Time: 9:59 PM
 */

namespace frontend\models\ydf;


use yii\db\ActiveRecord;

class User extends ActiveRecord{

    public static function tableName()
    {
        return 'fanwe_user';
    }

    public static function getDb()
    {
        return \Yii::$app->get('ydf_db');
    }

    public function beforeSave()
    {
    }
} 