<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use backend\models\MosqueDetails;
use backend\models\ReportsDownloader;
use backend\models\MosqueDetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * MosqueDetailsController implements the CRUD actions for MosqueDetails model.
 */
class MosqueDetailsController extends Controller
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
     * Lists all MosqueDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MosqueDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Mosque Name','Phone Number','Email Id','Mosque Address','Licence Code','Image URL','Commands','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['name'] = $oneData['name'];
                $newAr['phoneNumber'] = $oneData['phoneNumber'];
                $newAr['emailId'] = $oneData['emailId'];
                $newAr['address'] = $oneData['address'];
                // $newAr['licenceCode'] = $oneData['licenceCode'];
                $newAr['image'] =Url::to('@web/uploads/mosque/'. $oneData['image']);
                $time = date('d-m-Y H:i:s',strtotime($oneData['createdAt']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";
                // $newAr['description'] = $oneData['description'];
                $newAr['createdAt'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'MosqueDetails';
            $pry = new ReportsDownloader();
            $lis = $pry->excelDownload($input);
            if($lis=='error'){
                Yii::$app->session->setFlash('danger', 'No Data Founded for Report');
            }
        }
        // echo "<pre>";print_r($_GET);die;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MosqueDetails model.
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
     * Creates a new MosqueDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MosqueDetails();

        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";print_r($_FILES);die;
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $banerImg = array(); # array for Muliptle images url
            if($_FILES){
                if(array_key_exists('images', $_FILES['MosqueDetails']['name'])){
                    foreach($_FILES['MosqueDetails']['name']['images'] as $key_file=>$onefile){
                        if($onefile!=""){
                            $file_name = preg_replace('/\s+/', '_', $_FILES['MosqueDetails']['name']['images'][$key_file]);
                            $aa6 = "uploads/mosque/" .$file_name;
                            move_uploaded_file($_FILES['MosqueDetails']['tmp_name']['images'][$key_file], $aa6);  
                            $banerImg[]=$file_name; # Files url are Pushed to Array
                        }
                    } 
                }
            }
            if(!empty($banerImg)){
                $model->image = json_encode($banerImg);
            }
            $model->name = $_POST['MosqueDetails']['name'];
            $model->phoneNumber = $_POST['MosqueDetails']['phoneNumber'];
            // $model->licenceCode = $_POST['MosqueDetails']['licenceCode'];
            $model->emailId = $_POST['MosqueDetails']['emailId'];
            $model->address = $_POST['MosqueDetails']['address'];
            
            $model->alternatePhoneNumber = $_POST['MosqueDetails']['alternatePhoneNumber'];
            $model->popularName = $_POST['MosqueDetails']['popularName'];
            $model->googleMapLink = $_POST['MosqueDetails']['googleMapLink'];
            $model->googleMapLink = $_POST['MosqueDetails']['landmark'];
            // $model->description = $_POST['MosqueDetails']['description'];
           
            $arr = array();
            if(array_key_exists('dymenLabel', $_POST)){
                if(!empty($_POST['dymenLabel'])){
                    foreach ($_POST['dymenLabel'] as $key => $value) {
                        $a = array();
                        $a['label'] = $value;
                        $a['value'] = $_POST['dymenValue'][$key];
                        $arr[] = $a;
                    }
                    $model->otherInformations = json_encode($arr);
                }
            }
            $model->ipAddress = $_SERVER['REMOTE_ADDR'];
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
            if(!$model->save()){
                echo "<pre>";print_r($model->getErrors());die;
            }
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MosqueDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";print_r($_POST);die;
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $banerImg = array(); # array for Muliptle images url
            if($_FILES){
                if(array_key_exists('images', $_FILES['MosqueDetails']['name'])){
                    foreach($_FILES['MosqueDetails']['name']['images'] as $key_file=>$onefile){
                        if($onefile!=""){
                            $file_name = preg_replace('/\s+/', '_', $_FILES['MosqueDetails']['name']['images'][$key_file]);
                            $aa6 = "uploads/mosque/" .$file_name;
                            move_uploaded_file($_FILES['MosqueDetails']['tmp_name']['images'][$key_file], $aa6);  
                            $banerImg[]=$file_name; # Files url are Pushed to Array
                        }
                    } 
                }
            }
            if(!empty($banerImg)){
                $model->image = json_encode($banerImg);
            }
            $model->name = $_POST['MosqueDetails']['name'];
            $model->phoneNumber = $_POST['MosqueDetails']['phoneNumber'];
            // $model->licenceCode = $_POST['MosqueDetails']['licenceCode'];
            $model->emailId = $_POST['MosqueDetails']['emailId'];
            $model->address = $_POST['MosqueDetails']['address'];
            $model->alternatePhoneNumber = $_POST['MosqueDetails']['alternatePhoneNumber'];
            $model->popularName = $_POST['MosqueDetails']['popularName'];
            $model->googleMapLink = $_POST['MosqueDetails']['googleMapLink'];
            $model->landmark = $_POST['MosqueDetails']['landmark'];
            $model->otherInformations = "";
            $arr = array();
            if(array_key_exists('dymenLabel', $_POST)){
                if(!empty($_POST['dymenLabel'])){
                    foreach ($_POST['dymenLabel'] as $key => $value) {
                        $a = array();
                        $a['label'] = $value;
                        $a['value'] = $_POST['dymenValue'][$key];
                        $arr[] = $a;
                    }
                    $model->otherInformations = json_encode($arr);
                }
            }
            $model->ipAddress = $_SERVER['REMOTE_ADDR'];
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
            if(!$model->save()){
                echo "<pre>";print_r($model->getErrors());die;
            }
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MosqueDetails model.
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
     * Finds the MosqueDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MosqueDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MosqueDetails::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddInfo($id)
    {

        $id++;
        $content = '
            <tr class="multi-field drag-handler">
                <td scope="row" class="serial_no">'.$id.'</td>
                <td><input type="text" name="dymenLabel[]" class="form-control" value="" /></td>
                <td><input type="text" name="dymenValue[]" class="form-control" value="" /></td>
                <td><button type="button" style="margin-top:5px; align:center;" class="btn btn-danger btn-xs remove-field" id="remove'.$id.'" "title" ="Remove"><i class="fa fa-remove"></i></button></td>
                </td>
            </tr>
        ';
        return $content;
    }

    public function actionReport($call="")
    {
        if($call!=""){
            $searchJson = ArrayHelper::toArray(json_decode($call));
            Yii::$app->request->queryParams = array_merge($searchJson,Yii::$app->request->queryParams);
          
        }
        $searchModel = new MosqueDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
    }
}
