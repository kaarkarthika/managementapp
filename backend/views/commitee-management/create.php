<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CategoryManagement */

$this->title = 'Commitee & Staff Management';
$this->params['breadcrumbs'][] = ['label' => 'Commitee & Staff Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'New';
?>
 

<div class="commitee-management-create">

   <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name,
    ]) ?></div>
