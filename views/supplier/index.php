<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\SupplierSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Suppliers';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
$(".exportdata").on("click", function () {
    var kstring = "";
    if ($(this).html()=="Export selected"){
        var keys = $("#grid").yiiGridView("getSelectedRows");
        kstring = keys.join(",");
        if(kstring==""){
            alert("请选择要下载的数据");
            return false;
        }
    }
    $(this).attr("href","field?ids="+kstring);
});
');


?>
<div class="supplier-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Supplier', ['create'], ['class' => 'btn btn-success']) ?>
        <a class="btn btn-success exportdata" href="/supplier/export" data-confirm="您确定要下载选中的数据吗?">Export selected</a>
        <a class="btn btn-success exportdata" href="/supplier/export" data-confirm="您确定要下载全部数据吗?">Exporturl All</a>
    </p>

<!--    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => ['id' => 'grid'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function($model) {
                    return ['value' => $model->id];
                },
            ],
                [
                'attribute' => 'id',
                 "filter" =>Html::activeDropDownList($searchModel,'id',$searchModel->dropDown('id'),['prompt' => '全部', "class" => "form-control "]),
                'headerOptions' => ['width' => '120']
            ],
            'name',
            'code',
            [
                'attribute' => 't_status',
                'value' => function($model) {
                    return $model->t_status == "ok" ? "ok" : "hold";
                },
                "filter" =>Html::activeDropDownList($searchModel,'t_status',$searchModel->dropDown('status'),['prompt' => '全部', "class" => "form-control "]),
                'headerOptions' => ['width' => '120']
            ],
            ['class' => 'yii\grid\ActionColumn',  'header' => '操作'],
        ],
    ]); ?>


</div>
