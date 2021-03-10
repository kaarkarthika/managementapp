<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\IncomeTypeMaster */

$this->title = 'New';
$this->params['breadcrumbs'][] = ['label' => 'Income Modes Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="income-type-master-create">

    <?= $this->render('_form', [
        'model' => $model,
        'token_name' => $token_name, 
    ]) ?>

</div>
