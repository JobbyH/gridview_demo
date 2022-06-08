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
            if ($search == 'g10') {
                $query = $query->andFilterWhere(['>', 'id', 10]);
            }
            if ($search == 'l10') {
                $query = $query->andFilterWhere(['<', 'id', 10]);
            }
            if ($search == 'gt10') {
                $query = $query->andFilterWhere(['>=', 'id', 10]);
            }
            if ($search == 'lt10') {
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

    public function actionExport() {

        $get = Yii::$app->request->get();
        if (empty($get)) {
            echo '';exit;
        }
        if (!isset($get['ids']) || empty($get['ids'])) {
            echo '';exit;
        }

        $idsArr = explode(',', $get['ids']);

        $csvFileName = 'Demo-Gridview-'.date('YmdHis').'.csv';
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=".$csvFileName);
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");

        if (isset($get['all']) && $get['all'] == 0) {
            $suppliers = Supplier::find()->where(['in', 'id', $idsArr])->asArray()->all();
        }
        if (isset($get['all']) && $get['all'] == 1) {
            $id = isset($get['id']) && !empty($get['id']) ? $get['id'] : false;
            $name = isset($get['name']) && !empty($get['name']) ? $get['name'] : false;
            $code = isset($get['code']) && !empty($get['code']) ? $get['code'] : false;
            $tStatus = isset($get['t_status']) && !empty($get['t_status']) ? $get['t_status'] : false;

            $query = Supplier::find();
            if ($id) {
                if ($id == 'g10') {
                    $query = $query->andFilterWhere(['>', 'id', 10]);
                }
                if ($id == 'l10') {
                    $query = $query->andFilterWhere(['<', 'id', 10]);
                }
                if ($id == 'gt10') {
                    $query = $query->andFilterWhere(['>=', 'id', 10]);
                }
                if ($id == 'lt10') {
                    $query = $query->andFilterWhere(['<=', 'id', 10]);
                }
            }
            if ($name) {
                $query = $query->andWhere(['like', 'name', $name]);
            }
            if ($code) {
                $query = $query->andWhere(['like', 'code', $code]);
            }
            if ($tStatus) {
                $query = $query->andWhere(['t_status' => $tStatus]);
            }

            $suppliers = $query->asArray()->all();
        }

        $fieldArr = explode(',', $get['fields']);

        $string = $get['fields']."\n";
        foreach ($suppliers as $supplier) {
            $string = $string . $supplier['id'];

            if (in_array('name', $fieldArr)) {
                $string .= ',' . $supplier['name'];
            }
            if (in_array('code', $fieldArr)) {
                $string .= ',' . $supplier['code'];
            }
            if (in_array('t_status', $fieldArr)) {
                $string .= ',' . $supplier['t_status'];
            }
            $string .= "\n";
        }

        $string = iconv("utf-8", 'gbk', $string);

        echo $string;

    }
}
