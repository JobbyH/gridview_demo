<?php

/** @var yii\web\View $this */

use \yii\grid\GridView;
use app\models\Supplier;

$this->title = 'GridView Demo';

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter'=>true,
    'showHeader' => true,
    'columns' => [
        [
            'class' => yii\grid\CheckboxColumn::class,
            'headerOptions' => ['width' => '100'],
            'footer' => '<a class="btn btn-primary btn-sm" onclick=delall("'.Yii::$app->urlManager->createUrl(['grid/export']).'")>导出</a>'
        ],

        [
            'attribute' => 'id',
            'filter' => Supplier::ID_DROPDOWNLIST_MAP,
            'filterInputOptions' => ['prompt' => 'all id', 'class' => 'form-control', 'id' => null],
            'headerOptions' => ['width' => '140'],
//            'enableSorting' => false
        ],

        [
            'attribute' => 'name',
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
        ],

        [
            'label' => '编码',
            'attribute' => 'code',
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
        ],
        [
            'label' => '状态',
            'attribute' => 't_status',
            'filter' => ['ok' => 'ok', 'hold' => 'hold'],
            'filterInputOptions' => ['prompt' => 'all t_status', 'class' => 'form-control', 'id' => null],
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
        ],
        ['class' => 'yii\grid\ActionColumn', 'header' => '操作'],
    ],
]);


    ?>
