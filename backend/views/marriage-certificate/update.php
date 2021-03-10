<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Marriage Registration';
$this->params['breadcrumbs'][] = ['label' => 'Marriage Registration', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="marriage-certificate-update">
     
	
    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>

  </div>
