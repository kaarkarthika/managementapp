<?php

namespace backend\controllers;

use Yii;
use backend\models\DesignationMaster;
use backend\models\DesignationMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DesignationMasterController implements the CRUD actions for DesignationMaster model.
 */
class DesignationMasterController extends Controller
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
     * Lists all DesignationMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DesignationMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DesignationMaster model.
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
     * Creates a new DesignationMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new DesignationMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->desigantionName = strtoupper($_POST['DesignationMaster']['desigantionName']);
            $model->comments = $_POST['DesignationMaster']['comments'];
            $model->activeStatus = $_POST['DesignationMaster']['activeStatus'];
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
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
     * Updates an existing DesignationMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->desigantionName = strtoupper($_POST['DesignationMaster']['desigantionName']) ;
            $model->comments = $_POST['DesignationMaster']['comments'];
            $model->activeStatus = $_POST['DesignationMaster']['activeStatus'];
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
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
     * Deletes an existing DesignationMaster model.
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
     * Finds the DesignationMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DesignationMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DesignationMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
