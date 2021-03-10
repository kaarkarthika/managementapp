<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Shortcut */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Shortcuts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shortcut-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->short_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->short_id], [
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
            'short_id',
            'name',
            'link',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
