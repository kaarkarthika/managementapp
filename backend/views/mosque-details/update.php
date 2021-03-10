<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MosqueDetails */

$this->params['breadcrumbs'][] = ['label' => 'Mosque Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mosque-details-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
