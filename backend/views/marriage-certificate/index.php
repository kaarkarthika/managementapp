<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marriage Registration';
$this->params['breadcrumbs'][] = $this->title;
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
?>
<style type="text/css">
   /*.btn-success{
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
<div class="category-management-index">

    <div class="box box-primary  ">
      <div class=" ">
   
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   
   <div class="" id="searchDiv" style="margin-top: 25px;" hidden>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
                <div class=" pull-right">
                    <?= Html::a('Add Marriage Certificate', ['create'], ['class' => 'btn btn-success']) ?>      
                    <?= Html::Button('Search/Download', ['class' => 'btn btn-default','id'=>'search','value'=>'open']) ?>       
                </div>
    </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
    <div class=" box-body">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
             //'id',
            'bride_name',
            'groom_name',
            'contact_number',
            'groom_contact_number',
            [
              'attribute'=>'wedding_date',
              'value'=>function($models, $keys){
                $dty = date('d-m-Y',strtotime($models->wedding_date));
                if(strrpos($dty, '1970')||strrpos($dty, '0000')){
                  $dty = "-";
                }
                return  $dty;
                
              },
            ],
            'wedding_venue',
            //'bride_age',
           // 'fathers_name',
            //'mothers_name',
            //'bride_address:ntext',
             // 'witness_name',
            //'groom_age',
            //'groom_fathers_name',
            //'groom_mothers_name',
            //'groom_address:ntext',
            //'groom_witness_name:ntext',
            //'created_at',
            //'updated_at',

          
           // ['class' => 'yii\grid\ActionColumn'],
          ['class' => 'yii\grid\ActionColumn',
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
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i> Marriage Registration</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
     $('body').on("click","#search",function(){
        var data = $('#search').val();
        if(data=='open'){
            $('#searchDiv').slideToggle();
            $('#search').val('close');
            document.querySelector('#search').innerText = 'Hide';
        }else if(data=='close'){
            $('#searchDiv').slideToggle();
            $('#search').val('open');
            document.querySelector('#search').innerText = 'Search/Download';
        }
    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    $(function () {
        $("#marriagecertificatesearch-created_at").datepicker({ 
            autoclose: true, 
           todayHighlight: true,
            format:'dd-mm-yyyy'
        });$("#marriagecertificatesearch-updated_at").datepicker({ 
            autoclose: true, 
           todayHighlight: true,
            format:'dd-mm-yyyy'
        });
    });
</script>

