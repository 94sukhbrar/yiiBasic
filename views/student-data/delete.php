<?php



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\StudentData */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = (string)$model;
?>

<div class="wrapper">
	<div class=" panel ">
<div class="text-center">
		<h2>Are you sure you want to delete this item? All related data is deleted</h2></div>
		<div
			class="student-data-view panel-body">
		



		</div>
	</div>
	<div class=" panel ">
		<div class=" panel-body ">
    <?php echo \app\components\TDetailView::widget([
    	'id'	=> 'student-data-detail-view',
        'model' => $model,
        'options'=>['class'=>'table table-bordered'],
        'attributes' => [
            'id',
            'subject',
            [
			'attribute' => 'user_id',
			'format'=>'raw',
			'value' => user_id,
			],
            /*[
			'attribute' => 'state_id',
			'format'=>'raw',
			'value' => $model->getStateBadge(),],*/
            'created_on:datetime',
            'updated_on:datetime',
        ],
    ]) ?>


<?php  ?>



<?php 
$form = ActiveForm::begin([
					
						'id'	=> 'student-data-form',
						]);
						
						
echo $form->errorSummary($model);	
?>

	 <div class="form-group">
		<div
			class="col-md-6 col-md-offset-3 bottom-admin-button btn-space-bottom text-right">
			
        <?= Html::submitButton('Confirm', ['id'=> 'student-data-form-submit','class' =>'btn btn-success']) ?>
    </div>
	</div>

    <?php ActiveForm::end(); ?>

		</div>
</div>
 


	<div class=" panel ">
				<div class=" panel-body ">
					<div
						class="student-data-panel">

<?php
$this->context->startPanel();
	$this->context->addPanel('Feeds', 'feeds', 'Feed',$model /*,null,true*/);

$this->context->endPanel();
?>
				</div>
				</div>
			</div>

	<div class=" panel ">
		<div class=" panel-body ">

<?php echo CommentsWidget::widget(['model'=>$model]); ?>
			</div>
	</div>
</div>
