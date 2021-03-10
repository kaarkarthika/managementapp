<?php

namespace backend\controllers;

use Yii;
use backend\models\ExpensesManagement;
use backend\models\ReportsDownloader;
use backend\models\ExpensesManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ExpensesManagementController implements the CRUD actions for ExpensesManagement model.
 */
class ExpensesManagementController extends Controller
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
     * Lists all ExpensesManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExpensesManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Expenses Type','Expenses Date','Expenses Amount','Narration','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['type'] = $oneData['type'];
                $dat = date('d-m-Y',strtotime($oneData['exe_date']));
                if(strpos($dat, '1970')||strpos($dat, '0000')){
                    $dat = "-";
                }
                $newAr['exe_date'] = $dat;
                $newAr['amount'] = $oneData['amount']; 
                $newAr['narration'] = $oneData['narration']; 
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'ExpensesDetails';
            // echo "<prE>";print_r($input);die;
            $pry = new ReportsDownloader();
            $lis = $pry->excelDownload($input);
            if($lis=='error'){
                Yii::$app->session->setFlash('danger', 'No Data Founded for Report');
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExpensesManagement model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ExpensesManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExpensesManagement();

        if ($model->load(Yii::$app->request->post())) {
            $model->type = $_POST['ExpensesManagement']['type'];
            $model->committe_staff = $_POST['ExpensesManagement']['committe_staff'];
            $model->narration = $_POST['ExpensesManagement']['narration'];
            $model->exe_date = date('Y-m-d',strtotime( $_POST['ExpensesManagement']['exe_date']));
            $model->amount = $_POST['ExpensesManagement']['amount'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ExpensesManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // echo "<prE>";print_r($_POST);die;
            $model->type = $_POST['ExpensesManagement']['type'];
            $model->committe_staff = $_POST['ExpensesManagement']['committe_staff'];
            $model->exe_date = date('Y-m-d',strtotime( $_POST['ExpensesManagement']['exe_date']));
            $model->amount = $_POST['ExpensesManagement']['amount'];
            $model->narration = $_POST['ExpensesManagement']['narration'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ExpensesManagement model.
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
     * Finds the ExpensesManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExpensesManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExpensesManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
