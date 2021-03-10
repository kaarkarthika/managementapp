<?php

namespace backend\controllers;

use Yii;
use backend\models\StatusModule;
use backend\models\StatusModuleSearch;
use backend\models\TechnicianMaster;
use backend\models\BrandMapping;
use backend\models\ServiceModule;
use backend\models\CustomerMaster;
use backend\models\UserActivityLog;
use backend\models\AddressMappingList;
use backend\models\RandomGeneration;
use backend\models\RescheduleHistory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * StatusModuleController implements the CRUD actions for StatusModule model.
 */
class StatusModuleController extends Controller
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
     * Lists all StatusModule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionIndexHistory()
    {
        $searchModel = new StatusModuleSearch();
        $dataProvider = $searchModel->searchhistory(Yii::$app->request->queryParams);
        return $this->render('index-history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatusModule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StatusModule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StatusModule();
         $session = Yii::$app->session;
       if(Yii::$app->request->post()){
        // echo "<pre>";print_r($_POST);die;
    if ($formTokenValue = Yii::$app->request->post('StatusModule')['hidden_Input']) 
    {   
    $sessionTokenValue =  $session['hidden_token'];
    if ($formTokenValue == $sessionTokenValue ) 
    {
    //$customername=Yii::$app->request->post()['customer_name'];
    $product_id=$_POST['StatusModule']['product_id'];
    $brand_id=$_POST['StatusModule']['brand_id'];
    $service_type=$_POST['StatusModule']['service_type'];
        //$address=$_POST['StatusModule']['address'];
    $remarks=$_POST['StatusModule']['remarks'];

    $customercheck=$_POST['StatusModule']['phone'];
    $customer_name1=$_POST['StatusModule']['customer_name'];
    $customer_unique1=$_POST['StatusModule']['customer_unique'];
     if($customer_unique1==""){
        $authkey=Yii::$app->security->generateRandomString();
        $model22 = new CustomerMaster();
        $model22->platform="webservice";
        $model22->email='';
        $model22->customer_name=$customer_name1;
        $model22->phone=$customercheck;
        $model22->active_status='1';
        $model22->auth_key=Yii::$app->security->generateRandomString();
        $random_generation=RandomGeneration::find()
        ->where(['key_id'=>'customer_unique'])
        ->asArray()
        ->one();
        $random_generation_number=$random_generation['random_number'];
        $inc_value=$random_generation_number+1;
        $random_no = str_pad($random_generation_number, 6, "0", STR_PAD_LEFT);
        $model->customer_unique=$random_no;
        $model22->customer_unique=$random_no;
    if($model22->save()){
        RandomGeneration::updateAll(['random_number' => $inc_value], ['id' => '1']);
    }else{
        echo "<pre>";print_r($model22->getErrors());die;
    }
    $model44 = new AddressMappingList();
    $model44->customer_unique=$random_no;
    $model44->address=$remarks;
    $model44->status='A';
    $model44->address_label='Home';
    if($model44->save()){
    }else{
     echo "<pre>";print_r($model44->getErrors());die;
    }
    }else{
    $model->customer_unique=$customer_unique1;
     }
         //$customer_unique="";
         

         $datetime=$_POST['StatusModule']['date'];
         $time=$_POST['StatusModule']['re_time'];
         $date=date('d/m/Y',strtotime($datetime));
         //$time=date('H:i',strtotime($datetime));
         $model->product_id=$product_id ;
         $model->brand_id=$brand_id;
         $model->service_type=$service_type;
         $model->date=$date;
         $model->time=$time;
         $model->slot_time=$time;
         $model->re_time=$time;
         $model->bdatetime=date('Y-m-d H:i:s',strtotime($datetime));
        // $model->address=$address;
         $model->remarks=$remarks;
         $model->phone_number=$customercheck;
         $model->updated_at=date("Y-m-d H:i:s");
         $model->status="Pending";
         $model->platform="Web";
         if($model->save()){
            Yii::$app->session->remove('hidden_token');
         Yii::$app->getSession()->setFlash('success', 'Service Created successfully.');
         return $this->redirect(['index']);   
     }else{
        echo "<pre>";print_r($model->getErrors());die;
     }
              }else{
 return $this->redirect(['index']);  
              }
          }
         }
        else {  
        $formTokenName = uniqid();
        $session['hidden_token']=$formTokenName; 
        return $this->render('create', [
        'model' => $model,
        'token_name' => $formTokenName,
        ]);
        }
    }
    /**
     * Updates an existing StatusModule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->post()) {
        $customername=Yii::$app->request->post()['customer_name'];
        $product_id=$_POST['StatusModule']['product_id'];
        $brand_id=$_POST['StatusModule']['brand_id'];
        $service_type=$_POST['StatusModule']['service_type'];
      //  $address=$_POST['StatusModule']['address'];
        $remarks=$_POST['StatusModule']['remarks'];
        $status=$_POST['StatusModule']['status'];
        $customercheck=CustomerMaster::find()->where(['user_id'=>$customername])->asArray()->one();
        $phone="";
        if(!empty($customercheck)){
        $phone=$customercheck['phone'];
        }
         $datetime=$_POST['StatusModule']['date'];
         $date=date('d-m-Y',strtotime($datetime));
         $time=date('H:i:s',strtotime($datetime));
         $model->product_id=$product_id ;
         $model->brand_id=$brand_id;
         $model->service_type=$service_type;
         $model->date=$date;
         $model->time=$time;
         //$model->address=$address;
         $model->remarks=$remarks;
         $model->phone_number=$phone;
         $model->status=$status;
         $model->updated_at=date("Y-m-d H:i:s");

         $model->platform="Web";
         $model->save();
         Yii::$app->getSession()->setFlash('success', 'Service Updated successfully.');
         return $this->redirect(['index']);
        } 
        else
        {
        return $this->render('update', [
        'model' => $model,
        ]);
        }
    }

    /**
     * Deletes an existing StatusModule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StatusModule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatusModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatusModule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   public function actionApprove($id)
   {
    // Notification
    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];

$registerid=CustomerMaster::find()
->where(['customer_unique'=>$customerunique])
->asArray()
->one();

$registration_idssss="";
if(!empty($registerid)){
$registration_idssss=$registerid['token'];
}
StatusModule::updateAll(['status'=>'Approved','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);

$data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Approved",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

//$technician_id = $_POST['StatusModule']['technician_id'];
$msg_1=array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Service Approved Successfully.",'id'=>$id,'type'=>"booking");
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
//building headers for the request
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
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
    curl_close($ch);
    Yii::$app->getSession()->setFlash('success', 'Service Approved successfully.');
    return $this->redirect(['index']);
   }

   public function actionPicked($id)
   { 
    //Notification
    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();
    $registration_idssss="";
if(!empty($registerid)){
$registration_idssss=$registerid['token'];
}

$data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Picked",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");
  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
//StatusModule::updateAll(['status'=>'Approved'],['auto_id'=>$id]);
//$technician_id = $_POST['StatusModule']['technician_id'];
$msg_1=array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Service Picked Successfully Our Technician will Contact You Soon.",'id'=>$id);
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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

        
        StatusModule::updateAll(['status'=>'Picked','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);
        Yii::$app->getSession()->setFlash('success', 'Service Picked successfully.');
        return $this->redirect(['index']);
   }

    public function actionTechnicianList($id)
    {
        return $this->renderAjax('view-technician', [
            'model' => $this->findModel($id),
        ]);
    }


// Notification
/*public function send_notification($registrationIds="",$msgkey=""){
  $msg_1 = array('msg' => "Assigned the Technician",'followup_list'=>"12");
    $msg1 = array('message'=>json_encode($msg_1));
    $fields = array('registration_ids' => $registrationIds, 'data' => $msg1);
    $url = 'https://fcm.googleapis.com/fcm/send';
  $apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
  }*/
   public function actionTechnicianListAssign($id)
   {


    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();
    $assigndetails=StatusModule::find()
    ->where(['customer_unique'=>$customerunique])
    ->andWhere(['status'=>"Assigned"])
    ->orderBy(['updated_at'=>SORT_DESC])
    ->asArray()
    ->one();
    
    $oldtechnician="";
    if(!empty($assigndetails)){
    $oldtechnician=$assigndetails['technician_id'];
    }
$registration_idssss="";
if(!empty($registerid)){
$registration_idssss=$registerid['token'];
}
$technician_id=$_POST['StatusModule']['technician_id'];
$technician_idss=TechnicianMaster::find()
    ->where(['auto_id'=>$technician_id])
    ->asArray()
    ->one();

$techid="";
if($technician_idss!=""){
$techid=$technician_idss['token'];
}
$data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Assigned",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>$technician_id,'last_technician'=>$oldtechnician,'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

 StatusModule::updateAll(['status'=>'Assigned','technician_id'=>$technician_id,'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);


$msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Assigned Successfully.",'id'=>$id,'type'=>"booking");

$msg1 = array('message'=>json_encode($msg_1));
//echo "<pre>"; print_r($msg1);die;
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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

     
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);


if($techid!=""){

    $technician_push=TechnicianMaster::find()
    ->where(['auto_id'=>$technician_id])
    ->andWhere(['logout_status'=>"A"])
    ->asArray()
    ->one();

if(!empty($technician_push)){

$msg_1 = array('image'=>$image,'title'=>"Technician Assigned",'msg' => "You Have Assigned For New Customer",'id'=>$id,'type'=>"booking");
$msg1 = array('message'=>json_encode($msg_1));
//print_r($msg1);die;
$fields = array('registration_ids' =>[$techid], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
       }

 
        }   


       // return $result;
        Yii::$app->getSession()->setFlash('success', 'Technician Assigned successfully.');
        return $this->redirect(['index']);
   }

   public function actionCancelStatus($id)
   {

       $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();
    $registration_idssss="";
if(!empty($registerid)){
$registration_idssss=$registerid['token'];
}

$statuscheck="";
$cancelcheck=StatusModule::find()->where(['auto_id'=>$id])->asArray()->one();
if(!empty($cancelcheck)){
$statuscheck=$cancelcheck['status'];
}
if($statuscheck=="Completed"){

Yii::$app->getSession()->setFlash('danger', 'Service Already Completed.');
return $this->redirect(['index']);

}else{

        $cancel_remarks = $_POST['StatusModule']['cancel_remarks'];
        StatusModule::updateAll(['status'=>'Cancelled','cancel_remarks'=>$cancel_remarks,'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);


$data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Cancelled",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

//StatusModule::updateAll(['status'=>'Approved'],['auto_id'=>$id]);
/*$technician_id = $_POST['StatusModule']['technician_id'];
*/$msg_1=array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Your Service Cancelled.",'id'=>$id,'type'=>"booking");
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        Yii::$app->getSession()->setFlash('success', 'Service Cancelled successfully.');
        return $this->redirect(['index']);
    }
   }

    public function actionCompleteStatus($id)
   {
    
    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];

    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();
    $registration_idssss="";
    if(!empty($registerid)){
    $registration_idssss=$registerid['token'];
    }

 $data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Completed",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>date('Y-m-d H:i:s'));

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

 //Notification Function     
$msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Service Completed Successfully.",'id'=>$id,'type'=>"booking");
$msg1 = array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //echo "<pre>";print_r($_POST);die;
        $amount = $_POST['StatusModule']['amount'];
        $complete_remarks = $_POST['StatusModule']['complete_remarks'];
        $compdatetime=$models['complete_date'];
        $complete_date = $_POST['StatusModule']['complete_date'];
        $complete_time = $_POST['complete_time'];

    $datatimenew=$complete_date.' '. $complete_time .':00';
    $date1=date('Y/m/d',strtotime($complete_date));
    $complete_time=date('H:i',strtotime($complete_time));
    $text = str_replace('/', '-', $complete_date);
    $datatimenew=$text.' '. $complete_time .':00';
    $datenew=date('Y-m-d H:i:s',strtotime($datatimenew));

        StatusModule::updateAll(['status'=>'Completed','amount'=>$amount,'complete_remarks'=>$complete_remarks,'complete_date'=>$datenew,'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);

        Yii::$app->getSession()->setFlash('success', 'Service Completed successfully.');

        return $this->redirect(['index']);
   }


   //Reached Status Notification 
   /*created  by prathap 10-12-19*/
    
     public function actionReached($id)
   {
   // die;
    $data=Url::base(true);
    $image=$data."/images/electrical/location.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();

    $registration_idssss="";
    if(!empty($registerid)){
    $registration_idssss=$registerid['token'];
    }
 //Notification Function     
$msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Reached Your Location.",'id'=>$id,'type'=>"booking");
$msg1 = array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        StatusModule::updateAll(['status'=>'Reached','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);

        Yii::$app->getSession()->setFlash('success', 'Technician Arrived Your Location.');

        return $this->redirect(['index']);
   }

     public function actionStart($id)
   {
   // die;
    $data=Url::base(true);
    $image=$data."/images/electrical/start.png";
    $models = $this->findModel($id);
    $customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();

    $registration_idssss="";
    if(!empty($registerid)){
    $registration_idssss=$registerid['token'];
    }
 //Notification Function     
$msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Your Service Started.",'id'=>$id,'type'=>"booking");
$msg1 = array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        StatusModule::updateAll(['status'=>'Start','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);

        Yii::$app->getSession()->setFlash('success', 'Your Service Started');

        return $this->redirect(['index']);
   }



   /*end*/

public function actionRescheduleStatus($id)
{

$models = $this->findModel($id);
$customerunique=$models['customer_unique'];
$bdatetime=$models['bdatetime'];
$re_time11=$models['re_time'];
$technician_id=$models['technician_id'];
$re_date = $_POST['StatusModule']['re_date'];
$re_time = $_POST['StatusModule']['re_time'];
$statuscheck="";
$bdatetimelog="";
$cancelcheck=StatusModule::find()->where(['auto_id'=>$id])->asArray()->one();
if(!empty($cancelcheck)){
$statuscheck=$cancelcheck['status'];
$bdatetimelog=$cancelcheck['bdatetime'];
}
if($statuscheck=="Picked"){
Yii::$app->getSession()->setFlash('danger', 'Service Already Picked Cannot Reschedule.');
return $this->redirect(['index']);
}else{

   // echo "<pre>";print_r($_POST);die;
    $re_time = $_POST['StatusModule']['re_time'];
    $datatimenew=$re_date.' '. $re_time .':00';
    $date1=date('d-m-Y',strtotime($re_date));   
   // $re_time=date('H:i',strtotime($re_time));
    $text = str_replace('/', '-', $re_date);
    $datatimenew=$text;

$datenew=date('Y-m-d',strtotime($datatimenew));
$data_array=array('customer_unique'=>$customerunique,'service_id'=>$id,'platform'=>'web','message'=>"Reschedule",'prev_slot'=>$re_time11,'cur_slot'=>$re_time,'lat_scedule_date'=>$bdatetimelog,'rescedule_date'=>$datenew,'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
    $update=StatusModule::updateAll(['status'=>'Pending','re_schedule'=>'yes','re_date'=>$date1,'bdatetime'=>$datenew,'re_time'=>$re_time,'technician_id'=>"",'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$id]);
    $reschedule = new RescheduleHistory();
    $reschedule->customer_unique=$customerunique;
    $reschedule->prev_techid=$technician_id;
    $reschedule->current_techid="admin";
    $reschedule->service_id=$id;
    $reschedule->prev_slot=$re_time11;
    $reschedule->cur_slot=$re_time;
    $reschedule->previous_date=$bdatetime;
    $reschedule->current_bookindate=$datenew;
    if($reschedule->save()){
    }
    else
    {
    echo "<pre>";print_r($reschedule->getErrors());die;
    }

$data=Url::base(true);
$image=$data."/images/electrical/success.png";
$registerid=CustomerMaster::find()
->where(['customer_unique'=>$customerunique])
->asArray()
->one(); 
$registration_idssss="";
if(!empty($registerid)){
$registration_idssss=$registerid['token'];
}
//StatusModule::updateAll(['status'=>'Approved'],['auto_id'=>$id]);
$msg_1=array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Your Service Rescheduled.",'id'=>$id,'type'=>"booking");
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('registration_ids' =>[$registration_idssss], 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAFbig1w4:APA91bHnlShz7_0dXeZ6HWMElfpLclog_h9txLeH4vlxIrTLE8FmrdRpACafZopfAivB-SZlmoNIFY0DEflmEdq3ViYV-Ei55ldX7GLyw6pQ5_C34jQ_qwlWcjqvk8fm3RBU1RIJxRpn";
        //building headers for the request
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
        Yii::$app->getSession()->setFlash('success', 'Service Rescheduled successfully.');
        return $this->redirect(['index']);
    }
   }

    public function actionReschedule($id)
    {
        return $this->renderAjax('view-reschedule-enquiry', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionCancel($id)
    {
        return $this->renderAjax('view-cancel', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionComplete($id)
    {
        return $this->renderAjax('view-complete', [
            'model' => $this->findModel($id),
        ]);
    }

public function actionGetbranch($id)
    {
        if(!empty($id))
        {
            $branch_master=BrandMapping::find()->where(['service_id'=>$id])->asArray()->all();
            $ServiceModule=ServiceModule::find()->where(['service_id'=>$id])->asArray()->all();

           // print_r($ServiceModule);die;
        
            $data_array=array();
            if(!empty($branch_master))
            {
                $branch_master_map='';
                foreach ($branch_master as $key => $value) {
                    $branch_master_map.='<option value='.$value['autoid'].'>'.$value['brands'].'</option>';
                }

                $data_array[0]='ok';
                $data_array[1]=$branch_master_map;

                //return json_encode($data_array);
            }
            else
            {
                 $data_array[3]='no-data';
               //  return json_encode($data_array);
            }


           
            if(!empty($ServiceModule))
            {

              //  print_r($ServiceModule);die;
                $branch_master_map2='';
                foreach ($ServiceModule as $key1 => $value1) {
                    $branch_master_map2.='<option value='.$value1['auto_id'].'>'.$value1['service_type'].'</option>';
                }

                $data_array[4]='ok';
                $data_array[5]=$branch_master_map2;

                return json_encode($data_array);
            }
            else
            {
                 $data_array[6]='no-data';

                 return json_encode($data_array);
            }
        }
        
    }

}
