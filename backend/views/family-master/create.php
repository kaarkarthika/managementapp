<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FamilyMaster */

$this->title = 'Add New';
$this->params['breadcrumbs'][] = ['label' => 'Family Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="family-master-create">

    <?= $this->render('_form', [
        'model' => $model,
        'depentContent' => $depentContent,
    ]) ?>

</div>
