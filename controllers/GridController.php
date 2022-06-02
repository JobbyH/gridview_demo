<?php
namespace app\controllers;


use yii\web\Controller;

class GridController extends Controller
{
    public function actionList()
    {
        return $this->render('login', [
            'model' => $model,
        ]);
    }
}
