<?php
namespace app\controllers;

use app\models\Supplier;
use yii\web\Controller;

class GridController extends Controller
{
    public function actionList()
    {
        $suppliers = Supplier::find()->where(['t_status'=>'ok'])->all();

        return $this->render('list', [
            'models' => $suppliers
        ]);
    }
}
