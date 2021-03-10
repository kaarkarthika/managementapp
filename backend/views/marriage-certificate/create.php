<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CategoryManagement */

$this->title = 'New Registration';
$this->params['breadcrumbs'][] = ['label' => 'Marriage Registration', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class=" ">
<div class="marriage-certificate-create">
  
   <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>
  </div>
</div>


