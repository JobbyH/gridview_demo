<?php
namespace app\controllers;

use Yii;
use app\models\Supplier;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class GridController extends Controller
{
    public function actionList()
    {

        $get = Yii::$app->request->get();
        $where = [];
        $render = [];

        if (!empty($get['Supplier']['t_status'])) {
            $where['t_status'] = $get['Supplier']['t_status'];
        }

        $query = Supplier::find()->where($where);
        if (!empty($get['Supplier']['name'])) {
            $query = $query->andFilterWhere(['like', 'name', $get['Supplier']['name']]);
        }
        if (!empty($get['Supplier']['code'])) {
            $query = $query->andFilterWhere(['like', 'code', $get['Supplier']['code']]);
        }
        if (!empty($get['Supplier']['id'])) {

            $search = $get['Supplier']['id'];
            if ($search == '>10') {
                $query = $query->andFilterWhere(['>', 'id', 10]);
            }
            if ($search == '<10') {
                $query = $query->andFilterWhere(['<', 'id', 10]);
            }
            if ($search == '>=10') {
                $query = $query->andFilterWhere(['>=', 'id', 10]);
            }
            if ($search == '<=10') {
                $query = $query->andFilterWhere(['<=', 'id', 10]);
            }
        }

        $render['dataProvider'] = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);

        $render['searchModel'] = new Supplier();

        return $this->render('list', $render);
    }
}
