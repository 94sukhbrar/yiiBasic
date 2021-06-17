<?php

namespace app\controllers;

use Yii;
use app\models\StudentData;
use app\models\search\StudentData as StudentDataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\User;
use yii\web\HttpException;
use yii\bootstrap\ActiveForm;
/**
 * StudentDataController implements the CRUD actions for StudentData model.
 */
class StudentDataController extends Controller
{


    /**
     * Lists all StudentData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StudentDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
 		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentData model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
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
        $status = StudentData::massDelete();
        if ($status == true) {
            $response['status'] = 'OK';
        }
        return $response;
    }
    
    /**
     * Creates a new StudentData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(/* $id*/)
    {
        $model = new StudentData();
        $model->loadDefaultValues();
        $model->state_id = StudentData::STATE_ACTIVE;
        
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
     * Updates an existing StudentData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

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
     * Clone an existing StudentData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClone($id)
    {
        $old = $this->findModel($id);
        
        $model = new StudentData();
        $model->loadDefaultValues();
        $model->state_id = StudentData::STATE_ACTIVE;
        
        		 	 $model->subject  = $old->subject;
		//$model->user_id  = $old->user_id		 	 $model->user_id  = $old->user_id;
		//$model->state_id  = $old->state_id		 	 $model->state_id  = $old->state_id;
		//$model->created_on  = $old->created_on		 	 $model->created_on  = $old->created_on;
				 	 $model->updated_on  = $old->updated_on;
				
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
     * Deletes an existing StudentData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

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
     * Truncate an existing StudentData model.
     * If truncate is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionClear($truncate = true)
    {
        $query = StudentData::find();
        foreach ($query->each() as $model) {
            $model->delete();
        }
        if ($truncate) {
            StudentData::truncate();
        }
        \Yii::$app->session->setFlash('success', 'StudentData Cleared !!!');
        return $this->redirect([
            'index'
        ]);
    }

    /**
     * Finds the StudentData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $accessCheck = true)
    {
        if (($model = StudentData::findOne($id)) !== null) {

			if ($accessCheck && ! ($model->isAllowed ()))
				throw new HttpException ( 403, Yii::t ( 'app', 'You are not allowed to access this page.' ) );

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
 

 }
