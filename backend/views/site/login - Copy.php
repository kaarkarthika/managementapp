<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = 'MOSQUE MANAGEMENT - LOGIN';
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/loader/favicon.png" type="image/x-icon" />
<link href="<?php echo Url::base(); ?>/Lato/lato.css" rel="stylesheet">
    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(<?php echo Url::base(); ?>/images/login_bg.jpg.jpg)" data-overlay="7">
        <div class="row h-100 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
      
            
          </div>
        </div>

      </div>
      <div class="col-md-6 col-lg-5 col-xl-4 al ign-self-center">
      <center><img src="<?php echo  Url::base(); ?>/images/images/boms.png" alt=" " width="200" height="150"> </center>
        <div class="px-80 py-30 br-top-logo">
      <br>
      <center><h4>LOGIN</h4></center>
           <br>
          <?php $form = ActiveForm::begin(['options'=> ['autocomplete'=>'off','class' => 'form-type-material']]); ?>  
          <?= Html::csrfMetaTags() ?>
            <div class="form-group">
              <!-- <input type="text" class="form-control" id="username">
              <label for="username">Username</label> -->
              <?= $form->field($model, 'username')->textInput(['class'=>'form-control','required'=>true])->label('Username');  ?> 
            </div>

            <div class="form-group">
              <!-- <input type="password" class="form-control" id="password">
              <label for="password">Password</label> -->
              <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','required'=>true])->label('Password');  ?> 
            </div>

            <div class="form-group flexbox">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" checked>
                <label class="custom-control-label">Remember me</label>
              </div>

              <a class="text-muted text-boms1 fs-13" href="#">Forgot password?</a>
            </div>

            <div class="form-group">
              <button class="btn btn-bold btn-block btn-boms" type="submit">Login</button>
            </div>
             <?php ActiveForm::end(); ?>
    </div>
      </div>
    </div>

 


<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = 'MOSQUE MANAGEMENT - LOGIN';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
.login-page, .register-page {
    
   
   background-image: url("images/login_bg.jpg")!important; 
   background-size:100% 100%;
}
 .login-box-body, .register-box-body {
   /* background: rgb(66, 89, 130) !important;*/
   background:#000!important;
   /*background-image: url("images/pooja1.jpg")!important;*/
}
/*.login-box-body { 
  background-image: url("images/11136297.jpeg")!important;
    background-repeat: no-repeat!important;
    background-size: cover!important;
    margin-top:-23px;
}*/

</style>
<div class="login-box">
      <!-- <div class="login-logo" style="margin-top: -9px;">
       
       <a href="../../index2.html"><b>SWiM</b> </a>
      </div> -->
      <div class="login-box" style="margin-top: -9px;">
        <a href="../../index2.html" target="_blank"><center><!--  <span style="color: #000;"><img src="images/swim_logo.png" width="220px" height="75px"> 
        ANITHA PUSHPAVANAN KUPPUSAMY . </span>  --></center></a> 
         <!-- <a href="../../index2.html">Admin<b>SWIM</b></a> -->
         
      </div>

      <!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg" style="color: #fff; ">MOSQUE MANAGEMENT</p>
       <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
         
           <?= $form->field($model, 'username',[
           'options'=>[
             		'tag'=>'div',
             		'class'=>'form-group has-feedback',
             ],
			'template' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>{hint}{error}'
			])->textInput(array('placeholder' => 'Username'));  ?> 
			
			<?= $form->field($model, 'password',[
           'options'=>[
             		'tag'=>'div',
             		'class'=>'form-group has-feedback',
             ],
			'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{hint}{error}'])->passwordInput(array('placeholder' => 'Password'));  ?> 
			           
          
          <div class="row">
            <div class="col-xs-8">
              <div class="checkbox icheck">
                <label style="color: #fff;">
                  <?= $form->field($model, 'rememberMe')-> checkbox(['value' => false]) ?> 
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
               <?= Html::submitButton('<i class="fa fa-fw fa-sign-in"></i> Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div><!-- /.col -->
          </div>
        <?php ActiveForm::end(); ?>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->


    