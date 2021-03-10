<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */

$this->title = 'Admin Detail View';
//$this->title = $model->id;  

$this->params['breadcrumbs'][] = $this->title;

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
  .box-header {
    color: #fff;
    background-color:<?php echo $color_code;?>;
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
<div class="box-body">
    <div class="box box-primary cgridoverlap">
     <div class="box-header with-border">
    <h3 class="box-title"><i class="fa fa-fw fa-street-view"></i> <?= Html::encode($this->title) ?></h3>
    </div><!-- /.box-header -->
<div class="userdetails-view">


    <p class="pull-right">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
       <!--  <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>


    <div class="col-md-12">

              <!-- Profile Image -->
              
                  <img class="profile-user-img img-responsive img-circle" src="dist/img/user2-160x160.jpg" alt="User profile picture">
                  <h3 class="profile-username text-center"><?= $model->first_name .' '. $model->last_name  ?></h3>
                  <p class="text-muted text-center"><?php echo $model->user_type == 'A' ? 'Admin' : "Others"; ?></p>

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <b>User Name</b> <a class="pull-right"><?= $model->username ?></a>
                    </li>
                    
                    <li class="list-group-item">
                      <b>City</b> <a class="pull-right"><?= $model->city ?></a>
                    </li>
                    <li class="list-group-item">
                      <b>Status</b> <a class="pull-right"><?= $model->status_flag == 'A'? 'Active' : 'Inactive' ?></a>
                    </li>
                  </ul>

                
              
            </div><!-- /.col -->

    
</div>
</div>
</div>