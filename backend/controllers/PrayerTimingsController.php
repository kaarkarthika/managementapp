<?php

namespace backend\controllers;

use Yii;
use backend\models\PrayerTimings;
use backend\models\PrayerTimingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * PrayerTimingsController implements the CRUD actions for PrayerTimings model.
 */
class PrayerTimingsController extends Controller
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
     * Lists all PrayerTimings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrayerTimingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PrayerTimings model.
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
     * Creates a new PrayerTimings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PrayerTimings();

        if ($model->load(Yii::$app->request->post())) {
            $prayTy = $_POST['PrayerTimings']['prayerType'];
            // echo "<prE>";print_r($_POST);die;
            if($prayTy=='daily'){
                foreach ($_POST['slot1StartTime'] as $key => $oneTime) {
                    $day = $key+1;
                    $models = PrayerTimings::find()->where(['day'=>$day])->andWhere(['prayerType'=>$prayTy])->one();
                    if(!$models){
                        // echo "string";die;
                        $models = new PrayerTimings();
                        $models->createdAt = date('Y-m-d H:i:s');
                    }
                    $models->prayerType = $prayTy;
                    $models->eventName = 'Daily';
                    $models->day = $day;
                    $models->slotNo = 1;
                    $models->startTime = $_POST['slot1StartTime'][$key];
                    $models->endTime = $_POST['slot1EndTime'][$key];
                    $models->slot2StartDate = $_POST['slot2StartTime'][$key];
                    $models->slot2EndDate = $_POST['slot2EndTime'][$key];                
                    $models->ipAddress = $_SERVER['REMOTE_ADDR'];
                    $models->updatedAt = date('Y-m-d H:i:s');
                    if(!$models->save()){
                        echo "<pre>";print_r($models->getErrors());die;
                    }                    
                }

            }else{
                if($prayTy=='event'){                    
                    $model->slotNo = rand(100,1000000);
                    $model->eventName = $_POST['eventName'];
                    $model->eventDate = date('Y-m-d',strtotime($_POST['eventDate']));
                    // $model->startDate = date('Y-m-d',strtotime($_POST['eventStartDate']));
                    // $model->endDate = date('Y-m-d',strtotime($_POST['eventEndDate']));
                    $model->startTime = $_POST['eventStartDate'];
                    $model->endTime = $_POST['eventEndDate'];
                }elseif ($prayTy=='friday') {
                    $model = PrayerTimings::find()->where(['prayerType'=>$prayTy])->one();
                    if(!$model){
                        $model = new PrayerTimings();
                    }
                    $model->eventName = 'Firday';
                    $model->slotNo = 2;
                    $model->startTime = $_POST['slot1StartTime'];
                    $model->endTime = $_POST['slot1EndTime'];
                    $model->slot2StartDate = $_POST['slot2StartTime'];
                    $model->slot2EndDate = $_POST['slot2EndTime'];
                }
                $model->prayerType = $prayTy;
                $model->ipAddress = $_SERVER['REMOTE_ADDR'];
                $model->createdAt = date('Y-m-d H:i:s');
                $model->updatedAt = date('Y-m-d H:i:s');
                if(!$model->save()){
                    echo "<pre>";print_r($model->getErrors());die;
                }                
                
            }
            return $this->redirect(['index']);
        }
        $dataContent = "";
        return $this->render('create', [
            'model' => $model,
            'dataContent' => $dataContent,
        ]);
    }

    /**
     * Updates an existing PrayerTimings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $prayTy = $_POST['PrayerTimings']['prayerType'];
            if($prayTy=='daily'){
                foreach ($_POST['slot1StartTime'] as $key => $oneTime) {
            // echo "<prE>";print_r($_POST);die;
                    $day = $key+1;
                    $models = PrayerTimings::find()->where(['day'=>$day])->andWhere(['prayerType'=>$prayTy])->one();
                    if(!$models){
                        // echo "string";die;
                        $models = new PrayerTimings();
                        $models->createdAt = date('Y-m-d H:i:s');
                    }
                    $models->prayerType = $prayTy;
                    $models->eventName = 'Daily';
                    $models->day = $day;
                    $models->slotNo = 1;
                    $models->startTime = $_POST['slot1StartTime'][$key];
                    $models->endTime = $_POST['slot1EndTime'][$key];
                    $models->slot2StartDate = $_POST['slot2StartTime'][$key];
                    $models->slot2EndDate = $_POST['slot2EndTime'][$key];                
                    $models->ipAddress = $_SERVER['REMOTE_ADDR'];
                    $models->updatedAt = date('Y-m-d H:i:s');
                    if(!$models->save()){
                        echo "<pre>";print_r($models->getErrors());die;
                    }                    
                }

            }else{
                if($prayTy=='event'){  
                   $model->slotNo = rand(100,1000000);
                    $model->eventName = $_POST['eventName'];
                    $model->eventDate = date('Y-m-d',strtotime($_POST['eventDate']));
                    // $model->startDate = date('Y-m-d',strtotime($_POST['eventStartDate']));
                    // $model->endDate = date('Y-m-d',strtotime($_POST['eventEndDate']));
                    $model->startTime = $_POST['eventStartDate'];
                    $model->endTime = $_POST['eventEndDate'];
                }elseif ($prayTy=='friday') {
                    $model = PrayerTimings::find()->where(['prayerType'=>$prayTy])->one();
                    if(!$model){
                        $model = new PrayerTimings();
                    }
                    $model->eventName = 'Firday';
                    $model->slotNo = 2;
                    $model->startTime = $_POST['slot1StartTime'];
                    $model->endTime = $_POST['slot1EndTime'];
                    $model->slot2StartDate = $_POST['slot2StartTime'];
                    $model->slot2EndDate = $_POST['slot2EndTime'];
                }
                $model->prayerType = $prayTy;
                $model->ipAddress = $_SERVER['REMOTE_ADDR'];
                $model->createdAt = date('Y-m-d H:i:s');
                $model->updatedAt = date('Y-m-d H:i:s');
                if(!$model->save()){
                    echo "<pre>";print_r($model->getErrors());die;
                }                
                
            }
            return $this->redirect(['index']);
        }

        $ty = $model->prayerType;
        $dataId = $id;
        $dataContent = $this->actionPrayType($ty,$dataId);
        return $this->render('update', [
            'model' => $model,
            'dataContent' => $dataContent,
        ]);
    }

    /**
     * Deletes an existing PrayerTimings model.
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
     * Finds the PrayerTimings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PrayerTimings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrayerTimings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionPrayType($id='',$dataId="")
    {
    
        
        
        $content = "";
        if($id=='friday'){
            $pryData = PrayerTimings::find()->where(['autoid'=>$dataId])->asArray()->one();
            if(empty($pryData)){
                // echo "<pre>";print_r($pryData);die;
                $pryData = PrayerTimings::find()->where(['prayerType'=>$id])->asArray()->one();
            }
            $slot1st = $slot1end = $slot2st = $slot2end = "";
            if(!empty($pryData)){
                $slot1st = $pryData['startTime'];
                $slot1end = $pryData['endTime'];
                $slot2st = $pryData['slot2StartDate'];
                $slot2end = $pryData['slot2EndDate'];
            }
            $content .= '
                <div class="table-responsive-xl">
                    <table class="table table-bordered table-striped manage">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan = "5" style="text-align:center;">Friday Prayer</th>
                            </tr>
                        </thead>
                        <tbody class="fields process" id="DymentionTableBody">
                            <tr>
                                <td><b>Slot 1</b></td>
                                <td>Start Time</td>
                                <td><input type="text" class="form-control" name="slot1StartTime" id="slot1StartTime" value="'.$slot1st.'" /></td>
                                <td>End Time</td>
                                <td><input type="text" class="form-control" name="slot1EndTime" id="slot1EndTime"  value="'.$slot1end.'"/></td>
                            </tr>
                            <tr>
                                <td><b>Slot 2</b></td>
                                <td>Start Time</td>
                                <td><input type="text" class="form-control" name="slot2StartTime" id="slot2StartTime"  value="'.$slot2st.'"/></td>
                                <td>End Time</td>
                                <td><input type="text" class="form-control" name="slot2EndTime" id="slot2EndTime"  value="'.$slot2end.'"/></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            ';
        }elseif ($id=='daily') {

            $pryData = PrayerTimings::find()->where(['slotNo'=>1])->asArray()->all();
            $pryDataAr = ArrayHelper::index($pryData,'day');
            // echo "<prE>";print_r($pryDataAr);die;
            $content .= '
                <div class="table-responsive-xl">
                    <table class="table table-bordered table-striped manage" >
                        <thead class="thead-dark">
                            <tr>
                                <th colspan = "5" style="text-align:center;">Daily Prayer</th>
                            </tr>
                        </thead>
                        <tbody class="fields process" id="DymentionTableBody">
                        ';

                for ($i=1; $i <= 5 ; $i++) { 

                    $slot1st = $slot1end = $slot2st = $slot2end = "";
                    if(!empty($pryDataAr)){
                        if(array_key_exists($i, $pryDataAr)){
                            $slot1st = $pryDataAr[$i]['startTime'];
                            $slot1end = $pryDataAr[$i]['endTime'];
                            $slot2st = $pryDataAr[$i]['slot2StartDate'];
                            $slot2end = $pryDataAr[$i]['slot2EndDate'];                            
                        }
                    }

                    $content .= '
                        <tr style="background-color:#E7E9EE;">
                            <td colspan="5"> Day '.$i.'</td>
                        </tr>
                        <tr>
                            <td><b>Slot 1</b></td>
                            <td>Start Time</td>
                            <td><input type="text" class="form-control" name="slot1StartTime[]" id="slot1StartTime" value="'.$slot1st.'"/></td>
                            <td>End Time</td>
                            <td><input type="text" class="form-control" name="slot1EndTime[]" id="slot1EndTime" value="'.$slot1end.'"/></td>
                        </tr>
                        <tr>
                            <td><b>Slot 2</b></td>
                            <td>Start Time</td>
                            <td><input type="text" class="form-control" name="slot2StartTime[]" id="slot2StartTime" value="'.$slot2st.'"/></td>
                            <td>End Time</td>
                            <td><input type="text" class="form-control" name="slot2EndTime[]" id="slot2EndTime" value="'.$slot2end.'"/></td>
                        </tr>
                    ';                    
                }

                $content .= ' </tbody>
                    </table>
                </div>
            ';
        }else if($id=='event'){
            $pryData = PrayerTimings::find()->where(['autoid'=>$dataId])->asArray()->one();
            // echo "<prE>";print_r($pryData);die;
            $eventEndDate = $eventStDate = $eventName = $eventDate = "";
            if(!empty($pryData)){
                $eventName = $pryData['eventName'];
                $eventStDate = $pryData['startTime'];
                $eventEndDate = $pryData['endTime'];
                $eventDate = date('d-m-Y',strtotime($pryData['eventDate']));
                if(strpos($eventDate, '1970') || strpos($eventDate, '0000')){
                    $eventDate = "-";
                }
            }
            $content .= '
                <div class="table-responsive-xl">
                    <table class="table table-bordered table-striped manage" >
                        <thead class="thead-dark">
                            <tr>
                                <th colspan = "6" style="text-align:center;">Special Event</th>
                            </tr>
                        </thead>
                        <tbody class="fields process" id="DymentionTableBody">
                            <tr>
                                <td><input type="text" class="form-control" name="eventName" id="eventName" placeholder="Event Name" value="'.$eventName.'" /></td>
                                
                                <td><input type="text" class="form-control" name="eventDate" placeholder="Event Date" id="eventDate" value="'.$eventDate.'" /></td>
                                <td>Start Time</td>
                                <td><input type="text" class="form-control" name="eventStartDate" id="eventStartDate" value="'.$eventStDate.'" /></td>
                                <td>End Time</td>
                                <td><input type="text" class="form-control" name="eventEndDate" id="eventEndDate"  value="'.$eventEndDate.'" /></td>
                            </tr>                            
                        </tbody>
                    </table>
                </div>
            ';
        }
        return $content;
    }


    public function actionSingleUpdate($id){
        $session= Yii::$app->session;
        $prayer_timings = PrayerTimings::findOne($id);
        $time1=$time2=$time3=$time4="";
        if($prayer_timings){
            if($_POST){
                //echo "<pre>";print_r($_POST);die;
                if(array_key_exists('time1', $_POST))
                $time1 = $_POST['time1'];
                if(array_key_exists('time2', $_POST))
                $time2 = $_POST['time2'];
                if(array_key_exists('time3', $_POST))
                $time3 = $_POST['time3'];
                if(array_key_exists('time4', $_POST))
                $time4 = $_POST['time4'];
                $prayer_timings->time1 =$time1;
                $prayer_timings->time2 =$time2;
                $prayer_timings->time3 =$time3;
                $prayer_timings->time4 =$time4;
                if($prayer_timings->save()){
                   // return $time1;
                }
            }  
        }
    }


    // public function actionSingleDelete($id){
    //     $PrayerTimings = PrayerTimings::findOne($id);
    //     if($PrayerTimings){
    //         $PrayerTimings->delete();
    //     }
    // }
}
