<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?=ltrim($generator->modelClass, '\\')?> */

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
$this->params['breadcrumbs'][] = <?=$generator->generateString('Add')?>;
?>

<div class="wrapper">
	<div class="card">

		<div
			class="<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-create">

</div>

	</div>

	<div class="content-section clearfix card">

		<?="<?= "?>$this->render ( '_form', [ 'model' => $model ] )?></div>
</div>


