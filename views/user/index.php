<?php
/* @var $this yii\web\View */
?>
<h1>Пользователи</h1>


<?php

use app\models\User;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

$dataProvider = new ActiveDataProvider([
    'query' => User::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        ['label' => 'Логин', 'attribute' => 'login'],
        ['label' => 'Телефон', 'attribute' => 'phone'],
        ['label' => 'Страна', 'attribute' => 'city.country.name', 'value' => function($data){return $data->city ? $data->city->country->name : 'Не указано';}],
        ['label' => 'Город', 'attribute' => 'city.name', 'value' => function($data){return $data->city ? $data->city->name : 'Не указано';}],
        ['label' => 'Инвайт', 'attribute' => 'invite_id'],
    ]
]);
?>