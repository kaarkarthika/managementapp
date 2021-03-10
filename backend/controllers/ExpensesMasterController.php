<?php

namespace backend\controllers;

use Yii;
use backend\models\ExpensesMaster;
use backend\models\ExpensesMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ExpensesMasterController implements the CRUD actions for ExpensesMaster model.
 */
class ExpensesMasterController extends Controller
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
        ];
    }

    /**
     * Lists all ExpensesMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpensesMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExpensesMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExpensesMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExpensesMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->expenses_name = strtoupper($_POST['ExpensesMaster']['expenses_name']);
            $model->comments = $_POST['ExpensesMaster']['comments'];
            $model->activeStatus = $_POST['ExpensesMaster']['activeStatus'];
            $model->created_at  = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if(!$model->save()){
            echo "<prE>";print_r($model->getErrors());die;
            }
             return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExpensesMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->expenses_name = strtoupper($_POST['ExpensesMaster']['expenses_name']) ;
            $model->comments = $_POST['ExpensesMaster']['comments'];
            $model->activeStatus = $_POST['ExpensesMaster']['activeStatus'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if(!$model->save()){
                echo "<prE>";print_r($model->getErrors());die;
            }
            return $this->redirect(['index']);
       }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExpensesMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ExpensesMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpensesMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExpensesMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
