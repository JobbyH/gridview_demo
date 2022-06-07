<style>
    a.x_hidden {top: 0px;left: 0px;position: fixed;}
</style>
<?php
use \yii\grid\GridView;
use app\models\Supplier;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;

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
//            'enableSorting' => false,
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
//        ['class' => 'yii\grid\ActionColumn', 'header' => '操作'],
    ],
    'emptyText' => '暂时没有任何生活记录！',
//    'layout' => "{items}\n{summary}\n{pager}",
//    'pager' => [
//        //'options' => ['class' => 'hidden']
//        /* 默认不显示的按钮设置 */
//        'firstPageLabel' => '首页 ',
//        'prevPageLabel' => '上一页 ',
//        'nextPageLabel' => '下一页 ',
//        'lastPageLabel' => '尾页'
//    ]
]);


echo Html::a('', '#', [
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',
    'class' => 'btn btn-success x_hidden',
]);

Modal::begin([
    'id' => 'create-modal',
//    'header' => '<h4 class="modal-title">创建</h4>',
//    'bodyOptions' => [''],
    'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
//    'title' => 'xxuuee'
]);
Modal::end();

$requestUrl = Url::toRoute('create');
$js = <<<JS
    $(document).on('click', '#create', function () {
        var html = '<a>All items in this current page have been selected.</a>';
        html += '<a href="#">Select all items that match this search across current page.</a>';
       $('.modal-body').html(html);
       // $.get('{$requestUrl}', {},
       //     function (data) {
       //         $('.modal-body').html(data);
       //     }  
       // );
    });
JS;
$this->registerJs($js);

$js = <<<JS
$('input[name="selection[]"], input[name="selection_all"]').click(function() {
    var all_checked = true;
    setTimeout(function() {
        $('input[name="selection[]"').each(function() {
          // console.info(this, this.checked);
          if (!this.checked) {
              all_checked = false;
          }
        });
        if (all_checked) {
            $("#create").click();
        } 
    }, 500);
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
    ?>
