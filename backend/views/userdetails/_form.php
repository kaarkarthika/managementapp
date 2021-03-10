<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */
/* @var $form yii\widgets\ActiveForm */

  $session = Yii::$app->session;
   /* @var $this yii\web\View */
   /* @var $model backend\models\CategoryManagement */
   /* @var $form yii\widgets\ActiveForm */
session_start();
if(isset($_SESSION['color_code'])){
$color_code=$_SESSION['color_code'];
}
else
{
$color_code="#ed1c24";
}
?>
<style>
     .box-header {
    color: #fff;
    background-color:<?php echo $color_code;?>;
}
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
<section class="content">
<!-- Info boxes -->
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
            <div class="box-header with-border">
                     <h3 class="box-title"><?= $model->isNewRecord ? '<i class="fa fa-fw fa-user-plus"></i>' : '<i class="fa fa-fw fa-user"></i>' ?>  <?= Html::encode($this->title) ?></h3>
              </div><!-- /.box-header -->
<div class="userdetails-form">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-12">

    <div class="form-group col-md-6">
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => true]) ?>
    </div>
        <div class="form-group col-md-6">

	<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => true]) ?>
	</div>
	</div>
	<div class="col-md-12">
	<div class="form-group col-md-6">
	<?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'placeholder' => true]) ?>
	</div>
	<div class="form-group col-md-6">
	<?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true, 'placeholder' => true,'maxlength' => 10,'onkeypress'=>'return isNumberKey(event)']) ?>
	</div>
  
  
	</div>
	<div class="col-md-12">
	<div class="form-group col-md-6">
  <?= $form->field($model, 'support_number')->textInput(['maxlength' => true, 'placeholder' => true,'maxlength' => 10,'onkeypress'=>'return isNumberKey(event)'])?>
  </div>
	 <div class="form-group col-md-6">

  <?= $form->field($model, 'email_id')->textInput(['maxlength' => true, 'placeholder' => true]) ?>
	</div>
	</div>
	<div class="col-md-12">
	</div>

	 <div class="col-md-12">

   <div class="form-group col-md-6">

	<?= $form->field($model, 'city')->textArea(['maxlength' => true, 'placeholder' => true]) ?>
  </div>
	    <div class="form-group col-md-6">

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => true,'readonly'=>'true']) ?>
    </div>
  <!--  	    <div class="form-group col-md-4">

    <?php //echo $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'Email id']) ?>
    </div> -->

    <div class="form-group col-md-6">
    <?php echo $model->isNewRecord ?$form->field($model, 'password_hash')->passwordInput(['placeholder' => 'Password','value'=>'']) : ''; ?>
    <?php //echo  $form->field($model, 'password_hash')->passwordInput(['placeholder' => 'Password','value'=>'']) ?>
    </div>    
	</div>

   <div class="box-footer pull-right">
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>
    </div>

</div>
</div>
</div>
</div>
</section>



<script type="text/javascript">
    $(".datepicker").datepicker();
    </script>
    <script>
     function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

  </script>