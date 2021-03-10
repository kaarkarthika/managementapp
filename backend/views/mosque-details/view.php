<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MosqueDetails */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mosque Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mosque-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->masqueId], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->masqueId], [
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
            'masqueId',
            'name',
            'phoneNumber',
            'address:ntext',
            'image:ntext',
            'licenceCode',
            'otherInformations:ntext',
            'createdAt',
            'updatedAt',
            'ipAddress',
        ],
    ]) ?>

</div>
