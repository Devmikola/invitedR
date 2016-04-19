<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<h1>Созать новый инвайт</h1>
<?php $form = ActiveForm::begin([
    'id' => 'sign-up-form',
    'options' => ['class' => 'form-horizontal create-invite'],
    'enableAjaxValidation' => true,
]) ?>
<?= $form->field($model, 'id')->textInput(['maxlength' => 6]) ?>


<div class="form-group">
    <div class="col-lg-12 invite-send-button">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>
</div>

<?php ActiveForm::end(); ?>

