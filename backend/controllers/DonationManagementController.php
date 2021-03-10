<?php

namespace backend\controllers;

use Yii;
use backend\models\DonationManagement;
use backend\models\ReportsDownloader;
use backend\models\DonationManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * DonationManagementController implements the CRUD actions for DonationManagement model.
 */
class DonationManagementController extends Controller
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
     * Lists all DonationManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DonationManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Donation Mode','Donation Date','Donation Amount','Card Number','Bank Name','Card Holder Name','Reference Number','Payer Name','Payer Contact Number','Payer Address','Payer Comments','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['donation_type'] = $oneData['donation_type'];
                $dat = date('d-m-Y',strtotime($oneData['donation_date']));
                if(strpos($dat, '1970')||strpos($dat, '0000')){
                    $dat = "-";
                }
                $newAr['donation_date'] = $dat;
                $newAr['donationAmount'] = $oneData['donationAmount'];
                $newAr['card_number'] = $oneData['card_number'];
                $newAr['bankName'] = $oneData['bankName'];
                $newAr['cardHolderName'] = $oneData['cardHolderName'];
                $newAr['reference_number'] = $oneData['reference_number'];
                $newAr['donor_name'] = $oneData['donor_name'];
                $newAr['contact_number'] = $oneData['contact_number'];
                $newAr['donor_address'] = $oneData['donor_address'];
                $newAr['donor_description'] = $oneData['donor_description']; 
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'DonationDetails';
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
     * Displays a single DonationManagement model.
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
     * Creates a new DonationManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DonationManagement();

        if (Yii::$app->request->post()) {
            $model->donation_type = $_POST['DonationManagement']['donation_type'];
            $model->donation_date = date('Y-m-d',strtotime($_POST['DonationManagement']['donation_date']));
            $model->donationAmount = $_POST['DonationManagement']['donationAmount'];
            if($model->donation_type=='CASH' || $model->donation_type=='OTHERS')
                $model->reference_number = $_POST['DonationManagement']['reference_number'];
            if($model->donation_type=='CARD'){
                 $model->reference_number = $_POST['DonationManagement']['reference_number'];
                // $model->card_number = $_POST['DonationManagement']['card_number'];
                // $model->bankName = $_POST['DonationManagement']['bankName'];
                // $model->cardHolderName = $_POST['DonationManagement']['cardHolderName'];
            }
            if($_POST['DonationManagement']['donor_name']!="")
                $model->donor_name = $_POST['DonationManagement']['donor_name'];
            if($_POST['DonationManagement']['contact_number']!="")
                $model->contact_number = $_POST['DonationManagement']['contact_number'];
            if($_POST['DonationManagement']['donor_address']!="")
                $model->donor_address = $_POST['DonationManagement']['donor_address'];
            if($_POST['DonationManagement']['donor_description']!="")
                $model->donor_description = $_POST['DonationManagement']['donor_description'];
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
     * Updates an existing DonationManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
            $model->donation_type = $_POST['DonationManagement']['donation_type'];
            $model->donation_date = date('Y-m-d',strtotime($_POST['DonationManagement']['donation_date']));
            $model->donationAmount = $_POST['DonationManagement']['donationAmount'];
            if($model->donation_type=='CASH' || $model->donation_type=='OTHERS')
                $model->reference_number = $_POST['DonationManagement']['reference_number'];
            if($model->donation_type=='CARD'){
                // $model->card_number = $_POST['DonationManagement']['card_number'];
                // $model->bankName = $_POST['DonationManagement']['bankName'];
                // $model->cardHolderName = $_POST['DonationManagement']['cardHolderName'];
                  $model->reference_number = $_POST['DonationManagement']['reference_number'];
            }
            if($_POST['DonationManagement']['donor_name']!="")
                $model->donor_name = $_POST['DonationManagement']['donor_name'];
            if($_POST['DonationManagement']['contact_number']!="")
                $model->contact_number = $_POST['DonationManagement']['contact_number'];
            if($_POST['DonationManagement']['donor_address']!="")
                $model->donor_address = $_POST['DonationManagement']['donor_address'];
            if($_POST['DonationManagement']['donor_description']!="")
                $model->donor_description = $_POST['DonationManagement']['donor_description'];
            $model->updated_at = date('Y-m-d H:i:s');
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DonationManagement model.
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
     * Finds the DonationManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DonationManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DonationManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
