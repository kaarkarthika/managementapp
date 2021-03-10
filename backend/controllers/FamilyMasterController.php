<?php

namespace backend\controllers;

use Yii;
use backend\models\FamilyMaster;
use backend\models\ReportsDownloader;
use backend\models\RelationshipMaster;
use backend\models\FamilyMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * FamilyMasterController implements the CRUD actions for FamilyMaster model.
 */
class FamilyMasterController extends Controller
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
     * Lists all FamilyMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FamilyMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array("Family Head's Name","Family Head's Age","Family Head's Gender","Family Head's Education","Family Head's Occupation",'No of Dependents','Contact Number','Alternate Phone Number','Email Id','Landmark','Address','Description','Active Status','Created Time','Dependent Name','Dependent Age','Dependent Relationship','Dependent Education','Dependent Occupation','Dependent Gender');

            $faml = RelationshipMaster::find()->asArray()->all();
            $famlAr = ArrayHelper::map($faml,'id','relation_type');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['familyHeadName'] = $oneData['familyHeadName'];
                $newAr['headAge'] = $oneData['headAge'];
                $newAr['headGender'] = $oneData['headGender'];
                $newAr['headEducation'] = $oneData['headEducation'];
                $newAr['headOccupation'] = $oneData['headOccupation'];
                $newAr['noOfDependents'] = $oneData['noOfDependents'];
                $newAr['contactNumber'] = $oneData['contactNumber'];
                $newAr['alternatePhoneNumber'] = $oneData['alternatePhoneNumber'];
                $newAr['emailId'] = $oneData['emailId'];
                $newAr['landMark'] = $oneData['landMark'];
                $newAr['address'] = $oneData['address'];
                $newAr['description'] = $oneData['description'];
                $newAr['activeStatus'] = 'Active';
                if($oneData['description']=='I'){
                    $newAr['activeStatus'] = 'In-Active';
                }
                $time = date('d-m-Y H:i:s',strtotime($oneData['createdAt']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['createdAt'] = $time;
                $newAr['dependentName'] = $newAr['dependentAge'] = $newAr['dependentRelationship'] = $newAr['dependentEducation'] = $newAr['dependentOccupation'] = $newAr['dependentGender'] = "";
                $isHaving = "no";
                if($oneData['dependentDetails']!=""){
                    $alls = ArrayHelper::toArray(json_decode($oneData['dependentDetails']));
                    if(!empty($alls)){
                        $isHaving = "yes";
                        foreach ($alls as $key => $onDep) {
                            $newAr['dependentName'] = $onDep["name"];
                            $newAr['dependentAge'] = $onDep["age"];
                            $rep = "";
                            if(array_key_exists($onDep["relationship"], $famlAr)){
                                $rep = $famlAr[$onDep["relationship"]];
                            }
                            $newAr['dependentRelationship'] = $rep;
                            $newAr['dependentEducation'] = $onDep["education"];
                            $newAr['dependentOccupation'] = $onDep["occupation"];
                            $newAr['dependentGender'] = $onDep["gender"];
                            $body[] = $newAr;
                        }
                    }
                }
                if($isHaving == "no"){
                    $body[] = $newAr;
                }
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'FamilyDetails';
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
     * Displays a single FamilyMaster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $depentContent = $this->actionAddDependentsView($id);
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),            
            'depentContent' => $depentContent,
        ]);
    }

    /**
     * Creates a new FamilyMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FamilyMaster();
        $depentContent = "";
        if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";print_r($_POST);die;
            $model->familyHeadName = $_POST['FamilyMaster']['familyHeadName'];
            $model->headAge = $_POST['FamilyMaster']['headAge'];
            $model->headGender = $_POST['FamilyMaster']['headGender'];
            $model->headEducation = $_POST['FamilyMaster']['headEducation'];
            $model->headOccupation = $_POST['FamilyMaster']['headOccupation'];
            $model->noOfDependents = $_POST['FamilyMaster']['noOfDependents'];
            $model->contactNumber = $_POST['FamilyMaster']['contactNumber'];
            $model->alternatePhoneNumber = $_POST['FamilyMaster']['alternatePhoneNumber'];
            $model->emailId = $_POST['FamilyMaster']['emailId'];
            $model->landMark = $_POST['FamilyMaster']['landMark'];
            $model->address = $_POST['FamilyMaster']['address'];
            $model->description = $_POST['FamilyMaster']['description'];
            $model->activeStatus = $_POST['FamilyMaster']['activeStatus'];
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
            $model->updatedIpaddress = $_SERVER['REMOTE_ADDR'];
            if(array_key_exists('dependentDetails', $_POST['FamilyMaster'])){
                if(!empty($_POST['FamilyMaster']['dependentDetails'])){
                    $resAr = array();
                    $ar = 1;
                    foreach ($_POST['FamilyMaster']['dependentDetails']['name'] as $key => $oneDt) {
                        $rt = array();
                        $rt['name'] = $oneDt;
                        $rt['age'] = $_POST['FamilyMaster']['dependentDetails']['age'][$key];
                        $rt['relationship'] = $_POST['FamilyMaster']['dependentDetails']['relationship'][$key];
                        $rt['education'] = $_POST['FamilyMaster']['dependentDetails']['education'][$key];
                        $rt['occupation'] = $_POST['FamilyMaster']['dependentDetails']['occupation'][$key];
                        $gnN = 'gender'.$ar;
                        $rt['gender'] = "";
                        if(array_key_exists($gnN, $_POST['FamilyMaster']['dependentDetails'])){
                            if(!empty($_POST['FamilyMaster']['dependentDetails'][$gnN])){
                                $rt['gender'] = $_POST['FamilyMaster']['dependentDetails'][$gnN][0];
                            }
                        }
                        $resAr[] = $rt;
                        $ar++;
                    }
                }
            }
            $model->dependentDetails = json_encode($resAr);
            if(!$model->save())
            {
                echo "<pre>";print_r($model->getErrors());die;
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'depentContent' => $depentContent,
        ]);
    }

    /**
     * Updates an existing FamilyMaster model.
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
            $model->familyHeadName = $_POST['FamilyMaster']['familyHeadName'];
            $model->headAge = $_POST['FamilyMaster']['headAge'];
            $model->headGender = $_POST['FamilyMaster']['headGender'];
            $model->headEducation = $_POST['FamilyMaster']['headEducation'];
            $model->headOccupation = $_POST['FamilyMaster']['headOccupation'];
            $model->noOfDependents = $_POST['FamilyMaster']['noOfDependents'];
            $model->contactNumber = $_POST['FamilyMaster']['contactNumber'];
            $model->alternatePhoneNumber = $_POST['FamilyMaster']['alternatePhoneNumber'];
            $model->emailId = $_POST['FamilyMaster']['emailId'];
            $model->landMark = $_POST['FamilyMaster']['landMark'];
            $model->address = $_POST['FamilyMaster']['address'];
            $model->description = $_POST['FamilyMaster']['description'];
            $model->activeStatus = 'A';
            if($_POST['FamilyMaster']['activeStatus']==0){
                $model->activeStatus = 'I';
            }
            
            $model->createdAt = date('Y-m-d H:i:s');
            $model->updatedAt = date('Y-m-d H:i:s');
            $model->updatedIpaddress = $_SERVER['REMOTE_ADDR'];
            $model->dependentDetails = "";
            if(array_key_exists('dependentDetails', $_POST['FamilyMaster'])){
                if(!empty($_POST['FamilyMaster']['dependentDetails'])){
                    $resAr = array();
                    $ar = 1;
                    foreach ($_POST['FamilyMaster']['dependentDetails']['name'] as $key => $oneDt) {
                        $rt = array();
                        $rt['name'] = $oneDt;
                        $rt['age'] = $_POST['FamilyMaster']['dependentDetails']['age'][$key];
                        $rt['relationship'] = $_POST['FamilyMaster']['dependentDetails']['relationship'][$key];
                        $rt['education'] = $_POST['FamilyMaster']['dependentDetails']['education'][$key];
                        $rt['occupation'] = $_POST['FamilyMaster']['dependentDetails']['occupation'][$key];
                        $gnN = 'gender'.$ar;
                        $rt['gender'] = "";
                        if(array_key_exists($gnN, $_POST['FamilyMaster']['dependentDetails'])){
                            if(!empty($_POST['FamilyMaster']['dependentDetails'][$gnN])){
                                $rt['gender'] = $_POST['FamilyMaster']['dependentDetails'][$gnN][0];
                            }
                        }
                        $resAr[] = $rt;
                        $ar++;
                    }
                }
            }
            $model->dependentDetails = json_encode($resAr);
            if(!$model->save())
            {
                echo "<pre>";print_r($model->getErrors());die;
            }

            return $this->redirect(['index']);
        }
        $depentContent = $this->actionAddDependents($id);
        // echo "<prE>";print_r($depentContent);die;
        return $this->render('update', [
            'model' => $model,
            'depentContent' => $depentContent,
        ]);
    }

    /**
     * Deletes an existing FamilyMaster model.
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
     * Finds the FamilyMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FamilyMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FamilyMaster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddDependents($id="")
    {
        if($_POST || $id!=""){
            $cnt = 0;
            $depen = array();
            if($id!=""){
                $model = $this->findModel($id);
                if($model){
                    $depen =ArrayHelper::toArray(json_decode($model->dependentDetails));
                }
                $cnt = count($depen);
            }

            $faml = RelationshipMaster::find()->where(['active_status'=>1])->asArray()->all();
           
            if($_POST){
                $cnt = $_POST['id'];
            }
            $content = "";
            for ($i=1; $i <= $cnt; $i++) { 
                $memCnt = $i+1;
                $u = $i-1;
                $gen = $nam = $age = $edu = $occu = $rela = "";
                if(array_key_exists($u, $depen)){
                    // echo "<pre>";print_r($depen[$u]);die;
                    $nam = $depen[$u]['name'];
                    $age = $depen[$u]['age'];
                    $rela = $depen[$u]['relationship'];
                    $edu = $depen[$u]['education'];
                    $occu = $depen[$u]['occupation'];
                    $gen = $depen[$u]['gender'];
                }
                $isFemale = $isMale = "";
                if($gen=='male'){
                    $isMale = "checked";
                }else if($gen=='female'){
                    $isFemale = "checked";              
                }
                $sel = '
                <select class="form-control relationship" name="FamilyMaster[dependentDetails][relationship][]" >
                    <option value="">Select</option>';
                if(!empty($faml)){
                    foreach ($faml as $key => $oneVal) {
                        
                        $issel = "";
                        if($rela==$oneVal['id']){
                            $issel = 'selected';
                        }
                        $sel .= '<option value="'.$oneVal['id'].'" '.$issel.'>'.$oneVal['relation_type'].'</option>';
                    }
                }
            $sel .= '</select>';     
                $content .= '<div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Member '.$memCnt.'</legend>
                                        <div  class="col-sm-12 form-group" >
                                            <div class="col-sm-4 form-group" >
                                                <label >Name</label>
                                                <input type="text" name="FamilyMaster[dependentDetails][name][]" class="dependentName form-control" value="'.$nam.'">
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label >Age</label>
                                                <input type="text" name="FamilyMaster[dependentDetails][age][]" onkeypress="return isNumberKey(event)" class="dependentName form-control" value="'.$age.'">
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label >Gender</label><br>
                                                <input type="radio" id="male" name="FamilyMaster[dependentDetails][gender'.$i.'][]" value="male" '.$isMale.'>
                                                <label for="male">Male</label>
                                                <input type="radio" id="female" name="FamilyMaster[dependentDetails][gender'.$i.'][]" value="female" '.$isFemale.'>
                                                <label for="female" >Female</label>
                                                
                                            </div>
                                        </div>
                                        <div  class="col-sm-12 form-group mb_0" >
                                            <div class="col-sm-4 form-group" >
                                                <label >Relationship With Family Head</label>
                                                '.$sel.'
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label >Education</label>
                                                <input type="text" name="FamilyMaster[dependentDetails][education][]" class="dependentName form-control" value="'.$edu.'">
                                            </div>
                                            <div class="col-sm-4 form-group" >
                                                <label > Occupation</label>
                                                <input type="text" name="FamilyMaster[dependentDetails][occupation][]" class="dependentName form-control" value="'.$occu.'">
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>';
            }
            return $content;
        }
    }

    public function actionAddDependentsView($id="")
    {
        if($_POST || $id!=""){
            $cnt = 0;
            $depen = array();
            if($id!=""){
                $model = $this->findModel($id);
                if($model){
                    $depen =ArrayHelper::toArray(json_decode($model->dependentDetails));
                }
                $cnt = count($depen);
            }

            $faml = RelationshipMaster::find()->where(['active_status'=>1])->asArray()->all();
           
            if($_POST){
                $cnt = $_POST['id'];
            }
            $content = "";
            for ($i=1; $i <= $cnt; $i++) { 
                $memCnt = $i+1;
                $u = $i-1;
                $gen = $nam = $age = $edu = $occu = $rela = "";
                if(array_key_exists($u, $depen)){
                    // echo "<pre>";print_r($depen[$u]);die;
                    $nam = $depen[$u]['name'];
                    $age = $depen[$u]['age'];
                    $rela = $depen[$u]['relationship'];
                    $edu = $depen[$u]['education'];
                    $occu = $depen[$u]['occupation'];
                    $gen = $depen[$u]['gender'];
                }

                $sel = '
                <select class="form-control relationship" name="FamilyMaster[dependentDetails][relationship][]" >
                    <option value="">Select</option>';
                    $rel = "";
                if(!empty($faml)){
                    foreach ($faml as $key => $oneVal) {
                        $issel = "";
                        if($rela==$oneVal['id']){
                            $issel = 'selected';
                            $rel = $oneVal['relation_type'];
                        }
                        $sel .= '<option value="'.$oneVal['id'].'" '.$issel.'>'.$oneVal['relation_type'].'</option>';
                    }
                }
            $sel .= '</select>';     
                $content .= '
                    

                <div  class="col-sm-12 form-group mb_0" >
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border">Member '.$memCnt.'</legend>
                                        <div  class="col-sm-12 form-group" >
                                            <table class="thistableonly">
                                                <tr>
                                                    <td>Name</td>
                                                    <td>'.$nam.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Age</td>
                                                    <td>'.$age.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Gender</td>
                                                    <td>'.$gen.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Education</td>
                                                    <td>'.$edu.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Relationship</td>
                                                    <td>'.$rel.'</td>
                                                </tr>
                                                <tr>
                                                    <td>Occupation</td>
                                                    <td>'.$occu.'</td>
                                                </tr>
                                            </table>                                            
                                    </fieldset>
                                </div>';
            }
            return $content;
        }
    }
}
