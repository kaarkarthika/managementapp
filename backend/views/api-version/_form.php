<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$session = Yii::$app->session;

/* @var $this yii\web\View */
/* @var $model backend\models\Colorsystem */
/* @var $form yii\widgets\ActiveForm */
 
   ?>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-6 form-group' >
                     <label class="control-label">App Name</label>
                    <?= $form->field($model, 'apps_name')->textInput(['maxlength' => true])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <label class="control-label">APP Version</label>
                     <?= $form->field($model, 'app_version')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)'])->label(false) ?>
                  </div>
                </div>
                <div class="row">
                  <?php 
                  if($model->isNewRecord){
                  $model->force_update = 1;
                  }?>
               <div class='col-sm-6 form-group ' >
            
                  <?= $form->field($model, 'force_update', [
                     'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Force Update</label></div>{error}",
                     ])->checkbox([],false) ?>
               </div>
                <div class='col-sm-6 form-group' >
                     <label class="control-label">Version Name</label>
                     <?= $form->field($model, 'version_key')->textInput(['maxlength' => true])->label(false) ?>
                  </div>
                </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <nav></nav>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>