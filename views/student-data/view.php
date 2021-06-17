<?php

use app\components\useraction\UserAction;
use app\modules\comment\widgets\CommentsWidget;
/* @var $this yii\web\View */
/* @var $model app\models\StudentData */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = (string)$model;
?>

<div class="wrapper">
	<div class=" card ">

		<div
			class="student-data-view card-body">
		



		</div>
	</div>

	<div class=" card ">
		<div class=" card-body ">
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
			'value' => $model->user_id,
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


		<?php				echo UserAction::widget ( [
						'model' => $model,
						'attribute' => 'state_id',
						'states' => $model->getStateOptions ()
				] );
				?>

		</div>
</div>
 


	<div class=" card ">
				<div class=" card-body ">
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

	<div class=" card ">
		<div class=" card-body ">

<?= CommentsWidget::widget(['model'=>$model]); ?>
			</div>
	</div>
</div>
