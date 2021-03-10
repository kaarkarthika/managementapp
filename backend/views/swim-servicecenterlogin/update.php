<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SwimServicecenterlogin */

$this->title = 'Update Swim Servicecenterlogin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Swim Servicecenterlogins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="swim-servicecenterlogin-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
