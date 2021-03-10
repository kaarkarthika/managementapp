<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\CustomerMaster;
use backend\models\DropdownManagement;
use backend\models\UserActivityLog;
use backend\models\TechnicianMaster;
use backend\models\ApiServiceLog;
use backend\models\HourMaster;
use backend\models\CategoryManagement;
use backend\models\RandomGeneration;
use backend\models\RescheduleHistory;
use backend\models\BrandMapping;
use backend\models\StatusModule;
use backend\models\ServiceModule;
use backend\models\QuickService;
use backend\models\AddressMappingList;
use backend\models\Userdetails;
use yii\web\UploadedFile;
use yii\db\Expression;
class CustomerApiController extends Controller
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
 //Related Videos End


// Notification
public function send_notification($customerunique="",$status="",$service_id=""){

  

    $data=Url::base(true);
    $image=$data."/images/electrical/success.png";
    $image22=$data."/images/electrical/location.png";
  //  $models = $this->findModel($id);
    //$customerunique=$models['customer_unique'];
    $registerid=CustomerMaster::find()
    ->where(['customer_unique'=>$customerunique])
    ->asArray()
    ->one();
    $registration_idssss="";
    if(!empty($registerid)){
    $registration_idssss=$registerid['token'];
    }
    //print_r($registration_idssss);die;
    if($status=="picked"){
    $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Picked Your Servcie.",'id'=>$service_id,'type'=>"booking");
    }else if($status=="reached"){
    $msg_1 = array('image'=>$image22,'title'=>"Pooja Elctrical.",'msg' => "Technician Arrived Your  Location.",'id'=>$service_id,'type'=>"booking");
    }
    else if($status=="start"){
    $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Technician Arrived Your  Location.",'id'=>$service_id,'type'=>"booking");
    }else{
     $msg_1 = array('image'=>$image,'title'=>"Pooja Elctrical.",'msg' => "Welcome",'id'=>$service_id,'type'=>"booking");
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

 //$this-> send_sms_number_transaction($customerunique,$status);

 public function send_sms_number_transaction($mnumber="",$bodytxt=""){
  $mnumber=trim($mnumber);
  $return="SMSnotenabled";
  if($mnumber!="" && is_numeric($mnumber) && strlen($mnumber)=="10"){
         
        $return="SMS Send";           
        $user_name="prathap";
        $user_password="rohit";
        $user_senderid="123";
       $sms_url="http://api.clickatell.com/http/sendmsg?to";
        $mnumber='+91'.$mnumber;        
        $bodytxt=str_replace("&", 'and', "");
        $bodytxt=str_replace("+", '', "$bodytxt");
        $bodytxt=str_replace("/", '', "$bodytxt");
        $bodytxt=rawurlencode( "$bodytxt");
        //$url = "http://smstrans.adwise.org.in/sendsms.jsp?user=ryabank&password=123456a&mobiles=$to&sms=$body&senderid=RYABNK";
          $url = $sms_url."=".$mnumber."&msg=".$user_password."";
         $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_HEADER, true);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);          
        $return_m=curl_exec($ch);      
        $return=$return.'_'.$return_m; 
        }
  return $return;
}

  
  /*public function actionServicecheck(){
        $initialize = array('sub_exam_id'=>"1",'answer_suffix'=>"2");
       $ch = curl_init("http://192.168.1.52/2019/invoicetansi/index.php/queuelist");
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POST, true);
       //   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$initialize);
          $response = curl_exec($ch);
          print_r($response);die;
          curl_close($ch);
          $resp = json_decode($response,true);
  }*/




 public function actionLogin(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','apimethod');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="login";
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
  $phonenumber=$requestInput['phonenumber'];
  if($apimethod=="poojaapi"){
  $str_rnd = mt_rand(1000, 9999);
 // $str_rnd="1234";
  $body = $str_rnd.' is your OTP for PoojaElectrical.';
  $student_mobile='8760776740';
  //$this-> send_sms_number_transaction($student_mobile,$body);
  if($phonenumber!=""){

  $customer_master=CustomerMaster::find()
  ->where(['phone'=>$phonenumber])
  ->asArray()
  ->one();

  if(!empty($customer_master)){
    $disable=$customer_master['disable'];
    if($disable=="yes"){
    $list['status'] = "error";
    $list['message'] = "Your account has been terminated.Please contact the admin.";

    }else{
      $otp=$str_rnd;
    $otpstatus="otp_sent";
    $platform="mobile";
    $active_status="1";
   $phonen=$customer_master['phone'];
   CustomerMaster::updateALL(['otp_number'=>$otp,'otp_status'=>$otpstatus,'platform'=>$platform,'active_status'=>$active_status,'updated_at'=>date("Y-m-d H:i:s")],['phone'=>$phonen]);
   $list['status'] = "success";
    $list['otp'] = $str_rnd;
    $list['message'] = "OTP Send successfully";
    }
     
   }else{

    $random_generation=RandomGeneration::find()
    ->where(['key_id'=>'customer_unique'])
    ->asArray()
    ->one();
    $random_generation_number=$random_generation['random_number'];
    $inc_value=$random_generation_number+1;
    $random_no = str_pad($random_generation_number, 6, "0", STR_PAD_LEFT);
    $model = new CustomerMaster();
    $model->phone=$phonenumber;
    $model->otp_number=$str_rnd;
    $model->customer_unique=$random_no;
    $model->otp_status="otp_sent";
    $model->platform="mobile";
    $model->updated_at=date("Y-m-d H:i:s");
    $model->active_status="1";
    if($model->save()){
    RandomGeneration::updateAll(['random_number' => $inc_value], ['id' => '1']);
    }
    else{
      echo "<pre>";print_r($model->getErrors());die;
    }
    $list['status'] = "success";
    $list['otp'] = $str_rnd;
    $list['message'] = "OTP Send successfully"; 
  }
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


  //Reschedule or Cancellation

   public function actionUpdateservice(){
    //die;
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true);
  //echo "<pre>";  print_r($requestInput);die;
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('booking_id','apimethod','date','time','cancelremarks','status');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updateservice";
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
  if($apimethod=="bookservicelist"){
  $booking_id=$requestInput['booking_id'];
  $date=$requestInput['date'];
  $cancelremarks=$requestInput['cancelremarks'];
  $time=$requestInput['time'];
  $bookingdetails=StatusModule::find()
  ->where(['auto_id'=>$booking_id])
  ->asArray()
  ->one();
  $customerunique="";
  $bdatetime="";
  $re_time1234="";
  $technician_id="";
  $service_id="";
  if(!empty($bookingdetails)){
    $customerunique=$bookingdetails['customer_unique'];
    $technician_id=$bookingdetails['technician_id'];
    $service_id=$bookingdetails['auto_id'];
    $re_time1234=$bookingdetails['re_time'];
    
  }
  //Booking Time
  $date=$requestInput['date'];
  $date1=date('Y/m/d',strtotime($date));
  $time=$requestInput['time'];
  $re_time=date('H:i',strtotime($time));
  $text = str_replace('/', '-', $date);
  $datatimenew=$text;
  $datenew=date('Y-m-d',strtotime($datatimenew));
  $datatimenew=$date;
  $status=$requestInput['status'];
  if($status=="R"){
  $data_array=array('customer_unique'=>$customerunique,'service_id'=>$booking_id,'platform'=>'mobile','message'=>"Reschedule",'prev_slot'=>$re_time1234,'cur_slot'=>$time,'lat_scedule_date'=>$bdatetime,'rescedule_date'=>$datenew,'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");
  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
   StatusModule::updateALL(['re_date'=>$date,'bdatetime'=>$datenew,'re_time'=>$time,'re_schedule'=>"yes",'technician_id'=>"",'status'=>"Pending",'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$booking_id]);
    $reschedule = new RescheduleHistory();
    $reschedule->customer_unique=$customerunique;
    $reschedule->prev_techid=$technician_id;
    $reschedule->current_techid="user";
    $reschedule->service_id=$service_id;
    $reschedule->prev_slot=$re_time1234;
    $reschedule->cur_slot=$time;
    $reschedule->previous_date=$bdatetime;
    $reschedule->current_bookindate=$datenew;
    if($reschedule->save()){
    }
    else
    {
    echo "<pre>";print_r($reschedule->getErrors());die;
    }

  }else if($status=="C"){

  StatusModule::updateALL(['status'=>"Cancelled",'cancel_remarks'=>$cancelremarks,'re_schedule'=>"no",'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$booking_id]);

  $data_array=array('customer_unique'=>$customerunique,'service_id'=>$booking_id,'platform'=>'mobile','message'=>"Cancelled",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

  }
  $list['status'] = "success";
  $list['message'] = "Updated Successfully";
  }
  }
//Log Table 
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][]=$list;
   return json_encode($response);
  }
  public function actionVerifyotp(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','otp','apimethod');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="verifyotp";
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
      $phonenumber=$requestInput['phonenumber'];
      $token="";
      if(isset($requestInput['token'])){

      $token=$requestInput['token'];
      }
      $otp=$requestInput['otp'];
if($apimethod=="poojaapi"){
$customer_master=CustomerMaster::find()
->where(['phone'=>$phonenumber])
->asArray()
->one();

$date=$customer_master['updated_at'];
$date22 = date('Y-m-d H:i:s');
$date = strtotime($date);
$date = strtotime("+5 minute", $date);
$date = date('Y-m-d H:i:s', $date);
$datestart= strtotime($date);
$date22start= strtotime($date22);
    if(!empty($customer_master)){
    $otp2=$customer_master['otp_number'];
    $default_id=$customer_master['default_id'];
    $customer_name=$customer_master['customer_name'];
    $email=$customer_master['email'];
    if($email!=""){
      $email=$email;
    }else{
      $email="";
    }
    $customer_unique=$customer_master['customer_unique'];
    if($customer_unique!=""){
      $customer_unique=$customer_unique;
    }else{
      $customer_unique="";
    } 
    if($customer_name!=""){
     $userlogintype="old";
     $userloginname=$customer_name;
    }else{
     $userlogintype="new";
     $userloginname="";
    }
    
    if($date22start <= $datestart){
    if($otp==$otp2){
   CustomerMaster::updateALL(['otp_status'=>'verified','token'=>$token,'updated_at'=>date("Y-m-d H:i:s")],['phone'=>$phonenumber]);
     $customer_master22=CustomerMaster::find()
    //->select('DATE_ADD(CREATION_DATE, INTERVAL 5 DAY) ');
    ->where(['phone'=>$phonenumber])
    ->andWhere(['token'=>$token])
    ->asArray()
    ->one();

if(!empty($customer_master22)){
}else{
  $customer_master44=CustomerMaster::find()
  //  ->select('DATE_ADD(CREATION_DATE, INTERVAL 5 DAY) ');
    ->andWhere(['token'=>$token])
    ->asArray()
    ->one();
 $userid=$customer_master44['user_id'];
 CustomerMaster::updateALL(['token'=>'','updated_at'=>date("Y-m-d H:i:s")],['user_id'=>$userid]);
 }
   /* if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    }*/
    $addressmaplist=array();        
    if($default_id!=""){
    $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->andWhere(['auto_id'=>$default_id])
    ->asArray()
    ->one();
    } 

    $list['status'] = "success";
    $list['user_role'] = $userlogintype;
    $list['unique_id'] = $customer_unique;
    $list['name'] = $userloginname;
    $list['email'] = $email;
    $list['address_id'] ="";
    $list['address'] = "";
    $list['address_label'] = "";
    if(!empty($addressmaplist)){
    $list['address_id'] = $addressmaplist['auto_id'];
    $list['address'] = $addressmaplist['address'];
    $list['address_label'] = $addressmaplist['address_label'];
    //$list['name'] = $userloginname;
    }
    $list['message'] = "OTP Verfied successfully";
    }else{
    $list['status'] = "error";
    $list['user_role'] = $userlogintype;
    $list['unique_id'] = $customer_unique;
    $list['name'] = "";
    $list['email'] ="";
    $list['address_id'] ="";
    $list['address'] = "";
    $list['address_label'] = "";
    $list['message'] = "Enter OTP correctly";
    }
    }
    else
    {
    $list['status'] = "error";
    $list['user_role'] = $userlogintype;
    $list['unique_id'] = $customer_unique;
    $list['name'] = "";
    $list['email'] ="";
    $list['address_id'] ="";
    $list['address'] = "";
    $list['address_label'] = "";
    $list['message'] = "OTP Expired.";
    }
    }
    else
    {
    $list['status']="error";
    $list['user_role']="";
    $list['unique_id'] = "";
    $list['name']="";
    $list['email'] ="";
    $list['address_id'] ="";
    $list['address'] = "";
    $list['address_label'] = "";
    $list['message']="Mobile Number Invalid";
    }
  }
  }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
    return json_encode($response);
  }
  public function actionUpdateprofile(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Apimethod Not Valid';
  $field_check=array('phonenumber','name','email','apimethod','address_id','unique_no','type','otp');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updateprofile";
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
    $phonenumber=$requestInput['phonenumber'];
    $unique_no=$requestInput['unique_no'];
    $name=$requestInput['name'];
    $address=$requestInput['address_id'];
    $email=$requestInput['email'];
    $type=$requestInput['type'];
  if($apimethod=="poojaapi"){
  if($type=="generate"){
  $customer_master=CustomerMaster::find()
  ->where(['customer_unique'=>$unique_no])
  ->asArray()
  ->one();
  if(!empty($customer_master)){
  $str_rnd = mt_rand(1000, 9999);
  $body = $str_rnd.' is your OTP for PoojaElectrical.';
  $student_mobile='8760776740';
 // $this-> send_sms_number_transaction($student_mobile,$body);
    //$otp=$str_rnd;
    $otpstatus="otp_sent";
    $platform="mobile";
    $active_status="1";
    $phonen=$customer_master['phone'];
    $updateww=CustomerMaster::updateALL(['otp_number'=>$str_rnd,'otp_status'=>$otpstatus,'platform'=>$platform,'active_status'=>$active_status,'updated_at'=>date("Y-m-d H:i:s")],['customer_unique'=>$unique_no]);
    if($updateww=="0"){
    $list['status'] = "error";
    $list['message'] = "OTP Not Sent";
    $list['otp'] = "";
     $list['type'] ="";
    }else{
    $list['status'] = "success";
    $list['message'] = "OTP Sent Successfully";
    $list['otp'] = $str_rnd;
    $list['type'] ="generate";
    }
    //$list['auth_key'] = $auth_key;
   }
   }else if($type=="verify"){

$customer_master=CustomerMaster::find()
    ->where(['customer_unique'=>$unique_no])
    ->asArray()
    ->one();
if(!empty($customer_master)){
$otp=$requestInput['otp'];
    $otp2=$customer_master['otp_number'];
$date=$customer_master['updated_at'];
$date22 = date('Y-m-d H:i:s');
$date = strtotime($date);
$date = strtotime("+5 minute", $date);
$date = date('Y-m-d H:i:s', $date);
$datestart= strtotime($date);
$date22start= strtotime($date22);
  if($date22start <= $datestart){

    if($otp==$otp2){
   
    $auth_key=Yii::$app->security->generateRandomString();
    $update=CustomerMaster::updateALL(['otp_status'=>'verified','user_type'=>'olduser','email'=>$email,'default_id'=>$address,'phone'=>$phonenumber,'customer_name'=>$name,'auth_key'=>$auth_key,'platform'=>'mobile','updated_at'=>date("Y-m-d H:i:s")],['customer_unique'=>$unique_no]);

    if($update=="1"){
    $list['status'] = "success";
     $list['type'] ="verify";
    $list['message'] = "Profile Updated Successfully";
    }else{
      $list['status'] = "error";
      $list['type'] ="verify";
    $list['message'] = "Profile Not Updated";
    }
    
    }else{
    $list['status'] = "error";
    $list['type'] ="verify";
    $list['message'] = "OTP Not Matched";
    }
  }else{
    $list['status'] = "error";
    $list['type'] ="verify";
    $list['message'] = "OTP Expired";
  }
}else{
  $list['status'] = "error";
  $list['type'] ="verify";
  $list['message'] = "Customer Unique Number Invalid";
}
}else if($type=="save"){

  $name=$requestInput['name'];
    $address=$requestInput['address_id'];
    $email=$requestInput['email'];
$phonenumber=$requestInput['phonenumber'];

$update=CustomerMaster::updateALL(['email'=>$email,'default_id'=>$address,'phone'=>$phonenumber,'customer_name'=>$name,'updated_at'=>date("Y-m-d H:i:s")],['customer_unique'=>$unique_no]);
     $list['status'] = "success";
     $list['type'] ="save";
     $list['message'] = "Profile Updated Successfully";


}
  }
  }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
   $response['Output'][] = $list;
    return json_encode($response);
  }


//servicetypelist  

public function actionServicetypelist(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="servicetypelist";
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
    if($apimethod=="poojaapi"){

    $servicetypelists=DropdownManagement::find()
    ->where(['key'=>"service_type"])
    ->asArray()
    ->all();
    //echo "<pre>";  print_r($servicetypelists);die;
    $ceek=array();
    foreach ($servicetypelists as $key => $value) {
    $ceek[]=$value['value'];
    }
    if(!empty($servicetypelists)){
    $list['status'] = "success";
    $list['message'] = "Service Type List";
    $list['service_type']=$ceek;
    }else{
    $list['status'] = "error";
    $list['message'] = "Service Type No Data";
    $list['service_type']=$ceek;
    }
    }
    }
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}
public function actionUpdatename(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('phonenumber','name','apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="updatename";
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
    $phonenumber=$requestInput['phonenumber'];
    $name=$requestInput['name'];

    if($apimethod=="poojaapi"){
    $customer_master=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
     if(!empty($customer_master)){
    /*$random_generation=RandomGeneration::find()
    ->where(['key_id'=>'customer_unique'])
    ->asArray()
    ->one();
    $random_generation_number=$random_generation['random_number'];
    $inc_value=$random_generation_number+1;
    $random_no = str_pad($random_generation_number, 6, "0", STR_PAD_LEFT);*/
    $auth_key=Yii::$app->security->generateRandomString();
    $update=CustomerMaster::updateALL(['otp_status'=>'verified','user_type'=>'olduser','customer_name'=>$name,'auth_key'=>$auth_key,'platform'=>'mobile','updated_at'=>date("Y-m-d H:i:s")],['phone'=>$phonenumber]);
    $customer_master_type=CustomerMaster::find()
    ->where(['phone'=>$phonenumber])
    ->asArray()
    ->one();
    $olduser=$customer_master_type['user_type'];
    $customer_unique=$customer_master_type['customer_unique'];
    $list['status'] = "success";
    $list['message'] = "User Updated Successfully";
    $list['user_type'] = $olduser;
    $list['unique_id'] = $customer_unique;
    $list['auth_key'] = $auth_key;
    }else{
    $list['status'] = "error";
    $list['message'] = "Mobile Number Invalid";
    }
    }
    }
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}

public function actionServicerating(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('service_rating','service_id','apimethod','service_feedback');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="customer-rating";
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
    }
    else
    {

    $apimethod=$requestInput['apimethod'];
    $service_id=$requestInput['service_id'];
    $service_rating=$requestInput['service_rating'];
    $service_feedback=$requestInput['service_feedback'];
    if($apimethod=="servicerating"){
    $servicevalue=StatusModule::find()
    ->where(['auto_id'=>$service_id])
    ->asArray()
    ->one();
    if(!empty($servicevalue)){
    $update=StatusModule::updateALL(['service_feedback'=>$service_feedback,'service_rating'=>$service_rating,'updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$service_id]);
    $list['status'] = "success";
    $list['message'] = "Thanks for giving feedback !!!.";
    }else{
    $list['status'] = "error";
    $list['message'] = "Service Id Missing";
    }
    }
    }
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}

/*public function actionProcessdetails(){
  $list = array();
   $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Nill';
      $field_check=array('service_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="processdetails";
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
      $list['status'] = "success";
      $list['message'] = "Process details";
      $list['process_status'] = "1";
      $list['brand'] = "Haier";
       $list['date'] = "13/02/2019";
          $list['time'] = "04:45 PM";
           $list['service_type'] = "General service";
            $list['service_person_name'] = "MR. Jagan";
             $list['phone_no'] = "9876543210";

if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
 $response['Output'][] = $list;
 return json_encode($response);
}
}*/
//Boooked Save
public function actionBookservice(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_number','product_id','brand_id','service_id','date','time','address','customer_unique');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservice";
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
    $product_id=$requestInput['product_id'];
    $brand_id=$requestInput['brand_id'];
    $phone_number=$requestInput['phone_number'];
    $customer_unique=$requestInput['customer_unique'];
    $service_id=$requestInput['service_id'];
    $date=$requestInput['date'];
    $date1=date('Y/m/d',strtotime($date));
    $time=$requestInput['time'];
    $re_time=date('H:i',strtotime($time));
    $text = str_replace('/', '-', $date);
    $datatimenew=$text.' '. $re_time .':00';
    $datenew=date('Y-m-d H:i:s',strtotime($datatimenew));
    $address=$requestInput['address'];
    $remarks="";
    if(isset($requestInput['remarks'])){
    $remarks=$requestInput['remarks'];
    }
    $slot_time="";
    if(isset($requestInput['slot_time'])){
    $slot_time=$requestInput['slot_time'];
    }
    
  if($apimethod=="bookservice"){
    $model = new StatusModule();
    $model->product_id=$product_id;
    $model->brand_id=$brand_id;
    $model->service_type=$service_id;
    $model->bdatetime=$datenew;
    $model->customer_unique=$customer_unique;
    $model->phone_number=$phone_number;
    $model->date=$date;
    $model->time=$slot_time;
    $model->address=$address;
    $model->slot_time=$slot_time;
    $model->remarks=$remarks;
    $model->updated_at=date("Y-m-d H:i:s");
    $model->status="Pending";
    $model->platform="Mobile";
    $model->re_schedule="no";

  if($model->save()){
  $data_array=array('customer_unique'=>$customer_unique,'service_id'=>$model->auto_id,'platform'=>'mobile','message'=>"Booking",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");
  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
  $customermaster=CustomerMaster::updateAll(['default_id'=>$address,'updated_at'=>date("Y-m-d H:i:s")],['customer_unique'=>$customer_unique]);
    $list['status'] = "success";
    $list['message'] = "booking created successfully";
    $list['service_id'] =$model->auto_id;
    }else{
    echo "<pre>";print_r($model->getErrors());die;
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

//BookService List
  public function actionBookservicelist(){
    $data=Url::base(true);
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_number','customer_unique');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelist";
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
    $phone_number=$requestInput['phone_number'];
    $customer_unique=$requestInput['customer_unique'];
    if($apimethod=="bookservicelist"){
    $booklisttable=StatusModule::find()
    ->where(['customer_unique'=>$customer_unique])
    ->andWhere(['NOT IN','phone_number',array(0)])
    ->andWhere(['NOT IN','status',array('Cancelled','Completed')])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();

//print_r($booklisttable);die;

    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');
   }
    if(!empty($booklisttable)){
        
        $listva=array();
        foreach ($booklisttable as $key => $value) {
        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
         $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
       // ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();

   //echo "<pre>";     print_r($slottime);die;
        
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }

         


        $categoryname="";
        if(isset($categorylistindex[$product_id])){
        $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $category_image="";
        if(isset($categorylistindex[$product_id])){
        $category_image=$categorylistindex[$product_id]['category_image'];
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
        $servicenames=ucfirst($servicelistindex[$service_type]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['imageurl']=$data."/backend/web/".$category_image;
        $listva['status']=$value['status'];
        $listva['date']=$value['date'];
        $listva['unique_id']=$value['customer_unique'];
        $listva['phone_number']=$value['phone_number'];

        $listva['time']=$correcttime;
        $listva['cancel_remarks']="";

        if($value['cancel_remarks']!=""){
        $listva['cancel_remarks']=$value['cancel_remarks'];
        }

        $listva['re_schedule']="no";

        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }

        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }

        $listva['re_time']="";
        if($value['re_time']!=""){
         $slottime11=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime11)){
        $correct_time=$slottime11['correct_time'];
        $listva['re_time']=$correct_time;
        }  
        }
        
        $listva['address']=$value['address'];
        if($technician_id!=""){
        if($technicianindex!=""){
        if(isset($technicianindex[$technician_id])){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }
        }else{
        $listva['technician']="";
        }

        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
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
  public function actionBookservicelisthistory(){
    $data=Url::base(true);
    //$data."/backend/web/".$category_image;
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_number','customer_unique');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelist";
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
    $phone_number=$requestInput['phone_number'];
    $customer_unique=$requestInput['customer_unique'];
    if($apimethod=="servicehistory"){
    $booklisttable=StatusModule::find()
    ->where(['IN','status',array('Cancelled','Completed')])
    ->andWhere(['customer_unique'=>$customer_unique])
    ->andWhere(['NOT IN','phone_number',array(0)])
    ->orderBy(['updated_at'=>SORT_DESC])
    ->asArray()
    ->all();
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }
    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
      foreach ($booklisttable as $key => $value) {
         $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
      // ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }


        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
        $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$service_type]['service_type']);
        }
        $category_image="";
        if(isset($categorylistindex[$product_id])){
          $category_image=$categorylistindex[$product_id]['category_image'];
        }
        $listva['imageurl']=$data."/backend/web/".$category_image;
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['imageurl']=$data."/backend/web/".$category_image;
        $listva['status']=$value['status'];
        $listva['phone_number']=$value['phone_number'];
        $listva['date']=$value['date'];
        $listva['unique_id']=$value['customer_unique'];
        $listva['time']=date('h:i A',strtotime($value['time']));
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){

        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
         $slottime22=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $listva['re_time']=$correct_time;
        } 
        }
        $listva['address']=$value['address'];

        $listva['from_time']=$from_time;
        $listva['to_time']=$to_time;
        $listva['correcttime']=$correcttime;
        if($technician_id!=""){
        if($technicianindex[$technician_id]){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }else{
        $listva['technician']="";
        }
        if($value['amount']!=""){
        $listva['amount']=$value['amount']  .'  Rs/-';
        }else{
        $listva['amount']="NA";
        }
        $get_start_date=date('M d Y',strtotime($value['created_at']));
        $listva['created_at'] = $get_start_date;
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
        $list['status'] = "success";
       $list['message'] = "No Service Data.";
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

  //BookService List
  public function actionBookservicelisthistoryview(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','service_id');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="historyview";
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
    $service_id=$requestInput['service_id'];
  
    if($apimethod=="servicehistory"){
    $booklisttable=StatusModule::find()
    ->where(['auto_id'=>$service_id])
    ->andWhere(['IN','status',array('Cancelled','Completed')])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
     if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
     }
     if(!empty($categorylist)){  
     $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
     }
    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');
    }
    if(!empty($booklisttable)){
       $listva=array();
      foreach ($booklisttable as $key => $value) {

         $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
      //  ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();
        
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }

        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
        $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
        $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['status']=$value['status'];
        $listva['date']=$value['date'];
        $listva['phone_number']=$value['phone_number'];
        $listva['unique_id']=$value['customer_unique'];
        $listva['time']=date('h:i A',strtotime($value['time']));
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){
        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";

        if($value['re_time']!=""){
        $slottime22=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $listva['re_time']=$correct_time;
        }
        }
        $listva['from_time']=$from_time;
        $listva['to_time']=$to_time;
        $listva['correcttime']=$correcttime;

        $listva['address']=$value['address'];
        if($technician_id!=""){
        if(isset($technicianindex[$technician_id])){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }else{
        $listva['technician']="";
        }

        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
       $list['status'] = "success";
       $list['message'] = "No Service Data.";
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
  
  public function actionBookservicelistdetails(){
    $data=Url::base(true);
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','booking_id');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="bookservicelistdetails";
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
    $booking_id=$requestInput['booking_id'];
    if($apimethod=="bookservicelist"){
    $booklisttable=StatusModule::find()
    ->where(['auto_id'=>$booking_id])
    ->orderBy(['created_at'=>SORT_DESC])
    ->asArray()
    ->all();
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
     $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
     }
    if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
    }

    if(!empty($categorylist)){  
     $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
    } 
    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    if(!empty($booklisttable)){
       $listva=array();
       $listvade=array();
       $listvadess=array();
      foreach ($booklisttable as $key => $value) {

        $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
      //  ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();
        
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }
      //  echo "<pre>";print_r($booklisttable);die;
        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $brand_id=$value['brand_id'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
          $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $servicenames="";
        if(isset($servicelistindex[$service_type])){
          $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
        }
        $brandnames="";
        if(isset($brandmappingindex[$brand_id])){
         $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
        }
        $listva['id']=$value['auto_id'];
        $listva['service_type']=$servicenames;
        $listva['brand']=$brandnames.' - '.$categoryname;
        $listva['status']=$value['status'];

        if($value['service_rating']!=""){
        $listva['service_rating']=$value['service_rating'];
        $listva['rating_status']="yes";
        }else{
        $listva['service_rating']="";
        $listva['rating_status']="no";
        }
        $listva['assigned']="No";
        if($value['status']=="Assigned" || $value['status']=="Completed" || $value['status']=="Picked"){
        $listva['assigned']="Yes";
        }
        $listva['date']=$value['date'];
        $listva['unique_id']=$value['customer_unique'];
        $listva['time']=$correcttime;
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){
        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['amount']="";
        if($value['amount']!=""){
        $listva['amount']=$value['amount'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['re_date']=$value['re_date'];
        }
        $listva['re_time']="";
        if($value['re_time']!=""){
        $slottime22=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $listva['re_time']=$correct_time;
        }
       
        }
        $listva['from_time']=$from_time;
        $listva['to_time']=$to_time;
        $listva['correcttime']=$correcttime;
       // $listva['$from_time']=$from_time;
        if($value['address']!=""){
        $addresslist=AddressMappingList::find()->where(['auto_id'=>$value['address']])->andWhere(['status'=>"A"])->asArray()->one();
        if(!empty($addresslist)){
        $listva['lat']=$addresslist['lat'];
        $listva['lng']=$addresslist['lng'];
        $listva['address']=$addresslist['address'];
        $listva['address_id']=$value['address'];
        $listva['address_label']=$addresslist['address_label'];
        }
        }
        else
        {
        $listva['lat']="";
        $listva['lng']="";
         $listva['address_id']="";
        $listva['address']="";
        $listva['address_label']="";
        }
        if($technician_id!=""){
        if(isset($technicianindex[$technician_id])){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        $name=$technicianindex[$technician_id]['technician_name'];
        $phone_no=$technicianindex[$technician_id]['phone_no'];
        $email_id=$technicianindex[$technician_id]['email_id'];
        $technician_image =$technicianindex[$technician_id]['technician_image']; 
      // echo "<pre>";print_r($technicianindex[$technician_id]);die;
        $listvadess['tech_id']=$technician_id;
        $listvadess['name']=$name;
        $listvadess['phone_no']=$phone_no;
        $listvadess['email_id']=$email_id;
        if($technician_image!=''){
        $listvadess['technician_image']= $data."/backend/web/".$technician_image;
        }else{
        $listvadess['technician_image']="";
        }
        }
        }else{
        $listva['technician']="";
        $listva['tech_id']="";
        $listvadess['name']="";
        $listvadess['phone_no']="";
        $listvadess['email_id']="";
        $listvadess['technician_image']="";
        }
        $listva['created_at']=$value['created_at'];
        $listva['technician_details'][]=$listvadess;
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "List of service.";
      }
    }else{
    $list['status'] = "success";
    $list['message'] = "No Service Data.";
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

/*Service Module LisT*/
public function actionServicedetails(){
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('category_key','apimethod');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="servicedetails";
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
    $catageory_key=$requestInput['category_key'];
    if($apimethod=="poojaapi"){
    $brand_mapping=BrandMapping::find()
    ->where(['service_id'=>$catageory_key])
    ->asArray()
    ->all();
    $service_module=ServiceModule::find()
    ->where(['service_id'=>$catageory_key])
    ->asArray()
    ->all(); 
     $hour_master=HourMaster::find()
    ->asArray()
    ->all();  
    $det_list1=array();
    $det1=array();
    $det22=array();
    $det4=array();
    $det_list=array();
    $data=Url::base(true);
    if(!empty($hour_master)){
    foreach ($hour_master as $key => $value22) {
    $det22['id']=$value22['id'];
    $det22['from_time']=$value22['from_time'];
    $det22['to_time']=$value22['to_time'];
    $det22['correct']=$value22['from_time'].' - '.$value22['to_time'];
    $det4[]=$det22;
    }  
    }
    if($brand_mapping!="" && $service_module !=""){
    foreach ($brand_mapping as $key => $value) {
    $det['service_list']=$value['service_id'];
    $det['brands']=ucfirst($value['brands']);
    $det['brand_id']=$value['autoid'];
    $det['description']=$value['description'];
    $det['brand_logo']=$data."/backend/web/".$value['brand_image'];
    $det1[]=$det;
    }  
    foreach ($service_module as $key => $value) {
    $det_list['auto_id']=$value['auto_id'];
    $det_list['service_list']=$value['service_id'];
    $det_list['service_type']=ucfirst($value['service_type']);
    $det_list['description']=$value['description'];
    $det_list1[]=$det_list;
    }    
    $list['status']='success';
    $list['message']='success';
    $list['brands']=$det1;
    $list['service_type']=$det_list1;
    $list['time_hours']=$det4;
    }
    else if($brand_mapping!=""){
    foreach ($brand_mapping as $key => $value) {
    $det['service_list']=$value['service_id'];
    $det['brands']=$value['brands'];
    $det['brand_id']=$value['autoid'];
    $det['description']=$value['description'];
    $det['brand_logo']=$data."/backend/web/".$value['brand_image'];
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['brands']=$det1;
    $list['service_type']=array();
     $list['time_hours']=$det4;
    }  
    }
    elseif($service_module!=""){
    foreach ($service_module as $key => $value) {
    $det_list['auto_id']=$value['auto_id'];
    $det_list['service_list']=$value['service_id'];
    $det_list['service_type']=$value['service_type'];
    $det_list['description']=$value['description'];
    $det_list1[]=$det_list;
    }
    $list['status']='success';
    $list['message']='success';
    $list['brands']=array();
    $list['service_type']=$det_list1;
     $list['time_hours']=$det4;
    }    
    }
    else
    {
    $list['status']='success';
    $list['message']='List not Available';
    $list['brands']=array();
    $list['service_type']=array();
    }
    }
  if($log_id!=''){
    $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
    $model_log->response_data=json_encode($list);
    $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}
/*Technician Login*/
public function actionTechnicianlogin(){
  $data=Url::base(true);
  $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
     $list['status'] = 'error';
     $list['message'] = 'Invalid Apimethod';
    $field_check=array('username','password','apimethod');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="technicianlogin";
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
    $username=$requestInput['username'];
    $password=$requestInput['password'];
    $token="";
    if(isset($requestInput['token'])){  
    $token=$requestInput['token'];
    }
    if($apimethod=="poojaapi"){
    $TechnicianMaster=TechnicianMaster::find()
    ->where(['user_name'=>$username])
    ->andWhere(['active_status'=>"1"])
    ->asArray()
    ->one();
    $det1=array();
    $det=array();
    if(!empty($TechnicianMaster)){
       $password_hash=$TechnicianMaster['password'];
    if($password_hash!="" && $password!=""){
       if(Yii::$app->security->validatePassword($password,$password_hash)){
         TechnicianMaster::updateAll(['token'=>$token,'logout_status'=>'A'],['user_name'=>$username]);
          $det['tech_id']=$TechnicianMaster['auto_id'];
          $det['technician_name']=$TechnicianMaster['technician_name'];
          $det['address']=$TechnicianMaster['address'];
          $det['phone_no']=$TechnicianMaster['phone_no'];
          $det['email_id']=$TechnicianMaster['email_id'];
      $det['technician_image']=$data."/backend/web/".$TechnicianMaster['technician_image'];
          $det1[]=$det;
          $list['status']='success';
          $list['message']='success';
          $list['profile']=$det1;
        }else{
          $list['status']='error';
          $list['message']='Invalid Password';
          $list['profile']=array();
        }
       }
      else{
          $list['status']='error';
          $list['message']='Password Is Empty';
          $list['profile']=array();
      }
      }else{
          $list['status']='error';
          $list['message']='Invalid Login';
          $list['profile']=array();
         }
       }
     }
  if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}
/*SERVICE LOGIN DETAILS*/
 public function actionTechnicianloginlist(){
//  die;
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','tech_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="technicianloginlist";
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
        $list['bookinglist']=array();
    }else{


    $apimethod=$requestInput['apimethod'];
    $tech_id=$requestInput['tech_id'];
  
    if($apimethod=="technician_list"){
     $TechnicianMaster=TechnicianMaster::find()
    ->where(['auto_id'=>$tech_id])
    ->asArray()
    ->one();
   //echo "<pre>";  print_r($TechnicianMaster);die;


        $page = 1;
        $start = 10;
        $limit = 10;

    $servicetypelists=StatusModule::find()
    ->where(['technician_id'=>$tech_id])
    ->andWhere(['IN','status',array('Assigned','Rescheduled','Picked')])
    ->asArray()
   //->limit($start)
    ->all();
    
     if(isset($requestInput['page'])){
          //  print_r("expression");die;
    if($requestInput['page']=="all") {
      $page = $requestInput['page'];
           
    $servicetypelists=StatusModule::find()
    ->where(['technician_id'=>$tech_id])
    ->andWhere(['IN','status',array('Assigned','Rescheduled','Picked')])
    ->asArray()
   //->limit($start)
    ->all();
        }
    else{
    if(isset($requestInput['page'])){
    $page = $requestInput['page'];
    if (!is_numeric($page)) {
    $page = 1;
    }
    $start = $page * $limit; 
    $servicetypelists=StatusModule::find()
    ->where(['technician_id'=>$tech_id])
    ->andWhere(['IN','status',array('Assigned','Rescheduled','Picked')])
    ->asArray()
    ->limit($start)
    ->all();
            }
        }
        }
    

   // print_r($servicetypelists);die;
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
     $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }
  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   }
    $data=Url::base(true);
    
    if(!empty($servicetypelists)){
       $listva=array();
    //echo "<pre>";    print_r($servicetypelists);die;
      foreach ($servicetypelists as $value) {
        

         $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
       // ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();
        
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }

        $customerdetail=CustomerMaster::find()
        ->select('customer_name')
        ->where(['customer_unique'=>$value['customer_unique']])
        ->asArray()
        ->one();
       // print_r($customerdetail['customer_name']);die;
     $customernamen="";
     if($customerdetail!=""){
     $customernamen=$customerdetail['customer_name'];
     }



        $technician_id=$value['technician_id'];
        $product_id=$value['product_id'];
        $service_type=$value['service_type'];
        $brand_id=$value['brand_id'];
        $categoryname="";
        if(isset($categorylistindex[$product_id])){
        $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
        }
        $category_image="";
        if(isset($categorylistindex[$product_id])){
        $category_image=$categorylistindex[$product_id]['category_image'];
        }

        $servicenames="";
        if(isset($servicelistindex[$service_type])){
        $servicenames=ucfirst($servicelistindex[$service_type]['service_type']);
        }
        $brandnames="";
        if(isset($brandmappingindex[$brand_id])){
        $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
        }
        $listva['service_id']=$value['auto_id'];
        $listva['service_type']=$categoryname.' - '.$servicenames;
        $listva['brand']=$brandnames;
        $listva['customer_name']=$customernamen;
        if($value['tech_status']!=""){
        $listva['status']=$value['tech_status'];
        }else{
        $listva['status']=$value['status'];
        }
        $listva['imageurl']=$data."/backend/web/".$category_image;
        
        $listva['customer_unique']=$value['customer_unique'];
        $listva['phone_number']=$value['phone_number'];
        
        $listva['cancel_remarks']="";
        if($value['cancel_remarks']!=""){
        $listva['cancel_remarks']=$value['cancel_remarks'];
        }
        $listva['re_schedule']="no";
        if($value['re_schedule']!=""){
        $listva['re_schedule']=$value['re_schedule'];
        }
        $listva['date']=$value['date'];
        

        $listva['time']="";
    if($value['time']!=""){
     $time=HourMaster::find()->where(['id'=>$value['time']])->asArray()->one();

     if(!empty($time)){
    $listva['time']=$time['correct_time'];
     }

    }

        $listva['re_date']="";
        if($value['re_date']!=""){
        $listva['date']=$value['re_date'];
        $listva['re_date']=$value['re_date'];
        }

        $listva['re_time']="";
        if($value['re_time']!=""){

        $listva['time']=$value['re_time'];
         $slottime22=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $listva['re_time']=$correct_time;
        }
        //$listva['re_time']=$value['re_time'];
        }
        $listva['from_time']=$from_time;
        $listva['to_time']=$to_time;
        $listva['correcttime']=$correcttime;
     
     if($value['address']!=""){
      $address=$value['address'];
     }else{
      $address="";
     }
     $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->andWhere(['auto_id'=>$address])
    ->asArray()
    ->one();

    $listva['address_id'] ="";
    $listva['address'] = "";
    $listva['address_label'] = "";
    $listva['lat'] = "";
    $listva['lng'] = "";
    if(!empty($addressmaplist)){
    $listva['address_id'] = $addressmaplist['auto_id'];
    $listva['address'] = $addressmaplist['address'];
    $listva['lat'] = $addressmaplist['lat'];
    $listva['lng'] = $addressmaplist['lng'];
    $listva['address_label'] = $addressmaplist['address_label'];
    //$list['name'] = $userloginname;
    }
     if($technician_id!=""){
        if($technicianindex!=""){
        if(isset($technicianindex[$technician_id])){
        $listva['technician']=$technicianindex[$technician_id]['technician_name'];
        }
        }
        }else{
        $listva['technician']="";
        }
        $listva['created_at']=$value['created_at'];
        $list['bookinglist'][]=$listva;
        $list['status'] = "success";
        $list['message'] = "Technician List.";
     }
     }else{
      $list['status'] = "success";
    $list['message'] = "No Records Found.";
    $list['bookinglist']=array();

    }
    }else{
    $list['status'] = "error";
    $list['message'] = "Api Method Not Valid.";
    $list['bookinglist']=array();
    }
  }
  
    if($log_id!=''){
      $model_log=ApiServiceLog::find()->where(['autoid'=>$log_id])->one();
      $model_log->response_data=json_encode($list);
      $model_log->save();
    }
$response['Output'][] = $list;
return json_encode($response);
}
/*Customer Master Details*/
public function actionCustomerdetails(){
    $list = array();
    $listvadess = array();
    $listva = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','cust_id');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="customerdetails";
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
      $cust_id=$requestInput['cust_id'];

  if($apimethod=="customerdetails"){
    
     $status_module =StatusModule::find()
     ->where(['auto_id'=>$cust_id])
     ->asArray()
     ->one();
   //echo "<pre>";  print_r($status_module);die;
     $customeruniqu="";
     if(!empty($status_module)){
      $customeruniqu=$status_module['customer_unique'];
     }
     
     $customer_master=CustomerMaster::find()
     ->where(['customer_unique'=>$customeruniqu])
     ->asArray()
     ->one();
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
    $user_details=Userdetails::find()
    ->where(['id'=>'1'])
    ->asArray()
    ->one();
  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');
   }
  $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->asArray()
    ->all();

    if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    } 

   if($cust_id !=""){
    $det['customer_name']=$customer_master['customer_name'];

    
    $det['phone']=$customer_master['phone'];
    if($customer_master['email']!=''){
    $det['email']=$customer_master['email'];
    }else{
      $det['email']="";
    }
    $technician_id=$status_module['technician_id'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $phone_number=$status_module['phone_number'];
    $customer_unique=$status_module['customer_unique'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$service_type]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['admin_mobile_number']=$user_details['support_number'];
    $det['date']=$status_module['date'];
    $det['time']="";
    if($status_module['time']!=""){
   
     $time=HourMaster::find()->where(['id'=>$status_module['time']])->asArray()->one();

     if(!empty($time)){
    $det['time']=$time['correct_time'];
     }

    }
    
    $det['address']="";
    $det['remarks']="";
    if($status_module['remarks']!=""){

    $det['address']=$status_module['remarks'];
    }
    $det['unique_id']=$customer_unique;
    // $det['status']=$status_module['status'];
    if($status_module['tech_status']!=""){
    $det['status']=$status_module['tech_status'];
    }
    else
    {
    $det['status']=$status_module['status'];
    }
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
    $det['cancel_remarks']=""; 
    }
    $det['created_at']=$status_module['created_at'];
    if($status_module['re_schedule']!=""){

    $det['re_schedule']=$status_module['re_schedule'];
  }else{
    $det['re_schedule']="";
  }
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
    $det['re_date']="";
    }

    if($status_module['re_time']!=''){

       $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        //$listva['re_time']=$correct_time;
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
      }
     else{
        $det['re_time']="";
      }
    $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->andWhere(['auto_id'=>$status_module['address']])
    ->asArray()
    ->one();

    $det['address_id'] ="";
    //$det['address'] = "";
    $det['address_label'] = "";
    $det['lat'] = "";
    $det['lng'] = "";
    if(!empty($addressmaplist)){
    $det['address_id'] = $addressmaplist['auto_id'];
    $det['address'] = $addressmaplist['address'];
    $det['lat'] = $addressmaplist['lat'];
    $det['lng'] = $addressmaplist['lng'];
    $det['address_label'] = $addressmaplist['address_label'];
    //$list['name'] = $userloginname;
    }else{
    }
    if($customer_unique!=""){
        if(isset($addressmaplistindex[$customer_unique])){
        $det['addressdetails']=$addressmaplistindex[$customer_unique]['phone_no'];
        $lat=$addressmaplistindex[$customer_unique]['lat'];
        $lng=$addressmaplistindex[$customer_unique]['lng'];
        if($lat!=""){
        $listvadess['lat']=$lat; 
        $det['lat']=$lat;
        }else{
        $listvadess['lat']=""; 
        $det['lat']="";
        }
        if($lng!=""){ 
        $listvadess['lng']=$lng;
        $det['lng']=$lng;
        }else{
        $listvadess['lng']="";
        $det['lng']="";
        }
        //$det['lng']=$lng;
        }
        }else{
        $listva['addressdetails']="";
        
        $listvadess['lat']="";
        $listvadess['lng']="";
        $det['lat']="";
        $det['lng']="";
        }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    $list['addressdetails'][]=$listvadess;
  } else{
    $list['status'] = "Error";
    $list['message'] = "No Data.";
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


/*Address Mapping List*/
public function actionAddressadd(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_no','customer_unique','lng','lat','address','address_label');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="addressadd";
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
    $phone_no=$requestInput['phone_no'];
    $customer_unique=$requestInput['customer_unique'];
    $lng=$requestInput['lng'];
    $lat=$requestInput['lat'];
    $address=$requestInput['address'];
    $address_label=$requestInput['address_label'];
  if($apimethod=="addressadd"){
    $model = new  AddressMappingList();
    $model->lng=$lng;
    $model->lat=$lat;
    $model->phone_no=$phone_no;
    $model->customer_unique=$customer_unique;
    $model->address=$address;
    $model->address_label=$address_label;
    $model->status="A";
    if($model->save()){
    }else{
    echo "<pre>";print_r($model->getErrors());die;
    }
    $list['status'] = "success";
    $list['message'] = "Address created successfully";
    $list['id'] = $model->auto_id;
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
  /*addressListdetails*/

public function actionAddressdetails(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','phone_no','customer_unique');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="addressdetails";
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
      $phone_no=$requestInput['phone_no'];
      $customer_unique=$requestInput['customer_unique'];

  if($apimethod=="addressdetails"){
     $AddressMappingList=AddressMappingList::find()
     ->where(['customer_unique'=>$customer_unique])
     ->andWhere(['status'=>"A"])
     ->asArray()
     ->all();
    // print_r($AddressMappingList);die;
   if(!empty($AddressMappingList)){
    foreach ($AddressMappingList as $key => $value) {
    $det['id']=$value['auto_id'];
    $det['phone_no']=$value['phone_no'];
    $det['unique_id']=$value['customer_unique'];
    $det['lat']=$value['lat'];
    $det['lng']=$value['lng'];
    $det['address_label']=$value['address_label'];
    $det['address']=$value['address'];
    $det['status']=$value['status'];
    $det['created_at']=$value['created_at'];
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    } 
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

    /*addressListdetails*/

public function actionQuickservice(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="quickservice";
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
     

  if($apimethod=="quickservice"){
     $AddressMappingList=QuickService::find()
     ->asArray()
     ->all();
   if(!empty($AddressMappingList)){
    foreach ($AddressMappingList as $key => $value) {
    $catename="";
    if($value['category_id']!=""){
    $categorylist=CategoryManagement::find()
    ->select('category_name')
    ->where(['auto_id'=>$value['category_id']])
    ->asArray()
    ->one();
     if(!empty($categorylist)){
      $catename=$categorylist['category_name'];
     }
    }

    $brandname="";
    if($value['brand_id']!=""){
    $BrandMapping=BrandMapping::find()
    ->select('brands')
    ->where(['autoid'=>$value['brand_id']])
    ->asArray()
    ->one();
    if(!empty($BrandMapping)){
    $brandname=$BrandMapping['brands'];
     }
    }

    $servicename="";
    if($value['service_id']!=""){
    $ServiceMapping=ServiceModule::find()
    ->select('service_type')
    ->where(['auto_id'=>$value['service_id']])
    ->asArray()
    ->one();
    if(!empty($ServiceMapping)){
    $servicename=$ServiceMapping['service_type'];
     }
    }
    $det['quick_id']=$value['id'];
    $det['category_id']=$value['category_id'];
    $det['category_name']=$catename;
    $det['brand_id']=$value['brand_id'];
    $det['brand_name']=$brandname;
    $base=Url::base(true);
                               
    if($value['image_new']!=''){
    $det['quick_image']=$base."/backend/web/".$value['image_new'];
    }else{
    $det['quick_image']="";
    }
    $det['service_id']=$value['service_id'];
    $det['service_name']=$servicename;
    $det['label']=$value['label'];
    $det['description']=$value['description'];
    //$det['quick_image']=$value['quick_image'];
    $det['created_at']=$value['created_at'];
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['quickservice']=$det1;
    } 
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

/*Address Edit*/
  public function actionAddressedit(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','address_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="addressedit";
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
  $address_id=$requestInput['address_id'];
  if($apimethod=="addressedit"){
     $dta=AddressMappingList::updateAll(['status'=>'D'],['auto_id'=>$address_id]);
     if($dta==1){
     $list['status']='success';
     $list['message']='Address Deleted Successfully';
    }else{
     $list['status']='error';
     $list['message']='Address Not Deleted';
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

  /*Tech Logout*/
  public function actionTechlogout(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','tech_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="techlogout";
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
  $tech_id=$requestInput['tech_id'];
  if($apimethod=="logout"){
    if($tech_id!=""){

     $Techvariable=TechnicianMaster::find()->where(['auto_id'=>$tech_id])->one();

     if(!empty($Techvariable)){
     $dta=TechnicianMaster::updateAll(['logout_status'=>'I'],['auto_id'=>$tech_id]);
     if($dta==1){
     $list['status']='success';
     $list['message']='Technician Signout Successfully';
    }else{
     $list['status']='error';
     $list['message']='Technician Signout Not Working';
     }
     }else{
      $list['status']='error';
     $list['message']='Invalid Technician ID';
     }
   }else{
   $list['status']='error';
     $list['message']='Technician ID Mandatory';

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

  

  /******** pagination start *********/   
  
           /********** pagination end  **********/

  public function actionTechhistory(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','tech_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="techhistory";
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
  $tech_id=$requestInput['tech_id'];
  if($apimethod=="techhistory"){
  	//die;
     $data=Url::base(true);
     $status_module =StatusModule::find()
     ->where(['technician_id'=>$tech_id])
     ->andWhere(['IN','status',array('Cancelled','Completed')])
     ->orderBy(['updated_at'=>SORT_DESC])
    // ->limit($start)
     ->asArray()
     ->all();

     if(isset($requestInput['page'])){
          //  print_r("expression");die;
    if($requestInput['page']=="all") {
      $page = $requestInput['page'];
           
   $status_module =StatusModule::find()
     ->where(['technician_id'=>$tech_id])
     ->andWhere(['IN','status',array('Cancelled','Completed')])
     ->orderBy(['updated_at'=>SORT_DESC])
    // ->limit($start)
     ->asArray()
     ->all();
        }
    else{
    if(isset($requestInput['page'])){
    $page = $requestInput['page'];
    if (!is_numeric($page)) {
    $page = 1;
    }
    $start = $page * $limit; 
    $status_module =StatusModule::find()
     ->where(['technician_id'=>$tech_id])
     ->andWhere(['IN','status',array('Cancelled','Completed')])
     ->orderBy(['updated_at'=>SORT_DESC])
     ->limit($start)
     ->asArray()
     ->all();
            }
        }
        }
     

     //print_r($status_module);die;

      $customer_master=CustomerMaster::find()
     ->asArray()
     ->all();

    $customer_masterindex=ArrayHelper::index($customer_master,'phone');
    //echo "<pre>";  print_r($customer_masterindex);die;

    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }


    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   
   if(!empty($status_module)){
    foreach ($status_module as $key => $value) {

         $from_time="";
         $to_time="";
         $correcttime="";
        if($value['slot_time']!=""){
         $slottime=HourMaster::find()
      //  ->select('from_time','to_time','id')
        ->where(['id'=>$value['slot_time']])
        ->asArray()
        ->one();
        
        if(!empty($slottime)){
          $from_time=$slottime['from_time'];
          $to_time=$slottime['to_time'];
          $correcttime=$from_time.' - '.$to_time;
        } 
        }

      $product_id=$value['product_id'];
     $det['service_id']=$value['auto_id'];

      $det['customer_name']="";
    if(isset($customer_masterindex[$value['phone_number']])){
      $det['customer_name']=ucfirst($customer_masterindex[$value['phone_number']]['customer_name']);
    }
    $det['email']="";
    if(isset($customer_masterindex[$value['phone_number']])){
      $det['email']=ucfirst($customer_masterindex[$value['phone_number']]['email']);
    }

    $category_image="";
    if(isset($categorylistindex[$product_id])){
    $category_image=$categorylistindex[$product_id]['category_image'];
    }

    // $det['customer_name']=$customer_master['customer_name'];
    $det['phone']=$value['phone_number'];
    
    $technician_id=$value['technician_id'];

     $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->andWhere(['auto_id'=>$value['address']])
    ->asArray()
    ->one();
    $det['address_id'] ="";
    $det['address'] = "";
    $det['address_label'] = "";
    $det['lat'] = "";
    $det['lng'] = "";
    if(!empty($addressmaplist)){
    $det['address_id'] = $addressmaplist['auto_id'];
    $det['address'] = $addressmaplist['address'];
    $det['lat'] = $addressmaplist['lat'];
    $det['lng'] = $addressmaplist['lng'];
    $det['address_label'] = $addressmaplist['address_label'];
    //$list['name'] = $userloginname;
    }
    //$det['address']=$value['address'];
    $brand_id=$value['brand_id'];
    $product_id=$value['product_id'];
    $phone_number=$value['phone_number'];
    $service_type=$value['service_type'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$service_type]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['image_url']=$data."/backend/web/".$category_image;
    $det['date']=$value['date'];
    $det['time']=date('h:i A',strtotime($value['time']));
    $det['remarks']=$value['remarks'];
    $det['unique_id']=$value['customer_unique'];
    $det['status']=$value['status'];
    $det['amount']=$value['amount'];
    if($value['complete_remarks']!=''){
    $det['complete_remarks']=$value['complete_remarks'];
    }else{
     $det['complete_remarks']=""; 
    }
    if($value['cancel_remarks']!=''){
    $det['cancel_remarks']=$value['cancel_remarks'];
    }else{
     $det['cancel_remarks']=""; 
    }
    if($value['re_schedule']!=''){
    $det['re_schedule']=$value['re_schedule'];
    }else{
     $det['re_schedule']=""; 
    }
    $det['created_at']=$value['created_at'];
    
    if($value['re_date']!=''){
    $det['re_date']=$value['re_date'];
    }else{
      $det['re_date']="";
    }
    if($value['re_time']!=''){
      $slottime22=HourMaster::find()
        ->where(['id'=>$value['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
    }else{
      $det['re_time']="";
    }
    $det['from_time']=$from_time;
    $det['to_time']=$to_time;
    $det['correcttime']=$correcttime;
    
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['completed_list']=$det1;
  }
}
else{
	$list['status']='error';
     $list['message']='no data';
     $list['completed_list']=array();
}
}else{
     $list['status']='error';
     $list['message']='no data';
     $list['completed_list']=array();
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

/*Techhistory View*/

  public function actionTechhistoryview(){
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','techview_id');

    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="techhistoryview";
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
  $techview_id=$requestInput['techview_id'];
  if($apimethod=="techhistoryview"){
     $status_module =StatusModule::find()
     ->where(['technician_id'=>$techview_id])
     ->andWhere(['IN','status',array('Cancelled','Completed')])
     ->asArray()
     ->one();
//echo "<pre>";print_r($status_module);die;
      $customer_master=CustomerMaster::find()
     ->asArray()
     ->all();

    $customer_masterindex=ArrayHelper::index($customer_master,'phone');
    //echo "<pre>";  print_r($customer_masterindex);die;

    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();

    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();

    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }


    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   if($status_module !=''){
      $det['id']=$status_module['auto_id'];
      $det['customer_name']="";
    if(isset($customer_masterindex[$status_module['phone_number']])){
      $det['customer_name']=ucfirst($customer_masterindex[$status_module['phone_number']]['customer_name']);
    }
    $det['email']="";
    if(isset($customer_masterindex[$status_module['phone_number']])){
      $det['email']=ucfirst($customer_masterindex[$status_module['phone_number']]['email']);
    }
    // $det['customer_name']=$customer_master['customer_name'];
    $det['phone']=$status_module['phone_number'];
    $technician_id=$status_module['technician_id'];
    $det['address']=$status_module['address'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['date']=$status_module['date'];
    $det['time']=$status_module['time'];
    $det['remarks']=$status_module['remarks'];
    $det['unique_id']=$status_module['customer_unique'];
    $det['status']=$status_module['status'];
    $det['amount']=$status_module['amount'];
    $det['complete_remarks']=$status_module['complete_remarks'];
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
     $det['cancel_remarks']=""; 
    }
    $det['created_at']=$status_module['created_at'];
    $det['re_schedule']=$status_module['re_schedule'];
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
      $det['re_date']="";
    }
    if($status_module['re_time']!=''){

      $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }

    }else{
      $det['re_time']="";
    }
    
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['completed_list']=$det1;
}else{
     $list['status']='error';
     $list['message']='no data';
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
/*Technician Pickup*/
  public function actionTechnicianpickup(){
    //print_r("expression");die;
    $list = array();
    $postd=(Yii::$app ->request ->rawBody);
    $requestInput = json_decode($postd,true); 
    $list['status'] = 'error';
    $list['message'] = 'Invalid Apimethod';
    $field_check=array('apimethod','service_id','status');
    $model_log=new ApiServiceLog();
    $model_log->request_data=$postd;
    $model_log->event_key="technicianpickup";
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
  $service_id=$requestInput['service_id'];
  $status=$requestInput['status'];
  if($apimethod=="technicianpickup"){

    if($status=="picked"){
    if($service_id!=""){ 
     $tech_pickup=StatusModule::updateAll(['status'=>'Picked'],['auto_id'=>$service_id]);

     $list['status']='error';
     $list['status_type']='';
     $list['message']='Error in Data';
     
     $det=array();
     $status_module =StatusModule::find()
     ->where(['auto_id'=>$service_id])
     ->asArray()
     ->one();

     $customeruniqu="";
     if(!empty($status_module)){
      $customeruniqu=$status_module['customer_unique'];
     }

     $technician_idlog="";
     if(!empty($status_module)){
      $technician_idlog=$status_module['technician_id'];
     }



  $data_array=array('customer_unique'=>$customeruniqu,'service_id'=>$service_id,'platform'=>'mobile','message'=>"Picked",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>$technician_idlog,'last_technician'=>$technician_idlog,'completed_date'=>"");
  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);

     $this->send_notification($customeruniqu,$status,$service_id);
     
     $customer_master=CustomerMaster::find()
     ->where(['customer_unique'=>$customeruniqu])
     ->asArray()
     ->one();
     // echo "<pre>";print_r($customer_master);
     // echo "<pre>";print_r($status_module);die;
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   $user_details=Userdetails::find()
    ->where(['id'=>'1'])
    ->asArray()
    ->one();


  $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->asArray()
    ->all();

    if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    } 

   if($service_id !=""){
    $det['customer_name']=$customer_master['customer_name'];
    $det['address']=$status_module['remarks'];
    $det['phone']=$customer_master['phone'];
    if($customer_master['email']!=''){
    $det['email']=$customer_master['email'];
    }else{
    $det['email']="";
    }
    $technician_id=$status_module['technician_id'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $phone_number=$status_module['phone_number'];
    $customer_unique=$status_module['customer_unique'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['date']=$status_module['date'];
    $det['time']=date('h:i A',strtotime($status_module['time']));
    $det['remarks']=$status_module['remarks'];
    $det['unique_id']=$customer_unique;
    $det['status']=$status_module['status'];
    $det['admin_mobile_number']=$user_details['support_number'];
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
    $det['cancel_remarks']=""; 
    }
    $det['created_at']=$status_module['created_at'];
    $det['re_schedule']=$status_module['re_schedule'];
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
    $det['re_date']="";
    }
    if($status_module['re_time']!=''){

       $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
  //  $det['re_time']=date('h:i A',strtotime($status_module['re_time']));
    }else{
      $det['re_time']="";
    }
    $listvadess=array();
       if($customer_unique!=""){
        if(isset($addressmaplistindex[$customer_unique])){
        $det['addressdetails']=$addressmaplistindex[$customer_unique]['phone_no'];
        $lat=$addressmaplistindex[$customer_unique]['lat'];
        $lng=$addressmaplistindex[$customer_unique]['lng'];
        $listvadess['lat']=$lat;
        $listvadess['lng']=$lng;
        $det['lat']=$lat;
        $det['lng']=$lng;
        }
        }else{
        $listva['addressdetails']="";
        $listvadess['lat']="";
        $listvadess['lng']="";
        $det['lat']="";
        $det['lng']="";
        }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    $list['addressdetails'][]=$listvadess;
  } else{
    $list['status'] = "Error";
    $list['message'] = "No Data.";
    }

     $list['status']='success';
     $list['status_type']='Picked';
     $list['message']='Technician Picked Successfully'; 
     
    }else{
     $list['status']='error';
     $list['message']='Service id mandatory';
     $list['status_type']="";
    }

    }else if($status=="reached"){

    if($service_id!=""){ 
     $tech_pickup=StatusModule::updateAll(['status'=>'Picked','tech_status'=>'Reached','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$service_id]);
     $list['status']='error';
     $list['status_type']='';
     $list['message']='Error in Data';
     
     $det=array();
     $status_module =StatusModule::find()
     ->where(['auto_id'=>$service_id])
     ->asArray()
     ->one();
     $customeruniqu="";
     if(!empty($status_module)){
      $customeruniqu=$status_module['customer_unique'];
     }

     $data_array=array('customer_unique'=>$customeruniqu,'service_id'=>$service_id,'platform'=>'mobile','message'=>"Reached",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
     
     $customer_master=CustomerMaster::find()
     ->where(['customer_unique'=>$customeruniqu])
     ->asArray()
     ->one();

     $this->send_notification($customeruniqu,$status,$service_id);
     // echo "<pre>";print_r($customer_master);
     // echo "<pre>";print_r($status_module);die;
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();
    $user_details=Userdetails::find()
    ->where(['id'=>'1'])
    ->asArray()
    ->one();
    

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   
  $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->asArray()
    ->all();

    if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    } 

   if($service_id !=""){
    $det['customer_name']=$customer_master['customer_name'];
    $det['address']=$status_module['remarks'];
    $det['phone']=$customer_master['phone'];
    if($customer_master['email']!=''){
    $det['email']=$customer_master['email'];
    }else{
    $det['email']="";
    }
    $technician_id=$status_module['technician_id'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $phone_number=$status_module['phone_number'];
    $customer_unique=$status_module['customer_unique'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['date']=$status_module['date'];
    $det['time']=date('h:i A',strtotime($status_module['time']));
    $det['remarks']=$status_module['remarks'];
    $det['unique_id']=$customer_unique;
    $det['status']="Picked";
    if($status_module['tech_status']=="Reached"){
    if($status_module['status']=="Picked"){
    $det['status']="Reached";
    }
    }
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
    $det['cancel_remarks']=""; 
    }
    $det['admin_mobile_number']=$user_details['support_number'];
    $det['created_at']=$status_module['created_at'];
    $det['re_schedule']=$status_module['re_schedule'];
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
    $det['re_date']="";
    }
    if($status_module['re_time']!=''){
       $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
   // $det['re_time']=date('h:i A',strtotime($status_module['re_time']));
    }else{
      $det['re_time']="";
    }
    $listvadess=array();
       if($customer_unique!=""){
        if(isset($addressmaplistindex[$customer_unique])){
        $det['addressdetails']=$addressmaplistindex[$customer_unique]['phone_no'];
        $lat=$addressmaplistindex[$customer_unique]['lat'];
        $lng=$addressmaplistindex[$customer_unique]['lng'];
        $listvadess['lat']=$lat;
        $listvadess['lng']=$lng;
        $det['lat']=$lat;
        $det['lng']=$lng;
        }
        }else{
        $listva['addressdetails']="";
        $listvadess['lat']="";
        $listvadess['lng']="";
        $det['lat']="";
        $det['lng']="";
        }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    $list['addressdetails'][]=$listvadess;
  } else{
    $list['status'] = "Error";
    $list['message'] = "No Data.";
    }

     $list['status']='success';
     $list['status_type']='Reached';
     $list['message']='Technician Reached Your Locations'; 
     
    }else{
     $list['status']='error';
     $list['message']='Service id mandatory';
     $list['status_type']="";
    }
    }
    else if($status=="start"){
    if($service_id!=""){ 
     $tech_pickup=StatusModule::updateAll(['status'=>'Picked','tech_status'=>'Start','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$service_id]);
     $list['status']='error';
     $list['status_type']='';
     $list['message']='Error in Data';
     
     $det=array();
     $status_module =StatusModule::find()
     ->where(['auto_id'=>$service_id])
     ->asArray()
     ->one();
     $customeruniqu="";
     if(!empty($status_module)){
      $customeruniqu=$status_module['customer_unique'];
     }
     $data_array=array('customer_unique'=>$customeruniqu,'service_id'=>$service_id,'platform'=>'mobile','message'=>"Start",'lat_scedule_date'=>"",'rescedule_date'=>"",'curr_technician'=>"",'last_technician'=>"",'completed_date'=>"");

  $activity_log_insert=new UserActivityLog();
  $activity_log_insert->UserLog($data_array);
     
     $customer_master=CustomerMaster::find()
     ->where(['customer_unique'=>$customeruniqu])
     ->asArray()
     ->one();

    $user_details=Userdetails::find()
    ->where(['id'=>'1'])
    ->asArray()
    ->one();

     $this->send_notification($customeruniqu,$status,$service_id);
     // echo "<pre>";print_r($customer_master);
     // echo "<pre>";print_r($status_module);die;
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   
  $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->asArray()
    ->all();

    if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    } 

   if($service_id !=""){
    $det['customer_name']=$customer_master['customer_name'];
    $det['address']=$status_module['remarks'];
    $det['phone']=$customer_master['phone'];
    if($customer_master['email']!=''){
    $det['email']=$customer_master['email'];
    }else{
    $det['email']="";
    }
    $technician_id=$status_module['technician_id'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $phone_number=$status_module['phone_number'];
    $customer_unique=$status_module['customer_unique'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['date']=$status_module['date'];
    $det['time']=date('h:i A',strtotime($status_module['time']));
    $det['remarks']=$status_module['remarks'];
    $det['unique_id']=$customer_unique;
    $det['status']="Picked";
    if($status_module['tech_status']=="Start"){
    if($status_module['status']=="Picked"){
    $det['status']="Start";
    }
    }
    $det['admin_mobile_number']=$user_details['support_number'];
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
    $det['cancel_remarks']=""; 
    }
    $det['created_at']=$status_module['created_at'];
    $det['re_schedule']=$status_module['re_schedule'];
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
    $det['re_date']="";
    }
    if($status_module['re_time']!=''){
       $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
   // $det['re_time']=date('h:i A',strtotime($status_module['re_time']));
    }else{
      $det['re_time']="";
    }
    $listvadess=array();
       if($customer_unique!=""){
        if(isset($addressmaplistindex[$customer_unique])){
        $det['addressdetails']=$addressmaplistindex[$customer_unique]['phone_no'];
        $lat=$addressmaplistindex[$customer_unique]['lat'];
        $lng=$addressmaplistindex[$customer_unique]['lng'];
        $listvadess['lat']=$lat;
        $listvadess['lng']=$lng;
        $det['lat']=$lat;
        $det['lng']=$lng;
        }
        }else{
        $listva['addressdetails']="";
        $listvadess['lat']="";
        $listvadess['lng']="";
        $det['lat']="";
        $det['lng']="";
        }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    $list['addressdetails'][]=$listvadess;
  } else{
    $list['status'] = "Error";
    $list['message'] = "No Data.";
    }

     $list['status']='success';
     $list['status_type']='Reached';
     $list['message']='Technician Reached Your Locations';
    }else{
     $list['status']='error';
     $list['message']='Service id mandatory';
     $list['status_type']="";
    }

    }
    else if($status=="complete1"){
    if($service_id!=""){ 
     $tech_pickup=StatusModule::updateAll(['status'=>'Completed','tech_status'=>'Completed','updated_at'=>date("Y-m-d H:i:s")],['auto_id'=>$service_id]);
     $list['status']='error';
     $list['status_type']='';
     $list['message']='Error in Data';
     $det=array();
     $status_module =StatusModule::find()
     ->where(['auto_id'=>$service_id])
     ->asArray()
     ->one();
     $customeruniqu="";
     if(!empty($status_module)){
      $customeruniqu=$status_module['customer_unique'];
     }
     
     $customer_master=CustomerMaster::find()
     ->where(['customer_unique'=>$customeruniqu])
     ->asArray()
     ->one();
     // echo "<pre>";print_r($customer_master);
     // echo "<pre>";print_r($status_module);die;
    $categorylist=CategoryManagement::find()
    ->asArray()
    ->all();
    $BrandMapping=BrandMapping::find()
    ->asArray()
    ->all();
    $technician=TechnicianMaster::find()
    ->asArray()
    ->all();

  if(!empty($technician)){
    $technicianindex=ArrayHelper::index($technician,'auto_id');
  }

  if(!empty($BrandMapping)){
    $brandmappingindex=ArrayHelper::index($BrandMapping,'autoid');
  }
  if(!empty($categorylist)){  
  $categorylistindex=ArrayHelper::index($categorylist,'auto_id');
  }

    $servicelist=ServiceModule::find()
    ->asArray()
    ->all();
   
   if(!empty($servicelist)){
    $servicelistindex=ArrayHelper::index($servicelist,'auto_id');

   } 
   
  $addressmaplist=AddressMappingList::find()
    ->where(['status'=>'A'])
    ->asArray()
    ->all();

    if(!empty($addressmaplist)){
    $addressmaplistindex=ArrayHelper::index($addressmaplist,'customer_unique');
    } 

   if($service_id !=""){
    $det['customer_name']=$customer_master['customer_name'];
    $det['address']=$status_module['remarks'];
    $det['phone']=$customer_master['phone'];
    if($customer_master['email']!=''){
    $det['email']=$customer_master['email'];
    }else{
    $det['email']="";
    }
    $technician_id=$status_module['technician_id'];
    $brand_id=$status_module['brand_id'];
    $product_id=$status_module['product_id'];
    $service_type=$status_module['service_type'];
    $phone_number=$status_module['phone_number'];
    $customer_unique=$status_module['customer_unique'];
    $categoryname="";
    if(isset($categorylistindex[$product_id])){
      $categoryname=ucfirst($categorylistindex[$product_id]['category_name']);
    }
    $servicenames="";
    if(isset($servicelistindex[$service_type])){
      $servicenames=ucfirst($servicelistindex[$product_id]['service_type']);
    }
    $brandnames="";
    if(isset($brandmappingindex[$brand_id])){
      $brandnames=ucfirst($brandmappingindex[$brand_id]['brands']);
    }
    $technician_name="";
    if(isset($technicianindex[$technician_id])){
       $technician_name=ucfirst($technicianindex[$technician_id]['technician_name']);
    }
    $det['category_name']=$categoryname;
    $det['service_type']=$servicenames;
    $det['brand_name']=$brandnames;
    $det['technician_name']=$technician_name;
    $det['date']=$status_module['date'];
    $det['time']=date('h:i A',strtotime($status_module['time']));
    $det['remarks']=$status_module['remarks'];
    $det['unique_id']=$customer_unique;
    $det['status']="Completed";
   
    if($status_module['cancel_remarks']!=''){
    $det['cancel_remarks']=$status_module['cancel_remarks'];
    }else{
    $det['cancel_remarks']=""; 
    }
    $det['created_at']=$status_module['created_at'];
    $det['re_schedule']=$status_module['re_schedule'];
    if($status_module['re_date']!=''){
    $det['re_date']=$status_module['re_date'];
    }else{
    $det['re_date']="";
    }
    if($status_module['re_time']!=''){
       $slottime22=HourMaster::find()
        ->where(['id'=>$status_module['re_time']])
        ->asArray()
        ->one();
        if(!empty($slottime22)){
        $correct_time=$slottime22['correct_time'];
        $det['re_time']=$correct_time;
        }else{
        $det['re_time']="";
        }
   // $det['re_time']=date('h:i A',strtotime($status_module['re_time']));
    }else{
      $det['re_time']="";
    }
    $listvadess=array();
       if($customer_unique!=""){
        if(isset($addressmaplistindex[$customer_unique])){
        $det['addressdetails']=$addressmaplistindex[$customer_unique]['phone_no'];
        $lat=$addressmaplistindex[$customer_unique]['lat'];
        $lng=$addressmaplistindex[$customer_unique]['lng'];
        $listvadess['lat']=$lat;
        $listvadess['lng']=$lng;
        }
        }else{
        $listva['addressdetails']="";
        $listvadess['lat']="";
        $listvadess['lng']="";
        }
    $det1[]=$det;
    $list['status']='success';
    $list['message']='success';
    $list['profile']=$det1;
    $list['addressdetails'][]=$listvadess;
  } else{
    $list['status'] = "Error";
    $list['message'] = "No Data.";
    }

     $list['status']='success';
     $list['status_type']='Completed';
     $list['message']='Service Completed'; 
     
    }else{
     $list['status']='error';
     $list['message']='Service id mandatory';
     $list['status_type']="";
    }

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
