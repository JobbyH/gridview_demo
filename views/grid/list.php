<?php

/** @var yii\web\View $this */

use yii\web\View;
use \yii\grid\GridView;

$this->title = 'GridView Demo';





    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'label' => '姓名',
                'value' => function ($model) {
                    return $model->name;
                }
            ],
            [
                'label' => '编码',
                'value' => function ($model) {
                    return $model->code;
                }
            ],
            [
                'label' => '状态',
                'value' => function ($model) {
                    return $model->t_status;
                }
            ],
        ],
    ]);



    ?>
