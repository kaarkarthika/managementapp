<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MosqueDetails */

$this->title = 'Create Mosque Details';
$this->params['breadcrumbs'][] = ['label' => 'Mosque Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mosque-details-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
