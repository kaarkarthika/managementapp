<?php

namespace backend\controllers;
error_reporting(E_ALL ^ E_NOTICE);
use Yii;
use backend\models\SwimServicecenterlogin;
use backend\models\SwimServicecenterloginSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * SwimServicecenterloginController implements the CRUD actions for SwimServicecenterlogin model.
 */
class SwimServicecenterloginController extends Controller
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
     * Lists all SwimServicecenterlogin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SwimServicecenterloginSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SwimServicecenterlogin model.
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
     * Creates a new SwimServicecenterlogin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SwimServicecenterlogin();

        if ($model->load(Yii::$app->request->post())) {

            //$model->created_at=date("Y-m-d h:i:s");
        $password=Yii::$app->request->post('SwimServicecenterlogin')['password_hash'];
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
            
            if($model->save())
            {
                Yii::$app->getSession()->setFlash('success','Service Center login created successfully');
            }
            else
            {
                Yii::$app->getSession()->setFlash('error','Username is already exist');
               
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SwimServicecenterlogin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SwimServicecenterlogin model.
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
     * Finds the SwimServicecenterlogin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SwimServicecenterlogin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SwimServicecenterlogin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
