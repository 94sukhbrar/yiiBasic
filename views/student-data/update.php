<?php


/* @var $this yii\web\View */
/* @var $model app\models\StudentData */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="wrapper">
	<div class=" card ">
		<div
			class="student-data-update">

	</div>
	</div>


	<div class="content-section clearfix card">
		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>

