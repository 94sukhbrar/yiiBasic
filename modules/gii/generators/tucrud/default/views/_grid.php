<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
/**
 *
 * @var View $this
 * @var Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>


use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

use <?=$generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView"?>;
<?=$generator->enablePjax ? 'use yii\widgets\Pjax;' : ''?>

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var <?=ltrim($generator->searchModelClass, '\\')?> $searchModel
 */

?>
<?php
$class = Inflector::camel2id(StringHelper::basename($generator->modelClass));
$id = $class . "-grid";
$pjax = $class . "-pjax-grid";
?>

<div class='table table-responsive'>


<?=$generator->enablePjax ? "<?php Pjax::begin(['id'=>'" . $pjax . "']); ?>" : ''?>

<?php

if ($generator->indexWidgetType === 'grid') :
    ?>
    <?="<?php echo "?>GridView::widget([
    	'id' => '<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions'=>['class'=>'table table-bordered'],
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn','header'=>'<a>S.No.<a/>'],
           [ 
								'name' => 'check',
								'class' => 'yii\grid\CheckboxColumn',
								'visible' => User::isAdmin () 
						],

<?php
    $modelClass = $generator->modelClass;
    $hasOneRelations = $modelClass::getHasOneRelations();
    $count = 0;
    $fieldMatch = '/^(updated_on|update_time|actual_start|actual_end|password|passcode|activation_key)/i';
    if (($tableSchema = $generator->getTableSchema()) === false) {

        foreach ($generator->getColumnNames() as $name) {
            if (preg_match($fieldMatch, $name))
                echo "            // '" . $name . "',\n";

            elseif ($count < 8) {
                $count ++;
                echo "            '" . $name . "',\n";
            } else {
                echo "            // '" . $name . "',\n";
            }
        }
    } else {

        foreach ($tableSchema->columns as $column) {

            if (isset($hasOneRelations[$column->name])) {
                $column_out = "[" . "
				'attribute' => '$column->name',
				'format'=>'raw',
				'value' => function (\$data) { return \$data->$column->name;  },
				" . "]";
            } else if ($column->type == "datetime") {
                $column_out = "[" . "
				'attribute' => '$column->name',
				'format'=>'raw',
                'filter' => \yii\jui\DatePicker::widget([
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true
                        ],
                        'model' => " . '$searchModel' . ",
                        'attribute' => '$column->name',
                        'options' => [
                            'id' => 'created_on',
                            'class' => 'form-control'
                        ]
                    ]),
				'value' => function (\$data) { return date('Y-m-d H:i:s', strtotime('$column->name'));  },
				" . "]";
            } else {
                $column_out = $generator->generateGridViewColumn($column);
            }

            if (preg_match($fieldMatch, $column->name) || $column->type === 'text' || $column->allowNull)
                echo "            /* " . $column_out . ",*/\n";

            elseif ($count < 8) {
                $count ++;
                echo "            " . $column_out . ",\n";
            } else {
                echo "            /* " . $column_out . ",*/\n";
            }
        }
    }
    ?>

            ['class' => '\yii\grid\ActionColumn','header'=>'<a>Actions</a>'/*  'showModal' => \Yii::$app->params['useCrudModals'] = false */
],
        ],
    ]); ?>
<?php

else :
    ?>

    <?="<?= "?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?=$nameAttribute?>), ['view', <?=$urlParams?>]);
        },
    ]) ?>
<?php

endif;
?>
<?=$generator->enablePjax ? '<?php Pjax::end(); ?>' : ''?>

<?php

echo "</div>"?>


