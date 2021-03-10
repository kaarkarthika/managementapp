<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FamilyMaster */

$this->title = 'Updatee';
$this->params['breadcrumbs'][] = ['label' => 'Family Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="family-master-update">


    <?= $this->render('_form', [
        'model' => $model,        
        'depentContent' => $depentContent,
    ]) ?>

</div>
