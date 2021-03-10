<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   $session = Yii::$app->session;
   /* @var $this yii\web\View */
   /* @var $model backend\models\CategoryManagement */
   /* @var $form yii\widgets\ActiveForm */
if(isset($_SESSION['color_code'])){
$color_code=$_SESSION['color_code'];
}
else
{
$color_code="#ed1c24";
}
?>
<style>
  textarea{
    resize: none;
  }
  /*.btn-success{
    background-color:<?php //echo $color_code;?>;
   color: #fff;
   border-color: <?php //echo $color_code;?>;
  }
  .clssdyna{
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
<div class="relationship-master-form">
<div id="page-content">
<div class="">
<div class="eq-height">
<div class="panel">
<div class="panel-body">
<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
<div class="row">
<div class='col-sm-6 form-group' >
<?= $form->field($model, 'relation_type')->textInput(['maxlength' => true,'class'=>"form-control upper"]) ?>
<?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
</div>
<div class="col-sm-6 form-group">
    <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
</div>
</div>
<div class="row">
<?php 
if($model->isNewRecord){
$model->active_status = 1;
}?>
<div class='col-sm-6 form-group ' >
<?= $form->field($model, 'active_status', [
 'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
 ])->checkbox([],false) ?>
</div>
</div>
<div class="form-group pull-right">
<?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
<?= Html::a('Cancel',['index'], ['class' =>'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>

