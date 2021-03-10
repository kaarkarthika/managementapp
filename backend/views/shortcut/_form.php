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
  .btn-success{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .clssdyna{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php echo $color_code;?>;
  }
  .btn-success:hover {   
    border-color:<?php echo $color_code;?>;
  }

   .score {
   background-color: #0c9cce;
   color: #fff;
   font-weight: 600;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   line-height: 40px;
   text-align: center;
   margin: auto;
   /* padding: 21% 14%;*/
   }
   .checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .upper {
   text-transform: uppercase;
   }
   .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   }
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px; */
   border: 1px solid #cccccc;
   content: "";
   display: inline-block;
   height: 17px;
   left: 0!important;
   margin-left: -20px!important;
   position: absolute;
   transition: 0.3s ease-in-out;
   width: 17px;
   outline: none !important;
   }
   .checkbox input[type="checkbox"]:checked + label::after {
   content: "\f00c";
   font-family: 'FontAwesome';
   color: #fff;
   position: relative;
   right: 59px;
   bottom: 1px;
   }
   .checkbox label {
   display: inline-block;
   padding-left: 5px;
   position: relative;
   }
</style>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Name</h3> -->
                     <label class="control-label">Shortcode Name</label>
                     <?= $form->field($model, 'name')->textInput(['maxlength' => true,'placeholder'=>'shortcode','class'=>'form-control'])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Location</h3> -->
                     <label class="control-label">ShortCode Link</label>
                     <?= $form->field($model, 'link')->textInput(['maxlength'=>true,'class'=>'form-control','placeholder'=>'shortcodelink'])->label(false) ?>
                  </div>
               
                  
                  
              
               <?php 
                  if($model->isNewRecord){
                  $model->status = 1;
                  }?>
               <div class='col-sm-6 form-group ' >
                  
                  <?= $form->field($model, 'status', [
                     'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
                     ])->checkbox([],false) ?>
               </div>

                </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <nav></nav>
         </div>
      </div>
   </div>
</div>
</div>