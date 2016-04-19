<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Добро пожаловать на сайт inventR !</p>
        <?= Html::img('colors.jpg')?>
        <br>
        <br>
        <p>Вы можете <?= Html::a('Войти', '/site/login')?> или <?= Html::a('Зарегистрироваться', '/user/create')?>. </p>
        </div>
</div>
