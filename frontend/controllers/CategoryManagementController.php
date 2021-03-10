<?php
namespace frontend\controllers;
use Yii;
use yii\helpers\Url;
use backend\models\CategoryManagement;
use backend\models\CategoryManagementSearch;
use backend\models\ApiVersion;
use backend\models\ApiServiceLog;
use backend\models\StatusModule;
use backend\models\UserActivityLog;
use backend\models\CustomerMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

 /**
 * CategoryManagementController implements the CRUD actions for CategoryManagement model.
 */
class CategoryManagementController extends Controller
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
  public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
    /**
     * Lists all CategoryManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    //Service
     

     


      public function actionCategorylistyoutube(){

  
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
            $bunch_ids=$requestInput['category_id'];
            $bunchinfo=CategoryManagement::find()->where(['IN','auto_id',$bunch_ids])->asArray()->all();
            $result_array=array();
            if($bunchinfo){
            $bunchinfor_index=ArrayHelper::index($bunchinfo,'bunch_autoid');            
            foreach ($bunch_ids as $bunch_one) {
                if(isset($bunchinfor_index[$bunch_one])){
                    $arr=array();
                    $arr['bunch_id']=$bunch_one;
                    $arr['delivery_by']=$bunchinfor_index[$bunch_one]['service_vehicle_deliveredby_id'];
                    $arr['reinspection']=$bunchinfor_index[$bunch_one]['reinspection_done_by_id'];
                    $result_array[]=$arr;
                }
            }
            }
            $list['status']='success';
            $list['message'] = 'deliveredb_reinspection_done';  
            $list['results']=$result_array;
        }
        
        $response['Output'][]=$list;
        return json_encode($response);
 }

    //Servie

    /**
     * Displays a single CategoryManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CategoryManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function send_notification($customerunique="",$status="",$service_id=""){

    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $image22=$data."/images/electrical/location.png";

    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();

    $registration_idssss="";
    if(!empty($registerid)){
    $registration_idssss=$registerid['token'];
    }
    if($status=="picked"){
    $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Picked Your Servcie.",'id'=>$service_id,'type'=>"booking");
    }else if($status=="reached"){
    $msg_1 = array('image'=>$image22,'title'=>"Pooja Elctrical.",'msg' => "Technician Arrived Your  Location.",'id'=>$service_id,'type'=>"booking");
    }
    else if($status=="start"){
    $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Started  Your Service.",'id'=>$service_id,'type'=>"booking");
    }
    else if($status=="complete"){
     $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Your Service Completed",'id'=>$service_id,'type'=>"booking");
    }
$msg1 = array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
$headers = array('Authorization: key=' . $apikey, 'Content-Type: application/json');
        $ch = curl_init();
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //finally executing the curl request
        $result = curl_exec($ch);
       // print_r($result);die;
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
   /* public function actionCreate()
    {
        $model = new CategoryManagement();

        if ($model->load(Yii::$app->request->post())) {
           // echo "<pre>";
              
             // print_r($_POST);print_r($_FILES);die;

            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_image = $image_name;
            }

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Logo Saved successfully.');
                   return $this->redirect(['view', 'id' => $model->auto_id]);                } 
                   else {
                    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
                     return $this->render('create', [
                'model' => $model,
            ]);
                }
          
        } 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Updates an existing CategoryManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_image = $image_name;
                    $model->save();
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }*/

    /**
     * Deletes an existing CategoryManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    /*public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }*/

    /**
     * Finds the CategoryManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
/*App Version*/
 public function actionAppversion(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="appversion";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($requestInput[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
    } 
    if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
    }else{

      $apimethod=$requestInput['apimethod'];

  if($apimethod=="appversion"){
     $ApiVersion=ApiVersion::find()
     ->where(['version_key'=>"App"])
     ->asArray()
     ->one();
   // echo"<pre>";print_r($ApiVersion);die;
   if(!empty($ApiVersion)){
    $det['id']=$ApiVersion['auto_id'];
    $det['apps_name']=$ApiVersion['apps_name'];
    $det['app_version']=$ApiVersion['app_version'];
    if($ApiVersion['force_update']=="1"){
    $det['force_update']="Yes";
    }else if($ApiVersion['force_update']=="0"){
      $det['force_update']="No";  
    }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['appversion']=$det1;
   }else{
    $list['status'] = "error";
    $list['message'] = "no data";
    }
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }
/*Complete Status*/

 public function actionCompletestatus(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $post1['post']=$_POST;
    $post1['files']=$_FILES;
    $upload_file1="";
     if(isset($_FILES['upload_file']['name'])){
     $upload_file1=$_FILES['upload_file']['name'];
     }
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','service_id','status','amount');
    $model_log=new ApiServiceLog();
    $model_log->request_data=json_encode($post1);
    $model_log->event_key="completestatus";
    $model_log->created_at=date("Y-m-d H:i:s");
    $model_log->save();
    $log_id=$model_log->autoid;
     $is_error = '';
     foreach ($field_check as $one_key) {
        $key_val =isset($_POST[$one_key]);
        if ($key_val == '') {
          $is_error = 'yes';
          $is_error_note = $one_key;
          break;
        }
      } 
  if ($is_error == "yes") {
        $list['status'] = 'error';
        $list['message'] = $is_error_note . ' is Mandatory.';
      }else{
         $api_method = $service_id = $status = $upload_file = $complete_remarks = "";
         $amount ="0";
        if(array_key_exists('apimethod', $_POST)){
            $api_method = $_POST['apimethod'];
        }
        if(array_key_exists('service_id', $_POST)){
            $service_id = $_POST['service_id'];
        }
        if(array_key_exists('status', $_POST)){
            $status = $_POST['status'];
        }
        if(array_key_exists('amount', $_POST)){
            $amount = $_POST['amount'];
        }
        if(array_key_exists('complete_remarks', $_POST)){
            $complete_remarks = $_POST['complete_remarks'];
        }
        $customer_rating="";
        if(array_key_exists('customer_rating', $_POST)){
            $customer_rating = $_POST['customer_rating'];
        }
        
       // $date = date('d-m-Y h:i A', time());
        $date = date('Y-m-d H:i:s');
       // print_r($date);die;
        $list['status'] = 'error';
        $list['message'] = 'Invalid Api Method';
        if($api_method=="completestatus"){
        if($status=="Completed"){
        if($service_id!=''){
    if($upload_file1!=""){
    $status="complete";
    $customerunique=StatusModule::find()->where(['auto_id'=>$service_id])->asArray()->one();
    $customeruniqu="";
    if(!empty($customerunique)){
    $customeruniqu=$customerunique['customer_unique'];
    }

  $data_array=array('customer_unique'=>$customeruniqu,'service_id'=>$service_id,'platform'=>'mobile','message'=>"Completed",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>$date);

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

    $tech_pickup=StatusModule::updateAll(['status'=>'Completed','complete_date'=>$date,'amount'=>$amount,'technician_rating'=>$customer_rating,'complete_remarks'=>$complete_remarks,'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$service_id]);

    

   $this->send_notification($customeruniqu,$status,$service_id);
        
           $StatusModule=StatusModule::find()
          ->where(['auto_id'=>$service_id])
          ->one();
            if(isset($_FILES['upload_file']['name']))
                {
                  if(!empty($StatusModule)){
                    $uploads_dir = 'backend/web/images/signature/';         
                       $tmp_name =$_FILES["upload_file"]["tmp_name"];
                        $file_name = rand().$_FILES["upload_file"]["name"];
                     $uploads_dir = 'backend/web/images/signature/'.$file_name;
                     $uploads_dir1 = 'images/signature/'.$file_name;
                     move_uploaded_file($tmp_name, $uploads_dir);
                     $StatusModule->upload_file=$uploads_dir1;
                    if($StatusModule->save()){
                    }else{
                     echo "<pre>";print_r($StatusModule->getErrors());die;
                    }
                    }
                    }
                    $list['status'] = 'success';
                    $list['message'] = 'Completed Successfully';
                    }
                    else{
                    $list['status'] = 'error';
                    $list['message'] = 'Signature is mandatory';
                    }
                    }
                    else{
                    $list['status'] = 'error';
                    $list['message'] = 'service id mandatory';
                    }
                    }else{
                    $list['status'] = 'error';
                    $list['message'] = 'no data';
                    }
                    }
                }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
   return json_encode($response);
  }
}
