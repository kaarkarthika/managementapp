<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Expenses Masters';
$this->params['breadcrumbs'][] = $this->title;
if(isset($_SESSION['color_code'])){
    $color_code=$_SESSION['color_code'];
}else{
    $color_code="#ed1c24";
}
?>
<div class="donation-type-master-index">
    <div class="box box-primary  ">
        <div class=" ">
            <div class=" box-header with-border box-header-bg">
                <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
                <?= Html::a('Add Expenses', ['create'], ['class' => 'btn btn-success pull-right']) ?>
            </div>
        </div>
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'expenses_name',
                [
                    'attribute'=>'activeStatus',
                    'headerOptions'=>['style'=>'width:200px;'],
                    'value'=>function($models, $keys){
                        if($models->activeStatus=="1"){
                            return  "Active";
                        }else{
                            return  "In Active";
                        }
                    },
                    'filter'=>array('1'=>'Active','0'=>'In Active'),
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Action',
                    'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
                        'template'=>'{view}{update}{delete}',
                        'buttons'=>[
                        'view' => function ($url, $model, $key) {
                            return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                }, 
                        'update' => function ($url, $model, $key) {
                            $options = array_merge([
                                'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                'data-toggle'=>'tooltip',
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                            ]);
                            return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                        },
                    ] 
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Expenses Master</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>
