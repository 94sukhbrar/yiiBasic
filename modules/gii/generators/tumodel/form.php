<?php


use yii\gii\generators\model\Generator;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\model\Generator */

echo $form->field ( $generator, 'moduleName' );
echo $form->field ( $generator, 'tableName' )->textInput ( [
		'table_prefix' => $generator->getTablePrefix ()
] );
echo $form->field ( $generator, 'modelClass' );
echo $form->field ( $generator, 'ns' );
echo $form->field ( $generator, 'baseClass' );
echo $form->field ( $generator, 'db' );
echo $form->field ( $generator, 'useTablePrefix' )->checkbox ();
echo $form->field ( $generator, 'generateRelations' )->dropDownList ( [
		Generator::RELATIONS_NONE => 'No relations',
		Generator::RELATIONS_ALL => 'All relations',
		Generator::RELATIONS_ALL_INVERSE => 'All relations with inverse'
] );
//echo $form->field ( $generator, 'generateRelationsFromCurrentSchema' )->checkbox ();
echo $form->field ( $generator, 'generateLabelsFromComments' )->checkbox ();
echo $form->field ( $generator, 'enableI18N' )->checkbox ();
echo $form->field ( $generator, 'generateQuery' )->checkbox ();
echo $form->field ( $generator, 'messageCategory' );
?>
