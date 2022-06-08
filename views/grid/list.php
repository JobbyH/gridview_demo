<?php
$a = '<a>All items in this current page have been selected.</a><br/><a class=\'s_all\' onclick=\'selectall()\'>Select all items that match this search</a>';
$b = '<a>All conversations in this search have been selected.</a><br/> <a class=\'c_all\' onclick=\'cancelall()\'>clear selection.</a>';
$c = '<div><label for=\'export_header_id\'>id</label><input disabled=\"disabled\" checked=\"checked\" type=\'checkbox\' id=\'export_header_id\' value=\'id\' class=\"export_header\"><br/><label for=\'export_header_name\'>name</label><input type=\'checkbox\' id=\'export_header_name\' value=\'name\' class=\"export_header\"><br/><label for=\'export_header_code\'>code</label><input type=\'checkbox\' id=\'export_header_code\' value=\'code\' class=\"export_header\"><br/><label for=\'export_header_t_status\'>t_status</label><input type=\'checkbox\' id=\'export_header_t_status\' value=\'t_status\' class=\"export_header\"><br/></div>';
?>
<style>
    a.x_hidden {top: 0;left: 0;position: fixed;}
    a.export_btn {display: none;}
    .modal-body label {margin: 0 15px 0 40px;}
</style>
<script>
    root_scope = {modal_body_flag: '', export_header_fields:{'id':true, 'name':true, 'code':true, 't_status':true}};
    function goto() {
        root_scope.modal_body_flag = 'prompt_export_header';
        var ids = [];
        $('input[name="selection[]"').each(function() {
            if (this.checked) {
                ids.push(this.value);
            }
        });

        if (ids.length <= 0) {
            alert("no items selected.");
            return false;
        }

        $("#create").click();
        $("#export_btn").css('display', 'block');
    }

    function selectall() {
        $("#export_all").attr('checked', true);
        $("div.modal-body").html("<?=$b ?>");
    }

    function cancelall() {
        $("#export_all").attr('checked', false);
        $("input[name='selection_all']").click();
        $("a.close_btn").click();
        $('.modal-body').html("<?=$a ?>");

    }
</script>
<?php
use \yii\grid\GridView;
use app\models\Supplier;
use yii\bootstrap4\Modal;
use yii\helpers\Html;

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
            'footer' => '<a class="btn btn-primary btn-sm" onclick=goto()>Export</a><br/><input type="checkbox" id="export_all" disabled="disabled">all selected</input>'
        ],

        [
            'attribute' => 'id',
            'filter' => Supplier::ID_DROPDOWNLIST_MAP,
            'filterInputOptions' => ['prompt' => 'all id', 'class' => 'form-control', 'id' => null, 'value' => $_GET['Supplier']['id']??''],
            'headerOptions' => ['width' => '140'],
//            'enableSorting' => false,
        ],

        [
            'attribute' => 'name',
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
            'filterInputOptions' => ['value' => $_GET['Supplier']['name']??'', 'class' => 'form-control']
        ],

        [
            'label' => '编码',
            'attribute' => 'code',
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
            'filterInputOptions' => ['value' => $_GET['Supplier']['code']??'', 'class' => 'form-control']
        ],
        [
            'label' => '状态',
            'attribute' => 't_status',
            'filter' => ['ok' => 'ok', 'hold' => 'hold'],
            'filterInputOptions' => ['prompt' => 'all t_status', 'class' => 'form-control', 'id' => null, 'value' => $_GET['Supplier']['t_status']??''],
            'enableSorting' => false,
            'headerOptions' => ['width' => '200'],
        ],
//        ['class' => 'yii\grid\ActionColumn', 'header' => '操作'],
    ],
    'emptyText' => 'No Result Searched!',
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
    'footer' => '<a href="#" class="btn btn-primary close_btn" data-dismiss="modal">Close</a><a id="export_btn" class="btn btn-primary export_btn">go to Export</a>',
//    'title' => 'xxuuee'
]);
Modal::end();

$js = <<<JS
    $(document).on('click', '#create', function () {
        if (root_scope.modal_body_flag == 'selectall') {
            $('.modal-body').html("$a");
        }
        if (root_scope.modal_body_flag == 'prompt_export_header') {
            $('.modal-body').html("$c");
            $('input.export_header').each(function() {
                var val = this.value;
              if (root_scope.export_header_fields[val] === true) {
                  $(this).attr('checked', true);
              } else {
                  $(this).attr('checked', false);
              }
            });
        } 
    });
    $(document).on('click', 'input.export_header', function () {
        var val = this.value;
        if (this.checked) {
            root_scope.export_header_fields[val] = true;
        } else {
            root_scope.export_header_fields[val] = false;
        }
    });
    $(document).on('click', '#export_btn', function () {
        var ids = [];
        $('input[name="selection[]"').each(function() {
            if (this.checked) {
                ids.push(this.value);
            }
        });
        if (ids.length <= 0) {
            alert("no items selected.");
            return false;
        }
        
        var fieldarr = ['id'];
        $("input.export_header").each(function() {
          if (this.value != 'id' && this.checked) {
              fieldarr.push(this.value);
          }
        });
        
        var export_all = $("#export_all").attr('checked') ? 1 : 0;
        var url = location.origin + location.pathname + '?r=grid/export&ids=' + ids.join(",")
            + '&id=' + $('select[name="Supplier[id]"]').find("option:selected").val()
            + '&name=' + $('#supplier-name').val()
            + '&code=' + $('#supplier-code').val()
            + '&t_status=' + $('select[name="Supplier[t_status]"]').find("option:selected").val()
            + '&all=' + export_all + '&fields=' + fieldarr.join(',');

        location.href = url;
    });

JS;
$this->registerJs($js);

$js = <<<JS
$('input[name="selection[]"], input[name="selection_all"]').click(function() {
    var all_checked = true;
    var all_canceled = true;
    setTimeout(function() {
        $('input[name="selection[]"').each(function() {
          if (!this.checked) {
              all_checked = false;
          }
          if (this.checked) {
              all_canceled = false;
          } 
        });
        if (all_checked) {
            root_scope.modal_body_flag = 'selectall';
            $("#create").click();
        }
        if (all_canceled) {
            $("#export_all").attr('checked', false);
        } 
    }, 500);
    $("#export_btn").css('display', 'none');
});
JS;
$this->registerJs($js, \yii\web\View::POS_END);
    ?>
