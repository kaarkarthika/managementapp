<?php

namespace backend\controllers;

use Yii;
use backend\models\Shortcut;
use backend\models\ShortcutSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ShortcutController implements the CRUD actions for Shortcut model.
 */
class ShortcutController extends Controller
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
     * Lists all Shortcut models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShortcutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shortcut model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Shortcut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shortcut();

        if (Yii::$app->request->post()) {
             $model->name=Yii::$app->request->post()['Shortcut']['name'];
            $model->link=Yii::$app->request->post()['Shortcut']['link'];
            $model->status=Yii::$app->request->post()['Shortcut']['status'];
             if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Saved successfully.');
               return $this->redirect(['index']); } 
            else {
               
               Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
           return $this->render('create', [
           'model' => $model,
            ]);
                }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Shortcut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->post()) {
            $model->name=Yii::$app->request->post()['Shortcut']['name'];
            $model->link=Yii::$app->request->post()['Shortcut']['link'];
            $model->status=Yii::$app->request->post()['Shortcut']['status'];
        if($model->save()) {
            Yii::$app->getSession()->setFlash('success', 'Updated successfully.');
               return $this->redirect(['index']); } 
        else{
            Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
           return $this->render('create', [
           'model' => $model,
            ]);
        }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Shortcut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Shortcut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Shortcut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shortcut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
