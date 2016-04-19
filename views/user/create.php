<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Country;

$form = ActiveForm::begin([
    'id' => 'sign-up-form',
    'options' => ['class' => 'form-horizontal', 'style' => 'background-color: #eeeeee; padding-left: 34px;'],
    'enableAjaxValidation' => true,
]) ?>

<h1 style="padding-top: 10px;">Регистрация</h1>

<?= $form->field($model, 'login') ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<?= $form->field($model, 'password_confirmation')->passwordInput() ?>
<?= $form->field($model, 'phone') ?>
<?php echo $form->field($model, 'country')->dropdownList(
    Country::find()->select(['name', 'id'])->indexBy('id')->column(),
    ['prompt' => 'Выберете страну',
     'onchange'=>'
            $.post( "'.Yii::$app->urlManager->createUrl('/user/cities/').'/"+$(this).val(), function( data ) {
              $( "select#signupform-city" ).html( "<option>Выберете город</option>" + data["cities_list"] );
            });'
    ]
);?>

<?php echo $form->field($model, 'city')->dropdownList(
    [],
    ['prompt' => 'Выберете город']
);?>

<?= $form->field($model, 'invite_id') ?>


    <div class="form-group">
        <div class="col-lg-12" style="padding-left: 0px; margin-bottom: 20px;">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Очистить', ['class' => 'btn btn-primary', 'style' => 'margin-left: 60px;']) ?>
        </div>


    </div>
<?php ActiveForm::end() ?>
