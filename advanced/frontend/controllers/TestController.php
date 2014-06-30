<?php
/**
 * Created by IntelliJ IDEA.
 * User: al
 * Date: 6/29/2014
 * Time: 12:46 PM
 */

namespace frontend\controllers;


use yii\web\Controller;

class TestController extends Controller{

    public function actionXml()
    {
        header('Content-Type: text/xml; charset=utf-8');
        $writer = new \XMLWriter();
        $writer->openMemory();
        $writer->startDocument('1.0', 'utf-8');
        $writer->startElement('FromUserName');
        $writer->writeCdata('FromUser Name');
        $writer->endElement();
        $writer->endDocument();

       echo  $writer->outputMemory(true);

    }

} 