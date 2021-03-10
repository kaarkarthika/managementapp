<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Color System';
$this->params['breadcrumbs'][] = ['label' => 'Color System', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="video-management-update">
     <div class="box box-primary">
	    <div class=" ">
    	  <div class=" box-header with-border box-header-bg">
             <h3 class="box-title "><?= Html::encode($this->title) ?></h3>
          </div>
	    </div>
	</div>
	
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

  </div>