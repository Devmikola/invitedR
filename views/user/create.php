<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Country;

$form = ActiveForm::begin([
    'id' => 'sign-up-form',
    'options' => ['class' => 'form-horizontal user-create-form'],
    'enableAjaxValidation' => true,
]) ?>

<h1 class="title-registration">Регистрация</h1>

<?= $form->field($model, 'login',  ['template' => "{label}<br>{input}{error}"]) ?>
<?= $form->field($model, 'password',  ['template' => "{label}<br>{input}{error}"])->passwordInput() ?>
<?= $form->field($model, 'password_confirmation',  ['template' => "{label}<br>{input}{error}"])->passwordInput() ?>
<?= $form->field($model, 'phone',  ['template' => "{label}<br>{input}{error}"]) ?>
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

<?= $form->field($model, 'invite_id',  ['template' => "{label}<br>{input}{error}"])->textInput(['maxlength' => 6])  ?>
    <div class="form-group">
        <div class="col-lg-12 user-create-buttons">
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Очистить', ['class' => 'btn btn-primary button-margin-left']) ?>
        </div>

    </div>
<?php ActiveForm::end() ?>
