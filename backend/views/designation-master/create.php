<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DesignationMaster */

$this->title = 'New Designation';
$this->params['breadcrumbs'][] = ['label' => 'Designation Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-master-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
