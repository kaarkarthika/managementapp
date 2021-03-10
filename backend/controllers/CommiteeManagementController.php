<?php

namespace backend\controllers;

use Yii;
use backend\models\CommiteeManagement;
use backend\models\ReportsDownloader;
use backend\models\CommiteeManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * CommiteeManagementController implements the CRUD actions for CommiteeManagement model.
 */
class CommiteeManagementController extends Controller
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
     * Lists all CommiteeManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CommiteeManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(array_key_exists('download', Yii::$app->request->queryParams)){
            $data = ArrayHelper::toArray($dataProvider->getModels());
            $input = array();
            $header = $body = array();
            $header = array('Name','Age','Type','Education','Present Address','Perment Address','Salary','Benifits 1','Benifits 2','Benefits 3','Active Status','Created Time');
            foreach ($data as $key => $oneData) {
                $newAr = array();
                $newAr['name'] = $oneData['name'];
                $newAr['age'] = $oneData['age'];
                $newAr['select_type'] = $oneData['select_type'];
                $newAr['education'] = $oneData['education'];
                $newAr['present_address'] = $oneData['present_address'];
                $newAr['permanent_address'] = $oneData['permanent_address'];
                $newAr['salary'] = $oneData['salary'];
                $newAr['benefits1'] = $oneData['benefits1'];
                $newAr['benefits2'] = $oneData['benefits2'];
                $newAr['benefits3'] = $oneData['benefits3'];
                $newAr['activeStatus'] = "Active";
                if($oneData['active_status']=='0'){
                    $newAr['activeStatus'] = "In-Active";
                }
                $time = date('d-m-Y H:i:s',strtotime($oneData['created_at']));
                if(strpos($time, '1970')||strpos($time, '1970'))
                    $time = "-";

                $newAr['created_at'] = $time;
                $body[] = $newAr;
            }

            $input['header'] = $header;
            $input['body'] = $body;
            $input['reportName'] = 'CommiteeManagement';
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
     * Displays a single CommiteeManagement model.
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
     * Creates a new CommiteeManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CommiteeManagement();

        $session = Yii::$app->session; 
        if($model->load(Yii::$app->request->post())) {
        if ($formTokenValue = Yii::$app->request->post('CommiteeManagement')['hidden_Input']) {   
          $sessionTokenValue =  $session['hidden_token'];
          if ($formTokenValue == $sessionTokenValue ){
            // echo "<prE>";print_r($_POST);die;
            $model->comments = Yii::$app->request->post('CommiteeManagement')['comments'];
            $model->asOnDate = date('Y-m-d',strtotime(Yii::$app->request->post('CommiteeManagement')['asOnDate'])) ;
        if ($model->save()) {
            Yii::$app->session->remove('hidden_token');
            Yii::$app->getSession()->setFlash('success', 'Commitee Saved successfully.');
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
     * Updates an existing CommiteeManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->asOnDate = date('Y-m-d',strtotime(Yii::$app->request->post('CommiteeManagement')['asOnDate'])) ;
            $model->comments = Yii::$app->request->post('CommiteeManagement')['comments'];
        if($model->save()){
            
         Yii::$app->getSession()->setFlash('success', 'Commitee Updated successfully.');
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
     * Deletes an existing CommiteeManagement model.
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
     * Finds the CommiteeManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CommiteeManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CommiteeManagement::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
