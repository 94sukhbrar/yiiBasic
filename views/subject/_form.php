<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Subject */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    #subject-created_on {
    width: 100%;
}
</style>
<div class="subject-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'subject_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group field-subject-subject_name required">
        <label class="control-label" for="subject-subject_name">Created Date</label>

        <?= yii\jui\DatePicker::widget([
            'model' => $model,
            'attribute' => 'created_on',
            'dateFormat' => 'yyyy-MM-dd',
        ]); ?>
    </div>



  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>