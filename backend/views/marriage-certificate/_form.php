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
  fieldset {
  display: block;
  margin-left: 2px;
  margin-right: 2px;
  padding-top: 0.35em;
  padding-bottom: 0.625em;
  padding-left: 0.75em;
  padding-right: 0.75em;
  border: 2px groove (internal value);
}
 /* .btn-success{
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
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-4 form-group mb_0 mb_0' >
                    <?php 
                      if($model->wedding_date!="" && $model->wedding_date!=NULL){
                        $model->wedding_date = date('d-m-Y',strtotime($model->wedding_date));
                      }
                    ?>
                    <?= $form->field($model, 'wedding_date')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                    <?= $form->field($model, 'wedding_venue')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                    <?= $form->field($model, 'imam_detail')->textInput(['maxlength' => true]) ?>
                  </div>
                </div>
                 <?= $form->field($model, 'hidden_Input')->hiddenInput(['id'=>'hidden_Input','class'=>'form-control','value'=>$token_name])->label(false)?>
                 <fieldset>
                <div class="l_bg"> <legend>Bride Details</legend></div><br>
                <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                      <?= $form->field($model, 'bride_name')->textInput(['maxlength' => true]) ?>
                  </div>
                   <div class='col-sm-4 form-group mb_0' >
                       <?= $form->field($model, 'bride_age')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                       <?= $form->field($model, 'contact_number')->textInput(['maxlength' => 10,'onkeypress'=>'return isNumberKey(event)']) ?>
                  </div>
              </div>
              <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'fathers_name')->textInput(['maxlength' => true]) ?>
                  </div>
            <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'mothers_name')->textInput(['maxlength' => true]) ?>
               </div>
               <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'bride_address')->textArea(['rows' => '3']) ?>
               </div>
        </div>
         <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'witness_name')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'witness_name2')->textInput(['maxlength' => true]) ?>
                  </div>
        </div>
        </fieldset>
        <fieldset>
                 <div class="l_bg"> <legend>Bridegroom Details</legend></div><br>
        <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'groom_name')->textInput(['maxlength' => true]) ?>
                  </div>
            <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'groom_age')->textInput(['maxlength' => true]) ?>
               </div>
               <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'groom_contact_number')->textInput(['maxlength' => 10,'onkeypress'=>'return isNumberKey(event)']) ?>
               </div>
        </div>
         <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'groom_fathers_name')->textInput(['maxlength' => true]) ?>
                  </div>
            <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'groom_mothers_name')->textInput(['maxlength' => true]) ?>
               </div>
               <div class='col-sm-4 form-group mb_0 ' >
                   <?= $form->field($model, 'groom_address')->textArea(['rows' => '3']) ?>
               </div>
        </div>
        <div class="row">
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'groom_witness_name')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-4 form-group mb_0' >
                  <?= $form->field($model, 'groom_witness_name2')->textInput(['maxlength' => true]) ?>
                  </div>
        </div>
    </fieldset>
            <div class="form-group mb_0 text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
                <?= Html::a('Cancel',['index'] ,['class' => 'btn btn-default']) ?>
            </div>
            <?php ActiveForm::end(); ?>
         </div>
      </div>
   </div>
</div>
</div>

<script>
     function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

$(function () {
  $("#marriagecertificate-wedding_date").datepicker({ 
        autoclose: true, 
       // todayHighlight: true,
        format:'dd-mm-yyyy'
  });
});


  </script>


 

