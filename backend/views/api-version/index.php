<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Version';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-version-index">
  <div class="box box-primary  ">
  <div class="">
  </div>
  <div class="table-responsive">
  <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           //'auto_id'
            'apps_name',
            'app_version',
             ['attribute'=>'force_update',
            'headerOptions'=>['style'=>'width:100px;'],
            'value'=>function($models, $keys){
             if($models->force_update=="1"){
              return  "Yes";
             }else{
              return  "No";
             }
            },
            'filter'=>array('0'=>'NO','1'=>'YES'),
            ],
            'version_key',
            'create_at',
            'update_at',
             ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{update}',
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
    ]); ?></div>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){ 
        var url = $(this).attr('value');
        $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Videos</span>');
        $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
         return false;
         });
         $(document).ready(function(){
            $('#w1').removeClass('grid-view') 
         });
</script>

