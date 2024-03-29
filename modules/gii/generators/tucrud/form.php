<?php

 
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $generator yii\gii\generators\crud\Generator */
echo $form->field ( $generator, 'modelClass' );
// echo $form->field($generator, 'searchModelClass');

echo $form->field ( $generator, 'controllerClass' );
echo $form->field ( $generator, 'baseControllerClass' );
echo $form->field ( $generator, 'moduleID' );
echo $form->field ( $generator, 'indexWidgetType' )->dropDownList ( [ 
		'grid' => 'GridView',
		'list' => 'ListView' 
] );
echo $form->field ( $generator, 'enableUserMode' )->checkbox ();
echo $form->field ( $generator, 'enableAdminMode' )->checkbox ();
echo $form->field ( $generator, 'enableI18N' )->checkbox ();
echo $form->field ( $generator, 'enablePjax' )->checkbox ();
echo $form->field ( $generator, 'messageCategory' );

?>
