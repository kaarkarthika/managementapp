<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Donation Management';
$this->params['breadcrumbs'][] = $this->title;
if(isset($_SESSION['color_code'])){
    $color_code=$_SESSION['color_code'];
}else{
    $color_code="#ed1c24";
}
?>
<div class="family-master-index">
    <div class="box box-primary  ">
        <div class=" ">
            <div class=" box-header with-border box-header-bg">
                <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
                <div class="" id="searchDiv" style="margin-top: 25px;" hidden>
                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
                <div class="pull-right">
                    <?= Html::a('Add', ['create'], ['class' => 'btn btn-success']) ?>       
                    <?= Html::Button('Search/Download', ['class' => 'btn btn-default','id'=>'search','value'=>'open']) ?>       
                </div>
            </div>
        </div>
        <div class=" box-bode">
        <?php Pjax::begin(); ?>    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'donation_type', 
                [
                    'attribute'=>'donation_date',
                    // 'headerOptions'=>['style'=>'width:100px;'],
                    'value'=>function($models, $keys){
                        $dt = date('d-m-Y',strtotime($models->donation_date));
                        if(strpos($dt, '1970')||strpos($dt, '0000')){
                            $dt = "-";
                        }
                        return $dt;
                    },
                ], 
                [
                    'attribute'=>'donor_name',
                    // 'headerOptions'=>['style'=>'width:100px;'],
                    'value'=>function($models, $keys){
                        $name = "-";
                        if($models->donor_name!="" && $models->donor_name!=NULL){
                            $name = ucfirst($models->donor_name);
                        }
                        return $name;
                    },
                ],
                [
                    'attribute'=>'donationAmount',
                    'contentOptions' => ['style' => 'text-align:right;'],
                    'headerOptions'=>['style'=>'width:150px;'],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header'=> 'Action',
                    'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
                    'template'=>'{update}{delete}',
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
</div>
<script type="text/javascript">
     $('body').on("click",".modalView",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Family Details</span>');
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
        $("#donationmanagementsearch-created_at").datepicker({ 
            autoclose: true, 
           todayHighlight: true,
            format:'dd-mm-yyyy'
        });
        $("#donationmanagementsearch-updated_at").datepicker({ 
            autoclose: true, 
           todayHighlight: true,
            format:'dd-mm-yyyy'
        });
    });
</script>