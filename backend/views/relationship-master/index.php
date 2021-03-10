<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Relationship Masters';
$this->params['breadcrumbs'][] = $this->title;

   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
?>
<style type="text/css">
  /* .btn-success{
    background-color:<?php //echo $color_code;?>;
   color: #fff;
   border-color: <?php //echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php //echo $color_code;?>;
}
.btn-success:hover {
   
    border-color:<?php //echo $color_code;?>;
}*/
</style>
<div class="relationship-master-index">

    <div class="box box-primary  ">
      <div class=" ">
   
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?= Html::a('Add Relationship', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            'relation_type',

            //'active_status',
            ['attribute'=>'active_status',
            'headerOptions'=>['style'=>'width:100px;'],
            'value'=>function($models, $keys){
             

             if($models->active_status=="1"){

                return  "Active";
             }else{
                return  "In Active";
             }
               
            },
            'filter'=>array('0'=>'NO','1'=>'YES'),
          ],
          
           // ['class' => 'yii\grid\ActionColumn'],
          ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view}{update}{delete}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
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
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
</div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Relation Type</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>

