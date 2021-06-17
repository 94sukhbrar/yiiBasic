<?php


use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams ();

echo "<?php\n";
?>



use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $model <?=ltrim ( $generator->modelClass, '\\' )?> */

<?php if(!empty($generator->moduleID)){?>
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->moduleID)))) ?>, 'url' => ['/<?php echo $generator->moduleID;?>']];
<?php }?>
$this->params['breadcrumbs'][] = ['label' => <?=$generator->generateString ( Inflector::pluralize ( Inflector::camel2words ( StringHelper::basename ( $generator->modelClass ) ) ) )?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = (string)$model;
?>

<div class="wrapper">
	<div class=" panel ">
<div class="text-center">
		<h2>Are you sure you want to delete this item? All related data is deleted</h2></div>
		<div
			class="<?=Inflector::camel2id ( StringHelper::basename ( $generator->modelClass ) )?>-view panel-body">
		



		</div>
	</div>
	<div class=" panel ">
		<div class=" panel-body ">
    <?="<?php echo "?>\app\components\TDetailView::widget([
    	'id'	=> '<?=Inflector::camel2id ( StringHelper::basename ( $generator->modelClass ) )?>-detail-view',
        'model' => $model,
        'options'=>['class'=>'table table-bordered'],
        'attributes' => [
<?php
$classname = $generator->modelClass;
$hasOneRelations = $classname::getHasOneRelations ();

if (($tableSchema = $generator->getTableSchema ()) === false) {
	foreach ( $generator->getColumnNames () as $name ) {

		if (isset ( $hasOneRelations [$name] ))
			$name = $hasOneRelations [$name] [0];
		if (preg_match ( '/^(description|content|password|activation_key)/i', $name ))

			echo "           /* '" . $name . "',*/\n";
		else
			echo "            '" . $name . "',\n";
	}
} else {

	foreach ( $tableSchema->columns as $column ) {
		if (isset ( $hasOneRelations [$column->name] )) {
			$column_out = "[" . "
			'attribute' => '$column->name',
			'format'=>'raw',
			'value' => $column->name,
			" . "]";
		} else {
			$column_out = $generator->generateDetailViewColumn ( $column );
		}
		if (preg_match ( '/^(title|state_id|description|content|password|activation_key)/i', $column->name ))
			echo "            /*" . $column_out . ",*/\n";
		else
			echo "            " . $column_out . ",\n";
	}
}
?>
        ],
    ]) ?>


<?php

echo "<?php  ";

foreach ( $tableSchema->columns as $column ) {
	$column_out = $generator->generateDetailViewColumn ( $column );
	if (preg_match ( '/^(description|content)/i', $column->name ))
		echo 'echo $model->' . $column->name . ';';
}
?>?>



<?="<?php "?>

$form = ActiveForm::begin([
					
						'id'	=> '<?=$generator->getControllerID ()?>-form',
						]);
						
						
echo $form->errorSummary($model);	
<?php

echo '?>';
?>


	 <div class="form-group">
		<div
			class="col-md-6 col-md-offset-3 bottom-admin-button btn-space-bottom text-right">
			
        <?="<?= "?>Html::submitButton('Confirm', ['id'=> '<?=$generator->getControllerID ()?>-form-submit','class' =>'btn btn-success']) ?>
    </div>
	</div>

    <?="<?php "?>ActiveForm::end(); ?>

		</div>
</div>
 <?php
	$classname = $generator->modelClass;

	if (count ( $classname::getHasManyRelations () ) != 0) {
		?>



	<div class=" panel ">
				<div class=" panel-body ">
					<div
						class="<?=Inflector::camel2id ( StringHelper::basename ( $generator->modelClass ) )?>-panel">

<?php

		echo "<?php\n";
		?>
$this->context->startPanel();
<?php

		foreach ( $classname::getHasManyRelations () as $field => $relationClass ) {
			?>
	$this->context->addPanel('<?=ucfirst ( $relationClass [0] )?>', '<?=$relationClass [0]?>', '<?=$relationClass [1]?>',$model /*,null,true*/);
<?php
		}
		?>

$this->context->endPanel();
?>
				</div>
				</div>
			</div>
<?php
	}
	?>

	<div class=" panel ">
		<div class=" panel-body ">

<?="<?php echo "?>CommentsWidget::widget(['model'=>$model]); ?>
			</div>
	</div>
</div>
