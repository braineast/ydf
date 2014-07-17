<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/17/2014
 * Time: 6:49 PM
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Deal;


class ProductController extends Controller
{

    public $layout = 'ydf';

    public function actionTest()
    {
        $ret = Deal::getAll();
        var_dump($ret);
    }

    public function actionIndex()
    {
        return $this->actionList();
    }

    public function actionList()
    {
        return $this->render('list', ['deals'=>Deal::getAll(), 'summary'=>\frontend\models\ydf\Deal::getSummary()]);
    }

    public function actionView($id = null)
    {
        if ($id)
        {
            $deal = Deal::loadById(intval($id));
            if ($deal)
                return $this->render('view', ['deal'=>$deal]);
        }
        return $this->redirect(Yii::$app->urlManager->createUrl('product'), 302);
    }

    public function actionDeals()
    {
        return $this->render('deals');
    }

}