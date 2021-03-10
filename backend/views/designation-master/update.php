<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\DesignationMaster */

$this->title = 'Update Designation Master: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Designation Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="designation-master-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
