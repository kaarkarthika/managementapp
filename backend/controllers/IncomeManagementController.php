<?php

namespace backend\controllers;

use Yii;
use backend\models\ReportsDownloader;
use backend\models\IncomeManagement;
use backend\models\IncomeManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * IncomeManagementController implements the CRUD actions for IncomeManagement model.
 */
class IncomeManagementController extends Controller
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
     * Lists all IncomeManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IncomeManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Income Mode','Income Date','Income Amount','Card Number','Bank Name','Card Holder Name','Reference Number','Payer Name','Payer Contact Number','Payer Address','Payer Comments','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['income_type'] = $oneData['income_type'];
                $dat = date('d-m-Y',strtotime($oneData['income_date']));
                if(strpos($dat, '1970')||strpos($dat, '0000')){
                    $dat = "-";
                }
                $newAr['income_date'] = $dat;
                $newAr['incomeAmount'] = $oneData['incomeAmount'];
                $newAr['card_number'] = $oneData['card_number'];
                $newAr['bankName'] = $oneData['bankName'];
                $newAr['cardHolderName'] = $oneData['cardHolderName'];
                $newAr['reference_number'] = $oneData['reference_number'];
                $newAr['payer_name'] = $oneData['payer_name'];
                $newAr['contact_number'] = $oneData['contact_number'];
                $newAr['payer_address'] = $oneData['payer_address'];
                $newAr['payer_description'] = $oneData['payer_description']; 
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'IncomeDetails';
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
     * Displays a single IncomeManagement model.
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
     * Creates a new IncomeManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new IncomeManagement();
        if (Yii::$app->request->post()) {
            $model->income_type = $_POST['IncomeManagement']['income_type'];
            $model->income_date = date('Y-m-d',strtotime($_POST['IncomeManagement']['income_date']));
            $model->incomeAmount = $_POST['IncomeManagement']['incomeAmount'];
            if($model->income_type=='CASH' || $model->income_type=='OTHERS')
                $model->reference_number = $_POST['IncomeManagement']['reference_number'];
            if($model->income_type=='CARD'){
                // $model->card_number = $_POST['IncomeManagement']['card_number'];
                // $model->bankName = $_POST['IncomeManagement']['bankName'];
                // $model->cardHolderName = $_POST['IncomeManagement']['cardHolderName'];
                 $model->reference_number = $_POST['IncomeManagement']['reference_number'];
            }
            if($_POST['IncomeManagement']['payer_name']!="")
                $model->payer_name = $_POST['IncomeManagement']['payer_name'];
            if($_POST['IncomeManagement']['contact_number']!="")
                $model->contact_number = $_POST['IncomeManagement']['contact_number'];
            if($_POST['IncomeManagement']['payer_address']!="")
                $model->payer_address = $_POST['IncomeManagement']['payer_address'];
            if($_POST['IncomeManagement']['payer_description']!="")
                $model->payer_description = $_POST['IncomeManagement']['payer_description'];
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
     * Updates an existing IncomeManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $model->income_type = $_POST['IncomeManagement']['income_type'];
            $model->income_date = date('Y-m-d',strtotime($_POST['IncomeManagement']['income_date']));
            $model->incomeAmount = $_POST['IncomeManagement']['incomeAmount'];
            if($model->income_type!='')
                $model->reference_number = $_POST['IncomeManagement']['reference_number'];
            if($model->income_type=='CARD'){
                // $model->card_number = $_POST['IncomeManagement']['card_number'];
                // $model->bankName = $_POST['IncomeManagement']['bankName'];
                // $model->cardHolderName = $_POST['IncomeManagement']['cardHolderName'];
                 $model->reference_number = $_POST['IncomeManagement']['reference_number'];
            }
            if($_POST['IncomeManagement']['payer_name']!="")
                $model->payer_name = $_POST['IncomeManagement']['payer_name'];
            if($_POST['IncomeManagement']['contact_number']!="")
                $model->contact_number = $_POST['IncomeManagement']['contact_number'];
            if($_POST['IncomeManagement']['payer_address']!="")
                $model->payer_address = $_POST['IncomeManagement']['payer_address'];
            if($_POST['IncomeManagement']['payer_description']!="")
                $model->payer_description = $_POST['IncomeManagement']['payer_description'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing IncomeManagement model.
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
     * Finds the IncomeManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return IncomeManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = IncomeManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
