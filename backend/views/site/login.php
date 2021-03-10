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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--=============================================================-->  
    <link rel="icon" type="image/png" href="images/login/icons/favicon.ico"/>
    <!--=============================================================-->
	<link href="https://fonts.googleapis.com/css?family=Nunito+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <!--============================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.css">
   

    <!--============================================================-->
    <link rel="stylesheet" type="text/css" href="css/loginUtil.css">
    <link rel="stylesheet" type="text/css" href="css/loginMain.css">
    <!--=========================================================-->
</head>
<body style="background-image: url(images/login_bg.jpg);">
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100" style="background-image: url(images/login_bg.jpg);background-size:100% 100%;">
        <?php $form = ActiveForm::begin(['options'=> ['autocomplete'=>'off','class' => 'form-type-material login100-form validate-form']]); ?>  
        
          <span class="login100-form-title p-b-43">
            MOSQUE MANAGEMENT
          </span>
          
          
          <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
            <input class="input100" type="text" name="LoginForm[username]" required>

            <span class="focus-input100"></span>
            <span class="label-input100">User Name</span>
          </div>
          
          
          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="LoginForm[password]" required>

            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
          </div>

          <div class="flex-sb-m w-full p-t-3 p-b-32">
            <div class="">
            <?php 
              if($isError=='yes'){ ?>
                <span id="errorSpan" style="color: #ecbdc1;">Invalid Username or Password..!</span> 
              <?php  } ?>
            </div>
          </div>
      

          <div class="container-login100-form-btn">
            <button class="login100-form-btn">
              Login
            </button>
          </div>

          <div class="text-center p-t-46 p-b-20">
            <span class="txt2">
              <p class="pull-left">&copy; <?= date('Y') ?> Mosque Management </strong>     All rights reserved.</p>
            </span>
          </div>
          

          
        <?php ActiveForm::end(); ?>

        <div class="login100-more" style="background-image: url('imag es/login_bg.jpg');">
        </div>
      </div>
    </div>
  </div>
  
<!--===============================================================================================-->
  <script src="../../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
  <script src="../../vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
  <script src="../../vendor/bootstrap/js/popper.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->

<!--======================================================================================-->
  <script src="js/jqueryCustomized.js"></script>

</body>
<script type="text/javascript">
  $('body').on('keyup','.input100',function(){
    $('#errorSpan').hide();
  });
</script>
