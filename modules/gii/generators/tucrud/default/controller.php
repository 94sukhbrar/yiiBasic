<?php

/**
 * This is the template for generating a CRUD controller class file.
 */
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?=StringHelper::dirname(ltrim($generator->controllerClass, '\\'))?>;

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
use <?=ltrim($generator->baseControllerClass, '\\')?>;
use yii\web\NotFoundHttpException;
use app\models\User;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
/**
 * <?=$controllerClass?> implements the CRUD actions for <?=$modelClass?> model.
 */
class <?=$controllerClass?> extends <?=StringHelper::basename($generator->baseControllerClass) . "\n"?>
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
        if(Yii::$app->request->isAjax) 
		{
    		return $this->renderAjax('view', [
                'model' => $model
            ]);
        }
        return $this->render('view', [
            'model' => $model
        ]);
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
    public function actionCreate(/* $id*/)
    {
        $model = new <?=$modelClass?>();
        $model->loadDefaultValues();
        $model->state_id = <?=$modelClass?>::STATE_ACTIVE;
        
       /* if (is_numeric($id)) {
            $post = Post::findOne($id);
            if ($post == null)
            {
              throw new NotFoundHttpException('The requested post does not exist.');
            }
            $model->id = $id;
                
        }*/
        
     
		$post = \yii::$app->request->post ();
		if (\yii::$app->request->isAjax && $model->load ( $post )) {
			\yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ActiveForm::validate ( $model );
		}
        if ($model->load($post) && $model->save()) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', "Record has been added Successfully."));        
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
            \Yii::$app->getSession()->setFlash('success', \Yii::t('app', "Record has been updated Successfully."));
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->updateMenuItems($model);
        if(Yii::$app->request->isAjax) 
		{
    		return $this->renderAjax('update', [
                'model' => $model
            ]);
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }
    
    /**
     * Clone an existing <?=$modelClass?> model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * <?=implode("\n     * ", $actionParamComments) . "\n"?>
     * @return mixed
     */
    public function actionClone(<?=$actionParams?>)
    {
        $old = $this->findModel(<?=$actionParams?>);
        
        $model = new <?=$modelClass?>();
        $model->loadDefaultValues();
        $model->state_id = <?=$modelClass?>::STATE_ACTIVE;
        
        <?php
        foreach ($generator->getColumnNames() as $name) {
            if ($name != "id") {
                if (preg_match('/^(user_id|password|created_on|state_id|created_by)/i', $name)) {
                    echo "//\$model->$name  = \$old->$name";
                }
                ?>
		 	 $model-><?=$name?>  = $old-><?=$name?>;
		<?php
            }
        }
        ?>
		
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
			\Yii::$app->getSession()->setFlash('success', \Yii::t('app', "Record has been deleted Successfully."));
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
