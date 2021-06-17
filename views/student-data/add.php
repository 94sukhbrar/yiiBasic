<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StudentData */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Student Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Add');
?>

<div class="wrapper">
	<div class="card">

		<div
			class="student-data-create">

</div>

	</div>

	<div class="content-section clearfix card">

		<?= $this->render ( '_form', [ 'model' => $model ] )?></div>
</div>


