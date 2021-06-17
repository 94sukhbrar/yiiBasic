<?php


/**
 * This is the template for generating a CRUD controller class file.
 */
use app\models\User;
use yii\helpers\StringHelper;
use yii\db\ActiveRecordInterface;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/* @var $class ActiveRecordInterface */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?=StringHelper::dirname(ltrim($generator->adminControllerClass, '\\'))?>;

use Yii;
use <?=ltrim($generator->modelClass, '\\')?>;
<?php

if (! empty($generator->searchModelClass)) :
    ?>
use <?=ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "")?>;
<?php

else :
    ?>
use yii\data\ActiveDataProvider;
<?php

endif;
?>
use <?=ltrim($generator->baseControllerClass, '\\')?> as <?=$generator->adminbaseControllerClass?>;
use yii\web\NotFoundHttpException;
use app\models\User;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
/**
 * <?=$controllerClass?> implements the CRUD actions for <?=$modelClass?> model.
 */
class <?=$controllerClass?> extends <?=$generator->adminbaseControllerClass . "\n"?>
{


    /**
     * Lists all <?=$modelClass?> models.
     * @return mixed
     */
    public function actionIndex()
    {
<?php

if (! empty($generator->searchModelClass)) :
    ?>
        $searchModel = new <?=isset($searchModelAlias) ? $searchModelAlias : $searchModelClass?>();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
<?php

else :
    ?>
        $dataProvider = new ActiveDataProvider([
            'query' => <?=$modelClass?>::find(),
        ]);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
<?php

endif;
?>
    }

    /**
     * Displays a single <?=$modelClass?> model.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return mixed
     */
    public function actionView(<?=$actionParams?>)
    {
        $model = $this->findModel(<?=$actionParams?>);
        $this->updateMenuItems($model);
        return $this->render('view', ['model' => $model]);

    }
    
   /**
     * actionMass delete in mass as items are checked
     *
     * @param string $action
     * @return string
     */
    public function actionMass($action = 'delete')
    {
        \Yii::$app->response->format = 'json';
        $response['status'] = 'NOK';
        $status = <?=$modelClass?>::massDelete();
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }
    
    /**
     * Creates a new <?=$modelClass?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?=$modelClass?>();
        $model->loadDefaultValues();
        $model->state_id = <?=$modelClass?>::STATE_ACTIVE;
		$post = \yii::$app->request->post ();
		if (\yii::$app->request->isAjax && $model->load ( $post )) {
			\yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ActiveForm::validate ( $model );
		}
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        return $this->render('create', [
                'model' => $model,
            ]);

    }

    /**
     * Updates an existing <?=$modelClass?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return mixed
     */
    public function actionUpdate(<?=$actionParams?>)
    {
        $model = $this->findModel(<?=$actionParams?>);

 		$post = \yii::$app->request->post ();
		if (\yii::$app->request->isAjax && $model->load ( $post )) {
			\yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ActiveForm::validate ( $model );
		}
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->updateMenuItems($model);
        return $this->render('update', [
                'model' => $model,
            ]);

    }

     /**
     * Deletes an existing <?=$modelClass?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return mixed
     */
    public function actionDelete(<?=$actionParams?>)
    {
        $model = $this->findModel(<?=$actionParams?>);

		if(\yii::$app->request->post())
		{
			$model->delete();
        	return $this->redirect(['index']);
		}
		return $this->render('delete', [
                'model' => $model,
            ]);
    }
    /**
     * Truncate an existing <?=$modelClass?> model.
     * If truncate is successful, the browser will be redirected to the 'index' page.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return mixed
     */
    public function actionClear($truncate = true)
    {
        $query = <?=$modelClass?>::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            <?=$modelClass?>::truncate();
        }
        \Yii::$app->session->setFlash('success', '<?=$modelClass?> Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the <?=$modelClass?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return <?=$modelClass?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?=$actionParams?>, $accessCheck = true)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
}
?>
        if (($model = <?=$modelClass?>::findOne(<?=$condition?>)) !== null) {

			if ($accessCheck && ! ($model->isAllowed ()))
				throw new HttpException ( 403, Yii::t ( 'app', 'You are not allowed to access this page.' ) );

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
