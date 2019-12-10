<?php
namespace app\modules\account\controllers;

use yii\web\Controller;

class QuestionsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
