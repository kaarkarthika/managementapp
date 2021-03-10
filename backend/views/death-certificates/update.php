<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Death Registration';
$this->params['breadcrumbs'][] = ['label' => 'Death Registration', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="death-certificates-update">
     
	
    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
         'childContent' => $childContent,
    ]) ?>

  </div>