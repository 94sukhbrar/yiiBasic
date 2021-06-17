<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?=$generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView"?>;

/* @var $this yii\web\View */
<?=! empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : ''?>
/* @var $dataProvider yii\data\ActiveDataProvider */

<?php

if (! empty($generator->moduleID)) {
    ?>
$this->params['breadcrumbs'][] = ['label' => <?=$generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->moduleID))))?>, 'url' => ['/<?php

    echo $generator->moduleID;
    ?>']];
<?php
}
?>
$this->params['breadcrumbs'][] = ['label' => <?=$generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))))?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = <?=$generator->generateString('Index')?>;;
?>
<div class="wrapper">
	<div class="user-index">
		<div class=" card ">
			
				<div class="<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-index">

				<?= "<?= " ?>Html::a(<?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create'], ['class' => 'btn btn-success']) ?>


  </div>
			
		</div>
		<div class="card panel-margin">
			<div class="card-body">
				<div class="content-section clearfix">
					<header class="card-header head-border">   <?="<?= "?>strtoupper(Yii::$app->controller->action->id); ?> </header>
		<?="<?php "?>echo $this->render('_grid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]); ?>
</div>
			</div>
		</div>
	</div>

</div>

