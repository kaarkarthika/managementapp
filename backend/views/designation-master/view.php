<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\DesignationMaster */

$this->title = $model->designationId;
$this->params['breadcrumbs'][] = ['label' => 'Designation Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="designation-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->designationId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->designationId], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'designationId',
            'desigantionName',
            'activeStatus',
            'createdAt',
            'updatedAt',
            'comments:ntext',
        ],
    ]) ?>

</div>
