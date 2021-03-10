<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Relationship Master';
$this->params['breadcrumbs'][] = ['label' => 'Relationship Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="relationship-master-update">
     
	
    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,    
      ]) ?>

  </div>