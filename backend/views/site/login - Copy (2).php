<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = 'MOSQUE MANAGEMENT - LOGIN';
$this->params['breadcrumbs'][] = $this->title;
// echo  Url::base().'/images/mosque.png';die; 
?>

<link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/favicon/mosque.png" type="image/x-icon" />
<link href="<?php echo Url::base(); ?>/Lato/lato.css" rel="stylesheet">
    <div class="row no-gutters min-h-fullscreen bg-white">
      <div class="col-md-6 col-lg-7 col-xl-8 d-none d-md-block bg-img" style="background-image: url(<?php echo Url::base(); ?>/images/favicon/mosque.jpg)" data-overlay="7">
        <div class="row h-100 pl-50">
          <div class="col-md-10 col-lg-8 align-self-end">
      
            
          </div>
        </div>

      </div>
      <div class="col-md-6 col-lg-5 col-xl-4 al ign-self-center">
      <center><img src="<?php echo  Url::base(); ?>/images/mosque.png" alt=" " width="200" height="150"> </center>
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

            

            <div class="form-group" style="margin-top: 30px;">
              <button class="btn btn-bold btn-block btn-boms" type="submit">Login</button>
            </div>
             <?php ActiveForm::end(); ?>
    </div>
      </div>
    </div>

 
