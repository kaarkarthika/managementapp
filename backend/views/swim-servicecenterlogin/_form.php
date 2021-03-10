<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\SwimServiceCentre;
use yii\helpers\ArrayHelper;
//use backend\models\Frontenduser;

/* @var $this yii\web\View */
/* @var $model backend\models\SwimBranchAdmin */
/* @var $form yii\widgets\ActiveForm */
$pass=$model->id;
?>
<style type="text/css">
  
  .box-header {
    color: #fff;
    background-color: #ff0000;
</style>
<section class="content">
<!-- Info boxes -->
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
            <div class="box-header with-border">
                     <h3 class="box-title"><?= $model->isNewRecord ? '<i class="fa fa-fw fa-calendar-plus-o"></i>' : '<i class="fa fa-fw fa-edit"></i>' ?>  <?= Html::encode($this->title) ?></h3>
              </div><!-- /.box-header -->
<div class="school-mgmt-form">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>
 <div class="col-md-12">
         <div class="form-group col-md-6">
  

<?= $form->field($model, 'servicecenter_id')->dropDownList(
  ArrayHelper::map(SwimServiceCentre::find()->where(['service_center_status'=>'A'])->all(),'center_autoid','service_center_name'),['prompt'=>'Select Service Centre']
  ) ?>

  </div>
        <div class="form-group col-md-6">   
     <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
  </div>

<?php if(count($pass)>0)
{?>
       <div class="form-group col-md-6">   
     
  </div>
<?php } 

else
      {?>

    <div class="form-group col-md-6">   
     <?= $form->field($model, 'password_hash')->PasswordInput(['maxlength' => true]) ?>
  </div>
  </div>
<?php }
?>
<div class="box-footer pull-right">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-fw fa-save"></i> Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    </div>
<?php ActiveForm::end(); ?>
    

</div>
</div>
</div>
</div>
</section>



<script type="text/javascript">
    $(".datepicker").datepicker();
    </script>