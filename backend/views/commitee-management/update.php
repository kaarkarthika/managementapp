<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Commitee & Staff Management';
$this->params['breadcrumbs'][] = ['label' => 'Commitee & Staff Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="commitee-management-update">
  
	
    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?>

  </div>
