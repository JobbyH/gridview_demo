<?php
namespace app\controllers;

use app\models\Supplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class GridController extends Controller
{
    public function actionList()
    {
        //$suppliers = Supplier::find()->where(['t_status'=>'ok'])->all();

        $where = [];
        $render = [];

        $render['dataProvider'] = new ActiveDataProvider([
            'query' => Supplier::find()->where($where),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('list', $render);
    }
}
