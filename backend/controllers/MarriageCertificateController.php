<?php

namespace backend\controllers;

use Yii;
use backend\models\MarriageCertificate;
use backend\models\ReportsDownloader;
use backend\models\MarriageCertificateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MarriageCertificateController implements the CRUD actions for MarriageCertificate model.
 */
class MarriageCertificateController extends Controller
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
     * Lists all MarriageCertificate models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MarriageCertificateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Wedding Date','Wedding Venue','Bride Name','Bride Contact Number','Bride Age','Bride Father Name','Bride Mother Name','Bride Address','Bride Witness','Groom Name','Groom Contact Number','Groom Age','Groom Father Name','Groom Mother Name','Groom Address','Groom Witness','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $dat = date('d-m-Y',strtotime($oneData['wedding_date']));
                if(strpos($dat, '1970')||strpos($dat, '0000')){
                    $dat = "-";
                }
                $newAr['wedding_date'] = $dat;
                $newAr['wedding_venue'] = $oneData['wedding_venue'];
                $newAr['bride_name'] = $oneData['bride_name'];
                $newAr['contact_number'] = $oneData['contact_number'];
                $newAr['bride_age'] = $oneData['bride_age'];
                $newAr['fathers_name'] = $oneData['fathers_name'];
                $newAr['mothers_name'] = $oneData['mothers_name'];
                $newAr['bride_address'] = $oneData['bride_address'];
                $newAr['witness_name'] = $oneData['witness_name'];
                $newAr['groom_name'] = $oneData['groom_name'];
                $newAr['groom_contact_number'] = $oneData['groom_contact_number']; 
                $newAr['groom_age'] = $oneData['groom_age']; 
                $newAr['groom_fathers_name'] = $oneData['groom_fathers_name']; 
                $newAr['groom_mothers_name'] = $oneData['groom_mothers_name']; 
                $newAr['groom_address'] = $oneData['groom_address']; 
                $newAr['groom_witness_name'] = $oneData['groom_witness_name']; 
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'MarriageRegistrationList';
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
     * Displays a single MarriageCertificate model.
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
     * Creates a new MarriageCertificate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarriageCertificate();

     $session = Yii::$app->session; 
        if($model->load(Yii::$app->request->post())) {
        if ($formTokenValue = Yii::$app->request->post('MarriageCertificate')['hidden_Input']) {   
          $sessionTokenValue =  $session['hidden_token'];
          if ($formTokenValue == $sessionTokenValue ){
            $model->wedding_date = date('Y-m-d H:i:s',strtotime($_POST['MarriageCertificate']['wedding_date']));
        if ($model->save()) {
            Yii::$app->session->remove('hidden_token');
            Yii::$app->getSession()->setFlash('success', 'Marriage Certificate Saved successfully.');
           return $this->redirect(['index']); 
         }else{
          Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
          $formTokenName = uniqid();
          $session['hidden_token']=$formTokenName;
               return $this->render('create', [
               'model' => $model,
               'token_name' => $formTokenName,
                ]);
                }
              }else{
               return $this->redirect(['index']); } 
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
     * Updates an existing MarriageCertificate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->wedding_date = date('Y-m-d H:i:s',strtotime($_POST['MarriageCertificate']['wedding_date']));
        if($model->save()){
         Yii::$app->getSession()->setFlash('success', 'Marriage Certificate Updated successfully.');
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
     * Deletes an existing MarriageCertificate model.
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
     * Finds the MarriageCertificate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MarriageCertificate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarriageCertificate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
