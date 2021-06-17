<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'full_name') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'password') ?>
        <?= $form->field($model, 'role_id') ?>
        <?= $form->field($model, 'state_id') ?>
        <?= $form->field($model, 'created_on') ?>
        <?= $form->field($model, 'date_of_birth') ?>
        <?= $form->field($model, 'last_visit_time') ?>
        <?= $form->field($model, 'last_action_time') ?>
        <?= $form->field($model, 'last_password_change') ?>
        <?= $form->field($model, 'updated_on') ?>
        <?= $form->field($model, 'gender') ?>
        <?= $form->field($model, 'email_verified') ?>
        <?= $form->field($model, 'tos') ?>
        <?= $form->field($model, 'type_id') ?>
        <?= $form->field($model, 'login_error_count') ?>
        <?= $form->field($model, 'created_by_id') ?>
        <?= $form->field($model, 'about_me') ?>
        <?= $form->field($model, 'contact_no') ?>
        <?= $form->field($model, 'city') ?>
        <?= $form->field($model, 'country') ?>
        <?= $form->field($model, 'zipcode') ?>
        <?= $form->field($model, 'language') ?>
        <?= $form->field($model, 'profile_file') ?>
        <?= $form->field($model, 'timezone') ?>
        <?= $form->field($model, 'activation_key') ?>
        <?= $form->field($model, 'access_token') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'latitude') ?>
        <?= $form->field($model, 'longitude') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-form -->
