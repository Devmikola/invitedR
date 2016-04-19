<?php
/* @var $this yii\web\View */
?>
<h1>Инвайты</h1>



<?php

use app\models\Invite;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>

<?= Html::a('Создать новый инвайт', ['create'], ['class' => 'btn btn-success']) ?>

<?php
$dataProvider = new ActiveDataProvider([
    'query' => Invite::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Код инвайта', 'attribute' => 'id'],
        ['label' => 'Статус', 'attribute' => 'status', 'value' => function($data){
            return $data->status ? "Уже используется {$data->user->login}" : 'Еще свободен';
        }],
        ['label' => 'Дата активации', 'attribute' => 'date_activation', 'value' => function($data){ return $data->date_activation ? $data->date_activation  : 'Еще не активирован'; }],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => 'Операции',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model) {
                    return $model->status ? '' : Html::a('<span class="glyphicon glyphicon-trash"></span>Delete', $url);
                },
            ],
        ],
    ]
]);
?>