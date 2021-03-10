<?php

namespace backend\controllers;

use Yii;
use backend\models\DeathCertificates;
use backend\models\ReportsDownloader;
use backend\models\DeathCertificatesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * DeathCertificatesController implements the CRUD actions for DeathCertificates model.
 */
class DeathCertificatesController extends Controller
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
     * Lists all DeathCertificates models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DeathCertificatesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array("Name of Deceased", "Father's Name of Deceased", "Childrens Name of Deceased", "Place of Death", "Place of Janaza Prayer", "Place of Burial Fields",'Death Date','Contact Person','address','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $dat = date('d-m-Y',strtotime($oneData['death_date']));
                if(strpos($dat, '1970')||strpos($dat, '0000')){
                    $dat = "-";
                }
                $newAr['demised_name'] = $oneData['demised_name'];
                $newAr['fatherName'] = $oneData['fatherName'];
                $newAr['childernName'] = $oneData['childernName'];
                $newAr['placeOfDeath'] = $oneData['placeOfDeath'];
                $newAr['placeOfJanazaPrayer'] = $oneData['placeOfJanazaPrayer'];
                $newAr['placeOfBurialFields'] = $oneData['placeOfBurialFields'];
                $newAr['death_date'] = $dat;
                $newAr['contact_person'] = $oneData['contact_person'];
                $newAr['relation_ship'] = $oneData['relation_ship'];
                $newAr['address'] = $oneData['address'];
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'DeathregistrationList';
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
     * Displays a single DeathCertificates model.
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
     * Creates a new DeathCertificates model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeathCertificates();
        $childContent = "";
          $session = Yii::$app->session; 
        if($model->load(Yii::$app->request->post())) {
        if ($formTokenValue = Yii::$app->request->post('DeathCertificates')['hidden_Input']) {   
          $sessionTokenValue =  $session['hidden_token'];
          if ($formTokenValue == $sessionTokenValue ){
            $model->childernName = $_POST['DeathCertificates']['childernName'];
            $model->death_date = date('Y-m-d H:i:s',strtotime($model->death_date));
               if(array_key_exists('childrenDetails', $_POST['DeathCertificates'])){
                if(!empty($_POST['DeathCertificates']['childrenDetails'])){
                    $resAr = array();
                    $ar = 1;
                    foreach ($_POST['DeathCertificates']['childrenDetails']['demised_name'] as $key => $oneDt) {
                        $rt = array();
                        $rt['demised_name'] = $oneDt;
                        $rt['contact_person'] = $_POST['DeathCertificates']['childrenDetails']['contact_person'][$key];
                        $rt['address'] = $_POST['DeathCertificates']['childrenDetails']['address'][$key];
                        $resAr[] = $rt;
                        $ar++;
                    }
                }
            }
            $model->childrenDetails = json_encode($resAr);
            if ($model->save()) {
            Yii::$app->session->remove('hidden_token');
            Yii::$app->getSession()->setFlash('success', 'Death Certificates Saved successfully.');
           return $this->redirect(['index']); 
         }else{
          Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
          $formTokenName = uniqid();
          $session['hidden_token']=$formTokenName;
               return $this->render('create', [
               'model' => $model,
               'token_name' => $formTokenName,
               'childContent' => $childContent,
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
                  'childContent' => $childContent,
                ]);
        }
    }

    /**
     * Updates an existing DeathCertificates model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
             $model->childernName = $_POST['DeathCertificates']['childernName'];
            $model->death_date = date('Y-m-d H:i:s',strtotime($model->death_date));
               if(array_key_exists('childrenDetails', $_POST['DeathCertificates'])){
                if(!empty($_POST['DeathCertificates']['childrenDetails'])){
                    $resAr = array();
                    $ar = 1;
                    foreach ($_POST['DeathCertificates']['childrenDetails']['demised_name'] as $key => $oneDt) {
                        $rt = array();
                        $rt['demised_name'] = $oneDt;
                        $rt['contact_person'] = $_POST['DeathCertificates']['childrenDetails']['contact_person'][$key];
                        $rt['address'] = $_POST['DeathCertificates']['childrenDetails']['address'][$key];
                        $resAr[] = $rt;
                        $ar++;
                    }
                }
            }
            $model->childrenDetails = json_encode($resAr);
        if($model->save()){
         Yii::$app->getSession()->setFlash('success', 'Death Certificates Updated successfully.');
         return $this->redirect(['index']);
        }else{
            echo "<pre>";print_r($model->getErrors());die;
        }
         
        } else {
     $childContent = $this->actionAddChildrens($id);
        $formTokenName = uniqid();
        $session['hidden_token']=$formTokenName;
            return $this->render('update', [
                'model' => $model,
                'token_name' => $formTokenName,
             'childContent' => $childContent,
            ]);
        }
       
    }

/*Add Childrens*/
      public function actionAddChildrens($id="")
    {
        if($_POST || $id!=""){
            $cnt = 0;
            $child = array();
            if($id!=""){
                $model = $this->findModel($id);
                if($model){
                    $child =ArrayHelper::toArray(json_decode($model->childrenDetails));
                }
                $cnt = count($child);
            }
            if($_POST){
                $cnt = $_POST['id'];
            }
            $content = "";
            for ($i=1; $i <= $cnt; $i++) { 
                $memCnt = $i+1;
                $u = $i-1;
                $demised_name = $contact_person = $address = "";
                if(array_key_exists($u, $child)){
                    $demised_name = $child[$u]['demised_name'];
                    $contact_person = $child[$u]['contact_person'];
                    $address = $child[$u]['address'];
                }   
                $content .= '<div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Member '.$memCnt.'</legend>
                                        <div  class="col-sm-12 form-group" >
                                            <div class="col-sm-4 form-group" >
                                                <label >Name</label>
                                                <input type="text" name="DeathCertificates[childrenDetails][demised_name][]" class="form-control" value="'.$demised_name.'">
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label >Contact Person</label>
                                                <input type="text" name="DeathCertificates[childrenDetails][contact_person][]" onkeypress="return isNumberKey(event)" class="form-control" value="'.$contact_person.'">
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label > Address</label>
                                               <textarea name="DeathCertificates[childrenDetails][address][]" class="form-control" rows="2">'.$address.'</textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>';
            }
            return $content;
        }
    }

    /**
     * Deletes an existing DeathCertificates model.
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
     * Finds the DeathCertificates model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeathCertificates the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeathCertificates::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
