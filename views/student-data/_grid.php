<?php


use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

use yii\grid\GridView;
use yii\widgets\Pjax;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var app\models\search\StudentData $searchModel
 */

?>

<div class='table table-responsive'>


<?php Pjax::begin(['id'=>'student-data-pjax-grid']); ?>
    <?php echo GridView::widget([
    	'id' => 'student-data-grid',
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

            'id',
            'subject',
            [
				'attribute' => 'user_id',
				'format'=>'raw',
				'value' => function ($data) { return $data->user_id;  },
				],
            [
			'attribute' => 'state_id','format'=>'raw','filter'=>isset($searchModel)?$searchModel->getStateOptions():null,
			'value' => function ($data) { return $data->getStateBadge();  },],
            [
				'attribute' => 'created_on',
				'format'=>'raw',
                'filter' => \yii\jui\DatePicker::widget([
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true
                        ],
                        'model' => $searchModel,
                        'attribute' => 'created_on',
                        'options' => [
                            'id' => 'created_on',
                            'class' => 'form-control'
                        ]
                    ]),
				'value' => function ($data) { return date('Y-m-d H:i:s', strtotime('created_on'));  },
				],
            /* [
				'attribute' => 'updated_on',
				'format'=>'raw',
                'filter' => \yii\jui\DatePicker::widget([
                        'inline' => false,
                        'clientOptions' => [
                            'autoclose' => true
                        ],
                        'model' => $searchModel,
                        'attribute' => 'updated_on',
                        'options' => [
                            'id' => 'created_on',
                            'class' => 'form-control'
                        ]
                    ]),
				'value' => function ($data) { return date('Y-m-d H:i:s', strtotime('updated_on'));  },
				],*/

            ['class' => '\yii\grid\ActionColumn','header'=>'<a>Actions</a>'/*  'showModal' => \Yii::$app->params['useCrudModals'] = false */
],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>

