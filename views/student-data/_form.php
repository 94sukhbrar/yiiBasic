<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\StudentData */
/* @var $form yii\widgets\ActiveForm */
?>
<header class="card-header">
                            <?= strtoupper(Yii::$app->controller->action->id); ?>
                        </header>
<div class="card-body">


    <?php 
$form = ActiveForm::begin([
	
						  'id'	=> 'student-data-form',
						  'options' => [
          				  'class' => 'row'
       								   ]
						]);
						
						
//echo $form->errorSummary($model);	
?>


<div class="row">


<div class="col-md-8 offset-md-2">

	
		 <?php echo $form->field($model, 'subject')->textInput(['maxlength' => 256]) ?>
	 		</div>


        <div class="col-md-6">
   
		 <?php echo $form->field($model, 'user_id')->dropDownList($model->getUserOptions(), ['prompt' => '']) ?>
	 		</div>


        <div class="col-md-6">
   
	<?php if(User::isAdmin()){?>	 <?php echo $form->field($model, 'state_id')->dropDownList($model->getStateOptions(), ['prompt' => '']) ?>
	 <?php }?>		</div>

</div>



				<div
					class="col-md-12 bottom-admin-button btn-space-bottom text-right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['id'=> 'student-data-form-submit','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>