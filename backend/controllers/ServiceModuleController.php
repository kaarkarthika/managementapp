<?php

namespace backend\controllers;

use Yii;
use backend\models\ServiceModule;
use backend\models\ServiceModuleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 * ServiceModuleController implements the CRUD actions for ServiceModule model.
 */
class ServiceModuleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],

                // ...
            ],
        ],
        ];
    }

    /**
     * Lists all ServiceModule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServiceModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServiceModule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ServiceModule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
   public function actionCreate()
    {
        $model = new ServiceModule();
        $session = Yii::$app->session;
       if ($model->load(Yii::$app->request->post())) {
        //echo "<pre>";print_r($_POST);die;
        if ($formTokenValue = Yii::$app->request->post('ServiceModule')['hidden_Input']) 
          {   
              $sessionTokenValue =  $session['hidden_token'];
               
        if ($formTokenValue == $sessionTokenValue ) 
         {
         $service_id =Yii::$app->request->post('ServiceModule')['service_id'];
         $description =Yii::$app->request->post('ServiceModule')['description'];
         $service_type =Yii::$app->request->post('ServiceModule')['service_type'];
         $model->description=$description;
         $model->service_id=$service_id;
         $model->service_type=$service_type;
         if($model->save()){
         Yii::$app->session->remove('hidden_token');
         return $this->redirect(['index']); 
         }else{
         echo "<pre>";print_r($model->getErrors());die;
         }
        }else
        {
        return $this->redirect(['index']); 
        }
        }
         
        }else {
            $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return $this->render('create', [
                'model' => $model,
                'token_name' => $formTokenName,
            ]);
        }
    }

    /**
     * Updates an existing ServiceModule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
         $service_id =Yii::$app->request->post('ServiceModule')['service_id'];
         $description =Yii::$app->request->post('ServiceModule')['description'];
         $service_type =Yii::$app->request->post('ServiceModule')['service_type'];
         $model->description=$description;
         $model->service_id=$service_id;
         $model->service_type=$service_type;
         if($model->save()){
         Yii::$app->session->remove('hidden_token');
         return $this->redirect(['index']); 
         }else{
         echo "<pre>";print_r($model->getErrors());die;
         }
        
        } else {
             $formTokenName = uniqid();
            $session['hidden_token']=$formTokenName;
            return $this->render('update', [
                'model' => $model,
                'token_name' => $formTokenName,
            ]);
        }
    }

    /**
     * Deletes an existing ServiceModule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServiceModule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServiceModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServiceModule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
